-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2025 at 12:09 AM
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
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `publish_year` year(4) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `publish_year`, `isbn`, `quantity`) VALUES
(1, 'wv', 'q', '2011', '11', 12),
(2, 'w', 'q1', '0000', '110', 2),
(3, 'Introduction To Python', 'q', '2011', '110', 10),
(4, 'Python', 'w', '2009', '1101', 2),
(5, 'w22', 'qrt', '2011', '211', 2),
(6, 'we', 'h', '0000', '77', 0),
(7, 'zxc', 'gg', '2009', '44', 20),
(8, 'zzz', 'asa', '2009', '11', 22),
(9, 'aa', 'aa', '0000', 'aa', 1),
(10, 'zzz11', 'asa', '2009', '11', 22),
(11, 'zzz', 'asa', '2009', '11', 22);

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date NOT NULL,
  `fees` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `student_name`, `student_id`, `email`, `book_title`, `borrow_date`, `return_date`, `fees`, `token`) VALUES
(1, 's', '18-38312-2', '18-38312-2@student.aiub.edu', 'w', '2025-01-01', '2025-01-11', 11, 'Bo113'),
(2, 's', '18-38312-2', '18-38312-2@student.aiub.edu', 'Introduction To Python', '2025-01-01', '2025-01-11', 11, 'Bo113'),
(3, 's', '18-38312-2', '18-38312-2@student.aiub.edu', 'Introduction To Python', '2025-01-01', '2025-01-11', 11, 'Bo113'),
(4, 's', '18-38312-2', '18-38312-2@student.aiub.edu', 'Introduction To Python', '2025-01-01', '2025-01-11', 11, 'Bo113'),
(5, 's', '18-38312-2', '18-38312-2@student.aiub.edu', 'Introduction To Python', '2025-01-01', '2025-01-11', 11, 'Bo113'),
(6, 's', '18-38312-2', '18-38312-2@student.aiub.edu', 'w', '2025-01-08', '2025-01-18', 11, 'Bo113'),
(7, 's', '18-38312-2', '18-38312-2@student.aiub.edu', 'Introduction To Python', '2025-01-01', '2025-01-11', 11, '11de'),
(8, 's', '18-38312-2', '18-38312-2@student.aiub.edu', 'Introduction To Python', '2025-01-09', '2025-01-13', 21, 'jj211'),
(9, 's', '18-38312-2', '18-38312-2@student.aiub.edu', 'w', '2025-01-08', '2025-01-16', 33, 'zz11'),
(10, 's', '18-38312-2', '18-38312-2@student.aiub.edu', 'aa', '2025-01-01', '2025-01-11', 11, 'jj21');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(50) NOT NULL,
  `used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `token`, `used`) VALUES
(21, 'aa11', 0),
(22, 'aa22', 0),
(23, 'jj21', 0),
(24, '1q11', 0),
(25, 'zz11', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
