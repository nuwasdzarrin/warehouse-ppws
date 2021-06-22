-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2021 at 11:16 PM
-- Server version: 10.3.29-MariaDB-cll-lve
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ngabarc1_warehouse_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

CREATE TABLE `institutions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `noted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `institutions`
--

INSERT INTO `institutions` (`id`, `name`, `noted`, `created_at`, `updated_at`) VALUES
(1, 'YAYASAN PEMELIHARAAN DAN PENGEMBANGAN WAKAF', 'Lembaga untuk A', '2021-01-31 20:06:05', '2021-06-22 13:07:23'),
(2, 'Lembaga B', 'Lembaga untuk B', '2021-01-31 20:06:21', '2021-01-31 20:06:21'),
(3, 'Lembaga C', 'Lembaga untuk C', '2021-01-31 20:06:33', '2021-01-31 20:06:33'),
(4, 'Lembaga D', 'Lembaga untuk D', '2021-01-31 20:06:53', '2021-01-31 20:06:53');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2021_01_08_074950_create_roles_table', 1),
(9, '2021_01_08_075256_create_transaction_statuses_table', 1),
(10, '2021_01_08_080611_create_institutions_table', 1),
(11, '2021_01_08_080651_create_product_categories_table', 1),
(12, '2021_01_08_080924_create_products_table', 1),
(13, '2021_01_08_083631_add_role_id_to_users_table', 1),
(14, '2021_01_11_081926_create_transactions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `institution_id` int(10) UNSIGNED DEFAULT NULL,
  `product_category_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` bigint(20) DEFAULT NULL,
  `noted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `institution_id`, `product_category_id`, `name`, `stock`, `noted`, `picture`, `created_at`, `updated_at`) VALUES
(1, 2, 5, 'Spidol Snowman Tidak Permanent', 50, 'Beli Pertama Kali', 'products/h45RTIYB2NUhPZAaFz9vFKOj9OrygPCpDFE2BhQm.jpg', '2021-02-02 02:40:54', '2021-02-11 08:04:45'),
(2, 1, 6, 'Rak Buku Citose', 0, 'Rak untuk buku', NULL, '2021-02-02 02:57:44', '2021-02-04 01:46:30'),
(3, 2, 4, 'Papan Tulis Spidol Putih', 9, 'Ini adalah papan tulis spidol putih', NULL, '2021-02-02 02:58:33', '2021-02-10 06:24:08'),
(4, 1, 7, 'Rak Al-Quran tingkat 4', 2, 'Rak Al-Qur\'an bertingkat 4', NULL, '2021-02-03 23:54:22', '2021-02-03 23:54:22'),
(5, 1, 8, 'Lemari Kaca Penyimpan Piala', 1, 'Lemari kaca untuk menyimpan piala', NULL, '2021-02-03 23:54:52', '2021-02-03 23:54:52'),
(6, 1, 6, 'Rak Buku Kayu Tingkat 6', 2, 'Rak Untuk perpustakaan buku tingkat 6', NULL, '2021-02-03 23:55:31', '2021-02-03 23:55:49'),
(9, 2, 3, 'Kursi Tamu Single Citose', 15, 'Kursi tamu singel citose lala', 'products/1jNA85Si45tFOL3q9TVgW6QyL7WE0Ve4inHhZ6HN.jpg', '2021-02-10 07:45:26', '2021-03-25 03:53:42'),
(10, 2, 3, 'Kursi Kuliah Citose', 0, 'Kursi Kuliah Include Meja Merk citose', 'products/1uYGv9dG1i9L1CPnW9509f1VYGypusKrz576SD6f.jpg', '2021-02-10 09:06:03', '2021-02-10 09:06:03'),
(11, 2, 5, 'Spidol Permanent', 0, 'Permanent Tidak Bisa Di hapus', 'products/ECIQeiztHNKFIaB9dlXd9xSRFZZNhkf5oS09Wcsq.jpg', '2021-02-10 09:06:32', '2021-02-10 09:06:32'),
(12, 1, 9, 'Kursi Plastik', 10, 'Baik', NULL, '2021-06-22 13:04:46', '2021-06-22 13:19:16');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `institution_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `institution_id`, `name`, `created_at`, `updated_at`) VALUES
(2, 3, 'Meja', '2021-02-01 00:59:52', '2021-02-01 01:09:12'),
(3, 2, 'Kursi', '2021-02-01 01:07:02', '2021-02-01 01:07:02'),
(4, 2, 'Papan Tulis', '2021-02-01 01:10:37', '2021-02-01 01:10:37'),
(5, 2, 'Spidol', '2021-02-01 01:23:29', '2021-02-01 01:23:29'),
(6, 1, 'Rak Buku', '2021-02-02 02:09:19', '2021-02-02 02:09:19'),
(7, 1, 'Rak Al-Quran', '2021-02-03 23:53:17', '2021-02-03 23:53:17'),
(8, 1, 'Lemari Kaca', '2021-02-03 23:53:29', '2021-02-03 23:53:29'),
(9, 1, 'Kursi', '2021-06-22 13:03:58', '2021-06-22 13:03:58');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', '2021-01-31 20:09:04', '2021-01-31 20:09:04'),
(2, 'staff', 'Staff', '2021-01-31 20:09:16', '2021-01-31 20:09:16'),
(3, 'superadmin', 'Super Admin', '2021-02-18 04:06:03', '2021-02-18 04:06:03');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `institution_id` int(10) UNSIGNED DEFAULT NULL,
  `transaction_status_id` int(10) UNSIGNED DEFAULT NULL,
  `in_out` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `officer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `product_id`, `user_id`, `institution_id`, `transaction_status_id`, `in_out`, `officer`, `amount`, `noted`, `picture`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 1, 'in', 'Ahmad', '10', 'Beli Spidol 10 Biji', NULL, '2021-02-02 20:34:29', '2021-02-02 20:34:29'),
(2, 3, 5, 2, 3, 'in', 'Rifai', '3', 'Dapat Hibah Papan Tulis Dari Kelas A', NULL, '2021-02-02 20:35:25', '2021-02-02 20:35:25'),
(3, 3, 5, 2, 4, 'out', 'Andi Asrama', '3', 'Untuk kelas luar ruangan', NULL, '2021-02-03 04:44:53', '2021-02-03 04:44:53'),
(4, 3, 5, 2, 7, 'out', 'Syauqi Abdul', '2', 'Hibah untuk ektra kurikuler pramuka', 'transaction_outs/dtvmYS8PO0152HiYOptg9pKppP47rbm8wlbe0qcB.png', '2021-02-03 06:30:36', '2021-02-10 05:19:09'),
(5, 1, 5, 2, 4, 'out', 'Putriani', '2', 'untuk dipergunakan pengenalan santri baru', 'transaction_outs/z5WtS6U0OJNFOqnrCrvc3ZMbaiQNlRWWQ76VX1MU.png', '2021-02-03 06:37:58', '2021-02-10 04:33:33'),
(6, 2, 6, 1, 1, 'in', 'Ramadhan', '2', 'Pembelian tgl ini rak buku', NULL, '2021-02-04 00:25:16', '2021-02-04 00:25:16'),
(7, 4, 6, 1, 3, 'in', 'Ahmad', '1', 'Dapat Hibah Rak Alquran dari masjid Desa', NULL, '2021-02-04 00:26:18', '2021-02-04 00:26:18'),
(8, 6, 6, 1, 1, 'in', 'Sobirin', '2', 'Investasi untuk perpustakaan baru', NULL, '2021-02-04 00:30:35', '2021-02-04 00:30:35'),
(9, 2, 6, 1, 7, 'out', 'Imam', '1', 'Di pakai untuk ruang santri 5', NULL, '2021-02-04 00:32:04', '2021-02-04 00:32:04'),
(10, 4, 6, 1, 7, 'out', 'Ust Syarif', '1', 'Di pakai masjid pondok putra', NULL, '2021-02-04 00:33:45', '2021-02-04 00:33:45'),
(11, 2, 6, 1, 3, 'in', 'Hamdan', '15', 'Dapat hibah dari donatur', NULL, '2021-02-04 01:39:13', '2021-02-04 01:39:13'),
(13, 2, 6, 1, 7, 'out', 'Hanan', '35', 'HIbahkan rak buku citose 35 habis ini stok kosong', NULL, '2021-02-04 01:46:30', '2021-02-04 01:46:30'),
(22, 3, 5, 2, 1, 'in', 'Fahmi', '7', 'Penambahan stok untuk ini itu', 'transaction_ins/BNB6NJo6m41Lj01IqUjjIqF8GGJk3lVGky8BAb0t.jpg', '2021-02-08 00:51:54', '2021-02-08 00:51:54'),
(23, 1, 1, 2, 1, 'in', 'Putri', '1', NULL, NULL, '2021-02-08 08:12:44', '2021-02-08 08:12:44'),
(24, 1, 5, 2, 1, 'in', 'Ahmad', '14', 'Penambahan Stok Spidol', 'transaction_ins/sWZ559CqTSLLr6ew40NaKfmden6jzcWkQMMSfNtc.jpg', '2021-02-08 09:11:10', '2021-02-08 09:11:10'),
(26, 3, 5, 2, 3, 'in', 'Huda', '8', 'hk', 'transaction_ins/epFltk7MAUzcFt4VqzcyVYMOkiS2oat58yRX14qk.jpg', '2021-02-08 10:08:19', '2021-02-09 09:50:51'),
(27, 3, 5, 2, 1, 'in', 'Huda', '6', 'Jumlahnya jadi 20. update dari 2 ke 6', NULL, '2021-02-09 09:47:22', '2021-02-09 09:56:59'),
(28, 3, 5, 2, 7, 'out', 'Hanan Muhammad', '10', 'penggunaan untuk mushola baru', 'transaction_outs/3lWeOpLDX0rl1zJcz1NPZLNGA3lRXygecmFW8c0F.png', '2021-02-10 04:57:33', '2021-02-10 06:24:08'),
(29, 1, 5, 2, 8, 'in', 'Admin', '5', 'Penyesuaian Stok', NULL, '2021-02-11 07:51:30', '2021-02-11 07:51:30'),
(30, 1, 1, 2, 9, 'out', 'Admin', '20', 'Penyesuaian Stok', NULL, '2021-02-11 08:04:45', '2021-02-11 08:04:45'),
(31, 9, 8, 2, 8, 'in', 'Admin', '15', 'Penyesuaian Stok', NULL, '2021-03-25 03:53:42', '2021-03-25 03:53:42'),
(32, 12, 8, 1, 8, 'in', 'Admin', '10', 'Penyesuaian Stok', NULL, '2021-06-22 13:05:19', '2021-06-22 13:05:19'),
(33, 12, 8, 1, 4, 'out', 'Ikhsan', '5', 'Resepsi Ust Bagaskoro di Auditorium', 'transaction_outs/nZVOPgnNpKDr8qynAnJ1WGreHBBd90NMYx5uHS2R.jpg', '2021-06-22 13:14:20', '2021-06-22 13:15:29'),
(34, 12, 8, 1, 5, 'in', 'Ikhsan', '5', 'Pengembalian kursi resepsi Ust Bagaskoro normal', 'transaction_ins/xeBydhtPmDi31hE5e2zWX8jWPGYpd5VEaojf8lnq.jpg', '2021-06-22 13:19:16', '2021-06-22 13:19:16');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_statuses`
--

