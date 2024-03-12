USE invoice;  -- Switch to the newly created database

-- Create the table schema
CREATE TABLE IF NOT EXISTS invoice (
  invoice_id INT PRIMARY KEY AUTO_INCREMENT,
  patient_id INT NOT NULL,
  medicine VARCHAR(255),
  total_price FLOAT NOT NULL,
  payment_status INT NOT NULL
  -- foreign key necessary? medicine put as [] or json?
);

-- Sample data
INSERT INTO invoice (patient_id, medicine, total_price, payment_status) VALUES 
(1, "panadol, cough", 9.99, 0),
(1, "panadol", 4.99, 0),
(2, "pandaol", 4.99, 0)
