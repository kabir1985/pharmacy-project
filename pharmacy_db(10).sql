-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 02, 2026 at 10:54 AM
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
(36, 13, 831, 0.19, 0.00),
(37, 15, 832, 0.48, 0.00),
(38, 13, 833, 33.61, 0.00),
(39, 15, 834, 364.12, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `customer_due_payment`
--

CREATE TABLE `customer_due_payment` (
  `payment_id` bigint UNSIGNED NOT NULL,
  `due_id` bigint UNSIGNED NOT NULL,
  `sales_id` bigint UNSIGNED NOT NULL,
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
(32, 'vat_tax_report', 32),
(33, 'product_entry', 33);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_category` bigint UNSIGNED NOT NULL,
  `product_brand` bigint UNSIGNED NOT NULL,
  `product_group` bigint UNSIGNED NOT NULL,
  `product_strength` bigint UNSIGNED DEFAULT NULL,
  `product_unit` bigint UNSIGNED NOT NULL,
  `sku` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alert_quantity` decimal(12,2) NOT NULL DEFAULT '0.00',
  `product_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default-medicine.png',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_category`, `product_brand`, `product_group`, `product_strength`, `product_unit`, `sku`, `barcode`, `alert_quantity`, `product_image`, `status`, `created_at`, `updated_at`) VALUES
(7, 'Napa', 161, 60, 46, 1, 22, 'sku-napa', 'barcode-napa', 5.00, 'default-medicine.png', 'active', '2026-08-01 02:30:55', '2026-08-01 02:30:55');

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
(57, 'testbrand', 158, '2026-07-23 06:39:43', '2026-07-23 06:39:43'),
(58, 'Bari-4', 159, '2026-07-31 05:43:07', '2026-07-31 05:43:07'),
(59, 'Nokia', 160, '2026-07-31 10:03:24', '2026-07-31 10:03:24'),
(60, 'Reneta', 161, '2026-08-01 02:30:23', '2026-08-01 02:30:23');

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
(158, 'testcategory'),
(159, 'Fruits'),
(160, 'Electric Item'),
(161, 'Tablet');

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
(51, 'tstgroup'),
(52, 'Chapai'),
(53, 'Hangeri');

-- --------------------------------------------------------

--
-- Table structure for table `product_opening_stock`
--

CREATE TABLE `product_opening_stock` (
  `opening_stock_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `supplier_id` bigint UNSIGNED DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `quantity` decimal(12,2) NOT NULL DEFAULT '0.00',
  `bonus_quantity` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax_type` enum('without_tax','with_tax') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'without_tax',
  `tax_id` bigint UNSIGNED DEFAULT NULL,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `purchase_price_without_vat` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `purchase_price_with_vat` decimal(12,2) NOT NULL DEFAULT '0.00',
  `profit_margin_percent` decimal(8,2) NOT NULL DEFAULT '0.00',
  `selling_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock_date` date NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_opening_stock`
--

INSERT INTO `product_opening_stock` (`opening_stock_id`, `product_id`, `supplier_id`, `expiry_date`, `quantity`, `bonus_quantity`, `tax_type`, `tax_id`, `tax_percentage`, `purchase_price_without_vat`, `tax_amount`, `purchase_price_with_vat`, `profit_margin_percent`, `selling_price`, `stock_date`, `remarks`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(12, 7, 124, '2026-08-28', 100.00, 0.00, 'without_tax', 8, 15.00, 2.00, 0.10, 2.10, 19.05, 2.50, '2026-08-02', 'dffdgdg', 18, 'active', '2026-08-02 04:11:04', '2026-08-02 06:36:58');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase`
--

CREATE TABLE `product_purchase` (
  `purchase_id` int NOT NULL,
  `purchase_invoice` varchar(100) NOT NULL,
  `payment_type` varchar(80) NOT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `invoice_total` decimal(12,2) DEFAULT NULL,
  `discount_amount_on_invoice_total` decimal(10,2) DEFAULT NULL,
  `vat_amount_on_invoice_total` decimal(10,2) DEFAULT NULL,
  `invoice_net_total` decimal(12,2) DEFAULT NULL,
  `paid_amount` decimal(14,2) NOT NULL DEFAULT '0.00',
  `due_amount` decimal(14,2) NOT NULL DEFAULT '0.00',
  `purchase_date` datetime DEFAULT NULL,
  `purchase_by` bigint UNSIGNED NOT NULL,
  `status` enum('active','cancelled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase_details`
--

CREATE TABLE `product_purchase_details` (
  `purchase_details_id` bigint UNSIGNED NOT NULL,
  `purchase_id` bigint UNSIGNED DEFAULT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `quantity_per_pack` decimal(12,2) NOT NULL DEFAULT '0.00',
  `box_quantity` decimal(12,2) NOT NULL DEFAULT '1.00',
  `free_qty` decimal(12,2) NOT NULL DEFAULT '0.00',
  `base_price_per_unit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax_id` bigint UNSIGNED DEFAULT NULL,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `product_wise_vat_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `product_wise_discount_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `selling_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `purchase_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `line_total` decimal(14,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
(17, 'teststrength'),
(18, '500mg'),
(19, '200gm');

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
(49, 'tstunit'),
(50, 'piece');

-- --------------------------------------------------------

--
-- Table structure for table `return_payment`
--

CREATE TABLE `return_payment` (
  `id` bigint UNSIGNED NOT NULL,
  `return_id` bigint UNSIGNED NOT NULL,
  `payment_type` varchar(30) NOT NULL COMMENT 'Cash, Bank, Mobile Banking, Adjust Due',
  `amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `payment_date` date NOT NULL,
  `remarks` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_sales`
--

CREATE TABLE `return_sales` (
  `return_id` bigint UNSIGNED NOT NULL,
  `return_invoice` varchar(50) NOT NULL,
  `sales_id` bigint UNSIGNED NOT NULL,
  `return_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `return_type` enum('FULL','PARTIAL') NOT NULL,
  `total_return_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `remarks` varchar(255) DEFAULT NULL,
  `return_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_sales_details`
--

CREATE TABLE `return_sales_details` (
  `return_details_id` bigint UNSIGNED NOT NULL,
  `return_id` bigint UNSIGNED NOT NULL,
  `sales_details_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `sold_qty` decimal(18,2) NOT NULL DEFAULT '0.00',
  `return_qty` decimal(18,2) NOT NULL DEFAULT '0.00',
  `remaining_qty` decimal(18,2) NOT NULL DEFAULT '0.00',
  `unit_price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total_return_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `return_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` bigint UNSIGNED NOT NULL,
  `sales_invoice` varchar(50) NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `sales_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_type` varchar(11) NOT NULL,
  `product_discount` decimal(11,2) NOT NULL,
  `product_vat` decimal(11,2) NOT NULL,
  `other_charge_on_all` decimal(11,2) NOT NULL,
  `grand_total` decimal(11,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(11,2) DEFAULT NULL,
  `payment_status` enum('Paid','Partial','Due') DEFAULT 'Paid',
  `seller_id` int DEFAULT NULL,
  `return_status` enum('NO_RETURN','PARTIAL','FULL') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'NO_RETURN',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `sales_invoice`, `customer_id`, `sales_date`, `payment_type`, `product_discount`, `product_vat`, `other_charge_on_all`, `grand_total`, `paid_amount`, `payment_status`, `seller_id`, `return_status`, `created_at`, `updated_at`) VALUES
(829, 'INV26211CE318', NULL, '2026-07-30 02:14:21', 'Cash', 2.00, 0.00, 0.00, 39.20, 39.00, 'Partial', 18, 'NO_RETURN', '2026-07-30 08:14:21', '2026-07-30 08:14:21'),
(830, 'INV26211C1FFD', NULL, '2026-07-30 02:16:33', 'Cash', 0.00, 0.00, 0.00, 40.00, 40.00, 'Paid', 18, 'NO_RETURN', '2026-07-30 08:16:33', '2026-07-30 08:16:33'),
(831, 'INV262118F292', 13, '2026-07-30 02:17:25', 'Cash', 2.01, 0.00, 0.00, 84.19, 84.00, 'Partial', 18, 'NO_RETURN', '2026-07-30 08:17:25', '2026-07-30 08:17:25'),
(832, 'INV2621149E61', 15, '2026-07-30 02:24:04', 'Cash', 1.72, 0.00, 0.00, 84.48, 84.00, 'Partial', 18, 'NO_RETURN', '2026-07-30 08:24:04', '2026-07-30 08:24:04'),
(833, 'INV2621132AF5', 13, '2026-07-30 02:28:45', 'Cash', 2.59, 0.00, 0.00, 83.61, 50.00, 'Partial', 18, 'NO_RETURN', '2026-07-30 08:28:45', '2026-07-30 08:28:45'),
(834, 'INV26211910CF', 15, '2026-07-30 02:34:46', 'Cash', 7.08, 0.00, 0.00, 464.12, 100.00, 'Partial', 18, 'NO_RETURN', '2026-07-30 08:34:46', '2026-07-30 08:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `sales_details`
--

CREATE TABLE `sales_details` (
  `sales_details_id` bigint UNSIGNED NOT NULL,
  `sales_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_quantity_sold` decimal(18,2) NOT NULL DEFAULT '0.00',
  `returned_qty` decimal(18,2) NOT NULL DEFAULT '0.00',
  `unit_price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total_sale_price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total_buy_price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales_details`
--

INSERT INTO `sales_details` (`sales_details_id`, `sales_id`, `product_id`, `product_quantity_sold`, `returned_qty`, `unit_price`, `total_sale_price`, `total_buy_price`, `created_at`, `updated_at`) VALUES
(1265, 827, 573, 1.00, 0.00, 1.20, 1.20, 1.00, '2026-07-30 08:01:07', '2026-07-30 08:01:07'),
(1266, 827, 575, 1.00, 0.00, 45.00, 45.00, 34.00, '2026-07-30 08:01:07', '2026-07-30 08:01:07'),
(1267, 828, 574, 1.00, 0.00, 40.00, 40.00, 33.00, '2026-07-30 08:06:32', '2026-07-30 08:06:32'),
(1268, 829, 573, 1.00, 0.00, 1.20, 1.20, 1.00, '2026-07-30 08:14:21', '2026-07-30 08:14:21'),
(1269, 829, 574, 1.00, 0.00, 40.00, 40.00, 33.00, '2026-07-30 08:14:21', '2026-07-30 08:14:21'),
(1270, 830, 574, 1.00, 0.00, 40.00, 40.00, 33.00, '2026-07-30 08:16:33', '2026-07-30 08:16:33'),
(1271, 831, 573, 1.00, 0.00, 1.20, 1.20, 1.00, '2026-07-30 08:17:25', '2026-07-30 08:17:25'),
(1272, 831, 574, 1.00, 0.00, 40.00, 40.00, 33.00, '2026-07-30 08:17:25', '2026-07-30 08:17:25'),
(1273, 831, 575, 1.00, 0.00, 45.00, 45.00, 34.00, '2026-07-30 08:17:25', '2026-07-30 08:17:25'),
(1274, 832, 574, 1.00, 0.00, 40.00, 40.00, 33.00, '2026-07-30 08:24:04', '2026-07-30 08:24:04'),
(1275, 832, 573, 1.00, 0.00, 1.20, 1.20, 1.00, '2026-07-30 08:24:04', '2026-07-30 08:24:04'),
(1276, 832, 575, 1.00, 0.00, 45.00, 45.00, 34.00, '2026-07-30 08:24:04', '2026-07-30 08:24:04'),
(1277, 833, 574, 1.00, 0.00, 40.00, 40.00, 33.00, '2026-07-30 08:28:45', '2026-07-30 08:28:45'),
(1278, 833, 573, 1.00, 0.00, 1.20, 1.20, 1.00, '2026-07-30 08:28:45', '2026-07-30 08:28:45'),
(1279, 833, 575, 1.00, 0.00, 45.00, 45.00, 34.00, '2026-07-30 08:28:45', '2026-07-30 08:28:45'),
(1280, 834, 574, 10.00, 0.00, 40.00, 400.00, 330.00, '2026-07-30 08:34:46', '2026-07-30 08:34:46'),
(1281, 834, 575, 1.00, 0.00, 45.00, 45.00, 34.00, '2026-07-30 08:34:46', '2026-07-30 08:34:46'),
(1282, 834, 576, 1.00, 0.00, 25.00, 25.00, 20.00, '2026-07-30 08:34:46', '2026-07-30 08:34:46'),
(1283, 834, 573, 1.00, 0.00, 1.20, 1.20, 1.00, '2026-07-30 08:34:46', '2026-07-30 08:34:46');

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

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustment_details`
--

CREATE TABLE `stock_adjustment_details` (
  `id` bigint NOT NULL,
  `adjustment_id` bigint NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `current_stock` decimal(12,2) NOT NULL,
  `adjustment_qty` decimal(12,2) NOT NULL,
  `new_stock` decimal(12,2) NOT NULL,
  `unit_cost` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_ledger`
--

CREATE TABLE `stock_ledger` (
  `stock_ledger_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `transaction_type` enum('OPENING','PURCHASE','SALE','SALE_RETURN','PURCHASE_RETURN','ADJUSTMENT') DEFAULT NULL,
  `reference_id` bigint UNSIGNED DEFAULT NULL,
  `qty_in` decimal(18,2) DEFAULT '0.00',
  `qty_out` decimal(18,2) DEFAULT '0.00',
  `balance_qty` decimal(18,2) DEFAULT '0.00',
  `unit_cost` decimal(15,2) DEFAULT '0.00',
  `transaction_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(100) NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stock_ledger`
--

INSERT INTO `stock_ledger` (`stock_ledger_id`, `product_id`, `transaction_type`, `reference_id`, `qty_in`, `qty_out`, `balance_qty`, `unit_cost`, `transaction_date`, `remarks`, `created_by`) VALUES
(20, 7, 'OPENING', 12, 100.00, 0.00, 100.00, 2.10, '2026-08-02 00:00:00', 'Opening Stock', 18);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` bigint UNSIGNED NOT NULL,
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
  `tax_id` bigint UNSIGNED NOT NULL,
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
(46, 'Administrator', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33'),
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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `idx_category` (`product_category`),
  ADD KEY `idx_brand` (`product_brand`),
  ADD KEY `idx_group` (`product_group`),
  ADD KEY `idx_strength` (`product_strength`),
  ADD KEY `idx_unit` (`product_unit`),
  ADD KEY `idx_barcode` (`barcode`),
  ADD KEY `idx_sku` (`sku`);

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
-- Indexes for table `product_opening_stock`
--
ALTER TABLE `product_opening_stock`
  ADD PRIMARY KEY (`opening_stock_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_supplier` (`supplier_id`),
  ADD KEY `idx_expiry` (`expiry_date`),
  ADD KEY `idx_stock_date` (`stock_date`),
  ADD KEY `idx_tax` (`tax_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `product_purchase`
--
ALTER TABLE `product_purchase`
  ADD PRIMARY KEY (`purchase_id`),
  ADD UNIQUE KEY `uk_purchase_invoice` (`purchase_invoice`);

--
-- Indexes for table `product_purchase_details`
--
ALTER TABLE `product_purchase_details`
  ADD PRIMARY KEY (`purchase_details_id`),
  ADD KEY `idx_purchase_invoice` (`purchase_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_expiry` (`expiry_date`),
  ADD KEY `idx_tax` (`tax_id`);

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
-- Indexes for table `return_payment`
--
ALTER TABLE `return_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_return_payment_return_id` (`return_id`);

--
-- Indexes for table `return_sales`
--
ALTER TABLE `return_sales`
  ADD PRIMARY KEY (`return_id`),
  ADD UNIQUE KEY `uk_return_invoice` (`return_invoice`),
  ADD KEY `idx_sales_id` (`sales_id`),
  ADD KEY `idx_return_date` (`return_date`),
  ADD KEY `idx_return_by` (`return_by`);

--
-- Indexes for table `return_sales_details`
--
ALTER TABLE `return_sales_details`
  ADD PRIMARY KEY (`return_details_id`),
  ADD KEY `idx_return_id` (`return_id`),
  ADD KEY `idx_sales_details_id` (`sales_details_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`),
  ADD UNIQUE KEY `sales_invoice` (`sales_invoice`),
  ADD KEY `fk_sales_seller` (`seller_id`),
  ADD KEY `fk_sales_customer` (`customer_id`);

--
-- Indexes for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD PRIMARY KEY (`sales_details_id`),
  ADD KEY `idx_sales_id` (`sales_id`),
  ADD KEY `idx_product_id` (`product_id`);

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
-- Indexes for table `stock_ledger`
--
ALTER TABLE `stock_ledger`
  ADD PRIMARY KEY (`stock_ledger_id`),
  ADD KEY `idx_product_batch` (`product_id`);

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
  MODIFY `due_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `menu_id`
--
ALTER TABLE `menu_id`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_brand`
--
ALTER TABLE `product_brand`
  MODIFY `brand_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `product_group`
--
ALTER TABLE `product_group`
  MODIFY `product_group_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `product_opening_stock`
--
ALTER TABLE `product_opening_stock`
  MODIFY `opening_stock_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_purchase`
--
ALTER TABLE `product_purchase`
  MODIFY `purchase_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `product_strength`
--
ALTER TABLE `product_strength`
  MODIFY `strength_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_unit`
--
ALTER TABLE `product_unit`
  MODIFY `product_unit_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `return_payment`
--
ALTER TABLE `return_payment`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_sales`
--
ALTER TABLE `return_sales`
  MODIFY `return_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_sales_details`
--
ALTER TABLE `return_sales_details`
  MODIFY `return_details_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=835;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `sales_details_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1284;

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
-- AUTO_INCREMENT for table `stock_ledger`
--
ALTER TABLE `stock_ledger`
  MODIFY `stock_ledger_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `tax_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  ADD CONSTRAINT `fk_customer_due_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customer_due_sales` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`sales_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `product_opening_stock`
--
ALTER TABLE `product_opening_stock`
  ADD CONSTRAINT `fk_opening_stock_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_opening_stock_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_opening_stock_tax` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`tax_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product_purchase_details`
--
ALTER TABLE `product_purchase_details`
  ADD CONSTRAINT `fk_purchase_details_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_purchase_details_tax` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`tax_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `return_payment`
--
ALTER TABLE `return_payment`
  ADD CONSTRAINT `fk_return_payment_return` FOREIGN KEY (`return_id`) REFERENCES `return_sales` (`return_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `return_sales`
--
ALTER TABLE `return_sales`
  ADD CONSTRAINT `fk_return_sales_sales` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`sales_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_return_sales_user` FOREIGN KEY (`return_by`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `return_sales_details`
--
ALTER TABLE `return_sales_details`
  ADD CONSTRAINT `fk_return_details_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_return_details_return` FOREIGN KEY (`return_id`) REFERENCES `return_sales` (`return_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_return_details_sales_details` FOREIGN KEY (`sales_details_id`) REFERENCES `sales_details` (`sales_details_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_sales_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sales_seller` FOREIGN KEY (`seller_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `stock_adjustment_details`
--
ALTER TABLE `stock_adjustment_details`
  ADD CONSTRAINT `fk_adjustment_master` FOREIGN KEY (`adjustment_id`) REFERENCES `stock_adjustment` (`adjustment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_adjustment_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON UPDATE CASCADE;

--
-- Constraints for table `stock_ledger`
--
ALTER TABLE `stock_ledger`
  ADD CONSTRAINT `stock_ledger_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
