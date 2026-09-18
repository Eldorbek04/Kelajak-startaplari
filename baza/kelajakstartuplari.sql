-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Сен 11 2026 г., 15:34
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kelajakstartuplari`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `region_id` bigint(20) UNSIGNED NOT NULL,
  `name_uz` varchar(255) NOT NULL,
  `name_ru` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `districts`
--

INSERT INTO `districts` (`id`, `region_id`, `name_uz`, `name_ru`, `name_en`, `created_at`, `updated_at`) VALUES
(1, 10, 'Guliston shahri', 'г. Гулистан', 'Gulistan city', '2026-09-11 12:23:24', '2026-09-11 12:23:24'),
(2, 10, 'Shirin shahri', 'г. Ширин', 'Shirin city', '2026-09-11 12:23:24', '2026-09-11 12:23:24'),
(3, 10, 'Yangiyer shahri', 'г. Янгиер', 'Yangiyer city', '2026-09-11 12:23:24', '2026-09-11 12:23:24'),
(4, 10, 'Oqoltin tumani', 'Акалтынский район', 'Akaltin district', '2026-09-11 12:23:24', '2026-09-11 12:23:24'),
(5, 10, 'Boyovut tumani', 'Баяутский район', 'Boyovut district', '2026-09-11 12:23:24', '2026-09-11 12:23:24'),
(6, 10, 'Guliston tumani', 'Гулистанский район', 'Gulistan district', '2026-09-11 12:23:24', '2026-09-11 12:23:24'),
(7, 10, 'Mirzaobod tumani', 'Мирзаабадский район', 'Mirzaabad district', '2026-09-11 12:23:24', '2026-09-11 12:23:24'),
(8, 10, 'Sardoba tumani', 'Сардобский район', 'Sardoba district', '2026-09-11 12:23:24', '2026-09-11 12:23:24'),
(9, 10, 'Sayxunobod tumani', 'Сайхунабадский район', 'Saykhunabad district', '2026-09-11 12:23:24', '2026-09-11 12:23:24'),
(10, 10, 'Sirdaryo tumani', 'Сырдарьинский район', 'Sirdaryo district', '2026-09-11 12:23:24', '2026-09-11 12:23:24'),
(11, 10, 'Hovos tumani', 'Хавастский район', 'Hovos district', '2026-09-11 12:23:24', '2026-09-11 12:23:24'),
(12, 1, 'Bektemir tumani', 'Бектемирский район', 'Bektemir district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(13, 1, 'Mirzo Ulugʻbek tumani', 'Мирзо-Улугбекский район', 'Mirzo Ulugbek district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(14, 1, 'Mirobod tumani', 'Мирабадский район', 'Mirobod district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(15, 1, 'Olmazor tumani', 'Алмазарский район', 'Olmazor district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(16, 1, 'Sirgʻali tumani', 'Сергелийский район', 'Sergeli district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(17, 1, 'Uchtepa tumani', 'Учтепинский район', 'Uchtepa district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(18, 1, 'Yashnobod tumani', 'Яшнабадский район', 'Yashnabod district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(19, 1, 'Chilonzor tumani', 'Чиланзарский район', 'Chilonzor district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(20, 1, 'Shayxontohur tumani', 'Шайхантахурский район', 'Shayxontohur district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(21, 1, 'Yunusobod tumani', 'Юнусабадский район', 'Yunusabad district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(22, 1, 'Yakkasaroy tumani', 'Яккасарайский район', 'Yakkasaray district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(23, 1, 'Yangihayot tumani', 'Янгихаётский район', 'Yangihayot district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(24, 3, 'Andijon shahri', 'г. Андижан', 'Andijan city', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(25, 3, 'Xonobod shahri', 'г. Ханабад', 'Khanabad city', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(26, 3, 'Andijon tumani', 'Андижанский район', 'Andijan district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(27, 3, 'Asaka tumani', 'Асакинский район', 'Asaka district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(28, 3, 'Baliqchi tumani', 'Балыкчинский район', 'Baliqchi district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(29, 3, 'Buloqboshi tumani', 'Булакбашинский район', 'Buloqboshi district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(30, 3, 'Boʻston tumani', 'Бостонский район', 'Boston district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(31, 3, 'Jalaquduq tumani', 'Джалалкудукский район', 'Jalaquduq district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(32, 3, 'Izboskan tumani', 'Избасканский район', 'Izboskan district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(33, 3, 'Qoʻrgʻontepa tumani', 'Кургантепинский район', 'Kurgantepa district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(34, 3, 'Marhamat tumani', 'Мархаматский район', 'Marhamat district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(35, 3, 'Paxtaobod tumani', 'Пахтаабадский район', 'Paxtaobod district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(36, 3, 'Ulugʻnor tumani', 'Улугнорский район', 'Ulugnor district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(37, 3, 'Xoʻjaobod tumani', 'Ходжаабадский район', 'Khojaobod district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(38, 3, 'Shahrixon tumani', 'Шахриханский район', 'Shahrixon district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(39, 10, 'Guliston shahri', 'г. Гулистан', 'Gulistan city', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(40, 10, 'Shirin shahri', 'г. Ширин', 'Shirin city', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(41, 10, 'Yangiyer shahri', 'г. Янгиер', 'Yangiyer city', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(42, 10, 'Oqoltin tumani', 'Акалтынский район', 'Akaltin district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(43, 10, 'Boyovut tumani', 'Баяутский район', 'Boyovut district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(44, 10, 'Guliston tumani', 'Гулистанский район', 'Gulistan district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(45, 10, 'Mirzaobod tumani', 'Мирзаабадский район', 'Mirzaabad district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(46, 10, 'Sardoba tumani', 'Сардобский район', 'Sardoba district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(47, 10, 'Sayxunobod tumani', 'Сайхунабадский район', 'Saykhunabad district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(48, 10, 'Sirdaryo tumani', 'Сырдарьинский район', 'Sirdaryo district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(49, 10, 'Hovos tumani', 'Хавастский район', 'Hovos district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(50, 9, 'Samarqand shahri', 'г. Самарканд', 'Samarkand city', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(51, 9, 'Kattaqoʻrgʻon shahri', 'г. Каттакурган', 'Kattakurgan city', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(52, 9, 'Oqdaryo tumani', 'Акдарьинский район', 'Akdarya district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(53, 9, 'Bulungʻur tumani', 'Булунгурский район', 'Bulungur district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(54, 9, 'Jomboy tumani', 'Джамбайский район', 'Jomboy district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(55, 9, 'Ishtixon tumani', 'Иштыханский район', 'Ishtixon district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(56, 9, 'Kattaqoʻrgʻon tumani', 'Каттакурганский район', 'Kattakurgan district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(57, 9, 'Qoʻshrabot tumani', 'Кошрабатский район', 'Koshrabat district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(58, 9, 'Narpay tumani', 'Нарпайский район', 'Narpay district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(59, 9, 'Nurabod tumani', 'Нурабадский район', 'Nurabod district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(60, 9, 'Payariq tumani', 'Пайарыкский район', 'Payariq district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(61, 9, 'Pastdargʻom tumani', 'Пастдаргомский район', 'Pastdargom district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(62, 9, 'Paxtachi tumani', 'Пахтачинский район', 'Paxtachi district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(63, 9, 'Samarqand tumani', 'Самаркандский район', 'Samarkand district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(64, 9, 'Toyloq tumani', 'Тойлакский район', 'Toyloq district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(65, 9, 'Urgut tumani', 'Ургутский район', 'Urgut district', '2026-09-11 12:25:45', '2026-09-11 12:25:45'),
(66, 4, 'Buxoro shahri', 'г. Бухара', 'Bukhara city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(67, 4, 'Kogon shahri', 'г. Каган', 'Kogon city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(68, 4, 'Buxoro tumani', 'Бухарский район', 'Bukhara district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(69, 4, 'Vobkent tumani', 'Вобкентский район', 'Vobkent district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(70, 4, 'Gʻijduvon tumani', 'Гиждуванский район', 'Gijduvon district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(71, 4, 'Kogon tumani', 'Каганский район', 'Kogon district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(72, 4, 'Qorakoʻl tumani', 'Каракульский район', 'Karakul district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(73, 4, 'Qorovulbozor tumani', 'Караулбазарский район', 'Qorovulbozor district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(74, 4, 'Peshku tumani', 'Пешкунский район', 'Peshku district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(75, 4, 'Romitan tumani', 'Ромитанский район', 'Romitan district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(76, 4, 'Jondor tumani', 'Жондорский район', 'Jondor district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(77, 4, 'Olot tumani', 'Алатский район', 'Olot district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(78, 12, 'Fargʻona shahri', 'г. Фергана', 'Fergana city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(79, 12, 'Quvasoy shahri', 'г. Кувасай', 'Kuvasoy city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(80, 12, 'Margʻilon shahri', 'г. Маргилан', 'Margilan city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(81, 12, 'Qoʻqon shahri', 'г. Коканд', 'Kokand city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(82, 12, 'Oltiariq tumani', 'Алтыарыкский район', 'Oltiariq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(83, 12, 'Bogʻdod tumani', 'Багдадский район', 'Bogdod district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(84, 12, 'Beshariq tumani', 'Бешарыкский район', 'Beshariq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(85, 12, 'Buvayda tumani', 'Бувайдинский район', 'Buvayda district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(86, 12, 'Dangʻara tumani', 'Дангаринский район', 'Dangara district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(87, 12, 'Yozyovon tumani', 'Язъяванский район', 'Yozyovon district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(88, 12, 'Quva tumani', 'Кувинский район', 'Quva district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(89, 12, 'Qoʻshtepa tumani', 'Куштепинский район', 'Qoshtepa district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(90, 12, 'Rishton tumani', 'Риштанский район', 'Rishton district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(91, 12, 'Soʻx tumani', 'Сохский район', 'Sokh district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(92, 12, 'Toshloq tumani', 'Ташлакский район', 'Toshloq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(93, 12, 'Uchkoʻprik tumani', 'Учкуприкский район', 'Uchkoprik district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(94, 12, 'Fargʻona tumani', 'Ферганский район', 'Fergana district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(95, 5, 'Jizzax shahri', 'г. Джизак', 'Jizzakh city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(96, 5, 'Arnasoy tumani', 'Арнасайский район', 'Arnasoy district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(97, 5, 'Baxmal tumani', 'Бахмальский район', 'Baxmal district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(98, 5, 'Gʻallaorol tumani', 'Галляаральский район', 'Gallaorol district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(99, 5, 'Sharof Rashidov tumani', 'Шароф Рашидовский район', 'Sharof Rashidov district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(100, 5, 'Doʻstlik tumani', 'Дустликский район', 'Dustlik district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(101, 5, 'Zafarobod tumani', 'Зафарабадский район', 'Zafarobod district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(102, 5, 'Zarbdor tumani', 'Зарбдарский район', 'Zarbdor district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(103, 5, 'Mirzachoʻl tumani', 'Мирзачульский район', 'Mirzachul district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(104, 5, 'Paxtakor tumani', 'Пахтакорский район', 'Paxtakor district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(105, 5, 'Forish tumani', 'Форишский район', 'Forish district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(106, 5, 'Yangiobod tumani', 'Янгиабадский район', 'Yangiobod district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(107, 8, 'Namangan shahri', 'г. Наманган', 'Namangan city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(108, 8, 'Kosonsoy tumani', 'Касансайский район', 'Kosonsoy district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(109, 8, 'Mingbuloq tumani', 'Мингбулакский район', 'Mingbuloq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(110, 8, 'Namangan tumani', 'Наманганский район', 'Namangan district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(111, 8, 'Norin tumani', 'Нарынский район', 'Norin district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(112, 8, 'Pop tumani', 'Папский район', 'Pop district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(113, 8, 'Toʻraqoʻrgʻon tumani', 'Туракурганский район', 'Toraqorgon district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(114, 8, 'Uychi tumani', 'Уйчинский район', 'Uychi district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(115, 8, 'Uchqoʻrgʻon tumani', 'Учкурганский район', 'Uchqorgon district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(116, 8, 'Chortoq tumani', 'Чартакский район', 'Chortoq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(117, 8, 'Chust tumani', 'Чустский район', 'Chust district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(118, 8, 'Yangiqoʻrgʻon tumani', 'Янгикурганский район', 'Yangiqorgon district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(119, 7, 'Navoiy shahri', 'г. Навои', 'Navoi city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(120, 7, 'Zarafshon shahri', 'г. Зарафшан', 'Zarafshon city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(121, 7, 'Gʻozgʻon shahri', 'г. Газган', 'Gozgon city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(122, 7, 'Karmana tumani', 'Карманинский район', 'Karmana district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(123, 7, 'Qiziltepa tumani', 'Кызылтепинский район', 'Qiziltepa district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(124, 7, 'Navbahor tumani', 'Навбахорский район', 'Navbahor district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(125, 7, 'Nurota tumani', 'Нуратинский район', 'Nurota district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(126, 7, 'Tomdi tumani', 'Учкудукский район', 'Tomdi district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(127, 7, 'Uchquduq tumani', 'Учкудукский район', 'Uchquduq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(128, 7, 'Xatirchi tumani', 'Хатырчинский район', 'Xatirchi district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(129, 6, 'Qarshi shahri', 'г. Карши', 'Qarshi city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(130, 6, 'Shahrisabz shahri', 'г. Шахрисабз', 'Shahrisabz city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(131, 6, 'Dehqonobod tumani', 'Дехканабадский район', 'Dehqonobod district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(132, 6, 'Gʻuzor tumani', 'Гузарский район', 'Guzor district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(133, 6, 'Qamashi tumani', 'Камашинский район', 'Qamashi district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(134, 6, 'Qarshi tumani', 'Каршинский район', 'Qarshi district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(135, 6, 'Kasbi tumani', 'Касбийский район', 'Kasbi district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(136, 6, 'Kitob tumani', 'Китабский район', 'Kitob district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(137, 6, 'Mirishkor tumani', 'Миришкорский район', 'Mirishkor district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(138, 6, 'Muborak tumani', 'Мубарекский район', 'Muborak district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(139, 6, 'Nishon tumani', 'Нишанский район', 'Nishon district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(140, 6, 'Chiroqchi tumani', 'Чиракчинский район', 'Chiroqchi district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(141, 6, 'Shahrisabz tumani', 'Шахрисабзский район', 'Shahrisabz district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(142, 6, 'Yakkabogʻ tumani', 'Яккабагский район', 'Yakkabog district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(143, 14, 'Nukus shahri', 'г. Нукус', 'Nukus city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(144, 14, 'Amudaryo tumani', 'Амударьинский район', 'Amudaryo district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(145, 14, 'Beruniy tumani', 'Берунийский район', 'Beruniy district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(146, 14, 'Kegeyli tumani', 'Кегейлийский район', 'Kegeyli district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(147, 14, 'Qoʻngʻirot tumani', 'Кунградский район', 'Qongirot district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(148, 14, 'Qanlikoʻl tumani', 'Канлыкульский район', 'Qanlikol district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(149, 14, 'Moʻynoq tumani', 'Муйнакский район', 'Moynoq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(150, 14, 'Nukus tumani', 'Нукусский район', 'Nukus district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(151, 14, 'Taxiatosh tumani', 'Тахиаташский район', 'Taxiatosh district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(152, 14, 'Taxtakoʻpir tumani', 'Тахтакупырский район', 'Taxtakopir district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(153, 14, 'Toʻrtkoʻl tumani', 'Турткульский район', 'Tortkol district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(154, 14, 'Xoʻjayli tumani', 'Ходжейлийский район', 'Xojayli district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(155, 14, 'Chimboy tumani', 'Чимбайский район', 'Chimboy district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(156, 14, 'Shumanay tumani', 'Шуманайский район', 'Shumanay district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(157, 14, 'Ellikqalʼa tumani', 'Элликкалинский район', 'Ellikqala district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(158, 11, 'Termiz shahri', 'г. Термез', 'Termez city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(159, 11, 'Angor tumani', 'Ангорский район', 'Angor district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(160, 11, 'Boysun tumani', 'Байсунский район', 'Boysun district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(161, 11, 'Denov tumani', 'Денауский район', 'Denov district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(162, 11, 'Jarqoʻrgʻon tumani', 'Джаркурганский район', 'Jarqorgon district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(163, 11, 'Qiziriq tumani', 'Кизирыкский район', 'Qiziriq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(164, 11, 'Qumqoʻrgʻon tumani', 'Кумкурганский район', 'Qumqorgon district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(165, 11, 'Muzrabot tumani', 'Музрабадский район', 'Muzrabot district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(166, 11, 'Sariosiyo tumani', 'Сариасийский район', 'Sariosiyo district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(167, 11, 'Termiz tumani', 'Термезский район', 'Termez district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(168, 11, 'Uzun tumani', 'Узунский район', 'Uzun district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(169, 11, 'Sherobod tumani', 'Шерабадский район', 'Sherobod district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(170, 11, 'Shoʻrchi tumani', 'Шурчинский район', 'Shorchi district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(171, 2, 'Olmaliq shahri', 'г. Алмалык', 'Almalyk city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(172, 2, 'Angren shahri', 'г. Ангрен', 'Angren city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(173, 2, 'Bekobod shahri', 'г. Бекабад', 'Bekabad city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(174, 2, 'Nurafshon shahri', 'г. Нурафшан', 'Nurafshon city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(175, 2, 'Oʻrta Chirchiq tumani', 'Урта-Чирчикский район', 'Orta Chirchiq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(176, 2, 'Boʻka tumani', 'Букинский район', 'Buka district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(177, 2, 'Boʻstonliq tumani', 'Бостанлыкский район', 'Bostonliq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(178, 2, 'Zangiota tumani', 'Зангиатинский район', 'Zangiota district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(179, 2, 'Qibray tumani', 'Кибрайский район', 'Qibray district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(180, 2, 'Quyi Chirchiq tumani', 'Куйи-Чирчикский район', 'Quyi Chirchiq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(181, 2, 'Parkent tumani', 'Паркентский район', 'Parkent district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(182, 2, 'Piskent tumani', 'Пскентский район', 'Piskent district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(183, 2, 'Toshkent tumani', 'Ташкентский район', 'Tashkent district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(184, 2, 'Chinoz tumani', 'Чиназский район', 'Chinoz district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(185, 2, 'Yuqori Chirchiq tumani', 'Юкори-Чирчикский район', 'Yuqori Chirchiq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(186, 2, 'Yangiyoʻl tumani', 'Янгиюльский район', 'Yangiyol district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(187, 13, 'Urganch shahri', 'г. Ургенч', 'Urgench city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(188, 13, 'Xiva shahri', 'г. Хива', 'Khiva city', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(189, 13, 'Bogʻot tumani', 'Багатский район', 'Bogot district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(190, 13, 'Gurlan tumani', 'Гурленский район', 'Gurlan district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(191, 13, 'Qoʻshkoʻpir tumani', 'Кошкупрский район', 'Qoshkopir district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(192, 13, 'Urganch tumani', 'Ургенчский район', 'Urgench district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(193, 13, 'Hazorasp tumani', 'Хазараспский район', 'Hazorasp district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(194, 13, 'Xiva tumani', 'Хивинский район', 'Khiva district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(195, 13, 'Shovot tumani', 'Шаватский район', 'Shovot district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(196, 13, 'Yangiariq tumani', 'Янгиарыкский район', 'Yangiariq district', '2026-09-11 12:28:59', '2026-09-11 12:28:59'),
(197, 13, 'Yangibozor tumani', 'Янгибазарский район', 'Yangibozor district', '2026-09-11 12:28:59', '2026-09-11 12:28:59');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
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
-- Структура таблицы `jobs`
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
-- Структура таблицы `job_batches`
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
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_13_180000_create_regions_table', 1),
(5, '2026_02_13_180001_create_districts_table', 1),
(6, '2026_04_03_111638_alter_users_for_phone_auth_and_create_otp_codes_table', 1),
(7, '2026_04_03_203142_create_project_submissions_table', 1),
(8, '2026_04_05_184901_add_user_id_and_status_to_project_submissions_table', 1),
(9, '2026_04_05_193741_add_unique_user_id_to_project_submissions_table', 1),
(10, '2026_04_05_200559_add_admin_workflow_fields_to_project_submissions_table', 1),
(11, '2026_06_26_143558_remove_district_stage_workflow_from_project_submissions_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `otp_codes`
--

CREATE TABLE `otp_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `project_submissions`
--

