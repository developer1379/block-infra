-- 1. Change contractor_id in workers table to accommodate UUID
ALTER TABLE `workers` MODIFY `contractor_id` CHAR(36) DEFAULT NULL;

-- 2. Change contractor_id in projects table to accommodate UUID (Awarded contractor)
ALTER TABLE `projects` MODIFY `contractor_id` CHAR(36) DEFAULT NULL;

-- 3. Change contractor_id in bids table
ALTER TABLE `bids` MODIFY `contractor_id` CHAR(36) NOT NULL;

-- 4. Change awarded_to in project_awards table
ALTER TABLE `project_awards` MODIFY `awarded_to` CHAR(36) NOT NULL;
