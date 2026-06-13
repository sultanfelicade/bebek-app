-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 13, 2026 at 04:48 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bebek_wien`
--

-- --------------------------------------------------------

--
-- Table structure for table `m_branches`
--

CREATE TABLE `m_branches` (
  `id_branch` varchar(30) NOT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `address` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `m_branches`
--

INSERT INTO `m_branches` (`id_branch`, `branch_name`, `address`) VALUES
('1', 'Pusat', 'tambelangan'),
('2', 'cabang-1', 'jerengik'),
('3', 'cabang-2', 'pasar tambelangan');

-- --------------------------------------------------------

--
-- Table structure for table `m_categories`
--

CREATE TABLE `m_categories` (
  `id_category` varchar(30) NOT NULL,
  `category_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `m_categories`
--

INSERT INTO `m_categories` (`id_category`, `category_name`) VALUES
('1', 'makanan'),
('2', 'minuman'),
('3', 'cemilan');

-- --------------------------------------------------------

--
-- Table structure for table `m_products`
--

CREATE TABLE `m_products` (
  `id_product` varchar(30) NOT NULL,
  `id_category` varchar(30) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `m_products`
--

INSERT INTO `m_products` (`id_product`, `id_category`, `product_name`, `price`) VALUES
('1', '1', 'bebek goreng', 20000.00),
('2', '1', 'ayam goreng', 18000.00);

-- --------------------------------------------------------

--
-- Table structure for table `m_users`
--

CREATE TABLE `m_users` (
  `id_user` varchar(30) NOT NULL,
  `id_branch` varchar(30) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','kasir') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `m_users`
--

INSERT INTO `m_users` (`id_user`, `id_branch`, `username`, `password`, `role`) VALUES
('5', '1', 'kasir_pusat', '$2y$12$pQBKK4EncQDWykfogulxEOS909P.8Jk2fbWlqE.fAaSypyshbTqQe', 'kasir'),
('6', '1', 'admin_pusat', '$2y$12$OiHrQXqCHTg/htGyeaRSouUCNOHUh8Ekcgsc3qlSj5iigbd31YxmG', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_sales`
--

CREATE TABLE `t_sales` (
  `id_sales` varchar(50) NOT NULL,
  `id_branch` varchar(30) DEFAULT NULL,
  `id_user` varchar(30) DEFAULT NULL,
  `total_amount` decimal(15,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_synced` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_sales_details`
--

CREATE TABLE `t_sales_details` (
  `id_detail` varchar(60) NOT NULL,
  `id_sales` varchar(50) DEFAULT NULL,
  `id_product` varchar(30) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_stock_mutations`
--

CREATE TABLE `t_stock_mutations` (
  `id_mutation` varchar(50) NOT NULL,
  `id_branch` varchar(30) DEFAULT NULL,
  `id_product` varchar(30) DEFAULT NULL,
  `type` enum('in','out') DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_synced` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_branches`
--
ALTER TABLE `m_branches`
  ADD PRIMARY KEY (`id_branch`);

--
-- Indexes for table `m_categories`
--
ALTER TABLE `m_categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `m_products`
--
ALTER TABLE `m_products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_category` (`id_category`);

--
-- Indexes for table `m_users`
--
ALTER TABLE `m_users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_branch` (`id_branch`);

--
-- Indexes for table `t_sales`
--
ALTER TABLE `t_sales`
  ADD PRIMARY KEY (`id_sales`),
  ADD KEY `id_branch` (`id_branch`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `t_sales_details`
--
ALTER TABLE `t_sales_details`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_sales` (`id_sales`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `t_stock_mutations`
--
ALTER TABLE `t_stock_mutations`
  ADD PRIMARY KEY (`id_mutation`),
  ADD KEY `id_branch` (`id_branch`),
  ADD KEY `id_product` (`id_product`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_products`
--
ALTER TABLE `m_products`
  ADD CONSTRAINT `m_products_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `m_categories` (`id_category`);

--
-- Constraints for table `m_users`
--
ALTER TABLE `m_users`
  ADD CONSTRAINT `m_users_ibfk_1` FOREIGN KEY (`id_branch`) REFERENCES `m_branches` (`id_branch`);

--
-- Constraints for table `t_sales`
--
ALTER TABLE `t_sales`
  ADD CONSTRAINT `t_sales_ibfk_1` FOREIGN KEY (`id_branch`) REFERENCES `m_branches` (`id_branch`),
  ADD CONSTRAINT `t_sales_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `m_users` (`id_user`);

--
-- Constraints for table `t_sales_details`
--
ALTER TABLE `t_sales_details`
  ADD CONSTRAINT `t_sales_details_ibfk_1` FOREIGN KEY (`id_sales`) REFERENCES `t_sales` (`id_sales`),
  ADD CONSTRAINT `t_sales_details_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `m_products` (`id_product`);

--
-- Constraints for table `t_stock_mutations`
--
ALTER TABLE `t_stock_mutations`
  ADD CONSTRAINT `t_stock_mutations_ibfk_1` FOREIGN KEY (`id_branch`) REFERENCES `m_branches` (`id_branch`),
  ADD CONSTRAINT `t_stock_mutations_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `m_products` (`id_product`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
