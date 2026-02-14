-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2025 at 11:33 PM
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
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `created_at`, `updated_at`, `name`, `email`, `phone`, `img`, `password`, `deleted_at`, `is_activate`, `report_id`) VALUES
(1, NULL, '2025-10-07 18:33:45', 'AmrHussien', 'hema@gmail.com', '123456', 'admin/assets/images/admins/175986922558122.webp', '$2y$10$NJFN1sueb26Fw4t2zHWEqOIw0tjSQaZw9BpkeXqKFYoPuo9cLh//2', NULL, 1, 1);

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
  `quantity` int DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `created_at`, `updated_at`, `name`, `img`, `deleted_at`, `is_activate`, `report_id`) VALUES
(1, '2025-10-07 23:19:58', '2025-10-07 23:20:54', 'Yvette Kline 111', 'admin/assets/images/categories/175988645414063.png', NULL, 1, 1),
(2, '2025-10-07 23:20:10', '2025-10-07 23:20:10', 'Asher Reyes 222', 'admin/assets/images/categories/175988641019152.png', NULL, 1, 1),
(3, '2025-10-07 23:19:58', '2025-10-07 23:20:54', 'Yvette Kline 333', 'admin/assets/images/categories/175988645414063.png', NULL, 1, 1),
(4, '2025-10-07 23:20:10', '2025-10-07 23:20:10', 'Asher Reyes 444', 'admin/assets/images/categories/175988641019152.png', NULL, 1, 1),
(5, '2025-10-07 23:19:58', '2025-10-07 23:20:54', 'Yvette Kline 555', 'admin/assets/images/categories/175988645414063.png', NULL, 1, 1),
(6, '2025-10-07 23:20:10', '2025-10-07 23:20:10', 'Asher Reyes 666', 'admin/assets/images/categories/175988641019152.png', NULL, 1, 1),
(7, '2025-10-07 23:19:58', '2025-10-07 23:20:54', 'Yvette Kline 777', 'admin/assets/images/categories/175988645414063.png', NULL, 1, 1),
(8, '2025-10-07 23:20:10', '2025-10-07 23:20:10', 'Asher Reyes 888', 'admin/assets/images/categories/175988641019152.png', NULL, 1, 1);

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
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `created_at`, `updated_at`, `mobile`, `email`, `location`, `details`, `deleted_at`, `is_activate`, `report_id`) VALUES
(1, '2025-10-10 23:36:15', '2025-10-10 23:36:15', '12313213', 'asd@asda.com', 'sad asd asd asd asdasdasdas', 'asdasdsad asdasdasd asdasdasd asdasdasd asdasdasd', NULL, 1, 1),
(2, '2025-10-14 05:34:22', '2025-10-14 05:34:22', '0123456789', 'email@gmail.com', 'location', 'details', NULL, 1, 1),
(3, '2025-10-14 05:34:27', '2025-10-14 05:34:27', '0123456789', 'email@gmail.com', 'location', NULL, NULL, 1, 1),
(4, '2025-11-11 18:45:47', '2025-11-11 18:45:47', 'Minim enim ut sint d', 'libetylih@mailinator.com', 'Consectetur volupta', 'Iusto eum labore nih', NULL, 1, 1),
(5, '2025-11-11 18:45:47', '2025-11-11 18:45:47', 'Minim enim ut sint d', 'libetylih@mailinator.com', 'Consectetur volupta', 'Iusto eum labore nih', NULL, 1, 1),
(6, '2025-11-11 18:46:16', '2025-11-11 18:46:16', 'Sed voluptas occaeca', 'jufo@mailinator.com', 'Itaque nisi magni co', 'Enim illo sed fugiat', NULL, 1, 1),
(7, '2025-11-11 18:46:47', '2025-11-11 18:46:47', 'Eveniet enim esse', 'myri@mailinator.com', 'Est molestiae ut mag', 'Illum est est dist', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_one_id` bigint UNSIGNED NOT NULL,
  `user_two_id` bigint UNSIGNED NOT NULL,
  `last_message_at` timestamp NULL DEFAULT NULL,
  `is_blocked` tinyint(1) NOT NULL DEFAULT '0',
  `blocked_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `user_one_id`, `user_two_id`, `last_message_at`, `is_blocked`, `blocked_by`, `created_at`, `updated_at`) VALUES
