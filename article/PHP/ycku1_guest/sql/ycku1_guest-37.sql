-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2014 年 10 月 28 日 09:51
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ycku1_guest`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `message`
-- 

CREATE TABLE `message` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'id',
  `touser` varchar(20) NOT NULL COMMENT '收件人',
  `fromuser` varchar(20) NOT NULL COMMENT '发件人',
  `content` varchar(200) NOT NULL COMMENT '发信内容',
  `date` datetime NOT NULL COMMENT '发信时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- 
-- 导出表中的数据 `message`
-- 

INSERT INTO `message` VALUES (1, '129', '101', '11松岛枫松岛枫松岛枫松岛枫公分高', '2014-10-27 23:18:03');
INSERT INTO `message` VALUES (2, '119', '101', '22fsdfsssdsdfsdfsdfsdfsdfsdfsf', '2014-10-27 23:19:09');
INSERT INTO `message` VALUES (3, '130', '101', '333fsdfsdfsfsdfsd', '2014-10-27 23:19:34');
INSERT INTO `message` VALUES (4, '130', '101', '444dfsdfsfsdfsd', '2014-10-27 23:19:44');
INSERT INTO `message` VALUES (5, '130', '101', '555dfsdfsfsfsdf', '2014-10-27 23:28:05');
INSERT INTO `message` VALUES (6, '130', '101', '666sdfsdfsfsdf', '2014-10-27 23:28:12');
INSERT INTO `message` VALUES (7, '130', '101', '777sdfsdfdfsdfsdf', '2014-10-27 23:28:22');
INSERT INTO `message` VALUES (8, '130', '121', '888fffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdf', '2014-10-27 23:54:13');
INSERT INTO `message` VALUES (9, '130', '121', '9999ffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdf', '2014-10-27 23:54:21');
INSERT INTO `message` VALUES (19, '130', '105', '身份的啥地方是的范德萨 啥地方啥地方啥地方', '2014-10-28 11:24:01');
INSERT INTO `message` VALUES (11, '130', '121', '11111fffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdf', '2014-10-27 23:54:47');
INSERT INTO `message` VALUES (12, '130', '121', '1212fffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdfsdffffffffffffffsdf', '2014-10-27 23:54:54');
INSERT INTO `message` VALUES (14, '130', '121', '1414sfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsf', '2014-10-27 23:55:27');
INSERT INTO `message` VALUES (15, '130', '121', '1515fsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsf', '2014-10-27 23:55:35');
INSERT INTO `message` VALUES (16, '130', '121', '1616sdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsfsdfsdfsfsf', '2014-10-27 23:55:47');
INSERT INTO `message` VALUES (18, '127', '102', '1717sadfsdfsdfsdfsdf', '2014-10-28 09:35:09');

-- --------------------------------------------------------

-- 
-- 表的结构 `user`
-- 

CREATE TABLE `user` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `uniqid` varchar(40) NOT NULL COMMENT '//验证身份唯一标示符',
  `active` varchar(40) NOT NULL COMMENT '//激活唯一标示符',
  `username` varchar(40) NOT NULL COMMENT '//用户名',
  `password` varchar(40) NOT NULL COMMENT '//密码',
  `passt` varchar(40) NOT NULL COMMENT '//密码提问',
  `passd` varchar(40) NOT NULL COMMENT '密码回答',
  `email` varchar(40) default NULL,
  `qq` varchar(20) default NULL,
  `url` varchar(40) default NULL,
  `sex` varchar(1) NOT NULL COMMENT '性别',
  `face` varchar(20) NOT NULL COMMENT '头像',
  `level` tinyint(1) unsigned NOT NULL default '0' COMMENT '会员等级',
  `reg_time` datetime NOT NULL COMMENT '注册时间',
  `last_time` datetime default NULL COMMENT '最后登录时间',
  `last_ip` varchar(20) NOT NULL COMMENT '最后登录ip',
  `login_count` mediumint(8) unsigned NOT NULL default '0' COMMENT '登录次数',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

-- 
-- 导出表中的数据 `user`
-- 

INSERT INTO `user` VALUES (12, 'e67dfa031aeabd53ed2a253e51d4091116901e6b', '', '104', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', 'adosdf@163.com', '234324324', 'http://www.baidu.com', '男', 'face/m04.gif', 0, '2014-10-26 22:47:37', '2014-10-27 21:45:14', '127.0.0.1', 2);
INSERT INTO `user` VALUES (11, 'e3a2806c3ea77047af10027f235dfc943bc1aae8', '', '103', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', 'adosdf@163.com', '2323423432', 'http://www.baidu.com', '女', 'face/m14.gif', 0, '2014-10-26 22:24:07', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (10, 'b02f95ce928592abac9655d8934436d8939946e0', '', '102', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', 'adosdf@163.com', '234234234', 'http://www.baidu.com', '男', 'face/m01.gif', 0, '2014-10-26 22:16:46', '2014-10-28 09:34:56', '127.0.0.1', 2);
INSERT INTO `user` VALUES (9, '0e01647561971181572bb18a1ba693ec80a496e3', '', '101', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '11111111', '011c945f30ce2cbafc452f39840f025693339c42', 'sdf@qq.com', '232323233', 'http://www.baidu.com', '男', 'face/m06.gif', 0, '2014-10-26 21:59:09', '2014-10-27 22:16:26', '127.0.0.1', 2);
INSERT INTO `user` VALUES (8, '41ecf45afcebd6d6032dd449e6f36abc548fdd92', '', '100', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', 'sdf@qq.com', '11111111111', 'http://www.baidu.com', '女', 'face/m05.gif', 1, '2014-10-26 21:58:48', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (13, 'ebfadd391d79d298a9d5c501e5609cf6a3ade991', '', '105', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', '', '2324234234', 'http://www.baidu.com', '女', 'face/m24.gif', 0, '2014-10-26 22:52:51', '2014-10-28 11:23:45', '127.0.0.1', 2);
INSERT INTO `user` VALUES (14, '3336eded7979ca890f6a428d5e343a494db01f6e', '', '106', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '234234234234', 'http://www.baidu.com', '男', 'face/m06.gif', 0, '2014-10-27 15:16:32', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (15, 'f8038406d596f1e5caf9f7f1816bfeec3e6f14d1', '', '107', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '23423423432', 'http://www.baidu.com', '男', 'face/m21.gif', 0, '2014-10-27 15:17:07', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (16, '86dbf16dcd7046ab46539dc3d92339917e5c37d7', '', '108', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '234234234', 'http://www.baidu.com', '女', 'face/m33.gif', 0, '2014-10-27 15:17:23', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (17, '54f9cd6f28fa30523a5769b4e5ccfd2341abb583', '', '109', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '23424234324', 'http://www.baidu.com', '男', 'face/m38.gif', 0, '2014-10-27 15:17:40', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (18, '67f9b503b5f5e2a1d36fa80947a3ecfc5f5d54e1', '', '110', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m30.gif', 0, '2014-10-27 15:18:03', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (19, '843c5569bfe50b3eb7134b1f81b35d13deb15d74', '', '111', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m35.gif', 0, '2014-10-27 15:18:19', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (20, '81df9521a1d18c264446a9d0a26b7d60eba9ba0c', '', '112', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m54.gif', 0, '2014-10-27 15:18:46', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (21, '9b422f6c43b102d9c21d16fa575e0df176a8360d', '', '113', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m60.gif', 0, '2014-10-27 15:19:03', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (22, '57bd521f8a4619afca9614b9db29020e9211fbe1', '', '114', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m39.gif', 0, '2014-10-27 15:19:21', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (23, 'b46b89a8db1b3f05e4182e752e29a80a4c456a19', '', '115', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m58.gif', 0, '2014-10-27 15:19:39', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (24, '7ff5f1b0b1b5734e291c2179046578cf3a25e311', '', '116', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m34.gif', 0, '2014-10-27 15:19:55', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (25, '0acc2e454213000e404e2dcef3ced843ada222ca', '', '117', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m26.gif', 0, '2014-10-27 15:20:13', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (26, '1d9de81d21bbe549499160e9a7b730eeee957fc5', '', '118', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m41.gif', 0, '2014-10-27 15:20:31', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (27, '7d1eaa6a3fb007a823316611e492b63aefcf48c7', '', '119', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m45.gif', 0, '2014-10-27 15:20:48', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (28, '20ce6d348a1d5d76dce81ac67ada7bdbd7cec99e', '', '120', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m44.gif', 0, '2014-10-27 15:21:06', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (29, '655b42c665d7e110b479265f4440299c26b9ffcc', '', '121', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m41.gif', 0, '2014-10-27 15:21:24', '2014-10-27 23:53:43', '127.0.0.1', 2);
INSERT INTO `user` VALUES (30, 'f187cee10db4bd8abc0520cd9cfe74c79c67a899', '', '122', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m52.gif', 0, '2014-10-27 15:21:44', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (31, 'b2e7ececbbc12f3b0cf2dc3f1ce0fe13e3977e2b', '', '123', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m48.gif', 0, '2014-10-27 15:22:01', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (32, '3b5c93959b8bdcf61e06c29dee2c5e5aa949eb6a', '', '124', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m50.gif', 0, '2014-10-27 15:22:17', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (33, '0e980997eeacc54005bc486b5dd93013c564f628', '', '125', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m49.gif', 0, '2014-10-27 15:22:36', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (34, 'e31dbd86fccce8d9f6081803c6d4e891f7243f29', '', '126', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m37.gif', 0, '2014-10-27 15:22:54', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (35, 'd809e0a7717ae277875f1d731ed5aba796e1a352', '', '127', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m53.gif', 0, '2014-10-27 15:23:13', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (36, '5c873101bdbe0e54449195a612a05df158b12a7a', '', '128', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m35.gif', 0, '2014-10-27 15:23:28', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (37, 'd46027bc51cbe70e3e05b04a3c734c763f44b221', '', '129', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m51.gif', 0, '2014-10-27 15:23:50', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (38, 'c6616cf2b2dc380e790ea40dc5e76d58a9472624', '', '130', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m63.gif', 0, '2014-10-27 15:24:10', '2014-10-28 11:24:11', '127.0.0.1', 5);
