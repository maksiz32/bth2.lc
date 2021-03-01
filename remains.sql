-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 01 2021 г., 13:59
-- Версия сервера: 5.7.25
-- Версия PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `birthdaydb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `remains`
--

CREATE TABLE `remains` (
  `id` int(10) UNSIGNED NOT NULL,
  `tech_id` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `remains`
--

INSERT INTO `remains` (`id`, `tech_id`, `count`, `created_at`, `updated_at`) VALUES
(1, 1, 50, '2021-02-20 08:38:14', '2021-02-26 15:23:24'),
(2, 2, 31, '2021-02-20 08:38:45', '2021-02-26 15:24:09'),
(3, 19, 11, '2021-02-20 08:38:51', '2021-02-26 15:33:04'),
(4, 3, 12, '2021-02-20 08:38:57', '2021-02-26 15:27:48'),
(5, 4, 19, '2021-02-20 08:39:03', '2021-02-26 15:28:50'),
(6, 5, 6, '2021-02-20 08:39:40', '2021-02-26 15:30:04'),
(7, 6, 10, '2021-02-20 08:39:47', '2021-02-24 15:13:49'),
(8, 10, 9, '2021-02-20 08:39:58', '2021-02-26 15:05:44'),
(9, 11, 6, '2021-02-20 08:40:09', '2021-02-26 15:30:12'),
(10, 13, 6, '2021-02-20 08:40:27', '2021-02-26 15:31:05'),
(11, 12, 17, '2021-02-20 08:40:32', '2021-02-26 15:27:01'),
(12, 14, 6, '2021-02-20 08:40:37', '2021-02-26 15:30:23'),
(13, 15, 33, '2021-02-20 08:40:43', '2021-02-26 15:22:52'),
(14, 16, 2, '2021-02-20 08:40:49', '2021-02-26 15:30:33'),
(15, 17, 27, '2021-02-20 08:40:55', '2021-02-26 15:23:42'),
(16, 18, 2, '2021-02-20 08:41:01', '2021-02-26 15:30:44'),
(17, 20, 19, '2021-02-20 08:41:08', '2021-02-26 15:28:14'),
(18, 21, 6, '2021-02-20 08:41:14', '2021-02-26 15:30:54'),
(19, 22, 15, '2021-02-20 08:44:47', '2021-02-20 08:44:47'),
(20, 23, 1, '2021-02-20 08:44:56', '2021-02-20 08:44:56');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `remains`
--
ALTER TABLE `remains`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `remains`
--
ALTER TABLE `remains`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
