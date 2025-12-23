-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 15, 2025 at 11:01 AM
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
(2, 'CNY', 'Chinese Yuan', '¥'),
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
(11, 'ayan11', 'zahin', 'ayan@gmail.com', '01913698854', 'banasree', '33331425875', 'Mia Group', 'special', '0000-00-00 00:00:00'),
(13, 'motin', 'mia', 'sfs@gmail.com', '01913698854', 'dhaka', '21/02/2021', 'motin&Brothers', 'special', '0000-00-00 00:00:00'),
(14, 'Mohamm Kabir', 'Hossain', 'kabir@gmail.com', '01913691185', 'Banasree, Dhaka-1207', '193322200415', 'Bdposhak.com', 'general', '0000-00-00 00:00:00'),
(15, 'Hossain ', 'Mahmood', 'hossain@gmail.com', '0155869547', 'Aftabnaga', '02213645478', 'bdposhak.com', 'general', '0000-00-00 00:00:00'),
(16, 'Hossain ', 'Mahmood', 'hossain@gmail.com', '0155869547', 'Aftabnaga', '02213645478', 'bdposhak.com', 'general', '0000-00-00 00:00:00'),
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
(361, '2025-07-31', '13', 'INV25212FA09C', 525, 0, 0),
(364, '2025-08-05', '13', 'INV25217398B8', 4590, 0, 0),
(365, '2025-08-24', '14', 'INV25236D85F4', 4590, 0, 0),
(366, '2025-08-24', '13', 'INV252362FA4E', 34680, 0, 0),
(367, '2025-08-24', '13', 'INV25236C2EFF', 25500, 0, 0),
(368, '2025-08-24', '13', 'INV2523668F09', 4590, 0, 0),
(369, '2025-08-24', '15', 'INV2523647FBE', 4590, 0, 0),
(370, '2025-08-24', '13', 'INV252360433B', 25500, 0, 0),
(371, '2025-08-24', '14', 'INV25236DBA25', 25500, 0, 0),
(372, '2025-08-24', '13', 'INV25236417A9', 25500, 0, 0),
(373, '2025-08-24', '13', 'INV2523699B53', 25500, 0, 0),
(374, '2025-08-24', '13', 'INV2523646375', 525, 0, 0),
(375, '2025-08-24', '13', 'INV25236FD6A8', 25500, 0, 0),
(376, '2025-08-24', '13', 'INV25236222CB', 525, 0, 0),
(377, '2025-08-24', '14', 'INV2523686A2A', 25500, 0, 0),
(378, '2025-08-24', '13', 'INV2523686BA2', 25500, 0, 0),
(379, '2025-08-24', '14', 'INV252363DE0B', 4590, 0, 0),
(380, '2025-08-24', '14', 'INV25236C179D', 525, 0, 0),
(381, '2025-08-24', '13', 'INV25236A77C2', 4590, 0, 0),
(382, '2025-08-24', '13', 'INV2523683BC5', 1224, 0, 0),
(383, '2025-08-24', '14', 'INV25236820D6', 47110, 0, 0),
(384, '2025-08-24', '14', 'INV252363262F', 4590, 0, 0),
(385, '2025-08-25', '13', 'INV25237DE68C', 1200, 0, 0),
(386, '2025-08-25', '14', 'INV252377F957', 1224, 0, 0),
(387, '2025-08-27', '13', 'INV2523927F5B', 5800, 0, 0),
(388, '2025-09-01', '13', 'INV25244CEE3C', 4589, 0, 0),
(389, '2025-09-01', '13', 'INV252441901F', 4589, 0, 0),
(390, '2025-09-22', '13', 'INV2526548B8C', 4900, 0, 0),
(391, '2025-09-22', '13', 'INV252656B035', 9360, 0, 0),
(392, '2025-09-22', '15', 'INV25265BA3E3', 5500, 0, 0),
(393, '2025-09-22', '11', 'INV25265C3A1D', 700, 0, 0),
(394, '2025-09-22', '13', 'INV2526575647', 64000, 0, 0),
(395, '2025-09-22', '14', 'INV25265ADDAA', 4857, 0, 0),
(396, '2025-09-22', '13', 'INV2526516D96', 4500, 0, 0);

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
(3, 'Female', 20001, '3');

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
  `expense_amount` bigint NOT NULL,
  `expense_note` varchar(200) DEFAULT NULL,
  `expense_date` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expense_id`, `expense_ref_no`, `expense_category`, `expense_sub_category`, `expense_what_for`, `expense_amount`, `expense_note`, `expense_date`) VALUES
(27, 'by kabir', '8', '3', 'Jewel\'s khabar', 1300, 'eid purose', '28-05-2025'),
(28, 'by kabir', '8', '3', 'Jewel\'s khabar', 1300, 'eid purose', '28-05-2025'),
(29, 'aasas', '11', '5', 'electicity bill2025may', 100, 'eid purose', '21-05-2025'),
(30, 'May2025', '12', '9', 'electicity bill2025may', 1200, 'bill fo may 25', '28-05-2025');

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
(7, 'Family Purpose'),
(8, 'test category'),
(11, 'Snacks'),
(12, 'Electricity Bill');

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
(1, 4, 'Bangla Khata11'),
(3, 7, 'Cloths Purchase'),
(4, 4, 'Pen Purchase'),
(5, 4, 'car'),
(7, 11, 'Morning Ruti'),
(8, 11, 'Dall Puri'),
(9, 12, 'Electricity Bill-May,2025');

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
(4, 'ABC Company', 'skabir@gmail.com', 'Bangladesh', 'BDT', '01913691193', NULL, 'test1');

-- --------------------------------------------------------

--
-- Table structure for table `held_sales`
--

CREATE TABLE `held_sales` (
  `id` int NOT NULL,
  `hold_id` varchar(50) NOT NULL,
  `seller_id` int NOT NULL,
  `customer_type` varchar(50) NOT NULL,
  `cart_data` varchar(500) NOT NULL,
  `discountOnTotalPrice` int NOT NULL,
  `vatOnTotalPrice` int NOT NULL,
  `created_at` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `held_sales`
--

INSERT INTO `held_sales` (`id`, `hold_id`, `seller_id`, `customer_type`, `cart_data`, `discountOnTotalPrice`, `vatOnTotalPrice`, `created_at`) VALUES
(22, 'HLD250924112742429', 18, 'Walk-In-Customer', '', 0, 0, ''),
(23, 'HLD250924113002309', 18, '14', '', 0, 0, ''),
(24, 'HLD250924113422640', 18, '14', '[{\"product_id\":\"101\",\"product_name\":\"Child Dress\",\"product_category\":\"105\",\"product_brand\":\"22\",\"product_group\":\"32\",\"product_unit\":\"9\",\"codefor_barcode\":\"child-dress\",\"tax_perchantage\":\"\",\"productinitial_quantity\":\"150\",\"buying_unit_price\":\"500\",\"selling_unit_price\":\"800\",\"alert_quantity\":\"2\",\"product_image\":\"95147aca2ae40603b8f0046a94a6308c.jpg\",\"total_stock\":\"148\",\"quantity\":\"1\"},{\"product_id\":\"103\",\"product_name\":\"Mobile\",\"product_category\":\"110\",\"product_brand\":\"25\",\"product_group\":\"37\",\"pr', 0, 0, '2025-09-24 11:34:22'),
(25, 'HLD251028044059514', 18, 'Walk-In-Customer', '[{\"product_id\":\"103\",\"product_name\":\"Mobile\",\"product_category\":\"110\",\"product_brand\":\"25\",\"product_group\":\"37\",\"product_unit\":\"9\",\"codefor_barcode\":\"Nok-001\",\"tax_perchantage\":\"2.00\",\"productinitial_quantity\":\"50\",\"buying_unit_price\":\"3500\",\"selling_unit_price\":\"4500\",\"alert_quantity\":\"2\",\"product_image\":\"nokia.jpg\",\"total_stock\":\"30\",\"quantity\":\"1\"}]', 0, 0, '2025-10-28 04:40:59'),
(26, 'HLD251215043307969', 18, 'Walk-In-Customer', '[{\"product_id\":\"105\",\"product_name\":\"Three piece\",\"product_category\":\"105\",\"product_brand\":\"22\",\"product_group\":\"32\",\"product_unit\":\"9\",\"codefor_barcode\":\"Tree piece Barcode\",\"tax_perchantage\":\"5\",\"productinitial_quantity\":\"100\",\"buying_unit_price\":\"300\",\"selling_unit_price\":\"500\",\"alert_quantity\":\"5\",\"product_image\":\"11.jpg\",\"total_stock\":\"94\",\"quantity\":\"1\"}]', 0, 0, '2025-12-15 04:33:07'),
(27, 'HLD251215043320849', 18, 'Walk-In-Customer', '[{\"product_id\":\"106\",\"product_name\":\"Shoes\",\"product_category\":\"112\",\"product_brand\":\"28\",\"product_group\":\"32\",\"product_unit\":\"9\",\"codefor_barcode\":\"Bata-Shoes\",\"tax_perchantage\":\"2\",\"productinitial_quantity\":\"50\",\"buying_unit_price\":\"790\",\"selling_unit_price\":\"1200\",\"alert_quantity\":\"5\",\"product_image\":\"shoes.jpg\",\"total_stock\":\"43\",\"quantity\":\"1\"}]', 0, 0, '2025-12-15 04:33:20');

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
(22, 'La-reve', 105),
(25, 'Nokia', 110),
(27, 'Laptop', 111),
(28, 'Bata', 112),
(29, 'Walton', 113),
(30, 'Paracetamle', 114),
(31, 'Beimco', 114),
(32, 'asdadasdas', 105),
(33, 'Panjabi', 105);

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
(105, 'Cloths'),
(110, 'Telecom'),
(111, 'Digital Product'),
(112, 'Shoes'),
(113, 'Electronics'),
(114, 'Tablet');

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
(32, 'Women'),
(37, 'Digital Product'),
(38, 'Paracetamle'),
(39, 'sdfdsfdsf'),
(40, 'sdfdsfdsf');

-- --------------------------------------------------------

--
-- Table structure for table `product_inital_stock`
--

CREATE TABLE `product_inital_stock` (
  `product_id` bigint NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `product_category` varchar(50) DEFAULT NULL,
  `product_brand` varchar(50) DEFAULT NULL,
  `product_group` int NOT NULL,
  `product_unit` varchar(50) DEFAULT NULL,
  `codefor_barcode` varchar(50) DEFAULT NULL,
  `tax_perchantage` varchar(11) NOT NULL,
  `productinitial_quantity` varchar(20) NOT NULL,
  `buying_unit_price` int NOT NULL,
  `selling_unit_price` varchar(50) NOT NULL,
  `alert_quantity` varchar(50) NOT NULL,
  `product_image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_inital_stock`
--

INSERT INTO `product_inital_stock` (`product_id`, `product_name`, `product_category`, `product_brand`, `product_group`, `product_unit`, `codefor_barcode`, `tax_perchantage`, `productinitial_quantity`, `buying_unit_price`, `selling_unit_price`, `alert_quantity`, `product_image`) VALUES
(101, 'Child Dress', '105', '22', 32, '9', 'child-dress', '', '150', 500, '800', '2', '95147aca2ae40603b8f0046a94a6308c.jpg'),
(103, 'Mobile', '110', '25', 37, '9', 'Nok-001', '2.00', '50', 3500, '4500', '2', 'nokia.jpg'),
(104, 'Laptop', '111', '27', 37, '9', '111', '2', '10', 20000, '25000', '5', 'laptop.jpg'),
(105, 'Three piece', '105', '22', 32, '9', 'Tree piece Barcode', '5', '100', 300, '500', '5', '11.jpg'),
(106, 'Shoes', '112', '28', 32, '9', 'Bata-Shoes', '2', '50', 790, '1200', '5', 'shoes.jpg'),
(107, 'Refrigerator', '113', '29', 37, '9', 'test', '2', '100', 30000, '40000', '5', 'freeze.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase`
--

