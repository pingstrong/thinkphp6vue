/*
 Navicat Premium Data Transfer

 Source Server         : 192.168.0.198（mariadb）
 Source Server Type    : MySQL
 Source Server Version : 101102
 Source Host           : 192.168.88.198:3306
 Source Schema         : keyiadmin

 Target Server Type    : MySQL
 Target Server Version : 101102
 File Encoding         : 65001

 Date: 22/07/2023 21:44:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for pg_article_category
-- ----------------------------
DROP TABLE IF EXISTS `pg_article_category`;
CREATE TABLE `pg_article_category`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '标题',
  `thumb` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '缩略图',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_content_article_cate_deleted_at`(`deleted_at`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pg_article_category
-- ----------------------------
INSERT INTO `pg_article_category` VALUES (3, '2023-07-22 17:28:53', '2023-07-22 17:28:53', NULL, 'dtest', 'http://www.backend.cc/storage/png/64bb7a53c82d8.png');

-- ----------------------------
-- Table structure for pg_article_content
-- ----------------------------
DROP TABLE IF EXISTS `pg_article_content`;
CREATE TABLE `pg_article_content`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '标题',
  `thumb` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '缩略图',
  `cate_id` bigint NULL DEFAULT NULL COMMENT '所属分类',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '内容详情',
  `state` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `sortid` bigint NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_content_article_deleted_at`(`deleted_at`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pg_article_content
-- ----------------------------
INSERT INTO `pg_article_content` VALUES (3, NULL, NULL, NULL, '血战到底，巴赫穆特遭弹雨覆盖烈焰滚滚：车臣突击部队也顶不住了', 'http://www.backend.cc/storage/gif/64bb76e212cd2.gif', 3, '<p>深夜的巴赫穆特市区烈阳滚滚，乌军冰雹火箭炮开始对巴赫穆特市区俄军目标展开第一轮覆盖性轰击。俄军炮兵与乌军炮兵迅速爆发炮战，在战斗当中，乌军第3亚速突击旅呼叫火力支援，海马斯摧毁俄军阵地一门俄军最强240毫米口径超重型自行迫击炮。<br/></p>', 1, 88);
INSERT INTO `pg_article_content` VALUES (4, NULL, NULL, NULL, '我成了全村第一个开拖拉机的女生', 'http://www.backend.cc/storage/png/64bb76f40b8e5.png', 3, '<p>我成了全村第一个开拖拉机的女生</p><p>【#我成了全村第一个开拖拉机的女生#】 #你会为了家人回村上班么# 安徽亳州，24岁女生姜晓娜在城里做了4年美甲师，去年她辞职回家学开收割机，成了村里第一个会开农机的女生。农忙季节，她5点起床收麦子，最多一天收100亩地。姜晓娜说：其实收麦子收入不高，但“比做100副美甲更有成就感”。@田野视频<br/></p>', 0, 12);

-- ----------------------------
-- Table structure for pg_files
-- ----------------------------
DROP TABLE IF EXISTS `pg_files`;
CREATE TABLE `pg_files`  (
  `fid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '文件名称',
  `urls` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '链接地址',
  `http_urls` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT ' 带域名的地址',
  `creat_by` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT ' 上传者',
  `creat_time` datetime NULL DEFAULT NULL COMMENT ' 上传时间',
  `oss` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT ' 存储位置',
  `type` int NULL DEFAULT NULL COMMENT ' 文件类型',
  `f_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT ' 文件类型',
  `f_size` int NULL DEFAULT 0 COMMENT '文件大小字节',
  PRIMARY KEY (`fid`) USING BTREE,
  INDEX `type`(`type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of pg_files
-- ----------------------------
INSERT INTO `pg_files` VALUES (27, '5ffbf99d5367d.jpg', '/storage/jpg/5ffbf99d5367d.jpg', 'http://pic.imeitou.com/uploads/allimg/230720/10-230H01AI2-lp.png', 'admins', '2021-01-11 15:09:17', '本地', 0, 'jpg', 0);
INSERT INTO `pg_files` VALUES (46, '64bb7340f30dd.gif', '/storage/gif/64bb7340f30dd.gif', 'http://www.backend.cc/storage/gif/64bb7340f30dd.gif', 'admins', '2023-07-22 14:12:16', '本地', 0, 'gif', 24056);
INSERT INTO `pg_files` VALUES (47, '64bb76e212cd2.gif', '/storage/gif/64bb76e212cd2.gif', 'http://www.backend.cc/storage/gif/64bb76e212cd2.gif', 'admins', '2023-07-22 14:27:46', '本地', 0, 'gif', 61863);
INSERT INTO `pg_files` VALUES (48, '64bb76f40b8e5.png', '/storage/png/64bb76f40b8e5.png', 'http://www.backend.cc/storage/png/64bb76f40b8e5.png', 'admins', '2023-07-22 14:28:04', '本地', 0, 'png', 491370);
INSERT INTO `pg_files` VALUES (49, '64bb773f6f93e.txt', '/storage/txt/64bb773f6f93e.txt', 'http://www.backend.cc/storage/txt/64bb773f6f93e.txt', 'admins', '2023-07-22 14:29:19', '本地', 3000, 'txt', 4460807);
INSERT INTO `pg_files` VALUES (50, 'QQ图片20170720112913.jpg', '/storage/jpg/64bb78970a1af.jpg', 'http://www.backend.cc/storage/jpg/64bb78970a1af.jpg', 'admins', '2023-07-22 14:35:03', '本地', 0, 'jpg', 5570);
INSERT INTO `pg_files` VALUES (51, '微信截图_20181027142412.png', '/storage/png/64bb7a53c82d8.png', 'http://www.backend.cc/storage/png/64bb7a53c82d8.png', 'admins', '2023-07-22 14:42:27', '本地', 0, 'png', 724229);

-- ----------------------------
-- Table structure for pg_files_set
-- ----------------------------
DROP TABLE IF EXISTS `pg_files_set`;
CREATE TABLE `pg_files_set`  (
  `sid` int NOT NULL AUTO_INCREMENT,
  `allowExts` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL COMMENT '允许上传的类型 ',
  `fileSize` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL COMMENT ' 上传大小',
  `q_accessKey` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '七牛云access',
  `q_secretKey` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '七牛云key',
  `q_bucket` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '七牛云空间',
  `q_domain` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT ' 七牛云绑定域名',
  `a_accessKeyId` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '阿里云ID',
  `a_accessKeySecret` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '阿里云KEY',
  `a_bucket` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '空间名称 ',
  `a_domain` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '访问域名',
  `files_ares` int NULL DEFAULT 0 COMMENT '存储位置',
  `t_secretId` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '腾讯云ID',
  `t_secretKey` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '腾讯云密钥',
  `t_region` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '存储桶',
  `t_appid` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT ' appID',
  `t_bucket` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '名称',
  PRIMARY KEY (`sid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of pg_files_set
-- ----------------------------
INSERT INTO `pg_files_set` VALUES (1, 'png,jpg,txt,doc,xls,gif,jpeg,txt', '19285000', 'aaaaaaaaaaa', 'bbbbbbbbbb', 'static', 'xxx.com', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for pg_setting
-- ----------------------------
DROP TABLE IF EXISTS `pg_setting`;
CREATE TABLE `pg_setting`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `skey` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '数据键标识',
  `title` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '标题',
  `item` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '数据项名称',
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '数据值',
  `type` enum('text','image','radio','checkbox','editor','file','textarea','images','files','switch','select') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'text',
  `metadata` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '元数据',
  `state` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `listsort` bigint NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_setting_deleted_at`(`deleted_at`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pg_setting
-- ----------------------------
INSERT INTO `pg_setting` VALUES (1, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'web', '网站名称', 'name', 'sad特斯拉', 'text', '', 1, 0);
INSERT INTO `pg_setting` VALUES (2, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'web', 'logo', 'logo', '\"http:\\/\\/www.backend.cc\\/storage\\/gif\\/64bb76e212cd2.gif\"', 'image', '', 1, 0);
INSERT INTO `pg_setting` VALUES (3, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'web', '公司宣传图', 'company_img', '[\"http:\\/\\/pic.imeitou.com\\/uploads\\/allimg\\/230718\\/10-230GQG543-lp.jpg\",\"http:\\/\\/pic.imeitou.com\\/uploads\\/allimg\\/230720\\/10-230H01AI2-lp.png\",\"http:\\/\\/www.backend.cc\\/storage\\/png\\/64bb7325d5c48.png\"]', 'images', '', 1, 0);
INSERT INTO `pg_setting` VALUES (4, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'web', '站点描述', 'description', '', 'textarea', '', 1, 0);
INSERT INTO `pg_setting` VALUES (5, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'web', '站点版权', 'copyright', '', 'text', '', 1, 0);
INSERT INTO `pg_setting` VALUES (6, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'web', '站点状态', 'isopen', '1', 'radio', '[{\"label\":0,\"title\":\"开启\"},{\"label\":1,\"title\":\"关闭\"}]', 1, 0);
INSERT INTO `pg_setting` VALUES (7, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'web', '公司分布', 'inc_address', '[\"\\u6df1\\u5733\",\"\\u5e7f\\u5dde\"]', 'checkbox', '[\"广州\", \"深圳\", \"上海\", \"北京\"]', 1, 0);
INSERT INTO `pg_setting` VALUES (8, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'web', 'app下载地址', 'app_downlink', 'http://www.backend.cc/storage/txt/64bb773f6f93e.txt', 'file', '', 1, 0);
INSERT INTO `pg_setting` VALUES (9, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'web', '服务政策', 'protocol', '<p><b><font color=\"#c24f4a\">asfdasdf222</font></b></p>', 'editor', '', 1, 0);
INSERT INTO `pg_setting` VALUES (10, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'web', '隐私协议', 'privacy', '<p>asdfasdasdfasdf</p>', 'editor', '', 1, 0);
INSERT INTO `pg_setting` VALUES (11, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'web', '商城状态', 'shop_status', '1', 'switch', '', 1, 0);
INSERT INTO `pg_setting` VALUES (12, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'kefu', '联系电话', 'mobile', '0', 'text', '', 1, 2);
INSERT INTO `pg_setting` VALUES (13, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'kefu', '联系人', 'concat_user', '0', 'text', '', 1, 1);
INSERT INTO `pg_setting` VALUES (14, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'payment', '公众号appid', 'wechat_app_id', 'a2222', 'text', '', 1, 0);
INSERT INTO `pg_setting` VALUES (15, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'payment', '微信商户号', 'wechat_mchid', '6786786', 'text', '', 1, 0);
INSERT INTO `pg_setting` VALUES (16, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'payment', '微信商户Key', 'wechat_key', '123123123123asfasfdasdf', 'text', '', 1, 0);
INSERT INTO `pg_setting` VALUES (17, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'payment', '微信证书apiclient_cert', 'wechat_apiclient_cert', 'http://www.backend.cc/storage/gif/64bb7340f30dd.gif', 'file', '', 1, 0);
INSERT INTO `pg_setting` VALUES (18, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'payment', '微信证书apiclient_key', 'wechat_apiclient_key', '0', 'file', '', 1, 0);
INSERT INTO `pg_setting` VALUES (19, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'sms', '签名', 'sign', 'asdfasdf', 'text', '', 1, 0);
INSERT INTO `pg_setting` VALUES (20, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'sms', '模板ID', 'template_id', '2222', 'text', '', 1, 0);
INSERT INTO `pg_setting` VALUES (21, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'promotion', '一级佣金', 'commission1', '0', 'text', '', 1, 0);
INSERT INTO `pg_setting` VALUES (22, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'promotion', '二级佣金', 'commission2', '0', 'text', '', 1, 0);
INSERT INTO `pg_setting` VALUES (23, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'promotion', '三级级佣金', 'commission3', '0', 'text', '', 1, 0);
INSERT INTO `pg_setting` VALUES (24, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'withdraw', '最低提现', 'low_money', '0', 'text', '', 1, 0);
INSERT INTO `pg_setting` VALUES (25, '2022-07-06 15:54:23', '2022-07-06 15:54:23', NULL, 'withdraw', '提现说明', 'detail', '0', 'editor', '', 1, 0);

-- ----------------------------
-- Table structure for pg_sys_dept
-- ----------------------------
DROP TABLE IF EXISTS `pg_sys_dept`;
CREATE TABLE `pg_sys_dept`  (
  `dept_id` int NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL COMMENT '部门名称',
  `parent_id` int NOT NULL DEFAULT 0 COMMENT '上级ID',
  `remarks` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '备注',
  `creat_time` datetime NOT NULL COMMENT '创建时间',
  `creat_by` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '创建者',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `update_by` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '修改者',
  `order_by` int NULL DEFAULT 100 COMMENT '排序',
  PRIMARY KEY (`dept_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of pg_sys_dept
-- ----------------------------
INSERT INTO `pg_sys_dept` VALUES (8, '柯一网络有限公司', 0, NULL, '2021-01-06 11:20:41', 'admins', NULL, NULL, 100);
INSERT INTO `pg_sys_dept` VALUES (9, '行政部', 8, NULL, '2021-01-06 11:20:46', 'admins', NULL, NULL, 100);
INSERT INTO `pg_sys_dept` VALUES (10, '技术部', 8, NULL, '2021-01-06 11:20:53', 'admins', NULL, NULL, 100);
INSERT INTO `pg_sys_dept` VALUES (11, '销售部', 8, NULL, '2021-01-06 11:20:58', 'admins', NULL, NULL, 100);
INSERT INTO `pg_sys_dept` VALUES (12, 'JAVA项目部', 10, NULL, '2021-01-06 11:21:13', 'admins', NULL, NULL, 100);
INSERT INTO `pg_sys_dept` VALUES (13, '市场部', 0, NULL, '2023-07-19 13:52:33', 'admins', NULL, NULL, 100);

-- ----------------------------
-- Table structure for pg_sys_member
-- ----------------------------
DROP TABLE IF EXISTS `pg_sys_member`;
CREATE TABLE `pg_sys_member`  (
  `uid` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL COMMENT '账号名称',
  `nick_name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '妮称',
  `password` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL COMMENT '密码',
  `face` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '头像地址',
  `login_ip` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '登录IP',
  `creat_time` datetime NOT NULL COMMENT '创建时间',
  `creat_by` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '创建者名字',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `update_by` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '修改者名字',
  `login_num` int NULL DEFAULT 0 COMMENT '登录次数',
  `phone` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '手机号码 ',
  `status` int NULL DEFAULT 0 COMMENT '0禁用，1启用',
  `dept_id` int NULL DEFAULT NULL COMMENT '所属部门',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of pg_sys_member
-- ----------------------------
INSERT INTO `pg_sys_member` VALUES (1, 'admins', '阿斯蒂芬', '619cf12c5fe33ced4a99b19079c292e2', 'http://www.backend.cc/storage/png/64bb7a53c82d8.png', '127.0.0.1', '2021-01-03 11:05:08', 'admins', '2021-01-11 22:09:59', 'admins', 1, '17787877777', 1, NULL);
INSERT INTO `pg_sys_member` VALUES (2, 'test123', 'test', 'f379eaf3c831b04de153469d1bec345e', 'http://www.backend.cc/storage/gif/64bb76e212cd2.gif', NULL, '2023-07-19 13:54:48', 'admins', '2023-07-22 21:34:24', 'admins', 0, '18888888888', 1, NULL);

-- ----------------------------
-- Table structure for pg_sys_member_role
-- ----------------------------
DROP TABLE IF EXISTS `pg_sys_member_role`;
CREATE TABLE `pg_sys_member_role`  (
  `uid` int NOT NULL,
  `role_id` int NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of pg_sys_member_role
-- ----------------------------
INSERT INTO `pg_sys_member_role` VALUES (1, 1);
INSERT INTO `pg_sys_member_role` VALUES (2, 6);

-- ----------------------------
-- Table structure for pg_sys_menu
-- ----------------------------
DROP TABLE IF EXISTS `pg_sys_menu`;
CREATE TABLE `pg_sys_menu`  (
  `menu_id` int NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL COMMENT '菜单名称',
  `parent_id` int NOT NULL DEFAULT 0 COMMENT '上级ID',
  `creat_time` datetime NOT NULL COMMENT '创建时间',
  `creat_by` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '创建者',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `update_by` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '修改者',
  `order_by` int NULL DEFAULT NULL COMMENT '排序',
  `path` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '路由地址',
  `component` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '组件路径',
  `type` int NOT NULL DEFAULT 0 COMMENT '菜单类型（0目录 1菜单2按钮）',
  `visible` int NOT NULL DEFAULT 0 COMMENT '菜单状态（0显示 1隐藏）',
  `status` int NOT NULL COMMENT '菜单状态（0正常 1停用）',
  `perms` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '权限标识',
  `icon` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '菜单图标',
  `is_frame` int NULL DEFAULT 1 COMMENT '是否为外链（0是 1否）',
  PRIMARY KEY (`menu_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of pg_sys_menu
-- ----------------------------
INSERT INTO `pg_sys_menu` VALUES (1, '系统管理', 0, '2021-01-03 15:20:31', 'admins', '2023-07-19 22:23:57', 'admins', 1, 'sys', NULL, 0, 0, 0, NULL, 'fa fa-asterisk', 1);
INSERT INTO `pg_sys_menu` VALUES (2, '菜单管理', 1, '2021-01-03 15:24:58', 'admins', NULL, NULL, 2, 'menu', 'system/menu/index', 1, 0, 0, 'sys:menu:index', 'fa fa-asterisk', 1);
INSERT INTO `pg_sys_menu` VALUES (3, '添加菜单', 2, '2021-01-03 16:59:04', 'admins', NULL, NULL, 1, NULL, NULL, 2, 0, 0, 'sys:menu:add', NULL, 1);
INSERT INTO `pg_sys_menu` VALUES (4, '修改菜单', 2, '2021-01-03 17:00:14', 'admins', NULL, NULL, 2, NULL, NULL, 2, 0, 0, 'sys:menu:edit', NULL, 1);
INSERT INTO `pg_sys_menu` VALUES (5, '删除菜单', 2, '2021-01-03 17:00:33', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'sys:menu:del', NULL, 1);
INSERT INTO `pg_sys_menu` VALUES (6, '修改排序', 2, '2021-01-03 20:52:15', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'sys:menu:orderby', NULL, 1);
INSERT INTO `pg_sys_menu` VALUES (7, '修改状态', 2, '2021-01-03 20:52:36', 'admins', '2021-01-03 21:10:11', 'admins', 100, NULL, NULL, 2, 0, 0, 'sys:menu:stauts', NULL, 1);
INSERT INTO `pg_sys_menu` VALUES (8, '角色管理', 1, '2021-01-03 21:53:41', 'admins', NULL, NULL, 100, 'role', 'system/role/index', 1, 0, 0, 'sys:role:index', 'fa fa-user-plus', 1);
INSERT INTO `pg_sys_menu` VALUES (9, '添加角色', 8, '2021-01-03 23:38:49', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'sys:role:add', NULL, 1);
INSERT INTO `pg_sys_menu` VALUES (10, '修改角色', 8, '2021-01-03 23:39:06', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'sys:role:edit', NULL, 1);
INSERT INTO `pg_sys_menu` VALUES (11, '删除角色', 8, '2021-01-03 23:39:22', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'sys:role:del', NULL, 1);
INSERT INTO `pg_sys_menu` VALUES (12, '系统工具', 0, '2021-01-03 23:51:43', 'admins', NULL, NULL, 100, 'tool', NULL, 0, 0, 0, NULL, 'fa fa-viacoin', 1);
INSERT INTO `pg_sys_menu` VALUES (13, '代码生成', 12, '2021-01-03 23:52:43', 'admins', NULL, NULL, 2, 'gen', 'tool/gen/index', 1, 0, 0, 'tool:gen:index', 'fa fa-location-arrow', 1);
INSERT INTO `pg_sys_menu` VALUES (14, '数据管理', 12, '2021-01-04 00:00:18', 'admins', NULL, NULL, 1, 'datas', 'tool/data/index', 1, 0, 0, 'tool:data:index', 'fa fa-server', 1);
INSERT INTO `pg_sys_menu` VALUES (15, '管理员管理', 1, '2021-01-06 10:41:30', 'admins', '2021-01-06 10:42:22', 'admins', 100, 'member', 'system/member/index', 1, 0, 0, 'sys:member:index', 'fa fa-group', 1);
INSERT INTO `pg_sys_menu` VALUES (16, '部门管理', 1, '2021-01-06 10:45:40', 'admins', NULL, NULL, 3, 'dept', 'system/dept/index', 1, 0, 0, 'sys:dept:index', 'fa fa-slideshare', 1);
INSERT INTO `pg_sys_menu` VALUES (17, '文件管理', 0, '2021-01-06 12:01:08', 'admins', NULL, NULL, 2, 'files', NULL, 0, 0, 0, NULL, 'fa fa-leanpub', 1);
INSERT INTO `pg_sys_menu` VALUES (18, '文件配置', 17, '2021-01-06 12:02:17', 'admins', NULL, NULL, 100, 'fielset', 'files/set', 1, 0, 0, 'files:set', 'fa fa-file-code-o', 1);
INSERT INTO `pg_sys_menu` VALUES (19, '文件列表', 17, '2021-01-06 14:11:58', 'admins', '2021-01-11 20:28:27', 'admins', 100, 'filesindex', 'files/index', 1, 0, 0, 'files:index', 'fa fa-leanpub', 1);
INSERT INTO `pg_sys_menu` VALUES (20, '删除文件', 19, '2021-01-11 09:55:02', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'files:del', NULL, 1);
INSERT INTO `pg_sys_menu` VALUES (21, '上传文件', 19, '2021-01-11 09:56:05', 'admins', NULL, NULL, 100, NULL, NULL, 2, 0, 0, 'files:upload', NULL, 1);
INSERT INTO `pg_sys_menu` VALUES (22, '文章管理', 0, '2023-07-19 20:09:43', 'admins', NULL, NULL, 100, 'article', NULL, 0, 0, 0, NULL, 'fa fa-th-large', 1);
INSERT INTO `pg_sys_menu` VALUES (23, '文章分类', 22, '2023-07-19 22:20:20', 'admins', NULL, NULL, 100, 'category', 'article/category/index', 1, 0, 0, 'article:category:index', 'fa fa-file-photo-o', 1);
INSERT INTO `pg_sys_menu` VALUES (24, '文章列表', 22, '2023-07-19 22:22:11', 'admins', NULL, NULL, 100, 'content', 'article/content/index', 1, 0, 0, 'article:content:index', 'fa fa-server', 1);
INSERT INTO `pg_sys_menu` VALUES (25, '配置管理', 0, '2023-07-19 22:26:21', 'admins', '2023-07-21 18:39:23', 'admins', 100, 'setting', '', 0, 0, 0, '', 'fa fa-leanpub', 1);
INSERT INTO `pg_sys_menu` VALUES (26, '常规配置', 25, '2023-07-21 18:42:03', 'admins', NULL, NULL, 100, 'base', 'setting/base/index', 1, 0, 0, 'setting:base:index', 'fa fa-bookmark', 1);
INSERT INTO `pg_sys_menu` VALUES (27, '营销配置', 25, '2023-07-21 18:42:44', 'admins', NULL, NULL, 100, 'marketing', 'setting/marketing/index', 1, 0, 0, 'setting:marketing:index', 'fa fa-binoculars', 1);

-- ----------------------------
-- Table structure for pg_sys_role
-- ----------------------------
DROP TABLE IF EXISTS `pg_sys_role`;
CREATE TABLE `pg_sys_role`  (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL COMMENT '角色名称',
  `creat_time` datetime NOT NULL COMMENT '创建时间',
  `creat_by` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '创建者',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `update_by` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '修改者',
  `status` int NOT NULL DEFAULT 0 COMMENT '0启用，1禁用',
  `order_by` int NULL DEFAULT 100 COMMENT '排序 ',
  `remarks` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of pg_sys_role
-- ----------------------------
INSERT INTO `pg_sys_role` VALUES (1, '超级管理员', '2021-01-03 12:13:40', 'admins', NULL, NULL, 0, 100, NULL);
INSERT INTO `pg_sys_role` VALUES (6, '管理员', '2021-01-03 23:17:55', 'admins', '2021-01-03 23:37:56', 'admins', 0, 100, '系统管理员部分权限');

-- ----------------------------
-- Table structure for pg_sys_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `pg_sys_role_menu`;
CREATE TABLE `pg_sys_role_menu`  (
  `role_id` int NOT NULL,
  `menu_id` int NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of pg_sys_role_menu
-- ----------------------------
INSERT INTO `pg_sys_role_menu` VALUES (6, 3);
INSERT INTO `pg_sys_role_menu` VALUES (6, 4);
INSERT INTO `pg_sys_role_menu` VALUES (6, 5);
INSERT INTO `pg_sys_role_menu` VALUES (6, 8);
INSERT INTO `pg_sys_role_menu` VALUES (6, 0);
INSERT INTO `pg_sys_role_menu` VALUES (6, 1);
INSERT INTO `pg_sys_role_menu` VALUES (6, 2);

-- ----------------------------
-- Table structure for pg_ttest
-- ----------------------------
DROP TABLE IF EXISTS `pg_ttest`;
CREATE TABLE `pg_ttest`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL COMMENT '名称',
  `type` int NULL DEFAULT NULL COMMENT '类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of pg_ttest
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
