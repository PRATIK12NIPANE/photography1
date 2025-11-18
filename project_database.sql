-- =====================================================
-- PJ Photography Website - Complete Database Setup
-- =====================================================
-- This SQL file contains the complete database structure
-- for the PJ Photography website project.
--
-- Database: pj_photography
-- Created: November 2025
-- =====================================================

-- Create database (if it doesn't exist)
CREATE DATABASE IF NOT EXISTS `pj_photography`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Use the database
USE `pj_photography`;

-- =====================================================
-- Table: contacts
-- Description: Stores contact form submissions
-- =====================================================
CREATE TABLE IF NOT EXISTS `contacts` (
    `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL COMMENT 'Contact person name',
    `email` VARCHAR(50) NOT NULL COMMENT 'Contact email address',
    `phone` VARCHAR(20) DEFAULT NULL COMMENT 'Contact phone number',
    `wedding_date` DATE DEFAULT NULL COMMENT 'Wedding date for event bookings',
    `venue` VARCHAR(100) DEFAULT NULL COMMENT 'Event venue location',
    `days` INT DEFAULT NULL COMMENT 'Number of days for photo shoot',
    `service` VARCHAR(50) DEFAULT NULL COMMENT 'Type of photography service requested',
    `message` TEXT COMMENT 'Detailed message from contact form',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Record creation timestamp',

    -- Indexes for better performance
    INDEX `idx_email` (`email`),
    INDEX `idx_created_at` (`created_at`),
    INDEX `idx_service` (`service`),
    INDEX `idx_wedding_date` (`wedding_date`),

    -- Constraints
    CONSTRAINT `chk_days` CHECK (`days` > 0 AND `days` <= 10),
    CONSTRAINT `chk_email_format` CHECK (`email` REGEXP '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Sample Data for Testing
-- =====================================================
-- Insert some sample contact form submissions
INSERT INTO `contacts` (`name`, `email`, `phone`, `wedding_date`, `venue`, `days`, `service`, `message`) VALUES
('Sarah Johnson', 'sarah.johnson@email.com', '+1-555-0123', '2025-06-15', 'Rose Garden Estate', 2, 'Wedding', 'Hi PJ! We\'d love to book you for our summer wedding. We need full-day coverage including ceremony and reception photos.'),
('David & Emma Smith', 'dave.emma@email.com', '+1-555-0456', '2025-08-22', 'Beachside Resort', 1, 'Wedding', 'Looking for an intimate beach wedding photography package. We want candid moments and couple portraits.'),
('Marketing Team', 'hello@techstartup.com', '+1-555-0789', NULL, 'Downtown Convention Center', 1, 'Corporate', 'We need professional headshots for our team of 15. Please include both individual and group shots.'),
('Jennifer Liu', 'jennifer@email.com', '+1-555-0321', '2025-12-01', 'Winter Wonderland Lodge', 2, 'Wedding', 'Planning a winter wonderland wedding theme. Need photos that capture the magical atmosphere.'),
('Family Reunion', 'grandma@email.com', '+1-555-0654', '2025-07-04', 'Grandma\'s Backyard', 1, 'Family', '75th birthday celebration with extended family. 30 people expected, need group photos and individual portraits.'),
('Portfolio Session', 'model@email.com', NULL, NULL, 'Studio Location', 1, 'Portfolio', 'Seeking professional portfolio photos for acting resume. Need both headshots and body shots in various outfits.'),
('Event Photography', 'events@email.com', '+1-555-0987', NULL, 'Convention Center', 1, 'Event', 'Corporate gala event this Friday. Need photos of speakers, networking, and venue setup.')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- =====================================================
-- Additional Tables (for future expansion)
-- =====================================================

-- Table: services (for different photography packages)
CREATE TABLE IF NOT EXISTS `services` (
    `id` INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL COMMENT 'Service package name',
    `description` TEXT COMMENT 'Detailed service description',
    `price_range` VARCHAR(20) COMMENT 'Price range (e.g., $500-$1500)',
    `duration_hours` INT DEFAULT 1 COMMENT 'Typical duration in hours',
    `includes` TEXT COMMENT 'What''s included in the package',
    `active` BOOLEAN DEFAULT TRUE COMMENT 'Service availability',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX `idx_active` (`active`),
    UNIQUE KEY `uk_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample services data
INSERT INTO `services` (`name`, `description`, `price_range`, `duration_hours`, `includes`, `active`) VALUES
('Wedding Photography', 'Complete wedding day coverage from preparation to reception', '$1500-$3500', 8, 'Full day coverage, 400+ edited photos, online gallery, print release', TRUE),
('Couple Session', 'Intimate couple photography session for engagement or anniversary', '$300-$600', 2, '1-2 hour session, 50+ edited photos, online gallery', TRUE),
('Family Portraits', 'Professional family photography for any occasion', '$200-$500', 1, '1 hour session, 25+ edited photos, print release', TRUE),
('Corporate Headshots', 'Professional business portraits for individuals or teams', '$100-$300', 1, '20-30 edited headshots, various backgrounds, online gallery', TRUE),
('Event Coverage', 'Photography for corporate events, parties, and celebrations', '$500-$1500', 4, 'Full event coverage, edited photo selection, usage rights', TRUE)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Table: gallery (for portfolio images)
CREATE TABLE IF NOT EXISTS `gallery` (
    `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(100) NOT NULL COMMENT 'Photo title',
    `description` TEXT COMMENT 'Photo description',
    `filename` VARCHAR(255) NOT NULL COMMENT 'Image filename',
    `category` VARCHAR(50) NOT NULL COMMENT 'Photo category (wedding, family, corporate, etc.)',
    `service_id` INT(3) UNSIGNED DEFAULT NULL COMMENT 'Related service ID',
    `featured` BOOLEAN DEFAULT FALSE COMMENT 'Featured on homepage',
    `display_order` INT DEFAULT 0 COMMENT 'Display order in gallery',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX `idx_category` (`category`),
    INDEX `idx_featured` (`featured`),
    INDEX `idx_service` (`service_id`),
    FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE SET NULL,

    UNIQUE KEY `uk_filename` (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample gallery data
INSERT INTO `gallery` (`title`, `description`, `filename`, `category`, `service_id`, `featured`, `display_order`) VALUES
('Summer Wedding Bliss', 'Beautiful outdoor wedding ceremony in a garden setting', 'summer-wedding-001.jpg', 'Wedding', 1, TRUE, 1),
('Family Beach Day', 'Heartwarming family portraits taken during golden hour at the beach', 'family-beach-001.jpg', 'Family', 3, TRUE, 2),
('Corporate Team Portrait', 'Professional group photo for tech startup annual meeting', 'corporate-team-001.jpg', 'Corporate', 4, FALSE, 3),
('Romantic Couple Session', 'Engagement photos in a romantic garden setting', 'couple-garden-001.jpg', 'Wedding', 2, TRUE, 4),
('Event Celebration', 'Festive corporate event photography capturing the celebratory atmosphere', 'event-celebration-001.jpg', 'Event', 5, FALSE, 5)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);

-- =====================================================
-- Views for Reporting (Future Use)
-- =====================================================

-- View: Recent Contact Submissions
CREATE OR REPLACE VIEW `vw_recent_contacts` AS
SELECT
    `id`,
    `name`,
    `email`,
    `phone`,
    `wedding_date`,
    `service`,
    `created_at`
FROM `contacts`
WHERE `created_at` >= DATE_SUB(NOW(), INTERVAL 30 DAY)
ORDER BY `created_at` DESC;

-- View: Service Popularity
CREATE OR REPLACE VIEW `vw_service_stats` AS
SELECT
    `service`,
    COUNT(*) as `total_inquiries`,
    MAX(`created_at`) as `last_inquiry`
FROM `contacts`
WHERE `service` IS NOT NULL
GROUP BY `service`
ORDER BY `total_inquiries` DESC;

-- =====================================================
-- Security and Permissions
-- =====================================================

-- Create a dedicated database user for the web application
-- Note: This should be executed separately with proper credentials
/*
CREATE USER IF NOT EXISTS 'pj_photo_user'@'localhost'
IDENTIFIED BY 'secure_password_here';

GRANT SELECT, INSERT, UPDATE ON `pj_photography`.* TO 'pj_photo_user'@'localhost';

FLUSH PRIVILEGES;
*/

-- =====================================================
-- Backup Information
-- =====================================================
/*
To backup this database:
mysqldump -u root -p pj_photography > pj_photography_backup.sql

To restore from backup:
mysql -u root -p pj_photography < pj_photography_backup.sql
*/

-- =====================================================
-- Setup Verification
-- =====================================================

-- Show database information
SELECT 'PJ Photography Database Setup Complete!' as Status;
SELECT COUNT(*) as 'Contacts Table Records' FROM contacts;
SELECT COUNT(*) as 'Services Available' FROM services;
SELECT COUNT(*) as 'Gallery Images' FROM gallery;

-- =====================================================
-- End of Database Setup
-- =====================================================
