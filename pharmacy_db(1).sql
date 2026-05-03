-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 03, 2026 at 10:10 AM
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
(3, 'EUR', 'EURO', '€'),
(4, 'USD', 'US Dollar', '$'),
(7, 'BDT', 'Taka', 'TK.');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` bigint NOT NULL,
  `cus_first_name` varchar(50) NOT NULL,
  `cus_last_name` varchar(50) NOT NULL,
  `cus_email` varchar(80) NOT NULL,
  `cus_phone` varchar(50) NOT NULL,
  `cus_address` varchar(200) NOT NULL,
  `cus_tin` varchar(50) NOT NULL,
  `cus_company` varchar(100) NOT NULL,
  `cus_type` varchar(50) NOT NULL,
  `cus_creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `cus_first_name`, `cus_last_name`, `cus_email`, `cus_phone`, `cus_address`, `cus_tin`, `cus_company`, `cus_type`, `cus_creation_date`) VALUES
(15, 'Hossain ', 'Mahmood', 'hossain@gmail.com', '0155869547', 'Aftabnaga', '02213645478', 'bdposhak.com', 'general', '0000-00-00 00:00:00'),
(18, 'Fouzia', 'Kona', 'kona@gmail.com', '011345567', 'dhaka', '9923445566', 'kona and company', 'special', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer_due`
--

CREATE TABLE `customer_due` (
  `due_id` int NOT NULL,
  `due_date` date NOT NULL,
  `customer_id` varchar(50) NOT NULL,
  `due_invoice_no` varchar(100) NOT NULL,
  `due_amount` bigint NOT NULL,
  `due_paid_amount` bigint NOT NULL,
  `current_balance` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_due`
--

INSERT INTO `customer_due` (`due_id`, `due_date`, `customer_id`, `due_invoice_no`, `due_amount`, `due_paid_amount`, `current_balance`) VALUES
(442, '2026-04-28', '15', 'INV261181911E', 12, 0, 0),
(443, '2026-04-28', '18', 'INV261180B975', 24, 0, 0),
(444, '2026-04-29', '18', 'INV26119F696A', 24, 0, 0),
(445, '2026-04-29', '15', 'INV26119B0AB3', 41, 0, 0),
(446, '2026-04-29', '15', 'INV261193ABF1', 2, 0, 0),
(447, '2026-04-30', '15', 'INV261202823F', 1, 0, 0),
(448, '2026-05-03', '15', 'INV26123C15E9', 50, 0, 0),
(449, '2026-05-03', '15', 'INV26123B7B8F', 6, 0, 0),
(450, '2026-05-03', '15', 'INV261230CD76', 29, 0, 0),
(451, '2026-05-03', '15', 'INV2612390290', 153, 0, 0),
(452, '2026-05-03', '15', 'INV2612320544', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_group`
--

CREATE TABLE `customer_group` (
  `customer_group_id` bigint NOT NULL,
  `cus_group_name` varchar(80) NOT NULL,
  `cus_due_limit` bigint NOT NULL,
  `discount_percent` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_group`
--

INSERT INTO `customer_group` (`customer_group_id`, `cus_group_name`, `cus_due_limit`, `discount_percent`) VALUES
(1, 'Special Customer', 5000, '5'),
(2, 'General', 2000, '2'),
(3, 'Female', 20001, '3'),
(4, 'test group', 1000, '33');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expense_id` bigint NOT NULL,
  `expense_ref_no` varchar(150) NOT NULL,
  `expense_category` varchar(100) NOT NULL,
  `expense_sub_category` varchar(100) NOT NULL,
  `expense_what_for` varchar(200) NOT NULL,
  `expense_amount` decimal(12,2) NOT NULL,
  `expense_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `expense_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(4, 'Office Purpose'),
(7, 'Family Purpos'),
(11, 'Snacks123'),
(12, 'Electricity Bill123');

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
(1, 4, 'Bangla Khata'),
(3, 7, 'Cloths Purchase'),
(4, 4, 'Pen Purchase'),
(5, 4, 'car'),
(7, 11, 'Morning Ruti'),
(8, 11, 'Dall Puri'),
(9, 12, 'Electricity Bill-May,2025'),
(10, 7, 'Dress purchase11');

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
  `customer_type` varchar(50) NOT NULL,
  `cart_data` longtext NOT NULL,
  `discountOnTotalPrice` int NOT NULL,
  `vatOnTotalPrice` int NOT NULL,
  `created_at` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `held_sales`
--

INSERT INTO `held_sales` (`id`, `hold_id`, `seller_id`, `customer_type`, `cart_data`, `discountOnTotalPrice`, `vatOnTotalPrice`, `created_at`) VALUES
(82, 'HLD260503073758234', 18, 'Walk-In-Customer', '[{\"product_id\":\"563\",\"product_name\":\"Napa Syrup\",\"product_image\":\"napa-syrup-100ml.jpg\",\"sales_price_for_customer\":\"24.00\",\"purchase_price\":\"20.00\",\"total_stock\":\"8\",\"total_purchase_cost\":\"20.00\",\"unit_purchase_price\":\"20.000000\",\"stock_value\":\"160.000000\",\"quantity\":\"1\"}]', 0, 0, '2026-05-03 07:37:58');

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
(21, 'receive_customer', 21),
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
  `brand_id` bigint NOT NULL,
  `product_brand_name` varchar(50) NOT NULL,
  `product_category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_brand`
--

INSERT INTO `product_brand` (`brand_id`, `product_brand_name`, `product_category_id`) VALUES
(37, 'Square', 132),
(38, 'Renata', 132),
(39, 'Incepta', 133),
(40, 'Square Pharma', 138);

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
(132, 'Tablets'),
(133, 'Syrups'),
(134, 'Injections'),
(135, 'Gels & Lotions'),
(136, 'Suppositories'),
(137, 'Drops'),
(138, 'Capsule');

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
(32, 'Herbal & Ayurvedic'),
(37, 'Over-The-Counter'),
(38, 'Doctor-prescribed drugs'),
(42, 'Personal Care'),
(43, 'Medical Devices'),
(44, 'Surgical Items'),
(45, 'Nutritional Products'),
(46, 'Baby Care'),
(47, 'Omeprazole');

-- --------------------------------------------------------

--
-- Table structure for table `product_inital_stock`
--

CREATE TABLE `product_inital_stock` (
  `product_id` bigint NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `product_category` int DEFAULT NULL,
  `product_brand` int DEFAULT NULL,
  `product_group` int DEFAULT NULL,
  `product_unit` int DEFAULT NULL,
  `codefor_barcode` varchar(50) DEFAULT NULL,
  `productinitial_quantity` int DEFAULT NULL,
  `base_price` decimal(10,2) DEFAULT NULL,
  `tax_type` varchar(50) NOT NULL,
  `tax_id` int NOT NULL,
  `tax_amount` decimal(10,2) DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `profit_margin_%` decimal(5,2) DEFAULT NULL,
  `cost_without_vat` int NOT NULL,
  `sales_price_before_vat` decimal(10,2) DEFAULT NULL,
  `vat_on_sales` decimal(10,2) DEFAULT NULL,
  `sales_price_for_customer` decimal(12,2) DEFAULT NULL,
  `alert_quantity` int DEFAULT NULL,
  `product_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_inital_stock`
--

INSERT INTO `product_inital_stock` (`product_id`, `product_name`, `product_category`, `product_brand`, `product_group`, `product_unit`, `codefor_barcode`, `productinitial_quantity`, `base_price`, `tax_type`, `tax_id`, `tax_amount`, `purchase_price`, `profit_margin_%`, `cost_without_vat`, `sales_price_before_vat`, `vat_on_sales`, `sales_price_for_customer`, `alert_quantity`, `product_image`) VALUES
(562, 'Napa Tablet', 132, 37, 37, 20, 'barcode', 112, 1.00, 'without_tax', 11, 0.00, 1.00, 20.00, 1, 1.20, 0.00, 1.20, 5, 'napa.jpeg'),
(563, 'Napa Syrup', 133, 39, 46, 22, 'barcode-syrup', 10, 20.00, 'without_tax', 11, 0.00, 20.00, 20.00, 20, 24.00, 0.00, 24.00, 2, 'napa-syrup-100ml.jpg'),
(564, 'Seclo 20 mg', 138, 40, 47, 22, 'barcode', 100, 3.50, 'without_tax', 11, 0.00, 3.50, 43.00, 4, 5.01, 0.00, 5.01, 5, 'seclo.jpeg');

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
(96, 'PUR2610976064', '18', 'Cash', '124', 200.00, 0.00, 0.00, 200.00, '2026-04-19 05:56:55'),
(97, 'PUR261199A4DD', '18', 'Cash', '106', 20.00, 0.00, 0.00, 20.00, '2026-04-29 07:30:34'),
(98, 'PUR2612001248', '18', 'Cash', '106', 1.00, 0.00, 0.00, 1.00, '2026-04-30 08:08:40'),
(99, 'PUR2612341EE4', '18', 'Cash', '124', 700.00, 0.00, 0.00, 700.00, '2026-05-03 05:57:40');

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
  `product_wise_vat_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `product_wise_discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchase_price` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_purchase_details`
--

INSERT INTO `product_purchase_details` (`purchase_id`, `purchase_invoice_id`, `product_id`, `quantity_per_pack`, `box_quantity`, `base_price_per_unit`, `product_wise_vat_amount`, `product_wise_discount_amount`, `purchase_price`) VALUES
(162, 'PUR261199A4DD', 563, 1, 1, 20.00, 0.00, 0.00, 20.00),
(164, 'PUR2612341EE4', 564, 100, 2, 3.50, 0.00, 0.00, 700.00);

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
  `current_stock` int DEFAULT '0',
  `last_update` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_stock`
--

INSERT INTO `product_stock` (`stock_id`, `product_id`, `opening_stock`, `purchase_stock`, `sale_stock`, `return_stock`, `current_stock`, `last_update`) VALUES
(1, 562, 100, 0, 0, 0, 100, '2026-04-19 15:19:42');

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
(24, 'Box (multiple strips)'),
(25, 'ml (Milliliter)'),
(26, 'Bottle'),
(27, 'Vial'),
(28, 'Ampoule'),
(29, 'mg (Milligram)'),
(30, 'g (Gram)'),
(31, 'kg (Kilogram)'),
(32, 'Sachet'),
(33, 'Pack'),
(34, 'Pair (for gloves)'),
(35, 'Roll (bandage)');

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
(88, '20-04-2026', '15', 'INV2610993157', 13, 0, 0),
(89, '20-04-2026', '15', 'INV2610993157', 0, 12, 0),
(90, '20-04-2026', '18', 'INV26109C43B1', 1, 0, 0),
(91, '20-04-2026', '15', 'INV261105D35E', 50, 0, 0),
(92, '20-04-2026', '15', 'INV261105D35E', 50, 0, 0),
(93, '20-04-2026', '15', 'INV2610993157', 13, 0, 0),
(94, '20-04-2026', '15', 'INV2610993157', 0, 12, 0),
(95, '20-04-2026', '15', 'INV2610993157', 13, 0, 0),
(96, '20-04-2026', '15', 'INV2610993157', 0, 12, 0),
(97, '20-04-2026', '15', 'INV261105D35E', 50, 0, 0),
(98, '20-04-2026', '15', 'INV2610993157', 13, 0, 0),
(99, '20-04-2026', '15', 'INV2610993157', 0, 12, 0),
(100, '20-04-2026', '15', 'INV261105D35E', 50, 0, 0),
(101, '20-04-2026', '15', 'INV261105D35E', 50, 0, 0),
(102, '20-04-2026', '15', 'INV261105D35E', 50, 0, 0),
(103, '20-04-2026', '15', 'INV261105D35E', 50, 0, 0),
(104, '20-04-2026', '15', 'INV261105D35E', 50, 0, 0),
(105, '21-04-2026', '15', 'INV261105D35E', 50, 0, 0),
(106, '21-04-2026', '15', 'INV261105D35E', 50, 0, 0),
(107, '21-04-2026', '15', 'INV261105D35E', 50, 0, 0),
(108, '21-04-2026', '15', 'INV261105D35E', 50, 0, 0),
(109, '21-04-2026', '15', 'INV2610993157', 13, 0, 0),
(110, '21-04-2026', '15', 'INV2610993157', 0, 12, 0),
(111, '23-04-2026', '15', 'INV261133B29A', 1, 0, 0),
(112, '24-04-2026', '15', 'INV26114524CE', 1, 0, 0),
(113, '24-04-2026', '15', 'INV2611482C99', 1, 0, 0),
(114, '26-04-2026', '15', 'INV261149E820', 7, 0, 0),
(115, '26-04-2026', '15', 'INV261149E820', 7, 0, 0),
(116, '26-04-2026', '15', 'INV261149E820', 7, 0, 0),
(117, '26-04-2026', '15', 'INV26116EB1B1', 1, 0, 0),
(118, '26-04-2026', '18', 'INV26116D0928', 6, 0, 0),
(120, '27-04-2026', '15', 'INV26117869A8', 73, 0, 0);

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
  `discountOnTotalPrice` decimal(11,2) DEFAULT '0.00',
  `vatOnTotalPrice` decimal(11,2) DEFAULT '0.00',
  `paid_amount` decimal(11,2) DEFAULT '0.00',
  `due_amount` decimal(11,2) DEFAULT '0.00',
  `return_by` int NOT NULL,
  `return_type` enum('FULL','PARTIAL') NOT NULL,
  `return_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `total_sale_price` decimal(11,2) DEFAULT '0.00',
  `productwiseVatPercnt` int NOT NULL,
  `productwiseDiscountPercnt` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int NOT NULL,
  `sales_invoice` varchar(50) NOT NULL,
  `customer_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sales_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_type` varchar(11) NOT NULL,
  `total_amount` decimal(11,2) DEFAULT NULL,
  `discountOnTotalPrice` decimal(11,2) NOT NULL,
  `vatOnTotalPrice` decimal(11,2) NOT NULL,
  `paid_amount` decimal(11,2) DEFAULT NULL,
  `due_amount` decimal(11,2) DEFAULT NULL,
  `seller_id` int DEFAULT NULL,
  `return_status` enum('ACTIVE','PARTIAL','FULL') DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `sales_invoice`, `customer_type`, `sales_date`, `payment_type`, `total_amount`, `discountOnTotalPrice`, `vatOnTotalPrice`, `paid_amount`, `due_amount`, `seller_id`, `return_status`, `created_at`) VALUES
(729, 'INV261181911E', '15', '2026-04-28 04:06:12', 'Cash', 12.12, 0.12, 0.24, 0.00, 12.12, 18, 'ACTIVE', '2026-04-28 10:06:12'),
(730, 'INV261180B975', '18', '2026-04-28 04:39:50', 'Cash', 24.00, 0.00, 0.00, 0.00, 24.00, 18, 'ACTIVE', '2026-04-28 10:39:50'),
(731, 'INV26119F696A', '18', '2026-04-29 00:55:05', 'Cash', 24.00, 0.00, 0.00, 0.00, 24.00, 18, 'ACTIVE', '2026-04-29 06:55:05'),
(732, 'INV26119B0AB3', '15', '2026-04-29 01:29:11', 'Cash', 40.80, 0.00, 0.00, 0.00, 40.80, 18, 'ACTIVE', '2026-04-29 07:29:11'),
(733, 'INV261193ABF1', '15', '2026-04-29 01:30:01', 'Cash', 2.40, 0.00, 0.00, 0.00, 2.40, 18, 'ACTIVE', '2026-04-29 07:30:01'),
(734, 'INV261202823F', '15', '2026-04-30 02:08:07', 'Cash', 1.20, 0.00, 0.00, 0.00, 1.20, 18, 'ACTIVE', '2026-04-30 08:08:07'),
(735, 'INV26123C15E9', '15', '2026-05-02 23:11:49', 'Cash', 50.10, 0.00, 0.00, 0.00, 50.10, 18, 'ACTIVE', '2026-05-03 05:11:49'),
(736, 'INV26123B7B8F', '15', '2026-05-03 01:37:39', 'Cash', 6.21, 0.00, 0.00, 0.00, 6.21, 18, 'ACTIVE', '2026-05-03 07:37:39'),
(737, 'INV261230CD76', '15', '2026-05-03 02:55:15', 'Cash', 29.01, 0.00, 0.00, 0.00, 29.01, 18, 'ACTIVE', '2026-05-03 08:55:15'),
(738, 'INV2612390290', '15', '2026-05-03 03:11:42', 'Cash', 152.53, 4.80, 0.07, 0.00, 152.53, 18, 'ACTIVE', '2026-05-03 09:11:42'),
(739, 'INV2612320544', '15', '2026-05-03 03:13:34', 'Cash', 1.20, 0.00, 0.00, 0.00, 1.20, 18, 'ACTIVE', '2026-05-03 09:13:34');

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
  `total_buy_price` decimal(12,2) DEFAULT NULL,
  `productwiseDiscountPercnt` int DEFAULT NULL,
  `productwiseDiscountAmount` decimal(11,2) DEFAULT NULL,
  `productwiseVatPercnt` int DEFAULT NULL,
  `productwiseVatAmount` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales_details`
--

INSERT INTO `sales_details` (`sales_details_id`, `sales_details_invoice`, `product_id`, `product_quantity_sold`, `unit_price`, `total_sale_price`, `total_buy_price`, `productwiseDiscountPercnt`, `productwiseDiscountAmount`, `productwiseVatPercnt`, `productwiseVatAmount`) VALUES
(1060, 'INV261181911E', 562, 10, 1.20, 12.00, 10.00, 1, 0.12, 2, 0.24),
(1061, 'INV261180B975', 563, 1, 24.00, 24.00, 20.00, 0, 0.00, 0, 0.00),
(1062, 'INV26119F696A', 563, 1, 24.00, 24.00, 20.00, 0, 0.00, 0, 0.00),
(1063, 'INV26119B0AB3', 562, 14, 1.20, 16.80, 14.00, 0, 0.00, 0, 0.00),
(1064, 'INV26119B0AB3', 563, 1, 24.00, 24.00, 20.00, 0, 0.00, 0, 0.00),
(1065, 'INV261193ABF1', 562, 2, 1.20, 2.40, 2.00, 0, 0.00, 0, 0.00),
(1066, 'INV261202823F', 562, 1, 1.20, 1.20, 1.00, 0, 0.00, 0, 0.00),
(1067, 'INV26123C15E9', 564, 10, 5.01, 50.10, 35.00, 0, 0.00, 0, 0.00),
(1068, 'INV26123B7B8F', 562, 1, 1.20, 1.20, 1.00, 0, 0.00, 0, 0.00),
(1069, 'INV26123B7B8F', 564, 1, 5.01, 5.01, 3.50, 0, 0.00, 0, 0.00),
(1070, 'INV261230CD76', 563, 1, 24.00, 24.00, 20.00, 0, 0.00, 0, 0.00),
(1071, 'INV261230CD76', 564, 1, 5.01, 5.01, 3.50, 0, 0.00, 0, 0.00),
(1072, 'INV2612390290', 562, 6, 1.20, 7.20, 6.00, 0, 0.00, 1, 0.07),
(1073, 'INV2612390290', 563, 5, 24.00, 120.00, 100.00, 4, 4.80, 0, 0.00),
(1074, 'INV2612390290', 564, 6, 5.01, 30.06, 21.00, 0, 0.00, 0, 0.00),
(1075, 'INV2612320544', 562, 1, 1.20, 1.20, 1.00, 0, 0.00, 0, 0.00);

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
(11, 'None', 4.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(80) NOT NULL,
  `login_id` varchar(80) NOT NULL,
  `login_password` varchar(80) NOT NULL,
  `user_role_id` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `login_id`, `login_password`, `user_role_id`) VALUES
(18, 'Md. Kabir Hossain', 'kabir@gmail.com', 'kabir', '123456', '46'),
(19, 'Nafisa Tabassom', 'nafisa@gmail.com', 'nafisa1', '589674', '48');

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
(46, 'Administrator', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,0,28,29,30,31,32'),
(47, 'Sales Man', '1,2,0,4,5,0,7,8,0,10,11,0,13,14,0,16,17,0,19,20,0,22,23,0,25,26,0,28,29,0,31,32'),
(48, 'user', '1,2,0,4,5,0,7,8,9,0,11,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0');

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
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_due`
--
ALTER TABLE `customer_due`
  ADD PRIMARY KEY (`due_id`);

--
-- Indexes for table `customer_group`
--
ALTER TABLE `customer_group`
  ADD PRIMARY KEY (`customer_group_id`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`expense_category_id`);

--
-- Indexes for table `expense_sub_category`
--
ALTER TABLE `expense_sub_category`
  ADD PRIMARY KEY (`expense_sub_category_id`);

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
  ADD PRIMARY KEY (`brand_id`);

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
  ADD PRIMARY KEY (`user_id`);

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
  MODIFY `customer_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `customer_due`
--
ALTER TABLE `customer_due`
  MODIFY `due_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=453;

--
-- AUTO_INCREMENT for table `customer_group`
--
ALTER TABLE `customer_group`
  MODIFY `customer_group_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `expense_category_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `expense_sub_category`
--
ALTER TABLE `expense_sub_category`
  MODIFY `expense_sub_category_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `held_sales`
--
ALTER TABLE `held_sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

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
  MODIFY `brand_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `product_group`
--
ALTER TABLE `product_group`
  MODIFY `product_group_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `product_inital_stock`
--
ALTER TABLE `product_inital_stock`
  MODIFY `product_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=565;

--
-- AUTO_INCREMENT for table `product_purchase`
--
ALTER TABLE `product_purchase`
  MODIFY `product_purchase_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `product_purchase_details`
--
ALTER TABLE `product_purchase_details`
  MODIFY `purchase_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `product_stock`
--
ALTER TABLE `product_stock`
  MODIFY `stock_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_unit`
--
ALTER TABLE `product_unit`
  MODIFY `product_unit_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `return_customer_due`
--
ALTER TABLE `return_customer_due`
  MODIFY `due_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `return_sales`
--
ALTER TABLE `return_sales`
  MODIFY `return_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `return_sales_details`
--
ALTER TABLE `return_sales_details`
  MODIFY `return_detail_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=740;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `sales_details_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1076;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `tax_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `user_role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
