-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2023 at 10:15 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carpool-jx`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `created_at`, `updated_at`) VALUES
(60, 3, 1, 'Hi I am TARC YY', '2023-05-18 16:21:17', '2023-05-18 16:21:17'),
(61, 3, 1, 'How are you?', '2023-05-18 17:06:11', '2023-05-18 17:06:11'),
(62, 1, 2, 'Hi I am Teo Yi Yang', '2023-05-19 05:00:56', '2023-05-19 05:00:56'),
(63, 1, 2, 'How are you JIaXin', '2023-05-19 05:01:12', '2023-05-19 05:01:12'),
(65, 3, 1, 'Hi May I ask the trip is available?', '2023-05-19 10:18:26', '2023-05-19 10:18:26'),
(66, 3, 2, 'Hi I am TARC YY', '2023-05-19 10:18:53', '2023-05-19 10:18:53'),
(67, 3, 2, 'How are you?', '2023-05-19 10:23:06', '2023-05-19 10:23:06'),
(68, 3, 1, 'Halo', '2023-05-22 06:47:20', '2023-05-22 06:47:20'),
(69, 1, 3, 'Fuck You', '2023-05-25 06:55:01', '2023-05-25 06:55:01'),
(71, 3, 2, 'Hi', '2023-05-29 09:38:03', '2023-05-29 09:38:03'),
(72, 8, 1, 'Hi', '2023-05-30 13:40:26', '2023-05-30 13:40:26'),
(73, 2, 1, 'I am Fine', '2023-05-30 13:50:54', '2023-05-30 13:50:54'),
(74, 10, 8, 'Hi, I would like to join your trip, I am available at the time and accept for the fare', '2023-05-31 01:58:26', '2023-05-31 01:58:26'),
(75, 8, 10, 'Hi JiaXin , I have accepted your request. See you there!!!', '2023-05-31 02:03:56', '2023-05-31 02:03:56');

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
(5, '2014_10_12_000000_create_users_table', 1),
(6, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(7, '2014_10_12_100000_create_password_resets_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2023_04_08_150323_add_soft_delete_to_users_table', 2),
(11, '2023_04_09_221919_create_trips_table', 3),
(12, '2023_04_09_222023_create_trip_requests_table', 3),
(18, '2023_04_10_151448_add_soft_delete_to_trips_table', 4),
(19, '2023_04_20_130345_create_trip_rider_table', 4),
(21, '2023_04_20_151843_rename_origin_column_in_table', 5),
(22, '2023_04_20_181556_add_status_to_trip_rider_table', 6),
(23, '2023_04_26_161116_add_soft_delete_and_columns_to_trip_requests_table', 7),
(24, '2023_05_16_133411_add_lat_lng_to_trips_and_trip_requests', 8),
(26, '2023_05_17_092707_add_status_to_trips_table', 9),
(27, '2023_05_17_113843_add_image_path_to_users', 10),
(28, '2023_05_17_121223_add_social_media_to_users_table', 11),
(29, '2023_05_18_103125_add_phone_no_to_users_table', 12),
(30, '2023_05_18_104700_create_messages_table', 13),
(35, '2023_05_18_170609_create_sessions_table', 14),
(36, '2023_05_21_123751_create_notifications_table', 14),
(37, '2023_05_23_110750_add_additional_fields_to_users_table', 15),
(41, '2023_05_23_112352_create_vehicles_table', 16),
(45, '2023_05_29_160431_add_fee_to_trips_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Notifications\\TripRequestNotification', 'App\\Models\\User', 1, '{\"message\":\"TARC YY requested to join your trip.\",\"trip_id\":10}', '2023-05-22 06:49:18', '2023-05-22 03:36:15', '2023-05-22 06:49:18'),
(2, 'App\\Notifications\\TripRequestNotification', 'App\\Models\\User', 1, '{\"message\":\"TARC YY requested to join your trip.\",\"trip_id\":10}', '2023-05-30 13:49:11', '2023-05-25 07:02:11', '2023-05-30 13:49:11'),
(3, 'App\\Notifications\\TripRequestNotification', 'App\\Models\\User', 1, '{\"message\":\"Chong Kah Yee requested to join your trip.\",\"trip_id\":15}', NULL, '2023-05-30 13:48:25', '2023-05-30 13:48:25'),
(5, 'App\\Notifications\\TripRequestNotification', 'App\\Models\\User', 8, '{\"message\":\"Jia Xin requested to join your trip.\",\"trip_id\":16}', '2023-05-31 02:03:20', '2023-05-31 02:02:01', '2023-05-31 02:03:20');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('chua@gmail.com', '$2y$10$tJLIvfu.BQJVJN7eKWcXMuVViJjB.OCESWm.wfLzfg7CVkMWi4vWi', '2023-04-05 21:47:44'),
('teo.lgms@gmail.com', '$2y$10$PTg/f2dhDGkMmCEMZZZnauZen/Q6OFUqM2oqYEUrOMcc/vvgbUa8y', '2023-04-05 22:29:31'),
('teoyy-wm19@student.tarc.edu.my', '$2y$10$uKTN0jh1ev6HG7uasHjiwu.BdBe6egGXD98tXJUaXvnGaE6UuPgXO', '2023-04-19 09:57:56');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `destination_location` varchar(255) NOT NULL,
  `departure_time` datetime NOT NULL,
  `available_seats` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `origin_lat` decimal(10,7) DEFAULT NULL,
  `origin_lng` decimal(10,7) DEFAULT NULL,
  `destination_lat` decimal(10,7) DEFAULT NULL,
  `destination_lng` decimal(10,7) DEFAULT NULL,
  `status` enum('pending','ongoing','completed') DEFAULT NULL,
  `pricing` decimal(8,2) DEFAULT NULL,
  `recommended_pricing` decimal(8,2) DEFAULT NULL,
  `eta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `vehicle_id`, `driver_id`, `pickup_location`, `destination_location`, `departure_time`, `available_seats`, `created_at`, `updated_at`, `deleted_at`, `origin_lat`, `origin_lng`, `destination_lat`, `destination_lng`, `status`, `pricing`, `recommended_pricing`, `eta`) VALUES
