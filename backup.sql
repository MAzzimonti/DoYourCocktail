-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 12:57 PM
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
(3, 'Negroni', 'Un cocktail italiano a base di gin.', '2024-05-03', 'negroni.jpg'),
(4, 'Pina Colada', 'Un cocktail tropicale a base di rum, crema di cocco e succo di ananas.', '2024-05-04', 'pinacolada.jpg'),
(5, 'Cosmopolitan', 'Un cocktail alla moda a base di vodka, triple sec, succo di lime e cranberry.', '2024-05-05', 'cosmopolitan.jpg'),
(6, 'Bloody Mary', 'Un cocktail salato a base di vodka, succo di pomodoro e spezie.', '2024-05-06', 'bloodymary.jpg'),
(7, 'Mai Tai', 'Un cocktail esotico a base di rum, cura?ao e lime.', '2024-05-07', 'maitai.jpg'),
(8, 'Old Fashioned', 'Un cocktail classico a base di bourbon o rye whiskey, zucchero, angostura e una spruzzata di acqua.', '2024-05-08', 'oldfashioned.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cocktail`
--
ALTER TABLE `cocktail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cocktail`
--
ALTER TABLE `cocktail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
