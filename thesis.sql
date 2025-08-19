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


-- Dumping database structure for thesis_app
CREATE DATABASE IF NOT EXISTS `thesis_app` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `thesis_app`;

-- Dumping structure for table thesis_app.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.cache: ~1 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('spatie.permission.cache', 'a:3:{s:5:"alias";a:4:{s:1:"a";s:2:"id";s:1:"b";s:4:"name";s:1:"c";s:10:"guard_name";s:1:"r";s:5:"roles";}s:11:"permissions";a:3:{i:0;a:4:{s:1:"a";i:1;s:1:"b";s:16:"dashboard_access";s:1:"c";s:3:"web";s:1:"r";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;i:4;i:6;}}i:1;a:4:{s:1:"a";i:2;s:1:"b";s:10:"edit_posts";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:"a";i:3;s:1:"b";s:12:"view_reports";s:1:"c";s:3:"web";s:1:"r";a:3:{i:0;i:1;i:1;i:3;i:2;i:6;}}}s:5:"roles";a:5:{i:0;a:3:{s:1:"a";i:1;s:1:"b";s:5:"admin";s:1:"c";s:3:"web";}i:1;a:3:{s:1:"a";i:2;s:1:"b";s:6:"editor";s:1:"c";s:3:"web";}i:2;a:3:{s:1:"a";i:3;s:1:"b";s:6:"viewer";s:1:"c";s:3:"web";}i:3;a:3:{s:1:"a";i:5;s:1:"b";s:8:"employee";s:1:"c";s:3:"web";}i:4;a:3:{s:1:"a";i:6;s:1:"b";s:5:"owner";s:1:"c";s:3:"web";}}}', 1754139912);

-- Dumping structure for table thesis_app.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.cache_locks: ~0 rows (approximately)

