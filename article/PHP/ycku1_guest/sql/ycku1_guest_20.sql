-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2014 年 10 月 27 日 04:38
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ycku1_guest`
-- 

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
  `reg_time` datetime NOT NULL COMMENT '注册时间',
  `last_time` datetime default NULL COMMENT '最后登录时间',
  `last_ip` varchar(20) NOT NULL COMMENT '最后登录ip',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- 
-- 导出表中的数据 `user`
-- 

INSERT INTO `user` VALUES (12, 'e67dfa031aeabd53ed2a253e51d4091116901e6b', '', '104', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', '', '', '', '女', 'face/m08.gif', '2014-10-26 22:47:37', '2014-10-26 22:47:37', '127.0.0.1');
INSERT INTO `user` VALUES (11, 'e3a2806c3ea77047af10027f235dfc943bc1aae8', '', '103', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', '', '', '', '男', 'face/m09.gif', '2014-10-26 22:24:07', '2014-10-26 22:24:07', '127.0.0.1');
INSERT INTO `user` VALUES (10, 'b02f95ce928592abac9655d8934436d8939946e0', '497c4cbbacc9632e29b6eb257d69d900d1a1d575', '102', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', '', '', '', '男', 'face/m11.gif', '2014-10-26 22:16:46', '2014-10-26 22:16:46', '127.0.0.1');
INSERT INTO `user` VALUES (9, '0e01647561971181572bb18a1ba693ec80a496e3', '27cd13657e155731d090fe3a5867148f66f6a317', '101', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '11111111', '011c945f30ce2cbafc452f39840f025693339c42', 'sdf@qq.com', '', '', '男', 'face/m06.gif', '2014-10-26 21:59:09', '2014-10-26 21:59:09', '127.0.0.1');
INSERT INTO `user` VALUES (8, '41ecf45afcebd6d6032dd449e6f36abc548fdd92', 'ecdb84d74a249df92b50530e1e10f47138694146', '100', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', 'sdf@qq.com', '11111111111', '', '女', 'face/m05.gif', '2014-10-26 21:58:48', '2014-10-26 21:58:48', '127.0.0.1');
INSERT INTO `user` VALUES (13, 'ebfadd391d79d298a9d5c501e5609cf6a3ade991', '', '105', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', '', '', '', '女', 'face/m24.gif', '2014-10-26 22:52:51', '2014-10-26 22:52:51', '127.0.0.1');
