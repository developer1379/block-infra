-- Add identity_type to workers table
ALTER TABLE `workers` ADD COLUMN `identity_type` ENUM('aadhar', 'pan', 'voter_id', 'driving_license', 'other') DEFAULT 'aadhar' AFTER `daily_wage`;