-- Dumping structure for table thesis_app.carts
CREATE TABLE IF NOT EXISTS `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.carts: ~0 rows (approximately)
INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
	(33, 2, '2025-07-30 17:15:43', '2025-07-30 17:15:43');

-- Dumping structure for table thesis_app.cart_items
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_cart_id_foreign` (`cart_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.cart_items: ~0 rows (approximately)
INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `product_name`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
	(29, 33, 1, 'Galam Non Kupas Kecil', 2000.00, 1, 2000.00, '2025-07-30 17:15:43', '2025-07-30 17:15:43');

-- Dumping structure for table thesis_app.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_user_id_foreign` (`user_id`),
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.customers: ~9 rows (approximately)
INSERT INTO `customers` (`id`, `user_id`, `phone`, `address`, `created_at`, `updated_at`, `latitude`, `longitude`) VALUES
	(1, 2, '081253864116', 'Kota Banjar Baru, Kalimantan Selatan, Indonesia', '2025-07-05 23:17:52', '2025-07-11 20:24:36', -3.4714992, 114.7060540),
	(2, 6, '088888880', 'Kota Banjarmasin, Kalimantan Selatan, Indonesia', '2025-07-11 17:11:13', '2025-07-23 20:19:24', -3.3277003, 114.5973931),
	(3, 8, '0888888889', 'Martapura, Kalimantan Selatan, Indonesia', '2025-07-20 18:17:13', '2025-07-23 20:19:41', -3.3280000, 114.5900000),
	(4, 11, '0888888881', 'Amuntai, Kalimantan Selatan, Indonesia', '2025-07-23 17:26:39', '2025-07-23 20:20:08', -3.3272147, 114.5948131),
	(5, 12, '0888888882', 'Kuripan, Kalimantan Selatan, Indonesia', '2025-07-23 17:27:08', '2025-07-23 20:20:21', -3.3509780, 114.5955801),
	(6, 13, '0888888883', 'Pelaihari, Kalimantan Selatan', '2025-07-23 20:18:56', '2025-07-23 20:18:56', -3.3334412, 114.6064201),
	(7, 14, '0888888884', 'Sungai Tabuk, Kalimantan Selatan', '2025-07-23 20:21:08', '2025-07-23 20:21:08', -3.3245870, 114.6977165),
	(8, 15, '0888888885', 'Sungai Lulut, Kalimantan Selatan', '2025-07-23 20:21:55', '2025-07-23 20:21:55', -3.3209882, 114.6278695),
	(9, 16, '0888888886', 'Kelayan A, Kalimantan Selatan', '2025-07-23 20:23:22', '2025-07-23 20:23:22', -3.3319560, 114.5933788),
	(10, 17, '0888888887', 'Mantuil, Kalimantan Selatan', '2025-07-23 20:24:03', '2025-07-23 20:24:03', -3.3525203, 114.5491070);

-- Dumping structure for table thesis_app.employees
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `position` enum('buruh','supir') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('bekerja','tersedia') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employees_user_id_foreign` (`user_id`),
  CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.employees: ~9 rows (approximately)
INSERT INTO `employees` (`id`, `user_id`, `position`, `phone`, `status`, `created_at`, `updated_at`) VALUES
	(1, 3, 'buruh', '081253864112', 'bekerja', '2025-07-05 23:18:20', '2025-07-23 20:44:15'),
	(2, 4, 'supir', '081253864113', 'bekerja', '2025-07-05 23:18:34', '2025-07-26 05:04:16'),
	(3, 5, 'buruh', '081253864114', 'tersedia', '2025-07-05 23:18:49', '2025-07-26 05:20:08'),
	(4, 9, 'supir', '081253864111', 'tersedia', '2025-07-23 17:24:45', '2025-07-26 19:24:37'),
	(5, 10, 'supir', '081253864118', 'tersedia', '2025-07-23 17:25:49', '2025-07-23 17:25:49'),
	(6, 18, 'buruh', '08128888881', 'bekerja', '2025-07-23 20:24:50', '2025-07-23 20:44:15'),
	(7, 19, 'buruh', '08128888882', 'bekerja', '2025-07-23 20:25:28', '2025-07-23 20:44:15'),
	(8, 20, 'buruh', '08128888883', 'tersedia', '2025-07-23 20:25:57', '2025-07-26 05:20:08'),
	(9, 21, 'supir', '081253864119', 'tersedia', '2025-07-23 20:26:58', '2025-07-26 19:26:36'),
	(10, 22, 'supir', '081253864120', 'tersedia', '2025-07-23 20:27:31', '2025-07-23 20:27:31');

-- Dumping structure for table thesis_app.failed_jobs
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

-- Dumping data for table thesis_app.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table thesis_app.finance_reports
CREATE TABLE IF NOT EXISTS `finance_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('income','expense') COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `transaction_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.finance_reports: ~19 rows (approximately)
INSERT INTO `finance_reports` (`id`, `type`, `category`, `source`, `amount`, `description`, `total`, `transaction_date`, `created_at`, `updated_at`) VALUES
	(13, 'income', 'Penjualan', 'cash', 950000.00, 'Pemasukan dari penjualan invoice #INVGS-072425-OKWC', 950000.00, '2025-07-24', '2025-07-23 20:35:05', '2025-07-23 20:35:05'),
	(14, 'income', 'Penjualan', 'cash', 1700000.00, 'Pemasukan dari penjualan invoice #INVGS-072425-GZNM', 2650000.00, '2025-07-24', '2025-07-23 20:35:43', '2025-07-23 20:35:43'),
	(15, 'income', 'Penjualan', 'cash', 1310000.00, 'Pemasukan dari penjualan invoice #INVGS-072425-OUM0', 3960000.00, '2025-07-24', '2025-07-23 20:37:31', '2025-07-23 20:37:31'),
	(16, 'income', 'Penjualan', 'cash', 630000.00, 'Pemasukan dari penjualan invoice #INVGS-072425-VAPM', 4590000.00, '2025-07-24', '2025-07-23 20:38:59', '2025-07-23 20:38:59'),
	(17, 'income', 'Penjualan', 'cash', 1330000.00, 'Pemasukan dari penjualan invoice #INVGS-072425-HKTK', 5920000.00, '2025-07-24', '2025-07-23 20:40:16', '2025-07-23 20:40:16'),
	(18, 'income', 'Penjualan', 'cash', 820000.00, 'Pemasukan dari penjualan invoice #INVGS-072425-7VCC', 6740000.00, '2025-07-24', '2025-07-23 20:40:22', '2025-07-23 20:40:22'),
	(19, 'income', 'Penjualan', 'cash', 320000.00, 'Pemasukan dari penjualan invoice #INVGS-072425-R3GD', 7060000.00, '2025-07-24', '2025-07-23 20:41:26', '2025-07-23 20:41:26'),
	(20, 'income', 'Penjualan', 'cash', 960000.00, 'Pemasukan dari penjualan invoice #INVGS-072425-UHHI', 8020000.00, '2025-07-24', '2025-07-23 20:41:30', '2025-07-23 20:41:30'),
	(21, 'income', 'Penjualan', 'cash', 480000.00, 'Pemasukan dari penjualan invoice #INVGS-072425-EOXD', 8500000.00, '2025-07-24', '2025-07-23 20:42:44', '2025-07-23 20:42:44'),
	(22, 'income', 'Penjualan', 'cash', 1560000.00, 'Pemasukan dari penjualan invoice #INVGS-072425-QB1E', 10060000.00, '2025-07-24', '2025-07-23 20:42:49', '2025-07-23 20:42:49'),
	(35, 'expense', 'Pengupahan', 'cash', 200000.00, 'Pembayaran sopir -  untuk Order #INVGS-072425-QB1E', 9860000.00, '2025-07-29', '2025-07-28 23:47:52', '2025-07-28 23:47:52'),
	(36, 'expense', 'Pengupahan', 'cash', 150000.00, 'Pembayaran buruh -  untuk Order #INVGS-072425-QB1E', 9710000.00, '2025-07-29', '2025-07-28 23:47:52', '2025-07-28 23:47:52'),
	(37, 'expense', 'Pengupahan', 'cash', 150000.00, 'Pembayaran buruh -  untuk Order #INVGS-072425-QB1E', 9560000.00, '2025-07-29', '2025-07-28 23:47:52', '2025-07-28 23:47:52'),
	(38, 'expense', 'Pengupahan', 'cash', 200000.00, 'Pembayaran sopir -  untuk Order #INVGS-072425-EOXD', 9660000.00, '2025-07-29', '2025-07-29 00:27:57', '2025-07-29 00:27:57'),
	(39, 'expense', 'Pengupahan', 'cash', 150000.00, 'Pembayaran buruh -  untuk Order #INVGS-072425-EOXD', 9510000.00, '2025-07-29', '2025-07-29 00:27:57', '2025-07-29 00:27:57'),
	(40, 'expense', 'Pengupahan', 'cash', 150000.00, 'Pembayaran buruh -  untuk Order #INVGS-072425-EOXD', 9360000.00, '2025-07-29', '2025-07-29 00:27:57', '2025-07-29 00:27:57'),
	(41, 'expense', 'Pengupahan', 'cash', 200000.00, 'Pembayaran sopir -  untuk Order #INVGS-072425-VAPM', 9160000.00, '2025-07-29', '2025-07-29 01:08:54', '2025-07-29 01:08:54'),
	(42, 'expense', 'Pengupahan', 'cash', 150000.00, 'Pembayaran buruh -  untuk Order #INVGS-072425-VAPM', 9010000.00, '2025-07-29', '2025-07-29 01:08:54', '2025-07-29 01:08:54'),
	(43, 'expense', 'Pengupahan', 'cash', 150000.00, 'Pembayaran buruh -  untuk Order #INVGS-072425-VAPM', 8860000.00, '2025-07-29', '2025-07-29 01:08:54', '2025-07-29 01:08:54');

-- Dumping structure for table thesis_app.jobs
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

-- Dumping data for table thesis_app.jobs: ~0 rows (approximately)

-- Dumping structure for table thesis_app.job_batches
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

-- Dumping data for table thesis_app.job_batches: ~0 rows (approximately)

-- Dumping structure for table thesis_app.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.migrations: ~17 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2024_07_22_060106_create_permission_tables', 1),
	(5, '2025_05_22_073753_create_products_table', 1),
	(6, '2025_06_22_024948_create_customers_table', 1),
	(7, '2025_06_23_034400_create_sales_table', 1),
	(8, '2025_06_24_025829_create_sale_details_table', 1),
	(9, '2025_06_28_063820_create_finance_reports_table', 1),
	(10, '2025_06_29_052915_create_employees_table', 1),
	(11, '2025_07_05_072956_create_trucks_table', 1),
	(12, '2025_07_05_080140_create_orders_table', 1),
	(13, '2025_07_05_080211_create_order_details_table', 1),
	(15, '2025_07_08_005902_create_carts_table', 2),
	(16, '2025_07_08_005941_create_cart_items_table', 2),
	(17, '2025_07_11_105716_create_truck_trackings_table', 3),
	(20, '2025_07_25_022408_create_product_reviews_table', 4),
	(21, '2025_07_29_070256_create_order_payments_table', 5);

-- Dumping structure for table thesis_app.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table thesis_app.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.model_has_roles: ~19 rows (approximately)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(4, 'App\\Models\\User', 2),
	(5, 'App\\Models\\User', 3),
	(5, 'App\\Models\\User', 4),
	(5, 'App\\Models\\User', 5),
	(4, 'App\\Models\\User', 6),
	(6, 'App\\Models\\User', 7),
	(4, 'App\\Models\\User', 8),
	(5, 'App\\Models\\User', 9),
	(5, 'App\\Models\\User', 10),
	(4, 'App\\Models\\User', 11),
	(4, 'App\\Models\\User', 12),
	(4, 'App\\Models\\User', 13),
	(4, 'App\\Models\\User', 14),
	(4, 'App\\Models\\User', 15),
	(4, 'App\\Models\\User', 16),
	(4, 'App\\Models\\User', 17),
	(5, 'App\\Models\\User', 18),
	(5, 'App\\Models\\User', 19),
	(5, 'App\\Models\\User', 20),
	(5, 'App\\Models\\User', 21),
	(5, 'App\\Models\\User', 22);

-- Dumping structure for table thesis_app.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint unsigned NOT NULL,
  `driver_id` bigint unsigned DEFAULT NULL,
  `truck_id` bigint unsigned DEFAULT NULL,
  `shipping_date` date DEFAULT NULL,
  `status` enum('draft','persiapan','pengiriman','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_sale_id_foreign` (`sale_id`),
  KEY `orders_driver_id_foreign` (`driver_id`),
  KEY `orders_truck_id_foreign` (`truck_id`),
  CONSTRAINT `orders_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_truck_id_foreign` FOREIGN KEY (`truck_id`) REFERENCES `trucks` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.orders: ~10 rows (approximately)
INSERT INTO `orders` (`id`, `sale_id`, `driver_id`, `truck_id`, `shipping_date`, `status`, `created_at`, `updated_at`) VALUES
	(13, 28, 4, 2, '2025-07-24', 'selesai', '2025-07-23 20:35:05', '2025-07-24 18:43:52'),
	(14, 29, 2, 2, '2025-07-24', 'selesai', '2025-07-23 20:35:43', '2025-07-23 20:42:58'),
	(15, 30, 2, 1, '2025-07-26', 'selesai', '2025-07-23 20:37:31', '2025-07-25 18:40:24'),
	(16, 32, 4, 4, '2025-07-26', 'selesai', '2025-07-23 20:38:59', '2025-07-26 19:24:37'),
	(17, 34, NULL, NULL, NULL, 'draft', '2025-07-23 20:40:16', '2025-07-23 20:40:16'),
	(18, 33, NULL, NULL, NULL, 'draft', '2025-07-23 20:40:22', '2025-07-23 20:40:22'),
	(19, 36, NULL, NULL, '2025-07-24', 'persiapan', '2025-07-23 20:41:26', '2025-07-23 20:44:15'),
	(20, 35, 2, 1, '2025-07-26', 'pengiriman', '2025-07-23 20:41:30', '2025-07-26 05:04:16'),
	(21, 38, 9, 3, '2025-07-24', 'selesai', '2025-07-23 20:42:44', '2025-07-26 19:26:36'),
	(22, 37, 2, 1, '2025-07-24', 'selesai', '2025-07-23 20:42:49', '2025-07-23 20:44:25');

-- Dumping structure for table thesis_app.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_details_order_id_foreign` (`order_id`),
  KEY `order_details_product_id_foreign` (`product_id`),
  CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.order_details: ~0 rows (approximately)

-- Dumping structure for table thesis_app.order_payments
CREATE TABLE IF NOT EXISTS `order_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `role` enum('sopir','buruh') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `paid_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_payments_order_id_foreign` (`order_id`),
  KEY `order_payments_employee_id_foreign` (`employee_id`),
  CONSTRAINT `order_payments_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.order_payments: ~9 rows (approximately)
INSERT INTO `order_payments` (`id`, `order_id`, `employee_id`, `role`, `amount`, `paid_at`, `created_at`, `updated_at`) VALUES
	(13, 22, 2, 'sopir', 200000.00, '2025-07-29', '2025-07-28 23:47:52', '2025-07-28 23:47:52'),
	(14, 22, 1, 'buruh', 150000.00, '2025-07-29', '2025-07-28 23:47:52', '2025-07-28 23:47:52'),
	(15, 22, 6, 'buruh', 150000.00, '2025-07-29', '2025-07-28 23:47:52', '2025-07-28 23:47:52'),
	(16, 21, 9, 'sopir', 200000.00, '2025-07-29', '2025-07-29 00:27:57', '2025-07-29 00:27:57'),
	(17, 21, 7, 'buruh', 150000.00, '2025-07-29', '2025-07-29 00:27:57', '2025-07-29 00:27:57'),
	(18, 21, 8, 'buruh', 150000.00, '2025-07-29', '2025-07-29 00:27:57', '2025-07-29 00:27:57'),
	(19, 16, 4, 'sopir', 200000.00, '2025-07-29', '2025-07-29 01:08:54', '2025-07-29 01:08:54'),
	(20, 16, 3, 'buruh', 150000.00, '2025-07-29', '2025-07-29 01:08:54', '2025-07-29 01:08:54'),
	(21, 16, 8, 'buruh', 150000.00, '2025-07-29', '2025-07-29 01:08:54', '2025-07-29 01:08:54');

-- Dumping structure for table thesis_app.order_worker
CREATE TABLE IF NOT EXISTS `order_worker` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `worker_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_worker_order_id_foreign` (`order_id`),
  KEY `FK_order_worker_employees` (`worker_id`),
  CONSTRAINT `FK_order_worker_employees` FOREIGN KEY (`worker_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_worker_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.order_worker: ~15 rows (approximately)
INSERT INTO `order_worker` (`id`, `order_id`, `worker_id`, `created_at`, `updated_at`) VALUES
	(21, 14, 1, NULL, NULL),
	(22, 14, 3, NULL, NULL),
	(23, 13, 7, NULL, NULL),
	(24, 13, 8, NULL, NULL),
	(25, 22, 1, NULL, NULL),
	(26, 22, 6, NULL, NULL),
	(27, 21, 7, NULL, NULL),
	(28, 21, 8, NULL, NULL),
	(29, 20, 3, NULL, NULL),
	(30, 19, 1, NULL, NULL),
	(31, 19, 6, NULL, NULL),
	(32, 19, 7, NULL, NULL),
	(33, 15, 8, NULL, NULL),
	(34, 16, 3, NULL, NULL),
	(35, 16, 8, NULL, NULL);

-- Dumping structure for table thesis_app.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table thesis_app.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.permissions: ~2 rows (approximately)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'dashboard_access', 'web', '2025-07-05 23:15:48', '2025-07-05 23:15:48'),
	(2, 'edit_posts', 'web', '2025-07-05 23:15:48', '2025-07-05 23:15:48'),
	(3, 'view_reports', 'web', '2025-07-05 23:15:48', '2025-07-05 23:15:48');

