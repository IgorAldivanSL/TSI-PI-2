-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 12/08/2025 às 18:31
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `rtrips`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios_adm`
--

CREATE TABLE `usuarios_adm` (
  `adm_id` int(11) NOT NULL,
  `adm_nome` varchar(255) NOT NULL,
  `adm_telefone` varchar(20) DEFAULT NULL,
  `adm_cpf` varchar(20) DEFAULT NULL,
  `adm_email` varchar(255) NOT NULL,
  `adm_senha` varchar(255) NOT NULL,
  `adm_ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `viagens`
--

CREATE TABLE `viagens` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_ida` date NOT NULL,
  `data_volta` date NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `usuarios_adm`
--
ALTER TABLE `usuarios_adm`
  ADD PRIMARY KEY (`adm_id`),
  ADD UNIQUE KEY `adm_email` (`adm_email`);

--
-- Índices de tabela `viagens`
--
ALTER TABLE `viagens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios_adm`
--
ALTER TABLE `usuarios_adm`
  MODIFY `adm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `viagens`
--
ALTER TABLE `viagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
