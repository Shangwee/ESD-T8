use mc;

CREATE TABLE IF NOT EXISTS `mc` (
  `mcid` INT AUTO_INCREMENT PRIMARY KEY,
  `patientname` VARCHAR(255) NOT NULL,
  `patientid` INT NOT NULL,
  `numberofdays` int(11),
  `assigned` int(11),
   `date` DATE,
  `newdate` DATE

);
--  "mc": {
--         "assigned": 0,
--         "date": "Sun, 24 Mar 2024 00:00:00 GMT",
--         "mcid": 2,
--         "newdate": "Mon, 25 Mar 2024 00:00:00 GMT",
--         "numberofdays": 1,
--         "patientid": 2,
--         "patientname": "dog"
--     },

-- INSERT INTO mc (patientname, patientid, numberofdays, assigned, )
-- VALUES (1, 3, 'CoughMedicine 2', 20.0, 5),
--        (1, 3, 'CoughMedicine 2', 20.0, 5),
--        (1, 3, 'CoughMedicine 2', 20.0, 5);



-- {
--     "invoice_id": 3,
--     "medicine": [
--         {"medicineID": 1, "medicineName": "CoughMedicine 2", "price": 20.0, "quantity": 5},
--         {"medicineID": 1, "medicineName": "CoughMedicine 2", "price": 20.0, "quantity": 5},
--         {"medicineID": 1, "medicineName": "CoughMedicine 2", "price": 20.0, "quantity": 5}
--     ],
--     "patient_id": 2,
--     "payment_status": 0,
--     "total_price": 10000000,
--     "name": "dog"
-- }


