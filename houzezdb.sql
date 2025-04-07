-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2025 at 09:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `houzez_laravel_vue`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `favorite_properties`
--

CREATE TABLE `favorite_properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorite_properties`
--

INSERT INTO `favorite_properties` (`id`, `user_id`, `property_id`, `created_at`, `updated_at`) VALUES
(4, 10, 20, '2025-03-02 15:12:52', '2025-03-02 15:12:52'),
(25, 10, 23, '2025-03-15 14:13:46', '2025-03-15 14:13:46'),
(28, 10, 19, '2025-03-19 14:29:19', '2025-03-19 14:29:19');

-- --------------------------------------------------------

--
-- Table structure for table `floor_plans`
--

CREATE TABLE `floor_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `plan_title` varchar(255) DEFAULT NULL,
  `plan_bedrooms` int(11) DEFAULT NULL,
  `plan_bathrooms` int(11) DEFAULT NULL,
  `plan_price` decimal(10,2) DEFAULT NULL,
  `price_postfix` varchar(255) DEFAULT NULL,
  `plan_size` int(11) DEFAULT NULL,
  `plan_image` varchar(255) DEFAULT NULL,
  `plan_description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_12_21_142055_create_personal_access_tokens_table', 1),
(5, '2024_12_26_072928_add_fields_to_users_table', 1),
(6, '2024_12_26_081107_create_user_profiles_table', 1),
(7, '2024_12_26_102738_add_social_media_fields_to_user_profiles', 1),
(8, '2025_01_21_202521_create_properties_table', 2),
(9, '2025_01_23_192220_create_properties_table', 3),
(10, '2025_01_23_193906_add_user_id_to_properties_table', 4),
(11, '2025_01_24_080127_create_property_images_table', 5),
(12, '2025_01_25_095437_create_sub_properties_table', 6),
(13, '2025_01_27_072044_create_floor_plans_table', 6),
(14, '2025_02_09_190258_create_property_attachments_table', 7),
(15, '2025_02_09_191614_create_property_attachments_table', 8),
(16, '2025_02_10_193821_add_three_new_columns_to_properties_table', 9),
(17, '2025_02_16_185048_create_customer_columns', 10),
(18, '2025_02_16_185049_create_subscriptions_table', 10),
(19, '2025_02_16_185050_create_subscription_items_table', 10),
(20, '2025_02_16_190115_create_plans_table', 11),
(21, '2025_02_16_201142_create_plans_table', 12),
(22, '2025_02_21_194837_add_slug_column_to_properties_table', 13),
(23, '2025_02_26_174346_add_is_admin_to_users_table', 13),
(24, '2025_03_02_191436_create_favorite_properties_table', 14),
(25, '2025_03_03_065324_create_subscribers_table', 15),
(26, '2025_03_07_173415_create_saved_searches_table', 16),
(27, '2025_03_12_202154_add_role_column_to_users_table', 17),
(28, '2025_03_18_193901_update_properties_table', 18);

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
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(162, 'App\\Models\\User', 14, 'auth_token', '7b2cf80afe32da88b9d90ad1d04d8875d7a07639e32c2203f23396b37dc8243e', '[\"*\"]', NULL, NULL, '2025-02-24 01:43:38', '2025-02-24 01:43:38'),
(208, 'App\\Models\\User', 15, 'auth_token', 'b5c412da70c49cbaa4a9c1ef95da936512e90f106df3bb09b4e2a6ce69072dee', '[\"*\"]', NULL, NULL, '2025-02-28 12:49:30', '2025-02-28 12:49:30'),
(211, 'App\\Models\\User', 17, 'auth_token', 'd22d187f4cb43e819a88061579ab3a94220b900f314b5a5485c3cef731a44665', '[\"*\"]', NULL, NULL, '2025-02-28 13:01:12', '2025-02-28 13:01:12'),
(241, 'App\\Models\\User', 10, 'auth_token', '54f998d041e3bb28f883a41d40d532ad85c754c473d8e8ea695e6cee9559721e', '[\"*\"]', '2025-03-19 14:36:16', NULL, '2025-03-19 14:02:28', '2025-03-19 14:36:16');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `billing_method` varchar(255) NOT NULL,
  `interval_count` tinyint(4) NOT NULL DEFAULT 1,
  `price` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `number_of_listings` varchar(255) DEFAULT NULL,
  `number_of_images` varchar(255) DEFAULT NULL,
  `taxes` varchar(255) DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `plan_id`, `name`, `billing_method`, `interval_count`, `price`, `currency`, `number_of_listings`, `number_of_images`, `taxes`, `total_price`, `active`, `created_at`, `updated_at`) VALUES
