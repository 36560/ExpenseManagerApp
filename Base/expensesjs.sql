-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Kwi 2022, 16:47
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `expensesjs`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8_polish_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_bill` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `category_name` varchar(250) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `bills`
--

INSERT INTO `bills` (`id`, `title`, `amount`, `date_bill`, `id_user`, `category_name`) VALUES
(55, 'przyjęcie', '100.00', '2021-12-25', 2, 'Food'),
(58, 'Rachunek za prąd', '20.00', '2023-01-01', 2, 'Bills');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE `category` (
  `name` varchar(250) COLLATE utf8_polish_ci NOT NULL,
  `image` varchar(550) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `category`
--

INSERT INTO `category` (`name`, `image`) VALUES
('Bills', 'https://img.icons8.com/external-itim2101-flat-itim2101/344/external-bills-financial-itim2101-flat-itim2101.png'),
('Food', 'https://img.icons8.com/emoji/344/sandwich-emoji.png'),
('Home', 'https://img.icons8.com/cute-clipart/344/home.png'),
('Incomes', 'https://img.icons8.com/external-flaticons-lineal-color-flat-icons/344/external-income-gig-economy-flaticons-lineal-color-flat-icons.png'),
('Loans', 'https://img.icons8.com/external-flaticons-flat-flat-icons/344/external-term-loan-finance-flaticons-flat-flat-icons-2.png'),
('Other incomes', 'https://img.icons8.com/external-flaticons-flat-flat-icons/344/external-income-digital-marketing-flaticons-flat-flat-icons.png'),
('Savings', 'https://img.icons8.com/external-flaticons-flat-flat-icons/344/external-savings-e-commerce-flaticons-flat-flat-icons.png'),
('Shopping', 'https://img.icons8.com/plasticine/344/shopping-cart-loaded.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(250) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(550) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(2, 'login', '$2y$10$1HlTIlImxEbfRFmzfG3m8eAzDzkyEQnuUh5g957LZ85J6hKy8mNBe');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `category_name` (`category_name`);

--
-- Indeksy dla tabeli `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`name`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bills_ibfk_2` FOREIGN KEY (`category_name`) REFERENCES `category` (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
