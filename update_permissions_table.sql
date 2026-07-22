-- Create modules table
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `is_system` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  CONSTRAINT `fk_modules_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_modules_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Update permissions table
ALTER TABLE `permissions` 
ADD COLUMN `module_id` int(11) DEFAULT NULL AFTER `id`,
ADD COLUMN `status` enum('active','inactive') DEFAULT 'active' AFTER `description`,
ADD COLUMN `is_system` tinyint(1) DEFAULT 0 AFTER `status`,
ADD COLUMN `created_by` int(11) DEFAULT NULL AFTER `is_system`,
ADD COLUMN `updated_by` int(11) DEFAULT NULL AFTER `is_system`,
ADD COLUMN `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() AFTER `created_at`,
ADD CONSTRAINT `fk_permissions_module` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_permissions_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
ADD CONSTRAINT `fk_permissions_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- Insert default modules
INSERT INTO `modules` (`name`, `slug`, `is_system`) VALUES
('Dashboard', 'dashboard', 1),
('Users', 'users', 1),
('Roles', 'roles', 1),
('Permissions', 'permissions', 1),
('Donors', 'donors', 0),
('Donations', 'donations', 0),
('Campaigns', 'campaigns', 0),
('Expenses', 'expenses', 0),
('Reports', 'reports', 0),
('Settings', 'settings', 1);
