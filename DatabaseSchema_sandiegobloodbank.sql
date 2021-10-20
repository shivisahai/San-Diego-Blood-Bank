-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2021 at 08:38 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sandiegobloodbank`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood`
--

CREATE TABLE `blood` (
  `Blood_ID` int(11) NOT NULL,
  `Blood_Group` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blood`
--

INSERT INTO `blood` (`Blood_ID`, `Blood_Group`) VALUES
(101, 'A+'),
(102, 'A-'),
(103, 'B+'),
(104, 'B-'),
(105, 'AB+'),
(106, 'AB-'),
(107, 'O+'),
(108, 'O-');

-- --------------------------------------------------------

--
-- Table structure for table `center`
--

CREATE TABLE `center` (
  `Center_ID` int(11) NOT NULL,
  `Center_Name` varchar(400) NOT NULL,
  `Center_Address` varchar(600) NOT NULL,
  `Zip_Code` varchar(10) NOT NULL,
  `Blood_ID` int(11) NOT NULL,
  `Blood_Type` varchar(30) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `center`
--

INSERT INTO `center` (`Center_ID`, `Center_Name`, `Center_Address`, `Zip_Code`, `Blood_ID`, `Blood_Type`, `Quantity`) VALUES
(9001, 'BIOMAT USA', '693 Palomar St Suite #7, Chula Vista, CA 91911', '91911', 101, 'Whole Blood', 4000),
(9001, 'BIOMAT USA', '693 Palomar St Suite #7, Chula Vista, CA 91911', '91911', 102, 'Red Blood Cells', 77345),
(9001, 'BIOMAT USA', '693 Palomar St Suite #7, Chula Vista, CA 91911', '91911', 103, 'Plasma', 2100),
(9002, 'Octapharma Plasma', '3232 Duke St, San Diego, CA 92110', '92110', 104, 'Platelet', 88432),
(9002, 'Octapharma Plasma', '3232 Duke St, San Diego, CA 92110', '92110', 105, 'Platelet', 10),
(9002, 'Octapharma Plasma', '3232 Duke St, San Diego, CA 92110', '92110', 106, 'Platelet', 88432),
(9003, 'San Diego Blood Bank', '3636 Gateway Center Ave STE 100, San Diego, CA 92102', '92102', 101, 'Platelet', 827),
(9003, 'San Diego Blood Bank', '3636 Gateway Center Ave STE 100, San Diego, CA 92102', '92102', 102, 'Whole Blood', 552),
(9003, 'San Diego Blood Bank', '3636 Gateway Center Ave STE 100, San Diego, CA 92102', '92102', 103, 'Whole Blood', 64242),
(9003, 'San Diego Blood Bank', '3636 Gateway Center Ave STE 100, San Diego, CA 92102', '92102', 104, 'Whole Blood', 3302),
(9003, 'San Diego Blood Bank', '3636 Gateway Center Ave STE 100, San Diego, CA 92102', '92102', 107, 'Whole Blood', 3302),
(9003, 'San Diego Blood Bank', '3636 Gateway Center Ave STE 100, San Diego, CA 92102', '92102', 108, 'Red Blood Cells', 98433),
(9004, 'Kearny Mesa Blood, Platelet and Plasma Donation Center', '4229 Ponderosa Ave C, San Diego, CA 92123', '92123', 105, 'Whole Blood', 732873),
(9004, 'Kearny Mesa Blood, Platelet and Plasma Donation Center', '4229 Ponderosa Ave C, San Diego, CA 92123', '92123', 106, 'Plasma', 932941),
(9004, 'Kearny Mesa Blood, Platelet and Plasma Donation Center', '4229 Ponderosa Ave C, San Diego, CA 92123', '92123', 108, 'Whole Blood', 732873);

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `Donor_ID` int(11) NOT NULL,
  `Donor_Name` varchar(50) NOT NULL,
  `Donor_Address` varchar(500) NOT NULL,
  `Zip_Code` varchar(10) NOT NULL,
  `Blood_Group` varchar(3) NOT NULL,
  `Donation_Type` varchar(20) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Center_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recipient`
--

CREATE TABLE `recipient` (
  `Receiver_ID` int(11) NOT NULL,
  `Receiver_Name` varchar(100) NOT NULL,
  `Receiver_Address` varchar(600) NOT NULL,
  `Zip_Code` varchar(10) NOT NULL,
  `Date` date NOT NULL,
  `Blood_Group` varchar(4) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Center_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood`
--
ALTER TABLE `blood`
  ADD PRIMARY KEY (`Blood_ID`);

--
-- Indexes for table `center`
--
ALTER TABLE `center`
  ADD PRIMARY KEY (`Center_ID`,`Blood_ID`,`Blood_Type`),
  ADD KEY `center_bloodId_fk` (`Blood_ID`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`Donor_ID`),
  ADD KEY `donor_centerId_fk` (`Center_ID`);

--
-- Indexes for table `recipient`
--
ALTER TABLE `recipient`
  ADD PRIMARY KEY (`Receiver_ID`),
  ADD KEY `recipient_centerId_fk` (`Center_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `center`
--
ALTER TABLE `center`
  ADD CONSTRAINT `center_bloodId_fk` FOREIGN KEY (`Blood_ID`) REFERENCES `blood` (`Blood_ID`);

--
-- Constraints for table `donor`
--
ALTER TABLE `donor`
  ADD CONSTRAINT `donor_centerId_fk` FOREIGN KEY (`Center_ID`) REFERENCES `center` (`Center_ID`);

--
-- Constraints for table `recipient`
--
ALTER TABLE `recipient`
  ADD CONSTRAINT `recipient_centerId_fk` FOREIGN KEY (`Center_ID`) REFERENCES `center` (`Center_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
