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
       ('Dan White','dWhite@gmail.com','password6', 1, '["4", "8"]');

