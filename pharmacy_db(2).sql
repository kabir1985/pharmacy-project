-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 27, 2026 at 11:07 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int NOT NULL,
  `currency_code` varchar(50) NOT NULL,
  `currency_name` varchar(50) NOT NULL,
  `currency_symbol` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `currency_code`, `currency_name`, `currency_symbol`) VALUES
(7, 'BDT', 'Taka', 'TK.');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` bigint UNSIGNED NOT NULL,
  `customer_group_id` bigint UNSIGNED DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_group_id`, `customer_name`, `phone`, `address`, `status`, `created_at`, `updated_at`) VALUES
(13, 2, 'Karim Ahmed', '01711000002', 'Gazipur', 0, '2026-07-24 06:51:38', '2026-07-24 17:10:32'),
(15, 2, 'Fouzia Begum', '01711000004', 'Dhaka', 1, '2026-07-24 06:51:38', '2026-07-24 06:51:38'),
(16, 3, 'ABC Diagnostic Center', '01711000005', 'Dhaka', 0, '2026-07-24 06:51:38', '2026-07-24 17:10:40'),
(20, 1, 'Jahid Hasan', '01711000009', 'Khulna', 1, '2026-07-24 06:51:38', '2026-07-24 06:51:38'),
(21, 2, 'kona123', '0191835567', 'Gazipur, Dhaka', 1, '2026-07-24 16:55:13', '2026-07-24 17:13:59'),
(23, 1, 'Ayan', '011764434', 'Barishal', 1, '2026-07-24 17:20:02', '2026-07-24 17:20:02');

-- --------------------------------------------------------

--
-- Table structure for table `customer_due`
--

