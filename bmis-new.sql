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
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(30),
    email VARCHAR(50),
    `password` VARCHAR(255),
    lname VARCHAR(20),
    fname VARCHAR(20),
    mi CHAR(1),
    sex VARCHAR(10),
    contact VARCHAR(11),
    position VARCHAR(20),
    `role` VARCHAR(15) DEFAULT 'staff'
);

-- Dumping admin data for tbl_user
INSERT INTO `tbl_user` (username, `email`, `password`, `lname`, `fname`, `mi`, `position`, `role`) VALUES
('admin', 'almodovarkurt64@gmail.com', '$2y$10$clkI7tjDcF3LzMN0a8bN1e/Ad0/pHl2oBlWlFxdQEkCjyHdt3H4Py', 'almodovar', 'kurt', 'a', 'chairman', 'administrator');


-- Table: tbl_brgyid
CREATE TABLE tbl_brgyid (
    id_brgyid VARCHAR(20) PRIMARY KEY,
    res_photo MEDIUMBLOB,
    fname VARCHAR(20),
    mi VARCHAR(1),
    lname VARCHAR(20),
    houseno VARCHAR(20),
    street VARCHAR(20),
    brgy VARCHAR(20) DEFAULT 'sinalhan',
    city VARCHAR(20) DEFAULT 'city of santa rosa',
    municipality VARCHAR(20) DEFAULT 'laguna',
    bdate DATE,
    `status` VARCHAR(20),
    precint_no VARCHAR(20),
    inc_lname VARCHAR(20),
    inc_fname VARCHAR(20),
    inc_mi CHAR(1),
    inc_contact VARCHAR(11),
    inc_houseno VARCHAR(20),
    inc_street VARCHAR(20),
    inc_brgy VARCHAR(20),
    inc_city VARCHAR(20),
    inc_municipality VARCHAR(20),
    valid_until TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL 1 YEAR),
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by VARCHAR(20),
    doc_status VARCHAR(20) DEFAULT 'pending'
);

-- Table: tbl_bspermit
CREATE TABLE tbl_bspermit (
    id_bspermit VARCHAR(20) PRIMARY KEY,
    fname VARCHAR(20),
    mi VARCHAR(1),
    lname VARCHAR(20),
    bsname VARCHAR(20),
    bshouseno VARCHAR(20),
    bsstreet VARCHAR(20),
    bsbrgy VARCHAR(20),
    bscity VARCHAR(20),
    bsmunicipality VARCHAR(20),
    bsindustry VARCHAR(20),
    aoe INT,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by VARCHAR(20),
    doc_status VARCHAR(20) DEFAULT 'pending'
);

-- Table: tbl_clearance
CREATE TABLE tbl_clearance (
    id_clearance VARCHAR(20) PRIMARY KEY,
    fname VARCHAR(20),
    mi VARCHAR(1),
    lname VARCHAR(20),
    age INT,
    houseno VARCHAR(20),
    street VARCHAR(20),
    brgy VARCHAR(20) DEFAULT 'sinalhan',
    city VARCHAR(20) DEFAULT 'city of santa rosa',
    municipality VARCHAR(20) DEFAULT 'laguna',
    purpose VARCHAR(20),
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by VARCHAR(20),
    doc_status VARCHAR(20) DEFAULT 'pending'
);

-- Table: tbl_indigency
CREATE TABLE tbl_indigency (
    id_indigency VARCHAR(20) PRIMARY KEY,
    fname VARCHAR(20),
    mi VARCHAR(1),
    lname VARCHAR(20),
    age INT,
    nationality VARCHAR(20),
    houseno VARCHAR(20),
    street VARCHAR(20),
    brgy VARCHAR(20) DEFAULT 'sinalhan',
    city VARCHAR(20) DEFAULT 'city of santa rosa',
    municipality VARCHAR(20) DEFAULT 'laguna',
    purpose VARCHAR(20),
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by VARCHAR(20),
    doc_status VARCHAR(20) DEFAULT 'pending'
);

-- Table: tbl_rescert
CREATE TABLE tbl_rescert (
    id_rescert VARCHAR(20) PRIMARY KEY,
    fname VARCHAR(20),
    mi VARCHAR(1),
    lname VARCHAR(20),
    age INT,
    houseno VARCHAR(20),
    street VARCHAR(20),
    brgy VARCHAR(20) DEFAULT 'sinalhan',
    city VARCHAR(20) DEFAULT 'city of santa rosa',
    municipality VARCHAR(20) DEFAULT 'laguna',
    purpose VARCHAR(20),
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by VARCHAR(20),
    doc_status VARCHAR(20) DEFAULT 'pending'
);

-- Table: tbl_announcement
CREATE TABLE tbl_announcement (
    id_announcement INT(11) PRIMARY KEY AUTO_INCREMENT,
    `event` VARCHAR(255) NOT NULL,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    FOREIGN KEY (created_by) REFERENCES tbl_user(id_user)
);


