-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 23 mei 2025 om 12:45
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `account`
--

INSERT INTO `account` (`id`, `email`, `password`, `role`, `profile_image`, `phone`, `address`) VALUES
(9, 'kelvin@kelvin.nl', '$2y$12$w2fuXiPg1m2jC.C9BCCB5ebeEPNUcwxVp2StqdFJa9y62xwwmfKWK', NULL, NULL, NULL, NULL),
(10, 'cassandra@cassandra.nl', '$2y$12$pVGqaOKe9t0QZZozeub4ueghtgx09JEKWb/ohSPhh6VCucC8Zpplm', NULL, NULL, NULL, NULL),
(12, 'wilma_flintstone@gmail.com', '$2y$10$E8qO4uXsftUcf8AJkQQZCu1F/YRMmYxl.74sIY1Ny95OAbHLqzl/i', NULL, '/assets/images/profile_12_68302f96bb553.png', '0628113240', 'Middelharnisstraat 179'),
(13, 'cerfeeoi@icloudcom', '$2y$14$OgPXimqnRx0HrkKz3NI1yOr2msyr3iFuM9utyVvRM8b8nrU4iNIUi', NULL, NULL, NULL, NULL),
(14, 'bob@icloud.com', '$2y$10$ANz7X9e6BQU3VwT/C0wTT.vocWN4tXZSzpIXsd5Fu9LGfTpmmGOG.', NULL, NULL, NULL, NULL),
(15, 'makriniel@icloud.com', '$2y$10$NjIZxeSjMRvnG/t7F1vN2O6SipfCMQLueMJl9NN5/bE6CpJyzt7nS', NULL, '/assets/images/profile_15_6830503547ce0.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `STATUS` varchar(20) DEFAULT 'pending',
  `payment_method` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `capacity` varchar(50) NOT NULL,
  `steering` varchar(50) NOT NULL,
  `gasoline` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `reviews_count` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `main_image` varchar(255) NOT NULL,
  `is_favorite` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `cars`
--

INSERT INTO `cars` (`id`, `brand`, `type`, `capacity`, `steering`, `gasoline`, `price`, `old_price`, `rating`, `reviews_count`, `description`, `main_image`, `is_favorite`, `created_at`) VALUES
(1, 'Koenigsegg', 'Sport', '2 People', 'Automatic ', '80L', 150.00, 200.00, 0, '2+ Reviewer', 'One of the fastest street-legal cars in the world. The Koenigsegg Agera RS combines extreme performance with stunning design. With 1160 horsepower and a lightning-fast 7-speed automatic transmission, every drive feels like a race. The large 80-liter fuel tank gives you the range for longer trips. Pure speed, luxury, and exclusivity.\r\n\r\n', 'car1.svg', 1, '2025-05-20 08:29:20'),
(2, 'Nissan GT - R', 'Sport', '2 People', 'Automatic ', '75L', 130.00, 150.00, 0, '4+ Reviewer', 'Known as “Godzilla,” the Nissan GT-R delivers raw power with advanced control. Its 570 horsepower and 6-speed dual-clutch automatic transmission make it a true performance icon. With a 74-liter fuel tank, it’s ready for both thrilling drives and longer journeys. The perfect mix of speed, comfort, and style.\r\n\r\n', 'car2.svg', 1, '2025-05-20 08:29:20'),
(3, 'Rolls - Royce', 'Sedan', '4 People', 'Automatic ', '82L', 350.00, 700.00, 0, '3+ Reviewer', 'Experience luxury with the wind in your hair. The Rolls-Royce Dawn is a stunning convertible that combines elegant design with powerful performance. Its smooth V12 engine delivers 563 hp, paired with an 8-speed automatic transmission for effortless driving. Perfect for stylish arrivals and unforgettable rides on sunny days.\r\n\r\n', 'Car (2).webp', 1, '2025-05-20 08:29:20'),
(4, 'Nissan GT - R Pure', 'Sport', '2 People', 'Automatic ', '74L', 240.00, 300.00, 0, '0', 'The Nissan GT-R Pure combines powerful performance with modern comfort. With around 565 horsepower and a quick 6-speed automatic transmission, this sports car impresses both on the road and the track. The 74-liter fuel tank ensures plenty of driving fun without frequent refueling. Perfect for speed and style enthusiasts.\r\n\r\n', 'Car (3).webp', 0, '2025-05-20 08:29:20'),
(5, 'All New Rush', 'SUV', '6 People', 'Automatic ', '45L', 120.00, 180.00, 0, '0', 'The Toyota Rush is a compact SUV with a rugged design and practical interior. Ideal for everyday driving and small adventures. Equipped with an automatic transmission and an efficient 104 hp engine, it offers comfort and ease of handling. The 45-liter fuel tank provides enough range for city driving and weekend trips.\r\n\r\n.', 'Car (4).webp', 0, '2025-05-20 08:29:20'),
(6, 'CR - V', 'SUV', '5 People', 'Automatic ', '57', 120.00, 150.00, 0, '0', 'The Honda CR-V is a reliable and spacious compact SUV, perfect for families and everyday driving. It offers smooth automatic transmission and efficient fuel consumption. With ample cargo space and a comfortable interior, it’s great for city trips and longer journeys alike.', 'Car (5).webp', 1, '2025-05-20 08:29:20'),
(7, 'All New Terios', 'SUV', '7 People', 'Manual', '45L', 80.00, 100.00, 0, '0', 'The Toyota All New Rush is a rugged and versatile 7-seater SUV, perfect for families and group trips. It combines practical space with reliable performance and easy handling. With an automatic transmission and a 45-liter fuel tank, it’s ideal for both city driving and longer journeys with ample passenger room.\r\n\r\n', 'Car (6).webp', 1, '2025-05-20 08:29:20'),
(8, 'CR - V', 'SUV', '5 People', 'Manual', '57L', 120.00, 150.00, 0, '0', 'The Honda CR-V is a spacious and reliable compact SUV, designed for both daily commutes and family road trips. With a powerful 190 hp engine, automatic transmission, and a 57-liter fuel tank, it offers smooth performance and fuel efficiency. Its roomy interior and modern features make it a favorite for comfort and practicality.', 'Car (7).webp', 1, '2025-05-20 08:29:20'),
(9, 'MG ZX Exclusive', 'Hatchback', '5 People', 'Automatic ', '45L', 240.00, 280.00, 0, '0', 'The MG ZS Exclusive is a premium version of the practical compact SUV. It offers leather-style seats, a touchscreen infotainment system, a rear camera, and smart connectivity. With a 45-liter fuel tank and 106 hp engine, this 5-seater is perfect for comfortable urban drives with a touch of luxury.', 'Car (8).webp', 0, '2025-05-20 08:29:20'),
(10, 'New MG ZS Sport', 'SUV', '6 People', 'Manual', '80L', 300.00, 600.00, 0, '0', 'The MG ZS Excite Sport brings sporty style and confident performance to your everyday drive. With its bold grille, dynamic body lines, and sporty alloy wheels, this compact SUV looks fast even when standing still. The 1.5L petrol engine delivers responsive power with 106 hp, paired with a smooth automatic transmission for effortless driving. ', 'Car (9).webp', 1, '2025-05-20 08:29:20'),
(11, 'MG ZX Excite', 'Hatchback', '5 People', 'Automatic ', '45L', 120.00, 180.00, 0, '0', 'The MG ZS Excite is a stylish and practical compact SUV. It features a comfortable interior, user-friendly tech, and a smooth ride, making it ideal for city drives and weekend getaways. With 106 horsepower and a 45-liter fuel tank, this 5-seater SUV offers great value, efficiency, and everyday comfort.', 'Car (10).webp', 1, '2025-05-20 08:29:20'),
(12, 'New MG ZS', 'SUV', '5 People', 'Manual', '45L', 120.00, 160.00, 0, '0', 'The New MG ZS is a stylish and practical compact SUV, perfect for city driving and weekend getaways. Equipped with a 1.5L petrol engine delivering 106 horsepower and a smooth automatic transmission, it offers a comfortable and efficient ride.', 'Car (11).webp', 0, '2025-05-20 08:29:20');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `car_likes`
--

CREATE TABLE `car_likes` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `like_status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `car_likes`
--

INSERT INTO `car_likes` (`id`, `car_id`, `user_id`, `created_at`, `like_status`) VALUES
(37, 5, 12, '2025-05-21 07:30:35', 0),
(38, 6, 12, '2025-05-21 07:30:48', 1),
(54, 4, 12, '2025-05-21 07:49:43', 0),
(55, 7, 12, '2025-05-21 07:49:54', 1),
(56, 8, 12, '2025-05-21 07:49:55', 1),
(59, 3, 12, '2025-05-21 07:58:24', 1),
(61, 1, 12, '2025-05-21 08:12:41', 1),
(64, 2, 12, '2025-05-22 10:29:20', 1),
(65, 10, 12, '2025-05-22 10:30:47', 1),
(66, 11, 12, '2025-05-22 10:38:56', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `like_status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rentals`
--

CREATE TABLE `rentals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `rental_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `STATUS` enum('active','completed','cancelled') DEFAULT 'active',
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `rentals`
--

INSERT INTO `rentals` (`id`, `user_id`, `car_id`, `start_date`, `end_date`, `rental_date`, `STATUS`, `total_price`) VALUES
(1, 12, 2, '2025-05-21', '2025-05-22', '2025-05-21 16:18:43', 'active', 260.00),
(2, 12, 2, '2025-05-21', '2025-05-22', '2025-05-21 16:22:31', 'active', 260.00),
(3, 12, 3, '2025-05-22', '2025-05-23', '2025-05-22 10:31:21', 'active', 700.00),
(4, 12, 2, '2025-05-22', '2025-05-23', '2025-05-22 10:35:26', 'active', 260.00),
(5, 12, 1, '2025-05-22', '2025-05-23', '2025-05-22 10:44:08', 'active', 300.00),
(6, 12, 2, '2025-05-22', '2025-05-23', '2025-05-22 10:49:29', 'active', 260.00),
(7, 12, 3, '2025-05-23', '2025-05-24', '2025-05-23 07:59:15', 'active', 700.00),
(8, 12, 3, '2025-05-29', '2025-05-31', '2025-05-23 08:10:46', 'active', 1050.00),
(9, 12, 3, '2025-05-23', '2025-05-24', '2025-05-23 08:17:26', 'active', 700.00),
(10, 15, 2, '2025-05-23', '2025-05-24', '2025-05-23 10:39:35', 'active', 260.00);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `date` varchar(50) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `reviews`
--

INSERT INTO `reviews` (`id`, `car_id`, `name`, `position`, `date`, `rating`, `comment`) VALUES
(1, 1, 'Ayoub Makrini', 'l', '20 May 2025', 3, ','),
(2, 1, 'ji', 'ji', '20 May 2025', 5, 'hi'),
(3, 2, 'test', 'test', '21 May 2025', 1, 'dit is een test'),
(4, 2, 'c', 's', '21 May 2025', 1, 'csc'),
(5, 2, 'v', 'v', '21 May 2025', 2, 'v'),
(6, 2, 'bv', 'v', '21 May 2025', 1, 'v'),
(7, 3, 'w', 'v', '21 May 2025', 1, '2'),
(8, 3, 'v', 'v', '21 May 2025', 3, 'v'),
(9, 3, 'v', 'v', '21 May 2025', 2, 'v');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexen voor tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `car_likes`
--
ALTER TABLE `car_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`car_id`,`user_id`);