(1, 3, 5, '2025-11-13 14:19:59', 0, NULL, NULL, '2025-11-13 14:19:59'),
(2, 3, 4, NULL, 0, NULL, '2025-11-08 12:15:36', '2025-11-08 12:15:36');

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
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `created_at`, `updated_at`, `name`, `deleted_at`, `is_activate`, `report_id`) VALUES
(1, '2025-10-08 00:26:31', '2025-10-08 00:26:31', 'Colby Combs', NULL, 1, 1),
(2, '2025-10-08 00:26:35', '2025-10-08 00:26:45', 'Brian Gomez 222', NULL, 1, 1);

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
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `created_at`, `updated_at`, `name`, `amount`, `type`, `deleted_at`, `is_activate`, `report_id`) VALUES
(1, '2025-10-10 18:03:24', '2025-10-10 18:03:24', 'Dieter Dennis', 70, 1, NULL, 1, 1),
(2, '2025-10-10 18:03:34', '2025-10-10 18:03:34', 'Cassandra Blankenship', 20, 2, NULL, 1, 1),
(3, '2025-10-10 18:03:39', '2025-10-10 18:05:07', 'Ava Battle 22', 12, 2, NULL, 1, 1);

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
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `report_id` tinyint NOT NULL DEFAULT '1'
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
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `created_at`, `updated_at`, `user_id`, `product_id`, `deleted_at`, `is_activate`, `report_id`) VALUES
(13, '2025-11-11 20:21:38', '2025-11-11 20:21:38', 3, 6, NULL, 1, 1),
(14, '2025-11-11 20:55:22', '2025-11-11 20:55:22', 3, 3, NULL, 1, 1),
(15, '2025-11-11 20:55:28', '2025-11-11 20:55:28', 3, 2, NULL, 1, 1);

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
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id`, `created_at`, `updated_at`, `mobile`, `email`, `vat`, `desc`, `message`, `vision`, `asks`, `abouts`, `terms`, `privacy_policies`, `deleted_at`, `is_activate`, `location`, `facebook`, `instagram`, `twitter`, `snapchat`, `tiktok`, `report_id`) VALUES
(1, '2025-10-10 19:21:48', '2025-10-21 23:33:19', '0101012222', 'hema@gmail.com', '10', NULL, NULL, NULL, NULL, '{\"10000001\":{\"head\":\"Martina Mitchell\",\"body\":\"Lewis Atkins\"},\"10000002\":{\"head\":\"Simon Stephens\",\"body\":\"Carly Medina\"}}', '{\"1000700001\":{\"head\":\"Alvin Arnold\",\"body\":\"Mary Alexander\"},\"1000700002\":{\"head\":\"Elaine Maddox\",\"body\":\"Renee Ratliff\"},\"1000400001\":{\"head\":\"Adrian Owens\",\"body\":\"Alfonso Summers\"}}', '{\"100070001\":{\"head\":\"Chandler Barr\",\"body\":\"Alana Kirby\"},\"100070003\":{\"head\":\"Lester Strickland\",\"body\":\"Kerry Chapman\"},\"100040001\":{\"head\":\"Nero Mccarty\",\"body\":\"Zorita Tucker\"}}', NULL, 1, 'location', 'http://127.0.0.1:7799/admin-panel/info/index/0/10', 'http://127.0.0.1:7799/admin-panel/info/index/0/10', 'http://127.0.0.1:7799/admin-panel/info/index/0/10', 'http://127.0.0.1:7799/admin-panel/info/index/0/10', 'http://127.0.0.1:7799/admin-panel/info/index/0/10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`, `report_id`) VALUES
(41, 'notifications', '{\"uuid\":\"6d966230-34c6-43e4-8745-55c6c37edafa\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:22:\\\"amrhuusien99@gmail.com\\\";s:7:\\\"orderNo\\\";i:43;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-07 09:02:09.098693\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762506129, 1762506070, 1),
(42, 'notifications', '{\"uuid\":\"18988ce5-8e2f-461b-a8d9-deaa9a1f4556\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:22:\\\"amrhuusien99@gmail.com\\\";s:7:\\\"orderNo\\\";i:43;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-07 09:03:41.886194\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762506221, 1762506161, 1),
(43, 'notifications', '{\"uuid\":\"d573dcde-ecdb-45c3-bff2-e3250096a7e9\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:22:\\\"amrhuusien99@gmail.com\\\";s:7:\\\"orderNo\\\";i:43;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-07 09:03:42.677059\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762506222, 1762506162, 1),
(44, 'notifications', '{\"uuid\":\"3e87d643-e3f5-4673-814b-022086e237bc\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:22:\\\"amrhuusien99@gmail.com\\\";s:7:\\\"orderNo\\\";i:43;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-07 09:04:27.341704\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762506267, 1762506207, 1),
(45, 'notifications', '{\"uuid\":\"2f26c18e-4cc9-4f77-9049-ea1c21fa249a\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:22:\\\"amrhuusien99@gmail.com\\\";s:7:\\\"orderNo\\\";i:43;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-07 09:12:03.966139\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762506723, 1762506663, 1),
(46, 'notifications', '{\"uuid\":\"c77631bf-cbce-455f-aa56-1c47ba3a136d\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:22:\\\"amrhuusien99@gmail.com\\\";s:7:\\\"orderNo\\\";i:40;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-07 09:31:43.942424\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762507903, 1762507844, 1),
(47, 'notifications', '{\"uuid\":\"5568a654-90fd-472d-b9a2-4c8c467f8bc5\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:22:\\\"amrhuusien99@gmail.com\\\";s:7:\\\"orderNo\\\";i:40;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-07 09:32:29.720364\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762507949, 1762507889, 1),
(48, 'notifications', '{\"uuid\":\"7d2cd700-d756-4bca-94d6-8b0e024821e7\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:22:\\\"amrhuusien99@gmail.com\\\";s:7:\\\"orderNo\\\";i:40;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-07 09:33:08.428218\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762507988, 1762507928, 1),
(49, 'notifications', '{\"uuid\":\"25172980-31ae-4a3b-99f3-5c743b5cf1b7\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:22:\\\"amrhuusien99@gmail.com\\\";s:7:\\\"orderNo\\\";i:40;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-07 09:45:12.938313\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762508712, 1762508652, 1),
(50, 'notifications', '{\"uuid\":\"0a858fe2-24be-4902-9dfd-b19b587e7f3b\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:22:\\\"amrhuusien99@gmail.com\\\";s:7:\\\"orderNo\\\";i:40;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-07 09:45:15.401287\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762508715, 1762508655, 1),
(51, 'notifications', '{\"uuid\":\"ce00eed9-9caa-49e9-a9a8-37ba0b1a51f6\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:44;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-08 20:22:28.443244\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762633348, 1762633289, 1),
(52, 'notifications', '{\"uuid\":\"e388c47f-9a88-4255-85db-f4605351fbdd\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:45;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-08 20:23:20.689496\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762633400, 1762633340, 1),
(57, 'notifications', '{\"uuid\":\"fc87b15c-8e5a-4e60-b092-626c4ab27612\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:48;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 00:51:17.557080\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762649477, 1762649417, 1),
(58, 'notifications', '{\"uuid\":\"d6f70830-e4b7-4b68-9a47-925d537a9f18\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:48;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 00:51:19.140374\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762649479, 1762649419, 1),
(59, 'notifications', '{\"uuid\":\"6e3bccba-e074-40dc-b777-b881bae3c674\",\"displayName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\OrderUpdatesMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"message\\\";s:35:\\\"the order no #48 has been canceled.\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 01:20:00.630924\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762651200, 1762651140, 1),
(60, 'notifications', '{\"uuid\":\"d5bd34f0-346d-4cd7-b499-94751de3a0a2\",\"displayName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\OrderUpdatesMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"message\\\";s:35:\\\"the order no #48 has been canceled.\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 01:20:02.282896\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762651202, 1762651142, 1),
(61, 'notifications', '{\"uuid\":\"e7abfb75-3a41-4ddc-b14a-3d55839b8536\",\"displayName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\OrderUpdatesMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"message\\\";s:34:\\\"your order #45 has been Completed.\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 02:30:41.135249\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762655441, 1762655383, 1),
(62, 'notifications', '{\"uuid\":\"d0669a8b-e24d-4fd7-8ddc-3d97d621851d\",\"displayName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\OrderUpdatesMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"message\\\";s:34:\\\"your order #45 has been Completed.\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 02:30:48.454785\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762655448, 1762655388, 1),
(63, 'notifications', '{\"uuid\":\"9a9c56ab-6b4f-4d91-b9b2-31a266d6f2c2\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 10:51:35.284646\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762685495, 1762685437, 1),
(64, 'notifications', '{\"uuid\":\"ad08f989-f14f-4013-b622-23958fd82eed\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 10:51:42.041491\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762685502, 1762685442, 1),
(65, 'notifications', '{\"uuid\":\"ba6ff313-d732-4bed-a924-fe7b604419b6\",\"displayName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\OrderUpdatesMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"message\\\";s:34:\\\"the offer no #1 has been rejected.\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 12:57:25.560040\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762693045, 1762692986, 1),
(66, 'notifications', '{\"uuid\":\"d7664ab8-69bd-430a-ac76-53c4831eedb9\",\"displayName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\OrderUpdatesMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"message\\\";s:34:\\\"the offer no #1 has been rejected.\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 12:57:26.622320\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762693046, 1762692986, 1),
(67, 'notifications', '{\"uuid\":\"7436c3d9-1486-482e-a013-91d360ccc00a\",\"displayName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\OrderUpdatesMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"message\\\";s:34:\\\"the offer no #2 has been accepted.\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 17:55:58.446745\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762710958, 1762710900, 1),
(68, 'notifications', '{\"uuid\":\"6f00b1b0-ad72-4b5d-96db-b8c2866594e3\",\"displayName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\OrderUpdatesMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"message\\\";s:34:\\\"the offer no #2 has been accepted.\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 17:56:00.753351\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762710960, 1762710900, 1),
(69, 'notifications', '{\"uuid\":\"88b9981f-0851-41f9-ac40-7f44e3c49fe9\",\"displayName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\OrderUpdatesMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"message\\\";s:34:\\\"the offer no #9 has been accepted.\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 18:17:31.405595\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762712251, 1762712191, 1),
(70, 'notifications', '{\"uuid\":\"aa97d20a-fd2e-4c71-8b9a-8a2b422c3085\",\"displayName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\OrderUpdatesMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\OrderUpdatesMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"message\\\";s:34:\\\"the offer no #9 has been accepted.\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-09 18:17:31.459746\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762712251, 1762712191, 1),
(71, 'notifications', '{\"uuid\":\"6405188a-a149-4483-bf4d-5c3bd428cbcf\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:16:\\\"amr223@gmail.com\\\";s:7:\\\"orderNo\\\";i:50;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 10:03:16.025232\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762768996, 1762768938, 1),
(72, 'notifications', '{\"uuid\":\"2b10c042-e2eb-4dd5-8548-aebb7e0a7de0\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:50;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 10:03:20.913168\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762769000, 1762768940, 1),
(73, 'notifications', '{\"uuid\":\"ad766ace-479c-4fa7-9029-3148a98b2913\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:15:27.910485\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762791327, 1762791269, 1),
(74, 'notifications', '{\"uuid\":\"e0435d08-8d49-4974-a7b5-f38a4df95deb\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:15:31.705614\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762791331, 1762791271, 1),
(75, 'notifications', '{\"uuid\":\"a7a16c1a-b4fa-4050-976b-77810bda2020\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:16:47.944667\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762791407, 1762791347, 1),
(76, 'notifications', '{\"uuid\":\"be367c0c-d51c-43a5-8a9d-217e1e24a0e1\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:16:49.588298\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762791409, 1762791349, 1),
(77, 'notifications', '{\"uuid\":\"4d93cc59-77f1-4438-b96d-a4496897ea9c\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:23:49.543310\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762791829, 1762791769, 1),
(78, 'notifications', '{\"uuid\":\"eb88f32b-b1cd-4d88-a4a7-b48140526bd1\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:23:51.350720\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762791831, 1762791771, 1),
(79, 'notifications', '{\"uuid\":\"4a83dd21-476a-45d8-aeef-44411fa03c40\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:25:34.030179\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762791934, 1762791874, 1),
(80, 'notifications', '{\"uuid\":\"3056ad99-537d-486c-80ab-3fe883df78d9\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:25:35.649375\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762791935, 1762791875, 1),
(81, 'notifications', '{\"uuid\":\"0bd5f4c5-e79e-4a7a-9e31-893fe4759cfd\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:26:56.083442\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762792016, 1762791956, 1),
(82, 'notifications', '{\"uuid\":\"f9a33ef3-e825-4f9b-a798-425cddccbde8\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:26:57.743851\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762792017, 1762791957, 1),
(83, 'notifications', '{\"uuid\":\"9832125f-66c6-48cc-b15d-0e6be60ab34d\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:28:50.891368\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762792130, 1762792070, 1),
(84, 'notifications', '{\"uuid\":\"a55be6bc-14cb-4a73-8315-1cd35515ac23\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:28:52.486159\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762792132, 1762792072, 1),
(85, 'notifications', '{\"uuid\":\"a73597fa-93b5-4dcf-a8af-417fd8104e33\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:30:59.236283\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762792259, 1762792199, 1),
(86, 'notifications', '{\"uuid\":\"e25374b2-4ab5-4592-bad8-ba3ab3c02c5d\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 16:31:00.868729\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762792260, 1762792200, 1),
(87, 'notifications', '{\"uuid\":\"ed2c6aec-7f77-4141-bc81-c8e3b97fd9ba\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 18:57:14.879525\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801034, 1762800974, 1),
(88, 'notifications', '{\"uuid\":\"38487176-cc3a-48be-ba8f-1816268f2256\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 18:57:16.748924\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801036, 1762800976, 1),
(89, 'notifications', '{\"uuid\":\"8dbc5f1d-ba9d-42a6-a56d-f5872e82b30c\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 18:57:52.672924\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801072, 1762801012, 1),
(90, 'notifications', '{\"uuid\":\"9ba0c420-c0ed-496e-babd-211ab12d1c2c\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 18:57:54.301065\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801074, 1762801014, 1),
(91, 'notifications', '{\"uuid\":\"445ac871-0e0b-4f7f-bc6b-c76c69929935\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 18:58:58.268935\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801138, 1762801078, 1),
(92, 'notifications', '{\"uuid\":\"3dc8c87a-6325-407d-86f1-9172a50577e6\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 18:58:59.938608\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801139, 1762801079, 1),
(93, 'notifications', '{\"uuid\":\"cadc1e42-741d-487e-9180-858a56f729ae\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 18:59:18.411134\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801158, 1762801098, 1),
(94, 'notifications', '{\"uuid\":\"d8cd2a57-f7b4-4144-8f6f-27d3d404cd61\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 18:59:20.160098\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801160, 1762801100, 1),
(95, 'notifications', '{\"uuid\":\"0f2bf1be-9d2b-4a9b-8b93-cbd1bcf291bb\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 18:59:31.249548\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801171, 1762801111, 1),
(96, 'notifications', '{\"uuid\":\"b7d310be-7496-47db-8133-383d7ab8f30f\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 18:59:32.839209\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801172, 1762801112, 1),
(97, 'notifications', '{\"uuid\":\"30e998bd-f11b-418b-bdba-5106fdec6469\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 18:59:53.236266\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801193, 1762801133, 1),
(98, 'notifications', '{\"uuid\":\"f9c108b8-6e89-4526-a2c3-88f0c575a7f2\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 18:59:54.872558\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801194, 1762801134, 1),
(99, 'notifications', '{\"uuid\":\"08351f20-798b-4dd5-bbbf-55eccc42ee35\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:01:00.432568\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801260, 1762801200, 1),
(100, 'notifications', '{\"uuid\":\"33b867f3-74d5-4b78-9843-265df5226b10\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:01:02.049730\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801262, 1762801202, 1),
(101, 'notifications', '{\"uuid\":\"d70085bf-92b0-468a-af65-d48250c078ca\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:03:42.815520\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801422, 1762801362, 1),
(102, 'notifications', '{\"uuid\":\"fc44335e-37d1-412b-b382-523c6bd65528\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:03:44.445390\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801424, 1762801364, 1),
(103, 'notifications', '{\"uuid\":\"1ac24d21-a1b3-4588-bc19-d4a44794a36d\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:05:02.219171\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801502, 1762801442, 1),
(104, 'notifications', '{\"uuid\":\"879fe5c8-4c1a-44c0-97d2-ed5aeb0e17c5\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:05:03.860410\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801503, 1762801443, 1),
(105, 'notifications', '{\"uuid\":\"a717fb7f-383b-45d6-bf5d-f81f6e974b35\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:08:47.625376\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801727, 1762801667, 1),
(106, 'notifications', '{\"uuid\":\"4108e19f-3e2f-45f6-ac05-cf8f2521d084\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:08:49.349239\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762801729, 1762801669, 1);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`, `report_id`) VALUES
(107, 'notifications', '{\"uuid\":\"c6f67267-1d3f-438b-a7e6-8b9b05d8b667\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:17:41.687146\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762802261, 1762802201, 1),
(108, 'notifications', '{\"uuid\":\"d9652c7d-74d3-4454-9dbc-18c087758584\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:17:43.308493\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762802263, 1762802203, 1),
(109, 'notifications', '{\"uuid\":\"be6e894c-4ac4-4aad-b2e4-cd7736e43997\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:19:00.220608\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762802340, 1762802280, 1),
(110, 'notifications', '{\"uuid\":\"6926e0da-373a-4203-8ba1-e7a89683b199\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:19:01.814858\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762802341, 1762802281, 1),
(111, 'notifications', '{\"uuid\":\"415e9b95-dcc7-4bf2-a333-72fbf477be21\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:18:\\\"amr22499@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:30:25.804923\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762803025, 1762802965, 1),
(112, 'notifications', '{\"uuid\":\"82c4fb36-f538-4d9b-ac98-3b7ecbadbbc1\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:49;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 19:30:27.717267\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762803027, 1762802967, 1),
(129, 'notifications', '{\"uuid\":\"aeb05fd0-a0a0-4c75-8b9a-339b88b604d2\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:59;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 22:07:06.356402\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762812426, 1762812366, 1),
(130, 'notifications', '{\"uuid\":\"e9c2463d-c925-4336-ace5-b6cee5f20804\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:59;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 22:07:08.054238\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762812428, 1762812368, 1),
(131, 'notifications', '{\"uuid\":\"e2e9aa7e-f612-41d6-b73e-0c632ef3c362\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:16:\\\"amr222@gmail.com\\\";s:7:\\\"orderNo\\\";i:60;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 22:07:09.650078\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762812429, 1762812369, 1),
(132, 'notifications', '{\"uuid\":\"bb23f323-0506-4204-a021-aeae884e3956\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:60;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 22:07:11.212429\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762812431, 1762812371, 1),
(133, 'notifications', '{\"uuid\":\"704f9061-4678-4f62-ba0a-48d3de9f846f\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:61;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 22:07:59.755728\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762812479, 1762812419, 1),
(134, 'notifications', '{\"uuid\":\"d439da87-4810-48fc-9068-f1b098325a97\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:61;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 22:08:01.561247\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762812481, 1762812421, 1),
(135, 'notifications', '{\"uuid\":\"34c6203e-3a83-4e41-af65-3e7b7ac53bba\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:16:\\\"amr222@gmail.com\\\";s:7:\\\"orderNo\\\";i:62;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 22:08:03.190156\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762812483, 1762812423, 1),
(136, 'notifications', '{\"uuid\":\"6e1742f1-f85d-43a5-aca7-de5ef2e77e06\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:62;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 22:08:04.738897\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762812484, 1762812424, 1),
(137, 'notifications', '{\"uuid\":\"e7912eb3-3617-43bf-bcea-349f56d7da1e\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:63;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 22:14:56.367621\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762812896, 1762812836, 1),
(138, 'notifications', '{\"uuid\":\"f4409974-f393-4c0b-be32-7203dfc85e20\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:63;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 22:14:58.030706\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762812898, 1762812838, 1),
(139, 'notifications', '{\"uuid\":\"032b1e81-927d-4b26-b105-179658b1c70c\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:16:\\\"amr222@gmail.com\\\";s:7:\\\"orderNo\\\";i:64;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 22:14:59.548961\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762812899, 1762812839, 1),
(140, 'notifications', '{\"uuid\":\"08fe300b-8a9f-4c7b-9725-5d075d670d7d\",\"displayName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NewOrderMailJob\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\NewOrderMailJob\\\":4:{s:5:\\\"email\\\";s:15:\\\"amr22@gmail.com\\\";s:7:\\\"orderNo\\\";i:64;s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 22:15:01.031075\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762812901, 1762812841, 1),
(141, 'notifications', '{\"uuid\":\"aad24800-54f8-41e7-add1-3040296a3ce2\",\"displayName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendUserCodeMailJob\\\":4:{s:5:\\\"email\\\";s:21:\\\"cozimy@mailinator.com\\\";s:4:\\\"code\\\";s:4:\\\"2759\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-12 00:30:11.181390\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762907411, 1762907353, 1),
(142, 'notifications', '{\"uuid\":\"a4c1f24a-2436-4843-8331-64cb6bc9b968\",\"displayName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendUserCodeMailJob\\\":4:{s:5:\\\"email\\\";s:19:\\\"casi@mailinator.com\\\";s:4:\\\"code\\\";s:4:\\\"3794\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-12 00:41:25.058386\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762908085, 1762908025, 1),
(143, 'notifications', '{\"uuid\":\"b803bd73-8d45-449c-9854-5027fd83ae46\",\"displayName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendUserCodeMailJob\\\":4:{s:5:\\\"email\\\";s:25:\\\"gyqegakiwu@mailinator.com\\\";s:4:\\\"code\\\";s:4:\\\"5689\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-12 00:42:31.060745\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762908151, 1762908091, 1),
(144, 'notifications', '{\"uuid\":\"06c364d1-d887-4999-8c64-7ea5fd1589b1\",\"displayName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendUserCodeMailJob\\\":4:{s:5:\\\"email\\\";s:21:\\\"zijaxe@mailinator.com\\\";s:4:\\\"code\\\";s:4:\\\"2930\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-12 00:44:55.406338\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762908295, 1762908235, 1),
(145, 'notifications', '{\"uuid\":\"73b8053b-542f-4f54-afb5-8ee6d055fcd7\",\"displayName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendUserCodeMailJob\\\":4:{s:5:\\\"email\\\";s:19:\\\"seko@mailinator.com\\\";s:4:\\\"code\\\";s:4:\\\"5776\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-12 01:23:38.868420\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762910618, 1762910558, 1),
(146, 'notifications', '{\"uuid\":\"755236e8-38d6-4d14-8736-76d04010a4f5\",\"displayName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendUserCodeMailJob\\\":4:{s:5:\\\"email\\\";s:19:\\\"doly@mailinator.com\\\";s:4:\\\"code\\\";s:4:\\\"3642\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-12 01:48:08.246063\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762912088, 1762912028, 1),
(147, 'notifications', '{\"uuid\":\"889b10de-7d17-4d0d-8fab-9d17dc84155e\",\"displayName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendUserCodeMailJob\\\":4:{s:5:\\\"email\\\";s:19:\\\"bybi@mailinator.com\\\";s:4:\\\"code\\\";s:4:\\\"4872\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-12 02:16:34.033212\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762913794, 1762913734, 1),
(148, 'notifications', '{\"uuid\":\"ab17d2ae-71b2-482c-9c3e-18e54f40c274\",\"displayName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendUserCodeMailJob\\\":4:{s:5:\\\"email\\\";s:19:\\\"bybi@mailinator.com\\\";s:4:\\\"code\\\";s:4:\\\"6315\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-12 02:18:13.938944\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762913893, 1762913833, 1),
(149, 'notifications', '{\"uuid\":\"4afa3ee1-8566-49dd-bc18-7f7d7054cc7b\",\"displayName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendUserCodeMailJob\\\":4:{s:5:\\\"email\\\";s:19:\\\"bybi@mailinator.com\\\";s:4:\\\"code\\\";s:4:\\\"3929\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-12 03:16:46.702352\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762917406, 1762917346, 1),
(150, 'notifications', '{\"uuid\":\"c34789fd-bfcc-42ee-b48f-b068e2ab5307\",\"displayName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendUserCodeMailJob\\\":4:{s:5:\\\"email\\\";s:19:\\\"bybi@mailinator.com\\\";s:4:\\\"code\\\";s:4:\\\"6253\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-12 03:17:28.609457\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762917448, 1762917388, 1),
(151, 'notifications', '{\"uuid\":\"8aaa4d3c-6126-466b-927f-5b31c421503d\",\"displayName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendUserCodeMailJob\\\":4:{s:5:\\\"email\\\";s:19:\\\"bybi@mailinator.com\\\";s:4:\\\"code\\\";s:4:\\\"8029\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-12 03:20:06.431047\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762917606, 1762917546, 1),
(152, 'notifications', '{\"uuid\":\"465efd27-99e8-4aae-9eb5-cfce8bafcdba\",\"displayName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10,60,180\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendUserCodeMailJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendUserCodeMailJob\\\":4:{s:5:\\\"email\\\";s:19:\\\"bybi@mailinator.com\\\";s:4:\\\"code\\\";s:4:\\\"4861\\\";s:5:\\\"queue\\\";s:13:\\\"notifications\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-12 03:20:45.866435\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1762917645, 1762917585, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message_type` enum('text','file') COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `is_deleted_by_sender` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted_by_receiver` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `receiver_id`, `message`, `file`, `message_type`, `is_read`, `read_at`, `is_deleted_by_sender`, `is_deleted_by_receiver`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 5, 'aaaaaaaaa aaaaaaaa aaaaaaaaa aaaaaaaaaa', NULL, 'text', 0, NULL, 0, 0, '2025-11-07 13:10:41', '2025-11-07 13:10:41'),
(3, 1, 5, 3, 'aaaaaaaaa aaaaaaaa aaaaaaaaa aaaaaaaaaa 222222', NULL, 'text', 1, '2025-11-07 11:23:34', 0, 0, '2025-11-07 13:10:41', '2025-11-07 11:23:34'),
(4, 1, 5, 3, 'aaaaaaaaa aaaaaaaa aaaaaaaaa aaaaaaaaaa 333333', NULL, 'text', 1, '2025-11-07 11:23:34', 0, 0, '2025-11-07 13:10:41', '2025-11-07 11:23:34'),
(5, 1, 3, 5, 'aaaaaaaaa aaaaaaaa aaaaaaaaa aaaaaaaaaa 444444', NULL, 'text', 0, NULL, 0, 0, '2025-11-07 13:10:41', '2025-11-07 13:10:41'),
(6, 1, 5, 3, 'aaaaaaaaa aaaaaaaa aaaaaaaaa aaaaaaaaaa 555555', NULL, 'text', 0, NULL, 0, 1, '2025-11-07 13:10:41', '2025-11-07 12:16:25'),
(7, 1, 3, 5, NULL, 'admin/assets/images/admins/175986922558122.webp', 'file', 0, NULL, 0, 0, '2025-11-07 13:10:41', '2025-11-07 13:10:41'),
(8, 1, 3, 5, 'message message message message', NULL, 'text', 0, NULL, 0, 0, '2025-11-07 11:55:31', '2025-11-07 11:55:31'),
(9, 1, 3, 5, NULL, NULL, 'file', 0, NULL, 0, 0, '2025-11-07 12:11:19', '2025-11-07 12:11:19'),
(10, 1, 3, 5, NULL, 'admin/assets/images/chats/176252472140736.png', 'file', 0, NULL, 0, 0, '2025-11-07 12:12:01', '2025-11-07 12:12:01'),
(11, 1, 3, 5, NULL, 'admin/assets/images/chats/176252476072273.png', 'file', 0, NULL, 0, 0, '2025-11-07 12:12:40', '2025-11-07 12:12:40'),
(12, 1, 3, 5, NULL, 'admin/assets/images/chats/176252477159861.png', 'file', 0, NULL, 0, 0, '2025-11-07 12:12:51', '2025-11-07 12:12:51'),
(13, 1, 3, 5, 'message message message message 2222', NULL, 'text', 0, NULL, 0, 0, '2025-11-07 12:46:59', '2025-11-07 12:46:59'),
(14, 1, 3, 5, 'message message message message 2222', NULL, 'text', 0, NULL, 0, 0, '2025-11-07 12:48:17', '2025-11-07 12:48:17'),
(15, 1, 3, 5, 'message message message message 2222', NULL, 'text', 0, NULL, 0, 0, '2025-11-07 12:50:23', '2025-11-07 12:50:23'),
(16, 1, 3, 5, 'message message message message 2222', NULL, 'text', 0, NULL, 0, 0, '2025-11-09 15:17:02', '2025-11-09 15:17:02'),
(17, 1, 3, 5, 'message message message message 2222', NULL, 'text', 0, NULL, 0, 0, '2025-11-09 15:17:27', '2025-11-09 15:17:27'),
(18, 1, 3, 5, 'message message message message 2222', NULL, 'text', 0, NULL, 0, 0, '2025-11-09 15:28:41', '2025-11-09 15:28:41'),
(19, 1, 3, 5, 'message message message message 2222', NULL, 'text', 0, NULL, 0, 0, '2025-11-10 06:20:56', '2025-11-10 06:20:56'),
(20, 1, 3, 5, 'message message message message 2222', NULL, 'text', 0, NULL, 0, 0, '2025-11-10 06:51:34', '2025-11-10 06:51:34'),
(21, 1, 3, 5, 'message message message message 2222', NULL, 'text', 0, NULL, 0, 0, '2025-11-10 06:51:44', '2025-11-10 06:51:44'),
(22, 1, 3, 5, 'message message message message 22223355', NULL, 'text', 0, NULL, 0, 0, '2025-11-13 12:28:00', '2025-11-13 12:28:00'),
(23, 1, 3, 5, 'message message message message 22223355', NULL, 'text', 0, NULL, 0, 0, '2025-11-13 12:28:59', '2025-11-13 12:28:59'),
(24, 1, 3, 5, 'message message message message 22223355', NULL, 'text', 0, NULL, 0, 0, '2025-11-13 13:47:22', '2025-11-13 13:47:22'),
(25, 1, 3, 5, 'message message message message 22223355', NULL, 'text', 0, NULL, 0, 0, '2025-11-13 13:49:18', '2025-11-13 13:49:18'),
(26, 1, 3, 5, 'message message message message 22223355', NULL, 'text', 0, NULL, 0, 0, '2025-11-13 13:56:48', '2025-11-13 13:56:48'),
(27, 1, 3, 5, 'message message message message 22223355', NULL, 'text', 0, NULL, 0, 0, '2025-11-13 13:57:49', '2025-11-13 13:57:49'),
(28, 1, 3, 5, 'message message message message 22223355', NULL, 'text', 0, NULL, 0, 0, '2025-11-13 14:15:47', '2025-11-13 14:15:47'),
(29, 1, 3, 5, 'message message message message 22223355', NULL, 'text', 0, NULL, 0, 0, '2025-11-13 14:18:05', '2025-11-13 14:18:05'),
(30, 1, 3, 5, 'message message message message 22223355', NULL, 'text', 0, NULL, 0, 0, '2025-11-13 14:18:58', '2025-11-13 14:18:58'),
(31, 1, 3, 5, 'message message message message 22223355', NULL, 'text', 0, NULL, 0, 0, '2025-11-13 14:19:59', '2025-11-13 14:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`, `report_id`) VALUES
(1, '2014_10_12_000000_create_users_table', 1, 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1, 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1, 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1, 1),
(5, '2023_10_19_000000_create_admins_table', 1, 1),
(6, '2023_10_19_000000_create_users_table', 2, 1),
(7, '2023_10_19_000000_create_categories_table', 3, 1),
(8, '2023_10_19_000000_create_countries_table', 4, 1),
(9, '2023_10_19_000000_create_products_table', 4, 1),
(10, '2023_10_19_000000_create_cart_table', 5, 1),
(11, '2023_10_19_000000_create_coupons_table', 5, 1),
(12, '2023_10_19_000000_create_orderItems_table', 5, 1),
(13, '2023_10_19_000000_create_orders_table', 5, 1),
(14, '2023_10_19_000000_create_info_table', 6, 1),
(15, '2023_10_19_000000_create_contacts_table', 7, 1),
(16, '2023_10_18_000000_create_cart_table', 8, 1),
(17, '2023_10_19_000000_create_favorites_table', 8, 1),
(18, '2023_10_19_000000_create_order_timeline_table', 9, 1),
(19, '2023_10_19_000000_create_offers_table', 10, 1),
(20, '2023_10_19_000000_create_offers_table copy', 11, 1),
(21, '2023_10_19_000000_create_ratings_table', 12, 1),
(22, '2023_10_19_000000_create_order_partial_receive_table', 13, 1),
(23, '2023_10_19_000000_create_order_partial_receive_table copy', 14, 1),
(24, '2023_10_19_000000_create_notifications_table', 15, 1),
(25, '2025_10_22_000000_create_add_cloumns_info_table', 16, 1),
(26, '2025_10_23_063338_create_jobs_table', 17, 1),
(27, '2025_10_25_000000_create_orders_add_columns_table', 18, 1),
(28, '2025_10_28_112139_add_status_to_all_tables', 19, 1),
(29, '2023_10_19_000000_create_reports_table', 20, 1),
(30, '2025_11_07_000001_create_conversations_table', 21, 1),
(31, '2025_11_07_000002_create_messages_table', 21, 1),
(32, '2025_11_07_000004_simplify_messages_table', 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serviceable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serviceable_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `created_at`, `updated_at`, `title`, `content`, `serviceable_type`, `serviceable_id`, `order_id`, `user_id`, `deleted_at`, `is_activate`, `report_id`) VALUES
(1, '2025-10-19 11:06:45', '2025-10-19 11:06:45', 'verified your account', 'your code: #1111', NULL, NULL, NULL, 7, NULL, 1, 1),
(2, '2025-10-19 11:09:18', '2025-10-19 11:09:18', 'verified your account', 'your code: #9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(3, NULL, NULL, 'verified your account', 'your code: #9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(4, NULL, NULL, 'verified your account', 'your code: #9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(5, NULL, NULL, 'verified your account', 'your code: #9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(6, NULL, NULL, 'verified your account', 'your code: #9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(7, '2025-10-19 11:17:37', '2025-10-19 11:17:37', 'verified your account', 'your code: 9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(8, '2025-10-19 11:17:37', '2025-10-19 11:17:37', 'verified your account', 'your code: 9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(9, NULL, NULL, 'verified your account', 'your code: 9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(10, NULL, NULL, 'verified your account', 'your code: 9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(11, NULL, NULL, 'verified your account', 'your code: 9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(12, NULL, NULL, 'verified your account', 'your code: 9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(13, NULL, NULL, 'verified your account', 'your code: 9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(14, NULL, NULL, 'verified your account', 'your code: 9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(15, NULL, NULL, 'verified your account', 'your code: 9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(16, NULL, NULL, 'verified your account', 'your code: 9999', NULL, NULL, NULL, 3, NULL, 1, 1),
(17, '2025-10-22 10:52:00', '2025-10-22 10:52:00', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 14, 14, 3, NULL, 1, 1),
(18, '2025-10-22 10:52:00', '2025-10-22 10:52:00', 'new order.', 'you have new order', 'App\\Models\\Order', 14, 14, 3, NULL, 1, 1),
(19, '2025-10-23 00:18:25', '2025-10-23 00:18:25', 'verified your account', 'your code: #8345', NULL, NULL, NULL, 8, NULL, 1, 1),
(20, '2025-10-23 00:26:10', '2025-10-23 00:26:10', 'verified your account', 'your code: #1036', NULL, NULL, NULL, 9, NULL, 1, 1),
(28, '2025-10-23 05:07:31', '2025-10-23 05:07:31', 'verified your account', 'your code: #4562', NULL, NULL, NULL, 17, NULL, 1, 1),
(29, '2025-10-23 05:18:55', '2025-10-23 05:18:55', 'verified your account', 'your code: #7257', NULL, NULL, NULL, 18, NULL, 1, 1),
(30, '2025-10-23 05:21:03', '2025-10-23 05:21:03', 'verified your account', 'your code: #6533', NULL, NULL, NULL, 19, NULL, 1, 1),
(31, '2025-10-23 05:23:24', '2025-10-23 05:23:24', 'verified your account', 'your code: #6664', NULL, NULL, NULL, 20, NULL, 1, 1),
(32, '2025-10-23 07:20:02', '2025-10-23 07:20:02', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 15, 15, 3, NULL, 1, 1),
(33, '2025-10-23 07:20:02', '2025-10-23 07:20:02', 'new order.', 'you have new order', 'App\\Models\\Order', 15, 15, 3, NULL, 1, 1),
(34, '2025-10-23 07:24:19', '2025-10-23 07:24:19', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 16, 16, 3, NULL, 1, 1),
(35, '2025-10-23 07:25:32', '2025-10-23 07:25:32', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 17, 17, 3, NULL, 1, 1),
(36, '2025-10-23 07:26:14', '2025-10-23 07:26:14', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 18, 18, 3, NULL, 1, 1),
(37, '2025-10-23 07:27:07', '2025-10-23 07:27:07', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 19, 19, 3, NULL, 1, 1),
(38, '2025-10-23 07:27:22', '2025-10-23 07:27:22', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 20, 20, 3, NULL, 1, 1),
(39, '2025-10-23 07:28:39', '2025-10-23 07:28:39', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 22, 22, 3, NULL, 1, 1),
(40, '2025-10-23 07:28:39', '2025-10-23 07:28:39', 'new order.', 'you have new order', 'App\\Models\\Order', 22, 22, 3, NULL, 1, 1),
(41, '2025-10-23 07:30:42', '2025-10-23 07:30:42', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 23, 23, 3, NULL, 1, 1),
(42, '2025-10-23 07:30:42', '2025-10-23 07:30:42', 'new order.', 'you have new order', 'App\\Models\\Order', 23, 23, 3, NULL, 1, 1),
(43, '2025-10-23 07:36:37', '2025-10-23 07:36:37', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 24, 24, 3, NULL, 1, 1),
(44, '2025-10-23 07:36:37', '2025-10-23 07:36:37', 'new order.', 'you have new order', 'App\\Models\\Order', 24, 24, 3, NULL, 1, 1),
(45, '2025-10-23 07:43:11', '2025-10-23 07:43:11', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 25, 25, 3, NULL, 1, 1),
(46, '2025-10-23 07:43:11', '2025-10-23 07:43:11', 'new order.', 'you have new order', 'App\\Models\\Order', 25, 25, 3, NULL, 1, 1),
(47, '2025-10-23 07:50:38', '2025-10-23 07:50:38', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 26, 26, 3, NULL, 1, 1),
(48, '2025-10-23 07:50:38', '2025-10-23 07:50:38', 'new order.', 'you have new order', 'App\\Models\\Order', 26, 26, 3, NULL, 1, 1),
(49, '2025-10-23 07:53:13', '2025-10-23 07:53:13', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 27, 27, 3, NULL, 1, 1),
(50, '2025-10-23 07:53:13', '2025-10-23 07:53:13', 'new order.', 'you have new order', 'App\\Models\\Order', 27, 27, 3, NULL, 1, 1),
(51, '2025-10-23 09:03:30', '2025-10-23 09:03:30', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 29, 29, 3, NULL, 1, 1),
(52, '2025-10-23 09:03:30', '2025-10-23 09:03:30', 'new order.', 'you have new order', 'App\\Models\\Order', 29, 29, 3, NULL, 1, 1),
(53, '2025-10-23 09:03:37', '2025-10-23 09:03:37', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 30, 30, 3, NULL, 1, 1),
(54, '2025-10-23 09:03:37', '2025-10-23 09:03:37', 'new order.', 'you have new order', 'App\\Models\\Order', 30, 30, 3, NULL, 1, 1),
(55, '2025-10-23 09:05:14', '2025-10-23 09:05:14', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 31, 31, 3, NULL, 1, 1),
(56, '2025-10-23 09:05:14', '2025-10-23 09:05:14', 'new order.', 'you have new order', 'App\\Models\\Order', 31, 31, 3, NULL, 1, 1),
(57, '2025-10-23 09:07:08', '2025-10-23 09:07:08', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 32, 32, 3, NULL, 1, 1),
(58, '2025-10-23 09:07:08', '2025-10-23 09:07:08', 'new order.', 'you have new order', 'App\\Models\\Order', 32, 32, 3, NULL, 1, 1),
(59, '2025-10-23 09:11:33', '2025-10-23 09:11:33', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 33, 33, 3, NULL, 1, 1),
(60, '2025-10-23 09:11:33', '2025-10-23 09:11:33', 'new order.', 'you have new order', 'App\\Models\\Order', 33, 33, 3, NULL, 1, 1),
(61, '2025-10-23 09:14:15', '2025-10-23 09:14:15', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 34, 34, 3, NULL, 1, 1),
(62, '2025-10-23 09:14:15', '2025-10-23 09:14:15', 'new order.', 'you have new order', 'App\\Models\\Order', 34, 34, 3, NULL, 1, 1),
(63, '2025-10-23 09:18:51', '2025-10-23 09:18:51', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 35, 35, 3, NULL, 1, 1),
(64, '2025-10-23 09:18:51', '2025-10-23 09:18:51', 'new order.', 'you have new order', 'App\\Models\\Order', 35, 35, 3, NULL, 1, 1),
(65, '2025-10-23 09:27:43', '2025-10-23 09:27:43', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 36, 36, 3, NULL, 1, 1),
(66, '2025-10-23 09:27:43', '2025-10-23 09:27:43', 'new order.', 'you have new order', 'App\\Models\\Order', 36, 36, 3, NULL, 1, 1),
(67, '2025-10-23 10:04:22', '2025-10-23 10:04:22', 'order canceled.', 'the order no #36 has been canceled.', 'App\\Models\\Order', 36, 36, 3, NULL, 1, 1),
(68, '2025-10-23 10:04:22', '2025-10-23 10:04:22', 'order canceled.', 'the order no #36 has been canceled.', 'App\\Models\\Order', 36, 36, 3, NULL, 1, 1),
(69, '2025-10-23 10:07:46', '2025-10-23 10:07:46', 'your order has been Confirmed by Supplier.', 'your order #35 has been Confirmed by Supplier.', 'App\\Models\\Order', 35, 35, 3, NULL, 1, 1),
(70, '2025-10-23 10:10:00', '2025-10-23 10:10:00', 'offer updates.', 'the offer no #5 has been accepted.', 'App\\Models\\Order', 12, 12, 3, NULL, 1, 1),
(71, '2025-10-23 15:27:53', '2025-10-23 15:27:53', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 37, 37, 3, NULL, 1, 1),
(72, '2025-10-23 15:27:53', '2025-10-23 15:27:53', 'new order.', 'you have new order', 'App\\Models\\Order', 37, 37, 2, NULL, 1, 1),
(73, '2025-10-23 15:30:38', '2025-10-23 15:30:38', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 38, 38, 3, NULL, 1, 1),
(74, '2025-10-23 15:30:38', '2025-10-23 15:30:38', 'new order.', 'you have new order', 'App\\Models\\Order', 38, 38, 3, NULL, 1, 1),
(75, '2025-10-23 15:32:13', '2025-10-23 15:32:13', 'your order has been Confirmed by Supplier.', 'your order #38 has been Confirmed by Supplier.', 'App\\Models\\Order', 38, 38, 3, NULL, 1, 1),
(76, '2025-10-23 15:37:30', '2025-10-23 15:37:30', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 39, 39, 3, NULL, 1, 1),
(77, '2025-10-23 15:37:30', '2025-10-23 15:37:30', 'new order.', 'you have new order', 'App\\Models\\Order', 39, 39, 2, NULL, 1, 1),
(78, '2025-10-23 15:37:36', '2025-10-23 15:37:36', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 40, 40, 3, NULL, 1, 1),
(79, '2025-10-23 15:37:36', '2025-10-23 15:37:36', 'new order.', 'you have new order', 'App\\Models\\Order', 40, 40, 3, NULL, 1, 1),
(84, '2025-10-25 09:58:30', '2025-10-25 09:58:30', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 43, 43, 3, NULL, 1, 1),
(85, '2025-10-25 21:19:44', '2025-10-25 21:19:44', 'your order has been Confirmed by Supplier.', 'your order #40 has been Confirmed by Supplier.', 'App\\Models\\Order', 40, 40, 3, NULL, 1, 1),
(86, '2025-11-07 07:01:08', '2025-11-07 07:01:08', 'Order #43 has been paid successfully.', 'Order #43 has been paid successfully.', 'App\\Models\\Order', 43, 43, 3, NULL, 1, 1),
(87, '2025-11-07 07:02:41', '2025-11-07 07:02:41', 'Order #43 has been paid successfully.', 'Order #43 has been paid successfully.', 'App\\Models\\Order', 43, 43, 3, NULL, 1, 1),
(88, '2025-11-07 07:02:42', '2025-11-07 07:02:42', 'Order #43 has been paid successfully.', 'Order #43 has been paid successfully.', 'App\\Models\\Order', 43, 43, 3, NULL, 1, 1),
(89, '2025-11-07 07:03:27', '2025-11-07 07:03:27', 'Order #43 has been paid successfully.', 'Order #43 has been paid successfully.', 'App\\Models\\Order', 43, 43, 3, NULL, 1, 1),
(90, '2025-11-07 07:11:03', '2025-11-07 07:11:03', 'Order #43 has been paid successfully.', 'Order #43 has been paid successfully.', 'App\\Models\\Order', 43, 43, 3, NULL, 1, 1),
(91, '2025-11-07 07:44:12', '2025-11-07 07:44:12', 'Order #40 has been paid successfully.', 'Order #40 has been paid successfully.', 'App\\Models\\Order', 40, 40, 3, NULL, 1, 1),
(92, '2025-11-07 07:44:12', '2025-11-07 07:44:12', 'Order #40 has been paid successfully.', 'Order #40 has been paid successfully.', 'App\\Models\\Order', 40, 40, 3, NULL, 1, 1),
(93, '2025-11-08 18:21:28', '2025-11-08 18:21:28', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 44, 44, 3, NULL, 1, 1),
(94, '2025-11-08 18:22:20', '2025-11-08 18:22:20', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 45, 45, 3, NULL, 1, 1),
(99, '2025-11-08 22:50:17', '2025-11-08 22:50:17', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 48, 48, 3, NULL, 1, 1),
(100, '2025-11-08 22:50:17', '2025-11-08 22:50:17', 'new order.', 'you have new order', 'App\\Models\\Order', 48, 48, 3, NULL, 1, 1),
(101, '2025-11-08 23:19:00', '2025-11-08 23:19:00', 'order canceled.', 'the order no #48 has been canceled.', 'App\\Models\\Order', 48, 48, 3, NULL, 1, 1),
(102, '2025-11-08 23:19:00', '2025-11-08 23:19:00', 'order canceled.', 'the order no #48 has been canceled.', 'App\\Models\\Order', 48, 48, 3, NULL, 1, 1),
(103, '2025-11-09 00:29:40', '2025-11-09 00:29:40', 'your order has been Completed.', 'your order #45 has been Completed.', 'App\\Models\\Order', 45, 45, 3, NULL, 1, 1),
(104, '2025-11-09 08:50:35', '2025-11-09 08:50:35', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(105, '2025-11-09 08:50:35', '2025-11-09 08:50:35', 'new order.', 'you have new order', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(106, '2025-11-09 10:56:25', '2025-11-09 10:56:25', 'offer updates.', 'the offer no #1 has been rejected.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(107, '2025-11-09 15:54:58', '2025-11-09 15:54:58', 'offer updates.', 'the offer no #2 has been accepted.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(108, '2025-11-09 16:16:31', '2025-11-09 16:16:31', 'offer updates.', 'the offer no #9 has been accepted.', 'App\\Models\\Order', 13, 13, 3, NULL, 1, 1),
(109, '2025-11-10 08:02:15', '2025-11-10 08:02:15', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 50, 50, 3, NULL, 1, 1),
(110, '2025-11-10 08:02:15', '2025-11-10 08:02:15', 'new order.', 'you have new order', 'App\\Models\\Order', 50, 50, 5, NULL, 1, 1),
(111, '2025-11-10 14:14:27', '2025-11-10 14:14:27', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(112, '2025-11-10 14:14:27', '2025-11-10 14:14:27', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(113, '2025-11-10 14:15:47', '2025-11-10 14:15:47', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(114, '2025-11-10 14:15:47', '2025-11-10 14:15:47', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(115, '2025-11-10 14:22:49', '2025-11-10 14:22:49', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(116, '2025-11-10 14:22:49', '2025-11-10 14:22:49', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(117, '2025-11-10 14:24:34', '2025-11-10 14:24:34', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(118, '2025-11-10 14:24:34', '2025-11-10 14:24:34', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(119, '2025-11-10 14:25:56', '2025-11-10 14:25:56', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(120, '2025-11-10 14:25:56', '2025-11-10 14:25:56', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(121, '2025-11-10 14:27:50', '2025-11-10 14:27:50', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(122, '2025-11-10 14:27:50', '2025-11-10 14:27:50', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(123, '2025-11-10 14:29:59', '2025-11-10 14:29:59', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(124, '2025-11-10 14:29:59', '2025-11-10 14:29:59', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(125, '2025-11-10 16:56:14', '2025-11-10 16:56:14', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(126, '2025-11-10 16:56:14', '2025-11-10 16:56:14', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(127, '2025-11-10 16:56:52', '2025-11-10 16:56:52', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(128, '2025-11-10 16:56:52', '2025-11-10 16:56:52', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(129, '2025-11-10 16:57:58', '2025-11-10 16:57:58', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(130, '2025-11-10 16:57:58', '2025-11-10 16:57:58', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(131, '2025-11-10 16:58:18', '2025-11-10 16:58:18', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(132, '2025-11-10 16:58:18', '2025-11-10 16:58:18', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(133, '2025-11-10 16:58:31', '2025-11-10 16:58:31', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(134, '2025-11-10 16:58:31', '2025-11-10 16:58:31', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(135, '2025-11-10 16:58:53', '2025-11-10 16:58:53', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(136, '2025-11-10 16:58:53', '2025-11-10 16:58:53', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(137, '2025-11-10 17:00:00', '2025-11-10 17:00:00', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(138, '2025-11-10 17:00:00', '2025-11-10 17:00:00', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(139, '2025-11-10 17:02:42', '2025-11-10 17:02:42', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(140, '2025-11-10 17:02:42', '2025-11-10 17:02:42', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(141, '2025-11-10 17:04:02', '2025-11-10 17:04:02', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(142, '2025-11-10 17:04:02', '2025-11-10 17:04:02', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(143, '2025-11-10 17:07:47', '2025-11-10 17:07:47', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(144, '2025-11-10 17:07:47', '2025-11-10 17:07:47', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(145, '2025-11-10 17:16:41', '2025-11-10 17:16:41', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(146, '2025-11-10 17:16:41', '2025-11-10 17:16:41', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(147, '2025-11-10 17:18:00', '2025-11-10 17:18:00', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(148, '2025-11-10 17:18:00', '2025-11-10 17:18:00', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(149, '2025-11-10 17:29:25', '2025-11-10 17:29:25', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 3, NULL, 1, 1),
(150, '2025-11-10 17:29:25', '2025-11-10 17:29:25', 'Order #49 has been paid successfully.', 'Order #49 has been paid successfully.', 'App\\Models\\Order', 49, 49, 7, NULL, 1, 1),
(167, '2025-11-10 20:06:06', '2025-11-10 20:06:06', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 59, 59, 3, NULL, 1, 1),
(168, '2025-11-10 20:06:06', '2025-11-10 20:06:06', 'new order.', 'you have new order', 'App\\Models\\Order', 59, 59, 3, NULL, 1, 1),
(169, '2025-11-10 20:06:09', '2025-11-10 20:06:09', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 60, 60, 3, NULL, 1, 1),
(170, '2025-11-10 20:06:09', '2025-11-10 20:06:09', 'new order.', 'you have new order', 'App\\Models\\Order', 60, 60, 4, NULL, 1, 1),
(171, '2025-11-10 20:06:59', '2025-11-10 20:06:59', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 61, 61, 3, NULL, 1, 1),
(172, '2025-11-10 20:06:59', '2025-11-10 20:06:59', 'new order.', 'you have new order', 'App\\Models\\Order', 61, 61, 3, NULL, 1, 1),
(173, '2025-11-10 20:07:03', '2025-11-10 20:07:03', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 62, 62, 3, NULL, 1, 1),
(174, '2025-11-10 20:07:03', '2025-11-10 20:07:03', 'new order.', 'you have new order', 'App\\Models\\Order', 62, 62, 4, NULL, 1, 1),
(175, '2025-11-10 20:13:56', '2025-11-10 20:13:56', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 63, 63, 3, NULL, 1, 1),
(176, '2025-11-10 20:13:56', '2025-11-10 20:13:56', 'new order.', 'you have new order', 'App\\Models\\Order', 63, 63, 3, NULL, 1, 1),
(177, '2025-11-10 20:13:59', '2025-11-10 20:13:59', 'new order.', 'your order sended to the provider', 'App\\Models\\Order', 64, 64, 3, NULL, 1, 1),
(178, '2025-11-10 20:13:59', '2025-11-10 20:13:59', 'new order.', 'you have new order', 'App\\Models\\Order', 64, 64, 4, NULL, 1, 1),
(179, '2025-11-11 22:29:10', '2025-11-11 22:29:10', 'verified your account', 'your code: #2759', NULL, NULL, NULL, 22, NULL, 1, 1),
(180, '2025-11-11 22:40:25', '2025-11-11 22:40:25', 'verified your account', 'your code: #3794', NULL, NULL, NULL, 23, NULL, 1, 1),
(181, '2025-11-11 22:41:31', '2025-11-11 22:41:31', 'verified your account', 'your code: #5689', NULL, NULL, NULL, 24, NULL, 1, 1),
(182, '2025-11-11 22:43:55', '2025-11-11 22:43:55', 'verified your account', 'your code: #2930', NULL, NULL, NULL, 25, NULL, 1, 1),
(183, '2025-11-11 23:22:38', '2025-11-11 23:22:38', 'verified your account', 'your code: #5776', NULL, NULL, NULL, 26, NULL, 1, 1),
(184, '2025-11-11 23:47:08', '2025-11-11 23:47:08', 'verified your account', 'your code: #3642', NULL, NULL, NULL, 27, NULL, 1, 1),
(185, '2025-11-12 00:15:34', '2025-11-12 00:15:34', 'verified your account', 'your code: #4872', NULL, NULL, NULL, 28, NULL, 1, 1),
(186, '2025-11-12 00:17:13', '2025-11-12 00:17:13', 'verified your account', 'your code: #6315', NULL, NULL, NULL, 28, NULL, 1, 1),
(187, '2025-11-12 01:15:46', '2025-11-12 01:15:46', 'verified your account', 'your code: #3929', NULL, NULL, NULL, 28, NULL, 1, 1),
(188, '2025-11-12 01:16:28', '2025-11-12 01:16:28', 'verified your account', 'your code: #6253', NULL, NULL, NULL, 28, NULL, 1, 1),
(189, '2025-11-12 01:19:06', '2025-11-12 01:19:06', 'verified your account', 'your code: #8029', NULL, NULL, NULL, 28, NULL, 1, 1),
(190, '2025-11-12 01:19:45', '2025-11-12 01:19:45', 'verified your account', 'your code: #4861', NULL, NULL, NULL, 28, NULL, 1, 1);

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
  `delivery_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `warranty` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `provider_id` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `status` tinyint DEFAULT NULL COMMENT '1 => pending, 2 => accepted, 3 => rejected',
  `notes` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rejected_reson` varchar(1255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `created_at`, `updated_at`, `files`, `cost`, `delivery_time`, `delivery_fee`, `warranty`, `deleted_at`, `is_activate`, `provider_id`, `order_id`, `status`, `notes`, `rejected_reson`, `report_id`) VALUES
(1, '2025-10-17 07:34:52', '2025-11-09 10:56:25', 'admin/assets/images/quotations/176069381589768.pdf,admin/assets/images/quotations/176069381538058.png', 1500.00, '2025-10-17 09:08:28', 0.00, 'warranty', NULL, 1, 3, 49, 3, '44444 44444444 44444444 44444444', 'wwwwwwwww wwwwwwwwww wwwwwwwwwwwwww', 1),
(2, '2025-10-17 07:36:55', '2025-11-09 15:54:58', 'admin/assets/images/quotations/176278378563987.png,admin/assets/images/quotations/176278378537999.png', 1000.00, '2025-10-17 09:08:28', 0.00, 'warranty', NULL, 1, 7, 49, 2, NULL, NULL, 1),
(4, '2025-10-17 07:41:00', '2025-11-10 12:13:23', 'admin/assets/images/quotations/176069406066035.pdf,admin/assets/images/quotations/176069406012375.png', 1200.00, '2025-10-27 09:08:28', 0.00, 'warranty', NULL, 1, 3, 12, 2, NULL, NULL, 1),
(5, '2025-10-17 07:41:00', '2025-10-23 10:10:00', 'admin/assets/images/quotations/176069406066035.pdf,admin/assets/images/quotations/176069406012375.png', 1200.00, '2025-10-27 09:08:28', 0.00, 'warranty', NULL, 1, 6, 49, 1, NULL, NULL, 1),
(6, '2025-11-03 08:18:54', '2025-11-03 08:18:54', 'admin/assets/images/quotations/176216513438166.png,admin/assets/images/quotations/176216513454743.png', 1000.00, '20', 0.00, 'warranty', NULL, 1, 3, 12, 1, NULL, NULL, 1),
(7, '2025-11-03 08:19:07', '2025-11-03 08:19:07', 'admin/assets/images/quotations/176216514738110.png,admin/assets/images/quotations/176216514752883.png', 10000.00, '20', 0.00, 'warranty', NULL, 1, 3, 12, 1, NULL, NULL, 1),
(8, '2025-11-03 08:19:41', '2025-11-03 08:19:41', 'admin/assets/images/quotations/176216518131119.png,admin/assets/images/quotations/176216518170461.png', 10000.00, '20', 0.00, 'warranty', NULL, 1, 3, 12, 1, NULL, NULL, 1),
(9, '2025-11-09 16:12:04', '2025-11-09 16:16:31', 'admin/assets/images/quotations/176271192436141.png,admin/assets/images/quotations/176271192479103.png', 10000.00, '20', 0.00, 'warranty', NULL, 1, 3, 13, 2, 'notes7777', NULL, 1),
(10, '2025-11-10 12:09:45', '2025-11-10 12:09:45', 'admin/assets/images/quotations/176278378563987.png,admin/assets/images/quotations/176278378537999.png', 10000.00, '20', 111.00, 'warranty', NULL, 1, 3, 13, 1, 'notes7777', NULL, 1);

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
  `getway_transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` tinyint DEFAULT '0' COMMENT '0 => unpaid, 1 => paid',
  `request_type` tinyint DEFAULT NULL COMMENT '1 => Immediate Request, 2 => Scheduled Request',
  `delivery_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frequency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_start_date` datetime DEFAULT NULL,
  `vat` int DEFAULT '0',
  `vat_amount` decimal(10,2) DEFAULT '0.00',
  `delivery_fee` decimal(10,2) DEFAULT '0.00',
  `discount` decimal(10,2) DEFAULT '0.00',
  `items_cost` decimal(10,2) DEFAULT '0.00',
  `total_before_discount` decimal(10,2) DEFAULT '0.00',
  `total_cost` decimal(10,2) DEFAULT '0.00',
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
  `deleted_at` datetime DEFAULT NULL,
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `created_at`, `updated_at`, `user_id`, `device_category_id`, `coupon_id`, `provider_id`, `offer_id`, `order_type`, `payment_type`, `getway_transaction_id`, `payment_status`, `request_type`, `delivery_duration`, `frequency`, `schedule_start_date`, `vat`, `vat_amount`, `delivery_fee`, `discount`, `items_cost`, `total_before_discount`, `total_cost`, `address`, `files`, `notes`, `device_name`, `budget`, `quotation_type`, `serial_number`, `issue_description`, `date_time_picker`, `preferred_service_time`, `deleted_at`, `report_id`) VALUES
(1, '2025-10-13 15:02:21', '2025-10-13 15:02:21', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 286.60, NULL, 0.00, 2866.00, 3152.60, 3152.60, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, '2025-10-13 15:09:39', '2025-10-13 15:09:39', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 286.60, NULL, 0.00, 2866.00, 3152.60, 3152.60, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(3, '2025-10-13 15:45:34', '2025-10-13 15:45:34', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 286.60, NULL, 0.00, 2866.00, 3152.60, 3152.60, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(7, '2025-10-14 04:40:43', '2025-10-14 04:40:43', 3, NULL, 3, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 286.60, NULL, 343.92, 2866.00, 3152.60, 2808.68, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(8, '2025-10-14 04:46:21', '2025-10-14 04:46:21', 3, NULL, 3, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 286.60, NULL, 12.00, 2866.00, 3152.60, 3140.60, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(9, '2025-10-14 05:04:23', '2025-10-14 05:04:23', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 286.60, NULL, 0.00, 2866.00, 3152.60, 3152.60, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(10, '2025-10-17 05:51:20', '2025-10-17 05:51:20', 3, NULL, NULL, 3, NULL, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin/assets/images/quotations/176068748037849.pdf,admin/assets/images/quotations/176068748064153.png', 'aaaaaaa aaaaaaaaaaaa aaaaaaaaaaaa', NULL, '20000', NULL, NULL, NULL, '2025-10-17 09:08:28', NULL, NULL, 1),
(11, '2025-10-17 06:21:05', '2025-10-17 06:21:05', 3, NULL, NULL, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(12, '2025-10-17 06:30:04', '2025-10-23 10:10:00', 3, 1, NULL, 3, 5, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 50.00, NULL, NULL, NULL, NULL, 'address address address', NULL, NULL, 'device_name device_name device_name', NULL, NULL, 'serial_number serial_number serial_number', 'issue_description issue_description issue_description issue_description', NULL, '2025-10-17 09:08:28', NULL, 1),
(13, '2025-10-17 06:52:07', '2025-11-09 16:16:31', 3, NULL, NULL, 3, 9, 2, NULL, NULL, NULL, 2, 'delivery duration', 'frequency', '2025-10-17 09:08:28', 10, 1000.00, NULL, NULL, 10000.00, 11000.00, 11000.00, NULL, NULL, 'aaaaaaa aaaaaaaaaaaa aaaaaaaaaaaa', NULL, '20000', NULL, NULL, NULL, '2025-10-17 09:08:28', NULL, NULL, 1),
(14, '2025-10-22 10:52:00', '2025-10-22 10:52:00', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 162.00, NULL, 0.00, 1620.00, 1782.00, 1782.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(15, '2025-10-23 07:20:02', '2025-10-23 07:20:02', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 150.00, NULL, 0.00, 1500.00, 1650.00, 1650.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(16, '2025-10-23 07:24:19', '2025-10-23 07:24:19', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(17, '2025-10-23 07:25:32', '2025-10-23 07:25:32', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(18, '2025-10-23 07:26:14', '2025-10-23 07:26:14', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(19, '2025-10-23 07:27:07', '2025-10-23 07:27:07', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(20, '2025-10-23 07:27:22', '2025-10-23 07:27:22', 3, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(22, '2025-10-23 07:28:39', '2025-10-23 07:28:39', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 75.00, NULL, 0.00, 750.00, 825.00, 825.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(23, '2025-10-23 07:30:42', '2025-10-23 07:30:42', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 75.00, NULL, 0.00, 750.00, 825.00, 825.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(24, '2025-10-23 07:36:37', '2025-10-23 07:36:37', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 75.00, NULL, 0.00, 750.00, 825.00, 825.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(25, '2025-10-23 07:43:11', '2025-10-23 07:43:11', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 75.00, NULL, 0.00, 750.00, 825.00, 825.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(26, '2025-10-23 07:50:38', '2025-10-23 07:50:38', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 75.00, NULL, 0.00, 750.00, 825.00, 825.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(27, '2025-10-23 07:53:13', '2025-10-23 07:53:13', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 75.00, NULL, 0.00, 750.00, 825.00, 825.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(29, '2025-10-23 09:03:29', '2025-10-23 09:03:29', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 75.00, NULL, 0.00, 750.00, 825.00, 825.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(30, '2025-10-23 09:03:37', '2025-10-23 09:03:37', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 75.00, NULL, 0.00, 750.00, 825.00, 825.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(31, '2025-10-23 09:05:14', '2025-10-23 09:05:14', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 75.00, NULL, 0.00, 750.00, 825.00, 825.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(32, '2025-10-23 09:07:08', '2025-10-23 09:07:08', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 75.00, NULL, 0.00, 750.00, 825.00, 825.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(33, '2025-10-23 09:11:33', '2025-10-23 09:11:33', 3, NULL, NULL, 3, NULL, 2, NULL, NULL, NULL, 1, 'delivery duration', 'frequency', '2025-10-17 09:08:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aaaaaaa aaaaaaaaaaaa aaaaaaaaaaaa', NULL, '20000', NULL, NULL, NULL, '2025-10-17 09:08:28', NULL, NULL, 1),
(34, '2025-10-23 09:14:15', '2025-10-23 09:14:15', 3, NULL, NULL, 3, NULL, 2, NULL, NULL, NULL, 1, 'delivery duration', 'frequency', '2025-10-17 09:08:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aaaaaaa aaaaaaaaaaaa aaaaaaaaaaaa', NULL, '20000', NULL, NULL, NULL, '2025-10-17 09:08:28', NULL, NULL, 1),
(35, '2025-10-23 09:18:51', '2025-10-23 09:18:51', 3, NULL, NULL, 3, NULL, 2, NULL, NULL, NULL, 2, 'delivery duration', 'frequency', '2025-10-17 09:08:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aaaaaaa aaaaaaaaaaaa aaaaaaaaaaaa', NULL, '20000', NULL, NULL, NULL, '2025-10-17 09:08:28', NULL, NULL, 1),
(37, '2025-10-23 15:27:53', '2025-10-23 15:27:53', 3, 1, NULL, 2, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'address address address', NULL, NULL, 'device_name device_name device_name', NULL, NULL, 'serial_number serial_number serial_number', 'issue_description issue_description issue_description issue_description', NULL, '2025-10-17 09:08:28', NULL, 1),
(38, '2025-10-23 15:30:38', '2025-10-23 15:30:38', 3, 1, NULL, 3, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'address address address', NULL, NULL, 'device_name device_name device_name', NULL, NULL, 'serial_number serial_number serial_number', 'issue_description issue_description issue_description issue_description', NULL, '2025-10-17 09:08:28', NULL, 1),
(39, '2025-10-23 15:37:30', '2025-10-23 15:37:30', 3, 1, NULL, 2, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'address address address', NULL, NULL, 'device_name device_name device_name', NULL, NULL, 'serial_number serial_number serial_number', 'issue_description issue_description issue_description issue_description', NULL, '2025-10-17 09:08:28', NULL, 1),
(40, '2025-10-23 15:37:36', '2025-11-07 07:30:43', 3, 1, NULL, 3, NULL, 3, 'Visa', '1278018', 1, NULL, NULL, NULL, NULL, 10, 83.20, NULL, 0.00, 832.00, 915.20, 1915.20, 'address address address', NULL, NULL, 'device_name device_name device_name', NULL, NULL, 'serial_number serial_number serial_number', 'issue_description issue_description issue_description issue_description', NULL, '2025-10-17 09:08:28', NULL, 1),
(43, '2025-10-25 09:58:30', '2025-11-08 12:08:51', 3, NULL, NULL, NULL, NULL, 1, 'Visa', '1277901', 1, NULL, NULL, NULL, NULL, 10, 83.20, NULL, 0.00, 832.00, 915.20, 915.20, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, 'issue issue / issue issue 2', NULL, NULL, NULL, 1),
(44, '2025-11-08 18:21:28', '2025-11-08 18:21:28', 3, NULL, 3, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, 10, 239.40, NULL, 287.28, 2394.00, 2633.40, 2346.12, 'aaaaaa aaaaaaaaa aaaaaaaaaaa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(45, '2025-11-08 18:22:20', '2025-11-09 00:04:57', 3, NULL, 3, 3, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, 10, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'aaaaaa aaaaaaaaa aaaaaaaaaaa', NULL, NULL, NULL, NULL, NULL, NULL, 'ddddddddd dddddddddd ddddddddd', NULL, NULL, NULL, 1),
(48, '2025-11-08 22:50:17', '2025-11-08 22:50:17', 3, NULL, 3, 3, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, 10, 171.20, 0.00, 205.44, 1712.00, 1883.20, 1677.76, 'aaa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(49, '2025-11-09 08:50:34', '2025-11-10 17:29:25', 3, NULL, NULL, 7, 2, 2, 'Visa', '1322031', 1, 2, 'Sed necessitatibus e', 'Est et assumenda est', '2026-12-20 00:00:00', 10, 100.00, 100.00, 0.00, 1000.00, 1100.00, 1100.00, 'Minim exercitationem', 'admin/assets/images/quotations/176268543412712.png,admin/assets/images/quotations/176268543420973.png,admin/assets/images/quotations/176268543495096.png', 'Rerum elit vitae do', NULL, '6000', NULL, NULL, NULL, '2026-05-28 09:24:00', NULL, NULL, 1),
(50, '2025-11-10 08:02:15', '2025-11-10 08:02:15', 3, 2, NULL, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Ratione enim esse vo', 'admin/assets/images/quotations/176276893594057.png,admin/assets/images/quotations/176276893518386.png,admin/assets/images/quotations/176276893584605.png', NULL, 'Calista Ward', NULL, NULL, '807', 'Sit eius laborum ame', NULL, '2026-01-14 23:33:00', NULL, 1),
(59, '2025-11-10 20:06:06', '2025-11-10 20:06:06', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, 10, 30.00, 0.00, 0.00, 300.00, 330.00, 330.00, 'cairo, nasr city', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(60, '2025-11-10 20:06:09', '2025-11-10 20:06:09', 3, NULL, NULL, 4, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, 10, 247.60, 0.00, 0.00, 2476.00, 2723.60, 2723.60, 'cairo, nasr city', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(61, '2025-11-10 20:06:59', '2025-11-10 20:06:59', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, 10, 30.00, 0.00, 0.00, 300.00, 330.00, 330.00, 'cairo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(62, '2025-11-10 20:07:03', '2025-11-10 20:07:03', 3, NULL, NULL, 4, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, 10, 247.60, 0.00, 0.00, 2476.00, 2723.60, 2723.60, 'cairo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(63, '2025-11-10 20:13:56', '2025-11-10 20:13:56', 3, NULL, NULL, 3, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, 10, 30.00, 0.00, 0.00, 300.00, 330.00, 330.00, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(64, '2025-11-10 20:13:59', '2025-11-10 20:13:59', 3, NULL, NULL, 4, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, 10, 55.60, 0.00, 0.00, 556.00, 611.60, 611.60, 'address address address address address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

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
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `created_at`, `updated_at`, `order_id`, `product_id`, `quantity`, `item_price`, `total_price`, `deleted_at`, `is_activate`, `report_id`) VALUES
(1, NULL, NULL, 1, 2, 3, 682.00, 2046.00, NULL, 1, 1),
(2, NULL, NULL, 1, 1, 1, 820.00, 820.00, NULL, 1, 1),
(3, NULL, NULL, 2, 2, 3, 682.00, 2046.00, NULL, 1, 1),
(4, NULL, NULL, 2, 1, 1, 820.00, 820.00, NULL, 1, 1),
(5, '2025-10-13 15:45:34', '2025-10-13 15:45:34', 3, 2, 3, 682.00, 2046.00, NULL, 1, 1),
(6, '2025-10-13 15:45:34', '2025-10-13 15:45:34', 3, 1, 1, 820.00, 820.00, NULL, 1, 1),
(13, '2025-10-14 04:40:43', '2025-10-14 04:40:43', 7, 2, 3, 682.00, 2046.00, NULL, 1, 1),
(14, '2025-10-14 04:40:43', '2025-10-14 04:40:43', 7, 1, 1, 820.00, 820.00, NULL, 1, 1),
(15, '2025-10-14 04:46:21', '2025-10-14 04:46:21', 8, 2, 3, 682.00, 2046.00, NULL, 1, 1),
(16, '2025-10-14 04:46:21', '2025-10-14 04:46:21', 8, 1, 1, 820.00, 820.00, NULL, 1, 1),
(17, '2025-10-14 05:04:23', '2025-10-14 05:04:23', 12, 2, 3, 682.00, 2046.00, NULL, 1, 1),
(18, '2025-10-14 05:04:23', '2025-10-14 05:04:23', 12, 3, 1, 820.00, 820.00, NULL, 1, 1),
(19, '2025-10-22 10:52:00', '2025-10-22 10:52:00', 14, 1, 1, 820.00, 820.00, NULL, 1, 1),
(20, '2025-10-22 10:52:00', '2025-10-22 10:52:00', 14, 4, 2, 150.00, 300.00, NULL, 1, 1),
(21, '2025-10-22 10:52:00', '2025-10-22 10:52:00', 14, 3, 5, 100.00, 500.00, NULL, 1, 1),
(22, '2025-10-23 07:20:02', '2025-10-23 07:20:02', 15, 7, 5, 150.00, 750.00, NULL, 1, 1),
(23, '2025-10-23 07:20:02', '2025-10-23 07:20:02', 15, 4, 5, 150.00, 750.00, NULL, 1, 1),
(25, '2025-10-23 07:28:39', '2025-10-23 07:28:39', 22, 4, 5, 150.00, 750.00, NULL, 1, 1),
(26, '2025-10-23 07:30:42', '2025-10-23 07:30:42', 23, 4, 5, 150.00, 750.00, NULL, 1, 1),
(27, '2025-10-23 07:36:37', '2025-10-23 07:36:37', 24, 4, 5, 150.00, 750.00, NULL, 1, 1),
(28, '2025-10-23 07:43:11', '2025-10-23 07:43:11', 25, 4, 5, 150.00, 750.00, NULL, 1, 1),
(29, '2025-10-23 07:50:38', '2025-10-23 07:50:38', 26, 4, 5, 150.00, 750.00, NULL, 1, 1),
(30, '2025-10-23 07:53:13', '2025-10-23 07:53:13', 27, 4, 5, 150.00, 750.00, NULL, 1, 1),
(32, '2025-10-23 09:03:29', '2025-10-23 09:03:29', 29, 4, 5, 150.00, 750.00, NULL, 1, 1),
(33, '2025-10-23 09:03:37', '2025-10-23 09:03:37', 30, 4, 5, 150.00, 750.00, NULL, 1, 1),
(34, '2025-10-23 09:05:14', '2025-10-23 09:05:14', 31, 4, 5, 150.00, 750.00, NULL, 1, 1),
(35, '2025-10-23 09:07:08', '2025-10-23 09:07:08', 32, 4, 5, 150.00, 750.00, NULL, 1, 1),
(36, '2025-10-25 09:58:30', '2025-10-25 09:58:30', 43, 4, 1, 150.00, 150.00, NULL, 1, 1),
(37, '2025-10-25 09:58:30', '2025-10-25 09:58:30', 43, 2, 1, 682.00, 682.00, NULL, 1, 1),
(38, '2025-11-08 18:21:28', '2025-11-08 18:21:28', 45, 2, 1, 682.00, 682.00, NULL, 1, 1),
(39, '2025-11-08 18:21:28', '2025-11-08 18:21:28', 45, 4, 2, 150.00, 300.00, NULL, 1, 1),
(40, '2025-11-08 18:21:28', '2025-11-08 18:21:28', 45, 7, 2, 150.00, 300.00, NULL, 1, 1),
(41, '2025-11-08 18:21:28', '2025-11-08 18:21:28', 45, 6, 2, 556.00, 1112.00, NULL, 1, 1),
(48, '2025-11-08 22:50:17', '2025-11-08 22:50:17', 48, 4, 2, 150.00, 300.00, NULL, 1, 1),
(49, '2025-11-08 22:50:17', '2025-11-08 22:50:17', 48, 6, 2, 556.00, 1112.00, NULL, 1, 1),
(50, '2025-11-08 22:50:17', '2025-11-08 22:50:17', 48, 7, 2, 150.00, 300.00, NULL, 1, 1),
(61, '2025-11-10 20:06:06', '2025-11-10 20:06:06', 59, 7, 2, 150.00, 300.00, NULL, 1, 1),
(62, '2025-11-10 20:06:09', '2025-11-10 20:06:09', 60, 6, 2, 556.00, 1112.00, NULL, 1, 1),
(63, '2025-11-10 20:06:09', '2025-11-10 20:06:09', 60, 2, 2, 682.00, 1364.00, NULL, 1, 1),
(64, '2025-11-10 20:06:59', '2025-11-10 20:06:59', 61, 7, 2, 150.00, 300.00, NULL, 1, 1),
(65, '2025-11-10 20:07:03', '2025-11-10 20:07:03', 62, 6, 2, 556.00, 1112.00, NULL, 1, 1),
(66, '2025-11-10 20:07:03', '2025-11-10 20:07:03', 62, 2, 2, 682.00, 1364.00, NULL, 1, 1),
(67, '2025-11-10 20:13:56', '2025-11-10 20:13:56', 63, 7, 1, 150.00, 150.00, NULL, 1, 1),
(68, '2025-11-10 20:13:56', '2025-11-10 20:13:56', 63, 4, 1, 150.00, 150.00, NULL, 1, 1),
(69, '2025-11-10 20:13:59', '2025-11-10 20:13:59', 64, 6, 1, 556.00, 556.00, NULL, 1, 1);

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
  `received_all_quantity` tinyint NOT NULL DEFAULT '0',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_partial_receive`
--

INSERT INTO `order_partial_receive` (`id`, `created_at`, `updated_at`, `order_id`, `user_id`, `offer_id`, `files`, `received_quantity`, `reason_for_partial`, `deleted_at`, `is_activate`, `received_all_quantity`, `report_id`) VALUES
(1, '2025-10-18 05:46:07', '2025-10-18 05:46:07', 12, 3, NULL, NULL, 20, 'reason for partial', NULL, 1, 0, 1),
(2, '2025-10-18 05:46:59', '2025-10-18 05:46:59', 12, 3, NULL, 'admin/assets/images/orders/176077361962994.png,admin/assets/images/orders/176077361964279.png', 20, 'reason for partial', NULL, 1, 0, 1),
(3, '2025-10-18 05:47:29', '2025-10-18 05:47:29', 13, 3, NULL, 'admin/assets/images/orders/176077364991405.png,admin/assets/images/orders/176077364967018.png', NULL, NULL, NULL, 1, 1, 1),
(4, '2025-10-18 06:01:04', '2025-10-18 06:01:04', 8, 3, NULL, 'admin/assets/images/orders/176077446496552.png,admin/assets/images/orders/176077446454646.png', 2000, 'reason for partial', NULL, 1, 0, 1),
(5, '2025-11-11 21:22:21', '2025-11-11 21:22:21', 49, 3, NULL, 'admin/assets/images/orders/176290334119976.png,admin/assets/images/orders/176290334129273.png,admin/assets/images/orders/176290334127618.png', 20, 'Repudiandae aut prov', NULL, 1, 0, 1);

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
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_timeline`
--

INSERT INTO `order_timeline` (`id`, `created_at`, `updated_at`, `user_id`, `order_id`, `timeline_no`, `action_at`, `deleted_at`, `is_activate`, `report_id`) VALUES
(2, '2025-10-14 04:40:43', '2025-10-14 04:40:43', 3, 7, 1, '2025-10-14 06:40:43', NULL, 1, 1),
(3, '2025-10-14 04:46:21', '2025-10-14 04:46:21', 3, 8, 1, '2025-10-14 06:46:21', NULL, 1, 1),
(4, '2025-10-14 05:04:23', '2025-10-14 05:04:23', 3, 9, 1, '2025-10-14 07:04:23', NULL, 1, 1),
(5, '2025-10-17 05:51:20', '2025-10-17 05:51:20', 3, 10, 1, '2025-10-17 07:51:20', NULL, 1, 1),
(6, '2025-10-17 06:21:05', '2025-10-17 06:21:05', 3, 11, 1, '2025-10-17 08:21:05', NULL, 1, 1),
(7, '2025-10-17 06:30:04', '2025-10-17 06:30:04', 3, 12, 1, '2025-10-17 08:30:04', NULL, 1, 1),
(8, '2025-10-17 06:52:07', '2025-10-17 06:52:07', 3, 13, 1, '2025-10-17 08:52:07', NULL, 1, 1),
(9, '2025-10-17 22:10:00', '2025-10-17 22:10:00', 3, 12, 2, '2025-10-18 00:10:00', NULL, 1, 1),
(10, '2025-10-17 22:14:08', '2025-10-17 22:14:08', 3, 12, 3, '2025-10-18 00:14:08', NULL, 1, 1),
(12, '2025-10-22 10:52:00', '2025-10-22 10:52:00', 3, 14, 1, '2025-10-22 12:52:00', NULL, 1, 1),
(13, '2025-10-23 07:20:02', '2025-10-23 07:20:02', 3, 15, 1, '2025-10-23 09:20:02', NULL, 1, 1),
(14, '2025-10-23 07:24:19', '2025-10-23 07:24:19', 3, 16, 1, '2025-10-23 09:24:19', NULL, 1, 1),
(15, '2025-10-23 07:25:32', '2025-10-23 07:25:32', 3, 17, 1, '2025-10-23 09:25:32', NULL, 1, 1),
(16, '2025-10-23 07:26:14', '2025-10-23 07:26:14', 3, 18, 1, '2025-10-23 09:26:14', NULL, 1, 1),
(17, '2025-10-23 07:27:07', '2025-10-23 07:27:07', 3, 19, 1, '2025-10-23 09:27:07', NULL, 1, 1),
(18, '2025-10-23 07:27:22', '2025-10-23 07:27:22', 3, 20, 1, '2025-10-23 09:27:22', NULL, 1, 1),
(20, '2025-10-23 07:28:39', '2025-10-23 07:28:39', 3, 22, 1, '2025-10-23 09:28:39', NULL, 1, 1),
(21, '2025-10-23 07:30:42', '2025-10-23 07:30:42', 3, 23, 1, '2025-10-23 09:30:42', NULL, 1, 1),
(22, '2025-10-23 07:36:37', '2025-10-23 07:36:37', 3, 24, 1, '2025-10-23 09:36:37', NULL, 1, 1),
(23, '2025-10-23 07:43:11', '2025-10-23 07:43:11', 3, 25, 1, '2025-10-23 09:43:11', NULL, 1, 1),
(24, '2025-10-23 07:50:38', '2025-10-23 07:50:38', 3, 26, 1, '2025-10-23 09:50:38', NULL, 1, 1),
(25, '2025-10-23 07:53:13', '2025-10-23 07:53:13', 3, 27, 1, '2025-10-23 09:53:13', NULL, 1, 1),
(27, '2025-10-23 09:03:30', '2025-10-23 09:03:30', 3, 29, 1, '2025-10-23 11:03:30', NULL, 1, 1),
(28, '2025-10-23 09:03:37', '2025-10-23 09:03:37', 3, 30, 1, '2025-10-23 11:03:37', NULL, 1, 1),
(29, '2025-10-23 09:05:14', '2025-10-23 09:05:14', 3, 31, 1, '2025-10-23 11:05:14', NULL, 1, 1),
(30, '2025-10-23 09:07:08', '2025-10-23 09:07:08', 3, 32, 1, '2025-10-23 11:07:08', NULL, 1, 1),
(31, '2025-10-23 09:11:33', '2025-10-23 09:11:33', 3, 33, 1, '2025-10-23 11:11:33', NULL, 1, 1),
(32, '2025-10-23 09:14:15', '2025-10-23 09:14:15', 3, 34, 1, '2025-10-23 11:14:15', NULL, 1, 1),
(33, '2025-10-23 09:18:51', '2025-10-23 09:18:51', 3, 35, 1, '2025-10-23 11:18:51', NULL, 1, 1),
(35, '2025-10-23 10:07:46', '2025-10-23 10:07:46', 3, 35, 2, '2025-10-23 12:07:46', NULL, 1, 1),
(36, '2025-10-23 15:27:53', '2025-10-23 15:27:53', 3, 37, 1, '2025-10-23 17:27:53', NULL, 1, 1),
(37, '2025-10-23 15:30:38', '2025-10-23 15:30:38', 3, 38, 1, '2025-10-23 17:30:38', NULL, 1, 1),
(38, '2025-10-23 15:32:13', '2025-10-23 15:32:13', 3, 38, 2, '2025-10-23 17:32:13', NULL, 1, 1),
(39, '2025-10-23 15:37:30', '2025-10-23 15:37:30', 3, 39, 1, '2025-10-23 17:37:30', NULL, 1, 1),
(40, '2025-10-23 15:37:36', '2025-10-23 15:37:36', 3, 40, 1, '2025-10-23 17:37:36', NULL, 1, 1),
(43, '2025-10-25 09:58:30', '2025-10-25 09:58:30', 3, 43, 1, '2025-10-25 11:58:30', NULL, 1, 1),
(44, '2025-10-25 21:19:44', '2025-10-25 21:19:44', 3, 40, 2, '2025-10-25 23:19:44', NULL, 1, 1),
(47, '2025-11-08 18:21:28', '2025-11-08 18:21:28', 3, 44, 1, '2025-11-08 20:21:28', NULL, 1, 1),
(48, '2025-11-08 18:22:20', '2025-11-08 18:22:20', 3, 45, 1, '2025-11-08 20:22:20', NULL, 1, 1),
(49, '2025-11-08 18:22:20', '2025-11-08 18:22:20', 5, 45, 2, '2025-11-08 20:22:20', NULL, 1, 1),
(50, '2025-11-08 18:22:20', '2025-11-08 18:22:20', 5, 45, 3, '2025-11-08 20:22:20', NULL, 1, 1),
(53, '2025-11-08 22:50:17', '2025-11-08 22:50:17', 3, 48, 1, '2025-11-09 00:50:17', NULL, 1, 1),
(54, '2025-11-08 23:19:00', '2025-11-08 23:19:00', 3, 48, 12, '2025-11-09 01:19:00', NULL, 1, 1),
(55, '2025-11-08 18:22:20', '2025-11-08 18:22:20', 5, 45, 4, '2025-11-08 20:22:20', NULL, 1, 1),
(56, '2025-11-08 18:22:20', '2025-11-08 18:22:20', 5, 45, 5, '2025-11-08 20:22:20', NULL, 1, 1),
(57, '2025-11-09 00:29:40', '2025-11-09 00:29:40', 3, 45, 6, '2025-11-09 02:29:40', NULL, 1, 1),
(58, '2025-11-09 08:50:35', '2025-11-09 08:50:35', 3, 49, 1, '2025-11-09 10:50:35', NULL, 1, 1),
(59, '2025-11-09 15:54:58', '2025-11-09 15:54:58', 3, 49, 7, '2025-11-09 17:54:58', NULL, 1, 1),
(60, '2025-11-09 15:54:58', '2025-11-09 15:54:58', 3, 49, 9, '2025-11-09 17:54:58', NULL, 1, 1),
(61, '2025-11-09 16:12:04', '2025-11-09 16:12:04', 3, 13, 1, '2025-11-09 18:12:04', NULL, 1, 1),
(62, '2025-11-09 16:16:31', '2025-11-09 16:16:31', 3, 13, 9, '2025-11-09 18:16:31', NULL, 1, 1),
(63, '2025-11-10 08:02:15', '2025-11-10 08:02:15', 3, 50, 1, '2025-11-10 10:02:15', NULL, 1, 1),
(64, '2025-11-10 12:09:45', '2025-11-10 12:09:45', 3, 13, 7, '2025-11-10 14:09:45', NULL, 1, 1),
(73, '2025-11-10 20:06:06', '2025-11-10 20:06:06', 3, 59, 1, '2025-11-10 22:06:06', NULL, 1, 1),
(74, '2025-11-10 20:06:09', '2025-11-10 20:06:09', 3, 60, 1, '2025-11-10 22:06:09', NULL, 1, 1),
(75, '2025-11-10 20:06:59', '2025-11-10 20:06:59', 3, 61, 1, '2025-11-10 22:06:59', NULL, 1, 1),
(76, '2025-11-10 20:07:03', '2025-11-10 20:07:03', 3, 62, 1, '2025-11-10 22:07:03', NULL, 1, 1),
(77, '2025-11-10 20:13:56', '2025-11-10 20:13:56', 3, 63, 1, '2025-11-10 22:13:56', NULL, 1, 1),
(78, '2025-11-10 20:13:59', '2025-11-10 20:13:59', 3, 64, 1, '2025-11-10 22:13:59', NULL, 1, 1),
(79, '2025-11-09 15:54:58', '2025-11-09 15:54:58', 3, 49, 3, '2025-11-09 17:54:58', NULL, 1, 1),
(80, '2025-11-09 15:55:58', '2025-11-09 15:55:58', 3, 49, 4, '2025-11-09 17:55:58', NULL, 1, 1),
(81, '2025-11-09 08:56:35', '2025-11-09 08:56:35', 3, 49, 5, '2025-11-09 10:56:35', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `report_id` tinyint NOT NULL DEFAULT '1'
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
  `updated_at` timestamp NULL DEFAULT NULL,
  `report_id` tinyint NOT NULL DEFAULT '1'
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
  `power` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manufacture_date` date DEFAULT NULL,
  `production_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimensions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warranty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin_id` int DEFAULT NULL,
  `provider_id` int DEFAULT NULL,
  `is_offer` tinyint NOT NULL DEFAULT '0',
  `is_special` tinyint NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `created_at`, `updated_at`, `name`, `category_id`, `desc`, `price`, `stock_quantity`, `img`, `imgs`, `imaging_type`, `power`, `manufacture_date`, `production_date`, `expiry_date`, `weight`, `dimensions`, `warranty`, `origin_id`, `provider_id`, `is_offer`, `is_special`, `deleted_at`, `is_activate`, `report_id`) VALUES
(1, '2025-10-08 01:12:27', '2025-10-08 01:12:27', 'Clayton Gomez', 2, 'Veniam facilis offi', 820.00, 807, 'admin/assets/images/products/175989314777281.png', 'admin/assets/images/products/175989314759419.png,admin/assets/images/products/175989314738878.png,admin/assets/images/products/175989314752094.png', 'Accusamus necessitat', NULL, '2024-12-24', '2025-01-11', '2025-12-26', 'Quis doloribus dolor', 'Enim fugiat cillum a', 'Adipisci quae nihil', 2, 3, 0, 0, NULL, 1, 1),
(2, '2025-10-08 01:13:18', '2025-11-10 19:31:55', 'Hope Carr 2222', 1, 'Possimus porro qui 00', 682.00, 68100, 'admin/assets/images/products/175989385946497.png', 'admin/assets/images/products/175989319839038.png,admin/assets/images/products/175989319847555.png,admin/assets/images/products/175989319857839.png', 'Consequuntur tempora 00', NULL, '2023-11-13', '2025-06-27', '2025-09-09', 'Commodi reprehenderi', 'Maiores qui qui sint', 'Esse ut unde nobis v', 2, 4, 0, 0, NULL, 1, 1),
(3, '2025-10-17 22:47:30', '2025-10-17 22:47:30', 'name name', 2, 'desc desc desc', 100.00, 500, 'admin/assets/images/products/176074845041950.png', 'admin/assets/images/products/176074845095536.png,admin/assets/images/products/176074845037741.png', 'imaging type', NULL, '2025-10-17', '2025-10-17', '2025-12-17', 'weight', 'dimensions', 'warranty', 2, 3, 0, 0, NULL, 1, 1),
(4, '2025-10-17 22:52:04', '2025-11-01 05:18:14', 'name name 2', 2, 'desc desc desc 222', 150.00, 500, 'admin/assets/images/products/176074872416367.png', 'admin/assets/images/products/176074872470575.png,admin/assets/images/products/176074872438653.png', 'ppooiiuu', '1231kk', '2025-10-17', '2025-10-17', '2025-12-17', 'weight 22', 'dimensions', 'warranty', 2, 3, 0, 1, NULL, 1, 1),
(6, '2025-10-22 00:56:24', '2025-10-22 00:58:14', 'Phyllis Fuller', 2, 'A vel explicabo Rep', 556.00, 429, 'admin/assets/images/products/176110178453670.png', NULL, 'Esse est minim sus', NULL, '1978-03-06', '1983-03-04', '2003-06-17', 'Quaerat voluptatem e', 'Aut autem deserunt e', 'Ullam ipsum iure lo', 2, 4, 1, 1, NULL, 1, 1),
(7, '2025-10-22 01:00:37', '2025-10-22 01:01:44', 'name name 22', 2, 'desc desc desc 222', 150.00, 500, 'admin/assets/images/products/176110203727611.avif', NULL, NULL, NULL, '2025-10-17', '2025-10-17', '2025-12-17', 'weight 22', 'dimensions', 'warranty', 2, 3, 1, 1, NULL, 1, 1);

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
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `created_at`, `updated_at`, `comment`, `rating`, `user_id`, `forable_type`, `forable_id`, `deleted_at`, `is_activate`, `report_id`) VALUES
(1, '2025-10-18 03:29:51', '2025-10-18 03:29:51', 'test test test 11', 3, 2, 'App\\Models\\User', 3, NULL, 1, 1),
(2, '2025-10-18 03:30:56', '2025-10-18 03:30:56', 'test test test 22', 3, 3, 'App\\Models\\Product', 4, NULL, 1, 1),
(3, '2025-10-18 03:31:02', '2025-10-18 03:31:02', 'test test test 33', 5, 3, 'App\\Models\\Product', 4, NULL, 1, 1),
(4, '2025-10-18 03:31:06', '2025-10-18 03:31:06', 'test test test 44', 4, 3, 'App\\Models\\Product', 4, NULL, 1, 1),
(5, '2025-10-18 03:31:09', '2025-10-18 03:54:23', 'test test test 55', 2, 3, 'App\\Models\\Product', 4, NULL, 1, 1),
(6, '2025-10-18 03:31:13', '2025-10-18 03:54:11', 'test test test 66', 5, 3, 'App\\Models\\Product', 4, NULL, 1, 1),
(7, '2025-10-18 03:31:31', '2025-10-18 03:31:31', 'test test test 77', 5, 1, 'App\\Models\\User', 4, NULL, 1, 1),
(8, '2025-10-18 03:31:35', '2025-10-18 03:31:35', 'test test test 88', 4, 3, 'App\\Models\\User', 4, NULL, 1, 1),
(9, '2025-10-22 01:08:14', '2025-10-22 01:08:14', 'test test test 99', 4, 3, 'App\\Models\\User', 3, NULL, 0, 1),
(10, '2025-10-22 01:08:28', '2025-10-22 01:08:28', 'test test test 00', 0, 3, 'App\\Models\\User', 3, NULL, 0, 1),
(11, '2025-10-22 01:08:34', '2025-10-22 01:08:34', 'test test test', 5, 3, 'App\\Models\\User', 3, NULL, 0, 1),
(12, '2025-11-09 01:01:00', '2025-11-09 01:01:00', 'qqqqqqqqqqqqqqqq', 3, 3, 'App\\Models\\User', 3, NULL, 0, 1),
(13, '2025-11-09 01:04:10', '2025-11-09 01:04:10', 'rrrrrrrrrrrrrrrrrrrrrrrrrrr', 4, 3, 'App\\Models\\User', 3, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_activate` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `created_at`, `updated_at`, `name`, `deleted_at`, `is_activate`) VALUES
(1, '2025-10-28 09:34:15', '2025-10-28 09:34:15', 'report', NULL, 1);

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
  `is_activate` tinyint NOT NULL DEFAULT '1',
  `report_id` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `mobile`, `mobile_verified_at`, `iban`, `branch`, `tax_number`, `cr_number`, `cr_document`, `location`, `img`, `fcm_token`, `code`, `user_type`, `deleted_at`, `is_activate`, `report_id`) VALUES
(1, 'jesu', 'mezi@mailinator.com', NULL, '$2y$10$fUyB2Oi.63.zzbmYZPxS7eQlNDZn1b/sn6sPlEm0zK7NgrtRH.9f.', NULL, '2025-10-07 22:28:43', '2025-10-07 22:28:43', '1231231213213', NULL, NULL, 'Voluptatem expedita', '92221321kk', '254123132l', 'admin/assets/images/users/176015127150451.png', 'Nam fugiat tempor vo', 'admin/assets/images/users/175988332346772.png', NULL, NULL, 2, NULL, 1, 1),
(2, 'ruvyrin', 'fyly@mailinator.com', NULL, '$2y$10$WCIX5A8T2nbtJHWwwwFZIOSW1TK3ty/oQ9tCXSNe2fZ9C/.o5Z0P2', NULL, '2025-10-07 22:31:27', '2025-10-07 22:31:27', '98784654655', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin/assets/images/users/175988348799653.png', NULL, NULL, 1, NULL, 1, 1),
(3, 'amr 4442', 'amr22@gmail.com', '2025-10-17 21:00:23', '$2y$10$HYErtOa2j0NJcZCYqKkjGuesixtwA1K4XIQqi6TisxSx2kdZJRUz.', NULL, '2025-10-11 00:07:27', '2025-11-08 16:58:14', '+96612345678002', '2025-10-17 21:00:23', 'iban-data', 'branch', '123123132', '123123123123', NULL, 'location', 'admin/assets/images/users/176262829453862.png', 'cXmf-bClTg68yTEcnujtvu:APA91bFQ9uDF3lki7GPv2xaA73187SLjdsvP8hOs2c5hBsMbvLULn7Tvp2PMRSVmJlmEkkB9AWaCp-apPbLS_mUezF2pIfOuhg20Ic8J6m46TCP4M5Kl91M', NULL, 2, NULL, 1, 1),
(4, 'amr 444', 'amr222@gmail.com', NULL, '$2y$10$QmskJkeIaWyVPF8QsbewJel/dnzRKmxFqMYsPmGrAgToq.KFrZlyi', NULL, '2025-10-11 00:44:45', '2025-10-11 00:44:45', '+966123456780020', NULL, 'iban-data0', NULL, NULL, NULL, NULL, 'location location location', 'admin/assets/images/users/175988348799653.png', 'cXmf-bClTg68yTEcnujtvu:APA91bFQ9uDF3lki7GPv2xaA73187SLjdsvP8hOs2c5hBsMbvLULn7Tvp2PMRSVmJlmEkkB9AWaCp-apPbLS_mUezF2pIfOuhg20Ic8J6m46TCP4M5Kl91M', '1111', 1, NULL, 1, 1),
(5, 'amr 4443', 'amr223@gmail.com', NULL, '$2y$10$v0PsS8Sq43JnvilTajtXuutwrv7pdHyJ1KwBRdm8EO6AHhOMJJky2', NULL, '2025-10-11 00:49:37', '2025-10-11 00:49:37', '+966123456780023', NULL, 'iban-data3', 'branch', '123123132', '123123123123', NULL, 'location', NULL, 'drOWb72CTLmxu4AaJ_LbU6:APA91bFoprg_oWZbiHLefNSwRbtFUMX0u-W_xu4OcT8WIP24c70bNnR8jAMcqBVGXAhfoY7H6zxzvzzCCSDZcKKmGJ3J2mQej9ENsinfLPjgLt0Yf9Grx1M', '1111', 2, NULL, 1, 1),
(6, 'amr 4444', 'amr224@gmail.com', NULL, '$2y$10$Q1HwsTFaTFtdV5LiSb9on.tFDmZXQiqs/BX9d/.8qE3mHb5cMQlbO', NULL, '2025-10-11 00:54:31', '2025-10-11 00:54:31', '+966123456780024', NULL, 'iban-data4', 'branch', '123123132', '123123123123', 'admin/assets/images/users/176015127150451.png', 'location', NULL, 'cXmf-bClTg68yTEcnujtvu:APA91bFQ9uDF3lki7GPv2xaA73187SLjdsvP8hOs2c5hBsMbvLULn7Tvp2PMRSVmJlmEkkB9AWaCp-apPbLS_mUezF2pIfOuhg20Ic8J6m46TCP4M5Kl91M', '1111', 2, NULL, 1, 1),
(7, 'amr 444499', 'amr22499@gmail.com', NULL, '$2y$10$k4Sx6JkbnUf50NHxue3xi.nxVAtKz9CfXJ2W8aEA3KCWEHJFD2Pk.', NULL, '2025-10-19 11:06:45', '2025-10-19 11:06:45', '+966123456780099', NULL, 'iban-data499', 'branch', '123123132', '123123123123', NULL, 'location', NULL, 'cXmf-bClTg68yTEcnujtvu:APA91bFQ9uDF3lki7GPv2xaA73187SLjdsvP8hOs2c5hBsMbvLULn7Tvp2PMRSVmJlmEkkB9AWaCp-apPbLS_mUezF2pIfOuhg20Ic8J6m46TCP4M5Kl91M', '1111', 2, NULL, 1, 1),
(21, 'hospital12@gmail.com', 'hospital12@gmail.com', '2025-11-08 14:21:19', '$2y$10$Vdcra7/LqkvfkVir1fFTJuw8Q7C/AjpU8rfJ5VXbR77Wf1P2cBct2', NULL, '2025-11-08 11:04:46', '2025-11-08 11:04:46', '333333333', '2025-11-08 14:21:27', '12344321', 'hospital 12', NULL, '12344321', 'admin/assets/images/users/176260708676693.jpg', 'king fahd st. jidah, KSA', NULL, 'd-HVRtGMQj-XhuD0MNuhb0:APA91bHncj5OwckPEAJHpkRwW_-tAoKb_HfvgmVY5inNRcr5l8iXMd3fWSbSEulzcx2TjOSOob4rI0lQp0bFRrN6JyA21e4MN0jZTPiQZMbvQ8J5GvGeUEU', NULL, 1, NULL, 1, 1),
(22, 'Upton Hutchinson', 'cozimy@mailinator.com', NULL, '$2y$10$6jz7mZefjoO8TphZ8jPK8uagoIHHaxg4H6obnCAFmWuUhtkrIPk.2', NULL, '2025-11-11 22:29:10', '2025-11-11 22:29:10', '789654258', NULL, 'uuuu774hh55', 'Nesciunt veniam fa', '916', '422', 'admin/assets/images/users/176290735064382.png', 'Dolor rerum quia lab', NULL, NULL, '2759', 2, NULL, 1, 1),
(23, 'Sandra Salas', 'casi@mailinator.com', NULL, '$2y$10$di9XXI1oLDo0D//k74bcfuAX.PdTbfylEbvIRR89rfviNNkJ0geVG', NULL, '2025-11-11 22:40:25', '2025-11-11 22:40:25', '456456456', NULL, '987789987', 'Ratione dolore rem e', '166', '820', 'admin/assets/images/users/176290802559974.png', 'Quis incidunt aute', NULL, NULL, '3794', 1, NULL, 1, 1),
(24, 'Xyla Allen', 'gyqegakiwu@mailinator.com', NULL, '$2y$10$KC5w.F9joMjC8XcK6tONVe7Vbs5K0lAmHSqWaxcAEtY9u1zGO3J8G', NULL, '2025-11-11 22:41:31', '2025-11-11 22:41:31', '654789654', NULL, '98745632', 'Voluptas et et vero', '394', '809', 'admin/assets/images/users/176290809128052.png', 'Cupiditate id praese', NULL, NULL, '5689', 1, NULL, 1, 1),
(25, 'Yardley Jarvis', 'zijaxe@mailinator.com', NULL, '$2y$10$4zQnOfXHFr9/k/XQ2D9iVe5qYjwYtG4F2KfkEq4tPFpHxMOUltW56', NULL, '2025-11-11 22:43:55', '2025-11-11 22:43:55', '123213256', NULL, '541321655', 'Dolore corporis quae', '938', '656', 'admin/assets/images/users/176290823561035.png', 'Molestiae voluptatem', NULL, NULL, '2930', 2, NULL, 1, 1),
(26, 'Leo Hale', 'seko@mailinator.com', '2025-11-11 23:39:48', '$2y$10$zmVjbwnND9a7IQjZeB/8nOtoME.o/InPqiUt74YYwXrZ.AFw.PWKC', NULL, '2025-11-11 23:22:38', '2025-11-11 23:39:48', '963258963', '2025-11-11 23:39:48', 'Hic distinctio Quia', 'Dolore ab esse magn', '353', '449', 'admin/assets/images/users/176291055843755.png', 'Est dicta maxime qui', NULL, NULL, NULL, 2, NULL, 1, 1),
(27, 'Kyra Mathis', 'doly@mailinator.com', '2025-11-12 00:03:33', '$2y$10$EQ/XfkP41/3Xp1uMUSG7v.mACMfQ4Vztl2CRkmsXMgE9gBlN9A4jC', NULL, '2025-11-11 23:47:08', '2025-11-12 00:03:33', '8978976543', '2025-11-12 00:03:33', '424244211111', 'Ullam commodo beatae', '766', '302', 'admin/assets/images/users/176291202873933.png', 'Possimus adipisci q', NULL, NULL, NULL, 1, NULL, 1, 1),
(28, 'Timon Crane', 'bybi@mailinator.com', '2025-11-12 00:17:39', '$2y$10$N.7D1/QHyu1dUrYs2kz87OMrr950GpkT1dGClWR6tQAodTFUrVw1.', NULL, '2025-11-12 00:15:34', '2025-11-12 01:37:13', '7852148215', '2025-11-12 00:17:39', '9568566', 'Non illum anim qui', '729', '823', 'admin/assets/images/users/176291373362575.png', 'Quos nihil ipsum to', NULL, NULL, NULL, 1, NULL, 1, 1);

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
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversations_user_two_id_foreign` (`user_two_id`),
  ADD KEY `conversations_blocked_by_foreign` (`blocked_by`),
  ADD KEY `conversations_user_one_id_user_two_id_index` (`user_one_id`,`user_two_id`),
  ADD KEY `conversations_last_message_at_index` (`last_message_at`);

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
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`),
  ADD KEY `messages_conversation_id_index` (`conversation_id`),
  ADD KEY `messages_sender_id_receiver_id_index` (`sender_id`,`receiver_id`),
  ADD KEY `messages_is_read_index` (`is_read`),
  ADD KEY `messages_created_at_index` (`created_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_serviceable_type_serviceable_id_index` (`serviceable_type`,`serviceable_id`);

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
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `order_partial_receive`
--
ALTER TABLE `order_partial_receive`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_timeline`
--
ALTER TABLE `order_timeline`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_blocked_by_foreign` FOREIGN KEY (`blocked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `conversations_user_one_id_foreign` FOREIGN KEY (`user_one_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_user_two_id_foreign` FOREIGN KEY (`user_two_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
