/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50644
 Source Host           : localhost:3306
 Source Schema         : keyi

 Target Server Type    : MySQL
 Target Server Version : 50644
 File Encoding         : 65001

 Date: 12/01/2021 10:11:31
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ky_files
-- ----------------------------
DROP TABLE IF EXISTS `ky_files`;
CREATE TABLE `ky_files`  (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '文件名称',
  `urls` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '链接地址',
  `http_urls` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT ' 带域名的地址',
  `creat_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT ' 上传者',
  `creat_time` datetime NULL DEFAULT NULL COMMENT ' 上传时间',
  `oss` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT ' 存储位置',
  `type` int(255) NULL DEFAULT NULL COMMENT ' 文件类型',
  `f_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT ' 文件类型',
  PRIMARY KEY (`fid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of ky_files
-- ----------------------------
INSERT INTO `ky_files` VALUES (24, '5ff5665c1926d.jpg', '/storage/jpg/5ff5665c1926d.jpg', 'http://127.0.0.1:8000/storage/jpg/5ff5665c1926d.jpg', 'admins', '2021-01-06 15:27:24', '本地', 0, 'jpg');
INSERT INTO `ky_files` VALUES (25, '5ff66b4609058.jpg', '/storage/jpg/5ff66b4609058.jpg', 'http://127.0.0.1:8000/storage/jpg/5ff66b4609058.jpg', 'admins', '2021-01-07 10:00:38', '本地', 0, 'jpg');
INSERT INTO `ky_files` VALUES (26, '5ff66b4c5f4de.jpg', '/storage/jpg/5ff66b4c5f4de.jpg', 'http://127.0.0.1:8000/storage/jpg/5ff66b4c5f4de.jpg', 'admins', '2021-01-07 10:00:44', '本地', 0, 'jpg');
INSERT INTO `ky_files` VALUES (27, '5ffbf99d5367d.jpg', '/storage/jpg/5ffbf99d5367d.jpg', 'http://127.0.0.1:8000/storage/jpg/5ffbf99d5367d.jpg', 'admins', '2021-01-11 15:09:17', '本地', 0, 'jpg');
INSERT INTO `ky_files` VALUES (28, '5ffbf99d68b1b.jpg', '/storage/jpg/5ffbf99d68b1b.jpg', 'http://127.0.0.1:8000/storage/jpg/5ffbf99d68b1b.jpg', 'admins', '2021-01-11 15:09:17', '本地', 0, 'jpg');
INSERT INTO `ky_files` VALUES (29, '5ffbf9a154f56.jpg', '/storage/jpg/5ffbf9a154f56.jpg', 'http://127.0.0.1:8000/storage/jpg/5ffbf9a154f56.jpg', 'admins', '2021-01-11 15:09:21', '本地', 0, 'jpg');
INSERT INTO `ky_files` VALUES (31, '5ffc0331070e2.jpg', '/storage/jpg/5ffc0331070e2.jpg', 'http://127.0.0.1:8000/storage/jpg/5ffc0331070e2.jpg', 'admins', '2021-01-11 15:50:09', '本地', 0, 'jpg');
INSERT INTO `ky_files` VALUES (34, '5ffc03740a3b5.jpg', '/storage/jpg/5ffc03740a3b5.jpg', 'http://127.0.0.1:8000/storage/jpg/5ffc03740a3b5.jpg', 'admins', '2021-01-11 15:51:16', '本地', 0, 'jpg');
INSERT INTO `ky_files` VALUES (36, '5ffc091ebfce7.jpg', '/storage/jpg/5ffc091ebfce7.jpg', 'http://127.0.0.1:8000/storage/jpg/5ffc091ebfce7.jpg', 'admins', '2021-01-11 16:15:26', '本地', 0, 'jpg');
INSERT INTO `ky_files` VALUES (37, '5ffc09488360b.jpg', '/storage/jpg/5ffc09488360b.jpg', 'http://127.0.0.1:8000/storage/jpg/5ffc09488360b.jpg', 'admins', '2021-01-11 16:16:08', '本地', 0, 'jpg');
INSERT INTO `ky_files` VALUES (38, '5ffc094d5bb16.jpg', '/storage/jpg/5ffc094d5bb16.jpg', 'http://127.0.0.1:8000/storage/jpg/5ffc094d5bb16.jpg', 'admins', '2021-01-11 16:16:13', '本地', 0, 'jpg');

-- ----------------------------
-- Table structure for ky_files_set
-- ----------------------------
DROP TABLE IF EXISTS `ky_files_set`;
CREATE TABLE `ky_files_set`  (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `allowExts` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '允许上传的类型 ',
  `fileSize` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT ' 上传大小',
  `q_accessKey` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '七牛云access',
  `q_secretKey` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '七牛云key',
  `q_bucket` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '七牛云空间',
  `q_domain` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT ' 七牛云绑定域名',
  `a_accessKeyId` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '阿里云ID',
  `a_accessKeySecret` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '阿里云KEY',
  `a_bucket` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '空间名称 ',
  `a_domain` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '访问域名',
  `files_ares` int(11) NULL DEFAULT 0 COMMENT '存储位置',
  `t_secretId` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '腾讯云ID',
  `t_secretKey` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '腾讯云密钥',
  `t_region` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '存储桶',
  `t_appid` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT ' appID',
  `t_bucket` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '名称',
  PRIMARY KEY (`sid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of ky_files_set
-- ----------------------------
INSERT INTO `ky_files_set` VALUES (1, 'png,jpg,txt,doc,xls', '19285000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for ky_sys_dept
-- ----------------------------
DROP TABLE IF EXISTS `ky_sys_dept`;
CREATE TABLE `ky_sys_dept`  (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '部门名称',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '上级ID',
  `remarks` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '备注',
  `creat_time` datetime NOT NULL COMMENT '创建时间',
  `creat_by` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '创建者',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `update_by` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '修改者',
  `order_by` int(255) NULL DEFAULT 100 COMMENT '排序',
  PRIMARY KEY (`dept_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of ky_sys_dept
-- ----------------------------
INSERT INTO `ky_sys_dept` VALUES (8, '柯一网络有限公司', 0, NULL, '2021-01-06 11:20:41', 'admins', NULL, NULL, 100);
INSERT INTO `ky_sys_dept` VALUES (9, '行政部', 8, NULL, '2021-01-06 11:20:46', 'admins', NULL, NULL, 100);
INSERT INTO `ky_sys_dept` VALUES (10, '技术部', 8, NULL, '2021-01-06 11:20:53', 'admins', NULL, NULL, 100);
INSERT INTO `ky_sys_dept` VALUES (11, '销售部', 8, NULL, '2021-01-06 11:20:58', 'admins', NULL, NULL, 100);
INSERT INTO `ky_sys_dept` VALUES (12, 'JAVA项目部', 10, NULL, '2021-01-06 11:21:13', 'admins', NULL, NULL, 100);

-- ----------------------------
-- Table structure for ky_sys_member
-- ----------------------------
DROP TABLE IF EXISTS `ky_sys_member`;
CREATE TABLE `ky_sys_member`  (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '账号名称',
  `nick_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '妮称',
  `password` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '密码',
  `face` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '头像地址',
  `login_ip` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '登录IP',
  `creat_time` datetime NOT NULL COMMENT '创建时间',
  `creat_by` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '创建者名字',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `update_by` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '修改者名字',
  `login_num` int(11) NULL DEFAULT 0 COMMENT '登录次数',
  `phone` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '手机号码 ',
  `status` int(255) NULL DEFAULT 0 COMMENT '0禁用，1启用',
  `dept_id` int(11) NULL DEFAULT NULL COMMENT '所属部门',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of ky_sys_member
-- ----------------------------
INSERT INTO `ky_sys_member` VALUES (1, 'admins', 'Mr.He', '619cf12c5fe33ced4a99b19079c292e2', 'http://127.0.0.1:8000/storage/jpg/5ffc09488360b.jpg', '127.0.0.1', '2021-01-03 11:05:08', 'admins', '2021-01-11 22:09:59', 'admins', 1, '18223830067', 1, NULL);

-- ----------------------------
-- Table structure for ky_sys_member_role
-- ----------------------------
DROP TABLE IF EXISTS `ky_sys_member_role`;
CREATE TABLE `ky_sys_member_role`  (
  `uid` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of ky_sys_member_role
-- ----------------------------
INSERT INTO `ky_sys_member_role` VALUES (1, 1);

-- ----------------------------
-- Table structure for ky_sys_menu
-- ----------------------------
DROP TABLE IF EXISTS `ky_sys_menu`;
CREATE TABLE `ky_sys_menu`  (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '菜单名称',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '上级ID',
  `creat_time` datetime NOT NULL COMMENT '创建时间',
  `creat_by` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '创建者',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `update_by` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '修改者',
  `order_by` int(255) NULL DEFAULT NULL COMMENT '排序',
  `path` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '路由地址',
  `component` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '组件路径',
  `type` int(255) NOT NULL DEFAULT 0 COMMENT '菜单类型（0目录 1菜单2按钮）',
  `visible` int(1) NOT NULL DEFAULT 0 COMMENT '菜单状态（0显示 1隐藏）',
  `status` int(1) NOT NULL COMMENT '菜单状态（0正常 1停用）',
  `perms` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '权限标识',
  `icon` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '菜单图标',
  `is_frame` int(10) NULL DEFAULT 1 COMMENT '是否为外链（0是 1否）',
  PRIMARY KEY (`menu_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of ky_sys_menu
-- ----------------------------
INSERT INTO `ky_sys_menu` VALUES (1, '系统设置', 0, '2021-01-03 15:20:31', 'admins', NULL, NULL, 1, 'sys', NULL, 0, 0, 0, NULL, 'fa fa-asterisk', 1);
INSERT INTO `ky_sys_menu` VALUES (2, '菜单管理', 1, '2021-01-03 15:24:58', 'admins', NULL, NULL, 2, 'menu', 'system/menu/index', 1, 0, 0, 'sys:menu:index', 'fa fa-asterisk', 1);
INSERT INTO `ky_sys_menu` VALUES (3, '添加菜单', 2, '2021-01-03 16:59:04', 'admins', NULL, NULL, 1, NULL, NULL, 2, 0, 0, 'sys:menu:add', NULL, 1);
INSERT INTO `ky_sys_menu` VALUES (4, '修改菜单', 2, '2021-01-03 17:00:14', 'admins', NULL, NULL, 2, NULL, NULL, 2, 0, 0, 'sys:menu:edit', NULL, 1);
INSERT INTO `ky_sys_menu` VALUES (5, '删除菜单', 2, '2021-01-03 17:00:33', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'sys:menu:del', NULL, 1);
INSERT INTO `ky_sys_menu` VALUES (6, '修改排序', 2, '2021-01-03 20:52:15', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'sys:menu:orderby', NULL, 1);
INSERT INTO `ky_sys_menu` VALUES (7, '修改状态', 2, '2021-01-03 20:52:36', 'admins', '2021-01-03 21:10:11', 'admins', 100, NULL, NULL, 2, 0, 0, 'sys:menu:stauts', NULL, 1);
INSERT INTO `ky_sys_menu` VALUES (8, '角色管理', 1, '2021-01-03 21:53:41', 'admins', NULL, NULL, 100, 'role', 'system/role/index', 1, 0, 0, 'sys:role:index', 'fa fa-user-plus', 1);
INSERT INTO `ky_sys_menu` VALUES (9, '添加角色', 8, '2021-01-03 23:38:49', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'sys:role:add', NULL, 1);
INSERT INTO `ky_sys_menu` VALUES (10, '修改角色', 8, '2021-01-03 23:39:06', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'sys:role:edit', NULL, 1);
INSERT INTO `ky_sys_menu` VALUES (11, '删除角色', 8, '2021-01-03 23:39:22', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'sys:role:del', NULL, 1);
INSERT INTO `ky_sys_menu` VALUES (12, '系统工具', 0, '2021-01-03 23:51:43', 'admins', NULL, NULL, 100, 'tool', NULL, 0, 0, 0, NULL, 'fa fa-viacoin', 1);
INSERT INTO `ky_sys_menu` VALUES (13, '代码生成', 12, '2021-01-03 23:52:43', 'admins', NULL, NULL, 2, 'gen', 'tool/gen/index', 1, 0, 0, 'tool:gen:index', 'fa fa-location-arrow', 1);
INSERT INTO `ky_sys_menu` VALUES (14, '数据管理', 12, '2021-01-04 00:00:18', 'admins', NULL, NULL, 1, 'datas', 'tool/data/index', 1, 0, 0, 'tool:data:index', 'fa fa-server', 1);
INSERT INTO `ky_sys_menu` VALUES (15, '管理员管理', 1, '2021-01-06 10:41:30', 'admins', '2021-01-06 10:42:22', 'admins', 100, 'member', 'system/member/index', 1, 0, 0, 'sys:member:index', 'fa fa-group', 1);
INSERT INTO `ky_sys_menu` VALUES (16, '部门管理', 1, '2021-01-06 10:45:40', 'admins', NULL, NULL, 3, 'dept', 'system/dept/index', 1, 0, 0, 'sys:dept:index', 'fa fa-slideshare', 1);
INSERT INTO `ky_sys_menu` VALUES (17, '文件管理', 0, '2021-01-06 12:01:08', 'admins', NULL, NULL, 2, 'files', NULL, 0, 0, 0, NULL, 'fa fa-leanpub', 1);
INSERT INTO `ky_sys_menu` VALUES (18, '文件配置', 17, '2021-01-06 12:02:17', 'admins', NULL, NULL, 100, 'fielset', 'files/set', 1, 0, 0, 'files:set', 'fa fa-file-code-o', 1);
INSERT INTO `ky_sys_menu` VALUES (19, '文件列表', 17, '2021-01-06 14:11:58', 'admins', '2021-01-11 20:28:27', 'admins', 100, 'filesindex', 'files/index', 1, 0, 0, 'files:index', 'fa fa-leanpub', 1);
INSERT INTO `ky_sys_menu` VALUES (20, '删除文件', 19, '2021-01-11 09:55:02', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'files:del', NULL, 1);
INSERT INTO `ky_sys_menu` VALUES (21, '上传文件', 19, '2021-01-11 09:56:05', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'files:upload', NULL, 1);

-- ----------------------------
-- Table structure for ky_sys_role
-- ----------------------------
DROP TABLE IF EXISTS `ky_sys_role`;
CREATE TABLE `ky_sys_role`  (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '角色名称',
  `creat_time` datetime NOT NULL COMMENT '创建时间',
  `creat_by` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '创建者',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `update_by` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '修改者',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0启用，1禁用',
  `order_by` int(255) NULL DEFAULT 100 COMMENT '排序 ',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of ky_sys_role
-- ----------------------------
INSERT INTO `ky_sys_role` VALUES (1, '超级管理员', '2021-01-03 12:13:40', 'admins', NULL, NULL, 0, 100, NULL);
INSERT INTO `ky_sys_role` VALUES (6, '管理员', '2021-01-03 23:17:55', 'admins', '2021-01-03 23:37:56', 'admins', 0, 100, '系统管理员部分权限');

-- ----------------------------
-- Table structure for ky_sys_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `ky_sys_role_menu`;
CREATE TABLE `ky_sys_role_menu`  (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of ky_sys_role_menu
-- ----------------------------
INSERT INTO `ky_sys_role_menu` VALUES (6, 3);
INSERT INTO `ky_sys_role_menu` VALUES (6, 4);
INSERT INTO `ky_sys_role_menu` VALUES (6, 5);
INSERT INTO `ky_sys_role_menu` VALUES (6, 8);
INSERT INTO `ky_sys_role_menu` VALUES (6, 0);
INSERT INTO `ky_sys_role_menu` VALUES (6, 1);
INSERT INTO `ky_sys_role_menu` VALUES (6, 2);

-- ----------------------------
-- Table structure for ky_ttest
-- ----------------------------
DROP TABLE IF EXISTS `ky_ttest`;
CREATE TABLE `ky_ttest`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '名称',
  `type` int(255) NULL DEFAULT NULL COMMENT '类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ky_ttest
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
