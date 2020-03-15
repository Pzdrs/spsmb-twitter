-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 15. bře 2020, 23:23
-- Verze serveru: 10.4.8-MariaDB
-- Verze PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `spsmbtwitter`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `general`
--

CREATE TABLE `general` (
  `id` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `general`
--

INSERT INTO `general` (`id`, `content`) VALUES
('forgot_password_email_message', 'Your password is: $password'),
('forgot_password_email_not_corresponding', 'The entered email does not corresspond with the user associated one.'),
('forgot_password_email_subject', 'SPSMB Twitter - Forgot password'),
('login_banned', 'You are banned from the website for:<br>$banReason'),
('login_invalid_user', 'This user does not exist.\r\n'),
('login_wrong_password', 'You have entered the wrong password.'),
('register_passwords_not_same', 'The passwords you have entered does not match.'),
('register_space_in_username', 'Do not include spaces in username'),
('website_accessible', 'true'),
('website_author', 'Pzdrs'),
('website_description', 'SPSMB Twitter knockoff. It is basically the same thing but SPSMB motivated.'),
('website_keywords', 'spsmb, twitter, pzdrs, wap, zaverecna prace'),
('website_name', 'SPSMB Twitter'),
('website_notAccessible', 'The website is currently not accessible due to maintenance.');

-- --------------------------------------------------------

--
-- Struktura tabulky `tweets`
--

CREATE TABLE `tweets` (
  `id` int(11) NOT NULL,
  `authorId` int(11) NOT NULL,
  `postedOn` datetime NOT NULL,
  `content` text NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `rank` enum('MEMBER','ADMINISTRATOR') NOT NULL DEFAULT 'MEMBER',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `displayName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tweets` int(11) NOT NULL DEFAULT 0,
  `likedTweets` text NOT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `banReason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `rank`, `username`, `password`, `displayName`, `email`, `tweets`, `likedTweets`, `banned`, `banReason`) VALUES
(14, 'ADMINISTRATOR', 'admin', '$2y$10$lhV6WKjaHI3fDRseEaDPoeZSWOSuySBJ8feuo91I1LmEI/qb7xv9S', 'Administrátor', 'administrator@admin.com', 0, ', 5', 0, '');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `general`
--
ALTER TABLE `general`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `tweets`
--
ALTER TABLE `tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
