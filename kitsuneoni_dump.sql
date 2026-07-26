-- Kitsuneoni Database Dump
-- Generated: 2026-07-21 20:47:24

SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
SET time_zone = '+00:00';

-- --------------------------------------------------------
-- Table: activity_logs

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `properties` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_index` (`user_id`),
  KEY `activity_logs_type_index` (`type`),
  KEY `activity_logs_created_at_index` (`created_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: brands

DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `brands` (`id`,`name`,`slug`,`description`,`logo`,`website`,`is_active`,`created_at`,`updated_at`) VALUES
(1,'Kitsuneoni','kitsuneoni','Kitsuneoni Workshop — Author\'s workshop specializing in handcrafted Japanese collectibles.',NULL,NULL,1,'2026-07-21 20:29:05','2026-07-21 20:29:05');

-- --------------------------------------------------------
-- Table: cache

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cache` (`key`,`value`,`expiration`) VALUES
('kitsuneoni_cache_page_views_2026-07-21','i:31;',1784752813);

-- --------------------------------------------------------
-- Table: cache_locks

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: categories

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_slug_index` (`slug`),
  KEY `categories_is_active_index` (`is_active`),
  KEY `categories_parent_id_index` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`,`name`,`slug`,`description`,`image`,`icon`,`parent_id`,`sort_order`,`is_active`,`meta_title`,`meta_description`,`created_at`,`updated_at`) VALUES
(1,'Katanas','katanas','Premium handcrafted Japanese katanas',NULL,NULL,NULL,'0',1,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(2,'Wakizashi','wakizashi','Short Japanese swords',NULL,NULL,NULL,'0',1,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(3,'Tanto','tanto','Japanese short blades',NULL,NULL,NULL,'0',1,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(4,'Display Stands','display-stands','Premium display stands for your collection',NULL,NULL,NULL,'0',1,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(5,'Accessories','accessories','Maintenance oil, cases, and more',NULL,NULL,NULL,'0',1,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05');

-- --------------------------------------------------------
-- Table: failed_jobs

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: faqs

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `faqs` (`id`,`question`,`answer`,`category`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES
(1,'How do I place an order?','Click "Order Now" on any product page, fill in your details, and submit. We\'ll confirm via email and provide payment details through Telegram or WhatsApp.',NULL,1,1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(2,'How long does shipping take?','<strong>CIS countries:</strong> 3-7 business days via CDEK, Russian Post, or Yandex Delivery.<br><strong>International:</strong> 7-21 business days via DHL or UPS.',NULL,2,1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(3,'Are the products handmade?','Yes! Every piece is handcrafted in our workshop. Slight variations may occur — this confirms authenticity.',NULL,3,1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(4,'What payment methods do you accept?','We use a manual order system. After placing your order, we\'ll confirm and provide payment options via Telegram or WhatsApp.',NULL,4,1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(5,'Can I track my order?','Yes! Once shipped, you\'ll receive a tracking number via email.',NULL,5,1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(6,'Do you offer custom pieces?','Absolutely! Contact us via Telegram to discuss custom orders.',NULL,6,1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(7,'What is included with each order?','The product, a premium gift case, display stand (where applicable), and maintenance oil.',NULL,7,1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(8,'Do you have a loyalty program?','Yes! Bronze (3% after 1 order), Silver (5% after 3 orders), Gold (10% after 5 orders). Your level is permanent.',NULL,8,1,'2026-07-21 20:29:06','2026-07-21 20:29:06');

-- --------------------------------------------------------
-- Table: job_batches

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: jobs

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: media

DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint unsigned NOT NULL,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: migrations

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'2024_01_01_000001_create_products_table',1),
(3,'2024_01_01_000002_create_orders_table',1),
(4,'2024_01_01_000003_create_reviews_and_misc_table',1),
(5,'2024_01_01_000004_create_settings_and_infra_table',1),
(6,'2024_01_01_000010_add_video_url_to_products_table',1),
(7,'2024_01_01_000011_add_video_file_to_products_table',1),
(8,'2026_07_20_000001_add_region_prices_to_products_table',1),
(9,'2026_07_20_000002_drop_region_prices_from_products_table',1);

-- --------------------------------------------------------
-- Table: newsletter_subscribers

DROP TABLE IF EXISTS `newsletter_subscribers`;
CREATE TABLE `newsletter_subscribers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `unsubscribed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscribers_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: order_items

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `variant` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_index` (`order_id`),
  KEY `order_items_product_id_index` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `order_items` (`id`,`order_id`,`product_id`,`product_name`,`product_slug`,`product_image`,`quantity`,`unit_price`,`total_price`,`variant`,`created_at`,`updated_at`) VALUES
(1,1,16,'Akajiri','akajiri','products/akajiri-1.webp',1,415.00,415.00,NULL,'2026-07-21 20:35:13','2026-07-21 20:35:13');

