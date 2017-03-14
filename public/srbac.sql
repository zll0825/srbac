/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : crbac

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-03-14 14:10:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for t_rbac_element
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_element`;
CREATE TABLE `t_rbac_element` (
  `EID` int(11) NOT NULL AUTO_INCREMENT COMMENT '页面元素ID',
  `ELEMENTCODE` varchar(256) DEFAULT NULL COMMENT '页面元素编码',
  PRIMARY KEY (`EID`),
  KEY `Index_EID` (`EID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='页面元素';

-- ----------------------------
-- Table structure for t_rbac_file
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_file`;
CREATE TABLE `t_rbac_file` (
  `FID` int(11) NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `FILENAME` varchar(256) DEFAULT NULL COMMENT '文件名',
  `FILEPATH` varchar(512) DEFAULT NULL COMMENT '文件路径',
  PRIMARY KEY (`FID`),
  KEY `Index_FID` (`FID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文件表';

-- ----------------------------
-- Table structure for t_rbac_function
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_function`;
CREATE TABLE `t_rbac_function` (
  `FID` int(11) NOT NULL AUTO_INCREMENT COMMENT '操作ID',
  `FUNCTIONNAME` varchar(64) DEFAULT NULL COMMENT '操作名称',
  `FUNCTIONCODE` varchar(64) DEFAULT NULL COMMENT '操作编码',
  `FILTERURL` varchar(512) DEFAULT NULL COMMENT '拦截URL前缀',
  `PARENTFID` int(11) DEFAULT NULL COMMENT '父操作ID',
  PRIMARY KEY (`FID`),
  KEY `Index_FID` (`FID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='功能操作表';

-- ----------------------------
-- Table structure for t_rbac_menu
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_menu`;
CREATE TABLE `t_rbac_menu` (
  `MID` int(11) NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `MENUNAME` varchar(128) DEFAULT NULL COMMENT '菜单名称',
  `MENUCODE` varchar(128) DEFAULT NULL COMMENT '菜单编码',
  `MENUURL` varchar(256) DEFAULT NULL COMMENT '菜单URL',
  `PARENTMID` int(11) DEFAULT NULL COMMENT '父菜单ID',
  PRIMARY KEY (`MID`),
  KEY `Index_MID` (`MID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Table structure for t_rbac_permission
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_permission`;
CREATE TABLE `t_rbac_permission` (
  `PID` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限ID',
  `PERMISSIONTYPE` varchar(256) DEFAULT NULL COMMENT '权限类型：\r\n            1.Menu\r\n            2.Element\r\n            3.File\r\n            4.Function',
  `APPLICATION` varchar(256) DEFAULT NULL COMMENT '应用终端：\r\n            1.WEB\r\n            2.APP',
  PRIMARY KEY (`PID`),
  KEY `Index_PID` (`PID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Table structure for t_rbac_permissionelement
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_permissionelement`;
CREATE TABLE `t_rbac_permissionelement` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `PID` int(11) DEFAULT NULL COMMENT '权限ID',
  `EID` int(11) DEFAULT NULL COMMENT '页面元素ID',
  PRIMARY KEY (`ID`),
  KEY `Index_ID` (`ID`),
  KEY `Index_PID` (`PID`),
  KEY `Index_EID` (`EID`),
  CONSTRAINT `FK_Reference_10` FOREIGN KEY (`PID`) REFERENCES `t_rbac_permission` (`PID`),
  CONSTRAINT `FK_Reference_20` FOREIGN KEY (`EID`) REFERENCES `t_rbac_element` (`EID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限页面元素关联表';

-- ----------------------------
-- Table structure for t_rbac_permissionfile
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_permissionfile`;
CREATE TABLE `t_rbac_permissionfile` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `PID` int(11) DEFAULT NULL COMMENT '权限ID',
  `FID` int(11) DEFAULT NULL COMMENT '文件ID',
  PRIMARY KEY (`ID`),
  KEY `Index_ID` (`ID`),
  KEY `Index_PID` (`PID`),
  KEY `Index_FID` (`FID`),
  CONSTRAINT `FK_Reference_11` FOREIGN KEY (`FID`) REFERENCES `t_rbac_file` (`FID`),
  CONSTRAINT `FK_Reference_12` FOREIGN KEY (`PID`) REFERENCES `t_rbac_permission` (`PID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限文件关联表';

