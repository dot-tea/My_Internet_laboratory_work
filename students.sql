-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Окт 30 2019 г., 19:20
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
-- База данных: `students`
--

-- --------------------------------------------------------

--
-- Структура таблицы `papercraft`
--

CREATE TABLE `papercraft` (
  `id` int(2) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `date_of_entry` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `attended_lessons` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `papercraft`
--

INSERT INTO `papercraft` (`id`, `student_name`, `date_of_entry`, `email`, `phone_number`, `attended_lessons`) VALUES
(1, 'Иванова Наталья Николаевна', '2019-09-03', 'nata@somewhere.ru', '+74268361612', 5),
(2, 'Александрова Ольга Анатольевна', '2019-09-03', 'whatever@luchshayapochta.ru', '+73289423433', 4),
(3, 'Соколов Антон Валерьевич', '2019-09-03', 'yep@yep.ru', '+73243124132', 3),
(4, 'Кузнецова Елизавета Сергеева', '2019-09-01', 'well@wow.ru', '+79376643423', 8),
(5, 'Пушкин Александр Сергеевич', '2019-10-01', 'well@wow.ru', '+79999999999', 2),
(6, 'Буянов Ладно Океевич', '2008-02-29', 'ladno@vk.com', '+79999999999', 1),
(7, 'Сильвесторов Василий', '2019-09-01', 'pust.budet@ya.ru', '', 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `papercraft`
--
ALTER TABLE `papercraft`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `papercraft`
--
ALTER TABLE `papercraft`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
