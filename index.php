<?php
// index.php - หน้าแรกสำหรับแสดงรายชื่อนักศึกษา (READ)
require_once 'config/db.php';

// ดึงข้อมูลนักศึกษาทั้งหมด
try {
    $stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
    $students = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

include 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>รายชื่อนักศึกษา</h2>
    <a href="create.php" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> เพิ่มนักศึกษาใหม่
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ลำดับ</th>
                        <th>รหัสนักศึกษา</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>สาขาวิชา</th>
                        <th>ชั้นปี</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($students) > 0): ?>
                        <?php foreach ($students as $index => $student): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                <td><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['major']); ?></td>
                                <td><?php echo htmlspecialchars($student['year']); ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> แก้ไข
                                    </a>
                                    <!-- ปุ่มลบ จะส่งไปที่หน้า delete.php พร้อมยืนยันด้วย JS -->
                                    <a href="delete.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบข้อมูลนักศึกษาคนนี้?');">
                                        <i class="bi bi-trash"></i> ลบ
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">ไม่พบข้อมูลนักศึกษา</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
