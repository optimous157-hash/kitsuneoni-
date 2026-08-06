-- ============================================================
-- Yamagata Oni — Complete Database Schema & Seed Data
-- Compatible with MySQL 8.0+ / MariaDB 10.3+
-- Generated from Laravel migrations + DatabaseSeeder
-- ============================================================

CREATE DATABASE IF NOT EXISTS yamagata_oni
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE yamagata_oni;

-- -----------------------------------------------------------
-- 1. Users & Auth
-- -----------------------------------------------------------
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `email_verified_at` TIMESTAMP NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(255) NOT NULL DEFAULT 'user',
  `phone` VARCHAR(255) NULL,
  `avatar` VARCHAR(255) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `remember_token` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL PRIMARY KEY,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL PRIMARY KEY,
  `user_id` BIGINT UNSIGNED NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` TEXT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  INDEX `sessions_user_id_index` (`user_id`),
  INDEX `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 2. Products — Categories & Brands
-- -----------------------------------------------------------
CREATE TABLE `categories` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT NULL,
  `image` VARCHAR(255) NULL,
  `icon` VARCHAR(255) NULL,
  `parent_id` BIGINT UNSIGNED NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `meta_title` VARCHAR(255) NULL,
  `meta_description` TEXT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `categories_slug_index` (`slug`),
  INDEX `categories_is_active_index` (`is_active`),
  INDEX `categories_parent_id_index` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `brands` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT NULL,
  `logo` VARCHAR(255) NULL,
  `website` VARCHAR(255) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 3. Products
