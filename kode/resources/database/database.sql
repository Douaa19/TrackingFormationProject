
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 17, 2024 at 09:27 AM
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
-- Database: `support_ticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT NULL COMMENT 'Active:1 Inactive:0',
  `best_agent` tinyint NOT NULL COMMENT 'Yes:1 No:0  ',
  `categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notification_settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `blocked_user` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muted_user` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `muted_ticket` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `super_agent` tinyint DEFAULT NULL,
  `agent` tinyint DEFAULT NULL COMMENT 'agent:1 admin:0',
  `super_admin` tinyint DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `phone`, `email`, `image`, `status`, `best_agent`, `categories`, `notification_settings`, `permissions`, `blocked_user`, `muted_user`, `muted_ticket`, `super_agent`, `agent`, `super_admin`, `address`, `latitude`, `longitude`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin', 'admin', '+880123456789', 'demo@example.com', '655cbd2eb94011700576558.png', 1, 0, NULL, '{\"email\":{\"new_ticket\":\"1\",\"agent_ticket_reply\":\"1\",\"agent_assign_ticket\":\"1\",\"user_reply_admin\":\"1\",\"user_reply_agent\":\"1\"},\"sms\":{\"agent_ticket_reply\":\"1\",\"new_ticket\":\"1\",\"agent_assign_ticket\":\"1\",\"user_reply_agent\":\"1\",\"user_reply_admin\":\"1\"},\"browser\":{\"agent_ticket_reply\":\"1\",\"new_ticket\":\"1\",\"agent_assign_ticket\":\"1\",\"user_reply_agent\":\"1\",\"user_reply_admin\":\"1\"},\"slack\":{\"agent_ticket_reply\":\"1\",\"new_ticket\":\"1\",\"agent_assign_ticket\":\"1\",\"user_reply_agent\":\"1\",\"user_reply_admin\":\"1\"}}', NULL, NULL, NULL, NULL, NULL, 0, NULL, '{\"status\":\"fail\",\"message\":\"reserved range\",\"query\":\"127.0.0.1\",\"browser_name\":\"Mozilla Firefox\",\"device_name\":\"Windows\"}', NULL, NULL, '$2y$10$CEvXx9Wu82EG3ZgJv6Yh9u0j2PTamacRAdbdl9AVquW8Bl2JYUphi', 'VqwCkwC8ACO5ymlbObIk3N7Ze0gAKAlQ3kst7jBTsYI4uyDuUHd2jC9hBWIb', NULL, '2023-11-21 14:22:39');

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agent_responses`
--

