CREATE DATABASE `cms_seda`;
USE `cms_seda`;

GRANT ALL PRIVILEGES ON `cms_seda`.* TO 'cms_seda'@'localhost' IDENTIFIED BY 'cms_seda';

CREATE TABLE `config` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`var` varchar(100) NOT NULL default '',
	`val` text,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `menu` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`label` varchar(100) NOT NULL default '',
	`content` varchar(100) NOT NULL default '',
	`order` int(2) NOT NULL default 0,
	`parent` int(11) NOT NULL default -1,
	`active` int(1) NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `users` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`username` varchar(50) NOT NULL default '',
	`password` varchar(50) NOT NULL default '',
	`first_name` varchar(50) NOT NULL default '',
	`last_name` varchar(50) NOT NULL default '',
	`email` varchar(255) NOT NULL default '',
	`tel` varchar(30) NOT NULL default '',
	`mobile` varchar(30) NOT NULL default '',
	`fax` varchar(30) NOT NULL default '',
	`notes` varchar(255) NOT NULL default '',
	`active` int(1) NOT NULL default 1,
	PRIMARY KEY(`uid`)
);

CREATE TABLE `web_stats` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`ip` varchar(30) NOT NULL default '',
	`page` varchar(100) NOT NULL default '',
	`session` varchar(50) NOT NULL default '',
	PRIMARY KEY (`uid`)
);

CREATE TABLE `categories` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`name` varchar(255) NOT NULL default '',
	`active` int(1) NOT NULL default 0,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `products` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`user` int(11) NOT NULL default 0,
	`category` int(11) NOT NULL default 0,
	`name` varchar(255) NOT NULL default '',
	`price` decimal(10,2) NOT NULL default 0,
	`picture` varchar(255) NOT NULL default '',
	`active` int(1) NOT NULL default 0,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `orders` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`name` varchar(255) NOT NULL default '',
	`contact_number` varchar(30) NOT NULL default '',
	`email` varchar(255) NOT NULL default '',
	`address` text,
	`reference` varchar(255) NOT NULL default '',
	`amount` decimal(10,2) NOT NULL default 0,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `order_items` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`product` int(11) NOT NULL default 0,
	`price` decimal(10,2) NOT NULL default 0,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `gallery` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`item` varchar(12) NOT NULL default '',
	`file` varchar(255) NOT NULL default '',
	PRIMARY KEY (`uid`)
);

CREATE TABLE `payments` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`order` int(11) NOT NULL default 0,
	`reference` varchar(255) NOT NULL default '',
	`payment_date` datetime NOT NULL default '0000-00-00 00:00:00',
	`payment_type` varchar(20) NOT NULL default '',
	`status` varchar(10) NOT NULL default 'PRE',
	`amount` decimal(10,2) NOT NULL default 0,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `jobs` (
	`uid` int(11) NOT NULL auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`user` int(11) NOT NULL default 0,
	`job_title` varchar(255) NOT NULL default '',
	`location` varchar(255) NOT NULL default '',
	`salary` varchar(255) NOT NULL default '',
	`text` text,
	`email` varchar(255) NOT NULL default '',
	`active` int(1) NOT NULL default 0,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `candidates` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`name` varchar(255) NOT NULL default '',
	`contact_number` varchar(30) NOT NULL default '',
	`email` varchar(255) NOT NULL default '',
	`active` int(1) NOT NULL default 0,
	`cv` varchar(255) NOT NULL default '',
	PRIMARY KEY (`uid`)
);

INSERT INTO users (`datetime`, `username`, `password`, `first_name`, `last_name`, `email`, `active`) VALUES(NOW(), 'admin', MD5('admin'), 'Admin', 'User', 'development@implyit.co.za', 1);
CREATE TABLE `clients` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`user` int(11) NOT NULL default 0,
	`sector_id` int(1) NOT NULL default 1,
	`name` varchar(50) NOT NULL default '',
	`notes` varchar(255) NOT NULL default '',
	`picture` varchar(255) NOT NULL DEFAULT '',
	`contact` varchar(255) NOT NULL DEFAULT '',
	`email`  varchar(255) NOT NULL DEFAULT '',
	`website`  varchar(255) NOT NULL DEFAULT '',
	`active` int(1) NOT NULL default 1,
	
	PRIMARY KEY(`uid`)
);

/* Changes: 08 May 2013 Elie */

CREATE TABLE `sectors` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`user` int(11) NOT NULL default 0,
	`name` varchar(50) NOT NULL default '',
	`active` int(1) NOT NULL default 1,
	PRIMARY KEY(`uid`)
);


INSERT INTO `sectors` (`datetime`,`user`, `name`, `active`) VALUES(NOW(),1,'Agriculture-Agro-Processed Foods',1);
INSERT INTO `sectors` (`datetime`,`user`, `name`, `active`) VALUES(NOW(),1,'Automotive Parts',1); 
INSERT INTO `sectors` (`datetime`,`user`, `name`, `active`) VALUES(NOW(),1,'Chemicals',1);
INSERT INTO `sectors` (`datetime`,`user`, `name`, `active`) VALUES(NOW(),1,'Crafts',1);
INSERT INTO `sectors` (`datetime`,`user`, `name`, `active`) VALUES(NOW(),1,'Fabricated Metals',1);
INSERT INTO `sectors` (`datetime`,`user`, `name`, `active`) VALUES(NOW(),1,'Fashion-Textiles',1);
INSERT INTO `sectors` (`datetime`,`user`, `name`, `active`) VALUES(NOW(),1,'Footwear',1);
INSERT INTO `sectors` (`datetime`,`user`, `name`, `active`) VALUES(NOW(),1,'Furniture-Household Fittings',1);
INSERT INTO `sectors` (`datetime`,`user`, `name`, `active`) VALUES(NOW(),1,'Giftware-Industries with Export Potential',1);
INSERT INTO `sectors` (`datetime`,`user`, `name`, `active`) VALUES(NOW(),1,'ICT',1);
INSERT INTO `sectors` (`datetime`,`user`, `name`, `active`) VALUES(NOW(),1,'Wool-Mohair',1);
/* End Changes: 08 May 2013 Elie */





CREATE TABLE `members` (
	`uid` int(11) auto_increment,
	`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	`Surname` varchar(50) NOT NULL default '',
	`Name` varchar(50) NOT NULL default '',
	`Dateofbirth` varchar(255) NOT NULL default '',
	`Telephonework` varchar(30) NOT NULL default '',
	`cellphone` varchar(30) NOT NULL default '',
	`EmailAddress` varchar(30) NOT NULL default '',
	`Datemarriage` varchar(255) NOT NULL default '',
	`active` int(1) NOT NULL default 1,
	PRIMARY KEY(`uid`)
);
                                                