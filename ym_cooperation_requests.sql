/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : habibi

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2018-12-08 17:53:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ym_cooperation_requests
-- ----------------------------
DROP TABLE IF EXISTS `ym_cooperation_requests`;
CREATE TABLE `ym_cooperation_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL COMMENT 'نام',
  `last_name` varchar(255) NOT NULL COMMENT 'نام خانوادگی',
  `mobile` varchar(11) NOT NULL COMMENT 'شماره موبایل',
  `expertise` varchar(255) DEFAULT NULL COMMENT 'تخصص',
  `experience_level` varchar(255) DEFAULT NULL COMMENT 'میزان تجربه',
  `create_date` varchar(20) DEFAULT NULL,
  `status` decimal(1,0) unsigned NOT NULL DEFAULT '0' COMMENT 'وضعیت',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_cooperation_requests
-- ----------------------------
