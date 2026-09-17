-- ========================================================
-- RASINDU NAWOD PORTFOLIO & CLIENT COMMUNICATION PORTAL
-- Production MySQL Database Schema & Initial Data Seeding
-- Designed for PHP 8+ and MySQL 8.0 / MariaDB 10.4+
-- ========================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `rasindu_portfolio` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `rasindu_portfolio`;

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(150) NOT NULL,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `phone` VARCHAR(25) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('user', 'admin') DEFAULT 'user',
  `profile_image` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('active', 'disabled') DEFAULT 'active',
  `last_login` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_users_role` (`role`),
  INDEX `idx_users_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: contact_messages
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NULL,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(191) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `subject` VARCHAR(200) NOT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('Unread', 'Read', 'In Progress', 'Replied', 'Closed') DEFAULT 'Unread',
  `admin_reply` TEXT NULL,
  `replied_at` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_contact_user` (`user_id`),
  INDEX `idx_contact_status` (`status`),
  CONSTRAINT `fk_contact_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: conversations
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `conversations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `subject` VARCHAR(200) NOT NULL,
  `status` ENUM('Unread', 'Read', 'In Progress', 'Replied', 'Closed') DEFAULT 'Unread',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_conv_user` (`user_id`),
  CONSTRAINT `fk_conv_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: messages (Two-way chat messages)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `messages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `conversation_id` INT UNSIGNED NOT NULL,
  `sender_id` INT UNSIGNED NOT NULL,
  `sender_role` ENUM('user', 'admin') NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_msg_conversation` (`conversation_id`),
  CONSTRAINT `fk_msg_conv` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_msg_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: notifications
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(150) NOT NULL,
  `message` TEXT NOT NULL,
  `type` VARCHAR(50) DEFAULT 'reply',
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_notif_user` (`user_id`),
  CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: projects
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `projects` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  `description` TEXT NOT NULL,
  `tech_stack` VARCHAR(255) NOT NULL,
  `image` TEXT NOT NULL,
  `github_link` VARCHAR(255) DEFAULT NULL,
  `live_link` VARCHAR(255) DEFAULT NULL,
  `is_featured` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: design_gallery
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `design_gallery` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  `image` TEXT NOT NULL,
  `tools` VARCHAR(150) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: services
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `services` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `description` TEXT NOT NULL,
  `icon` VARCHAR(50) NOT NULL,
  `features` TEXT NOT NULL,
  `base_price` VARCHAR(50) DEFAULT 'Negotiable',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: blog_posts
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `excerpt` TEXT NOT NULL,
  `content` LONGTEXT NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  `read_time` VARCHAR(20) DEFAULT '5 min read',
  `image` TEXT NOT NULL,
  `author` VARCHAR(100) DEFAULT 'Rasindu Nawod',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: testimonials
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `role` VARCHAR(100) NOT NULL,
  `organization` VARCHAR(150) NOT NULL,
  `content` TEXT NOT NULL,
  `avatar` TEXT DEFAULT NULL,
  `rating` TINYINT UNSIGNED DEFAULT 5,
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
-- Table: admin_logs
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `admin_id` INT UNSIGNED NULL,
  `action` VARCHAR(100) NOT NULL,
  `target_type` VARCHAR(50) DEFAULT NULL,
  `target_id` INT UNSIGNED DEFAULT NULL,
  `description` TEXT NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_admin_logs_admin` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- SEED INITIAL SYSTEM DATA
-- ========================================================

-- Primary Administrator Account
-- Username: rasindu
-- Initial Password: RokyN2k0_5 (Hashed with standard PASSWORD_BCRYPT)
INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `phone`, `password`, `role`, `status`, `created_at`)
VALUES 
(1, 'Rasindu Nawod', 'rasindu', 'razindunawod@gmail.com', '+94 74 386 9265', '$2y$12$ILsdzNSUV76qq0RLRIhdOOOq4cEPmYTyOmFSl2HyvqKXR01S33NF.', 'admin', 'active', NOW())
ON DUPLICATE KEY UPDATE `username` = VALUES(`username`);

-- Sample User for Testing
INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `phone`, `password`, `role`, `status`, `created_at`)
VALUES 
(2, 'Kaveen Jayawardena', 'kaveen_j', 'kaveen@example.com', '+94 77 520 3445', '$2y$12$ILsdzNSUV76qq0RLRIhdOOOq4cEPmYTyOmFSl2HyvqKXR01S33NF.', 'user', 'active', NOW())
ON DUPLICATE KEY UPDATE `username` = VALUES(`username`);

-- Sample Contact Messages
INSERT INTO `contact_messages` (`id`, `user_id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `admin_reply`, `replied_at`)
VALUES 
(1, 2, 'Kaveen Jayawardena', 'kaveen@example.com', '+94 77 520 3445', 'Inquiry: Modern Portfolio Website', 'Hello Rasindu, I need a responsive portfolio for my architecture practice. Looking forward to discussing specifications and timelines.', 'Replied', 'Hello Kaveen! Thank you for reaching out. I would be thrilled to work on your architecture portfolio. Please provide any brand assets and layout preferences.', NOW()),
(2, NULL, 'Dilshan Fernando', 'dilshan@creativepulse.lk', '+94 71 987 6543', 'Brand Identity & Logo Design Project', 'Hi Rasindu, we loved your vector typography work. Would love to collaborate on our startup logo design.', 'Unread', NULL, NULL)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`);

-- Sample Conversation
INSERT INTO `conversations` (`id`, `user_id`, `subject`, `status`, `created_at`)
VALUES 
(1, 2, 'Inquiry: Modern Portfolio Website', 'Replied', NOW())
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`);

