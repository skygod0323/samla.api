/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : samla

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2021-03-13 17:16:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('1', 'cat1', '2021-03-01 14:55:06', '2021-03-01 14:55:06');

-- ----------------------------
-- Table structure for downloads
-- ----------------------------
DROP TABLE IF EXISTS `downloads`;
CREATE TABLE `downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of downloads
-- ----------------------------

-- ----------------------------
-- Table structure for images
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `downloads` varchar(255) DEFAULT NULL,
  `categories` varchar(255) DEFAULT NULL,
  `modelreleases` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `imageurl` varchar(255) DEFAULT NULL,
  `lowimageurl` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `photographer` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sublocation` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of images
-- ----------------------------
INSERT INTO `images` VALUES ('1', null, '1', '1', 'tag,tag2', 'kortaben.jpg', 'https://nbv.s3.eu-north-1.amazonaws.com/kortaben_26qc76YH6eoyY5ZeVPIB.jpg', 'https://nbv.s3.eu-north-1.amazonaws.com/low_kortaben_26qc76YH6eoyY5ZeVPIB.jpg', 'kortaben', 'this is kortaben', null, null, null, null, null, null, null, null, '2021-03-01 15:10:18', '2021-03-01 15:10:18');

-- ----------------------------
-- Table structure for modelreleases
-- ----------------------------
DROP TABLE IF EXISTS `modelreleases`;
CREATE TABLE `modelreleases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of modelreleases
-- ----------------------------
INSERT INTO `modelreleases` VALUES ('1', 'Portable application.rtf', 'https://nbv.s3.eu-north-1.amazonaws.com/Portable%20application_eCe1qjx58vfqLYY6zMAP.rtf', '2021-03-01 15:05:35', '2021-03-01 15:05:35');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT '',
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `remember_token` varchar(255) DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('0', 'Super', 'Admin', 'aaa@aaa.com', '$2y$10$KPLzOMrs1eJvzV4JXhvhTOVvDsuT1Mfka7.6n3o55dlmtP3n2hXiC', '', '2021-03-02 07:24:49', '2021-03-01 15:19:51', '2021-03-01 15:19:51', 'superadmin');
INSERT INTO `users` VALUES ('1', 'KSS', 'Alexander', 'kss_alexander@outlook.com', '$2y$10$3kKwcABSadXzQBox/KveaeB4TxuvyCL2Lvx.oOimnwP5MWqSrCoUe', '', '2021-03-01 15:21:38', '2021-03-01 15:23:05', '2021-03-01 15:23:05', 'admin');
