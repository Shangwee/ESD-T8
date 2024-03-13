use prescription;

CREATE TABLE prescription (
    prescriptionID INT AUTO_INCREMENT PRIMARY KEY,
    patientID INT NOT NULL,
    doctorID INT NOT NULl,
    medicine JSON NOT NULL,
    datetime DATETIME
);


INSERT INTO prescription (patientID, doctorID, medicine, datetime)
VALUES
  (4, 1, '[{"medcineID": 1, "medicineName": "Omeprazole", "quantity": 5, "instruction": "Twice daily"}, {"medcineID": 4,"medicineName": "Fexofenadine", "quantity": 2, "instruction": "As needed"}]', '2024-03-12 10:00:00'),
  (5, 2, '[{"medcineID": 4,"medicineName": "Fexofenadine", "quantity": 2, "instruction": "As needed"}, {"medcineID": 6,"medicineName": "Cetirizine", "quantity": 2, "instruction": "4 times daily"}]', '2024-03-11 15:30:00'),
  (6, 3, '[{"medcineID": 6,"medicineName": "Cetirizine", "quantity": 2, "instruction": "4 times daily"}, {"medcineID": 4,"medicineName": "Fexofenadine", "quantity": 2, "instruction": "As needed"}]', '2024-03-10 09:00:00');