-- --------------------------------------------------------
-- Table: orders

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reference_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `processing_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_reference_number_unique` (`reference_number`),
  KEY `orders_reference_number_index` (`reference_number`),
  KEY `orders_status_index` (`status`),
  KEY `orders_customer_email_index` (`customer_email`),
  KEY `orders_created_at_index` (`created_at`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `orders` (`id`,`reference_number`,`status`,`customer_name`,`customer_email`,`customer_phone`,`customer_country`,`customer_city`,`customer_address`,`subtotal`,`shipping_cost`,`total`,`currency`,`notes`,`ip_address`,`user_agent`,`confirmed_at`,`processing_at`,`delivered_at`,`cancelled_at`,`created_at`,`updated_at`) VALUES
(1,'YO-QTIZYNNQ','pending','Ndiambei Fabrice','fabricelemongho@gmail.com',+237676065043,'Cameroon','Yaoundé','VF4R+GM2',415.00,25.00,440.00,'USD',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0',NULL,NULL,NULL,NULL,'2026-07-21 20:35:13','2026-07-21 20:35:13');

-- --------------------------------------------------------
-- Table: page_sections

DROP TABLE IF EXISTS `page_sections`;
CREATE TABLE `page_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `data` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_sections_key_unique` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `page_sections` (`id`,`key`,`title`,`content`,`data`,`is_active`,`sort_order`,`created_at`,`updated_at`) VALUES
(1,'hero_title',NULL,'Each Blade Tells a Story',NULL,1,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(2,'hero_subtitle',NULL,'Premium Japanese collectibles forged by hand with centuries of tradition.',NULL,1,'0','2026-07-21 20:29:06','2026-07-21 20:29:06');

-- --------------------------------------------------------
-- Table: password_reset_tokens

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: personal_access_tokens

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: product_images

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_index` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=448 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `product_images` (`id`,`product_id`,`path`,`alt_text`,`sort_order`,`is_primary`,`created_at`,`updated_at`) VALUES
(1,1,'products/autumn-dragon-1.jpg','Autumn Dragon','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(2,1,'products/autumn-dragon-2.jpg','Autumn Dragon',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(3,1,'products/autumn-dragon-3.jpg','Autumn Dragon',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(4,1,'products/autumn-dragon-4.jpg','Autumn Dragon',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(5,1,'products/autumn-dragon-5.jpg','Autumn Dragon',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(6,1,'products/autumn-dragon-6.jpg','Autumn Dragon',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(7,1,'products/autumn-dragon-7.jpg','Autumn Dragon',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(8,1,'products/autumn-dragon-8.jpg','Autumn Dragon',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(9,1,'products/autumn-dragon-9.jpg','Autumn Dragon',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(10,2,'products/black-lotus-1.jpg','Black Lotus','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(11,2,'products/black-lotus-2.jpg','Black Lotus',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(12,2,'products/black-lotus-3.jpg','Black Lotus',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(13,2,'products/black-lotus-4.jpg','Black Lotus',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(14,2,'products/black-lotus-5.jpg','Black Lotus',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(15,2,'products/black-lotus-6.jpg','Black Lotus',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(16,2,'products/black-lotus-7.jpg','Black Lotus',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(17,2,'products/black-lotus-8.jpg','Black Lotus',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(18,2,'products/black-lotus-9.jpg','Black Lotus',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(19,3,'products/blue-dragon-1.jpg','Blue Dragon','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(20,3,'products/blue-dragon-2.jpg','Blue Dragon',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(21,3,'products/blue-dragon-3.jpg','Blue Dragon',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(22,3,'products/blue-dragon-4.jpg','Blue Dragon',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(23,3,'products/blue-dragon-5.jpg','Blue Dragon',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(24,3,'products/blue-dragon-6.jpg','Blue Dragon',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(25,3,'products/blue-dragon-7.jpg','Blue Dragon',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(26,3,'products/blue-dragon-8.jpg','Blue Dragon',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(27,4,'products/dragonfly-1.jpg','Dragonfly','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(28,4,'products/dragonfly-2.jpg','Dragonfly',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(29,4,'products/dragonfly-3.jpg','Dragonfly',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(30,4,'products/dragonfly-4.jpg','Dragonfly',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(31,4,'products/dragonfly-5.jpg','Dragonfly',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(32,4,'products/dragonfly-6.jpg','Dragonfly',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(33,4,'products/dragonfly-7.jpg','Dragonfly',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(34,4,'products/dragonfly-8.jpg','Dragonfly',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(35,4,'products/dragonfly-9.jpg','Dragonfly',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(36,4,'products/dragonfly-10.jpg','Dragonfly',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(37,5,'products/forest-spirit-1.jpg','Forest Spirit','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(38,5,'products/forest-spirit-2.jpg','Forest Spirit',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(39,5,'products/forest-spirit-3.jpg','Forest Spirit',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(40,5,'products/forest-spirit-4.jpg','Forest Spirit',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(41,5,'products/forest-spirit-5.jpg','Forest Spirit',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(42,5,'products/forest-spirit-6.jpg','Forest Spirit',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(43,5,'products/forest-spirit-7.jpg','Forest Spirit',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(44,5,'products/forest-spirit-8.jpg','Forest Spirit',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(45,5,'products/forest-spirit-9.jpg','Forest Spirit',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(46,6,'products/kokuryu-tanto-1.jpg','Kokuryū Tantō','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(47,6,'products/kokuryu-tanto-2.jpg','Kokuryū Tantō',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(48,6,'products/kokuryu-tanto-3.jpg','Kokuryū Tantō',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(49,6,'products/kokuryu-tanto-4.jpg','Kokuryū Tantō',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(50,6,'products/kokuryu-tanto-5.jpg','Kokuryū Tantō',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05');
INSERT INTO `product_images` (`id`,`product_id`,`path`,`alt_text`,`sort_order`,`is_primary`,`created_at`,`updated_at`) VALUES
(51,6,'products/kokuryu-tanto-6.jpg','Kokuryū Tantō',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(52,6,'products/kokuryu-tanto-7.jpg','Kokuryū Tantō',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(53,6,'products/kokuryu-tanto-8.jpg','Kokuryū Tantō',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(54,6,'products/kokuryu-tanto-9.jpg','Kokuryū Tantō',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(55,7,'products/muichiro-tokito-nichirin-1.jpg','Muichiro Tokito (Nichirin) Katana','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(56,7,'products/muichiro-tokito-nichirin-2.jpg','Muichiro Tokito (Nichirin) Katana',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(57,7,'products/muichiro-tokito-nichirin-3.jpg','Muichiro Tokito (Nichirin) Katana',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(58,7,'products/muichiro-tokito-nichirin-4.jpg','Muichiro Tokito (Nichirin) Katana',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(59,7,'products/muichiro-tokito-nichirin-5.jpg','Muichiro Tokito (Nichirin) Katana',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(60,7,'products/muichiro-tokito-nichirin-6.jpg','Muichiro Tokito (Nichirin) Katana',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(61,7,'products/muichiro-tokito-nichirin-7.jpg','Muichiro Tokito (Nichirin) Katana',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(62,7,'products/muichiro-tokito-nichirin-8.jpg','Muichiro Tokito (Nichirin) Katana',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(63,7,'products/muichiro-tokito-nichirin-9.jpg','Muichiro Tokito (Nichirin) Katana',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(64,8,'products/sea-breeze-1.jpg','Sea Breeze','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(65,8,'products/sea-breeze-2.jpg','Sea Breeze',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(66,8,'products/sea-breeze-3.jpg','Sea Breeze',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(67,8,'products/sea-breeze-4.jpg','Sea Breeze',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(68,8,'products/sea-breeze-5.jpg','Sea Breeze',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(69,8,'products/sea-breeze-6.jpg','Sea Breeze',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(70,8,'products/sea-breeze-7.jpg','Sea Breeze',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(71,8,'products/sea-breeze-8.jpg','Sea Breeze',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(72,8,'products/sea-breeze-9.jpg','Sea Breeze',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(73,9,'products/steel-storm-1.jpg','Steel Storm','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(74,9,'products/steel-storm-2.jpg','Steel Storm',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(75,9,'products/steel-storm-3.jpg','Steel Storm',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(76,9,'products/steel-storm-4.jpg','Steel Storm',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(77,9,'products/steel-storm-5.jpg','Steel Storm',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(78,9,'products/steel-storm-6.jpg','Steel Storm',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(79,9,'products/steel-storm-7.jpg','Steel Storm',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(80,9,'products/steel-storm-8.jpg','Steel Storm',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(81,9,'products/steel-storm-9.jpg','Steel Storm',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(82,9,'products/steel-storm-10.jpg','Steel Storm',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(83,10,'products/tanjiro-kamado-1.jpg','Tanjiro Kamado\'s Katana','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(84,10,'products/tanjiro-kamado-2.jpg','Tanjiro Kamado\'s Katana',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(85,10,'products/tanjiro-kamado-3.jpg','Tanjiro Kamado\'s Katana',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(86,10,'products/tanjiro-kamado-4.jpg','Tanjiro Kamado\'s Katana',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(87,10,'products/tanjiro-kamado-5.jpg','Tanjiro Kamado\'s Katana',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(88,10,'products/tanjiro-kamado-6.jpg','Tanjiro Kamado\'s Katana',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(89,10,'products/tanjiro-kamado-7.jpg','Tanjiro Kamado\'s Katana',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(90,10,'products/tanjiro-kamado-8.jpg','Tanjiro Kamado\'s Katana',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(91,10,'products/tanjiro-kamado-9.jpg','Tanjiro Kamado\'s Katana',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(92,11,'products/the-wandering-warrior-1.jpg','The Wandering Warrior','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(93,11,'products/the-wandering-warrior-2.jpg','The Wandering Warrior',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(94,11,'products/the-wandering-warrior-3.jpg','The Wandering Warrior',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(95,11,'products/the-wandering-warrior-4.jpg','The Wandering Warrior',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(96,11,'products/the-wandering-warrior-5.jpg','The Wandering Warrior',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(97,11,'products/the-wandering-warrior-6.jpg','The Wandering Warrior',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(98,11,'products/the-wandering-warrior-7.jpg','The Wandering Warrior',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(99,11,'products/the-wandering-warrior-8.jpg','The Wandering Warrior',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(100,11,'products/the-wandering-warrior-9.jpg','The Wandering Warrior',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05');
INSERT INTO `product_images` (`id`,`product_id`,`path`,`alt_text`,`sort_order`,`is_primary`,`created_at`,`updated_at`) VALUES
(101,12,'products/winged-hawk-1.jpg','Winged Hawk','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(102,12,'products/winged-hawk-2.jpg','Winged Hawk',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(103,12,'products/winged-hawk-3.jpg','Winged Hawk',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(104,12,'products/winged-hawk-4.jpg','Winged Hawk',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(105,12,'products/winged-hawk-5.jpg','Winged Hawk',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(106,12,'products/winged-hawk-6.jpg','Winged Hawk',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(107,12,'products/winged-hawk-7.jpg','Winged Hawk',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(108,12,'products/winged-hawk-8.jpg','Winged Hawk',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(109,12,'products/winged-hawk-9.jpg','Winged Hawk',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(110,12,'products/winged-hawk-10.jpg','Winged Hawk',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(111,13,'products/sanemi-shinazugawa-1.jpg','Sanemi Shinazugawa Katana','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(112,13,'products/sanemi-shinazugawa-2.jpg','Sanemi Shinazugawa Katana',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(113,13,'products/sanemi-shinazugawa-3.jpg','Sanemi Shinazugawa Katana',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(114,13,'products/sanemi-shinazugawa-4.jpg','Sanemi Shinazugawa Katana',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(115,13,'products/sanemi-shinazugawa-5.jpg','Sanemi Shinazugawa Katana',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(116,13,'products/sanemi-shinazugawa-6.jpg','Sanemi Shinazugawa Katana',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(117,13,'products/sanemi-shinazugawa-7.jpg','Sanemi Shinazugawa Katana',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(118,13,'products/sanemi-shinazugawa-8.jpg','Sanemi Shinazugawa Katana',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(119,14,'products/kokushibo-1.jpg','Kokushibo Katana','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(120,14,'products/kokushibo-2.jpg','Kokushibo Katana',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(121,14,'products/kokushibo-3.jpg','Kokushibo Katana',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(122,14,'products/kokushibo-4.jpg','Kokushibo Katana',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(123,14,'products/kokushibo-5.jpg','Kokushibo Katana',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(124,14,'products/kokushibo-6.jpg','Kokushibo Katana',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(125,14,'products/kokushibo-7.jpg','Kokushibo Katana',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(126,14,'products/kokushibo-8.jpg','Kokushibo Katana',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(127,14,'products/kokushibo-9.jpg','Kokushibo Katana',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(128,15,'products/yoriichi-tsugikuni-1.jpg','Yoriichi Tsugikuni Katana','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(129,15,'products/yoriichi-tsugikuni-2.jpg','Yoriichi Tsugikuni Katana',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(130,15,'products/yoriichi-tsugikuni-3.jpg','Yoriichi Tsugikuni Katana',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(131,15,'products/yoriichi-tsugikuni-4.jpg','Yoriichi Tsugikuni Katana',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(132,15,'products/yoriichi-tsugikuni-5.jpg','Yoriichi Tsugikuni Katana',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(133,15,'products/yoriichi-tsugikuni-6.jpg','Yoriichi Tsugikuni Katana',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(134,15,'products/yoriichi-tsugikuni-7.jpg','Yoriichi Tsugikuni Katana',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(135,15,'products/yoriichi-tsugikuni-8.jpg','Yoriichi Tsugikuni Katana',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(136,16,'products/akajiri-1.webp','Akajiri','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(137,16,'products/akajiri-2.webp','Akajiri',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(138,16,'products/akajiri-3.webp','Akajiri',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(139,16,'products/akajiri-4.webp','Akajiri',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(140,16,'products/akajiri-5.webp','Akajiri',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(141,16,'products/akajiri-6.webp','Akajiri',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(142,16,'products/akajiri-7.webp','Akajiri',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(143,16,'products/akajiri-8.webp','Akajiri',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(144,16,'products/akajiri-9.webp','Akajiri',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(145,16,'products/akajiri-10.webp','Akajiri',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(146,16,'products/akajiri-11.webp','Akajiri',10,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(147,17,'products/akiryuuto-1.webp','Akiryuuto','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(148,17,'products/akiryuuto-2.webp','Akiryuuto',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(149,17,'products/akiryuuto-3.webp','Akiryuuto',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(150,17,'products/akiryuuto-4.webp','Akiryuuto',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05');
INSERT INTO `product_images` (`id`,`product_id`,`path`,`alt_text`,`sort_order`,`is_primary`,`created_at`,`updated_at`) VALUES
(151,17,'products/akiryuuto-5.webp','Akiryuuto',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(152,17,'products/akiryuuto-6.webp','Akiryuuto',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(153,17,'products/akiryuuto-7.webp','Akiryuuto',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(154,17,'products/akiryuuto-8.webp','Akiryuuto',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(155,18,'products/bamboo-whirlwind-1.webp','Bamboo Whirlwind','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(156,18,'products/bamboo-whirlwind-2.webp','Bamboo Whirlwind',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(157,18,'products/bamboo-whirlwind-3.webp','Bamboo Whirlwind',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(158,18,'products/bamboo-whirlwind-4.webp','Bamboo Whirlwind',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(159,18,'products/bamboo-whirlwind-5.webp','Bamboo Whirlwind',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(160,18,'products/bamboo-whirlwind-6.webp','Bamboo Whirlwind',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(161,18,'products/bamboo-whirlwind-7.webp','Bamboo Whirlwind',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(162,18,'products/bamboo-whirlwind-8.webp','Bamboo Whirlwind',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(163,18,'products/bamboo-whirlwind-9.webp','Bamboo Whirlwind',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(164,18,'products/bamboo-whirlwind-10.webp','Bamboo Whirlwind',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(165,19,'products/cold-wave-1.webp','Cold Wave','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(166,19,'products/cold-wave-2.webp','Cold Wave',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(167,19,'products/cold-wave-3.webp','Cold Wave',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(168,19,'products/cold-wave-4.webp','Cold Wave',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(169,19,'products/cold-wave-5.webp','Cold Wave',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(170,19,'products/cold-wave-6.webp','Cold Wave',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(171,19,'products/cold-wave-7.webp','Cold Wave',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(172,19,'products/cold-wave-8.webp','Cold Wave',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(173,19,'products/cold-wave-9.webp','Cold Wave',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(174,20,'products/comet-1.webp','Comet','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(175,20,'products/comet-2.webp','Comet',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(176,20,'products/comet-3.webp','Comet',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(177,20,'products/comet-4.webp','Comet',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(178,20,'products/comet-5.webp','Comet',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(179,20,'products/comet-6.webp','Comet',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(180,20,'products/comet-7.webp','Comet',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(181,20,'products/comet-8.webp','Comet',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(182,20,'products/comet-9.webp','Comet',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(183,20,'products/comet-10.webp','Comet',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(184,21,'products/emperors-dragon-1.webp','Emperor\'s Dragon','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(185,21,'products/emperors-dragon-2.webp','Emperor\'s Dragon',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(186,21,'products/emperors-dragon-3.webp','Emperor\'s Dragon',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(187,21,'products/emperors-dragon-4.webp','Emperor\'s Dragon',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(188,21,'products/emperors-dragon-5.webp','Emperor\'s Dragon',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(189,21,'products/emperors-dragon-6.webp','Emperor\'s Dragon',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(190,21,'products/emperors-dragon-7.webp','Emperor\'s Dragon',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(191,21,'products/emperors-dragon-8.webp','Emperor\'s Dragon',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(192,22,'products/golden-dragon-tan-1.webp','Golden Dragon Tan','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(193,22,'products/golden-dragon-tan-2.webp','Golden Dragon Tan',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(194,22,'products/golden-dragon-tan-3.webp','Golden Dragon Tan',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(195,22,'products/golden-dragon-tan-4.webp','Golden Dragon Tan',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(196,22,'products/golden-dragon-tan-5.webp','Golden Dragon Tan',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(197,22,'products/golden-dragon-tan-6.webp','Golden Dragon Tan',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(198,22,'products/golden-dragon-tan-7.webp','Golden Dragon Tan',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(199,22,'products/golden-dragon-tan-8.webp','Golden Dragon Tan',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(200,22,'products/golden-dragon-tan-9.webp','Golden Dragon Tan',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05');
INSERT INTO `product_images` (`id`,`product_id`,`path`,`alt_text`,`sort_order`,`is_primary`,`created_at`,`updated_at`) VALUES
(201,22,'products/golden-dragon-tan-10.webp','Golden Dragon Tan',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(202,23,'products/hairyu-1.webp','Hairyu','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(203,23,'products/hairyu-2.webp','Hairyu',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(204,23,'products/hairyu-3.webp','Hairyu',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(205,23,'products/hairyu-4.webp','Hairyu',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(206,23,'products/hairyu-5.webp','Hairyu',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(207,23,'products/hairyu-6.webp','Hairyu',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(208,23,'products/hairyu-7.webp','Hairyu',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(209,23,'products/hairyu-8.webp','Hairyu',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(210,23,'products/hairyu-9.webp','Hairyu',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(211,23,'products/hairyu-10.webp','Hairyu',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(212,24,'products/hakugin-1.webp','Hakugin','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(213,24,'products/hakugin-2.webp','Hakugin',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(214,24,'products/hakugin-3.webp','Hakugin',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(215,24,'products/hakugin-4.webp','Hakugin',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(216,24,'products/hakugin-5.webp','Hakugin',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(217,24,'products/hakugin-6.webp','Hakugin',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(218,24,'products/hakugin-7.webp','Hakugin',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(219,24,'products/hakugin-8.webp','Hakugin',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(220,24,'products/hakugin-9.webp','Hakugin',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(221,24,'products/hakugin-10.webp','Hakugin',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(222,25,'products/hakurei-1.webp','Hakurei','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(223,25,'products/hakurei-2.webp','Hakurei',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(224,25,'products/hakurei-3.webp','Hakurei',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(225,25,'products/hakurei-4.webp','Hakurei',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(226,25,'products/hakurei-5.webp','Hakurei',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(227,25,'products/hakurei-6.webp','Hakurei',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(228,25,'products/hakurei-7.webp','Hakurei',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(229,25,'products/hakurei-8.webp','Hakurei',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(230,25,'products/hakurei-9.webp','Hakurei',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(231,26,'products/hanami-1.webp','Hanami','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(232,26,'products/hanami-2.webp','Hanami',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(233,26,'products/hanami-3.webp','Hanami',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(234,26,'products/hanami-4.webp','Hanami',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(235,26,'products/hanami-5.webp','Hanami',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(236,26,'products/hanami-6.webp','Hanami',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(237,26,'products/hanami-7.webp','Hanami',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(238,26,'products/hanami-8.webp','Hanami',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(239,26,'products/hanami-9.webp','Hanami',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(240,27,'products/hoshikage-1.webp','Hoshikage','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(241,27,'products/hoshikage-2.webp','Hoshikage',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(242,27,'products/hoshikage-3.webp','Hoshikage',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(243,27,'products/hoshikage-4.webp','Hoshikage',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(244,27,'products/hoshikage-5.webp','Hoshikage',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(245,27,'products/hoshikage-6.webp','Hoshikage',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(246,27,'products/hoshikage-7.webp','Hoshikage',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(247,27,'products/hoshikage-8.webp','Hoshikage',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(248,28,'products/hosina-1.webp','Hosina','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(249,28,'products/hosina-2.webp','Hosina',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(250,28,'products/hosina-3.webp','Hosina',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05');
INSERT INTO `product_images` (`id`,`product_id`,`path`,`alt_text`,`sort_order`,`is_primary`,`created_at`,`updated_at`) VALUES
(251,28,'products/hosina-4.webp','Hosina',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(252,28,'products/hosina-5.webp','Hosina',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(253,28,'products/hosina-6.webp','Hosina',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(254,28,'products/hosina-7.webp','Hosina',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(255,28,'products/hosina-8.webp','Hosina',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(256,28,'products/hosina-9.webp','Hosina',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(257,29,'products/kagedoku-1.webp','Kagedoku','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(258,29,'products/kagedoku-2.webp','Kagedoku',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(259,29,'products/kagedoku-3.webp','Kagedoku',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(260,29,'products/kagedoku-4.webp','Kagedoku',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(261,29,'products/kagedoku-5.webp','Kagedoku',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(262,29,'products/kagedoku-6.webp','Kagedoku',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(263,29,'products/kagedoku-7.webp','Kagedoku',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(264,29,'products/kagedoku-8.webp','Kagedoku',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(265,29,'products/kagedoku-9.webp','Kagedoku',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(266,30,'products/kairyu-1.webp','Kairyu','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(267,30,'products/kairyu-2.webp','Kairyu',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(268,30,'products/kairyu-3.webp','Kairyu',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(269,30,'products/kairyu-4.webp','Kairyu',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(270,30,'products/kairyu-5.webp','Kairyu',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(271,30,'products/kairyu-6.webp','Kairyu',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(272,30,'products/kairyu-7.webp','Kairyu',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(273,30,'products/kairyu-8.webp','Kairyu',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(274,30,'products/kairyu-9.webp','Kairyu',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(275,30,'products/kairyu-10.webp','Kairyu',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(276,31,'products/kaisen-1.webp','Kaisen','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(277,31,'products/kaisen-2.webp','Kaisen',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(278,31,'products/kaisen-3.webp','Kaisen',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(279,31,'products/kaisen-4.webp','Kaisen',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(280,31,'products/kaisen-5.webp','Kaisen',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(281,31,'products/kaisen-6.webp','Kaisen',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(282,31,'products/kaisen-7.webp','Kaisen',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(283,31,'products/kaisen-8.webp','Kaisen',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(284,32,'products/katana-stand-1.webp','Katana Stand','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(285,32,'products/katana-stand-2.webp','Katana Stand',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(286,32,'products/katana-stand-3.webp','Katana Stand',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(287,32,'products/katana-stand-4.webp','Katana Stand',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(288,33,'products/kinmei-1.webp','Kinmei','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(289,33,'products/kinmei-2.webp','Kinmei',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(290,33,'products/kinmei-3.webp','Kinmei',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(291,33,'products/kinmei-4.webp','Kinmei',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(292,33,'products/kinmei-5.webp','Kinmei',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(293,33,'products/kinmei-6.webp','Kinmei',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(294,33,'products/kinmei-7.webp','Kinmei',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(295,33,'products/kinmei-8.webp','Kinmei',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(296,33,'products/kinmei-9.webp','Kinmei',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(297,33,'products/kinmei-10.webp','Kinmei',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(298,34,'products/kinsai-1.webp','Kinsai','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(299,34,'products/kinsai-2.webp','Kinsai',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(300,34,'products/kinsai-3.webp','Kinsai',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05');
INSERT INTO `product_images` (`id`,`product_id`,`path`,`alt_text`,`sort_order`,`is_primary`,`created_at`,`updated_at`) VALUES
(301,34,'products/kinsai-4.webp','Kinsai',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(302,34,'products/kinsai-5.webp','Kinsai',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(303,34,'products/kinsai-6.webp','Kinsai',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(304,34,'products/kinsai-7.webp','Kinsai',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(305,34,'products/kinsai-8.webp','Kinsai',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(306,34,'products/kinsai-9.webp','Kinsai',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(307,34,'products/kinsai-10.webp','Kinsai',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(308,35,'products/longsword-1.webp','Longsword','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(309,35,'products/longsword-2.webp','Longsword',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(310,35,'products/longsword-3.webp','Longsword',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(311,35,'products/longsword-4.webp','Longsword',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(312,35,'products/longsword-5.webp','Longsword',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(313,35,'products/longsword-6.webp','Longsword',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(314,35,'products/longsword-7.webp','Longsword',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(315,35,'products/longsword-8.webp','Longsword',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(316,36,'products/midori-ryu-1.webp','Midori-ryu','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(317,36,'products/midori-ryu-2.webp','Midori-ryu',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(318,36,'products/midori-ryu-3.webp','Midori-ryu',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(319,36,'products/midori-ryu-4.webp','Midori-ryu',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(320,36,'products/midori-ryu-5.webp','Midori-ryu',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(321,36,'products/midori-ryu-6.webp','Midori-ryu',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(322,36,'products/midori-ryu-7.webp','Midori-ryu',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(323,36,'products/midori-ryu-8.webp','Midori-ryu',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(324,36,'products/midori-ryu-9.webp','Midori-ryu',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(325,37,'products/mizutori-1.webp','Mizutori','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(326,37,'products/mizutori-2.webp','Mizutori',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(327,37,'products/mizutori-3.webp','Mizutori',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(328,37,'products/mizutori-4.webp','Mizutori',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(329,37,'products/mizutori-5.webp','Mizutori',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(330,37,'products/mizutori-6.webp','Mizutori',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(331,37,'products/mizutori-7.webp','Mizutori',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(332,37,'products/mizutori-8.webp','Mizutori',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(333,37,'products/mizutori-9.webp','Mizutori',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(334,37,'products/mizutori-10.webp','Mizutori',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(335,38,'products/musei-1.webp','Musei','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(336,38,'products/musei-2.webp','Musei',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(337,38,'products/musei-3.webp','Musei',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(338,38,'products/musei-4.webp','Musei',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(339,38,'products/musei-5.webp','Musei',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(340,38,'products/musei-6.webp','Musei',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(341,38,'products/musei-7.webp','Musei',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(342,38,'products/musei-8.webp','Musei',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(343,38,'products/musei-9.webp','Musei',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(344,38,'products/musei-10.webp','Musei',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(345,39,'products/roar-of-the-tiger-1.webp','Roar of the Tiger','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(346,39,'products/roar-of-the-tiger-2.webp','Roar of the Tiger',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(347,39,'products/roar-of-the-tiger-3.webp','Roar of the Tiger',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(348,39,'products/roar-of-the-tiger-4.webp','Roar of the Tiger',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(349,39,'products/roar-of-the-tiger-5.webp','Roar of the Tiger',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(350,39,'products/roar-of-the-tiger-6.webp','Roar of the Tiger',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05');
INSERT INTO `product_images` (`id`,`product_id`,`path`,`alt_text`,`sort_order`,`is_primary`,`created_at`,`updated_at`) VALUES
(351,39,'products/roar-of-the-tiger-7.webp','Roar of the Tiger',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(352,39,'products/roar-of-the-tiger-8.webp','Roar of the Tiger',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(353,39,'products/roar-of-the-tiger-9.webp','Roar of the Tiger',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(354,40,'products/ruiin-1.webp','Ruiin','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(355,40,'products/ruiin-2.webp','Ruiin',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(356,40,'products/ruiin-3.webp','Ruiin',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(357,40,'products/ruiin-4.webp','Ruiin',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(358,40,'products/ruiin-5.webp','Ruiin',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(359,40,'products/ruiin-6.webp','Ruiin',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(360,40,'products/ruiin-7.webp','Ruiin',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(361,40,'products/ruiin-8.webp','Ruiin',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(362,40,'products/ruiin-9.webp','Ruiin',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(363,40,'products/ruiin-10.webp','Ruiin',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(364,41,'products/ryusei-1.webp','Ryusei','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(365,41,'products/ryusei-2.webp','Ryusei',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(366,41,'products/ryusei-3.webp','Ryusei',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(367,41,'products/ryusei-4.webp','Ryusei',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(368,41,'products/ryusei-5.webp','Ryusei',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(369,41,'products/ryusei-6.webp','Ryusei',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(370,41,'products/ryusei-7.webp','Ryusei',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(371,41,'products/ryusei-8.webp','Ryusei',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(372,41,'products/ryusei-9.webp','Ryusei',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(373,42,'products/seika-1.webp','Seika','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(374,42,'products/seika-2.webp','Seika',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(375,42,'products/seika-3.webp','Seika',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(376,42,'products/seika-4.webp','Seika',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(377,42,'products/seika-5.webp','Seika',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(378,42,'products/seika-6.webp','Seika',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(379,42,'products/seika-7.webp','Seika',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(380,42,'products/seika-8.webp','Seika',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(381,42,'products/seika-9.webp','Seika',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(382,42,'products/seika-10.webp','Seika',9,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(383,43,'products/seiryu-1.webp','Seiryu','0',1,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(384,43,'products/seiryu-2.webp','Seiryu',1,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(385,43,'products/seiryu-3.webp','Seiryu',2,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(386,43,'products/seiryu-4.webp','Seiryu',3,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(387,43,'products/seiryu-5.webp','Seiryu',4,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(388,43,'products/seiryu-6.webp','Seiryu',5,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(389,43,'products/seiryu-7.webp','Seiryu',6,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(390,43,'products/seiryu-8.webp','Seiryu',7,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(391,43,'products/seiryu-9.webp','Seiryu',8,'0','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(392,44,'products/shinei-1.webp','Shin\'ei','0',1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(393,44,'products/shinei-2.webp','Shin\'ei',1,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(394,44,'products/shinei-3.webp','Shin\'ei',2,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(395,44,'products/shinei-4.webp','Shin\'ei',3,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(396,44,'products/shinei-5.webp','Shin\'ei',4,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(397,44,'products/shinei-6.webp','Shin\'ei',5,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(398,44,'products/shinei-7.webp','Shin\'ei',6,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(399,44,'products/shinei-8.webp','Shin\'ei',7,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(400,44,'products/shinei-9.webp','Shin\'ei',8,'0','2026-07-21 20:29:06','2026-07-21 20:29:06');
INSERT INTO `product_images` (`id`,`product_id`,`path`,`alt_text`,`sort_order`,`is_primary`,`created_at`,`updated_at`) VALUES
(401,45,'products/shirokawa-1.webp','Shirokawa','0',1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(402,45,'products/shirokawa-2.webp','Shirokawa',1,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(403,45,'products/shirokawa-3.webp','Shirokawa',2,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(404,45,'products/shirokawa-4.webp','Shirokawa',3,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(405,45,'products/shirokawa-5.webp','Shirokawa',4,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(406,45,'products/shirokawa-6.webp','Shirokawa',5,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(407,45,'products/shirokawa-7.webp','Shirokawa',6,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(408,45,'products/shirokawa-8.webp','Shirokawa',7,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(409,45,'products/shirokawa-9.webp','Shirokawa',8,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(410,45,'products/shirokawa-10.webp','Shirokawa',9,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(411,45,'products/shirokawa-11.webp','Shirokawa',10,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(412,46,'products/suzume-1.webp','Suzume','0',1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(413,46,'products/suzume-2.webp','Suzume',1,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(414,46,'products/suzume-3.webp','Suzume',2,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(415,46,'products/suzume-4.webp','Suzume',3,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(416,46,'products/suzume-5.webp','Suzume',4,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(417,46,'products/suzume-6.webp','Suzume',5,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(418,46,'products/suzume-7.webp','Suzume',6,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(419,46,'products/suzume-8.webp','Suzume',7,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(420,47,'products/tenma-1.webp','Tenma','0',1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(421,47,'products/tenma-2.webp','Tenma',1,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(422,47,'products/tenma-3.webp','Tenma',2,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(423,47,'products/tenma-4.webp','Tenma',3,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(424,47,'products/tenma-5.webp','Tenma',4,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(425,47,'products/tenma-6.webp','Tenma',5,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(426,47,'products/tenma-7.webp','Tenma',6,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(427,47,'products/tenma-8.webp','Tenma',7,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(428,47,'products/tenma-9.webp','Tenma',8,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(429,48,'products/tokiwa-1.webp','Tokiwa','0',1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(430,48,'products/tokiwa-2.webp','Tokiwa',1,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(431,48,'products/tokiwa-3.webp','Tokiwa',2,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(432,48,'products/tokiwa-4.webp','Tokiwa',3,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(433,48,'products/tokiwa-5.webp','Tokiwa',4,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(434,48,'products/tokiwa-6.webp','Tokiwa',5,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(435,48,'products/tokiwa-7.webp','Tokiwa',6,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(436,48,'products/tokiwa-8.webp','Tokiwa',7,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(437,48,'products/tokiwa-9.webp','Tokiwa',8,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(438,48,'products/tokiwa-10.webp','Tokiwa',9,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(439,49,'products/uguisu-1.webp','Uguisu','0',1,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(440,49,'products/uguisu-2.webp','Uguisu',1,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(441,49,'products/uguisu-3.webp','Uguisu',2,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(442,49,'products/uguisu-4.webp','Uguisu',3,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(443,49,'products/uguisu-5.webp','Uguisu',4,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(444,49,'products/uguisu-6.webp','Uguisu',5,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(445,49,'products/uguisu-7.webp','Uguisu',6,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(446,49,'products/uguisu-8.webp','Uguisu',7,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(447,49,'products/uguisu-9.webp','Uguisu',8,'0','2026-07-21 20:29:06','2026-07-21 20:29:06');

-- --------------------------------------------------------
-- Table: product_tags

DROP TABLE IF EXISTS `product_tags`;
CREATE TABLE `product_tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `tag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_tags_product_id_index` (`product_id`),
  KEY `product_tags_tag_index` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: product_variants

DROP TABLE IF EXISTS `product_variants`;
CREATE TABLE `product_variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_modifier` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_variants_product_id_index` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: products

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `compare_at_price` decimal(10,2) DEFAULT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `in_stock` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_bestseller` tinyint(1) NOT NULL DEFAULT '0',
  `is_new` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `sales_count` int NOT NULL DEFAULT '0',
  `views_count` int NOT NULL DEFAULT '0',
  `weight` int DEFAULT NULL COMMENT 'Weight in grams',
  `length` int DEFAULT NULL COMMENT 'Length in cm',
  `material` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `steel_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `construction` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hardness_hrc` decimal(4,1) DEFAULT NULL,
  `blade_length` decimal(6,1) DEFAULT NULL,
  `overall_length` decimal(6,1) DEFAULT NULL,
  `blade_width` decimal(4,1) DEFAULT NULL,
  `blade_thickness` decimal(4,1) DEFAULT NULL,
  `handle_material` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scabbard_material` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint unsigned NOT NULL,
  `brand_id` bigint unsigned DEFAULT NULL,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `og_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_slug_index` (`slug`),
  KEY `products_category_id_index` (`category_id`),
  KEY `products_brand_id_index` (`brand_id`),
  KEY `products_is_featured_index` (`is_featured`),
  KEY `products_is_bestseller_index` (`is_bestseller`),
  KEY `products_is_new_index` (`is_new`),
  KEY `products_is_active_index` (`is_active`),
  KEY `products_price_index` (`price`),
  KEY `products_created_at_index` (`created_at`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`id`,`name`,`slug`,`short_description`,`description`,`price`,`compare_at_price`,`cost_price`,`sku`,`stock`,`in_stock`,`is_featured`,`is_bestseller`,`is_new`,`is_active`,`sort_order`,`sales_count`,`views_count`,`weight`,`length`,`material`,`steel_type`,`construction`,`hardness_hrc`,`blade_length`,`overall_length`,`blade_width`,`blade_thickness`,`handle_material`,`scabbard_material`,`category_id`,`brand_id`,`meta_title`,`meta_description`,`og_image`,`video_url`,`video_file`,`created_at`,`updated_at`) VALUES
(1,'Autumn Dragon','autumn-dragon','Hand-forged T10 high-carbon steel katana (103 cm) with differential clay tempering and natural wavy hamon. Full tang, hand-polished satin finish. Includes stand, gift case, and maintenance oil.','<p>The "Autumn Dragon" katana combines traditional Japanese aesthetics with modern craftsmanship. The blade is hand-forged from high-carbon T10 steel and has undergone differential clay tempering, resulting in a natural, wavy hamon pattern on the edge. The blade\'s surface has been hand-polished to a refined satin finish.</p><p>The full-tang construction ensures high strength and reliability. The handle is wrapped in traditional brown ito cord over natural skate leather (same-gawa), providing a secure grip. The tsuba is made of steel with a classic Japanese ornamentation, and the habaki is made of brass with a floral pattern. The scabbard is made of lacquered wood and features a brown sageo cord.</p>',270.00,NULL,NULL,'KTN-AD-001',3,1,1,1,1,1,'0','0','0',1300,NULL,'T10 High Carbon Steel','T10 High Carbon Steel','Full Tang',60.0,71.0,103.0,3.2,NULL,'Wood, Natural stingray leather (Samegawa), Brown Ito','Lacquered wood',1,1,'Autumn Dragon Katana — T10 Steel, 103cm | Kitsuneoni','Hand-forged T10 steel katana with differential clay tempering and natural wavy hamon. Full tang, 103 cm. Premium collectible with stand and gift case.',NULL,'','products/videos/autumn-dragon.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(2,'Black Lotus','black-lotus','Damascus steel tanto (55 cm) with multi-layered pattern, approx. 60 HRC. Full tang, hand-polished. Includes stand, gift case, and care oil.','<p>The "Black Lotus" tanto combines traditional Japanese style with modern, hand-forged quality. The blade is made of multi-layered Damascus steel with a striking natural pattern and is hardened to a hardness of approximately 60 HRC, ensuring high strength, excellent wear resistance, and durability.</p><p>The full-tang construction gives the knife superb reliability and balance. The handle is made of wood with a stingray leather-like finish and traditional Japanese braiding. The tsuba is made of iron with an openwork design, and the habaki is made of brass with decorative grooves. The sheath is made of solid wood with a black lacquer finish. Each tanto is hand-assembled.</p>',215.00,NULL,NULL,'TNT-BL-001',7,1,1,'0',1,1,'0','0','0',720,NULL,'Multi-layered Damascus Steel','Damascus Steel','Full Tang',60.0,33.0,55.0,3.2,NULL,'Wood, Faux stingray leather, Traditional Japanese wrapping','Solid wood, Black lacquer finish',3,1,'Black Lotus Tanto — Damascus Steel, 55cm | Kitsuneoni','Hand-forged Damascus steel tanto with multi-layered pattern. Approx. 60 HRC, full tang, 55 cm. Premium collectible with stand and gift case.',NULL,'','products/videos/black-lotus.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(3,'Blue Dragon','blue-dragon','One-of-a-kind T10 tool steel katana (103 cm) with differential clay tempering, 60 HRC, and mirror polish. Blue dragon engraving on lacquered saya.','<p>The Blue Dragon is a one-of-a-kind auction-grade katana, crafted separately from the main collection with individual hand-finishing and additional quality control. The blade is hand-forged from T10 tool steel with differential clay tempering, achieving a cutting edge hardness of 60 HRC with a natural wavy hamon. Hand-polished to a mirror finish.</p><p>The tsuba features openwork design in nickel silver (white copper) with a decorative finish. The tsuka is wrapped in blue cotton cord over natural stingray leather with decorative menuki. The saya is crafted from hard mountain wood with multi-layered black lacquer and an artistic engraving of a blue dragon. All fittings are brass with a decorative antique gold finish.</p>',720.00,NULL,NULL,'KTN-BD-001',12,1,1,'0',1,1,'0','0','0',1100,NULL,'T10 Tool Steel','T10 Tool Steel','Full Tang',60.0,72.0,103.0,3.2,NULL,'Wood, Natural stingray leather, Blue cotton wrapping, Decorative menuki','Hard mountain wood, Multi-layered black lacquer, Blue dragon engraving',1,1,'Blue Dragon Katana — One-of-a-Kind T10 Steel | Kitsuneoni','One-of-a-kind T10 tool steel katana with blue dragon saya engraving. 60 HRC, mirror polish, 103 cm. Premium collectible with wooden case and stand.',NULL,'','products/videos/blue-dragon.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(4,'Dragonfly','dragonfly','T10 high-carbon steel tanto (55 cm) with differential clay tempering and natural hamon. Hand-polished, brass habaki, brown ito wrapping.','<p>The Yamagata "Dragonfly" Tanto is a compact Japanese blade crafted in the traditional style. The blade is handcrafted from high-carbon T10 steel and has undergone differential clay-hardened tempering, which creates a natural hamon line on the blade. Hand polishing accentuates the blade\'s geometry and its mirror-like shine.</p><p>The handle is wrapped in traditional brown ito cord over natural skate leather (same-gawa). The tsuba and decorative fittings are made of zinc alloy with golden dragonfly motifs. The scabbard is made of lacquered natural wood with an artistic black-and-gold pattern and is complemented by a brown sageo cord.</p>',420.00,NULL,NULL,'TNT-DF-001',5,1,1,'0',1,1,'0','0','0',650,NULL,'T10 High Carbon Steel','T10 High Carbon Steel','Full Tang',NULL,33.0,55.0,3.2,NULL,'Wood, Natural stingray leather (Samegawa), Brown Ito','Lacquered wood',3,1,'Dragonfly Tanto — T10 Steel, 55cm | Kitsuneoni','T10 high-carbon steel tanto with differential clay tempering and natural hamon. 55 cm, hand-polished, premium collectible.',NULL,'','products/videos/dragonfly.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(5,'Forest Spirit','forest-spirit','Multi-layered Damascus steel tanto (53 cm) with green lacquered sheath and decorative metal fittings. Hand-forged and hand-polished.','<p>The "Forest Spirit" tanto is crafted in the traditional Japanese style with striking green lacquered sheaths and decorative metal fittings. The blade is made of multi-layered Damascus steel using a hand-forging method; it features a natural pattern and is characterized by high strength, excellent edge retention, and durability.</p><p>The handle is made of wood with a stingray leather-like finish and traditional Japanese wrapping. The tsuba is made of a decorative metal alloy with a classic ornamentation, and the habaki is adorned with a relief pattern. The scabbard is made of solid wood with a green lacquer finish and decorative carving. Each tanto is assembled by hand.</p>',225.00,NULL,NULL,'TNT-FS-001',18,1,1,'0',1,1,'0','0','0',600,NULL,'Multi-layered Damascus Steel','Damascus Steel','Full Tang',NULL,33.0,53.0,3.2,NULL,'Wood, Imitation stingray leather, Traditional Japanese wrapping','Solid wood, Green lacquer finish with decorative ornamentation',3,1,'Forest Spirit Tanto — Damascus Steel, 53cm | Kitsuneoni','Hand-forged Damascus steel tanto with green lacquered sheath. 53 cm, hand-polished, premium collectible with stand and gift case.',NULL,'','products/videos/forest-spirit.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(6,'Kokuryū Tantō','kokuryu-tanto','Multi-layered Damascus steel tantō (55 cm) with artistic dragon tsuba. ~60 HRC, hand-polished, black braided wrap. Includes stand and gift box.','<p>The Yamagata Kokuryū Tantō is a compact Japanese sword that combines traditional aesthetics with exceptional durability. The blade is crafted from multi-layered Damascus steel that has undergone repeated forging, resulting in a hardness of approximately 60 HRC, high elasticity, and a distinctive steel pattern. The full-tang construction ensures reliability and durability.</p><p>The handle is made of wood with natural stingray leather and traditional black braiding. The tsuba is made of metal and features an artistic depiction of a dragon. The scabbard is crafted from solid wood with black-and-red lacquered carvings and decorative cord. Entirely hand-assembled.</p>',255.00,NULL,NULL,'TNT-KT-001',9,1,1,'0',1,1,'0','0','0',760,NULL,'Multi-layered Damascus Steel','Damascus Steel','Full Tang',60.0,33.0,55.0,3.2,NULL,'Wood, Genuine stingray leather, Black braided wrap','Solid wood, Black-and-red lacquered carvings',3,1,'Kokuryū Tantō — Damascus Steel, 55cm | Kitsuneoni','Hand-forged Damascus steel tantō with artistic dragon tsuba. ~60 HRC, 55 cm, hand-polished. Premium collectible with stand and gift box.',NULL,'','products/videos/kokuryu-tanto.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(7,'Muichiro Tokito (Nichirin) Katana','muichiro-tokito-nichirin','Demon Slayer-inspired katana (105 cm) with matte black blade, geometric gold tsuba, and blue diamond handle pattern. 1045 carbon steel.','<p>The Muichiro Tokito katana is modeled after the legendary "Pillar of Mist" sword from the anime Demon Slayer. This model faithfully replicates the signature design of the original weapon: a matte black blade, a geometric gold tsuba, a handle with traditional black wrapping and blue diamond patterns, and a classic black wooden scabbard with gold-plated fittings.</p><p>The blade is made of 1045 carbon steel with a decorative surface finish. The full-tang construction ensures strength and reliability. The tsuba is made of a metal alloy, and the habaki has a brass coating. The handle is made of wood with traditional Japanese wrapping, and the scabbard is made of solid wood with a matte black lacquer finish. Each katana is assembled by hand.</p>',230.00,NULL,NULL,'KTN-MT-001',2,1,1,'0',1,1,'0','0','0',950,NULL,'1045 Carbon Steel','1045 Carbon Steel','Full Tang',53.0,72.0,105.0,3.2,NULL,'Wood, Faux stingray leather, Traditional Japanese wrapping','Solid wood, Matte black lacquer finish',1,1,'Muichiro Tokito (Nichirin) Katana — 105cm | Kitsuneoni','Demon Slayer-inspired Muichiro Tokito katana. 1045 carbon steel, full tang, 105 cm. Premium collectible with stand and gift box.',NULL,'','products/videos/muichiro-tokito-nichirin.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(8,'Sea Breeze','sea-breeze','T10 steel katana (102 cm) with differential clay tempering and straight hamon. Hand-engraved dragon motifs, dark blue wrapping. Premium collectible.','<p>The "Sea Breeze" katana is inspired by the tranquility of the ocean and Japanese sword-making tradition. The blade is crafted from high-quality T10 steel with differential clay-tempering and a straight hamon line. The blade\'s surface is adorned with hand-engraved dragon motifs and polished by hand.</p><p>The full-tang construction ensures high strength and excellent balance. The handle is made of wood, covered with genuine stingray leather, and wrapped in dark blue cord. The habaki is made of brass with embossed dragon engraving. The tsuba is made of iron, and the fittings are made of iron and a zinc alloy. The scabbard is made of solid wood with a lacquer finish. Hand-assembled.</p>',506.00,NULL,NULL,'KTN-SB-001',14,1,1,'0',1,1,'0','0','0',1100,NULL,'T10 Steel','T10 Steel','Full Tang',NULL,72.0,102.0,3.2,NULL,'Wood, Genuine stingray leather, Dark blue wrapping','Solid wood, Lacquer finish',1,1,'Sea Breeze Katana — T10 Steel, 102cm | Kitsuneoni','T10 steel katana with hand-engraved dragon motifs and straight hamon. 102 cm, full tang, premium collectible with stand and gift case.',NULL,'','products/videos/sea-breeze.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(9,'Steel Storm','steel-storm','Multi-layered Damascus steel katana (103.5 cm) with all-metal hilt and scabbard. Solid-forged construction, hand-polished, 1.4 kg.','<p>The "Steel Storm" katana combines a minimalist, modern design with traditional Japanese craftsmanship. The blade is made of multi-layered Damascus steel with a striking pattern across its entire surface and is forged as a single, solid piece. The all-metal hilt is decorated with embossed ornamentation and ensures high durability.</p><p>The scabbard is made of metal with a wear-resistant lacquer coating. The habaki is made of brass, while the tsuba and all other fittings are made of a metal alloy. The sword is entirely hand-assembled.</p>',305.00,NULL,NULL,'KTN-SS-001',6,1,1,'0',1,1,'0','0','0',1400,NULL,'Multi-layered Damascus Steel','Damascus Steel','Full Tang',NULL,65.5,103.5,3.2,NULL,'All-metal, cast with embossed ornamentation','All-metal, painted with wear-resistant lacquer',1,1,'Steel Storm Katana — Damascus Steel, 103.5cm | Kitsuneoni','Multi-layered Damascus steel katana with all-metal hilt and scabbard. 103.5 cm, solid-forged, premium collectible with stand and gift case.',NULL,'',NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(10,'Tanjiro Kamado\'s Katana','tanjiro-kamados-katana','Demon Slayer-inspired katana (105 cm) with decorative 1045 carbon steel blade. Red handle wrap, black scabbard. Full tang.','<p>The Tanjiro Kamado Katana (#1) is modeled after the main character\'s first sword from the anime Demon Slayer. The blade is made of 1045 carbon steel with a decorative surface finish. The full-tang construction ensures strength and durability.</p><p>The tsuba is made of a metal alloy, and the habaki has a brass coating. The handle is made of wood with red stingray leather imitation and traditional Japanese wrapping. The scabbard is made of solid wood with a matte black finish. Each katana is assembled by hand.</p>',230.00,NULL,NULL,'KTN-TK-001',21,1,1,'0',1,1,'0','0','0',950,NULL,'1045 Carbon Steel','1045 Carbon Steel','Full Tang',53.0,72.0,105.0,3.2,NULL,'Wood, Red stingray leather imitation, Traditional Japanese wrapping','Solid wood, Matte black finish',1,1,'Tanjiro Kamado\'s Katana — 105cm | Kitsuneoni','Demon Slayer Tanjiro Kamado katana replica. 1045 carbon steel, full tang, 105 cm. Premium collectible with stand and gift box.',NULL,'','products/videos/tanjiro-kamado.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(11,'The Wandering Warrior','the-wandering-warrior','T10 high-carbon steel ko-tanto (51 cm) with differential clay tempering and wavy hamon. Solid ebony handle and sheath, brass fittings.','<p>The "Wandering Warrior" tanto is crafted in the classic Japanese style and combines traditional aesthetics with high-quality craftsmanship. The blade is made of high-carbon T10 steel and has undergone differential clay tempering, resulting in a distinctive wavy hamon pattern on the edge. The blade is hand-polished to a satin finish.</p><p>The full-tang construction ensures the knife\'s strength and durability. The handle is crafted from solid ebony without traditional wrapping, emphasizing the model\'s minimalist style. The habaki and decorative fittings are made of brass. The sheath is also crafted from solid ebony and features a black sageo cord. Each piece is assembled by hand.</p>',355.00,NULL,NULL,'TNT-WW-001',4,1,1,'0',1,1,'0','0','0',550,NULL,'T10 High Carbon Steel','T10 High Carbon Steel','Full Tang',NULL,33.0,51.0,3.2,NULL,'Solid ebony','Solid ebony',3,1,'The Wandering Warrior Tanto — T10 Steel, 51cm | Kitsuneoni','T10 high-carbon steel ko-tanto with ebony handle and sheath. 51 cm, wavy hamon, hand-polished. Premium collectible with stand and gift case.',NULL,'','products/videos/the-wandering-warrior.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(12,'Winged Hawk','winged-hawk','1060 high-carbon steel tachi (103.5 cm) with oil quenching and hand-polished finish. White-lacquered sheath, black traditional braiding.','<p>The "Winged Hawk" Tachi is crafted in the classic Japanese style and combines historical aesthetics with a reliable modern design. The blade is made of high-carbon 1060 steel, oil-hardened, and hand-polished, giving it excellent strength, elasticity, and precise geometry.</p><p>The full-tang construction ensures high reliability and proper balance. The handle is made of wood, covered with natural stingray leather, and wrapped in traditional black cord. The habaki is made of brass, while the tsuba and decorative fittings are made of zinc alloy with an artistic finish. The white-lacquered sheath, crafted from solid wood, is complemented by a traditional tachi suspension. Each piece is hand-assembled.</p>',305.00,NULL,NULL,'TCH-WH-001',11,1,1,'0',1,1,'0','0','0',1100,NULL,'1060 High Carbon Steel','1060 High Carbon Steel','Full Tang',NULL,72.5,103.5,3.2,NULL,'Wood, Natural stingray leather, Black traditional braiding','Solid wood, White lacquer finish',1,1,'Winged Hawk Tachi — 1060 Steel, 103.5cm | Kitsuneoni','1060 high-carbon steel tachi with white-lacquered sheath. 103.5 cm, oil-hardened, hand-polished. Premium collectible with stand and gift case.',NULL,'',NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(13,'Sanemi Shinazugawa Katana','sanemi-shinazugawa-katana','Demon Slayer-inspired katana (105 cm) with black blade with green wave pattern. 1045 carbon steel, full tang. Includes stand and gift case.','<p>The Sanemi Shinazugawa katana is modeled after the Wind Pillar\'s weapon from the anime "Demon Slayer." The model features a black blade with a green wavy pattern along the cutting edge, black wooden scabbard with a white camouflage pattern, and the signature eight-spoked tsuba.</p><p>The handle is made of wood with traditional Japanese wrapping in a white-and-green color scheme. The blade is crafted from 1045 carbon steel with a decorative surface finish. The full-tang construction ensures durability, and each katana is assembled by hand.</p>',230.00,NULL,NULL,'KTN-SS-002',8,1,1,'0',1,1,'0','0','0',950,NULL,'1045 Carbon Steel','1045 Carbon Steel','Full Tang',53.0,72.0,105.0,3.2,NULL,'Wood, Traditional Japanese wrapping, White-and-green scheme','Solid wood, Decorative finish with white camouflage pattern',1,1,'Sanemi Shinazugawa Katana — 105cm | Kitsuneoni','Demon Slayer Sanemi Shinazugawa katana replica. 1045 carbon steel, full tang, 105 cm. Premium collectible with stand and gift case.',NULL,'','products/videos/sanemi-shinazugawa.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(14,'Kokushibo Katana','kokushibo-katana','Demon Slayer-inspired katana (105 cm) with multi-eye blade pattern, pink scabbard, and purple tsuba. 1045 carbon steel, full tang.','<p>The Kokushibo katana is modeled after the legendary demonic sword of Upper Moon I from the anime "Demon Slayer." The model combines a recognizable blade with a decorative pattern of multiple eyes, a pink wooden scabbard featuring the brand\'s signature ornamentation, a purple sculpted tsuba, and a handle with dark green traditional Japanese wrapping.</p><p>Underneath the wrapping is a pink imitation stingray leather inlay, giving the handle its distinctive appearance. The blade is made of 1045 carbon steel with a decorative surface finish. The full-tang construction ensures strength and reliability. Each katana is assembled by hand.</p>',230.00,NULL,NULL,'KTN-KK-001',16,1,1,'0',1,1,'0','0','0',950,NULL,'1045 Carbon Steel','1045 Carbon Steel','Full Tang',53.0,72.0,105.0,3.2,NULL,'Wood, Pink stingray leather imitation, Dark green traditional wrapping','Solid wood, Decorative finish',1,1,'Kokushibo Katana — 105cm | Kitsuneoni','Demon Slayer Kokushibo katana replica with eye pattern blade. 1045 carbon steel, full tang, 105 cm. Premium collectible with stand and gift case.',NULL,'','products/videos/kokushibo.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(15,'Yoriichi Tsugikuni Katana','yoriichi-tsugikuni-katana','Demon Slayer-inspired katana (105 cm) with black blade with fiery red pattern. 1045 carbon steel, full tang, gold-plated fittings.','<p>The Yoriichi Tsugikuni Katana is modeled after the legendary sword of the universe\'s greatest swordsman, "The Blade That Slays Demons." This model faithfully reproduces the distinctive appearance of the original blade: a black blade with a fiery red pattern, a sleek black saya with gold-plated fittings, and a handle wrapped in traditional light-gold cord.</p><p>The blade is made of 1045 carbon steel with a decorative surface finish. The guard is made of a metal alloy, and the habaki has a brass coating. The handle is made of wood with traditional Japanese wrapping, and the scabbard is made of solid wood with a matte black lacquer finish. Each katana is assembled by hand.</p>',230.00,NULL,NULL,'KTN-YT-001',25,1,1,'0',1,1,'0','0','0',950,NULL,'1045 Carbon Steel','1045 Carbon Steel','Full Tang',NULL,72.0,105.0,3.2,NULL,'Wood, Traditional Japanese wrapping, Light-gold cord','Solid wood, Matte black lacquer finish with gold-plated fittings',1,1,'Yoriichi Tsugikuni Katana — 105cm | Kitsuneoni','Demon Slayer Yoriichi Tsugikuni katana replica with fiery red blade pattern. 1045 carbon steel, full tang, 105 cm. Premium collectible with stand and gift box.',NULL,'','products/videos/yoriichi-tsugikuni.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(16,'Akajiri','akajiri','Collectible and training katana with a sharpened blade made of patterned steel. Suitable for cutting practice and tameshigiri. Features iron tsuba, brass habaki, and black fabric handle wrapping.','<p>The "Akajiri" is a premium collectible and training katana featuring a sharpened blade made of patterned steel. Suitable for honing technique, cutting practice, and tameshigiri on light targets when performed with proper technique, as well as for collections, home decor, and gifts.</p><p>The blade is hand-polished with a visually distinct wavy hamon line formed by the steel\'s pattern and accentuated by hand polishing. The full-tang construction ensures strength and reliability.</p><p>The handle is crafted from wood with black dense fabric wrapping and white same-gawa (genuine stingray leather), secured with 2 mekugi. The iron tsuba provides a solid guard, while the brass habaki completes the traditional aesthetic. The scabbard is made from solid lacquered wood.</p><h3>Key Features</h3><ul><li>Patterned steel blade, hand-polished with wavy hamon</li><li>Full tang construction</li><li>Iron tsuba with brass habaki</li><li>Black fabric wrapping with white same-gawa</li><li>Includes care kit and premium box</li></ul>',415.00,NULL,NULL,'KTN-AK-001',9,1,1,1,1,1,'0',1,1,1150,NULL,'Patterned Steel','Patterned Steel','Full Tang',NULL,72.0,102.0,3.2,'0.7','Wood, Black dense fabric wrapping, White same-gawa, 2 mekugi','Solid wood, Lacquered',1,1,'Akajiri Katana — Patterned Steel, 102cm | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:35:13'),
(17,'Akiryuuto','akiryuuto','Collectible and training wakizashi made of patterned steel with a sharpened blade. Compact length for precise close-range control. Includes care kit.','The "Akiryuuto" is a collectible and training wakizashi crafted from patterned 609 steel with a sharpened blade. Its compact length provides precise control at close range, making it ideal for practice and collection.',418.00,NULL,NULL,'WKZ-AK-001',13,1,1,'0',1,1,'0','0','0',800,NULL,'609 Patterned Steel','609 Patterned Steel (etched)','Full Tang, Shinogi-zukuri',NULL,53.0,77.0,3.2,'0.7','Wood, Stingray leather (samegawa), Tight brown wrapping','Wood, Textured lacquer finish',2,1,'Akiryuuto Wakizashi — Patterned Steel, 77cm | Kitsuneoni',NULL,NULL,NULL,'products/videos/l2wiYyppbwGKo83BvSuohzRL85P9srqDSj3UXugq.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(18,'Bamboo Whirlwind','bamboo-whirlwind','T10 steel katana in a black-and-green color scheme. Differential hardening with clay creates an authentic hamon. High level of craftsmanship.','The "Bamboo Whirlwind" is a T10 steel katana in a striking black-and-green color scheme. The blade is crafted using traditional Japanese techniques, featuring differential hardening with clay that creates an authentic hamon line.',350.00,NULL,NULL,'KTN-BW-001',19,1,1,'0',1,1,'0','0','0',1180,NULL,'T10 High Carbon Steel','T10 High Carbon Steel','Full Tang, Differential hardening with clay',58.0,72.0,103.0,3.2,'0.7','Wood, Stingray leather (samegawa), Black fabric wrapping, 2 mekugi','Solid wood, Lacquered',1,1,'Bamboo Whirlwind Katana — T10 Steel, 103cm | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(19,'Cold Wave','cold-wave','T10 steel training katana with collapsible construction and differential clay hardening. Pronounced wavy hamon, 99 cm overall.','The "Cold Wave" is a T10 steel katana featuring collapsible construction for easy transport and storage. The blade is crafted with differential clay hardening, creating a pronounced wavy hamon line along the edge.',250.00,NULL,NULL,'KTN-CW-001',5,1,1,'0',1,1,'0','0','0',1150,NULL,'T10 High Carbon Steel','T10 High Carbon Steel','Collapsible, Differential hardening with clay',56.0,70.0,99.0,3.2,'0.7','Wood, Dense fabric wrapping (Ito)','Wood',1,1,'Cold Wave Katana — T10 Steel, 99cm | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(20,'Comet','comet','Patterned 609 layered steel katana with stone pattern forging technique. Brass fittings, solid lacquered saya. 102 cm overall.','The "Comet" is a premium katana forged from 609 patterned (layered) steel using the distinctive "stone" pattern formation technique. The blade showcases a unique layered pattern across its surface, finished by hand.',300.00,NULL,NULL,'KTN-CM-001',22,1,1,'0',1,1,'0','0','0',1050,NULL,'609 Patterned Steel (layered)','609 Patterned Steel','Full Tang, Stone pattern forging',NULL,72.0,102.0,3.2,'0.7','Wood, Fabric wrapping','Solid wood, Lacquered',1,1,'Comet Katana — 609 Patterned Steel, 102cm | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(21,'Emperor\'s Dragon','emperors-dragon','1060 high-manganese steel katana with a distinctive dragon-shaped accent hilt. Oil-quenched to 58 HRC. 107 cm overall. Collectible design.','The "Emperor\'s Dragon" is a distinctive katana featuring a unique dragon-shaped accent hilt that sets it apart from traditional designs. The blade is forged from high-manganese (1060) steel, oil-quenched for durability.',280.00,NULL,NULL,'KTN-ED-001',7,1,1,'0',1,1,'0','0','0',1050,NULL,'High-manganese Steel (1060)','1060 High-manganese Steel','Full Tang, Oil-quenched',58.0,73.0,107.0,3.1,'0.7','Resin, Artistic dragon-shaped design','Solid wood, Lacquered',1,1,'Emperor\'s Dragon Katana — 1060 Steel, 107cm | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(22,'Golden Dragon Tan','golden-dragon-tan','Tang-style dao with multi-layered patterned steel blade and brass fittings. Premium rosewood scabbard. A solid, well-crafted piece.','The "Golden Dragon Tan" is a Tang-style dao (Chinese single-edged sword) featuring a multi-layered patterned steel blade with a distinct steel pattern. This prestigious piece combines traditional Chinese sword craft with Japanese finishing.',380.00,NULL,NULL,'DAO-GD-001',15,1,1,'0',1,1,'0','0','0',1100,NULL,'Multi-layered Patterned Steel','Multi-layered Patterned Steel','Full Tang',56.0,70.0,95.0,3.5,'0.7','Wood, Fabric wrapping','Rosewood',1,1,'Golden Dragon Tan — Tang-style Dao, Patterned Steel | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(23,'Hairyu','hairyu','T10 steel katana selected by public vote. Well-balanced geometry with differential hardening. Dragon and wave relief tsuba.','The "Hairyu" katana was selected by public vote for its well-balanced geometry, precise craftsmanship, and practical design. The blade is made of T10 steel with differential heat treatment, creating a distinct hamon.',310.00,NULL,NULL,'KTN-HR-001',3,1,1,'0',1,1,'0','0','0',1150,NULL,'T10 High Carbon Steel','T10 High Carbon Steel','Full Tang, Differential heat treatment',58.0,71.0,103.0,3.2,'0.7','Wood, Brown tight wrapping (Ito)','Wood, Green lacquer with speckled pattern',1,1,'Hairyu Katana — T10 Steel, 103cm | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(24,'Hakugin','hakugin','High-manganese steel training katana with 56-58 HRC hardness. Shinogi-zukuri geometry with formal yokote. Blue and white ito wrapping.','The "Hakugin" is a collectible and training katana featuring a high-manganese steel blade with a hardness of 56-58 HRC. The single-edged blade has a decorative wavy pattern and is oil-quenched for durability.',366.00,NULL,NULL,'KTN-HG-001',17,1,1,'0',1,1,'0','0','0',1050,NULL,'High-manganese Steel','High-manganese Steel','Detachable, Oil-quenched, Shinogi-zukuri',57.0,72.0,103.0,3.2,'0.7','Wood, Blue and white ito wrapping, 2 bamboo mekugi','Wood, Lacquered with cotton sageo',1,1,'Hakugin Katana — High-manganese Steel, 103cm | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(25,'Hakurei','hakurei','T10 steel tanto with differential clay-hardened tempering and gently wavy hamon (notare-midare). White lacquered saya with floral patterns.','The "Hakurei" is a T10 steel tanto designed for both collection and training. The blade features differential clay-hardened tempering that creates a soft, wavy hamon (notare-midare style) accentuated by hand polishing.',439.00,NULL,NULL,'TNT-HK-001',9,1,1,'0',1,1,'0','0','0',600,NULL,'T10 High Carbon Steel','T10 High Carbon Steel','Full Tang, Differential clay tempering, Shinogi-zukuri',58.0,33.0,55.0,3.2,'0.7','Wood, Stingray leather (samegawa), Blue braiding','Wood, White lacquer with floral patterns',3,1,'Hakurei Tanto — T10 Steel, 55cm | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(26,'Hanami','hanami','1060 steel katana with blackened blade and light-colored floral saya. Shinogi-zukuri geometry, full-hardened. Suitable for training and collection.','The "Hanami" is a collectible and training katana made of high-carbon manganese 1060 steel with a sharpened blade. The light-colored saya with floral designs and the contrasting blackened blade create a striking look.',299.00,NULL,NULL,'KTN-HN-001',24,1,1,'0',1,1,'0','0','0',1050,NULL,'1060 High-carbon Manganese Steel','1060 High-carbon Manganese Steel','Full Tang, Full-hardened, Shinogi-zukuri',56.0,72.0,102.0,3.2,'0.7','Wood, Stingray leather (samegawa), Brown tight braiding','Wood, White lacquer with floral design',1,1,'Hanami Katana — 1060 Steel, 102cm | Kitsuneoni',NULL,NULL,NULL,'products/videos/DbSfuv4qnlTwIuxWCWdA0Q9lC683yzfS7PernzBT.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(27,'Hoshikage','hoshikage','T10 steel tanto with differential hardening and wavy hamon (gunome-midare). Starry sky lacquer effect on scabbard. Compact collector piece.','The "Hoshikage" is a T10 steel tanto designed for both collection and training, featuring differential hardening with clay that creates a wavy hamon (~gunome-midare style). The polished blade with hamon is accentuated by the starry sky lacquer scabbard.',229.00,NULL,NULL,'TNT-HS-001',6,1,1,'0',1,1,'0','0','0',575,NULL,'T10 Carbon Tool Steel','T10 Carbon Tool Steel','Full Tang, Differential clay tempering, Shinogi-zukuri',58.0,32.5,52.5,3.2,'0.7','Wood, Fabric wrapping','Wood, Lacquer with starry sky effect',3,1,'Hoshikage Tanto — T10 Steel, 52.5cm | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(28,'Hosina','hosina','T10 steel katana with differential clay-hardened tempering and wavy hamon (gunome-midare). Starry sky lacquer scabbard. Pre-sharpened.','The "Hosina" is a collector\'s and training katana made of T10 steel with differential clay-hardened tempering and a wavy hamon (~gunome-midare). The blade comes pre-sharpened and is balanced for collection and practice.',309.00,NULL,NULL,'KTN-HO-001',12,1,1,'0',1,1,'0','0','0',1010,NULL,'T10 High Carbon Steel','T10 High Carbon Steel','Full Tang, Differential clay-hardened tempering',58.0,72.5,103.5,3.2,'0.7','Wood, Stingray leather (samegawa), Black braiding','Wood, Lacquer with starry sky effect',1,1,'Hosina Katana — T10 Steel, 103.5cm | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(29,'Kagedoku','kagedoku','1060 steel katana with bo-hi groove and mirror-finish tang. 102 cm, suitable for training, tameshigiri, and collecting.','The "Kagedoku" is a collectible and training katana made of 1060 high-manganese steel with a sharpened blade and a hand-polished, mirror-finish tang. The blade features a bo-hi (groove) for weight reduction.',315.00,NULL,NULL,'KTN-KD-001',8,1,1,'0',1,1,'0','0','0',1150,NULL,'1060 High-manganese Steel','1060 High-manganese Steel','Full Tang, Bo-hi groove',56.0,72.0,102.0,3.2,'0.7','Solid wood, Tightly woven fabric wrapping, 2 mekugi','Solid wood, Lacquered',1,1,'Kagedoku Katana — 1060 Steel, 102cm | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(30,'Kairyu','kairyu','T10 steel katana with dragon engraving and blue-to-black gradient saya. Differential hardening, 102 cm. Premium collector piece.','The "Kairyu" is a collector\'s and training katana made of T10 carbon tool steel with differential clay-hardened tempering. The hand-polished blade features a dragon engraving and a visually distinct blue-to-black gradient saya.',579.00,NULL,NULL,'KTN-KR-001',20,1,1,'0',1,1,'0','0','0',1100,NULL,'T10 Carbon Tool Steel','T10 Carbon Tool Steel','Full Tang, Differential clay tempering, Shinogi-zukuri',58.0,72.0,102.0,3.2,'0.7','Wood, Stingray leather (samegawa), Tight blue wrapping','Wood, Lacquered blue-to-black gradient',1,1,'Kairyu Katana — T10 Steel with Dragon Engraving | Kitsuneoni',NULL,NULL,NULL,'products/videos/xrKgSxrKV1Hl7yG1G9hoOLel5XuwESDIlmyYoQD2.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(31,'Kaisen','kaisen','T10 steel tanto with fish motif engraving and calm wavy hamon (~notare). Hardwood saya with natural grain. 55 cm. Hand-finished.','The "Kaisen" is a collector\'s and training tanto crafted from T10 steel with differential clay-hardened tempering and a subtle, wavy hamon (~notare style). The blade comes pre-sharpened and features a fish motif engraving.',435.00,NULL,NULL,'TNT-KS-001',4,1,1,'0',1,1,'0','0','0',600,NULL,'T10 High Carbon Steel','T10 High Carbon Steel','Full Tang, Differential clay-hardened tempering',58.0,32.0,55.0,3.2,'0.7','Hardwood with natural grain','Hardwood with natural grain',3,1,'Kaisen Tanto — T10 Steel with Fish Engraving | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(32,'Katana Stand','katana-stand','Handcrafted katana stand made of karagach wood with oil finish. Milled engraving combined with epoxy resin.','This handcrafted katana stand is made of premium karagach wood with an oil finish that brings out the natural grain. The milled engraving adds a decorative touch, combined with epoxy resin accents for a refined look.',75.00,NULL,NULL,'ACC-KS-001',14,1,1,'0',1,1,'0','0','0',800,NULL,'Karagach wood, Epoxy resin',NULL,'Milled carving',NULL,NULL,30.0,NULL,NULL,NULL,NULL,5,1,'Katana Stand — Handcrafted Karagach Wood | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(33,'Kinmei','kinmei','Premium T10 steel katana with pronounced wavy hamon (gunome). Copper fittings throughout. 103 cm, 1.2 kg. Unsharpened collector piece.','The "Kinmei" is a premium collectible and training katana made of T10 steel with differential clay-hardened tempering and a pronounced wavy hamon (~gunome style). The blade features a monoblock construction with copper fittings.',1139.00,NULL,NULL,'KTN-KM-001',11,1,1,'0',1,1,'0','0','0',1200,NULL,'T10 High Carbon Steel','T10 High Carbon Steel','Full Tang, Monoblock, Differential clay hardening, Detachable',58.0,71.0,103.0,3.2,'0.7','Wood, Stingray leather (galushi), Fabric wrapping, 2 mekugi','Solid wood, Lacquered',1,1,'Kinmei Katana — T10 Steel, Copper Fittings | Kitsuneoni',NULL,NULL,NULL,'products/videos/foWxuPOz0OvBFITRGTNfqHV1xXoPDmYCjKMoR1zJ.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(34,'Kinsai','kinsai','1060 manganese steel tachi with mirror-polished blade and fuller. Textured lacquer saya with metal inlays. 103 cm, silver accents.','The "Kinsai" is a collector\'s and training tachi made of 1060 manganese steel with a mirror-polished and sharpened edge. The blade features a fuller (bo-hi) for weight reduction and follows traditional tachi geometry.',320.00,NULL,NULL,'TCH-KS-001',18,1,1,'0',1,1,'0','0','0',960,NULL,'1060 Manganese Steel','1060 Manganese Steel','Full Tang, Shinogi-zukuri',57.0,73.0,103.0,3.2,'0.7','Wood, Stingray leather (samegawa), Brown braiding','Wood, Textured lacquer with metal inlays',1,1,'Kinsai Tachi — 1060 Steel, Mirror Polish | Kitsuneoni',NULL,NULL,NULL,'products/videos/sNOX6VFj3ny2exRK7nYmN7aE0CGNCTuWqoKADpQ3.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(35,'Longsword','longsword','European longsword with carbon steel blade and fuller. Inspired by 16th-17th century designs. 108 cm, stainless steel fittings.','This European longsword features precise geometry with a cold-polished carbon steel blade and fuller. Inspired by 16th-17th century blades, with styling reminiscent of "The Witcher" aesthetic. Hand-forged.',250.00,NULL,NULL,'EUR-LS-001',5,1,1,'0',1,1,'0','0','0',1200,NULL,'Carbon Steel','Carbon Steel','Full Tang, Fuller groove',57.0,80.0,108.0,4.0,'0.6','Solid wood, Cord-wrapped','Suede, Solid wood, Leather-covered',5,1,'Longsword — European Style Carbon Steel | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(36,'Midori-ryu','midori-ryu','1060 steel katana with pronounced wavy hamon (gunome) and green lacquer saya. Openwork floral tsuba, chu-kissaki. 102 cm.','The "Midori-ryu" katana is crafted from high-carbon 1060 steel with a full-tang construction. The blade features shinogi-zukuri geometry, hand-polishing, and a pronounced wavy hamon (~gunome) with a chu-kissaki tip.',305.00,NULL,NULL,'KTN-MR-001',23,1,1,1,1,1,'0','0','0',1050,NULL,'1060 High-carbon Steel','1060 High-carbon Steel','Full Tang, Shinogi-zukuri',56.0,72.0,102.0,3.2,'0.7','Wood, Stingray leather (samegawa), Green wrapping, Golden menuki','Wood, Green lacquer',1,1,'Midori-ryu Katana — 1060 Steel, Green Lacquer | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(37,'Mizutori','mizutori','T10 steel katana with gunome-midare hamon and artistically painted blue lacquer saya. Double-sided relief tsuba. 103 cm.','The "Mizutori" is a collectible and training katana featuring a T10 steel blade with a wavy hamon (~gunome-midare) and a sharp edge. Suitable for practicing techniques, tameshigiri, and training, as well as collection.',636.00,NULL,NULL,'KTN-MZ-001',7,1,1,'0',1,1,'0','0','0',1050,NULL,'T10 High Carbon Steel','T10 High Carbon Steel','Full Tang',58.0,71.0,103.0,3.2,'0.7','Wooden core, White cotton wrapping','Wood, Glossy blue lacquer, Artistic painting of blooming branches with birds',1,1,'Mizutori Katana — T10 Steel, Blue Art Lacquer | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(38,'Musei','musei','1095 steel katana with oxidized blackened finish and engraving. Square matte tsuba, black lacquer saya. 103 cm. Sleek and austere.','The "Musei" is a collectible and training katana made of 1095 high-carbon steel with an oxidized blackened blade finish and engraving. The dark finish emphasizes the steel\'s austerity and depth, while the engraving adds character.',247.00,NULL,NULL,'KTN-MS-001',16,1,1,'0',1,1,'0','0','0',1050,NULL,'1095 High-carbon Steel','1095 High-carbon Steel','Full Tang, Shinogi-zukuri',57.0,71.0,103.0,2.9,'0.5','Wood, Stingray leather (samegawa), Black braiding','Wood, Black lacquer',1,1,'Musei Katana — 1095 Steel, Blackened Finish | Kitsuneoni',NULL,NULL,NULL,'products/videos/LMzRR74aaX7ysCjMrzh9f2utwfWXqf9eFkeGFzFb.mp4','2026-07-21 20:29:05','2026-07-21 20:29:05'),
(39,'Roar of the Tiger','roar-of-the-tiger','Auction-exclusive T10 steel katana with distinctive hamon and differential hardening. Balanced geometry, lacquered scabbard.','The "Roar of the Tiger" is an auction-exclusive katana crafted from T10 steel with differential hardening and a distinctive hamon. Precise geometry provides excellent balance and stability. The lacquered scabbard adds a refined finish.',700.00,NULL,NULL,'KTN-RT-001',9,1,1,'0',1,1,'0','0','0',1100,NULL,'T10 High Carbon Steel','T10 High Carbon Steel','Full Tang, Differential hardening',58.0,72.0,103.0,3.2,'0.7','Wood, Stingray leather (samegawa), Fabric wrapping','Wood, Lacquered',1,1,'Roar of the Tiger Katana — Auction Exclusive | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(40,'Ruiin','ruiin','Damascus-style patterned steel katana with floral design. Full brass fittings including habaki and kashira. 102 cm, 1.17 kg.','The "Ruiin" is an auction-exclusive katana featuring patterned Damascus-style steel with a "floral" design. The blade is complemented by full brass fittings including habaki and kashira. The handle features thick fabric wrapping.',450.00,NULL,NULL,'KTN-RN-001',13,1,1,'0',1,1,'0','0','0',1170,NULL,'Patterned Damascus-style Steel (Floral design)','Patterned Damascus-style Steel','Full Tang',57.0,72.0,102.0,3.2,'0.7','Wood, Thick fabric wrapping (ito), 2 mekugi','Wood, Lacquered',1,1,'Ruiin Katana — Damascus-style Patterned Steel | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(41,'Ryusei','ryusei','Patterned layered steel katana with bo-hi groove and mirror-polished finish. Brass fittings. 102 cm. Suitable for training.','The "Ryusei" is a collectible and training katana featuring a sharpened blade made of layered patterned steel with a bo-hi groove for weight reduction and improved balance. The blade is hand-polished to a mirror finish.',366.00,NULL,NULL,'KTN-RS-001',2,1,1,'0',1,1,'0','0','0',1220,NULL,'Patterned Layered Steel','Patterned Layered Steel','Full Tang, Bo-hi groove',57.0,72.0,102.0,3.2,'0.7','Solid wood, Tightly woven fabric wrapping, 2 mekugi','Solid wood, Lacquered',1,1,'Ryusei Katana — Patterned Layered Steel | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(42,'Seika','seika','1090+Monosteel katana with dark austere finish. Eco-leather scabbard with kanji, brass fittings. 102 cm. For training and collection.','The "Seika" is an auction-exclusive katana with a dark, austere finish. The scabbard features eco-leather covering with kanji characters, complemented by a solid black handle and understated brass fittings.',580.00,NULL,NULL,'KTN-SK-001',19,1,1,'0',1,1,'0','0','0',1100,NULL,'1090 + Monosteel','1090 + Monosteel','Full Tang, Fully forged',57.0,72.0,102.0,3.2,'0.7','Wood, Eco-leather, Tight black wrapping, 2 mekugi','Wood, Eco-leather with kanji characters',1,1,'Seika Katana — 1090+Monosteel, Leather Saya | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(43,'Seiryu','seiryu','1050 steel tanto with dragon engraving and dark blue lacquer saya with golden dragon design. 55 cm. Includes stand.','The "Seiryu" tanto is crafted in a traditional Japanese style with an emphasis on the image of an azure dragon. The blade is adorned with deep engraving, and the dark blue scabbard is accented with a golden dragon design.',285.00,NULL,NULL,'TNT-SR-001',10,1,1,'0',1,1,'0','0','0',650,NULL,'1050 Carbon Steel','1050 Carbon Steel','Full Tang, Shinogi-zukuri',55.0,33.0,55.0,3.2,'0.6','Wood, Stingray leather (samegawa), Dark blue wrapping','Wood, Lacquer with decorative dragon design',3,1,'Seiryu Tanto — 1050 Steel, Dragon Design | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(44,'Shin\'ei','shinei','1050 steel katana with dragon engraving and deeply carved solid wood scabbard. Square cast tsuba. 102 cm.','The "Shin\'ei" is a collectible and training katana made of 1050 carbon steel with a sharpened blade. The polished blade features a dragon engraving, and the carved solid wood scabbard adds depth to the design.',255.00,NULL,NULL,'KTN-SE-001',21,1,1,'0',1,1,'0','0','0',1100,NULL,'1050 Carbon Steel','1050 Carbon Steel','Full Tang, Shinogi-zukuri',55.0,72.0,102.0,3.2,'0.7','Wood, Stingray leather (samegawa), Brown wrapping','Solid wood, Deeply carved, Lacquered',1,1,'Shin\'ei Katana — 1050 Steel, Carved Saya | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05'),
(45,'Shirokawa','shirokawa','Premium hand-forged tachi with differential clay tempering. Silver-gold dragon relief fittings. 104 cm. Disassemblable construction.','The "Shirokawa" is a premium hand-forged tachi crafted from high-carbon forged steel with a maru (fully forged) construction. The blade undergoes differential clay tempering and hand-polishing to achieve a refined hamon.',1551.00,NULL,NULL,'TCH-SK-001',6,1,1,'0',1,1,'0','0','0',1150,NULL,'High-carbon Forged Steel (Hand-forged)','High-carbon Forged Steel','Maru (Fully forged), Shinogi-zukuri, Differential clay tempering, Disassemblable',58.0,71.0,104.0,3.2,'0.7','Wood, Pearlescent stingray leather (samegawa), Cotton cord, 2 mekugi','Solid wood, Lacquered, Family crest motif (Sengoku period), Tachi hanger',1,1,'Shirokawa Tachi — Premium Hand-Forged, $1,551 | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(46,'Suzume','suzume','1060 steel tanto with eagle-head pommel and hand-painted composite saya. 53.5 cm. Compact and lightweight for display.','The "Suzume" is a collectible and training tanto crafted from 1060 carbon steel with a sharp edge and uniform polish. Its compact size and light weight make it convenient for display, photography, and collection.',159.00,NULL,NULL,'TNT-SZ-001',15,1,1,'0',1,1,'0','0',1,500,NULL,'1060 Carbon Steel','1060 Carbon Steel','Full Tang, Shinogi-zukuri',56.0,31.0,53.5,2.8,'0.5','Wood, Stingray leather (samegawa), Black braided wrap','Impact-resistant composite, Glossy finish, Hand-painted design',3,1,'Suzume Tanto — 1060 Steel, Eagle Pommel | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:06','2026-07-21 20:40:12'),
(47,'Tenma','tenma','1045 steel katana with oxidized graphite-hued blade and pronounced gunome hamon. Gray-black handle, artistic scabbard. 102 cm.','The "Tenma" katana features an understated, dark design with artistic decoration on the scabbard and a distinct temper line on the blade. The blade is made of 1045 carbon steel, hand-polished and oxidized for a graphite hue.',355.00,NULL,NULL,'KTN-TM-001',8,1,1,'0',1,1,'0','0','0',1050,NULL,'1045 Carbon Steel','1045 Carbon Steel','Full Tang, Shinogi-zukuri',54.0,72.0,102.0,3.2,'0.7','Wood, Stingray leather (samegawa), Gray cord wrapping','Wood, Lacquer finish, Artistic design',1,1,'Tenma Katana — 1045 Steel, Oxidized Blade | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(48,'Tokiwa','tokiwa','1090 steel katana with oil-hardened blade, dark green design. Reinforced double-locking handle. 102 cm. Auction-exclusive.','The "Tokiwa" is an auction-exclusive katana featuring a dark green, understated design with clean geometry. The 1090 steel blade is oil-hardened, providing consistent rigidity, sharpness, and smooth polishing.',530.00,NULL,NULL,'KTN-TW-001',17,1,1,'0',1,1,'0','0','0',1100,NULL,'1090 Steel','1090 Steel','Full Tang, Oil-hardened, Reinforced double-locking handle',57.0,72.0,102.0,3.2,'0.7','Wood, Stingray leather (samegawa), Tight wrapping, Double locking','Wood, Lacquered',1,1,'Tokiwa Katana — 1090 Steel, Dark Green | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:06','2026-07-21 20:29:06'),
(49,'Uguisu','uguisu','1045 steel katana with "Flowers and Birds" artistic inlay on black lacquer saya. Openwork floral tsuba. 102 cm. Includes stand.','The "Uguisu" katana is crafted from high-carbon 1045 steel with a full-tang construction. The blade features shinogi-zukuri geometry, hand-polishing, and a decorative wavy hamon with a chu-kissaki tip.',315.00,NULL,NULL,'KTN-UG-001',3,1,1,'0',1,1,'0','0','0',1050,NULL,'1045 High-carbon Steel','1045 High-carbon Steel','Full Tang, Shinogi-zukuri',54.0,72.0,102.0,3.2,'0.7','Wood, Stingray leather (samegawa), Two-tone wrapping','Wood, Black lacquer, "Flowers and Birds" artistic inlay',1,1,'Uguisu Katana — 1045 Steel, Flowers & Birds Saya | Kitsuneoni',NULL,NULL,NULL,NULL,'2026-07-21 20:29:06','2026-07-21 20:29:06');

-- --------------------------------------------------------
-- Table: reviews

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint unsigned NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_product_id_index` (`product_id`),
  KEY `reviews_is_approved_index` (`is_approved`),
  KEY `reviews_is_featured_index` (`is_featured`),
  KEY `reviews_rating_index` (`rating`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: sessions

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: settings

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`id`,`group`,`key`,`value`,`type`,`created_at`,`updated_at`) VALUES
(1,'general','site_name','Kitsuneoni','text','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(2,'general','site_tagline','Premium Handcrafted Japanese Collectibles','text','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(3,'general','contact_email','orders@kitsuneoni.com','text','2026-07-21 20:29:06','2026-07-21 20:29:06');

-- --------------------------------------------------------
-- Table: testimonials

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint unsigned NOT NULL DEFAULT '5',
  `source` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_approved` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonials_is_featured_index` (`is_featured`),
  KEY `testimonials_is_approved_index` (`is_approved`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `testimonials` (`id`,`customer_name`,`customer_title`,`customer_avatar`,`body`,`rating`,`source`,`is_featured`,`is_approved`,`sort_order`,`created_at`,`updated_at`) VALUES
(1,'Alex M.','Collector, USA',NULL,'Stunning craftsmanship. Every piece feels like it was made just for you.',5,NULL,1,1,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(2,'Dmitry K.','Collector, Russia',NULL,'The quality, the packaging, the personal touch — it\'s all there. Highly recommend.',5,NULL,1,1,'0','2026-07-21 20:29:06','2026-07-21 20:29:06'),
(3,'Marco R.','Collector, Italy',NULL,'Fast delivery to Europe. The craftsmanship rivals pieces I\'ve seen for twice the price.',5,NULL,1,1,'0','2026-07-21 20:29:06','2026-07-21 20:29:06');

-- --------------------------------------------------------
-- Table: users

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`,`name`,`email`,`email_verified_at`,`password`,`role`,`phone`,`avatar`,`is_active`,`remember_token`,`created_at`,`updated_at`) VALUES
(1,'Kitsuneoni Admin','admin@kitsuneoni.com',NULL,'$2y$12$v6trCDTM/WD8TF2OMNnq4.HCkSmhZLRe4eZAd/xrnK8C6LrYOCOy6','super_admin',NULL,NULL,1,NULL,'2026-07-21 20:29:05','2026-07-21 20:29:05');

-- --------------------------------------------------------
-- Table: wishlists

DROP TABLE IF EXISTS `wishlists`;
CREATE TABLE `wishlists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  `session_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  KEY `wishlists_product_id_foreign` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;
