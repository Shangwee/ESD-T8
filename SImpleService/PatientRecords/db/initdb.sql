-- Assuming the database doesn't exist
CREATE DATABASE IF NOT EXISTS RecordDB;

USE RecordDB;  -- Switch to the newly created database

-- Create the table schema
CREATE TABLE IF NOT EXISTS record (
  id INT PRIMARY KEY AUTO_INCREMENT,
  patient_id INT NOT NULL,
  record_date DATETIME NOT NULL
);

-- Sample data
INSERT INTO record (patient_id, record_date)
VALUES (1, '2024-03-08 16:03:00'),
       (2, '2024-03-08 16:03:04')
