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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mi` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `email`, `password`, `lname`, `fname`, `mi`, `role`) VALUES
(2, 'admin@gmail.com', 'admin', 'vilfamat', 'vincent', 'b', 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_announcement`
--

CREATE TABLE `tbl_announcement` (
  `id_announcement` int(11) NOT NULL,
  `event` varchar(1000) NOT NULL,
  `target` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `addedby` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_announcement`
--

INSERT INTO `tbl_announcement` (`id_announcement`, `event`, `target`, `start_date`, `addedby`) VALUES
(6, 'Free Consultations available from June 13, 2021 until June 25, 2021', NULL, '2021-06-12', 'vilfamat, vincent');


-- --------------------------------------------------------

--
-- Table structure for table `tbl_brgyid`
--

CREATE TABLE `tbl_brgyid` (
  `id_brgyid` varchar(20) NOT NULL,
  `id_resident` int(11) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mi` varchar(255) NOT NULL,
  `houseno` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `brgy` varchar(255) NOT NULL,
  `municipal` varchar(255) NOT NULL,
  `bplace` varchar(255) NOT NULL,
  `bdate` varchar(255) NOT NULL,
  `res_photo` varchar(255) DEFAULT NULL,
  `inc_lname` varchar(255) NOT NULL,
  `inc_fname` varchar(255) NOT NULL,
  `inc_mi` varchar(255) NOT NULL,
  `inc_contact` varchar(255) NOT NULL,
  `inc_houseno` varchar(255) NOT NULL,
  `inc_street` varchar(255) NOT NULL,
  `inc_brgy` varchar(255) NOT NULL,
  `inc_municipal` varchar(255) DEFAULT NULL,
  `req_status` varchar(8) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bspermit`
--

CREATE TABLE `tbl_bspermit` (
  `id_bspermit` varchar(20) NOT NULL,
  `id_resident` int(11) NOT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `mi` varchar(255) DEFAULT NULL,
  `bsname` varchar(255) DEFAULT NULL,
  `houseno` varchar(255) DEFAULT NULL,
  `street` varchar(252) DEFAULT NULL,
  `brgy` varchar(255) DEFAULT NULL,
  `municipal` varchar(255) DEFAULT NULL,
  `bsindustry` varchar(255) DEFAULT NULL,
  `aoe` int(11) NOT NULL,
  `req_status` varchar(8) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `tbl_clearance`
--

CREATE TABLE `tbl_clearance` (
  `id_clearance` varchar(20) NOT NULL,
  `id_resident` int(11) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mi` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `houseno` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `brgy` varchar(255) NOT NULL,
  `municipal` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `req_status` varchar(8) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `tbl_indigency` (
  `id_indigency` varchar(20) NOT NULL,
  `id_resident` int(11) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mi` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `houseno` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `brgy` varchar(255) NOT NULL,
  `municipal` varchar(255) NOT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `req_status` varchar(8) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `tbl_rescert`
--

CREATE TABLE `tbl_rescert` (
  `id_rescert` varchar(20) NOT NULL,
  `id_resident` int(11) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mi` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `houseno` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `brgy` varchar(255) NOT NULL,
  `municipal` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `req_status` varchar(8) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_resident`
--

CREATE TABLE `tbl_resident` (
  `id_resident` int(11) NOT NULL,
  `res_photo` mediumblob DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mi` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `houseno` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `brgy` varchar(255) DEFAULT NULL,
  `municipal` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `bdate` date NOT NULL,
  `bplace` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `family_role` varchar(255) NOT NULL,
  `voter` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `addedby` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mi` varchar(255) NOT NULL,
  `age` int(20) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `addedby` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `email`, `password`, `lname`, `fname`, `mi`, `age`, `sex`, `address`, `contact`, `position`, `role`, `addedby`) VALUES
(12, 'earl@gmail.com', 'earl12345', 'Villaluna', 'Earl', 'Dela Cruz', 23, 'Male', 'Blk. 35 Lot 20 Margo', '09785631125', 'Barangay Treasurer', 'user', 'Vilfamat, Vincent');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  ADD PRIMARY KEY (`id_announcement`);

--
-- Indexes for table `tbl_bspermit`
--
ALTER TABLE `tbl_bspermit`
  ADD PRIMARY KEY (`id_bspermit`);

--
-- Indexes for table `tbl_clearance`
--
ALTER TABLE `tbl_clearance`
  ADD PRIMARY KEY (`id_clearance`);

--
-- Indexes for table `tbl_indigency`
--
ALTER TABLE `tbl_indigency`
  ADD PRIMARY KEY (`id_indigency`);

--
-- Indexes for table `tbl_rescert`
--
ALTER TABLE `tbl_rescert`
  ADD PRIMARY KEY (`id_rescert`);

--
-- Indexes for table `tbl_resident`
--
ALTER TABLE `tbl_resident`
  ADD PRIMARY KEY (`id_resident`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tbl_brgyid`
--
ALTER TABLE `tbl_brgyid`
  ADD PRIMARY KEY (`id_brgyid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  MODIFY `id_announcement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_brgyid`
--
ALTER TABLE `tbl_brgyid`
  MODIFY `id_brgyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;


--
-- AUTO_INCREMENT for table `tbl_bspermit`
--
ALTER TABLE `tbl_bspermit`
  MODIFY `id_bspermit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_clearance`
--
ALTER TABLE `tbl_clearance`
  MODIFY `id_clearance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_indigency`
--
ALTER TABLE `tbl_indigency`
  MODIFY `id_indigency` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_rescert`
--
ALTER TABLE `tbl_rescert`
  MODIFY `id_rescert` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111112;

--
-- AUTO_INCREMENT for table `tbl_resident`
--
ALTER TABLE `tbl_resident`
  MODIFY `id_resident` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Starting number for rescert id (001)
--

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

--
-- Starting number for brgy id (101)
--

CREATE TRIGGER generate_brgy_id
BEFORE INSERT ON tbl_brgyid
FOR EACH ROW
BEGIN
    DECLARE currentDate CHAR(10);
    DECLARE dailyCount INT;
    DECLARE newId VARCHAR(20);

    -- Get the current date in YYYY-MM-DD format
    SET currentDate = DATE_FORMAT(NOW(), '%Y-%m-%d');

    -- Count the entries for the current date
    SELECT COUNT(*) + 101 INTO dailyCount
    FROM tbl_brgyid
    WHERE id_brgyid LIKE CONCAT(currentDate, '-%');

    -- Format the new ID
    SET newId = CONCAT(currentDate, '-', dailyCount);

    -- Assign the generated ID to the new row
    SET NEW.id_brgyid = newId;
END;

--
-- Starting number for rescert id (201)
--

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

    -- Assign the generated ID to the new row
    SET NEW.id_bspermit = newId;
END;

--
-- Starting number for clearance id (301)
--

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

    -- Assign the generated ID to the new row
    SET NEW.id_clearance = newId;
END;

--
-- Starting number for indigency id (401)
--

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

    -- Assign the generated ID to the new row
    SET NEW.id_indigency = newId;
END;