(1, NULL, 1, 'Subang Jaya', 'Kepong Baru', '2023-04-22 14:00:00', '4', '2023-04-13 03:53:23', '2023-05-17 02:03:53', NULL, NULL, NULL, NULL, NULL, 'ongoing', NULL, NULL, NULL),
(4, NULL, 2, 'Setapak', 'Jinjang', '2023-05-01 14:29:00', '4', '2023-04-26 06:29:35', '2023-05-17 02:54:07', NULL, NULL, NULL, NULL, NULL, 'ongoing', NULL, NULL, NULL),
(6, NULL, 3, 'KL', 'Malacca', '2023-07-05 15:44:00', '6', '2023-04-26 07:44:11', '2023-07-08 14:01:43', NULL, NULL, NULL, NULL, NULL, 'ongoing', NULL, NULL, NULL),
(7, NULL, 2, 'Kepong, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', 'TARUC, Jalan Genting Kelang, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', '2023-05-17 13:54:00', '4', '2023-05-16 05:54:48', '2023-05-18 03:27:40', NULL, '3.2140586', '101.6355864', '3.2142686', '101.7318815', 'ongoing', NULL, NULL, NULL),
(8, NULL, 3, 'PV 128, Jalan Genting Kelang, Danau Kota, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', 'TARUC, Jalan Genting Kelang, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', '2023-05-18 01:53:00', '4', '2023-05-16 16:53:37', '2023-05-18 03:27:40', NULL, '3.2006711', '101.7168407', '3.2142686', '101.7318815', 'ongoing', NULL, NULL, NULL),
(9, NULL, 1, 'Kepong Baru, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', 'Moonlight Cake House (Setapak), Jalan Genting Kelang, Danau Kota, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', '2023-05-19 18:07:00', '5', '2023-05-19 10:07:08', '2023-05-19 10:13:26', NULL, '3.2075140', '101.6427594', '3.1982107', '101.7140972', 'ongoing', NULL, NULL, NULL),
(10, NULL, 1, 'Kepong Baru, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', 'Loud Speaker Family Karaoke @ Setapak 文良港, Jalan Genting Kelang, Danau Kota, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', '2023-05-31 18:12:00', '5', '2023-05-19 10:13:00', '2023-06-21 06:27:27', NULL, '3.2075140', '101.6427594', '3.1983889', '101.7140089', 'ongoing', NULL, NULL, NULL),
(11, NULL, 3, 'Kepong, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', 'Kuantan, Pahang, Malaysia', '2023-05-22 11:25:00', '6', '2023-05-22 03:25:14', '2023-05-22 06:53:46', NULL, '3.2140586', '101.6355864', '3.8168380', '103.3317144', 'ongoing', NULL, NULL, NULL),
(12, NULL, 1, 'TARUC, Jalan Genting Kelang, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', 'LGMS (LE Global Services), Ss 16, Subang Jaya, Selangor, Malaysia', '2023-05-25 14:55:00', '4', '2023-05-25 06:55:53', '2023-05-25 07:00:03', NULL, '3.2148013', '101.7325716', '3.0817000', '101.5818875', 'ongoing', NULL, NULL, NULL),
(13, NULL, 3, 'Empire Shopping Gallery, Main Entrance, Jalan SS 16/1, Ss 16, Subang Jaya, Selangor, Malaysia', 'Surau KTM, Ss 16, Subang Jaya, Selangor, Malaysia', '2023-06-30 17:50:00', '5', '2023-05-29 09:13:56', '2023-07-08 14:01:43', NULL, '3.0816071', '101.5829301', '3.0842476', '101.5883934', 'ongoing', NULL, NULL, NULL),
(14, 10, 1, 'Subang Jaya, Selangor, Malaysia', 'Kepong, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', '2023-06-14 12:03:00', '4', '2023-05-30 04:03:28', '2023-06-21 06:27:27', NULL, '3.0567330', '101.5850782', '3.2140586', '101.6355864', 'ongoing', '15.00', NULL, '8 min'),
(15, 10, 1, 'TARUC, Jalan Genting Kelang, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', 'PV 128, Jalan Genting Kelang, Danau Kota, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', '2023-07-27 13:28:00', '4', '2023-05-30 05:28:21', '2023-05-30 07:14:50', NULL, '3.2148825', '101.7284025', '3.2006711', '101.7168407', 'pending', '15.00', NULL, '12 mins'),
(16, 12, 8, 'Domino\'s Kepong, Jalan Rimbunan Raya 1, Laman Rimbunan, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', 'Jinjang Police Station, Jalan Jinjang Utama, Jinjang Utara, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', '2023-06-01 21:00:00', '4', '2023-05-30 13:46:35', '2023-06-21 06:27:27', NULL, '3.2111290', '101.6496243', '3.2138586', '101.6590954', 'ongoing', '20.00', NULL, '6 mins'),
(17, 13, 10, 'TARUC, Jalan Genting Kelang, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', 'PV16 Platinum Lake Condominium, Jalan Danau Saujana, Danau Kota, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', '2023-06-01 10:00:00', '3', '2023-05-31 01:59:25', '2023-05-31 02:07:53', '2023-05-31 02:07:53', '3.2148825', '101.7284025', '3.2019743', '101.7172734', 'ongoing', '5.00', NULL, '9 mins');

