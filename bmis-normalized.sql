-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2021 at 06:53 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `bmis`

-- Table structure for table `tbl_user`
CREATE TABLE `tbl_user` (
  `id_user` INT PRIMARY KEY AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `lname` VARCHAR(255) NOT NULL,
  `fname` VARCHAR(255) NOT NULL,
  `mi` CHAR(1) NOT NULL,
  `sex` VARCHAR(10) DEFAULT NULL,
  `contact` VARCHAR(11) DEFAULT NULL,
  `age` INT,
  `position` VARCHAR(20) DEFAULT NULL,
  `role` VARCHAR(15) DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping admin data for tbl_user
INSERT INTO `tbl_user` (`email`, `password`, `lname`, `fname`, `mi`, `position`, `role`) VALUES
('almodovarkurt64@gmail.com', 'brgysinalhan13', 'almodovar', 'kurt', 'a', 'chairman', 'administrator');

-- Table structure for table `tbl_resident`
CREATE TABLE `tbl_resident` (
  `id_resident` INT PRIMARY KEY AUTO_INCREMENT, -- Changed to AUTO_INCREMENT
  `profile_photo` MEDIUMBLOB DEFAULT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `lname` VARCHAR(20) NOT NULL,
  `fname` VARCHAR(20) NOT NULL,
  `mi` CHAR(1) NOT NULL,
  `age` INT NOT NULL,
  `sex` VARCHAR(10) NOT NULL,
  `status` VARCHAR(15) NOT NULL,
  `houseno` VARCHAR(20) DEFAULT NULL,
  `street` VARCHAR(20) DEFAULT NULL,
  `brgy` VARCHAR(20) DEFAULT 'sinalhan',
  `city` VARCHAR(20) DEFAULT 'santa rosa city',
  `municipal` VARCHAR(20) DEFAULT 'laguna',
  `contact` VARCHAR(11) NOT NULL,
  `bdate` DATE NOT NULL,
  `bplace` VARCHAR(50) NOT NULL,
  `nationality` VARCHAR(10) NOT NULL,
  `voter` VARCHAR(3) NOT NULL,
  precint_no VARCHAR(10) DEFAULT NULL,
  `addedby_id` INT DEFAULT NULL,
  FOREIGN KEY (`addedby_id`) REFERENCES `tbl_user` (`id_user`) -- Fixed foreign key syntax
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `tbl_announcement`
CREATE TABLE `tbl_announcement` (
  `id_announcement` INT PRIMARY KEY AUTO_INCREMENT,
  `event` VARCHAR(1000) NOT NULL,
  `start_date` DATE NOT NULL,
  `addedby_id` INT,
  FOREIGN KEY (`addedby_id`) REFERENCES `tbl_user` (`id_user`) -- Fixed foreign key syntax
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `tbl_announcement`
INSERT INTO `tbl_announcement` (`event`, `start_date`, `addedby_id`) VALUES
('Free Consultations available from June 13, 2021 until June 25, 2021', '2021-06-12', 1);

-- Table structure for table `tbl_brgyid`
CREATE TABLE `tbl_brgyid` (
  `id_brgyid` VARCHAR(20) PRIMARY KEY NOT NULL,
  `id_resident` INT,
  `res_photo` MEDIUMBLOB DEFAULT NULL,
  valid_until date NOT NULL,
  `inc_lname` VARCHAR(20) NOT NULL,
  `inc_fname` VARCHAR(20) NOT NULL,
  `inc_mi` CHAR(1) NOT NULL,
  `inc_contact` VARCHAR(11) NOT NULL,
  `inc_houseno` VARCHAR(20) DEFAULT NULL,
  `inc_street` VARCHAR(20) NOT NULL,
  `inc_brgy` VARCHAR(20) DEFAULT 'sinalhan',
  `inc_city` VARCHAR(20) DEFAULT 'santa rosa city',
  `inc_municipal` VARCHAR(20) DEFAULT 'laguna',
  `req_status` VARCHAR(10) DEFAULT 'pending',
  FOREIGN KEY (`id_resident`) REFERENCES `tbl_resident` (`id_resident`) -- Fixed foreign key syntax
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `tbl_bspermit`
CREATE TABLE `tbl_bspermit` (
  `id_bspermit` VARCHAR(20) PRIMARY KEY NOT NULL,
  `id_resident` INT,
  bshouseno VARCHAR(20) DEFAULT NULL,
  bsstreet VARCHAR(20) DEFAULT NULL,
  bsbrgy VARCHAR(20),
  bscity VARCHAR(20),
  bsmunicipal VARCHAR(20),
  `bsname` VARCHAR(30) DEFAULT NULL,
  `bsindustry` VARCHAR(100) DEFAULT NULL,
  `aoe` INT NOT NULL,
  `req_status` VARCHAR(10) DEFAULT 'pending',
  FOREIGN KEY (`id_resident`) REFERENCES `tbl_resident` (`id_resident`) -- Fixed foreign key syntax
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `tbl_clearance`
CREATE TABLE `tbl_clearance` (
  `id_clearance` VARCHAR(20) PRIMARY KEY NOT NULL,
  `id_resident` INT,
  `purpose` VARCHAR(255) NOT NULL,
  `req_status` VARCHAR(10) DEFAULT 'pending',
  FOREIGN KEY (`id_resident`) REFERENCES `tbl_resident` (`id_resident`) -- Fixed foreign key syntax
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `tbl_indigency`
CREATE TABLE `tbl_indigency` (
  `id_indigency` VARCHAR(20) PRIMARY KEY NOT NULL,
  `id_resident` INT,
  `purpose` VARCHAR(255) DEFAULT NULL,
  `date` DATE NOT NULL,
  `req_status` VARCHAR(10) DEFAULT 'pending',
  FOREIGN KEY (`id_resident`) REFERENCES `tbl_resident` (`id_resident`) -- Fixed foreign key syntax
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `tbl_rescert`
CREATE TABLE `tbl_rescert` (
  `id_rescert` VARCHAR(20) PRIMARY KEY NOT NULL,
  `id_resident` INT,
  `purpose` VARCHAR(255) NOT NULL,
  `date` DATE NOT NULL,
  `req_status` VARCHAR(10) DEFAULT 'pending',
  FOREIGN KEY (`id_resident`) REFERENCES `tbl_resident` (`id_resident`) -- Fixed foreign key syntax
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;






-- Tables for archiving

-- Table structure for table `tbl_brgyid`
CREATE TABLE `tbl_archive_brgyid` (
  `id_brgyid` VARCHAR(20) PRIMARY KEY NOT NULL,
  `res_photo` MEDIUMBLOB DEFAULT NULL,
  `lname` VARCHAR(20) NOT NULL,
  `fname` VARCHAR(20) NOT NULL,
  `mi` CHAR(1) NOT NULL,
  `houseno` VARCHAR(20) DEFAULT NULL,
  `street` VARCHAR(20) DEFAULT NULL,
  `brgy` VARCHAR(20) DEFAULT 'sinalhan',
  `city` VARCHAR(20) DEFAULT 'santa rosa city',
  `municipal` VARCHAR(20) DEFAULT 'laguna',
  `inc_lname` VARCHAR(20) NOT NULL,
  `inc_fname` VARCHAR(20) NOT NULL,
  `inc_mi` CHAR(1) NOT NULL,
  `inc_contact` VARCHAR(11) NOT NULL,
  `inc_houseno` VARCHAR(20) DEFAULT NULL,
  `inc_street` VARCHAR(20) NOT NULL,
  `inc_brgy` VARCHAR(20) DEFAULT 'sinalhan',
  `inc_city` VARCHAR(20) DEFAULT 'santa rosa city',
  `inc_municipal` VARCHAR(20) DEFAULT 'laguna',
  `bdate` DATE NOT NULL,
  `status` VARCHAR(15) NOT NULL,
  precint_no VARCHAR(10) DEFAULT NULL,
  valid_until date NOT NULL,
  archived_time DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `tbl_bspermit`
CREATE TABLE `tbl_arhive_bspermit` (
  `id_bspermit` VARCHAR(20) PRIMARY KEY NOT NULL,
  `lname` VARCHAR(20) NOT NULL,
  `fname` VARCHAR(20) NOT NULL,
  `mi` CHAR(1) NOT NULL,
  bshouseno VARCHAR(20) DEFAULT NULL,
  bsstreet VARCHAR(20) DEFAULT NULL,
  bsbrgy VARCHAR(20),
  bscity VARCHAR(20),
  bsmunicipal VARCHAR(20),
  `bsname` VARCHAR(30) DEFAULT NULL,
  `bsindustry` VARCHAR(100) DEFAULT NULL,
  `aoe` INT NOT NULL,
  archived_time DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `tbl_clearance`
CREATE TABLE `tbl_archive_clearance` (
  `id_clearance` VARCHAR(20) PRIMARY KEY NOT NULL,
  `lname` VARCHAR(20) NOT NULL,
  `fname` VARCHAR(20) NOT NULL,
  `mi` CHAR(1) NOT NULL,
  `age` INT NOT NULL,
  `houseno` VARCHAR(20) DEFAULT NULL,
  `street` VARCHAR(20) DEFAULT NULL,
  `brgy` VARCHAR(20) DEFAULT 'sinalhan',
  `city` VARCHAR(20) DEFAULT 'santa rosa city',
  `municipal` VARCHAR(20) DEFAULT 'laguna',
  `status` VARCHAR(15) NOT NULL,
  `purpose` VARCHAR(255) NOT NULL,
  archived_time DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `tbl_indigency`
CREATE TABLE `tbl_archive_indigency` (
  `id_indigency` VARCHAR(20) PRIMARY KEY NOT NULL,
  `lname` VARCHAR(20) NOT NULL,
  `fname` VARCHAR(20) NOT NULL,
  `mi` CHAR(1) NOT NULL,
  `age` INT NOT NULL,
  `houseno` VARCHAR(20) DEFAULT NULL,
  `street` VARCHAR(20) DEFAULT NULL,
  `brgy` VARCHAR(20) DEFAULT 'sinalhan',
  `city` VARCHAR(20) DEFAULT 'santa rosa city',
  `municipal` VARCHAR(20) DEFAULT 'laguna',
  `purpose` VARCHAR(255) DEFAULT NULL,
  `date` DATE NOT NULL,
  archived_time DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `tbl_rescert`
CREATE TABLE `tbl_archive_rescert` (
  `id_rescert` VARCHAR(20) PRIMARY KEY NOT NULL,
  `lname` VARCHAR(20) NOT NULL,
  `fname` VARCHAR(20) NOT NULL,
  `mi` CHAR(1) NOT NULL,
  `age` INT NOT NULL,
  `houseno` VARCHAR(20) DEFAULT NULL,
  `street` VARCHAR(20) DEFAULT NULL,
  `brgy` VARCHAR(20) DEFAULT 'sinalhan',
  `city` VARCHAR(20) DEFAULT 'santa rosa city',
  `municipal` VARCHAR(20) DEFAULT 'laguna',
  `purpose` VARCHAR(255) NOT NULL,
  `date` DATE NOT NULL,
  archived_time DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Set the delimiter to //
DELIMITER //

-- Starting number for rescert id (001)
CREATE TRIGGER generate_rescert_id
BEFORE INSERT ON tbl_rescert
FOR EACH ROW
BEGIN
    DECLARE currentDate CHAR(10);
    DECLARE dailyCount INT;
    DECLARE newId VARCHAR(20);

    -- Get the current date in YYYY-MM-DD format
    SET currentDate = DATE_FORMAT(NOW(), '%Y-%m-%d');

    -- Count the entries for the current date
    SELECT COUNT(*) + 1 INTO dailyCount
    FROM tbl_rescert
    WHERE id_rescert LIKE CONCAT(currentDate, '-%');

    -- Format the new ID
    SET newId = CONCAT(currentDate, '-', LPAD(dailyCount, 3, '0'));

    -- Assign the generated ID to the new row
    SET NEW.id_rescert = newId;
END;

//
CREATE TRIGGER generate_brgy_id
BEFORE INSERT ON tbl_brgyid
FOR EACH ROW
BEGIN
    DECLARE currentYear VARCHAR(4);
    DECLARE dailyCount INT;
    DECLARE newId VARCHAR(20);

    -- Get the current year
    SET currentYear = DATE_FORMAT(NOW(), '%Y');

    -- Count the entries for the current year and offset by 1001
    SELECT COUNT(*) + 1001 INTO dailyCount
    FROM tbl_brgyid
    WHERE id_brgyid LIKE CONCAT(currentYear, '-%');

    -- Format the new ID
    SET newId = CONCAT(currentYear, '-', dailyCount);

    -- Check for duplicates and increment dailyCount if necessary
    WHILE EXISTS (SELECT 1 FROM tbl_brgyid WHERE id_brgyid = newId) DO
        SET dailyCount = dailyCount + 1;
        SET newId = CONCAT(currentYear, '-', dailyCount);
    END WHILE;

    -- Assign the generated ID to the new row
    SET NEW.id_brgyid = newId;

END //

-- Starting number for bspermit id
CREATE TRIGGER generate_bspermit_id
BEFORE INSERT ON tbl_bspermit
FOR EACH ROW
BEGIN
    DECLARE currentDate CHAR(10);
    DECLARE dailyCount INT;
    DECLARE newId VARCHAR(20);

    -- Get the current date in YYYY-MM-DD format
    SET currentDate = DATE_FORMAT(NOW(), '%Y-%m-%d');

    -- Count the entries for the current date
    SELECT COUNT(*) + 201 INTO dailyCount
    FROM tbl_bspermit
    WHERE id_bspermit LIKE CONCAT(currentDate, '-%');

    -- Format the new ID
    SET newId = CONCAT(currentDate, '-', dailyCount);

    WHILE EXISTS (SELECT 1 FROM tbl_bspermit WHERE id_bspermit = newId) DO
        SET dailyCount = dailyCount + 1;
        SET newId = CONCAT(currentDate, '-', dailyCount);
    END WHILE;

    -- Assign the generated ID to the new row
    SET NEW.id_bspermit = newId;
END;
//

-- Starting number for clearance id (301)
CREATE TRIGGER generate_clearance_id
BEFORE INSERT ON tbl_clearance
FOR EACH ROW
BEGIN
    DECLARE currentDate CHAR(10);
    DECLARE dailyCount INT;
    DECLARE newId VARCHAR(20);

    -- Get the current date in YYYY-MM-DD format
    SET currentDate = DATE_FORMAT(NOW(), '%Y-%m-%d');

    -- Count the entries for the current date
    SELECT COUNT(*) + 301 INTO dailyCount
    FROM tbl_clearance
    WHERE id_clearance LIKE CONCAT(currentDate, '-%');

    -- Format the new ID
    SET newId = CONCAT(currentDate, '-', dailyCount);

    WHILE EXISTS (SELECT 1 FROM tbl_clearance WHERE id_clearance = newId) DO
        SET dailyCount = dailyCount + 1;
        SET newId = CONCAT(currentDate, '-', dailyCount);
    END WHILE;

    -- Assign the generated ID to the new row
    SET NEW.id_clearance = newId;
END;
//

-- Starting number for indigency id (401)
CREATE TRIGGER generate_indigency_id
BEFORE INSERT ON tbl_indigency
FOR EACH ROW
BEGIN
    DECLARE currentDate CHAR(10);
    DECLARE dailyCount INT;
    DECLARE newId VARCHAR(20);

    -- Get the current date in YYYY-MM-DD format
    SET currentDate = DATE_FORMAT(NOW(), '%Y-%m-%d');

    -- Count the entries for the current date
    SELECT COUNT(*) + 401 INTO dailyCount
    FROM tbl_indigency
    WHERE id_indigency LIKE CONCAT(currentDate, '-%');

    -- Format the new ID
    SET newId = CONCAT(currentDate, '-', dailyCount);

    WHILE EXISTS (SELECT 1 FROM tbl_indigency WHERE id_indigency = newId) DO
        SET dailyCount = dailyCount + 1;
        SET newId = CONCAT(currentDate, '-', dailyCount);
    END WHILE;

    -- Assign the generated ID to the new row
    SET NEW.id_indigency = newId;
END;
//

-- Reset the delimiter back to ;
DELIMITER ;
