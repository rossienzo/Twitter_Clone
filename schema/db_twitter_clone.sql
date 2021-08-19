-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 03-Out-2020 às 23:42
-- Versão do servidor: 10.1.35-MariaDB
-- versão do PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitter_clone`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tweets`
--

CREATE TABLE `tweets` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tweet` varchar(140) NOT NULL,
  `data` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tweets`
--

INSERT INTO `tweets` (`id`, `id_usuario`, `tweet`, `data`) VALUES
(2, 20, 'wetwtet', '2020-05-26 10:53:16'),
(3, 22, 'teswet', '2020-05-26 11:00:10'),
(5, 22, 'eba', '2020-05-26 11:18:18'),
(6, 22, 'eee', '2020-05-26 11:23:37'),
(7, 22, 'Mais um tweet test\r\n', '2020-05-26 11:45:10'),
(8, 22, 's', '2020-05-26 11:47:06'),
(10, 25, 'Eu sou Clara', '2020-05-27 11:35:23'),
(11, 25, 'out', '2020-05-27 14:27:16'),
(12, 25, '', '2020-05-27 14:41:49'),
(37, 19, '1', '2020-05-28 16:57:13'),
(38, 19, '2', '2020-05-28 16:57:17'),
(39, 19, '3', '2020-05-28 16:57:19'),
(40, 19, '4', '2020-05-28 16:57:19'),
(41, 19, '5', '2020-05-28 16:57:20'),
(42, 19, '6', '2020-05-28 16:57:21'),
(43, 19, '7', '2020-05-28 16:57:22'),
(44, 19, '8', '2020-05-28 16:57:23'),
(45, 19, '9', '2020-05-28 16:57:25'),
(48, 19, '11\r\n', '2020-05-29 10:10:08'),
(51, 19, '14', '2020-05-29 10:10:14'),
(52, 19, '15', '2020-05-29 10:10:16'),
(53, 19, '16', '2020-05-29 10:10:18'),
(54, 19, '17', '2020-05-29 10:10:20'),
(55, 19, '18', '2020-05-29 10:10:22'),
(56, 19, '19', '2020-05-29 10:10:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(19, 'admin', 'admin@hot', 'c93ccd78b2076528346216b3b2f701e6'),
(22, 'test', 'test@hot', 'e10adc3949ba59abbe56e057f20f883e'),
(23, 'jose', 'jose@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(25, 'Clara', 'clara@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(26, 'Altair', 'altair@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(27, 'paulo', 'paulo@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_seguidores`
--

CREATE TABLE `usuarios_seguidores` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_usuario_seguindo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios_seguidores`
--

INSERT INTO `usuarios_seguidores` (`id`, `id_usuario`, `id_usuario_seguindo`) VALUES
(20, 19, 26),
(23, 25, 19),
(24, 19, 25),
(25, 19, 23);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios_seguidores`
--
ALTER TABLE `usuarios_seguidores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `usuarios_seguidores`
--
ALTER TABLE `usuarios_seguidores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
