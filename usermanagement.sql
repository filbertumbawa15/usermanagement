-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 26, 2024 at 05:41 PM
-- Server version: 10.6.15-MariaDB-log
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usermanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `config_level`
--

CREATE TABLE `config_level` (
  `uuid` char(36) NOT NULL,
  `nama_level` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `config_level`
--

INSERT INTO `config_level` (`uuid`, `nama_level`, `created_at`, `updated_at`, `create_user`, `modified_user`) VALUES
('5fc874ed-03a4-11ef-ba3c-94de801a1234', 'Supervisor', '2024-04-26 08:09:28', '2024-04-26 08:09:28', 'Admin', 'Admin'),
('5fc87e2f-03a4-11ef-ba3c-94de801a1234', 'Admin Trucking', '2024-04-26 08:09:28', '2024-04-26 08:09:28', 'Admin', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `config_modul`
--

CREATE TABLE `config_modul` (
  `uuid` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `urutan` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `config_modul`
--

INSERT INTO `config_modul` (`uuid`, `nama`, `folder`, `icon`, `urutan`, `logo`, `created_at`, `updated_at`, `create_user`, `modified_user`) VALUES
('28009bd7-03a4-11ef-ba3c-94de801a1234', 'Pajak', 'pajak', 'fas fa-home', '4', 'a.jpg', '2024-04-26 08:07:27', '2024-04-26 08:07:27', 'Admin', 'Admin'),
('2800a4f3-03a4-11ef-ba3c-94de801a1234', 'General Ledger', 'generalledger', 'fas fa-home', '5', 'a.jpg', '2024-04-26 08:07:27', '2024-04-26 08:07:27', 'Admin', 'Admin'),
('706dc100-039f-11ef-ba3c-94de801a1234', 'Trucking', 'trucking', 'fas fa-home', '1', 'a.jpg', '2024-04-26 07:33:22', '2024-04-26 07:33:22', 'Admin', 'Admin'),
('706dcedf-039f-11ef-ba3c-94de801a1234', 'EMKL', 'emkl', 'fas fa-home', '2', 'a.jpg', '2024-04-26 07:33:22', '2024-04-26 07:33:22', 'Admin', 'Admin'),
('eff73092-03a3-11ef-ba3c-94de801a1234', 'Settings', 'settings', 'fas fa-home', '3', 'a.jpg', '2024-04-26 08:06:25', '2024-04-26 08:06:25', 'Admin', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `config_modul_akses`
--

CREATE TABLE `config_modul_akses` (
  `uuid` char(36) NOT NULL,
  `id_level` varchar(255) NOT NULL,
  `id_config_modul` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `config_modul_akses`
--

INSERT INTO `config_modul_akses` (`uuid`, `id_level`, `id_config_modul`, `created_at`, `updated_at`, `create_user`, `modified_user`) VALUES
('90d5f34e-03a4-11ef-ba3c-94de801a1234', '5fc874ed-03a4-11ef-ba3c-94de801a1234', '28009bd7-03a4-11ef-ba3c-94de801a1234', '2024-04-26 08:09:23', '2024-04-26 08:09:23', 'Admin', 'Admin'),
('90d5fccd-03a4-11ef-ba3c-94de801a1234', '5fc874ed-03a4-11ef-ba3c-94de801a1234', '2800a4f3-03a4-11ef-ba3c-94de801a1234', '2024-04-26 08:09:23', '2024-04-26 08:09:23', 'Admin', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `config_modul_level_akses`
--

CREATE TABLE `config_modul_level_akses` (
  `uuid` char(36) NOT NULL,
  `id_level` varchar(255) NOT NULL,
  `id_menu` varchar(255) NOT NULL,
  `baca` varchar(255) NOT NULL,
  `tulis` varchar(255) NOT NULL,
  `ubah` varchar(255) NOT NULL,
  `hapus` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config_modul_menu`
--

CREATE TABLE `config_modul_menu` (
  `uuid` char(36) NOT NULL,
  `id_config_modul` varchar(255) NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `id_parent` varchar(255) NOT NULL,
  `nomor_urutan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config_user`
--

CREATE TABLE `config_user` (
  `uuid` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `id_level` varchar(100) DEFAULT NULL,
  `hp` varchar(14) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `last_logged_in` datetime DEFAULT NULL,
  `status` enum('aktif','tidak') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `config_user`
--

INSERT INTO `config_user` (`uuid`, `nama`, `email`, `password`, `salt`, `id_level`, `hp`, `photo`, `token`, `last_logged_in`, `status`, `created_at`, `updated_at`, `create_user`, `modified_user`) VALUES
('9be59ae3-6187-4e48-b400-3a8ca79fffd8', 'Denice', 'filbertumbawa@gmail.com', '$2y$12$eboA3WpEBEDT2Gw1Z/EiT.NYUQxqLJvcKeIPrfqstBeh1mU0Eenum', '$2y$12$RUsboa8.wJzd4ZKOTfKTqe8o0blivUUoXTK7b4G6NLCPqgoTMiZMy', '5fc874ed-03a4-11ef-ba3c-94de801a1234', '085233534605', 'a.jpg', '', '2024-04-25 12:03:53', 'aktif', '2024-04-25 21:08:04', '2024-04-25 21:08:04', 'Admin', 'Admin');

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
(29, '2014_10_12_000000_create_users_table', 1),
(30, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(31, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(32, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(33, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(34, '2016_06_01_000004_create_oauth_clients_table', 1),
(35, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(36, '2019_08_19_000000_create_failed_jobs_table', 1),
(37, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(38, '2024_04_24_103555_create_config_level_table', 1),
(39, '2024_04_24_105116_create_table_config_modul', 1),
(40, '2024_04_25_031700_create_table_config_modul_menu', 1),
(41, '2024_04_25_032027_create_config_modul_akses_table', 1),
(42, '2024_04_25_032301_create_config_modul_level_akses_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('4ebd49b1fb9f0ec31200cf85a35f84143ea584b1ccc0906158b1924b2842a2f2a3a03e65a3d64a3f', '9be59ae3-6187-4e48-b400-3a8ca79fffd8', 3, 'accessToken', '[]', 0, '2024-04-25 21:09:26', '2024-04-25 21:09:26', '2025-04-26 04:09:26');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` char(36) NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'HfOqYTZLBrs3WDsdlsrkPz0Nlz7Alu9rUMbOfIqt', NULL, 'http://localhost', 1, 0, 0, '2024-04-25 21:09:17', '2024-04-25 21:09:17'),
(2, NULL, 'Laravel Password Grant Client', 'htmJ5k7sIBu2l7gtxxKxXFP8QB3ZeeGv2H6pncW2', 'users', 'http://localhost', 0, 1, 0, '2024-04-25 21:09:17', '2024-04-25 21:09:17'),
(3, NULL, 'Laravel Personal Access Client', '9WJgzE7TVJP6cW1gPDTfKIr54uGSsF8WHJf294rz', NULL, 'http://localhost', 1, 0, 0, '2024-04-25 21:09:21', '2024-04-25 21:09:21'),
(4, NULL, 'Laravel Password Grant Client', 'VUxMQfIusqKbKZz9A47j8wDaW1yMYWDmm4w7a7pG', 'users', 'http://localhost', 0, 1, 0, '2024-04-25 21:09:21', '2024-04-25 21:09:21');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-04-25 21:09:17', '2024-04-25 21:09:17'),
(2, 3, '2024-04-25 21:09:21', '2024-04-25 21:09:21');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `config_level`
--
ALTER TABLE `config_level`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `config_modul`
--
ALTER TABLE `config_modul`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `config_modul_akses`
--
ALTER TABLE `config_modul_akses`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `config_modul_level_akses`
--
ALTER TABLE `config_modul_level_akses`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `config_modul_menu`
--
ALTER TABLE `config_modul_menu`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `config_user`
--
ALTER TABLE `config_user`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `config_user_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