CREATE TABLE `agent_responses` (
  `id` bigint UNSIGNED NOT NULL,
  `agent_id` bigint UNSIGNED DEFAULT NULL,
  `ticket_id` bigint UNSIGNED DEFAULT NULL,
  `response_time` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agent_tickets`
--

CREATE TABLE `agent_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `agent_id` smallint UNSIGNED DEFAULT NULL,
  `ticket_id` smallint UNSIGNED DEFAULT NULL,
  `assigned_by` bigint DEFAULT NULL,
  `short_notes` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `article_category_id` bigint UNSIGNED DEFAULT NULL,
  `serial_id` tinyint DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint DEFAULT NULL COMMENT 'active :1 inactive 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `article_categories`
--

CREATE TABLE `article_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `serial_id` tinyint DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canned_replies`
--

CREATE TABLE `canned_replies` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `share_with` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_details` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `article_display_flag` tinyint DEFAULT '0',
  `ticket_display_flag` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `floating_id` bigint UNSIGNED DEFAULT NULL,
  `sender` tinyint DEFAULT NULL,
  `seen` tinyint DEFAULT NULL,
  `seen_by_agent` tinyint DEFAULT NULL,
  `deleted_by_user` tinyint NOT NULL DEFAULT '0',
  `deleted_by_admin` tinyint NOT NULL DEFAULT '0',
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `user_id`, `admin_id`, `floating_id`, `sender`, `seen`, `seen_by_agent`, `deleted_by_user`, `deleted_by_admin`, `message`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, 1, 0, 0, 0, 0, 'sss', '2024-04-04 04:37:24', '2024-04-04 04:37:24'),
(2, NULL, 1, 1, 1, 0, 0, 0, 0, 'sss', '2024-04-04 04:37:28', '2024-04-04 04:37:28'),
(3, NULL, 1, 1, 1, 0, 0, 0, 0, 'sss', '2024-04-04 04:37:38', '2024-04-04 04:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_notifications`
--

CREATE TABLE `custom_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `notify_id` bigint UNSIGNED DEFAULT NULL,
  `notify_by` bigint DEFAULT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_read` tinyint DEFAULT NULL COMMENT 'Yes:1 , no: 0',
  `notification_for` tinyint DEFAULT NULL COMMENT 'Superadmin:1 , Agent: 2 ,User :3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `envato_item_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `envato_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Active:1 ,Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT 'Active : 1, Inactive : 0',
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
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `question` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `floating_chats`
--

CREATE TABLE `floating_chats` (
  `id` bigint UNSIGNED NOT NULL,
  `assign_to` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_closed` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Yes:1 , No: 0',
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
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Active:1 , Inactive: 0',
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
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `leader_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `priority_id` bigint UNSIGNED NOT NULL,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `id` bigint UNSIGNED NOT NULL,
  `group_id` bigint UNSIGNED NOT NULL,
  `agent_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incomming_mail_gateways`
--

CREATE TABLE `incomming_mail_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `department_id` int UNSIGNED DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credentials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `match_keywords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active:1 ,Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_bases`
--

CREATE TABLE `knowledge_bases` (
  `id` bigint UNSIGNED NOT NULL,
  `department_id` int UNSIGNED DEFAULT NULL,
  `parent_id` int UNSIGNED DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Active:1 ,Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'default : 1,Not default : 0',
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Active : 1,Inactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `uid`, `created_by`, `updated_by`, `name`, `code`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ASWTG454DGGD', 1, NULL, 'English', 'en', '1', '1', '2023-03-14 14:09:00', '2023-11-22 17:26:08'),
(16, '30nO-p9MnDgW8-nnf8', NULL, NULL, 'Bangladesh', 'bd', '0', '1', '2023-11-22 17:25:54', '2023-11-22 17:26:08');

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE `mails` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT 'Active : 1 Inactive : 2',
  `driver_information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mails`
--

INSERT INTO `mails` (`id`, `name`, `status`, `driver_information`, `created_at`, `updated_at`) VALUES
(1, 'SMTP', 1, '{\"driver\":\"SMTP\",\"host\":\"demo\",\"port\":\"465\",\"from\":{\"address\":\"demo@example.com\",\"name\":\"KodePixel - Help\"},\"encryption\":\"SSL\",\"username\":\"demo@example.com\",\"password\":\"demo\"}', '2022-09-09 14:52:30', '2023-12-28 09:26:54'),
(2, 'PHP MAIL', 1, NULL, '2022-09-08 18:00:00', '2022-07-20 04:41:46'),
(3, 'SendGrid Api', 1, '{\"app_key\":\"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\",\"from\":{\"address\":\"debnath.bappe@gmail.com\",\"name\":\"Demo Name\"}}', '2022-09-08 18:00:00', '2023-05-22 06:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `serial_id` int DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `show_in_header` tinyint DEFAULT '0',
  `show_in_footer` tinyint DEFAULT '0',
  `show_in_quick_link` tinyint DEFAULT '0',
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
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
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
(61, '2024_05_04_125335_create_incomming_mail_gateways_table', 22);

-- --------------------------------------------------------

--
-- Table structure for table `model_translations`
--

CREATE TABLE `model_translations` (
  `id` bigint UNSIGNED NOT NULL,
  `translateable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `translateable_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `response_time` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `resolve_time` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `color_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active:1 , Inactive: 0',
  `is_default` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes:1 ,No: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`id`, `name`, `response_time`, `resolve_time`, `color_code`, `status`, `is_default`, `created_at`, `updated_at`) VALUES
(3, 'Low', '{\"in\":\"1\",\"format\":\"Week\"}', '{\"in\":\"2\",\"format\":\"Week\"}', '#26b56f', '1', '0', '2023-08-30 10:36:25', '2023-12-20 11:49:26'),
(6, 'Medium', '{\"in\":\"2\",\"format\":\"Hour\"}', '{\"in\":\"3\",\"format\":\"Hour\"}', '#b2aa14', '1', '0', '2023-08-30 10:43:55', '2023-12-20 11:49:26'),
(7, 'Urgent', '{\"in\":\"2\",\"format\":\"Minute\"}', '{\"in\":\"8\",\"format\":\"Minute\"}', '#82223a', '1', '0', '2023-08-30 10:44:11', '2023-12-20 11:49:26'),
(8, 'High', '{\"in\":\"1\",\"format\":\"Minute\"}', '{\"in\":\"1\",\"format\":\"Minute\"}', '#db1414', '1', '1', '2023-08-30 10:45:14', '2023-12-20 11:49:26');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `plugin` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0' COMMENT 'Yes: 1,No: 0',
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `plugin`, `status`, `created_at`, `updated_at`) VALUES
(77, 'site_name', 'PixelDesk', '0', '1', NULL, '2023-11-21 13:09:23'),
(78, 'site_logo_sm', '65a27dac4eaf91705147820.png', '0', '1', NULL, '2023-11-22 07:28:43'),
(79, 'site_logo_lg', '65a27dac4a8421705147820.png', '0', '1', NULL, '2023-11-22 07:28:43'),
(80, 'site_favicon', '65a27dac5285c1705147820.png', '0', '1', NULL, '2023-11-21 14:34:36'),
(81, 'user_site_name', 'PixelDesk', '0', '1', NULL, '2023-11-21 13:09:23'),
(82, 'phone', '+88 123 123 000', '0', '1', NULL, '2023-11-21 13:09:23'),
(83, 'email', 'admin@pixeldesk.test', '0', '1', NULL, '2023-11-21 13:09:23'),
(84, 'address', '123 Support Street, Ticketville, Techlandia 98765', '0', '1', NULL, '2023-11-21 13:09:23'),
(85, 'user_register', '1', '0', '1', NULL, '2023-05-13 12:09:12'),
(86, 'last_corn_run', NULL, '0', '1', NULL, NULL),
(87, 'default_mail_template', '<!-- [if !mso]><!--><!--<![endif]-->\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"#414a51\">\r\n<tbody>\r\n<tr>\r\n<td height=\"50\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: center; vertical-align: top; font-size: 0;\" align=\"center\">\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\" width=\"600\">\r\n<table class=\"table-inner\" border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td style=\"border-top-left-radius: 6px; border-top-right-radius: 6px; text-align: center; vertical-align: top; font-size: 0;\" align=\"center\" bgcolor=\"#0087ff\">\r\n<table style=\"height: 122.398px;\" border=\"0\" width=\"90%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr style=\"height: 20px;\">\r\n<td style=\"height: 20px;\" height=\"20\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 82.3984px;\">\r\n<td style=\"font-family: \'Open sans\', Arial, sans-serif; color: #ffffff; font-size: 16px; font-weight: bold; height: 82.3984px;\" align=\"center\"><img style=\"display: block; line-height: 0px; font-size: 0px; border: 0px;\" src=\"{{logo}}\" alt=\"img\" width=\"173\" height=\"37\"></td>\r\n</tr>\r\n<tr style=\"height: 20px;\">\r\n<td style=\"height: 20px;\" height=\"20\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table class=\"table-inner\" border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"text-align: center; vertical-align: top; font-size: 0;\" align=\"center\" bgcolor=\"#FFFFFF\">\r\n<table style=\"height: 235px; width: 90%;\" border=\"0\" width=\"511\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr style=\"height: 40px;\">\r\n<td style=\"height: 40px;\" height=\"40\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 30.7969px;\">\r\n<td style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 22px; color: #414a51; font-weight: bold; height: 30.7969px;\" align=\"center\">Hello {{username}}</td>\r\n</tr>\r\n<tr style=\"height: 24px;\">\r\n<td style=\"text-align: center; vertical-align: top; font-size: 0px; height: 24px;\" align=\"center\">\r\n<table style=\"height: 25px; width: 340px;\" border=\"0\" width=\"193\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td style=\"border-bottom: 3px solid #0087ff; width: 338px;\" height=\"20\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 20px;\">\r\n<td style=\"height: 20px;\" height=\"20\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 28px;\">\r\n<td style=\"font-family: \'Open sans\', Arial, sans-serif; color: #7f8c8d; font-size: 16px; line-height: 28px; height: 28px;\" align=\"left\">{{message}}</td>\r\n</tr>\r\n<tr style=\"height: 40px;\">\r\n<td style=\"height: 40px;\" height=\"40\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;\" align=\"center\" bgcolor=\"#f4f4f4\" height=\"45\">\r\n<table border=\"0\" width=\"90%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td height=\"10\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td class=\"preference-link\" style=\"font-family: \'Open sans\',Arial,sans-serif; color: #95a5a6; font-size: 14px;\" align=\"center\">© 2023&nbsp;<a href=\"#\">{{site_name}}</a>&nbsp;. All Rights Reserved.</td>\r\n</tr>\r\n<tr>\r\n<td height=\"10\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td height=\"60\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', '0', '1', NULL, '2023-06-11 09:39:36'),
(88, 'default_sms_template', 'Hello, {{name}}\r\n{{message}}', '0', '1', NULL, '2023-05-17 10:04:05'),
(89, 'two_factor_auth', '{\"google\":\"1\",\"sms\":\"0\",\"mail\":\"0\"}', '0', '1', NULL, NULL),
(90, 'email_verification', '0', '0', '1', NULL, '2023-11-23 16:25:10'),
(91, 'sms_otp_verification', '1', '0', '1', NULL, NULL),
(92, 'email_notifications', '1', '0', '1', NULL, '2023-06-08 11:37:57'),
(93, 'sms_notifications', '1', '0', '1', NULL, '2023-06-14 07:30:24'),
(94, 'time_zone', '\'Asia/Dhaka\'', '0', '1', NULL, NULL),
(95, 'maintenance_mode', '0', '0', '1', NULL, '2023-06-08 11:27:09'),
(96, 'app_debug', '1', '0', '1', NULL, '2023-11-23 15:36:15'),
(97, 'pagination_number', '10', '0', '1', NULL, '2023-11-21 13:09:23'),
(98, 'copy_right_text', '© 2024 PixelDesk All Rights Reserved KodePixel', '0', '1', NULL, '2023-11-21 13:09:23'),
(99, 'demo_mode', '0', '0', '1', NULL, '2023-06-15 12:29:16'),
(101, 'google_recaptcha', '{\"key\":\"@@@@\",\"secret_key\":\"@@@\",\"status\":\"0\"}', '1', '1', NULL, '2023-11-21 13:09:36'),
(102, 'default_recaptcha', '1', '0', '1', NULL, '2023-08-23 05:47:49'),
(103, 'captcha', '1', '0', '1', NULL, '2023-05-13 12:01:14'),
(104, 'social_login', '{\"google_oauth\":{\"client_id\":\"##\",\"client_secret\":\"##\",\"status\":\"1\"},\"facebook_oauth\":{\"client_id\":\"##\",\"client_secret\":\"##\",\"status\":\"1\"},\"azure_oauth\":{\"client_id\":\"##\",\"client_secret\":\"##\",\"status\":\"1\"},\"envato_oauth\":{\"client_id\":\"##\",\"client_secret\":\"##\",\"status\":\"1\"}}', '1', '1', NULL, '2023-11-21 12:51:32'),
(105, 'google_map', '{\"key\":\"#\"}', '0', '1', NULL, NULL),
(106, 'storage', 'local', '0', '1', NULL, '2023-09-04 09:19:09'),
(108, 'mime_types', '[\"csv\",\"doc\",\"docx\",\"ico\",\"jpeg\",\"jpg\",\"pdf\",\"png\",\"tiff\",\"zip\"]', '0', '1', NULL, '2023-09-04 09:19:09'),
(109, 'aws_s3', '{\"s3_key\":\"AKIAVHNVGMOH7UEGUX@#\",\"s3_secret\":\"5fvYpCPottI4267kxW6SVcMzj3GGkCs65GpYgd##\",\"s3_region\":\"ap-southeast-1\",\"s3_bucket\":\"gen-bucket-s3\"}', '1', '1', NULL, '2023-11-21 13:10:07'),
(110, 'pusher_settings', '{\"app_id\":\"1234\",\"app_key\":\"demo\",\"app_secret\":\"demo\",\"app_cluster\":\"ap2\",\"chanel\":\"My-Channel\",\"event\":\"My-Event\"}', '1', '1', NULL, '2023-11-21 13:09:55'),
(111, 'database_notifications', '1', '0', '1', NULL, '2023-05-13 12:01:13'),
(112, 'cookie', '1', '0', '1', NULL, '2023-09-05 07:37:35'),
(113, 'ticket_settings', '[{\"labels\":\"Name\",\"type\":\"text\",\"required\":\"1\",\"placeholder\":\"Name\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"name\"},{\"labels\":\"Email\",\"type\":\"email\",\"required\":\"1\",\"placeholder\":\"Email\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"email\"},{\"labels\":\"Category\",\"type\":\"select\",\"required\":\"1\",\"placeholder\":\"Select  Category\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"category\"},{\"labels\":\"Priority\",\"type\":\"select\",\"required\":\"1\",\"placeholder\":\"Select Priority\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"priority\"},{\"labels\":\"Subject\",\"type\":\"text\",\"required\":\"1\",\"placeholder\":\"Subject\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"subject\"},{\"labels\":\"Description\",\"type\":\"textarea\",\"required\":\"1\",\"placeholder\":\"Description\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"description\"},{\"labels\":\"Attachment\",\"type\":\"file\",\"required\":\"0\",\"placeholder\":\"Upload upto\",\"default\":\"1\",\"multiple\":\"1\",\"name\":\"attachments\"}]', '0', '1', NULL, '2023-11-21 13:53:49'),
(114, 'max_file_size', '2000000', '0', '1', NULL, '2023-09-04 09:19:09'),
(115, 'cookie_text', 'We use cookies for a better website experience. By using our site, you agree to our Cookie Policy.', '0', '1', NULL, '2023-11-21 13:09:23'),
(116, 'geo_location', 'ip_base', '0', '1', NULL, '2023-09-04 11:19:59'),
(117, 'google_map_key', 'AIzaSyBTOYRAWi26WsbUXi06KNun_FrQZVii9ws', '0', '1', NULL, '2023-09-04 11:19:59'),
(118, 'auto_ticket_assignment', '0', '0', '1', NULL, '2023-09-05 07:01:04'),
(119, 'email_gateway_id', '1', '0', '1', NULL, '2023-06-14 07:30:35'),
(120, 'chat_module', '1', '0', '1', NULL, '2023-08-29 10:18:45'),
(121, 'same_site_name', '0', '0', '1', NULL, '2023-07-06 09:40:31'),
(122, 'max_file_upload', '6', '0', '1', NULL, '2023-09-04 09:19:09'),
(123, 'sms_gateway_id', '2', '0', '1', NULL, '2023-09-04 11:18:54'),
(124, 'slack_notifications', '1', '0', '1', NULL, '2023-05-17 11:36:54'),
(126, 'slack_web_hook_url', 'https://hooks.slack.com/services/T02KR14CAKE/B05893M157W/fHbOfOAi6xEcUy4vKpy8nQ##', '0', '1', NULL, '2023-11-21 13:09:45'),
(128, 'slack_channel', 'xxx', '0', '1', NULL, '2023-11-21 13:09:45'),
(129, 'frontend_logo', '65a27dac552bc1705147820.png', '0', '1', NULL, '2023-11-21 14:34:36'),
(130, 'ticket_notes', '<h4 style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:var(--text-primary);font-family:Inter, sans-serif;font-size:20px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;letter-spacing:normal;line-height:1.2;margin:0px 0px 5px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 18px; font-weight: normal;\">Tell us!</span></h4><p style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:rgb(57, 67, 75);font-family:Inter, sans-serif;font-size:16px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;line-height:1.8;margin:0px 0px 25px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 14px;\">Add as much detail as possible, including site and page name.</span></p><h4 style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:var(--text-primary);font-family:Inter, sans-serif;font-size:20px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;letter-spacing:normal;line-height:1.2;margin:0px 0px 5px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 18px; font-weight: normal;\">Show us!</span></h4><p style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:rgb(57, 67, 75);font-family:Inter, sans-serif;font-size:16px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;line-height:1.8;margin:0px 0px 25px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 14px;\">Add a screenshot or a link to a video.</span></p><h4 style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:var(--text-primary);font-family:Inter, sans-serif;font-size:20px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;letter-spacing:normal;line-height:1.2;margin:0px 0px 5px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 18px; font-weight: normal;\">Caution</span></h4><p style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:rgb(57, 67, 75);font-family:Inter, sans-serif;font-size:16px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;line-height:1.8;margin:0px 0px 25px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 14px;\">Ticket response time can be up to 2 business days.</span></p><h4 style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:var(--text-primary);font-family:Inter, sans-serif;font-size:20px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;letter-spacing:normal;line-height:1.2;margin:0px 0px 5px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 18px; font-weight: normal;\">Response Time</span></h4><p style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:rgb(57, 67, 75);font-family:Inter, sans-serif;font-size:16px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;line-height:1.8;margin:0px 0px 25px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"font-size: 14px;\">Our support team operates six days a week, from 10:00 AM to 8:00 PM in Bangladesh Standard Time (GMT+6), and strives to handle each ticket in a timely manner. However, our response time may be delayed by one or two business days during every weekend or government holiday.</span></p><h4 style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;color:var(--text-primary);font-family:Inter, sans-serif;font-size:20px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;letter-spacing:normal;line-height:1.2;margin:0px 0px 5px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><font color=\"#ff0000\"><span style=\"font-weight: normal; background-color: rgb(255, 255, 255); font-size: 18px;\">Important Notice </span><span style=\"font-weight: normal; background-color: rgb(255, 255, 255);\"><br></span></font></h4><p><span style=\"color:rgb(57,67,75);font-family:Inter, sans-serif;font-size:16px;\"><span style=\"-webkit-text-stroke-width: 0px; box-sizing: border-box; font-style: normal; font-variant-caps: normal; font-variant-ligatures: normal; font-weight: 400; letter-spacing: normal; margin: 0px; outline: none; padding: 0px; text-align: start; text-decoration-color: initial; text-decoration-style: initial; text-decoration-thickness: initial; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; font-size: 14px;\">If a ticket remains unresponsive for more than one or two business days or is unrelated to our support items, it will be locked. Additionally, duplicate ticket issues may also result in ticket locking. Thank you for your cooperation.</span></span></p><p><span style=\"color:rgb(57,67,75);font-family:Inter, sans-serif;font-size:16px;\"><span style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;margin:0px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><br></span></span></p><p><span style=\"color:rgb(57,67,75);font-family:Inter, sans-serif;font-size:16px;\"><span style=\"-webkit-text-stroke-width:0px;box-sizing:border-box;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;margin:0px;orphans:2;outline:none;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><br></span></span></p>', '0', '1', NULL, '2023-11-21 13:53:49'),
(131, 'primary_color', '#081176', '0', '1', NULL, '2023-11-21 14:27:10'),
(132, 'secondary_color', '#07298b', '0', '1', NULL, '2023-11-21 14:27:10'),
(133, 'text_secondary', '#777777', '0', '1', NULL, '2023-11-21 14:27:10'),
(134, 'text_primary', '#0f2335', '0', '1', NULL, '2023-11-21 14:27:10'),
(135, 'open_ai_key', '@@@@', '0', '1', NULL, '2023-09-03 07:04:06'),
(136, 'auto_reply', '1', '0', '1', NULL, '2023-06-14 07:30:09'),
(137, 'terms_accepted_flag', '1', '0', '1', NULL, '2023-07-06 07:36:06'),
(138, 'avg_response_time', '20', '0', '1', NULL, '2023-09-02 05:31:51'),
(139, 'number_of_tickets', '2', '0', '1', NULL, '2023-09-02 05:31:51'),
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
(150, 'system_installed_at', '2024-09-17 15:23:08', '0', '1', NULL, NULL),
(153, 'purchase_key', '776799ce-9fb4-4bdf-b80c-cb1129d417d7', '0', '1', NULL, NULL),
(154, 'envato_username', 'support_tickets', '0', '1', NULL, NULL),
(155, 'maintenance_title', 'Maintenance Title Here', '0', '1', NULL, NULL),
(156, 'maintenance_description', 'Maintenance Mode Description Here', '0', '1', NULL, NULL),
(157, 'last_cron_run', '2024-01-13 16:02:04', '0', '1', NULL, NULL),
(158, 'enable_business_hour', '1', '0', '1', NULL, NULL),
(159, 'business_hour', '{\"Mon\":{\"is_off\":true,\"start_time\":\"12:00 AM\",\"end_time\":\"12:30 AM\"},\"Tue\":{\"is_off\":true,\"start_time\":\"12:00 AM\",\"end_time\":\"9:15 PM\"},\"Wed\":{\"is_off\":true,\"start_time\":\"12:00 AM\",\"end_time\":\"8:15 AM\"},\"Thu\":{\"is_off\":true,\"start_time\":\"12:00 AM\",\"end_time\":\"12:15 AM\"},\"Fri\":{\"is_off\":true,\"start_time\":\"12:00 AM\",\"end_time\":\"1:15 AM\"},\"Sat\":{\"is_off\":false,\"start_time\":\"12:45 AM\",\"end_time\":\"3:30 AM\"},\"Sun\":{\"is_off\":true,\"start_time\":\"24H\",\"end_time\":null}}', '0', '1', NULL, NULL),
(160, 'operating_note', '<span style=\"font-size: 14px;\">You can reach our technical team during hours aligned with the<b><span style=\"font-size: 18px;\">  </span></b></span><span style=\"font-size: 18px;\"><b>[timezone]</b></span><span style=\"font-size: 14px;\"><b><span style=\"font-size: 18px;\"> </span></b> Time Zone.</span>', '0', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sms_gateways`
--

CREATE TABLE `sms_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `gateway_code` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credential` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT 'Active : 1, Inactive : 0',
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
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` int UNSIGNED NOT NULL,
  `support_ticket_id` int UNSIGNED DEFAULT NULL,
  `admin_id` int UNSIGNED DEFAULT NULL,
  `mail_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `editor_files` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seen` tinyint NOT NULL DEFAULT '0' COMMENT 'Yes: 1, No: 0',
  `is_draft` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes:1 ,No: 0',
  `is_note` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes:1 ,No: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` int UNSIGNED NOT NULL,
  `ticket_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `mail_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority_id` bigint UNSIGNED DEFAULT NULL,
  `ticket_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` bigint UNSIGNED DEFAULT NULL,
  `priority` tinyint DEFAULT NULL COMMENT 'Urgent: 1, High: 2, Low: 3, Medium: 4 ',
  `created_at` timestamp NULL DEFAULT NULL,
  `solved_at` timestamp NULL DEFAULT NULL,
  `requested_by` bigint DEFAULT NULL,
  `solved_request_at` timestamp NULL DEFAULT NULL,
  `notification_settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `envato_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_support_expired` tinyint DEFAULT NULL,
  `otp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locked_trigger` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_last_reply` timestamp NULL DEFAULT NULL,
  `is_trigger_timeframe_locked` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'true:1 ,false: 0',
  `solved_request` tinyint DEFAULT NULL COMMENT 'Requested : 0 ,Accepted :1 ,Rejected:2',
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_resolution_requests`
--

CREATE TABLE `ticket_resolution_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `is_solved` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pending: 2 ,Yes:1 , No: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_statuses`
--

CREATE TABLE `ticket_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Active:1 , Inactive: 0',
  `default` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Yes:1 , No: 0',
  `is_base` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Yes:1 , No: 0',
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
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `all_condition` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `any_condition` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `actions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `triggered_counter` int NOT NULL DEFAULT '0',
  `last_triggered` timestamp NULL DEFAULT NULL,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Active:1 ,Inactive: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
(530, 'en', 'user_login', 'User Login', '2024-09-17 09:25:59', '2024-09-17 09:25:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `envato_purchases` longtext COLLATE utf8mb4_unicode_ci,
  `o_auth_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `latitude` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cnss` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `traning` tinyint DEFAULT NULL,
  `city` tinyint DEFAULT NULL,
  `revenue` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `garage_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `muted_agent` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notification_settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified` tinyint DEFAULT NULL COMMENT 'Yes: 1, No: 0 ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` bigint UNSIGNED NOT NULL,
  `ip_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_blocked` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes: 1, No: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `ip_address`, `agent_info`, `is_blocked`, `created_at`, `updated_at`) VALUES
