-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2025 a las 05:00:50
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ravepass`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Techno Mainstage', 'techno-mainstage', 'Categoría para los escenarios principales de los eventos de techno, con artistas de renombre y sets de larga duración.', '2025-05-28 00:53:57', '2025-05-28 00:53:57'),
(2, 'Hard Techno', 'hard-techno', 'Sonidos potentes y ritmos implacables. Para los amantes del techno más duro.', '2025-05-28 00:53:57', '2025-05-28 00:53:57'),
(3, 'Melodic Techno', 'melodic-techno', 'Techno con énfasis en melodías envolventes y atmósferas profundas.', '2025-05-28 00:53:57', '2025-05-28 00:53:57'),
(4, 'Acid Techno', 'acid-techno', 'Caracterizado por los sonidos ácidos de los sintetizadores TB-303. Un clásico del techno.', '2025-05-28 00:53:57', '2025-05-28 00:53:57'),
(5, 'Minimal Techno', 'minimal-techno', 'Enfoque en la repetición y la sutil progresión. Perfecto para los que aprecian la elegancia en la simplicidad.', '2025-05-28 00:53:57', '2025-05-28 00:53:57'),
(6, 'Detroit Techno', 'detroit-techno', 'El sonido original y futurista de Detroit, cuna del techno.', '2025-05-28 00:53:57', '2025-05-28 00:53:57'),
(7, 'Industrial Techno', 'industrial-techno', 'Sonidos crudos y texturas industriales. Techno oscuro y experimental.', '2025-05-28 00:53:57', '2025-05-28 00:53:57'),
(8, 'Ambient Techno', 'ambient-techno', 'Una fusión de techno y atmósferas ambientales, ideal para experiencias inmersivas.', '2025-05-28 00:53:57', '2025-05-28 00:53:57'),
(9, 'Live Techno', 'live-techno', 'Eventos donde los artistas tocan en vivo, creando música en tiempo real.', '2025-05-28 00:53:57', '2025-05-28 00:53:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `poster_path` varchar(255) DEFAULT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `available_tickets` int(11) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `start_date`, `end_date`, `location`, `city`, `poster_path`, `price`, `available_tickets`, `category_id`, `user_id`, `is_published`, `slug`, `created_at`, `updated_at`) VALUES
(27, 'CODE SUMMER FESTIVAL', 'El mayor evento del verano.', '2025-07-12 12:00:00', NULL, 'Av. de la Industria, 82, 28970 Humanes de Madrid, Madrid', 'Humanes de Madrid', 'events_posters/TxuAtvmDYo1RNJgCLGO1AQumAVZpGTCrNPP3iB18.jpg', 35.00, 4500, 1, 5, 1, 'code-summer-festival', '2025-06-10 15:00:40', '2025-06-10 15:00:40'),
(28, 'MONEGROS DESERT FESTIVAL', 'Solo tú y el desierto.', '2025-07-26 09:00:00', NULL, 'Desierto de los Monegros', 'Aragón', 'events_posters/ZXCY9w95hTnoHeN6pSMAHFwk68ygJBh16ikQgp96.jpg', 90.00, 3999, 2, 5, 1, 'monegros-desert-festival', '2025-06-10 15:04:13', '2025-06-10 15:34:53'),
(29, 'FURY FEST', 'Locura absoluta.', '2025-06-13 22:00:00', NULL, 'La mercedes', 'Barcelona', 'events_posters/THYJuaYzNMMq0znEeuddWUZpK20HQVJjJVI7awJ1.jpg', 25.00, 2197, 3, 5, 1, 'fury-fest', '2025-06-10 15:06:35', '2025-06-10 23:39:02'),
(30, '150 by FABRIK', 'Música pura.', '2025-07-26 21:00:00', NULL, 'Av. de la Industria, 82, 28970 Humanes de Madrid, Madrid', 'Humanes de Madrid', 'events_posters/J3nHa1HFO1eco8r8VmBPdlkTa1I7fScnJz9WhzI4.jpg', 45.00, 2000, 7, 6, 1, '150-by-fabrik', '2025-06-10 15:09:03', '2025-06-10 15:09:03'),
(31, 'DRUMCODE', 'La última code antes del verano.', '2025-06-14 22:00:00', NULL, 'Av. de la Industria, 82, 28970 Humanes de Madrid, Madrid', 'Av. de la Industria, 82, 28970 Humanes de Madrid, Madrid', 'events_posters/chKGMjmtCwTTXurhlNlBDcXtGUw39sdLiWAeUe6l.jpg', 23.00, 1499, 5, 6, 1, 'drumcode', '2025-06-10 15:10:37', '2025-06-10 15:35:01'),
(32, 'NEXUS FESTIVAL 2025', 'A quemar la pista.', '2025-06-13 20:00:00', NULL, 'Av. de la Industria, 82, 28970 Humanes de Madrid, Madrid', 'Humanes de Madrid', 'events_posters/Cz8AejovcQxZKuszkUY6HioMualECQjukOm5JYt0.jpg', 23.00, 4598, 4, 6, 1, 'nexus-festival-2025', '2025-06-10 15:13:16', '2025-06-10 23:54:08'),
(33, 'MONDO IS BACK', 'Mondo vuelve para el verano.', '2025-07-05 12:00:00', NULL, 'C. Alcalá, 20, Centro, 28014 Madrid', 'Madrid', 'events_posters/vATgSb5BgcOhyoaCk2CIsufNntY5l851soaat9S7.jpg', 46.00, 899, 9, 7, 1, 'mondo-is-back', '2025-06-10 15:14:46', '2025-06-10 15:33:32'),
(34, 'MEDUSA FESTIVAL 2025', 'Techno y playa.', '2025-08-16 12:00:00', NULL, 'Playa de Cullera', 'Valencia', 'events_posters/r0kQhXu7CEltRjcKb7yRpRGzpcy8WH6MJftQiUdb.jpg', 90.00, 4499, 8, 7, 1, 'medusa-festival-2025', '2025-06-10 15:16:54', '2025-06-10 15:34:34'),
(35, 'BLACKWORKS FESTIVAL IV ANIVERSARIO', 'La fiesta en su máximo explendor.', '2025-09-20 22:00:00', NULL, 'Av. del Partenón, 5, Barajas, 28042 Madrid', 'Madrid', 'events_posters/UbeXLD5Ee2ENLtFoDaUzsxKRsCSwjaWO45YrD4x6.jpg', 70.00, 6999, 6, 7, 1, 'blackworks-festival-iv-aniversario', '2025-06-10 15:19:08', '2025-06-10 15:34:24'),
(36, 'A SUMMER FESTIVAL', 'El primer evento del verano está aquí.', '2025-06-21 20:00:00', NULL, '28500 Arganda del Rey, Madrid', 'Madrid', 'events_posters/hB33e6SeVsVNoAvJ60bt6EuUOmirZfSqE8Xa6Kwf.jpg', 60.00, 2699, 2, 7, 1, 'a-summer-festival', '2025-06-10 15:22:41', '2025-06-10 15:34:16'),
(37, 'AQUASELLA FEST 2025', 'Solo para expertos.', '2025-08-17 20:00:00', NULL, 'El Valle de la Música', 'Arriondas y Cangas de Onís', 'events_posters/PZcagmltL03HiXfaHrDyKq0uD5ct2oRM628ruqFu.jpg', 130.00, 10000, 5, 5, 1, 'aquasella-fest-2025', '2025-06-10 15:25:13', '2025-06-10 15:25:13'),
(38, 'FLORIDA135', 'La discoteca más antigua de España.', '2025-07-19 23:00:00', NULL, 'Cam. Sotet, 2, 22520 Fraga, Huesca', 'Fraga', 'events_posters/M1jS6fmrWyafWcQjiuOraVitfiOhRX21GDldwLQQ.jpg', 30.00, 1498, 4, 5, 1, 'florida135', '2025-06-10 15:27:53', '2025-06-10 23:54:56'),
(39, 'ROTTERDAM RAVE', '2025.', '2025-06-14 22:00:00', NULL, 'Rottterdam.', 'Paises Bajos.', 'events_posters/gExMbja1r8E6704zmUrI3QGkRLEi4ogKoYoiJaPA.jpg', 65.00, 1700, 4, 8, 1, 'rotterdam-rave', '2025-06-10 23:36:33', '2025-06-10 23:37:02'),
(40, 'Evento del IES juan bosco', 'evento de verano.', '2025-06-14 12:00:00', NULL, 'IES Juan Bosco', 'Cordoba', 'events_posters/n2b3VvJBSgBzILwvx9buraQYJa67qePzAcNyoXSI.jpg', 10.00, 1000, 2, 5, 1, 'evento-del-ies-juan-bosco', '2025-06-11 00:06:09', '2025-06-11 00:06:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
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
-- Estructura de tabla para la tabla `jobs`
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
-- Estructura de tabla para la tabla `job_batches`
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
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '0001_01_01_000000_create_users_table', 1),
(9, '0001_01_01_000001_create_cache_table', 1),
(10, '0001_01_01_000002_create_jobs_table', 1),
(11, '2025_05_27_182207_create_categories_table', 1),
(12, '2025_05_27_182212_create_events_table', 1),
(13, '2025_05_27_182217_create_tickets_table', 1),
(14, '2025_05_27_182608_create_payments_table', 1),
(15, '2025_05_28_005005_add_purchase_date_and_status_to_tickets_table', 1),
(16, '2025_05_28_005543_add_ticket_id_to_payments_table', 2),
(17, '2025_05_28_231504_add_ticket_id_to_payments_table', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('daniellomas116@gmail.com', '$2y$12$ZJcACDFhJv5QS90vLfAnYeYXWrTf.jeqabUh0O8pN3NxFqZTDryjy', '2025-06-01 20:24:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `status` varchar(255) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `ticket_id`, `transaction_id`, `amount`, `currency`, `status`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES
(26, 5, 52, 'TRX-9fx4UWrgdO', 25.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 15:33:11', '2025-06-10 15:33:11'),
(27, 5, 53, 'TRX-K8RWDfefa7', 46.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 15:33:32', '2025-06-10 15:33:32'),
(28, 5, 54, 'TRX-KlSaqogeQ2', 23.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 15:33:40', '2025-06-10 15:33:40'),
(29, 6, 55, 'TRX-ZlECv7JV9y', 25.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 15:34:08', '2025-06-10 15:34:08'),
(30, 6, 56, 'TRX-mmVDZPD7JH', 60.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 15:34:16', '2025-06-10 15:34:16'),
(31, 6, 57, 'TRX-C7x5rUf07i', 70.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 15:34:24', '2025-06-10 15:34:24'),
(32, 6, 58, 'TRX-s2XrKI931G', 90.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 15:34:34', '2025-06-10 15:34:34'),
(33, 7, 59, 'TRX-tDKYGm7LrZ', 90.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 15:34:53', '2025-06-10 15:34:53'),
(34, 7, 60, 'TRX-5OaU0pnf5k', 23.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 15:35:01', '2025-06-10 15:35:01'),
(35, 7, 61, 'TRX-HXHso42klm', 30.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 15:35:13', '2025-06-10 15:35:13'),
(36, 5, 62, 'TRX-idtmy9jLwN', 25.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 23:39:02', '2025-06-10 23:39:02'),
(37, 10, 63, 'TRX-kMmc1bOaTt', 23.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 23:54:08', '2025-06-10 23:54:08'),
(38, 10, 64, 'TRX-Kayx3l72hH', 30.00, 'EUR', 'completed', 'paypal', NULL, '2025-06-10 23:54:56', '2025-06-10 23:54:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
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
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ANl77nZIh96aYmFMCODW16JFqE85FqbI7bxhoe51', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibGluQlJiTk8weGsybXlBNUg1bklMRzZNSTVMTzdKWkpWWTVnbWFBeiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cHM6Ly9sb2NhbGhvc3QvcmF2ZVBhc3MvcHVibGljL3Byb2ZpbGUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MToiaHR0cHM6Ly9sb2NhbGhvc3QvcmF2ZVBhc3MvcHVibGljL3Byb2ZpbGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748820498);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_date` datetime NOT NULL,
  `ticket_code` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`id`, `event_id`, `user_id`, `purchase_date`, `ticket_code`, `price`, `status`, `created_at`, `updated_at`) VALUES
