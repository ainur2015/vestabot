-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Ноя 23 2023 г., 22:28
-- Версия сервера: 10.11.4-MariaDB-1~deb12u1
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vestabot`
--

-- --------------------------------------------------------

--
-- Структура таблицы `aucsion`
--

CREATE TABLE `aucsion` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `shop` int(11) NOT NULL,
  `plata` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `aucsion`
--

INSERT INTO `aucsion` (`id`, `name`, `shop`, `plata`) VALUES
(3, 'акция', 1000, 2),
(4, 'акция', 1000, 1),
(9, 'бренд', 900, 3),
(11, 'банковая', 9000, 50),
(15, 'пчела', 100, 1),
(18, 'биби', 100, 1),
(19, 'mercedes', 300, 1),
(21, 'rub', 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `base`
--

CREATE TABLE `base` (
  `id` int(11) NOT NULL,
  `sigr` int(11) NOT NULL,
  `pris` int(11) NOT NULL,
  `bank` int(11) NOT NULL,
  `invs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `base`
--

INSERT INTO `base` (`id`, `sigr`, `pris`, `bank`, `invs`) VALUES
(1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `buss`
--

CREATE TABLE `buss` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `shop` int(11) NOT NULL,
  `plata` int(11) NOT NULL,
  `sull` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `buss`
--

INSERT INTO `buss` (`id`, `name`, `shop`, `plata`, `sull`) VALUES
(1, 'Завод Бумаги', 150, 10, 150),
(2, 'Завод Оружия', 820, 30, 820),
(3, 'Завод Техники', 1500, 90, 1500),
(4, 'Завод Урана', 3000, 190, 3000),
(5, 'Завод Атома', 5000, 500, 5000),
(6, 'Электростанция', 7000, 800, 7000),
(7, 'АЭС', 10000, 1500, 10000),
(8, 'Министерство Мира', 17000, 2800, 17000),
(9, 'Секретная компания', 40000, 3900, 40000),
(10, 'Всемирный Банк', 50000, 4900, 50000);

-- --------------------------------------------------------


--
-- Структура таблицы `computer`
--

CREATE TABLE `computer` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `shop` int(11) NOT NULL,
  `sull` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `computer`
--

INSERT INTO `computer` (`id`, `name`, `shop`, `sull`) VALUES
(1, 'Персональный компьютер', 100, 80),
(2, 'Настольный компьютер', 200, 180),
(3, 'Ноутбук', 250, 230),
(4, 'Планшет', 300, 280),
(5, 'Смартфон', 380, 380),
(6, 'Рабочая станция', 450, 450),
(7, 'Сервер', 500, 500),
(8, 'Большая ЭВМ', 600, 600),
(9, 'Супер Компьютер', 800, 800),
(10, 'Квантовый Компьютер', 1000, 1000);

-- --------------------------------------------------------

--
-- Структура таблицы `exta`
--

CREATE TABLE `exta` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `shop` int(11) NOT NULL,
  `sull` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `exta`
--

INSERT INTO `exta` (`id`, `name`, `shop`, `sull`) VALUES
(1, 'Бумага', 10, 10),
(2, 'Картонка', 20, 20),
(3, 'Доска', 60, 60),
(4, 'Железа', 100, 100),
(5, 'Кожа', 150, 150),
(6, 'Одеяло', 170, 170),
(7, 'Лодка', 200, 200),
(8, 'Яхта', 250, 250),
(9, 'Подводная лодка', 370, 370),
(10, 'Атомная лодка', 400, 400);

-- --------------------------------------------------------

--
-- Структура таблицы `ferma`
--

CREATE TABLE `ferma` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `shop` int(11) NOT NULL,
  `sull` int(11) NOT NULL,
  `plata` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `ferma`
--

INSERT INTO `ferma` (`id`, `name`, `shop`, `sull`, `plata`) VALUES
(1, 'Смартфон', 50, 50, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `home`
--

CREATE TABLE `home` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `shop` int(11) NOT NULL,
  `sull` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `home`
--

INSERT INTO `home` (`id`, `name`, `shop`, `sull`) VALUES
(1, 'Коробка', 10, 10),
(2, 'Тунель', 25, 25),
(3, 'Ферма', 50, 50),
(4, 'Гараж', 80, 80),
(5, 'Собачья Будка', 170, 170),
(6, 'Дом', 250, 250),
(7, '2-х этажный дом', 300, 300),
(8, 'Коттедж', 400, 400),
(9, 'Банк', 600, 600),
(10, 'Вертолет', 800, 800);

-- --------------------------------------------------------

--
-- Структура таблицы `mashin`
--

CREATE TABLE `mashin` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `shop` int(11) NOT NULL,
  `sull` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `mashin`
--

INSERT INTO `mashin` (`id`, `name`, `shop`, `sull`) VALUES
(1, 'Peel P50', 30, 30),
(2, 'Toyota C-HR', 70, 70),
(3, 'Ford Ecosport', 150, 150),
(4, 'Chevrolet Trax', 200, 200),
(5, 'Volkswagen Atlas Cross Sport', 250, 250),
(6, 'Mercedes-Benz GLB', 300, 300),
(7, 'Nissan Rogue Sport', 350, 350),
(8, 'Jeep Renegade', 400, 400),
(9, 'Volkswagen Taos', 500, 500),
(10, 'TESLA X', 1000, 1000);

-- --------------------------------------------------------

--
-- Структура таблицы `odes`
--

CREATE TABLE `odes` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `shop` int(11) NOT NULL,
  `sull` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `odes`
--

INSERT INTO `odes` (`id`, `name`, `shop`, `sull`) VALUES
(1, 'Картонная одежда', 10, 10),
(2, 'Шерстяная одежда', 25, 25),
(3, 'Крысинная одежда', 70, 70),
(4, 'Универсальная одежда', 150, 150),
(5, 'Тяжёлая одежда', 200, 200),
(6, 'Тёплая одежда', 250, 250),
(7, 'Российская одежда', 350, 350),
(8, 'Addidas Одежда', 450, 450),
(9, 'Современная одежда', 500, 500),
(10, 'Одежда Бога.', 700, 700);

-- --------------------------------------------------------

--
-- Структура таблицы `pitomith`
--

CREATE TABLE `pitomith` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `shop` int(11) NOT NULL,
  `sull` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pitomith`
--

INSERT INTO `pitomith` (`id`, `name`, `shop`, `sull`) VALUES
(1, 'Бутылка', 10, 10),
(2, 'Хомяк', 74, 66),
(3, 'Кот', 96, 71),
(4, 'Бомж', 130, 72),
(5, 'Собака', 155, 99),
(6, 'Лиса', 210, 172),
(7, 'Вор', 279, 200),
(8, 'Енот', 340, 300),
(9, 'Ребёнок', 400, 399),
(10, 'Бог', 3000, 3000),
(11, 'САТАНА', 3000, 3000);

-- --------------------------------------------------------

--
-- Структура таблицы `psettings`
--

CREATE TABLE `psettings` (
  `id` int(11) NOT NULL,
  `bot` int(11) NOT NULL,
  `casino` int(11) NOT NULL,
  `bank` int(11) NOT NULL,
  `clic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `psettings`
--

INSERT INTO `psettings` (`id`, `bot`, `casino`, `bank`, `clic`) VALUES
(1, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `pvirus`
--

CREATE TABLE `pvirus` (
  `bot` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `vk_id` int(11) NOT NULL,
  `text` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sitata`
--

CREATE TABLE `sitata` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `sitata`
--

INSERT INTO `sitata` (`id`, `text`) VALUES
(4, 'Падает тот, кто бежит. Тот, кто ползет, не падает.'),
(5, 'Если человек сильный, это не значит, что ему не больно.'),
(6, 'Оглянись на меня, я псих\nЯ ушёл далеко назад,\nТы же знаешь, что я любил,\nИ люблю, черт возьми, опять...\n\nТы сама не здорова, вижу.\nИ в попытках меня понять.\n\nЯ же знаю, что ты любила!\nЧерт возьми, полюби опять.'),
(7, 'Время утекает сквозь пальцы опущенных рук.'),
(8, 'Самая большая ошибка — это боязнь совершить ошибку.'),
(9, 'Верная любовь помогает переносить все тяготы.'),
(10, 'Лучше притворится глупым, чем слушать людей.'),
(11, 'Чистая совесть — самая лучшая подушка.'),
(12, 'Ты есть то, во что ты веришь.'),
(13, 'Единственное счастье в жизни — это постоянное стремление вперед.'),
(14, 'Любовь сильнее страха смерти.'),
(15, 'Лучше признаться в любви, чем ждать чуда.'),
(16, 'Лучше закрыть глаза, чем страдать.'),
(17, 'Душе живёт настоящая любовь.'),
(18, 'Не бегай за девушками, пусть они бегают.'),
(19, 'Влюбляются не влюбляйся'),
(20, 'Родители вы сума сошли?\nКакие здесь оценки????\nВаш ребёнок у депресию упал.'),
(21, 'Всегда одинокий\nМного думает о будущем.\nЛюбят, одну на всю жизнь.\nВсего добиваешься сам.\nЛюбишь тишину?\nВедь я прав?'),
(22, 'Я прав верно?\nВлюбляешься тебя бросают в последний момент.\nВ чём смысл любви?'),
(23, 'Ищешь людей и находишь человека.\nПереписываешься с человеком.\nИ он нравится тебе.\nМиг он спрашивает твою фото лица.\nТы отказываешься.\nВсё ты в чёрном списке.'),
(24, 'Влюбляешься от касания.\nПризнаешься в любви.\nНо тебя отшивают.\nИ ты перестаешь быть человеком.'),
(25, 'По-моему, нет ничего хуже,\nкогда привязываешься к человеку и, \nкак больной ждешь от него звонка или сообщения.\nа ему там и без тебя хорошо.'),
(26, 'Люди которых бросили девочки либо парни бросили девочек.\nСтановятся сильнее.'),
(27, 'Лучше остаться в одиночестве\nчем влюбится в кого-то.'),
(28, 'Лучший друг это я.'),
(29, 'Дружба - это найти особенного человека, с кем ты можешь быть придурком.'),
(30, 'Настоящие друзья не судят друг друга, они судят других людей с вами.'),
(31, 'Только недавно узнал на физике что,\nНикогда не бывает холода, бывает только отсутствиет тепло.\nИ это заставило мне задуматься, что может\nненависти не существует\nа есть только отсутствует любовь.'),
(32, 'Каждый раз проверяю телефон, как буд-то кому то нужен.'),
(33, 'Однажды Кто-то соберёт твоё\nпотрёпанное сердце по кусочкам.\n\nИ напомнит - что такое счастье.'),
(34, 'Я как белый карандаш\nВроде есть, но никому\nНе нужен....'),
(35, 'Мудр не тот кто знает многое,\nА то кто знает нужное.'),
(36, 'Без любви жить легче,\nНо без неё нет смысла'),
(37, 'Если вам будет одиноко\nто вспомните Сашу\nБелого который потерял\nМаму, семью и друзей, но\nвсе равно не сдался'),
(38, '\nЧтобы не испортить себе жизнь\nи не придумывать любовь там,\nгде её нет, напоминай себе всегда....\nЕсли человек хочет быть с тобой,\nон будет рядом всегда.......'),
(39, 'Мужчина в этой жизни.\nДолжен любить 3-х девушек.\n\n- Ту, которая родила его.\n- Ту, которая родила для него.\n- Ту, которая родилась от него.'),
(40, 'Крепкая любовь начинается с невзнапной дружбы'),
(41, '\nБлизкий человек, может убить с одного удара ведь он знает куда бить.'),
(42, 'Ничего нет позорного, если человек говорит ты позор, обозначает что человек не сумеел пережить свой позор.'),
(43, 'Когда я попросил бога убрать из моей жизни врагов, то куда-то начали пропадать мои друзья.'),
(44, 'Эх молодёжь...\nВы думаете главное иметь по больше друзей?\nДовольно одного.\n\nНайти себе единственного но своего.'),
(45, 'Люди поймут, потеря родного человека с этого мира.'),
(46, 'Как думаешь? Когда человек умирает?\n\nКогда пуля поражает его сердце?\n\nНет...\n\nКогда его поражает неизлечимая болезнь?\n\nНет...\n\nМожет когда он съедает суп из ядовитых грибов?\n\nНет...\n\nЧеловек умирает, когда о нем забывают.'),
(47, '\nРаньше я думал, что нужно беречь Дружбу,\nХорошие отношения , а сейчас Понял что нужно беречь себя  от\nЛицемерных людей которые улыбаясь \nВ глаза тихо ненавидят за спиной\nПусть  лучше рядом останется один человек\nНо он будет настоящим.'),
(48, 'Я конечно не лучший человек на земле\nно я надеюсь, что когда я умру, хоть кто то скажет: а он был хороший.'),
(49, 'Будущее только в твои руках, кто помешает твоему будущему то эти люди уже не люди.'),
(50, '\nЧеловек, жизнь одна.'),
(51, '\n\nА знаешь ли жизнь животного от человека в чем отличается?\nУ человека может сердце сломаться при расставании\nУ животного только инстинкт.');

-- --------------------------------------------------------

--
-- Структура таблицы `sp`
--

CREATE TABLE `sp` (
  `id` int(11) NOT NULL,
  `vk_id` int(11) NOT NULL,
  `nick` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `sp`
--

INSERT INTO `sp` (`id`, `vk_id`, `nick`) VALUES
(2, 26, 'Белый рыцарь ');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `vk_id` int(11) NOT NULL,
  `nick` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `time_bonus` int(11) NOT NULL,
  `ban` int(11) DEFAULT 0,
  `vip` int(11) NOT NULL DEFAULT 0,
  `bank` int(11) NOT NULL,
  `times` text NOT NULL,
  `pitom` int(11) NOT NULL,
  `computer` int(11) NOT NULL,
  `home` int(11) NOT NULL DEFAULT 0,
  `exta` int(11) NOT NULL DEFAULT 0,
  `mashin` int(11) NOT NULL DEFAULT 0,
  `odes` int(11) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT 0,
  `buss` int(11) DEFAULT 0,
  `buss_plata` int(11) NOT NULL,
  `buss_sull` int(11) DEFAULT 0,
  `ferma` int(11) NOT NULL DEFAULT 0,
  `ferma_colv` int(11) NOT NULL DEFAULT 0,
  `ferma_sull` int(11) NOT NULL DEFAULT 0,
  `ferma_plata` int(11) NOT NULL,
  `rub` int(11) NOT NULL DEFAULT 0,
  `ras` int(11) NOT NULL DEFAULT 1,
  `aucs` int(11) NOT NULL,
  `part` int(11) NOT NULL DEFAULT 0,
  `part_colv` int(11) NOT NULL,
  `clic_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;


--
-- Структура таблицы `virusbot`
--

CREATE TABLE `virusbot` (
  `id` int(11) NOT NULL,
  `vk_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `times` int(11) NOT NULL,
  `ban` int(11) NOT NULL DEFAULT 0,
  `vip` int(11) NOT NULL DEFAULT 0,
  `admin` int(11) NOT NULL DEFAULT 0,
  `nick` text NOT NULL,
  `tabl` int(11) NOT NULL,
  `ilic` int(11) NOT NULL,
  `sar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `aucsion`
--
ALTER TABLE `aucsion`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `base`
--
ALTER TABLE `base`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `buss`
--
ALTER TABLE `buss`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `computer`
--
ALTER TABLE `computer`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `exta`
--
ALTER TABLE `exta`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ferma`
--
ALTER TABLE `ferma`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `home`
--
ALTER TABLE `home`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mashin`
--
ALTER TABLE `mashin`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `odes`
--
ALTER TABLE `odes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pitomith`
--
ALTER TABLE `pitomith`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `psettings`
--
ALTER TABLE `psettings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sitata`
--
ALTER TABLE `sitata`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sp`
--
ALTER TABLE `sp`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `virusbot`
--
ALTER TABLE `virusbot`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `aucsion`
--
ALTER TABLE `aucsion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `buss`
--
ALTER TABLE `buss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `computer`
--
ALTER TABLE `computer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `exta`
--
ALTER TABLE `exta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `ferma`
--
ALTER TABLE `ferma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `home`
--
ALTER TABLE `home`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `mashin`
--
ALTER TABLE `mashin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `odes`
--
ALTER TABLE `odes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `pitomith`
--
ALTER TABLE `pitomith`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `psettings`
--
ALTER TABLE `psettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sitata`
--
ALTER TABLE `sitata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `sp`
--
ALTER TABLE `sp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT для таблицы `virusbot`
--
ALTER TABLE `virusbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
