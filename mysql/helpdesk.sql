-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 25 2015 г., 21:56
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.4.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `helpdesk`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `comment_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`id`, `ticket_id`, `text`, `user`, `comment_time`) VALUES
(1, 13, 'Текст сообщения', 'Пользователь', '0000-00-00 00:00:00'),
(2, 13, 'Еще текст сообщения', 'Инженер', '0000-00-00 00:00:00'),
(3, 13, 'Проверка комментария от инженера', 'Инженер', '0000-00-00 00:00:00'),
(4, 13, 'Еще проверка', 'Инженер', '2015-04-04 10:14:19'),
(5, 13, 'Проверка последовательности комментариев', 'Инженер', '2015-04-04 10:18:07'),
(6, 3, 'Проверка на закрытом тикете', 'Инженер', '2015-04-04 10:18:45'),
(7, 13, 'А это комментарий от пользователя', 'Пользователь', '2015-04-04 10:19:15'),
(8, 2, 'gsdfgsdfg', 'Пользователь', '2015-09-09 23:33:09'),
(9, 2, 'sdfgsdgf', 'Пользователь', '2015-09-09 23:33:16'),
(10, 127, 'ываыва', 'Пользователь', '2015-09-12 13:07:40'),
(11, 125, 'dgsdg', 'Инженер', '2015-09-13 00:17:30'),
(12, 125, '', 'Инженер', '2015-09-13 00:17:35'),
(13, 125, '', 'Инженер', '2015-09-13 00:17:36'),
(14, 124, '', 'Инженер', '2015-09-13 00:18:41'),
(15, 124, '', 'Инженер', '2015-09-13 00:19:26'),
(16, 121, '', 'Инженер', '2015-09-13 00:20:57'),
(17, 125, 'dfgsdgf', 'Инженер', '2015-09-13 00:22:53');

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link_id` varchar(50) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `real_filename` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`id`, `text`, `datetime`) VALUES
(1, 'Будет отключено электричество', '2015-03-17 00:00:00'),
(2, 'Профилактические мероприятия на сервере', '2015-03-25 00:00:00'),
(3, 'првоерка\r\n', '2015-04-04 10:51:15'),
(4, 'dsfg', '2015-06-04 20:17:53'),
(5, '', '2015-09-12 14:59:25');

-- --------------------------------------------------------

