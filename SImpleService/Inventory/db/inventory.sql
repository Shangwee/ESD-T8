use inventory;

CREATE TABLE IF NOT EXISTS `inventory` (
  `inventoryID` INT AUTO_INCREMENT PRIMARY KEY,
  `medicine` VARCHAR(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11),
  `alternative` JSON
);

--
-- Dumping data for table `inventory`
--
--
INSERT INTO inventory (medicine, price, quantity, alternative)
VALUES
( 'CoughMedicine 1', 10, 100, '["2","3"]'),
( 'CoughMedicine 2', 20.00, 100 , '["1","3"]'),
( 'CoughMedicine 3', 15.00, 100, '["1","2"]'),
( 'FluMedicine 1', 20.00, 100, '["5","6"]'),
( 'FluMedicine 2', 10.00, 100, '["4","6"]'),
( 'FluMedicine 3', 5.00, 100, '["4","5"]'),
( 'HeadacheMed 1', 6.00, 100, '["8","9"]'),
( 'HeadacheMed 2', 10.00, 100, '["7","9"]'),
( 'HeadacheMed 3', 15.00, 100, '["7","8"]'),
( 'FeverMedicine 1', 12.00, 100, '["11","12"]'),
( 'FeverMedicine 2', 12.00, 100, '["10","12"]'),
( 'FeverMedicine 3', 20.00, 100, '["10","11"]');