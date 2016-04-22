/*
Navicat MySQL Data Transfer

Source Server         : Server
Source Server Version : 50535
Source Host           : 127.0.0.1:3306
Source Database       : devcms

Target Server Type    : MYSQL
Target Server Version : 50535
File Encoding         : 65001

Date: 2014-03-08 00:14:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for be_alerts
-- ----------------------------
DROP TABLE IF EXISTS `be_alerts`;
CREATE TABLE `be_alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_alerts
-- ----------------------------

-- ----------------------------
-- Table structure for be_block_relations
-- ----------------------------
DROP TABLE IF EXISTS `be_block_relations`;
CREATE TABLE `be_block_relations` (
  `parent` varchar(255) NOT NULL,
  `child` varchar(255) NOT NULL,
  `version` int(11) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`parent`,`child`,`version`),
  KEY `version_parent` (`parent`,`version`),
  KEY `version` (`version`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_block_relations
-- ----------------------------

-- ----------------------------
-- Table structure for be_blocks
-- ----------------------------
DROP TABLE IF EXISTS `be_blocks`;
CREATE TABLE `be_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `global` enum('yes','no') CHARACTER SET latin1 DEFAULT 'no',
  `type` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `data` longblob,
  `options` blob,
  `active` enum('yes','no') CHARACTER SET latin1 DEFAULT 'yes',
  PRIMARY KEY (`id`,`version`),
  UNIQUE KEY `name_version_unique` (`version`,`name`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_blocks
-- ----------------------------

-- ----------------------------
-- Table structure for be_cache
-- ----------------------------
DROP TABLE IF EXISTS `be_cache`;
CREATE TABLE `be_cache` (
  `id` varchar(255) NOT NULL,
  `object` blob,
  `timeout` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_cache
-- ----------------------------

-- ----------------------------
-- Table structure for be_link_permissions
-- ----------------------------
DROP TABLE IF EXISTS `be_link_permissions`;
CREATE TABLE `be_link_permissions` (
  `link_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`link_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_link_permissions
-- ----------------------------
INSERT INTO `be_link_permissions` VALUES ('1', '1');
INSERT INTO `be_link_permissions` VALUES ('1', '2');
INSERT INTO `be_link_permissions` VALUES ('1', '3');
INSERT INTO `be_link_permissions` VALUES ('1', '4');
INSERT INTO `be_link_permissions` VALUES ('1', '5');
INSERT INTO `be_link_permissions` VALUES ('2', '1');
INSERT INTO `be_link_permissions` VALUES ('2', '2');
INSERT INTO `be_link_permissions` VALUES ('2', '3');
INSERT INTO `be_link_permissions` VALUES ('2', '4');
INSERT INTO `be_link_permissions` VALUES ('2', '5');
INSERT INTO `be_link_permissions` VALUES ('3', '1');
INSERT INTO `be_link_permissions` VALUES ('3', '2');
INSERT INTO `be_link_permissions` VALUES ('3', '3');
INSERT INTO `be_link_permissions` VALUES ('3', '4');
INSERT INTO `be_link_permissions` VALUES ('3', '5');
INSERT INTO `be_link_permissions` VALUES ('4', '1');
INSERT INTO `be_link_permissions` VALUES ('4', '2');
INSERT INTO `be_link_permissions` VALUES ('4', '3');
INSERT INTO `be_link_permissions` VALUES ('4', '4');
INSERT INTO `be_link_permissions` VALUES ('4', '5');
INSERT INTO `be_link_permissions` VALUES ('5', '2');
INSERT INTO `be_link_permissions` VALUES ('6', '1');
INSERT INTO `be_link_permissions` VALUES ('6', '2');
INSERT INTO `be_link_permissions` VALUES ('6', '3');
INSERT INTO `be_link_permissions` VALUES ('6', '4');
INSERT INTO `be_link_permissions` VALUES ('6', '5');
INSERT INTO `be_link_permissions` VALUES ('7', '1');
INSERT INTO `be_link_permissions` VALUES ('7', '2');
INSERT INTO `be_link_permissions` VALUES ('7', '3');
INSERT INTO `be_link_permissions` VALUES ('7', '4');
INSERT INTO `be_link_permissions` VALUES ('7', '5');
INSERT INTO `be_link_permissions` VALUES ('8', '1');
INSERT INTO `be_link_permissions` VALUES ('8', '2');
INSERT INTO `be_link_permissions` VALUES ('8', '3');
INSERT INTO `be_link_permissions` VALUES ('8', '4');
INSERT INTO `be_link_permissions` VALUES ('8', '5');
INSERT INTO `be_link_permissions` VALUES ('9', '1');
INSERT INTO `be_link_permissions` VALUES ('9', '2');
INSERT INTO `be_link_permissions` VALUES ('9', '3');
INSERT INTO `be_link_permissions` VALUES ('9', '4');
INSERT INTO `be_link_permissions` VALUES ('9', '5');
INSERT INTO `be_link_permissions` VALUES ('10', '1');

-- ----------------------------
-- Table structure for be_links
-- ----------------------------
DROP TABLE IF EXISTS `be_links`;
CREATE TABLE `be_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `target` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `parent` int(11) DEFAULT '0',
  `order` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_links
-- ----------------------------
INSERT INTO `be_links` VALUES ('1', 'Home', '', '', null, '0', '1');
INSERT INTO `be_links` VALUES ('2', 'Pages', '', '', null, '0', '2');
INSERT INTO `be_links` VALUES ('3', 'About', '', '', null, '0', '3');
INSERT INTO `be_links` VALUES ('4', 'Service', '', '', null, '0', '4');
INSERT INTO `be_links` VALUES ('5', 'Contact', '', '', null, '0', '5');
INSERT INTO `be_links` VALUES ('9', 'FAQ', '/page-example-page.html', '', null, '2', '0');

-- ----------------------------
-- Table structure for be_module_permissions
-- ----------------------------
DROP TABLE IF EXISTS `be_module_permissions`;
CREATE TABLE `be_module_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` int(11) NOT NULL DEFAULT '0',
  `group` int(11) DEFAULT NULL,
  `access` enum('frontend','backend') DEFAULT 'frontend',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_module_permissions
-- ----------------------------
INSERT INTO `be_module_permissions` VALUES ('1', '1', '2', 'frontend');
INSERT INTO `be_module_permissions` VALUES ('2', '1', '3', 'frontend');
INSERT INTO `be_module_permissions` VALUES ('3', '1', '1', 'backend');
INSERT INTO `be_module_permissions` VALUES ('4', '2', '2', 'frontend');
INSERT INTO `be_module_permissions` VALUES ('5', '2', '3', 'frontend');
INSERT INTO `be_module_permissions` VALUES ('6', '2', '1', 'backend');
INSERT INTO `be_module_permissions` VALUES ('7', '3', '2', 'frontend');
INSERT INTO `be_module_permissions` VALUES ('8', '3', '3', 'frontend');
INSERT INTO `be_module_permissions` VALUES ('9', '3', '1', 'backend');

-- ----------------------------
-- Table structure for be_modules
-- ----------------------------
DROP TABLE IF EXISTS `be_modules`;
CREATE TABLE `be_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `folder` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `installer_id` int(11) DEFAULT NULL,
  `install_time` int(11) DEFAULT NULL,
  `active` enum('true','false') DEFAULT 'true',
  `installed` enum('yes','no') DEFAULT 'no',
  `market_id` int(11) DEFAULT '0',

  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_modules
-- ----------------------------
INSERT INTO `be_modules` VALUES ('1', 'Page', 'page', '3.1.0', '0', '1394228161', 'true', 'yes', '0');
INSERT INTO `be_modules` VALUES ('2', 'Blog', 'blog', '3.1.0', '0', '1394228780', 'true', 'yes', '0');
INSERT INTO `be_modules` VALUES ('3', 'BuilderPayment', 'builderpayment', '3.1.0', '0', '1394228780', 'true', 'yes', '0');

-- ----------------------------
-- Table structure for be_options
-- ----------------------------
DROP TABLE IF EXISTS `be_options`;
CREATE TABLE `be_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `option_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_options
-- ----------------------------
INSERT INTO `be_options` VALUES ('1', 'active_frontend_theme', 'default_theme_2016');
INSERT INTO `be_options` VALUES ('2', 'active_backend_theme', 'dashboard');
INSERT INTO `be_options` VALUES ('3', 'version', '3.2.3');
INSERT INTO `be_options` VALUES ('4', 'active_user_backend_theme', 'user_dashboard');
INSERT INTO `be_options` VALUES ('5', 'default_registration_group', 'Members');
INSERT INTO `be_options` VALUES ('6', 'login_title', 'Website Member Login');
INSERT INTO `be_options` VALUES ('7', 'register_title', 'Website Member Registration');
INSERT INTO `be_options` VALUES ('8', 'sign_up_verification', 'admin');
INSERT INTO `be_options` VALUES ('9', 'register_email', '<h2>Registration completed</h2><br>You have new account on ');
INSERT INTO `be_options` VALUES ('10', 'verification_email', '<h2>Verification completed</h2><br>You account has already been on ');
INSERT INTO `be_options` VALUES ('11', 'welcome_email', '<h2>Welcome</h2><br>We are happy to see you on ');
INSERT INTO `be_options` VALUES ('12', 'email_address', 'noreply@mysite.com');
INSERT INTO `be_options` VALUES ('13', 'user_dashboard_activ', 'no');
INSERT INTO `be_options` VALUES ('14', 'notify_admin_registered_user', 'no');
INSERT INTO `be_options` VALUES ('15', 'be_blog_access_groups', 'Members');
INSERT INTO `be_options` VALUES ('16', 'default_website_access_group', 'Administrators,Members,Guests');

-- ----------------------------
-- Table structure for be_page_versions
-- ----------------------------
DROP TABLE IF EXISTS `be_page_versions`;
CREATE TABLE `be_page_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `approver` int(11) NOT NULL DEFAULT '-1',
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `status` enum('pending','submitted') CHARACTER SET latin1 DEFAULT 'pending',
  `active` enum('yes','no') CHARACTER SET latin1 DEFAULT 'no',
  `time_created` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `path_active` (`path`,`active`),
  KEY `path_status` (`path`,`status`),
  KEY `path` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_page_versions
-- ----------------------------

-- ----------------------------
-- Table structure for be_pages
-- ----------------------------
DROP TABLE IF EXISTS `be_pages`;
CREATE TABLE `be_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `template` varchar(255) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `groups` varchar(255) DEFAULT NULL,
  `meta_desc` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `seo_index` varchar(255) CHARACTER SET swe7 COLLATE swe7_bin NOT NULL,
  `seo_follow` varchar(255) NOT NULL,
  `seo_snippet` varchar(255) NOT NULL,
  `seo_archive` varchar(255) NOT NULL,
  `seo_img_index` varchar(255) NOT NULL,
  `seo_odp` varchar(255) NOT NULL,  
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_pages
-- ----------------------------
INSERT INTO `be_pages` VALUES ('11', 'Example Page', 'blank.tpl', '1426204004', '13', 'example-page', 'Guests,Members,Administrators', '', '', 'noindex,', 'nofollow,','','','','');

-- ----------------------------
-- Table structure for be_blog_comments
-- ----------------------------
DROP TABLE IF EXISTS `be_post_comments`;
DROP TABLE IF EXISTS `be_blog_comments`;
CREATE TABLE `be_blog_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `text` text,
  `time_created` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_blog_comments
-- ----------------------------

-- ----------------------------
-- Table structure for be_blog_posts
-- ----------------------------
DROP TABLE IF EXISTS `be_blog_posts`;
DROP TABLE IF EXISTS `be_posts`;
CREATE TABLE `be_blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `text` text DEFAULT NULL,
  `image` varchar(255) DEFAULT '',
  `time_created` int(11) DEFAULT '0',
  `category_id` int(11) DEFAULT '0',  
  `user_id` int(11) unsigned NOT NULL,  
  `comments_allowed` enum('yes','no','hide') DEFAULT 'yes',
  `tags` varchar(255) DEFAULT '',
  `groups_allowed` varchar(255) DEFAULT '',
  `slug` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title_fulltext` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_blog_posts
-- ----------------------------

-- ----------------------------
-- Table structure for be_blog_categories
-- ----------------------------
DROP TABLE IF EXISTS `be_blog_categories`;
CREATE TABLE `be_blog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(255) DEFAULT '',
  `image` varchar(255) DEFAULT '',
  `time_created` int(11) DEFAULT NULL,
  `groups_allowed` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_blog_categories
-- ----------------------------

-- ----------------------------
-- Table structure for be_blog_comment_reports
-- ----------------------------
DROP TABLE IF EXISTS `be_blog_comment_reports`;
CREATE TABLE `be_blog_comment_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) DEFAULT '0',
  `text` varchar(255) DEFAULT '',
  `time_of_creation` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_blog_comment_reports
-- ----------------------------

-- ----------------------------
-- Table structure for be_link_groups_users
-- ----------------------------
DROP TABLE IF EXISTS `be_link_groups_users`;
CREATE TABLE `be_link_groups_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_link_groups_users
-- ----------------------------

-- ----------------------------
-- Table structure for be_user_settings
-- ----------------------------
DROP TABLE IF EXISTS `be_user_settings`;
CREATE TABLE `be_user_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `allow_avatar` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_user_settings
-- ----------------------------

-- ----------------------------
-- Table structure for be_user_groups
-- ----------------------------
DROP TABLE IF EXISTS `be_user_groups`;
CREATE TABLE `be_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `description` text,
  `allow_posts` int(2),
  `allow_categories` int(2),
  `use_created_categories` int(1) DEFAULT '0',
  `default_user_post_category` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_user_groups
-- ----------------------------
INSERT INTO `be_user_groups` VALUES ('1', 'Administrators', 'Group for all users who should have access to the Admin Dashboard.',1,1,0,'');
INSERT INTO `be_user_groups` VALUES ('2', 'Members', 'Group for logged in users.',0,0,0,'');
INSERT INTO `be_user_groups` VALUES ('3', 'Guests', 'Group for non-logged in users.',0,0,0,'');
INSERT INTO `be_user_groups` VALUES ('4', 'Frontend Editor', 'Members of this group are able to make changes to the website pages. Still a member of Frontend Manager group must approve their changes.',0,0,0,'');
INSERT INTO `be_user_groups` VALUES ('5', 'Frontend Manager', 'Members of this group are able to approve changes made by the Frontend Editor group and switch page versions.',0,0,0,'');

-- ----------------------------
-- Table structure for be_users
-- ----------------------------
DROP TABLE IF EXISTS `be_users`;
CREATE TABLE `be_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `first_name` varchar(60) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `avatar` varchar(500) DEFAULT NULL,
  `date_registered` int(11) DEFAULT NULL,
  `level` enum('Member','Administrator') DEFAULT 'Member',
  `last_activity` int(11) DEFAULT '0',
  `pass_reset_token` varchar(255) DEFAULT '',
  `verified` varchar(225) DEFAULT 'no',
  `cache_token` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `user_search_fulltext` (`username`,`first_name`,`email`),
  FULLTEXT KEY `username_fulltext` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=13 ;

-- ----------------------------
-- Records of be_users
-- ----------------------------

-- ----------------------------
-- Table structure for be_visits
-- ----------------------------
DROP TABLE IF EXISTS `be_visits`;
CREATE TABLE `be_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `page` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timestamp` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of be_visits
-- ----------------------------

-- Update 2.0.25 ---


ALTER TABLE be_alerts CHANGE `user` `user_id` INT (11);
DROP TABLE IF EXISTS `be_products`;
CREATE TABLE `be_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `remote_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

ALTER TABLE be_module_permissions CHANGE `module` `module_id` INT (11);
ALTER TABLE be_module_permissions CHANGE `group` `group_id` INT (11);


-- Update 2.0.26 ---
-- ----------------------------
-- Table structure for be_builderpayment_addresses
-- ----------------------------
DROP TABLE IF EXISTS `be_builderpayment_addresses`;
CREATE TABLE `be_builderpayment_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_builderpayment_addresses
-- ----------------------------

-- ----------------------------
-- Table structure for be_builderpayment_link_order_bill_addr
-- ----------------------------
DROP TABLE IF EXISTS `be_builderpayment_link_order_bill_addr`;
CREATE TABLE `be_builderpayment_link_order_bill_addr` (
  `id` int(11) NOT NULL,
  `billingaddress_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_builderpayment_link_order_bill_addr
-- ----------------------------

-- ----------------------------
-- Table structure for be_builderpayment_link_order_product
-- ----------------------------
DROP TABLE IF EXISTS `be_builderpayment_link_order_product`;
CREATE TABLE `be_builderpayment_link_order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_builderpayment_link_order_product
-- ----------------------------

-- ----------------------------
-- Table structure for be_builderpayment_link_order_ship_addr
-- ----------------------------
DROP TABLE IF EXISTS `be_builderpayment_link_order_ship_addr`;
CREATE TABLE `be_builderpayment_link_order_ship_addr` (
  `id` int(11) NOT NULL,
  `shippingaddress_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_builderpayment_link_order_ship_addr
-- ----------------------------

-- ----------------------------
-- Table structure for be_builderpayment_link_ship_user
-- ----------------------------
DROP TABLE IF EXISTS `be_builderpayment_link_ship_user`;
CREATE TABLE `be_builderpayment_link_ship_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shippingaddress_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_builderpayment_link_ship_user
-- ----------------------------

-- ----------------------------
-- Table structure for be_builderpayment_order_products
-- ----------------------------
DROP TABLE IF EXISTS `be_builderpayment_order_products`;
CREATE TABLE `be_builderpayment_order_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `custom_data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_builderpayment_order_products
-- ----------------------------

-- ----------------------------
-- Table structure for be_builderpayment_orders
-- ----------------------------
DROP TABLE IF EXISTS `be_builderpayment_orders`;
CREATE TABLE `be_builderpayment_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `custom_data` longblob,
  `payment_method` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `status` enum('pending','paid','canceled') DEFAULT 'pending',
  `billingaddress_id` int(11) DEFAULT NULL,
  `shippingaddress_id` int(11) DEFAULT NULL,
  `callback` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `gross` decimal(11,2) DEFAULT NULL,
  `paid_gross` decimal(11,2) DEFAULT '0.00',
  `shipped` enum('yes','no') DEFAULT 'no',
  `time_created` int(11) DEFAULT '0',
  `time_paid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_builderpayment_orders
-- ----------------------------