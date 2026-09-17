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
-- Table: social_links
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `social_links` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `platform` VARCHAR(50) NOT NULL,
  `url` TEXT NOT NULL,
  `icon` VARCHAR(50) NOT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
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
('Kaveen Jayawardena', 'kaveen@example.com', '+94 77 520 3445', 'Inquiry: Modern Portfolio Website', 'Hello Rasindu, I need a responsive portfolio for my architecture practice. Looking forward to discussing.', 'Unread'),
('Dilshan Fernando', 'dilshan@creativepulse.lk', '+94 71 987 6543', 'Brand Identity & Logo Design Project', 'Hi Rasindu, we loved your vector typography work. Would love to collaborate on our startup logo.', 'Replied');

-- Seed Sample Projects
INSERT INTO `projects` (`title`, `category`, `description`, `technologies`, `image`, `github_url`)
VALUES 
('ICBT Campus Academic Portal & Website', 'Web Development', 'A complete academic and student management platform featuring secure authentication, timetable query, and responsive navigation.', 'HTML5, CSS3, JavaScript, PHP 8, MySQL', 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop', 'https://github.com/roky2k05'),
('Rasindu Nawod Personal Portfolio Website', 'Web Development', 'High-performance personal brand web experience with dark/light themes, typography scales, and interactive contact console.', 'HTML5, Tailwind CSS, JavaScript, PHP, MySQL', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop', 'https://github.com/roky2k05'),
('Creative Brand Identity & Vector Design System', 'Graphic Design', 'Comprehensive branding suite featuring typography standards, modern vector marks, and promotional collateral.', 'Adobe Illustrator, Adobe Photoshop', 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop', NULL);

-- Seed Design Gallery Items
INSERT INTO `design_gallery` (`title`, `category`, `image`, `tools`)
VALUES 
('Geometric Apex Logo Mark', 'Branding', 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop', 'Adobe Illustrator'),
('Cybernetic Soundwave Poster', 'Posters', 'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?q=80&w=800&auto=format&fit=crop', 'Photoshop & Illustrator'),
('Minimalist Product Packaging Identity', 'Packaging', 'https://images.unsplash.com/photo-1634017839464-5c339ebe3cb4?q=80&w=800&auto=format&fit=crop', 'Adobe Illustrator');

-- Seed Social Media Links
INSERT INTO `social_links` (`platform`, `url`, `icon`, `is_active`)
VALUES 
('Facebook', 'https://www.facebook.com/share/1F6N9ALqmG/', 'facebook', 1),
('Instagram', 'https://www.instagram.com/lex_frost2k5?stkn=dmloMGtkc2RmZWIz', 'instagram', 1),
('TikTok', 'https://www.tiktok.com/@rokiya2k?_r=1&_d=eghhldf7b1bdcf&sec_uid=MS4wLjABAAAA9Fc8bjJeZgg20lwBvRADfJKQpJKMRB_UvsZKLhxLenI0rBAqYLucldlVJOKP4AfY&share_author_id=7237487704039982085&sharer_language=en&source=h5_m&u_code=e85lf7kg2c73c5&timestamp=1789668068&user_id=7237487704039982085&sec_user_id=MS4wLjABAAAA9Fc8bjJeZgg20lwBvRADfJKQpJKMRB_UvsZKLhxLenI0rBAqYLucldlVJOKP4AfY&item_author_type=1&utm_source=copy&utm_campaign=client_share&utm_medium=android&share_iid=7685691593941632788&share_link_id=55482e22-81d5-4931-8ef4-c1ba7cb431da&share_app_id=1233&ugbiz_name=ACCOUNT&ug_btm=b8727%2Cb7360&social_share_type=5&enable_checksum=1', 'tiktok', 1),
('GitHub', 'https://github.com/roky2k05', 'github', 1),
('LinkedIn', 'https://www.linkedin.com/in/rasindu-nawod-148901374', 'linkedin', 1),
('WhatsApp', 'https://wa.me/94743869265', 'whatsapp', 1);
