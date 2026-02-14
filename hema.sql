-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 18, 2025 at 07:12 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hema`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `created_at`, `updated_at`, `name`, `email`, `phone`, `img`, `password`, `deleted_at`, `is_activate`) VALUES
(1, NULL, '2025-10-07 18:33:45', 'AmrHussien', 'hema@gmail.com', '123456', 'admin/assets/images/admins/175986922558122.webp', '$2y$10$NJFN1sueb26Fw4t2zHWEqOIw0tjSQaZw9BpkeXqKFYoPuo9cLh//2', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `user_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `created_at`, `updated_at`, `deleted_at`, `is_activate`, `user_id`, `product_id`, `quantity`) VALUES
(7, '2025-10-12 23:32:49', '2025-10-12 23:33:04', NULL, 1, 3, 2, 3),
(8, '2025-10-12 23:32:52', '2025-10-12 23:32:52', NULL, 1, 3, 1, 1),
(9, '2025-10-18 01:16:42', '2025-10-18 01:16:42', NULL, 1, 3, 4, 1),
(10, '2025-10-18 01:17:45', '2025-10-18 01:17:45', NULL, 1, 3, 4, 2),
(11, '2025-10-18 01:18:06', '2025-10-18 01:18:06', NULL, 1, 3, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `created_at`, `updated_at`, `name`, `img`, `deleted_at`, `is_activate`) VALUES
(1, '2025-10-07 23:19:58', '2025-10-07 23:20:54', 'Yvette Kline 22', 'admin/assets/images/categories/175988645414063.png', NULL, 1),
(2, '2025-10-07 23:20:10', '2025-10-07 23:20:10', 'Asher Reyes', 'admin/assets/images/categories/175988641019152.png', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `created_at`, `updated_at`, `mobile`, `email`, `location`, `details`, `deleted_at`, `is_activate`) VALUES
(1, '2025-10-10 23:36:15', '2025-10-10 23:36:15', '12313213', 'asd@asda.com', 'sad asd asd asd asdasdasdas', 'asdasdsad asdasdasd asdasdasd asdasdasd asdasdasd', NULL, 1),
(2, '2025-10-14 05:34:22', '2025-10-14 05:34:22', '0123456789', 'email@gmail.com', 'location', 'details', NULL, 1),
(3, '2025-10-14 05:34:27', '2025-10-14 05:34:27', '0123456789', 'email@gmail.com', 'location', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `created_at`, `updated_at`, `name`, `deleted_at`, `is_activate`) VALUES
(1, '2025-10-08 00:26:31', '2025-10-08 00:26:31', 'Colby Combs', NULL, 1),
(2, '2025-10-08 00:26:35', '2025-10-08 00:26:45', 'Brian Gomez 222', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `type` tinyint DEFAULT NULL COMMENT '1 => amount, 2 => percentage',
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `created_at`, `updated_at`, `name`, `amount`, `type`, `deleted_at`, `is_activate`) VALUES
(1, '2025-10-10 18:03:24', '2025-10-10 18:03:24', 'Dieter Dennis', 70, 1, NULL, 1),
(2, '2025-10-10 18:03:34', '2025-10-10 18:03:34', 'Cassandra Blankenship', 55, 1, NULL, 1),
(3, '2025-10-10 18:03:39', '2025-10-10 18:05:07', 'Ava Battle 22', 12, 1, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `created_at`, `updated_at`, `user_id`, `product_id`, `deleted_at`, `is_activate`) VALUES
(1, '2025-10-17 22:52:58', '2025-10-17 22:52:58', 3, 1, NULL, 1),
(2, '2025-10-17 22:52:58', '2025-10-17 22:52:58', 3, 2, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `message` text COLLATE utf8mb4_unicode_ci,
  `vision` text COLLATE utf8mb4_unicode_ci,
  `asks` text COLLATE utf8mb4_unicode_ci,
  `abouts` text COLLATE utf8mb4_unicode_ci,
  `terms` text COLLATE utf8mb4_unicode_ci,
  `privacy_policies` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id`, `created_at`, `updated_at`, `mobile`, `email`, `vat`, `desc`, `message`, `vision`, `asks`, `abouts`, `terms`, `privacy_policies`, `deleted_at`, `is_activate`) VALUES
(1, '2025-10-10 19:21:48', '2025-10-12 23:51:25', '0101012222', 'hema@gmail.com', '10', NULL, NULL, NULL, NULL, '{\"10000001\":{\"head\":\"Martina Mitchell\",\"body\":\"Lewis Atkins\"},\"10000002\":{\"head\":\"Simon Stephens\",\"body\":\"Carly Medina\"}}', '{\"1000600001\":{\"head\":\"Alvin Arnold\",\"body\":\"Mary Alexander\"},\"1000600002\":{\"head\":\"Elaine Maddox\",\"body\":\"Renee Ratliff\"},\"1000300001\":{\"head\":\"Adrian Owens\",\"body\":\"Alfonso Summers\"}}', '{\"100060001\":{\"head\":\"Chandler Barr\",\"body\":\"Alana Kirby\"},\"100060003\":{\"head\":\"Lester Strickland\",\"body\":\"Kerry Chapman\"},\"100030001\":{\"head\":\"Nero Mccarty\",\"body\":\"Zorita Tucker\"}}', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_10_19_000000_create_admins_table', 1),
(6, '2023_10_19_000000_create_users_table', 2),
(7, '2023_10_19_000000_create_categories_table', 3),
(8, '2023_10_19_000000_create_countries_table', 4),
(9, '2023_10_19_000000_create_products_table', 4),
(10, '2023_10_19_000000_create_cart_table', 5),
(11, '2023_10_19_000000_create_coupons_table', 5),
(12, '2023_10_19_000000_create_orderItems_table', 5),
(13, '2023_10_19_000000_create_orders_table', 5),
(14, '2023_10_19_000000_create_info_table', 6),
(15, '2023_10_19_000000_create_contacts_table', 7),
(16, '2023_10_18_000000_create_cart_table', 8),
(17, '2023_10_19_000000_create_favorites_table', 8),
(18, '2023_10_19_000000_create_order_timeline_table', 9),
(19, '2023_10_19_000000_create_offers_table', 10),
(20, '2023_10_19_000000_create_offers_table copy', 11),
(21, '2023_10_19_000000_create_ratings_table', 12),
(22, '2023_10_19_000000_create_order_partial_receive_table', 13),
(23, '2023_10_19_000000_create_order_partial_receive_table copy', 14);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `files` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `delivery_time` datetime DEFAULT NULL,
  `warranty` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `provider_id` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `status` tinyint DEFAULT NULL COMMENT '1 => pending, 2 => accepted, 3 => rejected',
  `rejected_reson` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `created_at`, `updated_at`, `files`, `cost`, `delivery_time`, `warranty`, `deleted_at`, `is_activate`, `provider_id`, `order_id`, `status`, `rejected_reson`) VALUES
(1, '2025-10-17 07:34:52', '2025-10-17 07:34:52', 'admin/assets/images/quotations/176069381589768.pdf,admin/assets/images/quotations/176069381538058.png', 1500.00, '2025-10-17 09:08:28', 'warranty', NULL, 1, 3, 12, 1, NULL),
(2, '2025-10-17 07:36:55', '2025-10-17 07:36:55', 'admin/assets/images/quotations/176069381589768.pdf,admin/assets/images/quotations/176069381538058.png', 1000.00, '2025-10-17 09:08:28', 'warranty', NULL, 1, 3, 12, 1, NULL),
(4, '2025-10-17 07:41:00', '2025-10-18 00:02:31', 'admin/assets/images/quotations/176069406066035.pdf,admin/assets/images/quotations/176069406012375.png', 1200.00, '2025-10-27 09:08:28', 'warranty', NULL, 1, 3, 12, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `device_category_id` int DEFAULT NULL,
  `coupon_id` int DEFAULT NULL,
  `provider_id` int DEFAULT NULL,
  `offer_id` int DEFAULT NULL,
  `order_type` int DEFAULT NULL COMMENT '1 => order, 2 => quotation, 3 => maintenace',
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` tinyint DEFAULT NULL COMMENT '1 => unpaid, 2=> paid',
  `request_type` tinyint DEFAULT NULL COMMENT '1 => Immediate Request, 2 => Scheduled Request',
  `delivery_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frequency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_start_date` datetime DEFAULT NULL,
  `vat` int DEFAULT NULL,
  `vat_amount` decimal(6,2) DEFAULT NULL,
  `delivery_fee` decimal(6,2) DEFAULT NULL,
  `discount` decimal(6,2) DEFAULT NULL,
  `items_cost` decimal(6,2) DEFAULT NULL,
  `total_before_discount` decimal(6,2) DEFAULT NULL,
  `total_cost` decimal(6,2) DEFAULT NULL,
  `address` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `files` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_name` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quotation_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_time_picker` datetime DEFAULT NULL,
  `preferred_service_time` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `created_at`, `updated_at`, `user_id`, `device_category_id`, `coupon_id`, `provider_id`, `offer_id`, `order_type`, `payment_type`, `payment_status`, `request_type`, `delivery_duration`, `frequency`, `schedule_start_date`, `vat`, `vat_amount`, `delivery_fee`, `discount`, `items_cost`, `total_before_discount`, `total_cost`, `address`, `files`, `notes`, `device_name`, `budget`, `quotation_type`, `serial_number`, `issue_description`, `date_time_picker`, `preferred_service_time`, `deleted_at`) VALUES
