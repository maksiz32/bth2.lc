-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'admin',	'admin@gmail.com',	'admin',	NULL,	'$2y$10$AQ16uxwMo9xZCs3H3qow1.6PApE4IiH2TTP61Oge1QqVVqZaIj01O',	'8LJllm0STXyZJ1x1VDvTf2eWHNxGUMfBEw2pH4gRL5XKeGC9CQYpwbyd3rDE',	'2019-06-17 13:57:15',	'2019-06-17 13:57:15'),
(3,	'MVManzulin',	'maksim_manzulin@bryansk.rgs.ru',	'admin',	NULL,	'$2y$10$17.QQ9QcI687XHa8HGIe8eDNX0UpCivMXMpAT6hUbbpIW4bWulThi',	'rzAPjWccfNjrTnfbIoSrevRfwWmk5bhlzYthwAl1sqtjoKj1JLzYIBVxcCv8',	'2019-07-05 11:06:30',	'2019-07-05 11:06:30'),
(4,	'VVSpinskiy',	'vladislav_spinskiy@bryansk.rgs.ru',	'admin',	NULL,	'$2y$10$0YncHj1meSf71Zlpdsk1jeO2pwjkelgSzkR6xfDnR7CkSYWHXW8PK',	NULL,	'2019-07-05 11:07:37',	'2019-07-05 11:07:37'),
(5,	'IALozbineva',	'kadry@bryansk.rgs.ru',	'user',	NULL,	'$2y$10$0VXz8tcK9mKhm.HPjS7eSOvpIPsoywkTskmxRofu55TKXE5N4SYiW',	'61LaFl2QJUwzn1o86sd0xhprJxkiUepz6GeXqMiTD9FK2BoXXdFJX0pPKwVD',	'2019-07-05 11:08:22',	'2019-07-05 11:08:22'),
(6,	'MPBulavka',	'rgs@bryansk.rgs.ru',	'user',	NULL,	'$2y$10$VmsC2dXvV2wvykq4pP0ViulAMsf48ZFhhRTsmtbcoDk/4nT0dd7qS',	'mjHHzAzefPegQkkMjG1ZNPMZuVMrVFHYGVrWmKKz7GYCi0Sam9jN5bAzk9ev',	'2019-07-05 11:09:20',	'2019-07-05 11:09:20');

-- 2019-10-22 06:56:57
