CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `phone` VARCHAR(20) NULL,
  `cpf` VARCHAR(14) NULL,
  `password` varchar(255) NOT NULL,
  `address` VARCHAR(255) NULL,
  `number` VARCHAR(10) NULL,
  `complement` VARCHAR(255) NULL,
  `neighborhood` VARCHAR(255) NULL,
  `city` VARCHAR(255) NULL,
  `state` VARCHAR(2) NULL,
  `zip_code` VARCHAR(10) NULL,
  `role` varchar(255) DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin User', 'admin@estore.com', '$2y$10$G70ViKY/cgbVRUXCKaqCpu3OjHRZ2et.oN/V/J6bmqA.', 'admin', '2025-10-03 00:52:17'),
(2, 'User E-Store', 'user@estore.com', '$2y$10$vrkCTnkdjQUzCmzx137g5.nmQPXB4tFcqEyeWAzKEy9LPGFCVOMXy', 'user', '2025-10-03 00:59:28'),
(3, 'Felipe', 'felipefigueiredobatista08@gmail.com', '$2y$10$GLOvXa27/KndAeIiSrRADu2yXmQAEzEZV0mx3KuM8xa3TMDHcFg82', 'user', '2025-10-06 14:06:07'),
(4, 'gabriel', 'gabi@gmail.com', '$2y$10$M72rbRkr84Ncjbti/wwN.e5TuH8V792q/tQuSepfiPefcKAKR.gae', 'user', '2025-10-06 17:23:41');
