use mc;

CREATE TABLE IF NOT EXISTS `mc` (
  `mcid` INT AUTO_INCREMENT PRIMARY KEY,
  `patientname` VARCHAR(255) NOT NULL,
  `patientid` INT NOT NULL,
  `numberofdays` int(11)
);
