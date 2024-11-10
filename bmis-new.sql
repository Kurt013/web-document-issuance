-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
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

--
-- Database: `bmis`
--

CREATE TABLE tbl_user (
    id_user INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    lname VARCHAR(20) NOT NULL,
    fname VARCHAR(20) NOT NULL,
    mi VARCHAR(1) NOT NULL,
    sex VARCHAR(10) NOT NULL,
    contact VARCHAR(11) NOT NULL,
    position VARCHAR(20) NOT NULL,
    `role` VARCHAR(15) DEFAULT 'staff'
);

-- Dumping admin data for tbl_user
INSERT INTO `tbl_user` (username, `email`, `password`, `lname`, `fname`, `mi`, `position`, `role`) VALUES
('admin', 'almodovarkurt64@gmail.com', '$2y$10$clkI7tjDcF3LzMN0a8bN1e/Ad0/pHl2oBlWlFxdQEkCjyHdt3H4Py', 'almodovar', 'kurt', 'a', 'chairman', 'administrator');

CREATE TABLE tbl_records (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by VARCHAR(30) NOT NULL,
    doc_type VARCHAR(20) NOT NULL
);

CREATE TABLE tbl_brgyid (
    id_brgyid VARCHAR(20) PRIMARY KEY UNIQUE NOT NULL,
    res_photo MEDIUMBLOB NOT NULL,
    fname VARCHAR(20) NOT NULL,
    mi VARCHAR(1) NOT NULL,
    lname VARCHAR(20) NOT NULL,
    houseno VARCHAR(20) NOT NULL,
    street VARCHAR(20) NOT NULL,
    brgy VARCHAR(20) NOT NULL,
    city VARCHAR(20) NOT NULL,
    municipality VARCHAR(20) NOT NULL,
    bdate DATE NOT NULL,
    `status` VARCHAR(20) NOT NULL,
    precint_no VARCHAR(20) NOT NULL,
    inc_lname VARCHAR(20) NOT NULL,
    inc_fname VARCHAR(20) NOT NULL,
    inc_mi VARCHAR(1) NOT NULL,
    inc_contact VARCHAR(11) NOT NULL,
    inc_houseno VARCHAR(20) DEFAULT NULL,
    inc_street VARCHAR(20) NOT NULL,
    inc_brgy VARCHAR(20) NOT NULL,
    inc_city VARCHAR(20) NOT NULL,
    inc_municipal VARCHAR(20) NOT NULL,
    valid_until DATE NOT NULL,
    generated_by INT NOT NULL,
    generated_on DATE DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (generated_by) REFERENCES tbl_user(id_user)
);

CREATE TABLE tbl_bspermit (
    id_bspermit VARCHAR(20) PRIMARY KEY UNIQUE NOT NULL,
    fname VARCHAR(20) NOT NULL,
    mi VARCHAR(1) NOT NULL,
    lname VARCHAR(20) NOT NULL,
    bshouseno VARCHAR(20) NOT NULL,
    bsstreet VARCHAR(20) NOT NULL,
    bsbrgy VARCHAR(20) NOT NULL,
    bscity VARCHAR(20) NOT NULL,
    bsmunicipality VARCHAR(20) NOT NULL,
    bsindustry VARCHAR(20) NOT NULL,
    aoe INT NOT NULL,
    generated_by INT NOT NULL,
    generated_on DATE DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (generated_by) REFERENCES tbl_user(id_user)
);

CREATE TABLE tbl_clearance (
    id_clearance VARCHAR(20) PRIMARY KEY UNIQUE NOT NULL,
    fname VARCHAR(20) NOT NULL,
    mi VARCHAR(1) NOT NULL,
    lname VARCHAR(20) NOT NULL,
    age INT NOT NULL,
    houseno VARCHAR(20) NOT NULL,
    street VARCHAR(20) NOT NULL,
    brgy VARCHAR(20) NOT NULL,
    city VARCHAR(20) NOT NULL,
    municipality VARCHAR(20) NOT NULL,
    purpose VARCHAR(20) NOT NULL,
    generated_by INT NOT NULL,
    generated_on DATE DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (generated_by) REFERENCES tbl_user(id_user)
);

CREATE TABLE tbl_indigency (
    id_indigency VARCHAR(20) PRIMARY KEY UNIQUE NOT NULL,
    fname VARCHAR(20) NOT NULL,
    mi VARCHAR(1) NOT NULL,
    lname VARCHAR(20) NOT NULL,
    age INT NOT NULL,
    nationality VARCHAR(20) NOT NULL,
    houseno VARCHAR(20) NOT NULL,
    street VARCHAR(20) NOT NULL,
    brgy VARCHAR(20) NOT NULL,
    city VARCHAR(20) NOT NULL,
    municipality VARCHAR(20) NOT NULL,
    purpose VARCHAR(20) NOT NULL,
    generated_by INT NOT NULL,
    generated_on DATE DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (generated_by) REFERENCES tbl_user(id_user)
);

CREATE TABLE tbl_rescert (
    id_rescert VARCHAR(20) PRIMARY KEY UNIQUE NOT NULL,
    fname VARCHAR(20) NOT NULL,
    mi VARCHAR(1) NOT NULL,
    lname VARCHAR(20) NOT NULL,
    age INT NOT NULL,
    nationality VARCHAR(20) NOT NULL,
    houseno VARCHAR(20) NOT NULL,
    street VARCHAR(20) NOT NULL,
    brgy VARCHAR(20) NOT NULL,
    city VARCHAR(20) NOT NULL,
    municipality VARCHAR(20) NOT NULL,
    purpose VARCHAR(20) NOT NULL,
    generated_by INT NOT NULL,
    generated_on DATE DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (generated_by) REFERENCES tbl_user(id_user)
);

CREATE TABLE tbl_announcement (
    id_announcement INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    event VARCHAR(255) NOT NULL,
    generated_on TIMESTAMP NOT NULL,
    generated_by INT NOT NULL,
    FOREIGN KEY (generated_by) REFERENCES tbl_user(id_user)
);

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