-- Archive table for tbl_brgyid
CREATE TABLE tbl_brgyid_archive (
    id_brgyid VARCHAR(20) PRIMARY KEY,
    res_photo MEDIUMBLOB,
    fname VARCHAR(20),
    mi VARCHAR(1),
    lname VARCHAR(20),
    houseno VARCHAR(20),
    brgy VARCHAR(20) DEFAULT 'sinalhan',
    city VARCHAR(20) DEFAULT 'city of santa rosa',
    municipality VARCHAR(20) DEFAULT 'laguna',
    bdate DATE,
    `status` VARCHAR(20),
    precint_no VARCHAR(20),
    inc_lname VARCHAR(20),
    inc_fname VARCHAR(20),
    inc_mi CHAR(1),
    inc_contact VARCHAR(11),
    inc_houseno VARCHAR(20),
    inc_street VARCHAR(20),
    inc_brgy VARCHAR(20),
    inc_city VARCHAR(20),
    inc_municipality VARCHAR(20),
    valid_until DATE,
    archived_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    archived_by INT,
    FOREIGN KEY (archived_by) REFERENCES tbl_user(id_user)
);

-- Archive table for tbl_bspermit
CREATE TABLE tbl_bspermit_archive (
    id_bspermit VARCHAR(20) PRIMARY KEY,
    fname VARCHAR(20),
    mi VARCHAR(1),
    lname VARCHAR(20),
    bshouseno VARCHAR(20),
    bsstreet VARCHAR(20),
    bsbrgy VARCHAR(20),
    bscity VARCHAR(20),
    bsmunicipality VARCHAR(20),
    bsindustry VARCHAR(20),
    aoe INT,
    archived_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    archived_by INT,
    FOREIGN KEY (archived_by) REFERENCES tbl_user(id_user)
);

-- Archive table for tbl_clearance
CREATE TABLE tbl_clearance_archive (
    id_clearance VARCHAR(20) PRIMARY KEY,
    fname VARCHAR(20),
    mi VARCHAR(1),
    lname VARCHAR(20),
    age INT,
    houseno VARCHAR(20),
    street VARCHAR(20),
    brgy VARCHAR(20) DEFAULT 'sinalhan',
    city VARCHAR(20) DEFAULT 'city of santa rosa',
    municipality VARCHAR(20) DEFAULT 'laguna',
    purpose VARCHAR(20),
    archived_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    archived_by INT,
    FOREIGN KEY (archived_by) REFERENCES tbl_user(id_user)
);

-- Archive table for tbl_indigency
CREATE TABLE tbl_indigency_archive (
    id_indigency VARCHAR(20) PRIMARY KEY,
    fname VARCHAR(20),
    mi VARCHAR(1),
    lname VARCHAR(20),
    age INT,
    nationality VARCHAR(20),
    houseno VARCHAR(20),
    street VARCHAR(20),
    brgy VARCHAR(20) DEFAULT 'sinalhan',
    city VARCHAR(20) DEFAULT 'city of santa rosa',
    municipality VARCHAR(20) DEFAULT 'laguna',
    purpose VARCHAR(20),
    archived_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    archived_by INT,
    FOREIGN KEY (archived_by) REFERENCES tbl_user(id_user)
);