(1, '2025-10-13 15:02:21', '2025-10-13 15:02:21', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 10, 286.60, NULL, 0.00, 2866.00, 3152.60, 3152.60, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '2025-10-13 15:09:39', '2025-10-13 15:09:39', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 10, 286.60, NULL, 0.00, 2866.00, 3152.60, 3152.60, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2025-10-13 15:45:34', '2025-10-13 15:45:34', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 10, 286.60, NULL, 0.00, 2866.00, 3152.60, 3152.60, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '2025-10-14 04:40:43', '2025-10-14 04:40:43', 3, NULL, 3, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 10, 286.60, NULL, 343.92, 2866.00, 3152.60, 2808.68, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '2025-10-14 04:46:21', '2025-10-14 04:46:21', 3, NULL, 3, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 10, 286.60, NULL, 12.00, 2866.00, 3152.60, 3140.60, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '2025-10-14 05:04:23', '2025-10-14 05:04:23', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 10, 286.60, NULL, 0.00, 2866.00, 3152.60, 3152.60, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '2025-10-17 05:51:20', '2025-10-17 05:51:20', 3, NULL, NULL, 3, NULL, 2, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin/assets/images/quotations/176068748037849.pdf,admin/assets/images/quotations/176068748064153.png', 'aaaaaaa aaaaaaaaaaaa aaaaaaaaaaaa', NULL, '20000', NULL, NULL, NULL, '2025-10-17 09:08:28', NULL, NULL),
(11, '2025-10-17 06:21:05', '2025-10-17 06:21:05', 3, NULL, NULL, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '2025-10-17 06:30:04', '2025-10-18 16:34:10', 3, 1, NULL, 3, 4, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 50.00, NULL, NULL, NULL, NULL, 'address address address', NULL, NULL, 'device_name device_name device_name', NULL, NULL, 'serial_number serial_number serial_number', 'issue_description issue_description issue_description issue_description', NULL, '2025-10-17 09:08:28', NULL),
(13, '2025-10-17 06:52:07', '2025-10-17 06:52:07', 3, NULL, NULL, 3, NULL, 2, NULL, NULL, 2, 'delivery duration', 'frequency', '2025-10-17 09:08:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aaaaaaa aaaaaaaaaaaa aaaaaaaaaaaa', NULL, '20000', NULL, NULL, NULL, '2025-10-17 09:08:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `item_price` decimal(6,2) DEFAULT NULL,
  `total_price` decimal(6,2) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `created_at`, `updated_at`, `order_id`, `product_id`, `quantity`, `item_price`, `total_price`, `deleted_at`, `is_activate`) VALUES
