-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2026 at 09:21 AM
-- Server version: 8.0.44
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sanitaryfactory`
--

-- --------------------------------------------------------

--
-- Table structure for table `material_usage`
--

CREATE TABLE `material_usage` (
  `usage_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `material_id` int DEFAULT NULL,
  `quantity_used` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `material_usage`
--

INSERT INTO `material_usage` (`usage_id`, `product_id`, `material_id`, `quantity_used`) VALUES
(1, 1, 1, 5.00),
(2, 1, 2, 3.00),
(3, 2, 1, 4.00),
(4, 2, 5, 2.00),
(5, 3, 1, 3.00),
(6, 3, 6, 1.00),
(7, 4, 1, 6.00),
(8, 4, 2, 2.00),
(9, 5, 1, 4.00),
(10, 5, 5, 3.00);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int NOT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `molding_required` int DEFAULT NULL,
  `casting_required` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `type`, `molding_required`, `casting_required`) VALUES
(1, 'Wall Hung Toilet', 'Toilet', 3, 4),
(2, 'One Piece Toilet', 'Toilet', 2, 3),
(3, 'Pedestal Basin', 'Basin', 2, 2),
(4, 'Table Top Basin', 'Basin', 1, 2),
(5, 'Corner Basin', 'Basin', 1, 1),
(6, 'Half Pedestal Basin', 'Basin', 2, 2),
(7, 'Squat Pan', 'Toilet', 2, 3),
(8, 'Wash Sink Small', 'Kitchen', 1, 2),
(9, 'Wash Sink Double', 'Kitchen', 2, 3),
(10, 'Designer Basin', 'Luxury', 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE `production` (
  `production_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `production_date` date DEFAULT NULL,
  `quantity_produced` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `production`
--

INSERT INTO `production` (`production_id`, `product_id`, `production_date`, `quantity_produced`) VALUES
(1, 1, '2026-05-01', 50),
(2, 2, '2026-05-01', 40),
(3, 3, '2026-05-01', 30),
(4, 4, '2026-05-02', 45),
(5, 5, '2026-05-02', 35),
(6, 1, '2026-05-03', 60),
(7, 2, '2026-05-03', 50),
(8, 3, '2026-05-04', 55),
(9, 4, '2026-05-04', 65),
(10, 5, '2026-05-05', 70);

-- --------------------------------------------------------

--
-- Table structure for table `raw_material`
--

CREATE TABLE `raw_material` (
  `material_id` int NOT NULL,
  `material_name` varchar(50) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `cost_per_unit` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `raw_material`
--

INSERT INTO `raw_material` (`material_id`, `material_name`, `unit`, `cost_per_unit`) VALUES
(1, 'Clay', 'kg', 10.00),
(2, 'Silica', 'kg', 15.00),
(3, 'Feldspar', 'kg', 20.00),
(4, 'Water', 'litre', 2.00),
(5, 'Glaze', 'kg', 50.00),
(6, 'Color Pigment', 'kg', 100.00),
(7, 'Plaster', 'kg', 30.00),
(8, 'Gypsum', 'kg', 25.00),
(9, 'Sand', 'kg', 5.00),
(10, 'Additives', 'kg', 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `worker`
--

CREATE TABLE `worker` (
  `worker_id` int NOT NULL,
  `worker_name` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `daily_wage` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `worker`
--

INSERT INTO `worker` (`worker_id`, `worker_name`, `role`, `daily_wage`) VALUES
(1, 'Rahul Sharma', 'Molding Worker', 500.00),
(2, 'Amit Patel', 'Casting Worker', 550.00),
(3, 'Ravi Kumar', 'Finishing Worker', 600.00),
(4, 'Suresh Yadav', 'Glazing Worker', 650.00),
(5, 'Mahesh Singh', 'Packing Worker', 400.00),
(6, 'Kiran Verma', 'Supervisor', 800.00),
(7, 'Vijay Thakur', 'Loader', 350.00),
(8, 'Deepak Gupta', 'Quality Check', 700.00),
(9, 'Arjun Mehta', 'Maintenance', 750.00),
(10, 'Manoj Joshi', 'Casting Worker', 550.00),
(11, 'Rakesh Mishra', 'Molding Worker', 520.00),
(12, 'Sunil Chauhan', 'Finishing Worker', 610.00),
(13, 'Anil Desai', 'Glazing Worker', 660.00),
(14, 'Prakash Jain', 'Packing Worker', 420.00),
(15, 'Nitin Shah', 'Supervisor', 820.00),
(16, 'Hemant Patel', 'Loader', 360.00),
(17, 'Dinesh Parmar', 'Quality Check', 710.00),
(18, 'Gaurav Singh', 'Maintenance', 760.00),
(19, 'Pankaj Kumar', 'Casting Worker', 540.00),
(20, 'Sanjay Rana', 'Molding Worker', 530.00);

-- --------------------------------------------------------

--
-- Table structure for table `worker_assignment`
--

CREATE TABLE `worker_assignment` (
  `assignment_id` int NOT NULL,
  `worker_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `work_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `worker_assignment`
--

INSERT INTO `worker_assignment` (`assignment_id`, `worker_id`, `product_id`, `work_type`) VALUES
(1, 1, 1, 'Molding'),
(2, 2, 1, 'Casting'),
(3, 3, 1, 'Finishing'),
(4, 4, 2, 'Glazing'),
(5, 5, 3, 'Packing'),
(6, 6, 4, 'Supervision'),
(7, 7, 5, 'Loading'),
(8, 8, 2, 'Quality Check'),
(9, 9, 3, 'Maintenance'),
(10, 10, 4, 'Casting'),
(11, 11, 5, 'Molding'),
(12, 12, 6, 'Finishing'),
(13, 13, 7, 'Glazing'),
(14, 14, 8, 'Packing'),
(15, 15, 9, 'Supervision'),
(16, 16, 10, 'Loading'),
(17, 17, 6, 'Quality Check'),
(18, 18, 7, 'Maintenance'),
(19, 19, 8, 'Casting'),
(20, 20, 9, 'Molding');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `material_usage`
--
ALTER TABLE `material_usage`
  ADD PRIMARY KEY (`usage_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`production_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `raw_material`
--
ALTER TABLE `raw_material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `worker`
--
ALTER TABLE `worker`
  ADD PRIMARY KEY (`worker_id`);

--
-- Indexes for table `worker_assignment`
--
ALTER TABLE `worker_assignment`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `worker_id` (`worker_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `material_usage`
--
ALTER TABLE `material_usage`
  MODIFY `usage_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `production_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `raw_material`
--
ALTER TABLE `raw_material`
  MODIFY `material_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `worker`
--
ALTER TABLE `worker`
  MODIFY `worker_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `worker_assignment`
--
ALTER TABLE `worker_assignment`
  MODIFY `assignment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `material_usage`
--
ALTER TABLE `material_usage`
  ADD CONSTRAINT `material_usage_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `material_usage_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `raw_material` (`material_id`);

--
-- Constraints for table `production`
--
ALTER TABLE `production`
  ADD CONSTRAINT `production_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `worker_assignment`
--
ALTER TABLE `worker_assignment`
  ADD CONSTRAINT `worker_assignment_ibfk_1` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`),
  ADD CONSTRAINT `worker_assignment_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
