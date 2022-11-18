-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 18. Nov 2022 um 17:11
-- Server-Version: 10.4.25-MariaDB
-- PHP-Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `be17_cr5_animal_adoption_david`
--
CREATE DATABASE IF NOT EXISTS `be17_cr5_animal_adoption_david` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be17_cr5_animal_adoption_david`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `location` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `size` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `vaccinated` varchar(5) NOT NULL,
  `breed` varchar(50) NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `pets`
--

INSERT INTO `pets` (`id`, `name`, `location`, `description`, `size`, `age`, `vaccinated`, `breed`, `picture`) VALUES
(2, 'David', 'Hasenstrasse 10', 'Baby bunny', 'small', 2, 'Yes', 'Bunny', '637770e47700a.jpg'),
(4, 'Garfield', 'Teststrasse 100', 'Big fat cat loves lasagne', 'large', 9, 'No', 'Cat', '637765fd15dec.jpg'),
(5, 'Anton', 'Snake street 3', 'White snake', 'small', 2, 'No', 'Snake', '63776fca6567d.jpg'),
(6, 'Armin', 'Meidlinger Strasse 3', 'cute Hamster ', 'small', 3, 'Yes', 'Hamster', '63777004afc16.jpg'),
(7, 'Andrew T.', 'Burgstrasse 3', 'Loudly bird', 'small', 8, 'No', 'Bird', '637770ac6db63.jpg'),
(8, 'Joshua', 'Praterstern 2', 'Happy dog', 'large', 5, 'Yes', 'Dog', '6377717de0720.jpg'),
(9, 'Felix', 'Schäferstrasse 80', 'German Shepperd', 'Large', 10, 'Yes', 'Dog', '63777dcf56adf.jpg'),
(10, 'Alfred', 'Baumgasse 77', 'Big albino snake', 'large', 10, 'No', 'Snake', '63777e5655db2.jpg'),
(11, 'Andy', 'Papageigasse 1', 'Bird', 'small', 9, 'Yes', 'Bird', '63777f0e39314.jpg'),
(12, 'Michael B.', 'Wr. Neustadt 23', 'Dog', 'large', 6, 'No', 'Dog', '637786dc6a0ce.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) DEFAULT NULL,
  `fk_pet_id` int(11) DEFAULT NULL,
  `adoption_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email`, `phone_number`, `address`, `picture`, `status`) VALUES
(4, 'admin', 'admin', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'admin@mail.com', '123456789', 'Admin street 12', 'admavatar.png', 'adm'),
(5, 'User2', 'Man', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'user@mail.com', '6456375345', 'user street 11', '637755d32cf54.png', 'user'),
(6, 'David', 'Nguyen', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'david@mail.com', '067762034244', 'Davidgasse 123', 'avatar.png', 'user');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`fk_user_id`),
  ADD KEY `fk_pet_id` (`fk_pet_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pet_adoption_ibfk_2` FOREIGN KEY (`fk_pet_id`) REFERENCES `pets` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
