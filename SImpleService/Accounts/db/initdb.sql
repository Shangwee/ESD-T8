-- Assuming the database doesn't exist
CREATE DATABASE IF NOT EXISTS AccountDB;

USE AccountDB;  -- Switch to the newly created database

-- Create the table schema
CREATE TABLE IF NOT EXISTS account (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role INT NOT NULL,
  allergies JSON
);

-- Sample data
INSERT INTO account (name, email, password, role, allergies)
VALUES ('John Doe', 'johndoe@email.com', 'password1', 0, NULL),
       ('Jane Smith', 'janesmith@email.com', 'password2', 0, NULL),
       ('Michael Lee', 'mlee@email.com', 'password3', 0, NULl),
       ('Alice Brown', 'aliceb@email.com', 'password4', 1, '["1"]'),
       ('David Johnson', 'djohnson@email.com', 'password5', 1, '["7", "11"]'),
       ('Dan White','dWhite@gmail.com','password6', 1, '["4", "8"]')
       ('Sarah Williams', 'sarah@email.com', 'password7', 1, NULL),
       ('Robert Davis', 'robert@email.com', 'password8', 1, NULL),
       ('Emily Johnson', 'emily@email.com', 'password9', 1, NULL),
       ('Daniel Wilson', 'daniel@email.com', 'password10', 1, '["2", "5"]'),
       ('Olivia Brown', 'olivia@email.com', 'password11', 1, '["3", "6"]');