-- --------------------------------------------------------

--
-- Table structure for table `trip_requests`
--

CREATE TABLE `trip_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `seats_requested` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `destination_location` varchar(255) NOT NULL,
  `origin_lat` decimal(10,7) DEFAULT NULL,
  `origin_lng` decimal(10,7) DEFAULT NULL,
  `destination_lat` decimal(10,7) DEFAULT NULL,
  `destination_lng` decimal(10,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trip_requests`
--

INSERT INTO `trip_requests` (`id`, `user_id`, `trip_id`, `seats_requested`, `status`, `created_at`, `updated_at`, `deleted_at`, `pickup_location`, `destination_location`, `origin_lat`, `origin_lng`, `destination_lat`, `destination_lng`) VALUES
(1, 2, 6, 1, 'approved', '2023-04-26 07:45:52', '2023-04-26 08:59:41', NULL, 'KL', 'Malacca', NULL, NULL, NULL, NULL),
(2, 3, 4, 1, 'approved', '2023-05-15 06:05:54', '2023-05-17 02:54:07', NULL, 'Setapak', 'Jinjang', NULL, NULL, NULL, NULL),
(3, 1, 4, 1, 'approved', '2023-05-15 06:19:57', '2023-05-17 02:47:55', NULL, 'Setapak', 'Jinjang', NULL, NULL, NULL, NULL),
(4, 2, 7, 1, 'rejected', '2023-05-16 08:36:05', '2023-05-16 08:36:15', NULL, 'Kepong, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', 'TARUC, Jalan Genting Kelang, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', NULL, NULL, NULL, NULL),
(8, 2, 10, 1, 'pending', '2023-05-21 08:11:57', '2023-05-21 08:11:57', NULL, 'Kepong Baru, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', 'Loud Speaker Family Karaoke @ Setapak 文良港, Jalan Genting Kelang, Danau Kota, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', NULL, NULL, NULL, NULL),
(9, 10, 16, 1, 'approved', '2023-05-31 02:02:01', '2023-05-31 02:03:10', NULL, 'Domino\'s Kepong, Jalan Rimbunan Raya 1, Laman Rimbunan, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', 'Jinjang Police Station, Jalan Jinjang Utama, Jinjang Utara, Kuala Lumpur, Federal Territory of Kuala Lumpur, Malaysia', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trip_rider`
--

CREATE TABLE `trip_rider` (
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `destination_location` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'Customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `social_media` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_media`)),
  `bio` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `education` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_no`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `image_path`, `social_media`, `bio`, `location`, `education`, `occupation`) VALUES
(1, 'Teo Yi Yang', 'teo.lgms@gmail.com', '+60136956250', 'Admin', NULL, '$2y$10$0jo6eBayYaTFYJQxgmSQDuZw682eVUcvh9zPoGoUeYgSw4Lwacly.', NULL, '2023-04-05 20:01:31', '2023-05-30 13:49:49', NULL, NULL, '{\"instagram\":\"_yiyanggg\",\"facebook\":\"Yi Yang Teo\"}', 'I am actually a TARC Student in Degree Last Year , Feel free to know me, Say Something to me if you like to know me more', 'Kepong', 'TARUMT', 'Software Engineer'),
(2, 'Chua Jia Xin', 'chua@gmail.com', '+6012345678', 'User', NULL, '$2y$10$7SShNnucJjNXtImwMN55X.sM4rGya8qfXCZzRGvsmRGpBWCosCerW', NULL, '2023-04-05 21:38:10', '2023-05-20 19:30:04', NULL, 'storage/images/Chua Jia Xin_2.jpeg', '{\"instagram\":\"jiaxin__chua\",\"facebook\":null}', NULL, NULL, NULL, NULL),
(3, 'TARC YY', 'teoyy-wm19@student.tarc.edu.my', NULL, 'Admin', NULL, '$2y$10$jXOgOdL21lVLtsYhR9VLcepZdDE85lgTOlRWD070eWE9lgjM0zHAm', 't3Fe2LH9Y3O2anpegdVwTFUdCdJ8qKCp4GkZyZnCgjUl2lAm56CqNSX4d8lg', '2023-04-05 22:33:55', '2023-04-08 15:58:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Test', 'testing@gmail.com', NULL, 'Admin', NULL, '$2y$10$uMKremtaDy1dLJDReIb2DOI6s8VY.NUNUbJbSxFaeXRNziXHHIOxO', NULL, '2023-04-07 19:50:36', '2023-04-09 02:11:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Yap Ki Nen', 'kinen@gmail.com', NULL, 'Customer', NULL, '$2y$10$hOc9vDD2gIMT1m/3kmIx2eTyrHDa76L1xMEn7O5Ma3j0IPTSe5J/C', NULL, '2023-05-30 10:04:26', '2023-05-30 10:04:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Hiu Hwa Shen', 'hwashen@gmail.com', NULL, 'Customer', NULL, '$2y$10$1YKL50Xcn8CN.v1jgaA4l.eRP2i9oJtFTk6DcRauLHa1MJfMxSqiW', NULL, '2023-05-30 10:25:09', '2023-05-30 10:25:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Law Kuan Teng', 'kuanteng@gmail.com', NULL, 'Customer', NULL, '$2y$10$T23rIVyRVp5rTOmZpK//ceID/abnEx6vaA/zWJqlrl3sSp/.vUSPq', NULL, '2023-05-30 10:30:59', '2023-05-31 02:09:41', '2023-05-31 02:09:41', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Chong Kah Yee', 'kahyee@gmail.com', NULL, 'Admin', NULL, '$2y$10$wEQNujXZ1Fopn.v90FVLHuskv00UKJN1PRKxrSC6YZCFIZwMM6sX6', NULL, '2023-05-30 13:34:59', '2023-05-31 02:09:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Jia Xin', 'jiaxinchua@gmail.com', NULL, 'Customer', NULL, '$2y$10$EwZ3Zqn2tZ7ASTZsdSBc3e6G.cTlHTSUyp9ScBINWVHCydfQYHace', NULL, '2023-05-31 01:41:15', '2023-05-31 01:41:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Jia Xin', 'chuajiaxin@gmail.com', '0123456789', 'Customer', NULL, '$2y$10$fRlgM.3ezg2WwPzZf50TEe8G1z8hVzI6l1xF6U3kssLGq7.QtGhqG', '1QLB20weX35cibCOkJueja9J5GIFgxdJiXb8hvgWm07rB4JG4412vd9vI9Uy', '2023-05-31 01:47:39', '2023-05-31 03:28:01', NULL, 'storage/images/Jia Xin_10.jpg', '{\"instagram\":\"jiaxin__chua\",\"facebook\":\"jiaxin_chua\"}', 'I am a final year student in TARUC', 'Setapak', 'TARMUT', 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `number_plate` varchar(255) DEFAULT NULL,
  `available_seats` int(11) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `user_id`, `name`, `vehicle_type`, `brand`, `model`, `color`, `number_plate`, `available_seats`, `images`, `created_at`, `updated_at`) VALUES
(6, 3, 'w', 'Minivan', 'BMW', 'Myvi', 'Red', 'WC 789K', 3, '[{\"image\":\"TARC YY_3_w_6_20230529_153328.jpg\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_w_6_20230529_153328.jpg\"},{\"image\":\"TARC YY_3_w_6_20230529_154539.png\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_w_6_20230529_154539.png\"},{\"image\":\"TARC YY_3_w_6_20230529_154540.jpg\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_w_6_20230529_154540.jpg\"},{\"image\":\"TARC YY_3_w_6_20230529_155754.png\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_w_6_20230529_155754.png\"}]', '2023-05-25 07:40:10', '2023-05-29 07:57:54'),
(7, 3, 'w', 'Sedan', 'Ford', '234', '434', '2342', 2, '[{\"image\":\"TARC YY_3_Test_8_(1).png\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_Test_8_(1).png\"},{\"image\":\"TARC YY_3_Test_8_(2).jpg\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_Test_8_(2).jpg\"},{\"image\":\"TARC YY_3_Test_8_(3).png\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_Test_8_(3).png\"}]', '2023-05-25 07:41:43', '2023-05-29 06:11:25'),
(8, 3, 'Test', 'Sedan', 'BMW', '234', '434', '2342', 3, '[{\"image\":\"TARC YY_3_Test_8_(1).png\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_Test_8_(1).png\"},{\"image\":\"TARC YY_3_Test_8_(2).jpg\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_Test_8_(2).jpg\"},{\"image\":\"TARC YY_3_Test_8_(3).png\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_Test_8_(3).png\"}]', '2023-05-25 07:53:17', '2023-05-25 07:53:18'),
(9, 3, 'Test', 'SUV', 'BMW', '234', '434', '2342', 3, '[{\"image\":\"TARC YY_3_Test_9_(1).jpg\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_Test_9_(1).jpg\"}]', '2023-05-25 07:55:31', '2023-05-25 07:55:32'),
(10, 1, '343', 'SUV', 'BMW', '433', '2423', '243', 4, '[{\"image\":\"TARC YY_3_343_10_(1).png\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_343_10_(1).png\"},{\"image\":\"TARC YY_3_343_10_(2).png\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_343_10_(2).png\"},{\"image\":\"TARC YY_3_343_10_(3).jpg\",\"path\":\"storage\\/vehicle_images\\/TARC YY_3_343_10_(3).jpg\"}]', '2023-05-25 07:59:01', '2023-05-25 07:59:02'),
(12, 8, 'Small Gold', 'Palamela', 'Mercedes', 'Asia', 'Red', 'WC859B', 5, '[{\"image\":\"Chong Kah Yee_8_Small Gold_12_20230530_214234.png\",\"path\":\"storage\\/vehicle_images\\/Chong Kah Yee_8_Small Gold_12_20230530_214234.png\"},{\"image\":\"Chong Kah Yee_8_Small Gold_12_20230530_214236.png\",\"path\":\"storage\\/vehicle_images\\/Chong Kah Yee_8_Small Gold_12_20230530_214236.png\"},{\"image\":\"Chong Kah Yee_8_Small Gold_12_20230530_214236.jpg\",\"path\":\"storage\\/vehicle_images\\/Chong Kah Yee_8_Small Gold_12_20230530_214236.jpg\"}]', '2023-05-30 13:42:33', '2023-05-30 13:42:36'),
(13, 10, 'My Red Myvi', 'Car', 'Perodua', 'Myvi', 'Red', 'WCK5989', 4, '[{\"image\":\"Jia Xin_10_My Red Myvi_13_20230531_095026.png\",\"path\":\"storage\\/vehicle_images\\/Jia Xin_10_My Red Myvi_13_20230531_095026.png\"},{\"image\":\"Jia Xin_10_My Red Myvi_13_20230531_095026.jpg\",\"path\":\"storage\\/vehicle_images\\/Jia Xin_10_My Red Myvi_13_20230531_095026.jpg\"},{\"image\":\"Jia Xin_10_My Red Myvi_13_20230531_095110.png\",\"path\":\"storage\\/vehicle_images\\/Jia Xin_10_My Red Myvi_13_20230531_095110.png\"}]', '2023-05-31 01:50:24', '2023-05-31 01:51:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

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
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trips_driver_id_foreign` (`driver_id`),
  ADD KEY `trips_vehicle_id_foreign` (`vehicle_id`);

--
-- Indexes for table `trip_requests`
--
ALTER TABLE `trip_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_requests_user_id_foreign` (`user_id`),
  ADD KEY `trip_requests_trip_id_foreign` (`trip_id`);

--
-- Indexes for table `trip_rider`
--
ALTER TABLE `trip_rider`
  ADD PRIMARY KEY (`trip_id`,`user_id`),
  ADD KEY `trip_rider_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicles_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `trip_requests`
--
ALTER TABLE `trip_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `trips_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

--
-- Constraints for table `trip_requests`
--
ALTER TABLE `trip_requests`
  ADD CONSTRAINT `trip_requests_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`),
  ADD CONSTRAINT `trip_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `trip_rider`
--
ALTER TABLE `trip_rider`
  ADD CONSTRAINT `trip_rider_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trip_rider_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