-- Archive table for tbl_rescert
CREATE TABLE tbl_rescert_archive (
    id_rescert VARCHAR(20) PRIMARY KEY,
    fname VARCHAR(20),
    mi VARCHAR(1),
    lname VARCHAR(20),
    age INT,
    houseno VARCHAR(20),
    street VARCHAR(20),
    brgy VARCHAR(20) DEFAULT 'sinalhan',
    city VARCHAR(20) DEFAULT 'city of santa rosa',
    municipality VARCHAR(20) DEFAULT 'laguna',
    purpose VARCHAR(20),
    archived_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    archived_by INT,
    FOREIGN KEY (archived_by) REFERENCES tbl_user(id_user)
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
    
    WHILE EXISTS (SELECT 1 FROM tbl_rescert WHERE id_rescert = newId) DO
        SET dailyCount = dailyCount + 1;
        SET newId = CONCAT(currentDate, '-', dailyCount);
    END WHILE;

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



-- Dumping data for tbl_brgyid
INSERT INTO tbl_brgyid (res_photo, fname, mi, lname, houseno, bdate, `status`, precint_no, inc_lname, inc_fname, inc_mi, inc_contact, inc_houseno, inc_street, inc_brgy, inc_city, inc_municipality, valid_until, created_by, doc_status)
VALUES
(NULL, 'John', 'A', 'Doe', '123', '1990-01-01', 'Single', '123A', 'Smith', 'Jane', 'B', '09123456789', '456', 'Main St', 'Sinalhan', 'City of Santa Rosa', 'Laguna', '2025-01-01', 1, 'accepted'),
(NULL, 'Jane', 'B', 'Smith', '456', '1985-02-02', 'Single', '456B', 'Doe', 'John', 'A', '09876543210', '789', 'Second St', 'Sinalhan', 'City of Santa Rosa', 'Laguna', '2025-02-02', 2, 'accepted'),
(NULL, 'Alice', 'C', 'Johnson', '789', '1992-03-03', 'Married', '789C', 'Brown', 'Emma', 'C', '09765432109', '321', 'Third St', 'Sinalhan', 'City of Santa Rosa', 'Laguna', '2025-03-03', 3, 'accepted'),
(NULL, 'Robert', 'D', 'Brown', '321', '1988-04-04', 'Married', '321D', 'Johnson', 'Alice', 'C', '09654321098', '654', 'Fourth St', 'Sinalhan', 'City of Santa Rosa', 'Laguna', '2025-04-04', 4, 'accepted'),
(NULL, 'Emma', 'E', 'Wilson', '654', '1995-05-05', 'Single', '654E', 'Lee', 'Chris', 'D', '09543210987', '987', 'Fifth St', 'Sinalhan', 'City of Santa Rosa', 'Laguna', '2025-05-05', 5, 'accepted');

-- Dumping data for tbl_bspermit
INSERT INTO tbl_bspermit (fname, mi, lname, bshouseno, bsstreet, bsbrgy, bscity, bsmunicipality, bsindustry, aoe, created_by, doc_status)
VALUES
('Michael', 'F', 'White', '123', 'Business St', 'Sinalhan', 'City of Santa Rosa', 'Laguna', 'Retail', 5, 1, 'accepted'),
('Sarah', 'G', 'Green', '456', 'Market Ave', 'Sinalhan', 'City of Santa Rosa', 'Laguna', 'Services', 10, 2, 'accepted'),
('David', 'H', 'Black', '789', 'Commerce Blvd', 'Sinalhan', 'City of Santa Rosa', 'Laguna', 'Wholesale', 3, 3, 'accepted'),
('Laura', 'I', 'Gray', '321', 'Trade Dr', 'Sinalhan', 'City of Santa Rosa', 'Laguna', 'Manufacturing', 8, 4, 'accepted'),
('Tom', 'J', 'Silver', '654', 'Industry Cir', 'Sinalhan', 'City of Santa Rosa', 'Laguna', 'Construction', 15, 5, 'accepted');

-- Dumping data for tbl_clearance
INSERT INTO tbl_clearance (fname, mi, lname, age, houseno, street, purpose, created_by, doc_status)
VALUES
('Anna', 'K', 'Martin', 28, '101', 'Maple St', 'Employment', 1, 'accepted'),
('Jake', 'L', 'Garcia', 34, '202', 'Pine St', 'Travel', 2, 'accepted'),
('Sophia', 'M', 'Lopez', 25, '303', 'Cedar St', 'Education', 3, 'accepted'),
('Liam', 'N', 'Perez', 40, '404', 'Birch St', 'Housing', 4, 'accepted'),
('Olivia', 'O', 'Ramirez', 22, '505', 'Oak St', 'Other', 5, 'accepted');

-- Dumping data for tbl_indigency
INSERT INTO tbl_indigency (fname, mi, lname, age, nationality, houseno, street, purpose, created_by, doc_status)
VALUES
('James', 'P', 'Hernandez', 32, 'Filipino', '201', 'First Ave', 'Financial Aid', 1, 'accepted'),
('Maria', 'Q', 'Smith', 27, 'Filipino', '202', 'Second Ave', 'Medical Assistance', 2, 'accepted'),
('Ethan', 'R', 'Johnson', 29, 'Filipino', '203', 'Third Ave', 'Scholarship', 3, 'accepted'),
('Ella', 'S', 'Davis', 35, 'Filipino', '204', 'Fourth Ave', 'Housing', 4, 'accepted'),
('Henry', 'T', 'Brown', 24, 'Filipino', '205', 'Fifth Ave', 'Food Assistance', 5, 'accepted');

-- Dumping data for tbl_rescert
INSERT INTO tbl_rescert (fname, mi, lname, age, houseno, street, purpose, created_by, doc_status)
VALUES
('John', 'U', 'Nguyen', 31, '701', 'Lakeside St', 'Identification', 1, 'accepted'),
('Emma', 'V', 'Patel', 26, '702', 'Hilltop Rd', 'Proof of Residency', 2, 'accepted'),
('Lily', 'W', 'Wang', 22, '703', 'Sunset Blvd', 'Work Permit', 3, 'accepted'),
('Noah', 'X', 'Kim', 33, '704', 'Park Ave', 'School Requirements', 4, 'accepted'),
('Grace', 'Y', 'Chen', 29, '705', 'Downtown St', 'Banking', 5, 'accepted');

-- Dumping data for tbl_announcement
INSERT INTO tbl_announcement (`event`, created_by)
VALUES
('Community Meeting', 1),
('Public Health Drive', 1),
('Fire Safety Seminar', 1),
('Disaster Preparedness', 1),
('Clean-Up Drive', 1);

