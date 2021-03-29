-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 29 2021 г., 11:18
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
-- Структура таблицы `videos`
--

CREATE TABLE `videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `videos`
--

INSERT INTO `videos` (`id`, `file`, `name`, `poster`, `created_at`, `updated_at`) VALUES
(1, 'Pozdravlenie.mp4', 'Поздравление <span class=\"color_red\">2009</span> год', NULL, NULL, NULL),
(2, 'rgs.mp4', 'Поздравление <span class=\"color_red\">90</span> лет', NULL, NULL, NULL),
(3, 'Life_2_x264.mp4', 'История компании <span class=\"color_red\">95</span> лет', NULL, NULL, NULL),
(4, 'the_best_bryansk.mp4', 'Лига лучших. Брянск', NULL, NULL, NULL),
(5, 'history.mp4', 'История компании <span class=\"color_red\">96 лет</span>', NULL, NULL, NULL),
(6, 'f_113_part_2.mp4', 'Вторая часть обучения работе с новыми формами 113.<br /><b>Ответы на вопросы слушателей.</b>', NULL, NULL, NULL),
(7, 'f_113_part_1.mp4', 'Первая часть обучения работе с новыми формами 113', NULL, NULL, NULL),
(8, '1253.mp4', 'Видео от Волковой', NULL, NULL, NULL),
(13, '1585063649_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Техника продаж. Семенова А.В. Часть 3', NULL, '2020-03-24 15:28:14', '2020-03-25 06:46:04'),
(14, '1585063841_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Техника продаж. Семенова А.В. Часть 2', NULL, '2020-03-24 15:30:46', '2020-03-25 06:46:35'),
(15, '1585063905_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Техника продаж. Семенова А.В. Часть 1', NULL, '2020-03-24 15:31:45', '2020-03-25 06:46:59'),
(16, '1585117970_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Телемедицина - программа Доктор Онлайн. Чижман Ю.А', NULL, '2020-03-25 06:32:50', '2020-03-25 06:47:29'),
(17, '1585118129_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Телемедицина - программа Доктор Онлайн. Ашфак', NULL, '2020-03-25 06:36:05', '2020-03-25 06:47:57'),
(18, '1585118294_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Современные технологии лечения онкологических заболеваний. Ю. Чернышева', NULL, '2020-03-25 06:39:56', '2020-03-25 06:48:31'),
(19, '1585119331_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Современные технологии лечения онкологических заболеваний. Лядов К.В.', NULL, '2020-03-25 06:56:45', '2020-03-25 06:56:45'),
(20, '1585120313_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Проблемы онкологических пациентов в России и пути их решения. Боровова И.В.', NULL, '2020-03-25 07:13:38', '2020-03-25 07:32:09'),
(21, '1585121669_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Примеры клиник. Суслова В.Н. Санделюк В.С.', NULL, '2020-03-25 07:34:29', '2020-03-25 07:34:29'),
(22, '1585121798_videoalbum.mp4', 'Новые <b><span class=\"text-danger\">КСП</span></b> - какие виды страхования мы выбрали и почему. Меркулов О.Ю. часть 3', NULL, '2020-03-25 07:36:42', '2020-03-25 07:36:42'),
(23, '1585121899_videoalbum.mp4', 'Новые <b><span class=\"text-danger\">КСП</span></b> - какие виды страхования мы выбрали и почему. Меркулов О.Ю. часть 2', NULL, '2020-03-25 07:38:44', '2020-03-25 07:38:44'),
(24, '1585122585_videoalbum.mp4', '<b><span class=\"text-danger\">КСП</span></b> - какие виды страхования мы выбрали и почему. Меркулов О.Ю. часть 1', NULL, '2020-03-25 07:50:09', '2020-03-25 07:50:09'),
(25, '1585127024_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Компания РОСГОССТРАХ Жизнь. программы страхования РГС Жизнь. Смирнова Ю.А.', NULL, '2020-03-25 09:03:58', '2020-03-25 09:03:58'),
(26, '1585127248_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Выполнение плановых показателей по агентской сети и офисному каналу продаж, история успешного развития продаж КСП. Конкин С.В.', NULL, '2020-03-25 09:07:56', '2020-03-25 09:07:56'),
(27, '1585127623_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Возможности КСП Помощь на дороге. И. Тимофеев', NULL, '2020-03-25 09:14:22', '2020-03-25 09:14:22'),
(28, '1585127866_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Нюансы новых программ ДМС. Купцова О.А.', NULL, '2020-03-25 09:18:16', '2020-03-25 09:25:48'),
(29, '1585128572_videoalbum.mp4', '<b><span class=\"text-danger\">КСП.</span></b> Введение Шабанова Ю.А.', NULL, '2020-03-25 09:29:32', '2020-03-25 09:29:32'),
(30, '1594198275_videoalbum.mp4', 'Формирование АПП (агентсткий портал)', 'app.jpg', '2020-07-08 08:51:15', '2020-07-08 08:51:15'),
(31, '1594198312_videoalbum.mp4', 'Формирование Счета (агентский портал)', 'pa-check.jpg', '2020-07-08 08:51:52', '2020-07-08 08:51:52'),
(32, '1595515817_videoalbum.mp4', '<b><span class=\"text-danger\">ТЕССА.</span></b> Урок 4. Настройка объектов системы (Часть_2)', 'objects-2.jpg', '2020-07-23 14:50:33', '2020-07-24 09:42:49'),
(33, '1595515950_videoalbum.mp4', '<b><span class=\"text-danger\">ТЕССА.</span></b> Урок 5. Настройка объектов системы (Часть_3)', 'objects-3.jpg', '2020-07-23 14:52:33', '2020-07-24 09:42:16'),
(34, '1595516949_videoalbum.mp4', '<b><span class=\"text-danger\">ТЕССА.</span></b> Урок 6. Права доступа и ролевая модель, временные зоны', 'roules.jpg', '2020-07-23 15:09:28', '2020-07-24 09:41:50'),
(35, '1595517054_videoalbum.mp4', '<b><span class=\"text-danger\">ТЕССА.</span></b> Урок 7. Синхронизация с ActiveDirectory (LDAP), Kerberos, потоковое сканирование', 'ad.jpg', '2020-07-23 15:10:58', '2020-07-24 09:42:27'),
(36, '1595517168_videoalbum.mp4', '<b><span class=\"text-danger\">ТЕССА.</span></b> Урок 8. Шаблоны файлов. Виртуальные файлы (часть_1)', 'layouts-1.jpg', '2020-07-23 15:12:51', '2020-07-24 09:40:50'),
(37, '1595517402_videoalbum.mp4', '<b><span class=\"text-danger\">ТЕССА.</span></b> Урок 9. Шаблоны файлов. Виртуальные файлы (часть 2). Обсуждения и уведомления', 'layouts-2.jpg', '2020-07-23 15:16:49', '2020-07-23 15:16:49'),
(38, '1595517649_videoalbum.mp4', '<b><span class=\"text-danger\">ТЕССА.</span></b> Урок 10. Обновление системы на новую версию', 'updates.jpg', '2020-07-23 15:20:52', '2020-07-24 09:40:29'),
(39, '1595517911_videoalbum.mp4', '<b><span class=\"text-danger\">ТЕССА.</span></b> Урок 11. Введение в маршруты документов (Часть_1)', 'tessa-rout-1.jpg', '2020-07-23 15:25:24', '2020-07-24 09:40:12'),
(40, '1595518041_videoalbum.mp4', '<b><span class=\"text-danger\">ТЕССА.</span></b> Урок 12. Введение в маршруты документов (Часть_2)', 'tessa-rout-2.jpg', '2020-07-23 15:27:34', '2020-07-24 09:39:48'),
(41, '1606386103_videoalbum.mp4', 'РГС ЗДОРОВЬЕ', 'health.jpg', '2020-11-26 10:23:18', '2020-11-26 10:23:18');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_file_name_index` (`file`,`name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
