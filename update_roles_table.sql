ALTER TABLE `roles` 
ADD COLUMN `display_name` varchar(100) NOT NULL AFTER `name`,
ADD COLUMN `status` enum('active','inactive') DEFAULT 'active' AFTER `description`,
ADD COLUMN `created_by` int(11) DEFAULT NULL AFTER `status`,
ADD COLUMN `updated_by` int(11) DEFAULT NULL AFTER `status`,
ADD CONSTRAINT `fk_roles_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
ADD CONSTRAINT `fk_roles_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- Update existing roles with display names
UPDATE `roles` SET `display_name` = `name`;
