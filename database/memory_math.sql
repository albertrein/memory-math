-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Maio-2020 às 03:13
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `memory_math`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrador`
--

CREATE TABLE `administrador` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NOME` varchar(255) NOT NULL,
  `SENHA` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carta_calculo`
--

CREATE TABLE `carta_calculo` (
  `ID` int(10) UNSIGNED NOT NULL,
  `EXPRESSAO` varchar(255) NOT NULL,
  `RESPOSTA` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `carta_calculo`
--

INSERT INTO `carta_calculo` (`ID`, `EXPRESSAO`, `RESPOSTA`) VALUES
(2, '5 / 1', 1),
(3, '10 * 2', 2),
(4, '4 + 9', 3),
(5, '10 - 3', 4),
(6, '15 - 7', 5),
(7, '3 * 4', 6),
(8, '8 + 5', 3),
(9, '7 - 2', 1),
(10, '18 + 7', 7),
(11, '5 * 4', 2),
(12, '20 / 4', 1),
(13, '3 + 3', 8),
(14, '0 * 7', 9),
(15, '7 / 7', 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `carta_resposta`
--

CREATE TABLE `carta_resposta` (
  `ID` int(10) UNSIGNED NOT NULL,
  `RESULTADO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `carta_resposta`
--

INSERT INTO `carta_resposta` (`ID`, `RESULTADO`) VALUES
(9, 0),
(10, 1),
(1, 5),
(8, 6),
(4, 7),
(5, 8),
(6, 12),
(3, 13),
(2, 20),
(7, 25);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogador`
--

CREATE TABLE `jogador` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NOME` varchar(255) NOT NULL,
  `SENHA` varchar(255) NOT NULL,
  `PONTOS` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `jogador`
--

INSERT INTO `jogador` (`ID`, `NOME`, `SENHA`, `PONTOS`) VALUES
(1, 'Guilherme', '12345', 450),
(2, 'Renan', '12345', 350),
(3, 'Samuel', '12345', 400),
(4, 'Jonas', '12345', 500),
(5, 'Alberto', '12345', 550),
(6, 'Player1', '12345', 300),
(7, 'Einstein', '12345', 5000),
(8, 'Bhaskara', '12345', 2500),
(9, 'Pitagoras', '12345', 1500),
(10, 'Tales', '12345', 1400),
(11, 'Newton', '12345', 3500),
(12, 'Hawking', '12345', 3000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pergunta`
--

CREATE TABLE `pergunta` (
  `ID` int(10) UNSIGNED NOT NULL,
  `PERGUNTA` varchar(255) NOT NULL,
  `RESPOSTA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pergunta`
--

INSERT INTO `pergunta` (`ID`, `PERGUNTA`, `RESPOSTA`) VALUES
(1, '6 - 5', 1),
(2, '8 / 2', 4),
(3, '4 * 3', 12),
(4, '19 - 5', 14),
(5, '11 + 7', 18),
(6, '9 - 6', 3),
(7, '3 + 5', 8);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `NOME_ADM` (`NOME`);

--
-- Índices para tabela `carta_calculo`
--
ALTER TABLE `carta_calculo`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EXPRESSAO` (`EXPRESSAO`),
  ADD KEY `FKCARTA_RESPOSTA` (`RESPOSTA`);

--
-- Índices para tabela `carta_resposta`
--
ALTER TABLE `carta_resposta`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `RESULTADO` (`RESULTADO`);

--
-- Índices para tabela `jogador`
--
ALTER TABLE `jogador`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `NOME_JOG` (`NOME`);

--
-- Índices para tabela `pergunta`
--
ALTER TABLE `pergunta`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `PERGUNTA` (`PERGUNTA`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administrador`
--
ALTER TABLE `administrador`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `carta_calculo`
--
ALTER TABLE `carta_calculo`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `carta_resposta`
--
ALTER TABLE `carta_resposta`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `jogador`
--
ALTER TABLE `jogador`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `pergunta`
--
ALTER TABLE `pergunta`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `carta_calculo`
--
ALTER TABLE `carta_calculo`
  ADD CONSTRAINT `FKCARTA_RESPOSTA` FOREIGN KEY (`RESPOSTA`) REFERENCES `carta_resposta` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