-- ----------------------------
-- Table structure for t_rbac_permissionfunction
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_permissionfunction`;
CREATE TABLE `t_rbac_permissionfunction` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `PID` int(11) DEFAULT NULL COMMENT '权限ID',
  `FID` int(11) DEFAULT NULL COMMENT '操作ID',
  PRIMARY KEY (`ID`),
  KEY `Index_ID` (`ID`),
  KEY `Index_PID` (`PID`),
  KEY `Index_FID` (`FID`),
  CONSTRAINT `FK_Reference_5` FOREIGN KEY (`PID`) REFERENCES `t_rbac_permission` (`PID`),
  CONSTRAINT `FK_Reference_6` FOREIGN KEY (`FID`) REFERENCES `t_rbac_function` (`FID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限操作关联表';

-- ----------------------------
-- Table structure for t_rbac_permissionmenu
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_permissionmenu`;
CREATE TABLE `t_rbac_permissionmenu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `PID` int(11) DEFAULT NULL COMMENT '权限ID',
  `MID` int(11) DEFAULT NULL COMMENT '菜单ID',
  PRIMARY KEY (`ID`),
  KEY `Index_ID` (`ID`),
  KEY `Index_PID` (`PID`),
  KEY `Index_MID` (`MID`),
  CONSTRAINT `FK_Reference_19` FOREIGN KEY (`MID`) REFERENCES `t_rbac_menu` (`MID`),
  CONSTRAINT `FK_Reference_8` FOREIGN KEY (`PID`) REFERENCES `t_rbac_permission` (`PID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限菜单关联表';

-- ----------------------------
-- Table structure for t_rbac_role
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_role`;
CREATE TABLE `t_rbac_role` (
  `ROLEID` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `ROLENAME` varchar(256) DEFAULT NULL COMMENT '角色名称',
  PRIMARY KEY (`ROLEID`),
  KEY `Index_ROLEID` (`ROLEID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Table structure for t_rbac_rolepermission
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_rolepermission`;
CREATE TABLE `t_rbac_rolepermission` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `ROLEID` int(11) DEFAULT NULL COMMENT '角色ID',
  `PID` int(11) DEFAULT NULL COMMENT '权限ID',
  PRIMARY KEY (`ID`),
  KEY `Index_ID` (`ID`),
  KEY `Index_ROLEID` (`ROLEID`),
  KEY `Index_PID` (`PID`),
  CONSTRAINT `FK_Reference_3` FOREIGN KEY (`ROLEID`) REFERENCES `t_rbac_role` (`ROLEID`),
  CONSTRAINT `FK_Reference_4` FOREIGN KEY (`PID`) REFERENCES `t_rbac_permission` (`PID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限关联表';

-- ----------------------------
-- Table structure for t_rbac_user
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_user`;
CREATE TABLE `t_rbac_user` (
  `UID` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `AVATAR` varchar(512) DEFAULT NULL COMMENT '头像',
  `NICKNAME` varchar(64) DEFAULT NULL COMMENT '用户昵称',
  `REGTIME` datetime DEFAULT NULL COMMENT '注册时间',
  `LOGINIP` varchar(64) DEFAULT NULL COMMENT '登录IP',
  PRIMARY KEY (`UID`),
  KEY `Index_UID` (`UID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Table structure for t_rbac_userauth
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_userauth`;
CREATE TABLE `t_rbac_userauth` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `UID` int(11) DEFAULT NULL COMMENT '用户ID',
  `LOGINTYPE` varchar(64) DEFAULT NULL COMMENT '登录类型',
  `LOGINID` varchar(256) DEFAULT NULL COMMENT '登录ID',
  `LOGINNAME` varchar(256) DEFAULT NULL COMMENT '登录名',
  `PASSWORD` varchar(512) DEFAULT NULL COMMENT '登录密码',
  PRIMARY KEY (`ID`),
  KEY `Index_ID` (`ID`),
  KEY `Index_UID` (`UID`),
  CONSTRAINT `FK_Reference_17` FOREIGN KEY (`UID`) REFERENCES `t_rbac_user` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户第三方授权表';

-- ----------------------------
-- Table structure for t_rbac_usergroup
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_usergroup`;
CREATE TABLE `t_rbac_usergroup` (
  `UGID` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户组ID',
  `GROUPNAME` varchar(64) DEFAULT NULL COMMENT '用户组名称',
  `PARENTUGID` int(11) DEFAULT NULL COMMENT '父用户组ID',
  PRIMARY KEY (`UGID`),
  KEY `Index_UGID` (`UGID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户组';

-- ----------------------------
-- Table structure for t_rbac_usergrouprole
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_usergrouprole`;
CREATE TABLE `t_rbac_usergrouprole` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `ROLEID` int(11) DEFAULT NULL COMMENT '角色ID',
  `UGID` int(11) DEFAULT NULL COMMENT '用户组ID',
  PRIMARY KEY (`ID`),
  KEY `Index_ID` (`ID`),
  KEY `Index_ROLEID` (`ROLEID`),
  KEY `Index_UGID` (`UGID`),
  CONSTRAINT `FK_Reference_16` FOREIGN KEY (`ROLEID`) REFERENCES `t_rbac_role` (`ROLEID`),
  CONSTRAINT `FK_Reference_18` FOREIGN KEY (`UGID`) REFERENCES `t_rbac_usergroup` (`UGID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组角色关联表';

-- ----------------------------
-- Table structure for t_rbac_usergroupuser
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_usergroupuser`;
CREATE TABLE `t_rbac_usergroupuser` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `UGID` int(11) DEFAULT NULL COMMENT '用户组ID',
  `UID` int(11) DEFAULT NULL COMMENT '用户ID',
  PRIMARY KEY (`ID`),
  KEY `Index_ID` (`ID`),
  KEY `Index_UGID` (`UGID`),
  KEY `Index_UID` (`UID`),
  CONSTRAINT `FK_Reference_13` FOREIGN KEY (`UGID`) REFERENCES `t_rbac_usergroup` (`UGID`),
  CONSTRAINT `FK_Reference_14` FOREIGN KEY (`UID`) REFERENCES `t_rbac_user` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组与用户关联表';

-- ----------------------------
-- Table structure for t_rbac_userrole
-- ----------------------------
DROP TABLE IF EXISTS `t_rbac_userrole`;
CREATE TABLE `t_rbac_userrole` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `UID` int(11) DEFAULT NULL COMMENT '用户ID',
  `ROLEID` int(11) DEFAULT NULL COMMENT '角色ID',
  PRIMARY KEY (`ID`),
  KEY `Index_ID` (`ID`),
  KEY `Index_UID` (`UID`),
  KEY `Index_ROLEID` (`ROLEID`),
  CONSTRAINT `FK_Reference_1` FOREIGN KEY (`UID`) REFERENCES `t_rbac_user` (`UID`),
  CONSTRAINT `FK_Reference_2` FOREIGN KEY (`ROLEID`) REFERENCES `t_rbac_role` (`ROLEID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色关联表';

-- ----------------------------
-- View structure for v_rbac_userrole
-- ----------------------------
DROP VIEW IF EXISTS `v_rbac_userrole`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `v_rbac_userrole` AS SELECT
	t1.UID, t1.AVATAR,t1.NICKNAME,t1.REGTIME,t1.LOGINIP, 
	t3.ROLEID,t3.ROLENAME
FROM
	t_rbac_user t1
LEFT JOIN t_rbac_userrole t2 ON t1.UID = t2.UID
LEFT JOIN t_rbac_role t3 ON t2.ROLEID = t3.ROLEID
UNION
SELECT
	t1.UID, t1.AVATAR,t1.NICKNAME,t1.REGTIME,t1.LOGINIP,
	t5.ROLEID,t5.ROLENAME
FROM
	t_rbac_user t1
LEFT JOIN t_rbac_usergroupuser t2 ON t1.UID = t2.UID
LEFT JOIN t_rbac_usergroup t3 ON t2.UGID = t3.UGID
LEFT JOIN t_rbac_usergrouprole t4 ON t3.UGID = t4.UGID
LEFT JOIN t_rbac_role t5 ON t4.ROLEID = t5.ROLEID
ORDER BY ROLEID, UID ;

-- ----------------------------
-- View structure for v_rbac_allelement
-- ----------------------------
DROP VIEW IF EXISTS `v_rbac_allelement`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `v_rbac_allelement` AS SELECT
  t1.PID, t1.PERMISSIONTYPE,t1.APPLICATION, 
  t2.EID, t3.ELEMENTCODE
FROM
  t_rbac_permission t1
LEFT JOIN t_rbac_permissionelement t2 ON t1.PID = t2.PID
LEFT JOIN t_rbac_element t3 ON t2.EID = t3.EID
WHERE t1.PERMISSIONTYPE='ELEMENT' ;

-- ----------------------------
-- View structure for t_rbac_userelemrntpermission
-- ----------------------------
DROP VIEW IF EXISTS `t_rbac_userelemrntpermission`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `t_rbac_userelemrntpermission` AS SELECT 
t1.UID,t1.AVATAR,t1.NICKNAME,t1.REGTIME, t1.LOGINIP,
t3.PID,t3.PERMISSIONTYPE,t3.APPLICATION,t3.EID,t3.ELEMENTCODE 
FROM v_rbac_userrole t1
LEFT JOIN t_rbac_rolepermission t2 ON t1.ROLEID=t2.ROLEID
LEFT JOIN v_rbac_allelement t3 on t2.PID=t3.PID WHERE t3.EID IS NOT NULL
GROUP BY t1.UID,t1.AVATAR,t1.NICKNAME,t1.REGTIME, t1.LOGINIP,
t3.PID,t3.PERMISSIONTYPE,t3.APPLICATION,t3.EID,t3.ELEMENTCODE
ORDER BY t1.UID,t3.ELEMENTCODE ;

-- ----------------------------
-- View structure for v_rbac_allfunction
-- ----------------------------
DROP VIEW IF EXISTS `v_rbac_allfunction`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `v_rbac_allfunction` AS SELECT
  t1.PID, t1.PERMISSIONTYPE,t1.APPLICATION, 
  t2.FID, t3.FUNCTIONNAME,t3.FUNCTIONCODE,t3.FILTERURL,t3.PARENTFID
FROM
  t_rbac_permission t1
LEFT JOIN t_rbac_permissionfunction t2 ON t1.PID = t2.PID
LEFT JOIN t_rbac_function t3 ON t2.FID = t3.FID
WHERE t1.PERMISSIONTYPE='FUNCTION' ;

-- ----------------------------
-- View structure for v_rbac_allmenu
-- ----------------------------
DROP VIEW IF EXISTS `v_rbac_allmenu`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `v_rbac_allmenu` AS SELECT
  t1.PID, t1.PERMISSIONTYPE,t1.APPLICATION, t2.MID,t3.MENUNAME,t3.MENUCODE,t3.MENUURL,t3.PARENTMID
FROM
  t_rbac_permission t1
LEFT JOIN t_rbac_permissionmenu t2 ON t1.PID = t2.PID
LEFT JOIN t_rbac_menu t3 ON t2.MID = t3.MID
WHERE t1.PERMISSIONTYPE='MENU' ;

-- ----------------------------
-- View structure for v_rbac_userfunctionpermission
-- ----------------------------
DROP VIEW IF EXISTS `v_rbac_userfunctionpermission`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `v_rbac_userfunctionpermission` AS SELECT 
t1.UID,t1.AVATAR,t1.NICKNAME,t1.REGTIME, t1.LOGINIP,
t3.PID,t3.PERMISSIONTYPE,t3.APPLICATION,t3.FID,t3.FUNCTIONNAME,t3.FUNCTIONCODE,t3.FILTERURL,t3.PARENTFID
FROM v_rbac_userrole t1
LEFT JOIN t_rbac_rolepermission t2 ON t1.ROLEID=t2.ROLEID
LEFT JOIN v_rbac_allfunction t3 on t2.PID=t3.PID WHERE t3.FID IS NOT NULL
GROUP BY t1.UID,t1.AVATAR,t1.NICKNAME,t1.REGTIME, t1.LOGINIP,
t3.PID,t3.PERMISSIONTYPE,t3.APPLICATION,t3.FID,t3.FUNCTIONNAME,t3.FUNCTIONCODE,t3.FILTERURL,t3.PARENTFID
ORDER BY t1.UID,t3.FUNCTIONCODE ;

-- ----------------------------
-- View structure for v_rbac_usermenupermission
-- ----------------------------
DROP VIEW IF EXISTS `v_rbac_usermenupermission`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `v_rbac_usermenupermission` AS SELECT 
t1.UID,t1.AVATAR,t1.NICKNAME,t1.REGTIME, t1.LOGINIP,
t3.PID,t3.PERMISSIONTYPE,t3.APPLICATION,t3.MID,t3.MENUNAME,t3.MENUCODE,t3.MENUURL,t3.PARENTMID 
FROM v_rbac_userrole t1
LEFT JOIN t_rbac_rolepermission t2 ON t1.ROLEID=t2.ROLEID
LEFT JOIN v_rbac_allmenu t3 on t2.PID=t3.PID WHERE t3.MID IS NOT NULL
GROUP BY t1.UID,t1.AVATAR,t1.NICKNAME,t1.REGTIME, t1.LOGINIP,
t3.PID,t3.PERMISSIONTYPE,t3.APPLICATION,t3.MID,t3.MENUNAME,t3.MENUCODE,t3.MENUURL,t3.PARENTMID
ORDER BY t1.UID,t3.MENUCODE ;
