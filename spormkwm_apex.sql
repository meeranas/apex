-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 25, 2025 at 03:03 PM
-- Server version: 11.4.8-MariaDB-cll-lve-log
-- PHP Version: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spormkwm_apex`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('apex-dashboard-cache-livewire-rate-limiter:271c621ff0d23a5c69760bb2f71362a4834eb67e:timer', 'i:1758777840;', 1758777840),
('apex-dashboard-cache-livewire-rate-limiter:271c621ff0d23a5c69760bb2f71362a4834eb67e', 'i:2;', 1758777840),
('apex-dashboard-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:30:{i:0;a:4:{s:1:\"a\";s:1:\"1\";s:1:\"b\";s:16:\"view_any_invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:1;a:4:{s:1:\"a\";s:1:\"2\";s:1:\"b\";s:12:\"view_invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:\"a\";s:1:\"3\";s:1:\"b\";s:14:\"create_invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:4:{s:1:\"a\";s:1:\"4\";s:1:\"b\";s:14:\"update_invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:4:{s:1:\"a\";s:1:\"5\";s:1:\"b\";s:14:\"delete_invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";s:1:\"6\";s:1:\"b\";s:15:\"restore_invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";s:1:\"7\";s:1:\"b\";s:20:\"force_delete_invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";s:1:\"8\";s:1:\"b\";s:20:\"view_any_transaction\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:8;a:4:{s:1:\"a\";s:1:\"9\";s:1:\"b\";s:16:\"view_transaction\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:9;a:4:{s:1:\"a\";s:2:\"10\";s:1:\"b\";s:18:\"create_transaction\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:10;a:4:{s:1:\"a\";s:2:\"11\";s:1:\"b\";s:18:\"update_transaction\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:11;a:4:{s:1:\"a\";s:2:\"12\";s:1:\"b\";s:18:\"delete_transaction\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";s:2:\"13\";s:1:\"b\";s:19:\"restore_transaction\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";s:2:\"14\";s:1:\"b\";s:24:\"force_delete_transaction\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";s:2:\"15\";s:1:\"b\";s:17:\"view_any_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:4:{s:1:\"a\";s:2:\"16\";s:1:\"b\";s:13:\"view_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:16;a:4:{s:1:\"a\";s:2:\"17\";s:1:\"b\";s:15:\"create_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";s:2:\"18\";s:1:\"b\";s:15:\"update_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";s:2:\"19\";s:1:\"b\";s:15:\"delete_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";s:2:\"20\";s:1:\"b\";s:16:\"restore_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";s:2:\"21\";s:1:\"b\";s:21:\"force_delete_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";s:2:\"22\";s:1:\"b\";s:15:\"view_any_issuer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";s:2:\"23\";s:1:\"b\";s:11:\"view_issuer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";s:2:\"24\";s:1:\"b\";s:13:\"create_issuer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";s:2:\"25\";s:1:\"b\";s:13:\"update_issuer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";s:2:\"26\";s:1:\"b\";s:13:\"delete_issuer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";s:2:\"27\";s:1:\"b\";s:14:\"restore_issuer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";s:2:\"28\";s:1:\"b\";s:19:\"force_delete_issuer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";s:2:\"29\";s:1:\"b\";s:14:\"view_dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:29;a:4:{s:1:\"a\";s:2:\"30\";s:1:\"b\";s:12:\"view_reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";s:1:\"1\";s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";s:1:\"2\";s:1:\"b\";s:6:\"issuer\";s:1:\"c\";s:3:\"web\";}}}', 1758864194);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(19, 'المدينة', 1, '2025-09-24 18:22:22', '2025-09-24 18:22:22'),
(18, 'الخبر', 1, '2025-09-24 18:22:10', '2025-09-24 18:22:10'),
(17, 'الدمام', 1, '2025-09-24 18:21:58', '2025-09-24 18:21:58'),
(16, 'جدة', 1, '2025-09-24 18:21:50', '2025-09-24 18:21:50'),
(15, 'الرياض', 1, '2025-09-24 16:50:22', '2025-09-24 16:50:22');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `issuer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(191) NOT NULL,
  `account_number` varchar(191) NOT NULL,
  `representative_name` varchar(191) NOT NULL,
  `mobile_number` varchar(191) NOT NULL,
  `address` text NOT NULL,
  `remarks` text DEFAULT NULL,
  `old_balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `issuer_id`, `customer_name`, `account_number`, `representative_name`, `mobile_number`, `address`, `remarks`, `old_balance`, `created_at`, `updated_at`, `city_id`) VALUES
(25, 8, 'خياط اناقة التميز', '216465', 'راشد محمد', '0555320338', 'شارع الخوارزمي قبل مطعم الرافدين', NULL, 0.00, '2025-09-24 20:24:10', '2025-09-24 20:24:10', 17),
(24, 8, 'خياط الراقي', '152325', 'علي الاموي', '0555320338', 'مقابل كورنيش الخبر', NULL, 1000.00, '2025-09-24 20:22:51', '2025-09-24 20:22:51', 18),
(23, 6, 'خياط القمة', '5', 'Fatima Al-Muqaddam', '0555320338', 'Test', NULL, 4500.00, '2025-09-24 18:31:21', '2025-09-24 18:31:21', 19),
(21, 7, 'خياط الابداع', '3', 'Layla Al-Bahri', '0555320338', 'test', NULL, 10000.00, '2025-09-24 18:30:07', '2025-09-24 18:30:07', 17),
(22, 7, 'خياط اليخت', '4', 'Ahmed Al-Zahrani', '0555320338', 'test', NULL, 3000.00, '2025-09-24 18:30:46', '2025-09-24 18:30:46', 18),
(19, 6, 'خياط الاصالة', '1', 'Sara Al-Saeed', '0555320338', 'test', NULL, 5000.00, '2025-09-24 18:28:23', '2025-09-24 18:28:23', 15),
(20, 8, 'خياط الاناقة', '2', 'Khalid Al-Mansoor', '0555320338', 'test', NULL, 7500.00, '2025-09-24 18:29:14', '2025-09-24 18:29:14', 16);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(191) NOT NULL,
  `goods_delivery_document_number` varchar(191) NOT NULL,
  `invoice_date` date NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `issuer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `due_date` date NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `goods_delivery_document_number`, `invoice_date`, `customer_id`, `issuer_id`, `due_date`, `remarks`, `created_at`, `updated_at`, `city_id`) VALUES
