# Student CRUD System

ระบบจัดการข้อมูลนักศึกษาแบบ CRUD (Create, Read, Update, Delete) พัฒนาด้วย PHP และ MySQL (PDO) โดยใช้ Bootstrap 5 สำหรับ UI (เป็น Educational Project สำหรับนักศึกษา)

## โครงสร้างระบบ
- **ภาษา**: PHP 8.x
- **ฐานข้อมูล**: MySQL / MariaDB (ติดต่อผ่าน PDO)
- **Frontend**: HTML5 + Bootstrap 5 (CDN)

## วิธีการติดตั้งเพื่อรันบน Localhost

1. **เตรียมฐานข้อมูล**
   - เปิดโปรแกรม XAMPP หรือ Laragon
   - Start Apache และ MySQL
   - เข้าไปที่ phpMyAdmin (http://localhost/phpmyadmin)
   - สร้างฐานข้อมูลใหม่ชื่อ `student_crud_db`
   - Import ไฟล์ `database/schema.sql` ลงในฐานข้อมูลที่เพิ่งสร้าง จะได้ตาราง `students` พร้อมข้อมูลตัวอย่าง

2. **ตั้งค่าการเชื่อมต่อ (ถ้าจำเป็น)**
   - เปิดไฟล์ `config/db.php`
   - หากรหัสผ่าน MySQL ของคุณไม่ใช่ค่าว่าง (empty password) ให้แก้ไขตัวแปร `$password` ให้ตรงกับระบบของคุณ
   - ค่าเริ่มต้นสำหรับ XAMPP/Laragon ส่วนใหญ่คือ Username: `root` และ Password: `''` (ไม่มีรหัสผ่าน)

3. **รันทดสอบระบบ**
   - นำโฟลเดอร์โปรเจกต์ไปไว้ใน `htdocs` (สำหรับ XAMPP) หรือ `www` (สำหรับ Laragon)
   - เปิดเบราว์เซอร์ไปที่ http://localhost/student-crud (เปลี่ยนชื่อตามโฟลเดอร์จริง)

## ฟีเจอร์ที่มี
1. **แสดงผลข้อมูล (READ)**: หน้า index.php จะแสดงรายชื่อนักศึกษาทั้งหมดจากฐานข้อมูล
2. **เพิ่มข้อมูลใหม่ (CREATE)**: หน้า create.php มีฟอร์มให้กรอกรหัสนักศึกษา ชื่อ สกุล สาขา ชั้นปี
3. **แก้ไขข้อมูล (UPDATE)**: หน้า edit.php สามารถแก้ไขข้อมูลนักศึกษาแต่ละคนได้
4. **ลบข้อมูล (DELETE)**: หน้า delete.php จะทำการลบข้อมูล พร้อมระบบยืนยัน (Confirm) ผ่าน JavaScript

## ความปลอดภัย
- ระบบนี้ใช้ Prepared Statement ของ PDO เพื่อป้องกัน SQL Injection ในทุกจุดที่มีการรับค่าจากผู้ใช้
