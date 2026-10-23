-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Oct 23, 2026 at 07:16 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mathplay`
--

-- --------------------------------------------------------

--
-- Table structure for table `questoes`
--

CREATE TABLE `questoes` (
  `id` int NOT NULL,
  `tipo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pergunta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `alternativa_a` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alternativa_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alternativa_c` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alternativa_d` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resposta_correta` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `explicacao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dificuldade` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'facil'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questoes`
--

INSERT INTO `questoes` (`id`, `tipo`, `pergunta`, `alternativa_a`, `alternativa_b`, `alternativa_c`, `alternativa_d`, `resposta_correta`, `explicacao`, `dificuldade`) VALUES
(1, 'inteiros', 'Quanto é -8 + 13?', '-21', '5', '-5', '21', 'B', 'Quando somamos -8 com +13, podemos calcular 13 - 8 = 5. Como o número positivo é maior, o resultado fica positivo. Portanto, a resposta é 5.', 'facil'),
(2, 'inteiros', 'Quanto é -7 - 5?', '12', '-2', '-12', '2', 'C', 'Temos -7 - 5. Subtrair 5 de -7 significa andar mais 5 unidades para a esquerda na reta numérica. Assim, -7 - 5 = -12.', 'facil'),
(3, 'inteiros', 'Quanto é (-4) × (-3)?', '-12', '7', '12', '-7', 'C', 'Na multiplicação, quando temos dois números negativos, o resultado é positivo. Então 4 × 3 = 12. Portanto, (-4) × (-3) = 12.', 'medio'),
(4, 'inteiros', 'Quanto é 20 ÷ (-4)?', '5', '-5', '16', '-16', 'B', 'Quando dividimos um número positivo por um número negativo, o resultado é negativo. 20 ÷ 4 = 5, então 20 ÷ (-4) = -5.', 'medio'),
(5, 'equacoes', 'Resolva: 2x + 6 = 14', '2', '4', '6', '8', 'B', 'Primeiro retiramos 6 dos dois lados: 2x = 14 - 6. Então 2x = 8. Agora dividimos os dois lados por 2: x = 4.', 'facil'),
(6, 'equacoes', 'Resolva: x + 9 = 15', '4', '5', '6', '7', 'C', 'Para descobrir x, precisamos retirar 9 dos dois lados. Assim: x = 15 - 9. Portanto, x = 6.', 'facil'),
(7, 'equacoes', 'Resolva: 3x = 21', '6', '7', '8', '9', 'B', 'Como 3x significa 3 multiplicado por x, dividimos 21 por 3. Assim: x = 21 ÷ 3 = 7.', 'facil'),
(8, 'equacoes', 'Resolva: 4x - 8 = 16', '4', '5', '6', '7', 'C', 'Primeiro adicionamos 8 aos dois lados: 4x = 24. Depois dividimos por 4: x = 6.', 'medio');

-- --------------------------------------------------------

--
-- Table structure for table `respostas`
--

CREATE TABLE `respostas` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `questao_id` int NOT NULL,
  `resposta_usuario` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acertou` tinyint(1) NOT NULL,
  `xp_ganho` int DEFAULT '0',
  `respondido_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `respostas`
--

