-- =====================================================================
-- Aracım Gelsin — Corporate Mobility Platform
-- Database schema (MySQL 8 / MariaDB 10.4+)
--
-- Conventions:
--   * snake_case, English table/column names
--   * InnoDB + utf8mb4 everywhere
--   * every content table carries: sort_order (display order),
--     is_active (admin on/off toggle), created_at / updated_at
-- =====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `aracim_gelsin`
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `aracim_gelsin`;

-- ---------------------------------------------------------------------
-- admins — admin panel operators
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username`       VARCHAR(60)  NOT NULL,
    `email`          VARCHAR(150) NOT NULL,
    `full_name`      VARCHAR(150) NOT NULL,
    `password_hash`  VARCHAR(255) NOT NULL,
    `last_login_at`  DATETIME NULL,
    `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_admins_username` (`username`),
    UNIQUE KEY `uq_admins_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- site_settings — key/value editable copy (hero text, store links, SEO…)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `site_settings` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `setting_key`    VARCHAR(100) NOT NULL,
    `setting_value`  TEXT NULL,
    `updated_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_site_settings_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- sections — which page/section blocks render, and in what order.
-- `page_key` scopes a section to one routed page (home, about, fleet, …).
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `sections` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `page_key`       VARCHAR(30) NOT NULL DEFAULT 'home',
    `section_key`    VARCHAR(60) NOT NULL,
    `section_name`   VARCHAR(150) NOT NULL,
    `is_active`      TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order`     INT NOT NULL DEFAULT 0,
    UNIQUE KEY `uq_sections_page_key` (`page_key`, `section_key`),
    KEY `idx_sections_page_key` (`page_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- problem_items — "Her Ulaşım İhtiyacı Servis Planına Uymaz" list
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `problem_items` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `description`    VARCHAR(255) NOT NULL,
    `sort_order`     INT NOT NULL DEFAULT 0,
    `is_active`      TINYINT(1) NOT NULL DEFAULT 1,
    `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- process_steps — shared shape for "Nasıl Çalışır?" and "Dijital Sistem"
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `process_steps` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `flow_type`      ENUM('how_it_works','digital_system') NOT NULL,
    `step_number`    TINYINT UNSIGNED NOT NULL,
    `icon`           VARCHAR(60) NOT NULL DEFAULT 'bolt',
    `title`          VARCHAR(150) NOT NULL,
    `description`    VARCHAR(255) NOT NULL,
    `sort_order`     INT NOT NULL DEFAULT 0,
    `is_active`      TINYINT(1) NOT NULL DEFAULT 1,
    `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY `idx_process_steps_flow_type` (`flow_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- fleet_vehicles — vehicle classes (TOGG, Ford Explorer, Tourneo Custom)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `fleet_vehicles` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name`           VARCHAR(100) NOT NULL,
    `category`       VARCHAR(150) NOT NULL,
    `tagline`        VARCHAR(200) NOT NULL,
    `description`    VARCHAR(255) NULL,
    `image_path`     VARCHAR(255) NULL,
    `sort_order`     INT NOT NULL DEFAULT 0,
    `is_active`      TINYINT(1) NOT NULL DEFAULT 1,
    `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- fleet_vehicle_features — "Kullanım Odağı" bullets per vehicle
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `fleet_vehicle_features` (
    `id`               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `fleet_vehicle_id` INT UNSIGNED NOT NULL,
    `feature_text`     VARCHAR(200) NOT NULL,
    `sort_order`       INT NOT NULL DEFAULT 0,
    CONSTRAINT `fk_fleet_vehicle_features_vehicle`
        FOREIGN KEY (`fleet_vehicle_id`) REFERENCES `fleet_vehicles` (`id`) ON DELETE CASCADE,
    KEY `idx_fleet_vehicle_features_vehicle` (`fleet_vehicle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- use_cases — "Kullanım Senaryoları" cards
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `use_cases` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `icon`           VARCHAR(60) NOT NULL DEFAULT 'directions_car',
    `title`          VARCHAR(150) NOT NULL,
    `description`    VARCHAR(255) NOT NULL,
    `sort_order`     INT NOT NULL DEFAULT 0,
    `is_active`      TINYINT(1) NOT NULL DEFAULT 1,
    `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- highlight_stats — short stat badges (30 DK / Elektrikli / İzmir / B2B)
-- reused by the Hero strip and the "Neden Farklı?" section
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `highlight_stats` (
    `id`                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `stat_value`        VARCHAR(30)  NOT NULL,
    `stat_label`        VARCHAR(100) NOT NULL,
    `stat_description`  VARCHAR(200) NULL,
    `icon`               VARCHAR(60) NOT NULL DEFAULT 'bolt',
    `sort_order`        INT NOT NULL DEFAULT 0,
    `is_active`         TINYINT(1) NOT NULL DEFAULT 1,
    `created_at`        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- hub_locations — regional nodes on the strategic operation map
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `hub_locations` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `region_label`   VARCHAR(100) NOT NULL,
    `area_name`      VARCHAR(150) NOT NULL,
    `position_top`   VARCHAR(10) NOT NULL DEFAULT '50%',
    `position_left`  VARCHAR(10) NOT NULL DEFAULT '50%',
    `is_center`      TINYINT(1) NOT NULL DEFAULT 0,
    `sort_order`     INT NOT NULL DEFAULT 0,
    `is_active`      TINYINT(1) NOT NULL DEFAULT 1,
    `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- hub_features — "Hub Modeli" bullet list
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `hub_features` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `feature_text`   VARCHAR(200) NOT NULL,
    `sort_order`     INT NOT NULL DEFAULT 0,
    `is_active`      TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- management_features — "Yönetim Paneli" bullet list
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `management_features` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `icon`           VARCHAR(60) NOT NULL DEFAULT 'visibility',
    `feature_text`   VARCHAR(200) NOT NULL,
    `sort_order`     INT NOT NULL DEFAULT 0,
    `is_active`      TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- management_stats — the 4 dark stat tiles on "Yönetim Paneli"
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `management_stats` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `stat_title`     VARCHAR(100) NOT NULL,
    `stat_subtitle`  VARCHAR(100) NOT NULL,
    `sort_order`     INT NOT NULL DEFAULT 0,
    `is_active`      TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- comparison_criteria — "Rekabet Perspektifi" table rows
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `comparison_criteria` (
    `id`                          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `criterion_name`              VARCHAR(150) NOT NULL,
    `traditional_service_value`   VARCHAR(100) NOT NULL,
    `taxi_app_value`              VARCHAR(100) NOT NULL,
    `aracim_gelsin_value`         VARCHAR(100) NOT NULL,
    `sort_order`                  INT NOT NULL DEFAULT 0,
    `is_active`                   TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- guarantee_features — Özikizler Turizm Şirketler Grubu Güvencesi cards
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `guarantee_features` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `icon`           VARCHAR(60) NOT NULL DEFAULT 'verified',
    `title`          VARCHAR(150) NOT NULL,
    `description`    VARCHAR(255) NOT NULL,
    `sort_order`     INT NOT NULL DEFAULT 0,
    `is_active`      TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- lead_requests — corporate "teklif al" form submissions
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `lead_requests` (
    `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_name`   VARCHAR(150) NOT NULL,
    `contact_name`   VARCHAR(150) NOT NULL,
    `phone`          VARCHAR(30)  NOT NULL,
    `email`          VARCHAR(150) NOT NULL,
    `message`        VARCHAR(1000) NULL,
    `source_page`    VARCHAR(150) NULL,
    `status`         ENUM('new','contacted','closed') NOT NULL DEFAULT 'new',
    `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY `idx_lead_requests_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
