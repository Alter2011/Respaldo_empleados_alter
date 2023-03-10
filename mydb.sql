-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2018 at 03:27 AM
-- Server version: 10.1.36-MySQL
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `imagen` blob,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`codigo`, `nombre`, `apellido`, `email`, `clave`, `telefono`, `direccion`, `imagen`, `rol`) VALUES
(1, 'Vladimir', 'Hernandez', 'vladexander@gmail.com', '202cb962ac59075b964b07152d234b70', '77484663', 'Goascoran', '', 'Administrador'),
(3, 'Hector', 'Hernandez', 'hector.aha08@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', '12345678', 'Casa', '', 'Administrador'),
(5, 'admin', 'admin', 'admin@mail.com', '21232f297a57a5a743894a0e4a801fc3', '12345678', 'direccion', '', 'Administrador'),
(15, 'Walter', 'Sanchez', 'walter@mail.com', '202cb962ac59075b964b07152d234b70', '12345678', 'calle, avenida, casa', 0x433a5c66616b65706174685c46414d494c4941202d2057494e5f32303137303831315f3135343830392e4a5047, 'Usuario'),
(16, 'Maria', 'Crespin Hernandez', 'maria@mail.com', '202cb962ac59075b964b07152d234b70', '1234598', 'Nueva Direccion', '', 'Usuario');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
