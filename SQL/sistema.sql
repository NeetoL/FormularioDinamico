-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/11/2024 às 15:08
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `inserir_formulario` (IN `nome_formulario` VARCHAR(255), IN `descricao_formulario` TEXT, IN `id_usuario` INT, IN `validade_formulario` DATE, IN `campos_json` JSON)   BEGIN
    DECLARE formulario_id INT;
    DECLARE i INT DEFAULT 0;
    DECLARE campo_nome VARCHAR(255);
    DECLARE campo_tipo VARCHAR(50);
    DECLARE campo_obrigatorio BOOLEAN;
    DECLARE campo_ordem INT;

    -- Inserir o formulário na tabela `formularios`
    INSERT INTO `formularios` (`nome`, `descricao`, `id_usuario`, `validade`)
    VALUES (nome_formulario, descricao_formulario, id_usuario, validade_formulario);

    -- Obter o ID do último formulário inserido
    SET formulario_id = LAST_INSERT_ID();

    -- Inserir os campos do formulário
    -- Campos são passados como JSON, por exemplo:
    -- '[{"nome": "Nome", "tipo": "text", "obrigatorio": true, "ordem": 1}, 
    --   {"nome": "Email", "tipo": "email", "obrigatorio": true, "ordem": 2}]'

    -- Loop através dos campos passados no JSON
    WHILE i < JSON_LENGTH(campos_json) DO
        SET campo_nome = JSON_UNQUOTE(JSON_EXTRACT(campos_json, CONCAT('$[', i, '].nome')));
        SET campo_tipo = JSON_UNQUOTE(JSON_EXTRACT(campos_json, CONCAT('$[', i, '].tipo')));
        SET campo_obrigatorio = JSON_UNQUOTE(JSON_EXTRACT(campos_json, CONCAT('$[', i, '].obrigatorio')));
        SET campo_ordem = JSON_UNQUOTE(JSON_EXTRACT(campos_json, CONCAT('$[', i, '].ordem')));

        -- Inserir cada campo na tabela `campos_formulario`
        INSERT INTO `campos_formulario` (`id_formulario`, `nome_campo`, `tipo_campo`, `obrigatorio`, `ordem`)
        VALUES (formulario_id, campo_nome, campo_tipo, campo_obrigatorio, campo_ordem);

        SET i = i + 1;
    END WHILE;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `campos_formulario`
--

CREATE TABLE `campos_formulario` (
  `id` int(11) NOT NULL,
  `id_formulario` int(11) NOT NULL,
  `nome_campo` varchar(255) NOT NULL,
  `tipo_campo` varchar(50) NOT NULL,
  `obrigatorio` tinyint(1) NOT NULL DEFAULT 0,
  `ordem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `campos_formulario`
--

INSERT INTO `campos_formulario` (`id`, `id_formulario`, `nome_campo`, `tipo_campo`, `obrigatorio`, `ordem`) VALUES
(1, 1, 'Nome', 'text', 0, 1),
(2, 1, 'Data de Nascimento', 'date', 0, 2),
(3, 1, 'Email', 'email', 0, 3),
(4, 1, 'Telefone', 'tel', 0, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `formularios`
--

CREATE TABLE `formularios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `validade` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `formularios`
--

INSERT INTO `formularios` (`id`, `nome`, `descricao`, `data_criacao`, `id_usuario`, `validade`) VALUES
(1, 'Formulário de Cadastro', 'Formulário para cadastro de novos usuários', '2024-11-15 18:54:20', 1, '2024-12-31');

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas_formulario`
--

CREATE TABLE `respostas_formulario` (
  `id` int(11) NOT NULL,
  `respostas_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`respostas_json`)),
  `id_formulario` int(11) NOT NULL,
  `data_resposta` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_ativo` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `respostas_formulario`
--

INSERT INTO `respostas_formulario` (`id`, `respostas_json`, `id_formulario`, `data_resposta`, `status_ativo`) VALUES
(27, '[{\"campo\":\"Nome\",\"value\":\"Luiz Rodrigues Castro Neto\"},{\"campo\":\"Data de Nascimento\",\"value\":\"19\\/08\\/1993\"},{\"campo\":\"Email\",\"value\":\"luis_iraja@hotmail.com\"},{\"campo\":\"Telefone\",\"value\":\"21991543513\"},{\"campo\":\"id\",\"value\":\"1\"}]', 1, '2024-11-17 02:02:07', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `nivel` enum('admin','editor','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data_criacao`, `nivel`) VALUES
(1, 'Administrador', 'admin@example.com', '$2y$10$q9my6yMYfb0jhUDNOnhoE.wLXr.LSrhJRntpCKdBynKJzYO2bxYSC', '2024-11-15 13:50:18', 'admin'),
(2, 'admin@example.com', 'netolindoo@icloud.com', '$2y$10$9E0EwKG4ZqEOMQTJxvdSruPXjN7hzGxenogovrdtSdY9aNTShmmeu', '2024-11-15 16:50:07', 'editor'),
(3, 'Luiz Rodrigues Castro Neto', 'luizrodriguescastroneto@gmail.com', '$2y$10$c3Ai0hG2gP4OoIK3NFaMxeCZGlNDpad2CYpCfGa7/id780zWlB11m', '2024-11-15 16:56:09', 'editor'),
(5, 'admin@example.com', 'luizrodriguescastroneto@gmail.comm', '$2y$10$/mR4BpZrgHElnsrVGwh6F.1TIf8DRIibL8JLivS66McdkyYvwIDtC', '2024-11-15 16:57:44', 'editor'),
(6, 'Luiz Rodrigues Castro Neto', 'admin@frangonacaixa.com', '$2y$10$cFeEG1CHyjLppdAORTT.f.vuSerMFNc7nFu40zLkcjQtw0lGq2TqS', '2024-11-15 17:20:14', 'admin');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `campos_formulario`
--
ALTER TABLE `campos_formulario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_formulario` (`id_formulario`);

--
-- Índices de tabela `formularios`
--
ALTER TABLE `formularios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `respostas_formulario`
--
ALTER TABLE `respostas_formulario`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `campos_formulario`
--
ALTER TABLE `campos_formulario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `formularios`
--
ALTER TABLE `formularios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `respostas_formulario`
--
ALTER TABLE `respostas_formulario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `campos_formulario`
--
ALTER TABLE `campos_formulario`
  ADD CONSTRAINT `campos_formulario_ibfk_1` FOREIGN KEY (`id_formulario`) REFERENCES `formularios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `formularios`
--
ALTER TABLE `formularios`
  ADD CONSTRAINT `formularios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
