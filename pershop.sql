/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : pershop

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2018-02-14 00:26:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'lemon', 'lemon', 'lemon@163.com', '$2y$10$LVu2.hSCjbL5lYGRx3zbkufT1Pbi4laKe62L6S/8EuKIGFaWDf7FK', 'Nz4xKxvh15M04k4xwxtA8t3tMH37qfNV4QsvK2tYs2smIEyrxSDkkx9egfcZ', '2018-02-11 09:18:09', '2018-02-11 09:18:09');
INSERT INTO `admins` VALUES ('2', 'Syble Thompson II', 'Bruce', 'roselyn.barton@example.net', '$2y$10$GvcUeuxAf3KIW8j3/e64S.moc8heCgLr3LxdL.fk35rVt2O39.rsi', 'Whbs1eDGzk', '2018-02-11 09:18:09', '2018-02-11 09:18:09');
INSERT INTO `admins` VALUES ('3', 'Wendy Jerde III', 'Norma', 'pagac.trey@example.com', '$2y$10$GvcUeuxAf3KIW8j3/e64S.moc8heCgLr3LxdL.fk35rVt2O39.rsi', 'qk0ABJApDw', '2018-02-11 09:18:09', '2018-02-11 09:18:09');
INSERT INTO `admins` VALUES ('4', 'Maud Breitenberg', 'Hettie', 'uzieme@example.com', '$2y$10$GvcUeuxAf3KIW8j3/e64S.moc8heCgLr3LxdL.fk35rVt2O39.rsi', '1kV4Xqju1P', '2018-02-11 09:18:09', '2018-02-11 09:18:09');

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单图标',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单链接',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级菜单ID',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,0禁用1启用',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES ('1', '系统管理', 'fa fa-cog', 'http://pershop.oo/admin/user', '0', '1', '1', '2018-02-12 10:50:39', '2018-02-12 10:50:39');
INSERT INTO `menus` VALUES ('2', '菜单管理', 'fa fa-th-large', 'http://pershop.oo/admin/user', '1', '1', '1', '2018-02-12 10:54:17', '2018-02-12 10:54:17');
INSERT INTO `menus` VALUES ('3', '用户管理', 'fa fa-users', 'http://pershop.oo/admin/user', '1', '4', '1', '2018-02-12 10:55:18', '2018-02-12 10:55:18');
INSERT INTO `menus` VALUES ('4', '角色管理', 'fa fa-tags', 'http://pershop.oo/admin/permission', '1', '2', '1', '2018-02-12 15:43:11', '2018-02-12 15:43:11');
INSERT INTO `menus` VALUES ('5', '权限管理', 'fa fa-key', 'http://pershop.oo/admin/role', '1', '3', '1', '2018-02-12 15:56:34', '2018-02-12 15:56:34');
INSERT INTO `menus` VALUES ('6', '商品管理', 'fa fa-user', 'http://pershop.oo/admin/role', '0', '1', '1', '2018-02-13 09:20:48', '2018-02-13 09:20:48');
INSERT INTO `menus` VALUES ('7', '添加商品', 'fa fa-key', 'http://pershop.oo/admin/goods', '6', '10', '1', '2018-02-13 16:17:14', '2018-02-13 16:17:14');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('45', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('46', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('47', '2018_02_10_080523_create_admins_table', '1');
INSERT INTO `migrations` VALUES ('48', '2018_02_11_085214_entrust_setup_tables', '1');
INSERT INTO `migrations` VALUES ('49', '2018_02_12_054132_create_menu_table', '2');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'admin.system.sign_in', '登录后台', '登录后台', '2018-02-11 09:18:09', '2018-02-11 09:18:09');
INSERT INTO `permissions` VALUES ('2', 'admin.menus.list', '菜单列表', '菜单列表', '2018-02-11 09:18:09', '2018-02-11 09:18:09');
INSERT INTO `permissions` VALUES ('3', 'admin.menus.add', '添加菜单', '添加菜单', '2018-02-11 09:18:09', '2018-02-11 09:18:09');
INSERT INTO `permissions` VALUES ('4', 'admin.menus.edit', '修改菜单', '修改菜单', '2018-02-11 09:18:09', '2018-02-11 09:18:09');
INSERT INTO `permissions` VALUES ('5', 'admin.menus.delete', '删除菜单', '删除菜单', '2018-02-11 09:18:09', '2018-02-11 09:18:09');

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('1', '1');
INSERT INTO `permission_role` VALUES ('2', '1');
INSERT INTO `permission_role` VALUES ('3', '1');
INSERT INTO `permission_role` VALUES ('4', '1');
INSERT INTO `permission_role` VALUES ('5', '1');
INSERT INTO `permission_role` VALUES ('1', '2');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'admin', '超级管理员', 'User is allowed to manage and edit other users', '2018-02-11 09:18:09', '2018-02-11 09:18:09');
INSERT INTO `roles` VALUES ('2', 'user', '普通管理员', 'User is the owner of a given project', '2018-02-11 09:18:09', '2018-02-11 09:18:09');

-- ----------------------------
-- Table structure for role_admin
-- ----------------------------
DROP TABLE IF EXISTS `role_admin`;
CREATE TABLE `role_admin` (
  `admin_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`admin_id`,`role_id`),
  KEY `role_admin_role_id_foreign` (`role_id`),
  CONSTRAINT `role_admin_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_admin_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_admin
-- ----------------------------
INSERT INTO `role_admin` VALUES ('1', '1');
INSERT INTO `role_admin` VALUES ('2', '2');
INSERT INTO `role_admin` VALUES ('3', '2');
INSERT INTO `role_admin` VALUES ('4', '2');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'lemon', 'Neoma', 'lemon@163.com', '$2y$10$kToh4I1oHkz9ztgyeT/1DuRW9kibpYbNEpTw7/Ka3h2CFoOO0fFEK', 'fYvWSlEBkK', '2018-02-11 09:18:09', '2018-02-11 09:18:09');
INSERT INTO `users` VALUES ('2', 'Bertram Adams I', 'Kendall', 'sporer.chaim@example.org', '$2y$10$xCwn7cv3cdfWr1OnHns/LelZsFP5kyWAD1kGuhZAsRPnFAkBgT7U6', 'YCOjwdpA9f', '2018-02-11 09:18:09', '2018-02-11 09:18:09');
INSERT INTO `users` VALUES ('3', 'Prof. Brisa Turner Sr.', 'Rosa', 'vyundt@example.org', '$2y$10$xCwn7cv3cdfWr1OnHns/LelZsFP5kyWAD1kGuhZAsRPnFAkBgT7U6', 'UcfgvxVdas', '2018-02-11 09:18:09', '2018-02-11 09:18:09');
INSERT INTO `users` VALUES ('4', 'Mrs. Yasmine Harvey II', 'Liliane', 'ezequiel.denesik@example.org', '$2y$10$xCwn7cv3cdfWr1OnHns/LelZsFP5kyWAD1kGuhZAsRPnFAkBgT7U6', 'ZuMl7FgL79', '2018-02-11 09:18:09', '2018-02-11 09:18:09');
