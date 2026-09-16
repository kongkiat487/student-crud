<?php
// create.php - หน้าสำหรับเพิ่มข้อมูลนักศึกษา (CREATE)
require_once 'config/db.php';

$error = '';
$success = '';

// ตรวจสอบว่ามีการส่งฟอร์มมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลและทำความสะอาด
    $student_id = trim($_POST['student_id']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $major = trim($_POST['major']);
    $year = trim($_POST['year']);

    // ตรวจสอบความถูกต้องของข้อมูลเบื้องต้น
    if (empty($student_id) || empty($first_name) || empty($last_name) || empty($major) || empty($year)) {
        $error = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
    } else {
        try {
            // เตรียมคำสั่ง SQL ป้องกัน SQL Injection ด้วย Prepared Statement
            $stmt = $pdo->prepare("INSERT INTO students (student_id, first_name, last_name, major, year) VALUES (:student_id, :first_name, :last_name, :major, :year)");
            
            // ผูกข้อมูลเข้ากับ parameters
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':major', $major);
            $stmt->bindParam(':year', $year);
            
            // รันคำสั่ง SQL
            if ($stmt->execute()) {
                $success = "เพิ่มข้อมูลนักศึกษาสำเร็จ";
                // หลังจากบันทึกเสร็จ สามารถ Redirect กลับไปหน้าแรกได้
                // header("Location: index.php");
                // exit;
            }
        } catch (PDOException $e) {
            // เช็คว่าเป็น error จากข้อมูลซ้ำ (Duplicate entry)
            if ($e->getCode() == 23000) {
                $error = "รหัสนักศึกษานี้มีอยู่ในระบบแล้ว";
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
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">เพิ่มนักศึกษาใหม่</h4>
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

                <form action="create.php" method="POST">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">รหัสนักศึกษา</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" maxlength="10" required>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col">
                            <label for="first_name" class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col">
                            <label for="last_name" class="form-label">นามสกุล</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="major" class="form-label">สาขาวิชา</label>
                        <select class="form-select" id="major" name="major" required>
                            <option value="">-- เลือกสาขาวิชา --</option>
                            <option value="เทคโนโลยีสารสนเทศ">เทคโนโลยีสารสนเทศ</option>
                            <option value="วิทยาการคอมพิวเตอร์">วิทยาการคอมพิวเตอร์</option>
                            <option value="วิศวกรรมซอฟต์แวร์">วิศวกรรมซอฟต์แวร์</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="year" class="form-label">ชั้นปี</label>
                        <select class="form-select" id="year" name="year" required>
                            <option value="">-- เลือกชั้นปี --</option>
                            <option value="1">ชั้นปีที่ 1</option>
                            <option value="2">ชั้นปีที่ 2</option>
                            <option value="3">ชั้นปีที่ 3</option>
                            <option value="4">ชั้นปีที่ 4</option>
                        </select>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-secondary me-md-2">ยกเลิก</a>
                        <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
