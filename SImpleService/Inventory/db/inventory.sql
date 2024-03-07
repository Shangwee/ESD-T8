use inventory;

CREATE TABLE IF NOT EXISTS `inventory` (
  `inventoryID` INT AUTO_INCREMENT PRIMARY KEY,
  `medicine` VARCHAR(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT NULL
);

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`medicine`, `price`, `quantity`) VALUES
( 'Omeprazole', '35.00', 100),
( 'Ranitidine', '40.00', 100),
( 'Lansoprazole', '45.00', 100),
( 'Fexofenadine', '50.00', 100),
( 'Diphenhydramine', '55.00', 100),
( 'Cetirizine', '60.00', 100),
( 'Loratadine', '65.00', 100),
( 'Omeprazole', '70.00', 100),
( 'Ranitidine', '75.00', 100),
( 'Lansoprazole', '80.00', 100),
( 'Fexofenadine', '85.00', 100),
( 'Diphenhydramine', '90.00', 100),
( 'Cetirizine', '95.00', 100),
( 'Loratadine', '100.00', 100),
( 'Omeprazole', '105.00', 100),
( 'Ranitidine', '110.00', 100),
( 'Lansoprazole', '115.00', 100),
( 'Fexofenadine', '120.00', 100),
( 'Diphenhydramine', '125.00', 100),
( 'Cetirizine', '130.00', 100),
( 'Loratadine', '135.00', 100),
( 'Omeprazole', '140.00', 100),
( 'Ranitidine', '145.00', 100),
( 'Lansoprazole', '150.00', 100),
( 'Fexofenadine', '155.00', 100),
( 'Diphenhydramine', '160.00', 100),
( 'Cetirizine', '165.00', 100),
( 'Loratadine', '170.00', 100),
( 'Omeprazole', '175.00', 100),
( 'Ranitidine', '180.00', 100),
( 'Lansoprazole', '185.00', 100);

-- update entry 31
UPDATE `inventory` SET `price` = '190.00' WHERE `inventoryID` = 31;