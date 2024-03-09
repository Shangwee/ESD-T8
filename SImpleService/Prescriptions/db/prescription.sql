use prescription;

CREATE TABLE prescription (
    prescriptionID INT AUTO_INCREMENT PRIMARY KEY,
    patientID INT NOT NULL,
    doctorID INT NOT NULl,
    medicine VARCHAR(255) ,
    quantity INT NOT NULL,
    instructions TEXT,
    datetime DATETIME
);

-- create data
INSERT INTO prescription ( patientID, doctorID, medicine, quantity, instructions, datetime) VALUES 
(4, 1, 'Lansoprazole', 30, 'Take 1 tablet every 4 hours', '2024-03-01 16:03:00'),
(5, 2,'Ibuprofen', 20, 'Take 2 tablets every 6 hours', '2024-03-08 16:03:00'), 
(6, 3,'Amoxicillin', 10, 'Take 1 capsule every 8 hours', '2024-03-9 10:03:00');