INSERT INTO `respostas` (`id`, `usuario_id`, `questao_id`, `resposta_usuario`, `acertou`, `xp_ganho`, `respondido_em`) VALUES
(1, 1, 3, 'A', 0, 0, '2026-10-09 21:03:22'),
(2, 1, 1, 'B', 1, 10, '2026-10-09 21:03:37'),
(3, 1, 1, 'B', 1, 10, '2026-10-09 21:03:52'),
(4, 1, 1, 'D', 0, 0, '2026-10-09 21:04:00'),
(5, 1, 1, 'D', 0, 0, '2026-10-09 21:05:50'),
(6, 1, 3, 'A', 0, 0, '2026-10-09 21:07:37'),
(7, 1, 4, 'B', 1, 10, '2026-10-09 21:07:44'),
(8, 1, 4, 'B', 1, 10, '2026-10-09 21:07:58'),
(9, 1, 1, 'B', 1, 10, '2026-10-09 21:08:13'),
(10, 1, 1, 'B', 1, 10, '2026-10-09 21:08:17'),
(11, 1, 4, 'B', 1, 10, '2026-10-09 21:08:21'),
(12, 1, 2, 'C', 1, 10, '2026-10-09 21:14:22'),
(13, 1, 3, 'A', 0, 0, '2026-10-09 21:14:28'),
(14, 1, 1, 'B', 1, 10, '2026-10-09 21:14:35'),
(15, 1, 4, 'B', 1, 10, '2026-10-09 21:14:40'),
(16, 1, 5, 'B', 1, 10, '2026-10-09 21:15:40'),
(17, 1, 6, 'C', 1, 10, '2026-10-09 21:16:16'),
(18, 1, 7, 'B', 1, 10, '2026-10-09 21:16:52'),
(19, 1, 8, 'C', 1, 10, '2026-10-09 21:17:44'),
(20, 1, 4, 'B', 1, 10, '2026-10-21 14:13:20'),
(21, 1, 3, 'A', 0, 0, '2026-10-21 14:13:27'),
(22, 1, 2, 'C', 1, 10, '2026-10-21 14:13:40'),
(23, 1, 1, 'A', 0, 0, '2026-10-21 14:13:49'),
(24, 1, 8, 'D', 0, 0, '2026-10-21 14:14:21'),
(25, 3, 2, 'D', 0, 0, '2026-10-21 14:33:21'),
(26, 3, 3, 'A', 0, 0, '2026-10-21 16:47:05'),
(27, 3, 4, 'A', 0, 0, '2026-10-21 16:47:15'),
(28, 3, 1, 'B', 1, 10, '2026-10-21 16:47:22'),
(29, 3, 2, 'C', 1, 10, '2026-10-21 16:47:31'),
(30, 1, 3, 'C', 1, 10, '2026-10-21 16:48:17'),
(31, 1, 1, 'B', 1, 10, '2026-10-21 16:48:21'),
(32, 1, 4, 'A', 0, 0, '2026-10-21 16:48:28'),
(33, 1, 2, 'A', 0, 0, '2026-10-21 16:48:36'),
(34, 1, 3, 'B', 0, 0, '2026-10-21 16:58:57'),
(35, 1, 4, 'C', 0, 0, '2026-10-21 16:59:02'),
(36, 1, 2, 'D', 0, 0, '2026-10-21 16:59:04'),
(37, 1, 1, 'C', 0, 0, '2026-10-21 16:59:06'),
(38, 1, 5, 'B', 1, 10, '2026-10-21 16:59:15'),
(39, 1, 7, 'D', 0, 0, '2026-10-21 16:59:18'),
(40, 1, 8, 'C', 1, 10, '2026-10-21 16:59:21'),
(41, 1, 6, 'B', 0, 0, '2026-10-21 16:59:24'),
(42, 1, 5, 'A', 0, 0, '2026-10-21 16:59:28'),
(43, 1, 8, 'C', 1, 10, '2026-10-21 16:59:31'),
(44, 1, 7, 'C', 0, 0, '2026-10-21 16:59:33'),
(45, 1, 6, 'C', 1, 10, '2026-10-21 16:59:35'),
(46, 1, 2, 'A', 0, 0, '2026-10-21 17:02:03'),
(47, 1, 4, 'C', 0, 0, '2026-10-21 17:02:05'),
(48, 1, 3, 'C', 1, 10, '2026-10-21 17:02:08'),
(49, 1, 2, 'C', 1, 10, '2026-10-21 17:02:43'),
(50, 1, 4, 'B', 1, 10, '2026-10-21 17:02:46'),
(51, 3, 2, 'A', 0, 0, '2026-10-21 21:16:52'),
(52, 3, 4, 'B', 1, 10, '2026-10-21 21:16:59'),
(53, 3, 3, 'C', 1, 10, '2026-10-21 21:17:05'),
(54, 3, 1, 'B', 1, 10, '2026-10-21 21:17:09'),
(55, 3, 2, 'A', 0, 0, '2026-10-21 21:17:15'),
(56, 3, 4, 'A', 0, 0, '2026-10-21 21:17:31'),
(57, 3, 1, 'B', 1, 10, '2026-10-21 21:17:35'),
(58, 3, 3, 'C', 1, 10, '2026-10-21 21:17:40'),
(59, 3, 1, 'B', 1, 10, '2026-10-21 21:17:58'),
(60, 3, 3, 'C', 1, 10, '2026-10-21 21:18:04'),
(61, 3, 2, 'A', 0, 0, '2026-10-21 21:18:12'),
(62, 3, 4, 'B', 1, 10, '2026-10-21 21:18:20'),
(63, 3, 2, 'A', 0, 0, '2026-10-21 21:18:28'),
(64, 1, 7, 'B', 1, 10, '2026-10-21 21:58:28'),
(65, 1, 8, 'C', 1, 10, '2026-10-21 21:58:42'),
(66, 1, 5, 'B', 1, 10, '2026-10-21 22:00:11'),
(67, 1, 6, 'C', 1, 10, '2026-10-21 22:00:35'),
(68, 1, 5, 'B', 1, 10, '2026-10-21 22:00:57'),
(69, 1, 7, 'B', 1, 10, '2026-10-21 22:01:02'),
(70, 1, 8, 'C', 1, 10, '2026-10-21 22:02:00'),
(71, 1, 6, 'C', 1, 10, '2026-10-21 22:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xp` int NOT NULL DEFAULT '0',
  `nivel` int NOT NULL DEFAULT '1',
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `xp`, `nivel`, `criado_em`) VALUES
(1, 'evellyn', 'evellyn@gmail.com', '$2y$10$7Joynjyi3UoN2yxHoiIR4OglfmUP/JNIAD7JaVsZdLFhSvSbfIS1S', 330, 3, '2026-10-09 20:49:43'),
(3, 'bingo', 'test@gmail', '$2y$10$.O/gOv6YROhlHOeiCbjVTuoXiTvQLRKaUvNXfukKvoIJtOJNHE8n6', 100, 2, '2026-10-21 14:33:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questoes`
--
ALTER TABLE `questoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_respostas_usuario` (`usuario_id`),
  ADD KEY `idx_respostas_questao` (`questao_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_usuarios_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questoes`
--
ALTER TABLE `questoes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `fk_respostas_questao` FOREIGN KEY (`questao_id`) REFERENCES `questoes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_respostas_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
