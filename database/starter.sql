-- ============================================================
--  Starter Kit — MySQL Database
--  Database : starter
--  Import   : phpMyAdmin > Import > select this file
--  Version  : 1.1.0
-- ============================================================

SET SQL_MODE   = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone  = "+00:00";
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `starter`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `starter`;

-- ============================================================
--  TABLE: users
--  Roles: user, editor  (admin role lives in admins table)
-- ============================================================
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
    `id`         INT(11)      UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(100) NOT NULL,
    `email`      VARCHAR(150) NOT NULL,
    `password`   VARCHAR(255) NOT NULL,
    `role`       ENUM('user','editor')        NOT NULL DEFAULT 'user',
    `status`     ENUM('active','inactive')    NOT NULL DEFAULT 'active',
    `avatar`     VARCHAR(255)                     DEFAULT NULL,
    `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- plain password: password
INSERT INTO `users` (`name`, `email`, `password`, `role`, `status`) VALUES
('Alice Johnson', 'alice@example.com', '$2y$10$UwBbtw7SU2RR5YPq5Moj2eZuHJUfYXP3Fd5QcoYIW65TIveFKIzAC', 'user',   'active'),
('Bob Smith',     'bob@example.com',   '$2y$10$UwBbtw7SU2RR5YPq5Moj2eZuHJUfYXP3Fd5QcoYIW65TIveFKIzAC', 'user',   'active'),
('Carol White',   'carol@example.com', '$2y$10$UwBbtw7SU2RR5YPq5Moj2eZuHJUfYXP3Fd5QcoYIW65TIveFKIzAC', 'editor', 'active'),
('David Lee',     'david@example.com', '$2y$10$UwBbtw7SU2RR5YPq5Moj2eZuHJUfYXP3Fd5QcoYIW65TIveFKIzAC', 'user',   'active'),
('Eva Brown',     'eva@example.com',   '$2y$10$UwBbtw7SU2RR5YPq5Moj2eZuHJUfYXP3Fd5QcoYIW65TIveFKIzAC', 'user',   'inactive');

-- ============================================================
--  TABLE: admins
--  Dedicated admin accounts — separate from users
-- ============================================================
DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
    `id`         INT(11)      UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(100) NOT NULL,
    `email`      VARCHAR(150) NOT NULL,
    `password`   VARCHAR(255) NOT NULL,
    `avatar`     VARCHAR(255)                     DEFAULT NULL,
    `status`     ENUM('active','inactive')    NOT NULL DEFAULT 'active',
    `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_admins_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- plain password: password
INSERT INTO `admins` (`name`, `email`, `password`, `status`) VALUES
('Admin', 'admin@starter.com', '$2y$10$UwBbtw7SU2RR5YPq5Moj2eZuHJUfYXP3Fd5QcoYIW65TIveFKIzAC', 'active');

-- ============================================================
--  TABLE: super_admins
--  Highest privilege — can manage admins and all users
-- ============================================================
DROP TABLE IF EXISTS `super_admins`;

CREATE TABLE `super_admins` (
    `id`         INT(11)      UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(100) NOT NULL,
    `email`      VARCHAR(150) NOT NULL,
    `password`   VARCHAR(255) NOT NULL,
    `avatar`     VARCHAR(255)                     DEFAULT NULL,
    `status`     ENUM('active','inactive')    NOT NULL DEFAULT 'active',
    `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_super_admins_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- plain password: password
INSERT INTO `super_admins` (`name`, `email`, `password`, `status`) VALUES
('Super Admin', 'superadmin@starter.com', '$2y$10$UwBbtw7SU2RR5YPq5Moj2eZuHJUfYXP3Fd5QcoYIW65TIveFKIzAC', 'active');

-- ============================================================
--  TABLE: sessions
-- ============================================================
DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
    `id`            VARCHAR(128) NOT NULL,
    `user_id`       INT(11)      UNSIGNED DEFAULT NULL,
    `ip_address`    VARCHAR(45)           DEFAULT NULL,
    `user_agent`    TEXT                  DEFAULT NULL,
    `payload`       TEXT         NOT NULL,
    `last_activity` INT(11)      NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_sessions_user_id`       (`user_id`),
    KEY `idx_sessions_last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
--  TABLE: password_resets
-- ============================================================
DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
    `id`         INT(11)      UNSIGNED NOT NULL AUTO_INCREMENT,
    `email`      VARCHAR(150) NOT NULL,
    `token`      VARCHAR(255) NOT NULL,
    `expires_at` DATETIME     NOT NULL,
    `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_pr_email` (`email`),
    KEY `idx_pr_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
--  TABLE: activity_logs
-- ============================================================
DROP TABLE IF EXISTS `activity_logs`;

CREATE TABLE `activity_logs` (
    `id`          INT(11)      UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`     INT(11)      UNSIGNED          DEFAULT NULL,
    `action`      VARCHAR(100) NOT NULL,
    `description` TEXT                  DEFAULT NULL,
    `ip_address`  VARCHAR(45)           DEFAULT NULL,
    `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_al_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `activity_logs` (`user_id`, `action`, `description`, `ip_address`) VALUES
(1, 'login',    'User logged in',      '127.0.0.1'),
(2, 'login',    'User logged in',      '127.0.0.1'),
(1, 'register', 'New account created', '127.0.0.1'),
(3, 'logout',   'User logged out',     '127.0.0.1');

SET FOREIGN_KEY_CHECKS = 1;
