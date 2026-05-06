-- Add missing contractor_id column to projects table with UUID support
ALTER TABLE `projects` ADD COLUMN `contractor_id` CHAR(36) DEFAULT NULL AFTER `client_id`;
