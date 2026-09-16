<?php
// delete.php - สำหรับลบข้อมูลนักศึกษา (DELETE)
require_once 'config/db.php';

// ตรวจสอบว่ามี id ส่งมาหรือไม่
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // ลบข้อมูลโดยใช้ Prepared Statement
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    } catch (PDOException $e) {
        // หากเกิดข้อผิดพลาดในการลบ สามารถจัดการแสดงผล error หรือ log ได้ตามเหมาะสม
        die("Delete failed: " . $e->getMessage());
    }
}

// ลบเสร็จให้ redirect กลับหน้าแรกเสมอ
header("Location: index.php");
exit;
?>