-- Sample Conversation Messages
INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `sender_role`, `message`, `created_at`)
VALUES 
(1, 1, 2, 'user', 'Hello Rasindu, I need a responsive portfolio for my architecture practice. Looking forward to discussing specifications and timelines.', NOW()),
(2, 1, 1, 'admin', 'Hello Kaveen! Thank you for reaching out. I would be thrilled to work on your architecture portfolio. Please provide any brand assets and layout preferences.', NOW())
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`);

-- Sample Notification
INSERT INTO `notifications` (`user_id`, `title`, `message`, `type`, `is_read`, `created_at`)
VALUES 
(2, 'New Reply', 'You have received a reply to your inquiry: Modern Portfolio Website', 'reply', 0, NOW());

-- Seed Projects
INSERT INTO `projects` (`title`, `category`, `description`, `tech_stack`, `image`, `github_link`, `live_link`, `is_featured`)
VALUES 
('ICBT Campus Academic Portal & Website', 'Web Development', 'A complete academic and student management platform featuring secure authentication, timetable query, and responsive navigation.', 'HTML5, CSS3, JavaScript, PHP 8, MySQL', 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop', 'https://github.com/roky2k05', 'https://github.com/roky2k05', 1),
('Rasindu Nawod Personal Portfolio Website', 'Web Development', 'High-performance personal brand web experience with dark/light themes, typography scales, and interactive contact console.', 'HTML5, Tailwind CSS, JavaScript, PHP, MySQL', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop', 'https://github.com/roky2k05', 'https://github.com/roky2k05', 1),
('Creative Brand Identity & Vector Design System', 'Graphic Design', 'Comprehensive branding suite featuring typography standards, modern vector marks, and promotional collateral.', 'Adobe Illustrator, Adobe Photoshop', 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop', NULL, NULL, 1);

-- Seed Design Gallery Items
INSERT INTO `design_gallery` (`title`, `category`, `image`, `tools`)
VALUES 
('Geometric Apex Logo Mark', 'Branding', 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop', 'Adobe Illustrator'),
('Cybernetic Soundwave Poster', 'Posters', 'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?q=80&w=800&auto=format&fit=crop', 'Photoshop & Illustrator'),
('Minimalist Product Packaging Identity', 'Packaging', 'https://images.unsplash.com/photo-1634017839464-5c339ebe3cb4?q=80&w=800&auto=format&fit=crop', 'Adobe Illustrator');

-- Seed Services
INSERT INTO `services` (`title`, `description`, `icon`, `features`, `base_price`)
VALUES 
('Web Development', 'Custom responsive websites, PHP/MySQL architectures, interactive web portals, and clean UI engineering.', 'code', 'Responsive Layouts, PHP & MySQL Backend, Secure Authentication, SEO Optimization', 'LKR 45,000+'),
('Graphic Design & Branding', 'Distinctive visual identities, vector logos, typography systems, and print/digital social media kits.', 'palette', 'Vector Logo Design, Brand Style Guides, Social Media Collateral, Print-ready Assets', 'LKR 20,000+'),
('UI/UX Prototyping', 'User journeys, wireframes, and modern interactive mockups adapted from Figma design standards.', 'layout', 'Figma Prototypes, Design Tokens, Responsive Testing, User Experience Audits', 'LKR 25,000+');

-- Seed Blog Posts
INSERT INTO `blog_posts` (`title`, `slug`, `excerpt`, `content`, `category`, `read_time`, `image`)
VALUES 
('Building Secure PHP & MySQL Portals in 2026', 'building-secure-php-mysql-portals-2026', 'Practical guide to prepared statements, CSRF protection, and role-based access control in modern PHP development.', 'Security in web applications begins with robust input validation, PDO prepared statements, and session hardening. When engineering user portals, always ensure IDOR protection by scoping queries to authenticated session IDs...', 'Engineering', '6 min read', 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=800&auto=format&fit=crop'),
('Vector Craft: Precision Geometric Logo Design', 'vector-craft-precision-geometric-logo-design', 'How mathematical grids and visual balance create timeless marks in Adobe Illustrator.', 'Logo design requires rigorous attention to negative space, optical adjustments, and silhouette legibility across small digital screens and large billboards...', 'Design', '4 min read', 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop');

-- Seed Testimonials
INSERT INTO `testimonials` (`name`, `role`, `organization`, `content`, `avatar`, `rating`)
VALUES 
('Navod Nawarathna', 'Lecturer in Software Engineering', 'ICBT Campus', 'Rasindu demonstrates exceptional dedication to clean code, architectural discipline, and responsive web development. His problem-solving abilities are outstanding.', 'https://media.licdn.com/dms/image/v2/D5603AQEU28h1iRrn9A/profile-displayphoto-shrink_200_200/B56ZV72E5OHgAc-/0/1741581454530?e=1747872000&v=beta&t=0FkK978yZ4_qGj0W8Gq7t9W1X2Y3Z4A5B6C7D8E9F0G', 5),
('Paramee Lakshitha', 'Senior Graphic Designer', 'Creative Studio', 'A natural eye for composition, clean typography, and balanced vector aesthetics. Working alongside Rasindu on branding collateral was effortless and inspiring.', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400&auto=format&fit=crop', 5);

-- Seed Social Links
INSERT INTO `social_links` (`platform`, `url`, `icon`, `is_active`)
VALUES 
('Facebook', 'https://www.facebook.com/share/1F6N9ALqmG/', 'facebook', 1),
('Instagram', 'https://www.instagram.com/lex_frost2k5?stkn=dmloMGtkc2RmZWIz', 'instagram', 1),
('TikTok', 'https://www.tiktok.com/@rokiya2k', 'tiktok', 1),
('GitHub', 'https://github.com/roky2k05', 'github', 1),
('LinkedIn', 'https://www.linkedin.com/in/rasindu-nawod-148901374', 'linkedin', 1),
('WhatsApp', 'https://wa.me/94743869265', 'whatsapp', 1);

-- Initial Audit Log
INSERT INTO `admin_logs` (`admin_id`, `action`, `target_type`, `target_id`, `description`, `ip_address`)
VALUES 
(1, 'System Initialized', 'Database', 1, 'Rasindu Nawod portfolio schema & seed tables loaded successfully.', '127.0.0.1');

COMMIT;