(1, '127.0.0.1', '{\"country\":\"\",\"countryCode\":\"\",\"city\":\"\",\"lon\":\"\",\"lat\":\"\",\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"127.0.0.1\",\"timezone\":\"\",\"time\":\"17-09-2024 03:23:53 PM\"}', '0', '2024-02-25 11:10:41', '2024-09-17 09:23:53');

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
-- Indexes for table `incomming_mail_gateways`
--
ALTER TABLE `incomming_mail_gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `incomming_mail_gateways_name_unique` (`name`);

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_responses`
--
ALTER TABLE `agent_responses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_tickets`
--
ALTER TABLE `agent_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_categories`
--
ALTER TABLE `article_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `canned_replies`
--
ALTER TABLE `canned_replies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_notifications`
--
ALTER TABLE `custom_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floating_chats`
--
ALTER TABLE `floating_chats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incomming_mail_gateways`
--
ALTER TABLE `incomming_mail_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knowledge_bases`
--
ALTER TABLE `knowledge_bases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `model_translations`
--
ALTER TABLE `model_translations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `sms_gateways`
--
ALTER TABLE `sms_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_resolution_requests`
--
ALTER TABLE `ticket_resolution_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_statuses`
--
ALTER TABLE `ticket_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket_triggers`
--
ALTER TABLE `ticket_triggers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=531;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