--
-- Indexen voor tabel `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`car_id`);

--
-- Indexen voor tabel `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexen voor tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `car_likes`
--
ALTER TABLE `car_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT voor een tabel `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `car_likes`
--
ALTER TABLE `car_likes`
  ADD CONSTRAINT `car_likes_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `account` (`id`),
  ADD CONSTRAINT `rentals_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);

--
-- Beperkingen voor tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

UPDATE `cars` SET
    `main_image` = CASE 
        WHEN `main_image` = 'Car (2).webp' THEN 'car3.svg'
        WHEN `main_image` = 'Car (3).webp' THEN 'car4.svg'
        WHEN `main_image` = 'Car (4).webp' THEN 'car5.svg'
        WHEN `main_image` = 'Car (5).webp' THEN 'car6.svg'
        WHEN `main_image` = 'Car (6).webp' THEN 'car7.svg'
        WHEN `main_image` = 'Car (7).webp' THEN 'car8.svg'
        WHEN `main_image` = 'Car (8).webp' THEN 'car9.svg'
        WHEN `main_image` = 'Car (9).webp' THEN 'car10.svg'
        WHEN `main_image` = 'Car (10).webp' THEN 'car11.svg'
        WHEN `main_image` = 'Car (11).webp' THEN 'car12.svg'
        ELSE main_image
    END;
