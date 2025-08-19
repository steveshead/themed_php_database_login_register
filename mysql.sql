-- Login Registration App Database
-- Clean installation script for GitHub distribution
--
-- Instructions:
-- 1. Create a new database in your MySQL server
-- 2. Run this script to create the required tables
-- 3. Update your config file with your database credentials

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
    `id` int(11) NOT NULL,
    `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
    `first_name` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Member',
    `approved` tinyint(1) NOT NULL DEFAULT '1',
    `activation_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `remember_me_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `reset_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `last_seen` datetime NOT NULL,
    `registered` datetime NOT NULL,
    `avatar` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `occupation` text COLLATE utf8mb4_unicode_ci,
    `motto` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `location` text COLLATE utf8mb4_unicode_ci,
    `facebook` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `instagram` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `twitter` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `tfa_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `tfa_enabled` tinyint(1) NOT NULL DEFAULT '0',
    `tfa_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `totp_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `totp_enabled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
    `id` int(11) NOT NULL,
    `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `attempts_left` tinyint(1) NOT NULL DEFAULT '5',
    `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `username` (`username`),
    ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `ip_address` (`ip_address`);

-- --------------------------------------------------------

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------
--
-- Optional: Create a default admin account
-- Uncomment the lines below if you want to create a default admin user
-- Default password is 'admin123' (change immediately after installation!)
--
-- INSERT INTO `accounts` (`username`, `password`, `email`, `role`, `approved`, `activation_code`, `last_seen`, `registered`)
-- VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@yoursite.com', 'Admin', 1, 'activated', NOW(), NOW());