-- -----------------------------------------------------------
CREATE TABLE `products` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `short_description` TEXT NULL,
  `description` LONGTEXT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `compare_at_price` DECIMAL(10,2) NULL,
  `cost_price` DECIMAL(10,2) NULL,
  `sku` VARCHAR(255) NULL UNIQUE,
  `stock` INT NOT NULL DEFAULT 0,
  `in_stock` TINYINT(1) NOT NULL DEFAULT 1,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `is_bestseller` TINYINT(1) NOT NULL DEFAULT 0,
  `is_new` TINYINT(1) NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `sales_count` INT NOT NULL DEFAULT 0,
  `views_count` INT NOT NULL DEFAULT 0,
  `weight` INT NULL COMMENT 'Weight in grams',
  `length` INT NULL COMMENT 'Length in cm',
  `material` VARCHAR(255) NULL,
  `steel_type` VARCHAR(255) NULL,
  `construction` VARCHAR(255) NULL,
  `hardness_hrc` DECIMAL(4,1) NULL,
  `blade_length` DECIMAL(6,1) NULL,
  `overall_length` DECIMAL(6,1) NULL,
  `blade_width` DECIMAL(4,1) NULL,
  `blade_thickness` DECIMAL(4,1) NULL,
  `handle_material` VARCHAR(255) NULL,
  `scabbard_material` VARCHAR(255) NULL,
  `category_id` BIGINT UNSIGNED NOT NULL,
  `brand_id` BIGINT UNSIGNED NULL,
  `meta_title` VARCHAR(255) NULL,
  `meta_description` TEXT NULL,
  `og_image` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `products_slug_index` (`slug`),
  INDEX `products_category_id_index` (`category_id`),
  INDEX `products_brand_id_index` (`brand_id`),
  INDEX `products_is_featured_index` (`is_featured`),
  INDEX `products_is_bestseller_index` (`is_bestseller`),
  INDEX `products_is_new_index` (`is_new`),
  INDEX `products_is_active_index` (`is_active`),
  INDEX `products_price_index` (`price`),
  INDEX `products_created_at_index` (`created_at`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_images` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `product_id` BIGINT UNSIGNED NOT NULL,
  `path` VARCHAR(255) NOT NULL,
  `alt_text` VARCHAR(255) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_primary` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `product_images_product_id_index` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_tags` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `product_id` BIGINT UNSIGNED NOT NULL,
  `tag` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `product_tags_product_id_index` (`product_id`),
  INDEX `product_tags_tag_index` (`tag`),
  CONSTRAINT `product_tags_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_variants` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `product_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `value` VARCHAR(255) NOT NULL,
  `price_modifier` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `stock` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `product_variants_product_id_index` (`product_id`),
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 4. Orders
-- -----------------------------------------------------------
CREATE TABLE `orders` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `reference_number` VARCHAR(255) NOT NULL UNIQUE,
  `status` VARCHAR(255) NOT NULL DEFAULT 'pending',
  `customer_name` VARCHAR(255) NOT NULL,
  `customer_email` VARCHAR(255) NOT NULL,
  `customer_phone` VARCHAR(255) NULL,
  `customer_country` VARCHAR(255) NOT NULL,
  `customer_city` VARCHAR(255) NOT NULL,
  `customer_address` TEXT NOT NULL,
  `subtotal` DECIMAL(10,2) NOT NULL,
  `shipping_cost` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `total` DECIMAL(10,2) NOT NULL,
  `currency` VARCHAR(3) NOT NULL DEFAULT 'USD',
  `notes` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(255) NULL,
  `confirmed_at` TIMESTAMP NULL,
  `processing_at` TIMESTAMP NULL,
  `delivered_at` TIMESTAMP NULL,
  `cancelled_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `orders_reference_number_index` (`reference_number`),
  INDEX `orders_status_index` (`status`),
  INDEX `orders_customer_email_index` (`customer_email`),
  INDEX `orders_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_items` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_id` BIGINT UNSIGNED NOT NULL,
  `product_id` BIGINT UNSIGNED NOT NULL,
  `product_name` VARCHAR(255) NOT NULL,
  `product_slug` VARCHAR(255) NOT NULL,
  `product_image` VARCHAR(255) NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  `unit_price` DECIMAL(10,2) NOT NULL,
  `total_price` DECIMAL(10,2) NOT NULL,
  `variant` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `order_items_order_id_index` (`order_id`),
  INDEX `order_items_product_id_index` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 5. Reviews & Community
-- -----------------------------------------------------------
CREATE TABLE `reviews` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `product_id` BIGINT UNSIGNED NOT NULL,
  `customer_name` VARCHAR(255) NOT NULL,
  `customer_email` VARCHAR(255) NOT NULL,
  `customer_country` VARCHAR(255) NULL,
  `rating` TINYINT UNSIGNED NOT NULL,
  `title` TEXT NULL,
  `body` TEXT NOT NULL,
  `image` VARCHAR(255) NULL,
  `is_verified` TINYINT(1) NOT NULL DEFAULT 0,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `is_approved` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `reviews_product_id_index` (`product_id`),
  INDEX `reviews_is_approved_index` (`is_approved`),
  INDEX `reviews_is_featured_index` (`is_featured`),
  INDEX `reviews_rating_index` (`rating`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `testimonials` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `customer_name` VARCHAR(255) NOT NULL,
  `customer_title` VARCHAR(255) NULL,
  `customer_avatar` VARCHAR(255) NULL,
  `body` TEXT NOT NULL,
  `rating` TINYINT UNSIGNED NOT NULL DEFAULT 5,
  `source` VARCHAR(255) NULL,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `is_approved` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `testimonials_is_featured_index` (`is_featured`),
  INDEX `testimonials_is_approved_index` (`is_approved`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `wishlists` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT UNSIGNED NULL,
  `product_id` BIGINT UNSIGNED NOT NULL,
  `session_id` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`, `product_id`),
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `newsletter_subscribers` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `name` VARCHAR(255) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `token` VARCHAR(255) NULL,
  `subscribed_at` TIMESTAMP NULL,
  `unsubscribed_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 6. Content — FAQs, Page Sections, Activity Logs
-- -----------------------------------------------------------
CREATE TABLE `faqs` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `question` VARCHAR(255) NOT NULL,
  `answer` TEXT NOT NULL,
  `category` VARCHAR(255) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `page_sections` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(255) NOT NULL UNIQUE,
  `title` VARCHAR(255) NULL,
  `content` TEXT NULL,
  `data` JSON NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `activity_logs` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT UNSIGNED NULL,
  `type` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `properties` JSON NULL,
  `ip_address` VARCHAR(45) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `activity_logs_user_id_index` (`user_id`),
  INDEX `activity_logs_type_index` (`type`),
  INDEX `activity_logs_created_at_index` (`created_at`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 7. Settings & Media
-- -----------------------------------------------------------
CREATE TABLE `settings` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `group` VARCHAR(255) NOT NULL DEFAULT 'general',
  `key` VARCHAR(255) NOT NULL UNIQUE,
  `value` LONGTEXT NULL,
  `type` VARCHAR(255) NOT NULL DEFAULT 'text',
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `media` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `mime_type` VARCHAR(255) NOT NULL,
  `path` VARCHAR(255) NOT NULL,
  `size` BIGINT UNSIGNED NOT NULL,
  `meta` JSON NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 8. Laravel Infrastructure — Cache, Jobs, Tokens
-- -----------------------------------------------------------
CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL PRIMARY KEY,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) NOT NULL PRIMARY KEY,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` TINYINT UNSIGNED NOT NULL,
  `reserved_at` INT UNSIGNED NULL,
  `available_at` INT UNSIGNED NOT NULL,
  `created_at` INT UNSIGNED NOT NULL,
  INDEX `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` VARCHAR(255) NOT NULL PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` INT NOT NULL,
  `pending_jobs` INT NOT NULL,
  `failed_jobs` INT NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` MEDIUMTEXT NULL,
  `cancelled_at` INT NULL,
  `created_at` INT NOT NULL,
  `finished_at` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `uuid` VARCHAR(255) NOT NULL UNIQUE,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `personal_access_tokens` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `token` VARCHAR(64) NOT NULL UNIQUE,
  `abilities` TEXT NULL,
  `last_used_at` TIMESTAMP NULL,
  `expires_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- SEED DATA
-- ============================================================

-- -----------------------------------------------------------
-- Admin user (password: "password")
-- -----------------------------------------------------------
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `avatar`, `is_active`, `remember_token`, `created_at`, `updated_at`)
VALUES (1, 'Yamagata Admin', 'admin@yamagataoni.com', NOW(), '$2y$12$LJ3m4ys3Lk0TSwHnbfOMiOXPm1Qlq5Gz1VOH0G4EZ5YbQ0N0v1OaK', 'super_admin', NULL, NULL, 1, NULL, NOW(), NOW());

-- -----------------------------------------------------------
-- Categories
-- -----------------------------------------------------------
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `icon`, `parent_id`, `sort_order`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'Katanas',       'katanas',        'Premium handcrafted Japanese katanas',      NULL, '⚔️', NULL, 0, 1, NULL, NULL, NOW(), NOW()),
(2, 'Wakizashi',     'wakizashi',      'Short Japanese swords',                      NULL, '🗡️', NULL, 0, 1, NULL, NULL, NOW(), NOW()),
(3, 'Tanto',         'tanto',          'Japanese short blades',                       NULL, '🔪', NULL, 0, 1, NULL, NULL, NOW(), NOW()),
(4, 'Display Stands','display-stands', 'Premium display stands for your collection',  NULL, '🏆', NULL, 0, 1, NULL, NULL, NOW(), NOW()),
(5, 'Accessories',   'accessories',    'Maintenance oil, cases, and more',            NULL, '📦', NULL, 0, 1, NULL, NULL, NOW(), NOW());

-- -----------------------------------------------------------
-- Brands
-- -----------------------------------------------------------
INSERT INTO `brands` (`id`, `name`, `slug`, `description`, `logo`, `website`, `is_active`, `created_at`, `updated_at`)
VALUES (1, 'Yamagata', 'yamagata', 'Yamagata Workshop — Author\'s workshop specializing in handcrafted Japanese collectibles.', NULL, NULL, 1, NOW(), NOW());

-- -----------------------------------------------------------
-- Products
-- -----------------------------------------------------------
INSERT INTO `products` (`id`, `name`, `slug`, `short_description`, `description`, `price`, `compare_at_price`, `cost_price`, `sku`, `stock`, `in_stock`, `is_featured`, `is_bestseller`, `is_new`, `is_active`, `sort_order`, `sales_count`, `views_count`, `weight`, `length`, `material`, `steel_type`, `construction`, `hardness_hrc`, `blade_length`, `overall_length`, `blade_width`, `blade_thickness`, `handle_material`, `scabbard_material`, `category_id`, `brand_id`, `meta_title`, `meta_description`, `og_image`, `created_at`, `updated_at`) VALUES
(1, 'Sanemi Shinazugawa Katana',       'sanemi-shinazugawa-katana',       'Collectible katana inspired by the Wind Hashira from Demon Slayer. Black blade with green wave pattern, 105cm.', '<p>The Sanemi Shinazugawa Katana is inspired by the weapon of the Wind Hashira from Demon Slayer. It features a black blade with a distinctive green wave pattern along the cutting edge, black wooden saya with a white camouflage design, and the iconic eight-point metal tsuba.</p><p>The wooden handle is wrapped in traditional Japanese white and dark green cord. The blade is crafted from 1045 high-carbon steel with a decorative finish. Its Full Tang construction provides excellent strength and durability.</p>', 230.00, 280.00, NULL, 'YO-KAT-001', 15, 1, 1, 1, 0, 1, 0, 47, 0, 950, NULL, 'Carbon Steel', '1045 High Carbon Steel', 'Full Tang', 53.0, 72.0, 105.0, 3.2, 0.7, 'Wood, Traditional Japanese Wrap', 'Solid Wood, Decorative Finish', 1, 1, 'Sanemi Shinazugawa Katana — 105cm Collectible | Yamagata Oni', 'Premium handcrafted Sanemi Shinazugawa Katana. 1045 carbon steel, full tang, 105cm. Includes display stand, gift case, and maintenance oil.', NULL, NOW(), NOW()),
(2, 'Bushido Katana — Classic Black',  'bushido-katana-classic-black',     'Classic black katana with traditional styling. 105cm, 1045 carbon steel. Full tang construction.', '<p>A timeless piece inspired by the way of the warrior. This classic black katana features a hand-polished 1045 carbon steel blade with a deep black finish. Traditional tsuka-ito wrapping in black over white samegawa.</p>', 195.00, NULL, NULL, 'YO-KAT-002', 20, 1, 1, 1, 0, 1, 0, 62, 0, 900, NULL, 'Carbon Steel', '1045 High Carbon Steel', 'Full Tang', 52.0, 70.0, 105.0, NULL, NULL, NULL, NULL, 1, 1, 'Bushido Katana — Classic Black | Yamagata Oni', 'Classic black bushido katana. Handcrafted 1045 carbon steel, full tang, 105cm. Premium gift case included.', NULL, NOW(), NOW()),
(3, 'Rengoku Flame Katana',            'rengoku-flame-katana',             'Flame-themed collectible katana. Red and gold accents, 106cm. Limited edition.', '<p>Inspired by the flame pillar, this stunning katana features a red-tinted blade with golden flame motifs along the hamon. The tsuba is shaped like a flame, and the handle is wrapped in crimson and gold cord.</p>', 245.00, 300.00, NULL, 'YO-KAT-003', 8, 1, 1, 0, 1, 1, 0, 31, 0, 960, NULL, 'Carbon Steel', '1045 High Carbon Steel', 'Full Tang', 53.0, 73.0, 106.0, NULL, NULL, NULL, NULL, 1, 1, 'Rengoku Flame Katana — Limited Edition | Yamagata Oni', 'Limited edition Rengoku flame katana. Red-tinted blade, gold accents, 106cm. Premium gift case and stand included.', NULL, NOW(), NOW()),
(4, 'Mini Katana — Desk Display',      'mini-katana-desk-display',         'Compact 50cm mini katana perfect for desk display. Handcrafted with the same attention to detail.', '<p>A beautifully crafted mini katana at 50cm, perfect for desk display or as a gift. Features the same hand-polished 1045 carbon steel blade and traditional handle wrapping as our full-size katanas.</p>', 85.00, NULL, NULL, 'YO-KAT-004', 30, 1, 0, 1, 0, 1, 0, 89, 0, 350, NULL, 'Carbon Steel', '1045 Carbon Steel', 'Full Tang', NULL, 33.0, 50.0, NULL, NULL, NULL, NULL, 1, 1, 'Mini Katana — Desk Display 50cm | Yamagata Oni', 'Handcrafted 50cm mini katana for desk display. Premium quality, includes display stand.', NULL, NOW(), NOW()),
(5, 'Traditional Wakizashi',           'traditional-wakizashi',            'Traditional 70cm wakizashi. 1045 carbon steel, hand-polished blade with black lacquered saya.', '<p>A traditional wakizashi featuring a hand-polished 1045 carbon steel blade. The black lacquered saya (scabbard) pairs with a traditional cord-wrapped handle.</p>', 165.00, NULL, NULL, 'YO-WAK-001', 12, 1, 0, 0, 0, 1, 0, 23, 0, 600, NULL, 'Carbon Steel', '1045 Carbon Steel', 'Full Tang', NULL, 48.0, 70.0, NULL, NULL, NULL, NULL, 2, 1, NULL, NULL, NULL, NOW(), NOW()),
(6, 'Custom Tanto Blade',              'custom-tanto-blade',               'Compact 30cm tanto blade. Handcrafted with premium materials. Perfect for collectors.', '<p>A beautifully crafted tanto blade at 30cm. Features hand-polished steel with a wooden handle and decorative saya.</p>', 95.00, NULL, NULL, 'YO-TAN-001', 18, 1, 0, 0, 0, 1, 0, 34, 0, 250, NULL, 'Carbon Steel', NULL, NULL, NULL, 18.0, 30.0, NULL, NULL, NULL, NULL, 3, 1, NULL, NULL, NULL, NOW(), NOW()),
(7, 'Premium Sword Display Stand',     'premium-sword-display-stand',      'Handcrafted wooden display stand for swords up to 110cm. Black lacquer finish.', '<p>Display your collection with this premium wooden stand. Handcrafted with a black lacquer finish, it supports swords up to 110cm in length. Non-scratch padding protects your blades.</p>', 45.00, NULL, NULL, 'YO-ACC-001', 50, 1, 1, 0, 0, 1, 0, 112, 0, NULL, NULL, 'Wood', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, NULL, NULL, NULL, NOW(), NOW()),
(8, 'Sword Maintenance Kit',           'sword-maintenance-kit',            'Complete sword maintenance kit. Includes clove oil, cleaning cloth, and storage pouch.', '<p>Keep your blade in pristine condition with our maintenance kit. Includes premium clove oil, microfiber cleaning cloth, and a leather storage pouch.</p>', 25.00, NULL, NULL, 'YO-ACC-002', 100, 1, 0, 0, 0, 1, 0, 200, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 1, NULL, NULL, NULL, NOW(), NOW());

-- -----------------------------------------------------------
-- Product Images (one placeholder per product)
-- -----------------------------------------------------------
INSERT INTO `product_images` (`product_id`, `path`, `alt_text`, `sort_order`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 'products/placeholder-1.jpg', 'Sanemi Shinazugawa Katana', 0, 1, NOW(), NOW()),
(2, 'products/placeholder-2.jpg', 'Bushido Katana — Classic Black', 0, 1, NOW(), NOW()),
(3, 'products/placeholder-3.jpg', 'Rengoku Flame Katana', 0, 1, NOW(), NOW()),
(4, 'products/placeholder-4.jpg', 'Mini Katana — Desk Display', 0, 1, NOW(), NOW()),
(5, 'products/placeholder-5.jpg', 'Traditional Wakizashi', 0, 1, NOW(), NOW()),
(6, 'products/placeholder-6.jpg', 'Custom Tanto Blade', 0, 1, NOW(), NOW()),
(7, 'products/placeholder-7.jpg', 'Premium Sword Display Stand', 0, 1, NOW(), NOW()),
(8, 'products/placeholder-8.jpg', 'Sword Maintenance Kit', 0, 1, NOW(), NOW());

-- -----------------------------------------------------------
-- Reviews
-- -----------------------------------------------------------
INSERT INTO `reviews` (`product_id`, `customer_name`, `customer_email`, `customer_country`, `rating`, `title`, `body`, `image`, `is_verified`, `is_featured`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 'Alex M.',   'alex@example.com',   'USA',    5, 'Incredible craftsmanship',   'The Sanemi katana exceeded all expectations. The detail on the blade is stunning and the weight feels perfect. Packaging was premium — came in a beautiful gift case.', NULL, 1, 1, 1, NOW(), NOW()),
(2, 'Dmitry K.', 'dmitry@example.com', 'Russia', 5, 'Best collector item I own', 'Ordered the Bushido katana. The quality is outstanding for the price. Arrived well-packaged with the display stand. Highly recommend.', NULL, 1, 1, 1, NOW(), NOW()),
(3, 'Marco R.',  'marco@example.com',  'Italy',  5, 'Beautiful piece',           'The Rengoku Flame katana is a work of art. The red accents on the blade are incredible. Shipping to Europe took about 10 days. Very satisfied.', NULL, 1, 1, 1, NOW(), NOW()),
(4, 'Yuki T.',   'yuki@example.com',   'Japan',  4, 'Great quality',             'Very impressive craftsmanship. The mini katana is perfect for my desk. Would love to see more designs.', NULL, 1, 0, 1, NOW(), NOW()),
(7, 'James L.',  'james@example.com',  'UK',     5, 'Perfect gift',              'Bought the display stand as a gift for my brother who collects swords. He loved it! The quality is premium.', NULL, 1, 0, 1, NOW(), NOW()),
(1, 'Sarah W.',  'sarah@example.com',  'Germany',5, 'Amazing quality',           'Third purchase from Yamagata. The consistency in quality is remarkable. Every piece I own is stunning.', NULL, 1, 1, 1, NOW(), NOW());

-- -----------------------------------------------------------
-- Testimonials
-- -----------------------------------------------------------
INSERT INTO `testimonials` (`customer_name`, `customer_title`, `customer_avatar`, `body`, `rating`, `source`, `is_featured`, `is_approved`, `sort_order`, `created_at`, `updated_at`) VALUES
('Alex M.',   'Collector, USA',    NULL, 'Yamagata makes the most beautiful katanas I\'ve ever seen. The attention to detail is unmatched. Every piece feels like it was made just for you.', 5, NULL, 1, 1, 0, NOW(), NOW()),
('Dmitry K.', 'Collector, Russia', NULL, 'I\'ve been collecting for years and Yamagata is my go-to. The quality, the packaging, the personal touch — it\'s all there.', 5, NULL, 1, 1, 0, NOW(), NOW()),
('Marco R.',  'Collector, Italy',  NULL, 'Fast delivery to Europe and the pieces arrived in perfect condition. The craftsmanship rivals pieces I\'ve seen for twice the price.', 5, NULL, 1, 1, 0, NOW(), NOW());

-- -----------------------------------------------------------
-- FAQs
-- -----------------------------------------------------------
INSERT INTO `faqs` (`question`, `answer`, `category`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
('How do I place an order?',                            'Click "Order Now" on any product page, fill in your details, and submit. We\'ll confirm your order via email and provide payment details through Telegram or WhatsApp.', NULL, 1, 1, NOW(), NOW()),
('How long does shipping take?',                        '<strong>CIS countries:</strong> 3-7 business days via CDEK, Russian Post, or Yandex Delivery.<br><strong>International:</strong> 7-21 business days via DHL or UPS.', NULL, 2, 1, NOW(), NOW()),
('Are the products handmade?',                          'Yes! Every piece is handcrafted in our workshop. Due to the nature of handmade items, slight variations may occur — this confirms the authenticity of your piece.', NULL, 3, 1, NOW(), NOW()),
('What payment methods do you accept?',                 'We use a manual order system. After placing your order, we\'ll confirm the details and provide payment options via Telegram or WhatsApp.', NULL, 4, 1, NOW(), NOW()),
('Can I track my order?',                               'Yes! Once your order is shipped, you\'ll receive a tracking number via email. You can track your package in real-time.', NULL, 5, 1, NOW(), NOW()),
('Do you offer custom pieces?',                         'Absolutely! Contact us via Telegram @Yamagataaa to discuss custom orders. We can create personalized pieces to your specifications.', NULL, 6, 1, NOW(), NOW()),
('What is included with each order?',                   'Each order includes the product, a premium gift case, display stand (where applicable), and maintenance oil.', NULL, 7, 1, NOW(), NOW()),
('Do you have a loyalty program?',                      'Yes! Bronze (3% after 1 order), Silver (5% after 3 orders), Gold (10% after 5 orders). Your level is permanent.', NULL, 8, 1, NOW(), NOW());

-- -----------------------------------------------------------
-- Page Sections
-- -----------------------------------------------------------
INSERT INTO `page_sections` (`key`, `title`, `content`, `data`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
('hero_title',    NULL, 'Each Blade Tells a Story', NULL, 1, 0, NOW(), NOW()),
('hero_subtitle', NULL, 'Premium Japanese collectibles forged by hand with centuries of tradition.', NULL, 1, 0, NOW(), NOW());

-- -----------------------------------------------------------
-- Settings
-- -----------------------------------------------------------
INSERT INTO `settings` (`group`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES
('general', 'site_name',     'Yamagata Oni',                         'text', NOW(), NOW()),
('general', 'site_tagline',  'Premium Handcrafted Japanese Collectibles', 'text', NOW(), NOW()),
('contact', 'contact_email', 'orders@yamagataoni.com',               'text', NOW(), NOW());
