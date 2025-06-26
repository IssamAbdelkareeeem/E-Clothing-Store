-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2025 at 09:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web1211821_clothingstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` decimal(3,1) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `description`, `price`, `rating`, `image`, `quantity`) VALUES
(19, 'Silk Blouse', 'Blouses', 'Made from luxurious, smooth silk\r\n\r\nLightweight and breathable\r\n\r\nIdeal for office or elegant casual looks', 49.99, 4.0, '19.jpg', 30),
(21, 'Canvas Tote Bag', 'Bags', 'Spacious with sturdy parallel handles\r\n\r\nMade from canvas, leather, or synthetics\r\n\r\nPerfect for daily use, shopping, or work', 29.99, 4.0, '21.jpg', 39),
(25, 'Dark Mocha Air Jordan 1', 'Shoes', 'High-top sneaker with brown, black, and white colorway\r\n\r\nPremium leather construction\r\n\r\nPopular in streetwear and sneaker culture', 350.00, 5.0, '25.jpeg', 12),
(26, 'White Tee', 'T-Shirts', '100% Cotton\r\n\r\nClassic short-sleeve cotton t-shirt\r\n\r\nClean, versatile design\r\n\r\nCan be worn alone or as a base layer\r\n\r\n', 59.99, 4.0, '26.jpeg', 13),
(27, 'Puffer Jacket', 'Jackets', 'jacket', 300.00, 3.0, '363.jpeg', 12),
(28, 'Phantom Jordan 1', 'Shoes', 'Amazing shoe looks good on every fit fr', 1500.00, 4.0, '575.jpeg', 3),
(30, 'Black T-Shirt', 'T-Shirts', 'black tshirt', 30.00, 2.0, '30.jpeg', 4),
(31, 'T-Shirt (CS special edition)', 'T-Shirts', 'C.S t-shirt', 55.00, 5.0, '31.jpeg', 55),
(32, 'original blue jeans', 'Jeans', 'very original , good texture', 35.00, 3.0, '32.jpeg', 9),
(33, 'white jacket', 'Jackets', 'white jacket - for men', 35.00, 4.0, '33.jpeg', 12),
(35, 'big boy eng shirts ', 'T-Shirts', 'engineer in top', 420.00, 5.0, '35.jpeg', 3),
(36, 'Black jacket ', 'Jackets', 'Nike black jacket', 69.50, 5.0, '36.jpeg', 5),
(37, 'Dungarees Outfit', 'Dungarees', 'good looking blue color outfit', 35.69, 5.0, '37.jpeg', 31);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