(1, NULL, NULL, 1, 2, 3, 682.00, 2046.00, NULL, 1),
(2, NULL, NULL, 1, 1, 1, 820.00, 820.00, NULL, 1),
(3, NULL, NULL, 2, 2, 3, 682.00, 2046.00, NULL, 1),
(4, NULL, NULL, 2, 1, 1, 820.00, 820.00, NULL, 1),
(5, '2025-10-13 15:45:34', '2025-10-13 15:45:34', 3, 2, 3, 682.00, 2046.00, NULL, 1),
(6, '2025-10-13 15:45:34', '2025-10-13 15:45:34', 3, 1, 1, 820.00, 820.00, NULL, 1),
(13, '2025-10-14 04:40:43', '2025-10-14 04:40:43', 7, 2, 3, 682.00, 2046.00, NULL, 1),
(14, '2025-10-14 04:40:43', '2025-10-14 04:40:43', 7, 1, 1, 820.00, 820.00, NULL, 1),
(15, '2025-10-14 04:46:21', '2025-10-14 04:46:21', 8, 2, 3, 682.00, 2046.00, NULL, 1),
(16, '2025-10-14 04:46:21', '2025-10-14 04:46:21', 8, 1, 1, 820.00, 820.00, NULL, 1),
(17, '2025-10-14 05:04:23', '2025-10-14 05:04:23', 12, 2, 3, 682.00, 2046.00, NULL, 1),
(18, '2025-10-14 05:04:23', '2025-10-14 05:04:23', 12, 1, 1, 820.00, 820.00, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_partial_receive`
--

CREATE TABLE `order_partial_receive` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `offer_id` int DEFAULT NULL,
  `files` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_quantity` int DEFAULT NULL,
  `reason_for_partial` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `received_all_quantity` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_partial_receive`
--

INSERT INTO `order_partial_receive` (`id`, `created_at`, `updated_at`, `order_id`, `user_id`, `offer_id`, `files`, `received_quantity`, `reason_for_partial`, `deleted_at`, `is_activate`, `received_all_quantity`) VALUES
(1, '2025-10-18 05:46:07', '2025-10-18 05:46:07', 12, 3, NULL, NULL, 20, 'reason for partial', NULL, 1, 0),
(2, '2025-10-18 05:46:59', '2025-10-18 05:46:59', 12, 3, NULL, 'admin/assets/images/orders/176077361962994.png,admin/assets/images/orders/176077361964279.png', 20, 'reason for partial', NULL, 1, 0),
(3, '2025-10-18 05:47:29', '2025-10-18 05:47:29', 13, 3, NULL, 'admin/assets/images/orders/176077364991405.png,admin/assets/images/orders/176077364967018.png', NULL, NULL, NULL, 1, 1),
(4, '2025-10-18 06:01:04', '2025-10-18 06:01:04', 8, 3, NULL, 'admin/assets/images/orders/176077446496552.png,admin/assets/images/orders/176077446454646.png', 2000, 'reason for partial', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_timeline`
--

CREATE TABLE `order_timeline` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `timeline_no` int DEFAULT NULL COMMENT '1 => Order Created, 2 => Confirmed by Supplier, 3 => Processing, 4 => Shipped, 5 => Delivered, 6 => Completed',
  `action_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_timeline`
--

INSERT INTO `order_timeline` (`id`, `created_at`, `updated_at`, `user_id`, `order_id`, `timeline_no`, `action_at`, `deleted_at`, `is_activate`) VALUES
(2, '2025-10-14 04:40:43', '2025-10-14 04:40:43', 3, 7, 1, '2025-10-14 06:40:43', NULL, 1),
(3, '2025-10-14 04:46:21', '2025-10-14 04:46:21', 3, 8, 1, '2025-10-14 06:46:21', NULL, 1),
(4, '2025-10-14 05:04:23', '2025-10-14 05:04:23', 3, 9, 1, '2025-10-14 07:04:23', NULL, 1),
(5, '2025-10-17 05:51:20', '2025-10-17 05:51:20', 3, 10, 1, '2025-10-17 07:51:20', NULL, 1),
(6, '2025-10-17 06:21:05', '2025-10-17 06:21:05', 3, 11, 1, '2025-10-17 08:21:05', NULL, 1),
(7, '2025-10-17 06:30:04', '2025-10-17 06:30:04', 3, 12, 1, '2025-10-17 08:30:04', NULL, 1),
(8, '2025-10-17 06:52:07', '2025-10-17 06:52:07', 3, 13, 1, '2025-10-17 08:52:07', NULL, 1),
(9, '2025-10-17 22:10:00', '2025-10-17 22:10:00', 3, 12, 2, '2025-10-18 00:10:00', NULL, 1),
(10, '2025-10-17 22:14:08', '2025-10-17 22:14:08', 3, 12, 3, '2025-10-18 00:14:08', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `desc` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL,
  `stock_quantity` int DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imgs` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imaging_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manufacture_date` date DEFAULT NULL,
  `production_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimensions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warranty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin_id` int DEFAULT NULL,
  `provider_id` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `created_at`, `updated_at`, `name`, `category_id`, `desc`, `price`, `stock_quantity`, `img`, `imgs`, `imaging_type`, `manufacture_date`, `production_date`, `expiry_date`, `weight`, `dimensions`, `warranty`, `origin_id`, `provider_id`, `deleted_at`, `is_activate`) VALUES
(1, '2025-10-08 01:12:27', '2025-10-08 01:12:27', 'Clayton Gomez', 2, 'Veniam facilis offi', 820.00, 807, 'admin/assets/images/products/175989314777281.png', 'admin/assets/images/products/175989314759419.png,admin/assets/images/products/175989314738878.png,admin/assets/images/products/175989314752094.png', 'Accusamus necessitat', '2024-12-24', '2025-01-11', '2025-12-26', 'Quis doloribus dolor', 'Enim fugiat cillum a', 'Adipisci quae nihil', 2, NULL, NULL, 1),
(2, '2025-10-08 01:13:18', '2025-10-08 01:24:19', 'Hope Carr 2222', 1, 'Possimus porro qui 00', 682.00, 68100, 'admin/assets/images/products/175989385946497.png', 'admin/assets/images/products/175989319839038.png,admin/assets/images/products/175989319847555.png,admin/assets/images/products/175989319857839.png', 'Consequuntur tempora 00', '2023-11-13', '2025-06-27', '2025-09-09', 'Commodi reprehenderi', 'Maiores qui qui sint', 'Esse ut unde nobis v', 2, NULL, NULL, 1),
(3, '2025-10-17 22:47:30', '2025-10-17 22:47:30', 'name name', 2, 'desc desc desc', 100.00, 500, 'admin/assets/images/products/176074845041950.png', 'admin/assets/images/products/176074845095536.png,admin/assets/images/products/176074845037741.png', 'imaging type', '2025-10-17', '2025-10-17', '2025-12-17', 'weight', 'dimensions', 'warranty', 2, 3, NULL, 1),
(4, '2025-10-17 22:52:04', '2025-10-17 23:10:09', 'name name 2', 2, 'desc desc desc 222', 150.00, 500, 'admin/assets/images/products/176074872416367.png', 'admin/assets/images/products/176074872470575.png,admin/assets/images/products/176074872438653.png', NULL, '2025-10-17', '2025-10-17', '2025-12-17', 'weight 22', 'dimensions', 'warranty', 2, 3, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `rating` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `forable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forable_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `created_at`, `updated_at`, `comment`, `rating`, `user_id`, `forable_type`, `forable_id`, `deleted_at`, `is_activate`) VALUES
(1, '2025-10-18 03:29:51', '2025-10-18 03:29:51', 'test test test', 3, 3, 'App\\Models\\User', 3, NULL, 0),
(2, '2025-10-18 03:30:56', '2025-10-18 03:30:56', 'test test test', 3, 3, 'App\\Models\\Product', 4, NULL, 0),
(3, '2025-10-18 03:31:02', '2025-10-18 03:31:02', 'test test test', 5, 3, 'App\\Models\\Product', 4, NULL, 0),
(4, '2025-10-18 03:31:06', '2025-10-18 03:31:06', 'test test test', 4, 3, 'App\\Models\\Product', 4, NULL, 0),
(5, '2025-10-18 03:31:09', '2025-10-18 03:54:23', 'test test test', 2, 3, 'App\\Models\\Product', 4, NULL, 1),
(6, '2025-10-18 03:31:13', '2025-10-18 03:54:11', 'test test test', 5, 3, 'App\\Models\\Product', 4, NULL, 1),
(7, '2025-10-18 03:31:31', '2025-10-18 03:31:31', 'test test test', 5, 3, 'App\\Models\\User', 3, NULL, 0),
(8, '2025-10-18 03:31:35', '2025-10-18 03:31:35', 'test test test', 4, 3, 'App\\Models\\User', 3, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_verified_at` timestamp NULL DEFAULT NULL,
  `iban` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cr_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cr_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fcm_token` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` tinyint DEFAULT NULL COMMENT '1 => clients, 2 => providers, 3 => logistics',
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `mobile`, `mobile_verified_at`, `iban`, `branch`, `tax_number`, `cr_number`, `cr_document`, `location`, `img`, `fcm_token`, `code`, `user_type`, `deleted_at`, `is_activate`) VALUES
(1, 'jesu@mailinator.com', 'mezi@mailinator.com', NULL, '$2y$10$fUyB2Oi.63.zzbmYZPxS7eQlNDZn1b/sn6sPlEm0zK7NgrtRH.9f.', NULL, '2025-10-07 22:28:43', '2025-10-07 22:28:43', '1231231213213', NULL, NULL, 'Voluptatem expedita', '92221321kk', '254123132l', 'admin/assets/images/users/176015127150451.png', 'Nam fugiat tempor vo', 'admin/assets/images/users/175988332346772.png', NULL, NULL, 2, NULL, 1),
(2, 'ruvyrin@mailinator.com', 'fyly@mailinator.com', NULL, '$2y$10$WCIX5A8T2nbtJHWwwwFZIOSW1TK3ty/oQ9tCXSNe2fZ9C/.o5Z0P2', NULL, '2025-10-07 22:31:27', '2025-10-07 22:31:27', '98784654655', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin/assets/images/users/175988348799653.png', NULL, NULL, 1, NULL, 1),
(3, 'amr 4442', 'amr22@gmail.com', '2025-10-17 21:00:23', '$2y$10$VV23TW4CHm58U3KuCnnB9OyBW3PPWi9ZdrljvYPaOcDEgEhR22pee', NULL, '2025-10-11 00:07:27', '2025-10-17 21:01:46', '+96612345678002', '2025-10-17 21:00:23', 'iban-data', 'branch', '123123132', '123123123123', NULL, 'location', NULL, 'cXmf-bClTg68yTEcnujtvu:APA91bFQ9uDF3lki7GPv2xaA73187SLjdsvP8hOs2c5hBsMbvLULn7Tvp2PMRSVmJlmEkkB9AWaCp-apPbLS_mUezF2pIfOuhg20Ic8J6m46TCP4M5Kl91M', NULL, 2, NULL, 1),
(4, 'amr 444', 'amr222@gmail.com', NULL, '$2y$10$QmskJkeIaWyVPF8QsbewJel/dnzRKmxFqMYsPmGrAgToq.KFrZlyi', NULL, '2025-10-11 00:44:45', '2025-10-11 00:44:45', '+966123456780020', NULL, 'iban-data0', NULL, NULL, NULL, NULL, NULL, NULL, 'cXmf-bClTg68yTEcnujtvu:APA91bFQ9uDF3lki7GPv2xaA73187SLjdsvP8hOs2c5hBsMbvLULn7Tvp2PMRSVmJlmEkkB9AWaCp-apPbLS_mUezF2pIfOuhg20Ic8J6m46TCP4M5Kl91M', '1111', 1, NULL, 1),
(5, 'amr 4443', 'amr223@gmail.com', NULL, '$2y$10$v0PsS8Sq43JnvilTajtXuutwrv7pdHyJ1KwBRdm8EO6AHhOMJJky2', NULL, '2025-10-11 00:49:37', '2025-10-11 00:49:37', '+966123456780023', NULL, 'iban-data3', 'branch', '123123132', '123123123123', NULL, 'location', NULL, 'cXmf-bClTg68yTEcnujtvu:APA91bFQ9uDF3lki7GPv2xaA73187SLjdsvP8hOs2c5hBsMbvLULn7Tvp2PMRSVmJlmEkkB9AWaCp-apPbLS_mUezF2pIfOuhg20Ic8J6m46TCP4M5Kl91M', '1111', 2, NULL, 1),
(6, 'amr 4444', 'amr224@gmail.com', NULL, '$2y$10$Q1HwsTFaTFtdV5LiSb9on.tFDmZXQiqs/BX9d/.8qE3mHb5cMQlbO', NULL, '2025-10-11 00:54:31', '2025-10-11 00:54:31', '+966123456780024', NULL, 'iban-data4', 'branch', '123123132', '123123123123', 'admin/assets/images/users/176015127150451.png', 'location', NULL, 'cXmf-bClTg68yTEcnujtvu:APA91bFQ9uDF3lki7GPv2xaA73187SLjdsvP8hOs2c5hBsMbvLULn7Tvp2PMRSVmJlmEkkB9AWaCp-apPbLS_mUezF2pIfOuhg20Ic8J6m46TCP4M5Kl91M', '1111', 2, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_partial_receive`
--
ALTER TABLE `order_partial_receive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_timeline`
--
ALTER TABLE `order_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_forable_type_forable_id_index` (`forable_type`,`forable_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_partial_receive`
--
ALTER TABLE `order_partial_receive`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_timeline`
--
ALTER TABLE `order_timeline`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