-- Dumping structure for table thesis_app.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('galam','bambu','atap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `stock` int NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.products: ~9 rows (approximately)
INSERT INTO `products` (`id`, `name`, `description`, `category`, `price`, `stock`, `unit`, `image`, `created_at`, `updated_at`) VALUES
	(1, 'Galam Non Kupas Kecil', 'Galam dengan ukuran diameter 5 cm', 'galam', 2000, 210, 'Batang', 'GaixJDAZA69ButRpnUxhviSgrFLFYzJvgMC5XPeQ.png', '2025-07-05 23:17:35', '2025-07-26 20:00:41'),
	(2, 'Galam Non Kupas Besar', 'Galam dengan ukuran diameter 10 cm', 'galam', 5000, 16, 'Batang', 'MzBibhCzCckpQhkqvd0urnuQSN6GFG3hRDQCV4ZM.png', '2025-07-07 04:55:09', '2025-07-26 19:56:32'),
	(3, 'Bambu Besar', 'Bambu dengan lebar 4 cm', 'bambu', 7000, 140, 'Ikat', 'kQAagNcQys8nljAEyLzCBg4lXNh6mV3wdip4D8pn.png', '2025-07-22 20:42:04', '2025-07-25 20:06:38'),
	(5, 'Bambu Kecil', 'Bambu dengan diameter lebar 2 cm', 'bambu', 5000, 230, 'Ikat', 'vFKleHcTxBaO96eXVojb3Kw7JgUgKWfHLUXBz0IC.png', '2025-07-23 17:17:24', '2025-07-26 19:54:23'),
	(6, 'Atap Anyam Kecil', 'Atap Anyaman yang cocok untuk kandang ayam atau hewan ternak dengan panjang 3 m dan lebar 2 m', 'atap', 7000, 70, 'Unit', 'mTZmGml3DA2TKuEV2TMJnHYtf2waabG3JuLOvc3S.png', '2025-07-23 17:19:44', '2025-07-23 20:40:22'),
	(7, 'Galam Super', 'Galam dengan kondisi dan kualitas terbaik untuk keperluan kontruksi yang lebih berat', 'galam', 10000, 10, 'Batang', '6enObrWnXjukKYp23uWJ5SKRHW2nbsgQUF0t6O5r.png', '2025-07-23 18:48:08', '2025-07-23 20:42:42'),
	(8, 'Galam Kupas Kecil', 'Galam yang sudah dikupas dengan diameter 6 cm', 'galam', 4000, 20, 'Batang', '06jdoXiqKnwvOxkMcBzVw0O34JpXP26WwV930UzG.png', '2025-07-23 18:54:39', '2025-07-23 20:41:26'),
	(9, 'Galam Kupas Besar', 'Galam yang dikupas dengan ukuran diameter 10 cm', 'galam', 7000, 10, 'Batang', '5HiELj2R5sBADSegyJaF7SZohsDfmutFBji0N5ML.png', '2025-07-23 18:58:50', '2025-07-23 20:40:14'),
	(10, 'Bambu Super', 'Bambu denga kualitas paling terbaik untuk kontruksi', 'bambu', 10000, 200, 'Ikat', 'hgIEeNxGbga5HaykD06EjXJSmndXM5JJ134uzJBL.png', '2025-07-23 20:09:13', '2025-07-23 20:37:31'),
	(11, 'Atap Anyam Besar', 'Atap Anyaman yang cocok untuk kandang ayam atau hewan ternak dengan panjang 5 m dan lebar 2 m', 'atap', 10000, 160, 'Unit', 'JsAdLIf9cK8Cgz5NuYTr4mLfXFh73YiVpFO2YIR1.png', '2025-07-23 20:12:07', '2025-07-23 20:42:49');

-- Dumping structure for table thesis_app.product_reviews
CREATE TABLE IF NOT EXISTS `product_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `sales_id` bigint unsigned NOT NULL,
  `rating` tinyint unsigned NOT NULL COMMENT '1 sampai 5',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_reviews_product_id_foreign` (`product_id`),
  KEY `product_reviews_customer_id_foreign` (`customer_id`),
  KEY `product_reviews_sales_id_foreign` (`sales_id`),
  CONSTRAINT `product_reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_reviews_sales_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.product_reviews: ~2 rows (approximately)
INSERT INTO `product_reviews` (`id`, `product_id`, `customer_id`, `sales_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
	(3, 1, 1, 30, 5, 'Galamnya bener-bener mantap', '2025-07-25 19:27:22', '2025-07-25 19:27:22'),
	(4, 1, 1, 28, 5, 'Sudah order kedua, dan kualitasnya masih sangat oke', '2025-07-25 19:27:45', '2025-07-25 19:27:45'),
	(5, 6, 1, 30, 5, 'Kualitas atapnya bagus, semoga awet', '2025-07-26 19:42:58', '2025-07-26 19:42:58');

-- Dumping structure for table thesis_app.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.roles: ~5 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'web', '2025-07-05 23:15:48', '2025-07-05 23:15:48'),
	(2, 'editor', 'web', '2025-07-05 23:15:48', '2025-07-05 23:15:48'),
	(3, 'viewer', 'web', '2025-07-05 23:15:48', '2025-07-05 23:15:48'),
	(4, 'customer', 'web', '2025-07-05 23:15:48', '2025-07-05 23:15:48'),
	(5, 'employee', 'web', '2025-07-05 23:15:48', '2025-07-05 23:15:48'),
	(6, 'owner', 'web', '2025-07-06 09:54:05', '2025-07-06 09:54:06');

