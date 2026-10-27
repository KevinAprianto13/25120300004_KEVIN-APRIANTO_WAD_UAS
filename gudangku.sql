-- ==============================================================
-- UAS Web Application Development: GudangKu
-- Sistem Manajemen Inventaris Gudang berbasis Laravel dan MySQL
-- Database Schema & Initial Data Dump (gudangku.sql)
-- ==============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `users`
-- (Passwords are hashed bcrypt for 'password123')
-- --------------------------------------------------------
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin GudangKu', 'admin@gudangku.test', '$2y$12$N3aM43P62PjT67f1bJ6uAeFwF2E8QoG9M5Z1c0fD8xJ1K6L7W3O2C', 'admin', NULL, NOW(), NOW()),
(2, 'Staff Inventaris', 'staff@gudangku.test', '$2y$12$N3aM43P62PjT67f1bJ6uAeFwF2E8QoG9M5Z1c0fD8xJ1K6L7W3O2C', 'staff', NULL, NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `categories`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `categories`
-- --------------------------------------------------------
INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Elektronik & Gadget', 'Perangkat elektronik kantor, periferal komputer, dan aksesoris audio', NOW(), NOW()),
(2, 'Alat Tulis & Kantor (ATK)', 'Kebutuhan dokumen, kertas, pulpen, buku, dan perlengkapan meja kerja', NOW(), NOW()),
(3, 'Perkakas & Teknik', 'Peralatan mekanik, kelistrikan, dan pemeliharaan fasilitas', NOW(), NOW()),
(4, 'Bahan Kemasan & Logistik', 'Kardus, lakban, bubble wrap, stretch film, dan strapping band', NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `products`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `min_stock` int(10) UNSIGNED NOT NULL DEFAULT 5,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `products`
-- --------------------------------------------------------
INSERT INTO `products` (`id`, `category_id`, `sku`, `name`, `stock`, `min_stock`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 'ELK-001', 'Mouse Wireless Silent Click', 28, 10, 125000.00, NOW(), NOW()),
(2, 1, 'ELK-002', 'Keyboard Mechanical TKL Blue Switch', 4, 5, 380000.00, NOW(), NOW()),
(3, 1, 'ELK-003', 'Monitor LED 24 Inch Full HD IPS', 2, 5, 1650000.00, NOW(), NOW()),
(4, 2, 'ATK-001', 'Kertas HVS A4 80 Gram (1 Rim/500 Lembar)', 65, 15, 49500.00, NOW(), NOW()),
(5, 2, 'ATK-002', 'Ballpoint Gel Hitam 0.5mm (Pack isi 12)', 3, 8, 32000.00, NOW(), NOW()),
(6, 3, 'TEK-001', 'Set Obeng Presisi Magnetik 32-in-1', 16, 5, 85000.00, NOW(), NOW()),
(7, 4, 'LOG-001', 'Kardus Box Corrugated (30x20x15 cm)', 140, 30, 6500.00, NOW(), NOW()),
(8, 4, 'LOG-002', 'Bubble Wrap Tebal Roll 50m x 125cm', 0, 5, 110000.00, NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `stock_transactions`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `stock_transactions`;
CREATE TABLE `stock_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('in','out') NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_transactions_product_id_foreign` (`product_id`),
  KEY `stock_transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `stock_transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `stock_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `stock_transactions`
-- --------------------------------------------------------
INSERT INTO `stock_transactions` (`id`, `product_id`, `user_id`, `type`, `quantity`, `note`, `transaction_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'in', 30, 'Penerimaan stok batch awal dari supplier', DATE_SUB(CURDATE(), INTERVAL 10 DAY), NOW(), NOW()),
(2, 1, 2, 'out', 2, 'Pengeluaran untuk tim customer care', DATE_SUB(CURDATE(), INTERVAL 6 DAY), NOW(), NOW()),
(3, 2, 1, 'in', 10, 'Restock periferal komputer', DATE_SUB(CURDATE(), INTERVAL 8 DAY), NOW(), NOW()),
(4, 2, 2, 'out', 6, 'Distribusi unit ke workstation engineer', DATE_SUB(CURDATE(), INTERVAL 2 DAY), NOW(), NOW()),
(5, 4, 1, 'in', 80, 'Pengadaan kertas kantor bulanan', DATE_SUB(CURDATE(), INTERVAL 5 DAY), NOW(), NOW()),
(6, 4, 2, 'out', 15, 'Pengambilan untuk bagian administrasi keuangan', DATE_SUB(CURDATE(), INTERVAL 1 DAY), NOW(), NOW()),
(7, 7, 2, 'in', 150, 'Pasokan karton box packing', DATE_SUB(CURDATE(), INTERVAL 4 DAY), NOW(), NOW()),
(8, 7, 2, 'out', 10, 'Packing pengiriman order keluar', CURDATE(), NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