(2, 'plan_RmnwROMnUgwRkw', 'premium', 'month', 3, '100000', 'gbp', '100', '20', NULL, NULL, 1, '2025-02-16 15:21:11', '2025-02-16 15:41:58'),
(4, 'plan_RmonkW9NgHWjCM', 'premium 2', 'month', 3, '100000', 'usd', '100', '20', NULL, NULL, 0, '2025-02-16 16:14:01', '2025-02-16 16:14:01'),
(8, 'plan_RmpDoiPuaWtsl7', 'silver', 'month', 3, '500000', 'usd', '100', '20', NULL, NULL, 1, '2025-02-16 16:39:48', '2025-02-16 16:39:48'),
(11, 'plan_RnuRAyXpbHkcHb', 'shahbaz', 'day', 1, '80000', 'usd', '100', '20', NULL, NULL, 0, '2025-02-19 14:07:39', '2025-02-19 14:07:39'),
(12, 'plan_RnuStsOPooF7a7', 'professional', 'week', 2, '70000', 'usd', '50', '20', NULL, NULL, 1, '2025-02-19 14:09:17', '2025-02-19 14:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `property_status` varchar(255) NOT NULL DEFAULT 'draft',
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `label` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `second_price` decimal(10,2) DEFAULT NULL,
  `after_price` varchar(255) DEFAULT NULL,
  `price_prefix` varchar(255) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `garages` int(11) DEFAULT NULL,
  `garages_size` varchar(255) DEFAULT NULL,
  `area_size` int(11) DEFAULT NULL,
  `size_prefix` varchar(255) DEFAULT NULL,
  `land_area` int(11) DEFAULT NULL,
  `land_area_size_postfix` varchar(255) DEFAULT NULL,
  `property_id` varchar(255) DEFAULT NULL,
  `year_built` int(11) DEFAULT NULL,
  `property_feature` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`property_feature`)),
  `energy_class` varchar(255) DEFAULT NULL,
  `global_energy_performance_index` varchar(255) DEFAULT NULL,
  `renewable_energy_performance_index` varchar(255) DEFAULT NULL,
  `energy_performance_of_the_building` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `county_state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `neighborhood` varchar(255) DEFAULT NULL,
  `zip_postal_code` varchar(255) DEFAULT NULL,
  `map_street_view` text DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `virtual_tour` text DEFAULT NULL,
  `contact_information` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`contact_information`)),
  `private_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `title`, `slug`, `description`, `type`, `status`, `property_status`, `is_paid`, `is_featured`, `label`, `price`, `second_price`, `after_price`, `price_prefix`, `bedrooms`, `bathrooms`, `garages`, `garages_size`, `area_size`, `size_prefix`, `land_area`, `land_area_size_postfix`, `property_id`, `year_built`, `property_feature`, `energy_class`, `global_energy_performance_index`, `renewable_energy_performance_index`, `energy_performance_of_the_building`, `address`, `country`, `county_state`, `city`, `neighborhood`, `zip_postal_code`, `map_street_view`, `latitude`, `longitude`, `video_url`, `virtual_tour`, `contact_information`, `private_note`, `created_at`, `updated_at`, `user_id`) VALUES
