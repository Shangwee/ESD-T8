USE invoice;  -- Switch to the newly created database

-- Create the table schema
CREATE TABLE IF NOT EXISTS invoice (
  invoice_id INT PRIMARY KEY AUTO_INCREMENT,
  patient_id INT NOT NULL,
  medicine JSON NOT NULL,
  total_price FLOAT NOT NULL,
  payment_status INT NOT NULL
  -- foreign key necessary? medicine put as [] or json?
);

-- Sample data
INSERT INTO invoice (patient_id, medicine, total_price, payment_status) VALUES 
(1, '[{ "medicineID": 1, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}]', 10.00,0),
(1, '[{ "medicineID": 1, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}]', 10.00,0),
(2, '[{ "medicineID": 1, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}]', 10.00,0),
(2, '[{ "medicineID": 1, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}, {  "medicineID": 4, "medicineName": "FluMedicine 1","price": 20.0, "quantity": 2}]', 140.00,0),
(3, '[{ "medicineID": 2, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}, {  "medicineID": 4, "medicineName": "FluMedicine 1","price": 20.0, "quantity": 2}]', 140.00,0),
(3, '[{ "medicineID": 2, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}, {  "medicineID": 4, "medicineName": "FluMedicine 1","price": 20.0, "quantity": 2}]', 140.00,0),
(10, '[{ "medicineID": 2, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}, {  "medicineID": 4, "medicineName": "FluMedicine 1","price": 20.0, "quantity": 2}]', 140.00,0),
(11, '[{ "medicineID": 2, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}, {  "medicineID": 4, "medicineName": "FluMedicine 1","price": 20.0, "quantity": 2}]', 140.00,0),
(11, '[{ "medicineID": 2, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}, {  "medicineID": 4, "medicineName": "FluMedicine 1","price": 20.0, "quantity": 2}]', 140.00,0)

-- CREATE TABLE IF NOT EXISTS invoice (
--     invoice_id INT PRIMARY KEY AUTO_INCREMENT,
--     patient_id INT NOT NULL,
--     medicine VARCHAR(255),
--     total_price FLOAT NOT NULL,
--     payment_status INT NOT NULL

-- );


-- INSERT INTO invoice (patient_id, medicine, total_price, payment_status) VALUES 
-- (1,[{ "medicineID": 2, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}, {  "medicineID": 4, "medicineName": "FluMedicine 1","price": 20.0, "quantity": 2}], 140.00,0)