--
-- Структура таблицы `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) DEFAULT NULL,
  `text` text,
  `datetime_add` datetime DEFAULT NULL,
  `datetime_end` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `aud` varchar(255) DEFAULT NULL,
  `otdel` varchar(255) DEFAULT NULL,
  `fio` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `inv_number` varchar(255) DEFAULT NULL,
  `computer_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `complete_text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=131 ;

--
-- Дамп данных таблицы `ticket`
--

INSERT INTO `ticket` (`id`, `category`, `text`, `datetime_add`, `datetime_end`, `status`, `address`, `aud`, `otdel`, `fio`, `phone`, `inv_number`, `computer_name`, `user_id`, `complete_text`) VALUES
(1, 1, 'Принтер заминает бумагу', '2015-03-24 15:00:00', '2015-03-31 23:43:05', 1, '', '', '', '', '', '', 'comp', 1, ''),
(2, 2, 'Не работает программа студент Не работает программа студентНе работает программа студентНе работает программа студентНе работает программа студентНе работает программа студентНе работает программа студентНе работает программа студентНе работает программа студентНе работает программа студентНе работает программа студент', '0000-00-00 00:00:00', NULL, 0, '', '', '', '', '', '', '50gray', NULL, ''),
(3, 3, 'Не открывается файл', '0000-00-00 00:00:00', '2015-03-30 14:36:04', 3, '', '', '', '', '', '', '50gray', 1, ''),
(13, 4, 'Текст заявки', '2015-03-27 22:20:44', '2015-04-01 00:04:32', 2, 'УК2 (Ленина 114)', '316', 'Компьютерный центр', 'Иванов Иван Иванович', '7922567711', '4.10424542', '50gray', 1, 'Очень много работы выполнено'),
(123, 4, '', '2015-09-11 23:07:58', NULL, 0, '', '', '', '', '', '', '50gray', NULL, ''),
(124, 4, '', '2015-09-11 23:08:37', NULL, 0, '', '', '', '', '', '', '50gray', NULL, ''),
(125, 4, '', '2015-09-11 23:11:28', NULL, 0, '', '', '', '', '', '', '50gray', NULL, ''),
(126, 4, '', '2015-09-11 23:13:27', NULL, 4, '', '', '', '', '', '', '50gray', NULL, ''),
(127, 4, '', '2015-09-11 23:14:17', NULL, 4, '', '', '', '', '', '', '50gray', NULL, ''),
(128, 1, 'sfdgsdfdsfg', '2015-09-14 10:48:16', NULL, 0, 'Ленина 114\\1 (столовая УК №2)', '', '', 'sdfgwfgsdfg', '456456456', '', '50gray', NULL, ''),
(129, 4, '', '2015-09-14 14:18:05', NULL, 0, 'Ленина 114\\1 (столовая УК №2)', '', '', 'ываыва', '424243', 'укеуке', '50gray', NULL, ''),
(130, 4, '', '2015-09-14 14:18:39', NULL, 0, 'Ленина 114\\1 (столовая УК №2)', '45', '', 'цыцуке', '345345', '34535', '50gray', NULL, ''),
(98, 1, 'Принтер заминает бумагу\r\nНе загружается сайт', '2015-09-03 00:44:31', NULL, 0, 'Ленина 114\\2 (ИСАиИ)', '345', 'Библитека', 'Иванов Иван', '7899938383', '4.10445454', '50gray', 2, ''),
(111, 1, '', '2015-09-11 20:36:32', NULL, 0, '', '', '', '', '', '867', '50gray', NULL, ''),
(112, 1, '', '2015-09-11 20:36:59', NULL, 0, '', '', '', '', '', '', '50gray', NULL, ''),
(113, 1, '', '2015-09-11 20:37:41', NULL, 0, '', '', '', '', '', '', '50gray', NULL, ''),
(114, 4, '', '2015-09-11 20:37:57', NULL, 0, '', '', '', '', '', '', '50gray', NULL, ''),
(115, 1, '', '2015-09-11 20:39:39', NULL, 0, '', '', '', '', '', '', '50gray', NULL, ''),
(116, 1, '', '2015-09-11 20:40:42', NULL, 0, '', '', '', '', '', '', '50gray', NULL, ''),
(117, 1, '', '2015-09-11 20:41:21', NULL, 0, '', '', '', '', '', '', '50gray', NULL, ''),
(118, 1, '', '2015-09-11 20:43:32', NULL, 0, '', '', '', '', '7899938383', '54545', '50gray', NULL, ''),
(119, 1, 'sdfsdfsdf', '2015-09-11 20:47:35', NULL, 0, 'Ленина 114\\1 (столовая УК №2)', '', '', '234234', '23424', '', '50gray', NULL, ''),
(120, 4, '', '2015-09-11 20:47:43', NULL, 0, '', '', '', '', '', '', '50gray', NULL, ''),
(121, 4, '', '2015-09-11 20:49:16', NULL, 0, 'Ленина 114\\2 (ИСАиИ)', '', '', '2342341243243', '23424234', '43234', '50gray', NULL, ''),
(122, 4, '', '2015-09-11 23:06:05', NULL, 0, '', '', '', '', '', '', '50gray', NULL, ''),
(110, 4, '', '2015-09-10 00:37:12', NULL, 0, 'Ленина 114\\1 (столовая УК №2)', '43', 'wer', 'ewrwer', '44234', '4234234', '50gray', NULL, '');

-- --------------------------------------------------------

--
-- Структура таблицы `ticket_extra`
--

CREATE TABLE IF NOT EXISTS `ticket_extra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `ticket_extra`
--

INSERT INTO `ticket_extra` (`id`, `ticket_id`, `code`, `value`) VALUES
(1, 108, 'printermodel', 'HP LaserJet 1020'),
(2, 108, 'cartridge', 'HP 36A'),
(3, 107, 'printermodel', 'Canon 2900'),
(4, 110, 'printermodel', 'Xerox 3410'),
(5, 114, 'printermodel', ''),
(6, 120, 'printermodel', ''),
(7, 121, 'printermodel', 'sadfasdfasfd'),
(8, 122, 'printermodel', ''),
(9, 123, 'printermodel', ''),
(10, 124, 'printermodel', ''),
(11, 125, 'printermodel', ''),
(12, 126, 'printermodel', ''),
(13, 127, 'printermodel', ''),
(14, 129, 'printermodel', 'Принтера нет в списке'),
(15, 130, 'printermodel', 'Canon i-sensys MF 4120');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fio` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `fio`, `role`) VALUES
(1, 'alferov', '51e7a238eac5d1b39ad5b15d33e6921a', 'Алферов Ю.Г.', 'admin'),
(2, 'bezzubkova', '9f936507610d628a472f84478a752595', 'Беззубкова В.С.', 'engineer');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