CREATE TABLE `project_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `project_title` varchar(255) NOT NULL,
  `required_budget` bigint(20) UNSIGNED NOT NULL,
  `region_id` bigint(20) UNSIGNED NOT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `document_path` varchar(255) NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'new',
  `rejection_reason` text DEFAULT NULL,
  `region_date` date DEFAULT NULL,
  `region_time` varchar(16) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_uz` varchar(255) NOT NULL,
  `name_ru` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `regions`
--

INSERT INTO `regions` (`id`, `name_uz`, `name_ru`, `name_en`, `created_at`, `updated_at`) VALUES
(1, 'Toshkent shahri', 'г. Ташкент', 'Tashkent city', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(2, 'Toshkent viloyati', 'Ташкентская область', 'Tashkent region', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(3, 'Andijon viloyati', 'Андижанская область', 'Andijan region', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(4, 'Buxoro viloyati', 'Бухарская область', 'Bukhara region', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(5, 'Jizzax viloyati', 'Джизакская область', 'Jizzakh region', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(6, 'Qashqadaryo viloyati', 'Кашкадарьинская область', 'Kashkadarya region', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(7, 'Navoiy viloyati', 'Навоийская область', 'Navoi region', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(8, 'Namangan viloyati', 'Наманганская область', 'Namangan region', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(9, 'Samarqand viloyati', 'Самаркандская область', 'Samarkand region', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(10, 'Sirdaryo viloyati', 'Сырдарьинская область', 'Sirdaryo region', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(11, 'Surxondaryo viloyati', 'Сурхандарьинская область', 'Surkhandarya region', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(12, 'Fargʻona viloyati', 'Ферганская область', 'Fergana region', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(13, 'Xorazm viloyati', 'Хорезмская область', 'Khorezm region', '2026-09-11 12:21:40', '2026-09-11 12:21:40'),
(14, 'Qoraqalpogʻiston Respublikasi', 'Республика Каракалпакстан', 'Republic of Karakalpakstan', '2026-09-11 12:21:40', '2026-09-11 12:21:40');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `region_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `password`, `remember_token`, `created_at`, `updated_at`, `full_name`, `phone`, `role`, `region_id`) VALUES
(7, '$2y$12$X8hI24q7a62.Af9.RhkY1.BbVw5HHHZMVf0W4SDrOWCtoJTuYn7VG', NULL, '2026-09-11 13:45:09', '2026-09-11 13:45:09', 'Rayimjonov Eldorbek', '+998979090219', 'super_admin', NULL),
(9, '$2y$12$yMpuSajKviURD01lHpFuruiEJG5h6bUfvW83xDShUfGKuoEiOwmrm', NULL, '2026-09-11 14:54:09', '2026-09-11 14:54:09', 'Nurmaxamadov Xusan', '+998935736144', 'region_admin', 10);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Индексы таблицы `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Индексы таблицы `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `1` (`region_id`),
  ADD KEY `districts_name_uz_index` (`name_uz`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Индексы таблицы `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `otp_codes`
--
ALTER TABLE `otp_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otp_codes_phone_index` (`phone`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `project_submissions`
--
ALTER TABLE `project_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_submissions_user_id_unique` (`user_id`),
  ADD KEY `project_submissions_region_id_foreign` (`region_id`),
  ADD KEY `project_submissions_district_id_foreign` (`district_id`);

--
-- Индексы таблицы `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regions_name_uz_index` (`name_uz`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_region_id_foreign` (`region_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `project_submissions`
--
ALTER TABLE `project_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `1` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `project_submissions`
--
ALTER TABLE `project_submissions`
  ADD CONSTRAINT `project_submissions_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`),
  ADD CONSTRAINT `project_submissions_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`),
  ADD CONSTRAINT `project_submissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