CREATE TABLE `product_purchase` (
  `product_purchase_id` int NOT NULL,
  `purchase_invoice` varchar(100) NOT NULL,
  `purchaser_id` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `payment_type` varchar(80) NOT NULL,
  `purchase_discount` int NOT NULL,
  `purchase_other_cost` int NOT NULL,
  `supplier_id` varchar(50) NOT NULL,
  `purchase_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_purchase`
--

INSERT INTO `product_purchase` (`product_purchase_id`, `purchase_invoice`, `purchaser_id`, `payment_type`, `purchase_discount`, `purchase_other_cost`, `supplier_id`, `purchase_date`) VALUES
(68, 'PUR251781C57D', '1', 'Cash', 0, 0, '106', '2025-06-27 06:07:11'),
(69, 'PUR25217AE21C', '18', 'Cash', 0, 0, '106', '2025-08-05 00:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase_details`
--

CREATE TABLE `product_purchase_details` (
  `purchase_id` bigint NOT NULL,
  `purchase_invoice_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `unit_price` int NOT NULL,
  `quantity` int NOT NULL,
  `total_price` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_purchase_details`
--

INSERT INTO `product_purchase_details` (`purchase_id`, `purchase_invoice_id`, `product_id`, `unit_price`, `quantity`, `total_price`) VALUES
(123, 'PUR251781C57D', '101', 500, 2, 1000),
(124, 'PUR25217AE21C', '107', 30000, 1, 30000);

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
(9, 'piece'),
(16, 'gram'),
(18, 'Kg');

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
(16, '22-06-2025', '14', 'INV2516893BBF', 50678, 0, 0),
(17, '22-06-2025', '14', 'INV2516893BBF', 0, 2000, 0),
(18, '22-06-2025', '13', 'INV25173A4EDB', 700, 0, 0),
(19, '22-06-2025', '16', 'INV25173BA945', 24901, 0, 0),
(42, '03-09-2025', '13', 'INV251821D36E', 20500, 0, 0),
(43, '03-09-2025', '13', 'INV251821D36E', 0, 500, 0),
(44, '03-09-2025', '14', 'INV25173F2C4F', 25500, 0, 0),
(45, '03-09-2025', '14', 'INV25173F2C4F', 0, 48, 0),
(46, '03-09-2025', '14', 'INV25173F2C4F', 0, 900, 0),
(47, '03-09-2025', '14', 'INV25173F2C4F', 0, 700, 0),
(48, '03-09-2025', '14', 'INV25173F2C4F', 0, 300, 0),
(49, '10-09-2025', '14', 'INV25173A4B9B', 2448, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `return_sales`
--

CREATE TABLE `return_sales` (
  `sales_id` int NOT NULL,
  `sales_invoice` varchar(50) NOT NULL,
  `customer_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sales_date` varchar(40) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `discountOnTotalPrice` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `vatOnTotalPrice` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `paid_amount` decimal(11,2) DEFAULT NULL,
  `due_amount` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `return_sales`
--

INSERT INTO `return_sales` (`sales_id`, `sales_invoice`, `customer_type`, `sales_date`, `payment_type`, `discountOnTotalPrice`, `vatOnTotalPrice`, `paid_amount`, `due_amount`) VALUES
(65, 'INV2516893BBF', '14', '2025-06-17 11:36:21', 'Cash', '111', '222', 7777.00, 50678.00),
(66, 'INV25173A4EDB', '13', '2025-06-22 11:51:09', 'Cash', '22', '3', 97.00, 700.00),
(67, 'INV25173BA945', '16', '2025-06-22 12:05:44', 'Cash', '2', '2', 599.00, 24901.00),
(68, 'INV251821D36E', '13', '2025-07-01 10:16:49', 'Cash', '500', '200', 20000.00, 20500.00),
(69, 'INV25173F2C4F', '14', '2025-06-22 11:55:40', 'Cash', '0', '0', 0.00, 25500.00),
(70, 'INV25173A4B9B', '14', '2025-06-22 11:54:30', 'Cash', '0', '0', 0.00, 2448.00);

-- --------------------------------------------------------

--
-- Table structure for table `return_sales_details`
--

CREATE TABLE `return_sales_details` (
  `sales_details_id` int NOT NULL,
  `sales_details_invoice` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `product_quantity_sold` int NOT NULL,
  `unit_price` decimal(11,2) DEFAULT NULL,
  `total_buy_price` bigint NOT NULL,
  `total_sale_price` decimal(10,2) NOT NULL,
  `tax_paid` int NOT NULL,
  `tax_perchantage` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `return_sales_details`
--

INSERT INTO `return_sales_details` (`sales_details_id`, `sales_details_invoice`, `product_id`, `product_quantity_sold`, `unit_price`, `total_buy_price`, `total_sale_price`, `tax_paid`, `tax_perchantage`) VALUES
(42, 'INV2516893BBF', '101', 1, 800.00, 500, 800.00, 16, 2),
(43, 'INV2516893BBF', '102', 1, 1900.00, 1500, 1900.00, 38, 2),
(44, 'INV2516893BBF', '103', 1, 4500.00, 3500, 4500.00, 90, 2),
(45, 'INV2516893BBF', '104', 2, 25000.00, 40000, 50000.00, 1000, 2),
(46, 'INV25173A4EDB', '101', 1, 800.00, 500, 800.00, 16, 2),
(47, 'INV25173BA945', '104', 1, 25000.00, 20000, 25000.00, 500, 2),
(54, 'INV251821D36E', '107', 1, 40000.00, 30000, 40000.00, 800, 2),
(55, 'INV25173F2C4F', '104', 1, 25000.00, 20000, 25000.00, 500, 2),
(56, 'INV25173A4B9B', '106', 2, 1200.00, 1580, 2400.00, 48, 2);

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
  `discountOnTotalPrice` int NOT NULL,
  `vatOnTotalPrice` int NOT NULL,
  `paid_amount` decimal(11,2) DEFAULT NULL,
  `due_amount` decimal(11,2) DEFAULT NULL,
  `seller_id` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `sales_invoice`, `customer_type`, `sales_date`, `payment_type`, `discountOnTotalPrice`, `vatOnTotalPrice`, `paid_amount`, `due_amount`, `seller_id`) VALUES
(616, 'INV25212FA09C', '13', '2025-07-30 19:28:25', 'Cash', 0, 0, 0.00, 525.00, '18'),
(617, 'INV25217398B8', '13', '2025-08-04 19:24:04', 'Cash', 0, 0, 0.00, 4590.00, '18'),
(618, 'INV25236D85F4', '14', '2025-08-24 00:58:50', 'Cash', 0, 0, 0.00, 4590.00, '18'),
(619, 'INV252362FA4E', '13', '2025-08-24 00:59:24', 'Cash', 0, 0, 0.00, 34680.00, '18'),
(620, 'INV25236C2EFF', '13', '2025-08-24 01:00:47', 'Cash', 0, 0, 0.00, 25500.00, '18'),
(621, 'INV2523668F09', '13', '2025-08-24 01:07:47', 'Cash', 0, 0, 0.00, 4590.00, '18'),
(622, 'INV2523647FBE', '15', '2025-08-24 01:11:19', 'Cash', 0, 0, 0.00, 4590.00, '18'),
(623, 'INV252360433B', '13', '2025-08-24 01:11:53', 'Cash', 0, 0, 0.00, 25500.00, '18'),
(624, 'INV25236DBA25', '14', '2025-08-24 01:12:23', 'Cash', 0, 0, 0.00, 25500.00, '18'),
(625, 'INV25236417A9', '13', '2025-08-24 01:14:55', 'Cash', 0, 0, 0.00, 25500.00, '18'),
(626, 'INV2523699B53', '13', '2025-08-24 01:16:01', 'Cash', 0, 0, 0.00, 25500.00, '18'),
(627, 'INV2523646375', '13', '2025-08-24 01:17:42', 'Cash', 0, 0, 0.00, 525.00, '18'),
(628, 'INV25236FD6A8', '13', '2025-08-24 01:20:41', 'Cash', 0, 0, 0.00, 25500.00, '18'),
(629, 'INV25236222CB', '13', '2025-08-24 01:24:43', 'Cash', 0, 0, 0.00, 525.00, '18'),
(630, 'INV2523686A2A', '14', '2025-08-24 01:40:03', 'Cash', 0, 0, 0.00, 25500.00, '18'),
(631, 'INV2523686BA2', '13', '2025-08-24 01:41:40', 'Cash', 0, 0, 0.00, 25500.00, '18'),
(632, 'INV252363DE0B', '14', '2025-08-24 01:43:16', 'Cash', 0, 0, 0.00, 4590.00, '18'),
(633, 'INV25236C179D', '14', '2025-08-24 01:47:36', 'Cash', 0, 0, 0.00, 525.00, '18'),
(634, 'INV25236A77C2', '13', '2025-08-24 02:11:35', 'Cash', 0, 0, 0.00, 4590.00, '18'),
(635, 'INV2523683BC5', '13', '2025-08-24 02:16:03', 'Cash', 0, 0, 0.00, 1224.00, '18'),
(636, 'INV25236820D6', '14', '2025-08-24 02:19:24', 'Cash', 39, 10, 0.00, 47110.00, '18'),
(637, 'INV252363262F', '14', '2025-08-24 03:11:11', 'Cash', 0, 0, 0.00, 4590.00, '18'),
(638, 'INV25237DE68C', '13', '2025-08-25 02:48:55', 'Cash', 10, 0, 18.00, 1200.00, '18'),
(639, 'INV252377F957', '14', '2025-08-25 06:03:48', 'Cash', 0, 0, 0.00, 1224.00, '18'),
(640, 'INV2523927F5B', '13', '2025-08-27 01:04:39', 'Cash', 581, 0, 14.00, 5800.00, '18'),
(641, 'INV25244CEE3C', '13', '2025-09-01 02:17:14', 'Cash', 0, 0, 1.00, 4589.00, '18'),
(642, 'INV252441901F', '13', '2025-09-01 02:17:47', 'Cash', 0, 0, 1.00, 4589.00, '18'),
(643, 'INV2526548B8C', '13', '2025-09-22 01:08:25', 'Cash', 10, 0, 50.00, 4900.00, '18'),
(644, 'INV252656B035', '13', '2025-09-22 02:35:15', 'Cash', 0, 0, 0.00, 9360.00, '18'),
(645, 'INV25265BA3E3', '15', '2025-09-22 02:39:17', 'Cash', 0, 0, 81.00, 5500.00, '18'),
(646, 'INV25265C3A1D', '11', '2025-09-22 02:45:45', 'Cash', 48, 0, 200.00, 700.00, '18'),
(647, 'INV2526575647', '13', '2025-09-22 03:01:09', 'Cash', 7128, 0, 160.00, 64000.00, '18'),
(648, 'INV25265ADDAA', '14', '2025-09-22 03:09:07', 'Cash', 446, 0, 44.00, 4856.50, '18'),
(649, 'INV2526516D96', '13', '2025-09-22 03:12:52', 'Cash', 1060, 265, 5.00, 4500.00, '18');

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
  `total_buy_price` bigint NOT NULL,
  `total_sale_price` bigint NOT NULL,
  `productwiseVatPercnt` int DEFAULT NULL,
  `productwiseDiscountPercnt` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales_details`
--

INSERT INTO `sales_details` (`sales_details_id`, `sales_details_invoice`, `product_id`, `product_quantity_sold`, `unit_price`, `total_buy_price`, `total_sale_price`, `productwiseVatPercnt`, `productwiseDiscountPercnt`) VALUES
(905, 'INV251682190C', 106, 1, 1200.00, 790, 1200, 24, 2),
(917, 'INV25212FA09C', 105, 1, 500.00, 300, 500, 25, 5),
(918, 'INV25217398B8', 103, 1, 4500.00, 3500, 4500, 90, 2),
(919, 'INV25236D85F4', 103, 1, 4500.00, 3500, 4500, 90, 2),
(920, 'INV252362FA4E', 103, 2, 4500.00, 7000, 9000, 180, 2),
(921, 'INV252362FA4E', 104, 1, 25000.00, 20000, 25000, 500, 2),
(922, 'INV25236C2EFF', 104, 1, 25000.00, 20000, 25000, 500, 2),
(923, 'INV2523668F09', 103, 1, 4500.00, 3500, 4500, 90, 2),
(924, 'INV2523647FBE', 103, 1, 4500.00, 3500, 4500, 90, 2),
(925, 'INV252360433B', 104, 1, 25000.00, 20000, 25000, 500, 2),
(926, 'INV25236DBA25', 104, 1, 25000.00, 20000, 25000, 500, 2),
(927, 'INV25236417A9', 104, 1, 25000.00, 20000, 25000, 500, 2),
(928, 'INV2523699B53', 104, 1, 25000.00, 20000, 25000, 500, 2),
(929, 'INV2523646375', 105, 1, 500.00, 300, 500, 25, 5),
(930, 'INV25236FD6A8', 104, 1, 25000.00, 20000, 25000, 500, 2),
(931, 'INV25236222CB', 105, 1, 500.00, 300, 500, 25, 5),
(932, 'INV2523686A2A', 104, 1, 25000.00, 20000, 25000, 500, 2),
(933, 'INV2523686BA2', 104, 1, 25000.00, 20000, 25000, 500, 2),
(934, 'INV252363DE0B', 103, 1, 4500.00, 3500, 4500, 90, 2),
(935, 'INV25236C179D', 105, 1, 500.00, 300, 500, 25, 5),
(936, 'INV25236A77C2', 103, 1, 4500.00, 3500, 4500, 90, 2),
(937, 'INV2523683BC5', 106, 1, 1200.00, 790, 1200, 24, 2),
(938, 'INV25236820D6', 103, 1, 4500.00, 3500, 4500, 90, 2),
(939, 'INV25236820D6', 105, 1, 500.00, 300, 500, 25, 5),
(940, 'INV25236820D6', 106, 1, 1200.00, 790, 1200, 24, 2),
(941, 'INV25236820D6', 107, 1, 40000.00, 30000, 40000, 800, 2),
(942, 'INV252363262F', 103, 1, 4500.00, 3500, 4500, 90, 2),
(943, 'INV25237DE68C', 106, 1, 1200.00, 790, 1200, 24, 2),
(944, 'INV252377F957', 106, 1, 1200.00, 790, 1200, 24, 2),
(945, 'INV2523927F5B', 106, 1, 1200.00, 790, 1200, 24, 2),
(946, 'INV2523927F5B', 103, 1, 4500.00, 3500, 4500, 90, 2),
(947, 'INV25244CEE3C', 103, 1, 4500.00, 3500, 4500, 90, 2),
(948, 'INV252441901F', 103, 1, 4500.00, 3500, 4500, 90, 2),
(949, 'INV2526548B8C', 103, 1, 4500.00, 3500, 4500, 90, 2),
(950, 'INV252656B035', 103, 2, 4500.00, 7000, 9000, 5, 1),
(951, 'INV25265BA3E3', 101, 1, 800.00, 500, 800, 12, 5),
(952, 'INV25265BA3E3', 103, 1, 4500.00, 3500, 4500, 10, 5),
(953, 'INV25265C3A1D', 101, 1, 800.00, 500, 800, 7, 1),
(954, 'INV2526575647', 101, 1, 800.00, 500, 800, 2, 3),
(955, 'INV2526575647', 103, 1, 4500.00, 3500, 4500, 2, 3),
(956, 'INV2526575647', 104, 1, 25000.00, 20000, 25000, 2, 3),
(957, 'INV2526575647', 105, 1, 500.00, 300, 500, 2, 3),
(958, 'INV2526575647', 106, 1, 1200.00, 790, 1200, 2, 3),
(959, 'INV2526575647', 107, 1, 40000.00, 30000, 40000, 2, 3),
(960, 'INV25265ADDAA', 103, 1, 4500.00, 3500, 4500, 1, 2),
(961, 'INV2526516D96', 101, 1, 800.00, 500, 800, 2, 2),
(962, 'INV2526516D96', 103, 1, 4500.00, 3500, 4500, 2, 2);

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
(106, 'Sumonor Rahman', 'Cloths Business', '01952368875', 'sumon@gmail.com', 'Aftabnagar', '12/01/2022');

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `tax_id` int NOT NULL,
  `tax_name` varchar(80) NOT NULL,
  `tax_percentage` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`tax_id`, `tax_name`, `tax_percentage`) VALUES
(4, 'Tax 5%', '5'),
(8, 'Tax 2%', '2'),
(9, 'VAT', '0');

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
(19, 'Nafisa Tabassom', 'nafisa@gmail.com', 'nafisa', '123456', '47'),
(24, 'sdfdsf', 'kabir@gmail.com', 'kona', '123456', '48');

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
(48, 'sdfds', '1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0');

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
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expense_id`);

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
  ADD PRIMARY KEY (`purchase_id`);

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
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `return_sales_details`
--
ALTER TABLE `return_sales_details`
  ADD PRIMARY KEY (`sales_details_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `customer_due`
--
ALTER TABLE `customer_due`
  MODIFY `due_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=397;

--
-- AUTO_INCREMENT for table `customer_group`
--
ALTER TABLE `customer_group`
  MODIFY `customer_group_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expense_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `expense_category_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `expense_sub_category`
--
ALTER TABLE `expense_sub_category`
  MODIFY `expense_sub_category_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `held_sales`
--
ALTER TABLE `held_sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
  MODIFY `brand_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `product_group`
--
ALTER TABLE `product_group`
  MODIFY `product_group_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `product_inital_stock`
--
ALTER TABLE `product_inital_stock`
  MODIFY `product_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `product_purchase`
--
ALTER TABLE `product_purchase`
  MODIFY `product_purchase_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `product_purchase_details`
--
ALTER TABLE `product_purchase_details`
  MODIFY `purchase_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `product_unit`
--
ALTER TABLE `product_unit`
  MODIFY `product_unit_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `return_customer_due`
--
ALTER TABLE `return_customer_due`
  MODIFY `due_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `return_sales`
--
ALTER TABLE `return_sales`
  MODIFY `sales_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `return_sales_details`
--
ALTER TABLE `return_sales_details`
  MODIFY `sales_details_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=650;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `sales_details_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=963;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `tax_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `user_role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
