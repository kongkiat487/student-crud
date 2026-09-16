CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10) NOT NULL UNIQUE,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    major VARCHAR(100) NOT NULL,
    year INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (student_id, first_name, last_name, major, year) VALUES
('64010001', 'สมชาย', 'ใจดี', 'เทคโนโลยีสารสนเทศ', 3),
('64010002', 'สมหญิง', 'รักเรียน', 'วิทยาการคอมพิวเตอร์', 3),
('64010003', 'มานะ', 'อดทน', 'วิศวกรรมซอฟต์แวร์', 3),
('64010004', 'ปิติ', 'ยินดี', 'เทคโนโลยีสารสนเทศ', 3),
('64010005', 'ชูใจ', 'ร่าเริง', 'วิทยาการคอมพิวเตอร์', 3);
