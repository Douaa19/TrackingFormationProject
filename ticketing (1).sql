-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jan 08, 2025 at 09:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticketing`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(70) DEFAULT NULL,
  `username` varchar(70) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `image` varchar(120) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT 'Active:1 Inactive:0',
  `best_agent` tinyint(4) NOT NULL COMMENT 'Yes:1 No:0  ',
  `categories` longtext DEFAULT NULL,
  `notification_settings` text DEFAULT NULL,
  `permissions` longtext DEFAULT NULL,
  `blocked_user` varchar(191) DEFAULT NULL,
  `muted_user` longtext DEFAULT NULL,
  `muted_ticket` longtext DEFAULT NULL,
  `super_agent` tinyint(4) DEFAULT NULL,
  `agent` tinyint(4) DEFAULT NULL COMMENT 'agent:1 admin:0',
  `super_admin` tinyint(4) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `phone`, `email`, `image`, `status`, `best_agent`, `categories`, `notification_settings`, `permissions`, `blocked_user`, `muted_user`, `muted_ticket`, `super_agent`, `agent`, `super_admin`, `address`, `latitude`, `longitude`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Carplug', 'Carplug', '+212640731248', 'dlarif+logicat@logicat.eu', '676e7fda544d11735294938.png', 1, 0, NULL, '{\"email\":{\"new_chat\":\"1\",\"new_ticket\":\"1\",\"agent_ticket_reply\":\"1\",\"agent_assign_ticket\":\"1\",\"user_reply_admin\":\"1\",\"user_reply_agent\":\"1\"},\"sms\":{\"new_chat\":\"1\",\"agent_ticket_reply\":\"1\",\"new_ticket\":\"1\",\"agent_assign_ticket\":\"1\",\"user_reply_agent\":\"1\",\"user_reply_admin\":\"1\"},\"browser\":{\"new_chat\":\"1\",\"agent_ticket_reply\":\"1\",\"new_ticket\":\"1\",\"agent_assign_ticket\":\"1\",\"user_reply_agent\":\"1\",\"user_reply_admin\":\"1\"},\"slack\":{\"new_chat\":\"0\",\"agent_ticket_reply\":\"0\",\"new_ticket\":\"0\",\"agent_assign_ticket\":\"0\",\"user_reply_agent\":\"0\",\"user_reply_admin\":\"0\"}}', NULL, NULL, NULL, NULL, NULL, 0, NULL, '{\"status\":\"fail\",\"message\":\"reserved range\",\"query\":\"::1\",\"browser_name\":\"Google Chrome\",\"device_name\":\"Windows\"}', NULL, NULL, '$2y$10$CEvXx9Wu82EG3ZgJv6Yh9u0j2PTamacRAdbdl9AVquW8Bl2JYUphi', 'jzOvTobO1qWg0YhctuVkPUyJEMKLVjFSV2rLKvxvjn59JpURdBjWG8ROSHTu', NULL, '2024-12-27 10:22:19'),
(29, 'Jaltest', 'Jaltest Agent', '+212657543434', 'dlarif+jaltest@logicat.eu', NULL, 1, 0, '[]', '{\"email\":{\"new_chat\":\"1\",\"new_ticket\":\"1\",\"agent_assign_ticket\":\"1\",\"admin_assign_ticket\":\"1\",\"user_reply_agent\":\"1\"},\"sms\":{\"new_chat\":\"1\",\"new_ticket\":\"1\",\"agent_assign_ticket\":\"1\",\"admin_assign_ticket\":\"1\",\"user_reply_agent\":\"1\"},\"browser\":{\"new_chat\":\"1\",\"new_ticket\":\"1\",\"agent_assign_ticket\":\"1\",\"admin_assign_ticket\":\"1\",\"user_reply_agent\":\"1\"}}', '[\"view_dashboard\",\"manage_category\",\"manage_users\",\"manage_tickets\",\"update_tickets\",\"delete_tickets\",\"chat_module\",\"manage_contact\",\"manage_priorites\",\"manage_ticket_status\"]', '[]', '[]', '[]', 0, 1, NULL, '{\"status\":\"fail\",\"message\":\"reserved range\",\"query\":\"::1\",\"browser_name\":\"Google Chrome\",\"device_name\":\"Windows\"}', NULL, NULL, '$2y$10$lwK978p6vy0wVKVBaqttAuPXSRk3xuzY0w4thYP4HEiWXB.L.hzES', NULL, '2024-12-19 16:09:46', '2025-01-02 11:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agent_responses`
--

CREATE TABLE `agent_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `response_time` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agent_responses`
--

INSERT INTO `agent_responses` (`id`, `agent_id`, `ticket_id`, `response_time`, `created_at`, `updated_at`) VALUES
(3, 29, 6, 0.03, '2024-12-19 16:34:41', '2024-12-19 16:34:41'),
(4, 29, 7, 0.03, '2024-12-19 16:47:06', '2024-12-19 16:47:06'),
(5, 29, 9, 0.14, '2024-12-20 08:22:22', '2024-12-20 08:22:22'),
(6, 29, 10, 0.02, '2024-12-20 08:54:18', '2024-12-20 08:54:18');

-- --------------------------------------------------------

--
-- Table structure for table `agent_tickets`
--

CREATE TABLE `agent_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` smallint(5) UNSIGNED DEFAULT NULL,
  `ticket_id` smallint(5) UNSIGNED DEFAULT NULL,
  `assigned_by` bigint(20) DEFAULT NULL,
  `short_notes` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agent_tickets`
--

INSERT INTO `agent_tickets` (`id`, `agent_id`, `ticket_id`, `assigned_by`, `short_notes`, `created_at`, `updated_at`) VALUES
(1, 25, 2, 1, 'This ticket is for you!', '2024-12-19 13:53:58', '2024-12-19 13:53:58'),
(4, 26, 3, 1, 'Ticket Assigned BY SuperAdmin', '2024-12-19 15:08:02', '2024-12-19 15:08:02');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `article_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `serial_id` tinyint(4) DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT 'active :1 inactive 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `article_categories`
--

CREATE TABLE `article_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `serial_id` tinyint(4) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `status` enum('1','0') NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canned_replies`
--

CREATE TABLE `canned_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `body` longtext DEFAULT NULL,
  `status` enum('1','0') NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `share_with` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` longtext DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `sort_details` varchar(191) DEFAULT NULL,
  `status` enum('1','0') NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `article_display_flag` tinyint(4) DEFAULT 0,
  `ticket_display_flag` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `sort_details`, `status`, `article_display_flag`, `ticket_display_flag`, `created_at`, `updated_at`) VALUES
(1, '{\"en\":\"First Category\",\"bd\":null}', NULL, 'First Category', '1', 0, 1, '2024-12-19 13:51:42', '2024-12-19 13:51:42'),
(2, '{\"en\":\"Seconde Category\",\"bd\":null,\"gf\":null}', NULL, 'Seconde Category', '1', 1, NULL, '2024-12-19 13:51:56', '2024-12-20 15:31:23');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `floating_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender` tinyint(4) DEFAULT NULL,
  `seen` tinyint(4) DEFAULT NULL,
  `seen_by_agent` tinyint(4) DEFAULT NULL,
  `deleted_by_user` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_by_admin` tinyint(4) NOT NULL DEFAULT 0,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `user_id`, `admin_id`, `floating_id`, `sender`, `seen`, `seen_by_agent`, `deleted_by_user`, `deleted_by_admin`, `message`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, 1, 0, 0, 0, 0, 'sss', '2024-04-04 04:37:24', '2024-04-04 04:37:24'),
(2, NULL, 1, 1, 1, 0, 0, 0, 0, 'sss', '2024-04-04 04:37:28', '2024-04-04 04:37:28'),
(3, NULL, 1, 1, 1, 0, 0, 0, 0, 'sss', '2024-04-04 04:37:38', '2024-04-04 04:37:38'),
(4, 6, 29, NULL, 1, 1, 1, 0, 0, 'Hello customer 1 how are you?', '2024-12-19 16:32:55', '2024-12-19 16:42:05'),
(5, 6, 29, NULL, 0, 1, 1, 0, 0, 'Hello Agent', '2024-12-19 16:42:30', '2024-12-20 14:22:52'),
(6, 6, 1, NULL, 1, 1, 1, 0, 0, 'Hello customer 1', '2024-12-20 13:19:02', '2024-12-20 13:44:09'),
(7, 6, 1, NULL, 1, 1, 1, 0, 0, 'qdsqdsdq', '2024-12-20 13:19:10', '2024-12-20 13:44:09'),
(8, 6, 1, NULL, 1, 1, 1, 0, 0, 'QDQSDEZAZ', '2024-12-20 13:19:15', '2024-12-20 13:44:09'),
(9, 6, 1, NULL, 1, 1, 1, 0, 0, 'rzersdxzedfd', '2024-12-20 13:41:51', '2024-12-20 13:44:09'),
(10, 6, 1, NULL, 1, 1, 1, 0, 0, 'fdfcrezrzrzerzrzer', '2024-12-20 13:43:08', '2024-12-20 13:44:38'),
(11, 6, 1, NULL, 0, 1, 1, 0, 0, 'jzlkjdjsqkjdoiz zuoizuud sudoizu z', '2024-12-20 13:44:18', '2024-12-20 13:57:42'),
(12, 6, 1, NULL, 1, 1, 1, 0, 0, 'qsdsdfsfdsfd', '2024-12-20 13:44:56', '2024-12-20 13:57:42'),
(13, 6, 1, NULL, 1, 1, 1, 0, 0, 'hkjhsqdhskhd', '2024-12-20 13:55:27', '2024-12-20 14:24:21'),
(14, 6, 1, NULL, 0, 0, 1, 0, 0, 'csskksjkdjskdfd', '2024-12-20 13:57:53', '2024-12-20 14:24:21'),
(15, 6, 29, NULL, 0, 0, 1, 0, 0, 'Hello Agent !!!', '2024-12-20 14:22:41', '2024-12-20 14:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_notifications`
--

CREATE TABLE `custom_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notify_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notify_by` bigint(20) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `is_read` tinyint(4) DEFAULT NULL COMMENT 'Yes:1 , no: 0',
  `notification_for` tinyint(4) DEFAULT NULL COMMENT 'Superadmin:1 , Agent: 2 ,User :3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_notifications`
--

INSERT INTO `custom_notifications` (`id`, `notify_id`, `notify_by`, `data`, `is_read`, `notification_for`, `created_at`, `updated_at`) VALUES
(3, 25, 1, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/B7B723\",\"messsage\":\"You Have a New Assigned Ticket BySuperadmin\"}', 1, 2, '2024-12-19 13:53:58', '2024-12-19 13:56:00'),
(5, 1, 25, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/B7B723\",\"messsage\":\"Hello Dear!!! Agent1  Just Replied To a Ticket\"}', 1, 3, '2024-12-19 14:04:39', '2024-12-19 14:04:58'),
(7, 25, 1, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/B7B723\",\"messsage\":\"Hello Dear!!! Douaa Just Replied To a Conversations\"}', 1, 2, '2024-12-19 14:05:53', '2024-12-19 14:06:28'),
(9, 1, 25, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/B7B723\",\"messsage\":\"Hello Dear!!! Agent1  Just Replied To a Ticket\"}', 0, 3, '2024-12-19 14:07:13', '2024-12-19 14:07:13'),
(10, 25, 1, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/7ECE3C\",\"messsage\":\"You Have a New Assigned Ticket BySuperadmin\"}', 1, 2, '2024-12-19 14:34:34', '2024-12-19 14:50:03'),
(11, 25, 1, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/7ECE3C\",\"messsage\":\"You Have a New Assigned Ticket BySuperadmin\"}', 1, 2, '2024-12-19 14:34:36', '2024-12-19 14:50:03'),
(13, 26, 1, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\",\"messsage\":\"You Have a New Assigned Ticket BySuperadmin\"}', 1, 2, '2024-12-19 15:08:02', '2024-12-19 15:08:14'),
(15, 2, 26, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/3A16B4\",\"messsage\":\"Hello Dear!!! Agridiag  Just Replied To a Ticket\"}', 0, 3, '2024-12-19 15:08:43', '2024-12-19 15:08:43'),
(17, 26, 1, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\",\"messsage\":\"Hello Dear!!! Mohammed Just Replied To a Conversations\"}', 0, 2, '2024-12-19 15:09:34', '2024-12-19 15:09:34'),
(19, 26, 1, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\",\"messsage\":\"Hello Dear!!! Mohammed Just Replied To a Conversations\"}', 0, 2, '2024-12-19 15:11:54', '2024-12-19 15:11:54'),
(21, 2, 26, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/3A16B4\",\"messsage\":\"Hello Dear!!! Agridiag  Just Replied To a Ticket\"}', 0, 3, '2024-12-19 15:13:23', '2024-12-19 15:13:23'),
(24, 27, 1, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/2D6F53\",\"messsage\":\"You Have a New Assigned Ticket ByLogicat\"}', 0, 2, '2024-12-19 16:22:22', '2024-12-19 16:22:22'),
(29, 6, 29, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/chat\\/list\",\"messsage\":\"You Have A New Message From Jaltest\"}', 1, 3, '2024-12-19 16:32:55', '2024-12-19 16:50:13'),
(32, 6, 29, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/A3BB86\",\"messsage\":\"Hello Dear!!! Jaltest  Just Replied To a Ticket\"}', 1, 3, '2024-12-19 16:34:42', '2024-12-19 16:50:13'),
(37, 6, 29, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/9E9D35\",\"messsage\":\"Hello Dear!!! Jaltest  Just Replied To a Ticket\"}', 1, 3, '2024-12-19 16:47:07', '2024-12-19 16:50:13'),
(42, 6, 29, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/9E9D35\",\"messsage\":\"Hello Dear!!! Jaltest  Just Replied To a Ticket\"}', 1, 3, '2024-12-19 16:49:38', '2024-12-19 16:50:13'),
(49, 6, 29, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket9\",\"messsage\":\"Hello Dear!!! Jaltest  Just Replied To a Ticket\"}', 1, 3, '2024-12-20 08:22:23', '2024-12-20 08:24:48'),
(53, 6, 29, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket9\",\"messsage\":\"Hello Dear!!! Jaltest  Just Replied To a Ticket\"}', 1, 3, '2024-12-20 08:29:04', '2024-12-20 08:29:23'),
(57, 6, 29, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket9\",\"messsage\":\"Hello Dear!!! Jaltest  Just Replied To a Ticket\"}', 1, 3, '2024-12-20 08:32:16', '2024-12-20 08:32:37'),
(61, 6, 29, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket9\",\"messsage\":\"Hello Dear!!! Jaltest  Just Replied To a Ticket\"}', 1, 3, '2024-12-20 08:36:23', '2024-12-20 08:36:34'),
(65, 8, 29, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket10\",\"messsage\":\"Hello Dear!!! Jaltest  Just Replied To a Ticket\"}', 1, 3, '2024-12-20 08:54:19', '2024-12-20 08:54:31'),
(67, 6, 1, '{\"route\":\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/chat\\/list\",\"messsage\":\"You Have A New Message From Logicat\"}', 1, 3, '2024-12-20 13:19:02', '2024-12-20 13:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `envato_item_id` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` longtext NOT NULL,
  `envato_payload` longtext NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0' COMMENT 'Active:1 ,Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `envato_item_id`, `image`, `name`, `slug`, `description`, `envato_payload`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'COMMERCIAL VEHICLES', 'commercial-vehicles', 'We help you solve problems quickly and reduce repair times, with many brands.', '', '1', '2024-12-19 14:45:59', '2024-12-19 14:45:59'),
(2, NULL, NULL, 'CONSTRUCTION EQUIPMENT', 'construction-equipment', 'We help you solve problems quickly and reduce repair times, with many brands.', '', '1', '2024-12-19 14:46:48', '2024-12-19 14:46:48'),
(3, NULL, NULL, 'MARINE', 'marine', 'We help you solve problems quickly and reduce repair times, with many brands.', '', '1', '2024-12-19 14:47:01', '2024-12-19 14:47:01'),
(4, NULL, NULL, 'AGRICULTURAL EQUIPEMENT', 'agricultural-equipement', 'We help you solve problems quickly and reduce repair times, with many brands.', '', '1', '2024-12-19 14:47:19', '2024-12-19 14:47:19'),
(5, NULL, NULL, 'MATERIAL HANDLING', 'material-handling', 'We help you solve problems quickly and reduce repair times, with many brands.', '', '1', '2024-12-19 14:47:33', '2024-12-19 14:47:33'),
(6, NULL, NULL, 'BUNDLE PACK', 'bundle-pack', 'We help you solve problems quickly and reduce repair times, with many brands.', '', '1', '2024-12-19 14:48:00', '2024-12-19 14:48:00'),
(7, NULL, NULL, 'HynesPro', 'hynespro', 'Car Diagnostic, Repair, Maintenance and Electrical data at your fingertips', '', '1', '2024-12-19 15:30:59', '2024-12-19 15:30:59'),
(8, NULL, NULL, 'Technical service bulletins', 'technical-service-bulletins', 'Find DTCs solutions in a few clicks. Our platform contains over 1.2 million bulletins and it’s regularly updated.', '', '1', '2024-12-19 15:31:43', '2024-12-19 15:31:43'),
(9, NULL, NULL, 'Online learning', 'online-learning', 'Thanks to our user-friendly navigation and advanced search tools, you can easily find the content that meets your specific needs. Whether you’re a mechanic, a workshop manager, or a student, our online learning  is here to support you throughout your learning journey.', '', '1', '2024-12-19 15:32:26', '2024-12-19 15:32:26'),
(10, NULL, NULL, 'Workshop Helpline', 'workshop-helpline', 'Workshop Helpline is an assistance service for car mechanics and repairers. It consists of helping you identify the breakdowns and its solutions, which saves you time & money and increases profitability.', '', '1', '2024-12-19 15:33:45', '2024-12-19 15:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `body` longtext DEFAULT NULL,
  `sms_body` longtext DEFAULT NULL,
  `codes` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Active : 1, Inactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `slug`, `subject`, `body`, `sms_body`, `codes`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Password Reset', 'PASSWORD_RESET', 'Password Reset', '<p><span style=\"font-size: 14px;\">We have received a request to reset the password for your account on </span><b>{{code}}</b><span style=\"font-size: 14px;\">. This request was initiated at </span><b>{{time}}</b><span style=\"font-size: 14px;\">.</span><br><br><span style=\"font-size: 14px;\">If you did not initiate this request or have any concerns about your account security, please contact our support team immediately.</span></p><p><br></p>', NULL, '{\"code\":\"Password Reset Code\", \"time\":\"Time\"}', 1, NULL, '2023-12-28 09:45:24'),
(2, 'Support Ticket ', 'SUPPORT_TICKET_REPLY', 'Support Ticket Reply', 'To respond to Ticket ID {{ticket_number}}, please click the link below:<p><br><a href=\"{{link}}\" target=\"_blank\">Reply to Ticket</a><br><br>Thank you for your prompt attention to this matter.<br></p>', 'Hello Dear ! To get a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket.  {{link}}', '{\"ticket_number\":\"Support Ticket Number\",\"link\":\"Ticket URL For relpy\"}', 1, NULL, '2023-12-28 10:11:50'),
(11, 'Admin Password Reset', 'ADMIN_PASSWORD_RESET', 'Admin Password Reset', '<p>We have received a request to reset the password for your account with the following details:<br><br>Account Code: {{code}}<br>Request Time: {{time}}</p><p><br>If you did not initiate this request or have any concerns about your account security, please contact our support team immediately.</p>', NULL, '{\"code\":\"Password Reset Code\", \"time\":\"Time\"}', 1, NULL, '2023-12-28 10:12:56'),
(12, 'Password Reset Confirm', 'PASSWORD_RESET_CONFIRM', 'Password Reset Confirm', '<p>We have received a request to reset the password for your account on {{code}} and Request time {{time}}</p>', NULL, '{\"time\":\"Time\"}', 1, NULL, '2022-05-30 04:48:02'),
(13, 'Registration Verify', 'REGISTRATION_VERIFY', 'Registration Verify', '<p>Hi, {{name}} We have received a request to create an account, you need to verify email first, your verification code is {{code}} and request time {{time}}</p>', NULL, '{\"name\":\"Name\", \"code\":\"Password Reset Code\", \"time\":\"Time\"}', 1, NULL, '2022-09-22 04:25:23'),
(14, 'Test Mail', 'TEST_MAIL', 'Mail Configuration Test', '<title>SMTP Mail Test Successful</title>\r\n    <style>\r\n        body {\r\n            font-family: Arial, sans-serif;\r\n            background-color: #f4f4f4;\r\n            margin: 0;\r\n            padding: 0;\r\n        }\r\n        .container {\r\n            max-width: 600px;\r\n            margin: 0 auto;\r\n            padding: 20px;\r\n            background-color: #ffffff;\r\n            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);\r\n        }\r\n        h1 {\r\n            color: #007BFF;\r\n            font-size: 24px;\r\n            margin-bottom: 20px;\r\n        }\r\n        p {\r\n            color: #333;\r\n            font-size: 16px;\r\n            line-height: 1.5;\r\n        }\r\n        .button {\r\n            display: inline-block;\r\n            padding: 10px 20px;\r\n            background-color: #007BFF;\r\n            color: #ffffff;\r\n            text-decoration: none;\r\n            font-weight: bold;\r\n            border-radius: 5px;\r\n            margin-top: 20px;\r\n        }\r\n    </style>\r\n\r\n\r\n    <div class=\"container\">\r\n        <h1>SMTP Mail Test Successful</h1>\r\n        <p>Your SMTP mail configuration has been successfully tested and is working correctly.</p>\r\n        <p>If you have any further questions or need assistance, please feel free to contact our support team.</p>\r\n        <a href=\"https://support.kodepixel.com\" class=\"button\" target=\"_blank\">Visit Our Website</a>\r\n    </div>', NULL, '{\"name\":\"Name\",\"time\":\"Time\"}', 1, NULL, '2023-12-28 10:15:22'),
(15, 'New Message From Agent To User', 'USER_CHAT', 'New Message', '<p>Hello Dear ! You Have New Message From {{name}}, To See Your Message Click This Link &nbsp;<a style=\"background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;\" href=\"{{link}}\">Link</a></p>', 'Hello Dear ! You Have New Message From {{name}}, To See Your Message Click This Link  {{link}}', '{\"name\":\"Agent Name\",\"link\":\"Chat Message Url For Replay\"}', 1, NULL, '2023-05-27 06:39:17'),
(16, 'Ticket Assign ', 'SUPPORT_TICKET_ASSIGN', 'Support Ticket Assign', '<p>Hello Dear! You Have A Newly Assign Ticket By ({{role}}) {{name}} To provide a response to Ticket ID {{ticket_number}},&nbsp;<br>kindly click the link provided below in order to reply to the ticket. <a style=\"background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;\" href=\"{{link}}\">Link</a></p>', 'Hello Dear! You Have A Newly Assign Ticket By {{role}} ({{name}} \nTo provide a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket.  {{link}}', '{\n\"role\": \"Admin Role\",\n\"name\": \"Admin Name\",\n\"ticket_number\":\"Support Ticket Number\",\"link\":\"Ticket URL For relpy\"\n\n}', 1, NULL, '2023-06-02 13:59:18'),
(17, 'Ticket Assign By Agent', 'SUPPORT_TICKET_ASSIGN_BY_AGENT', 'Support Ticket Assign To Agent', '<p>Hello Superadmin ! Agent {{name}} just Assign A ticket To Agent {{assigned_to}} , Ticket ID {{ticket_number}} Click Here To See The Ticket &nbsp;<a style=\"background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;\" href=\"{{link}}\">Link</a></p>', 'Hello Superadmin ! Agent {{name}} just Assign A ticket To Agent {{assigned_to}} , Ticket ID {{ticket_number}}  Click Here To See The Ticket {{link}}', '{\n\"name\": \"Agent Name\",\n\"ticket_number\":\"Support Ticket Number\",\"link\":\"Ticket URL For relpy\"\n}', 1, NULL, '2023-06-02 15:42:04'),
(18, 'Ticket Replay', 'TICKET_REPLY', 'Support Ticket Reply', '<p>Hello Dear! ({{role}}) {{name}}!! Just Replied To A Ticket..  To provide a response to Ticket ID {{ticket_number}},&nbsp;<br>kindly click the link provided below in order to reply to the ticket. <a style=\"background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;\" href=\"{{link}}\">Link</a></p>', 'Hello Dear! ({{role}}) {{name}}!! Just Replied To A Ticket.. \nTo provide a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket.  {{link}}', '{\r\n\"role\": \"Admin Role\",\r\n\"name\": \"Admin/Agent/User Name\",\r\n\"ticket_number\":\"Support Ticket Number\",\"link\":\"Ticket URL For relpy\"\r\n\r\n}', 1, NULL, '2023-06-02 13:59:18'),
(19, 'Contact Message', 'contact_reply', 'Contact Message reply', 'Hello Dear! {{email}}\r\n{{message}}', '', '{\r\n\r\n\"email\": \"Contact Email\",\r\n\"message\":\"Message\"\r\n\r\n}', 1, NULL, '2023-06-02 13:59:18'),
(20, 'Ticket Closed', 'SUPPORT_TICKET_AUTO_CLOSED', 'Ticket Closed', '<p>Your ticket is closed as we received no response from you  Ticket ID {{ticket_number}},&nbsp;<br>kindly click the link provided below in order to view the ticket. <a style=\"background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;\" href=\"{{link}}\">Link</a></p>', 'Your Ticket Closed', '{\"ticket_number\":\"Ticket Number\",\"link\":\"Ticket Link\"}', 1, '2024-01-08 11:46:03', '2024-01-08 11:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(100) DEFAULT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `question` varchar(191) DEFAULT NULL,
  `answer` longtext DEFAULT NULL,
  `status` enum('1','0') NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `floating_chats`
--

CREATE TABLE `floating_chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assign_to` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `is_closed` enum('1','0') NOT NULL COMMENT 'Yes:1 , No: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `floating_chats`
--

INSERT INTO `floating_chats` (`id`, `assign_to`, `email`, `is_closed`, `created_at`, `updated_at`) VALUES
(1, 1, 'demo@gmail.com', '0', '2023-11-23 16:09:21', '2024-04-04 04:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `value` longtext DEFAULT NULL,
  `status` enum('1','0') NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `name`, `slug`, `value`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Banner section', 'banner_section', '{\"static_element\":{\"title\":{\"type\":\"text\",\"value\":\"Elevating Your Experience\"},\"description\":{\"type\":\"textarea\",\"value\":\"Welcome to Pixel Desk, your dedicated platform for efficient issue resolution and support. At Pixel Desk, we understand that every challenge is unique, and that\'s why we\'re here to tailor solutions to your specific needs. Tell us what you need help with\"},\"banner_image\":{\"type\":\"file\",\"size\":\"520x480\",\"value\":\"655daf2d996ee1700638509.png\"}}}', '1', NULL, '2023-11-30 13:37:11'),
(2, 'Explore section', 'explore_section', '{\"static_element\":{\"title\":{\"type\":\"text\",\"value\":\"Effortlessly Scale and Personalize Customer Service\"},\"sub_title\":{\"type\":\"text\",\"value\":\"Streamline Support Operations\"},\"description\":{\"type\":\"textarea\",\"value\":\"Maximize support efficiency, minimize costs, and deliver outstanding experiences. Our innovative solution empowers you to scale your customer service operations seamlessly while keeping expenses in check. Premium customers enjoy the added advantage of dedicated live chat support with knowledgeable agents for prompt assistance, ensuring their satisfaction.\"},\"btn_text\":{\"type\":\"text\",\"value\":\"Submit Ticket\"},\"btn_url\":{\"type\":\"url\",\"value\":\"https:\\/\\/pixeldesk.kodepixel.com\\/\"},\"banner_image\":{\"type\":\"file\",\"size\":\"480x290\",\"value\":\"655db004d93b91700638724.png\"}}}', '1', NULL, '2023-11-30 13:24:34'),
(3, 'Support section', 'support_section', '{\"static_element\":{\"title\":{\"type\":\"text\",\"value\":\"Browse All Topics\"},\"sub_title\":{\"type\":\"text\",\"value\":\"CHOOSE YOUR SUPPORT\"}}}', '1', NULL, '2023-06-05 11:38:01'),
(4, 'Faq section', 'faq_section', '{\"static_element\":{\"title\":{\"type\":\"text\",\"value\":\"Find answers to common questions about Pixel Desk\"},\"sub_title\":{\"type\":\"text\",\"value\":\"Frequently Asked Questions\"}}}', '1', NULL, '2023-11-30 13:38:50'),
(5, 'CTA Section', 'cta_section', '{\"static_element\":{\"title\":{\"type\":\"text\",\"value\":\"Unlock Exceptional Support from Our Expert Agents\"},\"description\":{\"type\":\"textarea\",\"value\":\"Welcome to Pixel Desk, where our support ticket software transforms issue resolution into a seamless experience. Effortlessly create tickets, capturing the essence of your concerns\\u2014be it technical glitches, electronics queries, or management challenges. Customizable categories empower administrators to tailor the support experience, ensuring targeted responses. Our dynamic ticket management features streamline workflow, reducing resolution times and enhancing user satisfaction.\"}}}', '1', NULL, '2023-11-30 13:41:23'),
(6, 'Contact Section', 'contact_section', '{\"static_element\":{\"title\":{\"type\":\"text\",\"value\":\"STAY CONNECTED\"},\"sub_title\":{\"type\":\"text\",\"value\":\"Unlock Exceptional Support from Our Expert Agents\"}}}', '1', NULL, '2023-09-04 08:29:09'),
(7, 'Footer section', 'footer_section', '{\"static_element\":{\"text\":{\"type\":\"textarea\",\"value\":\"Experience efficient support management with Pixel Desk, the comprehensive ticketing software designed to streamline your customer service operations. Our platform empowers your team to resolve issues promptly, track ticket progress, and deliver exceptional support experiences.\"}}}', '1', NULL, '2023-11-30 13:42:36'),
(8, 'Social section', 'social_section', '{\"static_element\":{\"facebook\":{\"icon\":\"<i class=\\\"bi bi-facebook\\\"><\\/i>\",\"url\":\"#\",\"type\":\"text\"},\"google\":{\"icon\":\"<i class=\\\"bi bi-google\\\"><\\/i>\",\"url\":\"#\",\"type\":\"text\"},\"linked_in\":{\"icon\":\"<i class=\\\"bi bi-linkedin\\\"><\\/i>\",\"url\":\"#\",\"type\":\"text\"},\"twitter\":{\"icon\":\"<i class=\\\"bi bi-twitter\\\"><\\/i>\",\"url\":\"#\",\"type\":\"text\"},\"instagram\":{\"icon\":\"<i class=\\\"bi bi-instagram\\\"><\\/i>\",\"url\":\"#\",\"type\":\"text\"}}}', '1', NULL, '2023-08-26 07:01:25'),
(9, 'Newsletter section', 'newsletter_section', '{\"static_element\":{\"title\":{\"type\":\"text\",\"value\":\"Sign Up For The Newsletter\"},\"description\":{\"type\":\"textarea\",\"value\":\"Be the First to Know: Stay Updated with Exclusive Offers, News, and Insights!\"}}}', '1', NULL, '2023-07-10 11:39:26'),
(10, 'Auth Section', 'authentication_section', '{\"static_element\":{\"banner_image\":{\"type\":\"file\",\"size\":\"700x1200\",\"value\":\"655db2b7550ba1700639415.png\"}}}', '1', NULL, '2023-11-22 07:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `leader_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `priority_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('1','0') NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"c234fece-40f7-48af-bddb-a43281746fe2\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"7ECE3C\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/7ECE3C\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734616346, 1734616346),
(2, 'default', '{\"uuid\":\"ef0ec230-3ec4-46b8-b1a2-f8f1320b7e37\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"7ECE3C\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/7ECE3C\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734616346, 1734616346),
(3, 'default', '{\"uuid\":\"65945fd1-3e27-4bbe-9d59-ce4a2e1bde83\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:24:\\\"App\\\\Models\\\\SupportTicket\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"7ECE3C\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/tickets\\/7ECE3C\\/reply\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734616346, 1734616346),
(4, 'default', '{\"uuid\":\"5f15e899-667c-4d76-83a7-253037e2e6f4\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"B7B723\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/B7B723\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734616348, 1734616348),
(5, 'default', '{\"uuid\":\"26b999a2-957b-4155-8c08-94e1a4a8678f\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"B7B723\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/B7B723\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734616348, 1734616348),
(6, 'default', '{\"uuid\":\"26e4bb51-cd76-4eec-aa5b-7836a0258348\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:24:\\\"App\\\\Models\\\\SupportTicket\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"B7B723\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/tickets\\/B7B723\\/reply\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734616348, 1734616348),
(7, 'default', '{\"uuid\":\"05340fbc-b667-4509-9148-d89145490ee5\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:6:\\\"Agent1\\\";s:13:\\\"ticket_number\\\";s:6:\\\"B7B723\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/B7B723\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734617079, 1734617079),
(8, 'default', '{\"uuid\":\"ee613a66-cb08-4a02-8e06-21da175d0446\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:6:\\\"Agent1\\\";s:13:\\\"ticket_number\\\";s:6:\\\"B7B723\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/B7B723\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734617079, 1734617079),
(9, 'default', '{\"uuid\":\"4be3364f-29ad-4d3b-a24d-177a264c70a2\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:5:\\\"Douaa\\\";s:13:\\\"ticket_number\\\";s:6:\\\"B7B723\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/B7B723\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734617153, 1734617153),
(10, 'default', '{\"uuid\":\"90f0a294-77eb-42ba-8c12-1202e4da6a7a\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:5:\\\"Douaa\\\";s:13:\\\"ticket_number\\\";s:6:\\\"B7B723\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/B7B723\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734617153, 1734617153),
(11, 'default', '{\"uuid\":\"bf67f252-13fb-4570-8bc0-ea20b697e766\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:6:\\\"Agent1\\\";s:13:\\\"ticket_number\\\";s:6:\\\"B7B723\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/B7B723\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734617233, 1734617233),
(12, 'default', '{\"uuid\":\"dbfe15e4-9017-4526-87e2-23258d5d9bf2\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:6:\\\"Agent1\\\";s:13:\\\"ticket_number\\\";s:6:\\\"B7B723\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/B7B723\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734617233, 1734617233),
(13, 'default', '{\"uuid\":\"2e5a5e37-77a1-474c-b12d-75df8e18733d\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"3A16B4\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734620793, 1734620793),
(14, 'default', '{\"uuid\":\"0ff767f7-3f6a-4876-8311-05f7d56583ca\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"3A16B4\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734620793, 1734620793),
(15, 'default', '{\"uuid\":\"eff9c2ce-e878-4a07-81c5-0ca9bd3f772a\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:24:\\\"App\\\\Models\\\\SupportTicket\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"3A16B4\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/tickets\\/3A16B4\\/reply\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734620793, 1734620793),
(16, 'default', '{\"uuid\":\"85fd513f-8df0-4d4b-9bbc-629518cf5d57\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:8:\\\"Agridiag\\\";s:13:\\\"ticket_number\\\";s:6:\\\"3A16B4\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734620923, 1734620923),
(17, 'default', '{\"uuid\":\"f49cec81-8d06-4fd7-85c0-50444cadb9ac\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:8:\\\"Agridiag\\\";s:13:\\\"ticket_number\\\";s:6:\\\"3A16B4\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734620923, 1734620923),
(18, 'default', '{\"uuid\":\"431e7af3-6469-4f1c-ae23-80a7e5966128\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:8:\\\"Mohammed\\\";s:13:\\\"ticket_number\\\";s:6:\\\"3A16B4\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734620974, 1734620974),
(19, 'default', '{\"uuid\":\"ea7cfac8-0dbc-438f-bb98-674a4fb80e71\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:8:\\\"Mohammed\\\";s:13:\\\"ticket_number\\\";s:6:\\\"3A16B4\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734620974, 1734620974),
(20, 'default', '{\"uuid\":\"05816225-77e2-445b-8c34-24f9bbda8393\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:8:\\\"Mohammed\\\";s:13:\\\"ticket_number\\\";s:6:\\\"3A16B4\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734621114, 1734621114),
(21, 'default', '{\"uuid\":\"132d872e-c77d-4d17-aa9f-8bfe24a8e960\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:8:\\\"Mohammed\\\";s:13:\\\"ticket_number\\\";s:6:\\\"3A16B4\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734621114, 1734621114),
(22, 'default', '{\"uuid\":\"8a9bec25-9db9-4d36-bd1e-c56d0f7001dd\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:8:\\\"Agridiag\\\";s:13:\\\"ticket_number\\\";s:6:\\\"3A16B4\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734621203, 1734621203),
(23, 'default', '{\"uuid\":\"b68c9c58-f554-4109-95bf-a1c9088075e7\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:8:\\\"Agridiag\\\";s:13:\\\"ticket_number\\\";s:6:\\\"3A16B4\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/3A16B4\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734621203, 1734621203),
(24, 'default', '{\"uuid\":\"5e911b88-9d02-400d-950d-c5281ae5006c\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"2D6F53\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/2D6F53\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734624991, 1734624991),
(25, 'default', '{\"uuid\":\"345a5220-44ec-4a92-8267-601f8c987498\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"2D6F53\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/2D6F53\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734624991, 1734624991),
(26, 'default', '{\"uuid\":\"f222bcf7-2432-4060-bb9a-8f37e997513d\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:24:\\\"App\\\\Models\\\\SupportTicket\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"2D6F53\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/tickets\\/2D6F53\\/reply\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734624991, 1734624991),
(27, 'default', '{\"uuid\":\"629a350c-7120-4b45-ac41-f860141a9d68\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:1:{i:0;s:7:\\\"tickets\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:21:\\\"SUPPORT_TICKET_ASSIGN\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:10:\\\"SuperAdmin\\\";s:4:\\\"name\\\";s:7:\\\"Logicat\\\";s:13:\\\"ticket_number\\\";s:6:\\\"2D6F53\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/2D6F53\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734625352, 1734625352),
(28, 'default', '{\"uuid\":\"64c4316a-3080-4441-9d84-f08d3325f796\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"752153\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/752153\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734625613, 1734625613),
(29, 'default', '{\"uuid\":\"18ed7e5d-fccf-4c2f-a1da-20b4fbc366e0\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"752153\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/752153\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734625613, 1734625613),
(30, 'default', '{\"uuid\":\"ea337fbf-cd3c-447e-bbbf-f07cf4449ee8\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:24:\\\"App\\\\Models\\\\SupportTicket\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"752153\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/tickets\\/752153\\/reply\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734625613, 1734625613),
(31, 'default', '{\"uuid\":\"23081e62-fa8c-4780-89e3-5e67c6e493b0\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:6:\\\"752153\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/752153\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734625801, 1734625801),
(32, 'default', '{\"uuid\":\"6a8c2aab-5bd1-4a96-ba36-caf89206e4c1\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:6:\\\"752153\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/752153\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734625801, 1734625801),
(33, 'default', '{\"uuid\":\"4f814c28-631d-46fe-a067-97dc56a9f5b9\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"A3BB86\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/A3BB86\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734625899, 1734625899),
(34, 'default', '{\"uuid\":\"a44d672a-ad23-4641-8ba9-c25e1d5d7603\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"A3BB86\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/A3BB86\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734625899, 1734625899),
(35, 'default', '{\"uuid\":\"e4550fa2-a471-4c6f-a3d3-abbbbd29feed\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:24:\\\"App\\\\Models\\\\SupportTicket\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"A3BB86\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/tickets\\/A3BB86\\/reply\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734625899, 1734625899),
(36, 'default', '{\"uuid\":\"7270ef76-9751-4908-b242-6407c462732a\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:9:\\\"USER_CHAT\\\";s:4:\\\"code\\\";a:2:{s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:4:\\\"link\\\";s:60:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/chat\\/list\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734625975, 1734625975),
(37, 'default', '{\"uuid\":\"2a9fd7b8-cc1a-4572-93ac-4d2e6a455f1f\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:1:{i:0;s:7:\\\"tickets\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:21:\\\"SUPPORT_TICKET_ASSIGN\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:10:\\\"SuperAdmin\\\";s:4:\\\"name\\\";s:7:\\\"Logicat\\\";s:13:\\\"ticket_number\\\";s:6:\\\"A3BB86\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/A3BB86\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626038, 1734626038),
(38, 'default', '{\"uuid\":\"92ba46be-1871-4eef-8163-c43a41714261\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:6:\\\"A3BB86\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/A3BB86\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626082, 1734626082),
(39, 'default', '{\"uuid\":\"b40b9182-44c1-4947-9a01-7bd68e928626\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:6:\\\"A3BB86\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/A3BB86\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626082, 1734626082),
(40, 'default', '{\"uuid\":\"de2d503d-a327-4b2e-b3e7-affcf839f18c\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:6:\\\"A3BB86\\\";s:4:\\\"link\\\";s:65:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/A3BB86\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626082, 1734626082),
(41, 'default', '{\"uuid\":\"60b0b318-0bee-4ce4-a886-6e768abb3fcf\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:9:\\\"USER_CHAT\\\";s:4:\\\"code\\\";a:2:{s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:4:\\\"link\\\";s:61:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/chat\\/list\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626551, 1734626551);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(42, 'default', '{\"uuid\":\"085a4489-01f4-4b8f-bfc4-bc19f2577adf\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/9E9D35\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626652, 1734626652),
(43, 'default', '{\"uuid\":\"535e2d93-a17a-4b3e-b157-d177f9bd19a6\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/9E9D35\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626652, 1734626652),
(44, 'default', '{\"uuid\":\"11abdaba-c9bc-4722-a2ac-41ff1b01b710\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:24:\\\"App\\\\Models\\\\SupportTicket\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/tickets\\/9E9D35\\/reply\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626652, 1734626652),
(45, 'default', '{\"uuid\":\"d648c9ae-8de4-4050-a1d5-da0d15568591\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:1:{i:0;s:7:\\\"tickets\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:21:\\\"SUPPORT_TICKET_ASSIGN\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:10:\\\"SuperAdmin\\\";s:4:\\\"name\\\";s:7:\\\"Logicat\\\";s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/9E9D35\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626714, 1734626714),
(46, 'default', '{\"uuid\":\"9979f09d-f743-4212-89f0-32996c1f5a18\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/9E9D35\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626827, 1734626827),
(47, 'default', '{\"uuid\":\"d261141c-f807-4de2-8ea8-7b2acfc64504\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/9E9D35\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626827, 1734626827),
(48, 'default', '{\"uuid\":\"99887efc-693a-4263-b18d-14ad7f5836e4\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:65:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/9E9D35\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626827, 1734626827),
(49, 'default', '{\"uuid\":\"42029fd5-3d02-4179-b823-d0bd3ae591ec\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/9E9D35\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626914, 1734626914),
(50, 'default', '{\"uuid\":\"3299fda1-905d-43cf-a184-b796dd3c254d\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/9E9D35\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626914, 1734626914),
(51, 'default', '{\"uuid\":\"107e8b52-6677-45ae-b377-c75e05f75df3\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/9E9D35\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626915, 1734626915),
(52, 'default', '{\"uuid\":\"94e4c538-3cd5-47c1-ba13-ce2c3f6fa1b9\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/9E9D35\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626978, 1734626978),
(53, 'default', '{\"uuid\":\"774cb142-593a-42af-9cd4-b09437174ab2\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/9E9D35\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626978, 1734626978),
(54, 'default', '{\"uuid\":\"e1fc4d1c-b50c-4d2e-949e-9e057f7de878\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:6:\\\"9E9D35\\\";s:4:\\\"link\\\";s:65:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/9E9D35\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734626978, 1734626978),
(55, 'default', '{\"uuid\":\"fce2850c-7952-4629-a283-cb2c5c24eea5\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"C946F2\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/C946F2\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734627470, 1734627470),
(56, 'default', '{\"uuid\":\"dd5aff23-6a6e-4e74-9055-268446bdc48d\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"C946F2\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/C946F2\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734627470, 1734627470),
(57, 'default', '{\"uuid\":\"d4905d51-dd57-45a8-b2e5-08db7a889194\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:24:\\\"App\\\\Models\\\\SupportTicket\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:6:\\\"C946F2\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/tickets\\/C946F2\\/reply\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734627470, 1734627470),
(58, 'default', '{\"uuid\":\"7bf33cc5-4f68-4f61-8ca0-abc5e146643d\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:4:{i:0;s:7:\\\"tickets\\\";i:1;s:20:\\\"tickets.ticketStatus\\\";i:2;s:33:\\\"tickets.ticketStatus.translations\\\";i:3;s:18:\\\"tickets.department\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:21:\\\"SUPPORT_TICKET_ASSIGN\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:10:\\\"SuperAdmin\\\";s:4:\\\"name\\\";s:7:\\\"Logicat\\\";s:13:\\\"ticket_number\\\";s:6:\\\"C946F2\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/C946F2\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734627577, 1734627577),
(59, 'default', '{\"uuid\":\"7ea84674-9f1e-435b-8c93-6bf0ade11f57\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:4:{i:0;s:7:\\\"tickets\\\";i:1;s:20:\\\"tickets.ticketStatus\\\";i:2;s:33:\\\"tickets.ticketStatus.translations\\\";i:3;s:18:\\\"tickets.department\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:21:\\\"SUPPORT_TICKET_ASSIGN\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:10:\\\"SuperAdmin\\\";s:4:\\\"name\\\";s:7:\\\"Logicat\\\";s:13:\\\"ticket_number\\\";s:6:\\\"C946F2\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/C946F2\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734627712, 1734627712),
(60, 'default', '{\"uuid\":\"315912e5-a8d9-4454-9b15-52af528594db\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734682127, 1734682127),
(61, 'default', '{\"uuid\":\"63589d73-e494-40a4-970f-89eff786483a\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734682127, 1734682127),
(62, 'default', '{\"uuid\":\"022fa64a-b4f8-4523-83e7-202d49d3b8b1\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:24:\\\"App\\\\Models\\\\SupportTicket\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/tickets\\/Ticket9\\/reply\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734682127, 1734682127),
(63, 'default', '{\"uuid\":\"a802299f-9f66-410f-a80f-1ae7464e7dd3\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:4:{i:0;s:7:\\\"tickets\\\";i:1;s:20:\\\"tickets.ticketStatus\\\";i:2;s:33:\\\"tickets.ticketStatus.translations\\\";i:3;s:18:\\\"tickets.department\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:21:\\\"SUPPORT_TICKET_ASSIGN\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:10:\\\"SuperAdmin\\\";s:4:\\\"name\\\";s:7:\\\"Logicat\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734682557, 1734682557),
(64, 'default', '{\"uuid\":\"f415c161-94dd-4133-837a-005d48e1e40c\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734682943, 1734682943),
(65, 'default', '{\"uuid\":\"d2c6bcd4-7c1d-49cb-aaf2-e1a6b41cc6d8\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734682943, 1734682943),
(66, 'default', '{\"uuid\":\"081734e2-af29-4788-95fb-21155866587d\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734682944, 1734682944),
(67, 'default', '{\"uuid\":\"b3074532-89da-4c40-8c4d-b6b0ad135eec\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734682944, 1734682944),
(68, 'default', '{\"uuid\":\"dbe0516c-9d2b-4fef-83c4-4a11d17a601a\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683156, 1734683156),
(69, 'default', '{\"uuid\":\"0bcc38c9-42cd-4d59-bfce-db2d589e3ac5\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683156, 1734683156),
(70, 'default', '{\"uuid\":\"fb558ad5-4c3b-4ce2-a6fd-c4acf3a40e55\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683156, 1734683156),
(71, 'default', '{\"uuid\":\"64572cef-e592-4117-976b-3a349ea8d822\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683344, 1734683344),
(72, 'default', '{\"uuid\":\"5d246010-45a7-486d-8df1-b7ed83497fe1\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683344, 1734683344),
(73, 'default', '{\"uuid\":\"dcf99501-c624-409f-8cde-ad9057e9c2d0\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683345, 1734683345),
(74, 'default', '{\"uuid\":\"2fc86c17-28de-4403-940b-6008ca193b51\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683345, 1734683345),
(75, 'default', '{\"uuid\":\"8fbafa9c-a16c-4483-9a2d-ccaae5b93423\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683390, 1734683390),
(76, 'default', '{\"uuid\":\"ab5636c5-5f97-4c94-923f-bf00c3d2ecd4\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683390, 1734683390),
(77, 'default', '{\"uuid\":\"e9417c51-2491-4119-907e-64f41b23eacf\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683390, 1734683390),
(78, 'default', '{\"uuid\":\"371effff-fda5-440b-bdab-118d36755314\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683536, 1734683536),
(79, 'default', '{\"uuid\":\"1a68f7dc-8451-4b9a-b7a3-4554015ed438\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683536, 1734683536),
(80, 'default', '{\"uuid\":\"4a1ab546-6f5e-4967-b2de-01cbaa06953f\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683537, 1734683537),
(81, 'default', '{\"uuid\":\"1e4e90d6-ab6b-4492-8f88-500aea573c93\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683537, 1734683537);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(82, 'default', '{\"uuid\":\"0120ef14-5180-426b-90b8-013025d8e6b7\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683695, 1734683695),
(83, 'default', '{\"uuid\":\"800fc7bb-6a5e-40ec-b459-4ea004d1d019\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683695, 1734683695),
(84, 'default', '{\"uuid\":\"a3ecef42-78bb-4730-ae23-e072f727fe17\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:4:\\\"User\\\";s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683696, 1734683696),
(85, 'default', '{\"uuid\":\"bce378cb-0744-4997-ad9b-b710178cc300\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683783, 1734683783),
(86, 'default', '{\"uuid\":\"527e0c51-42d6-4c12-97a4-d7ccbb78f711\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683783, 1734683783),
(87, 'default', '{\"uuid\":\"37bf0fcf-dc2f-4c6c-998d-484f3af363f0\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683784, 1734683784),
(88, 'default', '{\"uuid\":\"568e5f87-2545-43aa-bd0b-c27568ec8791\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:7:\\\"Ticket9\\\";s:4:\\\"link\\\";s:66:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket9\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734683784, 1734683784),
(89, 'default', '{\"uuid\":\"a50326f0-9b98-4ea1-a9ee-30029b8857db\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:8:\\\"Ticket10\\\";s:4:\\\"link\\\";s:68:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket10\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734684743, 1734684743),
(90, 'default', '{\"uuid\":\"bcfad7b0-7403-447a-a391-f80f4461bdc7\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:8:\\\"Ticket10\\\";s:4:\\\"link\\\";s:68:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket10\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734684743, 1734684743),
(91, 'default', '{\"uuid\":\"aabef50c-a644-4d39-9bb0-59c7e8819fb4\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:24:\\\"App\\\\Models\\\\SupportTicket\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:8:\\\"Ticket10\\\";s:4:\\\"link\\\";s:68:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/tickets\\/Ticket10\\/reply\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734684743, 1734684743),
(92, 'default', '{\"uuid\":\"473d6892-dc35-4a0d-8844-444ed7a3ce90\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:4:{i:0;s:7:\\\"tickets\\\";i:1;s:20:\\\"tickets.ticketStatus\\\";i:2;s:33:\\\"tickets.ticketStatus.translations\\\";i:3;s:18:\\\"tickets.department\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:21:\\\"SUPPORT_TICKET_ASSIGN\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:10:\\\"SuperAdmin\\\";s:4:\\\"name\\\";s:7:\\\"Logicat\\\";s:13:\\\"ticket_number\\\";s:8:\\\"Ticket10\\\";s:4:\\\"link\\\";s:68:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket10\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734684818, 1734684818),
(93, 'default', '{\"uuid\":\"869c5d2e-e701-4e6c-9f85-33275df08adc\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:8:\\\"Ticket10\\\";s:4:\\\"link\\\";s:68:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket10\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734684859, 1734684859),
(94, 'default', '{\"uuid\":\"e6d16dc4-192f-476a-a596-3bc799306d7c\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:8:\\\"Ticket10\\\";s:4:\\\"link\\\";s:68:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket10\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734684859, 1734684859),
(95, 'default', '{\"uuid\":\"18d3187f-0d3b-4c79-aa9f-61dcc305a03b\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:8:\\\"Ticket10\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket10\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734684860, 1734684860),
(96, 'default', '{\"uuid\":\"7035c76e-ab85-4a25-afeb-5e8c967720af\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:12:\\\"TICKET_REPLY\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:5:\\\"Agent\\\";s:4:\\\"name\\\";s:7:\\\"Jaltest\\\";s:13:\\\"ticket_number\\\";s:8:\\\"Ticket10\\\";s:4:\\\"link\\\";s:67:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/tickets\\/Ticket10\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734684860, 1734684860),
(97, 'default', '{\"uuid\":\"5efb7726-48ef-4c27-ab2d-4b9965ab5d99\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:4:{i:0;s:7:\\\"tickets\\\";i:1;s:20:\\\"tickets.ticketStatus\\\";i:2;s:33:\\\"tickets.ticketStatus.translations\\\";i:3;s:18:\\\"tickets.department\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:21:\\\"SUPPORT_TICKET_ASSIGN\\\";s:4:\\\"code\\\";a:4:{s:4:\\\"role\\\";s:10:\\\"SuperAdmin\\\";s:4:\\\"name\\\";s:7:\\\"Logicat\\\";s:13:\\\"ticket_number\\\";s:8:\\\"Ticket10\\\";s:4:\\\"link\\\";s:68:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket10\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734685059, 1734685059),
(98, 'default', '{\"uuid\":\"29fcb6f6-6907-43e4-bacc-dc68260c41aa\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:9:\\\"USER_CHAT\\\";s:4:\\\"code\\\";a:2:{s:4:\\\"name\\\";s:7:\\\"Logicat\\\";s:4:\\\"link\\\";s:60:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/chat\\/list\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734700742, 1734700742),
(99, 'default', '{\"uuid\":\"22ac6757-b4a3-4401-8a19-1d2ca14d9621\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:9:\\\"USER_CHAT\\\";s:4:\\\"code\\\";a:2:{s:4:\\\"name\\\";s:7:\\\"Logicat\\\";s:4:\\\"link\\\";s:60:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/user\\/chat\\/list\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734700742, 1734700742),
(100, 'default', '{\"uuid\":\"81021e55-da13-44a4-b5f8-88ecdda83719\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:9:\\\"USER_CHAT\\\";s:4:\\\"code\\\";a:2:{s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:4:\\\"link\\\";s:61:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/chat\\/list\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734702259, 1734702259),
(101, 'default', '{\"uuid\":\"49d6dbf1-02d2-4921-bf86-2cc9857bfe26\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:9:\\\"USER_CHAT\\\";s:4:\\\"code\\\";a:2:{s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:4:\\\"link\\\";s:61:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/chat\\/list\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734702259, 1734702259),
(102, 'default', '{\"uuid\":\"ae335035-118b-41cf-b37d-7faba642d4f1\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:9:\\\"USER_CHAT\\\";s:4:\\\"code\\\";a:2:{s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:4:\\\"link\\\";s:61:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/chat\\/list\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734703074, 1734703074),
(103, 'default', '{\"uuid\":\"6128aff5-7ea1-4d2f-9617-d0055f8dc94d\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:9:\\\"USER_CHAT\\\";s:4:\\\"code\\\";a:2:{s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:4:\\\"link\\\";s:61:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/chat\\/list\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734703074, 1734703074),
(104, 'default', '{\"uuid\":\"982ff128-6355-4cc6-847a-874072b81b13\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:9:\\\"USER_CHAT\\\";s:4:\\\"code\\\";a:2:{s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:4:\\\"link\\\";s:61:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/chat\\/list\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734704561, 1734704561),
(105, 'default', '{\"uuid\":\"e4cfc0eb-e86c-451b-9cd2-f4fb20860b3c\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:9:\\\"USER_CHAT\\\";s:4:\\\"code\\\";a:2:{s:4:\\\"name\\\";s:10:\\\"Customer 1\\\";s:4:\\\"link\\\";s:61:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/chat\\/list\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734704561, 1734704561),
(106, 'default', '{\"uuid\":\"3853cee9-35dc-47cb-ae2d-efdb31d0755c\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:8:\\\"Ticket11\\\";s:4:\\\"link\\\";s:68:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket11\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734709565, 1734709565),
(107, 'default', '{\"uuid\":\"92b974ac-23ec-49d6-a657-bbc9025f7200\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Admin\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:8:\\\"Ticket11\\\";s:4:\\\"link\\\";s:68:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/admin\\/tickets\\/Ticket11\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734709565, 1734709565),
(108, 'default', '{\"uuid\":\"3a169b3b-13be-4b6b-b2ae-139a892ec592\",\"displayName\":\"App\\\\Jobs\\\\SendEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmailJob\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\SendEmailJob\\\":13:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:24:\\\"App\\\\Models\\\\SupportTicket\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:8:\\\"template\\\";s:20:\\\"SUPPORT_TICKET_REPLY\\\";s:4:\\\"code\\\";a:2:{s:13:\\\"ticket_number\\\";s:8:\\\"Ticket11\\\";s:4:\\\"link\\\";s:68:\\\"http:\\/\\/localhost\\/pixeldesk-new-installer-v2.1\\/tickets\\/Ticket11\\/reply\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1734709565, 1734709565);

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_bases`
--

CREATE TABLE `knowledge_bases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `icon` varchar(191) NOT NULL,
  `description` longtext DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0' COMMENT 'Active:1 ,Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  `is_default` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'default : 1,Not default : 0',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Active : 1,Inactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `uid`, `created_by`, `updated_by`, `name`, `code`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ASWTG454DGGD', 1, NULL, 'English', 'en', '0', '1', '2023-03-14 14:09:00', '2024-12-27 15:41:33'),
(16, '30nO-p9MnDgW8-nnf8', NULL, NULL, 'Bangladesh', 'bd', '0', '1', '2023-11-22 17:25:54', '2024-12-27 15:41:33'),
(17, 'Vo1d-Ji8LHaP4-nRa9', NULL, NULL, 'French Guiana', 'gf', '0', '1', '2024-12-19 15:14:32', '2024-12-27 15:41:33'),
(18, '8Ytt-xIpOBlyZ-qKj0', NULL, NULL, 'France', 'fr', '1', '1', '2024-12-20 15:57:23', '2024-12-27 15:41:33');

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE `mails` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Active : 1 Inactive : 2',
  `driver_information` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mails`
--

INSERT INTO `mails` (`id`, `name`, `status`, `driver_information`, `created_at`, `updated_at`) VALUES
(1, 'SMTP', 1, '{\"driver\":\"SMTP\",\"host\":\"smtp.gmail.com\",\"port\":\"587\",\"from\":{\"address\":\"dlarif@logicat.eu\",\"name\":\"Logicat\"},\"encryption\":\"TLS\",\"username\":\"dlarif@logicat.eu\",\"password\":\"mkfp adgg hkfm jstf\"}', '2022-09-09 14:52:30', '2024-12-20 08:39:28'),
(2, 'PHP MAIL', 1, NULL, '2022-09-08 18:00:00', '2022-07-20 04:41:46'),
(3, 'SendGrid Api', 1, '{\"app_key\":\"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\",\"from\":{\"address\":\"debnath.bappe@gmail.com\",\"name\":\"Demo Name\"}}', '2022-09-08 18:00:00', '2023-05-22 06:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `serial_id` int(11) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `url` text NOT NULL,
  `status` enum('1','0') NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `show_in_header` tinyint(4) DEFAULT 0,
  `show_in_footer` tinyint(4) DEFAULT 0,
  `show_in_quick_link` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `serial_id`, `name`, `slug`, `url`, `status`, `show_in_header`, `show_in_footer`, `show_in_quick_link`, `created_at`, `updated_at`) VALUES
(14, 1, 'My Ticket', 'my-ticket', 'https://pixeldesk.kodepixel.com/ticket/search', '1', 0, 1, 0, '2023-11-22 08:26:06', '2023-11-22 08:26:06'),
(17, 2, 'Login', 'login', 'https://pixeldesk.kodepixel.com/login', '1', 0, 1, 0, '2023-11-22 10:19:54', '2023-11-22 11:00:30'),
(18, 3, 'Registration', 'registration', 'https://pixeldesk.kodepixel.com/register', '1', 0, 1, 0, '2023-11-22 10:22:54', '2023-11-22 10:23:17'),
(19, 1, 'knowledgebase', 'knowledgebase', 'http://localhost/ticket/v7/main_file/knowledgebases', '1', 1, 0, 0, '2024-04-04 04:42:36', '2024-04-04 04:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '2023_01_21_040736_create_imports_table', 1),
(4, '2023_04_08_125811_create_plans_table', 1),
(17, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(18, '2022_11_29_111509_create_jobs_table', 2),
(19, '2023_01_30_065615_create_settings_table', 2),
(20, '2023_01_31_045923_create_plugin_settings_table', 2),
(21, '2023_04_18_104936_create_categories_table', 2),
(22, '2023_04_18_165138_create_ticket_inputs_table', 2),
(23, '2023_05_08_143927_create_chats_table', 2),
(24, '2023_05_09_183042_create_agent_tickets_table', 2),
(25, '2023_05_09_184103_create_agent_responses_table', 2),
(26, '2023_05_21_142724_create_notifications_table', 2),
(27, '2023_05_21_210411_create_custom_notifications_table', 2),
(28, '2023_06_05_002200_create_canned_replies_table', 2),
(29, '2023_06_05_005648_create_faqs_table', 2),
(30, '2023_06_05_005827_create_articles_table', 2),
(31, '2023_06_05_143720_create_frontends_table', 3),
(32, '2023_06_05_230652_create_pages_table', 4),
(33, '2023_06_05_231805_create_subscribers_table', 4),
(34, '2023_06_05_231828_create_contacts_table', 4),
(35, '2023_06_06_142853_create_menus_table', 5),
(36, '2023_06_06_184439_create_article_categories_table', 6),
(37, '2023_08_27_165606_create_priorities_table', 7),
(38, '2023_08_28_112021_create_floating_chats_table', 8),
(39, '2023_08_31_123908_create_agent_responses_table', 9),
(40, '2023_08_31_164502_create_ticket_resolution_requests_table', 10),
(41, '2023_09_02_182357_create_groups_table', 11),
(42, '2023_09_03_154919_create_group_members_table', 11),
(43, '2023_12_17_104245_add_column_to_priorities', 12),
(44, '2023_12_17_121249_add_column_to_admins', 12),
(45, '2023_12_17_121756_add_column_to_support_messages', 12),
(46, '2023_12_18_104510_create_visitors_table', 12),
(47, '2024_01_06_130912_add_column_to_ticket_table', 13),
(48, '2024_02_07_091530_add_otp_to_support_tickets_table', 14),
(49, '2024_02_07_110847_create_ticket_triggers_table', 14),
(50, '2024_02_07_153603_add_counter_to_ticket_triggers_table', 14),
(51, '2024_02_17_170857_add_is_note_to_support_messages_table', 14),
(52, '2024_02_25_122544_add_mail_id_to_support_tickets_table', 14),
(53, '2024_02_25_142936_add_mail_id_to_support_messages', 14),
(54, '2024_03_25_132207_create_ticket_statuses_table', 15),
(55, '2024_03_25_133846_create_model_translations_table', 16),
(56, '2024_03_28_105421_create_departments_table', 17),
(57, '2024_03_28_112716_add_department_id_to_support_tickets_table', 18),
(58, '2024_03_28_122404_create_knowledge_bases_table', 19),
(59, '2024_03_30_125310_add_is_trigger_timeframe_locked_to_support_tickets_table', 20),
(60, '2024_04_01_100354_add_locked_trigger_to_support_tickets_table', 21),
(62, '2024_12_31_120606_update_users_table', 22);

-- --------------------------------------------------------

--
-- Table structure for table `model_translations`
--

CREATE TABLE `model_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `translateable_type` varchar(255) NOT NULL,
  `translateable_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(100) NOT NULL,
  `key` varchar(155) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` enum('1','0') NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(191) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `response_time` text DEFAULT NULL,
  `resolve_time` text DEFAULT NULL,
  `color_code` varchar(100) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT 'Active:1 , Inactive: 0',
  `is_default` enum('1','0') NOT NULL DEFAULT '0' COMMENT 'Yes:1 ,No: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`id`, `name`, `response_time`, `resolve_time`, `color_code`, `status`, `is_default`, `created_at`, `updated_at`) VALUES
(3, 'Low', '{\"in\":\"1\",\"format\":\"Week\"}', '{\"in\":\"2\",\"format\":\"Week\"}', '#26b56f', '1', '0', '2023-08-30 10:36:25', '2024-12-20 08:40:22'),
(6, 'Medium', '{\"in\":\"2\",\"format\":\"Hour\"}', '{\"in\":\"3\",\"format\":\"Hour\"}', '#b2aa14', '1', '0', '2023-08-30 10:43:55', '2024-12-20 08:40:22'),
(7, 'Urgent', '{\"in\":\"2\",\"format\":\"Minute\"}', '{\"in\":\"8\",\"format\":\"Minute\"}', '#82223a', '1', '0', '2023-08-30 10:44:11', '2024-12-20 08:40:22'),
(8, 'High', '{\"in\":\"1\",\"format\":\"Minute\"}', '{\"in\":\"1\",\"format\":\"Minute\"}', '#db1414', '1', '1', '2023-08-30 10:45:14', '2024-12-20 08:40:22');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` longtext DEFAULT NULL,
  `plugin` enum('0','1') DEFAULT '0' COMMENT 'Yes: 1,No: 0',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `plugin`, `status`, `created_at`, `updated_at`) VALUES
(77, 'site_name', 'Carplug', '0', '1', NULL, '2023-11-21 13:09:23'),
(78, 'site_logo_sm', '676e7f54e33001735294804.png', '0', '1', NULL, '2023-11-22 07:28:43'),
(79, 'site_logo_lg', '676e7f53767c51735294803.png', '0', '1', NULL, '2023-11-22 07:28:43'),
(80, 'site_favicon', '676e7f82e929b1735294850.png', '0', '1', NULL, '2023-11-21 14:34:36'),
(81, 'user_site_name', 'Logicat', '0', '1', NULL, '2023-11-21 13:09:23'),
(82, 'phone', '05 20 55 79 21', '0', '1', NULL, '2023-11-21 13:09:23'),
(83, 'email', 'contact@carplug.ma', '0', '1', NULL, '2023-11-21 13:09:23'),
(84, 'address', '17, Rue Omar Elkindy, Bourgogne, Casablanca, 20053, Maroc', '0', '1', NULL, '2023-11-21 13:09:23'),
(85, 'user_register', '1', '0', '1', NULL, '2023-05-13 12:09:12'),
(86, 'last_corn_run', NULL, '0', '1', NULL, NULL),
(87, 'default_mail_template', '<!-- [if !mso]><!--><!--<![endif]-->\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"#414a51\">\r\n<tbody>\r\n<tr>\r\n<td height=\"50\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: center; vertical-align: top; font-size: 0;\" align=\"center\">\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\" width=\"600\">\r\n<table class=\"table-inner\" border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td style=\"border-top-left-radius: 6px; border-top-right-radius: 6px; text-align: center; vertical-align: top; font-size: 0;\" align=\"center\" bgcolor=\"#0087ff\">\r\n<table style=\"height: 122.398px;\" border=\"0\" width=\"90%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr style=\"height: 20px;\">\r\n<td style=\"height: 20px;\" height=\"20\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 82.3984px;\">\r\n<td style=\"font-family: \'Open sans\', Arial, sans-serif; color: #ffffff; font-size: 16px; font-weight: bold; height: 82.3984px;\" align=\"center\"><img style=\"display: block; line-height: 0px; font-size: 0px; border: 0px;\" src=\"{{logo}}\" alt=\"img\" width=\"173\" height=\"37\"></td>\r\n</tr>\r\n<tr style=\"height: 20px;\">\r\n<td style=\"height: 20px;\" height=\"20\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table class=\"table-inner\" border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"text-align: center; vertical-align: top; font-size: 0;\" align=\"center\" bgcolor=\"#FFFFFF\">\r\n<table style=\"height: 235px; width: 90%;\" border=\"0\" width=\"511\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr style=\"height: 40px;\">\r\n<td style=\"height: 40px;\" height=\"40\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 30.7969px;\">\r\n<td style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 22px; color: #414a51; font-weight: bold; height: 30.7969px;\" align=\"center\">Hello {{username}}</td>\r\n</tr>\r\n<tr style=\"height: 24px;\">\r\n<td style=\"text-align: center; vertical-align: top; font-size: 0px; height: 24px;\" align=\"center\">\r\n<table style=\"height: 25px; width: 340px;\" border=\"0\" width=\"193\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td style=\"border-bottom: 3px solid #0087ff; width: 338px;\" height=\"20\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 20px;\">\r\n<td style=\"height: 20px;\" height=\"20\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 28px;\">\r\n<td style=\"font-family: \'Open sans\', Arial, sans-serif; color: #7f8c8d; font-size: 16px; line-height: 28px; height: 28px;\" align=\"left\">{{message}}</td>\r\n</tr>\r\n<tr style=\"height: 40px;\">\r\n<td style=\"height: 40px;\" height=\"40\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;\" align=\"center\" bgcolor=\"#f4f4f4\" height=\"45\">\r\n<table border=\"0\" width=\"90%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td height=\"10\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td class=\"preference-link\" style=\"font-family: \'Open sans\',Arial,sans-serif; color: #95a5a6; font-size: 14px;\" align=\"center\">© 2023&nbsp;<a href=\"#\">{{site_name}}</a>&nbsp;. All Rights Reserved.</td>\r\n</tr>\r\n<tr>\r\n<td height=\"10\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td height=\"60\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', '0', '1', NULL, '2023-06-11 09:39:36'),
(88, 'default_sms_template', 'Hello, {{name}}\r\n{{message}}', '0', '1', NULL, '2023-05-17 10:04:05'),
(89, 'two_factor_auth', '{\"google\":\"1\",\"sms\":\"0\",\"mail\":\"0\"}', '0', '1', NULL, NULL),
(90, 'email_verification', '1', '0', '1', NULL, '2023-11-23 16:25:10'),
(91, 'sms_otp_verification', '1', '0', '1', NULL, NULL),
(92, 'email_notifications', '1', '0', '1', NULL, '2023-06-08 11:37:57'),
(93, 'sms_notifications', '1', '0', '1', NULL, '2023-06-14 07:30:24'),
(94, 'time_zone', '\'Africa/Casablanca\'', '0', '1', NULL, NULL),
(95, 'maintenance_mode', '0', '0', '1', NULL, '2023-06-08 11:27:09'),
(96, 'app_debug', '1', '0', '1', NULL, '2023-11-23 15:36:15'),
(97, 'pagination_number', '10', '0', '1', NULL, '2023-11-21 13:09:23'),
(98, 'copy_right_text', 'Copyright © 2025 Agridiag Info France', '0', '1', NULL, '2023-11-21 13:09:23'),
(99, 'demo_mode', '0', '0', '1', NULL, '2023-06-15 12:29:16'),
(101, 'google_recaptcha', '{\"key\":\"@@@@\",\"secret_key\":\"@@@\",\"status\":\"0\"}', '1', '1', NULL, '2023-11-21 13:09:36'),
(102, 'default_recaptcha', '1', '0', '1', NULL, '2023-08-23 05:47:49'),
(103, 'captcha', '1', '0', '1', NULL, '2023-05-13 12:01:14'),
(104, 'social_login', '{\"google_oauth\":{\"client_id\":\"125020812135-t9541ms30vad488sbc8tcajmq1qc5dj3.apps.googleusercontent.com\",\"client_secret\":\"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\",\"status\":\"1\"},\"facebook_oauth\":{\"client_id\":\"##\",\"client_secret\":\"##\",\"status\":\"1\"},\"azure_oauth\":{\"client_id\":\"##\",\"client_secret\":\"##\",\"status\":\"1\"},\"envato_oauth\":{\"client_id\":\"##\",\"client_secret\":\"##\",\"status\":\"1\",\"personal_token\":\"@@\"}}', '1', '1', NULL, '2023-11-21 12:51:32'),
(105, 'google_map', '{\"key\":\"#\"}', '0', '1', NULL, NULL),
(106, 'storage', 'local', '0', '1', NULL, '2023-09-04 09:19:09'),
(108, 'mime_types', '[\"csv\",\"doc\",\"docx\",\"ico\",\"jpeg\",\"jpg\",\"pdf\",\"png\",\"tiff\",\"zip\"]', '0', '1', NULL, '2023-09-04 09:19:09'),
(109, 'aws_s3', '{\"s3_key\":\"AKIAVHNVGMOH7UEGUX@#\",\"s3_secret\":\"5fvYpCPottI4267kxW6SVcMzj3GGkCs65GpYgd##\",\"s3_region\":\"ap-southeast-1\",\"s3_bucket\":\"gen-bucket-s3\"}', '1', '1', NULL, '2023-11-21 13:10:07'),
(110, 'pusher_settings', '{\"app_id\":\"1234\",\"app_key\":\"demo\",\"app_secret\":\"demo\",\"app_cluster\":\"ap2\",\"chanel\":\"My-Channel\",\"event\":\"My-Event\"}', '1', '1', NULL, '2023-11-21 13:09:55'),
(111, 'database_notifications', '1', '0', '1', NULL, '2023-05-13 12:01:13'),
(112, 'cookie', '1', '0', '1', NULL, '2023-09-05 07:37:35'),
(113, 'ticket_settings', '[{\"labels\":\"Num\\u00e9ro de CNSS\",\"type\":\"text\",\"width\":\"COL_12\",\"required\":\"1\",\"visibility\":\"1\",\"placeholder\":\"num\\u00e9ro de CNSS\",\"default\":\"0\",\"name\":\"num\\u00e9ro_de_cnss\"},{\"labels\":\"Num\\u00e9ro de WhatsApp\",\"type\":\"text\",\"width\":\"COL_12\",\"required\":\"1\",\"visibility\":\"1\",\"placeholder\":\"num\\u00e9ro de whatsapp\",\"default\":\"0\",\"name\":\"num\\u00e9ro_de_whatsapp\"},{\"labels\":\"Name\",\"type\":\"text\",\"required\":\"1\",\"placeholder\":\"Name\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"name\"},{\"labels\":\"Email\",\"type\":\"email\",\"required\":\"1\",\"placeholder\":\"Email\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"email\"},{\"labels\":\"Phone\",\"type\":\"text\",\"width\":\"COL_12\",\"required\":\"1\",\"visibility\":\"1\",\"placeholder\":\"phone number\",\"default\":\"0\",\"name\":\"phone\"},{\"labels\":\"Subject\",\"type\":\"text\",\"required\":\"1\",\"placeholder\":\"Subject\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"subject\"},{\"labels\":\"Formation Type\",\"type\":\"select\",\"required\":\"1\",\"placeholder\":\"Select  Formation\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"category\",\"width\":\"COL_12\",\"visibility\":\"1\",\"option_value\":[],\"option\":[]},{\"labels\":\"Attachment\",\"type\":\"file\",\"required\":\"0\",\"placeholder\":\"Upload upto\",\"default\":\"1\",\"multiple\":\"1\",\"name\":\"attachments\"},{\"labels\":\"Priority\",\"type\":\"select\",\"required\":\"1\",\"placeholder\":\"Select Priority\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"priority\"},{\"labels\":\"Description\",\"type\":\"textarea\",\"required\":\"1\",\"placeholder\":\"Description\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"description\"}]', '0', '1', NULL, '2024-12-27 16:57:08'),
(114, 'max_file_size', '2000000', '0', '1', NULL, '2023-09-04 09:19:09'),
(115, 'cookie_text', 'We use cookies for a better website experience. By using our site, you agree to our Cookie Policy.', '0', '1', NULL, '2023-11-21 13:09:23'),
(116, 'geo_location', 'ip_base', '0', '1', NULL, '2023-09-04 11:19:59'),
(117, 'google_map_key', 'AIzaSyBTOYRAWi26WsbUXi06KNun_FrQZVii9ws', '0', '1', NULL, '2023-09-04 11:19:59'),
(118, 'auto_ticket_assignment', '0', '0', '1', NULL, '2023-09-05 07:01:04'),
(119, 'email_gateway_id', '1', '0', '1', NULL, '2024-12-19 15:55:33'),
(120, 'chat_module', '1', '0', '1', NULL, '2023-08-29 10:18:45'),
(121, 'same_site_name', '1', '0', '1', NULL, '2023-07-06 09:40:31'),
(122, 'max_file_upload', '6', '0', '1', NULL, '2023-09-04 09:19:09'),
(123, 'sms_gateway_id', '2', '0', '1', NULL, '2023-09-04 11:18:54'),
(124, 'slack_notifications', '1', '0', '1', NULL, '2023-05-17 11:36:54'),
(126, 'slack_web_hook_url', 'https://hooks.slack.com/services/T02KR14CAKE/B05893M157W/fHbOfOAi6xEcUy4vKpy8nQ##', '0', '1', NULL, '2023-11-21 13:09:45'),
(128, 'slack_channel', 'xxx', '0', '1', NULL, '2023-11-21 13:09:45'),
(129, 'frontend_logo', '676e7f559df391735294805.png', '0', '1', NULL, '2023-11-21 14:34:36'),
(130, 'ticket_notes', '<h4 style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:var(--text-primary);font-family:Inter, sans-serif;font-size:20px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;letter-spacing:normal;line-height:1.2;margin:0px 0px 5px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 18px; font-weight: normal;\">Tell us!</span></h4><p style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:rgb(57, 67, 75);font-family:Inter, sans-serif;font-size:16px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;line-height:1.8;margin:0px 0px 25px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 14px;\">Add as much detail as possible, including site and page name.</span></p><h4 style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:var(--text-primary);font-family:Inter, sans-serif;font-size:20px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;letter-spacing:normal;line-height:1.2;margin:0px 0px 5px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 18px; font-weight: normal;\">Show us!</span></h4><p style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:rgb(57, 67, 75);font-family:Inter, sans-serif;font-size:16px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;line-height:1.8;margin:0px 0px 25px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 14px;\">Add a screenshot or a link to a video.</span></p><h4 style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:var(--text-primary);font-family:Inter, sans-serif;font-size:20px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;letter-spacing:normal;line-height:1.2;margin:0px 0px 5px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 18px; font-weight: normal;\">Caution</span></h4><p style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:rgb(57, 67, 75);font-family:Inter, sans-serif;font-size:16px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;line-height:1.8;margin:0px 0px 25px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 14px;\">Ticket response time can be up to 2 business days.</span></p><h4 style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:var(--text-primary);font-family:Inter, sans-serif;font-size:20px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;letter-spacing:normal;line-height:1.2;margin:0px 0px 5px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 18px; font-weight: normal;\">Response Time</span></h4><p style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:rgb(57, 67, 75);font-family:Inter, sans-serif;font-size:16px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;line-height:1.8;margin:0px 0px 25px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 14px;\">Our support team operates six days a week, from 10:00 AM to 8:00 PM in Bangladesh Standard Time (GMT+6), and strives to handle each ticket in a timely manner. However, our response time may be delayed by one or two business days during every weekend or government holiday.</span></p><h4 style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:var(--text-primary);font-family:Inter, sans-serif;font-size:20px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;letter-spacing:normal;line-height:1.2;margin:0px 0px 5px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><font color=\"#ff0000\"><span style=\"font-weight: normal; background-color: rgb(255, 255, 255); font-size: 18px;\">Important Notice </span><span style=\"font-weight: normal; background-color: rgb(255, 255, 255);\"><br></span></font></h4><p><span style=\"color:rgb(57,67,75);font-family:Inter, sans-serif;font-size:16px;\"><span style=\"-webkit-text-stroke-width: 0px; box-sizing: border-box; font-style: normal; font-variant-caps: normal; font-variant-ligatures: normal; font-weight: 400; letter-spacing: normal; margin: 0px; outline: none; padding: 0px; text-align: start; text-decoration-color: initial; text-decoration-style: initial; text-decoration-thickness: initial; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; font-size: 14px;\">If a ticket remains unresponsive for more than one or two business days or is unrelated to our support items, it will be locked. Additionally, duplicate ticket issues may also result in ticket locking. Thank you for your cooperation.</span></span></p><p><span style=\"color:rgb(57,67,75);font-family:Inter, sans-serif;font-size:16px;\"><span style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;margin:0px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><br></span></span></p><p><span style=\"color:rgb(57,67,75);font-family:Inter, sans-serif;font-size:16px;\"><span style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;margin:0px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><br></span></span></p>', '0', '1', NULL, '2023-11-21 13:53:49'),
(131, 'primary_color', '#221133', '0', '1', NULL, '2023-11-21 14:27:10'),
(132, 'secondary_color', '#07298b', '0', '1', NULL, '2023-11-21 14:27:10'),
(133, 'text_secondary', '#777777', '0', '1', NULL, '2023-11-21 14:27:10'),
(134, 'text_primary', '#0f2335', '0', '1', NULL, '2023-11-21 14:27:10'),
(135, 'open_ai_key', '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', '0', '1', NULL, '2023-09-03 07:04:06'),
(136, 'auto_reply', '1', '0', '1', NULL, '2023-06-14 07:30:09'),
(137, 'terms_accepted_flag', '1', '0', '1', NULL, '2023-07-06 07:36:06'),
(138, 'avg_response_time', '30', '0', '1', NULL, '2023-09-02 05:31:51'),
(139, 'number_of_tickets', '3', '0', '1', NULL, '2023-09-02 05:31:51'),
(140, 'auto_best_agent', '1', '0', '1', NULL, '2023-09-02 05:11:26'),
(141, 'open_ai', '1', '0', '1', NULL, '2023-09-03 07:04:06'),
(142, 'meta_keywords', '', '0', '1', NULL, '2023-09-03 07:04:06'),
(143, 'meta_description', '', '0', '1', NULL, '2023-09-03 07:04:06'),
(144, 'meta_image', '', '0', '1', NULL, '2023-09-03 07:04:06'),
(145, 'group_base_ticket_assign', '0', '0', '1', NULL, '2023-09-05 07:37:23'),
(146, 'dos_attempts', '2', '0', '1', NULL, NULL),
(147, 'dos_attempts_in_second', '1', '0', '1', NULL, NULL),
(148, 'dos_security', 'captcha', '0', '1', NULL, NULL),
(149, 'app_version', '2.1', '0', '1', NULL, NULL),
(150, 'system_installed_at', '2025-01-08 09:00:11', '0', '1', NULL, NULL),
(153, 'purchase_key', 'cfb543c8-f94e-4901-b5b6-72ad97a3d33e', '0', '1', NULL, NULL),
(154, 'envato_username', 'JohnDoe123', '0', '1', NULL, NULL),
(155, 'maintenance_title', 'Maintenance Title Here', '0', '1', NULL, NULL),
(156, 'maintenance_description', 'Maintenance Mode Description Here', '0', '1', NULL, NULL),
(157, 'last_cron_run', '2024-01-13 16:02:04', '0', '1', NULL, NULL),
(158, 'enable_business_hour', '1', '0', '1', NULL, NULL),
(159, 'business_hour', '{\"Mon\":{\"is_off\":true,\"start_time\":\"9:00 AM\",\"end_time\":\"6:00 PM\"},\"Tue\":{\"is_off\":true,\"start_time\":\"9:00 AM\",\"end_time\":\"6:00 PM\"},\"Wed\":{\"is_off\":true,\"start_time\":\"9:00 AM\",\"end_time\":\"6:00 PM\"},\"Thu\":{\"is_off\":true,\"start_time\":\"9:00 AM\",\"end_time\":\"6:00 PM\"},\"Fri\":{\"is_off\":true,\"start_time\":\"9:00 AM\",\"end_time\":\"6:00 PM\"},\"Sat\":{\"is_off\":false,\"start_time\":\"9:00 AM\",\"end_time\":\"6:00 PM\"},\"Sun\":{\"is_off\":true,\"start_time\":\"24H\",\"end_time\":null}}', '0', '1', NULL, NULL),
(160, 'operating_note', '<span style=\"font-size: 14px;\">You can reach our technical team during hours aligned with the<b><span style=\"font-size: 18px;\">  </span></b></span><span style=\"font-size: 18px;\"><b>[timezone]</b></span><span style=\"font-size: 14px;\"><b><span style=\"font-size: 18px;\"> </span></b> Time Zone.</span>', '0', '1', NULL, NULL),
(161, 'email_to_ticket', '1', '0', '1', NULL, NULL),
(162, 'ticket_department', '1', '0', '1', NULL, NULL),
(163, 'agent_name_privacy', '0', '0', '1', NULL, NULL),
(164, 'message_seen_status', '1', '0', '1', NULL, NULL),
(165, 'user_ticket_close', '0', '0', '1', NULL, NULL),
(166, 'user_ticket_open', '0', '0', '1', NULL, NULL),
(167, 'ticket_prefix', 'Ticket', '0', '1', NULL, NULL),
(168, 'ticket_suffix', '0', '0', '1', NULL, NULL),
(169, 'guest_ticket', '1', '0', '1', NULL, NULL),
(170, 'custom_file', '1', '0', '1', NULL, NULL),
(171, 'ticket_search_otp', '0', '0', '1', NULL, NULL),
(172, 'user_ticket_delete', '0', '0', '1', NULL, NULL),
(173, 'ticket_close_status', '4', '0', '1', NULL, NULL),
(174, 'ticket_close_days', '5', '0', '1', NULL, NULL),
(175, 'ticket_duplicate_status', '[\"3\"]', '0', '1', NULL, NULL),
(176, 'default_notification', '1', '0', '1', NULL, NULL),
(177, 'dos_prevent', '1', '0', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sms_gateways`
--

CREATE TABLE `sms_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gateway_code` varchar(30) DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `credential` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Active : 1, Inactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_gateways`
--

INSERT INTO `sms_gateways` (`id`, `gateway_code`, `name`, `credential`, `status`, `created_at`, `updated_at`) VALUES
(1, '101NEX', 'nexmo', '{\"api_key\":\"demo\",\"api_secret\":\"demo\",\"sender_id\":\"1234\"}', 1, NULL, '2023-12-28 09:24:01'),
(2, '102TWI', 'twilio', '{\"account_sid\":\"demo\",\"auth_token\":\"demo\",\"from_number\":\"1234\"}', 1, NULL, '2023-12-28 09:23:50'),
(3, '103BIRD', 'message Bird', '{\"access_key\":\"demo\"}', 1, NULL, '2023-12-28 09:24:11'),
(4, '104INFO', 'InfoBip', '{\"sender_id\":\"1234\",\"infobip_api_key\":\"demo\",\"infobip_base_url\":\"demo\"}', 1, NULL, '2023-12-28 09:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `support_ticket_id` int(10) UNSIGNED DEFAULT NULL,
  `admin_id` int(10) UNSIGNED DEFAULT NULL,
  `mail_id` varchar(191) DEFAULT NULL,
  `message` longtext NOT NULL,
  `original_message` longtext DEFAULT NULL,
  `file` text DEFAULT NULL,
  `editor_files` text DEFAULT NULL,
  `seen` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Yes: 1, No: 0',
  `is_draft` enum('1','0') NOT NULL DEFAULT '0' COMMENT 'Yes:1 ,No: 0',
  `is_note` enum('1','0') NOT NULL DEFAULT '0' COMMENT 'Yes:1 ,No: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_messages`
--

INSERT INTO `support_messages` (`id`, `support_ticket_id`, `admin_id`, `mail_id`, `message`, `original_message`, `file`, `editor_files`, `seen`, `is_draft`, `is_note`, `created_at`, `updated_at`) VALUES
(2, 2, NULL, NULL, '<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><head><meta charset=\'utf-8\"\'></head><body><p>I have security issues in my deskI have security issues in my desk</p></body></html>\n', NULL, '[]', '[]', 1, '0', '0', '2024-12-19 13:52:27', '2024-12-19 13:52:27'),
(3, 2, 25, NULL, '<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><head><meta charset=\'utf-8\"\'></head><body><p>Hello! We arz hzppy to see you here. How can I help you?</p></body></html>\n', NULL, '[]', '[]', 1, '0', '0', '2024-12-19 14:04:38', '2024-12-19 14:04:38'),
(4, 2, NULL, NULL, '<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><head><meta charset=\'utf-8\"\'></head><body><p>Thnk you! I have an issue in my desk it doesn\'t open.</p></body></html>\n', NULL, '[]', '[]', 1, '0', '0', '2024-12-19 14:05:52', '2024-12-19 14:05:52'),
(5, 2, 25, NULL, '<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><head><meta charset=\'utf-8\"\'></head><body><p>kqsmlklq sqslq sqispois aizpo pipa piapza</p></body></html>\n', NULL, '[]', '[]', 0, '0', '0', '2024-12-19 14:07:12', '2024-12-19 14:07:12'),
(6, 3, NULL, NULL, '<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><head><meta charset=\'utf-8\"\'></head><body><p>Text 1</p></body></html>\n', NULL, '[]', '[]', 1, '0', '0', '2024-12-19 15:06:32', '2024-12-19 15:06:32'),
(7, 3, 26, NULL, '<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><head><meta charset=\'utf-8\"\'></head><body><p>Hello Mr Mohammed! How can I help you?</p></body></html>\n', NULL, '[]', '[]', 1, '0', '0', '2024-12-19 15:08:42', '2024-12-19 15:08:42'),
(8, 3, NULL, NULL, '<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><head><meta charset=\'utf-8\"\'></head><body><p>I have some issues with y engin. Can you help me ti fix it please?</p></body></html>\n', NULL, '[]', '[]', 1, '0', '0', '2024-12-19 15:09:32', '2024-12-19 15:09:32'),
(9, 3, NULL, NULL, '<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><head><meta charset=\'utf-8\"\'></head><body><p>Yes of course mr Mohammed. Thak you!</p></body></html>\n', NULL, '[]', '[]', 1, '0', '0', '2024-12-19 15:11:52', '2024-12-19 15:11:52'),
(10, 3, 26, NULL, '<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><head><meta charset=\'utf-8\"\'></head><body><p>Thank you for choosing us!</p></body></html>\n', NULL, '[]', '[]', 0, '0', '0', '2024-12-19 15:13:22', '2024-12-19 15:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket_number` varchar(191) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mail_id` varchar(191) DEFAULT NULL,
  `priority_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ticket_data` text DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `status` bigint(20) UNSIGNED DEFAULT NULL,
  `priority` tinyint(4) DEFAULT NULL COMMENT 'Urgent: 1, High: 2, Low: 3, Medium: 4 ',
  `created_at` timestamp NULL DEFAULT NULL,
  `solved_at` timestamp NULL DEFAULT NULL,
  `requested_by` bigint(20) DEFAULT NULL,
  `solved_request_at` timestamp NULL DEFAULT NULL,
  `notification_settings` longtext DEFAULT NULL,
  `envato_payload` longtext DEFAULT NULL,
  `is_support_expired` tinyint(4) DEFAULT NULL,
  `otp` varchar(100) DEFAULT NULL,
  `locked_trigger` longtext DEFAULT NULL,
  `user_last_reply` timestamp NULL DEFAULT NULL,
  `is_trigger_timeframe_locked` enum('1','0') NOT NULL DEFAULT '0' COMMENT 'true:1 ,false: 0',
  `solved_request` tinyint(4) DEFAULT NULL COMMENT 'Requested : 0 ,Accepted :1 ,Rejected:2',
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_resolution_requests`
--

CREATE TABLE `ticket_resolution_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `is_solved` enum('0','1','2') NOT NULL COMMENT 'Pending: 2 ,Yes:1 , No: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_statuses`
--

CREATE TABLE `ticket_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `color_code` varchar(255) NOT NULL,
  `status` enum('1','0') NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `default` enum('1','0') NOT NULL COMMENT 'Yes:1 , No: 0',
  `is_base` enum('1','0') NOT NULL COMMENT 'Yes:1 , No: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_statuses`
--

INSERT INTO `ticket_statuses` (`id`, `name`, `color_code`, `status`, `default`, `is_base`, `created_at`, `updated_at`) VALUES
(1, 'OPEN', '#db1414', '1', '0', '1', '2024-04-04 04:36:29', '2024-04-04 04:36:29'),
(2, 'PENDING', '#db1414', '1', '1', '1', '2024-04-04 04:36:29', '2024-04-04 04:36:29'),
(3, 'PROCESSING', '#db1414', '1', '0', '1', '2024-04-04 04:36:29', '2024-04-04 04:36:29'),
(4, 'SOLVED', '#db1414', '1', '0', '1', '2024-04-04 04:36:29', '2024-04-04 04:36:29'),
(5, 'HOLD', '#db1414', '1', '0', '1', '2024-04-04 04:36:29', '2024-04-04 04:36:29'),
(6, 'CLOSED', '#db1414', '1', '0', '1', '2024-04-04 04:36:29', '2024-04-04 04:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_triggers`
--

CREATE TABLE `ticket_triggers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `all_condition` longtext DEFAULT NULL,
  `any_condition` longtext DEFAULT NULL,
  `actions` longtext DEFAULT NULL,
  `triggered_counter` int(11) NOT NULL DEFAULT 0,
  `last_triggered` timestamp NULL DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0' COMMENT 'Active:1 ,Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(40) DEFAULT NULL,
  `key` varchar(191) DEFAULT NULL,
  `value` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `code`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'en', 'back_to_home', 'Back to Home', '2024-02-25 11:10:22', '2024-02-25 11:10:22'),
(2, 'en', 'track', 'Track', '2024-02-25 11:10:22', '2024-02-25 11:10:22'),
(3, 'en', 'create_ticket', 'Create Ticket', '2024-02-25 11:10:22', '2024-02-25 11:10:22'),
(4, 'en', 'login', 'Login', '2024-02-25 11:10:22', '2024-02-25 11:10:22'),
(5, 'en', 'important_links', 'Important Links', '2024-02-25 11:10:22', '2024-02-25 11:10:22'),
(6, 'en', 'quick_link', 'Quick Link', '2024-02-25 11:10:22', '2024-02-25 11:10:22'),
(7, 'en', 'social_links', 'Social Links', '2024-02-25 11:10:22', '2024-02-25 11:10:22'),
(8, 'en', 'enter_your_email', 'Enter Your Email', '2024-02-25 11:10:22', '2024-02-25 11:10:22'),
(9, 'en', 'subscribe', 'Subscribe', '2024-02-25 11:10:22', '2024-02-25 11:10:22'),
(10, 'en', 'admin_access_portal', 'Admin Access Portal', '2024-04-04 04:36:16', '2024-04-04 04:36:16'),
(11, 'en', 'username', 'Username', '2024-04-04 04:36:17', '2024-04-04 04:36:17'),
(12, 'en', 'enter_username', 'Enter username', '2024-04-04 04:36:17', '2024-04-04 04:36:17'),
(13, 'en', 'password', 'Password', '2024-04-04 04:36:17', '2024-04-04 04:36:17'),
(14, 'en', 'enter_password', 'Enter password', '2024-04-04 04:36:17', '2024-04-04 04:36:17'),
(15, 'en', 'remember_me', 'Remember me', '2024-04-04 04:36:17', '2024-04-04 04:36:17'),
(16, 'en', 'forgot_password', 'Forgot password', '2024-04-04 04:36:17', '2024-04-04 04:36:17'),
(17, 'en', 'sign_in', 'Sign In', '2024-04-04 04:36:17', '2024-04-04 04:36:17'),
(18, 'en', 'welcome_back_', 'Welcome Back ', '2024-04-04 04:36:17', '2024-04-04 04:36:17'),
(19, 'en', 'admin_login', 'Admin Login', '2024-04-04 04:36:17', '2024-04-04 04:36:17'),
(20, 'en', 'welcome', 'Welcome', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(21, 'en', 'heres_whats_happening_with_your_system', 'Here\'s what\'s happening with your System', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(22, 'en', 'last_cron_run', 'Last cron run', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(23, 'en', 'sort_by', 'Sort by', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(24, 'en', 'all', 'All', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(25, 'en', 'today', 'Today', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(26, 'en', 'yesterday', 'Yesterday', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(27, 'en', 'last_7_days', 'Last 7 Days', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(28, 'en', 'last_30_days', 'Last 30 Days', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(29, 'en', 'total_users', 'Total Users', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(30, 'en', 'total_agents', 'Total Agents', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(31, 'en', 'total_categories', 'Total Categories', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(32, 'en', 'total_articles', 'Total Articles', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(33, 'en', 'total_subscriber', 'Total Subscriber', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(34, 'en', 'total_tickets', 'Total Tickets', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(35, 'en', 'view_all', 'View All', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(36, 'en', 'tickets', 'Tickets', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(37, 'en', 'total', 'Total', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(38, 'en', 'ticket_by_user', 'Ticket By User', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(39, 'en', 'sorry_no_result_found', 'Sorry! No Result Found', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(40, 'en', 'ticket_by_category', 'Ticket By Category', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(41, 'en', 'latest_tickets', 'Latest Tickets', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(42, 'en', 'download_pdf', 'Download PDF', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(43, 'en', 'ticket_id', 'Ticket Id', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(44, 'en', 'name', 'Name', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(45, 'en', 'email', 'Email', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(46, 'en', 'creation_time', 'Creation Time', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(47, 'en', 'subject', 'Subject', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(48, 'en', 'status', 'Status', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(49, 'en', 'pending_tickets', 'Pending Tickets', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(50, 'en', 'top_categories_by_tickets', 'Top Categories By Tickets', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(51, 'en', 'latest_agent_replies', 'Latest Agent Replies', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(52, 'en', 'opened_tickets', 'Opened Tickets', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(53, 'en', 'closed_tickets', 'Closed Tickets', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(54, 'en', 'dashboard', 'Dashboard', '2024-04-04 04:36:37', '2024-04-04 04:36:37'),
(55, 'en', 'clear_cache', 'Clear Cache', '2024-04-04 04:36:38', '2024-04-04 04:36:38'),
(56, 'en', 'browse_frontend', 'Browse Frontend', '2024-04-04 04:36:38', '2024-04-04 04:36:38'),
(57, 'en', 'notifications', 'Notifications', '2024-04-04 04:36:38', '2024-04-04 04:36:38'),
(58, 'en', 'no_new_notificatios', 'No New Notificatios', '2024-04-04 04:36:38', '2024-04-04 04:36:38'),
(59, 'en', 'profile', 'Profile', '2024-04-04 04:36:38', '2024-04-04 04:36:38'),
(60, 'en', 'logout', 'Logout', '2024-04-04 04:36:38', '2024-04-04 04:36:38'),
(61, 'en', 'menu', 'Menu', '2024-04-04 04:36:38', '2024-04-04 04:36:38'),
(62, 'en', 'messenger', 'Messenger', '2024-04-04 04:36:38', '2024-04-04 04:36:38'),
(63, 'en', 'ticketsagents__users', 'Tickets,Agents & Users', '2024-04-04 04:36:38', '2024-04-04 04:36:38'),
(64, 'en', 'tickets_lists', 'Tickets Lists', '2024-04-04 04:36:38', '2024-04-04 04:36:38'),
(65, 'en', 'ticket_configuration', 'Ticket Configuration', '2024-04-04 04:36:38', '2024-04-04 04:36:38'),
(66, 'en', 'general_configuration', 'General Configuration', '2024-04-04 04:36:38', '2024-04-04 04:36:38'),
(67, 'en', 'triggering', 'Triggering', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(68, 'en', 'ticket_status', 'Ticket Status', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(69, 'en', 'departments', 'Departments', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(70, 'en', 'ticket_priority', 'Ticket Priority', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(71, 'en', 'ticket_categories', 'Ticket Categories', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(72, 'en', 'predefined_response', 'Predefined Response', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(73, 'en', 'agent_management', 'Agent Management', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(74, 'en', 'add_new', 'Add New', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(75, 'en', 'agent_list', 'Agent List', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(76, 'en', 'agent_group', 'Agent Group', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(77, 'en', 'manage_user', 'Manage User', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(78, 'en', 'user_list', 'User List', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(79, 'en', 'appearance__others', 'Appearance & Others', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(80, 'en', 'appearance_settings', 'Appearance Settings', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(81, 'en', 'section_manage', 'Section Manage', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(82, 'en', 'menu_manage', 'Menu Manage', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(83, 'en', 'dynamic_pages', 'Dynamic Pages', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(84, 'en', 'faq_section', 'FAQ Section', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(85, 'en', 'knowledgebase', 'knowledgebase', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(86, 'en', 'article_administration', 'Article Administration', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(87, 'en', 'article_topics', 'Article Topics', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(88, 'en', 'article_categories', 'Article Categories', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(89, 'en', 'article_list', 'Article List', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(90, 'en', 'marketingpromotion', 'Marketing/Promotion', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(91, 'en', 'contact_message', 'Contact Message', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(92, 'en', 'subscribers', 'Subscribers', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(93, 'en', 'email__sms_config', 'Email & SMS Config', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(94, 'en', 'email_configuration', 'Email Configuration', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(95, 'en', 'outgoing_method', 'Outgoing Method', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(96, 'en', 'incoming_method', 'Incoming Method', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(97, 'en', 'global_template', 'Global template', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(98, 'en', 'mail_templates', 'Mail templates', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(99, 'en', 'sms_configuration', 'SMS Configuration', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(100, 'en', 'sms_gateway', 'SMS Gateway', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(101, 'en', 'global_setting', 'Global Setting', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(102, 'en', 'sms_templates', 'SMS templates', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(103, 'en', 'setup__configurations', 'Setup & Configurations', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(104, 'en', 'application_settings', 'Application Settings', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(105, 'en', 'app_settings', 'App Settings', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(106, 'en', 'ai_configuration', 'AI Configuration', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(107, 'en', 'system_preferences', 'System Preferences', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(108, 'en', 'notification_settings', 'Notification settings', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(109, 'en', 'security_settings', 'Security Settings', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(110, 'en', 'visitors', 'Visitors', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(111, 'en', 'dos_security', 'Dos Security', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(112, 'en', 'system_upgrade', 'System Upgrade', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(113, 'en', 'languages', 'Languages', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(114, 'en', 'about_system', 'About System', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(115, 'en', 'app_version', 'App Version', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(116, 'en', 'ai_assistance', 'AI Assistance', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(117, 'en', 'result', 'Result', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(118, 'en', 'copy', 'Copy', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(119, 'en', 'download', 'Download', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(120, 'en', 'your_content', 'Your Content', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(121, 'en', 'your_prompt_goes_here__', 'Your prompt goes here .... ', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(122, 'en', 'what_do_you_want_to_do', 'What do you want to do', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(123, 'en', 'here_are_some_ideas', 'Here are some ideas', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(124, 'en', 'more', 'More', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(125, 'en', 'translate', 'Translate', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(126, 'en', 'back', 'Back', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(127, 'en', 'rewrite_it', 'Rewrite It', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(128, 'en', 'adjust_tone', 'Adjust Tone', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(129, 'en', 'choose_language', 'Choose Language', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(130, 'en', 'select_language', 'Select Language', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(131, 'en', 'or', 'OR', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(132, 'en', 'make_your_own_prompt', 'Make Your Own Prompt', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(133, 'en', 'ex_make_it_more_friendly_', 'Ex: Make It more friendly ', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(134, 'en', 'insert', 'Insert', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(135, 'en', 'cancel', 'Cancel', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(136, 'en', 'do_not_close_window_while_proecessing', 'Do not close window while proecessing', '2024-04-04 04:36:39', '2024-04-04 04:36:39'),
(137, 'en', 'hello_', 'Hello ', '2024-04-04 04:36:40', '2024-04-04 04:36:40'),
(138, 'en', 'this_function_is_not_avaialbe_for_website_demo_mode', 'This Function is Not Avaialbe For Website Demo Mode', '2024-04-04 04:36:40', '2024-04-04 04:36:40'),
(139, 'en', 'select_country', 'Select Country', '2024-04-04 04:36:40', '2024-04-04 04:36:40'),
(140, 'en', 'generate_with_ai', 'Generate With AI', '2024-04-04 04:36:40', '2024-04-04 04:36:40'),
(141, 'en', 'text_copied_to_clipboard', 'Text copied to clipboard!', '2024-04-04 04:36:40', '2024-04-04 04:36:40'),
(142, 'en', 'incoming_mail_configuration', 'incoming Mail Configuration', '2024-04-04 04:36:51', '2024-04-04 04:36:51'),
(143, 'en', 'home', 'Home', '2024-04-04 04:36:51', '2024-04-04 04:36:51'),
(144, 'en', 'imap_method', 'IMAP Method', '2024-04-04 04:36:52', '2024-04-04 04:36:52'),
(145, 'en', 'email_to_ticket', 'Email To Ticket', '2024-04-04 04:36:52', '2024-04-04 04:36:52'),
(146, 'en', 'convert_incoming_email_to_ticket_if_email_body_or_subject_contains__any_of_the_specified_keywords', 'Convert incoming email to ticket if email body or subject contains  any of the specified keywords', '2024-04-04 04:36:52', '2024-04-04 04:36:52'),
(147, 'en', 'comma_separated', 'Comma separated', '2024-04-04 04:36:52', '2024-04-04 04:36:52'),
(148, 'en', 'enter_', 'Enter ', '2024-04-04 04:36:52', '2024-04-04 04:36:52'),
(149, 'en', 'update', 'Update', '2024-04-04 04:36:52', '2024-04-04 04:36:52'),
(150, 'en', 'enter_keywords', 'Enter Keywords', '2024-04-04 04:36:52', '2024-04-04 04:36:52'),
(151, 'en', 'general_setting', 'General Setting', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(152, 'en', 'basic_settings', 'Basic Settings', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(153, 'en', 'agent_settings', 'Agent Settings', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(154, 'en', 'theme_settings', 'Theme Settings', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(155, 'en', 'storage_settings', 'Storage Settings', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(156, 'en', 'pusher_settings', 'Pusher Settings', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(157, 'en', 'slack_settings', 'Slack Settings', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(158, 'en', 'recaptcha_settings', 'Recaptcha Settings', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(159, 'en', '3rd_party_login', '3rd Party Login', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(160, 'en', 'logo_settings', 'Logo Settings', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(161, 'en', 'setup_cron_jobs', 'Setup Cron Jobs', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(162, 'en', 'use_same_site_name', 'Use Same Site Name', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(163, 'en', 'site_name', 'Site Name', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(164, 'en', 'user_site_name', 'User Site Name', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(165, 'en', 'phone', 'Phone', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(166, 'en', 'address', 'Address', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(167, 'en', 'copy_right_text', 'Copy Right Text', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(168, 'en', 'pagination_number', 'Pagination Number', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(169, 'en', 'time_zone', 'Time Zone', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(170, 'en', 'cookie__text', 'Cookie  Text', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(171, 'en', 'enter_cookie_text', 'Enter Cookie Text', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(172, 'en', 'maintenance_mode_title', 'Maintenance Mode Title', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(173, 'en', 'enter_title', 'Enter title', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(174, 'en', 'maintenance_mode_description', 'Maintenance Mode Description', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(175, 'en', 'enter_description', 'Enter description', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(176, 'en', 'submit', 'Submit', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(177, 'en', 'best_agent_settings', 'Best Agent Settings', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(178, 'en', 'avg_response_time', 'Avg Response Time', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(179, 'en', 'in_miniutes', 'In Miniutes', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(180, 'en', 'avg_response_time_required_to_become_a_bestpopular_agent', 'Avg Response Time Required To Become a Best/Popular Agent', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(181, 'en', 'minimum_no_of_responsed_ticket', 'Minimum No. Of Responsed Ticket', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(182, 'en', 'to_attain_the_status_of_a_top_agent_the_requisite_minimum_number_of_tickets_to_respond_to_is_', 'To attain the status of a top agent, the requisite minimum number of tickets to respond to is ...', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(183, 'en', 'enter_number', 'Enter Number', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(184, 'en', 'frontend_themecolor_settings', 'Frontend Theme/Color Settings', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(185, 'en', 'primary_color', 'Primary Color', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(186, 'en', 'secondary_color', 'Secondary Color', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(187, 'en', 'secondry_color', 'Secondry Color', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(188, 'en', 'text_primary_color', 'Text Primary Color', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(189, 'en', 'text_secondary_color', 'Text Secondary Color', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(190, 'en', 'text_secondry_color', 'Text Secondry Color', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(191, 'en', 'local', 'local', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(192, 'en', 'aws_s3', 'Aws S3', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(193, 'en', 'local_storage_settings', 'Local Storage Settings', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(194, 'en', 'supported_file_types', 'Supported File Types', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(195, 'en', 'maximum_file_upload', 'Maximum File Upload', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(196, 'en', 'you_can_not_upload_more_than_that_at_a_time_', 'You Can Not Upload More Than That At A Time ', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(197, 'en', 'max_file_upload_size', 'Max File Upload size', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(198, 'en', 'in_kilobyte', 'In Kilobyte', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(199, 'en', 's3_storage_settings', 'S3 Storage Settings', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(200, 'en', 'web_hook_url', 'Web Hook Url', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(201, 'en', 'chanel_name', 'Chanel Name', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(202, 'en', 'optional', 'Optional', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(203, 'en', 'use_default_captcha', 'Use Default Captcha', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(204, 'en', 'socail_login_setup', 'Socail Login Setup', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(205, 'en', 'active', 'Active', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(206, 'en', 'inactive', 'Inactive', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(207, 'en', 'callback_url', 'Callback Url', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(208, 'en', 'site_logo', 'Site Logo', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(209, 'en', 'logo_icon', 'Logo Icon', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(210, 'en', 'frontend_logo', 'Frontend Logo', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(211, 'en', 'site_favicon', 'Site Favicon', '2024-04-04 04:37:03', '2024-04-04 04:37:03'),
(212, 'en', 'cron_job_setting', 'Cron Job Setting', '2024-04-04 04:37:04', '2024-04-04 04:37:04'),
(213, 'en', 'cron_job_', 'Cron Job ', '2024-04-04 04:37:04', '2024-04-04 04:37:04'),
(214, 'en', 'set_time_for_1_minute', 'Set time for 1 minute', '2024-04-04 04:37:04', '2024-04-04 04:37:04'),
(215, 'en', 'close', 'Close							', '2024-04-04 04:37:04', '2024-04-04 04:37:04'),
(216, 'en', 'successfully_reseted', 'Successfully Reseted', '2024-04-04 04:37:04', '2024-04-04 04:37:04'),
(217, 'en', 'feild_is_required', 'Feild is Required', '2024-04-04 04:37:10', '2024-04-04 04:37:10'),
(218, 'en', 'system_setting_has_been_updated', 'System Setting has been updated', '2024-04-04 04:37:10', '2024-04-04 04:37:10'),
(219, 'en', 'anonymous_messages', 'Anonymous Messages', '2024-04-04 04:37:16', '2024-04-04 04:37:16'),
(220, 'en', 'start_chating_by_select_a_user', 'Start chating by select a user', '2024-04-04 04:37:16', '2024-04-04 04:37:16'),
(221, 'en', 'please_enter_a_message', 'Please Enter a Message', '2024-04-04 04:37:16', '2024-04-04 04:37:16'),
(222, 'en', 'type_your_message', 'Type your message', '2024-04-04 04:37:16', '2024-04-04 04:37:16'),
(223, 'en', 'you_can_not_reply_to_this_conversations', 'You Can not reply to this conversations', '2024-04-04 04:37:16', '2024-04-04 04:37:16'),
(224, 'en', 'please_set_up_your_pusher_configuration_first', 'Please set up your Pusher configuration first!', '2024-04-04 04:37:16', '2024-04-04 04:37:16'),
(225, 'en', 'something_went_wrong_', 'Something went wrong !!', '2024-04-04 04:37:16', '2024-04-04 04:37:16'),
(226, 'en', 'validation_error', 'Validation Error', '2024-04-04 04:37:16', '2024-04-04 04:37:16'),
(227, 'en', 'chat_list', 'Chat list', '2024-04-04 04:37:17', '2024-04-04 04:37:17'),
(228, 'en', 'no_message_found', 'No Message Found', '2024-04-04 04:37:20', '2024-04-04 04:37:20'),
(229, 'en', 'assign', 'Assign', '2024-04-04 04:37:20', '2024-04-04 04:37:20'),
(230, 'en', 'manage_frontend_section', 'Manage frontend section', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(231, 'en', 'frontends', 'Frontends', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(232, 'en', 'section_list', 'Section List', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(233, 'en', 'search_here', 'Search Here', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(234, 'en', 'title', 'Title', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(235, 'en', 'type_here', 'Type Here', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(236, 'en', 'description', 'Description', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(237, 'en', 'banner_image', 'Banner image', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(238, 'en', 'sub_title', 'Sub title', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(239, 'en', 'btn_text', 'Btn text', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(240, 'en', 'btn_url', 'Btn url', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(241, 'en', 'text', 'Text', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(242, 'en', 'see_icon', 'See Icon', '2024-04-04 04:37:46', '2024-04-04 04:37:46'),
(243, 'en', 'update_system', 'Update System', '2024-04-04 04:37:55', '2024-04-04 04:37:55'),
(244, 'en', 'system_update', 'System Update', '2024-04-04 04:37:55', '2024-04-04 04:37:55'),
(245, 'en', 'update_application', 'Update Application', '2024-04-04 04:37:55', '2024-04-04 04:37:55'),
(246, 'en', 'current_version', 'Current Version', '2024-04-04 04:37:56', '2024-04-04 04:37:56'),
(247, 'en', 'v', 'V', '2024-04-04 04:37:56', '2024-04-04 04:37:56'),
(248, 'en', 'upload_zip_file', 'Upload Zip file', '2024-04-04 04:37:56', '2024-04-04 04:37:56'),
(249, 'en', 'update_now', 'Update Now', '2024-04-04 04:37:56', '2024-04-04 04:37:56'),
(250, 'en', 'file_field_is_required', 'File field is required', '2024-04-04 04:37:58', '2024-04-04 04:37:58'),
(251, 'en', 'support', 'Support', '2024-04-04 04:39:42', '2024-04-04 04:39:42'),
(252, 'en', 'search_your_question_', 'Search Your Question ....', '2024-04-04 04:39:42', '2024-04-04 04:39:42'),
(253, 'en', 'search', 'Search', '2024-04-04 04:39:42', '2024-04-04 04:39:42'),
(254, 'en', 'contact', 'Contact', '2024-04-04 04:39:42', '2024-04-04 04:39:42'),
(255, 'en', 'write_us', 'Write Us', '2024-04-04 04:39:42', '2024-04-04 04:39:42'),
(256, 'en', 'enter_your_name', 'Enter Your Name', '2024-04-04 04:39:42', '2024-04-04 04:39:42'),
(257, 'en', 'enter_your_subject', 'Enter Your Subject', '2024-04-04 04:39:42', '2024-04-04 04:39:42'),
(258, 'en', 'message', 'Message', '2024-04-04 04:39:42', '2024-04-04 04:39:42'),
(259, 'en', 'type_your_message_here_', 'Type Your Message Here.......... ', '2024-04-04 04:39:42', '2024-04-04 04:39:42'),
(260, 'en', 'email_us', 'Email us', '2024-04-04 04:39:42', '2024-04-04 04:39:42'),
(261, 'en', 'our_friendly_team_is_here_to_help', 'Our friendly team is here to help.', '2024-04-04 04:39:42', '2024-04-04 04:39:42'),
(262, 'en', 'call_to_us', 'Call to us', '2024-04-04 04:39:43', '2024-04-04 04:39:43'),
(263, 'en', 'monfri_from_10am_to_6pm', 'Mon-Fri From 10am to 6pm', '2024-04-04 04:39:43', '2024-04-04 04:39:43'),
(264, 'en', 'visit_us', 'Visit us', '2024-04-04 04:39:43', '2024-04-04 04:39:43'),
(265, 'en', 'come_say_hello_at_our_office_hq', 'Come say hello at our office HQ', '2024-04-04 04:39:43', '2024-04-04 04:39:43'),
(266, 'en', 'create_ticket_here', 'Create Ticket Here', '2024-04-04 04:39:50', '2024-04-04 04:39:50'),
(267, 'en', 'files', 'files', '2024-04-04 04:39:50', '2024-04-04 04:39:50'),
(268, 'en', 'create', 'Create', '2024-04-04 04:39:50', '2024-04-04 04:39:50'),
(269, 'en', 'enter_email', 'Enter Email', '2024-04-04 04:39:50', '2024-04-04 04:39:50'),
(270, 'en', 'start', 'Start', '2024-04-04 04:39:50', '2024-04-04 04:39:50'),
(271, 'en', 'type__hit_enter', 'Type & hit enter', '2024-04-04 04:39:50', '2024-04-04 04:39:50'),
(272, 'en', 'pusher_configuration_error', 'Pusher configuration Error!!', '2024-04-04 04:39:50', '2024-04-04 04:39:50'),
(273, 'en', 'manage_language', 'Manage language', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(274, 'en', 'language', 'Language', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(275, 'en', 'language_list', 'Language List', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(276, 'en', 'add_new_language', 'Add New Language', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(277, 'en', 'code', 'Code', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(278, 'en', 'options', 'Options', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(279, 'en', 'make_default', 'Make Default', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(280, 'en', 'default', 'Default', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(281, 'en', 'add_language', 'Add Language', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(282, 'en', 'add', 'Add', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(283, 'en', 'are_you_sure_', 'Are you sure ?', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(284, 'en', 'are_you_sure_you_want_to____________________________remove_this_record_', 'Are you sure you want to                            remove this record ?', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(285, 'en', 'yes_delete_it', 'Yes, Delete It!', '2024-04-04 04:40:19', '2024-04-04 04:40:19'),
(286, 'en', 'system_information', 'System Information', '2024-04-04 04:40:22', '2024-04-04 04:40:22'),
(287, 'en', 'server_information', 'Server information', '2024-04-04 04:40:22', '2024-04-04 04:40:22'),
(288, 'en', 'value', 'Value', '2024-04-04 04:40:22', '2024-04-04 04:40:22'),
(289, 'en', 'php_versions', 'PHP versions', '2024-04-04 04:40:22', '2024-04-04 04:40:22'),
(290, 'en', 'laravel_versions', 'Laravel versions', '2024-04-04 04:40:22', '2024-04-04 04:40:22'),
(291, 'en', 'http_host', 'HTTP host', '2024-04-04 04:40:22', '2024-04-04 04:40:22'),
(292, 'en', 'phpini_config', 'php.ini Config', '2024-04-04 04:40:22', '2024-04-04 04:40:22'),
(293, 'en', 'config_name', 'Config Name', '2024-04-04 04:40:22', '2024-04-04 04:40:22'),
(294, 'en', 'current', 'Current', '2024-04-04 04:40:22', '2024-04-04 04:40:22'),
(295, 'en', 'recommended', 'Recommended', '2024-04-04 04:40:22', '2024-04-04 04:40:22'),
(296, 'en', 'file_uploads', 'File uploads', '2024-04-04 04:40:22', '2024-04-04 04:40:22'),
(297, 'en', 'on', 'On', '2024-04-04 04:40:23', '2024-04-04 04:40:23'),
(298, 'en', 'max_file_uploads', 'Max File Uploads', '2024-04-04 04:40:23', '2024-04-04 04:40:23'),
(299, 'en', 'allow_url_fopen', 'Allow url Fopen', '2024-04-04 04:40:23', '2024-04-04 04:40:23'),
(300, 'en', 'max_execution_time', 'Max Execution time', '2024-04-04 04:40:23', '2024-04-04 04:40:23'),
(301, 'en', 'max_input_time', 'Max Input time', '2024-04-04 04:40:23', '2024-04-04 04:40:23'),
(302, 'en', 'max_input_vars', 'Max Input vars', '2024-04-04 04:40:23', '2024-04-04 04:40:23'),
(303, 'en', 'memory_limit', 'Memory limit', '2024-04-04 04:40:23', '2024-04-04 04:40:23'),
(304, 'en', 'unlimited', 'Unlimited', '2024-04-04 04:40:23', '2024-04-04 04:40:23'),
(305, 'en', 'extensions', 'Extensions', '2024-04-04 04:40:23', '2024-04-04 04:40:23'),
(306, 'en', 'extension_name', 'Extension Name', '2024-04-04 04:40:23', '2024-04-04 04:40:23'),
(307, 'en', 'file__folder_permissions', 'File & Folder Permissions', '2024-04-04 04:40:23', '2024-04-04 04:40:23'),
(308, 'en', 'file_or_folder', 'File or Folder', '2024-04-04 04:40:23', '2024-04-04 04:40:23'),
(309, 'en', 'manage_ip', 'Manage Ip', '2024-04-04 04:40:29', '2024-04-04 04:40:29'),
(310, 'en', 'ip_list', 'Ip List', '2024-04-04 04:40:29', '2024-04-04 04:40:29'),
(311, 'en', 'filter_by_ip', 'Filter by ip', '2024-04-04 04:40:29', '2024-04-04 04:40:29'),
(312, 'en', 'filter', 'Filter', '2024-04-04 04:40:29', '2024-04-04 04:40:29'),
(313, 'en', 'reset', 'Reset', '2024-04-04 04:40:29', '2024-04-04 04:40:29'),
(314, 'en', 'ip', 'Ip', '2024-04-04 04:40:29', '2024-04-04 04:40:29'),
(315, 'en', 'blocked', 'Blocked', '2024-04-04 04:40:29', '2024-04-04 04:40:29'),
(316, 'en', 'last_visited', 'Last Visited', '2024-04-04 04:40:29', '2024-04-04 04:40:29'),
(317, 'en', 'add_ip', 'Add Ip', '2024-04-04 04:40:29', '2024-04-04 04:40:29'),
(318, 'en', 'ip_address', 'Ip Address', '2024-04-04 04:40:29', '2024-04-04 04:40:29'),
(319, 'en', 'enter_ip', 'Enter ip', '2024-04-04 04:40:29', '2024-04-04 04:40:29'),
(320, 'en', 'visistor_agent_info', 'Visistor Agent Info', '2024-04-04 04:40:29', '2024-04-04 04:40:29'),
(321, 'en', 'dos_security_settings', 'Dos Security Settings', '2024-04-04 04:40:32', '2024-04-04 04:40:32'),
(322, 'en', 'prevent_dos_attack', 'Prevent Dos Attack', '2024-04-04 04:40:32', '2024-04-04 04:40:32'),
(323, 'en', 'if_there_are_more_than', 'If there are more than', '2024-04-04 04:40:32', '2024-04-04 04:40:32'),
(324, 'en', 'attempts_in', 'attempts in', '2024-04-04 04:40:32', '2024-04-04 04:40:32'),
(325, 'en', 'second', 'second', '2024-04-04 04:40:32', '2024-04-04 04:40:32'),
(326, 'en', 'show_captcha', 'Show Captcha', '2024-04-04 04:40:32', '2024-04-04 04:40:32'),
(327, 'en', 'block_ip', 'Block Ip', '2024-04-04 04:40:32', '2024-04-04 04:40:32'),
(328, 'en', 'plugin_setting_has_been_updated', 'Plugin Setting has been updated', '2024-04-04 04:40:48', '2024-04-04 04:40:48'),
(329, 'en', 'chat_gpt_settings', 'Chat Gpt Settings', '2024-04-04 04:40:50', '2024-04-04 04:40:50'),
(330, 'en', 'open_ai_api_key', 'Open AI Api Key', '2024-04-04 04:40:50', '2024-04-04 04:40:50'),
(331, 'en', 'api_key', 'Api Key', '2024-04-04 04:40:51', '2024-04-04 04:40:51'),
(332, 'en', 'inbox', 'Inbox', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(333, 'en', 'tags', 'Tags', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(334, 'en', 'export', 'Export', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(335, 'en', 'export_as_pdf', 'Export As Pdf', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(336, 'en', 'export_as_csv', 'Export As Csv', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(337, 'en', 'select_status', 'Select status', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(338, 'en', 'select_priority', 'Select Priority', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(339, 'en', 'search_by_date', 'Search By Date', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(340, 'en', 'search_by_name_or_ticket_number', 'Search By Name, or Ticket Number', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(341, 'en', 'make_mine', 'Make Mine', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(342, 'en', 'mark_as_', 'Mark as ', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(343, 'en', 'are_you_sure_you_want_to________________________________remove_this_record_', 'Are you sure you want to                                remove this record ?', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(344, 'en', 'respone__resolve_time', 'Respone & Resolve Time', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(345, 'en', 'ticket_list', 'Ticket List', '2024-04-04 04:41:35', '2024-04-04 04:41:35'),
(346, 'en', 'user', 'User', '2024-04-04 04:41:38', '2024-04-04 04:41:38'),
(347, 'en', 'last_reply', 'Last reply', '2024-04-04 04:41:38', '2024-04-04 04:41:38'),
(348, 'en', 'assign_to', 'Assign to', '2024-04-04 04:41:38', '2024-04-04 04:41:38'),
(349, 'en', 'priority', 'Priority', '2024-04-04 04:41:38', '2024-04-04 04:41:38'),
(350, 'en', 'action', 'Action', '2024-04-04 04:41:38', '2024-04-04 04:41:38'),
(351, 'en', 'mine', 'Mine', '2024-04-04 04:41:38', '2024-04-04 04:41:38'),
(352, 'en', 'assigned', 'Assigned', '2024-04-04 04:41:38', '2024-04-04 04:41:38'),
(353, 'en', 'unassigned', 'Unassigned', '2024-04-04 04:41:38', '2024-04-04 04:41:38'),
(354, 'en', 'department', 'Department', '2024-04-04 04:41:38', '2024-04-04 04:41:38'),
(355, 'en', 'manage_knowledgebase', 'Manage Knowledgebase', '2024-04-04 04:41:59', '2024-04-04 04:41:59'),
(356, 'en', 'no_department_found', 'No department found', '2024-04-04 04:41:59', '2024-04-04 04:41:59'),
(357, 'en', 'see_all_department', 'See all department', '2024-04-04 04:41:59', '2024-04-04 04:41:59'),
(358, 'en', 'plese_select_a_department_first', 'Plese select a department first', '2024-04-04 04:41:59', '2024-04-04 04:41:59'),
(359, 'en', 'search_here_', 'Search Here !!', '2024-04-04 04:41:59', '2024-04-04 04:41:59'),
(360, 'en', 'department_list', 'Department List', '2024-04-04 04:42:02', '2024-04-04 04:42:02'),
(361, 'en', 'add_department', 'Add Department', '2024-04-04 04:42:02', '2024-04-04 04:42:02'),
(362, 'en', 'enter_name', 'Enter name', '2024-04-04 04:42:02', '2024-04-04 04:42:02'),
(363, 'en', 'image', 'Image', '2024-04-04 04:42:03', '2024-04-04 04:42:03'),
(364, 'en', 'manage_departments', 'Manage Departments', '2024-04-04 04:42:03', '2024-04-04 04:42:03'),
(365, 'en', 'menu_list', 'Menu List', '2024-04-04 04:42:17', '2024-04-04 04:42:17'),
(366, 'en', 'add_new_menu', 'Add New Menu', '2024-04-04 04:42:17', '2024-04-04 04:42:17'),
(367, 'en', 'url', 'URL', '2024-04-04 04:42:17', '2024-04-04 04:42:17'),
(368, 'en', 'add_menu', 'Add Menu', '2024-04-04 04:42:17', '2024-04-04 04:42:17'),
(369, 'en', 'serial_id', 'Serial Id', '2024-04-04 04:42:17', '2024-04-04 04:42:17'),
(370, 'en', 'enter_serial_id', 'Enter Serial Id', '2024-04-04 04:42:17', '2024-04-04 04:42:17'),
(371, 'en', 'enter_url', 'Enter Url', '2024-04-04 04:42:17', '2024-04-04 04:42:17'),
(372, 'en', 'header', 'Header', '2024-04-04 04:42:17', '2024-04-04 04:42:17'),
(373, 'en', 'footer', 'Footer', '2024-04-04 04:42:17', '2024-04-04 04:42:17'),
(374, 'en', 'update_menu', 'Update Menu', '2024-04-04 04:42:17', '2024-04-04 04:42:17'),
(375, 'en', 'name_field_is_required', 'Name Field Is Required', '2024-04-04 04:42:36', '2024-04-04 04:42:36'),
(376, 'en', 'name_field_must_be_unique', 'Name Field Must Be Unique', '2024-04-04 04:42:36', '2024-04-04 04:42:36'),
(377, 'en', 'menu_url_is_required', 'Menu Url Is Required', '2024-04-04 04:42:36', '2024-04-04 04:42:36'),
(378, 'en', 'serial_is_required', 'Serial Is Required', '2024-04-04 04:42:36', '2024-04-04 04:42:36'),
(379, 'en', 'menu_created_successfully', 'Menu Created Successfully', '2024-04-04 04:42:36', '2024-04-04 04:42:36'),
(380, 'en', 'how_can_we_help', 'How can we help', '2024-04-04 04:42:42', '2024-04-04 04:42:42'),
(381, 'en', 'browse_by_departments', 'Browse by departments', '2024-04-04 04:42:42', '2024-04-04 04:42:42'),
(382, 'en', 'please_select_a_department_first', 'Please select a department first', '2024-04-04 04:42:42', '2024-04-04 04:42:42'),
(383, 'en', 'ticket_configurations', 'Ticket Configurations', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(384, 'en', 'settings', 'Settings', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(385, 'en', 'field_settings', 'Field Settings', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(386, 'en', 'operating_hour', 'Operating Hour', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(387, 'en', 'ticket_settings', 'Ticket Settings', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(388, 'en', 'enabling_this_option_will_activate_email_to_ticket_feature', 'Enabling this option will activate Email to ticket feature', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(389, 'en', 'enable', 'Enable', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(390, 'en', 'disable', 'Disable', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(391, 'en', 'enable_ticket_department', 'Enable ticket department', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(392, 'en', 'enabling_this_option_will_activate_ticket_department_selection_during_ticket_create', 'Enabling this option will activate ticket department selection during ticket create', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(393, 'en', 'agent_name_privacy', 'Agent name privacy', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(394, 'en', 'enabling_this_option_will_activated_agent_name_privacy_in_user_reply_section_user_will_not_able_to_see_who_replied', 'Enabling this option will activated agent name privacy in user reply section. user will not able to see who replied', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(395, 'en', 'message_seen_status', 'Message seen status', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(396, 'en', 'by_enabling_this_option_users_will_be_able_to_see_whether_their_messages_have_been_seen_by_an_agent_or_not', 'By enabling this option, users will be able to see whether their messages have been seen by an agent or not', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(397, 'en', 'user_ticket_close', 'User ticket close', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(398, 'en', 'enabling_this_option_will_allow_user_to_close_their_ticket', 'Enabling this option will allow user to close their ticket', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(399, 'en', 'ticket_prefix', 'Ticket Prefix', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(400, 'en', 'ticket_suffix', 'Ticket Suffix', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(401, 'en', 'random_number', 'Random Number', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(402, 'en', 'incremental', 'Incremental', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(403, 'en', 'guest_ticket', 'Guest Ticket', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(404, 'en', 'custom_files', 'Custom files', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(405, 'en', 'in_ticket_reply', 'In Ticket Reply', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(406, 'en', 'ticket_view_otp', 'Ticket View OTP', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(407, 'en', 'enabling_this_option_will_activate_the_otp_system_for_ticket_view', 'Enabling this option will activate the OTP system for ticket View', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(408, 'en', 'user_ticket_delete', 'User Ticket Delete', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(409, 'en', 'enabling_this_option_will_allow_user_to_delete_ticket_', 'Enabling this option will allow user to delete ticket ', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(410, 'en', 'auto_close_ticket', 'Auto Close Ticket', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(411, 'en', 'ticket_with_the_status', 'Ticket With the status', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(412, 'en', 'will_be_automatically_closed_if_there_is_no_response_from_the_user_within', 'will be automatically closed if there is no response from the user within', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(413, 'en', 'days', 'Days', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(414, 'en', 'duplicate_ticket_prevent', 'Duplicate ticket Prevent', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(415, 'en', 'user_cant_create_multiple_tickets_with_the_same_category_if_status_is_', 'User Can\'t create multiple tickets with the same category if status is ', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(416, 'en', 'field_configuration', 'Field Configuration', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(417, 'en', 'add_more', 'Add More', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(418, 'en', 'labels', 'Labels', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(419, 'en', 'type', 'Type', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(420, 'en', 'width', 'Width', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(421, 'en', 'mandatoryrequired', 'Mandatory/Required', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(422, 'en', 'visibility', 'Visibility', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(423, 'en', 'placeholder', 'Placeholder', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(424, 'en', 'visible', 'Visible', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(425, 'en', 'hidden', 'Hidden', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(426, 'en', 'na', 'N/A', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(427, 'en', 'ticket_short_notes', 'Ticket Short Notes', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(428, 'en', 'operating_hours', 'Operating Hours', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(429, 'en', 'enable_business_hours', 'Enable business hours', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(430, 'en', 'start_time', 'Start time', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(431, 'en', 'end_time', 'End time', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(432, 'en', 'select_time', 'Select time', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(433, 'en', 'select_end_time', 'Select end time', '2024-04-04 04:42:54', '2024-04-04 04:42:54'),
(434, 'en', 'status_updated_successfully', 'Status Updated Successfully', '2024-04-04 04:43:27', '2024-04-04 04:43:27'),
(435, 'en', 'support_agent', 'Support agent', '2024-04-04 04:43:34', '2024-04-04 04:43:34'),
(436, 'en', 'offline', 'Offline', '2024-04-04 04:43:34', '2024-04-04 04:43:34'),
(437, 'en', 'our_technical_team_is_available_in_the', 'Our technical team is available in the', '2024-04-04 04:43:34', '2024-04-04 04:43:34'),
(438, 'en', 'timezone', 'timezone', '2024-04-04 04:43:34', '2024-04-04 04:43:34'),
(439, 'en', 'please_select_end_time', 'Please select end time', '2024-04-04 04:43:46', '2024-04-04 04:43:46'),
(440, 'en', 'please_select_start_time', 'Please select start time', '2024-04-04 04:43:46', '2024-04-04 04:43:46'),
(441, 'en', 'setting_has_been_updated', 'Setting has been updated', '2024-04-04 04:43:46', '2024-04-04 04:43:46'),
(442, 'en', 'closed', 'Closed', '2024-04-04 04:44:16', '2024-04-04 04:44:16'),
(443, 'en', 'manange_triggering', 'Manange Triggering', '2024-04-04 04:45:37', '2024-04-04 04:45:37'),
(444, 'en', 'triggers', 'Triggers', '2024-04-04 04:45:37', '2024-04-04 04:45:37'),
(445, 'en', 'trigger_list', 'Trigger List', '2024-04-04 04:45:37', '2024-04-04 04:45:37'),
(446, 'en', 'times_used', 'Times Used', '2024-04-04 04:45:37', '2024-04-04 04:45:37'),
(447, 'en', 'last_action', 'Last Action', '2024-04-04 04:45:37', '2024-04-04 04:45:37'),
(448, 'en', 'ticket_statuses', 'Ticket Statuses', '2024-04-04 04:45:40', '2024-04-04 04:45:40'),
(449, 'en', 'ticket_status_list', 'Ticket Status List', '2024-04-04 04:45:40', '2024-04-04 04:45:40'),
(450, 'en', 'products', 'Products', '2024-05-04 12:38:37', '2024-05-04 12:38:37'),
(451, 'en', 'configuration', 'Configuration', '2024-05-04 12:38:37', '2024-05-04 12:38:37'),
(452, 'en', 'enable_ticket_product', 'Enable ticket product', '2024-05-04 12:38:49', '2024-05-04 12:38:49'),
(453, 'en', 'enabling_this_option_will_activate_ticket_product_selection_during_ticket_create', 'Enabling this option will activate ticket product selection during ticket create', '2024-05-04 12:38:49', '2024-05-04 12:38:49'),
(454, 'en', 'user_ticket_reopen', 'User ticket re-open', '2024-05-04 12:38:49', '2024-05-04 12:38:49'),
(455, 'en', 'enabling_this_option_will_allow_user_to_reopen_their_cloesed_ticket', 'Enabling this option will allow user to re-open their cloesed ticket', '2024-05-04 12:38:49', '2024-05-04 12:38:49'),
(456, 'en', 'incoming_email_gateways', 'Incoming Email Gateways', '2024-05-04 12:38:55', '2024-05-04 12:38:55'),
(457, 'en', 'create_gateway', 'Create Gateway', '2024-05-04 12:38:55', '2024-05-04 12:38:55'),
(458, 'en', 'must_be_unique', 'Must be unique', '2024-05-04 12:38:55', '2024-05-04 12:38:55'),
(459, 'en', 'product', 'Product', '2024-05-04 12:38:55', '2024-05-04 12:38:55'),
(460, 'en', 'seletct_product', 'Seletct product', '2024-05-04 12:38:55', '2024-05-04 12:38:55'),
(461, 'en', 'gateways', 'Gateways', '2024-05-04 12:38:55', '2024-05-04 12:38:55'),
(462, 'en', 'you_can_reach_our_technical_team_during_hours_aligned_with_the_', 'You can reach our technical team during hours aligned with the ', '2024-05-21 07:39:15', '2024-05-21 07:39:15'),
(463, 'en', 'start__end_time', 'Start & End time', '2024-05-21 09:06:12', '2024-05-21 09:06:12'),
(464, 'en', '24_hour', '24 Hour', '2024-05-21 09:16:24', '2024-05-21 09:16:24'),
(465, 'en', 'online', 'Online', '2024-05-21 09:18:15', '2024-05-21 09:18:15'),
(466, 'en', 'operating_hours_note', 'Operating Hours Note', '2024-05-21 09:27:12', '2024-05-21 09:27:12'),
(467, 'en', 'notification_variables', 'Notification variables', '2024-05-21 09:27:31', '2024-05-21 09:27:31'),
(468, 'en', 'order_variable', 'Order Variable', '2024-05-21 09:28:00', '2024-05-21 09:28:00'),
(469, 'en', 'item_variable', 'Item Variable', '2024-05-21 09:28:15', '2024-05-21 09:28:15'),
(470, 'en', 'sms__email', 'SMS & Email', '2024-05-21 09:28:36', '2024-05-21 09:28:36'),
(471, 'en', 'whatsapp', 'WhatsApp', '2024-05-21 09:28:36', '2024-05-21 09:28:36'),
(472, 'en', 'sms_message', 'SMS Message', '2024-05-21 09:28:51', '2024-05-21 09:28:51'),
(473, 'en', 'enter_message', 'Enter message', '2024-05-21 09:28:51', '2024-05-21 09:28:51'),
(474, 'en', 'email_message', 'Email Message', '2024-05-21 09:28:51', '2024-05-21 09:28:51'),
(475, 'en', 'templates', 'Templates', '2024-05-21 09:29:08', '2024-05-21 09:29:08'),
(476, 'en', 'template', 'Template', '2024-05-21 09:29:08', '2024-05-21 09:29:08'),
(477, 'en', 'load_template', 'Load template', '2024-05-21 09:29:08', '2024-05-21 09:29:08'),
(478, 'en', 'select_a_template', 'Select a template', '2024-05-21 09:29:25', '2024-05-21 09:29:25'),
(479, 'en', 'note', 'Note', '2024-05-21 09:32:05', '2024-05-21 09:32:05'),
(480, 'en', 'select_audience', 'Select Audience', '2024-05-21 09:32:47', '2024-05-21 09:32:47'),
(481, 'en', 'instaction_note', 'Instaction Note', '2024-05-21 09:32:47', '2024-05-21 09:32:47'),
(482, 'en', 'select_product', 'Select product', '2024-05-21 09:32:47', '2024-05-21 09:32:47'),
(483, 'en', 'variables', 'Variables', '2024-05-21 09:39:00', '2024-05-21 09:39:00'),
(484, 'en', 'global_email_template', 'Global Email Template', '2024-05-21 09:39:21', '2024-05-21 09:39:21'),
(485, 'en', 'email_template_short_code', 'Email Template Short Code', '2024-05-21 09:39:21', '2024-05-21 09:39:21'),
(486, 'en', 'sent_from_email', 'Sent From Email', '2024-05-21 09:39:21', '2024-05-21 09:39:21'),
(487, 'en', 'email_template', 'Email Template', '2024-05-21 09:39:21', '2024-05-21 09:39:21'),
(488, 'en', 'mail_template_short_code', 'Mail Template Short Code', '2024-05-21 09:39:21', '2024-05-21 09:39:21'),
(489, 'en', 'mail_body', 'Mail Body', '2024-05-21 09:39:21', '2024-05-21 09:39:21'),
(490, 'en', 'system_timezone', 'System timezone', '2024-05-21 09:42:45', '2024-05-21 09:42:45'),
(491, 'en', 'enter_note', 'Enter note', '2024-05-21 09:49:07', '2024-05-21 09:49:07'),
(492, 'en', 'envato_configuration', 'Envato Configuration', '2024-09-17 09:23:17', '2024-09-17 09:23:17'),
(493, 'en', 'label', 'Label', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(494, 'en', 'drag_the_card_in_any_section', 'Drag the card in any section', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(495, 'en', 'mandatory', 'Mandatory', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(496, 'en', 'add_more_input_field', 'Add More Input Field', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(497, 'en', 'set_a_label', 'Set a Label', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(498, 'en', 'select_type', 'Select Type', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(499, 'en', 'yes', 'Yes', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(500, 'en', 'no', 'No', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(501, 'en', 'set_a_placeholder_for_this_new_input_field', 'Set a placeholder for this new input field', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(502, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(503, 'en', 'update_input_field', 'Update Input Field', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(504, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(505, 'en', 'option_value', 'Option Value', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(506, 'en', 'display_name', 'Display Name', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(507, 'en', 'multiple_seclect', 'Multiple Seclect', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(508, 'en', 'single_select', 'Single Select', '2024-09-17 09:23:22', '2024-09-17 09:23:22'),
(509, 'en', 'option_display_name', 'Option display name', '2024-09-17 09:23:22', '2024-09-17 09:23:22');
INSERT INTO `translations` (`id`, `code`, `key`, `value`, `created_at`, `updated_at`) VALUES
(510, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-09-17 09:23:37', '2024-09-17 09:23:37'),
(511, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-09-17 09:23:37', '2024-09-17 09:23:37'),
(512, 'en', 'envato_business_configuration', 'Envato Business Configuration', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(513, 'en', 'save__sync', 'Save & Sync', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(514, 'en', 'envato_settings', 'Envato Settings', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(515, 'en', 'envato_verifications', 'Envato verifications', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(516, 'en', 'enabling_this_option_will_activate_envato_verification_during_ticket_creation_if_the_product_is_synced_from_envato', 'Enabling this option will activate Envato verification during ticket creation if the product is synced from Envato.', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(517, 'en', 'enable_support_duration_verification', 'Enable support duration verification', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(518, 'en', 'enabling_this_option_will_activate_validation_of_the_envato_product_support_duration_during_ticket_creation', 'Enabling this option will activate validation of the Envato product support duration during ticket creation', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(519, 'en', 'ticket_status_is_', 'Ticket status is ', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(520, 'en', 'if_the_envato_support_is_expired', 'if the envato support is expired', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(521, 'en', 'envatio_support_expired_mail', 'Envatio support expired mail', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(522, 'en', 'this_email_will_be_sent_when_a_clients_envato_support_has_expired', 'This email will be sent when a clients Envato support has expired', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(523, 'en', 'are_you_sure', 'Are you sure?', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(524, 'en', 'this_will_reset_any_previous_item_changes_of_this_author', 'This will reset any previous item changes of this Author', '2024-09-17 09:23:53', '2024-09-17 09:23:53'),
(525, 'en', 'log_into_your_account', 'Log Into Your Account', '2024-09-17 09:25:58', '2024-09-17 09:25:58'),
(526, 'en', 'were_glad_to_see_you_again', 'We\'re glad to see you again!', '2024-09-17 09:25:58', '2024-09-17 09:25:58'),
(527, 'en', 'enter_captcha_value', 'Enter captcha value', '2024-09-17 09:25:59', '2024-09-17 09:25:59'),
(528, 'en', 'dont_have_an_account', 'Don\'t have an account', '2024-09-17 09:25:59', '2024-09-17 09:25:59'),
(529, 'en', 'create_new', 'Create New', '2024-09-17 09:25:59', '2024-09-17 09:25:59'),
(530, 'en', 'user_login', 'User Login', '2024-09-17 09:25:59', '2024-09-17 09:25:59'),
(531, 'en', 'assign_ticket_with_sort_notes', 'Assign Ticket With Sort Notes', '2024-12-19 18:33:04', '2024-12-19 18:33:04'),
(532, 'en', 'me', 'Me', '2024-12-19 18:33:04', '2024-12-19 18:33:04'),
(533, 'en', 'write_short_note_here', 'Write Short Note Here', '2024-12-19 18:33:04', '2024-12-19 18:33:04'),
(534, 'en', 'source', 'Source', '2024-12-19 18:33:06', '2024-12-19 18:33:06'),
(535, 'en', 'manage_agent', 'Manage Agent', '2024-12-19 18:33:45', '2024-12-19 18:33:45'),
(536, 'en', 'agents', 'Agents', '2024-12-19 18:33:45', '2024-12-19 18:33:45'),
(537, 'en', 'add_new_agent', 'Add New Agent', '2024-12-19 18:33:45', '2024-12-19 18:33:45'),
(538, 'en', 'avg_response_time__responsed_tickets', 'Avg Response Time - Responsed Tickets', '2024-12-19 18:33:45', '2024-12-19 18:33:45'),
(539, 'en', 'best_agent', 'Best Agent', '2024-12-19 18:33:45', '2024-12-19 18:33:45'),
(540, 'en', 'update_password', 'Update password', '2024-12-19 18:33:45', '2024-12-19 18:33:45'),
(541, 'en', 'minimum_5_character_required', 'Minimum 5 Character Required!!', '2024-12-19 18:33:45', '2024-12-19 18:33:45'),
(542, 'en', 'confirm_password', 'Confirm Password', '2024-12-19 18:33:45', '2024-12-19 18:33:45'),
(543, 'en', 'create__agent', 'Create  Agent', '2024-12-19 18:33:50', '2024-12-19 18:33:50'),
(544, 'en', 'create_agent', 'Create Agent', '2024-12-19 18:33:50', '2024-12-19 18:33:50'),
(545, 'en', 'agent', 'Agent', '2024-12-19 18:33:50', '2024-12-19 18:33:50'),
(546, 'en', 'super_agent', 'Super agent', '2024-12-19 18:33:50', '2024-12-19 18:33:50'),
(547, 'en', 'examplegamilcom', 'example@gamil.com', '2024-12-19 18:33:50', '2024-12-19 18:33:50'),
(548, 'en', 'enter_phone_number', 'Enter Phone Number', '2024-12-19 18:33:50', '2024-12-19 18:33:50'),
(549, 'en', 'access_categories', 'Access Categories', '2024-12-19 18:33:50', '2024-12-19 18:33:50'),
(550, 'en', 'permissions', 'Permissions', '2024-12-19 18:33:50', '2024-12-19 18:33:50'),
(551, 'en', 'email_field_is_required', 'Email Field is Required', '2024-12-19 18:35:49', '2024-12-19 18:35:49'),
(552, 'en', 'this_email_is_already_taken', 'This email is already taken', '2024-12-19 18:35:49', '2024-12-19 18:35:49'),
(553, 'en', 'user_name_field_is_required', 'User Name Field Is Required', '2024-12-19 18:35:49', '2024-12-19 18:35:49'),
(554, 'en', 'this_username_is_already_taken', 'This username is already taken', '2024-12-19 18:35:49', '2024-12-19 18:35:49'),
(555, 'en', 'phone_field_is_required', 'Phone Field Is Required', '2024-12-19 18:35:49', '2024-12-19 18:35:49'),
(556, 'en', 'please_select_a_category', 'Please Select a Category', '2024-12-19 18:35:49', '2024-12-19 18:35:49'),
(557, 'en', 'permission_is_required', 'Permission Is Required', '2024-12-19 18:35:49', '2024-12-19 18:35:49'),
(558, 'en', 'please_select_an_status', 'Please Select An Status', '2024-12-19 18:35:49', '2024-12-19 18:35:49'),
(559, 'en', 'password_feild_is_required', 'Password Feild Is Required', '2024-12-19 18:35:49', '2024-12-19 18:35:49'),
(560, 'en', 'confirm_password_does_not_match', 'Confirm Password Does not Match', '2024-12-19 18:35:49', '2024-12-19 18:35:49'),
(561, 'en', 'minimum_5_digit_or_character_is_required', 'Minimum 5 digit or character is required', '2024-12-19 18:35:49', '2024-12-19 18:35:49'),
(562, 'en', 'select_your_address', 'Select Your Address', '2024-12-19 18:35:49', '2024-12-19 18:35:49'),
(563, 'en', 'agent_creted_successfully', 'Agent Creted Successfully', '2024-12-19 18:35:50', '2024-12-19 18:35:50'),
(564, 'en', 'create__user', 'Create  User', '2024-12-19 18:36:05', '2024-12-19 18:36:05'),
(565, 'en', 'users', 'Users', '2024-12-19 18:36:05', '2024-12-19 18:36:05'),
(566, 'en', 'create_user', 'Create User', '2024-12-19 18:36:05', '2024-12-19 18:36:05'),
(567, 'en', 'user_name_feild_is_required', 'User Name Feild Is Required', '2024-12-19 18:36:29', '2024-12-19 18:36:29'),
(568, 'en', 'email_feild_is_required', 'Email Feild Is Required', '2024-12-19 18:36:29', '2024-12-19 18:36:29'),
(569, 'en', 'email_feild_must_be_unique', 'Email Feild Must Be Unique', '2024-12-19 18:36:29', '2024-12-19 18:36:29'),
(570, 'en', 'phone_feild_is_required', 'Phone Feild Is Required', '2024-12-19 18:36:29', '2024-12-19 18:36:29'),
(571, 'en', 'phone_feild_must_be_unique', 'Phone Feild Must Be Unique', '2024-12-19 18:36:29', '2024-12-19 18:36:29'),
(572, 'en', 'please_select_a_status', 'Please Select A Status', '2024-12-19 18:36:29', '2024-12-19 18:36:29'),
(573, 'en', 'user_created_successfully', 'User Created Successfully', '2024-12-19 18:36:30', '2024-12-19 18:36:30'),
(574, 'en', 'manage_users', 'Manage Users', '2024-12-19 18:36:38', '2024-12-19 18:36:38'),
(575, 'en', 'add_new_user', 'Add New User', '2024-12-19 18:36:38', '2024-12-19 18:36:38'),
(576, 'en', 'user_not_found', 'User Not Found', '2024-12-19 18:36:54', '2024-12-19 18:36:54'),
(577, 'en', 'successfully_login_as_a_user', 'SuccessFully Login As a User', '2024-12-19 18:36:54', '2024-12-19 18:36:54'),
(578, 'en', 'last_activity', 'Last Activity', '2024-12-19 18:36:57', '2024-12-19 18:36:57'),
(579, 'en', 'ticket_by_month', 'Ticket By Month', '2024-12-19 18:36:57', '2024-12-19 18:36:57'),
(580, 'en', 'user_dashboard', 'User dashboard', '2024-12-19 18:36:57', '2024-12-19 18:36:57'),
(581, 'en', 'chat', 'Chat', '2024-12-19 18:36:58', '2024-12-19 18:36:58'),
(582, 'en', 'manage_ticket', 'Manage Ticket', '2024-12-19 18:36:58', '2024-12-19 18:36:58'),
(583, 'en', 'canned_reply', 'Canned Reply', '2024-12-19 18:36:58', '2024-12-19 18:36:58'),
(584, 'en', 'accept_our_cookie', 'Accept Our Cookie', '2024-12-19 18:37:11', '2024-12-19 18:37:11'),
(585, 'en', 'accept__continue', 'Accept & Continue', '2024-12-19 18:37:11', '2024-12-19 18:37:11'),
(586, 'en', 'monday', 'Monday', '2024-12-19 18:37:27', '2024-12-19 18:37:27'),
(587, 'en', 'tuesday', 'Tuesday', '2024-12-19 18:37:27', '2024-12-19 18:37:27'),
(588, 'en', 'wednesday', 'Wednesday', '2024-12-19 18:37:27', '2024-12-19 18:37:27'),
(589, 'en', 'thursday', 'Thursday', '2024-12-19 18:37:27', '2024-12-19 18:37:27'),
(590, 'en', 'friday', 'Friday', '2024-12-19 18:37:27', '2024-12-19 18:37:27'),
(591, 'en', 'saturday', 'Saturday', '2024-12-19 18:37:27', '2024-12-19 18:37:27'),
(592, 'en', '', '', '2024-12-19 18:37:27', '2024-12-19 18:37:27'),
(593, 'en', 'manage_notifications', 'Manage Notifications', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(594, 'en', 'notifications_settings', 'Notifications Settings', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(595, 'en', 'notify_me_when', 'Notify me when', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(596, 'en', 'sms', 'Sms', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(597, 'en', 'browser', 'Browser', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(598, 'en', 'slack', 'Slack', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(599, 'en', 'there_is_a_new_ticketconversation', 'There is a New Ticket/Conversation', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(600, 'en', 'notify_me_when_agent', 'Notify me when Agent', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(601, 'en', 'replied_to_a_conversations', 'Replied To A Conversations', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(602, 'en', 'assign_a_ticket_to_', 'Assign a Ticket To ', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(603, 'en', 'notify_me_when_customer', 'Notify me when Customer', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(604, 'en', 'replied_to_on_of_my_conversations', 'Replied To On Of My Conversations', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(605, 'en', 'start_a_new_chat_message_with_me', 'Start A New Chat (Message With Me)', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(606, 'en', 'replied_to_', 'Replied To ', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(607, 'en', 'admin_notifications_settings', 'Admin Notifications Settings', '2024-12-19 18:37:44', '2024-12-19 18:37:44'),
(608, 'en', 'notifications_settings_updated', 'Notifications Settings Updated', '2024-12-19 18:38:01', '2024-12-19 18:38:01'),
(609, 'en', 'social_login_setup', 'Social Login Setup', '2024-12-19 18:38:09', '2024-12-19 18:38:09'),
(610, 'en', 'mail_configuration', 'Mail Configuration', '2024-12-19 13:40:00', '2024-12-19 13:40:00'),
(611, 'en', 'mail_gateway', 'Mail Gateway', '2024-12-19 13:40:00', '2024-12-19 13:40:00'),
(612, 'en', 'mail_gateway_list', 'Mail Gateway List', '2024-12-19 13:40:00', '2024-12-19 13:40:00'),
(613, 'en', 'gateway_name', 'Gateway Name', '2024-12-19 13:40:00', '2024-12-19 13:40:00'),
(614, 'en', 'update_gateway', 'Update Gateway', '2024-12-19 13:40:04', '2024-12-19 13:40:04'),
(615, 'en', 'email_gateway', 'Email Gateway', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(616, 'en', 'driver', 'Driver', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(617, 'en', 'enter_driver', 'Enter Driver', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(618, 'en', 'host', 'Host', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(619, 'en', 'enter_host', 'Enter Host', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(620, 'en', 'port', 'Port', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(621, 'en', 'enter_port', 'Enter Port', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(622, 'en', 'encryption', 'Encryption', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(623, 'en', 'enter_encryption', 'Enter Encryption', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(624, 'en', 'enter_mail_username', 'Enter Mail Username', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(625, 'en', 'enter_mail_password', 'Enter Mail Password', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(626, 'en', 'from_address', 'From Address', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(627, 'en', 'enter_from_address', 'Enter From Address', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(628, 'en', 'from_name', 'From Name', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(629, 'en', 'enter_from_name', 'Enter From Name', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(630, 'en', 'test_gateway', 'Test Gateway', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(631, 'en', 'enter_your_mail', 'Enter Your Mail', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(632, 'en', 'test', 'Test', '2024-12-19 13:40:05', '2024-12-19 13:40:05'),
(633, 'en', 'smtp_mail_method_has_been_updated', 'SMTP mail method has been updated', '2024-12-19 13:43:04', '2024-12-19 13:43:04'),
(634, 'en', 'mail_configuration_error_please_check_your_mail_configuration_properly', 'Mail Configuration Error, Please check your mail configuration properly', '2024-12-19 13:43:18', '2024-12-19 13:43:18'),
(635, 'en', 'categories', 'Categories', '2024-12-19 13:50:31', '2024-12-19 13:50:31'),
(636, 'en', 'category_list', 'Category List', '2024-12-19 13:50:31', '2024-12-19 13:50:31'),
(637, 'en', 'inctive', 'Inctive', '2024-12-19 13:50:31', '2024-12-19 13:50:31'),
(638, 'en', 'delete', 'Delete', '2024-12-19 13:50:31', '2024-12-19 13:50:31'),
(639, 'en', 'search_by_name', 'Search By Name', '2024-12-19 13:50:31', '2024-12-19 13:50:31'),
(640, 'en', 'add_category', 'Add Category', '2024-12-19 13:50:31', '2024-12-19 13:50:31'),
(641, 'en', 'sort_details', 'Sort Details', '2024-12-19 13:50:31', '2024-12-19 13:50:31'),
(642, 'en', 'write_sort_details_here', 'Write sort Details Here', '2024-12-19 13:50:31', '2024-12-19 13:50:31'),
(643, 'en', 'do_you_want_to_delete_these_records', 'Do You Want To Delete These Records??', '2024-12-19 13:50:31', '2024-12-19 13:50:31'),
(644, 'en', 'name_feild_must_be_required', 'Name Feild Must Be Required', '2024-12-19 13:51:42', '2024-12-19 13:51:42'),
(645, 'en', 'category_name_must_be_unique', 'Category Name Must Be Unique', '2024-12-19 13:51:42', '2024-12-19 13:51:42'),
(646, 'en', 'short_details_is_required', 'Short Details Is Required', '2024-12-19 13:51:42', '2024-12-19 13:51:42'),
(647, 'en', 'category_created_successfully', 'Category Created Successfully', '2024-12-19 13:51:42', '2024-12-19 13:51:42'),
(648, 'en', '_feild_is_required', ' Feild Is Required', '2024-12-19 13:52:17', '2024-12-19 13:52:17'),
(649, 'en', 'you_have_a_new_unassigned_ticket', 'You Have a New Unassigned Ticket', '2024-12-19 13:52:18', '2024-12-19 13:52:18'),
(650, 'en', 'ticket_successfully_created_', 'Ticket Successfully Created ', '2024-12-19 13:52:26', '2024-12-19 13:52:26'),
(651, 'en', 'notification_please_review_your_email', 'Notification: Please Review Your Email', '2024-12-19 13:52:26', '2024-12-19 13:52:26'),
(652, 'en', 'ticket_issued_your_ticketid_is_', 'Ticket Issued: Your TicketId Is ', '2024-12-19 13:52:26', '2024-12-19 13:52:26'),
(653, 'en', 'your_ticket', 'Your Ticket', '2024-12-19 13:52:26', '2024-12-19 13:52:26'),
(654, 'en', 'ticket_details', 'Ticket Details', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(655, 'en', 'ticket_number', 'Ticket Number', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(656, 'en', 'user_name', 'User Name', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(657, 'en', 'user_email', 'User Email', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(658, 'en', 'category', 'Category', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(659, 'en', 'create_date', 'Create Date', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(660, 'en', 'custom_ticket_data', 'Custom Ticket Data', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(661, 'en', 'no_file_found', 'No file Found', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(662, 'en', 'main_ticket_attachment', 'Main Ticket Attachment', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(663, 'en', 'reply', 'Reply', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(664, 'en', 'envato_verification', 'Envato verification', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(665, 'en', 'upload_file', 'Upload File', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(666, 'en', 'maximum_file_upload_', 'Maximum File Upload :', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(667, 'en', 'load_more', 'Load More', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(668, 'en', 'reply_list', 'Reply List', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(669, 'en', 'select_template', 'Select Template', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(670, 'en', 'start_typing', 'Start typing...', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(671, 'en', 'something_went_wrong__please_try_agian', 'Something went wrong !! Please Try agian', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(672, 'en', 'view_ticket', 'View Ticket', '2024-12-19 13:52:35', '2024-12-19 13:52:35'),
(673, 'en', 'unread_notifications', 'Unread Notifications', '2024-12-19 13:52:51', '2024-12-19 13:52:51'),
(674, 'en', 'clear_all', 'Clear all', '2024-12-19 13:52:51', '2024-12-19 13:52:51'),
(675, 'en', 'view_all_notifications', 'View All Notifications', '2024-12-19 13:52:51', '2024-12-19 13:52:51'),
(676, 'en', 'pending_tickets_', 'Pending Tickets: ', '2024-12-19 13:52:51', '2024-12-19 13:52:51'),
(677, 'en', 'all_notifications', 'All Notifications', '2024-12-19 13:53:11', '2024-12-19 13:53:11'),
(678, 'en', 'notification', 'Notification', '2024-12-19 13:53:11', '2024-12-19 13:53:11'),
(679, 'en', 'no_response_yet', 'No Response Yet', '2024-12-19 13:53:19', '2024-12-19 13:53:19'),
(680, 'en', 'not_resolved_yet', 'Not Resolved Yet', '2024-12-19 13:53:19', '2024-12-19 13:53:19'),
(681, 'en', 'ticket_id_feild_is_required', 'Ticket Id Feild Is Required', '2024-12-19 13:53:58', '2024-12-19 13:53:58'),
(682, 'en', 'ticket_id_feild_must_be_an_array', 'Ticket Id Feild Must Be An Array', '2024-12-19 13:53:58', '2024-12-19 13:53:58'),
(683, 'en', 'invalid_tickets_selected', 'Invalid Tickets Selected', '2024-12-19 13:53:58', '2024-12-19 13:53:58'),
(684, 'en', 'you_have_a_new_assigned_ticket_by', 'You Have a New Assigned Ticket By', '2024-12-19 13:53:58', '2024-12-19 13:53:58'),
(685, 'en', 'ticket_assigned_successfully', 'Ticket Assigned Successfully', '2024-12-19 13:53:59', '2024-12-19 13:53:59'),
(686, 'en', 'agent_not_found', 'Agent Not Found', '2024-12-19 13:55:19', '2024-12-19 13:55:19'),
(687, 'en', 'successfully_login_as_a_agent', 'SuccessFully Login As a Agent', '2024-12-19 13:55:19', '2024-12-19 13:55:19'),
(688, 'en', 'profile_settings', 'Profile Settings', '2024-12-19 13:55:21', '2024-12-19 13:55:21'),
(689, 'en', 'enter_your_user_name', 'Enter your User Name', '2024-12-19 13:55:21', '2024-12-19 13:55:21'),
(690, 'en', 'phonenumber', 'Phone												Number', '2024-12-19 13:55:21', '2024-12-19 13:55:21'),
(691, 'en', 'enter_your_phone_number', 'Enter your phone number', '2024-12-19 13:55:21', '2024-12-19 13:55:21'),
(692, 'en', 'emailaddress', 'Email												Address', '2024-12-19 13:55:21', '2024-12-19 13:55:21'),
(693, 'en', 'admin_profile', 'Admin Profile', '2024-12-19 13:55:21', '2024-12-19 13:55:21'),
(694, 'en', 'change_password', 'Change Password', '2024-12-19 13:55:47', '2024-12-19 13:55:47'),
(695, 'en', 'old_password', 'Old													 Password', '2024-12-19 13:55:47', '2024-12-19 13:55:47'),
(696, 'en', 'enter_current_password', 'Enter current password', '2024-12-19 13:55:47', '2024-12-19 13:55:47'),
(697, 'en', 'newpassword', 'New													Password', '2024-12-19 13:55:47', '2024-12-19 13:55:47'),
(698, 'en', 'enter_new_password', 'Enter new password', '2024-12-19 13:55:47', '2024-12-19 13:55:47'),
(699, 'en', 'confirmpassword', 'Confirm													Password', '2024-12-19 13:55:47', '2024-12-19 13:55:47'),
(700, 'en', 'changepassword', 'Change													Password', '2024-12-19 13:55:47', '2024-12-19 13:55:47'),
(701, 'en', 'notification_not_found', 'Notification Not Found', '2024-12-19 13:56:00', '2024-12-19 13:56:00'),
(702, 'en', 'notification_readed', 'Notification Readed', '2024-12-19 13:56:00', '2024-12-19 13:56:00'),
(703, 'en', 'unauthorized_access', 'Unauthorized access', '2024-12-19 13:56:01', '2024-12-19 13:56:01'),
(704, 'en', 'no_user_found_', 'No User Found !!', '2024-12-19 13:59:14', '2024-12-19 13:59:14'),
(705, 'en', 'user_blocked', 'User Blocked', '2024-12-19 13:59:15', '2024-12-19 13:59:15'),
(706, 'en', 'user_unblocked', 'User Unblocked', '2024-12-19 13:59:23', '2024-12-19 13:59:23'),
(707, 'en', 'agent_update', 'Agent Update', '2024-12-19 13:59:48', '2024-12-19 13:59:48'),
(708, 'en', 'update_agent', 'Update Agent', '2024-12-19 13:59:48', '2024-12-19 13:59:48'),
(709, 'en', 'enter_your_phone', 'Enter Your Phone', '2024-12-19 13:59:49', '2024-12-19 13:59:49'),
(710, 'en', 'agent_updated_successfully', 'Agent Updated Successfully', '2024-12-19 14:00:33', '2024-12-19 14:00:33'),
(711, 'en', 'short_notes', 'Short Notes', '2024-12-19 14:03:13', '2024-12-19 14:03:13'),
(712, 'en', 'previous_ticket', 'Previous Ticket', '2024-12-19 14:03:13', '2024-12-19 14:03:13'),
(713, 'en', 'email_notifications', 'Email Notifications', '2024-12-19 14:03:13', '2024-12-19 14:03:13'),
(714, 'en', 'enable_email_notification_form_system_notification_settings', 'Enable email notification form system notification settings', '2024-12-19 14:03:13', '2024-12-19 14:03:13'),
(715, 'en', 'sms_notifications', 'Sms Notifications', '2024-12-19 14:03:13', '2024-12-19 14:03:13'),
(716, 'en', 'enable_sms_notification_form_system_notification_settings', 'Enable sms notification form system notification settings', '2024-12-19 14:03:13', '2024-12-19 14:03:13'),
(717, 'en', 'browser_notifications', 'Browser Notifications', '2024-12-19 14:03:13', '2024-12-19 14:03:13'),
(718, 'en', 'enable_browser_notification_form_system_notification_settings_', 'Enable Browser notification form system notification settings ', '2024-12-19 14:03:13', '2024-12-19 14:03:13'),
(719, 'en', 'ticket_files', 'Ticket Files', '2024-12-19 14:03:13', '2024-12-19 14:03:13'),
(720, 'en', 'enter_purchase_key', 'Enter purchase key', '2024-12-19 14:03:14', '2024-12-19 14:03:14'),
(721, 'en', 'verify_purchase', 'Verify purchase', '2024-12-19 14:03:14', '2024-12-19 14:03:14'),
(722, 'en', 'send__', 'Send & ', '2024-12-19 14:03:14', '2024-12-19 14:03:14'),
(723, 'en', 'add_note', 'Add Note', '2024-12-19 14:03:15', '2024-12-19 14:03:15'),
(724, 'en', 'update_message', 'Update Message', '2024-12-19 14:03:15', '2024-12-19 14:03:15'),
(725, 'en', 'original_message', 'Original Message', '2024-12-19 14:03:15', '2024-12-19 14:03:15'),
(726, 'en', 'ticket', 'Ticket', '2024-12-19 14:03:15', '2024-12-19 14:03:15'),
(727, 'en', 'merged_tickets_can_not_be_unmerged', 'Merged tickets can not be unmerged.', '2024-12-19 14:03:15', '2024-12-19 14:03:15'),
(728, 'en', 'are_you_sure_you_want_merge_this_ticket_with_the_original_one_behind_the_popupsmerged_tickets_can_not_be_unmerged', 'Are you sure you want merge this ticket with the original one behind the pop-ups?Merged tickets can not be unmerged.', '2024-12-19 14:03:15', '2024-12-19 14:03:15'),
(729, 'en', 'yes_merge_it', 'Yes, Merge It!', '2024-12-19 14:03:15', '2024-12-19 14:03:15'),
(730, 'en', 'edit', 'Edit', '2024-12-19 14:03:17', '2024-12-19 14:03:17'),
(731, 'en', 'show_original', 'Show Original', '2024-12-19 14:03:17', '2024-12-19 14:03:17'),
(732, 'en', 'message_feild_is_required', 'Message Feild is Required', '2024-12-19 14:04:37', '2024-12-19 14:04:37'),
(733, 'en', 'replied_successfully', 'Replied Successfully', '2024-12-19 14:04:38', '2024-12-19 14:04:38'),
(734, 'en', 'hello_dear_', 'Hello Dear!!! ', '2024-12-19 14:04:38', '2024-12-19 14:04:38'),
(735, 'en', 'replied_to', 'Replied To', '2024-12-19 14:04:40', '2024-12-19 14:04:40'),
(736, 'en', 'new', 'New', '2024-12-19 14:04:53', '2024-12-19 14:04:53'),
(737, 'en', 'ticket_closed', 'Ticket Closed', '2024-12-19 14:07:13', '2024-12-19 14:07:13'),
(738, 'en', 'response_list', 'Response List', '2024-12-19 14:07:59', '2024-12-19 14:07:59'),
(739, 'en', 'add_new_reply', 'Add New Reply', '2024-12-19 14:07:59', '2024-12-19 14:07:59'),
(740, 'en', 'share_with', 'Share with', '2024-12-19 14:07:59', '2024-12-19 14:07:59'),
(741, 'en', 'add_reply', 'Add Reply', '2024-12-19 14:07:59', '2024-12-19 14:07:59'),
(742, 'en', 'body', 'Body', '2024-12-19 14:07:59', '2024-12-19 14:07:59'),
(743, 'en', 'share_canned_reply', 'Share canned reply', '2024-12-19 14:07:59', '2024-12-19 14:07:59'),
(744, 'en', 'assigned_to', 'Assigned To', '2024-12-19 14:15:32', '2024-12-19 14:15:32'),
(745, 'en', 'slack_notifications', 'Slack Notifications', '2024-12-19 14:15:32', '2024-12-19 14:15:32'),
(746, 'en', 'enable_slack_notification_form_system_notification_settings_', 'Enable Slack notification form system notification settings ', '2024-12-19 14:15:32', '2024-12-19 14:15:32'),
(747, 'en', 'agent_doesnot_exists', 'Agent Doesnot Exists', '2024-12-19 14:17:37', '2024-12-19 14:17:37'),
(748, 'en', 'deleted_successfully', 'Deleted Successfully', '2024-12-19 14:34:48', '2024-12-19 14:34:48'),
(749, 'en', 'edit_ticket', 'Edit Ticket', '2024-12-19 14:37:26', '2024-12-19 14:37:26'),
(750, 'en', 'ticket_category', 'Ticket category', '2024-12-19 14:37:26', '2024-12-19 14:37:26'),
(751, 'en', 'select_category', 'Select category', '2024-12-19 14:37:26', '2024-12-19 14:37:26'),
(752, 'en', 'product_list', 'Product List', '2024-12-19 14:38:33', '2024-12-19 14:38:33'),
(753, 'en', 'add_product', 'Add Product', '2024-12-19 14:38:33', '2024-12-19 14:38:33'),
(754, 'en', 'envato_product', 'Envato product', '2024-12-19 14:38:33', '2024-12-19 14:38:33'),
(755, 'en', 'manage_product', 'Manage Product', '2024-12-19 14:38:33', '2024-12-19 14:38:33'),
(756, 'en', 'default_name_is_required', 'Default name is required', '2024-12-19 14:45:59', '2024-12-19 14:45:59'),
(757, 'en', 'default_name_must_be_unique', 'Default name must be unique', '2024-12-19 14:45:59', '2024-12-19 14:45:59'),
(758, 'en', 'product_created_successfully', 'Product created successfully', '2024-12-19 14:45:59', '2024-12-19 14:45:59'),
(759, 'en', 'system', 'System', '2024-12-19 14:46:00', '2024-12-19 14:46:00'),
(760, 'en', 'product_updated_successfully', 'Product updated successfully', '2024-12-19 14:47:52', '2024-12-19 14:47:52'),
(761, 'en', 'ticket_updated_successfully', 'Ticket updated successfully', '2024-12-19 14:48:43', '2024-12-19 14:48:43'),
(762, 'en', 'cache_cleared_successfully', 'Cache Cleared Successfully', '2024-12-19 14:50:51', '2024-12-19 14:50:51'),
(763, 'en', 'sms_gateway_list', 'Sms Gateway list', '2024-12-19 14:55:29', '2024-12-19 14:55:29'),
(764, 'en', 'sms_global_template', 'SMS Global template', '2024-12-19 14:55:34', '2024-12-19 14:55:34'),
(765, 'en', 'sms_template_short_code', 'Sms Template Short Code', '2024-12-19 14:55:34', '2024-12-19 14:55:34'),
(766, 'en', 'email_templates', 'Email templates', '2024-12-19 15:01:37', '2024-12-19 15:01:37'),
(767, 'en', 'template_list', 'Template List', '2024-12-19 15:01:37', '2024-12-19 15:01:37'),
(768, 'en', '_name', ' Name', '2024-12-19 15:01:37', '2024-12-19 15:01:37'),
(769, 'en', 'email_not_found', 'Email Not Found', '2024-12-19 15:05:37', '2024-12-19 15:05:37'),
(770, 'en', 'manange_groups', 'Manange Groups', '2024-12-19 15:10:45', '2024-12-19 15:10:45'),
(771, 'en', 'groups', 'Groups', '2024-12-19 15:10:45', '2024-12-19 15:10:45'),
(772, 'en', 'group_list', 'Group List', '2024-12-19 15:10:45', '2024-12-19 15:10:45'),
(773, 'en', 'add_new_', 'Add New ', '2024-12-19 15:10:45', '2024-12-19 15:10:45'),
(774, 'en', 'optinos', 'Optinos', '2024-12-19 15:10:45', '2024-12-19 15:10:45'),
(775, 'en', 'personal_details', 'Personal Details', '2024-12-19 15:12:02', '2024-12-19 15:12:02'),
(776, 'en', 'user_profile', 'User Profile', '2024-12-19 15:12:02', '2024-12-19 15:12:02'),
(777, 'en', 'language_switched_successfully', 'Language Switched Successfully', '2024-12-19 15:13:41', '2024-12-19 15:13:41'),
(778, 'bd', 'language_switched_successfully', 'Language Switched Successfully', '2024-12-19 15:13:42', '2024-12-19 15:13:42'),
(779, 'bd', 'admin_access_portal', 'Admin Access Portal', '2024-12-19 15:13:49', '2024-12-19 15:13:49'),
(780, 'bd', 'username', 'Username', '2024-12-19 15:13:49', '2024-12-19 15:13:49'),
(781, 'bd', 'enter_username', 'Enter username', '2024-12-19 15:13:49', '2024-12-19 15:13:49'),
(782, 'bd', 'password', 'Password', '2024-12-19 15:13:49', '2024-12-19 15:13:49'),
(783, 'bd', 'enter_password', 'Enter password', '2024-12-19 15:13:50', '2024-12-19 15:13:50'),
(784, 'bd', 'remember_me', 'Remember me', '2024-12-19 15:13:50', '2024-12-19 15:13:50'),
(785, 'bd', 'forgot_password', 'Forgot password', '2024-12-19 15:13:50', '2024-12-19 15:13:50'),
(786, 'bd', 'sign_in', 'Sign In', '2024-12-19 15:13:50', '2024-12-19 15:13:50'),
(787, 'bd', 'welcome_back_', 'Welcome Back ', '2024-12-19 15:13:50', '2024-12-19 15:13:50'),
(788, 'bd', 'admin_login', 'Admin Login', '2024-12-19 15:13:50', '2024-12-19 15:13:50'),
(789, 'en', 'translate_language', 'Translate language', '2024-12-19 15:14:15', '2024-12-19 15:14:15'),
(790, 'en', 'key', 'key', '2024-12-19 15:14:16', '2024-12-19 15:14:16'),
(791, 'en', 'successfully_translated', 'Successfully Translated', '2024-12-19 15:14:16', '2024-12-19 15:14:16'),
(792, 'en', 'translation_failed', 'Translation Failed', '2024-12-19 15:14:16', '2024-12-19 15:14:16'),
(793, 'en', 'the_name_feild_is_required', 'The Name Feild is Required', '2024-12-19 15:14:32', '2024-12-19 15:14:32'),
(794, 'en', 'the_name_must_be_unique', 'The Name Must Be Unique', '2024-12-19 15:14:32', '2024-12-19 15:14:32'),
(795, 'gf', 'back_to_home', 'Back to Home', NULL, NULL),
(796, 'gf', 'track', 'Track', NULL, NULL),
(797, 'gf', 'create_ticket', 'Create Ticket', NULL, NULL),
(798, 'gf', 'login', 'Login', NULL, NULL),
(799, 'gf', 'important_links', 'Important Links', NULL, NULL),
(800, 'gf', 'quick_link', 'Quick Link', NULL, NULL),
(801, 'gf', 'social_links', 'Social Links', NULL, NULL),
(802, 'gf', 'enter_your_email', 'Enter Your Email', NULL, NULL),
(803, 'gf', 'subscribe', 'Subscribe', NULL, NULL),
(804, 'gf', 'admin_access_portal', 'Admin Access Portal', NULL, NULL),
(805, 'gf', 'username', 'Username', NULL, NULL),
(806, 'gf', 'enter_username', 'Enter username', NULL, NULL),
(807, 'gf', 'password', 'Password', NULL, NULL),
(808, 'gf', 'enter_password', 'Enter password', NULL, NULL),
(809, 'gf', 'remember_me', 'Remember me', NULL, NULL),
(810, 'gf', 'forgot_password', 'Forgot password', NULL, NULL),
(811, 'gf', 'sign_in', 'Sign In', NULL, NULL),
(812, 'gf', 'welcome_back_', 'Welcome Back ', NULL, NULL),
(813, 'gf', 'admin_login', 'Admin Login', NULL, NULL),
(814, 'gf', 'welcome', 'Welcome', NULL, NULL),
(815, 'gf', 'heres_whats_happening_with_your_system', 'Here\'s what\'s happening with your System', NULL, NULL),
(816, 'gf', 'last_cron_run', 'Last cron run', NULL, NULL),
(817, 'gf', 'sort_by', 'Sort by', NULL, NULL),
(818, 'gf', 'all', 'All', NULL, NULL),
(819, 'gf', 'today', 'Today', NULL, NULL),
(820, 'gf', 'yesterday', 'Yesterday', NULL, NULL),
(821, 'gf', 'last_7_days', 'Last 7 Days', NULL, NULL),
(822, 'gf', 'last_30_days', 'Last 30 Days', NULL, NULL),
(823, 'gf', 'total_users', 'Total Users', NULL, NULL),
(824, 'gf', 'total_agents', 'Total Agents', NULL, NULL),
(825, 'gf', 'total_categories', 'Total Categories', NULL, NULL),
(826, 'gf', 'total_articles', 'Total Articles', NULL, NULL),
(827, 'gf', 'total_subscriber', 'Total Subscriber', NULL, NULL),
(828, 'gf', 'total_tickets', 'Total Tickets', NULL, NULL),
(829, 'gf', 'view_all', 'View All', NULL, NULL),
(830, 'gf', 'tickets', 'Tickets', NULL, NULL),
(831, 'gf', 'total', 'Total', NULL, NULL),
(832, 'gf', 'ticket_by_user', 'Ticket By User', NULL, NULL),
(833, 'gf', 'sorry_no_result_found', 'Sorry! No Result Found', NULL, NULL),
(834, 'gf', 'ticket_by_category', 'Ticket By Category', NULL, NULL),
(835, 'gf', 'latest_tickets', 'Latest Tickets', NULL, NULL),
(836, 'gf', 'download_pdf', 'Download PDF', NULL, NULL),
(837, 'gf', 'ticket_id', 'Ticket Id', NULL, NULL),
(838, 'gf', 'name', 'Name', NULL, NULL),
(839, 'gf', 'email', 'Email', NULL, NULL),
(840, 'gf', 'creation_time', 'Creation Time', NULL, NULL),
(841, 'gf', 'subject', 'Subject', NULL, NULL),
(842, 'gf', 'status', 'Status', NULL, NULL),
(843, 'gf', 'pending_tickets', 'Pending Tickets', NULL, NULL),
(844, 'gf', 'top_categories_by_tickets', 'Top Categories By Tickets', NULL, NULL),
(845, 'gf', 'latest_agent_replies', 'Latest Agent Replies', NULL, NULL),
(846, 'gf', 'opened_tickets', 'Opened Tickets', NULL, NULL),
(847, 'gf', 'closed_tickets', 'Closed Tickets', NULL, NULL),
(848, 'gf', 'dashboard', 'Dashboard', NULL, NULL),
(849, 'gf', 'clear_cache', 'Clear Cache', NULL, NULL),
(850, 'gf', 'browse_frontend', 'Browse Frontend', NULL, NULL),
(851, 'gf', 'notifications', 'Notifications', NULL, NULL),
(852, 'gf', 'no_new_notificatios', 'No New Notificatios', NULL, NULL),
(853, 'gf', 'profile', 'Profile', NULL, NULL),
(854, 'gf', 'logout', 'Logout', NULL, NULL),
(855, 'gf', 'menu', 'Menu', NULL, NULL),
(856, 'gf', 'messenger', 'Messenger', NULL, NULL),
(857, 'gf', 'ticketsagents__users', 'Tickets,Agents & Users', NULL, NULL),
(858, 'gf', 'tickets_lists', 'Tickets Lists', NULL, NULL),
(859, 'gf', 'ticket_configuration', 'Ticket Configuration', NULL, NULL),
(860, 'gf', 'general_configuration', 'General Configuration', NULL, NULL),
(861, 'gf', 'triggering', 'Triggering', NULL, NULL),
(862, 'gf', 'ticket_status', 'Ticket Status', NULL, NULL),
(863, 'gf', 'departments', 'Departments', NULL, NULL),
(864, 'gf', 'ticket_priority', 'Ticket Priority', NULL, NULL),
(865, 'gf', 'ticket_categories', 'Ticket Categories', NULL, NULL),
(866, 'gf', 'predefined_response', 'Predefined Response', NULL, NULL),
(867, 'gf', 'agent_management', 'Agent Management', NULL, NULL),
(868, 'gf', 'add_new', 'Add New', NULL, NULL),
(869, 'gf', 'agent_list', 'Agent List', NULL, NULL),
(870, 'gf', 'agent_group', 'Agent Group', NULL, NULL),
(871, 'gf', 'manage_user', 'Manage User', NULL, NULL),
(872, 'gf', 'user_list', 'User List', NULL, NULL),
(873, 'gf', 'appearance__others', 'Appearance & Others', NULL, NULL),
(874, 'gf', 'appearance_settings', 'Appearance Settings', NULL, NULL),
(875, 'gf', 'section_manage', 'Section Manage', NULL, NULL),
(876, 'gf', 'menu_manage', 'Menu Manage', NULL, NULL),
(877, 'gf', 'dynamic_pages', 'Dynamic Pages', NULL, NULL),
(878, 'gf', 'faq_section', 'FAQ Section', NULL, NULL),
(879, 'gf', 'knowledgebase', 'knowledgebase', NULL, NULL),
(880, 'gf', 'article_administration', 'Article Administration', NULL, NULL),
(881, 'gf', 'article_topics', 'Article Topics', NULL, NULL),
(882, 'gf', 'article_categories', 'Article Categories', NULL, NULL),
(883, 'gf', 'article_list', 'Article List', NULL, NULL),
(884, 'gf', 'marketingpromotion', 'Marketing/Promotion', NULL, NULL),
(885, 'gf', 'contact_message', 'Contact Message', NULL, NULL),
(886, 'gf', 'subscribers', 'Subscribers', NULL, NULL),
(887, 'gf', 'email__sms_config', 'Email & SMS Config', NULL, NULL),
(888, 'gf', 'email_configuration', 'Email Configuration', NULL, NULL),
(889, 'gf', 'outgoing_method', 'Outgoing Method', NULL, NULL),
(890, 'gf', 'incoming_method', 'Incoming Method', NULL, NULL),
(891, 'gf', 'global_template', 'Global template', NULL, NULL),
(892, 'gf', 'mail_templates', 'Mail templates', NULL, NULL),
(893, 'gf', 'sms_configuration', 'SMS Configuration', NULL, NULL),
(894, 'gf', 'sms_gateway', 'SMS Gateway', NULL, NULL),
(895, 'gf', 'global_setting', 'Global Setting', NULL, NULL),
(896, 'gf', 'sms_templates', 'SMS templates', NULL, NULL),
(897, 'gf', 'setup__configurations', 'Setup & Configurations', NULL, NULL),
(898, 'gf', 'application_settings', 'Application Settings', NULL, NULL),
(899, 'gf', 'app_settings', 'App Settings', NULL, NULL),
(900, 'gf', 'ai_configuration', 'AI Configuration', NULL, NULL),
(901, 'gf', 'system_preferences', 'System Preferences', NULL, NULL),
(902, 'gf', 'notification_settings', 'Notification settings', NULL, NULL),
(903, 'gf', 'security_settings', 'Security Settings', NULL, NULL),
(904, 'gf', 'visitors', 'Visitors', NULL, NULL),
(905, 'gf', 'dos_security', 'Dos Security', NULL, NULL),
(906, 'gf', 'system_upgrade', 'System Upgrade', NULL, NULL),
(907, 'gf', 'languages', 'Languages', NULL, NULL),
(908, 'gf', 'about_system', 'About System', NULL, NULL),
(909, 'gf', 'app_version', 'App Version', NULL, NULL),
(910, 'gf', 'ai_assistance', 'AI Assistance', NULL, NULL),
(911, 'gf', 'result', 'Result', NULL, NULL),
(912, 'gf', 'copy', 'Copy', NULL, NULL),
(913, 'gf', 'download', 'Download', NULL, NULL),
(914, 'gf', 'your_content', 'Your Content', NULL, NULL),
(915, 'gf', 'your_prompt_goes_here__', 'Your prompt goes here .... ', NULL, NULL),
(916, 'gf', 'what_do_you_want_to_do', 'What do you want to do', NULL, NULL),
(917, 'gf', 'here_are_some_ideas', 'Here are some ideas', NULL, NULL),
(918, 'gf', 'more', 'More', NULL, NULL),
(919, 'gf', 'translate', 'Translate', NULL, NULL),
(920, 'gf', 'back', 'Back', NULL, NULL),
(921, 'gf', 'rewrite_it', 'Rewrite It', NULL, NULL),
(922, 'gf', 'adjust_tone', 'Adjust Tone', NULL, NULL),
(923, 'gf', 'choose_language', 'Choose Language', NULL, NULL),
(924, 'gf', 'select_language', 'Select Language', NULL, NULL),
(925, 'gf', 'or', 'OR', NULL, NULL),
(926, 'gf', 'make_your_own_prompt', 'Make Your Own Prompt', NULL, NULL),
(927, 'gf', 'ex_make_it_more_friendly_', 'Ex: Make It more friendly ', NULL, NULL),
(928, 'gf', 'insert', 'Insert', NULL, NULL),
(929, 'gf', 'cancel', 'Cancel', NULL, NULL),
(930, 'gf', 'do_not_close_window_while_proecessing', 'Do not close window while proecessing', NULL, NULL),
(931, 'gf', 'hello_', 'Hello ', NULL, NULL),
(932, 'gf', 'this_function_is_not_avaialbe_for_website_demo_mode', 'This Function is Not Avaialbe For Website Demo Mode', NULL, NULL),
(933, 'gf', 'select_country', 'Select Country', NULL, NULL),
(934, 'gf', 'generate_with_ai', 'Generate With AI', NULL, NULL),
(935, 'gf', 'text_copied_to_clipboard', 'Text copied to clipboard!', NULL, NULL),
(936, 'gf', 'incoming_mail_configuration', 'incoming Mail Configuration', NULL, NULL),
(937, 'gf', 'home', 'Home', NULL, NULL),
(938, 'gf', 'imap_method', 'IMAP Method', NULL, NULL),
(939, 'gf', 'email_to_ticket', 'Email To Ticket', NULL, NULL),
(940, 'gf', 'convert_incoming_email_to_ticket_if_email_body_or_subject_contains__any_of_the_specified_keywords', 'Convert incoming email to ticket if email body or subject contains  any of the specified keywords', NULL, NULL),
(941, 'gf', 'comma_separated', 'Comma separated', NULL, NULL),
(942, 'gf', 'enter_', 'Enter ', NULL, NULL),
(943, 'gf', 'update', 'Update', NULL, NULL),
(944, 'gf', 'enter_keywords', 'Enter Keywords', NULL, NULL),
(945, 'gf', 'general_setting', 'General Setting', NULL, NULL),
(946, 'gf', 'basic_settings', 'Basic Settings', NULL, NULL),
(947, 'gf', 'agent_settings', 'Agent Settings', NULL, NULL),
(948, 'gf', 'theme_settings', 'Theme Settings', NULL, NULL),
(949, 'gf', 'storage_settings', 'Storage Settings', NULL, NULL),
(950, 'gf', 'pusher_settings', 'Pusher Settings', NULL, NULL),
(951, 'gf', 'slack_settings', 'Slack Settings', NULL, NULL),
(952, 'gf', 'recaptcha_settings', 'Recaptcha Settings', NULL, NULL),
(953, 'gf', '3rd_party_login', '3rd Party Login', NULL, NULL),
(954, 'gf', 'logo_settings', 'Logo Settings', NULL, NULL),
(955, 'gf', 'setup_cron_jobs', 'Setup Cron Jobs', NULL, NULL),
(956, 'gf', 'use_same_site_name', 'Use Same Site Name', NULL, NULL),
(957, 'gf', 'site_name', 'Site Name', NULL, NULL),
(958, 'gf', 'user_site_name', 'User Site Name', NULL, NULL),
(959, 'gf', 'phone', 'Phone', NULL, NULL),
(960, 'gf', 'address', 'Address', NULL, NULL),
(961, 'gf', 'copy_right_text', 'Copy Right Text', NULL, NULL),
(962, 'gf', 'pagination_number', 'Pagination Number', NULL, NULL),
(963, 'gf', 'time_zone', 'Time Zone', NULL, NULL),
(964, 'gf', 'cookie__text', 'Cookie  Text', NULL, NULL),
(965, 'gf', 'enter_cookie_text', 'Enter Cookie Text', NULL, NULL),
(966, 'gf', 'maintenance_mode_title', 'Maintenance Mode Title', NULL, NULL),
(967, 'gf', 'enter_title', 'Enter title', NULL, NULL),
(968, 'gf', 'maintenance_mode_description', 'Maintenance Mode Description', NULL, NULL),
(969, 'gf', 'enter_description', 'Enter description', NULL, NULL),
(970, 'gf', 'submit', 'Submit', NULL, NULL),
(971, 'gf', 'best_agent_settings', 'Best Agent Settings', NULL, NULL),
(972, 'gf', 'avg_response_time', 'Avg Response Time', NULL, NULL),
(973, 'gf', 'in_miniutes', 'In Miniutes', NULL, NULL),
(974, 'gf', 'avg_response_time_required_to_become_a_bestpopular_agent', 'Avg Response Time Required To Become a Best/Popular Agent', NULL, NULL),
(975, 'gf', 'minimum_no_of_responsed_ticket', 'Minimum No. Of Responsed Ticket', NULL, NULL),
(976, 'gf', 'to_attain_the_status_of_a_top_agent_the_requisite_minimum_number_of_tickets_to_respond_to_is_', 'To attain the status of a top agent, the requisite minimum number of tickets to respond to is ...', NULL, NULL),
(977, 'gf', 'enter_number', 'Enter Number', NULL, NULL),
(978, 'gf', 'frontend_themecolor_settings', 'Frontend Theme/Color Settings', NULL, NULL),
(979, 'gf', 'primary_color', 'Primary Color', NULL, NULL),
(980, 'gf', 'secondary_color', 'Secondary Color', NULL, NULL),
(981, 'gf', 'secondry_color', 'Secondry Color', NULL, NULL),
(982, 'gf', 'text_primary_color', 'Text Primary Color', NULL, NULL),
(983, 'gf', 'text_secondary_color', 'Text Secondary Color', NULL, NULL),
(984, 'gf', 'text_secondry_color', 'Text Secondry Color', NULL, NULL),
(985, 'gf', 'local', 'local', NULL, NULL),
(986, 'gf', 'aws_s3', 'Aws S3', NULL, NULL),
(987, 'gf', 'local_storage_settings', 'Local Storage Settings', NULL, NULL),
(988, 'gf', 'supported_file_types', 'Supported File Types', NULL, NULL),
(989, 'gf', 'maximum_file_upload', 'Maximum File Upload', NULL, NULL),
(990, 'gf', 'you_can_not_upload_more_than_that_at_a_time_', 'You Can Not Upload More Than That At A Time ', NULL, NULL),
(991, 'gf', 'max_file_upload_size', 'Max File Upload size', NULL, NULL),
(992, 'gf', 'in_kilobyte', 'In Kilobyte', NULL, NULL),
(993, 'gf', 's3_storage_settings', 'S3 Storage Settings', NULL, NULL),
(994, 'gf', 'web_hook_url', 'Web Hook Url', NULL, NULL),
(995, 'gf', 'chanel_name', 'Chanel Name', NULL, NULL),
(996, 'gf', 'optional', 'Optional', NULL, NULL),
(997, 'gf', 'use_default_captcha', 'Use Default Captcha', NULL, NULL),
(998, 'gf', 'socail_login_setup', 'Socail Login Setup', NULL, NULL),
(999, 'gf', 'active', 'Active', NULL, NULL),
(1000, 'gf', 'inactive', 'Inactive', NULL, NULL),
(1001, 'gf', 'callback_url', 'Callback Url', NULL, NULL),
(1002, 'gf', 'site_logo', 'Site Logo', NULL, NULL),
(1003, 'gf', 'logo_icon', 'Logo Icon', NULL, NULL),
(1004, 'gf', 'frontend_logo', 'Frontend Logo', NULL, NULL),
(1005, 'gf', 'site_favicon', 'Site Favicon', NULL, NULL),
(1006, 'gf', 'cron_job_setting', 'Cron Job Setting', NULL, NULL),
(1007, 'gf', 'cron_job_', 'Cron Job ', NULL, NULL),
(1008, 'gf', 'set_time_for_1_minute', 'Set time for 1 minute', NULL, NULL),
(1009, 'gf', 'close', 'Close							', NULL, NULL),
(1010, 'gf', 'successfully_reseted', 'Successfully Reseted', NULL, NULL),
(1011, 'gf', 'feild_is_required', 'Feild is Required', NULL, NULL),
(1012, 'gf', 'system_setting_has_been_updated', 'System Setting has been updated', NULL, NULL),
(1013, 'gf', 'anonymous_messages', 'Anonymous Messages', NULL, NULL),
(1014, 'gf', 'start_chating_by_select_a_user', 'Start chating by select a user', NULL, NULL),
(1015, 'gf', 'please_enter_a_message', 'Please Enter a Message', NULL, NULL),
(1016, 'gf', 'type_your_message', 'Type your message', NULL, NULL),
(1017, 'gf', 'you_can_not_reply_to_this_conversations', 'You Can not reply to this conversations', NULL, NULL),
(1018, 'gf', 'please_set_up_your_pusher_configuration_first', 'Please set up your Pusher configuration first!', NULL, NULL),
(1019, 'gf', 'something_went_wrong_', 'Something went wrong !!', NULL, NULL),
(1020, 'gf', 'validation_error', 'Validation Error', NULL, NULL),
(1021, 'gf', 'chat_list', 'Chat list', NULL, NULL),
(1022, 'gf', 'no_message_found', 'No Message Found', NULL, NULL),
(1023, 'gf', 'assign', 'Assign', NULL, NULL),
(1024, 'gf', 'manage_frontend_section', 'Manage frontend section', NULL, NULL),
(1025, 'gf', 'frontends', 'Frontends', NULL, NULL),
(1026, 'gf', 'section_list', 'Section List', NULL, NULL),
(1027, 'gf', 'search_here', 'Search Here', NULL, NULL),
(1028, 'gf', 'title', 'Title', NULL, NULL),
(1029, 'gf', 'type_here', 'Type Here', NULL, NULL),
(1030, 'gf', 'description', 'Description', NULL, NULL),
(1031, 'gf', 'banner_image', 'Banner image', NULL, NULL),
(1032, 'gf', 'sub_title', 'Sub title', NULL, NULL),
(1033, 'gf', 'btn_text', 'Btn text', NULL, NULL),
(1034, 'gf', 'btn_url', 'Btn url', NULL, NULL),
(1035, 'gf', 'text', 'Text', NULL, NULL),
(1036, 'gf', 'see_icon', 'See Icon', NULL, NULL),
(1037, 'gf', 'update_system', 'Update System', NULL, NULL),
(1038, 'gf', 'system_update', 'System Update', NULL, NULL),
(1039, 'gf', 'update_application', 'Update Application', NULL, NULL),
(1040, 'gf', 'current_version', 'Current Version', NULL, NULL),
(1041, 'gf', 'v', 'V', NULL, NULL),
(1042, 'gf', 'upload_zip_file', 'Upload Zip file', NULL, NULL),
(1043, 'gf', 'update_now', 'Update Now', NULL, NULL),
(1044, 'gf', 'file_field_is_required', 'File field is required', NULL, NULL),
(1045, 'gf', 'support', 'Support', NULL, NULL),
(1046, 'gf', 'search_your_question_', 'Search Your Question ....', NULL, NULL),
(1047, 'gf', 'search', 'Search', NULL, NULL),
(1048, 'gf', 'contact', 'Contact', NULL, NULL),
(1049, 'gf', 'write_us', 'Write Us', NULL, NULL),
(1050, 'gf', 'enter_your_name', 'Enter Your Name', NULL, NULL),
(1051, 'gf', 'enter_your_subject', 'Enter Your Subject', NULL, NULL),
(1052, 'gf', 'message', 'Message', NULL, NULL),
(1053, 'gf', 'type_your_message_here_', 'Type Your Message Here.......... ', NULL, NULL),
(1054, 'gf', 'email_us', 'Email us', NULL, NULL),
(1055, 'gf', 'our_friendly_team_is_here_to_help', 'Our friendly team is here to help.', NULL, NULL),
(1056, 'gf', 'call_to_us', 'Call to us', NULL, NULL),
(1057, 'gf', 'monfri_from_10am_to_6pm', 'Mon-Fri From 10am to 6pm', NULL, NULL),
(1058, 'gf', 'visit_us', 'Visit us', NULL, NULL),
(1059, 'gf', 'come_say_hello_at_our_office_hq', 'Come say hello at our office HQ', NULL, NULL),
(1060, 'gf', 'create_ticket_here', 'Create Ticket Here', NULL, NULL),
(1061, 'gf', 'files', 'files', NULL, NULL),
(1062, 'gf', 'create', 'Create', NULL, NULL),
(1063, 'gf', 'enter_email', 'Enter Email', NULL, NULL),
(1064, 'gf', 'start', 'Start', NULL, NULL),
(1065, 'gf', 'type__hit_enter', 'Type & hit enter', NULL, NULL),
(1066, 'gf', 'pusher_configuration_error', 'Pusher configuration Error!!', NULL, NULL),
(1067, 'gf', 'manage_language', 'Manage language', NULL, NULL),
(1068, 'gf', 'language', 'Language', NULL, NULL),
(1069, 'gf', 'language_list', 'Language List', NULL, NULL),
(1070, 'gf', 'add_new_language', 'Add New Language', NULL, NULL),
(1071, 'gf', 'code', 'Code', NULL, NULL),
(1072, 'gf', 'options', 'Options', NULL, NULL),
(1073, 'gf', 'make_default', 'Make Default', NULL, NULL),
(1074, 'gf', 'default', 'Default', NULL, NULL),
(1075, 'gf', 'add_language', 'Add Language', NULL, NULL),
(1076, 'gf', 'add', 'Add', NULL, NULL),
(1077, 'gf', 'are_you_sure_', 'Are you sure ?', NULL, NULL),
(1078, 'gf', 'are_you_sure_you_want_to____________________________remove_this_record_', 'Are you sure you want to                            remove this record ?', NULL, NULL),
(1079, 'gf', 'yes_delete_it', 'Yes, Delete It!', NULL, NULL),
(1080, 'gf', 'system_information', 'System Information', NULL, NULL),
(1081, 'gf', 'server_information', 'Server information', NULL, NULL),
(1082, 'gf', 'value', 'Value', NULL, NULL),
(1083, 'gf', 'php_versions', 'PHP versions', NULL, NULL),
(1084, 'gf', 'laravel_versions', 'Laravel versions', NULL, NULL),
(1085, 'gf', 'http_host', 'HTTP host', NULL, NULL),
(1086, 'gf', 'phpini_config', 'php.ini Config', NULL, NULL),
(1087, 'gf', 'config_name', 'Config Name', NULL, NULL),
(1088, 'gf', 'current', 'Current', NULL, NULL),
(1089, 'gf', 'recommended', 'Recommended', NULL, NULL),
(1090, 'gf', 'file_uploads', 'File uploads', NULL, NULL),
(1091, 'gf', 'on', 'On', NULL, NULL),
(1092, 'gf', 'max_file_uploads', 'Max File Uploads', NULL, NULL),
(1093, 'gf', 'allow_url_fopen', 'Allow url Fopen', NULL, NULL),
(1094, 'gf', 'max_execution_time', 'Max Execution time', NULL, NULL),
(1095, 'gf', 'max_input_time', 'Max Input time', NULL, NULL),
(1096, 'gf', 'max_input_vars', 'Max Input vars', NULL, NULL),
(1097, 'gf', 'memory_limit', 'Memory limit', NULL, NULL),
(1098, 'gf', 'unlimited', 'Unlimited', NULL, NULL),
(1099, 'gf', 'extensions', 'Extensions', NULL, NULL),
(1100, 'gf', 'extension_name', 'Extension Name', NULL, NULL),
(1101, 'gf', 'file__folder_permissions', 'File & Folder Permissions', NULL, NULL),
(1102, 'gf', 'file_or_folder', 'File or Folder', NULL, NULL),
(1103, 'gf', 'manage_ip', 'Manage Ip', NULL, NULL),
(1104, 'gf', 'ip_list', 'Ip List', NULL, NULL),
(1105, 'gf', 'filter_by_ip', 'Filter by ip', NULL, NULL),
(1106, 'gf', 'filter', 'Filter', NULL, NULL),
(1107, 'gf', 'reset', 'Reset', NULL, NULL),
(1108, 'gf', 'ip', 'Ip', NULL, NULL),
(1109, 'gf', 'blocked', 'Blocked', NULL, NULL),
(1110, 'gf', 'last_visited', 'Last Visited', NULL, NULL),
(1111, 'gf', 'add_ip', 'Add Ip', NULL, NULL),
(1112, 'gf', 'ip_address', 'Ip Address', NULL, NULL),
(1113, 'gf', 'enter_ip', 'Enter ip', NULL, NULL),
(1114, 'gf', 'visistor_agent_info', 'Visistor Agent Info', NULL, NULL),
(1115, 'gf', 'dos_security_settings', 'Dos Security Settings', NULL, NULL),
(1116, 'gf', 'prevent_dos_attack', 'Prevent Dos Attack', NULL, NULL),
(1117, 'gf', 'if_there_are_more_than', 'If there are more than', NULL, NULL),
(1118, 'gf', 'attempts_in', 'attempts in', NULL, NULL),
(1119, 'gf', 'second', 'second', NULL, NULL),
(1120, 'gf', 'show_captcha', 'Show Captcha', NULL, NULL),
(1121, 'gf', 'block_ip', 'Block Ip', NULL, NULL),
(1122, 'gf', 'plugin_setting_has_been_updated', 'Plugin Setting has been updated', NULL, NULL);
INSERT INTO `translations` (`id`, `code`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1123, 'gf', 'chat_gpt_settings', 'Chat Gpt Settings', NULL, NULL),
(1124, 'gf', 'open_ai_api_key', 'Open AI Api Key', NULL, NULL),
(1125, 'gf', 'api_key', 'Api Key', NULL, NULL),
(1126, 'gf', 'inbox', 'Inbox', NULL, NULL),
(1127, 'gf', 'tags', 'Tags', NULL, NULL),
(1128, 'gf', 'export', 'Export', NULL, NULL),
(1129, 'gf', 'export_as_pdf', 'Export As Pdf', NULL, NULL),
(1130, 'gf', 'export_as_csv', 'Export As Csv', NULL, NULL),
(1131, 'gf', 'select_status', 'Select status', NULL, NULL),
(1132, 'gf', 'select_priority', 'Select Priority', NULL, NULL),
(1133, 'gf', 'search_by_date', 'Search By Date', NULL, NULL),
(1134, 'gf', 'search_by_name_or_ticket_number', 'Search By Name, or Ticket Number', NULL, NULL),
(1135, 'gf', 'make_mine', 'Make Mine', NULL, NULL),
(1136, 'gf', 'mark_as_', 'Mark as ', NULL, NULL),
(1137, 'gf', 'are_you_sure_you_want_to________________________________remove_this_record_', 'Are you sure you want to                                remove this record ?', NULL, NULL),
(1138, 'gf', 'respone__resolve_time', 'Respone & Resolve Time', NULL, NULL),
(1139, 'gf', 'ticket_list', 'Ticket List', NULL, NULL),
(1140, 'gf', 'user', 'User', NULL, NULL),
(1141, 'gf', 'last_reply', 'Last reply', NULL, NULL),
(1142, 'gf', 'assign_to', 'Assign to', NULL, NULL),
(1143, 'gf', 'priority', 'Priority', NULL, NULL),
(1144, 'gf', 'action', 'Action', NULL, NULL),
(1145, 'gf', 'mine', 'Mine', NULL, NULL),
(1146, 'gf', 'assigned', 'Assigned', NULL, NULL),
(1147, 'gf', 'unassigned', 'Unassigned', NULL, NULL),
(1148, 'gf', 'department', 'Department', NULL, NULL),
(1149, 'gf', 'manage_knowledgebase', 'Manage Knowledgebase', NULL, NULL),
(1150, 'gf', 'no_department_found', 'No department found', NULL, NULL),
(1151, 'gf', 'see_all_department', 'See all department', NULL, NULL),
(1152, 'gf', 'plese_select_a_department_first', 'Plese select a department first', NULL, NULL),
(1153, 'gf', 'search_here_', 'Search Here !!', NULL, NULL),
(1154, 'gf', 'department_list', 'Department List', NULL, NULL),
(1155, 'gf', 'add_department', 'Add Department', NULL, NULL),
(1156, 'gf', 'enter_name', 'Enter name', NULL, NULL),
(1157, 'gf', 'image', 'Image', NULL, NULL),
(1158, 'gf', 'manage_departments', 'Manage Departments', NULL, NULL),
(1159, 'gf', 'menu_list', 'Menu List', NULL, NULL),
(1160, 'gf', 'add_new_menu', 'Add New Menu', NULL, NULL),
(1161, 'gf', 'url', 'URL', NULL, NULL),
(1162, 'gf', 'add_menu', 'Add Menu', NULL, NULL),
(1163, 'gf', 'serial_id', 'Serial Id', NULL, NULL),
(1164, 'gf', 'enter_serial_id', 'Enter Serial Id', NULL, NULL),
(1165, 'gf', 'enter_url', 'Enter Url', NULL, NULL),
(1166, 'gf', 'header', 'Header', NULL, NULL),
(1167, 'gf', 'footer', 'Footer', NULL, NULL),
(1168, 'gf', 'update_menu', 'Update Menu', NULL, NULL),
(1169, 'gf', 'name_field_is_required', 'Name Field Is Required', NULL, NULL),
(1170, 'gf', 'name_field_must_be_unique', 'Name Field Must Be Unique', NULL, NULL),
(1171, 'gf', 'menu_url_is_required', 'Menu Url Is Required', NULL, NULL),
(1172, 'gf', 'serial_is_required', 'Serial Is Required', NULL, NULL),
(1173, 'gf', 'menu_created_successfully', 'Menu Created Successfully', NULL, NULL),
(1174, 'gf', 'how_can_we_help', 'How can we help', NULL, NULL),
(1175, 'gf', 'browse_by_departments', 'Browse by departments', NULL, NULL),
(1176, 'gf', 'please_select_a_department_first', 'Please select a department first', NULL, NULL),
(1177, 'gf', 'ticket_configurations', 'Ticket Configurations', NULL, NULL),
(1178, 'gf', 'settings', 'Settings', NULL, NULL),
(1179, 'gf', 'field_settings', 'Field Settings', NULL, NULL),
(1180, 'gf', 'operating_hour', 'Operating Hour', NULL, NULL),
(1181, 'gf', 'ticket_settings', 'Ticket Settings', NULL, NULL),
(1182, 'gf', 'enabling_this_option_will_activate_email_to_ticket_feature', 'Enabling this option will activate Email to ticket feature', NULL, NULL),
(1183, 'gf', 'enable', 'Enable', NULL, NULL),
(1184, 'gf', 'disable', 'Disable', NULL, NULL),
(1185, 'gf', 'enable_ticket_department', 'Enable ticket department', NULL, NULL),
(1186, 'gf', 'enabling_this_option_will_activate_ticket_department_selection_during_ticket_create', 'Enabling this option will activate ticket department selection during ticket create', NULL, NULL),
(1187, 'gf', 'agent_name_privacy', 'Agent name privacy', NULL, NULL),
(1188, 'gf', 'enabling_this_option_will_activated_agent_name_privacy_in_user_reply_section_user_will_not_able_to_see_who_replied', 'Enabling this option will activated agent name privacy in user reply section. user will not able to see who replied', NULL, NULL),
(1189, 'gf', 'message_seen_status', 'Message seen status', NULL, NULL),
(1190, 'gf', 'by_enabling_this_option_users_will_be_able_to_see_whether_their_messages_have_been_seen_by_an_agent_or_not', 'By enabling this option, users will be able to see whether their messages have been seen by an agent or not', NULL, NULL),
(1191, 'gf', 'user_ticket_close', 'User ticket close', NULL, NULL),
(1192, 'gf', 'enabling_this_option_will_allow_user_to_close_their_ticket', 'Enabling this option will allow user to close their ticket', NULL, NULL),
(1193, 'gf', 'ticket_prefix', 'Ticket Prefix', NULL, NULL),
(1194, 'gf', 'ticket_suffix', 'Ticket Suffix', NULL, NULL),
(1195, 'gf', 'random_number', 'Random Number', NULL, NULL),
(1196, 'gf', 'incremental', 'Incremental', NULL, NULL),
(1197, 'gf', 'guest_ticket', 'Guest Ticket', NULL, NULL),
(1198, 'gf', 'custom_files', 'Custom files', NULL, NULL),
(1199, 'gf', 'in_ticket_reply', 'In Ticket Reply', NULL, NULL),
(1200, 'gf', 'ticket_view_otp', 'Ticket View OTP', NULL, NULL),
(1201, 'gf', 'enabling_this_option_will_activate_the_otp_system_for_ticket_view', 'Enabling this option will activate the OTP system for ticket View', NULL, NULL),
(1202, 'gf', 'user_ticket_delete', 'User Ticket Delete', NULL, NULL),
(1203, 'gf', 'enabling_this_option_will_allow_user_to_delete_ticket_', 'Enabling this option will allow user to delete ticket ', NULL, NULL),
(1204, 'gf', 'auto_close_ticket', 'Auto Close Ticket', NULL, NULL),
(1205, 'gf', 'ticket_with_the_status', 'Ticket With the status', NULL, NULL),
(1206, 'gf', 'will_be_automatically_closed_if_there_is_no_response_from_the_user_within', 'will be automatically closed if there is no response from the user within', NULL, NULL),
(1207, 'gf', 'days', 'Days', NULL, NULL),
(1208, 'gf', 'duplicate_ticket_prevent', 'Duplicate ticket Prevent', NULL, NULL),
(1209, 'gf', 'user_cant_create_multiple_tickets_with_the_same_category_if_status_is_', 'User Can\'t create multiple tickets with the same category if status is ', NULL, NULL),
(1210, 'gf', 'field_configuration', 'Field Configuration', NULL, NULL),
(1211, 'gf', 'add_more', 'Add More', NULL, NULL),
(1212, 'gf', 'labels', 'Labels', NULL, NULL),
(1213, 'gf', 'type', 'Type', NULL, NULL),
(1214, 'gf', 'width', 'Width', NULL, NULL),
(1215, 'gf', 'mandatoryrequired', 'Mandatory/Required', NULL, NULL),
(1216, 'gf', 'visibility', 'Visibility', NULL, NULL),
(1217, 'gf', 'placeholder', 'Placeholder', NULL, NULL),
(1218, 'gf', 'visible', 'Visible', NULL, NULL),
(1219, 'gf', 'hidden', 'Hidden', NULL, NULL),
(1220, 'gf', 'na', 'N/A', NULL, NULL),
(1221, 'gf', 'ticket_short_notes', 'Ticket Short Notes', NULL, NULL),
(1222, 'gf', 'operating_hours', 'Operating Hours', NULL, NULL),
(1223, 'gf', 'enable_business_hours', 'Enable business hours', NULL, NULL),
(1224, 'gf', 'start_time', 'Start time', NULL, NULL),
(1225, 'gf', 'end_time', 'End time', NULL, NULL),
(1226, 'gf', 'select_time', 'Select time', NULL, NULL),
(1227, 'gf', 'select_end_time', 'Select end time', NULL, NULL),
(1228, 'gf', 'status_updated_successfully', 'Status Updated Successfully', NULL, NULL),
(1229, 'gf', 'support_agent', 'Support agent', NULL, NULL),
(1230, 'gf', 'offline', 'Offline', NULL, NULL),
(1231, 'gf', 'our_technical_team_is_available_in_the', 'Our technical team is available in the', NULL, NULL),
(1232, 'gf', 'timezone', 'timezone', NULL, NULL),
(1233, 'gf', 'please_select_end_time', 'Please select end time', NULL, NULL),
(1234, 'gf', 'please_select_start_time', 'Please select start time', NULL, NULL),
(1235, 'gf', 'setting_has_been_updated', 'Setting has been updated', NULL, NULL),
(1236, 'gf', 'closed', 'Closed', NULL, NULL),
(1237, 'gf', 'manange_triggering', 'Manange Triggering', NULL, NULL),
(1238, 'gf', 'triggers', 'Triggers', NULL, NULL),
(1239, 'gf', 'trigger_list', 'Trigger List', NULL, NULL),
(1240, 'gf', 'times_used', 'Times Used', NULL, NULL),
(1241, 'gf', 'last_action', 'Last Action', NULL, NULL),
(1242, 'gf', 'ticket_statuses', 'Ticket Statuses', NULL, NULL),
(1243, 'gf', 'ticket_status_list', 'Ticket Status List', NULL, NULL),
(1244, 'gf', 'products', 'Products', NULL, NULL),
(1245, 'gf', 'configuration', 'Configuration', NULL, NULL),
(1246, 'gf', 'enable_ticket_product', 'Enable ticket product', NULL, NULL),
(1247, 'gf', 'enabling_this_option_will_activate_ticket_product_selection_during_ticket_create', 'Enabling this option will activate ticket product selection during ticket create', NULL, NULL),
(1248, 'gf', 'user_ticket_reopen', 'User ticket re-open', NULL, NULL),
(1249, 'gf', 'enabling_this_option_will_allow_user_to_reopen_their_cloesed_ticket', 'Enabling this option will allow user to re-open their cloesed ticket', NULL, NULL),
(1250, 'gf', 'incoming_email_gateways', 'Incoming Email Gateways', NULL, NULL),
(1251, 'gf', 'create_gateway', 'Create Gateway', NULL, NULL),
(1252, 'gf', 'must_be_unique', 'Must be unique', NULL, NULL),
(1253, 'gf', 'product', 'Product', NULL, NULL),
(1254, 'gf', 'seletct_product', 'Seletct product', NULL, NULL),
(1255, 'gf', 'gateways', 'Gateways', NULL, NULL),
(1256, 'gf', 'you_can_reach_our_technical_team_during_hours_aligned_with_the_', 'You can reach our technical team during hours aligned with the ', NULL, NULL),
(1257, 'gf', 'start__end_time', 'Start & End time', NULL, NULL),
(1258, 'gf', '24_hour', '24 Hour', NULL, NULL),
(1259, 'gf', 'online', 'Online', NULL, NULL),
(1260, 'gf', 'operating_hours_note', 'Operating Hours Note', NULL, NULL),
(1261, 'gf', 'notification_variables', 'Notification variables', NULL, NULL),
(1262, 'gf', 'order_variable', 'Order Variable', NULL, NULL),
(1263, 'gf', 'item_variable', 'Item Variable', NULL, NULL),
(1264, 'gf', 'sms__email', 'SMS & Email', NULL, NULL),
(1265, 'gf', 'whatsapp', 'WhatsApp', NULL, NULL),
(1266, 'gf', 'sms_message', 'SMS Message', NULL, NULL),
(1267, 'gf', 'enter_message', 'Enter message', NULL, NULL),
(1268, 'gf', 'email_message', 'Email Message', NULL, NULL),
(1269, 'gf', 'templates', 'Templates', NULL, NULL),
(1270, 'gf', 'template', 'Template', NULL, NULL),
(1271, 'gf', 'load_template', 'Load template', NULL, NULL),
(1272, 'gf', 'select_a_template', 'Select a template', NULL, NULL),
(1273, 'gf', 'note', 'Note', NULL, NULL),
(1274, 'gf', 'select_audience', 'Select Audience', NULL, NULL),
(1275, 'gf', 'instaction_note', 'Instaction Note', NULL, NULL),
(1276, 'gf', 'select_product', 'Select product', NULL, NULL),
(1277, 'gf', 'variables', 'Variables', NULL, NULL),
(1278, 'gf', 'global_email_template', 'Global Email Template', NULL, NULL),
(1279, 'gf', 'email_template_short_code', 'Email Template Short Code', NULL, NULL),
(1280, 'gf', 'sent_from_email', 'Sent From Email', NULL, NULL),
(1281, 'gf', 'email_template', 'Email Template', NULL, NULL),
(1282, 'gf', 'mail_template_short_code', 'Mail Template Short Code', NULL, NULL),
(1283, 'gf', 'mail_body', 'Mail Body', NULL, NULL),
(1284, 'gf', 'system_timezone', 'System timezone', NULL, NULL),
(1285, 'gf', 'enter_note', 'Enter note', NULL, NULL),
(1286, 'gf', 'envato_configuration', 'Envato Configuration', NULL, NULL),
(1287, 'gf', 'label', 'Label', NULL, NULL),
(1288, 'gf', 'drag_the_card_in_any_section', 'Drag the card in any section', NULL, NULL),
(1289, 'gf', 'mandatory', 'Mandatory', NULL, NULL),
(1290, 'gf', 'add_more_input_field', 'Add More Input Field', NULL, NULL),
(1291, 'gf', 'set_a_label', 'Set a Label', NULL, NULL),
(1292, 'gf', 'select_type', 'Select Type', NULL, NULL),
(1293, 'gf', 'yes', 'Yes', NULL, NULL),
(1294, 'gf', 'no', 'No', NULL, NULL),
(1295, 'gf', 'set_a_placeholder_for_this_new_input_field', 'Set a placeholder for this new input field', NULL, NULL),
(1296, 'gf', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', NULL, NULL),
(1297, 'gf', 'update_input_field', 'Update Input Field', NULL, NULL),
(1298, 'gf', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', NULL, NULL),
(1299, 'gf', 'option_value', 'Option Value', NULL, NULL),
(1300, 'gf', 'display_name', 'Display Name', NULL, NULL),
(1301, 'gf', 'multiple_seclect', 'Multiple Seclect', NULL, NULL),
(1302, 'gf', 'single_select', 'Single Select', NULL, NULL),
(1303, 'gf', 'option_display_name', 'Option display name', NULL, NULL),
(1304, 'gf', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', NULL, NULL),
(1305, 'gf', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', NULL, NULL),
(1306, 'gf', 'envato_business_configuration', 'Envato Business Configuration', NULL, NULL),
(1307, 'gf', 'save__sync', 'Save & Sync', NULL, NULL),
(1308, 'gf', 'envato_settings', 'Envato Settings', NULL, NULL),
(1309, 'gf', 'envato_verifications', 'Envato verifications', NULL, NULL),
(1310, 'gf', 'enabling_this_option_will_activate_envato_verification_during_ticket_creation_if_the_product_is_synced_from_envato', 'Enabling this option will activate Envato verification during ticket creation if the product is synced from Envato.', NULL, NULL),
(1311, 'gf', 'enable_support_duration_verification', 'Enable support duration verification', NULL, NULL),
(1312, 'gf', 'enabling_this_option_will_activate_validation_of_the_envato_product_support_duration_during_ticket_creation', 'Enabling this option will activate validation of the Envato product support duration during ticket creation', NULL, NULL),
(1313, 'gf', 'ticket_status_is_', 'Ticket status is ', NULL, NULL),
(1314, 'gf', 'if_the_envato_support_is_expired', 'if the envato support is expired', NULL, NULL),
(1315, 'gf', 'envatio_support_expired_mail', 'Envatio support expired mail', NULL, NULL),
(1316, 'gf', 'this_email_will_be_sent_when_a_clients_envato_support_has_expired', 'This email will be sent when a clients Envato support has expired', NULL, NULL),
(1317, 'gf', 'are_you_sure', 'Are you sure?', NULL, NULL),
(1318, 'gf', 'this_will_reset_any_previous_item_changes_of_this_author', 'This will reset any previous item changes of this Author', NULL, NULL),
(1319, 'gf', 'log_into_your_account', 'Log Into Your Account', NULL, NULL),
(1320, 'gf', 'were_glad_to_see_you_again', 'We\'re glad to see you again!', NULL, NULL),
(1321, 'gf', 'enter_captcha_value', 'Enter captcha value', NULL, NULL),
(1322, 'gf', 'dont_have_an_account', 'Don\'t have an account', NULL, NULL),
(1323, 'gf', 'create_new', 'Create New', NULL, NULL),
(1324, 'gf', 'user_login', 'User Login', NULL, NULL),
(1325, 'gf', 'assign_ticket_with_sort_notes', 'Assign Ticket With Sort Notes', NULL, NULL),
(1326, 'gf', 'me', 'Me', NULL, NULL),
(1327, 'gf', 'write_short_note_here', 'Write Short Note Here', NULL, NULL),
(1328, 'gf', 'source', 'Source', NULL, NULL),
(1329, 'gf', 'manage_agent', 'Manage Agent', NULL, NULL),
(1330, 'gf', 'agents', 'Agents', NULL, NULL),
(1331, 'gf', 'add_new_agent', 'Add New Agent', NULL, NULL),
(1332, 'gf', 'avg_response_time__responsed_tickets', 'Avg Response Time - Responsed Tickets', NULL, NULL),
(1333, 'gf', 'best_agent', 'Best Agent', NULL, NULL),
(1334, 'gf', 'update_password', 'Update password', NULL, NULL),
(1335, 'gf', 'minimum_5_character_required', 'Minimum 5 Character Required!!', NULL, NULL),
(1336, 'gf', 'confirm_password', 'Confirm Password', NULL, NULL),
(1337, 'gf', 'create__agent', 'Create  Agent', NULL, NULL),
(1338, 'gf', 'create_agent', 'Create Agent', NULL, NULL),
(1339, 'gf', 'agent', 'Agent', NULL, NULL),
(1340, 'gf', 'super_agent', 'Super agent', NULL, NULL),
(1341, 'gf', 'examplegamilcom', 'example@gamil.com', NULL, NULL),
(1342, 'gf', 'enter_phone_number', 'Enter Phone Number', NULL, NULL),
(1343, 'gf', 'access_categories', 'Access Categories', NULL, NULL),
(1344, 'gf', 'permissions', 'Permissions', NULL, NULL),
(1345, 'gf', 'email_field_is_required', 'Email Field is Required', NULL, NULL),
(1346, 'gf', 'this_email_is_already_taken', 'This email is already taken', NULL, NULL),
(1347, 'gf', 'user_name_field_is_required', 'User Name Field Is Required', NULL, NULL),
(1348, 'gf', 'this_username_is_already_taken', 'This username is already taken', NULL, NULL),
(1349, 'gf', 'phone_field_is_required', 'Phone Field Is Required', NULL, NULL),
(1350, 'gf', 'please_select_a_category', 'Please Select a Category', NULL, NULL),
(1351, 'gf', 'permission_is_required', 'Permission Is Required', NULL, NULL),
(1352, 'gf', 'please_select_an_status', 'Please Select An Status', NULL, NULL),
(1353, 'gf', 'password_feild_is_required', 'Password Feild Is Required', NULL, NULL),
(1354, 'gf', 'confirm_password_does_not_match', 'Confirm Password Does not Match', NULL, NULL),
(1355, 'gf', 'minimum_5_digit_or_character_is_required', 'Minimum 5 digit or character is required', NULL, NULL),
(1356, 'gf', 'select_your_address', 'Select Your Address', NULL, NULL),
(1357, 'gf', 'agent_creted_successfully', 'Agent Creted Successfully', NULL, NULL),
(1358, 'gf', 'create__user', 'Create  User', NULL, NULL),
(1359, 'gf', 'users', 'Users', NULL, NULL),
(1360, 'gf', 'create_user', 'Create User', NULL, NULL),
(1361, 'gf', 'user_name_feild_is_required', 'User Name Feild Is Required', NULL, NULL),
(1362, 'gf', 'email_feild_is_required', 'Email Feild Is Required', NULL, NULL),
(1363, 'gf', 'email_feild_must_be_unique', 'Email Feild Must Be Unique', NULL, NULL),
(1364, 'gf', 'phone_feild_is_required', 'Phone Feild Is Required', NULL, NULL),
(1365, 'gf', 'phone_feild_must_be_unique', 'Phone Feild Must Be Unique', NULL, NULL),
(1366, 'gf', 'please_select_a_status', 'Please Select A Status', NULL, NULL),
(1367, 'gf', 'user_created_successfully', 'User Created Successfully', NULL, NULL),
(1368, 'gf', 'manage_users', 'Manage Users', NULL, NULL),
(1369, 'gf', 'add_new_user', 'Add New User', NULL, NULL),
(1370, 'gf', 'user_not_found', 'User Not Found', NULL, NULL),
(1371, 'gf', 'successfully_login_as_a_user', 'SuccessFully Login As a User', NULL, NULL),
(1372, 'gf', 'last_activity', 'Last Activity', NULL, NULL),
(1373, 'gf', 'ticket_by_month', 'Ticket By Month', NULL, NULL),
(1374, 'gf', 'user_dashboard', 'User dashboard', NULL, NULL),
(1375, 'gf', 'chat', 'Chat', NULL, NULL),
(1376, 'gf', 'manage_ticket', 'Manage Ticket', NULL, NULL),
(1377, 'gf', 'canned_reply', 'Canned Reply', NULL, NULL),
(1378, 'gf', 'accept_our_cookie', 'Accept Our Cookie', NULL, NULL),
(1379, 'gf', 'accept__continue', 'Accept & Continue', NULL, NULL),
(1380, 'gf', 'monday', 'Monday', NULL, NULL),
(1381, 'gf', 'tuesday', 'Tuesday', NULL, NULL),
(1382, 'gf', 'wednesday', 'Wednesday', NULL, NULL),
(1383, 'gf', 'thursday', 'Thursday', NULL, NULL),
(1384, 'gf', 'friday', 'Friday', NULL, NULL),
(1385, 'gf', 'saturday', 'Saturday', NULL, NULL),
(1386, 'gf', '', '', NULL, NULL),
(1387, 'gf', 'manage_notifications', 'Manage Notifications', NULL, NULL),
(1388, 'gf', 'notifications_settings', 'Notifications Settings', NULL, NULL),
(1389, 'gf', 'notify_me_when', 'Notify me when', NULL, NULL),
(1390, 'gf', 'sms', 'Sms', NULL, NULL),
(1391, 'gf', 'browser', 'Browser', NULL, NULL),
(1392, 'gf', 'slack', 'Slack', NULL, NULL),
(1393, 'gf', 'there_is_a_new_ticketconversation', 'There is a New Ticket/Conversation', NULL, NULL),
(1394, 'gf', 'notify_me_when_agent', 'Notify me when Agent', NULL, NULL),
(1395, 'gf', 'replied_to_a_conversations', 'Replied To A Conversations', NULL, NULL),
(1396, 'gf', 'assign_a_ticket_to_', 'Assign a Ticket To ', NULL, NULL),
(1397, 'gf', 'notify_me_when_customer', 'Notify me when Customer', NULL, NULL),
(1398, 'gf', 'replied_to_on_of_my_conversations', 'Replied To On Of My Conversations', NULL, NULL),
(1399, 'gf', 'start_a_new_chat_message_with_me', 'Start A New Chat (Message With Me)', NULL, NULL),
(1400, 'gf', 'replied_to_', 'Replied To ', NULL, NULL),
(1401, 'gf', 'admin_notifications_settings', 'Admin Notifications Settings', NULL, NULL),
(1402, 'gf', 'notifications_settings_updated', 'Notifications Settings Updated', NULL, NULL),
(1403, 'gf', 'social_login_setup', 'Social Login Setup', NULL, NULL),
(1404, 'gf', 'mail_configuration', 'Mail Configuration', NULL, NULL),
(1405, 'gf', 'mail_gateway', 'Mail Gateway', NULL, NULL),
(1406, 'gf', 'mail_gateway_list', 'Mail Gateway List', NULL, NULL),
(1407, 'gf', 'gateway_name', 'Gateway Name', NULL, NULL),
(1408, 'gf', 'update_gateway', 'Update Gateway', NULL, NULL),
(1409, 'gf', 'email_gateway', 'Email Gateway', NULL, NULL),
(1410, 'gf', 'driver', 'Driver', NULL, NULL),
(1411, 'gf', 'enter_driver', 'Enter Driver', NULL, NULL),
(1412, 'gf', 'host', 'Host', NULL, NULL),
(1413, 'gf', 'enter_host', 'Enter Host', NULL, NULL),
(1414, 'gf', 'port', 'Port', NULL, NULL),
(1415, 'gf', 'enter_port', 'Enter Port', NULL, NULL),
(1416, 'gf', 'encryption', 'Encryption', NULL, NULL),
(1417, 'gf', 'enter_encryption', 'Enter Encryption', NULL, NULL),
(1418, 'gf', 'enter_mail_username', 'Enter Mail Username', NULL, NULL),
(1419, 'gf', 'enter_mail_password', 'Enter Mail Password', NULL, NULL),
(1420, 'gf', 'from_address', 'From Address', NULL, NULL),
(1421, 'gf', 'enter_from_address', 'Enter From Address', NULL, NULL),
(1422, 'gf', 'from_name', 'From Name', NULL, NULL),
(1423, 'gf', 'enter_from_name', 'Enter From Name', NULL, NULL),
(1424, 'gf', 'test_gateway', 'Test Gateway', NULL, NULL),
(1425, 'gf', 'enter_your_mail', 'Enter Your Mail', NULL, NULL),
(1426, 'gf', 'test', 'Test', NULL, NULL),
(1427, 'gf', 'smtp_mail_method_has_been_updated', 'SMTP mail method has been updated', NULL, NULL),
(1428, 'gf', 'mail_configuration_error_please_check_your_mail_configuration_properly', 'Mail Configuration Error, Please check your mail configuration properly', NULL, NULL),
(1429, 'gf', 'categories', 'Categories', NULL, NULL),
(1430, 'gf', 'category_list', 'Category List', NULL, NULL),
(1431, 'gf', 'inctive', 'Inctive', NULL, NULL),
(1432, 'gf', 'delete', 'Delete', NULL, NULL),
(1433, 'gf', 'search_by_name', 'Search By Name', NULL, NULL),
(1434, 'gf', 'add_category', 'Add Category', NULL, NULL),
(1435, 'gf', 'sort_details', 'Sort Details', NULL, NULL),
(1436, 'gf', 'write_sort_details_here', 'Write sort Details Here', NULL, NULL),
(1437, 'gf', 'do_you_want_to_delete_these_records', 'Do You Want To Delete These Records??', NULL, NULL),
(1438, 'gf', 'name_feild_must_be_required', 'Name Feild Must Be Required', NULL, NULL),
(1439, 'gf', 'category_name_must_be_unique', 'Category Name Must Be Unique', NULL, NULL),
(1440, 'gf', 'short_details_is_required', 'Short Details Is Required', NULL, NULL),
(1441, 'gf', 'category_created_successfully', 'Category Created Successfully', NULL, NULL),
(1442, 'gf', '_feild_is_required', ' Feild Is Required', NULL, NULL),
(1443, 'gf', 'you_have_a_new_unassigned_ticket', 'You Have a New Unassigned Ticket', NULL, NULL),
(1444, 'gf', 'ticket_successfully_created_', 'Ticket Successfully Created ', NULL, NULL),
(1445, 'gf', 'notification_please_review_your_email', 'Notification: Please Review Your Email', NULL, NULL),
(1446, 'gf', 'ticket_issued_your_ticketid_is_', 'Ticket Issued: Your TicketId Is ', NULL, NULL),
(1447, 'gf', 'your_ticket', 'Your Ticket', NULL, NULL),
(1448, 'gf', 'ticket_details', 'Ticket Details', NULL, NULL),
(1449, 'gf', 'ticket_number', 'Ticket Number', NULL, NULL),
(1450, 'gf', 'user_name', 'User Name', NULL, NULL),
(1451, 'gf', 'user_email', 'User Email', NULL, NULL),
(1452, 'gf', 'category', 'Category', NULL, NULL),
(1453, 'gf', 'create_date', 'Create Date', NULL, NULL),
(1454, 'gf', 'custom_ticket_data', 'Custom Ticket Data', NULL, NULL),
(1455, 'gf', 'no_file_found', 'No file Found', NULL, NULL),
(1456, 'gf', 'main_ticket_attachment', 'Main Ticket Attachment', NULL, NULL),
(1457, 'gf', 'reply', 'Reply', NULL, NULL),
(1458, 'gf', 'envato_verification', 'Envato verification', NULL, NULL),
(1459, 'gf', 'upload_file', 'Upload File', NULL, NULL),
(1460, 'gf', 'maximum_file_upload_', 'Maximum File Upload :', NULL, NULL),
(1461, 'gf', 'load_more', 'Load More', NULL, NULL),
(1462, 'gf', 'reply_list', 'Reply List', NULL, NULL),
(1463, 'gf', 'select_template', 'Select Template', NULL, NULL),
(1464, 'gf', 'start_typing', 'Start typing...', NULL, NULL),
(1465, 'gf', 'something_went_wrong__please_try_agian', 'Something went wrong !! Please Try agian', NULL, NULL),
(1466, 'gf', 'view_ticket', 'View Ticket', NULL, NULL),
(1467, 'gf', 'unread_notifications', 'Unread Notifications', NULL, NULL),
(1468, 'gf', 'clear_all', 'Clear all', NULL, NULL),
(1469, 'gf', 'view_all_notifications', 'View All Notifications', NULL, NULL),
(1470, 'gf', 'pending_tickets_', 'Pending Tickets: ', NULL, NULL),
(1471, 'gf', 'all_notifications', 'All Notifications', NULL, NULL),
(1472, 'gf', 'notification', 'Notification', NULL, NULL),
(1473, 'gf', 'no_response_yet', 'No Response Yet', NULL, NULL),
(1474, 'gf', 'not_resolved_yet', 'Not Resolved Yet', NULL, NULL),
(1475, 'gf', 'ticket_id_feild_is_required', 'Ticket Id Feild Is Required', NULL, NULL),
(1476, 'gf', 'ticket_id_feild_must_be_an_array', 'Ticket Id Feild Must Be An Array', NULL, NULL),
(1477, 'gf', 'invalid_tickets_selected', 'Invalid Tickets Selected', NULL, NULL),
(1478, 'gf', 'you_have_a_new_assigned_ticket_by', 'You Have a New Assigned Ticket By', NULL, NULL),
(1479, 'gf', 'ticket_assigned_successfully', 'Ticket Assigned Successfully', NULL, NULL),
(1480, 'gf', 'agent_not_found', 'Agent Not Found', NULL, NULL),
(1481, 'gf', 'successfully_login_as_a_agent', 'SuccessFully Login As a Agent', NULL, NULL),
(1482, 'gf', 'profile_settings', 'Profile Settings', NULL, NULL),
(1483, 'gf', 'enter_your_user_name', 'Enter your User Name', NULL, NULL),
(1484, 'gf', 'phonenumber', 'Phone												Number', NULL, NULL),
(1485, 'gf', 'enter_your_phone_number', 'Enter your phone number', NULL, NULL),
(1486, 'gf', 'emailaddress', 'Email												Address', NULL, NULL),
(1487, 'gf', 'admin_profile', 'Admin Profile', NULL, NULL),
(1488, 'gf', 'change_password', 'Change Password', NULL, NULL),
(1489, 'gf', 'old_password', 'Old													 Password', NULL, NULL),
(1490, 'gf', 'enter_current_password', 'Enter current password', NULL, NULL),
(1491, 'gf', 'newpassword', 'New													Password', NULL, NULL),
(1492, 'gf', 'enter_new_password', 'Enter new password', NULL, NULL),
(1493, 'gf', 'confirmpassword', 'Confirm													Password', NULL, NULL),
(1494, 'gf', 'changepassword', 'Change													Password', NULL, NULL),
(1495, 'gf', 'notification_not_found', 'Notification Not Found', NULL, NULL),
(1496, 'gf', 'notification_readed', 'Notification Readed', NULL, NULL),
(1497, 'gf', 'unauthorized_access', 'Unauthorized access', NULL, NULL),
(1498, 'gf', 'no_user_found_', 'No User Found !!', NULL, NULL),
(1499, 'gf', 'user_blocked', 'User Blocked', NULL, NULL),
(1500, 'gf', 'user_unblocked', 'User Unblocked', NULL, NULL),
(1501, 'gf', 'agent_update', 'Agent Update', NULL, NULL),
(1502, 'gf', 'update_agent', 'Update Agent', NULL, NULL),
(1503, 'gf', 'enter_your_phone', 'Enter Your Phone', NULL, NULL),
(1504, 'gf', 'agent_updated_successfully', 'Agent Updated Successfully', NULL, NULL),
(1505, 'gf', 'short_notes', 'Short Notes', NULL, NULL),
(1506, 'gf', 'previous_ticket', 'Previous Ticket', NULL, NULL),
(1507, 'gf', 'email_notifications', 'Email Notifications', NULL, NULL),
(1508, 'gf', 'enable_email_notification_form_system_notification_settings', 'Enable email notification form system notification settings', NULL, NULL),
(1509, 'gf', 'sms_notifications', 'Sms Notifications', NULL, NULL),
(1510, 'gf', 'enable_sms_notification_form_system_notification_settings', 'Enable sms notification form system notification settings', NULL, NULL),
(1511, 'gf', 'browser_notifications', 'Browser Notifications', NULL, NULL),
(1512, 'gf', 'enable_browser_notification_form_system_notification_settings_', 'Enable Browser notification form system notification settings ', NULL, NULL),
(1513, 'gf', 'ticket_files', 'Ticket Files', NULL, NULL),
(1514, 'gf', 'enter_purchase_key', 'Enter purchase key', NULL, NULL),
(1515, 'gf', 'verify_purchase', 'Verify purchase', NULL, NULL),
(1516, 'gf', 'send__', 'Send & ', NULL, NULL),
(1517, 'gf', 'add_note', 'Add Note', NULL, NULL),
(1518, 'gf', 'update_message', 'Update Message', NULL, NULL),
(1519, 'gf', 'original_message', 'Original Message', NULL, NULL),
(1520, 'gf', 'ticket', 'Ticket', NULL, NULL),
(1521, 'gf', 'merged_tickets_can_not_be_unmerged', 'Merged tickets can not be unmerged.', NULL, NULL),
(1522, 'gf', 'are_you_sure_you_want_merge_this_ticket_with_the_original_one_behind_the_popupsmerged_tickets_can_not_be_unmerged', 'Are you sure you want merge this ticket with the original one behind the pop-ups?Merged tickets can not be unmerged.', NULL, NULL),
(1523, 'gf', 'yes_merge_it', 'Yes, Merge It!', NULL, NULL),
(1524, 'gf', 'edit', 'Edit', NULL, NULL),
(1525, 'gf', 'show_original', 'Show Original', NULL, NULL),
(1526, 'gf', 'message_feild_is_required', 'Message Feild is Required', NULL, NULL),
(1527, 'gf', 'replied_successfully', 'Replied Successfully', NULL, NULL),
(1528, 'gf', 'hello_dear_', 'Hello Dear!!! ', NULL, NULL),
(1529, 'gf', 'replied_to', 'Replied To', NULL, NULL),
(1530, 'gf', 'new', 'New', NULL, NULL),
(1531, 'gf', 'ticket_closed', 'Ticket Closed', NULL, NULL),
(1532, 'gf', 'response_list', 'Response List', NULL, NULL),
(1533, 'gf', 'add_new_reply', 'Add New Reply', NULL, NULL),
(1534, 'gf', 'share_with', 'Share with', NULL, NULL),
(1535, 'gf', 'add_reply', 'Add Reply', NULL, NULL),
(1536, 'gf', 'body', 'Body', NULL, NULL),
(1537, 'gf', 'share_canned_reply', 'Share canned reply', NULL, NULL),
(1538, 'gf', 'assigned_to', 'Assigned To', NULL, NULL),
(1539, 'gf', 'slack_notifications', 'Slack Notifications', NULL, NULL),
(1540, 'gf', 'enable_slack_notification_form_system_notification_settings_', 'Enable Slack notification form system notification settings ', NULL, NULL),
(1541, 'gf', 'agent_doesnot_exists', 'Agent Doesnot Exists', NULL, NULL),
(1542, 'gf', 'deleted_successfully', 'Deleted Successfully', NULL, NULL),
(1543, 'gf', 'edit_ticket', 'Edit Ticket', NULL, NULL),
(1544, 'gf', 'ticket_category', 'Ticket category', NULL, NULL),
(1545, 'gf', 'select_category', 'Select category', NULL, NULL),
(1546, 'gf', 'product_list', 'Product List', NULL, NULL),
(1547, 'gf', 'add_product', 'Add Product', NULL, NULL),
(1548, 'gf', 'envato_product', 'Envato product', NULL, NULL),
(1549, 'gf', 'manage_product', 'Manage Product', NULL, NULL),
(1550, 'gf', 'default_name_is_required', 'Default name is required', NULL, NULL),
(1551, 'gf', 'default_name_must_be_unique', 'Default name must be unique', NULL, NULL),
(1552, 'gf', 'product_created_successfully', 'Product created successfully', NULL, NULL),
(1553, 'gf', 'system', 'System', NULL, NULL),
(1554, 'gf', 'product_updated_successfully', 'Product updated successfully', NULL, NULL),
(1555, 'gf', 'ticket_updated_successfully', 'Ticket updated successfully', NULL, NULL),
(1556, 'gf', 'cache_cleared_successfully', 'Cache Cleared Successfully', NULL, NULL),
(1557, 'gf', 'sms_gateway_list', 'Sms Gateway list', NULL, NULL),
(1558, 'gf', 'sms_global_template', 'SMS Global template', NULL, NULL),
(1559, 'gf', 'sms_template_short_code', 'Sms Template Short Code', NULL, NULL),
(1560, 'gf', 'email_templates', 'Email templates', NULL, NULL),
(1561, 'gf', 'template_list', 'Template List', NULL, NULL),
(1562, 'gf', '_name', ' Name', NULL, NULL),
(1563, 'gf', 'email_not_found', 'Email Not Found', NULL, NULL),
(1564, 'gf', 'manange_groups', 'Manange Groups', NULL, NULL),
(1565, 'gf', 'groups', 'Groups', NULL, NULL),
(1566, 'gf', 'group_list', 'Group List', NULL, NULL),
(1567, 'gf', 'add_new_', 'Add New ', NULL, NULL),
(1568, 'gf', 'optinos', 'Optinos', NULL, NULL),
(1569, 'gf', 'personal_details', 'Personal Details', NULL, NULL),
(1570, 'gf', 'user_profile', 'User Profile', NULL, NULL),
(1571, 'gf', 'language_switched_successfully', 'Language Switched Successfully', NULL, NULL),
(1572, 'gf', 'translate_language', 'Translate language', NULL, NULL),
(1573, 'gf', 'key', 'key', NULL, NULL),
(1574, 'gf', 'successfully_translated', 'Successfully Translated', NULL, NULL),
(1575, 'gf', 'translation_failed', 'Translation Failed', NULL, NULL),
(1576, 'gf', 'the_name_feild_is_required', 'The Name Feild is Required', NULL, NULL),
(1577, 'gf', 'the_name_must_be_unique', 'The Name Must Be Unique', NULL, NULL),
(1578, 'en', 'language_created_succesfully', 'Language Created Succesfully', '2024-12-19 15:14:32', '2024-12-19 15:14:32'),
(1579, 'en', 'subscribers_list', 'Subscribers List', '2024-12-19 15:36:15', '2024-12-19 15:36:15'),
(1580, 'en', 'send_mail', 'Send Mail', '2024-12-19 15:36:15', '2024-12-19 15:36:15'),
(1581, 'en', 'send', 'Send', '2024-12-19 15:36:15', '2024-12-19 15:36:15'),
(1582, 'en', 'succesfully_sent', 'Succesfully Sent', '2024-12-19 15:36:29', '2024-12-19 15:36:29'),
(1583, 'en', 'system_configuration', 'System Configuration', '2024-12-19 15:52:22', '2024-12-19 15:52:22'),
(1584, 'en', 'email_notification', 'Email Notification', '2024-12-19 15:52:22', '2024-12-19 15:52:22'),
(1585, 'en', 'enable_or_disable_email_notifications_for_various_events_or_activities_within_the_system_this_allows_you_to_stay_updated_via_email', 'Enable or disable email notifications for various events or activities within the system. This allows you to stay updated via email.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1586, 'en', 'sms_notification', 'SMS Notification', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1587, 'en', 'activate_or_deactivate_sms_notifications_which_can_be_used_to_receive_important_alerts_or_updates_via_text_messages', 'Activate or deactivate SMS notifications, which can be used to receive important alerts or updates via text messages.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1588, 'en', 'captcha_validations', 'Captcha Validations', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1589, 'en', 'enable_or_disable_captcha_validations_which_help_prevent_automated_spam_or_abuse_by_requiring_users_to_complete_a_verification_process', 'Enable or disable Captcha validations, which help prevent automated spam or abuse by requiring users to complete a verification process.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1590, 'en', 'database_notifications', 'Database Notifications', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1591, 'en', 'control_the_systems_notifications_related_to_database_activities_such_as_updates_or_changes_to_the_database', 'Control the system\'s notifications related to database activities, such as updates or changes to the database.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1592, 'en', 'integrate_the_system_with_slack_and_receive_notifications_directly_in_your_slack_workspace_for_realtime_updates', 'Integrate the system with Slack and receive notifications directly in your Slack workspace for real-time updates.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1593, 'en', 'cookie_activation', 'Cookie Activation', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1594, 'en', 'enable_or_disable_the_use_of_cookies_for_user_sessions_and_tracking_purposes', 'Enable or disable the use of cookies for user sessions and tracking purposes.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1595, 'en', 'automatic_ticket_assign', 'Automatic Ticket Assign', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1596, 'en', 'configure_the_system_to_automatically_assign_incoming_tickets_or_tasks_to_specific_agents_or_teams_based_on_predefined_rules_or_criteria', 'Configure the system to automatically assign incoming tickets or tasks to specific agents or teams based on predefined rules or criteria.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1597, 'en', 'group_base_ticket_assign', 'Group Base Ticket Assign', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1598, 'en', 'configure_the_system_to_automatically_assign_incoming_tickets_or_tasks_to_specific_agents_or_teams_based_on_priority_group', 'Configure the system to automatically assign incoming tickets or tasks to specific agents or teams based on Priority Group', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1599, 'en', 'ticket_security', 'Ticket Security', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1600, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1601, 'en', 'user_registration', 'User Registration', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1602, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1603, 'en', 'user_notifications', 'User Notifications', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1604, 'en', 'activating_the_initial_module_will_enable_browser_and_email_notifications_for_newly_registered_users', 'Activating the initial module will enable browser and email notifications for newly registered users', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1605, 'en', 'email_verifications', 'Email Verifications', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1606, 'en', 'set_up_email_verification_processes_to_ensure_that_users_email_addresses_are_valid_and_to_enhance_security_and_authenticity', 'Set up email verification processes to ensure that users email addresses are valid and to enhance security and authenticity.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1607, 'en', 'agent_chat_module', 'Agent Chat Module', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1608, 'en', 'manage_the_agent_chat_module_enabling_agents_to_communicate_and_provide_realtime_support_to_users_through_a_chat_interface', 'Manage the agent chat module, enabling agents to communicate and provide real-time support to users through a chat interface.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1609, 'en', 'app_debug', 'App Debug', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1610, 'en', 'enable_or_disable_the_app_debug_mode_which_allows_for_the_detection_and_resolution_of_software_bugs_or_issues_by_providing_detailed_error_messages_or_logs', 'Enable or disable the app debug mode, which allows for the detection and resolution of software bugs or issues by providing detailed error messages or logs.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1611, 'en', 'terms__conditions_validation', 'Terms & Conditions Validation', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1612, 'en', 'implement_validation_mechanisms_to_ensure_that_users_agree_to_and_comply_with_the_terms_and_conditions_of_using_the_system_or_application', 'Implement validation mechanisms to ensure that users agree to and comply with the terms and conditions of using the system or application.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1613, 'en', 'automated_best_agent_identification', 'Automated Best Agent Identification', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1614, 'en', 'enabling_this_module_activates_the_automatic_best_agent_selection_feature', 'Enabling this module activates the automatic best agent selection feature.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1615, 'en', 'site_maintenance_mode', 'Site Maintenance Mode', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1616, 'en', 'enabling_this_module_puts_the_site_in_maintenance_mode', 'Enabling this module puts the site in maintenance mode', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1617, 'en', 'force_ssl', 'Force SSL', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1618, 'en', 'enabling_this_feature_mandates_the_use_of_https_for_your_site', 'Enabling this feature mandates the use of HTTPS for your site.', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1619, 'en', 'sytem_configuration', 'Sytem Configuration', '2024-12-19 15:52:23', '2024-12-19 15:52:23'),
(1620, 'en', 'email_method_has_been_updated', 'Email method has been updated', '2024-12-19 15:53:00', '2024-12-19 15:53:00'),
(1621, 'en', 'successfully_sent_mail_please_check_your_inbox_or_spam', 'Successfully Sent Mail, please check your inbox or spam', '2024-12-19 16:00:19', '2024-12-19 16:00:19'),
(1622, 'en', 'name_feild_is_required', 'Name Feild Is Required', '2024-12-19 16:07:59', '2024-12-19 16:07:59'),
(1623, 'en', 'user_name_must_be_unique', 'User Name Must Be Unique', '2024-12-19 16:07:59', '2024-12-19 16:07:59'),
(1624, 'en', 'your_profile_has_been_updated', 'Your profile has been updated.', '2024-12-19 16:08:00', '2024-12-19 16:08:00'),
(1625, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-19 16:12:07', '2024-12-19 16:12:07'),
(1626, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-19 16:12:07', '2024-12-19 16:12:07'),
(1627, 'en', 'select_year', 'Select year', '2024-12-19 16:12:51', '2024-12-19 16:12:51'),
(1628, 'en', 'see_all_products', 'See all products', '2024-12-19 16:13:05', '2024-12-19 16:13:05'),
(1629, 'en', 'plese_select_a_product_first', 'Plese select a product first', '2024-12-19 16:13:05', '2024-12-19 16:13:05'),
(1630, 'bd', 'support', 'Support', '2024-12-19 16:13:24', '2024-12-19 16:13:24'),
(1631, 'bd', 'search_your_question_', 'Search Your Question ....', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1632, 'bd', 'search', 'Search', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1633, 'bd', 'sorry_no_result_found', 'Sorry! No Result Found', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1634, 'bd', 'create_ticket', 'Create Ticket', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1635, 'bd', 'contact', 'Contact', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1636, 'bd', 'write_us', 'Write Us', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1637, 'bd', 'name', 'Name', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1638, 'bd', 'enter_your_name', 'Enter Your Name', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1639, 'bd', 'email', 'Email', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1640, 'bd', 'enter_your_email', 'Enter Your Email', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1641, 'bd', 'subject', 'Subject', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1642, 'bd', 'enter_your_subject', 'Enter Your Subject', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1643, 'bd', 'message', 'Message', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1644, 'bd', 'type_your_message_here_', 'Type Your Message Here.......... ', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1645, 'bd', 'submit', 'Submit', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1646, 'bd', 'email_us', 'Email us', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1647, 'bd', 'our_friendly_team_is_here_to_help', 'Our friendly team is here to help.', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1648, 'bd', 'call_to_us', 'Call to us', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1649, 'bd', 'monfri_from_10am_to_6pm', 'Mon-Fri From 10am to 6pm', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1650, 'bd', 'visit_us', 'Visit us', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1651, 'bd', 'come_say_hello_at_our_office_hq', 'Come say hello at our office HQ', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1652, 'bd', 'home', 'Home', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1653, 'bd', 'track', 'Track', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1654, 'bd', 'welcome', 'Welcome', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1655, 'bd', 'dashboard', 'Dashboard', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1656, 'bd', 'logout', 'Logout', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1657, 'bd', 'important_links', 'Important Links', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1658, 'bd', 'quick_link', 'Quick Link', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1659, 'bd', 'social_links', 'Social Links', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1660, 'bd', 'subscribe', 'Subscribe', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1661, 'bd', 'accept_our_cookie', 'Accept Our Cookie', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1662, 'bd', 'accept__continue', 'Accept & Continue', '2024-12-19 16:13:25', '2024-12-19 16:13:25'),
(1663, 'en', 'recaptcha_validation_failed__try_again', 'Recaptcha Validation Failed !! try again', '2024-12-19 16:14:29', '2024-12-19 16:14:29'),
(1664, 'en', 'update__user', 'Update  User', '2024-12-19 16:15:20', '2024-12-19 16:15:20'),
(1665, 'en', 'update_user', 'Update User', '2024-12-19 16:15:20', '2024-12-19 16:15:20'),
(1666, 'en', 'user_updated_successfully', 'User Updated Successfully', '2024-12-19 16:15:31', '2024-12-19 16:15:31'),
(1667, 'en', 'admin_assign_a_conversations_to_me', 'Admin Assign A Conversations To Me', '2024-12-19 16:21:45', '2024-12-19 16:21:45'),
(1668, 'en', 'agent_notifications_settings', 'agent Notifications Settings', '2024-12-19 16:21:46', '2024-12-19 16:21:46'),
(1669, 'en', 'there_is_a_new_conversation', 'There is a New Conversation', '2024-12-19 16:26:16', '2024-12-19 16:26:16'),
(1670, 'en', 'there_is_a_ticket_reply', 'There Is A Ticket Reply', '2024-12-19 16:26:16', '2024-12-19 16:26:16'),
(1671, 'en', 'user_notifications_settings', 'User Notifications Settings', '2024-12-19 16:26:16', '2024-12-19 16:26:16'),
(1672, 'en', 'contacts', 'Contacts', '2024-12-19 16:32:35', '2024-12-19 16:32:35'),
(1673, 'en', 'mute_user', 'Mute User', '2024-12-19 16:32:39', '2024-12-19 16:32:39'),
(1674, 'en', 'you_have_a_new_message_from_', 'You Have A New Message From ', '2024-12-19 16:32:55', '2024-12-19 16:32:55'),
(1675, 'en', 'message_sent', 'Message Sent', '2024-12-19 16:32:56', '2024-12-19 16:32:56'),
(1676, 'en', 'direct_messages', 'Direct Messages', '2024-12-19 16:37:40', '2024-12-19 16:37:40'),
(1677, 'en', 'agent_deleted_successfully', 'Agent Deleted Successfully', '2024-12-19 16:39:50', '2024-12-19 16:39:50'),
(1678, 'en', 'delete_conversation', 'Delete Conversation', '2024-12-19 16:40:57', '2024-12-19 16:40:57'),
(1679, 'en', 'user_muted', 'User Muted', '2024-12-19 16:41:06', '2024-12-19 16:41:06'),
(1680, 'en', 'user_unmuted', 'User Unmuted', '2024-12-19 16:41:10', '2024-12-19 16:41:10'),
(1681, 'en', 'user_chat_list', 'User Chat list', '2024-12-19 16:42:02', '2024-12-19 16:42:02'),
(1682, 'en', 'no_agent_found_', 'No Agent Found !!', '2024-12-19 16:42:30', '2024-12-19 16:42:30'),
(1683, 'en', 'an_agent_has_requested_to_mark_this_ticket_as_solved_would_you_like_to_accept_this_request', 'An agent has requested to mark this ticket as \'Solved.\' Would you like to accept this request', '2024-12-19 16:49:50', '2024-12-19 16:49:50'),
(1684, 'en', 'thanks_for_your_response', 'Thanks!! For Your Response', '2024-12-19 16:50:00', '2024-12-19 16:50:00'),
(1685, 'en', 'id_is_required', 'Id Is Required', '2024-12-19 16:53:02', '2024-12-19 16:53:02'),
(1686, 'en', 'select_id_is_invalid', 'Select Id Is Invalid', '2024-12-19 16:53:02', '2024-12-19 16:53:02'),
(1687, 'en', 'status_is_required', 'Status Is Required', '2024-12-19 16:53:02', '2024-12-19 16:53:02'),
(1688, 'en', 'key_is_required', 'key Is Required', '2024-12-19 16:53:02', '2024-12-19 16:53:02'),
(1689, 'en', 'status_updated', 'Status Updated', '2024-12-19 16:53:02', '2024-12-19 16:53:02'),
(1690, 'en', 'merge', 'Merge', '2024-12-19 16:53:51', '2024-12-19 16:53:51'),
(1691, 'en', 'view', 'View', '2024-12-19 16:53:51', '2024-12-19 16:53:51'),
(1692, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-19 17:02:04', '2024-12-19 17:02:04'),
(1693, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-19 17:02:05', '2024-12-19 17:02:05');
INSERT INTO `translations` (`id`, `code`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1694, 'en', 'search_ticket', 'Search Ticket', '2024-12-19 17:04:19', '2024-12-19 17:04:19'),
(1695, 'en', 'search_ticket_here', 'Search Ticket Here', '2024-12-19 17:04:19', '2024-12-19 17:04:19'),
(1696, 'en', 'enter_ticket_number', 'Enter Ticket Number', '2024-12-19 17:04:19', '2024-12-19 17:04:19'),
(1697, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-20 07:58:11', '2024-12-20 07:58:11'),
(1698, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-20 07:58:11', '2024-12-20 07:58:11'),
(1699, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-20 08:00:13', '2024-12-20 08:00:13'),
(1700, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-20 08:00:13', '2024-12-20 08:00:13'),
(1701, 'en', 'contact_list', 'Contact List', '2024-12-20 08:00:30', '2024-12-20 08:00:30'),
(1702, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 08:00:47', '2024-12-20 08:00:47'),
(1703, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 08:00:47', '2024-12-20 08:00:47'),
(1704, 'en', 'user_deleted_successfully', 'User Deleted Successfully', '2024-12-20 08:13:41', '2024-12-20 08:13:41'),
(1705, 'en', 'gateway_created_succesfully', 'Gateway created succesfully', '2024-12-20 08:19:56', '2024-12-20 08:19:56'),
(1706, 'en', 'create_trigger', 'Create Trigger', '2024-12-20 08:21:23', '2024-12-20 08:21:23'),
(1707, 'en', 'meet', 'Meet', '2024-12-20 08:21:23', '2024-12-20 08:21:23'),
(1708, 'en', 'the_following_conditions', 'the following conditions', '2024-12-20 08:21:23', '2024-12-20 08:21:23'),
(1709, 'en', 'add_condition', 'Add Condition', '2024-12-20 08:21:23', '2024-12-20 08:21:23'),
(1710, 'en', 'any', 'Any', '2024-12-20 08:21:24', '2024-12-20 08:21:24'),
(1711, 'en', 'perform_these_actions', 'Perform these actions', '2024-12-20 08:21:24', '2024-12-20 08:21:24'),
(1712, 'en', 'add_action', 'Add Action', '2024-12-20 08:21:24', '2024-12-20 08:21:24'),
(1713, 'en', 'select_condition', 'Select Condition', '2024-12-20 08:21:30', '2024-12-20 08:21:30'),
(1714, 'en', 'enter_value', 'Enter Value', '2024-12-20 08:21:30', '2024-12-20 08:21:30'),
(1715, 'en', 'all_notification_cleared', 'All notification cleared', '2024-12-20 08:31:43', '2024-12-20 08:31:43'),
(1716, 'en', 'your_input_contained_potentially_harmful_content_and_has_been_sanitized', 'Your input contained potentially harmful content and has been sanitized!!', '2024-12-20 08:34:53', '2024-12-20 08:34:53'),
(1717, 'en', 'manange_priority', 'Manange Priority', '2024-12-20 08:40:01', '2024-12-20 08:40:01'),
(1718, 'en', 'priorities', 'Priorities', '2024-12-20 08:40:01', '2024-12-20 08:40:01'),
(1719, 'en', 'priority_list', 'Priority List', '2024-12-20 08:40:01', '2024-12-20 08:40:01'),
(1720, 'en', 'response__resolve', 'Response - Resolve', '2024-12-20 08:40:01', '2024-12-20 08:40:01'),
(1721, 'en', 'response_in', 'Response In', '2024-12-20 08:40:01', '2024-12-20 08:40:01'),
(1722, 'en', 'resolve_in', 'Resolve In', '2024-12-20 08:40:01', '2024-12-20 08:40:01'),
(1723, 'en', 'update_priority', 'Update Priority', '2024-12-20 08:40:27', '2024-12-20 08:40:27'),
(1724, 'en', 'color_code', 'Color Code', '2024-12-20 08:40:27', '2024-12-20 08:40:27'),
(1725, 'en', 'enter_color_code', 'Enter Color Code', '2024-12-20 08:40:27', '2024-12-20 08:40:27'),
(1726, 'en', 'update_ticket_status', 'Update Ticket Status', '2024-12-20 08:40:50', '2024-12-20 08:40:50'),
(1727, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 08:41:09', '2024-12-20 08:41:09'),
(1728, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 08:41:09', '2024-12-20 08:41:09'),
(1729, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 08:47:43', '2024-12-20 08:47:43'),
(1730, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 08:47:43', '2024-12-20 08:47:43'),
(1731, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 08:50:01', '2024-12-20 08:50:01'),
(1732, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 08:50:01', '2024-12-20 08:50:01'),
(1733, 'en', 'something_went_wrong', 'Something Went Wrong!!', '2024-12-20 08:51:43', '2024-12-20 08:51:43'),
(1734, 'en', 'sms_gateway_update', 'Sms Gateway update', '2024-12-20 11:26:01', '2024-12-20 11:26:01'),
(1735, 'en', 'enter_valid_api_data', 'Enter Valid API Data', '2024-12-20 11:26:01', '2024-12-20 11:26:01'),
(1736, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-20 11:34:55', '2024-12-20 11:34:55'),
(1737, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-20 11:34:55', '2024-12-20 11:34:55'),
(1738, 'en', 'logo__has_been_updated', 'logo  has been updated', '2024-12-20 11:54:42', '2024-12-20 11:54:42'),
(1739, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-20 11:58:50', '2024-12-20 11:58:50'),
(1740, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-20 11:58:50', '2024-12-20 11:58:50'),
(1741, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-20 13:15:06', '2024-12-20 13:15:06'),
(1742, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-20 13:15:06', '2024-12-20 13:15:06'),
(1743, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-20 13:16:12', '2024-12-20 13:16:12'),
(1744, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-20 13:16:12', '2024-12-20 13:16:12'),
(1745, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-20 13:16:51', '2024-12-20 13:16:51'),
(1746, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-20 13:16:51', '2024-12-20 13:16:51'),
(1747, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-20 13:56:21', '2024-12-20 13:56:21'),
(1748, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-20 13:56:21', '2024-12-20 13:56:21'),
(1749, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-20 13:57:25', '2024-12-20 13:57:25'),
(1750, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-20 13:57:25', '2024-12-20 13:57:25'),
(1751, 'en', 'update_templates', 'Update templates', '2024-12-20 14:01:42', '2024-12-20 14:01:42'),
(1752, 'en', 'update_template', 'Update Template', '2024-12-20 14:01:43', '2024-12-20 14:01:43'),
(1753, 'en', 'enter_subject', 'Enter Subject', '2024-12-20 14:01:43', '2024-12-20 14:01:43'),
(1754, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-20 14:02:25', '2024-12-20 14:02:25'),
(1755, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-20 14:02:25', '2024-12-20 14:02:25'),
(1756, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 14:02:51', '2024-12-20 14:02:51'),
(1757, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 14:02:52', '2024-12-20 14:02:52'),
(1758, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 14:11:32', '2024-12-20 14:11:32'),
(1759, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 14:11:32', '2024-12-20 14:11:32'),
(1760, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-20 14:14:51', '2024-12-20 14:14:51'),
(1761, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-20 14:14:51', '2024-12-20 14:14:51'),
(1762, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-20 14:18:22', '2024-12-20 14:18:22'),
(1763, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-20 14:18:23', '2024-12-20 14:18:23'),
(1764, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 14:27:29', '2024-12-20 14:27:29'),
(1765, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 14:27:29', '2024-12-20 14:27:29'),
(1766, 'en', 'labels_field_is_required', 'Labels Field Is Required', '2024-12-20 15:17:15', '2024-12-20 15:17:15'),
(1767, 'en', 'type_field_is_required', 'Type Field Is Required', '2024-12-20 15:17:15', '2024-12-20 15:17:15'),
(1768, 'en', 'required_field_is_required', 'Required Field Is Required', '2024-12-20 15:17:15', '2024-12-20 15:17:15'),
(1769, 'en', 'placeholder_field_is_required', 'Placeholder Field Is Required', '2024-12-20 15:17:15', '2024-12-20 15:17:15'),
(1770, 'en', 'default_field_is_required', 'Default Field Is Required', '2024-12-20 15:17:15', '2024-12-20 15:17:15'),
(1771, 'en', 'please_select_an_option_between_multiselect_or_sigle_select', 'Please select an option between multiselect or sigle select', '2024-12-20 15:17:15', '2024-12-20 15:17:15'),
(1772, 'en', 'the_display_name_is_required', 'The Display Name is required', '2024-12-20 15:17:15', '2024-12-20 15:17:15'),
(1773, 'en', 'the_option_value_field_is_required', 'The option Value field is required', '2024-12-20 15:17:15', '2024-12-20 15:17:15'),
(1774, 'en', 'updated_successfully', 'Updated successfully', '2024-12-20 15:17:16', '2024-12-20 15:17:16'),
(1775, 'en', 'update_category', 'Update Category', '2024-12-20 15:29:10', '2024-12-20 15:29:10'),
(1776, 'en', 'topics', 'Topics', '2024-12-20 15:29:10', '2024-12-20 15:29:10'),
(1777, 'en', 'update_topics', 'Update Topics', '2024-12-20 15:29:10', '2024-12-20 15:29:10'),
(1778, 'en', 'show_in_ticket', 'Show In Ticket', '2024-12-20 15:29:10', '2024-12-20 15:29:10'),
(1779, 'en', 'show_in_article', 'Show In Article', '2024-12-20 15:29:10', '2024-12-20 15:29:10'),
(1780, 'en', 'category_updated_successfully', 'Category Updated Successfully', '2024-12-20 15:29:31', '2024-12-20 15:29:31'),
(1781, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 15:33:33', '2024-12-20 15:33:33'),
(1782, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 15:33:33', '2024-12-20 15:33:33'),
(1783, 'en', 'sms_template', 'SMS Template', '2024-12-20 15:38:08', '2024-12-20 15:38:08'),
(1784, 'en', 'sms_template_list', 'SMS Template List', '2024-12-20 15:38:08', '2024-12-20 15:38:08'),
(1785, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 15:43:13', '2024-12-20 15:43:13'),
(1786, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-20 15:43:14', '2024-12-20 15:43:14'),
(1787, 'fr', 'back_to_home', 'Retour à l\'accueil', NULL, NULL),
(1788, 'fr', 'track', 'Suivre', NULL, NULL),
(1789, 'fr', 'create_ticket', 'Créer un ticket', NULL, '2024-12-20 16:20:27'),
(1790, 'fr', 'login', 'Connexion', NULL, NULL),
(1791, 'fr', 'important_links', 'Liens importants', NULL, NULL),
(1792, 'fr', 'quick_link', 'Lien rapide', NULL, NULL),
(1793, 'fr', 'social_links', 'Liens sociaux', NULL, NULL),
(1794, 'fr', 'enter_your_email', 'Entrez votre email', NULL, NULL),
(1795, 'fr', 'subscribe', 'S\'abonner', NULL, '2024-12-20 16:22:11'),
(1796, 'fr', 'admin_access_portal', 'Portail d\'accès administrateur', NULL, NULL),
(1797, 'fr', 'username', 'Nom d\'utilisateur', NULL, NULL),
(1798, 'fr', 'enter_username', 'Entrez le nom d\'utilisateur', NULL, NULL),
(1799, 'fr', 'password', 'Mot de passe', NULL, NULL),
(1800, 'fr', 'enter_password', 'Entrez le mot de passe', NULL, NULL),
(1801, 'fr', 'remember_me', 'Se souvenir de moi', NULL, NULL),
(1802, 'fr', 'forgot_password', 'Mot de passe oublié', NULL, NULL),
(1803, 'fr', 'sign_in', 'Se connecter', NULL, NULL),
(1804, 'fr', 'welcome_back_', 'Bon retour ', NULL, NULL),
(1805, 'fr', 'admin_login', 'Connexion administrateur', NULL, NULL),
(1806, 'fr', 'welcome', 'Bienvenue', NULL, NULL),
(1807, 'fr', 'heres_whats_happening_with_your_system', 'Voici ce qui se passe avec votre système', NULL, NULL),
(1808, 'fr', 'last_cron_run', 'Dernière exécution cron', NULL, NULL),
(1809, 'fr', 'sort_by', 'Trier par', NULL, NULL),
(1810, 'fr', 'all', 'Tous', NULL, NULL),
(1811, 'fr', 'today', 'Aujourd\'hui', NULL, NULL),
(1812, 'fr', 'yesterday', 'Hier', NULL, NULL),
(1813, 'fr', 'last_7_days', 'Les 7 derniers jours', NULL, NULL),
(1814, 'fr', 'last_30_days', 'Les 30 derniers jours', NULL, NULL),
(1815, 'fr', 'total_users', 'Nombre total d\'utilisateurs', NULL, NULL),
(1816, 'fr', 'total_agents', 'Nombre total d\'agents', NULL, NULL),
(1817, 'fr', 'total_categories', 'Nombre total de catégories', NULL, NULL),
(1818, 'fr', 'total_articles', 'Nombre total d\'articles', NULL, NULL),
(1819, 'fr', 'total_subscriber', 'Nombre total d\'abonnés', NULL, NULL),
(1820, 'fr', 'total_tickets', 'Nombre total de tickets', NULL, NULL),
(1821, 'fr', 'view_all', 'Voir tout', NULL, NULL),
(1822, 'fr', 'tickets', 'Tickets', NULL, NULL),
(1823, 'fr', 'total', 'Total', NULL, NULL),
(1824, 'fr', 'ticket_by_user', 'Ticket par utilisateur', NULL, NULL),
(1825, 'fr', 'sorry_no_result_found', 'Désolé ! Aucun résultat trouvé', NULL, NULL),
(1826, 'fr', 'ticket_by_category', 'Ticket par catégorie', NULL, NULL),
(1827, 'fr', 'latest_tickets', 'Derniers tickets', NULL, NULL),
(1828, 'fr', 'download_pdf', 'Télécharger le PDF', NULL, NULL),
(1829, 'fr', 'ticket_id', 'ID du ticket', NULL, NULL),
(1830, 'fr', 'name', 'Nom', NULL, NULL),
(1831, 'fr', 'email', 'Email', NULL, NULL),
(1832, 'fr', 'creation_time', 'Heure de création', NULL, NULL),
(1833, 'fr', 'subject', 'Sujet', NULL, NULL),
(1834, 'fr', 'status', 'Statut', NULL, NULL),
(1835, 'fr', 'pending_tickets', 'Tickets en attente', NULL, NULL),
(1836, 'fr', 'top_categories_by_tickets', 'Meilleures catégories par tickets', NULL, NULL),
(1837, 'fr', 'latest_agent_replies', 'Dernières réponses des agents', NULL, NULL),
(1838, 'fr', 'opened_tickets', 'Tickets ouverts', NULL, NULL),
(1839, 'fr', 'closed_tickets', 'Tickets fermés', NULL, NULL),
(1840, 'fr', 'dashboard', 'Tableau de bord', NULL, NULL),
(1841, 'fr', 'clear_cache', 'Vider le cache', NULL, NULL),
(1842, 'fr', 'browse_frontend', 'Parcourir le frontend', NULL, NULL),
(1843, 'fr', 'notifications', 'Notifications', NULL, NULL),
(1844, 'fr', 'no_new_notificatios', 'Pas de nouvelles notifications', NULL, NULL),
(1845, 'fr', 'profile', 'Profil', NULL, NULL),
(1846, 'fr', 'logout', 'Déconnexion', NULL, NULL),
(1847, 'fr', 'menu', 'Menu', NULL, NULL),
(1848, 'fr', 'messenger', 'Messagerie', NULL, NULL),
(1849, 'fr', 'ticketsagents__users', 'Tickets, Agents et Utilisateurs', NULL, NULL),
(1850, 'fr', 'tickets_lists', 'Listes de tickets', NULL, NULL),
(1851, 'fr', 'ticket_configuration', 'Configuration des tickets', NULL, NULL),
(1852, 'fr', 'general_configuration', 'Configuration générale', NULL, NULL),
(1853, 'fr', 'triggering', 'Déclenchement', NULL, NULL),
(1854, 'fr', 'ticket_status', 'Statut du ticket', NULL, NULL),
(1855, 'fr', 'departments', 'Départements', NULL, NULL),
(1856, 'fr', 'ticket_priority', 'Priorité du ticket', NULL, NULL),
(1857, 'fr', 'ticket_categories', 'Catégories de tickets', NULL, NULL),
(1858, 'fr', 'predefined_response', 'Réponse prédéfinie', NULL, NULL),
(1859, 'fr', 'agent_management', 'Gestion des agents', NULL, NULL),
(1860, 'fr', 'add_new', 'Ajouter nouveau', NULL, NULL),
(1861, 'fr', 'agent_list', 'Liste des agents', NULL, NULL),
(1862, 'fr', 'agent_group', 'Groupe d\'agents', NULL, NULL),
(1863, 'fr', 'manage_user', 'Gérer l\'utilisateur', NULL, NULL),
(1864, 'fr', 'user_list', 'Liste des utilisateurs', NULL, NULL),
(1865, 'fr', 'appearance__others', 'Apparence et autres', NULL, NULL),
(1866, 'fr', 'appearance_settings', 'Paramètres d\'apparence', NULL, NULL),
(1867, 'fr', 'section_manage', 'Gérer la section', NULL, NULL),
(1868, 'fr', 'menu_manage', 'Gérer le menu', NULL, NULL),
(1869, 'fr', 'dynamic_pages', 'Pages dynamiques', NULL, NULL),
(1870, 'fr', 'faq_section', 'Section FAQ', NULL, NULL),
(1871, 'fr', 'knowledgebase', 'Base de connaissances', NULL, NULL),
(1872, 'fr', 'article_administration', 'Administration des articles', NULL, NULL),
(1873, 'fr', 'article_topics', 'Sujets des articles', NULL, NULL),
(1874, 'fr', 'article_categories', 'Catégories d\'articles', NULL, NULL),
(1875, 'fr', 'article_list', 'Liste des articles', NULL, NULL),
(1876, 'fr', 'marketingpromotion', 'Marketing/Promotion', NULL, NULL),
(1877, 'fr', 'contact_message', 'Message de contact', NULL, NULL),
(1878, 'fr', 'subscribers', 'Abonnés', NULL, NULL),
(1879, 'fr', 'email__sms_config', 'Configuration Email et SMS', NULL, NULL),
(1880, 'fr', 'email_configuration', 'Configuration des emails', NULL, NULL),
(1881, 'fr', 'outgoing_method', 'Méthode d\'envoi', NULL, NULL),
(1882, 'fr', 'incoming_method', 'Méthode de réception', NULL, NULL),
(1883, 'fr', 'global_template', 'Modèle global', NULL, NULL),
(1884, 'fr', 'mail_templates', 'Modèles d\'emails', NULL, NULL),
(1885, 'fr', 'sms_configuration', 'Configuration des SMS', NULL, NULL),
(1886, 'fr', 'sms_gateway', 'Passerelle SMS', NULL, NULL),
(1887, 'fr', 'global_setting', 'Paramètres globaux', NULL, NULL),
(1888, 'fr', 'sms_templates', 'Modèles de SMS', NULL, NULL),
(1889, 'fr', 'setup__configurations', 'Configuration et paramètres', NULL, NULL),
(1890, 'fr', 'application_settings', 'Paramètres de l\'application', NULL, NULL),
(1891, 'fr', 'app_settings', 'Paramètres de l\'application', NULL, NULL),
(1892, 'fr', 'ai_configuration', 'Configuration de l\'IA', NULL, NULL),
(1893, 'fr', 'system_preferences', 'Préférences du système', NULL, NULL),
(1894, 'fr', 'notification_settings', 'Paramètres de notification', NULL, NULL),
(1895, 'fr', 'security_settings', 'Paramètres de sécurité', NULL, NULL),
(1896, 'fr', 'visitors', 'Visiteurs', NULL, NULL),
(1897, 'fr', 'dos_security', 'Sécurité DOS', NULL, NULL),
(1898, 'fr', 'system_upgrade', 'Mise à niveau du système', NULL, NULL),
(1899, 'fr', 'languages', 'Langues', NULL, NULL),
(1900, 'fr', 'about_system', 'À propos du système', NULL, NULL),
(1901, 'fr', 'app_version', 'Version de l\'application', NULL, NULL),
(1902, 'fr', 'ai_assistance', 'Assistance IA', NULL, NULL),
(1903, 'fr', 'result', 'Résultat', NULL, NULL),
(1904, 'fr', 'copy', 'Copier', NULL, NULL),
(1905, 'fr', 'download', 'Télécharger', NULL, NULL),
(1906, 'fr', 'your_content', 'Votre contenu', NULL, NULL),
(1907, 'fr', 'your_prompt_goes_here__', 'Votre invite va ici .... ', NULL, NULL),
(1908, 'fr', 'what_do_you_want_to_do', 'Que voulez-vous faire', NULL, NULL),
(1909, 'fr', 'here_are_some_ideas', 'Voici quelques idées', NULL, NULL),
(1910, 'fr', 'more', 'Plus', NULL, NULL),
(1911, 'fr', 'translate', 'Traduire', NULL, NULL),
(1912, 'fr', 'back', 'Retour', NULL, NULL),
(1913, 'fr', 'rewrite_it', 'Réécrire', NULL, NULL),
(1914, 'fr', 'adjust_tone', 'Ajuster le ton', NULL, NULL),
(1915, 'fr', 'choose_language', 'Choisir la langue', NULL, NULL),
(1916, 'fr', 'select_language', 'Sélectionner la langue', NULL, NULL),
(1917, 'fr', 'or', 'OU', NULL, NULL),
(1918, 'fr', 'make_your_own_prompt', 'Créez votre propre invite', NULL, NULL),
(1919, 'fr', 'ex_make_it_more_friendly_', 'Ex: Rendez-le plus convivial', NULL, NULL),
(1920, 'fr', 'insert', 'Insérer', NULL, NULL),
(1921, 'fr', 'cancel', 'Annuler', NULL, NULL),
(1922, 'fr', 'do_not_close_window_while_proecessing', 'Ne fermez pas la fenêtre pendant le traitement', NULL, NULL),
(1923, 'fr', 'hello_', 'Bonjour ', NULL, NULL),
(1924, 'fr', 'this_function_is_not_avaialbe_for_website_demo_mode', 'Cette fonction n\'est pas disponible pour le mode de démonstration du site Web', NULL, NULL),
(1925, 'fr', 'select_country', 'Sélectionner un pays', NULL, NULL),
(1926, 'fr', 'generate_with_ai', 'Générer avec l\'IA', NULL, NULL),
(1927, 'fr', 'text_copied_to_clipboard', 'Texte copié dans le presse-papiers !', NULL, NULL),
(1928, 'fr', 'incoming_mail_configuration', 'Configuration du courrier entrant', NULL, NULL),
(1929, 'fr', 'home', 'Accueil', NULL, NULL),
(1930, 'fr', 'imap_method', 'Méthode IMAP', NULL, NULL),
(1931, 'fr', 'email_to_ticket', 'Email vers ticket', NULL, NULL),
(1932, 'fr', 'convert_incoming_email_to_ticket_if_email_body_or_subject_contains__any_of_the_specified_keywords', 'Convertir l\'email entrant en ticket si le corps ou le sujet de l\'email contient l\'un des mots-clés spécifiés', NULL, NULL),
(1933, 'fr', 'comma_separated', 'Séparés par des virgules', NULL, NULL),
(1934, 'fr', 'enter_', 'Entrez ', NULL, NULL),
(1935, 'fr', 'update', 'Mettre à jour', NULL, NULL),
(1936, 'fr', 'enter_keywords', 'Entrez les mots-clés', NULL, NULL),
(1937, 'fr', 'general_setting', 'Paramètres généraux', NULL, NULL),
(1938, 'fr', 'basic_settings', 'Paramètres de base', NULL, NULL),
(1939, 'fr', 'agent_settings', 'Paramètres des agents', NULL, NULL),
(1940, 'fr', 'theme_settings', 'Paramètres du thème', NULL, NULL),
(1941, 'fr', 'storage_settings', 'Paramètres de stockage', NULL, NULL),
(1942, 'fr', 'pusher_settings', 'Paramètres Pusher', NULL, NULL),
(1943, 'fr', 'slack_settings', 'Paramètres Slack', NULL, NULL),
(1944, 'fr', 'recaptcha_settings', 'Paramètres Recaptcha', NULL, NULL),
(1945, 'fr', '3rd_party_login', 'Connexion tierce partie', NULL, NULL),
(1946, 'fr', 'logo_settings', 'Paramètres du logo', NULL, NULL),
(1947, 'fr', 'setup_cron_jobs', 'Configurer les tâches cron', NULL, NULL),
(1948, 'fr', 'use_same_site_name', 'Utiliser le même nom de site', NULL, NULL),
(1949, 'fr', 'site_name', 'Nom du site', NULL, NULL),
(1950, 'fr', 'user_site_name', 'Nom du site utilisateur', NULL, NULL),
(1951, 'fr', 'phone', 'Téléphone', NULL, NULL),
(1952, 'fr', 'address', 'Adresse', NULL, NULL),
(1953, 'fr', 'copy_right_text', 'Texte de copyright', NULL, NULL),
(1954, 'fr', 'pagination_number', 'Nombre de pagination', NULL, NULL),
(1955, 'fr', 'time_zone', 'Fuseau horaire', NULL, NULL),
(1956, 'fr', 'cookie__text', 'Texte du cookie', NULL, NULL),
(1957, 'fr', 'enter_cookie_text', 'Entrez le texte du cookie', NULL, NULL),
(1958, 'fr', 'maintenance_mode_title', 'Titre du mode maintenance', NULL, NULL),
(1959, 'fr', 'enter_title', 'Entrez le titre', NULL, NULL),
(1960, 'fr', 'maintenance_mode_description', 'Description du mode maintenance', NULL, NULL),
(1961, 'fr', 'enter_description', 'Entrez la description', NULL, NULL),
(1962, 'fr', 'submit', 'Soumettre', NULL, NULL),
(1963, 'fr', 'best_agent_settings', 'Paramètres du meilleur agent', NULL, NULL),
(1964, 'fr', 'avg_response_time', 'Temps de réponse moyen', NULL, NULL),
(1965, 'fr', 'in_miniutes', 'En minutes', NULL, NULL),
(1966, 'fr', 'avg_response_time_required_to_become_a_bestpopular_agent', 'Temps de réponse moyen requis pour devenir un agent meilleur/populaire', NULL, NULL),
(1967, 'fr', 'minimum_no_of_responsed_ticket', 'Nombre minimum de tickets répondus', NULL, NULL),
(1968, 'fr', 'to_attain_the_status_of_a_top_agent_the_requisite_minimum_number_of_tickets_to_respond_to_is_', 'Pour atteindre le statut de meilleur agent, le nombre minimum requis de tickets auxquels répondre est...', NULL, NULL),
(1969, 'fr', 'enter_number', 'Entrez le nombre', NULL, NULL),
(1970, 'fr', 'frontend_themecolor_settings', 'Paramètres de thème/couleur du frontend', NULL, NULL),
(1971, 'fr', 'primary_color', 'Couleur primaire', NULL, NULL),
(1972, 'fr', 'secondary_color', 'Couleur secondaire', NULL, NULL),
(1973, 'fr', 'secondry_color', 'Couleur secondaire', NULL, NULL),
(1974, 'fr', 'text_primary_color', 'Couleur primaire du texte', NULL, NULL),
(1975, 'fr', 'text_secondary_color', 'Couleur secondaire du texte', NULL, NULL),
(1976, 'fr', 'text_secondry_color', 'Couleur secondaire du texte', NULL, NULL),
(1977, 'fr', 'local', 'local', NULL, NULL),
(1978, 'fr', 'aws_s3', 'Aws S3', NULL, NULL),
(1979, 'fr', 'local_storage_settings', 'Paramètres de stockage local', NULL, NULL),
(1980, 'fr', 'supported_file_types', 'Types de fichiers pris en charge', NULL, NULL),
(1981, 'fr', 'maximum_file_upload', 'Téléchargement maximal de fichiers', NULL, NULL),
(1982, 'fr', 'you_can_not_upload_more_than_that_at_a_time_', 'Vous ne pouvez pas télécharger plus que cela à la fois', NULL, NULL),
(1983, 'fr', 'max_file_upload_size', 'Taille maximale de téléchargement de fichier', NULL, NULL),
(1984, 'fr', 'in_kilobyte', 'En kilo-octet', NULL, NULL),
(1985, 'fr', 's3_storage_settings', 'Paramètres de stockage S3', NULL, NULL),
(1986, 'fr', 'web_hook_url', 'URL du Web Hook', NULL, NULL),
(1987, 'fr', 'chanel_name', 'Nom du canal', NULL, NULL),
(1988, 'fr', 'optional', 'Optionnel', NULL, NULL),
(1989, 'fr', 'use_default_captcha', 'Utiliser le Captcha par défaut', NULL, NULL),
(1990, 'fr', 'socail_login_setup', 'Configuration de la connexion sociale', NULL, NULL),
(1991, 'fr', 'active', 'Actif', NULL, NULL),
(1992, 'fr', 'inactive', 'Inactif', NULL, NULL),
(1993, 'fr', 'callback_url', 'URL de rappel', NULL, NULL),
(1994, 'fr', 'site_logo', 'Logo du site', NULL, NULL),
(1995, 'fr', 'logo_icon', 'Icône du logo', NULL, NULL),
(1996, 'fr', 'frontend_logo', 'Logo du frontend', NULL, NULL),
(1997, 'fr', 'site_favicon', 'Favicon du site', NULL, NULL),
(1998, 'fr', 'cron_job_setting', 'Paramètres de la tâche cron', NULL, NULL),
(1999, 'fr', 'cron_job_', 'Tâche cron', NULL, NULL),
(2000, 'fr', 'set_time_for_1_minute', 'Définir le temps pour 1 minute', NULL, NULL),
(2001, 'fr', 'close', 'Fermer', NULL, NULL),
(2002, 'fr', 'successfully_reseted', 'Réinitialisé avec succès', NULL, NULL),
(2003, 'fr', 'feild_is_required', 'Le champ est obligatoire', NULL, NULL),
(2004, 'fr', 'system_setting_has_been_updated', 'Les paramètres du système ont été mis à jour', NULL, NULL),
(2005, 'fr', 'anonymous_messages', 'Messages anonymes', NULL, NULL),
(2006, 'fr', 'start_chating_by_select_a_user', 'Commencez à chatter en sélectionnant un utilisateur', NULL, NULL),
(2007, 'fr', 'please_enter_a_message', 'Veuillez saisir un message', NULL, NULL),
(2008, 'fr', 'type_your_message', 'Tapez votre message', NULL, NULL),
(2009, 'fr', 'you_can_not_reply_to_this_conversations', 'Vous ne pouvez pas répondre à cette conversation', NULL, NULL),
(2010, 'fr', 'please_set_up_your_pusher_configuration_first', 'Veuillez d\'abord configurer votre configuration Pusher !', NULL, NULL),
(2011, 'fr', 'something_went_wrong_', 'Quelque chose s\'est mal passé !!', NULL, NULL),
(2012, 'fr', 'validation_error', 'Erreur de validation', NULL, NULL),
(2013, 'fr', 'chat_list', 'Liste de chat', NULL, NULL),
(2014, 'fr', 'no_message_found', 'Aucun message trouvé', NULL, NULL),
(2015, 'fr', 'assign', 'Attribuer', NULL, NULL),
(2016, 'fr', 'manage_frontend_section', 'Gérer la section du frontend', NULL, NULL),
(2017, 'fr', 'frontends', 'Frontends', NULL, NULL),
(2018, 'fr', 'section_list', 'Liste des sections', NULL, NULL),
(2019, 'fr', 'search_here', 'Rechercher ici', NULL, NULL),
(2020, 'fr', 'title', 'Titre', NULL, NULL),
(2021, 'fr', 'type_here', 'Tapez ici', NULL, NULL),
(2022, 'fr', 'description', 'Description', NULL, NULL),
(2023, 'fr', 'banner_image', 'Image de la bannière', NULL, NULL),
(2024, 'fr', 'sub_title', 'Sous-titre', NULL, NULL),
(2025, 'fr', 'btn_text', 'Texte du bouton', NULL, NULL),
(2026, 'fr', 'btn_url', 'URL du bouton', NULL, NULL),
(2027, 'fr', 'text', 'Texte', NULL, NULL),
(2028, 'fr', 'see_icon', 'Voir l\'icône', NULL, NULL),
(2029, 'fr', 'update_system', 'Mettre à jour le système', NULL, NULL),
(2030, 'fr', 'system_update', 'Mise à jour du système', NULL, NULL),
(2031, 'fr', 'update_application', 'Mettre à jour l\'application', NULL, NULL),
(2032, 'fr', 'current_version', 'Version actuelle', NULL, NULL),
(2033, 'fr', 'v', 'V', NULL, NULL),
(2034, 'fr', 'upload_zip_file', 'Télécharger le fichier zip', NULL, NULL),
(2035, 'fr', 'update_now', 'Mettre à jour maintenant', NULL, NULL),
(2036, 'fr', 'file_field_is_required', 'Le champ fichier est obligatoire', NULL, NULL),
(2037, 'fr', 'support', 'Assistance', NULL, NULL),
(2038, 'fr', 'search_your_question_', 'Rechercher votre question ....', NULL, NULL),
(2039, 'fr', 'search', 'Rechercher', NULL, NULL),
(2040, 'fr', 'contact', 'Contact', NULL, NULL),
(2041, 'fr', 'write_us', 'Écrivez-nous', NULL, NULL),
(2042, 'fr', 'enter_your_name', 'Entrez votre nom', NULL, NULL),
(2043, 'fr', 'enter_your_subject', 'Entrez votre sujet', NULL, NULL),
(2044, 'fr', 'message', 'Message', NULL, NULL),
(2045, 'fr', 'type_your_message_here_', 'Tapez votre message ici..........', NULL, NULL),
(2046, 'fr', 'email_us', 'Envoyez-nous un email', NULL, NULL),
(2047, 'fr', 'our_friendly_team_is_here_to_help', 'Notre équipe amicale est là pour vous aider.', NULL, NULL),
(2048, 'fr', 'call_to_us', 'Appelez-nous', NULL, NULL),
(2049, 'fr', 'monfri_from_10am_to_6pm', 'Lun-Ven de 10h à 18h', NULL, NULL),
(2050, 'fr', 'visit_us', 'Rendez-nous visite', NULL, NULL),
(2051, 'fr', 'come_say_hello_at_our_office_hq', 'Venez nous saluer à notre siège social', NULL, NULL),
(2052, 'fr', 'create_ticket_here', 'Créer un ticket ici', NULL, NULL),
(2053, 'fr', 'files', 'fichiers', NULL, NULL),
(2054, 'fr', 'create', 'Créer', NULL, NULL),
(2055, 'fr', 'enter_email', 'Entrez l\'email', NULL, NULL),
(2056, 'fr', 'start', 'Démarrer', NULL, NULL),
(2057, 'fr', 'type__hit_enter', 'Tapez et appuyez sur Entrée', NULL, NULL),
(2058, 'fr', 'pusher_configuration_error', 'Erreur de configuration Pusher !!', NULL, NULL),
(2059, 'fr', 'manage_language', 'Gérer la langue', NULL, NULL),
(2060, 'fr', 'language', 'Langue', NULL, NULL),
(2061, 'fr', 'language_list', 'Liste des langues', NULL, NULL),
(2062, 'fr', 'add_new_language', 'Ajouter une nouvelle langue', NULL, NULL),
(2063, 'fr', 'code', 'Code', NULL, NULL),
(2064, 'fr', 'options', 'Options', NULL, NULL),
(2065, 'fr', 'make_default', 'Définir par défaut', NULL, NULL),
(2066, 'fr', 'default', 'Défaut', NULL, NULL),
(2067, 'fr', 'add_language', 'Ajouter une langue', NULL, NULL),
(2068, 'fr', 'add', 'Ajouter', NULL, NULL),
(2069, 'fr', 'are_you_sure_', 'Êtes-vous sûr ?', NULL, NULL),
(2070, 'fr', 'are_you_sure_you_want_to____________________________remove_this_record_', 'Êtes-vous sûr de vouloir supprimer cet enregistrement ?', NULL, NULL),
(2071, 'fr', 'yes_delete_it', 'Oui, supprimez-le !', NULL, NULL),
(2072, 'fr', 'system_information', 'Informations système', NULL, NULL),
(2073, 'fr', 'server_information', 'Informations sur le serveur', NULL, NULL),
(2074, 'fr', 'value', 'Valeur', NULL, NULL),
(2075, 'fr', 'php_versions', 'Versions PHP', NULL, NULL),
(2076, 'fr', 'laravel_versions', 'Versions Laravel', NULL, NULL),
(2077, 'fr', 'http_host', 'Hôte HTTP', NULL, NULL),
(2078, 'fr', 'phpini_config', 'Configuration php.ini', NULL, NULL),
(2079, 'fr', 'config_name', 'Nom de la configuration', NULL, NULL),
(2080, 'fr', 'current', 'Actuel', NULL, NULL),
(2081, 'fr', 'recommended', 'Recommandé', NULL, NULL),
(2082, 'fr', 'file_uploads', 'Téléchargements de fichiers', NULL, NULL),
(2083, 'fr', 'on', 'Activé', NULL, NULL),
(2084, 'fr', 'max_file_uploads', 'Téléchargements max de fichiers', NULL, NULL),
(2085, 'fr', 'allow_url_fopen', 'Autoriser url Fopen', NULL, NULL),
(2086, 'fr', 'max_execution_time', 'Temps d\'exécution max', NULL, NULL),
(2087, 'fr', 'max_input_time', 'Temps d\'entrée max', NULL, NULL),
(2088, 'fr', 'max_input_vars', 'Variables d\'entrée max', NULL, NULL),
(2089, 'fr', 'memory_limit', 'Limite de mémoire', NULL, NULL),
(2090, 'fr', 'unlimited', 'Illimité', NULL, NULL),
(2091, 'fr', 'extensions', 'Extensions', NULL, NULL),
(2092, 'fr', 'extension_name', 'Nom de l\'extension', NULL, NULL),
(2093, 'fr', 'file__folder_permissions', 'Permissions des fichiers et dossiers', NULL, NULL),
(2094, 'fr', 'file_or_folder', 'Fichier ou dossier', NULL, NULL),
(2095, 'fr', 'manage_ip', 'Gérer l\'IP', NULL, NULL),
(2096, 'fr', 'ip_list', 'Liste d\'IP', NULL, NULL),
(2097, 'fr', 'filter_by_ip', 'Filtrer par IP', NULL, NULL),
(2098, 'fr', 'filter', 'Filtrer', NULL, NULL),
(2099, 'fr', 'reset', 'Réinitialiser', NULL, NULL),
(2100, 'fr', 'ip', 'IP', NULL, NULL),
(2101, 'fr', 'blocked', 'Bloqué', NULL, NULL),
(2102, 'fr', 'last_visited', 'Dernière visite', NULL, NULL),
(2103, 'fr', 'add_ip', 'Ajouter une IP', NULL, NULL),
(2104, 'fr', 'ip_address', 'Adresse IP', NULL, NULL),
(2105, 'fr', 'enter_ip', 'Entrez l\'IP', NULL, NULL),
(2106, 'fr', 'visistor_agent_info', 'Infos de l\'agent visiteur', NULL, NULL),
(2107, 'fr', 'dos_security_settings', 'Paramètres de sécurité DOS', NULL, NULL),
(2108, 'fr', 'prevent_dos_attack', 'Prévenir les attaques DOS', NULL, NULL),
(2109, 'fr', 'if_there_are_more_than', 'S\'il y a plus de', NULL, NULL),
(2110, 'fr', 'attempts_in', 'tentatives dans', NULL, NULL),
(2111, 'fr', 'second', 'seconde', NULL, NULL),
(2112, 'fr', 'show_captcha', 'Afficher le Captcha', NULL, NULL),
(2113, 'fr', 'block_ip', 'Bloquer l\'IP', NULL, NULL),
(2114, 'fr', 'plugin_setting_has_been_updated', 'Le paramètre du plugin a été mis à jour', NULL, NULL),
(2115, 'fr', 'chat_gpt_settings', 'Paramètres Chat Gpt', NULL, NULL),
(2116, 'fr', 'open_ai_api_key', 'Clé API Open AI', NULL, NULL),
(2117, 'fr', 'api_key', 'Clé API', NULL, NULL),
(2118, 'fr', 'inbox', 'Boîte de réception', NULL, NULL),
(2119, 'fr', 'tags', 'Tags', NULL, NULL),
(2120, 'fr', 'export', 'Exporter', NULL, NULL),
(2121, 'fr', 'export_as_pdf', 'Exporter au format PDF', NULL, NULL),
(2122, 'fr', 'export_as_csv', 'Exporter au format CSV', NULL, NULL),
(2123, 'fr', 'select_status', 'Sélectionner un statut', NULL, NULL),
(2124, 'fr', 'select_priority', 'Sélectionner une priorité', NULL, NULL),
(2125, 'fr', 'search_by_date', 'Rechercher par date', NULL, NULL),
(2126, 'fr', 'search_by_name_or_ticket_number', 'Rechercher par nom ou numéro de ticket', NULL, NULL),
(2127, 'fr', 'make_mine', 'Mettre le mien', NULL, NULL),
(2128, 'fr', 'mark_as_', 'Marquer comme ', NULL, NULL),
(2129, 'fr', 'are_you_sure_you_want_to________________________________remove_this_record_', 'Êtes-vous sûr de vouloir supprimer cet enregistrement ?', NULL, NULL),
(2130, 'fr', 'respone__resolve_time', 'Temps de réponse et de résolution', NULL, NULL),
(2131, 'fr', 'ticket_list', 'Liste des tickets', NULL, NULL),
(2132, 'fr', 'user', 'Utilisateur', NULL, NULL),
(2133, 'fr', 'last_reply', 'Dernière réponse', NULL, NULL),
(2134, 'fr', 'assign_to', 'Attribuer à', NULL, NULL),
(2135, 'fr', 'priority', 'Priorité', NULL, NULL),
(2136, 'fr', 'action', 'Action', NULL, NULL),
(2137, 'fr', 'mine', 'Le mien', NULL, NULL),
(2138, 'fr', 'assigned', 'Attribué', NULL, NULL),
(2139, 'fr', 'unassigned', 'Non attribué', NULL, NULL),
(2140, 'fr', 'department', 'Département', NULL, NULL),
(2141, 'fr', 'manage_knowledgebase', 'Gérer la base de connaissances', NULL, NULL),
(2142, 'fr', 'no_department_found', 'Aucun département trouvé', NULL, NULL),
(2143, 'fr', 'see_all_department', 'Voir tous les départements', NULL, NULL),
(2144, 'fr', 'plese_select_a_department_first', 'Veuillez d\'abord sélectionner un département', NULL, NULL),
(2145, 'fr', 'search_here_', 'Rechercher ici !!', NULL, NULL),
(2146, 'fr', 'department_list', 'Liste des départements', NULL, NULL),
(2147, 'fr', 'add_department', 'Ajouter un département', NULL, NULL),
(2148, 'fr', 'enter_name', 'Entrez le nom', NULL, NULL),
(2149, 'fr', 'image', 'Image', NULL, NULL),
(2150, 'fr', 'manage_departments', 'Gérer les départements', NULL, NULL),
(2151, 'fr', 'menu_list', 'Liste des menus', NULL, NULL),
(2152, 'fr', 'add_new_menu', 'Ajouter un nouveau menu', NULL, NULL),
(2153, 'fr', 'url', 'URL', NULL, NULL),
(2154, 'fr', 'add_menu', 'Ajouter un menu', NULL, NULL),
(2155, 'fr', 'serial_id', 'ID de série', NULL, NULL),
(2156, 'fr', 'enter_serial_id', 'Entrez l\'ID de série', NULL, NULL),
(2157, 'fr', 'enter_url', 'Entrez l\'URL', NULL, NULL),
(2158, 'fr', 'header', 'En-tête', NULL, NULL),
(2159, 'fr', 'footer', 'Pied de page', NULL, NULL),
(2160, 'fr', 'update_menu', 'Mettre à jour le menu', NULL, NULL),
(2161, 'fr', 'name_field_is_required', 'Le champ nom est obligatoire', NULL, NULL),
(2162, 'fr', 'name_field_must_be_unique', 'Le champ nom doit être unique', NULL, NULL),
(2163, 'fr', 'menu_url_is_required', 'L\'URL du menu est obligatoire', NULL, NULL),
(2164, 'fr', 'serial_is_required', 'Le numéro de série est obligatoire', NULL, NULL),
(2165, 'fr', 'menu_created_successfully', 'Menu créé avec succès', NULL, NULL),
(2166, 'fr', 'how_can_we_help', 'Comment pouvons-nous vous aider', NULL, NULL),
(2167, 'fr', 'browse_by_departments', 'Parcourir par départements', NULL, NULL),
(2168, 'fr', 'please_select_a_department_first', 'Veuillez d\'abord sélectionner un département', NULL, NULL),
(2169, 'fr', 'ticket_configurations', 'Configurations des tickets', NULL, NULL),
(2170, 'fr', 'settings', 'Paramètres', NULL, NULL),
(2171, 'fr', 'field_settings', 'Paramètres de champ', NULL, NULL),
(2172, 'fr', 'operating_hour', 'Heures de service', NULL, NULL),
(2173, 'fr', 'ticket_settings', 'Paramètres des tickets', NULL, NULL),
(2174, 'fr', 'enabling_this_option_will_activate_email_to_ticket_feature', 'L\'activation de cette option activera la fonctionnalité d\'email vers ticket', NULL, NULL),
(2175, 'fr', 'enable', 'Activer', NULL, NULL),
(2176, 'fr', 'disable', 'Désactiver', NULL, NULL),
(2177, 'fr', 'enable_ticket_department', 'Activer le département de tickets', NULL, NULL);
INSERT INTO `translations` (`id`, `code`, `key`, `value`, `created_at`, `updated_at`) VALUES
(2178, 'fr', 'enabling_this_option_will_activate_ticket_department_selection_during_ticket_create', 'L\'activation de cette option activera la sélection du département de ticket lors de la création d\'un ticket', NULL, NULL),
(2179, 'fr', 'agent_name_privacy', 'Confidentialité du nom de l\'agent', NULL, NULL),
(2180, 'fr', 'enabling_this_option_will_activated_agent_name_privacy_in_user_reply_section_user_will_not_able_to_see_who_replied', 'L\'activation de cette option activera la confidentialité du nom de l\'agent dans la section de réponse de l\'utilisateur. L\'utilisateur ne pourra pas voir qui a répondu', NULL, NULL),
(2181, 'fr', 'message_seen_status', 'Statut de message vu', NULL, NULL),
(2182, 'fr', 'by_enabling_this_option_users_will_be_able_to_see_whether_their_messages_have_been_seen_by_an_agent_or_not', 'En activant cette option, les utilisateurs pourront voir si leurs messages ont été vus ou non par un agent', NULL, NULL),
(2183, 'fr', 'user_ticket_close', 'Fermeture du ticket par l\'utilisateur', NULL, NULL),
(2184, 'fr', 'enabling_this_option_will_allow_user_to_close_their_ticket', 'L\'activation de cette option permettra à l\'utilisateur de fermer son ticket', NULL, NULL),
(2185, 'fr', 'ticket_prefix', 'Préfixe du ticket', NULL, NULL),
(2186, 'fr', 'ticket_suffix', 'Suffixe du ticket', NULL, NULL),
(2187, 'fr', 'random_number', 'Nombre aléatoire', NULL, NULL),
(2188, 'fr', 'incremental', 'Incrémental', NULL, NULL),
(2189, 'fr', 'guest_ticket', 'Ticket invité', NULL, NULL),
(2190, 'fr', 'custom_files', 'Fichiers personnalisés', NULL, NULL),
(2191, 'fr', 'in_ticket_reply', 'Dans la réponse du ticket', NULL, NULL),
(2192, 'fr', 'ticket_view_otp', 'OTP de visualisation de ticket', NULL, NULL),
(2193, 'fr', 'enabling_this_option_will_activate_the_otp_system_for_ticket_view', 'L\'activation de cette option activera le système OTP pour la visualisation des tickets', NULL, NULL),
(2194, 'fr', 'user_ticket_delete', 'Suppression de ticket par l\'utilisateur', NULL, NULL),
(2195, 'fr', 'enabling_this_option_will_allow_user_to_delete_ticket_', 'L\'activation de cette option permettra à l\'utilisateur de supprimer le ticket', NULL, NULL),
(2196, 'fr', 'auto_close_ticket', 'Fermeture automatique du ticket', NULL, NULL),
(2197, 'fr', 'ticket_with_the_status', 'Ticket avec le statut', NULL, NULL),
(2198, 'fr', 'will_be_automatically_closed_if_there_is_no_response_from_the_user_within', 'sera automatiquement fermé s\'il n\'y a pas de réponse de l\'utilisateur dans', NULL, NULL),
(2199, 'fr', 'days', 'Jours', NULL, NULL),
(2200, 'fr', 'duplicate_ticket_prevent', 'Empêcher les tickets en double', NULL, NULL),
(2201, 'fr', 'user_cant_create_multiple_tickets_with_the_same_category_if_status_is_', 'L\'utilisateur ne peut pas créer plusieurs tickets avec la même catégorie si le statut est ', NULL, NULL),
(2202, 'fr', 'field_configuration', 'Configuration des champs', NULL, NULL),
(2203, 'fr', 'add_more', 'Ajouter plus', NULL, NULL),
(2204, 'fr', 'labels', 'Étiquettes', NULL, NULL),
(2205, 'fr', 'type', 'Type', NULL, NULL),
(2206, 'fr', 'width', 'Largeur', NULL, NULL),
(2207, 'fr', 'mandatoryrequired', 'Obligatoire/Requis', NULL, NULL),
(2208, 'fr', 'visibility', 'Visibilité', NULL, NULL),
(2209, 'fr', 'placeholder', 'Espace réservé', NULL, NULL),
(2210, 'fr', 'visible', 'Visible', NULL, NULL),
(2211, 'fr', 'hidden', 'Caché', NULL, NULL),
(2212, 'fr', 'na', 'N/A', NULL, NULL),
(2213, 'fr', 'ticket_short_notes', 'Notes brèves sur le ticket', NULL, NULL),
(2214, 'fr', 'operating_hours', 'Heures d\'ouverture', NULL, NULL),
(2215, 'fr', 'enable_business_hours', 'Activer les heures d\'ouverture', NULL, NULL),
(2216, 'fr', 'start_time', 'Heure de début', NULL, NULL),
(2217, 'fr', 'end_time', 'Heure de fin', NULL, NULL),
(2218, 'fr', 'select_time', 'Sélectionner l\'heure', NULL, NULL),
(2219, 'fr', 'select_end_time', 'Sélectionner l\'heure de fin', NULL, NULL),
(2220, 'fr', 'status_updated_successfully', 'Statut mis à jour avec succès', NULL, NULL),
(2221, 'fr', 'support_agent', 'Agent de support', NULL, NULL),
(2222, 'fr', 'offline', 'Hors ligne', NULL, NULL),
(2223, 'fr', 'our_technical_team_is_available_in_the', 'Notre équipe technique est disponible dans le', NULL, NULL),
(2224, 'fr', 'timezone', 'fuseau horaire', NULL, NULL),
(2225, 'fr', 'please_select_end_time', 'Veuillez sélectionner l\'heure de fin', NULL, NULL),
(2226, 'fr', 'please_select_start_time', 'Veuillez sélectionner l\'heure de début', NULL, NULL),
(2227, 'fr', 'setting_has_been_updated', 'Le paramètre a été mis à jour', NULL, NULL),
(2228, 'fr', 'closed', 'Fermé', NULL, NULL),
(2229, 'fr', 'manange_triggering', 'Gérer le déclenchement', NULL, NULL),
(2230, 'fr', 'triggers', 'Déclencheurs', NULL, NULL),
(2231, 'fr', 'trigger_list', 'Liste des déclencheurs', NULL, NULL),
(2232, 'fr', 'times_used', 'Nombre d\'utilisations', NULL, NULL),
(2233, 'fr', 'last_action', 'Dernière action', NULL, NULL),
(2234, 'fr', 'ticket_statuses', 'Statuts des tickets', NULL, NULL),
(2235, 'fr', 'ticket_status_list', 'Liste des statuts de tickets', NULL, NULL),
(2236, 'fr', 'products', 'Produits', NULL, NULL),
(2237, 'fr', 'configuration', 'Configuration', NULL, NULL),
(2238, 'fr', 'enable_ticket_product', 'Activer le produit de ticket', NULL, NULL),
(2239, 'fr', 'enabling_this_option_will_activate_ticket_product_selection_during_ticket_create', 'L\'activation de cette option activera la sélection du produit de ticket lors de la création du ticket', NULL, NULL),
(2240, 'fr', 'user_ticket_reopen', 'Réouverture du ticket par l\'utilisateur', NULL, NULL),
(2241, 'fr', 'enabling_this_option_will_allow_user_to_reopen_their_cloesed_ticket', 'L\'activation de cette option permettra à l\'utilisateur de rouvrir son ticket fermé', NULL, NULL),
(2242, 'fr', 'incoming_email_gateways', 'Passerelles d\'email entrant', NULL, NULL),
(2243, 'fr', 'create_gateway', 'Créer une passerelle', NULL, NULL),
(2244, 'fr', 'must_be_unique', 'Doit être unique', NULL, NULL),
(2245, 'fr', 'product', 'Produit', NULL, NULL),
(2246, 'fr', 'seletct_product', 'Sélectionner un produit', NULL, NULL),
(2247, 'fr', 'gateways', 'Passerelles', NULL, NULL),
(2248, 'fr', 'you_can_reach_our_technical_team_during_hours_aligned_with_the_', 'Vous pouvez joindre notre équipe technique pendant les heures correspondant au', NULL, NULL),
(2249, 'fr', 'start__end_time', 'Heure de début et de fin', NULL, NULL),
(2250, 'fr', '24_hour', '24 heures', NULL, NULL),
(2251, 'fr', 'online', 'En ligne', NULL, NULL),
(2252, 'fr', 'operating_hours_note', 'Note sur les heures de service', NULL, NULL),
(2253, 'fr', 'notification_variables', 'Variables de notification', NULL, NULL),
(2254, 'fr', 'order_variable', 'Variable de commande', NULL, NULL),
(2255, 'fr', 'item_variable', 'Variable d\'article', NULL, NULL),
(2256, 'fr', 'sms__email', 'SMS et Email', NULL, NULL),
(2257, 'fr', 'whatsapp', 'WhatsApp', NULL, NULL),
(2258, 'fr', 'sms_message', 'Message SMS', NULL, NULL),
(2259, 'fr', 'enter_message', 'Entrez le message', NULL, NULL),
(2260, 'fr', 'email_message', 'Message électronique', NULL, NULL),
(2261, 'fr', 'templates', 'Modèles', NULL, NULL),
(2262, 'fr', 'template', 'Modèle', NULL, NULL),
(2263, 'fr', 'load_template', 'Charger le modèle', NULL, NULL),
(2264, 'fr', 'select_a_template', 'Sélectionnez un modèle', NULL, NULL),
(2265, 'fr', 'note', 'Note', NULL, NULL),
(2266, 'fr', 'select_audience', 'Sélectionner l\'audience', NULL, NULL),
(2267, 'fr', 'instaction_note', 'Note d\'instructions', NULL, NULL),
(2268, 'fr', 'select_product', 'Sélectionner un produit', NULL, NULL),
(2269, 'fr', 'variables', 'Variables', NULL, NULL),
(2270, 'fr', 'global_email_template', 'Modèle d\'email global', NULL, NULL),
(2271, 'fr', 'email_template_short_code', 'Code court du modèle d\'email', NULL, NULL),
(2272, 'fr', 'sent_from_email', 'Envoyé depuis l\'email', NULL, NULL),
(2273, 'fr', 'email_template', 'Modèle d\'email', NULL, NULL),
(2274, 'fr', 'mail_template_short_code', 'Code court du modèle d\'email', NULL, NULL),
(2275, 'fr', 'mail_body', 'Corps de l\'email', NULL, NULL),
(2276, 'fr', 'system_timezone', 'Fuseau horaire du système', NULL, NULL),
(2277, 'fr', 'enter_note', 'Entrez la note', NULL, NULL),
(2278, 'fr', 'envato_configuration', 'Configuration Envato', NULL, NULL),
(2279, 'fr', 'label', 'Étiquette', NULL, NULL),
(2280, 'fr', 'drag_the_card_in_any_section', 'Faites glisser la carte dans n\'importe quelle section', NULL, NULL),
(2281, 'fr', 'mandatory', 'Obligatoire', NULL, NULL),
(2282, 'fr', 'add_more_input_field', 'Ajouter un champ de saisie supplémentaire', NULL, NULL),
(2283, 'fr', 'set_a_label', 'Définir une étiquette', NULL, NULL),
(2284, 'fr', 'select_type', 'Sélectionner le type', NULL, NULL),
(2285, 'fr', 'yes', 'Oui', NULL, NULL),
(2286, 'fr', 'no', 'Non', NULL, NULL),
(2287, 'fr', 'set_a_placeholder_for_this_new_input_field', 'Définir un espace réservé pour ce nouveau champ de saisie', NULL, NULL),
(2288, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2289, 'fr', 'update_input_field', 'Mettre à jour le champ de saisie', NULL, NULL),
(2290, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2291, 'fr', 'option_value', 'Valeur de l\'option', NULL, NULL),
(2292, 'fr', 'display_name', 'Nom d\'affichage', NULL, NULL),
(2293, 'fr', 'multiple_seclect', 'Sélection multiple', NULL, NULL),
(2294, 'fr', 'single_select', 'Sélection unique', NULL, NULL),
(2295, 'fr', 'option_display_name', 'Nom d\'affichage de l\'option', NULL, NULL),
(2296, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2297, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2298, 'fr', 'envato_business_configuration', 'Configuration commerciale Envato', NULL, NULL),
(2299, 'fr', 'save__sync', 'Enregistrer et synchroniser', NULL, NULL),
(2300, 'fr', 'envato_settings', 'Paramètres Envato', NULL, NULL),
(2301, 'fr', 'envato_verifications', 'Vérifications Envato', NULL, NULL),
(2302, 'fr', 'enabling_this_option_will_activate_envato_verification_during_ticket_creation_if_the_product_is_synced_from_envato', 'L\'activation de cette option activera la vérification Envato lors de la création du ticket si le produit est synchronisé à partir d\'Envato.', NULL, NULL),
(2303, 'fr', 'enable_support_duration_verification', 'Activer la vérification de la durée du support', NULL, NULL),
(2304, 'fr', 'enabling_this_option_will_activate_validation_of_the_envato_product_support_duration_during_ticket_creation', 'L\'activation de cette option activera la validation de la durée du support du produit Envato lors de la création du ticket', NULL, NULL),
(2305, 'fr', 'ticket_status_is_', 'Le statut du ticket est', NULL, NULL),
(2306, 'fr', 'if_the_envato_support_is_expired', 'si le support Envato a expiré', NULL, NULL),
(2307, 'fr', 'envatio_support_expired_mail', 'Email d\'expiration du support Envato', NULL, NULL),
(2308, 'fr', 'this_email_will_be_sent_when_a_clients_envato_support_has_expired', 'Cet email sera envoyé lorsqu\'un support Envato d\'un client a expiré', NULL, NULL),
(2309, 'fr', 'are_you_sure', 'Êtes-vous sûr(e) ?', NULL, NULL),
(2310, 'fr', 'this_will_reset_any_previous_item_changes_of_this_author', 'Cela réinitialisera tous les changements d\'éléments précédents de cet auteur', NULL, NULL),
(2311, 'fr', 'log_into_your_account', 'Connectez-vous à votre compte', NULL, NULL),
(2312, 'fr', 'were_glad_to_see_you_again', 'Nous sommes heureux de vous revoir !', NULL, NULL),
(2313, 'fr', 'enter_captcha_value', 'Entrez la valeur du captcha', NULL, NULL),
(2314, 'fr', 'dont_have_an_account', 'Vous n\'avez pas de compte ?', NULL, NULL),
(2315, 'fr', 'create_new', 'Créer un nouveau', NULL, NULL),
(2316, 'fr', 'user_login', 'Connexion utilisateur', NULL, NULL),
(2317, 'fr', 'assign_ticket_with_sort_notes', 'Attribuer un ticket avec des notes triées', NULL, NULL),
(2318, 'fr', 'me', 'Moi', NULL, NULL),
(2319, 'fr', 'write_short_note_here', 'Écrivez une note courte ici', NULL, NULL),
(2320, 'fr', 'source', 'Source', NULL, NULL),
(2321, 'fr', 'manage_agent', 'Gérer l\'agent', NULL, NULL),
(2322, 'fr', 'agents', 'Agents', NULL, NULL),
(2323, 'fr', 'add_new_agent', 'Ajouter un nouvel agent', NULL, NULL),
(2324, 'fr', 'avg_response_time__responsed_tickets', 'Temps de réponse moyen - Tickets répondus', NULL, NULL),
(2325, 'fr', 'best_agent', 'Meilleur agent', NULL, NULL),
(2326, 'fr', 'update_password', 'Mettre à jour le mot de passe', NULL, NULL),
(2327, 'fr', 'minimum_5_character_required', 'Minimum 5 caractères requis !!', NULL, NULL),
(2328, 'fr', 'confirm_password', 'Confirmer le mot de passe', NULL, NULL),
(2329, 'fr', 'create__agent', 'Créer un agent', NULL, NULL),
(2330, 'fr', 'create_agent', 'Créer un agent', NULL, NULL),
(2331, 'fr', 'agent', 'Agent', NULL, NULL),
(2332, 'fr', 'super_agent', 'Super agent', NULL, NULL),
(2333, 'fr', 'examplegamilcom', 'exemple@gamil.com', NULL, NULL),
(2334, 'fr', 'enter_phone_number', 'Entrez le numéro de téléphone', NULL, NULL),
(2335, 'fr', 'access_categories', 'Accéder aux catégories', NULL, NULL),
(2336, 'fr', 'permissions', 'Autorisations', NULL, NULL),
(2337, 'fr', 'email_field_is_required', 'Le champ email est obligatoire', NULL, NULL),
(2338, 'fr', 'this_email_is_already_taken', 'Cet email est déjà utilisé', NULL, NULL),
(2339, 'fr', 'user_name_field_is_required', 'Le champ nom d\'utilisateur est obligatoire', NULL, NULL),
(2340, 'fr', 'this_username_is_already_taken', 'Ce nom d\'utilisateur est déjà utilisé', NULL, NULL),
(2341, 'fr', 'phone_field_is_required', 'Le champ téléphone est obligatoire', NULL, NULL),
(2342, 'fr', 'please_select_a_category', 'Veuillez sélectionner une catégorie', NULL, NULL),
(2343, 'fr', 'permission_is_required', 'L\'autorisation est obligatoire', NULL, NULL),
(2344, 'fr', 'please_select_an_status', 'Veuillez sélectionner un statut', NULL, NULL),
(2345, 'fr', 'password_feild_is_required', 'Le champ mot de passe est obligatoire', NULL, NULL),
(2346, 'fr', 'confirm_password_does_not_match', 'Le mot de passe de confirmation ne correspond pas', NULL, NULL),
(2347, 'fr', 'minimum_5_digit_or_character_is_required', 'Minimum 5 chiffres ou caractères sont requis', NULL, NULL),
(2348, 'fr', 'select_your_address', 'Sélectionnez votre adresse', NULL, NULL),
(2349, 'fr', 'agent_creted_successfully', 'Agent créé avec succès', NULL, NULL),
(2350, 'fr', 'create__user', 'Créer un utilisateur', NULL, NULL),
(2351, 'fr', 'users', 'Utilisateurs', NULL, NULL),
(2352, 'fr', 'create_user', 'Créer un utilisateur', NULL, NULL),
(2353, 'fr', 'user_name_feild_is_required', 'Le champ nom d\'utilisateur est obligatoire', NULL, NULL),
(2354, 'fr', 'email_feild_is_required', 'Le champ email est obligatoire', NULL, NULL),
(2355, 'fr', 'email_feild_must_be_unique', 'Le champ email doit être unique', NULL, NULL),
(2356, 'fr', 'phone_feild_is_required', 'Le champ téléphone est obligatoire', NULL, NULL),
(2357, 'fr', 'phone_feild_must_be_unique', 'Le champ téléphone doit être unique', NULL, NULL),
(2358, 'fr', 'please_select_a_status', 'Veuillez sélectionner un statut', NULL, NULL),
(2359, 'fr', 'user_created_successfully', 'Utilisateur créé avec succès', NULL, NULL),
(2360, 'fr', 'manage_users', 'Gérer les utilisateurs', NULL, NULL),
(2361, 'fr', 'add_new_user', 'Ajouter un nouvel utilisateur', NULL, NULL),
(2362, 'fr', 'user_not_found', 'Utilisateur non trouvé', NULL, NULL),
(2363, 'fr', 'successfully_login_as_a_user', 'Connexion réussie en tant qu\'utilisateur', NULL, NULL),
(2364, 'fr', 'last_activity', 'Dernière activité', NULL, NULL),
(2365, 'fr', 'ticket_by_month', 'Tickets par mois', NULL, NULL),
(2366, 'fr', 'user_dashboard', 'Tableau de bord utilisateur', NULL, NULL),
(2367, 'fr', 'chat', 'Chat', NULL, NULL),
(2368, 'fr', 'manage_ticket', 'Gérer le ticket', NULL, NULL),
(2369, 'fr', 'canned_reply', 'Réponse pré-enregistrée', NULL, NULL),
(2370, 'fr', 'accept_our_cookie', 'Accepter nos cookies', NULL, NULL),
(2371, 'fr', 'accept__continue', 'Accepter et continuer', NULL, NULL),
(2372, 'fr', 'monday', 'Lundi', NULL, NULL),
(2373, 'fr', 'tuesday', 'Mardi', NULL, NULL),
(2374, 'fr', 'wednesday', 'Mercredi', NULL, NULL),
(2375, 'fr', 'thursday', 'Jeudi', NULL, NULL),
(2376, 'fr', 'friday', 'Vendredi', NULL, NULL),
(2377, 'fr', 'saturday', 'Samedi', NULL, NULL),
(2378, 'fr', '', '', NULL, NULL),
(2379, 'fr', 'manage_notifications', 'Gérer les notifications', NULL, NULL),
(2380, 'fr', 'notifications_settings', 'Paramètres de notification', NULL, NULL),
(2381, 'fr', 'notify_me_when', 'Me prévenir quand', NULL, NULL),
(2382, 'fr', 'sms', 'Sms', NULL, NULL),
(2383, 'fr', 'browser', 'Navigateur', NULL, NULL),
(2384, 'fr', 'slack', 'Slack', NULL, NULL),
(2385, 'fr', 'there_is_a_new_ticketconversation', 'Il y a un nouveau ticket/conversation', NULL, NULL),
(2386, 'fr', 'notify_me_when_agent', 'Me prévenir quand l\'agent', NULL, NULL),
(2387, 'fr', 'replied_to_a_conversations', 'A répondu à une conversation', NULL, NULL),
(2388, 'fr', 'assign_a_ticket_to_', 'Attribuer un ticket à ', NULL, NULL),
(2389, 'fr', 'notify_me_when_customer', 'Me prévenir quand le client', NULL, NULL),
(2390, 'fr', 'replied_to_on_of_my_conversations', 'A répondu à une de mes conversations', NULL, NULL),
(2391, 'fr', 'start_a_new_chat_message_with_me', 'Démarrer un nouveau chat (message avec moi)', NULL, NULL),
(2392, 'fr', 'replied_to_', 'A répondu à ', NULL, NULL),
(2393, 'fr', 'admin_notifications_settings', 'Paramètres de notification de l\'administrateur', NULL, NULL),
(2394, 'fr', 'notifications_settings_updated', 'Paramètres de notification mis à jour', NULL, NULL),
(2395, 'fr', 'social_login_setup', 'Configuration de la connexion sociale', NULL, NULL),
(2396, 'fr', 'mail_configuration', 'Configuration de la messagerie', NULL, NULL),
(2397, 'fr', 'mail_gateway', 'Passerelle de messagerie', NULL, NULL),
(2398, 'fr', 'mail_gateway_list', 'Liste des passerelles de messagerie', NULL, NULL),
(2399, 'fr', 'gateway_name', 'Nom de la passerelle', NULL, NULL),
(2400, 'fr', 'update_gateway', 'Mettre à jour la passerelle', NULL, NULL),
(2401, 'fr', 'email_gateway', 'Passerelle de messagerie', NULL, NULL),
(2402, 'fr', 'driver', 'Pilote', NULL, NULL),
(2403, 'fr', 'enter_driver', 'Entrez le pilote', NULL, NULL),
(2404, 'fr', 'host', 'Hôte', NULL, NULL),
(2405, 'fr', 'enter_host', 'Entrez l\'hôte', NULL, NULL),
(2406, 'fr', 'port', 'Port', NULL, NULL),
(2407, 'fr', 'enter_port', 'Entrez le port', NULL, NULL),
(2408, 'fr', 'encryption', 'Cryptage', NULL, NULL),
(2409, 'fr', 'enter_encryption', 'Entrez le cryptage', NULL, NULL),
(2410, 'fr', 'enter_mail_username', 'Entrez le nom d\'utilisateur de l\'email', NULL, NULL),
(2411, 'fr', 'enter_mail_password', 'Entrez le mot de passe de l\'email', NULL, NULL),
(2412, 'fr', 'from_address', 'Adresse de l\'expéditeur', NULL, NULL),
(2413, 'fr', 'enter_from_address', 'Entrez l\'adresse de l\'expéditeur', NULL, NULL),
(2414, 'fr', 'from_name', 'Nom de l\'expéditeur', NULL, NULL),
(2415, 'fr', 'enter_from_name', 'Entrez le nom de l\'expéditeur', NULL, NULL),
(2416, 'fr', 'test_gateway', 'Tester la passerelle', NULL, NULL),
(2417, 'fr', 'enter_your_mail', 'Entrez votre email', NULL, NULL),
(2418, 'fr', 'test', 'Tester', NULL, NULL),
(2419, 'fr', 'smtp_mail_method_has_been_updated', 'La méthode d\'envoi SMTP a été mise à jour', NULL, NULL),
(2420, 'fr', 'mail_configuration_error_please_check_your_mail_configuration_properly', 'Erreur de configuration de messagerie, veuillez vérifier correctement votre configuration de messagerie', NULL, NULL),
(2421, 'fr', 'categories', 'Catégories', NULL, NULL),
(2422, 'fr', 'category_list', 'Liste des catégories', NULL, NULL),
(2423, 'fr', 'inctive', 'Inactif', NULL, NULL),
(2424, 'fr', 'delete', 'Supprimer', NULL, NULL),
(2425, 'fr', 'search_by_name', 'Rechercher par nom', NULL, NULL),
(2426, 'fr', 'add_category', 'Ajouter une catégorie', NULL, NULL),
(2427, 'fr', 'sort_details', 'Détails du tri', NULL, NULL),
(2428, 'fr', 'write_sort_details_here', 'Écrivez les détails du tri ici', NULL, NULL),
(2429, 'fr', 'do_you_want_to_delete_these_records', 'Voulez-vous supprimer ces enregistrements ??', NULL, NULL),
(2430, 'fr', 'name_feild_must_be_required', 'Le champ nom doit être obligatoire', NULL, NULL),
(2431, 'fr', 'category_name_must_be_unique', 'Le nom de la catégorie doit être unique', NULL, NULL),
(2432, 'fr', 'short_details_is_required', 'Les courts détails sont obligatoires', NULL, NULL),
(2433, 'fr', 'category_created_successfully', 'Catégorie créée avec succès', NULL, NULL),
(2434, 'fr', '_feild_is_required', 'Le champ est obligatoire', NULL, NULL),
(2435, 'fr', 'you_have_a_new_unassigned_ticket', 'Vous avez un nouveau ticket non attribué', NULL, NULL),
(2436, 'fr', 'ticket_successfully_created_', 'Ticket créé avec succès ', NULL, NULL),
(2437, 'fr', 'notification_please_review_your_email', 'Notification : veuillez consulter votre email', NULL, NULL),
(2438, 'fr', 'ticket_issued_your_ticketid_is_', 'Ticket émis : votre numéro de ticket est ', NULL, NULL),
(2439, 'fr', 'your_ticket', 'Votre ticket', NULL, NULL),
(2440, 'fr', 'ticket_details', 'Détails du ticket', NULL, NULL),
(2441, 'fr', 'ticket_number', 'Numéro de ticket', NULL, NULL),
(2442, 'fr', 'user_name', 'Nom d\'utilisateur', NULL, NULL),
(2443, 'fr', 'user_email', 'Email de l\'utilisateur', NULL, NULL),
(2444, 'fr', 'category', 'Catégorie', NULL, NULL),
(2445, 'fr', 'create_date', 'Date de création', NULL, NULL),
(2446, 'fr', 'custom_ticket_data', 'Données personnalisées du ticket', NULL, NULL),
(2447, 'fr', 'no_file_found', 'Aucun fichier trouvé', NULL, NULL),
(2448, 'fr', 'main_ticket_attachment', 'Pièce jointe principale du ticket', NULL, NULL),
(2449, 'fr', 'reply', 'Répondre', NULL, NULL),
(2450, 'fr', 'envato_verification', 'Vérification Envato', NULL, NULL),
(2451, 'fr', 'upload_file', 'Télécharger un fichier', NULL, NULL),
(2452, 'fr', 'maximum_file_upload_', 'Téléchargement maximal de fichiers :', NULL, NULL),
(2453, 'fr', 'load_more', 'Charger plus', NULL, NULL),
(2454, 'fr', 'reply_list', 'Liste des réponses', NULL, NULL),
(2455, 'fr', 'select_template', 'Sélectionner un modèle', NULL, NULL),
(2456, 'fr', 'start_typing', 'Commencez à taper...', NULL, NULL),
(2457, 'fr', 'something_went_wrong__please_try_agian', 'Quelque chose s\'est mal passé !! Veuillez réessayer', NULL, NULL),
(2458, 'fr', 'view_ticket', 'Voir le ticket', NULL, NULL),
(2459, 'fr', 'unread_notifications', 'Notifications non lues', NULL, NULL),
(2460, 'fr', 'clear_all', 'Tout effacer', NULL, NULL),
(2461, 'fr', 'view_all_notifications', 'Voir toutes les notifications', NULL, NULL),
(2462, 'fr', 'pending_tickets_', 'Tickets en attente : ', NULL, NULL),
(2463, 'fr', 'all_notifications', 'Toutes les notifications', NULL, NULL),
(2464, 'fr', 'notification', 'Notification', NULL, NULL),
(2465, 'fr', 'no_response_yet', 'Pas encore de réponse', NULL, NULL),
(2466, 'fr', 'not_resolved_yet', 'Pas encore résolu', NULL, NULL),
(2467, 'fr', 'ticket_id_feild_is_required', 'Le champ ID du ticket est obligatoire', NULL, NULL),
(2468, 'fr', 'ticket_id_feild_must_be_an_array', 'Le champ ID du ticket doit être un tableau', NULL, NULL),
(2469, 'fr', 'invalid_tickets_selected', 'Tickets invalides sélectionnés', NULL, NULL),
(2470, 'fr', 'you_have_a_new_assigned_ticket_by', 'Vous avez un nouveau ticket assigné par', NULL, NULL),
(2471, 'fr', 'ticket_assigned_successfully', 'Ticket attribué avec succès', NULL, NULL),
(2472, 'fr', 'agent_not_found', 'Agent non trouvé', NULL, NULL),
(2473, 'fr', 'successfully_login_as_a_agent', 'Connexion réussie en tant qu\'agent', NULL, NULL),
(2474, 'fr', 'profile_settings', 'Paramètres du profil', NULL, NULL),
(2475, 'fr', 'enter_your_user_name', 'Entrez votre nom d\'utilisateur', NULL, NULL),
(2476, 'fr', 'phonenumber', 'Numéro de téléphone', NULL, NULL),
(2477, 'fr', 'enter_your_phone_number', 'Entrez votre numéro de téléphone', NULL, NULL),
(2478, 'fr', 'emailaddress', 'Adresse email', NULL, NULL),
(2479, 'fr', 'admin_profile', 'Profil administrateur', NULL, NULL),
(2480, 'fr', 'change_password', 'Modifier le mot de passe', NULL, NULL),
(2481, 'fr', 'old_password', 'Ancien mot de passe', NULL, NULL),
(2482, 'fr', 'enter_current_password', 'Entrez le mot de passe actuel', NULL, NULL),
(2483, 'fr', 'newpassword', 'Nouveau mot de passe', NULL, NULL),
(2484, 'fr', 'enter_new_password', 'Entrez le nouveau mot de passe', NULL, NULL),
(2485, 'fr', 'confirmpassword', 'Confirmer le mot de passe', NULL, NULL),
(2486, 'fr', 'changepassword', 'Modifier le mot de passe', NULL, NULL),
(2487, 'fr', 'notification_not_found', 'Notification non trouvée', NULL, NULL),
(2488, 'fr', 'notification_readed', 'Notification lue', NULL, NULL),
(2489, 'fr', 'unauthorized_access', 'Accès non autorisé', NULL, NULL),
(2490, 'fr', 'no_user_found_', 'Aucun utilisateur trouvé !!', NULL, NULL),
(2491, 'fr', 'user_blocked', 'Utilisateur bloqué', NULL, NULL),
(2492, 'fr', 'user_unblocked', 'Utilisateur débloqué', NULL, NULL),
(2493, 'fr', 'agent_update', 'Mise à jour de l\'agent', NULL, NULL),
(2494, 'fr', 'update_agent', 'Mettre à jour l\'agent', NULL, NULL),
(2495, 'fr', 'enter_your_phone', 'Entrez votre téléphone', NULL, NULL),
(2496, 'fr', 'agent_updated_successfully', 'Agent mis à jour avec succès', NULL, NULL),
(2497, 'fr', 'short_notes', 'Notes courtes', NULL, NULL),
(2498, 'fr', 'previous_ticket', 'Ticket précédent', NULL, NULL),
(2499, 'fr', 'email_notifications', 'Notifications par email', NULL, NULL),
(2500, 'fr', 'enable_email_notification_form_system_notification_settings', 'Activer la notification par email à partir des paramètres de notification du système', NULL, NULL),
(2501, 'fr', 'sms_notifications', 'Notifications par SMS', NULL, NULL),
(2502, 'fr', 'enable_sms_notification_form_system_notification_settings', 'Activer la notification par SMS à partir des paramètres de notification du système', NULL, NULL),
(2503, 'fr', 'browser_notifications', 'Notifications du navigateur', NULL, NULL),
(2504, 'fr', 'enable_browser_notification_form_system_notification_settings_', 'Activer la notification du navigateur à partir des paramètres de notification du système', NULL, NULL),
(2505, 'fr', 'ticket_files', 'Fichiers du ticket', NULL, NULL),
(2506, 'fr', 'enter_purchase_key', 'Entrez la clé d\'achat', NULL, NULL),
(2507, 'fr', 'verify_purchase', 'Vérifier l\'achat', NULL, NULL),
(2508, 'fr', 'send__', 'Envoyer & ', NULL, NULL),
(2509, 'fr', 'add_note', 'Ajouter une note', NULL, NULL),
(2510, 'fr', 'update_message', 'Mettre à jour le message', NULL, NULL),
(2511, 'fr', 'original_message', 'Message d\'origine', NULL, NULL),
(2512, 'fr', 'ticket', 'Ticket', NULL, NULL),
(2513, 'fr', 'merged_tickets_can_not_be_unmerged', 'Les tickets fusionnés ne peuvent pas être défusionnés.', NULL, NULL),
(2514, 'fr', 'are_you_sure_you_want_merge_this_ticket_with_the_original_one_behind_the_popupsmerged_tickets_can_not_be_unmerged', 'Êtes-vous sûr de vouloir fusionner ce ticket avec l\'original derrière les pop-ups ? Les tickets fusionnés ne peuvent pas être défusionnés.', NULL, NULL),
(2515, 'fr', 'yes_merge_it', 'Oui, fusionnez-le !', NULL, NULL),
(2516, 'fr', 'edit', 'Modifier', NULL, NULL),
(2517, 'fr', 'show_original', 'Afficher l\'original', NULL, NULL),
(2518, 'fr', 'message_feild_is_required', 'Le champ message est obligatoire', NULL, NULL),
(2519, 'fr', 'replied_successfully', 'Répondu avec succès', NULL, NULL),
(2520, 'fr', 'hello_dear_', 'Bonjour cher !!! ', NULL, NULL),
(2521, 'fr', 'replied_to', 'A répondu à', NULL, NULL),
(2522, 'fr', 'new', 'Nouveau', NULL, NULL),
(2523, 'fr', 'ticket_closed', 'Ticket fermé', NULL, NULL),
(2524, 'fr', 'response_list', 'Liste des réponses', NULL, NULL),
(2525, 'fr', 'add_new_reply', 'Ajouter une nouvelle réponse', NULL, NULL),
(2526, 'fr', 'share_with', 'Partager avec', NULL, NULL),
(2527, 'fr', 'add_reply', 'Ajouter une réponse', NULL, NULL),
(2528, 'fr', 'body', 'Corps', NULL, NULL),
(2529, 'fr', 'share_canned_reply', 'Partager la réponse pré-enregistrée', NULL, NULL),
(2530, 'fr', 'assigned_to', 'Attribué à', NULL, NULL),
(2531, 'fr', 'slack_notifications', 'Notifications Slack', NULL, NULL),
(2532, 'fr', 'enable_slack_notification_form_system_notification_settings_', 'Activer la notification Slack à partir des paramètres de notification du système', NULL, NULL),
(2533, 'fr', 'agent_doesnot_exists', 'L\'agent n\'existe pas', NULL, NULL),
(2534, 'fr', 'deleted_successfully', 'Supprimé avec succès', NULL, NULL),
(2535, 'fr', 'edit_ticket', 'Modifier le ticket', NULL, NULL),
(2536, 'fr', 'ticket_category', 'Catégorie de ticket', NULL, NULL),
(2537, 'fr', 'select_category', 'Sélectionner une catégorie', NULL, NULL),
(2538, 'fr', 'product_list', 'Liste de produits', NULL, NULL),
(2539, 'fr', 'add_product', 'Ajouter un produit', NULL, NULL),
(2540, 'fr', 'envato_product', 'Produit Envato', NULL, NULL),
(2541, 'fr', 'manage_product', 'Gérer le produit', NULL, NULL),
(2542, 'fr', 'default_name_is_required', 'Le nom par défaut est obligatoire', NULL, NULL),
(2543, 'fr', 'default_name_must_be_unique', 'Le nom par défaut doit être unique', NULL, NULL),
(2544, 'fr', 'product_created_successfully', 'Produit créé avec succès', NULL, NULL),
(2545, 'fr', 'system', 'Système', NULL, NULL),
(2546, 'fr', 'product_updated_successfully', 'Produit mis à jour avec succès', NULL, NULL),
(2547, 'fr', 'ticket_updated_successfully', 'Ticket mis à jour avec succès', NULL, NULL),
(2548, 'fr', 'cache_cleared_successfully', 'Cache vidé avec succès', NULL, NULL),
(2549, 'fr', 'sms_gateway_list', 'Liste des passerelles SMS', NULL, NULL),
(2550, 'fr', 'sms_global_template', 'Modèle SMS global', NULL, NULL),
(2551, 'fr', 'sms_template_short_code', 'Code court du modèle SMS', NULL, NULL),
(2552, 'fr', 'email_templates', 'Modèles d\'emails', NULL, NULL),
(2553, 'fr', 'template_list', 'Liste des modèles', NULL, NULL),
(2554, 'fr', '_name', ' Nom', NULL, NULL),
(2555, 'fr', 'email_not_found', 'Email non trouvé', NULL, NULL),
(2556, 'fr', 'manange_groups', 'Gérer les groupes', NULL, NULL),
(2557, 'fr', 'groups', 'Groupes', NULL, NULL),
(2558, 'fr', 'group_list', 'Liste des groupes', NULL, NULL),
(2559, 'fr', 'add_new_', 'Ajouter nouveau', NULL, NULL),
(2560, 'fr', 'optinos', 'Options', NULL, NULL),
(2561, 'fr', 'personal_details', 'Informations personnelles', NULL, NULL),
(2562, 'fr', 'user_profile', 'Profil utilisateur', NULL, NULL),
(2563, 'fr', 'language_switched_successfully', 'Langue changée avec succès', NULL, NULL),
(2564, 'fr', 'translate_language', 'Traduire la langue', NULL, NULL),
(2565, 'fr', 'key', 'clé', NULL, NULL),
(2566, 'fr', 'successfully_translated', 'Traduit avec succès', NULL, NULL),
(2567, 'fr', 'translation_failed', 'Échec de la traduction', NULL, NULL),
(2568, 'fr', 'the_name_feild_is_required', 'Le champ nom est obligatoire', NULL, NULL),
(2569, 'fr', 'the_name_must_be_unique', 'Le nom doit être unique', NULL, NULL),
(2570, 'fr', 'language_created_succesfully', 'Langue créée avec succès', NULL, NULL),
(2571, 'fr', 'subscribers_list', 'Liste des abonnés', NULL, NULL),
(2572, 'fr', 'send_mail', 'Envoyer un email', NULL, NULL),
(2573, 'fr', 'send', 'Envoyer', NULL, NULL),
(2574, 'fr', 'succesfully_sent', 'Envoyé avec succès', NULL, NULL),
(2575, 'fr', 'system_configuration', 'Configuration du système', NULL, NULL),
(2576, 'fr', 'email_notification', 'Notification par email', NULL, NULL),
(2577, 'fr', 'enable_or_disable_email_notifications_for_various_events_or_activities_within_the_system_this_allows_you_to_stay_updated_via_email', 'Activer ou désactiver les notifications par email pour divers événements ou activités au sein du système. Cela vous permet de rester informé par email.', NULL, NULL),
(2578, 'fr', 'sms_notification', 'Notification SMS', NULL, NULL),
(2579, 'fr', 'activate_or_deactivate_sms_notifications_which_can_be_used_to_receive_important_alerts_or_updates_via_text_messages', 'Activez ou désactivez les notifications SMS, qui peuvent être utilisées pour recevoir des alertes ou des mises à jour importantes par SMS.', NULL, NULL),
(2580, 'fr', 'captcha_validations', 'Validations Captcha', NULL, NULL),
(2581, 'fr', 'enable_or_disable_captcha_validations_which_help_prevent_automated_spam_or_abuse_by_requiring_users_to_complete_a_verification_process', 'Activer ou désactiver les validations Captcha, qui aident à empêcher le spam ou les abus automatisés en exigeant des utilisateurs qu\'ils effectuent un processus de vérification.', NULL, NULL),
(2582, 'fr', 'database_notifications', 'Notifications de la base de données', NULL, NULL),
(2583, 'fr', 'control_the_systems_notifications_related_to_database_activities_such_as_updates_or_changes_to_the_database', 'Contrôler les notifications du système liées aux activités de la base de données, telles que les mises à jour ou les modifications de la base de données.', NULL, NULL),
(2584, 'fr', 'integrate_the_system_with_slack_and_receive_notifications_directly_in_your_slack_workspace_for_realtime_updates', 'Intégrer le système à Slack et recevoir des notifications directement dans votre espace de travail Slack pour des mises à jour en temps réel.', NULL, NULL),
(2585, 'fr', 'cookie_activation', 'Activation des cookies', NULL, NULL),
(2586, 'fr', 'enable_or_disable_the_use_of_cookies_for_user_sessions_and_tracking_purposes', 'Activer ou désactiver l\'utilisation de cookies pour les sessions utilisateur et à des fins de suivi.', NULL, NULL),
(2587, 'fr', 'automatic_ticket_assign', 'Attribution automatique de tickets', NULL, NULL),
(2588, 'fr', 'configure_the_system_to_automatically_assign_incoming_tickets_or_tasks_to_specific_agents_or_teams_based_on_predefined_rules_or_criteria', 'Configurer le système pour attribuer automatiquement les tickets ou tâches entrants à des agents ou équipes spécifiques en fonction de règles ou de critères prédéfinis.', NULL, NULL),
(2589, 'fr', 'group_base_ticket_assign', 'Attribution de tickets basée sur un groupe', NULL, NULL),
(2590, 'fr', 'configure_the_system_to_automatically_assign_incoming_tickets_or_tasks_to_specific_agents_or_teams_based_on_priority_group', 'Configurer le système pour attribuer automatiquement les tickets ou tâches entrants à des agents ou équipes spécifiques en fonction du groupe de priorité', NULL, NULL),
(2591, 'fr', 'ticket_security', 'Sécurité des tickets', NULL, NULL),
(2592, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2593, 'fr', 'user_registration', 'Inscription utilisateur', NULL, NULL),
(2594, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2595, 'fr', 'user_notifications', 'Notifications utilisateur', NULL, NULL),
(2596, 'fr', 'activating_the_initial_module_will_enable_browser_and_email_notifications_for_newly_registered_users', 'L\'activation du module initial activera les notifications par navigateur et par email pour les utilisateurs nouvellement enregistrés', NULL, NULL),
(2597, 'fr', 'email_verifications', 'Vérifications des emails', NULL, NULL),
(2598, 'fr', 'set_up_email_verification_processes_to_ensure_that_users_email_addresses_are_valid_and_to_enhance_security_and_authenticity', 'Mettre en place des processus de vérification des emails pour s\'assurer que les adresses email des utilisateurs sont valides et pour améliorer la sécurité et l\'authenticité.', NULL, NULL),
(2599, 'fr', 'agent_chat_module', 'Module de chat des agents', NULL, NULL),
(2600, 'fr', 'manage_the_agent_chat_module_enabling_agents_to_communicate_and_provide_realtime_support_to_users_through_a_chat_interface', 'Gérer le module de chat des agents, permettant aux agents de communiquer et de fournir une assistance en temps réel aux utilisateurs via une interface de chat.', NULL, NULL),
(2601, 'fr', 'app_debug', 'Débogage de l\'application', NULL, NULL),
(2602, 'fr', 'enable_or_disable_the_app_debug_mode_which_allows_for_the_detection_and_resolution_of_software_bugs_or_issues_by_providing_detailed_error_messages_or_logs', 'Activer ou désactiver le mode de débogage de l\'application, qui permet la détection et la résolution des bogues ou problèmes logiciels en fournissant des messages d\'erreur ou des journaux dét', NULL, NULL),
(2603, 'fr', 'terms__conditions_validation', 'Validation des conditions générales', NULL, NULL),
(2604, 'fr', 'implement_validation_mechanisms_to_ensure_that_users_agree_to_and_comply_with_the_terms_and_conditions_of_using_the_system_or_application', 'Mettre en œuvre des mécanismes de validation pour garantir que les utilisateurs acceptent et se conforment aux termes et conditions d\'utilisation du système ou de l\'application.', NULL, NULL),
(2605, 'fr', 'automated_best_agent_identification', 'Identification automatisée du meilleur agent', NULL, NULL),
(2606, 'fr', 'enabling_this_module_activates_the_automatic_best_agent_selection_feature', 'L\'activation de ce module active la fonction de sélection automatique du meilleur agent.', NULL, NULL),
(2607, 'fr', 'site_maintenance_mode', 'Mode de maintenance du site', NULL, NULL),
(2608, 'fr', 'enabling_this_module_puts_the_site_in_maintenance_mode', 'L\'activation de ce module met le site en mode maintenance', NULL, NULL),
(2609, 'fr', 'force_ssl', 'Forcer SSL', NULL, NULL),
(2610, 'fr', 'enabling_this_feature_mandates_the_use_of_https_for_your_site', 'L\'activation de cette fonction impose l\'utilisation du protocole HTTPS pour votre site.', NULL, NULL),
(2611, 'fr', 'sytem_configuration', 'Configuration du système', NULL, NULL),
(2612, 'fr', 'email_method_has_been_updated', 'La méthode d\'email a été mise à jour', NULL, NULL),
(2613, 'fr', 'successfully_sent_mail_please_check_your_inbox_or_spam', 'Email envoyé avec succès, veuillez consulter votre boîte de réception ou votre dossier spam', NULL, NULL),
(2614, 'fr', 'name_feild_is_required', 'Le champ nom est obligatoire', NULL, NULL),
(2615, 'fr', 'user_name_must_be_unique', 'Le nom d\'utilisateur doit être unique', NULL, NULL),
(2616, 'fr', 'your_profile_has_been_updated', 'Votre profil a été mis à jour.', NULL, NULL),
(2617, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2618, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2619, 'fr', 'select_year', 'Sélectionner l\'année', NULL, NULL),
(2620, 'fr', 'see_all_products', 'Voir tous les produits', NULL, NULL),
(2621, 'fr', 'plese_select_a_product_first', 'Veuillez d\'abord sélectionner un produit', NULL, NULL),
(2622, 'fr', 'recaptcha_validation_failed__try_again', 'La validation Recaptcha a échoué !! veuillez réessayer', NULL, NULL),
(2623, 'fr', 'update__user', 'Mettre à jour l\'utilisateur', NULL, NULL),
(2624, 'fr', 'update_user', 'Mettre à jour l\'utilisateur', NULL, NULL),
(2625, 'fr', 'user_updated_successfully', 'Utilisateur mis à jour avec succès', NULL, NULL),
(2626, 'fr', 'admin_assign_a_conversations_to_me', 'L\'administrateur m\'attribue une conversation', NULL, NULL),
(2627, 'fr', 'agent_notifications_settings', 'Paramètres de notification de l\'agent', NULL, NULL),
(2628, 'fr', 'there_is_a_new_conversation', 'Il y a une nouvelle conversation', NULL, NULL),
(2629, 'fr', 'there_is_a_ticket_reply', 'Il y a une réponse au ticket', NULL, NULL),
(2630, 'fr', 'user_notifications_settings', 'Paramètres de notification de l\'utilisateur', NULL, NULL),
(2631, 'fr', 'contacts', 'Contacts', NULL, NULL),
(2632, 'fr', 'mute_user', 'Mettre l\'utilisateur en sourdine', NULL, NULL),
(2633, 'fr', 'you_have_a_new_message_from_', 'Vous avez un nouveau message de ', NULL, NULL),
(2634, 'fr', 'message_sent', 'Message envoyé', NULL, NULL),
(2635, 'fr', 'direct_messages', 'Messages directs', NULL, NULL),
(2636, 'fr', 'agent_deleted_successfully', 'Agent supprimé avec succès', NULL, NULL),
(2637, 'fr', 'delete_conversation', 'Supprimer la conversation', NULL, NULL),
(2638, 'fr', 'user_muted', 'Utilisateur mis en sourdine', NULL, NULL),
(2639, 'fr', 'user_unmuted', 'Utilisateur réactivé', NULL, NULL),
(2640, 'fr', 'user_chat_list', 'Liste de chat des utilisateurs', NULL, NULL),
(2641, 'fr', 'no_agent_found_', 'Aucun agent trouvé !!', NULL, NULL),
(2642, 'fr', 'an_agent_has_requested_to_mark_this_ticket_as_solved_would_you_like_to_accept_this_request', 'Un agent a demandé à marquer ce ticket comme « Résolu ». Souhaitez-vous accepter cette demande ?', NULL, NULL),
(2643, 'fr', 'thanks_for_your_response', 'Merci pour votre réponse !', NULL, NULL),
(2644, 'fr', 'id_is_required', 'L\'ID est obligatoire', NULL, NULL),
(2645, 'fr', 'select_id_is_invalid', 'L\'ID sélectionné n\'est pas valide', NULL, NULL),
(2646, 'fr', 'status_is_required', 'Le statut est obligatoire', NULL, NULL),
(2647, 'fr', 'key_is_required', 'La clé est obligatoire', NULL, NULL),
(2648, 'fr', 'status_updated', 'Statut mis à jour', NULL, NULL),
(2649, 'fr', 'merge', 'Fusionner', NULL, NULL),
(2650, 'fr', 'view', 'Voir', NULL, NULL),
(2651, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2652, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2653, 'fr', 'search_ticket', 'Rechercher un ticket', NULL, NULL),
(2654, 'fr', 'search_ticket_here', 'Rechercher un ticket ici', NULL, NULL),
(2655, 'fr', 'enter_ticket_number', 'Entrez le numéro du ticket', NULL, NULL),
(2656, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2657, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2658, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2659, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2660, 'fr', 'contact_list', 'Liste de contacts', NULL, NULL),
(2661, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2662, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2663, 'fr', 'user_deleted_successfully', 'Utilisateur supprimé avec succès', NULL, NULL),
(2664, 'fr', 'gateway_created_succesfully', 'Passerelle créée avec succès', NULL, NULL),
(2665, 'fr', 'create_trigger', 'Créer un déclencheur', NULL, NULL),
(2666, 'fr', 'meet', 'Répondre', NULL, NULL),
(2667, 'fr', 'the_following_conditions', 'les conditions suivantes', NULL, NULL),
(2668, 'fr', 'add_condition', 'Ajouter une condition', NULL, NULL),
(2669, 'fr', 'any', 'N\'importe quel', NULL, NULL),
(2670, 'fr', 'perform_these_actions', 'Effectuer ces actions', NULL, NULL),
(2671, 'fr', 'add_action', 'Ajouter une action', NULL, NULL),
(2672, 'fr', 'select_condition', 'Sélectionner une condition', NULL, NULL),
(2673, 'fr', 'enter_value', 'Entrez une valeur', NULL, NULL),
(2674, 'fr', 'all_notification_cleared', 'Toutes les notifications effacées', NULL, NULL),
(2675, 'fr', 'your_input_contained_potentially_harmful_content_and_has_been_sanitized', 'Votre saisie contenait du contenu potentiellement dangereux et a été nettoyée !!', NULL, NULL),
(2676, 'fr', 'manange_priority', 'Gérer la priorité', NULL, NULL),
(2677, 'fr', 'priorities', 'Priorités', NULL, NULL),
(2678, 'fr', 'priority_list', 'Liste des priorités', NULL, NULL),
(2679, 'fr', 'response__resolve', 'Réponse - Résoudre', NULL, NULL),
(2680, 'fr', 'response_in', 'Réponse dans', NULL, NULL),
(2681, 'fr', 'resolve_in', 'Résoudre dans', NULL, NULL),
(2682, 'fr', 'update_priority', 'Mettre à jour la priorité', NULL, NULL),
(2683, 'fr', 'color_code', 'Code de couleur', NULL, NULL),
(2684, 'fr', 'enter_color_code', 'Entrez le code couleur', NULL, NULL),
(2685, 'fr', 'update_ticket_status', 'Mettre à jour le statut du ticket', NULL, NULL),
(2686, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2687, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2688, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2689, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL);
INSERT INTO `translations` (`id`, `code`, `key`, `value`, `created_at`, `updated_at`) VALUES
(2690, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2691, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2692, 'fr', 'something_went_wrong', 'Quelque chose s\'est mal passé !!', NULL, NULL),
(2693, 'fr', 'sms_gateway_update', 'Mise à jour de la passerelle SMS', NULL, NULL),
(2694, 'fr', 'enter_valid_api_data', 'Entrez des données API valides', NULL, NULL),
(2695, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2696, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2697, 'fr', 'logo__has_been_updated', 'Le logo a été mis à jour', NULL, NULL),
(2698, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2699, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2700, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2701, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2702, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2703, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2704, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2705, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2706, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2707, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2708, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2709, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2710, 'fr', 'update_templates', 'Mettre à jour les modèles', NULL, NULL),
(2711, 'fr', 'update_template', 'Mettre à jour le modèle', NULL, NULL),
(2712, 'fr', 'enter_subject', 'Entrer le sujet', NULL, NULL),
(2713, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2714, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2715, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2716, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2717, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2718, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2719, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2720, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2721, 'fr', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'L\'activation de la fonctionnalité de sécurité CAPTCHA améliorera les mesures de sécurité de la plateforme, en ajoutant une couche de protection supplémentaire à la page de création de ticket ', NULL, NULL),
(2722, 'fr', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'L\'activation du premier module active également le module d\'inscription des utilisateurs, indiquant une relation entre les deux. Le module d\'inscription des utilisateurs est probablement soit', NULL, NULL),
(2723, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2724, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2725, 'fr', 'labels_field_is_required', 'Le champ des étiquettes est obligatoire', NULL, NULL),
(2726, 'fr', 'type_field_is_required', 'Le champ type est obligatoire', NULL, NULL),
(2727, 'fr', 'required_field_is_required', 'Le champ obligatoire est requis', NULL, NULL),
(2728, 'fr', 'placeholder_field_is_required', 'Le champ espace réservé est obligatoire', NULL, NULL),
(2729, 'fr', 'default_field_is_required', 'Le champ par défaut est obligatoire', NULL, NULL),
(2730, 'fr', 'please_select_an_option_between_multiselect_or_sigle_select', 'Veuillez sélectionner une option entre la sélection multiple ou la sélection unique', NULL, NULL),
(2731, 'fr', 'the_display_name_is_required', 'Le nom d\'affichage est obligatoire', NULL, NULL),
(2732, 'fr', 'the_option_value_field_is_required', 'Le champ valeur de l\'option est obligatoire', NULL, NULL),
(2733, 'fr', 'updated_successfully', 'Mis à jour avec succès', NULL, NULL),
(2734, 'fr', 'update_category', 'Mettre à jour la catégorie', NULL, NULL),
(2735, 'fr', 'topics', 'Sujets', NULL, NULL),
(2736, 'fr', 'update_topics', 'Mettre à jour les sujets', NULL, NULL),
(2737, 'fr', 'show_in_ticket', 'Afficher dans le ticket', NULL, NULL),
(2738, 'fr', 'show_in_article', 'Afficher dans l\'article', NULL, NULL),
(2739, 'fr', 'category_updated_successfully', 'Catégorie mise à jour avec succès', NULL, NULL),
(2740, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2741, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2742, 'fr', 'sms_template', 'Modèle SMS', NULL, NULL),
(2743, 'fr', 'sms_template_list', 'Liste des modèles SMS', NULL, NULL),
(2744, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2745, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Fermer                                                                                                                                                                                         ', NULL, NULL),
(2747, 'en', 'direct_training', 'Dircet Training', '2024-12-27 11:09:30', '2024-12-27 11:09:30'),
(2748, 'fr', 'direct_training', 'Formation Directe', '2024-12-27 11:19:56', '2024-12-27 11:19:56'),
(2749, 'fr', 'total_clients', 'total des clients', '2024-12-27 11:39:37', '2024-12-27 11:39:37'),
(2750, 'en', 'total_clients', 'Total Clients', '2024-12-27 11:53:26', '2024-12-27 11:53:26'),
(2752, 'fr', 'qualification_phase', 'Phase Qualification', '2024-12-27 11:53:26', '2024-12-27 11:53:26'),
(2753, 'en', 'qualification_phase', 'Qualification Phase', '2024-12-27 11:53:26', '2024-12-27 11:53:26'),
(2757, 'fr', 'administrative_preliminary_phase', 'Phase Administrative Préalable', '2024-12-27 11:53:26', '2024-12-27 11:53:26'),
(2758, 'en', 'administrative_preliminary_phase', 'Administrative Preliminary Phase', '2024-12-27 11:53:26', '2024-12-27 11:53:26'),
(2764, 'en', 'phase_qualification', 'Phase Qualification', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2766, 'en', 'validation_phase', 'Validation Phase', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2767, 'fr', 'validation_phase', 'Phase Validation', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2771, 'en', 'construction_phase', 'Construction Phase', '2024-12-27 14:06:49', '2024-12-27 14:06:49'),
(2772, 'fr', 'construction_phase', 'Phase Réalisation', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2773, 'fr', 'repayment_phase', 'Phase Remboursement', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2774, 'en', 'repayment_phase', 'Repayment Phase', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2777, 'en', 'engineering_+_training', 'Engineering + Training', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2778, 'fr', 'engineering_+_training', 'Ingénierie + Formation', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2782, 'en', 'engineering_phase', 'Engineering Phase', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2783, 'fr', 'engineering_phase', 'Phase Ingénierie', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2786, 'en', 'engineering_realization', 'Engineering Realization', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2787, 'fr', 'engineering_realization', 'Phase Ingénierie', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2790, 'en', 'phase_csf', 'Phase CSF', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2791, 'fr', 'phase_csf', 'Phase CSF', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2792, 'en', 'phase_csf', 'Phase CSF', '2024-12-27 14:26:03', '2024-12-27 14:26:03'),
(2793, 'en', 'phase_csf', 'Phase CSF', '2024-12-27 14:26:03', '2024-12-27 14:26:03'),
(2794, 'en', 'ingnierie__formation', 'Ingénierie + Formation', '2024-12-27 14:26:54', '2024-12-27 14:26:54'),
(2795, 'en', 'ingnierie__formation', 'Ingénierie + Formation', '2024-12-27 14:26:54', '2024-12-27 14:26:54'),
(2796, 'en', 'engineering_phase_', 'Engineering Phase ', '2024-12-27 14:26:54', '2024-12-27 14:26:54'),
(2797, 'en', 'engineering_phase_', 'Engineering Phase ', '2024-12-27 14:26:54', '2024-12-27 14:26:54'),
(2798, 'en', 'engineering_realization_', 'Engineering Realization ', '2024-12-27 14:26:54', '2024-12-27 14:26:54'),
(2799, 'fr', 'repayments_phase', 'Phase Remboursements', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2800, 'en', 'repayments_phase', 'Repayments Phase', '2024-12-27 14:02:20', '2024-12-27 14:02:20'),
(2801, 'en', 'repayments_phase', 'Repayments Phase', '2024-12-27 14:31:33', '2024-12-27 14:31:33'),
(2802, 'en', 'hello', 'Hello', '2024-12-27 14:42:36', '2024-12-27 14:42:36'),
(2803, 'en', 'hello', 'Hello', '2024-12-27 14:42:36', '2024-12-27 14:42:36'),
(2804, 'fr', 'ingnierie__formation', 'Ingénierie + Formation', '2024-12-27 14:47:52', '2024-12-27 14:47:52'),
(2805, 'fr', 'engineering_phase_', 'Engineering Phase ', '2024-12-27 14:47:52', '2024-12-27 14:47:52'),
(2806, 'en', 'administrative_preliminary', 'Administrative Preliminary', '2024-12-27 15:08:20', '2024-12-27 15:08:20'),
(2807, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-27 15:36:21', '2024-12-27 15:36:21'),
(2808, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-27 15:36:21', '2024-12-27 15:36:21'),
(2809, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-27 15:36:54', '2024-12-27 15:36:54'),
(2810, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-27 15:36:54', '2024-12-27 15:36:54'),
(2811, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-27 15:36:58', '2024-12-27 15:36:58'),
(2812, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-27 15:36:58', '2024-12-27 15:36:58'),
(2813, 'en', 'enabling_the_security_captcha_feature_will_enhance_the_platforms_security_measures_adding_an_additional_layer_of_protection_to_the_ticket_creation_page_to_mitigate_spam_and_unauthorized_submi', 'Enabling the security CAPTCHA feature will enhance the platform\'s security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized sub', '2024-12-27 15:37:13', '2024-12-27 15:37:13'),
(2814, 'en', 'enabling_the_first_module_also_activates_the_user_register_module_indicating_a_relationship_between_the_two_the_user_register_module_is_likely_either_a_prerequisite_for_the_proper_functioning', 'Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioni', '2024-12-27 15:37:13', '2024-12-27 15:37:13'),
(2815, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 15:37:14', '2024-12-27 15:37:14'),
(2816, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 15:37:14', '2024-12-27 15:37:14'),
(2817, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 15:37:24', '2024-12-27 15:37:24'),
(2818, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 15:37:24', '2024-12-27 15:37:24'),
(2819, 'en', 'deleted_succesfully', 'Deleted succesfully', '2024-12-27 15:37:39', '2024-12-27 15:37:39'),
(2820, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 15:38:41', '2024-12-27 15:38:41'),
(2821, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 15:38:41', '2024-12-27 15:38:41'),
(2822, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 15:38:50', '2024-12-27 15:38:50'),
(2823, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 15:38:50', '2024-12-27 15:38:50'),
(2824, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 15:39:06', '2024-12-27 15:39:06'),
(2825, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 15:39:06', '2024-12-27 15:39:06'),
(2826, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 15:39:15', '2024-12-27 15:39:15'),
(2827, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 15:39:15', '2024-12-27 15:39:15'),
(2828, 'fr', 'grer_la_langue', 'Gérer la langue', '2024-12-27 15:41:20', '2024-12-27 15:41:20'),
(2829, 'fr', 'default_language_set_successfully', 'Default Language Set Successfully', '2024-12-27 15:41:33', '2024-12-27 15:41:33'),
(2830, 'en', 'cae', 'CAE', '2024-12-27 15:49:06', '2024-12-27 15:49:06'),
(2831, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:15:49', '2024-12-27 16:15:49'),
(2832, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:15:49', '2024-12-27 16:15:49'),
(2833, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:15:55', '2024-12-27 16:15:55'),
(2834, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:15:55', '2024-12-27 16:15:55'),
(2835, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:16:16', '2024-12-27 16:16:16'),
(2836, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:16:16', '2024-12-27 16:16:16'),
(2837, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:23:41', '2024-12-27 16:23:41'),
(2838, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:23:41', '2024-12-27 16:23:41'),
(2839, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:23:47', '2024-12-27 16:23:47'),
(2840, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:23:47', '2024-12-27 16:23:47'),
(2841, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:31:56', '2024-12-27 16:31:56'),
(2842, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:31:56', '2024-12-27 16:31:56'),
(2843, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:32:14', '2024-12-27 16:32:14'),
(2844, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:32:14', '2024-12-27 16:32:14'),
(2845, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:34:35', '2024-12-27 16:34:35'),
(2846, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:34:35', '2024-12-27 16:34:35'),
(2847, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:37:09', '2024-12-27 16:37:09'),
(2848, 'en', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:37:09', '2024-12-27 16:37:09'),
(2849, 'fr', 'cae', 'CAE', '2024-12-27 16:52:09', '2024-12-27 16:52:09'),
(2850, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:53:42', '2024-12-27 16:53:42'),
(2851, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:53:42', '2024-12-27 16:53:42'),
(2852, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:54:42', '2024-12-27 16:54:42'),
(2853, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:54:42', '2024-12-27 16:54:42'),
(2854, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:56:29', '2024-12-27 16:56:29'),
(2855, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:56:29', '2024-12-27 16:56:29'),
(2856, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:56:33', '2024-12-27 16:56:33'),
(2857, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:56:33', '2024-12-27 16:56:33'),
(2858, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:57:41', '2024-12-27 16:57:41'),
(2859, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:57:41', '2024-12-27 16:57:41'),
(2860, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:57:43', '2024-12-27 16:57:43'),
(2861, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-27 16:57:43', '2024-12-27 16:57:43'),
(2862, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-30 14:58:51', '2024-12-30 14:58:51'),
(2863, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2024-12-30 14:58:51', '2024-12-30 14:58:51'),
(2864, 'en', 'enter_whatsapp_number', 'Enter WhatsApp Number', '2024-12-30 16:01:29', '2024-12-30 16:01:29'),
(2865, 'en', 'whatsapp_number', 'WhatsApp Number', '2024-12-30 16:01:48', '2024-12-30 16:01:48'),
(2866, 'en', 'cnss', 'CNSS', '2024-12-30 16:03:37', '2024-12-30 16:03:37'),
(2867, 'en', 'enter_cnss', 'Enter CNSS', '2024-12-30 16:03:37', '2024-12-30 16:03:37'),
(2868, 'en', 'enter_cnss_number', 'Enter CNSS Number', '2024-12-30 16:03:55', '2024-12-30 16:03:55'),
(2869, 'en', 'tranings', 'Tranings', '2024-12-30 16:06:20', '2024-12-30 16:06:20'),
(2870, 'en', 'direct_training_csf', 'Direct Training (CSF)', '2024-12-30 16:08:06', '2024-12-30 16:08:06'),
(2873, 'en', 'training', 'training', '2024-12-30 16:10:25', '2024-12-30 16:10:25'),
(2874, 'en', 'city', 'City', '2024-12-30 16:11:55', '2024-12-30 16:11:55'),
(2875, 'fr', 'whatsapp_number', 'Numéro WhatsApp', '2024-12-31 08:59:23', '2024-12-31 08:59:23'),
(2876, 'fr', 'enter_whatsapp_number', 'Entrez le numéro de WhatsApp', '2024-12-31 08:59:23', '2024-12-31 08:59:23'),
(2877, 'fr', 'cnss', 'CNSS', '2024-12-31 08:59:23', '2024-12-31 08:59:23'),
(2878, 'fr', 'enter_cnss_number', 'Entrez Votre Numéro De CNSS', '2024-12-31 08:59:23', '2024-12-31 08:59:23'),
(2879, 'fr', 'training', 'Formation', '2024-12-31 08:59:23', '2024-12-31 08:59:23'),
(2882, 'fr', 'city', 'Ville', '2024-12-31 08:59:24', '2024-12-31 08:59:24'),
(2883, 'fr', 'enter_your_garage_name', 'Entrez le Nom de Votre Garage', '2024-12-31 09:48:03', '2024-12-31 09:48:03'),
(2884, 'fr', 'garage_name', 'Le Nom De Garage', '2024-12-31 09:48:09', '2024-12-31 09:48:09'),
(2885, 'fr', 'garage_revenue', 'Chiffre d\'affaire', '2024-12-31 09:50:47', '2024-12-31 09:50:47'),
(2886, 'fr', 'enter_your_revenue', 'Entez votre chiffre d\'affaire', '2024-12-31 09:50:47', '2024-12-31 09:50:47'),
(2887, 'fr', 'direct_training_csf', 'Direct Training (CSF)', '2024-12-31 10:03:25', '2024-12-31 10:03:25'),
(2888, 'fr', 'engineering__training_giac__csf', 'Engineering + Training (GIAC + CSF)', '2024-12-31 10:03:25', '2024-12-31 10:03:25'),
(2889, 'fr', 'engineering__training', 'Engineering + Training', '2024-12-31 10:06:27', '2024-12-31 10:06:27'),
(2890, 'bd', 'back_to_home', 'Back to Home', '2024-12-31 10:34:47', '2024-12-31 10:34:47'),
(2891, 'bd', 'login', 'Login', '2024-12-31 10:34:48', '2024-12-31 10:34:48'),
(2892, 'bd', 'heres_whats_happening_with_your_system', 'Here\'s what\'s happening with your System', '2024-12-31 10:34:54', '2024-12-31 10:34:54'),
(2893, 'bd', 'last_cron_run', 'Last cron run', '2024-12-31 10:34:54', '2024-12-31 10:34:54'),
(2894, 'bd', 'sort_by', 'Sort by', '2024-12-31 10:34:54', '2024-12-31 10:34:54'),
(2895, 'bd', 'all', 'All', '2024-12-31 10:34:54', '2024-12-31 10:34:54'),
(2896, 'bd', 'today', 'Today', '2024-12-31 10:34:54', '2024-12-31 10:34:54'),
(2897, 'bd', 'yesterday', 'Yesterday', '2024-12-31 10:34:54', '2024-12-31 10:34:54'),
(2898, 'bd', 'last_7_days', 'Last 7 Days', '2024-12-31 10:34:54', '2024-12-31 10:34:54'),
(2899, 'bd', 'last_30_days', 'Last 30 Days', '2024-12-31 10:34:54', '2024-12-31 10:34:54'),
(2900, 'bd', 'direct_training', 'Direct Training', '2024-12-31 10:34:54', '2024-12-31 10:34:54'),
(2901, 'bd', 'total_clients', 'Total Clients', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2902, 'bd', 'cae', 'CAE', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2903, 'bd', 'qualification_phase', 'Qualification Phase', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2904, 'bd', 'view_all', 'View All', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2905, 'bd', 'administrative_preliminary_phase', 'Administrative Preliminary Phase', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2906, 'bd', 'validation_phase', 'Validation Phase', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2907, 'bd', 'construction_phase', 'Construction Phase', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2908, 'bd', 'repayment_phase', 'Repayment Phase', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2909, 'bd', 'ingnierie__formation', 'Ingénierie + Formation', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2910, 'bd', 'engineering_phase_', 'Engineering Phase ', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2911, 'bd', 'phase_csf', 'Phase CSF', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2912, 'bd', 'repayments_phase', 'Repayments Phase', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2913, 'bd', 'tickets', 'Tickets', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2914, 'bd', 'latest_tickets', 'Latest Tickets', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2915, 'bd', 'download_pdf', 'Download PDF', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2916, 'bd', 'ticket_id', 'Ticket Id', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2917, 'bd', 'creation_time', 'Creation Time', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2918, 'bd', 'status', 'Status', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2919, 'bd', 'pending_tickets', 'Pending Tickets', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2920, 'bd', 'top_categories_by_tickets', 'Top Categories By Tickets', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2921, 'bd', 'latest_agent_replies', 'Latest Agent Replies', '2024-12-31 10:34:55', '2024-12-31 10:34:55'),
(2922, 'bd', 'opened_tickets', 'Opened Tickets', '2024-12-31 10:34:56', '2024-12-31 10:34:56'),
(2923, 'bd', 'closed_tickets', 'Closed Tickets', '2024-12-31 10:34:56', '2024-12-31 10:34:56'),
(2924, 'bd', 'clear_cache', 'Clear Cache', '2024-12-31 10:34:57', '2024-12-31 10:34:57'),
(2925, 'bd', 'browse_frontend', 'Browse Frontend', '2024-12-31 10:34:57', '2024-12-31 10:34:57'),
(2926, 'bd', 'notifications', 'Notifications', '2024-12-31 10:34:57', '2024-12-31 10:34:57'),
(2927, 'bd', 'no_new_notificatios', 'No New Notificatios', '2024-12-31 10:34:57', '2024-12-31 10:34:57'),
(2928, 'bd', 'profile', 'Profile', '2024-12-31 10:34:57', '2024-12-31 10:34:57'),
(2929, 'bd', 'menu', 'Menu', '2024-12-31 10:34:58', '2024-12-31 10:34:58'),
(2930, 'bd', 'messenger', 'Messenger', '2024-12-31 10:34:58', '2024-12-31 10:34:58'),
(2931, 'bd', 'ticketsagents__users', 'Tickets,Agents & Users', '2024-12-31 10:34:58', '2024-12-31 10:34:58'),
(2932, 'bd', 'tickets_lists', 'Tickets Lists', '2024-12-31 10:34:58', '2024-12-31 10:34:58'),
(2933, 'bd', 'ticket_configuration', 'Ticket Configuration', '2024-12-31 10:34:58', '2024-12-31 10:34:58'),
(2934, 'bd', 'general_configuration', 'General Configuration', '2024-12-31 10:34:58', '2024-12-31 10:34:58'),
(2935, 'bd', 'triggering', 'Triggering', '2024-12-31 10:34:58', '2024-12-31 10:34:58'),
(2936, 'bd', 'ticket_status', 'Ticket Status', '2024-12-31 10:34:58', '2024-12-31 10:34:58'),
(2937, 'bd', 'products', 'Products', '2024-12-31 10:34:58', '2024-12-31 10:34:58'),
(2938, 'bd', 'ticket_priority', 'Ticket Priority', '2024-12-31 10:34:58', '2024-12-31 10:34:58'),
(2939, 'bd', 'ticket_categories', 'Ticket Categories', '2024-12-31 10:34:58', '2024-12-31 10:34:58'),
(2940, 'bd', 'predefined_response', 'Predefined Response', '2024-12-31 10:34:58', '2024-12-31 10:34:58'),
(2941, 'bd', 'agent_management', 'Agent Management', '2024-12-31 10:34:58', '2024-12-31 10:34:58');
INSERT INTO `translations` (`id`, `code`, `key`, `value`, `created_at`, `updated_at`) VALUES
(2942, 'bd', 'add_new', 'Add New', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2943, 'bd', 'agent_list', 'Agent List', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2944, 'bd', 'agent_group', 'Agent Group', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2945, 'bd', 'manage_user', 'Manage User', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2946, 'bd', 'user_list', 'User List', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2947, 'bd', 'appearance__others', 'Appearance & Others', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2948, 'bd', 'appearance_settings', 'Appearance Settings', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2949, 'bd', 'section_manage', 'Section Manage', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2950, 'bd', 'menu_manage', 'Menu Manage', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2951, 'bd', 'dynamic_pages', 'Dynamic Pages', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2952, 'bd', 'faq_section', 'FAQ Section', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2953, 'bd', 'knowledgebase', 'knowledgebase', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2954, 'bd', 'article_administration', 'Article Administration', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2955, 'bd', 'article_topics', 'Article Topics', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2956, 'bd', 'article_categories', 'Article Categories', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2957, 'bd', 'article_list', 'Article List', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2958, 'bd', 'marketingpromotion', 'Marketing/Promotion', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2959, 'bd', 'contact_message', 'Contact Message', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2960, 'bd', 'subscribers', 'Subscribers', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2961, 'bd', 'email__sms_config', 'Email & SMS Config', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2962, 'bd', 'email_configuration', 'Email Configuration', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2963, 'bd', 'outgoing_method', 'Outgoing Method', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2964, 'bd', 'incoming_method', 'Incoming Method', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2965, 'bd', 'global_template', 'Global template', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2966, 'bd', 'mail_templates', 'Mail templates', '2024-12-31 10:34:59', '2024-12-31 10:34:59'),
(2967, 'bd', 'sms_configuration', 'SMS Configuration', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2968, 'bd', 'sms_gateway', 'SMS Gateway', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2969, 'bd', 'global_setting', 'Global Setting', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2970, 'bd', 'sms_templates', 'SMS templates', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2971, 'bd', 'setup__configurations', 'Setup & Configurations', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2972, 'bd', 'application_settings', 'Application Settings', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2973, 'bd', 'app_settings', 'App Settings', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2974, 'bd', 'envato_configuration', 'Envato Configuration', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2975, 'bd', 'configuration', 'Configuration', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2976, 'bd', 'system_preferences', 'System Preferences', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2977, 'bd', 'notification_settings', 'Notification settings', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2978, 'bd', 'security_settings', 'Security Settings', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2979, 'bd', 'visitors', 'Visitors', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2980, 'bd', 'dos_security', 'Dos Security', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2981, 'bd', 'system_upgrade', 'System Upgrade', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2982, 'bd', 'languages', 'Languages', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2983, 'bd', 'about_system', 'About System', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2984, 'bd', 'app_version', 'App Version', '2024-12-31 10:35:00', '2024-12-31 10:35:00'),
(2985, 'bd', 'ai_assistance', 'AI Assistance', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2986, 'bd', 'result', 'Result', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2987, 'bd', 'copy', 'Copy', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2988, 'bd', 'download', 'Download', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2989, 'bd', 'your_content', 'Your Content', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2990, 'bd', 'your_prompt_goes_here__', 'Your prompt goes here .... ', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2991, 'bd', 'what_do_you_want_to_do', 'What do you want to do', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2992, 'bd', 'here_are_some_ideas', 'Here are some ideas', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2993, 'bd', 'more', 'More', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2994, 'bd', 'translate', 'Translate', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2995, 'bd', 'back', 'Back', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2996, 'bd', 'rewrite_it', 'Rewrite It', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2997, 'bd', 'adjust_tone', 'Adjust Tone', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2998, 'bd', 'choose_language', 'Choose Language', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(2999, 'bd', 'select_language', 'Select Language', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(3000, 'bd', 'or', 'OR', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(3001, 'bd', 'make_your_own_prompt', 'Make Your Own Prompt', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(3002, 'bd', 'ex_make_it_more_friendly_', 'Ex: Make It more friendly ', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(3003, 'bd', 'insert', 'Insert', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(3004, 'bd', 'cancel', 'Cancel', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(3005, 'bd', 'do_not_close_window_while_proecessing', 'Do not close window while proecessing', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(3006, 'bd', 'hello_', 'Hello ', '2024-12-31 10:35:01', '2024-12-31 10:35:01'),
(3007, 'bd', 'this_function_is_not_avaialbe_for_website_demo_mode', 'This Function is Not Avaialbe For Website Demo Mode', '2024-12-31 10:35:02', '2024-12-31 10:35:02'),
(3008, 'bd', 'select_country', 'Select Country', '2024-12-31 10:35:02', '2024-12-31 10:35:02'),
(3009, 'bd', 'generate_with_ai', 'Generate With AI', '2024-12-31 10:35:02', '2024-12-31 10:35:02'),
(3010, 'bd', 'text_copied_to_clipboard', 'Text copied to clipboard!', '2024-12-31 10:35:02', '2024-12-31 10:35:02'),
(3011, 'bd', 'create__user', 'Create  User', '2024-12-31 10:35:09', '2024-12-31 10:35:09'),
(3012, 'bd', 'users', 'Users', '2024-12-31 10:35:09', '2024-12-31 10:35:09'),
(3013, 'bd', 'create', 'Create', '2024-12-31 10:35:09', '2024-12-31 10:35:09'),
(3014, 'bd', 'create_user', 'Create User', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3015, 'bd', 'examplegamilcom', 'example@gamil.com', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3016, 'bd', 'minimum_5_character_required', 'Minimum 5 Character Required!!', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3017, 'bd', 'confirm_password', 'Confirm Password', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3018, 'bd', 'phone', 'Phone', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3019, 'bd', 'enter_phone_number', 'Enter Phone Number', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3020, 'bd', 'whatsapp_number', 'WhatsApp Number', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3021, 'bd', 'enter_whatsapp_number', 'Enter WhatsApp Number', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3022, 'bd', 'cnss', 'CNSS', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3023, 'bd', 'enter_cnss_number', 'Enter CNSS Number', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3024, 'bd', 'training', 'training', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3025, 'bd', 'engineering__training', 'Engineering + Training', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3026, 'bd', 'city', 'City', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3027, 'bd', 'garage_name', 'Garage Name', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3028, 'bd', 'enter_your_garage_name', 'Enter your Garage Name', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3029, 'bd', 'garage_revenue', 'Garage Revenue', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3030, 'bd', 'enter_your_revenue', 'Enter your Revenue', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3031, 'bd', 'active', 'Active', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3032, 'bd', 'inactive', 'Inactive', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3033, 'bd', 'image', 'Image', '2024-12-31 10:35:10', '2024-12-31 10:35:10'),
(3034, 'bd', 'add', 'Add', '2024-12-31 10:35:11', '2024-12-31 10:35:11'),
(3035, 'en', 'engineering__training', 'Engineering + Training', '2024-12-31 10:35:57', '2024-12-31 10:35:57'),
(3036, 'en', 'garage_name', 'Garage Name', '2024-12-31 10:35:57', '2024-12-31 10:35:57'),
(3037, 'en', 'enter_your_garage_name', 'Enter your Garage Name', '2024-12-31 10:35:57', '2024-12-31 10:35:57'),
(3038, 'en', 'garage_revenue', 'Garage Revenue', '2024-12-31 10:35:57', '2024-12-31 10:35:57'),
(3039, 'en', 'enter_your_revenue', 'Enter your Revenue', '2024-12-31 10:35:57', '2024-12-31 10:35:57'),
(3040, 'fr', 'active_user_status_then_try_again', 'Active User Status Then Try Again', '2025-01-02 11:39:29', '2025-01-02 11:39:29'),
(3041, 'en', 'full_name', 'Full Name', '2025-01-03 13:09:17', '2025-01-03 13:09:17'),
(3042, 'fr', 'training_type', 'Type de Formation', '2025-01-03 13:09:17', '2025-01-03 13:09:17'),
(3043, 'en', 'trainings', 'Trainings', '2025-01-03 13:09:17', '2025-01-03 13:09:17'),
(3044, 'fr', 'ebva_traning', 'EBVA Traning', '2025-01-03 13:09:17', '2025-01-03 13:09:17'),
(3045, 'fr', 'diagnosis_traning', 'Diagnosis Traning', '2025-01-03 13:09:18', '2025-01-03 13:09:18'),
(3046, 'fr', 'towing_traning', 'Towing Traning', '2025-01-03 13:09:18', '2025-01-03 13:09:18'),
(3047, 'fr', 'adas_traning', 'ADAS Traning', '2025-01-03 13:09:18', '2025-01-03 13:09:18'),
(3048, 'fr', 'preparation_for_the_electrical_activation_of_ev_charging_infrastructures', 'Preparation for the electrical activation of EV charging infrastructures', '2025-01-03 13:09:18', '2025-01-03 13:09:18'),
(3049, 'fr', 'preparation_for_vevh_electrical_clearance', 'Preparation for VE/VH Electrical Clearance', '2025-01-03 13:09:18', '2025-01-03 13:09:18'),
(3050, 'fr', 'whatsapp_number_feild_is_required', 'Whatsapp Number Feild Is Required', '2025-01-03 13:10:03', '2025-01-03 13:10:03'),
(3051, 'en', 'select_your_city', 'Select Your City', '2025-01-03 13:10:03', '2025-01-03 13:10:03'),
(3052, 'en', 'cnss_feild_is_required', 'CNSS Feild Is Required', '2025-01-03 13:10:03', '2025-01-03 13:10:03'),
(3053, 'en', 'cnss_number_must_be_unique', 'CNSS Number Must Be Unique', '2025-01-03 13:10:03', '2025-01-03 13:10:03'),
(3054, 'en', 'ebva_training', 'EBVA Training', '2025-01-03 13:36:51', '2025-01-03 13:36:51'),
(3055, 'en', 'diagnosis_training', 'Diagnosis Training', '2025-01-03 13:36:51', '2025-01-03 13:36:51'),
(3056, 'en', 'towing_training', 'Towing Training', '2025-01-03 13:36:52', '2025-01-03 13:36:52'),
(3057, 'en', 'adas_trianing', 'ADAS Trianing', '2025-01-03 13:36:52', '2025-01-03 13:36:52'),
(3058, 'en', 'select_training_type', 'Choisir un Type de Formation', '2025-01-03 14:00:39', '2025-01-03 14:00:39'),
(3059, 'fr', 'select_training', 'Choisir une Formation', '2025-01-03 14:00:39', '2025-01-03 14:00:39'),
(3060, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2025-01-03 14:15:41', '2025-01-03 14:15:41'),
(3061, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2025-01-03 14:15:41', '2025-01-03 14:15:41'),
(3062, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2025-01-03 14:15:49', '2025-01-03 14:15:49'),
(3063, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2025-01-03 14:15:49', '2025-01-03 14:15:49'),
(3064, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2025-01-03 14:15:49', '2025-01-03 14:15:49'),
(3065, 'fr', 'close__________________________________________________________________________________________________________________________________________________________________________________________', 'Close                                                                                                                                                                                          ', '2025-01-03 14:15:49', '2025-01-03 14:15:49'),
(3066, 'fr', 'full_name', 'Nom Complet', '2025-01-03 13:09:17', '2025-01-03 13:09:17'),
(3067, 'en', 'select_training', 'Select Training', '2025-01-03 14:00:39', '2025-01-03 14:00:39'),
(3068, 'fr', 'adas_trianing', 'Formation ADAS', '2025-01-03 13:36:52', '2025-01-03 13:36:52'),
(3069, 'fr', 'towing_training', 'Formation Remorquage', '2025-01-03 13:36:52', '2025-01-03 13:36:52'),
(3070, 'fr', 'diagnosis_training', 'Formation Diagnostic', '2025-01-03 13:36:51', '2025-01-03 13:36:51'),
(3071, 'fr', 'ebva_training', 'Formation EBVA', '2025-01-03 13:36:51', '2025-01-03 13:36:51'),
(3072, 'en', 'training_type', 'Training Type', '2025-01-06 11:19:40', '2025-01-06 11:19:40'),
(3073, 'en', 'preparation_for_the_electrical_activation_of_ev_charging_infrastructures', 'Preparation for the electrical activation of EV charging infrastructures', '2025-01-06 11:19:40', '2025-01-06 11:19:40'),
(3074, 'en', 'preparation_for_vevh_electrical_clearance', 'Preparation for VE/VH Electrical Clearance', '2025-01-06 11:19:40', '2025-01-06 11:19:40'),
(3075, 'fr', 'trainings', 'Formations', '2025-01-06 11:20:36', '2025-01-06 11:20:36'),
(3076, 'fr', 'select_your_city', 'Select Your City', '2025-01-06 11:22:29', '2025-01-06 11:22:29'),
(3077, 'fr', 'cnss_feild_is_required', 'CNSS Feild Is Required', '2025-01-06 11:22:29', '2025-01-06 11:22:29'),
(3078, 'fr', 'cnss_number_must_be_unique', 'CNSS Number Must Be Unique', '2025-01-06 11:22:29', '2025-01-06 11:22:29'),
(3079, 'fr', 'select_training_type', 'Select Training Type', '2025-01-06 11:22:29', '2025-01-06 11:22:29'),
(3080, 'fr', 'engineering__taining', 'Engineering + Taining', '2025-01-06 11:53:17', '2025-01-06 11:53:17'),
(3081, 'fr', 'engineering__taining', 'Engineering + Taining', '2025-01-06 11:53:17', '2025-01-06 11:53:17'),
(3082, 'en', 'engineering__taining', 'Engineering + Taining', '2025-01-06 14:24:47', '2025-01-06 14:24:47'),
(3083, 'fr', 'unable_to_upload_file_check_directory_permissions', 'Unable to upload file. Check directory permissions', '2025-01-07 11:49:55', '2025-01-07 11:49:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `envato_purchases` longtext DEFAULT NULL,
  `o_auth_id` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `cnss` varchar(100) DEFAULT NULL,
  `garage_name` varchar(191) DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `training_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `training` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `revenue` varchar(100) DEFAULT NULL,
  `whatsapp_number` varchar(100) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1 COMMENT 'Active : 1, Banned : 0',
  `muted_agent` longtext DEFAULT NULL,
  `notification_settings` text DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `verified` tinyint(4) DEFAULT NULL COMMENT 'Yes: 1, No: 0 ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `envato_purchases`, `o_auth_id`, `address`, `latitude`, `longitude`, `phone`, `cnss`, `garage_name`, `city`, `training_type`, `training`, `revenue`, `whatsapp_number`, `image`, `password`, `status`, `muted_agent`, `notification_settings`, `remember_token`, `verified`, `created_at`, `updated_at`) VALUES
(15, 'Khalid Rouiha', 'lux@example.com', NULL, NULL, '{\"status\":\"fail\",\"message\":\"reserved range\",\"query\":\"::1\",\"browser_name\":\"Google Chrome\",\"device_name\":\"Windows\"}', NULL, NULL, '064075645', '2233112', 'Garage Lux', 'Tanger‎', 'direct_training_(CSF)', 'adas_training', NULL, '064075645', NULL, '$2y$10$tJYo.Ayo08UL0NHJg2Q9KegOWfrpEOnEB82TqPMufmbBhpEoQ2l.W', 0, NULL, '{\"email\":{\"new_chat\":\"1\",\"ticket_reply\":\"1\"},\"browser\":{\"new_chat\":\"1\",\"ticket_reply\":\"1\"}}', NULL, NULL, '2025-01-06 11:22:29', '2025-01-06 11:22:29'),
(16, 'Ayman Kali', 'ayman@example.com', NULL, NULL, '{\"status\":\"fail\",\"message\":\"reserved range\",\"query\":\"::1\",\"browser_name\":\"Google Chrome\",\"device_name\":\"Windows\"}', NULL, NULL, '0640732900', '22333300', 'Garage Ayman', 'Casablanca', 'engineering_training_(GIAC+CSF)', 'diagnosis_training', NULL, '0640732900', NULL, '$2y$10$/Rgv/2O5/ZEB4Ezz/dwlEeZgnjJJi/9swNL1/bGfkQLBTimVXGP8W', 0, NULL, '{\"email\":{\"new_chat\":\"1\",\"ticket_reply\":\"1\"},\"browser\":{\"new_chat\":\"1\",\"ticket_reply\":\"1\"}}', NULL, NULL, '2025-01-06 16:22:09', '2025-01-06 16:22:09'),
(17, 'Mohamed Kabil', 'mohamed@example.com', NULL, NULL, '{\"status\":\"fail\",\"message\":\"reserved range\",\"query\":\"::1\",\"browser_name\":\"Google Chrome\",\"device_name\":\"Windows\"}', NULL, NULL, '0640732909', '223345', 'Garage Mohamed', 'Rabat', 'direct_training_(CSF)', 'diagnosis_training', NULL, '0640732909', NULL, '$2y$10$b0MeDIBBshifPG9Pznt47unOw5FbEJnBkki2PsgWOOqsBu/vhCAVC', 0, NULL, '{\"email\":{\"new_chat\":\"1\",\"ticket_reply\":\"1\"},\"browser\":{\"new_chat\":\"1\",\"ticket_reply\":\"1\"}}', NULL, NULL, '2025-01-06 16:23:05', '2025-01-06 16:23:05'),
(18, 'Hicham', 'hicham@example.com', NULL, NULL, '{\"status\":\"fail\",\"message\":\"reserved range\",\"query\":\"::1\",\"browser_name\":\"Google Chrome\",\"device_name\":\"Windows\"}', NULL, NULL, '0678987634', '22333301', 'Garage Hicham', 'Tanger‎', 'engineering_training_(GIAC+CSF)', 'towing_training', NULL, '0678987634', NULL, '$2y$10$HFPs2Kt.mMpDeBU6qK8QFuW9lZXDbvjDIEK/.1E5xdENpWZbp2fHS', 0, NULL, '{\"email\":{\"new_chat\":\"1\",\"ticket_reply\":\"1\"},\"browser\":{\"new_chat\":\"1\",\"ticket_reply\":\"1\"}}', NULL, NULL, '2025-01-06 16:24:12', '2025-01-06 16:24:12'),
(19, 'Abdellah', 'abdellah@example.com', NULL, NULL, '{\"status\":\"fail\",\"message\":\"reserved range\",\"query\":\"::1\",\"browser_name\":\"Google Chrome\",\"device_name\":\"Windows\"}', NULL, NULL, '0640732906', '22333340', 'Garage Abdellah', 'Imzouren‎', 'direct_training_(CSF)', 'ebva_training', NULL, '0640732906', NULL, '$2y$10$yvPwI7jZvMRFkaf6kKuYlOuDxtNo/YwnUo9eZASmhlNWu246MxC1a', 0, NULL, '{\"email\":{\"new_chat\":\"1\",\"ticket_reply\":\"1\"},\"browser\":{\"new_chat\":\"1\",\"ticket_reply\":\"1\"}}', NULL, NULL, '2025-01-06 16:25:54', '2025-01-06 16:25:54');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `agent_info` longtext DEFAULT NULL,
  `is_blocked` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Yes: 1, No: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `ip_address`, `agent_info`, `is_blocked`, `created_at`, `updated_at`) VALUES
(1, '127.0.0.1', '{\"country\":\"\",\"countryCode\":\"\",\"city\":\"\",\"lon\":\"\",\"lat\":\"\",\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"127.0.0.1\",\"timezone\":\"\",\"time\":\"08-01-2025 09:19:03 AM\"}', '0', '2024-02-25 11:10:41', '2025-01-08 08:19:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_responses`
--
ALTER TABLE `agent_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_tickets`
--
ALTER TABLE `agent_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_categories`
--
ALTER TABLE `article_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_categories_name_unique` (`name`);

--
-- Indexes for table `canned_replies`
--
ALTER TABLE `canned_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_notifications`
--
ALTER TABLE `custom_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`),
  ADD UNIQUE KEY `departments_slug_unique` (`slug`),
  ADD UNIQUE KEY `envato_item_id` (`envato_item_id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `floating_chats`
--
ALTER TABLE `floating_chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `frontends_name_unique` (`name`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `groups_name_unique` (`name`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `knowledge_bases`
--
ALTER TABLE `knowledge_bases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `knowledge_bases_name_unique` (`name`),
  ADD UNIQUE KEY `knowledge_bases_slug_unique` (`slug`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_translations`
--
ALTER TABLE `model_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `model_translations_translateable_type_translateable_id_index` (`translateable_type`,`translateable_id`),
  ADD KEY `model_translations_locale_index` (`locale`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_title_unique` (`title`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_gateways`
--
ALTER TABLE `sms_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_resolution_requests`
--
ALTER TABLE `ticket_resolution_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_statuses`
--
ALTER TABLE `ticket_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_statuses_name_unique` (`name`);

--
-- Indexes for table `ticket_triggers`
--
ALTER TABLE `ticket_triggers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_triggers_name_unique` (`name`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_responses`
--
ALTER TABLE `agent_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `agent_tickets`
--
ALTER TABLE `agent_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_categories`
--
ALTER TABLE `article_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `canned_replies`
--
ALTER TABLE `canned_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_notifications`
--
ALTER TABLE `custom_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floating_chats`
--
ALTER TABLE `floating_chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `knowledge_bases`
--
ALTER TABLE `knowledge_bases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `model_translations`
--
ALTER TABLE `model_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `sms_gateways`
--
ALTER TABLE `sms_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ticket_resolution_requests`
--
ALTER TABLE `ticket_resolution_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_statuses`
--
ALTER TABLE `ticket_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket_triggers`
--
ALTER TABLE `ticket_triggers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3084;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