CREATE TABLE `transaction_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_statuses`
--

INSERT INTO `transaction_statuses` (`id`, `name`, `created_at`, `updated_at`, `type`) VALUES
(1, 'Beli', '2021-02-02 19:13:43', '2021-02-02 21:31:35', 'in'),
(2, 'Jual', '2021-02-02 19:13:47', '2021-02-03 04:18:50', 'out'),
(3, 'Hibah', '2021-02-02 19:13:51', '2021-02-03 04:19:05', 'in'),
(4, 'Dipinjam', '2021-02-02 19:13:56', '2021-02-03 04:26:15', 'out'),
(5, 'Pengembalian', '2021-02-02 19:14:06', '2021-02-03 04:18:36', 'in'),
(7, 'Hibah', '2021-02-03 04:20:57', '2021-02-03 04:20:57', 'out'),
(8, 'Penyesuaian', '2021-02-11 07:19:20', '2021-02-11 07:19:20', 'in'),
(9, 'Penyesuaian', '2021-02-11 07:19:31', '2021-02-11 07:19:31', 'out');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED DEFAULT NULL,
  `institution_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `institution_id`, `name`, `email`, `email_verified_at`, `password`, `address`, `phone`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Admin Lembaga B', 'lembaga-b@gmail.com', NULL, '$2y$10$7j4PnPF.2xNKqVmTQ79tXObRPlwjdnBmdb8pIexD.5AgACQh0jYj2', NULL, NULL, NULL, 'jE8TWLxo0TyiDn9vZmoYBBDu7mur0ud97jWhs4Ns6ZCZVCQHuiWtslJ5wobv', '2021-01-31 18:58:58', '2021-06-22 13:53:47'),
(5, 2, 2, 'Fajrul Moba', 'fajrul@gmail.com', NULL, '$2y$10$e.indbufmdVyxa6N6YsvBuXXNbxoRmRcOLchPuklFMNO3I/8V4A0.', 'JL Mangga Dua', NULL, 'users/Hkf8dCZdSkwdU5VULUnxMOc2a41yE1QnOJaFxmkN.jpg', 'MQITyqlZ1GMK3eDBRn4sPKANnG7SJimuxLKoOPDUzQxT0Jz44Efu7xm0bKaN', '2021-01-31 23:35:50', '2021-06-22 13:30:33'),
(6, 2, 1, 'nunu', 'nunu@gmail.com', NULL, '$2y$10$5BKTgif1EgI7NvoB7WU7cuMAACRW.eU47VHQpcfVayNt2sD3Z1OQG', 'Jl Paron Ngawi', '081213240016', NULL, 'vOxjiuQUrMqMwpv2suYK7DinOodKqurmC0TqAgrQkUNcc2I0ywPKH82NlyA5', '2021-01-31 23:36:49', '2021-01-31 23:36:49'),
(7, 2, 3, 'dana sanjaya', 'dana@gmail.com', NULL, '$2y$10$PZHOBu3dwakmJM8LAfzY/OlCNcHHI3zmV2KF4ifvxSvjSENarIjv6', NULL, NULL, 'users/HooXHL0HViPqSLawqslTDc7zUECcaFrjR72oonMF.png', NULL, '2021-02-02 02:11:48', '2021-02-02 02:11:48'),
(8, 3, NULL, 'Super Admin', 'admin@admin.com', NULL, '$2y$10$8IB28rwDRBM0Sm/xRL/BmeczAvfZE9KuPZcrSP7qJnSahTd0XsicK', NULL, NULL, NULL, 'NTLE1lUr9WZKmi1WYIAFoVWfZjSmAwDQ3fyKdNqStD3mCxQVZ7FCofTCFXKq', '2021-02-18 06:14:12', '2021-02-18 06:14:26'),
(9, 2, 2, 'Iqbal Mubarok', 'iqbal@gmail.com', NULL, '$2y$10$z6JVrJA5QpxwuxT5olx7EuZEFqGW09eWhIwEYsu39B00Cp.pXky9O', NULL, NULL, NULL, NULL, '2021-02-18 08:08:34', '2021-02-18 08:08:34'),
(10, 2, 2, 'Mubarok TV', 'mubarok@gmail.com', NULL, '$2y$10$AdrUY1dQ62gDzjpKATb2xuQphu7/EmjREnC/55FrEunIyxNG4GTfC', NULL, NULL, NULL, NULL, '2021-02-18 08:23:30', '2021-02-18 08:23:30'),
(11, 1, 1, 'Admin Lembaga A', 'lembaga-a@gmail.com', NULL, '$2y$10$xjBtq/8HaibDeflbAWrAB.yasWeNO7eBqPehIbgLkPYWpl1o1tIp6', NULL, NULL, NULL, NULL, '2021-02-18 09:30:23', '2021-02-18 09:30:44'),
(12, 1, 3, 'Admin Lembaga C', 'lembaga-c@gmail.com', NULL, '$2y$10$XALKJBFfXaWulkqt8q8jnO/vsCil.4WS4DPrXImZuK2T0fs08KJMm', NULL, NULL, NULL, NULL, '2021-02-18 09:32:08', '2021-02-18 09:32:08'),
(13, 2, 3, 'Soleh Mahmud', 'soleh@gmail.com', NULL, '$2y$10$T.Z4InWtd9/UNGTs492ezeDEI65o2APM8SvNvUMeIO452IXmoOkmy', NULL, NULL, NULL, NULL, '2021-02-18 09:42:38', '2021-02-18 09:42:38'),
(14, 1, 1, 'Rizza', 'ikhsanwahkid000@gmail.com', NULL, '$2y$10$w1iruUpNWFRFcuuTqmWHIex6sXyFQXdri7GpSgtx5RWgQphML78QK', 'Ponpes Wali songo Ngabar ponorogo', '0822-3027-5053', NULL, NULL, '2021-06-22 12:59:37', '2021-06-22 12:59:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_institution_id_foreign` (`institution_id`),
  ADD KEY `products_product_category_id_foreign` (`product_category_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_categories_institution_id_foreign` (`institution_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_product_id_foreign` (`product_id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_institution_id_foreign` (`institution_id`),
  ADD KEY `transactions_transaction_status_id_foreign` (`transaction_status_id`);

--
-- Indexes for table `transaction_statuses`
--
ALTER TABLE `transaction_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_institution_id_foreign` (`institution_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `institutions`
--
ALTER TABLE `institutions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `transaction_statuses`
--
ALTER TABLE `transaction_statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `products_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_transaction_status_id_foreign` FOREIGN KEY (`transaction_status_id`) REFERENCES `transaction_statuses` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
