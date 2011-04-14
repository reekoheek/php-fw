DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
	`id` bigint(20) NOT NULL auto_increment,
	`username` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	`first_name` varchar(255) NOT NULL,
	`middle_name` varchar(255) NOT NULL,
	`last_name` varchar(255) NOT NULL,
	`created_by` varchar(255) NOT NULL,
	`created_time` datetime NOT NULL,
	`updated_by` varchar(255) NOT NULL,
	`updated_time` datetime NOT NULL,
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `users` ADD UNIQUE `UNIQUE_USERNAME`(`username`);

insert into `users` values(null, 'admin', '123', 'Admin', '', 'System', 'system', now(), 'system', now());

/*********************************************************/

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
	`id` bigint(20) NOT NULL auto_increment,
	`project` bigint(20) NOT NULL,
	`title` varchar(255) NOT NULL,
	`description` text NOT NULL,
	`priority` bigint(20) NOT NULL,
	`context` bigint(20) NOT NULL,
	`created_by` varchar(255) NOT NULL,
	`created_time` datetime NOT NULL,
	`updated_by` varchar(255) NOT NULL,
	`updated_time` datetime NOT NULL,
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/************************************************************/
DROP TABLE IF EXISTS `lookups`;
CREATE TABLE `lookups` (
	`id` bigint(20) NOT NULL auto_increment,
	`type` varchar(255) NOT NULL,
	`code` varchar(255) NOT NULL,
	`name` varchar(255) NOT NULL,
	`description` text,
	`priority` bigint(20) NOT NULL,
	`created_by` varchar(255) NOT NULL,
	`created_time` datetime NOT NULL,
	`updated_by` varchar(255) NOT NULL,
	`updated_time` datetime NOT NULL,
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `lookups` ADD UNIQUE `UNIQUE_TYPE_CODE`(`type`, `code`);

/************************************************************/
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
	`id` bigint(20) NOT NULL auto_increment,
	`priority` varchar(255),	
	`message` text,
	`trace` text,
	`file` varchar(255),
	`line` varchar(255),
	`created_by` varchar(255) NOT NULL,
	`created_time` datetime NOT NULL,
	`updated_by` varchar(255) NOT NULL,
	`updated_time` datetime NOT NULL,
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