-- Dumping structure for table thesis_app.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.role_has_permissions: ~10 rows (approximately)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(1, 2),
	(2, 2),
	(1, 3),
	(3, 3),
	(1, 5),
	(1, 6),
	(3, 6);

-- Dumping structure for table thesis_app.sales
CREATE TABLE IF NOT EXISTS `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `payment_method` enum('cash','transfer','cod') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `snap_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('dibayar','belum dibayar','cicil','cancelled','menunggu pembayaran') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu pembayaran',
  `transaction_date` datetime NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sales_invoice_number_unique` (`invoice_number`),
  KEY `sales_customer_id_foreign` (`customer_id`),
  KEY `sales_user_id_foreign` (`user_id`),
  CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.sales: ~10 rows (approximately)
INSERT INTO `sales` (`id`, `invoice_number`, `customer_id`, `user_id`, `total_price`, `payment_method`, `snap_url`, `payment_status`, `transaction_date`, `note`, `created_at`, `updated_at`) VALUES
	(28, 'INVGS-072425-OKWC', 1, 1, 950000.00, 'cash', NULL, 'dibayar', '2025-07-24 04:34:47', NULL, '2025-07-23 20:34:47', '2025-07-23 20:35:05'),
	(29, 'INVGS-072425-GZNM', 7, 1, 1700000.00, 'cash', NULL, 'dibayar', '2025-07-24 04:35:35', NULL, '2025-07-23 20:35:35', '2025-07-23 20:35:41'),
	(30, 'INVGS-072425-OUM0', 1, 1, 1310000.00, 'cash', NULL, 'dibayar', '2025-07-24 04:37:25', NULL, '2025-07-23 20:37:25', '2025-07-23 20:37:31'),
	(32, 'INVGS-072425-VAPM', 1, 1, 630000.00, 'cash', NULL, 'dibayar', '2025-07-24 04:38:53', NULL, '2025-07-23 20:38:53', '2025-07-23 20:38:59'),
	(33, 'INVGS-072425-7VCC', 9, 1, 820000.00, 'cash', NULL, 'dibayar', '2025-07-24 04:39:34', NULL, '2025-07-23 20:39:34', '2025-07-23 20:40:22'),
	(34, 'INVGS-072425-HKTK', 8, 1, 1330000.00, 'cash', NULL, 'dibayar', '2025-07-24 04:39:58', NULL, '2025-07-23 20:39:58', '2025-07-23 20:40:14'),
	(35, 'INVGS-072425-UHHI', 6, 1, 960000.00, 'cash', NULL, 'dibayar', '2025-07-24 04:40:52', NULL, '2025-07-23 20:40:52', '2025-07-23 20:41:30'),
	(36, 'INVGS-072425-R3GD', 3, 1, 320000.00, 'cash', NULL, 'dibayar', '2025-07-24 04:41:20', NULL, '2025-07-23 20:41:20', '2025-07-23 20:41:26'),
	(37, 'INVGS-072425-QB1E', 10, 1, 1560000.00, 'cash', NULL, 'dibayar', '2025-07-24 04:42:00', NULL, '2025-07-23 20:42:00', '2025-07-23 20:42:49'),
	(38, 'INVGS-072425-EOXD', 2, 1, 480000.00, 'cash', NULL, 'dibayar', '2025-07-24 04:42:34', NULL, '2025-07-23 20:42:34', '2025-07-23 20:42:42');

-- Dumping structure for table thesis_app.sale_details
CREATE TABLE IF NOT EXISTS `sale_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_details_sale_id_foreign` (`sale_id`),
  KEY `sale_details_product_id_foreign` (`product_id`),
  CONSTRAINT `sale_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `sale_details_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.sale_details: ~19 rows (approximately)
INSERT INTO `sale_details` (`id`, `sale_id`, `product_id`, `product_name`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
	(28, 28, 1, 'Galam Non Kupas Kecil', 2000.00, 100, 200000.00, '2025-07-23 20:34:47', '2025-07-23 20:34:47'),
	(29, 28, 2, 'Galam Non Kupas Besar', 5000.00, 150, 750000.00, '2025-07-23 20:34:47', '2025-07-23 20:34:47'),
	(30, 29, 7, 'Galam Super', 10000.00, 150, 1500000.00, '2025-07-23 20:35:35', '2025-07-23 20:35:35'),
	(31, 29, 2, 'Galam Non Kupas Besar', 5000.00, 40, 200000.00, '2025-07-23 20:35:35', '2025-07-23 20:35:35'),
	(32, 30, 1, 'Galam Non Kupas Kecil', 2000.00, 50, 100000.00, '2025-07-23 20:37:25', '2025-07-23 20:37:25'),
	(33, 30, 10, 'Bambu Super', 10000.00, 100, 1000000.00, '2025-07-23 20:37:25', '2025-07-23 20:37:25'),
	(34, 30, 6, 'Atap Anyam Kecil', 7000.00, 30, 210000.00, '2025-07-23 20:37:25', '2025-07-23 20:37:25'),
	(37, 32, 6, 'Atap Anyam Kecil', 7000.00, 40, 280000.00, '2025-07-23 20:38:53', '2025-07-23 20:38:53'),
	(38, 32, 5, 'Bambu Kecil', 5000.00, 70, 350000.00, '2025-07-23 20:38:53', '2025-07-23 20:38:53'),
	(39, 33, 6, 'Atap Anyam Kecil', 7000.00, 60, 420000.00, '2025-07-23 20:39:34', '2025-07-23 20:39:34'),
	(40, 33, 8, 'Galam Kupas Kecil', 4000.00, 100, 400000.00, '2025-07-23 20:39:34', '2025-07-23 20:39:34'),
	(41, 34, 9, 'Galam Kupas Besar', 7000.00, 190, 1330000.00, '2025-07-23 20:39:58', '2025-07-23 20:39:58'),
	(42, 35, 3, 'Bambu Besar', 7000.00, 80, 560000.00, '2025-07-23 20:40:52', '2025-07-23 20:40:52'),
	(43, 35, 11, 'Atap Anyam Besar', 10000.00, 40, 400000.00, '2025-07-23 20:40:52', '2025-07-23 20:40:52'),
	(44, 36, 8, 'Galam Kupas Kecil', 4000.00, 80, 320000.00, '2025-07-23 20:41:20', '2025-07-23 20:41:20'),
	(45, 37, 11, 'Atap Anyam Besar', 10000.00, 100, 1000000.00, '2025-07-23 20:42:00', '2025-07-23 20:42:00'),
	(46, 37, 3, 'Bambu Besar', 7000.00, 80, 560000.00, '2025-07-23 20:42:00', '2025-07-23 20:42:00'),
	(47, 38, 7, 'Galam Super', 10000.00, 40, 400000.00, '2025-07-23 20:42:34', '2025-07-23 20:42:34'),
	(48, 38, 1, 'Galam Non Kupas Kecil', 2000.00, 40, 80000.00, '2025-07-23 20:42:34', '2025-07-23 20:42:34');

-- Dumping structure for table thesis_app.sessions
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

-- Dumping data for table thesis_app.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('K36uvEDf3uXOEUlDBz4ypXaYxZgTZ0odhyJFBwH8', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ3VHdzNndlZ3UE55NTZyemd4ZlFsc0RXWEZuSGNZcDFlQlpJamN3SyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1754054267);

-- Dumping structure for table thesis_app.trucks
CREATE TABLE IF NOT EXISTS `trucks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `plate_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('tersedia','dipakai','diperbaiki') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `trucks_plate_number_unique` (`plate_number`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.trucks: ~4 rows (approximately)
INSERT INTO `trucks` (`id`, `plate_number`, `type`, `capacity`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'DA 6333 HA', 'Truck Dump', '2.5', 'dipakai', '2025-07-05 23:19:02', '2025-07-26 05:04:16'),
	(2, 'DA 6334 HA', 'Truck Dump', '2.5', 'tersedia', '2025-07-11 03:36:30', '2025-07-24 18:43:52'),
	(3, 'DA 6335 HA', 'Truck Dump', '2.5', 'tersedia', '2025-07-23 17:23:46', '2025-07-26 19:26:36'),
	(4, 'DA 6336 HA', 'Truck Dump', '2.5', 'tersedia', '2025-07-23 17:23:58', '2025-07-26 19:24:37'),
	(5, 'DA 6337 HA', 'Truck Dump', '2.5', 'tersedia', '2025-07-23 17:24:11', '2025-07-23 17:24:11');

-- Dumping structure for table thesis_app.truck_trackings
CREATE TABLE IF NOT EXISTS `truck_trackings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `truck_id` bigint unsigned NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `status` enum('muat','jalan','bongkar','selesai') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `truck_trackings_truck_id_foreign` (`truck_id`),
  CONSTRAINT `truck_trackings_truck_id_foreign` FOREIGN KEY (`truck_id`) REFERENCES `trucks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.truck_trackings: ~0 rows (approximately)

-- Dumping structure for table thesis_app.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thesis_app.users: ~22 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin User', 'admin@example.com', NULL, '$2y$12$jFBwhkASE5NabS7RUlGmlOuIC5gjSq6idAZPoy1DYbgWPc9/qtAXy', NULL, '2025-07-05 23:15:48', '2025-07-05 23:15:48'),
	(2, 'Herly Riyanto Hidayat', 'herlyryanth@gmail.com', NULL, '$2y$12$v4O.mCPt67YyHh9TN5gCuO79IDRWnjSZLDuKg3qxBJPfpLwVVYS8q', NULL, '2025-07-05 23:17:52', '2025-07-05 23:17:52'),
	(3, 'Candra', 'buruh@gmail.com', NULL, '$2y$12$XIRsVilUxYwWSUgzwPsWveGywuInHjhQ2GuNYf6H/Xo8aCTSGDCbO', NULL, '2025-07-05 23:18:20', '2025-07-23 17:21:45'),
	(4, 'Yuda', 'supir@gmail.com', NULL, '$2y$12$NP1PEFuZT111sYtxcZk3YubPtpwGpH1tJgncM3SfBSrAEYb4rUvqa', NULL, '2025-07-05 23:18:34', '2025-07-23 17:21:59'),
	(5, 'Kholis', 'buruh1@gmail.com', NULL, '$2y$12$bAsFtCl0ovC5T32Nnr/oCOfeBIt99Zt2qZcm14xQW.ExBPtzm1KNu', NULL, '2025-07-05 23:18:48', '2025-07-23 17:22:45'),
	(6, 'Yanto Basnah', 'customer0@gmail.com', NULL, '$2y$12$UzDz398SINN2NakhGfXkVuxtO/p1e3bIUJvuEbrEja5i3k/ojlnD6', NULL, '2025-07-11 17:11:13', '2025-07-23 20:16:55'),
	(7, 'Rahmah', 'owner@example.com', NULL, '$2y$12$3vVtw8.rIPz5aXFyE8643OW2RYAXBe6irxKMBLN99ZJm1rLhnoi7m', NULL, '2025-07-20 00:06:38', '2025-07-20 00:06:38'),
	(8, 'Yadi', 'customer1@example.com', NULL, '$2y$12$Gexdxaev1kHj.4N.MdfjGe71aZZJFu2qGOOJ8d8M/DbCNe/rQpzfW', NULL, '2025-07-20 18:17:13', '2025-07-23 17:20:54'),
	(9, 'Sugi', 'supir1@gmail.com', NULL, '$2y$12$2dutDNsIqUG2TQR2nLBs7.qkdOHpvIRGZUj9QYhO0TBLjX1/DFu0y', NULL, '2025-07-23 17:24:45', '2025-07-23 17:24:45'),
	(10, 'Sugirto', 'supir2@gmail.com', NULL, '$2y$12$L2ta6vO2h3c3FVaz2IYza.Ps5839UTA4C1oRh.qy9Lo/PxjQh6jD6', NULL, '2025-07-23 17:25:49', '2025-07-23 17:25:49'),
	(11, 'Surianto', 'customer2@example.com', NULL, '$2y$12$W/Xmexpsir5d7dbzYB5smuZRxgap3Nmoja3TD4XO8.xZL71K9Ff.m', NULL, '2025-07-23 17:26:39', '2025-07-23 17:26:39'),
	(12, 'Sisrianto', 'customer3@example.com', NULL, '$2y$12$vT4sD1gyqVzfaHtM.P/mNuS5E2UDOeJ13XurVFrONUN1XzuOP2f.y', NULL, '2025-07-23 17:27:08', '2025-07-23 20:14:02'),
	(13, 'Cheng Li', 'customer4@example.com', NULL, '$2y$12$.nv7TRr6QYaQlzGeJImeVujXcH.8NH2HQPm3lGvpwXbxC1ZruJX.G', NULL, '2025-07-23 20:18:56', '2025-07-23 20:18:56'),
	(14, 'Siti', 'customer5@example.com', NULL, '$2y$12$oC3bWfydvbHjGplVdOPYaueIUJzIJKJe9FJgTM5LpJDLqsZlbyHm.', NULL, '2025-07-23 20:21:08', '2025-07-23 20:21:08'),
	(15, 'Brandon', 'customer6@example.com', NULL, '$2y$12$F5aqKD2zSuEFiQzrOjFeoOkq35U52ZIK.Wz0Q/vB2tgtAI.BMg1AG', NULL, '2025-07-23 20:21:55', '2025-07-23 20:21:55'),
	(16, 'Brenda', 'customer7@example.com', NULL, '$2y$12$cnQE00krEdmpQ1ygxiOI9OYzp7g.E8eJsNsu18k6ApNzrn8Ssh7ZS', NULL, '2025-07-23 20:23:21', '2025-07-23 20:23:21'),
	(17, 'Lilis', 'customer8@example.com', NULL, '$2y$12$fI81YkkWRpPp91x/lZZuSe6pubNO6t545oI7iziEr1cK9zEf3vhcG', NULL, '2025-07-23 20:24:03', '2025-07-23 20:24:03'),
	(18, 'Sugeng', 'buruh2@gmail.com', NULL, '$2y$12$jmQMruqOs0clzwhFGRw3Ju/CidbeLzC4Sf4OxgQ6lC2JedYHn7ktm', NULL, '2025-07-23 20:24:50', '2025-07-23 20:24:50'),
	(19, 'Lisa', 'buruh3@gmail.com', NULL, '$2y$12$Ds5lRunE1vdJ4dZESkN8KuoL8TDxjAk9gsdNDr7vwATJTmgcM/X7W', NULL, '2025-07-23 20:25:28', '2025-07-23 20:25:28'),
	(20, 'Seli', 'buruh4@gmail.com', NULL, '$2y$12$Ri4oV0BG.qmnSt.aszav2OFebOjfPzu1h66IbCrTqcGsMVDm2dDP2', NULL, '2025-07-23 20:25:57', '2025-07-23 20:25:57'),
	(21, 'Reza', 'supir3@gmail.com', NULL, '$2y$12$8K8C2ovIYPV5HfTjMLPdme.nn1OrSl/.fh6slPD7w.ZAto5VXnfGK', NULL, '2025-07-23 20:26:58', '2025-07-23 20:26:58'),
	(22, 'Riki', 'supir4@gmail.com', NULL, '$2y$12$Z6A5Vpciq2xh08r1Hby4UuLWOffUKokVv0OtcmQ9gsJyZd39SWjjq', NULL, '2025-07-23 20:27:31', '2025-07-23 20:27:31');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
