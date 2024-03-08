-- Assuming the database doesn't exist
CREATE DATABASE IF NOT EXISTS AccountDB;

USE AccountDB;  -- Switch to the newly created database

-- Create the table schema
CREATE TABLE IF NOT EXISTS account (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role INT NOT NULL
);

-- Sample data
INSERT INTO account (name, email, password, role)
VALUES ('John Doe', 'johndoe@email.com', 'password1', 0),
       ('Jane Smith', 'janesmith@email.com', 'password2', 0),
       ('Michael Lee', 'mlee@email.com', 'password3', 0),
       ('Alice Brown', 'aliceb@email.com', 'password4', 1),
       ('David Johnson', 'djohnson@email.com', 'password5', 2);