(3, 'title', 'title', 'fsdffsdf', 'studio', 'sale', 'pending', 0, 1, NULL, 10000.00, 345.00, '345', '345', NULL, NULL, NULL, NULL, 234, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, 'Ghous Pur', 'Pakistan', NULL, 'Chicago', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-01-23 16:04:00', '2025-02-10 14:10:05', 10),
(6, 'title', 'title-2', NULL, 'office', 'rent', 'draft', 0, 1, 'option 2', 250000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Chivilcoy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-01-25 08:06:00', '2025-01-25 08:06:00', 10),
(19, 'Penthouse apartment', 'penthouse-apartment', 'Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores le', 'apartment', 'sale', 'published', 1, 1, 'option 4', 2300000.00, 345.00, '345', '345', 25, 60, 23, '200', 234, 'prefix', 234, 'postfix', 'HZ-01', 1900, '[\"Air Conditioning\",\"Refrigerator\",\"Washer\",\"Laundry\",\"Barbeque\",\"Lawn\",\"Sauna\",\"WiFi\",\"Dryer\",\"Microwave\",\"Swimming Pool\",\"Window Coverings\",\"TV Cable\",\"Outdoor Shower\",\"Gym\"]', 'A+', '92.34 Km', '57.34 Km', 'high', '12 lot, street 234, land area Uk', 'USA', 'State', 'Amerika', 'Neighborhood', '234234', NULL, 28.42120000, 70.29890000, '<iframe width=\"100%\" height=\"415px\"                 src=\"https://www.youtube.com/embed/-NInBEdSvp8?si=6gtWuqMlA2gbfq6T\"                 title=\"YouTube video player\" frameborder=\"0\"                 allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\"                 referrerpolicy=\"strict-origin-when-cross-origin\"                 allowfullscreen></iframe>', '<iframe width=\"100%\" height=\"480\" src=\"https://my.matterport.com/show/?m=zEWsxhZpGba&amp;play=1&amp;qs=1\" frameborder=\"0\" allowfullscreen=\"allowfullscreen\"></iframe>', '[\"author_data\"]', NULL, '2025-02-11 14:37:15', '2025-03-18 14:41:18', 10),
(20, 'Modern apartment on the bay', 'modern-apartment-on-the-bay', 'Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt ', 'apartment', 'sale', 'published', 1, 1, 'option 4', 6000.00, 345.00, '345', '345', 4, 6, NULL, NULL, 57, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, 'Ghous Pur', 'Pakistan', NULL, 'Miami', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-02-13 13:12:17', '2025-02-13 13:12:17', 10),
(21, 'title', 'title-1', NULL, 'office', 'rent', 'published', 0, 1, 'option 2', 5000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'New York', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-02-13 13:13:27', '2025-02-13 13:13:27', 10),
(22, 'title update 2', 'title-update', 'fsdffsdf', 'apartment', 'draft', 'published', 0, 1, 'option 4', 9000.00, 345.00, '345', '345', NULL, NULL, NULL, NULL, 234, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, 'Ghous Pur', 'Pakistan', NULL, 'New York', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-02-13 13:20:54', '2025-02-13 13:20:54', 10),
(23, 'Contemporary apartment', 'contemporary-apartment', 'Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt', 'office', 'rent', 'published', 1, 1, 'option 4', 5000.00, 345.00, '345', '345', 30, 40, NULL, '345', 234, NULL, NULL, NULL, NULL, NULL, '[\"Barbeque\",\"WiFi\",\"Window Coverings\"]', NULL, NULL, NULL, NULL, 'Ghous Pur', 'Pakistan', NULL, 'New York', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-02-13 13:32:19', '2025-02-28 13:59:13', 10),
(25, 'villa city housing', 'villa-city-housing', NULL, 'villa', 'sale', 'draft', 0, 0, 'option 2', 7800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-02-28 07:18:44', '2025-02-28 07:18:44', 10),
(26, 'hosuing sceme', 'hosuing-sceme', NULL, NULL, 'draft', 'pending', 0, 0, NULL, 35000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'note', '2025-02-28 15:37:49', '2025-02-28 16:23:22', 10),
(27, 'new willing house', 'new-willing-house', NULL, NULL, 'draft', 'pending', 0, 0, NULL, 70000.00, NULL, NULL, NULL, 20, 10, NULL, NULL, 500, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-02-28 16:25:36', '2025-03-01 06:34:24', 10),
(28, 'new luxury apartment', 'new-luxury-apartment', NULL, 'apartment', 'rent', 'draft', 0, 0, NULL, 78000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-03-01 04:45:54', '2025-03-01 04:45:54', 10),
(29, 'big office building', 'big-office-building', NULL, 'office', 'sale', 'pending', 0, 0, NULL, 50000.00, NULL, NULL, NULL, 15, 4, NULL, NULL, 200, NULL, NULL, NULL, NULL, NULL, '[\"Air Conditioning\",\"Laundry\",\"Refrigerator\",\"Barbeque\",\"Lawn\",\"WiFi\",\"Window Coverings\"]', 'class', 'index', 'index', 'building', 'USA', 'USA', NULL, 'New York', 'street', '3123', NULL, NULL, NULL, 'https://www.youtube.co', 'virtual tour', '[\"author_data\"]', 'note 1', '2025-03-01 06:38:23', '2025-03-01 08:26:28', 11),
(30, 'commercial property', 'commercial-property', 'description', 'commercial', 'sale', 'draft', 0, 0, NULL, 55000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-03-01 08:27:29', '2025-03-01 08:30:36', 11),
(31, 'multi family home', 'multi-family-home', NULL, 'multi family home', 'rent', 'draft', 0, 0, NULL, 1500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-03-01 08:31:42', '2025-03-01 08:31:42', 11),
(32, 'multi family home', 'multi-family-home-1', NULL, 'multi family home', 'rent', 'draft', 0, 0, NULL, 1500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-03-01 08:31:56', '2025-03-01 08:31:56', 11),
(33, 'multi family home', 'multi-family-home-2', NULL, 'multi family home', 'sale', 'draft', 0, 0, NULL, 56000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-03-01 08:38:21', '2025-03-01 08:38:21', 11),
(34, 'multi family home', 'multi-family-home-3', NULL, 'multi family home', 'sale', 'draft', 0, 0, NULL, 56000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-03-01 08:38:29', '2025-03-01 08:38:29', 11),
(35, 'multi family homey', 'multi-family-homey', NULL, 'multi family home', 'rent', 'draft', 0, 0, NULL, 7800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-03-01 08:41:52', '2025-03-01 08:42:13', 11),
(36, 'single family home', 'single-family-home', NULL, 'single family home', 'sale', 'draft', 0, 0, NULL, 5000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-03-01 08:49:34', '2025-03-01 08:49:34', 11),
(37, 'single family home', 'single-family-home-1', NULL, 'single family home', 'sale', 'draft', 0, 0, NULL, 5000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-03-01 08:51:17', '2025-03-01 08:51:17', 11),
(38, 'highfy office', 'highfy-office', NULL, 'office', 'rent', 'pending', 0, 0, 'option 3', 2500.00, NULL, NULL, NULL, 10, 5, NULL, NULL, 650, NULL, NULL, NULL, NULL, NULL, '[\"Barbeque\",\"Air Conditioning\",\"Refrigerator\"]', NULL, NULL, NULL, NULL, 'Paracha Executive Hostel, Near Govt Science College, Gulgasht Colony Multan', 'USA', NULL, 'New York', NULL, NULL, NULL, NULL, NULL, 'https://www.youtube.com/watch?v=49d3Gn41IaA', NULL, '[\"agent_data\"]', NULL, '2025-03-08 05:06:03', '2025-03-08 05:13:21', 12);

-- --------------------------------------------------------

--
-- Table structure for table `property_attachments`
--

CREATE TABLE `property_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_attachments`
--

INSERT INTO `property_attachments` (`id`, `property_id`, `file_title`, `file_path`, `created_at`, `updated_at`) VALUES
(13, 38, 'This is a JPG file (atfah-j-_OuTyL6mIL8-unsplash)', 'http://localhost:8000/property_attachments/atfah-j-_OuTyL6mIL8-unsplash_1741428694.jpg', '2025-03-08 05:11:34', '2025-03-08 05:11:34'),
(14, 19, 'This is a PNG file (map)', 'http://localhost:8000/property_attachments/map_1742244355.png', '2025-03-17 15:45:55', '2025-03-17 15:45:55');

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `image_path`, `is_thumbnail`, `created_at`, `updated_at`) VALUES
(88, 3, 'http://localhost:8000/property_images/67a8cef234bdf_atfah-j-_OuTyL6mIL8-unsplash.jpg', 0, '2025-02-09 10:51:14', '2025-02-09 12:10:28'),
(92, 3, 'http://localhost:8000/property_images/67a8d080a3c25_ines-alvarez-fdez-7OGWqEf5u88-unsplash.jpg', 1, '2025-02-09 10:57:52', '2025-02-09 12:10:28'),
(102, 6, 'http://localhost:8000/property_images/67aa4b79732e8_ines-alvarez-fdez-7OGWqEf5u88-unsplash.jpg', 1, '2025-02-10 13:54:49', '2025-02-10 13:54:49'),
(108, 21, 'http://localhost:8000/property_images/67aa4b79732e8_ines-alvarez-fdez-7OGWqEf5u88-unsplash.jpg', 1, '2025-02-13 13:13:27', '2025-02-13 13:13:27'),
(109, 20, 'http://localhost:8000/property_images/67ae37f35a131_atfah-j-_OuTyL6mIL8-unsplash.jpg', 0, '2025-02-13 13:20:35', '2025-02-15 06:15:40'),
(110, 22, 'http://localhost:8000/property_images/67ae37f35a131_atfah-j-_OuTyL6mIL8-unsplash.jpg', 1, '2025-02-13 13:20:54', '2025-02-13 13:20:54'),
(112, 23, 'http://localhost:8000/property_images/67ae383ec34f1_atfah-j-_OuTyL6mIL8-unsplash.jpg', 0, '2025-02-13 13:32:19', '2025-03-15 15:34:29'),
(113, 23, 'http://localhost:8000/property_images/67b076ec23adb_ines-alvarez-fdez-7OGWqEf5u88-unsplash.jpg', 0, '2025-02-15 06:13:48', '2025-03-15 15:34:29'),
(114, 20, 'http://localhost:8000/property_images/67b07755d9a17_martin-martz-3_x1FRGAEwY-unsplash.jpg', 1, '2025-02-15 06:15:33', '2025-02-15 06:15:40'),
(115, 29, 'http://localhost:8000/property_images/67c30039761bb_atfah-j-_OuTyL6mIL8-unsplash.jpg', 1, '2025-03-01 07:40:25', '2025-03-01 07:40:25'),
(116, 38, 'http://localhost:8000/property_images/67cc16f5d4899_atfah-j-_OuTyL6mIL8-unsplash.jpg', 0, '2025-03-08 05:07:49', '2025-03-08 05:08:13'),
(117, 38, 'http://localhost:8000/property_images/67cc16f5d6c5a_ines-alvarez-fdez-7OGWqEf5u88-unsplash.jpg', 1, '2025-03-08 05:07:49', '2025-03-08 05:08:13'),
(118, 23, 'http://localhost:8000/property_images/67d5e436c87b7_martin-martz-3_x1FRGAEwY-unsplash.jpg', 1, '2025-03-15 15:33:58', '2025-03-15 15:34:29'),
(119, 23, 'http://localhost:8000/property_images/67d5e44b31585_atfah-j-_OuTyL6mIL8-unsplash.jpg', 0, '2025-03-15 15:34:19', '2025-03-15 15:34:29'),
(120, 23, 'http://localhost:8000/property_images/67d5e44b3fe9c_ines-alvarez-fdez-7OGWqEf5u88-unsplash.jpg', 0, '2025-03-15 15:34:19', '2025-03-15 15:34:29'),
(121, 23, 'http://localhost:8000/property_images/67d5e44b43c78_martin-martz-3_x1FRGAEwY-unsplash.jpg', 0, '2025-03-15 15:34:19', '2025-03-15 15:34:29'),
(122, 19, 'http://localhost:8000/property_images/67d5e6ac3359f_bg-hero.png', 0, '2025-03-15 15:44:28', '2025-03-18 14:16:25'),
(123, 19, 'http://localhost:8000/property_images/67d5e6ac3546a_home1.png', 1, '2025-03-15 15:44:28', '2025-03-18 14:16:25'),
(124, 19, 'http://localhost:8000/property_images/67d5e6ac36aed_home2.png', 0, '2025-03-15 15:44:28', '2025-03-18 14:16:25'),
(125, 19, 'http://localhost:8000/property_images/67d5e6ac381fd_home3.png', 0, '2025-03-15 15:44:28', '2025-03-18 14:16:25'),
(126, 19, 'http://localhost:8000/property_images/67d5e6ac399f5_home4.png', 0, '2025-03-15 15:44:28', '2025-03-18 14:16:25'),
(127, 19, 'http://localhost:8000/property_images/67d5e6ac3b156_home5.png', 0, '2025-03-15 15:44:28', '2025-03-18 14:16:25');

-- --------------------------------------------------------

--
-- Table structure for table `saved_searches`
--

CREATE TABLE `saved_searches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `parameters` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saved_searches`
--

INSERT INTO `saved_searches` (`id`, `user_id`, `parameters`, `created_at`, `updated_at`) VALUES
(1, 10, 'search=apartment&types=apartment,office&city=New+York&bedrooms=3&maxPrice=50000', '2025-03-07 13:37:59', '2025-03-07 13:37:59'),
(2, 10, 'search=&types=&city=&bedrooms=&maxPrice=', '2025-03-07 13:47:14', '2025-03-07 13:47:14'),
(3, 10, 'search=&types=villa,commercial,home&city=Houston&bedrooms=Any&maxPrice=300000', '2025-03-07 13:48:32', '2025-03-07 13:48:32'),
(5, 10, 'search=&types=&city=Phoenix&bedrooms=&maxPrice=', '2025-03-07 15:01:13', '2025-03-07 15:01:13'),
(6, 10, 'search=apartment&types=apartment,studio,office,shop,villa&city=New+York&bedrooms=&maxPrice=', '2025-03-07 15:32:45', '2025-03-07 15:32:45');

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BuqA81fhmLTHcR6xaaRqoTgsTiZUzvf4pP0RFPfq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid2xRMExQdVpIMzlyZGpUR2hQYWdmZGp0WWd0TktUZFNtekRGTmM2USI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1741544510),
('cfZxqFK3T5Jz0gmPYM2zMmGuVigKmcFWX5PNcQZL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZmtxVko2STIzQTRPYkZQVnBvUU9oVk15Q1ZBWkpGYW1xTTJLSldrVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1739474804),
('m0dlU05iUu4erm5N1cmmzDaf7x9Hkc5Ch66yUvUN', NULL, '127.0.0.1', 'PostmanRuntime/7.43.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYnZnTWhlTHZXa0xIcUY1M2llQVJiOFRKM1JsR0dBTkN6dW1DUE5VeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1738087437),
('wAuoRJiEEtppdp823cHM3TUErHCUQx2RSaR5ML3V', NULL, '127.0.0.1', 'PostmanRuntime/7.43.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTjFLeVVyZ2d0Z1FINTFwUlB5QlVxbERvekRXSWRVQmRaU1Qya2FWUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1741372491),
('YEgwKRkkcKJ2ABthR3T1FLrN78k1l2ZCKl4REvlg', NULL, '127.0.0.1', 'PostmanRuntime/7.43.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNzBYUkJwbDY4UGZSVkl3VzBCY3BZQWZNUERTYTBFN1IycG43V05PWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1739740392),
('zjyxiApaO1M1mYZ2kStffY1NqjR45lUuyq6ex12V', NULL, '127.0.0.1', 'PostmanRuntime/7.43.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidmYwUnJ0THhNRXJqaTRGMlo1NWxQSk12bHdCMHhuQjRHNTlmMnJoTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1739131011);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `created_at`, `updated_at`) VALUES
(4, 'shahbaz@gmail.com', '2025-03-12 14:37:48', '2025-03-12 14:37:48'),
(5, 'shahbaz1@gmail.com', '2025-03-12 14:38:31', '2025-03-12 14:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `stripe_status` varchar(255) NOT NULL,
  `stripe_price` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `type`, `stripe_id`, `stripe_status`, `stripe_price`, `quantity`, `trial_ends_at`, `ends_at`, `created_at`, `updated_at`) VALUES
(1, 10, 'default', 'sub_1QvGHoCiDsut3zNSE2HRJJeC', 'active', 'plan_RnuStsOPooF7a7', 1, NULL, NULL, '2025-02-22 05:50:20', '2025-02-22 05:50:23'),
(2, 10, 'default', 'sub_1QvGMXCiDsut3zNSdHWbaXKq', 'active', 'plan_RmpDoiPuaWtsl7', 1, NULL, NULL, '2025-02-22 05:55:12', '2025-02-22 05:55:14'),
(3, 10, 'default', 'sub_1QvGX6CiDsut3zNSJF7cVRh6', 'active', 'plan_RmpDoiPuaWtsl7', 1, NULL, NULL, '2025-02-22 06:06:08', '2025-02-22 06:06:10'),
(4, 10, 'default', 'sub_1QvHT8CiDsut3zNSfFVPOSzw', 'active', 'plan_RmpDoiPuaWtsl7', 1, NULL, NULL, '2025-02-22 07:06:06', '2025-02-23 08:16:35'),
(5, 10, 'default', 'sub_1QvfBXCiDsut3zNSFGHWqUyy', 'active', 'plan_RnuStsOPooF7a7', 1, NULL, '2025-03-09 08:25:31', '2025-02-23 08:25:33', '2025-03-07 11:37:28'),
(6, 11, 'default', 'sub_1QxVjqCiDsut3zNSF8jkqDNu', 'active', 'plan_RnuStsOPooF7a7', 1, NULL, '2025-03-14 10:44:34', '2025-02-28 10:44:32', '2025-02-28 12:23:37'),
(7, 19, 'default', 'sub_1QxYHACiDsut3zNSZdCLrAtU', 'active', 'plan_RmnwROMnUgwRkw', 1, NULL, NULL, '2025-02-28 13:27:05', '2025-02-28 13:27:08'),
(8, 12, 'default', 'sub_1R0KEjCiDsut3zNSMj7lhlsZ', 'active', 'plan_RmnwROMnUgwRkw', 1, NULL, '2025-06-08 05:04:05', '2025-03-08 05:04:04', '2025-03-08 05:15:37'),
(9, 18, 'default', 'sub_1R0S5mCiDsut3zNSlUHTNnz5', 'active', 'plan_RnuStsOPooF7a7', 1, NULL, NULL, '2025-03-08 13:27:23', '2025-03-08 13:27:25');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_items`
--

CREATE TABLE `subscription_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `stripe_product` varchar(255) NOT NULL,
  `stripe_price` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_items`
--

INSERT INTO `subscription_items` (`id`, `subscription_id`, `stripe_id`, `stripe_product`, `stripe_price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 'si_Rou6u3TmKUh0Dc', 'prod_RnuSxl3dcO3rkP', 'plan_RnuStsOPooF7a7', 1, '2025-02-22 05:50:20', '2025-02-22 05:50:20'),
(2, 2, 'si_RouAJ4IIMUnH9W', 'prod_RmpD7QClxmJTmq', 'plan_RmpDoiPuaWtsl7', 1, '2025-02-22 05:55:12', '2025-02-22 05:55:12'),
(3, 3, 'si_RouLIDSVoesuzo', 'prod_RmpD7QClxmJTmq', 'plan_RmpDoiPuaWtsl7', 1, '2025-02-22 06:06:08', '2025-02-22 06:06:08'),
(4, 4, 'si_RovJJflqyR6You', 'prod_RmpD7QClxmJTmq', 'plan_RmpDoiPuaWtsl7', 1, '2025-02-22 07:06:06', '2025-02-22 07:06:06'),
(5, 5, 'si_RpJpb1zimUmmUu', 'prod_RnuSxl3dcO3rkP', 'plan_RnuStsOPooF7a7', 1, '2025-02-23 08:25:33', '2025-02-23 08:25:33'),
(6, 6, 'si_RrECqHQKll9Wst', 'prod_RnuSxl3dcO3rkP', 'plan_RnuStsOPooF7a7', 1, '2025-02-28 10:44:32', '2025-02-28 10:44:32'),
(7, 7, 'si_RrGokPEufyn4ci', 'prod_Rmnw3hp7aTuMe8', 'plan_RmnwROMnUgwRkw', 1, '2025-02-28 13:27:05', '2025-02-28 13:27:05'),
(8, 8, 'si_Ru8VZ3IF2JKIVr', 'prod_Rmnw3hp7aTuMe8', 'plan_RmnwROMnUgwRkw', 1, '2025-03-08 05:04:04', '2025-03-08 05:04:04'),
(9, 9, 'si_RuGdwRNdStULI7', 'prod_RnuSxl3dcO3rkP', 'plan_RnuStsOPooF7a7', 1, '2025-03-08 13:27:23', '2025-03-08 13:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `sub_properties`
--

CREATE TABLE `sub_properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `garages` int(11) DEFAULT NULL,
  `garage_size` varchar(255) DEFAULT NULL,
  `area_size` int(11) DEFAULT NULL,
  `size_prefix` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `price_label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `role` varchar(255) NOT NULL DEFAULT 'subscriber',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) DEFAULT NULL,
  `pm_type` varchar(255) DEFAULT NULL,
  `pm_last_four` varchar(4) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `is_admin`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at`) VALUES
(10, 'shahbaz', NULL, 'shahbaz@gmail.com', 1, 'administrator', NULL, '$2y$12$4vBTGcuz22vAG4p38gD7IOj49mywac5HYR/hJMPAS8u250kigCLZa', NULL, '2025-01-16 15:57:08', '2025-03-13 14:51:49', 'cus_Rou50BL7gCXC52', 'visa', '4242', NULL),
(11, 'shahbaz1', NULL, 'shahbaz1@gmail.com', 0, 'agent', NULL, '$2y$12$B0kVueeyfRodnfGN4K61yuyhfWYb.W88jTWVJ1ubSUdblESGCzgHi', NULL, '2025-01-20 13:48:06', '2025-03-13 15:04:36', 'cus_RrECWTg3tJz4vP', 'visa', '4242', NULL),
(12, 'shahbaz2', NULL, 'shahbaz2@gmail.com', 0, 'owner', NULL, '$2y$12$/MatrvmucyWGLZIfggdWCOyLe4BW1NXBtW39aVrZTcnQ.t.km7ckO', NULL, '2025-02-17 14:28:15', '2025-03-13 15:04:27', 'cus_Ru8Vc9L3cgChws', 'visa', '4242', NULL),
(13, 'shahbaz3', NULL, 'shahbaz3@gmail.com', 0, 'seller', NULL, '$2y$12$6WOJLoEk4Nl6vupM0IUALeChM/kFoS/TrPsSILL.53xDyrPqvXudG', NULL, '2025-02-17 14:54:52', '2025-03-13 15:04:53', NULL, NULL, NULL, NULL),
(14, 'shahbaz4', NULL, 'shahbaz4@gmail.com', 0, 'subscriber', NULL, '$2y$12$LOpsF2yCiQxJ819shQtkN.FP/DrAO6Hch9Wp/cTt8jIcw1KGYhvLm', NULL, '2025-02-24 01:43:38', '2025-02-24 01:43:38', NULL, NULL, NULL, NULL),
(15, 'shahbaz5', NULL, 'shahbaz5@gmail.com', 0, 'subscriber', NULL, '$2y$12$4Bys.S/I1P0MbrsOD6e6vOVezl9w/Iv03fnHhzQ5DkfLXjHewUY/C', NULL, '2025-02-28 12:49:30', '2025-02-28 12:49:30', NULL, NULL, NULL, NULL),
(16, 'shahbaz6', NULL, 'shahbaz6@gmail.com', 0, 'subscriber', NULL, '$2y$12$7liswCyC5JtvkRJ0R.3v7OKfcZfxsRzUca7D2EcUBjB/pLji0R79S', NULL, '2025-02-28 12:52:02', '2025-02-28 12:52:02', NULL, NULL, NULL, NULL),
(17, 'shahbaz7', NULL, 'shahbaz7@gmail.com', 0, 'agent', NULL, '$2y$12$Kffihj6FdpXQG273/9uuLu5exXwV0Y5npF.b7EGQ62dcQSeS5Iv6a', NULL, '2025-02-28 13:01:12', '2025-03-13 14:11:38', NULL, NULL, NULL, NULL),
(18, 'shahbaz8', NULL, 'shahbaz8@gmail.com', 0, 'manager', NULL, '$2y$12$Q1.ycYdxRL8F1dCyW/Ki5OyzIfDmBhOEuwA2g8uZkD5URh8HtmU3S', NULL, '2025-02-28 13:20:45', '2025-03-13 15:24:56', 'cus_RuGcRsIMKRNnoq', 'visa', '4242', NULL),
(19, 'shahbaz9', NULL, 'shahbaz9@gmail.com', 0, 'buyer', NULL, '$2y$12$eutFtqjDYGjOMd1ywR6RCO9PW5H0yVfe0SAzJGy0RCgMuLtzlGeKm', NULL, '2025-02-28 13:24:20', '2025-03-17 13:48:53', 'cus_RrGoHuLFFmqaT9', 'visa', '4242', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `public_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `license` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `fax_number` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `tax_number` varchar(255) DEFAULT NULL,
  `service_areas` text DEFAULT NULL,
  `specialties` text DEFAULT NULL,
  `about_me` text DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `google_plus` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `pinterest` varchar(255) DEFAULT NULL,
  `vimeo` varchar(255) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `public_name`, `first_name`, `last_name`, `title`, `position`, `license`, `mobile`, `whatsapp`, `phone`, `fax_number`, `company_name`, `address`, `tax_number`, `service_areas`, `specialties`, `about_me`, `profile_picture`, `created_at`, `updated_at`, `facebook`, `twitter`, `linkedin`, `instagram`, `google_plus`, `youtube`, `pinterest`, `vimeo`, `skype`, `website`) VALUES
(9, 10, 'Shahbaz Ahmad', 'Shahbaz', 'Ahmad', 'title', 'position', 'licence', '888', '999888', '777888', NULL, 'web penter', 'address', '999', 'area', NULL, 'about me', 'http://localhost:8000/profile-picture/1741813036_profile.jpg', '2025-01-16 16:26:59', '2025-03-12 15:57:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 11, NULL, 'Shahbaz', 'Ahmad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ghous Pur\nZahir Pir', NULL, NULL, NULL, NULL, 'http://localhost:8000/profile-picture/1737400608_Capasdtursdase.PNG', '2025-01-20 13:48:21', '2025-01-26 10:30:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-08 05:02:57', '2025-03-08 05:02:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
-- Indexes for table `favorite_properties`
--
ALTER TABLE `favorite_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorite_properties_user_id_foreign` (`user_id`),
  ADD KEY `favorite_properties_property_id_foreign` (`property_id`);

--
-- Indexes for table `floor_plans`
--
ALTER TABLE `floor_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `floor_plans_property_id_foreign` (`property_id`);

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
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `properties_user_id_foreign` (`user_id`);

--
-- Indexes for table `property_attachments`
--
ALTER TABLE `property_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_attachments_property_id_foreign` (`property_id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_images_property_id_foreign` (`property_id`);

--
-- Indexes for table `saved_searches`
--
ALTER TABLE `saved_searches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saved_searches_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscriptions_stripe_id_unique` (`stripe_id`),
  ADD KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`);

--
-- Indexes for table `subscription_items`
--
ALTER TABLE `subscription_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_items_stripe_id_unique` (`stripe_id`),
  ADD KEY `subscription_items_subscription_id_stripe_price_index` (`subscription_id`,`stripe_price`);

--
-- Indexes for table `sub_properties`
--
ALTER TABLE `sub_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_properties_property_id_foreign` (`property_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_stripe_id_index` (`stripe_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profiles_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorite_properties`
--
ALTER TABLE `favorite_properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `floor_plans`
--
ALTER TABLE `floor_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `property_attachments`
--
ALTER TABLE `property_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `saved_searches`
--
ALTER TABLE `saved_searches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subscription_items`
--
ALTER TABLE `subscription_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sub_properties`
--
ALTER TABLE `sub_properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorite_properties`
--
ALTER TABLE `favorite_properties`
  ADD CONSTRAINT `favorite_properties_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorite_properties_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `floor_plans`
--
ALTER TABLE `floor_plans`
  ADD CONSTRAINT `floor_plans_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_attachments`
--
ALTER TABLE `property_attachments`
  ADD CONSTRAINT `property_attachments_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_searches`
--
ALTER TABLE `saved_searches`
  ADD CONSTRAINT `saved_searches_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_properties`
--
ALTER TABLE `sub_properties`
  ADD CONSTRAINT `sub_properties_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
