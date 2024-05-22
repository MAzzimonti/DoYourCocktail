-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2024 at 08:44 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doyourcocktail`
--

-- --------------------------------------------------------

--
-- Table structure for table `cocktail`
--

CREATE TABLE `cocktail` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `data_pubblicazione` date DEFAULT NULL,
  `immagine` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cocktail`
--

INSERT INTO `cocktail` (`id`, `nome`, `descrizione`, `data_pubblicazione`, `immagine`) VALUES
(1, 'Margarita', 'Un cocktail classico a base di tequila.', '2024-05-01', 'margarita.jpg'),
(2, 'Mojito', 'Un cocktail rinfrescante a base di rum.', '2024-05-02', 'mojito.jpg'),
(3, 'Negroni', 'Un cocktail italiano a base di gin.', '2024-05-03', 'negroni.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `co_ingr`
--

CREATE TABLE `co_ingr` (
  `id_cocktail` int(11) NOT NULL,
  `id_ingredienti` int(11) NOT NULL,
  `dosaggio` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `co_ingr`
--

INSERT INTO `co_ingr` (`id_cocktail`, `id_ingredienti`, `dosaggio`) VALUES
(1, 1, '50ml'),
(1, 4, '20ml'),
(1, 5, '30ml'),
(2, 2, '50ml'),
(2, 6, '10 foglie'),
(2, 7, '2 cucchiaini'),
(3, 3, '30ml'),
(3, 7, '1 cucchiaino'),
(3, 8, '30ml');

-- --------------------------------------------------------

--
-- Table structure for table `ingredienti`
--

CREATE TABLE `ingredienti` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ingredienti`
--

INSERT INTO `ingredienti` (`id`, `nome`) VALUES
(1, 'Tequila'),
(2, 'Rum'),
(3, 'Gin'),
(4, 'Triple Sec'),
(5, 'Succo di lime'),
(6, 'Menta'),
(7, 'Zucchero'),
(8, 'Vermouth Rosso');

-- --------------------------------------------------------

--
-- Table structure for table `recensione`
--

CREATE TABLE `recensione` (
  `id` int(11) NOT NULL,
  `valutazione` int(11) NOT NULL,
  `commento` text DEFAULT NULL,
  `data_recensione` date NOT NULL,
  `id_cocktail` int(11) DEFAULT NULL,
  `id_utente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recensione`
--

INSERT INTO `recensione` (`id`, `valutazione`, `commento`, `data_recensione`, `id_cocktail`, `id_utente`) VALUES
(1, 5, 'Fantastico! Uno dei migliori cocktail che abbia mai bevuto.', '2024-05-10', 1, 1),
(2, 4, 'Molto buono, ma un po\' troppo dolce per i miei gusti.', '2024-05-11', 2, 2),
(3, 3, 'Niente di speciale, ma comunque rinfrescante.', '2024-05-12', 2, 3),
(4, 5, 'Un classico senza tempo!', '2024-05-13', 3, 1),
(5, 4, 'Ottimo, ma il gin ? un po\' troppo forte.', '2024-05-14', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utente`
--

INSERT INTO `utente` (`id`, `nome`, `cognome`, `email`, `password`) VALUES
(1, 'Mario', 'Rossi', 'mario.rossi@example.com', 'password1'),
(2, 'Luigi', 'Verdi', 'luigi.verdi@example.com', 'password2'),
(3, 'Anna', 'Bianchi', 'anna.bianchi@example.com', 'password3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cocktail`
--
ALTER TABLE `cocktail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `co_ingr`
--
ALTER TABLE `co_ingr`
  ADD PRIMARY KEY (`id_cocktail`,`id_ingredienti`),
  ADD KEY `id_ingredienti` (`id_ingredienti`);

--
-- Indexes for table `ingredienti`
--
ALTER TABLE `ingredienti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cocktail` (`id_cocktail`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indexes for table `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cocktail`
--
ALTER TABLE `cocktail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ingredienti`
--
ALTER TABLE `ingredienti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `recensione`
--
ALTER TABLE `recensione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `co_ingr`
--
ALTER TABLE `co_ingr`
  ADD CONSTRAINT `co_ingr_ibfk_1` FOREIGN KEY (`id_cocktail`) REFERENCES `cocktail` (`id`),
  ADD CONSTRAINT `co_ingr_ibfk_2` FOREIGN KEY (`id_ingredienti`) REFERENCES `ingredienti` (`id`);

--
-- Constraints for table `recensione`
--
ALTER TABLE `recensione`
  ADD CONSTRAINT `recensione_ibfk_1` FOREIGN KEY (`id_cocktail`) REFERENCES `cocktail` (`id`),
  ADD CONSTRAINT `recensione_ibfk_2` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
