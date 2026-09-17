-- ==========================================================
-- Database Schema for Rasindu Nawod Portfolio Website
-- File: database.sql
-- Compatibility: MySQL 5.7+ / MySQL 8.0+ / MariaDB
-- ==========================================================

CREATE DATABASE IF NOT EXISTS `rasindu_portfolio` 
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `rasindu_portfolio`;

-- --------------------------------------------------------
-- Table: contact_messages
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(30) DEFAULT NULL,
  `subject` VARCHAR(200) NOT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('Unread', 'Read', 'Replied') DEFAULT 'Unread',
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_status` (`status`),
  INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: projects
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `projects` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `category` ENUM('Web Development', 'Graphic Design', 'UI/UX') NOT NULL,
  `description` TEXT NOT NULL,
  `technologies` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `github_url` VARCHAR(255) DEFAULT NULL,
  `live_url` VARCHAR(255) DEFAULT NULL,
  `is_featured` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: design_gallery
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `design_gallery` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `tools` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: admin_users
-- Default credentials: admin / rasindu@2026
-- (Password is hashed with PASSWORD_BCRYPT)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Admin User (Password: rasindu@2026)
INSERT INTO `admin_users` (`username`, `email`, `password_hash`)
VALUES ('admin', 'razindunawod@gmail.com', '$2y$10$wO082wZ81n.GgKqUu2768ODuFvQ3T2rA9O7xV.5R77vN8J3C9cKzW')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Seed Sample Inquiries
INSERT INTO `contact_messages` (`name`, `email`, `phone`, `subject`, `message`, `status`)
VALUES 
('Kaveen Jayawardena', 'kaveen@example.com', '+94 77 123 4567', 'Inquiry: Modern Portfolio Website', 'Hello Rasindu, I need a responsive portfolio for my architecture practice. Looking forward to discussing.', 'Unread'),
('Dilshan Fernando', 'dilshan@creativepulse.lk', '+94 71 987 6543', 'Brand Identity & Logo Design Project', 'Hi Rasindu, we loved your vector typography work. Would love to collaborate on our startup logo.', 'Replied');

-- Seed Sample Projects
INSERT INTO `projects` (`title`, `category`, `description`, `technologies`, `image`, `github_url`)
VALUES 
('ICBT Campus Academic Portal & Website', 'Web Development', 'A complete academic and student management platform featuring secure authentication, timetable query, and responsive navigation.', 'HTML5, CSS3, JavaScript, PHP 8, MySQL', 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop', 'https://github.com/rasindunawod'),
('Rasindu Nawod Personal Portfolio Website', 'Web Development', 'High-performance personal brand web experience with dark/light themes, typography scales, and interactive contact console.', 'HTML5, Tailwind CSS, JavaScript, PHP, MySQL', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop', 'https://github.com/rasindunawod'),
('Creative Brand Identity & Vector Design System', 'Graphic Design', 'Comprehensive branding suite featuring typography standards, modern vector marks, and promotional collateral.', 'Adobe Illustrator, Adobe Photoshop', 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop', NULL);
