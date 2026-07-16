-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2026 at 06:32 AM
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
-- Database: `sctime_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_batch`
--

CREATE TABLE `course_batch` (
  `batch_id` bigint NOT NULL,
  `course_id` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `time_slot` varchar(100) NOT NULL,
  `weekly_days` varchar(100) NOT NULL,
  `max_seats` int NOT NULL,
  `booked_seats` int NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course_batch`
--

INSERT INTO `course_batch` (`batch_id`, `course_id`, `start_date`, `end_date`, `time_slot`, `weekly_days`, `max_seats`, `booked_seats`, `status`) VALUES
(1, '67', '2024-10-01', '2024-12-15', '08:00 PM - 10:00 PM', 'Fri', 5, 5, 'active'),
(208, '65', '2024-03-01', '2025-06-01', '08:00 PM - 10:00 PM', 'Mon, Fri', 10, 7, 'active'),
(209, '66', '2025-01-02', '2025-02-02', '09:00 AM - 10:00 AM', 'Fri', 10, 0, 'active'),
(210, '69', '2025-02-15', '2025-04-15', '08:30 PM - 10:00 PM', 'Mon, Fri', 20, 0, 'active'),
(211, '70', '2025-02-04', '2025-10-30', '08:30 PM - 10:00 PM', 'Tue, Fri', 20, 0, 'active'),
(212, '71', '2025-02-01', '2025-05-30', '09:00 AM - 10:00 AM', 'Fri', 20, 3, 'active'),
(1437, '74', '2026-01-27', '2027-02-01', '04:00 PM - 05:00 PM', 'Mon, Fri', 100, 0, 'active'),
(1438, '65', '2026-01-28', '2026-02-28', '10:00 AM - 11:00 AM', 'Tue, Wed, Thu, Fri', 10, 1, 'inactive'),
(1439, '75', '2026-02-01', '2026-03-02', '10:00 AM - 11:00 AM', 'Mon,Fri', 100, 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `course_category`
--

CREATE TABLE `course_category` (
  `course_category_id` bigint NOT NULL,
  `course_section_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_category_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_category`
--

INSERT INTO `course_category` (`course_category_id`, `course_section_id`, `course_category_name`) VALUES
(29, '2', 'ওয়েব এন্ড সফটওয়্যার ডেভেলপমেন্ট'),
(30, '1', 'নবম শ্রেণী'),
(37, '1', 'দশম শ্রেনী'),
(151, '3', 'MCQ পরীক্ষা');

-- --------------------------------------------------------

--
-- Table structure for table `course_content`
--

CREATE TABLE `course_content` (
  `course_content_id` bigint NOT NULL,
  `course_id` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `chapter_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `chapter_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_title` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_link` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdf_file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_content`
--

INSERT INTO `course_content` (`course_content_id`, `course_id`, `chapter_id`, `chapter_name`, `video_title`, `video_link`, `pdf_file_path`) VALUES
(2, '67', 'CHAP241753736F', 'প্রাত্যহিক জীবনে সেট: ক্লাস-০১', '১। গণিতে সেটের প্রয়োজনীয়তা ২। সেটের প্রকাশ ৩। সেট লেখার ও প্রকাশের পদ্ধতি ৪। প্রকারভেদ (তালিকা ও গঠন পদ্ধতি) ৫। সসীম সেট, অসীম সেট, ফাঁকা সেট, উপসেট, সমান সেট, প্রকৃত উপসেট,  সেটের সেট', '#', NULL),
(3, '67', 'CHAP241753440D', 'প্রাত্যহিক জীবনে সেট: ক্লাস -০২', '১। শক্তি সেট ২। সেটের উপাদান সংখ্যা ৩। সেট প্রক্রিয়াকিরণ ৪। সংযোগ সেট, ছেদ সেট, অন্তর সেট', '#', NULL),
(4, '67', 'CHAP24189244F8', 'প্রাত্যহিক জীবনে সেট: ক্লাস -০৩', 'পূরক সেট, নিশ্ছেদ সেট, ভেনচিত্র, বাস্তব সমস‌্যায় ভেনচিত্র, সেটের কার্তেসীয় গুণজ ও সমস‌্যার সমাধান', '#', NULL),
(5, '65', 'CHAP241922B2A6', 'সপ্তাহ-০১: বেসিক ওয়েব ডেভেলপমেন্ট ও HTML5', 'VS Code Setup for HTML | Structural Tags | Text Formatting | List | Link | Image and Multimedia | Table | Form | Scripting | Special Purpose Tags | Advance web page structure', 'https://www.youtube.com/embed/O9tT9nvR2fQ', '  null23'),
(6, '65', 'CHAP2419296F36', 'সপ্তাহ-০২: বেসিক ওয়েব ডেভেলপমেন্ট ও HTML5', 'VS Code Setup for HTML | Structural Tags | Text Formatting | List | Link | Image and Multimedia | Table | Form | Semantic Tags | Scripting | Interactive Element | Special Purpose Tags | Advance web page structure | Meta | SEO Meta | HTTP-Equiv Meta | Open Graph | Twitter Card | Mobile Device Meta |', 'https://youtu.be/3ukDL0rctJs', NULL),
(7, '65', 'CHAP24192CF3FF', 'সপ্তাহ-০৩: বেসিক CSS', 'CSS Introduction | How to add CSS | Basic Syntax | Selector | Background properties | Border Properties | Border Radius Display Property | Cursor Property | Float Property | CSS Fonts | Important | Line Height | Margin | Padding | Filter | Overflow | Position | Word Wrap | Justify content | Text Dec', 'https://youtu.be/xHFVppFw9rc', NULL),
(8, '67', 'CHAP24233DEE0B', 'অনুক্রম ও ধারাঃ ক্লাস-০৪', 'সমান্তর অনুক্রম, সমান্তর অনুক্রমের সাধারণ পদ নির্ণয়, গুণোত্তর অনুক্রম, গুণোত্তর অনুক্রমের সাধারণ পদ নির্ণয়, ফিবোনাচ্চি ক্রম, সমান্তর ধারা', '#', '593c8287_2d60_5399b572.pdf'),
(9, '67', 'CHAP242336285F', 'অনুক্রম ও ধারাঃ ক্লাস-০৫', 'সমান্তর ধারার সমষ্টি, গুণোত্তর ধারা, গুণোত্তর ধারার প্রথম n সংখ‌্যক পদের সমষ্টি, অসীম গুণোত্তর ধারার সমষ্টি', '#', NULL),
(10, '67', 'CHAP24233B0750', 'অনুক্রম ও ধারাঃ ক্লাস-০৬', 'সমস‌্যা ও সমাধান', '#', NULL),
(11, '67', 'CHAP24233A67CA', 'লগারিদমের ধারণা ও প্রয়োগঃ ক্লাস-০৭', 'সূচক ও লগারিদমের সাধারণ আলোচনা, প্রকারভেদ, স্বাভাবিক ও সাধারন লগারিদম, সূত্রাবলি, সূচক ও লগারিদমের বৈশিষ্ট‌্য', '#', NULL),
(12, '67', 'CHAP24233D302D', 'লগারিদমের ধারণা ও প্রয়োগঃ ক্লাস-০৮', 'লগারিদমের ব‌্যবহারিক প্রয়োগ, সমস‌্যা ও সমাধান', '#', NULL),
(13, '67', 'CHAP2423378D2E', 'প্রকৃতি ও প্রযুক্তিতে বহুপদী রাশিঃ ক্লাস-০৯', 'বাস্তব সমস‌্যা থেকে বহুপদী রাশির গঠন, বহুপদী রাশি, এক চলকবিশিষ্ট বহুপদী রাশি, দ্বিমাত্রিক স্থানাঙ্ক জ‌্যামিতি, প্রকৃতি ও প্রযুক্তিতে একঘাত বহুপদী রাশি, প্রকৃতি ও প্রযুক্তিতে দ্বিঘাত বহুপদী রাশি, প্রকৃতি ও প্রযুক্তিতে ত্রিঘাত বহুপদী রাশি', '#', NULL),
(14, '67', 'CHAP24233F3073', 'প্রকৃতি ও প্রযুক্তিতে বহুপদী রাশিঃ ক্লাস-১০', 'দুই চলকবিশিষ্ট বহুপদী, তিন চলকবিশিষ্ট বহুপদী, বিশেষ বৈশিষ্টের বহুপদী রাশি, সমমাত্রিক বহুপদী, প্রতিসম বহুপদী, বহুপদী রাশির প্রক্রিয়া', '#', NULL),
(15, '67', 'CHAP24233F3073', 'প্রকৃতি ও প্রযুক্তিতে বহুপদী রাশিঃ ক্লাস-১১', 'ভাগ প্রক্রিয়ার সাধারণ বৈশিষ্ট‌্য, ভাগশেষ উপপাদ‌্য, উৎপাদকে বিশ্লেষণ, উৎপাদক উপপাদ‌্য, দ্বিঘাত রাশির উৎপাদকে বিশ্লেষণ, সাধারণ পদ্ধতিতে উৎপাদক, আংশিক ভগ্নাংশ', '#', NULL),
(16, '67', 'CHAP242332A4C4', 'বাস্তব সমস‌্যা সমাধানে সহসমীকরণঃ ১২', 'দুইটি সরল সহসমীকরণের সমাধান যোগ‌্যতা, জ‌্যামিতিক পর্যবেক্ষণ, বীজগাণিতিক পর্যবেক্ষণ, দুই চলকবিশিষ্ট সরল সহসমীকরণের সমাধান পদ্ধতি, লৈখিক পদ্ধতিতে সমাধান, প্রতিস্থাপন পদ্ধতিতে সমাধান', '#', NULL),
(17, '67', 'CHAP24233BE68C', 'বাস্তব সমস‌্যা সমাধানে সহসমীকরণঃ ১৩', 'অপনয়ন পদ্ধতিতে সমাধান, আড়গুণন পদ্ধতিতে সমাধান, দুই চলকের একঘাত ও দ্বিঘাত সহসমীকরন, এক চলকের দ্বিঘাত সমীকরণ সমাধান পদ্ধতি, মধ‌্যপদ বিস্তৃতির মাধ‌্যমে সমাধান, লেখচিত্রের সাহায‌্যে দ্বিঘাত সমীকরণের সমাধান, দুই চলকের একঘাত ও দ্বিঘাত সহসমীকরণের সমাধান, লেখচিত্রের মাধ‌্যমে সমাধান', '#', NULL),
(18, '67', 'CHAP24233468B2', 'পরিমাপে ত্রিকোণমিতিঃ ক্লাস-১৪', 'ত্রিকোণমিতির ধারণা, সমকোণী ত্রিভুজের বিভিন্ন বাহু ও কোণের পরিচিতি, সমকোণী ত্রিভুজের অতিভুজ ও সন্নিহিত বাহুর অন্তর্বর্তী কোণের সাপেক্ষে বিভিন্ন বাহুর অনুপাত, নির্দিষ্ট কোণের সাপেক্ষে বিভিন্ন অনুপাতের নামকরণ', '#', NULL),
(19, '67', 'CHAP24233E9A3B', 'পরিমাপে ত্রিকোণমিতিঃ ক্লাস-১৫', 'বিভিন্ন কোণের সাপেক্ষে ত্রিকোণমিতিক অনুপাতের মান, বিভিন্ন কোণের সাপেক্ষে ত্রিকোণমিতিক অনুপাত নির্ণয়ে ক‌্যালকুলেটরের ব‌্যবহার, উন্নতি ও অবনতি কোণ, ত্রিকোণমিতিক অনুপাত নির্ণয়ের প্রয়োজনীয়তা, দূরত্ব ও উচ্চতা বিষয়ক বাস্তব সমস‌্যা ও সমাধান', '#', '3d323466_21d7_e8d2b2a2.pdf'),
(20, '67', 'CHAP242347F4ED', 'পরিমাপে ত্রিকোণমিতিঃ ক্লাস-১৬', 'ত্রিকোণমিতিক কোণের পরিমাপ, জ‌্যামিতিক ও ত্রিকোণমিতিক কোণ, আদর্শ অবস্থানে বিভিন্ন চতুর্ভাগে ত্রিকোণমিতিক কোণ, কোণের আদর্শ অবস্থান ত্রিকোণমিতিক অনুপাত, কোয়াড্রেন্ট ও কোয়াড্রেন্টাল কোণের ত্রিকোণমিতিক অনুপাত', '#', NULL),
(21, '67', 'CHAP24234CCF34', 'পরিমাপে ত্রিকোণমিতিঃ ক্লাস-১৭', 'কোণের পার্থক‌্য অনুসারে ত্রিকোণমিতিক অনুপাতের আন্তঃসম্পর্ক, ত্রিকোণমিতিক ও স্থানাঙ্ক ‌জ‌্যামিতির আন্তঃসম্পর্ক, ত্রিকোণমিতিক কোণ এর রেডিয়ান পরিমাপ', '#', NULL),
(22, '67', 'CHAP242347009E', 'পরিমাপে ত্রিকোণমিতিঃ ক্লাস-১৮', 'বৃত্তচাপ ও বৃত্তকলার পরিমাপ, কোণক', '#', NULL),
(23, '67', 'CHAP242341420F', 'পরিমাপে ত্রিকোণমিতিঃ ক্লাস-১৯', 'গোলক, প্রিজম, সুষম বহুভুজের ক্ষেত্রফল', '#', NULL),
(24, '67', 'CHAP242341420F', 'পরিমাপে ত্রিকোণমিতিঃ ক্লাস-১৯', 'পিরামিড, সমস‌্যা ও সমাধান', '#', NULL),
(25, '67', 'CHAP2423486C19', 'বিস্তার পরিমাপঃ ক্লাস-২০', 'পরিসর, দৈনন্দিন জীবনে পরিসরের ব‌্যবহার, গড় ব‌্যবধান, বিন‌্যস্ত ও অবিন‌্যস্ত উপাত্তের গড় ব‌্যবধান নির্ণয়', '#', NULL),
(26, '67', 'CHAP24234FEE30', 'বিস্তার পরিমাপঃ ক্লাস-২১', 'পরিমিত ব‌্যবধান, ভেদাঙ্ক, সূত্রের মাধ‌্যমে ভেদাঙ্ক নির্ণয়, সূত্রের মাধ‌্যমে পরিমিত ব‌্যবধান নির্ণয়', '#', NULL),
(46, '66', 'CHAP242566A710', 'Class-01', 'Introduction to Programming with Java', 'Keywords, Variables, Operators -1. Arithmatic Operator 2.Relational Operator 3.Logical Operator, Java Input taking and Output Printing,  String in java', ''),
(47, '66', 'CHAP24256023E7', 'Class-02', ' Java Control Statements', 'There are Decision Making Statements', ''),
(48, '66', 'CHAP24256023E7', 'Class-02', 'Decision Making Statements', 'if statements & swtich statements', ''),
(49, '66', 'CHAP24256023E7', 'Class-02', 'Loop Staetments', 'for loop -- while loop -- do-while loop -- for each loop ', ''),
(50, '66', 'CHAP24256023E7', 'Class-02', 'Jump Statements', ' break statements -- continue statements', ''),
(51, '66', 'CHAP24256023E7', 'Class-02', 'Decision Making Statments: -- Practical ', 'Show your Biodata -- Print the biggest Number-- Swap two numbers -- Exercise -- Even or odd verifier -- Vowel or not', ''),
(52, '66', 'CHAP24256423A9', 'Class-03', ' Loop Statements', '1) For Loop 2)While Loop ', ''),
(53, '66', 'CHAP24256423A9', 'Class-03', 'Practice', '1) Sum of series  2)Lower case to upper case  3)Combination of Decision Making and Loop  4)Sum of Even numbers 5) Sum of Odd numbers  6) Remove white space from string', ''),
(54, '66', 'CHAP24258E6F9B', 'Class-04', 'Nested Decision Making Statements', '1. Nested Looping  2. Array In Java 3. Method In Java 4.For each Loop ', ''),
(55, '66', 'CHAP24258A5DC4', 'Class-05', 'comming soon....', 'comming soon....', ''),
(56, '66', 'CHAP2425834123', 'Class-06', 'comming soon....', 'comming soon....', ''),
(57, '66', 'CHAP24258483C2', 'Class-07', 'comming soon....', 'comming soon....', ''),
(58, '66', 'CHAP2425888D42', 'Class-08', 'comming soon....', 'comming soon....', ''),
(59, '66', 'CHAP242587D0B3', 'Class-09', 'comming soon....', 'comming soon....', ''),
(60, '66', 'CHAP2425888084', 'Class-10', 'comming soon....', 'comming soon....', ''),
(61, '66', 'CHAP24258E9720', 'Class-11', 'comming soon....', 'comming soon....', ''),
(62, '66', 'CHAP24258AA241', 'Class-12', 'comming soon....', 'comming soon....', ''),
(63, '66', 'CHAP24258B6127', 'Class-13', 'comming soon....', 'comming soon....', ''),
(64, '66', 'CHAP2425828A6F', 'Class-14', 'comming soon....', 'comming soon....', ''),
(67, '65', 'CHAP2426154951', 'সপ্তাহ-০৪:  বেসিক CSS', 'VS Code Setup for HTML |  Structural Tags | Text Formatting | List | Link | Image and Multimedia | Table | Form | Semantic Tags | Scripting | Interactive Element | Special Purpose Tags | Advance web page structure | Meta | SEO Meta | HTTP-Equiv Meta | Open Graph | Twitter Card | Mobile Device Meta |', '#', ''),
(68, '65', 'CHAP24261D3A2B', 'সপ্তাহ-০৫: CSS Framword-Bootstraps', 'Introduction', '#', ''),
(69, '65', 'CHAP24261A47E0', 'সপ্তাহ-০৬: Responsice Web Design ', 'Introduction', '#', ''),
(71, '65', 'CHAP2426178075', 'সপ্তাহ ০৭ঃ ডাটাবেস My SQL', '#', '#', ''),
(72, '65', 'CHAP24261A8E59', 'সপ্তাহ ০৮ঃ Getting started with WordPress', 'Inroduction to WordPress', '#', '7345e92c_e1c8_a8bb89c4.pdf'),
(73, '65', 'CHAP24261A8E59', 'সপ্তাহ ০৮ঃ Getting started with WordPress', 'WordPress essentials: Domains and hosting', '#', 'fd7ae262_7e67_168629bc.pdf'),
(74, '65', 'CHAP24261A8E59', 'সপ্তাহ ০৮ঃ Getting started with WordPress', 'Choosing and installing a theme', '#', 'f84f1932_f7ec_2ed5e80b.pdf'),
(75, '65', 'CHAP24261A8E59', 'সপ্তাহ ০৮ঃ Getting started with WordPress', 'Choosing and installing a plugin', '#', 'b63fcf1f_2f9c_6c2bc6de.pdf'),
(76, '65', 'CHAP24261A8E59', 'সপ্তাহ ০৮ঃ Getting started with WordPress', 'Getting started with the WordPress dashboard', '#', 'ee496ec5_261a_4be5b3a2.pdf'),
(77, '65', 'CHAP242614FD4E', 'সপ্তাহ ০৮ঃ Familiarity with the WordPress Interface', 'Understanding the difference between WordPress posts and pages ', '#', '7bb628d6_f500_1a69111c.pdf'),
(78, '65', 'CHAP242614FD4E', 'সপ্তাহ ০৮ঃ Familiarity with the WordPress Interface', 'Using the Media Library ', '#', '89818e4b_3b2a_357872c6.pdf'),
(79, '65', 'CHAP242614FD4E', 'সপ্তাহ ০৮ঃ Familiarity with the WordPress Interface', 'Creating posts and pages with the WordPress Block Editor ', '#', '6b91cf5c_5795_d155d172.pdf'),
(80, '65', 'CHAP242614FD4E', 'সপ্তাহ ০৮ঃ Familiarity with the WordPress Interface', 'Basic WordPress settings ', '#', '87c91177_8b91_4b813b72.pdf'),
(81, '65', 'CHAP242614FD4E', 'সপ্তাহ ০৮ঃ Familiarity with the WordPress Interface', 'What is the difference between the Block Editor and Site Editor? ', '#', 'd9fef5c4_cd1d_751d1a82.pdf'),
(85, '65', 'CHAP242619169E', 'সপ্তাহ ০৯ঃ Site Editing', 'Intro to the Site Editor', '#', 'bf4038d0_7472_1ebabeda.pdf'),
(86, '65', 'CHAP242619169E', 'সপ্তাহ ০৯ঃ Site Editing', 'Using page templates ', '#', '342b2c4d_13b8_ff3c768b.pdf'),
(87, '65', 'CHAP242619169E', 'সপ্তাহ ০৯ঃ Site Editing', 'Using template parts', '#', '6ca3b9bd_9dc6_76b2298a.pdf'),
(88, '65', 'CHAP2426140480', 'সপ্তাহ-১০ঃ Content Creation', 'Setting up your pages, posts, site logo and navigation menu ', '#', 'fc74eda2_51b0_6cd2ce5b.pdf'),
(89, '65', 'CHAP2426140480', 'সপ্তাহ-১০ঃ Content Creation', 'Creating and customizing a header and footer ', '#', '31a75568_66a8_347b9b0e.pdf'),
(90, '65', 'CHAP2426140480', 'সপ্তাহ-১০ঃ Content Creation', 'Nesting and using blocks to create visually appealing content ', '#', '9bca127b_1fd6_a239a1b4.pdf'),
(91, '65', 'CHAP2426140480', 'সপ্তাহ-১০ঃ Content Creation', 'Using block patterns', '#', 'b87b28fd_1818_8af87805.pdf'),
(92, '65', 'CHAP2426140480', 'সপ্তাহ-১০ঃ Content Creation', 'Embedding media and third-party content on your website ', '#', 'd51ed82c_8931_7b7ec7b7.pdf'),
(93, '65', 'CHAP24261588C6', 'সপ্তাহ-১১ঃ Security, Spam and Backups', '7 Tips to improve website security', '#', '2ba55ca0_f5a0_56f2b44e.pdf'),
(94, '65', 'CHAP24261588C6', 'সপ্তাহ-১১ঃ Security, Spam and Backups', 'Managing spam on your site ', '#', 'fd4d8942_01c9_65b6417e.pdf'),
(95, '65', 'CHAP24261588C6', 'সপ্তাহ-১১ঃ Security, Spam and Backups', 'How to backup your site', '#', '57560af3_e4ad_e46d9f44.pdf'),
(96, '65', 'CHAP242618B0FC', 'ক্লাস-১২ : SEO', 'How to improve SEO rankings', '#', '32ddb8a7_b550_cadb66b2.pdf'),
(97, '65', 'CHAP242618B0FC', 'ক্লাস-১২ : SEO', 'How to use headings for accessibility and SEO ', '#', '947e896b_3d3a_e801359c.pdf'),
(98, '69', 'CHAP252865124', 'সপ্তাহ-০১ঃ আরবী হরফ বা বর্ণের পরিচয়', '#', '#', ''),
(99, '69', 'CHAP252802070', 'সপ্তাহ-০২ঃ নক্তাযুক্ত হরফ, নক্তাবিহীন হরফ শিখি', '#', '#', ''),
(100, '69', 'CHAP25281E793', 'সপ্তাহ-০৩ঃ আরবী যুক্তাক্ষরের পরিচিতি', '#', '#', ''),
(101, '69', 'CHAP2528A6377', 'সপ্তাহ-০৪ঃ হরকত শিক্ষা', '#', '#', ''),
(110, '69', 'CHAP252813345', 'সপ্তাহ-০৫ঃ খাড়া যবর, খাড়া যের ও ঊল্টো পেশ শিখি', '#', '#', ''),
(111, '69', 'CHAP25283C5B8', 'সপ্তাহ ০৬ঃ সাকীন মদ পরিচিতি', '#', '#', ''),
(112, '69', 'CHAP2528E61B6', 'সপ্তাহ ০৭ঃ পাঁচ ওয়াক্ত নামায পরিচিতি', '#', '#', ''),
(113, '69', 'CHAP2528434AE', 'সপ্তাহ ০৮ঃ আয়াতুল কুরসি মুখস্থকরণ', '#', '#', ''),
(114, '69', 'CHAP252818D78', 'সপ্তাহ ০৯ঃ সুরা বাকারার শেষ ৩ আয়াত মুখস্থ শিখি', '#', '#', ''),
(115, '69', 'CHAP252840FDD', 'সপ্তাহ ১০ঃ সূরা হাশরের শেষ ৩ আয়াত মুখস্থ শিখি', '#', '#', ''),
(116, '69', 'CHAP2528DE83B', 'মডেল টেস্ট -০১', '#', '#', ''),
(117, '69', 'CHAP2528E35D8', 'মডেল টেস্ট -০২', '#', '#', ''),
(118, '71', 'CHAP2595FBD97', 'ক্লাস-০১ঃ সেট ও ফাংশন', 'সেট / সেট প্রকাশের পদ্ধতি/ সসীম সেট/ অসীম সেট/ ফাঁকা সেট/ ভেনচিত্র/ উপসেট/ প্রকৃত সেট/ পূরক সেট/ সার্বিক সেট/ সংযোগ সেট/ ছেদ সেট/ নিশ্চেদ ছেদ/ ডোমেন ও রেঞ্জ ', '#', ''),
(125, '71', 'CHAP25957B3B2', 'ক্লাস-২ঃ বীজগাণিতিক রাশি / অনুশীলনী ৩.১', 'বর্গ সম্বলিত সমস্যা (অনুশীলনী ৩.১)', '#', ''),
(129, '71', 'CHAP25954878D', 'ক্লাস-০৩ঃ বীজগাণিতিক রাশি / অনুশীলনী ৩.২', ' ঘন সম্বলিত সমস্যা', '#', ''),
(130, '71', 'CHAP25957885A', 'ক্লাস-০৪ঃ বীজগাণিতিক রাশি / অনুশীলনী ৩.৩', 'উৎপাদকে বিশ্লেষণ, ভাগশেষ ঊপপাদ্য ', '#', ''),
(131, '71', 'CHAP2595CD602', 'ক্লাস-০৫ঃ বীজগাণিতিক রাশি / অনুশীলনী ৩.৪', 'বাস্তব সমস্যা সমাধানে বীজগণিতিক সূত্র গঠন ও প্রয়োগ', '#', ''),
(132, '74', 'CHAP26261D052', 'Introduction', 'What is fundamental of computer, Binary, RAM and ROM ', 'https://www.youtube.com/embed/-SFrCZ2yY5Y', ''),
(133, '74', 'CHAP262660756', 'Test chapter', 'Election 2026', 'https://www.youtube.com/embed/zqJHo3uwZ90', ''),
(134, '75', 'CHAP26350BAB8', 'বাংলাদেশ বিষয়ে প্রশ্ন', '#', '#', '');

-- --------------------------------------------------------

--
-- Table structure for table `course_feedback`
--

CREATE TABLE `course_feedback` (
  `feedback_id` bigint NOT NULL,
  `teacher_course_id` varchar(50) NOT NULL,
  `course_id` varchar(50) NOT NULL,
  `feedback_rating` varchar(50) NOT NULL,
  `feedback` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `student_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_feedback`
--

INSERT INTO `course_feedback` (`feedback_id`, `teacher_course_id`, `course_id`, `feedback_rating`, `feedback`, `student_id`, `student_name`) VALUES
(1, 'TEA241625C317', '67', '5', 'আমার স্কুলিং টাইমের সাথে যাত্রা শুরু ১ বছর ধরে ২০২৪ থেকে , এখনো আমি যুক্ত আছি এবং বার্ষিক পরিক্ষায় ভাল রেজাল্টের পেছনে আরিফ স্যারের অবদান অনেক বেশি। এখনো আমি আমার গণিতের জন্য এই অনলাইন ক্লাসের উপর নির', 'STD2423157E03', 'Nafisa Tabassom'),
(2, 'TEA2416113B98', '65', '1', 'gdfgfd', 'STD2423157E03', 'Nafisa Tabassom');

-- --------------------------------------------------------

--
-- Table structure for table `course_include`
--

CREATE TABLE `course_include` (
  `course_include_id` bigint NOT NULL,
  `course_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_duration` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `live_class` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_exam` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_model_test` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_time` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_include`
--

INSERT INTO `course_include` (`course_include_id`, `course_id`, `course_duration`, `live_class`, `course_exam`, `course_model_test`, `class_time`) VALUES
(11, '65', 'কোর্সের মেয়াদ ৩ মাস', 'সরাসরি ক্লাস ১২ টি', 'পরীক্ষা ১০ টির অধিক', 'লাইভ প্রজেক্ট ৩ টি', 'প্রতি ক্লাস ২ ঘন্টা করে'),
(12, '67', 'কোর্সের মেয়াদ ৩ মাস', 'লাইভ ক্লাস ২০ টি', 'পরীক্ষা ১০ টি', 'মডেল টেস্ট ৩ টি', 'প্রতি ক্লাস ১ঃ৩০ মিনিট'),
(13, '66', 'কোর্সের মেয়াদ ০২ মাস', '১৬ টি লাইভ ক্লাস', '১০টির অধিক প্র্যাক্টিস প্রবলেম ও সলুশন', '১টি মডেল টেস্ট', 'প্রতি ক্লাস ০২ ঘন্টা'),
(14, '69', 'মেয়াদ ২ মাস', 'লাইভ অনলাইন ক্লাস ১৬ টি', 'পরীক্ষা ৩ টি', 'মডেল টেস্ট ২ টি', 'প্রতি ক্লাস ১.:৩০ মিনিট'),
(15, '71', 'কোর্সের মেয়াদ ৩ মাস', 'লাইভ ক্লাস ২০ টি', 'পরীক্ষা ১০ টি', 'মডেল টেস্ট ৩ টি', 'প্রতি ক্লাস ১ঃ৩০ মিনিট'),
(16, '75', '১ বছর', 'অনলাইন পরিক্ষা', '৫০ টি এমসিকিঊ পরিক্ষা', '১০ টা', '১ ঘন্টা করে');

-- --------------------------------------------------------

--
-- Table structure for table `course_section`
--

CREATE TABLE `course_section` (
  `course_section_id` bigint NOT NULL,
  `course_section_name` varchar(100) NOT NULL,
  `course_section_name_bangla` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_section`
--

INSERT INTO `course_section` (`course_section_id`, `course_section_name`, `course_section_name_bangla`) VALUES
(1, 'Academic_Course', 'একাডেমিক কোর্স'),
(2, 'Skill_Development', 'স্কিল ডেভেলপমেণ্ট'),
(3, 'Exam_Course', 'পরীক্ষা কোর্স');

-- --------------------------------------------------------

--
-- Table structure for table `course_type`
--

CREATE TABLE `course_type` (
  `course_type_id` bigint NOT NULL,
  `course_type_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_type_name_bangla` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_type`
--

INSERT INTO `course_type` (`course_type_id`, `course_type_name`, `course_type_name_bangla`) VALUES
(1, 'Online_Video_Course', 'অনলাইন ভিডিও কোর্স'),
(2, 'Online_Live_Coaching', 'অনলাইন লাইভ কোচিং'),
(3, 'Share_Your_Notes', 'শেয়ার নোট'),
(4, 'Question_And_Exam', 'পরীক্ষা কোর্স');

-- --------------------------------------------------------

--
-- Table structure for table `exam_setup`
--

CREATE TABLE `exam_setup` (
  `id` bigint NOT NULL,
  `exam_setup_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_teacher_id` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam_subject_course_id` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_chapter_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exam_duration` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_question` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marks_per_right_answer` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marks_per_wrong_answer` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_setup`
--

INSERT INTO `exam_setup` (`id`, `exam_setup_id`, `course_teacher_id`, `exam_name`, `exam_subject_course_id`, `subject_chapter_id`, `exam_duration`, `total_question`, `marks_per_right_answer`, `marks_per_wrong_answer`) VALUES
(4, 'EXAM-2430227AB6', 'TEA241625C317', 'মডেল টেস্ট-01', '67', 'CHAP24233B0750', '20', '10', '1', '0'),
(5, 'EXAM-24312510E2', 'TEA241625C317', 'Math Model Test - 02', '67', 'CHAP24233A67CA', '25', '20', '1', '0'),
(6, 'EXAM-250756543D', 'TEA241625C317', 'সেট ও ফাংশন ০১', '71', 'others', '20', '20', '1', '0'),
(7, 'EXAM-250968090B', 'TEA241625C317', 'বীজগাণিতিক রাশি / অনুশীলনী ৩.১ / মডেল টেস্ট', '71', 'CHAP25957B3B2', '15', '20', '1', '0'),
(40, 'EXAM-25335D8B66', 'TEA2416113B98', 'HTMl Basic Test', '65', 'CHAP241922B2A6', '10', '10', '1', '0'),
(41, 'EXAM-25363D924B', 'TEA2416113B98', 'physics 1st chapter', '73', 'Model-Test_or_Full-Course_Exam', '10', '10', '1', '0'),
(42, 'EXAM-26006F9083', 'TEA2416113B98', 'Basic website design course', '65', 'Model-Test_or_Full-Course_Exam', '10', '5', '1', '0'),
(43, 'EXAM-26006E3771', 'TEA2416113B98', 'Laravel Test', '65', 'Model-Test_or_Full-Course_Exam', '10', '1', '1', '0'),
(44, 'EXAM-2603680136', 'TEA253620D708', 'model test mcq', '75', 'CHAP26350BAB8', '10', '10', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `exam_start_process`
--

CREATE TABLE `exam_start_process` (
  `id` bigint NOT NULL,
  `unique_test_id` varchar(256) NOT NULL,
  `student_id` varchar(80) NOT NULL,
  `exam_setup_id` varchar(50) NOT NULL,
  `question_set_id` varchar(50) NOT NULL,
  `exam_start_at` varchar(80) NOT NULL,
  `exam_duration` varchar(50) NOT NULL,
  `exam_end_at` varchar(50) NOT NULL,
  `status` enum('0','1','') NOT NULL DEFAULT '0' COMMENT '0 = Progress,\\r\\n1 = Completed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_start_process`
--

INSERT INTO `exam_start_process` (`id`, `unique_test_id`, `student_id`, `exam_setup_id`, `question_set_id`, `exam_start_at`, `exam_duration`, `exam_end_at`, `status`) VALUES
(49, 'f091e02c86b25cd-975645b0a0208d4-335075748b0e471-df5914d18895f7e-a67d', 'STD2424950D5F', 'EXAM-250756543D', 'QSet-001', '03:02:52 PM', '20', '03:22:52 PM', '1'),
(50, 'a58cccea3da286c-c0c8d2c13bb0aa3-ecb0ced76c3603f-53afb6a38a3b1d9-6e63', 'STD2424950D5F', 'EXAM-2430227AB6', 'QSet-001', '03:04:09 PM', '20', '03:24:09 PM', '1'),
(51, '455811096c4b0d6-2f87b554633cdb7-cbce06065576183-d4eff5ff678aea1-eae0', 'STD2423157E03', 'EXAM-2603680136', 'QSet-001', '12:32:45 PM', '10', '12:42:45 PM', '1'),
(52, '69c9cc56b254812-f2e9889cb3ff6d8-10dcbf87324afb9-c893d4b668e076d-79d7', 'STD2423157E03', 'EXAM-250756543D', 'QSet-001', '12:34:58 PM', '20', '12:54:58 PM', '1');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_course`
--

CREATE TABLE `purchase_course` (
  `purchase_id` bigint NOT NULL,
  `purchase_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `course_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_id` int NOT NULL,
  `student_or_buyer_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_teacher_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_price` decimal(10,2) NOT NULL,
  `company_commission_percent` int NOT NULL,
  `company_amount` decimal(10,2) NOT NULL,
  `saler_or_teacher_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_course`
--

INSERT INTO `purchase_course` (`purchase_id`, `purchase_date`, `course_id`, `batch_id`, `student_or_buyer_id`, `course_teacher_id`, `course_price`, `company_commission_percent`, `company_amount`, `saler_or_teacher_amount`) VALUES
(45, '2024-10-28 09:47:59', '67', 1, 'STD2423157E03', 'TEA241625C317', 1000.00, 20, 200.00, 800.00),
(46, '2024-10-28 09:50:15', '67', 1, 'STD2424950D5F', 'TEA241625C317', 1000.00, 20, 200.00, 800.00),
(47, '2025-02-18 09:43:41', '65', 208, 'STD25049638B8', 'TEA2416113B98', 1000.00, 20, 200.00, 800.00),
(48, '2025-03-13 04:51:25', '71', 212, 'STD2423157E03', 'TEA241625C317', 1000.00, 20, 200.00, 800.00),
(49, '2025-03-23 08:23:07', '71', 212, 'STD2424950D5F', 'TEA241625C317', 1000.00, 20, 200.00, 800.00),
(50, '2025-08-11 08:52:02', '65', 208, 'STD243032103F', 'TEA2416113B98', 1000.00, 20, 200.00, 800.00),
(51, '2025-12-01 11:48:31', '65', 208, 'STD2423157E03', 'TEA2416113B98', 1000.00, 20, 200.00, 800.00),
(52, '2025-12-10 10:07:03', '65', 208, 'STD25344B7F3D', 'TEA2416113B98', 1000.00, 20, 200.00, 800.00),
(54, '2025-12-10 15:43:18', '67', 1, 'STD25344B7F3D', 'TEA241625C317', 1000.00, 20, 200.00, 800.00),
(55, '2025-12-10 15:43:38', '67', 1, 'STD25344B7F3D', 'TEA241625C317', 1000.00, 20, 200.00, 800.00),
(56, '2025-12-10 15:44:44', '67', 1, 'STD25344B7F3D', 'TEA241625C317', 1000.00, 20, 200.00, 800.00),
(57, '2025-12-28 12:57:51', '65', 208, 'STD25362071C5', 'TEA2416113B98', 1000.00, 20, 200.00, 800.00),
(58, '2026-01-27 16:00:34', '71', 212, 'STD2602227A23', 'TEA241625C317', 1000.00, 20, 200.00, 800.00),
(59, '2026-01-28 11:18:12', '65', 208, 'STD26022127D2', 'TEA2416113B98', 1000.00, 20, 200.00, 800.00),
(60, '2026-01-28 15:12:13', '65', 1438, 'STD2423157E03', 'TEA2416113B98', 1000.00, 20, 200.00, 800.00),
(61, '2026-02-05 12:32:23', '75', 1439, 'STD2423157E03', 'TEA253620D708', 250.00, 20, 50.00, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `question_answer`
--

CREATE TABLE `question_answer` (
  `id` bigint NOT NULL,
  `question_id` varchar(80) NOT NULL,
  `subject_id` varchar(80) NOT NULL,
  `your_answer_id` varchar(80) NOT NULL,
  `user_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_answer`
--

INSERT INTO `question_answer` (`id`, `question_id`, `subject_id`, `your_answer_id`, `user_id`) VALUES
(227, '220', 'EXAM-2603680136', '220-ANS0237D36', 'STD2423157E03'),
(228, '221', 'EXAM-2603680136', '221-ANS0237D15', 'STD2423157E03'),
(229, '37', 'EXAM-250756543D', '37-ANS03769D2', 'STD2423157E03'),
(230, '38', 'EXAM-250756543D', '38-ANS0376F9D', 'STD2423157E03'),
(231, '39', 'EXAM-250756543D', '39-ANS0376340', 'STD2423157E03'),
(232, '40', 'EXAM-250756543D', '40-ANS03760E3', 'STD2423157E03'),
(233, '41', 'EXAM-250756543D', '41-ANS0376BC4', 'STD2423157E03'),
(234, '42', 'EXAM-250756543D', '', 'STD2423157E03'),
(235, '43', 'EXAM-250756543D', '', 'STD2423157E03'),
(236, '44', 'EXAM-250756543D', '', 'STD2423157E03'),
(237, '45', 'EXAM-250756543D', '', 'STD2423157E03'),
(238, '46', 'EXAM-250756543D', '', 'STD2423157E03'),
(239, '47', 'EXAM-250756543D', '', 'STD2423157E03'),
(240, '48', 'EXAM-250756543D', '', 'STD2423157E03'),
(241, '49', 'EXAM-250756543D', '', 'STD2423157E03'),
(242, '50', 'EXAM-250756543D', '', 'STD2423157E03'),
(243, '51', 'EXAM-250756543D', '', 'STD2423157E03'),
(244, '52', 'EXAM-250756543D', '', 'STD2423157E03'),
(245, '53', 'EXAM-250756543D', '', 'STD2423157E03'),
(246, '54', 'EXAM-250756543D', '', 'STD2423157E03'),
(247, '55', 'EXAM-250756543D', '', 'STD2423157E03'),
(248, '56', 'EXAM-250756543D', '', 'STD2423157E03');

-- --------------------------------------------------------

--
-- Table structure for table `question_bank`
--

CREATE TABLE `question_bank` (
  `id` bigint NOT NULL,
  `subject_id` varchar(50) NOT NULL,
  `question_title` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_bank`
--

INSERT INTO `question_bank` (`id`, `subject_id`, `question_title`) VALUES
(7, 'EXAM-2430227AB6', '5+8+11+14+... ... ...+62 ধারাটি'),
(8, 'EXAM-2430227AB6', '175-175+175-175+... ... ... ধারাটির ১ম ১০০টি পদের মান'),
(9, 'EXAM-2430227AB6', '2+4+8+16+... ... .. ধারাটির ১০ম পদ কত?'),
(10, 'EXAM-2430227AB6', '1-1+1-1+1-1+1-1+........ধারাটির (2ক+1) সংখ‌‌্যক পদের সমষ্টি কত?'),
(11, 'EXAM-2430227AB6', '2-2+2-2+2-2+2-2+........ধারাটির (2ক+2) সংখ‌‌্যক পদের সমষ্টি কত?'),
(12, 'EXAM-2430227AB6', '1+2+3+4+⋯+n এর ক্ষেত্রে কোনটি সঠিক?'),
(13, 'EXAM-2430227AB6', 'ধারা কত প্রকার?'),
(14, 'EXAM-2430227AB6', 'একটি ধারাকে প্রতিবার নির্দিষ্ট একটি সংখ্যা দিয়ে গুণ অথবা ভাগ করে নতুন রাশি তৈরী করলে তাকে কোন ধারা বলা হয়?'),
(15, 'EXAM-2430227AB6', '5+8+11 +14+ ........... এ ধারাটির কত তম পদ 320 ?'),
(16, 'EXAM-2430227AB6', '১ হতে ১০০ পর্যন্ত সংখ্যাসমুহের যোগফল কত?'),
(17, 'EXAM-24312510E2', 'কোনটি সঠিক নয় ?'),
(18, 'EXAM-24312510E2', 'log 5+ log (5x+1)=  log (x+5)+1 হলে ১০ ভিত্তিক লগের ক্ষেত্রে x এর মান  কত?'),
(19, 'EXAM-24312510E2', 'সাধারন লগারিদমের ভিত্তি কত?'),
(20, 'EXAM-24312510E2', 'log p – log q এর সাথে মিল আছে কোনটির?'),
(21, 'EXAM-24312510E2', 'log ১০ ভিত্তিক e এর মান কত?'),
(22, 'EXAM-24312510E2', 'log e ভিত্তিক ১০ এর মান কত?'),
(23, 'EXAM-24312510E2', '২ ভিত্তিক লগ x এর মান ৫ হলে, x এর মান কত? '),
(24, 'EXAM-24312510E2', '১০ ভিত্তিক log  ( 7 x − 5 ) = 2 হলে, x এর মান কত?'),
(25, 'EXAM-24312510E2', 'b ভিত্তিক log a x c ভিত্তিক log b x d ভিত্তিক log c হলে, কোনটি সঠিক?'),
(26, 'EXAM-24312510E2', 'b ভিত্তিক log a x c ভিত্তিক log b x a ভিত্তিক log c হলে, কোনটি সঠিক?'),
(27, 'EXAM-24312510E2', '5 ভিত্তিক log 25 এর মান কত?'),
(28, 'EXAM-24312510E2', '2 ভিত্তিক log(8) + log(4) = কত?'),
(29, 'EXAM-24312510E2', '(10 এর ঘাত x ) = 1000 হলে, x এর মান'),
(30, 'EXAM-24312510E2', '5 log 2+4 log 3+2 log 4 + log 5- 2 log 9 =?'),
(31, 'EXAM-24312510E2', 'যদি x>1এবং  a>1 হয়, তবে a ভিত্তিক log x'),
(32, 'EXAM-24312510E2', '√ 3 ​ ভিত্তিক log  27 = x হলে, x এর মান কত?'),
(33, 'EXAM-24312510E2', '5 ​ ভিত্তিক log  (0.04) = x হলে, x এর মান কত?'),
(34, 'EXAM-24312510E2', 'log  (3x+1) = 2 হলে, x এর মান কত?'),
(35, 'EXAM-24312510E2', '2+log(0.01)'),
(36, 'EXAM-24312510E2', 'কোনটি সঠিক?'),
(37, 'EXAM-250756543D', 'সেট সম্পর্কে প্রথম ধারণা প্রবর্তন করেন কে?'),
(38, 'EXAM-250756543D', 'সেটের ব‌্যাপ্তি কত?'),
(39, 'EXAM-250756543D', 'A = {a, b, c} হলে, কোনটি সঠিক নয়?'),
(40, 'EXAM-250756543D', 'A = {x:x, 7 এর গুণিতক এবং 0 < x≤ 28} , A সেটটির তালিকা পদ্ধতিতে প্রকাশ কোনটি?'),
(41, 'EXAM-250756543D', 'সেট প্রকাশের পদ্ধতি কয়টি?'),
(42, 'EXAM-250756543D', 'C={1,2,3,4}'),
(43, 'EXAM-250756543D', 'কোনটি সসীম সেট?'),
(44, 'EXAM-250756543D', 'কোনটি ফাঁকা সেট নয়?'),
(45, 'EXAM-250756543D', 'ভেন ডায়াগ্রাম আবিষ্কার করেন কে?'),
(46, 'EXAM-250756543D', 'A = {n, f} এর উপসেট নয় কোনটি?'),
(47, 'EXAM-250756543D', 'A = {n, f} এর প্রকৃত উপসেট নয় কোনটি?'),
(48, 'EXAM-250756543D', 'P={x,y,z} হলে, এর প্রকৃত উপসেট কয়টি?'),
(49, 'EXAM-250756543D', 'A, B সেটের সমতা বিধানে কোনটি প্রয়োজন?'),
(50, 'EXAM-250756543D', 'A={1,2,a} ও  B={5,a} হলে, A-B এর সঠিক উত্তর কোনটি?'),
(51, 'EXAM-250756543D', 'কোনটি সার্বিক সেটের সাথে সামঞ্জস‌্য পূর্ণ নয়?'),
(52, 'EXAM-250756543D', 'A={1,2,a} ও  B={5,a} হলে কোনটি সঠিক?'),
(53, 'EXAM-250756543D', 'A= {} হলে, A এর শক্তি সেটের উপাদান কয়টি?'),
(54, 'EXAM-250756543D', 'কোনটি ক্রমজোড়?'),
(55, 'EXAM-250756543D', 'P={a}, Q={b,c}, PxQ=?'),
(56, 'EXAM-250756543D', '(2x+y,3)=(6,x-y) হলে, কোনটি সঠিক?'),
(57, 'EXAM-250968090B', 'বীজগাণিতিক রাশির ক্ষেত্রে কোন বিষয়সমূহ অত‌্যাবশ‌্যকীয়?'),
(58, 'EXAM-250968090B', 'পাটিগণিতের সর্বায়নকৃত রূপ হলো?'),
(59, 'EXAM-250968090B', 'ধ্রবক এর ক্ষেত্রে কোনটি সঠিক?'),
(60, 'EXAM-250968090B', 'কোনটি সঠিক নয়?'),
(61, 'EXAM-250968090B', '996 এর বর্গ ফল কত?'),
(62, 'EXAM-250968090B', 'বীজগণিতীয় প্রতীক দ্বারা প্রকাশিত যে কোন সাধারণ নিয়ম বা সিদ্ধান্তকে--'),
(63, 'EXAM-250968090B', 'x - y = 2 এবং xy= 24 হলে, (x+y) এর মান কত?'),
(64, 'EXAM-250968090B', '(x-a), f(x) এর একটি উৎপাদক হবে, '),
(65, 'EXAM-250968090B', 'একটি বইয়ের মূল‌্য 24 টাকা। এই মূল‌্য বই তৈরির ব‌্যয়ের 80% । বাকি মূল‌্য সরকার ভর্তুকি দেন।'),
(66, 'EXAM-250968090B', 'শতকরা বার্ষিক 7 টাকা হার সরল মুনাফায় 650 টাকার 6 বছরের মুনাফা কত?'),
(67, 'EXAM-250968090B', 'বার্ষিক শতকরা 6 টাকা হার চক্রবৃদ্ধি মুনাফায় 15000 টাকার 3 বছরের সবৃদ্ধিমূল কত?'),
(68, 'EXAM-250968090B', 'বার্ষিক শতকরা 6 টাকা হার চক্রবৃদ্ধি মুনাফায় 15000 টাকার 3 বছরের চক্রবৃদ্ধি মুল কত?'),
(69, 'EXAM-250968090B', 'x = 7+4√3 হলে √x = কত?'),
(70, 'EXAM-250968090B', '1007 এর বর্গের মান কত?'),
(71, 'EXAM-250968090B', '6.35x6.35+2x6.35x3.65+3.65x3.65'),
(72, 'EXAM-250968090B', 'a-b=4, ab=60 হলে ‍a+b এর মান কত?'),
(73, 'EXAM-250968090B', '∛x=√2 হলে x এর মান কত?'),
(74, 'EXAM-250968090B', '∛x=√5 হলে x এর মান কত?'),
(75, 'EXAM-250968090B', 'x+y=√7, xy=√1 হলে x-y এর মান কত?'),
(76, 'EXAM-250968090B', '(x÷y)+(y÷x)=1 হলে x-y এর মান কত?'),
(77, 'EXAM-250968090B', '(x÷y)+(y÷x)=-2 হলে x+y এর মান কত?'),
(78, 'EXAM-250968090B', '∛x+∛y=5, ∛x-∛y=3 হলে x+y এর মান কত?'),
(79, 'EXAM-250968090B', 'x=√7+√6 হলে x+(1/x) এর ঘন নির্ণয় করলে মান কত পাবে?'),
(80, 'EXAM-250968090B', '97 এর ঘন কত?'),
(81, 'EXAM-250968090B', 'x=-1, y=0 হলে (4x+5y) এর মান কত?'),
(211, 'EXAM-25335D8B66', 'What does HTML stand for?'),
(212, 'EXAM-25335D8B66', 'Which among the following is the correct way in HTML to insert an image?'),
(213, 'EXAM-25335D8B66', 'Which of the following elements can be used in HTML to create a table?'),
(214, 'EXAM-25335D8B66', 'Which tag is used to add an header in HTML5 table?'),
(215, 'EXAM-25335D8B66', 'Which tag is used for creating a drop-down selection list?'),
(216, 'EXAM-25363D924B', 'what is physics'),
(217, 'EXAM-26006F9083', 'What does HTML stand for?'),
(218, 'EXAM-26006F9083', 'Which tag is used to create a hyperlink in HTML?'),
(219, 'EXAM-26006E3771', 'what is laravel'),
(220, 'EXAM-2603680136', 'বাংলাদেশের রাজধানীর নাম কি?'),
(221, 'EXAM-2603680136', 'তোমার নাম কি?');

-- --------------------------------------------------------

--
-- Table structure for table `question_option`
--

CREATE TABLE `question_option` (
  `id` bigint NOT NULL,
  `question_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_answer_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_option` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_answer` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question_option`
--

INSERT INTO `question_option` (`id`, `question_id`, `question_answer_id`, `question_option`, `correct_answer`) VALUES
(16, '7', '7-ANS10303190', 'একটি সসীম ধারা', '1'),
(17, '7', '7-ANS10303A1F', 'একটি অসীম ধারা', '0'),
(18, '7', '7-ANS10303001', 'একটি গুণোত্তর ধারা', '0'),
(19, '7', '7-ANS10303D9C', 'কোনোটিই নয়', '0'),
(20, '8', '8-ANS10303D2D', '175', '0'),
(21, '8', '8-ANS10303D13', '0', '1'),
(22, '8', '8-ANS103033ED', '-175', '0'),
(23, '8', '8-ANS10303464', 'উপরের ক ও গ সঠিক', '0'),
(24, '9', '9-ANS1030353E', '2', '0'),
(25, '9', '9-ANS103032D5', '4', '0'),
(26, '9', '9-ANS10303886', '1024', '1'),
(27, '9', '9-ANS103039B2', '18', '0'),
(28, '10', '10-ANS10303D8E', '1', '1'),
(29, '10', '10-ANS1030331C', '2', '0'),
(30, '10', '10-ANS10303B68', '-1', '0'),
(31, '10', '10-ANS103030A4', '0', '0'),
(32, '11', '11-ANS10303FA9', '0', '1'),
(33, '11', '11-ANS10303143', '2', '0'),
(34, '11', '11-ANS10303D28', '-2', '0'),
(35, '11', '11-ANS10303C23', '1', '0'),
(36, '12', '12-ANS10303C38', '{n(n+1)}/2', '1'),
(37, '12', '12-ANS103039FE', 'n(n+1)', '0'),
(38, '12', '12-ANS1030363F', 'n(n+1)*2', '0'),
(39, '13', '13-ANS1030397C', '1', '0'),
(40, '13', '13-ANS1030368E', '2', '1'),
(41, '13', '13-ANS103032D6', '3', '0'),
(42, '13', '13-ANS10303CDD', '7', '0'),
(43, '14', '14-ANS10303B75', 'গুণোত্তর', '1'),
(44, '14', '14-ANS10303EEB', 'সমান্তর ধারা', '0'),
(45, '14', '14-ANS10303331', 'সাধারন ধারা', '0'),
(46, '14', '14-ANS103032A0', 'অসীম ধারা', '0'),
(47, '15', '15-ANS10303391', '১০৬ তম পদ', '1'),
(48, '15', '15-ANS10303CC8', '১০৮ তম পদ', '0'),
(49, '15', '15-ANS10303EE6', '৩২০ তম পদ', '0'),
(50, '15', '15-ANS103037EA', '২২ তম পদ', '0'),
(51, '16', '16-ANS10303846', '৫০৬০', '0'),
(52, '16', '16-ANS10303E1A', '৫৫০০', '0'),
(53, '16', '16-ANS103035E8', '৫০০৫', '0'),
(54, '16', '16-ANS10303671', '৫০৫০', '1'),
(55, '17', '17-ANS11313D32', 'log10 10 = 1', '0'),
(56, '17', '17-ANS11313609', 'log (2 + 3) = log (2 x 3)     ', '1'),
(57, '17', '17-ANS11313B93', 'log10 1 = 0', '0'),
(58, '17', '17-ANS113134FE', 'log (1 + 2 + 3) = log 1 + log 2 + log 3', '0'),
(59, '18', '18-ANS113132F6', '1', '0'),
(60, '18', '18-ANS11313FE2', '3', '1'),
(61, '18', '18-ANS11313060', '5', '0'),
(62, '18', '18-ANS11313FCA', '9', '0'),
(63, '19', '19-ANS113137D3', '1', '0'),
(64, '19', '19-ANS113134DA', '10', '1'),
(65, '19', '19-ANS11313EAE', '100', '0'),
(66, '19', '19-ANS11313FFD', '2', '0'),
(67, '20', '20-ANS113138D6', 'log (q/p)', '0'),
(68, '20', '20-ANS11313984', 'log (q-p)', '0'),
(69, '20', '20-ANS11313519', 'log (p÷q)', '1'),
(70, '20', '20-ANS11313729', 'log (q÷p)', '0'),
(71, '21', '21-ANS11313A44', '2.3026', '0'),
(72, '21', '21-ANS1131329E', '0.4343', '1'),
(73, '21', '21-ANS113132B2', 'দুটোই সঠিক', '0'),
(74, '21', '21-ANS11313815', 'কোনোটিই সঠিক নয়', '0'),
(75, '22', '22-ANS1131355B', '2.3026', '1'),
(76, '22', '22-ANS11313174', '0.4343', '0'),
(77, '22', '22-ANS1131324C', 'দুটোই সঠিক', '0'),
(78, '22', '22-ANS11313E2B', 'কোনোটিই সঠিক নয়', '0'),
(79, '23', '23-ANS11313D88', '25', '0'),
(80, '23', '23-ANS11313038', '৩২', '1'),
(81, '23', '23-ANS11313760', '১০', '0'),
(82, '23', '23-ANS11313602', '৫২', '0'),
(83, '24', '24-ANS11313CD0', '10', '0'),
(84, '24', '24-ANS11313000', '12', '0'),
(85, '24', '24-ANS11313FB4', '15', '1'),
(86, '24', '24-ANS1131326C', '18', '0'),
(87, '25', '25-ANS113132B4', 'a ভিত্তিক log a', '0'),
(88, '25', '25-ANS11313CBA', 'b ভিত্তিক log a', '0'),
(89, '25', '25-ANS113130C1', 'c ভিত্তিক log a', '0'),
(90, '25', '25-ANS11313B6D', 'd ভিত্তিক log a', '1'),
(91, '26', '26-ANS113138D5', '0', '0'),
(92, '26', '26-ANS11313F83', 'a', '0'),
(93, '26', '26-ANS113131CE', 'b', '0'),
(94, '26', '26-ANS113131AF', '1', '1'),
(95, '27', '27-ANS1131306D', '1', '0'),
(96, '27', '27-ANS113135BC', '2', '1'),
(97, '27', '27-ANS11313673', '25', '0'),
(98, '27', '27-ANS11313BFF', '5', '0'),
(99, '28', '28-ANS11313EEA', '1', '0'),
(100, '28', '28-ANS11313657', '2', '0'),
(101, '28', '28-ANS1131385E', '3', '0'),
(102, '28', '28-ANS11313C55', '5', '1'),
(103, '29', '29-ANS1131358E', '2', '0'),
(104, '29', '29-ANS11313973', '3', '1'),
(105, '29', '29-ANS11313931', '0', '0'),
(106, '29', '29-ANS11313884', 'অসীম', '0'),
(107, '30', '30-ANS1131392A', '2560', '0'),
(108, '30', '30-ANS11313756', 'log 2156     ', '0'),
(109, '30', '30-ANS113131A9', ' log 2560    ', '1'),
(110, '30', '30-ANS11313BCB', 'None of these', '0'),
(111, '31', '31-ANS11313B65', 'ধনাত্বক হবে', '1'),
(112, '31', '31-ANS11313544', 'ঋণাত্বক হবে', '0'),
(113, '31', '31-ANS11313E67', 'শুণ‌্য', '0'),
(114, '31', '31-ANS113137FF', 'কোনটিই নয়', '0'),
(115, '32', '32-ANS11313876', '3', '0'),
(116, '32', '32-ANS11313236', '4', '0'),
(117, '32', '32-ANS113136D5', '6', '1'),
(118, '32', '32-ANS11313276', '9', '0'),
(119, '33', '33-ANS11313A28', '2', '0'),
(120, '33', '33-ANS11313D12', '4', '0'),
(121, '33', '33-ANS11313119', '-4', '0'),
(122, '33', '33-ANS11313EFC', '-2', '1'),
(123, '34', '34-ANS11313B1C', '1/3', '0'),
(124, '34', '34-ANS11313C38', '99', '0'),
(125, '34', '34-ANS11313277', '33', '1'),
(126, '34', '34-ANS113132A4', '19/3', '0'),
(127, '35', '35-ANS11313B86', '4', '0'),
(128, '35', '35-ANS1131346D', '3', '0'),
(129, '35', '35-ANS113134B2', '1', '0'),
(130, '35', '35-ANS11313951', '0', '1'),
(131, '36', '36-ANS11313861', ' log (m + n) = log m + log n', '0'),
(132, '36', '36-ANS113133F0', 'log (m – n) = log m – log n', '0'),
(133, '36', '36-ANS11313C78', 'logb a x loga b =1', '1'),
(134, '36', '36-ANS11313291', 'None of these.', '0'),
(135, '37', '37-ANS03769D2', 'জর্জ ক‌্যান্টর', '1'),
(136, '37', '37-ANS0376F48', 'জন ভেন', '0'),
(137, '37', '37-ANS037652C', 'জর্জ ভেন', '0'),
(138, '37', '37-ANS0376D3B', 'জন ব‌্যান্টর', '0'),
(139, '38', '38-ANS0376009', 'বাস্তব জগত', '0'),
(140, '38', '38-ANS0376F9D', 'চিন্তা জগত', '0'),
(141, '38', '38-ANS0376E14', 'উভয়ই', '1'),
(142, '38', '38-ANS0376A64', 'কোনোটিই নয়', '0'),
(143, '39', '39-ANS0376CBA', 'a∈ A', '0'),
(144, '39', '39-ANS0376340', 'b ∉A', '1'),
(145, '39', '39-ANS0376105', 'A ∉c', '0'),
(146, '39', '39-ANS0376408', 'C∉A', '0'),
(147, '40', '40-ANS03768E4', '{35,40,21,28}', '0'),
(148, '40', '40-ANS0376E2E', '{35,42,56,63}', '0'),
(149, '40', '40-ANS03760E3', '{2,7,21,28}', '0'),
(150, '40', '40-ANS0376009', '{7,14,21,28}', '1'),
(151, '41', '41-ANS0376182', '1', '0'),
(152, '41', '41-ANS0376BC4', '2', '1'),
(153, '41', '41-ANS0376CF0', '3', '0'),
(154, '41', '41-ANS03766ED', '4', '0'),
(155, '42', '42-ANS03766DD', 'C = {x:x, 7 এর গুণিতক এবং 0 < x≤ 28}', '0'),
(156, '42', '42-ANS0376514', 'C = {x:x, ধনাত্বক পূর্ণ সংখ‌্যা}', '0'),
(157, '42', '42-ANS0376E13', 'C = {x:x, ধনাত্বক পূর্ণ সংখ‌্যা এবং x² < 18}', '1'),
(158, '42', '42-ANS0376D59', 'C = {x:x, ধনাত্বক পূর্ণ সংখ‌্যা এবং x² < 8}', '0'),
(159, '43', '43-ANS037652D', '{x:x, 7 এর গুণিতক এবং 0 < x≤ 28}', '1'),
(160, '43', '43-ANS037641E', '{x:x, বিজোড় স্বাভাবিক সংখ‌্যা}', '0'),
(161, '43', '43-ANS0376385', 'বাস্তব সংখ‌্যার সেট', '0'),
(162, '43', '43-ANS0376EE0', 'স্বাভাবিক সংখ‌্যার সেট', '0'),
(163, '44', '44-ANS0376F3B', '{x : 3 < x < 4, x পূর্ণ সংখ্যা}', '0'),
(164, '44', '44-ANS03765D3', '{φ}', '1'),
(165, '44', '44-ANS0376418', '{}', '0'),
(166, '44', '44-ANS0376F45', 'φ', '0'),
(167, '45', '45-ANS0376251', 'জর্জ ক‌্যান্টর', '0'),
(168, '45', '45-ANS0376A48', 'জর্জ ভেন', '0'),
(169, '45', '45-ANS0376370', 'জন ভেন', '1'),
(170, '45', '45-ANS0376811', 'জন ব‌্যান্টর', '0'),
(171, '46', '46-ANS0376DEE', '{f, n}', '0'),
(172, '46', '46-ANS037674F', 'φ', '0'),
(173, '46', '46-ANS0376F03', '{n, f}', '0'),
(174, '46', '46-ANS0376BD2', '{n, f, φ}', '1'),
(175, '47', '47-ANS0376E8F', '{n, f}', '1'),
(176, '47', '47-ANS03765D1', 'φ', '0'),
(177, '47', '47-ANS03767DC', '{n}', '0'),
(178, '47', '47-ANS0376026', '{f}', '0'),
(179, '48', '48-ANS037637B', '7', '1'),
(180, '48', '48-ANS037697E', '6', '0'),
(181, '48', '48-ANS0376FC5', '8', '0'),
(182, '48', '48-ANS0376423', '5', '0'),
(183, '49', '49-ANS0376B7D', 'A ⊆ B', '0'),
(184, '49', '49-ANS0376767', 'B ⊆ A', '0'),
(185, '49', '49-ANS0376D18', 'একটিও না', '1'),
(186, '49', '49-ANS03766B3', 'ক, খ উভয়টিই', '1'),
(187, '50', '50-ANS0376DA9', '{ }', '0'),
(188, '50', '50-ANS0376319', '{1,2}', '1'),
(189, '50', '50-ANS03765C3', '{a}', '0'),
(190, '50', '50-ANS03766E0', '{5,a}', '0'),
(191, '51', '51-ANS0376B6B', 'A', '1'),
(192, '51', '51-ANS0376AC2', 'U-A', '0'),
(193, '51', '51-ANS0376506', 'U\\A', '0'),
(194, '51', '51-ANS0376366', 'U’', '0'),
(195, '52', '52-ANS0376CC0', 'A ∩ B={ }', '0'),
(196, '52', '52-ANS0376929', 'A ∪ B ={1,2,5}', '0'),
(197, '52', '52-ANS03764C2', 'A ∩ B={a}', '1'),
(198, '52', '52-ANS03766E4', 'A ∪ B={5}', '0'),
(199, '53', '53-ANS0376F4E', '0', '0'),
(200, '53', '53-ANS0376B02', '1', '1'),
(201, '53', '53-ANS0376F7E', '2', '0'),
(202, '53', '53-ANS0376F81', '3', '0'),
(203, '54', '54-ANS0376FF4', '(Afia)', '0'),
(204, '54', '54-ANS037687B', '{afia, mafia}', '0'),
(205, '54', '54-ANS037638A', '(nabila, nafisa)', '1'),
(206, '54', '54-ANS0376054', '{naima}', '0'),
(207, '55', '55-ANS0376A7B', '{(a,b),(c,a)}', '0'),
(208, '55', '55-ANS0376FA7', '{(a,b),(a,c)}', '1'),
(209, '55', '55-ANS037650B', '{(a,b)}', '0'),
(210, '55', '55-ANS037634F', '(a,b),(a,c)', '0'),
(211, '56', '56-ANS0376DD7', '(2,2)', '0'),
(212, '56', '56-ANS0376F25', '(1,2)', '0'),
(213, '56', '56-ANS0376F79', '(3,0)', '1'),
(214, '56', '56-ANS037675E', '(0,3)', '0'),
(215, '57', '57-ANS04979E0', 'সংখ‌্যা নির্দেশক প্রতীক', '0'),
(216, '57', '57-ANS0497E40', 'প্রক্রিয়া চিহ্ন', '0'),
(217, '57', '57-ANS0497435', 'উভয়টিই', '1'),
(218, '57', '57-ANS0497F55', 'কোনোটিই নয়', '0'),
(219, '58', '58-ANS0497987', 'বীজগণিত', '1'),
(220, '58', '58-ANS0497908', 'জ‌্যামিতি', '0'),
(221, '58', '58-ANS0497C1A', 'পরিমিতি', '0'),
(222, '58', '58-ANS0497107', 'সাধারণ গণিত', '0'),
(223, '58', '58-ANS04978C7', 'উচ্চতর গণিত', '0'),
(224, '59', '59-ANS0497D83', 'চিহ্ন দ্বারা প্রকাশিত হয় এবং মান পরিবর্তন হতে পারে', '0'),
(225, '59', '59-ANS04974BD', 'y = x^2', '0'),
(226, '59', '59-ANS0497997', 'পরিবর্তনীয়', '0'),
(227, '59', '59-ANS0497296', 'অপরিবর্তনীয়', '1'),
(228, '60', '60-ANS04979D2', 'দুইটি রাশির বর্গের বিয়োগফল = রাশি দুইটির যোগফল x রাশিদ্বয়ের বিয়োগফল', '0'),
(229, '60', '60-ANS0497AD9', 'রাশি দ্বয়ের বিয়োগফল = দুইটি রাশির বর্গের বিয়োগফল ÷ রাশি দুইটির যোগফল', '0'),
(230, '60', '60-ANS049711F', 'রাশি দ্বয়ের বিয়োগফল = দুইটি রাশির বর্গের বিয়োগফল x রাশি দুইটির যোগফল', '1'),
(231, '60', '60-ANS0497E05', 'দুইটি রাশির বর্গের বিয়োগফল = রাশি দুইটির যোগফল x রাশি দুটির বিয়োগফল', '0'),
(232, '61', '61-ANS0497218', '992015+1', '1'),
(233, '61', '61-ANS0497181', '992019', '0'),
(234, '61', '61-ANS0497C9B', '1000016-8010', '0'),
(235, '61', '61-ANS049783D', '992015', '0'),
(236, '62', '62-ANS049707C', 'বীজগণিত বলা হয়', '0'),
(237, '62', '62-ANS0497C1E', 'বীজগণিতিক সূত্র বলা হয়', '1'),
(238, '62', '62-ANS049703A', 'পরিমিতি  বলা হয়', '0'),
(239, '62', '62-ANS0497BCB', 'পরিসংখ‌্যান বলা হয়', '0'),
(240, '63', '63-ANS0497998', '10', '1'),
(241, '63', '63-ANS0497618', '100', '0'),
(242, '63', '63-ANS049743D', '-52', '0'),
(243, '63', '63-ANS0497DEB', '-92', '0'),
(244, '64', '64-ANS04973F8', 'যদি f(a) = 0 হয়', '0'),
(245, '64', '64-ANS049724F', 'যদি f(x) = 0 হয়', '0'),
(246, '64', '64-ANS0497870', 'যদি এবং কেবল যদি f(a) = 0 হয়', '1'),
(247, '64', '64-ANS04979F0', 'যদি এবং কেবল যদি f(x) ', '0'),
(248, '65', '65-ANS0497097', 'ভর্তুকি ৩৫ টাকা', '0'),
(249, '65', '65-ANS049792D', 'ভর্তুকি 8 টাকা', '0'),
(250, '65', '65-ANS0497026', 'ভর্তুকি 48 টাকা', '0'),
(251, '65', '65-ANS049773B', 'ভর্তুকি 6 টাকা', '1'),
(252, '66', '66-ANS04977D6', 'মুনাফা 200 টাকা', '0'),
(253, '66', '66-ANS0497527', 'মুনাফা 274 টাকা', '0'),
(254, '66', '66-ANS04971FF', 'মুনাফা 273 টাকা', '1'),
(255, '66', '66-ANS04970A8', 'মুনাফা 873 টাকা', '0'),
(256, '67', '67-ANS0497A27', '17865', '0'),
(257, '67', '67-ANS0497547', '17824', '0'),
(258, '67', '67-ANS0497CD0', '17824.65', '0'),
(259, '67', '67-ANS0497A1F', '17865.24', '1'),
(260, '68', '68-ANS04975E3', '2865.24', '1'),
(261, '68', '68-ANS0497BD9', '17865.24', '0'),
(262, '68', '68-ANS0497860', '15000', '0'),
(263, '68', '68-ANS0497A5C', '2865.24+15000', '0'),
(264, '69', '69-ANS0498356', '√3', '0'),
(265, '69', '69-ANS0498D94', '2*√3', '0'),
(266, '69', '69-ANS04981FE', '2+√3', '1'),
(267, '69', '69-ANS0498706', '√3-2', '0'),
(268, '70', '70-ANS0498CD6', '1014049', '1'),
(269, '70', '70-ANS0498F36', '1014549', '0'),
(270, '70', '70-ANS049845E', '1714049', '0'),
(271, '70', '70-ANS0498128', '1007/1007', '0'),
(272, '71', '71-ANS049814B', '1001', '0'),
(273, '71', '71-ANS04980FB', '99', '0'),
(274, '71', '71-ANS0498048', '100', '1'),
(275, '71', '71-ANS0498B2A', '3.65x3.65', '0'),
(276, '72', '72-ANS049893C', '√256', '0'),
(277, '72', '72-ANS0498301', '±√256', '1'),
(278, '72', '72-ANS04987AE', '+16', '0'),
(279, '72', '72-ANS0498718', '-16', '0'),
(280, '73', '73-ANS04988CF', '2', '0'),
(281, '73', '73-ANS04985AD', '√2', '0'),
(282, '73', '73-ANS0498374', '2√2', '1'),
(283, '73', '73-ANS04988F8', '3√2', '0'),
(284, '74', '74-ANS0498534', '√5', '0'),
(285, '74', '74-ANS0498474', '5', '0'),
(286, '74', '74-ANS0498F16', '3√5', '1'),
(287, '74', '74-ANS0498B81', '5√5', '0'),
(288, '75', '75-ANS0498E18', '√3', '1'),
(289, '75', '75-ANS04987AD', '3', '0'),
(290, '75', '75-ANS049857B', '√11', '0'),
(291, '75', '75-ANS0498052', '7', '0'),
(292, '76', '76-ANS04988C9', '1', '0'),
(293, '76', '76-ANS0498A32', '0', '1'),
(294, '76', '76-ANS049883E', 'x=y-1', '0'),
(295, '76', '76-ANS0498425', 'xy', '0'),
(296, '77', '77-ANS0498684', '1', '0'),
(297, '77', '77-ANS0498DAE', '0', '1'),
(298, '77', '77-ANS04986EB', 'x=y-1', '0'),
(299, '77', '77-ANS049870F', 'xy', '0'),
(300, '77', '77-ANS0498BD8', '', '0'),
(301, '78', '78-ANS0498B0F', '5', '0'),
(302, '78', '78-ANS0498E73', '0', '0'),
(303, '78', '78-ANS0498847', '64', '0'),
(304, '78', '78-ANS04988B3', '65', '1'),
(305, '79', '79-ANS0498BBE', '2√7', '1'),
(306, '79', '79-ANS049821A', '2√6', '0'),
(307, '79', '79-ANS0498836', '√7', '0'),
(308, '79', '79-ANS04988D4', '√6', '0'),
(309, '80', '80-ANS0498FF9', '912673', '1'),
(310, '80', '80-ANS049830E', '0', '0'),
(311, '80', '80-ANS0498891', '912673', '0'),
(312, '80', '80-ANS049834F', '9409', '0'),
(313, '81', '81-ANS0498059', '4', '0'),
(314, '81', '81-ANS04987F1', '0', '0'),
(315, '81', '81-ANS0498D2D', '5', '0'),
(316, '81', '81-ANS04986E0', '-4', '1'),
(318, '82', '82-ANS06154E67', '1', '0'),
(319, '83', '83-ANS0615425B', '1', '0'),
(320, '84', '84-ANS06154C31', '1', '0'),
(321, '85', '85-ANS06154E36', '1', '0'),
(322, '86', '86-ANS06154026', '1', '0'),
(323, '87', '87-ANS06154978', '1', '0'),
(324, '88', '88-ANS06154358', '1', '0'),
(325, '89', '89-ANS06154144', '1', '0'),
(326, '90', '90-ANS06154766', '1', '0'),
(327, '91', '91-ANS06154B60', '1', '0'),
(328, '92', '92-ANS06154E3B', '1', '0'),
(329, '93', '93-ANS061540B9', '1', '0'),
(330, '94', '94-ANS06154789', '1', '0'),
(331, '95', '95-ANS06154B74', '1', '0'),
(332, '96', '96-ANS0615432D', '1', '0'),
(333, '97', '97-ANS0615405D', '1', '0'),
(334, '98', '98-ANS06154286', '1', '0'),
(335, '99', '99-ANS06154372', '1', '0'),
(336, '100', '100-ANS06154FBD', '1', '0'),
(337, '101', '101-ANS06154063', '1', '0'),
(338, '102', '102-ANS061540BE', '1', '0'),
(427, '148', '148-ANS06154AFD', '1', '0'),
(428, '149', '149-ANS06154189', '1\'\"', '0'),
(440, '154', '154-ANS061543B0', '1', '0'),
(442, '155', '155-ANS061541F6', '1', '0'),
(443, '156', '156-ANS06154D72', '1', '0'),
(444, '157', '157-ANS0615461D', '1', '0'),
(445, '158', '158-ANS06154C8A', '1', '0'),
(446, '159', '159-ANS061544DC', '1', '0'),
(447, '160', '160-ANS06154FA6', '1', '0'),
(448, '161', '161-ANS0615476E', '1', '0'),
(456, '162', '162-ANS0615483C', '1', '0'),
(458, '163', '163-ANS061546E9', '1', '0'),
(460, '164', '164-ANS06154D4B', '1', '0'),
(462, '165', '165-ANS0615491D', '1', '0'),
(464, '166', '166-ANS06154EE4', '1', '0'),
(466, '167', '167-ANS061549E7', '1', '0'),
(468, '168', '168-ANS06154F8B', '1', '0'),
(470, '169', '169-ANS06154B31', '1', '0'),
(472, '170', '170-ANS06154784', '1', '0'),
(474, '171', '171-ANS06154E8B', '1', '0'),
(476, '172', '172-ANS06154C2C', '1', '0'),
(484, '173', '173-ANS06154C64', '1', '0'),
(486, '174', '174-ANS061541B4', '1', '0'),
(494, '175', '175-ANS06154912', '1', '0'),
(496, '176', '176-ANS06154658', '1', '0'),
(498, '177', '177-ANS061546BD', '1', '0'),
(500, '178', '178-ANS061547E6', '1', '0'),
(501, '179', '179-ANS061540B4', '1', '0'),
(502, '180', '180-ANS061541EA', '1', '0'),
(503, '181', '181-ANS061549E5', '1', '0'),
(504, '182', '182-ANS06154B8C', '1', '0'),
(505, '183', '183-ANS06154BC0', '1', '0'),
(506, '184', '184-ANS06154B2A', '1', '0'),
(508, '185', '185-ANS06154310', '1', '0'),
(510, '186', '186-ANS06154833', '1', '0'),
(511, '187', '187-ANS061545A8', '1', '0'),
(512, '188', '188-ANS06154380', '1', '0'),
(514, '189', '189-ANS06154C2B', '1', '0'),
(515, '190', '190-ANS0615498D', '1', '0'),
(516, '191', '191-ANS06154F7D', '1', '0'),
(517, '192', '192-ANS0615408E', '1', '0'),
(519, '193', '193-ANS06154F7F', '1', '0'),
(521, '194', '194-ANS061547B6', '1', '0'),
(523, '195', '195-ANS06154053', '1', '0'),
(525, '196', '196-ANS061549CE', '1', '0'),
(527, '197', '197-ANS06154021', '1', '0'),
(529, '198', '198-ANS06154408', '1', '0'),
(531, '199', '199-ANS06154DAE', '1', '0'),
(533, '200', '200-ANS06154B85', '1', '0'),
(535, '201', '201-ANS0615468F', '1', '0'),
(537, '202', '202-ANS061543DB', '1', '0'),
(541, '203', '203-ANS06154C70', '1', '0'),
(543, '204', '204-ANS061540BB', '1', '0'),
(545, '205', '205-ANS06154AB1', '1', '0'),
(548, '206', '206-ANS06154EE0', '1', '0'),
(549, '207', '207-ANS061540BD', '1', '0'),
(550, '208', '208-ANS06154A23', '1', '0'),
(551, '209', '209-ANS061549E4', '1', '0'),
(614, '210', '210-ANS06154140', '1', '0'),
(615, '211', '211-ANS123369D7', 'Hyperlink and Hypertext Markup Language', '0'),
(616, '211', '211-ANS12336514', 'HyperTest Markup Language', '1'),
(617, '211', '211-ANS123360DA', 'Home Tool Markup Language', '0'),
(622, '213', '213-ANS12336CFB', '<table> , <tbody> , <trow>', '0'),
(623, '213', '213-ANS12336173', '<table> , <tb> , <trow>', '0'),
(624, '213', '213-ANS12336FF6', '<table> , <tbody> , <tr>', '0'),
(625, '213', '213-ANS12336EDC', 'All of the above', '1'),
(626, '214', '214-ANS123362AC', '<theader>', '0'),
(627, '214', '214-ANS123362A2', '<h1>', '1'),
(628, '214', '214-ANS12336B53', '<th>', '0'),
(629, '214', '214-ANS12336F51', '<header>', '0'),
(630, '215', '215-ANS12336763', '<select>', '0'),
(631, '215', '215-ANS12336D84', '<option>', '1'),
(632, '215', '215-ANS12336128', '<dropdown>', '0'),
(633, '216', '216-ANS123647DA', '1', '1'),
(634, '216', '216-ANS1236411F', '0', '0'),
(635, '217', '217-ANS01072D7', 'Hyperlinks and Text Markup Language', '1'),
(636, '217', '217-ANS0107A50', 'Hyper Transfer Markup Language', '0'),
(637, '218', '218-ANS010704B', '<link>', '0'),
(638, '218', '218-ANS0107D38', '<a>', '1'),
(639, '219', '219-ANS01073C7', 'php framework', '1'),
(640, '219', '219-ANS0107EBB', 'java framework', '0'),
(641, '220', '220-ANS0237D36', 'ঢাকা', '1'),
(642, '220', '220-ANS0237F69', 'জাহাঙ্গির নগর', '0'),
(643, '220', '220-ANS02375F2', 'সিলেট', '0'),
(644, '221', '221-ANS0237ED6', 'কবির', '1'),
(645, '221', '221-ANS0237D15', 'কনা', '0'),
(646, '221', '221-ANS0237F07', 'আয়ান', '0'),
(647, '221', '221-ANS0237976', 'নাফিছা', '0');

-- --------------------------------------------------------

--
-- Table structure for table `question_set`
--

CREATE TABLE `question_set` (
  `Id` bigint NOT NULL,
  `subject_id` varchar(100) NOT NULL,
  `question_set_id` varchar(50) NOT NULL,
  `question_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_set`
--

INSERT INTO `question_set` (`Id`, `subject_id`, `question_set_id`, `question_id`) VALUES
(9, 'EXAM-2430227AB6', 'QSet-001', '7'),
(10, 'EXAM-2430227AB6', 'QSet-001', '8'),
(11, 'EXAM-2430227AB6', 'QSet-001', '9'),
(12, 'EXAM-2430227AB6', 'QSet-001', '10'),
(13, 'EXAM-2430227AB6', 'QSet-001', '11'),
(14, 'EXAM-2430227AB6', 'QSet-001', '12'),
(15, 'EXAM-2430227AB6', 'QSet-001', '13'),
(16, 'EXAM-2430227AB6', 'QSet-001', '14'),
(17, 'EXAM-2430227AB6', 'QSet-001', '15'),
(18, 'EXAM-2430227AB6', 'QSet-001', '16'),
(19, 'EXAM-24312510E2', 'QSet-001', '17'),
(20, 'EXAM-24312510E2', 'QSet-001', '18'),
(21, 'EXAM-24312510E2', 'QSet-001', '19'),
(22, 'EXAM-24312510E2', 'QSet-001', '20'),
(23, 'EXAM-24312510E2', 'QSet-001', '21'),
(24, 'EXAM-24312510E2', 'QSet-001', '22'),
(25, 'EXAM-24312510E2', 'QSet-001', '23'),
(26, 'EXAM-24312510E2', 'QSet-001', '24'),
(27, 'EXAM-24312510E2', 'QSet-001', '25'),
(28, 'EXAM-24312510E2', 'QSet-001', '26'),
(29, 'EXAM-24312510E2', 'QSet-001', '27'),
(30, 'EXAM-24312510E2', 'QSet-001', '28'),
(31, 'EXAM-24312510E2', 'QSet-001', '29'),
(32, 'EXAM-24312510E2', 'QSet-001', '30'),
(33, 'EXAM-24312510E2', 'QSet-001', '31'),
(34, 'EXAM-24312510E2', 'QSet-001', '32'),
(35, 'EXAM-24312510E2', 'QSet-001', '33'),
(36, 'EXAM-24312510E2', 'QSet-001', '34'),
(37, 'EXAM-24312510E2', 'QSet-001', '35'),
(38, 'EXAM-24312510E2', 'QSet-001', '36'),
(109, 'EXAM-250756543D', 'QSet-001', '37'),
(110, 'EXAM-250756543D', 'QSet-001', '38'),
(111, 'EXAM-250756543D', 'QSet-001', '39'),
(112, 'EXAM-250756543D', 'QSet-001', '40'),
(113, 'EXAM-250756543D', 'QSet-001', '41'),
(114, 'EXAM-250756543D', 'QSet-001', '42'),
(115, 'EXAM-250756543D', 'QSet-001', '43'),
(116, 'EXAM-250756543D', 'QSet-001', '44'),
(117, 'EXAM-250756543D', 'QSet-001', '45'),
(118, 'EXAM-250756543D', 'QSet-001', '46'),
(119, 'EXAM-250756543D', 'QSet-001', '47'),
(120, 'EXAM-250756543D', 'QSet-001', '48'),
(121, 'EXAM-250756543D', 'QSet-001', '49'),
(122, 'EXAM-250756543D', 'QSet-001', '50'),
(123, 'EXAM-250756543D', 'QSet-001', '51'),
(124, 'EXAM-250756543D', 'QSet-001', '52'),
(125, 'EXAM-250756543D', 'QSet-001', '53'),
(126, 'EXAM-250756543D', 'QSet-001', '54'),
(127, 'EXAM-250756543D', 'QSet-001', '55'),
(128, 'EXAM-250756543D', 'QSet-001', '56'),
(129, 'EXAM-250968090B', 'QSet-003', '57'),
(130, 'EXAM-250968090B', 'QSet-003', '58'),
(131, 'EXAM-250968090B', 'QSet-003', '59'),
(132, 'EXAM-250968090B', 'QSet-003', '60'),
(133, 'EXAM-250968090B', 'QSet-003', '61'),
(134, 'EXAM-250968090B', 'QSet-003', '62'),
(135, 'EXAM-250968090B', 'QSet-003', '63'),
(136, 'EXAM-250968090B', 'QSet-003', '69'),
(137, 'EXAM-250968090B', 'QSet-003', '70'),
(138, 'EXAM-250968090B', 'QSet-003', '71'),
(139, 'EXAM-250968090B', 'QSet-003', '72'),
(140, 'EXAM-250968090B', 'QSet-003', '73'),
(141, 'EXAM-250968090B', 'QSet-003', '74'),
(142, 'EXAM-250968090B', 'QSet-003', '75'),
(143, 'EXAM-250968090B', 'QSet-003', '76'),
(144, 'EXAM-250968090B', 'QSet-003', '77'),
(145, 'EXAM-250968090B', 'QSet-003', '78'),
(146, 'EXAM-250968090B', 'QSet-003', '79'),
(147, 'EXAM-250968090B', 'QSet-003', '80'),
(148, 'EXAM-250968090B', 'QSet-003', '81'),
(149, 'EXAM-250968090B', 'QSet-001', '57'),
(150, 'EXAM-250968090B', 'QSet-001', '58'),
(151, 'EXAM-250968090B', 'QSet-001', '59'),
(152, 'EXAM-250968090B', 'QSet-001', '60'),
(153, 'EXAM-250968090B', 'QSet-001', '61'),
(154, 'EXAM-250968090B', 'QSet-001', '62'),
(155, 'EXAM-250968090B', 'QSet-001', '63'),
(156, 'EXAM-250968090B', 'QSet-001', '69'),
(157, 'EXAM-250968090B', 'QSet-001', '70'),
(158, 'EXAM-250968090B', 'QSet-001', '71'),
(159, 'EXAM-250968090B', 'QSet-001', '72'),
(160, 'EXAM-250968090B', 'QSet-001', '73'),
(161, 'EXAM-250968090B', 'QSet-001', '74'),
(162, 'EXAM-250968090B', 'QSet-001', '75'),
(163, 'EXAM-250968090B', 'QSet-001', '76'),
(164, 'EXAM-250968090B', 'QSet-001', '77'),
(165, 'EXAM-250968090B', 'QSet-001', '78'),
(166, 'EXAM-250968090B', 'QSet-001', '79'),
(167, 'EXAM-250968090B', 'QSet-001', '80'),
(168, 'EXAM-250968090B', 'QSet-001', '81'),
(174, 'EXAM-25335D8B66', 'QSet-002', '211'),
(175, 'EXAM-25335D8B66', 'QSet-002', '212'),
(176, 'EXAM-25335D8B66', 'QSet-002', '213'),
(177, 'EXAM-25335D8B66', 'QSet-002', '214'),
(179, 'EXAM-25335D8B66', 'QSet-001', '211'),
(180, 'EXAM-25335D8B66', 'QSet-001', '212'),
(181, 'EXAM-25335D8B66', 'QSet-001', '213'),
(182, 'EXAM-25335D8B66', 'QSet-001', '214'),
(183, 'EXAM-25335D8B66', 'QSet-001', '215'),
(184, 'EXAM-25363D924B', 'QSet-001', '216'),
(185, 'EXAM-26006F9083', 'QSet-001', '217'),
(186, 'EXAM-26006F9083', 'QSet-001', '218'),
(187, 'EXAM-26006F9083', 'QSet-002', '217'),
(188, 'EXAM-26006F9083', 'QSet-002', '218'),
(189, 'EXAM-26006E3771', 'QSet-002', '219'),
(190, 'EXAM-26006E3771', 'QSet-001', '219'),
(194, 'EXAM-2603680136', 'QSet-001', '220'),
(195, 'EXAM-2603680136', 'QSet-001', '221'),
(197, 'EXAM-2603680136', 'QSet-002', '220');

-- --------------------------------------------------------

--
-- Table structure for table `question_set_setup`
--

CREATE TABLE `question_set_setup` (
  `id` int NOT NULL,
  `question_set_id` varchar(60) NOT NULL,
  `question_set_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_set_setup`
--

INSERT INTO `question_set_setup` (`id`, `question_set_id`, `question_set_title`) VALUES
(1, 'QSet-001', 'পদ্মা'),
(2, 'QSet-002', 'মেঘনা');

-- --------------------------------------------------------

--
-- Table structure for table `sales_commission`
--

CREATE TABLE `sales_commission` (
  `sales_commission_id` bigint NOT NULL,
  `sales_commission_percent` varchar(30) NOT NULL,
  `sales_commission_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_commission`
--

INSERT INTO `sales_commission` (`sales_commission_id`, `sales_commission_percent`, `sales_commission_type`) VALUES
(5, '20', 'straight_commission');

-- --------------------------------------------------------

--
-- Table structure for table `student_profile`
--

CREATE TABLE `student_profile` (
  `ID` bigint NOT NULL,
  `stu_profile_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stu_date_of_birth` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stu_edu_level_class` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stu_last_edu_institute` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stu_male_female` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stu_pic` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stu_bangla_english_medium` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stu_city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stu_guirdian_name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stu_guirdian_mobile` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stu_guirdian_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_profile`
--

INSERT INTO `student_profile` (`ID`, `stu_profile_id`, `stu_date_of_birth`, `stu_edu_level_class`, `stu_last_edu_institute`, `stu_male_female`, `stu_pic`, `stu_bangla_english_medium`, `stu_city`, `stu_guirdian_name`, `stu_guirdian_mobile`, `stu_guirdian_address`) VALUES
(5, 'STD2423157E03', '', '', '', '', '', '', '', '', '', ''),
(15, 'STD2424950D5F', '', '', '', '', '', '', '', '', '', ''),
(6029, 'STD243032103F', '', '', '', '', '', '', '', '', '', ''),
(6030, 'STD243066B0C9', '', '', '', '', '', '', '', '', '', ''),
(6031, 'STD243064F14E', '', '', '', '', '', '', '', '', '', ''),
(6032, 'STD243073D677', '', '', '', '', '', '', '', '', '', ''),
(6033, 'STD24315F2333', '', '', '', '', '', '', '', '', '', ''),
(6034, 'STD250353E552', '', '', '', '', '', '', '', '', '', ''),
(6035, 'STD25049638B8', '', '', '', '', '', '', '', '', '', ''),
(6036, 'STD25344B7F3D', '16-02-2016', 'Degree', 'DU', 'Male', 'ayan zahin_imresizer.jpg', 'Bangla', 'Dhaka', 'Kabir', '0156985564', 'Dhaka'),
(6037, 'STD25362071C5', '', '', '', '', '', '', '', '', '', ''),
(6038, 'STD26022127D2', '', '', '', '', '', '', '', '', '', ''),
(6039, 'STD2602227A23', '25-01-1985', 'Ba', 'MA', 'Male', 'Dulal mia.jpeg', 'dsfsdf', 'sdfds', 'sdfds', 'sdfds', 'sdfds');

-- --------------------------------------------------------

--
-- Table structure for table `student_registration`
--

CREATE TABLE `student_registration` (
  `ID` bigint NOT NULL,
  `student_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `third_party_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_registration`
--

INSERT INTO `student_registration` (`ID`, `student_id`, `student_name`, `student_email`, `student_mobile`, `student_password`, `third_party_id`, `created_at`) VALUES
(5, 'STD2423157E03', 'Nafisa Tabassom', 'nafisa@gmail.com', '01913691185', '123456', NULL, NULL),
(15, 'STD2424950D5F', 'Nafisa Tahsin Nabila', 'bnasrin155@gmail.com', '01723411613', 'Nabila123', NULL, NULL),
(6029, 'STD243032103F', 'Shahriar', 'skabir85@gmail.com', NULL, '', '106556754043661382623', '2024-10-29 09:44:03'),
(6030, 'STD243066B0C9', 'Nasrin', 'bnasrin155@gmail.com', NULL, '', '106693791203737406311', '2024-11-01 12:48:34'),
(6031, 'STD243064F14E', 'Nafisa Tabassum', 'nafisanaferocks613@gmail.com', NULL, '', '108827214183817792929', '2024-11-01 13:00:26'),
(6032, 'STD243073D677', 'Mohammad kabir', 'weboutsourcebd2012@gmail.com', NULL, '', '103914507880970929898', '2024-11-02 07:06:45'),
(6033, 'STD24315F2333', 'SHEFAT', 'mdshefat250@gmail.com', NULL, '', '105678469347515870677', '2024-11-10 09:31:11'),
(6034, 'STD250353E552', 'Jewen', 'jewenh0@gmail.com', NULL, '', '115610751572423085318', '2025-02-04 14:39:36'),
(6035, 'STD25049638B8', 'Arif', 'arif1280@gmail.com', NULL, '', '100292997600266185115', '2025-02-18 09:42:38'),
(6036, 'STD25344B7F3D', 'Ayan Zahin', 'ayan@gmail.com', '01913698854', 'Kkabc*123', NULL, NULL),
(6037, 'STD25362071C5', 'Test', 'test@gmail.com', '01923658896', 'Kkabc*123', NULL, NULL),
(6038, 'STD26022127D2', 'Sakif', 'sakif@gmail.com', '01913658896', 'Kkabc*123', NULL, NULL),
(6039, 'STD2602227A23', 'abcd', 'abc@gmail.com', '01245896632', 'Kkabc*123', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supper_admin_login`
--

CREATE TABLE `supper_admin_login` (
  `id` int NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supper_admin_login`
--

INSERT INTO `supper_admin_login` (`id`, `user_id`, `password`) VALUES
(1, 'skabir85@gmail.com', 'Kkabc*123');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_course`
--

CREATE TABLE `teacher_course` (
  `course_id` bigint NOT NULL,
  `course_teacher_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `coures_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_type_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_section_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_category_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_level` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `what_you_will_learn` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_price` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `demo_class_link` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_prerequisite` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_note` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_pic` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_course`
--

INSERT INTO `teacher_course` (`course_id`, `course_teacher_id`, `coures_title`, `course_type_name`, `course_section_id`, `course_category_id`, `course_level`, `what_you_will_learn`, `course_price`, `demo_class_link`, `course_prerequisite`, `course_note`, `course_pic`, `course_status`) VALUES
(65, 'TEA2416113B98', 'বেসিক ওয়েব ডেভেলপমেন্ট', 'Online_Live_Coaching', '2', '29', 'college_level', 'Create and structure basic web pages using HTML and style them with CSS, Web Development with WordPress ,Develop dynamic web pages with interactive features using jQuery and JavaScript., Basic concept of PHP programming and MySQL database,Describe the Web terminology  like front-end developer  back-end developer full-stack developer server-side and client-side.', '1000', 'https://www.youtube.com/embed/6tc8P3xI0KU', 'ইন্টারমিডিয়েট পাশ', 'HTML, CSS, PHP + My SQL  এবং WordPress ইত্যাদি শিখার মাধ্যমে Web Developer হয়ে ফ্রিল্যান্সিং বা দেশ-বিদেশে বিভিন্ন কোম্পানীতে উচ্চ বেতনে চাকুরী করার সুযোগ রয়েছে। আমাদের দেশের অনেকেই Web Developer হিসেবে মাসে কয়েক লক্ষ্য টাকা উপার্জন করছে। বেকার যুবকদের কর্মসংস্থানের মাধ্যম হতে পারে এই কোর্স।', 'web developer.jpg', 'approved'),
(66, 'TEA241613C2C0', 'বেসিক জাভা প্রোগ্রামিং', 'Online_Live_Coaching', '1', '35', 'university_level', 'Learn the fundamentals of Java, Be able to write Java code as a begineer, Learn the basics of Object Oriented Programming (OOP), Learn best practices and how to write high quality Java code, Be able to demonstrate understanding of Java for Junior Java Developer position.', '7000', '#', 'Already know to a Programming Language', 'Learn Java Basics with Real Coding Examples. Become a Java Programmer From Complete Begineer.', 'basic-java.jpg', 'approved'),
(67, 'TEA241625C317', 'গণিত-নবম শ্রেণী (নতুন কারিকুলাম)', 'Online_Live_Coaching', '1', '30', 'high_school_level', 'সমস্যা সমাধানে বিভিন্ন গাণিতিক অনুসন্ধান প্রক্রিয়ার ব্যবহার, অনুসন্ধান প্রক্রিয়া ও মুক্তমনে যাচাই, বাস্তব জীবনে সমস্যা সমাধানে উপযুক্ত গাণিতিক সূত্রের প্রয়োগ ও বারবার অনুশীলনের মাধ্যমে দক্ষতা আনয়ন', '1000', '#', 'অষ্টম শ্রেণী পাশ হতে হবে', 'দেশের যেকোন জায়গা থেকে আমাদের অনলাইন ব্যচে সরাসরি নতুন সিলেবাস অনুযায়ী দেশের নামকরা প্রতিষ্ঠানের আপু-ভাইয়াদের মাধ্যমে পড়াশুনা করার সুযোগ ।', 'math nine arif.jpg', 'approved'),
(69, 'TEA25002B0977', 'সহজে কোরআন শিক্ষা-(সবার জন্য)', 'Online_Live_Coaching', '2', '36', 'high_school_level', 'ব্যস্ত মানুষ চাকুরীজিবি ও ব্যবসায়ীদের জন্য সন্ধ্যাকালীন সংক্ষিপ্ত কোর্স পরিচালনা, সহজ আধুনিক ও বিজ্ঞানভিত্তিক শিক্ষা প্রদানের টেকনিক ব্যবহার করে কুরআন শিক্ষা কে সহজ করা, তাজবীদসহ কুরআন শিক্ষা এবং ইহা বুঝতে পারা, একজন মুসলিম হিসেবে প্রতিদিনের জরূরী মাসলা মাসায়েল।', '500', '#', 'Know arabic alphabet basic knowledge', 'সকল প্রশংসা মহান আল্লাহর জন্য। শান্তি ও দোয়া কামনা মানবতার মুক্তির দূত সর্বকালের শেষ্ঠ মহা-মানব বাসূল (সাঃ) এর প্রতি। রাসূল (সাঃ) বলেছেন  - তোমাদের মধ্যে সে ব্যক্তি সর্বাপেক্ষা উত্তম যে নিজে কুরআন শিখে এবং অপরকে তা শিখায় ।  আমরা অনেকেই সঠিকভাবে কুরআন পড়তে জানি না, কুরআন শিক্ষা করে এর আলোকে জীবন গড়তে পারলেই কেবল দুনিয়া ও আখিরাতে কল্যান সম্ভব।', 'quara course.jpg', 'approved'),
(71, 'TEA241625C317', 'গণিত দশম শ্রেণী', 'Online_Live_Coaching', '1', '37', 'high_school_level', 'বাস্তব জীবনে সমস্যা সমাধানে উপযুক্ত গাণিতিক সূত্রের প্রয়োগ ও বারবার অনুশীলনের মাধ্যমে দক্ষতা আনয়ন, অনুসন্ধান প্রক্রিয়া ও মুক্তমনে যাচাই, সমস্যা সমাধানে বিভিন্ন গাণিতিক অনুসন্ধান প্রক্রিয়ার ব্যবহার', '1000', '#', 'Class Nine pass', 'দেশের যেকোন জায়গা থেকে আমাদের অনলাইন ব্যচে সরাসরি নতুন সিলেবাস অনুযায়ী দেশের নামকরা প্রতিষ্ঠানের আপু-ভাইয়াদের মাধ্যমে পড়াশুনা করার সুযোগ ।', 'math class-ten.jpg', 'approved'),
(72, 'TEA2416113B98', 'ICT in Financial Institutions (ICTFI)', 'Online_Live_Coaching', '2', '150', 'university_level', 'ডিপ্লোমা পরীক্ষায় পাস ইনশাআল্লাহ।', '600', '#', 'প্রতিটি ক্লাসে উপস্থিত থাকার চেস্টা করা।', 'আপনি যে বিষয়েই স্নাতক সম্পন্ন করেন না কেন ব্যাংকিং ক্যারিয়ারে কাঙ্ক্ষিত পদোন্নতি, আর্থিক প্রণোদনা বা পেশাগত উৎকর্ষ সাধনের জন্য ব্যাংকিং ডিপ্লোমা পরীক্ষা। প্রস্তুতির জন্য জেনে নিতে পারেন কিছু কার্যকর কৌশল।\r\n\r\n১. বিগত পরীক্ষার প্রশ্ন সমাধান দিয়ে প্রস্তুতি শুরু করা ভালো। এতে, পুরো সিলেবাসের অন্তত ৬০-৭০ শতাংশ বিষয় সম্পর্কে পরিষ্কার ধারণা হয়ে যাবে। যেহেতু ব্যাংকিং ডিপ্লোমা কোনো প্রতিযোগিতামূলক পরী', '', 'pending'),
(73, 'TEA2416113B98', 'MCQ Exam', 'Question_And_Exam', '3', '151', 'high_school_level', 'test exam', '200', '#', 'no', 'test', 'WhatsApp Image 2025-11-06 at 17.05.17_ef9d2ea8.jpg', 'pending'),
(74, 'TEA253625A7B2', 'Computer Basic Course for Job', 'Online_Video_Course', '2', '29', 'university_level', 'test, ', '500', '#', 'no', 'test', 'oirree.jpg', 'approved'),
(75, 'TEA253620D708', 'Mobile Engineerin', 'Question_And_Exam', '3', '151', 'university_level', 'test1, test2', '250', '#', 'No', 'PHP ও Laravel কোর্স করলে তুমি সহজে ওয়েবসাইট তৈরি শিখবে। PHP দিয়ে বেসিক প্রোগ্রামিং বুঝবে আর Laravel দিয়ে দ্রুত প্রফেশনাল ওয়েব অ্যাপ বানাতে পারবে। এতে ডাটাবেস, লগইন সিস্টেম ও প্রয়োজনীয় ফিচার শেখা যায়, ফলে তুমি সহজেই চাকরির জন্য প্রস্তুত হতে পারবে এবং চাইলে ফ্রিল্যান্সিং করেও ইনকাম করতে পারবে। মোট কথা, এই কোর্স তোমাকে দ্রুত একজন দক্ষ ওয়েব ডেভেলপার হতে সাহায্য করবে।', '513802263_24071854009102453_2536448296895193135_n.jpg', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_profile`
--

CREATE TABLE `teacher_profile` (
  `teacher_profile_id` bigint NOT NULL,
  `teacher_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_educational_institute` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_edu_his` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_pro_his` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_certi_award` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_pic` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `term_condition` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_profile`
--

INSERT INTO `teacher_profile` (`teacher_profile_id`, `teacher_id`, `last_educational_institute`, `teacher_edu_his`, `teacher_pro_his`, `teacher_certi_award`, `teacher_pic`, `term_condition`) VALUES
(26, 'TEA2416113B98', 'চট্টগ্রাম বিশ্ববিদ্যালয়', 'B.Sc. M.Sc. in Computer Science', 'আপওয়ার্কে ১৫০০+ ঘন্টা কাজ করার অভিজ্ঞতা', 'B.Sc. M.Sc.', 'kabir.png', ''),
(27, 'TEA241613C2C0', 'KUET', 'নটরডেম কলেজ, খুলনা প্রকোশল বিশ্ব (কুয়েট)', 'সাবেক শিক্ষকঃ ড্যাফোডিল ইঊনিভার্সিটি- কম্পিউটার বিজ্ঞান বিভাগ', 'B.Sc. M.Sc. CSE', '1110440-01787.jpg', ''),
(28, 'TEA241625C317', 'ঢাকা কলেজ', 'ঢাকা কলেজ', '৫ বছরের স্কুল শিক্ষকতার অভিজ্ঞতা', 'বিএসসি, এমএসসি ইন গণিত', 'arif.png', ''),
(30, 'TEA24333A1969', '', '', '', '', '', ''),
(31, 'TEA243417CF4B', '', '', '', '', '', ''),
(32, 'TEA243417EC59', '', '', '', '', '', ''),
(33, 'TEA25002B0977', 'অনার্স ও মাস্টার্স ইসলামিক স্টাডিজ বাংলাদেশ ইসলামী বিশ্ববিদ্যালয় ও কামিল হাদিস, সরকারী আলিয়া মাদ্রা', 'Hifzul Quran, Kamil and Islamic Studies (Masters)', 'সাবেক শিক্ষক তানযীমুল উম্মাহ হিফয মাদ্রাসা', 'Hafeze Quran, Kamil and Islamic Studies(Masters)', 'rahim.png', ''),
(34, 'TEA250312410E', '', '', '', '', '', ''),
(35, 'TEA2503312E89', 'ঢাকা কলেজ', 'বিএসসি, এমএসসি গণিত, ঢাকা কলেজ', 'গণিত শিক্ষক , স্কুল ও কলেজ', 'গণিত ', 'arif small pic.png', ''),
(36, 'TEA250350C533', 'Rajshahi University ', 'M.Sc(Physics), M.Sc( CSE),BSc( Physics) ', 'SO-IT,Janata Bank,Ex Lecturer Monpura school &college, Ex Lecturer, Rafa coaching, Challenger Academy Rajshahi ', 'JAIBB,DAIBB', 'inbound260349710324643347.jpg', ''),
(37, 'TEA2505379065', '', '', '', '', '', ''),
(38, 'TEA25071F98B4', '', '', '', '', '', ''),
(39, 'TEA2508081E2F', '', '', '', '', '', ''),
(40, 'TEA250818B7CC', '', '', '', '', '', ''),
(41, 'TEA250861CE93', '', '', '', '', '', ''),
(42, 'TEA25092A0546', '', '', '', '', '', ''),
(43, 'TEA25100B8D16', '', '', '', '', '', ''),
(44, 'TEA251125CE8E', '', '', '', '', '', ''),
(45, 'TEA251134CF32', '', '', '', '', '', ''),
(46, 'TEA25146869E0', '', '', '', '', '', ''),
(47, 'TEA25149A4F85', '', '', '', '', '', ''),
(48, 'TEA25151CD460', '', '', '', '', '', ''),
(49, 'TEA25153C3F4A', '', '', '', '', '', ''),
(50, 'TEA25153BBEAB', '', '', '', '', '', ''),
(51, 'TEA25153FEBC5', '', '', '', '', '', ''),
(52, 'TEA25153C1806', '', '', '', '', '', ''),
(53, 'TEA2515358623', '', '', '', '', '', ''),
(54, 'TEA2515386921', '', '', '', '', '', ''),
(55, 'TEA2515336E3B', '', '', '', '', '', ''),
(56, 'TEA251534A045', '', '', '', '', '', ''),
(57, 'TEA251536DD6C', '', '', '', '', '', ''),
(58, 'TEA25153760BA', '', '', '', '', '', ''),
(59, 'TEA251535521D', '', '', '', '', '', ''),
(60, 'TEA25153C5157', '', '', '', '', '', ''),
(61, 'TEA251538FA69', '', '', '', '', '', ''),
(62, 'TEA2515379B34', '', '', '', '', '', ''),
(63, 'TEA2515346F0E', '', '', '', '', '', ''),
(64, 'TEA251530AE89', '', '', '', '', '', ''),
(65, 'TEA25153BE87E', '', '', '', '', '', ''),
(66, 'TEA251537CBC3', '', '', '', '', '', ''),
(67, 'TEA251537EBD5', '', '', '', '', '', ''),
(68, 'TEA25164B2498', '', '', '', '', '', ''),
(69, 'TEA25170E7499', '', '', '', '', '', ''),
(70, 'TEA2521815A3D', '', '', '', '', '', ''),
(71, 'TEA252239697C', '', '', '', '', '', ''),
(72, 'TEA25231FADBD', '', '', '', '', '', ''),
(73, 'TEA252578A944', '', '', '', '', '', ''),
(74, 'TEA252693C4ED', '', '', '', '', '', ''),
(75, 'TEA252906C726', '', '', '', '', '', ''),
(76, 'TEA2531217EB5', '', '', '', '', '', ''),
(77, 'TEA253126820C', '', '', '', '', '', ''),
(78, 'TEA253182F094', '', '', '', '', '', ''),
(79, 'TEA2531872FC0', '', '', '', '', '', ''),
(80, 'TEA25324549AE', '', '', '', '', '', ''),
(81, 'TEA253273C1ED', '', '', '', '', '', ''),
(82, 'TEA253620D708', 'Bsc in CSE', 'Bsc from CU, Msc From DU', '10 years practical experiences in programming', 'Bsc and Msc', '955-pimage1-trdb004.jpg', ''),
(83, 'TEA25362490BA', '', '', '', '', '', ''),
(84, 'TEA25362B01C9', '', '', '', '', '', ''),
(85, 'TEA2536259E43', '', '', '', '', '', ''),
(86, 'TEA253625A7B2', 'Bsc', 'DU', '10 years experiences', 'Agree', 'ayan zahin_imresizer.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_registration`
--

CREATE TABLE `teacher_registration` (
  `ID` bigint NOT NULL,
  `teacher_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_email` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_mobile` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_registration`
--

INSERT INTO `teacher_registration` (`ID`, `teacher_id`, `teacher_name`, `teacher_email`, `teacher_mobile`, `teacher_password`) VALUES
(27, 'TEA2416113B98', 'কবির হোসাইন', 'skabir85@gmail.com', '01913691185', '123456'),
(28, 'TEA241613C2C0', 'সাইফ মাহমুদ', 'saif@gmail.com', '01913691185', '123456'),
(29, 'TEA241625C317', 'আরিফুল ইসলাম', 'arifulislamgm2@gmail.com', '01977772125', '123456'),
(34, 'TEA25002B0977', 'Abdur Rahim', 'rahim@gmail.com', '01850867451', '123456'),
(37, 'TEA250350C533', 'Md. Shamiul Islam', 'rockyru.phy@gmail.com', '01722302486', '07094337'),
(45, 'TEA251125CE8E', 'Shifat Hasan ', 'shifathasan2030@gmail.com', '01728939545', 'Dhaka@2025'),
(83, 'TEA253620D708', 'hello', 'hello@gmail.com', '01923654489', '123456'),
(84, 'TEA25362490BA', 'sdfsdf', 'kabirsf@gmail.com', '01456236658', '123456'),
(85, 'TEA25362B01C9', 'dsdfsdfd', 'kabirsdfsdf@gmail.com', '01584698852', '123456'),
(86, 'TEA2536259E43', 'sdfdsfs', 'kabir@sdsf', 'sdfsdf', '123456'),
(87, 'TEA253625A7B2', 'kona', 'kona@gmail.com', '01923698856', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_batch`
--
ALTER TABLE `course_batch`
  ADD PRIMARY KEY (`batch_id`);

--
-- Indexes for table `course_category`
--
ALTER TABLE `course_category`
  ADD PRIMARY KEY (`course_category_id`);

--
-- Indexes for table `course_content`
--
ALTER TABLE `course_content`
  ADD PRIMARY KEY (`course_content_id`);

--
-- Indexes for table `course_feedback`
--
ALTER TABLE `course_feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `course_include`
--
ALTER TABLE `course_include`
  ADD PRIMARY KEY (`course_include_id`);

--
-- Indexes for table `course_section`
--
ALTER TABLE `course_section`
  ADD PRIMARY KEY (`course_section_id`);

--
-- Indexes for table `course_type`
--
ALTER TABLE `course_type`
  ADD PRIMARY KEY (`course_type_id`);

--
-- Indexes for table `exam_setup`
--
ALTER TABLE `exam_setup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_start_process`
--
ALTER TABLE `exam_start_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_course`
--
ALTER TABLE `purchase_course`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `question_answer`
--
ALTER TABLE `question_answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_bank`
--
ALTER TABLE `question_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_option`
--
ALTER TABLE `question_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_set`
--
ALTER TABLE `question_set`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `question_set_setup`
--
ALTER TABLE `question_set_setup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_commission`
--
ALTER TABLE `sales_commission`
  ADD PRIMARY KEY (`sales_commission_id`);

--
-- Indexes for table `student_profile`
--
ALTER TABLE `student_profile`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `student_registration`
--
ALTER TABLE `student_registration`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `third_party_id` (`third_party_id`);

--
-- Indexes for table `supper_admin_login`
--
ALTER TABLE `supper_admin_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_course`
--
ALTER TABLE `teacher_course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  ADD PRIMARY KEY (`teacher_profile_id`);

--
-- Indexes for table `teacher_registration`
--
ALTER TABLE `teacher_registration`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_batch`
--
ALTER TABLE `course_batch`
  MODIFY `batch_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1440;

--
-- AUTO_INCREMENT for table `course_category`
--
ALTER TABLE `course_category`
  MODIFY `course_category_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `course_content`
--
ALTER TABLE `course_content`
  MODIFY `course_content_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `course_feedback`
--
ALTER TABLE `course_feedback`
  MODIFY `feedback_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_include`
--
ALTER TABLE `course_include`
  MODIFY `course_include_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `course_section`
--
ALTER TABLE `course_section`
  MODIFY `course_section_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_type`
--
ALTER TABLE `course_type`
  MODIFY `course_type_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exam_setup`
--
ALTER TABLE `exam_setup`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `exam_start_process`
--
ALTER TABLE `exam_start_process`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `purchase_course`
--
ALTER TABLE `purchase_course`
  MODIFY `purchase_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `question_answer`
--
ALTER TABLE `question_answer`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT for table `question_bank`
--
ALTER TABLE `question_bank`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `question_option`
--
ALTER TABLE `question_option`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=648;

--
-- AUTO_INCREMENT for table `question_set`
--
ALTER TABLE `question_set`
  MODIFY `Id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `question_set_setup`
--
ALTER TABLE `question_set_setup`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_commission`
--
ALTER TABLE `sales_commission`
  MODIFY `sales_commission_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `student_profile`
--
ALTER TABLE `student_profile`
  MODIFY `ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6040;

--
-- AUTO_INCREMENT for table `student_registration`
--
ALTER TABLE `student_registration`
  MODIFY `ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6040;

--
-- AUTO_INCREMENT for table `supper_admin_login`
--
ALTER TABLE `supper_admin_login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teacher_course`
--
ALTER TABLE `teacher_course`
  MODIFY `course_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  MODIFY `teacher_profile_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `teacher_registration`
--
ALTER TABLE `teacher_registration`
  MODIFY `ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
