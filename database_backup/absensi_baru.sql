-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for absensi_baru
CREATE DATABASE IF NOT EXISTS `absensi_baru` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `absensi_baru`;

-- Dumping structure for table absensi_baru.academic_years
CREATE TABLE IF NOT EXISTS `academic_years` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.academic_years: ~2 rows (approximately)
INSERT INTO `academic_years` (`id`, `name`, `semester`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, '2025/2026', 'Ganjil', 1, '2026-01-06 11:08:18', '2026-01-06 19:56:58'),
	(2, '2028/2029', 'Ganjil', 0, '2026-01-06 19:56:21', '2026-01-06 19:56:58');

-- Dumping structure for table absensi_baru.attendances
CREATE TABLE IF NOT EXISTS `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `schedule_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `status` enum('hadir','sakit','izin','alpha') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendances_schedule_id_foreign` (`schedule_id`),
  KEY `attendances_student_id_foreign` (`student_id`),
  CONSTRAINT `attendances_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.attendances: ~5 rows (approximately)
INSERT INTO `attendances` (`id`, `schedule_id`, `student_id`, `date`, `status`, `note`, `created_at`, `updated_at`) VALUES
	(1, 3, 3, '2026-01-07', 'izin', NULL, '2026-01-06 19:36:12', '2026-01-06 19:36:19'),
	(2, 3, 4, '2026-01-07', 'hadir', NULL, '2026-01-06 19:36:12', '2026-01-06 19:36:12'),
	(3, 3, 5, '2026-01-07', 'hadir', NULL, '2026-01-06 19:36:12', '2026-01-06 19:36:12'),
	(4, 5, 1, '2026-01-07', 'hadir', NULL, '2026-01-06 20:13:41', '2026-01-06 20:13:41'),
	(5, 5, 3, '2026-01-07', 'sakit', NULL, '2026-01-06 20:13:41', '2026-01-06 20:13:41');

-- Dumping structure for table absensi_baru.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.cache: ~0 rows (approximately)

-- Dumping structure for table absensi_baru.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.cache_locks: ~0 rows (approximately)

-- Dumping structure for table absensi_baru.classrooms
CREATE TABLE IF NOT EXISTS `classrooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_year_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classrooms_academic_year_id_foreign` (`academic_year_id`),
  CONSTRAINT `classrooms_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.classrooms: ~3 rows (approximately)
INSERT INTO `classrooms` (`id`, `name`, `academic_year_id`, `created_at`, `updated_at`) VALUES
	(1, 'XII RPL 12', 1, '2026-01-06 11:08:18', '2026-01-06 12:07:49'),
	(2, 'TKJ', 1, '2026-01-06 12:08:05', '2026-01-06 12:08:05'),
	(3, 'tkj2', 2, '2026-01-06 20:03:45', '2026-01-06 20:03:45');

-- Dumping structure for table absensi_baru.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table absensi_baru.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.jobs: ~0 rows (approximately)

-- Dumping structure for table absensi_baru.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.job_batches: ~0 rows (approximately)

-- Dumping structure for table absensi_baru.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.migrations: ~11 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_01_01_000001_create_academic_years_table', 1),
	(5, '2026_01_01_000002_create_classrooms_table', 1),
	(6, '2026_01_01_000003_create_subjects_table', 1),
	(7, '2026_01_01_000004_create_students_table', 1),
	(8, '2026_01_01_000005_create_schedules_table', 1),
	(9, '2026_01_01_000006_create_attendances_table', 1),
	(10, '2026_01_06_184223_add_subject_id_to_users_table', 2),
	(11, '2026_01_07_030619_make_classroom_id_nullable_in_students_table', 3);

-- Dumping structure for table absensi_baru.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table absensi_baru.schedules
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `classroom_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_classroom_id_foreign` (`classroom_id`),
  KEY `schedules_subject_id_foreign` (`subject_id`),
  KEY `schedules_user_id_foreign` (`user_id`),
  CONSTRAINT `schedules_classroom_id_foreign` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.schedules: ~3 rows (approximately)
INSERT INTO `schedules` (`id`, `classroom_id`, `subject_id`, `user_id`, `day`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
	(3, 1, 3, 3, 'Rabu', '09:00:00', '10:00:00', '2026-01-06 19:25:43', '2026-01-06 19:30:36'),
	(4, 2, 3, 2, 'Rabu', '09:00:00', '10:00:00', '2026-01-06 19:27:39', '2026-01-06 19:30:53'),
	(5, 2, 3, 3, 'Rabu', '09:01:00', '10:02:00', '2026-01-06 19:29:56', '2026-01-06 19:30:47');

-- Dumping structure for table absensi_baru.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('zX9UWBneeELgmLze687bA9HrzBJKvQOwmGeZl2Nl', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNm1xMjZDY05yMlB3ck5XRzBHMTJYRzZha0JrbkViVm1LNk5tMHBtaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ndXJ1L2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNDoiZ3VydS5kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1767731066);

-- Dumping structure for table absensi_baru.students
CREATE TABLE IF NOT EXISTS `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `classroom_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `students_classroom_id_foreign` (`classroom_id`),
  CONSTRAINT `students_classroom_id_foreign` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.students: ~4 rows (approximately)
INSERT INTO `students` (`id`, `name`, `gender`, `classroom_id`, `created_at`, `updated_at`) VALUES
	(1, 'Ahmad yani', 'L', 2, '2026-01-06 11:08:18', '2026-01-06 12:12:10'),
	(3, 'Chika', 'L', 2, '2026-01-06 11:08:18', '2026-01-06 20:05:50'),
	(4, 'Dedi', 'L', NULL, '2026-01-06 11:08:18', '2026-01-06 20:07:27'),
	(5, 'Eka', 'L', 1, '2026-01-06 11:08:18', '2026-01-06 11:08:18');

-- Dumping structure for table absensi_baru.subjects
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.subjects: ~1 rows (approximately)
INSERT INTO `subjects` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(3, 'inggris', '2026-01-06 12:04:01', '2026-01-06 12:04:01');

-- Dumping structure for table absensi_baru.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','guru') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'guru',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_subject_id_foreign` (`subject_id`),
  CONSTRAINT `users_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table absensi_baru.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `subject_id`) VALUES
	(1, 'Administrator', 'admin@sekolah.com', NULL, '$2y$12$pGaYrReWGTXkGrYGU35qA.C.gx4/zWRmdS/H0wSeNbQGav7w0SfHG', 'admin', NULL, '2026-01-06 11:08:18', '2026-01-06 11:08:18', NULL),
	(2, 'Pak Budi Santoso', 'budi@sekolah.com', NULL, '$2y$12$MhHZbxp7umQvF.FNYfpDY.F3ijcUXBYDsC3XSJg1K.rwOX64wSRvO', 'guru', NULL, '2026-01-06 11:08:18', '2026-01-06 11:08:18', NULL),
	(3, 'Bagas1', 'bagas@sekolah.com', NULL, '$2y$12$C14e5v0CNrut/mD72Kqy/.7rBF/OB1.ksBAhTY4KHvPCE7gfYGG9i', 'guru', NULL, '2026-01-06 11:53:10', '2026-01-06 12:01:06', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