CREATE TABLE `customer_due` (
  `due_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `sales_id` bigint UNSIGNED NOT NULL,
  `due_amount` decimal(15,2) NOT NULL,
  `paid_amount` decimal(15,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_due`
--

INSERT INTO `customer_due` (`due_id`, `customer_id`, `sales_id`, `due_amount`, `paid_amount`) VALUES
(30, 21, 821, 0.00, 100.08),
(31, 20, 822, 0.00, 36.20);

-- --------------------------------------------------------

--
-- Table structure for table `customer_due_payment`
--

CREATE TABLE `customer_due_payment` (
  `payment_id` bigint UNSIGNED NOT NULL,
  `due_id` bigint UNSIGNED NOT NULL,
  `sales_id` int NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `payment_method` enum('Cash','Card','Bkash','Nagad','Rocket','Bank','Cheque') NOT NULL DEFAULT 'Cash',
  `reference_no` varchar(100) DEFAULT NULL,
  `note` text,
  `received_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_due_payment`
--

INSERT INTO `customer_due_payment` (`payment_id`, `due_id`, `sales_id`, `customer_id`, `payment_date`, `payment_amount`, `payment_method`, `reference_no`, `note`, `received_by`, `created_at`, `updated_at`) VALUES
(7, 30, 821, 21, '2026-07-27 00:00:00', 100.08, 'Cash', '', '', 18, '2026-07-27 05:22:59', '2026-07-27 05:22:59'),
(8, 31, 822, 20, '2026-07-27 00:00:00', 20.00, 'Cash', '', '', 18, '2026-07-27 06:36:56', '2026-07-27 06:36:56'),
(9, 31, 822, 20, '2026-07-27 00:00:00', 16.20, 'Cash', '', '', 18, '2026-07-27 06:45:32', '2026-07-27 06:45:32');

-- --------------------------------------------------------

--
-- Table structure for table `customer_group`
--

CREATE TABLE `customer_group` (
  `customer_group_id` bigint UNSIGNED NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_group`
--

INSERT INTO `customer_group` (`customer_group_id`, `group_name`, `discount_percent`) VALUES
(1, 'General', 0.00),
(2, 'VIP', 5.00),
(3, 'Wholesale', 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expense_id` bigint UNSIGNED NOT NULL,
  `expense_ref_no` varchar(150) NOT NULL,
  `expense_category` bigint DEFAULT NULL,
  `expense_sub_category` bigint DEFAULT NULL,
  `expense_what_for` varchar(200) NOT NULL,
  `expense_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `expense_note` text,
  `expense_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expense_id`, `expense_ref_no`, `expense_category`, `expense_sub_category`, `expense_what_for`, `expense_amount`, `expense_note`, `expense_date`, `created_at`) VALUES
(4, 'test', 16, 24, 'rent', 20.00, 'test', '0000-00-00', '2026-07-12 15:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

CREATE TABLE `expense_category` (
  `expense_category_id` bigint NOT NULL,
  `expense_category_name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `expense_category`
--

INSERT INTO `expense_category` (`expense_category_id`, `expense_category_name`) VALUES
(15, 'Employee Salary'),
(16, 'Shop Rent'),
(17, 'License & Regulatory Fees'),
(18, 'Tax & VAT'),
(19, 'Cleaning & Maintenance'),
(20, 'Software & IT'),
(21, 'Marketing & Advertising'),
(22, 'Office Expense'),
(23, 'Miscellaneous');

-- --------------------------------------------------------

--
-- Table structure for table `expense_sub_category`
--

CREATE TABLE `expense_sub_category` (
  `expense_sub_category_id` bigint NOT NULL,
  `expense_category_id` bigint NOT NULL,
  `expense_sub_category_name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `expense_sub_category`
--

INSERT INTO `expense_sub_category` (`expense_sub_category_id`, `expense_category_id`, `expense_sub_category_name`) VALUES
(11, 15, 'Pharmacist Salary'),
(12, 15, 'Salesman Salary'),
(13, 15, 'Accountant Salary'),
(14, 15, 'Cleaner Salary'),
(15, 15, 'Overtime'),
(16, 15, 'Bonus'),
(17, 15, 'Commission'),
(18, 21, 'Facebook Ads'),
(19, 21, 'Banner Printing'),
(20, 21, 'Leaflet/Flyer'),
(21, 21, 'Local Newspaper Ads'),
(22, 21, 'Shop Signboard'),
(23, 15, 'SalsMan Salary'),
(24, 16, 'Rent May 2026');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_email` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `currency_id` varchar(50) NOT NULL,
  `company_phone` varchar(40) NOT NULL,
  `company_logo` varchar(200) DEFAULT NULL,
  `company_address` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `company_name`, `company_email`, `country`, `currency_id`, `company_phone`, `company_logo`, `company_address`) VALUES
(11, 'ABC Pharma', 'abc@gmail.com', 'Bangladesh', '7', '01913691185', NULL, 'House# 25, Road# 07, Sector# 2, Aftabnagar, Dhaka');

-- --------------------------------------------------------

--
-- Table structure for table `held_sales`
--

CREATE TABLE `held_sales` (
  `id` int NOT NULL,
  `hold_id` varchar(50) NOT NULL,
  `seller_id` int NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `cart_data` longtext NOT NULL,
  `otherChargeOnTotalPrice` decimal(11,2) DEFAULT NULL,
  `created_at` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_id`
--

CREATE TABLE `menu_id` (
  `id` int NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `menu_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu_id`
--

INSERT INTO `menu_id` (`id`, `menu_name`, `menu_id`) VALUES
(1, 'initial_product', 1),
(2, 'barcode_generate', 2),
(3, 'product_category', 3),
(4, 'product_brand', 4),
(5, 'product_group', 5),
(6, 'product_unit', 6),
(7, 'pos_sale', 7),
(8, 'general_sale', 8),
(9, 'sale_list', 9),
(10, 'sale_return', 10),
(11, 'sale_return_list', 11),
(12, 'purchase_product', 12),
(13, 'expense_category', 13),
(14, 'expense_sub_category', 14),
(15, 'expense_add', 15),
(16, 'customer_group', 16),
(17, 'customer_add', 17),
(18, 'supplier_add', 18),
(19, 'user_creation', 19),
(20, 'user_role_set', 20),
(21, 'due_collection', 21),
(22, 'supplier_payment', 22),
(23, 'general_settings', 23),
(24, 'currency_settings', 24),
(25, 'tax_setup', 25),
(26, 'stock_report', 26),
(27, 'sale_report', 27),
(28, 'profit_loss', 28),
(29, 'expense_report', 29),
(30, 'supplier_report', 30),
(31, 'customer_report', 31),
(32, 'vat_tax_report', 32);

-- --------------------------------------------------------

--
-- Table structure for table `payment_receive`
--

CREATE TABLE `payment_receive` (
  `payment_id` bigint NOT NULL,
  `bill_no` varchar(100) NOT NULL,
  `total_amount` bigint NOT NULL,
  `received_amount` bigint NOT NULL,
  `balance_amount` bigint NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_brand`
--

CREATE TABLE `product_brand` (
  `brand_id` bigint UNSIGNED NOT NULL,
  `product_brand_name` varchar(50) NOT NULL,
  `product_category_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_brand`
--

INSERT INTO `product_brand` (`brand_id`, `product_brand_name`, `product_category_id`, `created_at`, `updated_at`) VALUES
(39, 'Incepta', 133, '2026-05-24 08:04:27', '2026-05-24 08:04:27'),
(40, 'Square Pharma12', 138, '2026-05-24 08:04:27', '2026-07-21 04:48:53'),
(41, 'ayan', 140, '2026-07-03 14:39:15', '2026-07-03 14:39:15'),
(42, 'Aristopharma', 135, '2026-07-03 16:15:02', '2026-07-06 07:00:47'),
(44, 'ACI', 133, '2026-07-06 07:02:02', '2026-07-06 07:02:02'),
(45, 'Opsonin', 133, '2026-07-06 07:02:30', '2026-07-06 07:02:30'),
(46, 'Novartis', 133, '2026-07-06 07:02:59', '2026-07-06 07:02:59'),
(48, 'cef3', 134, '2026-07-19 04:49:38', '2026-07-19 04:49:38'),
(52, 'napa syrup', 133, '2026-07-19 08:19:07', '2026-07-19 08:19:07'),
(54, 'sdfdsf', 138, '2026-07-22 10:38:07', '2026-07-22 10:38:07'),
(55, 'sdfdsf', 155, '2026-07-23 06:32:51', '2026-07-23 06:32:51'),
(56, 'dfdsff', 153, '2026-07-23 06:33:39', '2026-07-23 06:33:39'),
(57, 'testbrand', 158, '2026-07-23 06:39:43', '2026-07-23 06:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_category_id` bigint NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`product_category_id`, `category_name`) VALUES
(134, 'Injections'),
(135, 'Gels & Lotions'),
(136, 'Suppositories 123'),
(137, 'Drops'),
(138, 'Capsule'),
(153, 'sdfdsfdsf'),
(154, 'hello category'),
(155, 'sdfdsfd'),
(156, 'dd2222'),
(157, 'sdfdsf'),
(158, 'testcategory');

-- --------------------------------------------------------

--
-- Table structure for table `product_group`
--

CREATE TABLE `product_group` (
  `product_group_id` bigint NOT NULL,
  `group_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_group`
--

INSERT INTO `product_group` (`product_group_id`, `group_name`) VALUES
(32, 'Fexofenadine'),
(38, 'Vitamin C'),
(42, 'Ciprofloxacin'),
(43, 'Diclofenac Diethylamine'),
(44, 'Surgical Items'),
(45, 'Nutritional Products'),
(46, 'Paracetamol'),
(47, 'Omeprazole'),
(48, 'Lotion'),
(49, 'Cefixime'),
(50, 'gggg'),
(51, 'tstgroup');

-- --------------------------------------------------------

--
-- Table structure for table `product_inital_stock`
--

CREATE TABLE `product_inital_stock` (
  `product_id` bigint NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_category` int DEFAULT NULL,
  `product_brand` int DEFAULT NULL,
  `product_group` int DEFAULT NULL,
  `product_strength` int NOT NULL,
  `product_unit` int DEFAULT NULL,
  `codefor_barcode` varchar(100) DEFAULT NULL,
  `productinitial_quantity` decimal(10,2) DEFAULT '0.00',
  `base_price` decimal(15,2) DEFAULT '0.00',
  `cost_without_vat` decimal(15,2) DEFAULT '0.00',
  `tax_type` enum('with_tax','without_tax') NOT NULL,
  `tax_id` int NOT NULL,
  `tax_amount` decimal(15,2) DEFAULT '0.00',
  `purchase_price` decimal(15,2) DEFAULT '0.00',
  `profit_margin_%` decimal(5,2) DEFAULT NULL,
  `sales_price_for_customer` decimal(15,2) DEFAULT '0.00',
  `alert_quantity` decimal(10,2) DEFAULT '0.00',
  `product_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_inital_stock`
--

INSERT INTO `product_inital_stock` (`product_id`, `product_name`, `product_category`, `product_brand`, `product_group`, `product_strength`, `product_unit`, `codefor_barcode`, `productinitial_quantity`, `base_price`, `cost_without_vat`, `tax_type`, `tax_id`, `tax_amount`, `purchase_price`, `profit_margin_%`, `sales_price_for_customer`, `alert_quantity`, `product_image`, `created_at`, `updated_at`) VALUES
(573, 'Napa 500', 132, 47, 46, 1, 22, 'barcode-napa', 5000.00, 1.00, 1.00, 'without_tax', 11, 0.00, 1.00, 20.00, 1.20, 5.00, 'napa 500.jpg', '2026-07-06 07:21:17', '2026-07-06 07:21:17'),
(574, 'Cef-3', NULL, NULL, 49, 5, 22, 'barcode-cef', 500.00, 33.00, 33.00, 'without_tax', 11, 0.00, 33.00, 21.00, 40.00, 5.00, 'cef-3.jpg', '2026-07-06 08:40:58', '2026-07-23 05:15:04'),
(575, 'test', 134, 48, 43, 5, 22, 'barcode-cef', 100.00, 34.00, 34.00, 'without_tax', 14, 0.00, 34.00, 32.00, 45.00, 5.00, 'default-medicine.png', '2026-07-19 04:50:47', '2026-07-19 04:50:47'),
(576, 'testproduct', 158, 57, 51, 17, 49, 'bar', 100.00, 20.00, 20.00, 'without_tax', 15, 0.00, 20.00, 22.00, 25.00, 4.00, '1784788875_43542eaa92d9178fe46d.png', '2026-07-23 06:41:15', '2026-07-23 07:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase`
--

CREATE TABLE `product_purchase` (
  `product_purchase_id` int NOT NULL,
  `purchase_invoice` varchar(100) NOT NULL,
  `purchaser_id` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `payment_type` varchar(80) NOT NULL,
  `supplier_id` varchar(50) NOT NULL,
  `invoice_total` decimal(12,2) DEFAULT NULL,
  `discount_amount_on_invoice_total` decimal(10,2) DEFAULT NULL,
  `vat_amount_on_invoice_total` decimal(10,2) DEFAULT NULL,
  `invoice_net_total` decimal(12,2) DEFAULT NULL,
  `purchase_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_purchase`
--

INSERT INTO `product_purchase` (`product_purchase_id`, `purchase_invoice`, `purchaser_id`, `payment_type`, `supplier_id`, `invoice_total`, `discount_amount_on_invoice_total`, `vat_amount_on_invoice_total`, `invoice_net_total`, `purchase_date`) VALUES
(112, 'PUR2618793170', '18', 'Cash', '106', 100.00, 0.00, 0.00, 100.00, '2026-07-06 07:23:23'),
(113, 'PUR26187A2715', '18', 'Cash', '124', 100.00, 0.00, 0.00, 100.00, '2026-07-06 08:46:33'),
(114, 'PUR26192608F1', '18', 'Cash', '106', 36.38, 1.09, 1.20, 36.45, '2026-07-11 06:42:50'),
(115, 'PUR2620051541', '18', 'Cash', '106', 327.69, 8.00, 31.75, 350.67, '2026-07-19 04:27:11'),
(116, 'PUR26202C8A31', '18', 'Cash', '124', 35.02, 0.00, 0.36, 35.38, '2026-07-21 08:32:38'),
(117, 'PUR2620211803', '18', 'Cash', '106', 35.02, 0.00, 0.36, 35.38, '2026-07-21 08:33:47'),
(118, 'PUR26202D0964', '18', 'Cash', '106', 67.99, 0.00, 0.67, 68.66, '2026-07-21 08:53:48'),
(119, 'PUR262048E221', '18', 'Cash', '106', 54390.00, 0.00, 598290.00, 652680.00, '2026-07-23 07:07:46'),
(120, 'PUR26207D16BF', '18', 'Cash', '106', 2161.01, 302.00, 3673.72, 5019.33, '2026-07-26 04:53:14'),
(121, 'PUR26207227CE', '18', 'Cash', '106', 250.34, 6.00, 51.90, 294.99, '2026-07-26 06:01:34'),
(122, 'PUR2620774321', '18', 'Cash', '106', 51.94, 4.00, 0.00, 47.94, '2026-07-26 06:37:56'),
(123, 'PUR26207F7FC6', '18', 'Cash', '106', 20.00, 0.00, 0.00, 20.00, '2026-07-26 06:48:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase_details`
--

CREATE TABLE `product_purchase_details` (
  `purchase_id` bigint NOT NULL,
  `purchase_invoice_id` varchar(100) NOT NULL,
  `product_id` bigint NOT NULL,
  `quantity_per_pack` int NOT NULL DEFAULT '0',
  `box_quantity` int NOT NULL DEFAULT '1',
  `base_price_per_unit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `free_qty` bigint NOT NULL,
  `product_wise_vat_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `product_wise_discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchase_price` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_purchase_details`
--

INSERT INTO `product_purchase_details` (`purchase_id`, `purchase_invoice_id`, `product_id`, `quantity_per_pack`, `box_quantity`, `base_price_per_unit`, `free_qty`, `product_wise_vat_amount`, `product_wise_discount_amount`, `purchase_price`) VALUES
(179, 'PUR2618793170', 573, 100, 1, 1.00, 0, 0.00, 0.00, 100.00),
(180, 'PUR26187A2715', 573, 100, 1, 1.00, 50, 0.00, 0.00, 100.00),
(181, 'PUR26192608F1', 574, 1, 1, 33.00, 10, 3.30, 0.99, 35.31),
(182, 'PUR26192608F1', 573, 1, 1, 1.00, 0, 0.10, 0.03, 1.07),
(183, 'PUR2620051541', 574, 1, 10, 33.00, 0, 9.90, 13.20, 326.70),
(184, 'PUR2620051541', 573, 1, 1, 1.00, 0, 0.03, 0.04, 0.99),
(185, 'PUR26202C8A31', 574, 1, 1, 33.00, 0, 0.99, 0.00, 33.99),
(186, 'PUR26202C8A31', 573, 1, 1, 1.00, 0, 0.03, 0.00, 1.03),
(187, 'PUR2620211803', 574, 1, 1, 33.00, 0, 0.99, 0.00, 33.99),
(188, 'PUR2620211803', 573, 1, 1, 1.00, 0, 0.03, 0.00, 1.03),
(189, 'PUR26202D0964', 575, 1, 1, 34.00, 0, 0.00, 0.00, 34.00),
(190, 'PUR26202D0964', 574, 1, 1, 33.00, 0, 0.99, 0.00, 33.99),
(191, 'PUR262048E221', 576, 1000, 1, 20.00, 0, 400.00, 0.00, 20400.00),
(192, 'PUR262048E221', 574, 1000, 1, 33.00, 0, 990.00, 0.00, 33990.00),
(193, 'PUR26207D16BF', 576, 1, 100, 20.00, 0, 200.00, 40.00, 2160.00),
(194, 'PUR26207D16BF', 573, 1, 1, 1.00, 0, 0.03, 0.02, 1.01),
(195, 'PUR26207227CE', 576, 1, 10, 20.00, 0, 20.00, 4.00, 216.00),
(196, 'PUR26207227CE', 573, 1, 1, 1.00, 0, 0.03, 0.02, 1.01),
(197, 'PUR26207227CE', 574, 1, 1, 33.00, 0, 0.99, 0.66, 33.33),
(198, 'PUR2620774321', 576, 1, 1, 20.00, 0, 0.00, 0.40, 19.60),
(199, 'PUR2620774321', 574, 1, 1, 33.00, 0, 0.00, 0.66, 32.34),
(200, 'PUR26207F7FC6', 576, 1, 1, 20.00, 0, 0.00, 0.00, 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_stock`
--

CREATE TABLE `product_stock` (
  `stock_id` int NOT NULL,
  `product_id` bigint NOT NULL,
  `opening_stock` int DEFAULT '0',
  `purchase_stock` int DEFAULT '0',
  `sale_stock` int DEFAULT '0',
  `return_stock` int DEFAULT '0',
  `adjustment_in_stock` decimal(12,2) DEFAULT '0.00',
  `adjustment_out_stock` decimal(12,2) DEFAULT '0.00',
  `current_stock` int DEFAULT '0',
  `last_update` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_strength`
--

CREATE TABLE `product_strength` (
  `strength_id` int NOT NULL,
  `strength_name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_strength`
--

INSERT INTO `product_strength` (`strength_id`, `strength_name`) VALUES
(1, '500 mg'),
(2, '20mg'),
(3, '10mg'),
(4, '665 mg'),
(5, '200 mg'),
(6, '100 mg/5ml'),
(7, '120 mg/5ml'),
(8, '12 mg/ml'),
(9, '250 mg'),
(10, '5 mg/5ml'),
(11, '120 mg'),
(12, '1%'),
(13, '100 IU/ml'),
(14, '5 ml'),
(15, '23mg'),
(16, 'strddd'),
(17, 'teststrength');

-- --------------------------------------------------------

--
-- Table structure for table `product_unit`
--

CREATE TABLE `product_unit` (
  `product_unit_id` bigint NOT NULL,
  `product_unit_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_unit`
--

INSERT INTO `product_unit` (`product_unit_id`, `product_unit_name`) VALUES
(20, 'Tablet (Tab)'),
(21, 'Capsule (Cap)'),
(22, 'Piece (Pcs)'),
(23, 'Strip (e.g., 10 tablets per strip)'),
(26, 'Bottle11'),
(28, 'Ampoule'),
(29, 'mg (Milligram)'),
(30, 'g (Gram)111'),
(31, 'kg (Kilogram)'),
(34, 'Pair (for gloves)'),
(36, 'kg'),
(41, 'Tube'),
(48, 'dasdsad'),
(49, 'tstunit');

-- --------------------------------------------------------

--
-- Table structure for table `return_customer_due`
--

CREATE TABLE `return_customer_due` (
  `due_id` int NOT NULL,
  `return_due_date` varchar(30) NOT NULL,
  `customer_id` varchar(30) NOT NULL,
  `due_invoice_no` varchar(30) NOT NULL,
  `due_amount` bigint NOT NULL,
  `due_paid_amount` bigint NOT NULL,
  `current_balance` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `return_customer_due`
--

INSERT INTO `return_customer_due` (`due_id`, `return_due_date`, `customer_id`, `due_invoice_no`, `due_amount`, `due_paid_amount`, `current_balance`) VALUES
(125, '09-07-2026', '15', 'INV2618814E54', 42, 0, 0),
(126, '09-07-2026', '15', 'INV26188117BA', 176, 0, 0),
(127, '16-07-2026', '18', 'INV261908D965', 240, 0, 0),
(128, '16-07-2026', '15', 'INV26191D02AC', 31, 0, 0),
(129, '16-07-2026', '15', 'INV26191D02AC', 31, 0, 0),
(130, '16-07-2026', '15', 'INV261914A4CC', 33, 0, 0),
(131, '23-07-2026', '15', 'INV26204E78B7', 110, 0, 0),
(132, '23-07-2026', '15', 'INV26204E78B7', 110, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `return_sales`
--

CREATE TABLE `return_sales` (
  `return_id` int NOT NULL,
  `sales_invoice` varchar(50) NOT NULL,
  `customer_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `return_date` timestamp NULL DEFAULT NULL,
  `payment_type` varchar(50) NOT NULL,
  `product_discount` decimal(11,2) DEFAULT NULL,
  `product_vat` decimal(11,2) DEFAULT '0.00',
  `other_charge_on_all` decimal(10,0) DEFAULT NULL,
  `paid_amount` decimal(11,2) DEFAULT '0.00',
  `due_amount` decimal(11,2) DEFAULT '0.00',
  `return_by` int NOT NULL,
  `return_type` enum('FULL','PARTIAL') NOT NULL,
  `return_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `return_sales`
--

INSERT INTO `return_sales` (`return_id`, `sales_invoice`, `customer_type`, `return_date`, `payment_type`, `product_discount`, `product_vat`, `other_charge_on_all`, `paid_amount`, `due_amount`, `return_by`, `return_type`, `return_reason`, `created_at`) VALUES
(116, 'INV26188777A1', 'Walk-In-Customer', '2026-07-06 22:54:21', 'Cash', 0.00, 0.00, 0, 41.22, 0.00, 18, 'PARTIAL', 'dsfsf', '2026-07-09 05:25:22'),
(117, 'INV2618814E54', '15', '2026-07-07 00:51:16', 'Cash', 0.00, 0.00, 0, 0.00, 41.61, 18, 'FULL', 'test', '2026-07-09 05:30:05'),
(118, 'INV26188117BA', '15', '2026-07-07 04:34:43', 'Cash', 0.00, 16.00, 0, 0.00, 176.00, 18, 'FULL', 'sdfds', '2026-07-09 05:30:47'),
(119, 'INV261908D965', '18', '2026-07-08 23:31:30', 'Cash', 0.00, 0.00, 0, 0.00, 240.00, 18, 'PARTIAL', 'sdff', '2026-07-16 05:29:03'),
(120, 'INV26191D02AC', '15', '2026-07-10 06:15:52', 'Cash', 10.00, 0.00, 0, 0.00, 31.20, 18, 'PARTIAL', 'fdgdgd', '2026-07-16 05:29:24'),
(121, 'INV261914A4CC', '15', '2026-07-10 06:16:56', 'Cash', 10.00, 0.00, 2, 0.00, 33.20, 18, 'FULL', 'hjjhk', '2026-07-16 05:29:50'),
(122, 'INV26204E78B7', '15', '2026-07-23 01:03:14', 'Cash', 0.00, 0.00, 0, 0.00, 110.00, 18, 'PARTIAL', 'test', '2026-07-23 07:08:56');

-- --------------------------------------------------------

--
-- Table structure for table `return_sales_details`
--

CREATE TABLE `return_sales_details` (
  `return_detail_id` int NOT NULL,
  `sales_details_invoice` varchar(50) NOT NULL,
  `product_id` int NOT NULL,
  `return_qty` int DEFAULT NULL,
  `unit_price` decimal(11,2) DEFAULT NULL,
  `total_buy_price` decimal(11,2) DEFAULT '0.00',
  `total_sale_price` decimal(11,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `return_sales_details`
--

INSERT INTO `return_sales_details` (`return_detail_id`, `sales_details_invoice`, `product_id`, `return_qty`, `unit_price`, `total_buy_price`, `total_sale_price`) VALUES
(102, 'INV26188777A1', 573, 1, 1.20, 1.00, 1.20),
(103, 'INV2618814E54', 574, 1, 40.00, 33.00, 40.00),
(104, 'INV2618814E54', 573, 1, 1.20, 1.00, 1.20),
(105, 'INV26188777A1', 574, 1, 40.00, 33.00, 40.00),
(106, 'INV26188117BA', 574, 4, 40.00, 132.00, 160.00),
(107, 'INV261908D965', 574, 1, 40.00, 198.00, 240.00),
(108, 'INV26191D02AC', 573, 1, 1.20, 1.00, 1.20),
(109, 'INV26191D02AC', 574, 1, 40.00, 33.00, 40.00),
(110, 'INV261914A4CC', 574, 1, 40.00, 33.00, 40.00),
(111, 'INV261914A4CC', 573, 1, 1.20, 1.00, 1.20),
(112, 'INV26204E78B7', 576, 1, 25.00, 20.00, 25.00),
(113, 'INV26204E78B7', 575, 1, 45.00, 34.00, 45.00),
(114, 'INV26204E78B7', 574, 1, 40.00, 33.00, 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int NOT NULL,
  `sales_invoice` varchar(50) NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `sales_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_type` varchar(11) NOT NULL,
  `total_amount` decimal(11,2) DEFAULT NULL,
  `product_discount` decimal(11,2) NOT NULL,
  `product_vat` decimal(11,2) NOT NULL,
  `other_charge_on_all` decimal(11,2) NOT NULL,
  `paid_amount` decimal(11,2) DEFAULT NULL,
  `due_amount` decimal(11,2) DEFAULT NULL,
  `seller_id` int DEFAULT NULL,
  `return_status` enum('ACTIVE','PARTIAL','FULL') DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `sales_invoice`, `customer_id`, `sales_date`, `payment_type`, `total_amount`, `product_discount`, `product_vat`, `other_charge_on_all`, `paid_amount`, `due_amount`, `seller_id`, `return_status`, `created_at`) VALUES
(821, 'INV26208500BD', 21, '2026-07-26 23:21:36', 'Cash', 100.08, 11.12, 0.00, 0.00, 100.08, 0.00, 18, 'ACTIVE', '2026-07-27 05:21:36'),
(822, 'INV26208B8A92', 20, '2026-07-27 00:14:09', 'Cash', 41.20, 0.00, 0.00, 0.00, 41.20, 0.00, 18, 'ACTIVE', '2026-07-27 06:14:09');

-- --------------------------------------------------------

--
-- Table structure for table `sales_details`
--

CREATE TABLE `sales_details` (
  `sales_details_id` int NOT NULL,
  `sales_details_invoice` varchar(50) DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `product_quantity_sold` int DEFAULT NULL,
  `unit_price` decimal(11,2) DEFAULT NULL,
  `total_sale_price` decimal(11,2) DEFAULT NULL,
  `total_buy_price` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales_details`
--

INSERT INTO `sales_details` (`sales_details_id`, `sales_details_invoice`, `product_id`, `product_quantity_sold`, `unit_price`, `total_sale_price`, `total_buy_price`) VALUES
(1252, 'INV26208500BD', 573, 1, 1.20, 1.20, 1.00),
(1253, 'INV26208500BD', 574, 1, 40.00, 40.00, 33.00),
(1254, 'INV26208500BD', 575, 1, 45.00, 45.00, 34.00),
(1255, 'INV26208500BD', 576, 1, 25.00, 25.00, 20.00),
(1256, 'INV26208B8A92', 573, 1, 1.20, 1.20, 1.00),
(1257, 'INV26208B8A92', 574, 1, 40.00, 40.00, 33.00);

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustment`
--

CREATE TABLE `stock_adjustment` (
  `adjustment_id` bigint NOT NULL,
  `adjustment_no` varchar(30) NOT NULL,
  `adjustment_date` date NOT NULL,
  `adjustment_type` enum('stock_in','stock_out') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `remarks` text,
  `adjusted_by` int NOT NULL,
  `total_items` int NOT NULL DEFAULT '0',
  `total_qty` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('Draft','Approved','Cancelled') NOT NULL DEFAULT 'Approved',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stock_adjustment`
--

INSERT INTO `stock_adjustment` (`adjustment_id`, `adjustment_no`, `adjustment_date`, `adjustment_type`, `reason`, `reference_no`, `remarks`, `adjusted_by`, `total_items`, `total_qty`, `status`, `created_at`, `updated_at`) VALUES
(6, 'SA-000001', '2026-07-16', 'stock_in', 'Physical Count', '123', 'tet', 18, 0, 0.00, 'Approved', '2026-07-16 05:05:45', '2026-07-16 05:14:08'),
(7, 'SA-000002', '2026-07-16', 'stock_out', '', '', '', 18, 0, 0.00, 'Approved', '2026-07-16 05:05:58', '2026-07-16 05:14:08');

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustment_details`
--

CREATE TABLE `stock_adjustment_details` (
  `id` bigint NOT NULL,
  `adjustment_id` bigint NOT NULL,
  `product_id` bigint NOT NULL,
  `current_stock` decimal(12,2) NOT NULL,
  `adjustment_qty` decimal(12,2) NOT NULL,
  `new_stock` decimal(12,2) NOT NULL,
  `unit_cost` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stock_adjustment_details`
--

INSERT INTO `stock_adjustment_details` (`id`, `adjustment_id`, `product_id`, `current_stock`, `adjustment_qty`, `new_stock`, `unit_cost`, `created_at`, `remarks`) VALUES
(6, 6, 573, 5224.00, 4.00, 5228.00, 0.00, '2026-07-16 05:05:45', NULL),
(7, 7, 574, 480.00, 10.00, 470.00, 0.00, '2026-07-16 05:05:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` bigint NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `business_name` varchar(100) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `supplier_email` varchar(100) NOT NULL,
  `supplier_address` varchar(150) NOT NULL,
  `supplier_entry_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `business_name`, `contact_number`, `supplier_email`, `supplier_address`, `supplier_entry_date`) VALUES
(106, 'Sumonor Rahman', 'Cloths Business', '01952368875', 'sumon@gmail.com', 'Aftabnagar', '12/01/2022'),
(124, 'Sakifur Rahman', 'Safif&Tailers', '01913691187', 'sakif@gmail.com', 'Bashabo, Dhaka', '17/02/2026');

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `tax_id` int NOT NULL,
  `tax_name` varchar(80) NOT NULL,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`tax_id`, `tax_name`, `tax_percentage`) VALUES
(8, 'Tax', 5.00),
(9, 'VAT', 10.00),
(11, 'None', 0.00),
(13, 'test tax', 20.00),
(14, 'vat', 0.00),
(15, 'tst', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `login_id` varchar(80) NOT NULL,
  `login_password` varchar(255) NOT NULL,
  `user_role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `login_id`, `login_password`, `user_role_id`) VALUES
(18, 'Md. Kabir Hossain', 'kabir@gmail.com', 'kabir', '$2y$10$DwWwcEb41BOiHKwPit4C2.hY4ym8Bkab7g.KLn/25sAOihc7PCCCe', 46),
(19, 'Nafisa Tabassom123', 'nafisa@gmail.com', 'nafisa1', '$2y$10$DwWwcEb41BOiHKwPit4C2.hY4ym8Bkab7g.KLn/25sAOihc7PCCCe', 46),
(26, 'ayan', 'ayan@gmail.com', 'ayan', '$2y$10$DwWwcEb41BOiHKwPit4C2.hY4ym8Bkab7g.KLn/25sAOihc7PCCCe', 49);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `user_role_id` int NOT NULL,
  `role_holder` varchar(100) NOT NULL,
  `user_previlege` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_role_id`, `role_holder`, `user_previlege`) VALUES
(46, 'Administrator', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32'),
(47, 'Sales Man', '1,2,0,4,5,0,7,8,0,10,11,0,13,14,0,16,17,0,19,20,0,22,23,0,25,26,0,28,29,0,31,32'),
(48, 'user', '1,2,0,4,5,0,7,8,9,0,11,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'),
(49, 'test', '1,0,0,0,0,0,7,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `idx_phone` (`phone`),
  ADD KEY `idx_customer_name` (`customer_name`),
  ADD KEY `fk_customer_group` (`customer_group_id`);

--
-- Indexes for table `customer_due`
--
ALTER TABLE `customer_due`
  ADD PRIMARY KEY (`due_id`),
  ADD KEY `idx_customer` (`customer_id`),
  ADD KEY `idx_invoice` (`sales_id`);

--
-- Indexes for table `customer_due_payment`
--
ALTER TABLE `customer_due_payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `idx_due` (`due_id`),
  ADD KEY `idx_sales` (`sales_id`),
  ADD KEY `idx_customer` (`customer_id`);

--
-- Indexes for table `customer_group`
--
ALTER TABLE `customer_group`
  ADD PRIMARY KEY (`customer_group_id`),
  ADD UNIQUE KEY `uk_group_name` (`group_name`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `expense_date` (`expense_date`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`expense_category_id`);

--
-- Indexes for table `expense_sub_category`
--
ALTER TABLE `expense_sub_category`
  ADD PRIMARY KEY (`expense_sub_category_id`),
  ADD KEY `idx_expense_category_id` (`expense_category_id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `held_sales`
--
ALTER TABLE `held_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_id`
--
ALTER TABLE `menu_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_receive`
--
ALTER TABLE `payment_receive`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `product_brand`
--
ALTER TABLE `product_brand`
  ADD PRIMARY KEY (`brand_id`),
  ADD UNIQUE KEY `unique_brand_category` (`product_brand_name`,`product_category_id`),
  ADD KEY `idx_product_category_id` (`product_category_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_category_id`);

--
-- Indexes for table `product_group`
--
ALTER TABLE `product_group`
  ADD PRIMARY KEY (`product_group_id`);

--
-- Indexes for table `product_inital_stock`
--
ALTER TABLE `product_inital_stock`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_purchase`
--
ALTER TABLE `product_purchase`
  ADD PRIMARY KEY (`product_purchase_id`);

--
-- Indexes for table `product_purchase_details`
--
ALTER TABLE `product_purchase_details`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `purchase_invoice_id` (`purchase_invoice_id`);

--
-- Indexes for table `product_stock`
--
ALTER TABLE `product_stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `product_strength`
--
ALTER TABLE `product_strength`
  ADD PRIMARY KEY (`strength_id`);

--
-- Indexes for table `product_unit`
--
ALTER TABLE `product_unit`
  ADD PRIMARY KEY (`product_unit_id`);

--
-- Indexes for table `return_customer_due`
--
ALTER TABLE `return_customer_due`
  ADD PRIMARY KEY (`due_id`);

--
-- Indexes for table `return_sales`
--
ALTER TABLE `return_sales`
  ADD PRIMARY KEY (`return_id`),
  ADD UNIQUE KEY `uniq_return_invoice` (`sales_invoice`);

--
-- Indexes for table `return_sales_details`
--
ALTER TABLE `return_sales_details`
  ADD PRIMARY KEY (`return_detail_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`),
  ADD UNIQUE KEY `sales_invoice` (`sales_invoice`);

--
-- Indexes for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD PRIMARY KEY (`sales_details_id`);

--
-- Indexes for table `stock_adjustment`
--
ALTER TABLE `stock_adjustment`
  ADD PRIMARY KEY (`adjustment_id`),
  ADD UNIQUE KEY `adjustment_no` (`adjustment_no`);

--
-- Indexes for table `stock_adjustment_details`
--
ALTER TABLE `stock_adjustment_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_adjustment_product` (`adjustment_id`,`product_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `idx_adjustment_id` (`adjustment_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `uk_login_id` (`login_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `customer_due`
--
ALTER TABLE `customer_due`
  MODIFY `due_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `customer_due_payment`
--
ALTER TABLE `customer_due_payment`
  MODIFY `payment_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customer_group`
--
ALTER TABLE `customer_group`
  MODIFY `customer_group_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expense_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `expense_category_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `expense_sub_category`
--
ALTER TABLE `expense_sub_category`
  MODIFY `expense_sub_category_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `held_sales`
--
ALTER TABLE `held_sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `menu_id`
--
ALTER TABLE `menu_id`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `payment_receive`
--
ALTER TABLE `payment_receive`
  MODIFY `payment_id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_brand`
--
ALTER TABLE `product_brand`
  MODIFY `brand_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `product_group`
--
ALTER TABLE `product_group`
  MODIFY `product_group_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `product_inital_stock`
--
ALTER TABLE `product_inital_stock`
  MODIFY `product_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=577;

--
-- AUTO_INCREMENT for table `product_purchase`
--
ALTER TABLE `product_purchase`
  MODIFY `product_purchase_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `product_purchase_details`
--
ALTER TABLE `product_purchase_details`
  MODIFY `purchase_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `product_stock`
--
ALTER TABLE `product_stock`
  MODIFY `stock_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_strength`
--
ALTER TABLE `product_strength`
  MODIFY `strength_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_unit`
--
ALTER TABLE `product_unit`
  MODIFY `product_unit_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `return_customer_due`
--
ALTER TABLE `return_customer_due`
  MODIFY `due_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `return_sales`
--
ALTER TABLE `return_sales`
  MODIFY `return_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `return_sales_details`
--
ALTER TABLE `return_sales_details`
  MODIFY `return_detail_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=823;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `sales_details_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1258;

--
-- AUTO_INCREMENT for table `stock_adjustment`
--
ALTER TABLE `stock_adjustment`
  MODIFY `adjustment_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stock_adjustment_details`
--
ALTER TABLE `stock_adjustment_details`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `tax_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `user_role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_customer_group` FOREIGN KEY (`customer_group_id`) REFERENCES `customer_group` (`customer_group_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `customer_due`
--
ALTER TABLE `customer_due`
  ADD CONSTRAINT `fk_customer_due_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_due_payment`
--
ALTER TABLE `customer_due_payment`
  ADD CONSTRAINT `fk_due_payment_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_due_payment_due` FOREIGN KEY (`due_id`) REFERENCES `customer_due` (`due_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_due_payment_sales` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`sales_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expense_sub_category`
--
ALTER TABLE `expense_sub_category`
  ADD CONSTRAINT `fk_expense_category` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_category` (`expense_category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_adjustment_details`
--
ALTER TABLE `stock_adjustment_details`
  ADD CONSTRAINT `fk_adjustment_master` FOREIGN KEY (`adjustment_id`) REFERENCES `stock_adjustment` (`adjustment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_adjustment_product` FOREIGN KEY (`product_id`) REFERENCES `product_inital_stock` (`product_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
