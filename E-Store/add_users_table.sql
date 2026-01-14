CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin User', 'admin@estore.com', '$2y$10$G70ViKY/cgbVRUXCKaqCpu3WJw5cp4C3OjHRZ2et.oN/V/J6bmqA.', 'admin', '2025-10-03 00:52:17'),
(2, 'User E-Store', 'user@estore.com', '$2y$10$vrkCTnkdjQUzCmzx137g5.nmQPXB4tFcqEyeWAzKEy9LPGFCVOMXy', 'user', '2025-10-03 00:59:28'),
(3, 'Felipe', 'felipefigueiredobatista08@gmail.com', '$2y$10$GLOvXa27/KndAeIiSrRADu2yXmQAEzEZV0mx3KuM8xa3TMDHcFg82', 'user', '2025-10-06 14:06:07'),
(4, 'gabriel', 'gabi@gmail.com', '$2y$10$M72rbRkr84Ncjbti/wwN.e5TuH8V792q/tQuSepfiPefcKAKR.gae', 'user', '2025-10-06 17:23:41');

