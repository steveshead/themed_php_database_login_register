-- Add columns for app-based 2FA
ALTER TABLE `accounts` 
ADD COLUMN `totp_secret` VARCHAR(255) DEFAULT NULL,
ADD COLUMN `totp_enabled` TINYINT(1) NOT NULL DEFAULT 0;