(52, 29, 5, '2025-06-10 17:33:11', 'RAVE-XXV1xCoD', 25.00, 'confirmed', '2025-06-10 15:33:11', '2025-06-10 15:33:11'),
(53, 33, 5, '2025-06-10 17:33:32', 'RAVE-pwW7kZbn', 46.00, 'confirmed', '2025-06-10 15:33:32', '2025-06-10 15:33:32'),
(54, 32, 5, '2025-06-10 17:33:40', 'RAVE-zqDDX8wV', 23.00, 'confirmed', '2025-06-10 15:33:40', '2025-06-10 15:33:40'),
(55, 29, 6, '2025-06-10 17:34:08', 'RAVE-6Jh9rsQh', 25.00, 'confirmed', '2025-06-10 15:34:08', '2025-06-10 15:34:08'),
(56, 36, 6, '2025-06-10 17:34:16', 'RAVE-CYESTDIH', 60.00, 'confirmed', '2025-06-10 15:34:16', '2025-06-10 15:34:16'),
(57, 35, 6, '2025-06-10 17:34:24', 'RAVE-TU1hlktC', 70.00, 'confirmed', '2025-06-10 15:34:24', '2025-06-10 15:34:24'),
(58, 34, 6, '2025-06-10 17:34:34', 'RAVE-8VBpG41U', 90.00, 'confirmed', '2025-06-10 15:34:34', '2025-06-10 15:34:34'),
(59, 28, 7, '2025-06-10 17:34:53', 'RAVE-23Ku3vKa', 90.00, 'confirmed', '2025-06-10 15:34:53', '2025-06-10 15:34:53'),
(60, 31, 7, '2025-06-10 17:35:01', 'RAVE-5hcTNaDZ', 23.00, 'confirmed', '2025-06-10 15:35:01', '2025-06-10 15:35:01'),
(61, 38, 7, '2025-06-10 17:35:13', 'RAVE-dNcKqMRb', 30.00, 'confirmed', '2025-06-10 15:35:13', '2025-06-10 15:35:13'),
(62, 29, 5, '2025-06-11 01:39:02', 'RAVE-MUMpGd4Z', 25.00, 'confirmed', '2025-06-10 23:39:02', '2025-06-10 23:39:02'),
(63, 32, 10, '2025-06-11 01:54:08', 'RAVE-PfunvnVo', 23.00, 'confirmed', '2025-06-10 23:54:08', '2025-06-10 23:54:08'),
(64, 38, 10, '2025-06-11 01:54:56', 'RAVE-PDdlxMui', 30.00, 'confirmed', '2025-06-10 23:54:56', '2025-06-10 23:54:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'usuario1', 'primerususario@gmail.com', NULL, '$2y$12$sRpjadPvJDW2bGteBokNSewhQboRhiE1lWQGJ31p2ptJb87roBgn.', NULL, '2025-06-10 14:52:04', '2025-06-10 14:52:04'),
(6, 'usuario2', 'segundousuario@gmail.com', NULL, '$2y$12$UC/WtpLqEgjJQ.PrTjORO.qGF4g32VG4jNtn0CZXy6Fw0TYjPF8lG', NULL, '2025-06-10 14:54:52', '2025-06-10 14:54:52'),
(7, 'usuario3', 'tercerusuario@gmail.com', NULL, '$2y$12$auXUnfI/2zck0LKQ2p2XoeJDTWnr2iK.Lwsxc4R6SSoMx1MPdzy2y', NULL, '2025-06-10 14:56:26', '2025-06-10 14:56:26'),
(8, 'usuario4', 'cuartousuario@gmail.com', NULL, '$2y$12$EslBSuGAzjJS/Mv6o/zb.OXDDGXwg.W.FJmgsKewTX7Ly/7wMd1KK', NULL, '2025-06-10 23:33:27', '2025-06-10 23:33:27'),
(9, 'usuario5', 'quintousuario@gmail.com', NULL, '$2y$12$JSxqXhGDPou8gZoW0Jq2vuGv5k4ZvTfUVghyVoIj3s1sCsWxYTTdm', NULL, '2025-06-10 23:48:49', '2025-06-10 23:48:49'),
(10, 'usuario6', 'sextousuario@gmail.com', NULL, '$2y$12$i49hZVzsq.2XOnZaLby8TuMko0AYoRQlejP4GHmJCI0MreQpmo58m', NULL, '2025-06-10 23:51:58', '2025-06-10 23:51:58');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `events_slug_unique` (`slug`),
  ADD KEY `events_category_id_foreign` (`category_id`),
  ADD KEY `events_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_ticket_id_foreign` (`ticket_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_ticket_code_unique` (`ticket_code`),
  ADD KEY `tickets_event_id_foreign` (`event_id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
