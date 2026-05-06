-- Add missing updated_at column to workers table
ALTER TABLE `workers` ADD COLUMN `updated_at` timestamp NULL DEFAULT NULL AFTER `created_at`;
