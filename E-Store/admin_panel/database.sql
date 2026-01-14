-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/10/2025 às 20:19
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
-- Banco de dados: `database`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_email`, `customer_phone`, `total_amount`, `status`, `created_at`, `updated_at`, `order_number`) VALUES
(8, 'felipe batista', 'felipefigueiredobatista08@gmail.com', '11988265655', 630.00, 'pending', '2025-10-07 09:47:25', '2025-10-07 09:47:25', '45750938');

-- --------------------------------------------------------

--
-- Estrutura para tabela `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `product_name`, `product_image`) VALUES
(8, 8, 2, 1, 630.00, 'Monitor Samsung 24 FHD', 'images/monitor2.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category`, `stock`, `created_at`, `updated_at`) VALUES
(0, 'Purificador de Água', 'Purificador de Água Natural e Gelada Electrolux PA31G', 349.99, 'http://localhost/E-store/images/filtro.png', 'Eletrodomésticos', 20, '2025-09-30 14:01:16', '2025-10-06 20:20:21'),
(1, 'Computador Dell Optiplex 3000', 'Intel I3 12100, RAM 16gb, SSD 256gb + HD 1TB, Video Radeon 550, Kit Tecldo e Mouse.', 1499.00, 'http://localhost/e-store/images/computador1.png', 'Computadores', 11, '2025-09-24 22:02:43', '2025-10-01 18:08:17'),
(2, 'Monitor Samsung 24 FHD', 'Monitor Samsung 24” FHD, 75Hz, HDMI, VGA, Freesync, Ajuste de Inclinação, Preto, Série T350.', 730.00, 'http://localhost/e-store/images/monitor2.png', 'Computadores', 22, '2025-09-24 22:02:43', '2025-10-01 18:09:22'),
(3, 'Computador Home Completo HD701', 'Computador Home Completo Pichau HD701, Intel Core i5, 8GB DDR3, SSD 120GB + Monitor.', 1799.00, 'http://localhost/e-store/images/computador3.png', 'Computadores', 39, '2025-09-24 22:02:43', '2025-10-01 18:08:27'),
(4, 'Monitor ACER E200Q', 'Monitor ACER E200Q, 19.5 POL, TN, HD, 6MS, 75HZ, HDMI/VGA', 599.00, 'http://localhost/e-store/images/monitor1.png', 'Computadores', 16, '2025-09-24 22:02:43', '2025-10-01 18:08:58'),
(5, 'Notebook Dell Inspirion 15 3000', 'i15-3501-A40P Intel Core i5 1135G7 15,6\" 4GB SSD 256 GB Windows 10.', 2399.00, 'http://localhost/e-store/images/notebook1.png', 'Computadores', 11, '2025-09-24 22:02:43', '2025-10-01 18:06:31'),
(6, 'Monitor Bluecase', 'Monitor Bluecase 20\" LED, HDMI e VGA, preto - BM20K4HVW.', 350.00, 'http://localhost/e-store/images/monitor3.png', 'Computadores', 42, '2025-09-24 22:02:43', '2025-10-01 18:09:07'),
(7, 'Micro-ondas 30 Litros LG', 'O micro-ondas LG possui uma tecnologia projetada para garantir o cozimento e descongelamento dos alimentos.', 700.00, 'http://localhost/E-store/images/microondas.png', 'Eletrodomésticos', 25, '2025-09-24 22:02:43', '2025-10-03 12:45:57'),
(8, 'Ventilador de Parede', 'Ventilador de Parede 50cm VENTI50P Preto com Grade em Pintura Epóxi Preta.', 620.00, 'http://localhost/e-store/images/ventilador1.png', 'Eletrodomésticos', 38, '2025-09-24 22:02:43', '2025-10-01 18:06:41'),
(9, 'Fogão Mueller MFI4BA', 'Fogão Mueller MFI4BA Acendimento Manual 4 Bocas Mesa Inox Forno 48,1L.', 620.00, 'http://localhost/E-store/images/fogao1.png', 'Eletrodomésticos', 5, '2025-09-24 22:02:43', '2025-10-03 12:45:19'),
(10, 'Geladeira Industrial 4 Portas', 'Geladeira Industrial 4 Portas 765L Galva Kofisa, isolamento térmico 100% injetado em poliuretano de alta densidade.', 3250.00, 'http://localhost/E-store/images/geladeira.png', 'Eletrodomésticos', 32, '2025-09-24 22:02:43', '2025-10-03 12:45:29'),
(12, 'Smart TV LED 32 Philco', 'Smart TV LED 32\" Philco PTV32G52S HD e Áudio Dolby Conversor Digital Integrado 2 HDMI 1 USB Wi-Fi com Netflix.', 949.99, 'http://localhost/E-store/images/tv.png', 'Eletrodomésticos', 26, '2025-09-24 22:02:43', '2025-10-03 12:46:29'),
(13, 'Cadeira Ergonômica de Escritório', 'Cadeira de escritório com o tamanho ajustável.', 399.00, 'http://localhost/e-store/images/cadeira.png', 'Móveis', 18, '2025-09-24 22:02:43', '2025-10-01 18:07:50'),
(14, 'Mesa Escrivaninha Para Escritório Reforçada', 'Fabricado em MDP 15mm, tampos com cantos arredondados.', 500.00, 'http://localhost/E-store/images/mesa.png', 'Móveis', 40, '2025-09-24 22:02:43', '2025-10-03 12:44:59'),
(15, 'Armário de Aço com 02 Portas de Abrir e Fechadura', 'Armário de Aço com 02 (duas) portas de abrir e tres prateleiras mais a base.', 550.00, 'http://localhost/e-store/images/armario1.png', 'Móveis', 21, '2025-09-24 22:02:43', '2025-10-01 18:06:50'),
(16, 'Mesa Escrivaninha para Escritório', 'A Mesa Para Escritório Com Borda ABS Com 3 Gavetas 150 X 58 Cm, Com Um Design Reto E Discreto', 499.00, 'http://localhost/E-store/images/escrivaninha.png', 'Móveis', 49, '2025-09-24 22:02:43', '2025-10-03 12:45:41'),
(17, 'Estante de Aço Mini', 'Estante de aço mini com 3 prateleiras 45x27cm 45kg coluna bipartida para escritório branca.', 130.00, 'http://localhost/E-store/images/armario2.png', 'Móveis', 14, '2025-09-24 22:02:43', '2025-10-03 12:45:09'),
(18, 'Cadeira de Escritório', 'Cadeira de Escritório Giratória com Regulagem de Altura em Tecido Preto e Confortável', 320.00, 'http://localhost/e-store/images/cadeira3.png', 'Móveis', 46, '2025-09-24 22:02:43', '2025-10-01 18:08:01'),
(19, 'Kit de Teclado e Mouse para Escritório C3Tech', 'Kit de Teclado e Mouse para Escritório C3Tech, com Conexão USB, ABNT2, Preto, KT200BK - C3Tch.', 220.00, 'http://localhost/e-store/images/kit1.png', 'Periféricos', 43, '2025-09-24 22:02:43', '2025-10-01 18:08:49'),
(20, 'Mouse Hp 100 1600dpi Usb Preto', 'Um sensor óptico preciso, com 1.600 DPI, permite o uso na maioria das superfícies. Com conexão USB rápida.', 65.00, 'http://localhost/e-store/images/mouse1.png', 'Periféricos', 45, '2025-09-24 22:02:43', '2025-10-01 18:09:44'),
(21, 'Teclado sem fio Logitech K270', 'Teclado sem fio Logitech K270, Teclas de Mídia de Fácil Acesso, Conexão USB, Pilhas Inclusas e Layout ABNT2', 170.00, 'http://localhost/E-store/images/teclado1.jpg', 'Periféricos', 49, '2025-09-24 22:02:43', '2025-10-03 12:46:38'),
(22, 'Mouse com fio USB Logitech M90', 'Mouse com fio USB Logitech M90 com Design Ambidestro e Facilidade Plug and Play', 50.00, 'http://localhost/E-store/images/mouse2.jpg', 'Periféricos', 19, '2025-09-24 22:02:43', '2025-10-03 12:46:10'),
(23, 'Kit Teclado e Mouse com fio USB Logitech MK120', 'Kit Teclado e Mouse com fio USB Logitech MK120 com Design Confortável, Durável e Resistente à Respingos', 149.00, 'http://localhost/e-store/images/kit2.png', 'Periféricos', 9, '2025-09-24 22:02:43', '2025-10-01 18:08:38'),
(24, 'Mouse Gamer Corsair Katar PRO', 'Mouse Gamer Corsair Katar PRO Ultra-Leve, RGB, 6 Botões, 12400DPI, Preto, Sensor óptico PixArt com 12400 DPI', 79.98, 'http://localhost/e-store/images/mouse3.png', 'Periféricos', 42, '2025-09-24 22:02:43', '2025-10-01 18:09:36');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `number` varchar(10) DEFAULT NULL,
  `complement` varchar(255) DEFAULT NULL,
  `neighborhood` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `cpf`, `password`, `address`, `number`, `complement`, `neighborhood`, `city`, `state`, `zip_code`, `profile_photo`, `role`, `created_at`) VALUES
(1, 'Admin User', 'admin@estore.com', NULL, NULL, '$2y$10$G70ViKY/cgbVRUXCKaqCpu3WJw5cp4C3OjHRZ2et.oN/V/J6bmqA.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2025-10-03 00:52:17'),
(9, 'User E-Store', 'user@estore.com', '(11) 988265655', '547.511.908-22', '$2y$10$J03IZZHEkpiQsuOCBLmPFuk1TiX0Cc1DRR.Wb0YKqLl4I5So.eXly', 'R. Força Pública', '89', '', 'Centro', 'Guarulhos', 'SP', '07012-030', 'uploads/profile_photos/user_9_1759858862.jpg', 'user', '2025-10-07 00:48:57'),
(10, 'felipe batista', 'felipefigueiredobatista08@gmail.com', '11988265655', '54751190822', '$2y$10$XZqKmkZlwQFETavkVdeBCeQxuaanheJFu3e22wAG3ySK30DyC3Q2y', 'Rua São Jomé', '136', '', 'Jardim São João', 'Guarulhos', 'SP', '07151150', 'uploads/profile_photos/user_10_1759858951.jpg', 'user', '2025-10-07 09:42:58');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
