-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 23 2020 г., 16:57
-- Версия сервера: 10.4.6-MariaDB
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `middb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `friend` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `friends`
--

INSERT INTO `friends` (`id`, `user`, `friend`) VALUES
(3, 3, 1),
(4, 1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `profile_wall`
--

CREATE TABLE `profile_wall` (
  `id` int(11) NOT NULL,
  `text` text COLLATE utf8mb4_bin NOT NULL,
  `user` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `profile_wall`
--

INSERT INTO `profile_wall` (`id`, `text`, `user`, `date`) VALUES
(1, 'fsdf', 1, '2020-03-23'),
(2, 'test', 1, '2020-03-23'),
(3, 'teset2', 1, '2020-03-23'),
(4, 'fs', 1, '2020-03-23'),
(5, 'Ð°Ñ‹Ð²', 1, '2020-03-23'),
(6, 'test', 1, '2020-03-23'),
(7, 'test', 2, '2020-03-23'),
(8, 'test', 3, '2020-03-23'),
(9, 'qwe\n', 3, '2020-03-23'),
(10, '342', 3, '2020-03-23'),
(11, 'efsd', 3, '2020-03-23'),
(12, 'efsd', 3, '2020-03-23'),
(13, '555555', 3, '2020-03-23');

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `date` date NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `user`, `user_to`, `date`, `accepted`) VALUES
(1, 1, 3, '2020-03-23', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `date_birth` date NOT NULL,
  `date_registration` date NOT NULL,
  `hash` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_bin DEFAULT '../asserts/images/users/user.png',
  `city` varchar(255) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `gender`, `phone_number`, `date_birth`, `date_registration`, `hash`, `image_path`, `city`) VALUES
(1, 'Adil', 'Hamidullov', '296221ea3c8015c3b18a6d881701e984', 'Female', '87751840677', '2222-02-22', '2020-03-22', '652812ccd4b47297d24c3ccad6a9e93e', '../asserts/images/users/images.jpg', ''),
(2, 'Almas', 'Namazbaev', '296221ea3c8015c3b18a6d881701e984', 'Male', '87715970970', '2020-02-20', '2020-03-23', 'ac2b58dd5564b4ad9907f6cdde0218da', '../asserts/images/users/images.jpg', ''),
(3, 'Test', 'Test', '296221ea3c8015c3b18a6d881701e984', 'Male', '123456', '2222-02-22', '2020-03-23', 'c9a9fa757febb0280012bd9af91e69d0', '../asserts/images/users/user.png	', '');

-- --------------------------------------------------------

--
-- Структура таблицы `wall`
--

CREATE TABLE `wall` (
  `id` int(11) NOT NULL,
  `text` text COLLATE utf8mb4_bin NOT NULL,
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `wall`
--

INSERT INTO `wall` (`id`, `text`, `user`, `date`) VALUES
(2, 'test', 2, '2020-03-23 00:00:00'),
(3, 'test', 3, '2020-03-23 00:00:00'),
(4, 'qwe\n', 3, '2020-03-23 00:00:00'),
(6, 'efsd', 3, '2020-03-23 00:00:00'),
(8, 'fsd', 3, '2020-03-23 15:18:15');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `profile_wall`
--
ALTER TABLE `profile_wall`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone_number`);

--
-- Индексы таблицы `wall`
--
ALTER TABLE `wall`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `profile_wall`
--
ALTER TABLE `profile_wall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `wall`
--
ALTER TABLE `wall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
