-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 09 2025 г., 22:12
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `DB1`
--

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `additiveсriterion`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `additiveсriterion` (
`additive_criterion` decimal(32,2)
,`category_name` varchar(20)
,`component_name` varchar(50)
,`id_component` int
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `averagegrade`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `averagegrade` (
`average_rating` decimal(14,4)
,`id_component` int
);

-- --------------------------------------------------------

--
-- Структура таблицы `Categories`
--

CREATE TABLE `Categories` (
  `id_categories` int NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Categories`
--

INSERT INTO `Categories` (`id_categories`, `name`) VALUES
(4, 'Блоки питания'),
(2, 'Видеокарты'),
(6, 'Жёсткие диски'),
(3, 'Материнские платы'),
(7, 'Мониторы'),
(5, 'Оперативная память'),
(8, 'Перефирия'),
(1, 'Процессоры');

-- --------------------------------------------------------

--
-- Структура таблицы `Components`
--

CREATE TABLE `Components` (
  `id_component` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `date_added` date NOT NULL,
  `technical_conditions` varchar(20) NOT NULL,
  `cost` decimal(9,2) NOT NULL,
  `id_categories` int DEFAULT NULL,
  `adreess` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Components`
--

INSERT INTO `Components` (`id_component`, `name`, `description`, `date_added`, `technical_conditions`, `cost`, `id_categories`, `adreess`) VALUES
(2, 'AMD Ryzen 9 7950X', 'Ядра: 16\nПотоки: 32\nБазовая частота: 4.5 GHz\nТурбо: до 5.7 GHz\nКэш L3: 64MB\nTDP: 170W', '2024-01-15', 'Рабочее', '62999.99', 1, 'Серверная 1, Стойка 3'),
(3, 'Intel Core i7-13700K', 'Ядра: 16 (8P + 8E)\nПотоки: 24\nБазовая частота: 3.4 GHz\nТурбо: до 5.4 GHz\nКэш L3: 30MB', '2024-02-01', 'Рабочее', '45999.99', 1, 'Серверная 2, Стойка 1'),
(4, 'AMD Ryzen 7 7800X3D', 'Ядра: 8\nПотоки: 16\nБазовая частота: 4.2 GHz\nТурбо: до 5.0 GHz\nКэш L3: 96MB\nTDP: 120W', '2024-02-01', 'Рабочее', '49999.99', 1, 'Серверная 2, Стойка 1'),
(5, 'Intel Core i5-13600K', 'Ядра: 14 (6P + 8E)\nПотоки: 20\nБазовая частота: 3.5 GHz\nТурбо: до 5.1 GHz\nКэш L3: 24MB', '2024-02-15', 'Рабочее', '35999.99', 1, 'Серверная 1, Стойка 2'),
(6, 'AMD Ryzen 5 7600X', 'Ядра: 6\nПотоки: 12\nБазовая частота: 4.7 GHz\nТурбо: до 5.3 GHz\nКэш L3: 32MB\nTDP: 105W', '2024-02-15', 'Рабочее', '29999.99', 1, 'Серверная 1, Стойка 2'),
(7, 'Intel Core i9-12900K', 'Ядра: 16 (8P + 8E)\nПотоки: 24\nБазовая частота: 3.2 GHz\nТурбо: до 5.2 GHz\nКэш L3: 30MB', '2023-12-01', 'Рабочее', '52999.99', 1, 'Серверная 2, Стойка 2'),
(8, 'AMD Ryzen 9 5950X', 'Ядра: 16\nПотоки: 32\nБазовая частота: 3.4 GHz\nТурбо: до 4.9 GHz\nКэш L3: 64MB\nTDP: 105W', '2023-12-01', 'Рабочее', '47999.99', 1, 'Серверная 2, Стойка 2'),
(9, 'Intel Core i7-12700K', 'Ядра: 12 (8P + 4E)\nПотоки: 20\nБазовая частота: 3.6 GHz\nТурбо: до 5.0 GHz\nКэш L3: 25MB', '2023-11-15', 'Рабочее', '39999.99', 1, 'Серверная 1, Стойка 1'),
(10, 'AMD Ryzen 7 5800X3D', 'Ядра: 8\nПотоки: 16\nБазовая частота: 3.4 GHz\nТурбо: до 4.5 GHz\nКэш L3: 96MB\nTDP: 105W', '2023-11-15', 'Рабочее', '42999.99', 1, 'Серверная 1, Стойка 1'),
(11, 'NVIDIA GeForce RTX 4090', 'GPU: AD102\nКудя ядра: 16384\nЧастота: 2.52 GHz\nПамять: 24GB GDDR6X\nШина памяти: 384-bit\nTDP: 450W', '2024-01-15', 'Рабочее', '189999.99', 2, 'Серверная 1, Стойка 4'),
(12, 'AMD Radeon RX 7900 XTX', 'GPU: Navi 31\nПотоковые процессоры: 12288\nЧастота: 2.5 GHz\nПамять: 24GB GDDR6\nШина памяти: 384-bit\nTDP: 355W', '2024-01-15', 'Рабочее', '159999.99', 2, 'Серверная 1, Стойка 4'),
(13, 'NVIDIA GeForce RTX 4080', 'GPU: AD103\nКудя ядра: 9728\nЧастота: 2.51 GHz\nПамять: 16GB GDDR6X\nШина памяти: 256-bit\nTDP: 320W', '2024-02-01', 'Рабочее', '139999.99', 2, 'Серверная 2, Стойка 3'),
(14, 'AMD Radeon RX 7900 XT', 'GPU: Navi 31\nПотоковые процессоры: 10752\nЧастота: 2.4 GHz\nПамять: 20GB GDDR6\nШина памяти: 320-bit\nTDP: 315W', '2024-02-01', 'Рабочее', '129999.99', 2, 'Серверная 2, Стойка 3'),
(15, 'NVIDIA GeForce RTX 4070 Ti', 'GPU: AD104\nКудя ядра: 7680\nЧастота: 2.61 GHz\nПамять: 12GB GDDR6X\nШина памяти: 192-bit\nTDP: 285W', '2024-02-15', 'Рабочее', '99999.99', 2, 'Серверная 1, Стойка 5'),
(16, 'AMD Radeon RX 7800 XT', 'GPU: Navi 32\nПотоковые процессоры: 3840\nЧастота: 2.12 GHz\nПамять: 16GB GDDR6\nШина памяти: 256-bit\nTDP: 263W', '2024-02-15', 'Рабочее', '89999.99', 2, 'Серверная 1, Стойка 5'),
(17, 'NVIDIA GeForce RTX 4070', 'GPU: AD104\nКудя ядра: 5888\nЧастота: 2.48 GHz\nПамять: 12GB GDDR6X\nШина памяти: 192-bit\nTDP: 200W', '2023-12-01', 'Рабочее', '79999.99', 2, 'Серверная 2, Стойка 4'),
(18, 'AMD Radeon RX 7700 XT', 'GPU: Navi 32\nПотоковые процессоры: 3456\nЧастота: 2.17 GHz\nПамять: 12GB GDDR6\nШина памяти: 192-bit\nTDP: 245W', '2023-12-01', 'Рабочее', '69999.99', 2, 'Серверная 2, Стойка 4'),
(19, 'NVIDIA GeForce RTX 4060 Ti', 'GPU: AD106\nКудя ядра: 4352\nЧастота: 2.54 GHz\nПамять: 8GB GDDR6\nШина памяти: 128-bit\nTDP: 160W', '2023-11-15', 'Рабочее', '59999.99', 2, 'Серверная 1, Стойка 6'),
(20, 'AMD Radeon RX 7600', 'GPU: Navi 33\nПотоковые процессоры: 2048\nЧастота: 2.25 GHz\nПамять: 8GB GDDR6\nШина памяти: 128-bit\nTDP: 165W', '2023-11-15', 'Рабочее', '49999.99', 2, 'Серверная 1, Стойка 6'),
(21, 'ASUS ROG MAXIMUS Z790 HERO', 'Сокет: LGA1700\nЧипсет: Intel Z790\nПамять: 4x DDR5\nМакс. память: 128GB\nPCIe: 4.0 x16', '2024-01-15', 'Рабочее', '69999.99', 3, 'Серверная 1, Стойка 7'),
(22, 'MSI MEG X670E ACE', 'Сокет: AM5\nЧипсет: AMD X670E\nПамять: 4x DDR5\nМакс. память: 128GB\nPCIe: 5.0 x16', '2024-01-15', 'Рабочее', '79999.99', 3, 'Серверная 1, Стойка 7'),
(23, 'GIGABYTE Z790 AORUS MASTER', 'Сокет: LGA1700\nЧипсет: Intel Z790\nПамять: 4x DDR5\nМакс. память: 128GB\nPCIe: 4.0 x16', '2024-02-01', 'Рабочее', '59999.99', 3, 'Серверная 2, Стойка 5'),
(24, 'ASRock X670E Taichi', 'Сокет: AM5\nЧипсет: AMD X670E\nПамять: 4x DDR5\nМакс. память: 128GB\nPCIe: 5.0 x16', '2024-02-01', 'Рабочее', '64999.99', 3, 'Серверная 2, Стойка 5'),
(25, 'ASUS ROG STRIX B760-F GAMING', 'Сокет: LGA1700\nЧипсет: Intel B760\nПамять: 4x DDR5\nМакс. память: 128GB\nPCIe: 4.0 x16', '2024-02-15', 'Рабочее', '29999.99', 3, 'Серверная 1, Стойка 8'),
(26, 'MSI MPG B650 CARBON WIFI', 'Сокет: AM5\nЧипсет: AMD B650\nПамять: 4x DDR5\nМакс. память: 128GB\nPCIe: 4.0 x16', '2024-02-15', 'Рабочее', '34999.99', 3, 'Серверная 1, Стойка 8'),
(27, 'GIGABYTE B760M AORUS ELITE', 'Сокет: LGA1700\nЧипсет: Intel B760\nПамять: 4x DDR5\nМакс. память: 128GB\nPCIe: 4.0 x16', '2023-12-01', 'Рабочее', '24999.99', 3, 'Серверная 2, Стойка 6'),
(28, 'ASRock B650M PG RIPTIDE', 'Сокет: AM5\nЧипсет: AMD B650\nПамять: 4x DDR5\nМакс. память: 128GB\nPCIe: 4.0 x16', '2023-12-01', 'Рабочее', '22999.99', 3, 'Серверная 2, Стойка 6'),
(29, 'ASUS PRIME H610M-K', 'Сокет: LGA1700\nЧипсет: Intel H610\nПамять: 2x DDR4\nМакс. память: 64GB\nPCIe: 4.0 x16', '2023-11-15', 'Рабочее', '14999.99', 3, 'Серверная 1, Стойка 9'),
(30, 'MSI PRO A620M-E', 'Сокет: AM5\nЧипсет: AMD A620\nПамять: 2x DDR5\nМакс. память: 64GB\nPCIe: 4.0 x16', '2023-11-15', 'Рабочее', '12999.99', 3, 'Серверная 1, Стойка 9'),
(31, 'Corsair AX1600i', 'Мощность: 1600W\nСертификат: 80 PLUS Titanium\nМодульный: Полностью\nКПД: 94%\nВентилятор: 140мм', '2024-01-15', 'Рабочее', '49999.99', 4, 'Серверная 1, Стойка 10'),
(32, 'be quiet! Dark Power Pro 12', 'Мощность: 1500W\nСертификат: 80 PLUS Titanium\nМодульный: Полностью\nКПД: 94%\nВентилятор: 135мм', '2024-01-15', 'Рабочее', '44999.99', 4, 'Серверная 1, Стойка 10'),
(33, 'Seasonic PRIME TX-1300', 'Мощность: 1300W\nСертификат: 80 PLUS Titanium\nМодульный: Полностью\nКПД: 94%\nВентилятор: 135мм', '2024-02-01', 'Рабочее', '39999.99', 4, 'Серверная 2, Стойка 7'),
(34, 'ASUS ROG THOR 1200P', 'Мощность: 1200W\nСертификат: 80 PLUS Platinum\nМодульный: Полностью\nКПД: 92%\nВентилятор: 135мм', '2024-02-01', 'Рабочее', '34999.99', 4, 'Серверная 2, Стойка 7'),
(35, 'Corsair RM1000x', 'Мощность: 1000W\nСертификат: 80 PLUS Gold\nМодульный: Полностью\nКПД: 90%\nВентилятор: 135мм', '2024-02-15', 'Рабочее', '24999.99', 4, 'Серверная 1, Стойка 11'),
(36, 'be quiet! Straight Power 11', 'Мощность: 850W\nСертификат: 80 PLUS Gold\nМодульный: Полностью\nКПД: 90%\nВентилятор: 135мм', '2024-02-15', 'Рабочее', '19999.99', 4, 'Серверная 1, Стойка 11'),
(37, 'Seasonic Focus GX-750', 'Мощность: 750W\nСертификат: 80 PLUS Gold\nМодульный: Полностью\nКПД: 90%\nВентилятор: 120мм', '2023-12-01', 'Рабочее', '14999.99', 4, 'Серверная 2, Стойка 8'),
(38, 'EVGA SuperNOVA 650 G5', 'Мощность: 650W\nСертификат: 80 PLUS Gold\nМодульный: Полностью\nКПД: 90%\nВентилятор: 135мм', '2023-12-01', 'Рабочее', '12999.99', 4, 'Серверная 2, Стойка 8'),
(39, 'Corsair CV550', 'Мощность: 550W\nСертификат: 80 PLUS Bronze\nМодульный: Нет\nКПД: 85%\nВентилятор: 120мм', '2023-11-15', 'Рабочее', '7999.99', 4, 'Серверная 1, Стойка 12'),
(40, 'be quiet! System Power 9', 'Мощность: 500W\nСертификат: 80 PLUS Bronze\nМодульный: Нет\nКПД: 85%\nВентилятор: 120мм', '2023-11-15', 'Рабочее', '6999.99', 4, 'Серверная 1, Стойка 12'),
(41, 'G.SKILL Trident Z5 RGB', 'Объем: 32GB (2x16GB)\nТип: DDR5\nЧастота: 6400MHz\nТайминги: CL32\nНапряжение: 1.4V', '2024-01-15', 'Рабочее', '29999.99', 5, 'Серверная 1, Стойка 13'),
(42, 'Corsair Dominator Platinum RGB', 'Объем: 32GB (2x16GB)\nТип: DDR5\nЧастота: 6200MHz\nТайминги: CL36\nНапряжение: 1.35V', '2024-01-15', 'Рабочее', '27999.99', 5, 'Серверная 1, Стойка 13'),
(43, 'Kingston Fury Beast RGB', 'Объем: 32GB (2x16GB)\nТип: DDR5\nЧастота: 6000MHz\nТайминги: CL36\nНапряжение: 1.35V', '2024-02-01', 'Рабочее', '24999.99', 5, 'Серверная 2, Стойка 9'),
(44, 'Crucial RAM DDR5', 'Объем: 32GB (2x16GB)\nТип: DDR5\nЧастота: 5600MHz\nТайминги: CL40\nНапряжение: 1.25V', '2024-02-01', 'Рабочее', '22999.99', 5, 'Серверная 2, Стойка 9'),
(45, 'G.SKILL Ripjaws V', 'Объем: 32GB (2x16GB)\nТип: DDR4\nЧастота: 3600MHz\nТайминги: CL16\nНапряжение: 1.35V', '2024-02-15', 'Рабочее', '19999.99', 5, 'Серверная 1, Стойка 14'),
(46, 'Corsair Vengeance LPX', 'Объем: 32GB (2x16GB)\nТип: DDR4\nЧастота: 3200MHz\nТайминги: CL16\nНапряжение: 1.35V', '2024-02-15', 'Рабочее', '17999.99', 5, 'Серверная 1, Стойка 14'),
(47, 'Kingston Fury Renegade', 'Объем: 16GB (2x8GB)\nТип: DDR4\nЧастота: 3600MHz\nТайминги: CL16\nНапряжение: 1.35V', '2023-12-01', 'Рабочее', '12999.99', 5, 'Серверная 2, Стойка 10'),
(48, 'Crucial Ballistix', 'Объем: 16GB (2x8GB)\nТип: DDR4\nЧастота: 3200MHz\nТайминги: CL16\nНапряжение: 1.35V', '2023-12-01', 'Рабочее', '11999.99', 5, 'Серверная 2, Стойка 10'),
(49, 'TeamGroup T-Force Vulcan Z', 'Объем: 16GB (2x8GB)\nТип: DDR4\nЧастота: 3000MHz\nТайминги: CL16\nНапряжение: 1.35V', '2023-11-15', 'Рабочее', '9999.99', 5, 'Серверная 1, Стойка 15'),
(50, 'Patriot Viper Steel', 'Объем: 16GB (2x8GB)\nТип: DDR4\nЧастота: 3000MHz\nТайминги: CL16\nНапряжение: 1.35V', '2023-11-15', 'Рабочее', '9499.99', 5, 'Серверная 1, Стойка 15'),
(51, 'Samsung 990 PRO', 'Тип: NVMe SSD\nОбъем: 2TB\nСкорость чтения: 7450MB/s\nСкорость записи: 6900MB/s\nФормат: M.2', '2024-01-15', 'Рабочее', '29999.99', 6, 'Серверная 1, Стойка 16'),
(52, 'WD Black SN850X', 'Тип: NVMe SSD\nОбъем: 2TB\nСкорость чтения: 7300MB/s\nСкорость записи: 6600MB/s\nФормат: M.2', '2024-01-15', 'Рабочее', '27999.99', 6, 'Серверная 1, Стойка 16'),
(53, 'Seagate FireCuda 530', 'Тип: NVMe SSD\nОбъем: 2TB\nСкорость чтения: 7300MB/s\nСкорость записи: 6900MB/s\nФормат: M.2', '2024-02-01', 'Рабочее', '26999.99', 6, 'Серверная 2, Стойка 11'),
(54, 'Crucial P5 Plus', 'Тип: NVMe SSD\nОбъем: 2TB\nСкорость чтения: 6600MB/s\nСкорость записи: 5000MB/s\nФормат: M.2', '2024-02-01', 'Рабочее', '24999.99', 6, 'Серверная 2, Стойка 11'),
(55, 'Samsung 870 EVO', 'Тип: SATA SSD\nОбъем: 2TB\nСкорость чтения: 560MB/s\nСкорость записи: 530MB/s\nФормат: 2.5\"', '2024-02-15', 'Рабочее', '19999.99', 6, 'Серверная 1, Стойка 17'),
(56, 'WD Black', 'Тип: HDD\nОбъем: 4TB\nСкорость вращения: 7200RPM\nКэш: 256MB\nФормат: 3.5\"', '2024-02-15', 'Рабочее', '17999.99', 6, 'Серверная 1, Стойка 17'),
(57, 'Seagate IronWolf Pro', 'Тип: HDD\nОбъем: 4TB\nСкорость вращения: 7200RPM\nКэш: 256MB\nФормат: 3.5\"', '2023-12-01', 'Рабочее', '16999.99', 6, 'Серверная 2, Стойка 12'),
(58, 'WD Red Pro', 'Тип: HDD\nОбъем: 4TB\nСкорость вращения: 7200RPM\nКэш: 256MB\nФормат: 3.5\"', '2023-12-01', 'Рабочее', '15999.99', 6, 'Серверная 2, Стойка 12'),
(59, 'Toshiba X300', 'Тип: HDD\nОбъем: 4TB\nСкорость вращения: 7200RPM\nКэш: 256MB\nФормат: 3.5\"', '2023-11-15', 'Рабочее', '14999.99', 6, 'Серверная 1, Стойка 18'),
(60, 'Seagate BarraCuda', 'Тип: HDD\nОбъем: 4TB\nСкорость вращения: 5400RPM\nКэш: 256MB\nФормат: 3.5\"', '2023-11-15', 'Рабочее', '12999.99', 6, 'Серверная 1, Стойка 18'),
(61, 'ASUS ROG Swift PG32UQX', 'Диагональ: 32\"\nРазрешение: 3840x2160\nЧастота: 144Hz\nМатрица: IPS\nHDR: Mini LED', '2024-01-15', 'Рабочее', '199999.99', 7, 'Серверная 1, Стойка 19'),
(62, 'Samsung Odyssey Neo G9', 'Диагональ: 49\"\nРазрешение: 5120x1440\nЧастота: 240Hz\nМатрица: VA\nHDR: Mini LED', '2024-01-15', 'Рабочее', '189999.99', 7, 'Серверная 1, Стойка 19'),
(63, 'LG 27GR95QE-B', 'Диагональ: 27\"\nРазрешение: 2560x1440\nЧастота: 240Hz\nМатрица: OLED\nHDR: HDR10', '2024-02-01', 'Рабочее', '99999.99', 7, 'Серверная 2, Стойка 13'),
(64, 'Dell Alienware AW3423DW', 'Диагональ: 34\"\nРазрешение: 3440x1440\nЧастота: 175Hz\nМатрица: QD-OLED\nHDR: HDR1000', '2024-02-01', 'Рабочее', '149999.99', 7, 'Серверная 2, Стойка 13'),
(65, 'ASUS TUF Gaming VG27AQ', 'Диагональ: 27\"\nРазрешение: 2560x1440\nЧастота: 165Hz\nМатрица: IPS\nHDR: HDR10', '2024-02-15', 'Рабочее', '49999.99', 7, 'Серверная 1, Стойка 20'),
(66, 'MSI Optix MAG274QRF-QD', 'Диагональ: 27\"\nРазрешение: 2560x1440\nЧастота: 165Hz\nМатрица: IPS\nHDR: HDR400', '2024-02-15', 'Рабочее', '54999.99', 7, 'Серверная 1, Стойка 20'),
(67, 'Gigabyte M27Q', 'Диагональ: 27\"\nРазрешение: 2560x1440\nЧастота: 170Hz\nМатрица: IPS\nHDR: HDR400', '2023-12-01', 'Рабочее', '44999.99', 7, 'Серверная 2, Стойка 14'),
(68, 'AOC 24G2', 'Диагональ: 24\"\nРазрешение: 1920x1080\nЧастота: 144Hz\nМатрица: IPS\nHDR: Нет', '2023-12-01', 'Рабочее', '24999.99', 7, 'Серверная 2, Стойка 14'),
(69, 'ViewSonic VX2758-2KP-MHD', 'Диагональ: 27\"\nРазрешение: 2560x1440\nЧастота: 144Hz\nМатрица: IPS\nHDR: HDR10', '2023-11-15', 'Рабочее', '39999.99', 7, 'Серверная 1, Стойка 21'),
(70, 'BenQ MOBIUZ EX2510S', 'Диагональ: 24.5\"\nРазрешение: 1920x1080\nЧастота: 165Hz\nМатрица: IPS\nHDR: HDR400', '2023-11-15', 'Рабочее', '29999.99', 7, 'Серверная 1, Стойка 21'),
(71, 'Logitech G Pro X Superlight', 'Тип: Мышь\nСенсор: HERO 25K\nDPI: 25600\nВес: 63г\nПодключение: Беспроводное', '2024-01-15', 'Рабочее', '14999.99', 8, 'Серверная 1, Стойка 22'),
(72, 'Razer Huntsman V2 Analog', 'Тип: Клавиатура\nПереключатели: Analog Optical\nПодсветка: RGB\nПодключение: USB-C', '2024-01-15', 'Рабочее', '24999.99', 8, 'Серверная 1, Стойка 22'),
(73, 'SteelSeries Prime Wireless', 'Тип: Мышь\nСенсор: TrueMove Pro\nDPI: 18000\nВес: 80г\nПодключение: Беспроводное', '2024-02-01', 'Рабочее', '12999.99', 8, 'Серверная 2, Стойка 15'),
(74, 'Corsair K100 RGB', 'Тип: Клавиатура\nПереключатели: OPX\nПодсветка: RGB\nПодключение: USB', '2024-02-01', 'Рабочее', '22999.99', 8, 'Серверная 2, Стойка 15'),
(75, 'Glorious Model O', 'Тип: Мышь\nСенсор: BAMF\nDPI: 19000\nВес: 67г\nПодключение: Проводное', '2024-02-15', 'Рабочее', '7999.99', 8, 'Серверная 1, Стойка 23'),
(76, 'Ducky One 3', 'Тип: Клавиатура\nПереключатели: Cherry MX\nПодсветка: RGB\nПодключение: USB-C', '2024-02-15', 'Рабочее', '17999.99', 8, 'Серверная 1, Стойка 23'),
(77, 'Zowie EC2-C', 'Тип: Мышь\nСенсор: 3360\nDPI: 3200\nВес: 73г\nПодключение: Проводное', '2023-12-01', 'Рабочее', '6999.99', 8, 'Серверная 2, Стойка 16'),
(78, 'Keychron Q1', 'Тип: Клавиатура\nПереключатели: Gateron\nПодсветка: RGB\nПодключение: USB-C', '2023-12-01', 'Рабочее', '15999.99', 8, 'Серверная 2, Стойка 16'),
(79, 'Pulsar Xlite V2', 'Тип: Мышь\nСенсор: PAW3370\nDPI: 19000\nВес: 59г\nПодключение: Проводное', '2023-11-15', 'Рабочее', '5999.99', 8, 'Серверная 1, Стойка 24'),
(80, 'Royal Kludge RK84', 'Тип: Клавиатура\nПереключатели: RK\nПодсветка: RGB\nПодключение: Bluetooth/USB', '2023-11-15', 'Рабочее', '8999.99', 8, 'Серверная 1, Стойка 24');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `countbreakdown`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `countbreakdown` (
`couunt_breakdown` bigint
,`id_component` int
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `countdatelastbreakdown`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `countdatelastbreakdown` (
`count_date_last_breakdown` int
,`id_component` int
);

-- --------------------------------------------------------

--
-- Структура таблицы `Declarations`
--

CREATE TABLE `Declarations` (
  `id_declaration` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `declaration` varchar(50) NOT NULL,
  `date_declaration` date NOT NULL,
  `id_component` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Declarations`
--

INSERT INTO `Declarations` (`id_declaration`, `id_user`, `declaration`, `date_declaration`, `id_component`) VALUES
(3, 1, 'Сломалось всё', '2025-03-06', 2),
(10, 2, 'Системный блок сильно шумит при работе', '2024-03-24', 26),
(11, 1, 'Не включается монитор после выходных', '2024-03-15', 21),
(12, 2, 'Принтер печатает с полосами', '2024-03-16', 22),
(13, 1, 'Клавиатура залита кофе, не работают кнопки', '2024-03-17', 23),
(14, 3, 'Мышь периодически зависает при движении', '2024-03-18', 24),
(15, 2, 'Сканер издает странные звуки при работе', '2024-03-19', 25),
(16, 4, 'Не работает USB-порт на системном блоке', '2024-03-20', 26),
(17, 3, 'Изображение на мониторе мерцает', '2024-03-21', 21),
(18, 1, 'Принтер замяло бумагу, не извлекается', '2024-03-22', 22),
(19, 4, 'Не работает левая кнопка мыши', '2024-03-23', 24);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `failurespermonth`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `failurespermonth` (
`category_name` varchar(20)
,`component_name` varchar(50)
,`days_in_use` int
,`failures_per_month` decimal(27,2)
,`id_component` int
,`problem_count` bigint
);

-- --------------------------------------------------------

--
-- Структура таблицы `Rating`
--

CREATE TABLE `Rating` (
  `id_rating` int NOT NULL,
  `id_component` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `grade` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Rating`
--

INSERT INTO `Rating` (`id_rating`, `id_component`, `id_user`, `grade`) VALUES
(1, 5, 1, 9),
(2, 12, 2, 8),
(3, 23, 3, 7),
(4, 34, 4, 9),
(5, 45, 5, 10),
(6, 56, 1, 8),
(7, 67, 2, 9),
(8, 78, 3, 7),
(9, 2, 4, 6),
(10, 13, 5, 9),
(11, 24, 1, 8),
(12, 35, 2, 7),
(13, 46, 3, 9),
(14, 57, 4, 8),
(15, 68, 5, 10),
(16, 79, 1, 9),
(17, 3, 2, 7),
(18, 14, 3, 8),
(19, 25, 4, 9),
(20, 36, 5, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `Removed`
--

CREATE TABLE `Removed` (
  `id_remove` int NOT NULL,
  `date_remove` date NOT NULL,
  `reason` varchar(50) NOT NULL,
  `id_component` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Removed`
--

INSERT INTO `Removed` (`id_remove`, `date_remove`, `reason`, `id_component`) VALUES
(1, '2025-03-02', 'Умер дед', 51),
(2, '2025-03-18', 'Умер дед', 32);

-- --------------------------------------------------------

--
-- Структура таблицы `Repaired`
--

CREATE TABLE `Repaired` (
  `id_repair` int NOT NULL,
  `date_repair` date NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `id_component` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Repaired`
--

INSERT INTO `Repaired` (`id_repair`, `date_repair`, `description`, `id_component`) VALUES
(1, '2025-03-10', 'Рандомный текст', 34),
(2, '2025-03-09', 'Рандомный текст', 24);

-- --------------------------------------------------------

--
-- Структура таблицы `Roles`
--

CREATE TABLE `Roles` (
  `id_role` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Roles`
--

INSERT INTO `Roles` (`id_role`, `name`, `description`) VALUES
(1, 'Пользователь', 'Пользователь системы'),
(2, 'Администратор', 'Админ системы');

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `id_user` int NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(15) NOT NULL,
  `id_role` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`id_user`, `login`, `password`, `id_role`) VALUES
(1, 'Боб', '11111111', 1),
(2, 'Боб1', '22222222', 1),
(3, 'Боб2', '33333333', 1),
(4, 'Боб3', '44444444', 1),
(5, 'Боб4', '55555555', 1),
(7, 'БобГлава', '1', 2),
(8, 'Бабай', '122222222222222', 1);

-- --------------------------------------------------------

--
-- Структура для представления `additiveсriterion` экспортирована как таблица
--
DROP TABLE IF EXISTS `additiveсriterion`;
CREATE TABLE`additiveсriterion`(
    `id_component` int NOT NULL DEFAULT '0',
    `component_name` varchar(50) COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `category_name` varchar(20) COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `additive_criterion` decimal(32,2) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Структура для представления `averagegrade` экспортирована как таблица
--
DROP TABLE IF EXISTS `averagegrade`;
CREATE TABLE`averagegrade`(
    `id_component` int DEFAULT NULL,
    `average_rating` decimal(14,4) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Структура для представления `countbreakdown` экспортирована как таблица
--
DROP TABLE IF EXISTS `countbreakdown`;
CREATE TABLE`countbreakdown`(
    `id_component` int DEFAULT NULL,
    `couunt_breakdown` bigint NOT NULL DEFAULT '0'
);

-- --------------------------------------------------------

--
-- Структура для представления `countdatelastbreakdown` экспортирована как таблица
--
DROP TABLE IF EXISTS `countdatelastbreakdown`;
CREATE TABLE`countdatelastbreakdown`(
    `id_component` int DEFAULT NULL,
    `count_date_last_breakdown` int DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Структура для представления `failurespermonth` экспортирована как таблица
--
DROP TABLE IF EXISTS `failurespermonth`;
CREATE TABLE`failurespermonth`(
    `id_component` int NOT NULL DEFAULT '0',
    `component_name` varchar(50) COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `category_name` varchar(20) COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `problem_count` bigint NOT NULL DEFAULT '0',
    `days_in_use` int DEFAULT NULL,
    `failures_per_month` decimal(27,2) DEFAULT NULL
);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`id_categories`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `Components`
--
ALTER TABLE `Components`
  ADD PRIMARY KEY (`id_component`),
  ADD KEY `id_categories` (`id_categories`);

--
-- Индексы таблицы `Declarations`
--
ALTER TABLE `Declarations`
  ADD PRIMARY KEY (`id_declaration`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_component` (`id_component`);

--
-- Индексы таблицы `Rating`
--
ALTER TABLE `Rating`
  ADD PRIMARY KEY (`id_rating`),
  ADD KEY `id_component` (`id_component`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `Removed`
--
ALTER TABLE `Removed`
  ADD PRIMARY KEY (`id_remove`),
  ADD UNIQUE KEY `id_component` (`id_component`);

--
-- Индексы таблицы `Repaired`
--
ALTER TABLE `Repaired`
  ADD PRIMARY KEY (`id_repair`),
  ADD KEY `id_component` (`id_component`);

--
-- Индексы таблицы `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Categories`
--
ALTER TABLE `Categories`
  MODIFY `id_categories` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `Components`
--
ALTER TABLE `Components`
  MODIFY `id_component` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT для таблицы `Declarations`
--
ALTER TABLE `Declarations`
  MODIFY `id_declaration` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `Rating`
--
ALTER TABLE `Rating`
  MODIFY `id_rating` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `Removed`
--
ALTER TABLE `Removed`
  MODIFY `id_remove` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `Repaired`
--
ALTER TABLE `Repaired`
  MODIFY `id_repair` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `Roles`
--
ALTER TABLE `Roles`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Components`
--
ALTER TABLE `Components`
  ADD CONSTRAINT `components_ibfk_1` FOREIGN KEY (`id_categories`) REFERENCES `Categories` (`id_categories`);

--
-- Ограничения внешнего ключа таблицы `Declarations`
--
ALTER TABLE `Declarations`
  ADD CONSTRAINT `declarations_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `Users` (`id_user`),
  ADD CONSTRAINT `declarations_ibfk_2` FOREIGN KEY (`id_component`) REFERENCES `Components` (`id_component`);

--
-- Ограничения внешнего ключа таблицы `Rating`
--
ALTER TABLE `Rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`id_component`) REFERENCES `Components` (`id_component`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `Users` (`id_user`);

--
-- Ограничения внешнего ключа таблицы `Removed`
--
ALTER TABLE `Removed`
  ADD CONSTRAINT `removed_ibfk_1` FOREIGN KEY (`id_component`) REFERENCES `Components` (`id_component`);

--
-- Ограничения внешнего ключа таблицы `Repaired`
--
ALTER TABLE `Repaired`
  ADD CONSTRAINT `repaired_ibfk_1` FOREIGN KEY (`id_component`) REFERENCES `Components` (`id_component`);

--
-- Ограничения внешнего ключа таблицы `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `Roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