(33, 'INV-20250924-163211-658', '545', '2025-09-24', 25, 6, '2025-10-30', NULL, '2025-09-24 20:32:11', '2025-09-24 20:32:11', NULL),
(32, 'INV-20250924-162817-238', '54444', '2025-09-24', 24, 8, '2025-11-30', NULL, '2025-09-24 20:28:17', '2025-09-24 20:28:17', NULL),
(31, 'INV-20250924-144426-189', '7666', '2025-09-10', 21, 7, '2025-10-21', NULL, '2025-09-24 18:44:26', '2025-09-24 18:44:26', NULL),
(30, 'INV-20250924-144302-555', '7664', '2025-09-24', 23, 6, '2025-11-07', NULL, '2025-09-24 18:43:02', '2025-09-24 18:43:02', NULL),
(29, 'INV-20250924-144102-442', '7663', '2025-09-20', 22, 7, '2025-10-23', NULL, '2025-09-24 18:41:02', '2025-09-24 18:41:02', NULL),
(28, 'INV-20250924-143935-685', '7662', '2025-09-18', 21, 7, '2025-09-26', NULL, '2025-09-24 18:39:35', '2025-09-24 18:39:35', NULL),
(27, 'INV-20250924-143809-141', '7660', '2025-09-24', 20, 8, '2025-10-24', NULL, '2025-09-24 18:38:09', '2025-09-24 18:38:09', NULL),
(26, 'INV-20250924-143547-783', '7658', '2025-09-01', 19, 6, '2025-09-22', NULL, '2025-09-24 18:35:47', '2025-09-24 18:35:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `yards` decimal(10,2) NOT NULL,
  `price_per_yard` decimal(10,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `yards`, `price_per_yard`, `total`, `created_at`, `updated_at`, `product_id`) VALUES
(53, 33, 125.00, 14.00, 1750.00, '2025-09-24 20:32:11', '2025-09-24 20:32:11', 6),
(52, 33, 250.00, 15.00, 3750.00, '2025-09-24 20:32:11', '2025-09-24 20:32:11', 8),
(51, 32, 125.00, 14.00, 1750.00, '2025-09-24 20:28:17', '2025-09-24 20:28:17', 9),
(50, 32, 250.00, 14.00, 3500.00, '2025-09-24 20:28:17', '2025-09-24 20:28:17', 8),
(49, 31, 5.00, 200.00, 1000.00, '2025-09-24 18:44:26', '2025-09-24 18:44:26', 9),
(48, 30, 5.00, 150.00, 750.00, '2025-09-24 18:43:02', '2025-09-24 18:43:02', 6),
(47, 30, 10.00, 200.00, 2000.00, '2025-09-24 18:43:02', '2025-09-24 18:43:02', 9),
(46, 29, 15.00, 100.00, 1500.00, '2025-09-24 18:41:02', '2025-09-24 18:41:02', 8),
(45, 28, 20.00, 150.00, 3000.00, '2025-09-24 18:39:35', '2025-09-24 18:39:35', 6),
(44, 27, 12.00, 100.00, 1200.00, '2025-09-24 18:38:09', '2025-09-24 18:38:09', 8),
(43, 27, 8.00, 20.00, 160.00, '2025-09-24 18:38:09', '2025-09-24 18:38:09', 9),
(42, 26, 5.00, 150.00, 750.00, '2025-09-24 18:35:47', '2025-09-24 18:35:47', 6),
(41, 26, 10.00, 100.00, 1000.00, '2025-09-24 18:35:47', '2025-09-24 18:35:47', 8),
(40, 25, 25.00, 9.80, 245.00, '2025-09-24 17:00:53', '2025-09-24 17:00:53', 6),
(39, 25, 125.00, 9.80, 1225.00, '2025-09-24 17:00:53', '2025-09-24 17:00:53', 7);

-- --------------------------------------------------------

--
-- Table structure for table `issuers`
--

CREATE TABLE `issuers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(191) NOT NULL,
  `id_expiration` date DEFAULT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `issuers`
--

INSERT INTO `issuers` (`id`, `full_name`, `id_expiration`, `photo`, `password`, `user_id`, `created_at`, `updated_at`) VALUES
(8, 'محمد', NULL, NULL, '$2y$12$wrX4wULTK/NNXoDsT5.LnOd2RhKH9ez0zawGh20iJhe9Fhy.0DBJW', 10, '2025-09-24 18:23:55', '2025-09-24 18:23:55'),
(7, 'احمد', NULL, NULL, '$2y$12$8fc.ItMV9YKJ2Dok950Eg.dTkcWmtM.qXiW1J3dLeRL9e7Bik3Oly', 9, '2025-09-24 18:23:29', '2025-09-24 18:23:29'),
(6, 'سالم', NULL, NULL, '$2y$12$Zd4oDFVc0xCEYvhRWEtbZ.pHFuQNJR2FNFO4rU0gZoR2ECXiLCLsC', 8, '2025-09-24 18:23:04', '2025-09-24 18:23:04');

-- --------------------------------------------------------

--
-- Table structure for table `issuer_access`
--

CREATE TABLE `issuer_access` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `issuer_id` bigint(20) UNSIGNED NOT NULL,
  `can_view_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_10_035311_create_customers_table', 1),
(5, '2025_09_10_035317_create_invoices_table', 1),
(6, '2025_09_10_035322_create_transactions_table', 1),
(7, '2025_09_10_035327_create_invoice_items_table', 1),
(8, '2025_09_11_183836_create_transaction_items_table', 1),
(9, '2025_09_13_161939_create_issuers_table', 1),
(10, '2025_09_13_161940_create_issuer_access_table', 1),
(11, '2025_09_13_161941_modify_invoices_add_issuer_id', 1),
(12, '2025_09_13_161942_modify_transactions_add_issuer_id', 1),
(13, '2025_09_13_162351_create_permission_tables', 1),
(14, '2025_09_13_183323_add_issuer_id_to_customers_table', 1),
(15, '2025_09_13_185644_remove_issuer_name_from_invoices_table', 1),
(16, '2025_09_13_185649_remove_issuer_name_from_transactions_table', 1),
(17, '2025_09_15_024957_create_cities_table', 1),
(18, '2025_09_15_025006_create_products_table', 1),
(19, '2025_09_15_025128_add_city_id_to_customers_table', 1),
(20, '2025_09_15_025134_add_city_id_to_invoices_table', 1),
(21, '2025_09_15_025140_add_city_id_to_transactions_table', 1),
(22, '2025_09_15_025145_add_product_id_to_invoice_items_table', 1),
(23, '2025_09_15_025151_add_product_id_to_transaction_items_table', 1),
(24, '2025_09_15_034358_add_unique_constraint_to_cities_name', 1),
(25, '2025_09_15_034757_remove_is_active_from_cities_table', 1),
(26, '2025_09_15_185050_remove_city_field_from_customers_table', 1),
(27, '2025_09_15_190000_remove_customer_name_and_city_from_invoices_table', 1),
(28, '2025_09_16_180001_remove_item_name_from_invoice_items_table', 1),
(29, '2025_09_16_182112_add_product_id_to_invoice_items_table_fix', 1),
(30, '2025_09_16_182244_fix_invoice_items_table_schema', 1),
(31, '2025_09_16_183913_remove_customer_name_and_city_from_transactions_table', 1),
(32, '2025_09_16_185002_remove_item_name_from_transaction_items_table', 1),
(33, '2025_09_16_215630_add_unique_constraint_to_products_name', 1),
(34, '2025_09_18_084842_add_product_id_to_invoice_items_table', 2),
(35, '2025_09_18_160206_remove_item_number_from_invoice_items_and_transaction_items_tables', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view_any_invoice', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(2, 'view_invoice', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(3, 'create_invoice', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(4, 'update_invoice', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(5, 'delete_invoice', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(6, 'restore_invoice', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(7, 'force_delete_invoice', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(8, 'view_any_transaction', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(9, 'view_transaction', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(10, 'create_transaction', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(11, 'update_transaction', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(12, 'delete_transaction', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(13, 'restore_transaction', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(14, 'force_delete_transaction', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(15, 'view_any_customer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(16, 'view_customer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(17, 'create_customer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(18, 'update_customer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(19, 'delete_customer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(20, 'restore_customer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(21, 'force_delete_customer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(22, 'view_any_issuer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(23, 'view_issuer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(24, 'create_issuer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(25, 'update_issuer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(26, 'delete_issuer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(27, 'restore_issuer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(28, 'force_delete_issuer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(29, 'view_dashboard', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(30, 'view_reports', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `number` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `number`, `created_at`, `updated_at`) VALUES
(8, 'X', '2', '2025-09-24 18:21:15', '2025-09-24 18:21:15'),
(9, 'Z', '3', '2025-09-24 18:21:31', '2025-09-24 18:21:31'),
(6, 'Y', '1', '2025-09-24 16:56:38', '2025-09-24 18:21:03');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(2, 'issuer', 'web', '2025-09-17 07:49:57', '2025-09-17 07:49:57');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(8, 2),
(9, 1),
(9, 2),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(29, 2),
(30, 1),
(30, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('debit','return_goods','discount') NOT NULL,
  `document_number` varchar(191) NOT NULL,
  `transaction_date` date NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `issuer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `payment_method` varchar(191) DEFAULT NULL,
  `total_amount` decimal(15,2) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `type`, `document_number`, `transaction_date`, `customer_id`, `issuer_id`, `amount`, `payment_method`, `total_amount`, `remarks`, `created_at`, `updated_at`, `city_id`) VALUES
(40, 'debit', '54', '2025-09-24', 24, 8, 1250.00, NULL, 1250.00, NULL, '2025-09-24 20:33:32', '2025-09-24 20:33:32', NULL),
(39, 'return_goods', '5', '2025-09-24', 23, 6, 0.00, NULL, 45.00, NULL, '2025-09-24 19:06:17', '2025-09-24 19:06:17', NULL),
(38, 'return_goods', '4', '2025-09-24', 22, 7, 0.00, NULL, 20.00, NULL, '2025-09-24 19:03:57', '2025-09-24 19:03:57', NULL),
(37, 'return_goods', '3', '2025-09-24', 21, 7, 0.00, NULL, 150.00, NULL, '2025-09-24 19:02:38', '2025-09-24 19:02:38', NULL),
(36, 'return_goods', '2', '2025-09-24', 20, 8, 0.00, NULL, 200.00, NULL, '2025-09-24 19:01:20', '2025-09-24 19:01:20', NULL),
(35, 'return_goods', '1', '2025-09-24', 19, 6, 0.00, NULL, 125.00, NULL, '2025-09-24 18:59:16', '2025-09-24 18:59:16', NULL),
(34, 'discount', '5', '2025-09-24', 23, 6, 75.00, NULL, 75.00, NULL, '2025-09-24 18:55:59', '2025-09-24 18:55:59', NULL),
(33, 'discount', '4', '2025-09-24', 22, 7, 50.00, NULL, 50.00, NULL, '2025-09-24 18:55:15', '2025-09-24 18:55:15', NULL),
(32, 'discount', '3', '2025-09-24', 21, 7, 400.00, NULL, 400.00, NULL, '2025-09-24 18:54:31', '2025-09-24 18:54:31', NULL),
(31, 'discount', '2', '2025-09-24', 20, 8, 200.00, NULL, 200.00, NULL, '2025-09-24 18:53:39', '2025-09-24 18:53:39', NULL),
(30, 'discount', '1', '2025-09-24', 19, 6, 100.00, NULL, 100.00, NULL, '2025-09-24 18:52:53', '2025-09-24 18:52:53', NULL),
(29, 'debit', '5', '2025-09-24', 23, 6, 100.00, NULL, 100.00, NULL, '2025-09-24 18:49:56', '2025-09-24 18:49:56', NULL),
(28, 'debit', '4', '2025-09-24', 22, 7, 150.00, NULL, 150.00, NULL, '2025-09-24 18:48:57', '2025-09-24 18:48:57', NULL),
(26, 'debit', '2', '2025-09-25', 20, 8, 300.00, 'bank_transfer', 300.00, NULL, '2025-09-24 18:46:58', '2025-09-24 18:46:58', NULL),
(27, 'debit', '3', '2025-09-24', 21, 7, 500.00, 'check', 500.00, NULL, '2025-09-24 18:47:55', '2025-09-24 18:47:55', NULL),
(25, 'debit', '1', '2025-09-24', 19, 6, 200.00, 'cash', 200.00, NULL, '2025-09-24 18:46:02', '2025-09-24 18:46:02', NULL),
(41, 'return_goods', '45345', '2025-09-24', 24, 8, 0.00, NULL, 1400.00, NULL, '2025-09-24 20:35:13', '2025-09-24 20:35:13', NULL),
(42, 'discount', '5454', '2025-09-24', 24, 8, 1000.00, NULL, 1000.00, NULL, '2025-09-24 20:36:00', '2025-09-24 20:36:00', NULL),
(43, 'debit', '254', '2025-09-24', 25, 6, 2000.00, NULL, 2000.00, NULL, '2025-09-24 20:37:18', '2025-09-24 20:37:18', NULL),
(44, 'discount', '352354', '2025-09-24', 25, 6, 500.00, NULL, 500.00, NULL, '2025-09-24 20:38:38', '2025-09-24 20:38:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `yards` decimal(10,2) NOT NULL,
  `price_per_yard` decimal(10,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_items`
--

INSERT INTO `transaction_items` (`id`, `transaction_id`, `yards`, `price_per_yard`, `total`, `created_at`, `updated_at`, `product_id`) VALUES
(14, 41, 100.00, 14.00, 1400.00, '2025-09-24 20:35:13', '2025-09-24 20:35:13', 8),
(13, 39, 0.10, 150.00, 15.00, '2025-09-24 19:06:17', '2025-09-24 19:06:17', 6),
(12, 38, 0.20, 100.00, 20.00, '2025-09-24 19:03:57', '2025-09-24 19:03:57', 8),
(11, 37, 1.00, 150.00, 150.00, '2025-09-24 19:02:38', '2025-09-24 19:02:38', 6),
(10, 36, 1.00, 100.00, 100.00, '2025-09-24 19:01:20', '2025-09-24 19:01:20', 8),
(9, 35, 0.50, 150.00, 75.00, '2025-09-24 18:59:16', '2025-09-24 18:59:16', 6),
(8, 23, 25.00, 9.80, 245.00, '2025-09-24 17:08:25', '2025-09-24 17:08:25', 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', NULL, '$2y$12$VbTdmWsaKpc1iFFey4cH..bv7SdCSpy.9GxZOGQy4PiTe7//.4jW2', 'pxxMsTd1VxQsBWmi4ZWPrCN5l1KdccKmv2p3FbOwdqoz2e9q1HUyjP64nRgw', '2025-09-17 07:49:57', '2025-09-17 07:49:57'),
(10, 'admin@example.com', 'test2@test.com', NULL, '$2y$12$ndoQ/XsG3R1sO98BBl8DH.fjoKtvcoqrP4vVrsWC2m5vVm0UZc7qO', NULL, '2025-09-24 18:23:54', '2025-09-24 18:23:54'),
(9, 'admin@example.com', 'test@test.com', NULL, '$2y$12$hfBLeGPIl0Ya1pcsupNpU.WISpFnH.PMwp6cepGM.YDEtlvH516lW', NULL, '2025-09-24 18:23:29', '2025-09-24 18:23:29'),
(8, 'admin@example.com', 'salem.h11@gmail.com', NULL, '$2y$12$UKZR56Dc0AtFHrIqUi.2ju9pOKzVde0fFX./pATHOu31Ae4kPajKq', NULL, '2025-09-24 18:23:03', '2025-09-24 18:23:03'),
(7, 'علي الدحي', 'ALI@GMAIL.COM', NULL, '$2y$12$.pE98bkRcusqXwbP5eepfeiK0bzwe02BGGa0u2mZ118TbXGottnfa', NULL, '2025-09-24 16:54:02', '2025-09-24 16:54:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_account_number_unique` (`account_number`),
  ADD KEY `customers_issuer_id_foreign` (`issuer_id`),
  ADD KEY `customers_city_id_foreign` (`city_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `invoices_customer_id_foreign` (`customer_id`),
  ADD KEY `invoices_issuer_id_foreign` (`issuer_id`),
  ADD KEY `invoices_city_id_foreign` (`city_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `issuers`
--
ALTER TABLE `issuers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issuers_user_id_foreign` (`user_id`);

--
-- Indexes for table `issuer_access`
--
ALTER TABLE `issuer_access`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `issuer_access_issuer_id_can_view_id_unique` (`issuer_id`,`can_view_id`),
  ADD KEY `issuer_access_can_view_id_foreign` (`can_view_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`) USING HASH;

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_name_unique` (`name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`) USING HASH;

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_customer_id_foreign` (`customer_id`),
  ADD KEY `transactions_issuer_id_foreign` (`issuer_id`),
  ADD KEY `transactions_city_id_foreign` (`city_id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_items_transaction_id_foreign` (`transaction_id`),
  ADD KEY `transaction_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `issuers`
--
ALTER TABLE `issuers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `issuer_access`
--
ALTER TABLE `issuer_access`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
