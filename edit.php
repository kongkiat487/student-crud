<?php
// edit.php - หน้าสำหรับแก้ไขข้อมูลนักศึกษา (UPDATE)
require_once 'config/db.php';

$error = '';
$success = '';
$student = null;

// ตรวจสอบว่ามี id ส่งมาหรือไม่
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// ดึงข้อมูลเดิมมาแสดงในฟอร์ม
try {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $student = $stmt->fetch();
    
    // ถ้าระบุ ID ที่ไม่มีอยู่จริง
    if (!$student) {
        header("Location: index.php");
        exit;
    }
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

// เมื่อมีการ submit ฟอร์มเพื่ออัปเดตข้อมูล
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลและทำความสะอาด
    $student_id = trim($_POST['student_id']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $major = trim($_POST['major']);
    $year = trim($_POST['year']);

    // ตรวจสอบความถูกต้องเบื้องต้น
    if (empty($student_id) || empty($first_name) || empty($last_name) || empty($major) || empty($year)) {
        $error = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
    } else {
        try {
            // อัปเดตข้อมูล
            $update_stmt = $pdo->prepare("UPDATE students SET student_id = :student_id, first_name = :first_name, last_name = :last_name, major = :major, year = :year WHERE id = :id");
            
            $update_stmt->bindParam(':student_id', $student_id);
            $update_stmt->bindParam(':first_name', $first_name);
            $update_stmt->bindParam(':last_name', $last_name);
            $update_stmt->bindParam(':major', $major);
            $update_stmt->bindParam(':year', $year);
            $update_stmt->bindParam(':id', $id);
            
            if ($update_stmt->execute()) {
                $success = "แก้ไขข้อมูลสำเร็จ";
                // อัปเดตข้อมูลในตัวแปร $student เพื่อให้ฟอร์มแสดงค่าใหม่ล่าสุด
                $student['student_id'] = $student_id;
                $student['first_name'] = $first_name;
                $student['last_name'] = $last_name;
                $student['major'] = $major;
                $student['year'] = $year;
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "รหัสนักศึกษานี้มีอยู่ในระบบแล้ว (อาจซ้ำกับคนอื่น)";
            } else {
                $error = "เกิดข้อผิดพลาด: " . $e->getMessage();
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">แก้ไขข้อมูลนักศึกษา</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                        <br>
                        <a href="index.php" class="btn btn-sm btn-primary mt-2">กลับหน้าแรก</a>
                    </div>
                <?php endif; ?>

                <form action="edit.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">รหัสนักศึกษา</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" maxlength="10" value="<?php echo htmlspecialchars($student['student_id']); ?>" required>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col">
                            <label for="first_name" class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>
                        </div>
                        <div class="col">
                            <label for="last_name" class="form-label">นามสกุล</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="major" class="form-label">สาขาวิชา</label>
                        <select class="form-select" id="major" name="major" required>
                            <option value="">-- เลือกสาขาวิชา --</option>
                            <option value="เทคโนโลยีสารสนเทศ" <?php echo ($student['major'] == 'เทคโนโลยีสารสนเทศ') ? 'selected' : ''; ?>>เทคโนโลยีสารสนเทศ</option>
                            <option value="วิทยาการคอมพิวเตอร์" <?php echo ($student['major'] == 'วิทยาการคอมพิวเตอร์') ? 'selected' : ''; ?>>วิทยาการคอมพิวเตอร์</option>
                            <option value="วิศวกรรมซอฟต์แวร์" <?php echo ($student['major'] == 'วิศวกรรมซอฟต์แวร์') ? 'selected' : ''; ?>>วิศวกรรมซอฟต์แวร์</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="year" class="form-label">ชั้นปี</label>
                        <select class="form-select" id="year" name="year" required>
                            <option value="">-- เลือกชั้นปี --</option>
                            <option value="1" <?php echo ($student['year'] == 1) ? 'selected' : ''; ?>>ชั้นปีที่ 1</option>
                            <option value="2" <?php echo ($student['year'] == 2) ? 'selected' : ''; ?>>ชั้นปีที่ 2</option>
                            <option value="3" <?php echo ($student['year'] == 3) ? 'selected' : ''; ?>>ชั้นปีที่ 3</option>
                            <option value="4" <?php echo ($student['year'] == 4) ? 'selected' : ''; ?>>ชั้นปีที่ 4</option>
                        </select>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-secondary me-md-2">ยกเลิก</a>
                        <button type="submit" class="btn btn-warning">อัปเดตข้อมูล</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
