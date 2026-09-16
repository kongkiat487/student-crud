<?php
$host = 'localhost';
$dbname = 'student_crud_db'; // ชื่อฐานข้อมูล
$username = 'root'; // username ของ XAMPP/Laragon
$password = ''; // password ของ XAMPP/Laragon

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // ตั้งค่า error mode เป็น Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // ตั้งค่าให้ fetch ข้อมูลเป็น associative array เป็นค่าเริ่มต้น
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
