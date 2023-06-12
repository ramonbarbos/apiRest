-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 12-Jun-2023 às 18:03
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `api`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agenda`
--

DROP TABLE IF EXISTS `agenda`;
CREATE TABLE IF NOT EXISTS `agenda` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_funcionario` int NOT NULL,
  `nm_funcionario` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_usuario` int NOT NULL,
  `nm_usuario` varchar(120) NOT NULL,
  `data_hora` datetime NOT NULL,
  `id_servico` varchar(120) NOT NULL,
  `valor` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `agenda`
--

INSERT INTO `agenda` (`id`, `id_funcionario`, `nm_funcionario`, `id_usuario`, `nm_usuario`, `data_hora`, `id_servico`, `valor`) VALUES
(26, 25, 'Carlos', 21, 'cliente', '2023-05-28 14:54:57', 'Barba', '7'),
(27, 25, 'Carlos', 21, 'cliente', '2023-05-28 14:57:35', 'Barba', '7'),
(28, 25, 'Carlos', 22, 'Clliente_02', '2023-05-28 15:16:07', 'Barba', '7'),
(29, 25, 'Carlos', 22, 'Clliente_02', '2023-05-28 15:16:07', 'Cabelo', '15'),
(30, 25, 'Carlos', 21, 'cliente', '2023-05-28 15:22:26', 'Barba', '7'),
(31, 25, 'Carlos', 22, 'Clliente_02', '2023-05-28 15:24:38', 'Cabelo', '15'),
(32, 23, 'TESTE', 22, 'Clliente_02', '2023-07-30 00:47:09', 'Barba', '7'),
(33, 26, 'Ulisses cortador', 21, 'cliente', '2023-06-02 19:49:13', 'Cabelo', '15'),
(34, 23, 'TESTE', 21, 'cliente', '2023-06-05 01:43:05', 'Barba', '7'),
(42, 25, 'Carlos', 24, 'Ramon', '2023-06-12 00:58:24', 'Cabelo', '15'),
(36, 26, 'Ulisses cortador', 21, 'cliente', '2023-06-06 13:57:15', 'Cabelo', '15'),
(37, 26, 'Ulisses cortador', 21, 'cliente', '2023-06-05 14:00:37', 'Cabelo', '15'),
(43, 26, 'Ulisses', 24, 'Ramon', '2023-06-09 01:55:10', 'Cabelo + Barba', '27'),
(44, 23, 'Jefersson', 24, 'Ramon', '2023-05-04 01:56:09', 'Barba', '7'),
(46, 23, 'Jefersson', 24, 'Ramon', '2023-06-15 02:08:29', 'Cabelo + Barba', '27'),
(47, 26, 'Ulisses', 22, 'Clliente_02', '2023-06-12 16:54:54', 'Cabelo + Barba', '27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade`
--

DROP TABLE IF EXISTS `cidade`;
CREATE TABLE IF NOT EXISTS `cidade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nm_cidade` varchar(120) NOT NULL,
  `estado` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `cidade`
--

INSERT INTO `cidade` (`id`, `nm_cidade`, `estado`) VALUES
(1, 'Salvador', 'Bahia'),
(2, 'Pres. Tanc. Neves', 'Bahia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE IF NOT EXISTS `funcionario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `nm_funcionario` varchar(120) NOT NULL,
  `nm_cargo` varchar(100) NOT NULL,
  `endereco` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `contato` varchar(15) NOT NULL,
  `ativo` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unico` (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`id`, `usuario_id`, `nm_funcionario`, `nm_cargo`, `endereco`, `bairro`, `cidade`, `contato`, `ativo`) VALUES
(26, 23, 'Ulisses', 'Barberio', 'avenida', 'Centro', 'Salvador', '123456789', 's'),
(23, 1, 'Jefersson', 'cargo teste', 'teste', 'teste', 'Salvador', '1234577656', 's'),
(25, 20, 'Carlos', 'Barbeiro', 'Av. Ipiranga', 'Ipiranga', 'Pres. Tanc. Neves', '123456789', 's');

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

DROP TABLE IF EXISTS `servico`;
CREATE TABLE IF NOT EXISTS `servico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nm_servico` varchar(100) NOT NULL,
  `valor` double(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `servico`
--

INSERT INTO `servico` (`id`, `nm_servico`, `valor`) VALUES
(1, 'Cabelo', 15),
(2, 'Barba', 7),
(4, 'Cabelo + Barba', 27);

-- --------------------------------------------------------

--
-- Estrutura da tabela `token_autorizados`
--

DROP TABLE IF EXISTS `token_autorizados`;
CREATE TABLE IF NOT EXISTS `token_autorizados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` varchar(150) NOT NULL,
  `status` enum('N','S') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_UN` (`token`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `token_autorizados`
--

INSERT INTO `token_autorizados` (`id`, `token`, `status`) VALUES
(1, 'pV7bu23OGriN2Lcu7arHqygklyoP08sxufCt364430cd3beb37', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(120) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `cidade` varchar(120) NOT NULL,
  `cargo` int NOT NULL DEFAULT '0',
  `ativo` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 's',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UN` (`login`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `senha`, `nome`, `cidade`, `cargo`, `ativo`) VALUES
(1, 'admin', 'admin', '', '0', 0, 's'),
(20, 'carlos', '123', 'Carlos', 'Salvador', 0, 's'),
(21, 'cliente', '123', 'cliente', 'Salvador', 0, 's'),
(22, 'cliente2', '123', 'Clliente_02', 'Pres. Tanc. Neves', 0, 's'),
(23, 'ulisses', '123', 'Ulisses', 'Salvador', 0, 's'),
(24, 'mon', '123', 'Ramon', 'Pres. Tanc. Neves', 0, 's');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
