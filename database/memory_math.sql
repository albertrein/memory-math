-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 26-Maio-2020 às 23:25
-- Versão do servidor: 5.6.41-84.1
-- versão do PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dankhorc_albertodev`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cartas_new`
--

CREATE TABLE IF NOT EXISTS `cartas_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expressao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `resposta` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `cartas_new`
--

INSERT INTO `cartas_new` (`id`, `expressao`, `resposta`) VALUES
(1, '3*3', 9),
(5, '5+4', 9),
(4, '4+4', 8),
(8, '6+5', 11),
(7, '30-10', 20),
(12, '20+0', 20),
(13, '25-5', 20),
(14, '7+5', 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogador`
--

CREATE TABLE IF NOT EXISTS `jogador` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `NOME` varchar(255) NOT NULL,
  `SENHA` varchar(255) NOT NULL,
  `PONTOS` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `jogador`
--

INSERT INTO `jogador` (`ID`, `NOME`, `SENHA`, `PONTOS`) VALUES
(4, '23424', '234234', 0),
(5, 'Guilherme', '123', 50),
(7, 'ã‚µãƒ ã‚¨ãƒ«', 'teste12345', 50),
(8, 'teste', 'teste123', 30),
(9, '123456', '132456', 80),
(10, 'blauzent', 'abc123', 50);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pergunta`
--

CREATE TABLE IF NOT EXISTS `pergunta` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `PERGUNTA` varchar(255) NOT NULL,
  `RESPOSTA` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pergunta`
--

INSERT INTO `pergunta` (`ID`, `PERGUNTA`, `RESPOSTA`) VALUES
(1, 'Jonas boy tem 2 laranjas, Samuel ninja roubou 2 laranjas de Jonas boy, quantas larajas ele ficou?', 0),
(2, 'Teste2', 236),
(3, 'testando', 4),
(5, 'a resposta eh 5 .....', 5),
(6, '5 mais 0', 5),
(7, 'A resposta eh 6  Qual eh a resposta?', 6),
(8, '5+5', 11);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
