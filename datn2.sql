-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 27, 2025 at 02:24 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datn2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_05_20_055247_create_vai_tro_table', 1),
(4, '2025_05_20_055507_create_phan_quyen_table', 1),
(5, '2025_05_20_055617_create_vai_tro_phan_quyen_table', 1),
(6, '2025_05_20_114216_create_phong_ban_table', 1),
(7, '2025_05_20_114359_create_vi_tri_cong_viec_table', 1),
(8, '2025_05_20_114452_create_nguoi_dung_table', 1),
(9, '2025_05_20_124941_create_sessions_table', 1),
(10, '2025_05_27_050722_create_nguoi_dung_vai_tros_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dungs`
--

CREATE TABLE `nguoi_dungs` (
  `id` bigint UNSIGNED NOT NULL,
  `ten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_tao` date DEFAULT NULL,
  `trang_thai` tinyint DEFAULT '1',
  `email_cong_ty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ho_ten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `gioi_tinh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dia_chi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cmnd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phong_ban_id` bigint UNSIGNED NOT NULL,
  `vi_tri_id` bigint UNSIGNED NOT NULL,
  `ngay_vao_lam` date DEFAULT NULL,
  `loai_hinh_lam_viec` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_nghi_viec` date DEFAULT NULL,
  `luong_co_ban` int DEFAULT '0',
  `thuong` int DEFAULT '0',
  `lien_he_khan_cap` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dt_nguoi_lien_he_khan_cap` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dia_chi_nguoi_lien_he_khan_cap` text COLLATE utf8mb4_unicode_ci,
  `dia_chi_thuong_tru` text COLLATE utf8mb4_unicode_ci,
  `anh_dai_dien` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoi_dungs`
--

INSERT INTO `nguoi_dungs` (`id`, `ten`, `email`, `email_verified_at`, `password`, `ngay_tao`, `trang_thai`, `email_cong_ty`, `ho_ten`, `ngay_sinh`, `gioi_tinh`, `so_dien_thoai`, `dia_chi`, `cmnd`, `phong_ban_id`, `vi_tri_id`, `ngay_vao_lam`, `loai_hinh_lam_viec`, `ngay_nghi_viec`, `luong_co_ban`, `thuong`, `lien_he_khan_cap`, `so_dt_nguoi_lien_he_khan_cap`, `dia_chi_nguoi_lien_he_khan_cap`, `dia_chi_thuong_tru`, `anh_dai_dien`, `created_at`, `updated_at`) VALUES
(1, 'admin1', 'admin@example.com', '2025-05-26 22:25:00', '$2y$12$PKCrbOgMMX9.NqLCl.CI4.r1DUxI6cWdDBCVAJX6bzGpw.z1CceQ.', '2025-05-27', 1, 'admin@congty.com', 'Nguyễn Văn A', '1995-05-05', 'Nam', '0987654321', '123 Lý Thường Kiệt', '123456789', 1, 1, '2020-01-01', 'Toàn thời gian', NULL, 10000000, 2000000, 'Nguyễn Văn B', '0912345678', '456 Lê Lợi', '789 Trần Hưng Đạo', 'avatar1.png', '2025-05-26 22:25:00', '2025-05-27 07:15:05');

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung_vai_tros`
--

CREATE TABLE `nguoi_dung_vai_tros` (
  `id` bigint UNSIGNED NOT NULL,
  `nguoi_dung_id` bigint UNSIGNED NOT NULL,
  `vai_tro_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoi_dung_vai_tros`
--

INSERT INTO `nguoi_dung_vai_tros` (`id`, `nguoi_dung_id`, `vai_tro_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-05-26 22:25:00', '2025-05-26 22:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `phan_quyens`
--

CREATE TABLE `phan_quyens` (
  `id` bigint UNSIGNED NOT NULL,
  `chuc_nang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cho_phep` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phan_quyens`
--

INSERT INTO `phan_quyens` (`id`, `chuc_nang`, `cho_phep`, `created_at`, `updated_at`) VALUES
(1, 'Quản lý tài khoản', 1, NULL, NULL),
(2, 'Xem báo cáo', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phong_bans`
--

CREATE TABLE `phong_bans` (
  `id` bigint UNSIGNED NOT NULL,
  `ten_phong_ban` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `quan_ly_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phong_bans`
--

INSERT INTO `phong_bans` (`id`, `ten_phong_ban`, `mo_ta`, `quan_ly_id`, `created_at`, `updated_at`) VALUES
(1, 'Phòng Nhân sự', 'Quản lý nhân sự', 1, NULL, NULL),
(2, 'Phòng IT', 'Phát triển phần mềm', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('sfE26WwYyEfohrdYkDV0LrIyW2pM2HQgTTOxkfFP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVktXblh5ZlpHRDlrbEFDQUo3Mjh2MzgzeFFPWDc1UnRzU252eUIxciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fX0=', 1748355826);

-- --------------------------------------------------------

--
-- Table structure for table `vai_tros`
--

CREATE TABLE `vai_tros` (
  `id` bigint UNSIGNED NOT NULL,
  `ten_vai_tro` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vai_tros`
--

INSERT INTO `vai_tros` (`id`, `ten_vai_tro`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Quản trị hệ thống', NULL, NULL),
(2, 'HR', 'Nhân sự', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vai_tro_phan_quyens`
--

CREATE TABLE `vai_tro_phan_quyens` (
  `vaitro_id` bigint UNSIGNED NOT NULL,
  `phanquyen_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vai_tro_phan_quyens`
--

INSERT INTO `vai_tro_phan_quyens` (`vaitro_id`, `phanquyen_id`) VALUES
(1, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `vi_tri_cong_viecs`
--

CREATE TABLE `vi_tri_cong_viecs` (
  `id` bigint UNSIGNED NOT NULL,
  `ten_vi_tri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `phong_ban_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vi_tri_cong_viecs`
--

INSERT INTO `vi_tri_cong_viecs` (`id`, `ten_vi_tri`, `mo_ta`, `phong_ban_id`, `created_at`, `updated_at`) VALUES
(1, 'Trưởng phòng', 'Quản lý phòng ban', 1, NULL, NULL),
(2, 'Nhân viên lập trình', 'Lập trình phần mềm', 2, NULL, NULL);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `nguoi_dungs`
--
ALTER TABLE `nguoi_dungs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nguoi_dungs_email_unique` (`email`),
  ADD KEY `nguoi_dungs_phong_ban_id_foreign` (`phong_ban_id`),
  ADD KEY `nguoi_dungs_vi_tri_id_foreign` (`vi_tri_id`);

--
-- Indexes for table `nguoi_dung_vai_tros`
--
ALTER TABLE `nguoi_dung_vai_tros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_vai_tros_nguoi_dung_id_foreign` (`nguoi_dung_id`),
  ADD KEY `nguoi_dung_vai_tros_vai_tro_id_foreign` (`vai_tro_id`);

--
-- Indexes for table `phan_quyens`
--
ALTER TABLE `phan_quyens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phong_bans`
--
ALTER TABLE `phong_bans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `vai_tros`
--
ALTER TABLE `vai_tros`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vai_tro_phan_quyens`
--
ALTER TABLE `vai_tro_phan_quyens`
  ADD KEY `vai_tro_phan_quyens_vaitro_id_foreign` (`vaitro_id`),
  ADD KEY `vai_tro_phan_quyens_phanquyen_id_foreign` (`phanquyen_id`);

--
-- Indexes for table `vi_tri_cong_viecs`
--
ALTER TABLE `vi_tri_cong_viecs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vi_tri_cong_viecs_phong_ban_id_foreign` (`phong_ban_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `nguoi_dungs`
--
ALTER TABLE `nguoi_dungs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nguoi_dung_vai_tros`
--
ALTER TABLE `nguoi_dung_vai_tros`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `phan_quyens`
--
ALTER TABLE `phan_quyens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `phong_bans`
--
ALTER TABLE `phong_bans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vai_tros`
--
ALTER TABLE `vai_tros`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vi_tri_cong_viecs`
--
ALTER TABLE `vi_tri_cong_viecs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nguoi_dungs`
--
ALTER TABLE `nguoi_dungs`
  ADD CONSTRAINT `nguoi_dungs_phong_ban_id_foreign` FOREIGN KEY (`phong_ban_id`) REFERENCES `phong_bans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nguoi_dungs_vi_tri_id_foreign` FOREIGN KEY (`vi_tri_id`) REFERENCES `vi_tri_cong_viecs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nguoi_dung_vai_tros`
--
ALTER TABLE `nguoi_dung_vai_tros`
  ADD CONSTRAINT `nguoi_dung_vai_tros_nguoi_dung_id_foreign` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dungs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nguoi_dung_vai_tros_vai_tro_id_foreign` FOREIGN KEY (`vai_tro_id`) REFERENCES `vai_tros` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vai_tro_phan_quyens`
--
ALTER TABLE `vai_tro_phan_quyens`
  ADD CONSTRAINT `vai_tro_phan_quyens_phanquyen_id_foreign` FOREIGN KEY (`phanquyen_id`) REFERENCES `phan_quyens` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vai_tro_phan_quyens_vaitro_id_foreign` FOREIGN KEY (`vaitro_id`) REFERENCES `vai_tros` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vi_tri_cong_viecs`
--
ALTER TABLE `vi_tri_cong_viecs`
  ADD CONSTRAINT `vi_tri_cong_viecs_phong_ban_id_foreign` FOREIGN KEY (`phong_ban_id`) REFERENCES `phong_bans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
