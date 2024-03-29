use prescription;

CREATE TABLE prescription (
    prescriptionID INT AUTO_INCREMENT PRIMARY KEY,
    patientID INT NOT NULL,
    doctorID INT NOT NULl,
    medicine JSON NOT NULL,
    process BOOLEAN DEFAULT FALSE,
    datetime DATETIME
);


INSERT INTO prescription (patientID, doctorID, medicine, datetime)
VALUES
  (4, 1, '[{"medicineID": 2, "medicineName": "CoughMedicine 2", "quantity": 5, "instruction": "Twice daily"}, {"medicineID": 4,"medicineName": "FluMedicine 1", "quantity": 2, "instruction": "As needed"}]', '2024-03-12 10:00:00'),
  (5, 2, '[{"medicineID": 4,"medicineName": "FluMedicine 1", "quantity": 2, "instruction": "As needed"}, {"medicineID": 12,"medicineName": "FeverMedicine 3", "quantity": 2, "instruction": "4 times daily"}]', '2024-03-11 15:30:00'),
  (6, 3, '[{"medicineID": 11,"medicineName": "FeverMedicine 2", "quantity": 2, "instruction": "4 times daily"}, {"medicineID": 4,"medicineName": "FluMedicine 1", "quantity": 2, "instruction": "As needed"}]', '2024-03-10 09:00:00');