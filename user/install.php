<?php
/*
 * 网站用户数据库安装文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * modified		2009-1-3
 */

include_once(dirname(__FILE__).'/config/config.inc.php');
include_once(dirname(__FILE__).'/class/user.class.php');

$objWebInit = new user();
$objWebInit->db();

if(empty($charset)) $charset = str_replace('-', '', $arrGWeb['charset']);
if(empty($extend)) $extend = $objWebInit->db->getAttribute(PDO::ATTR_SERVER_VERSION) > '4.1' ? " DEFAULT CHARSET={$charset} " : "";

$intDbSummaryLen = $arrGWeb['db_summary_len'];
//写入频道数组
if(empty($strWEB_ROOT_pre)) $strWEB_ROOT_pre = $arrGWeb['WEB_ROOT_pre'];
if(empty($strWEBADMIN_ROOT)) $strWEBADMIN_ROOT = __WEBADMIN_ROOT;
unset($arrGWeb);

try{
	//sql语句
	if($_SESSION['install_type']) $sql[] = "DROP TABLE IF EXISTS `".$arrGPdoDB['db_tablepre']."user`;";
	$sql[] = "CREATE TABLE IF NOT EXISTS `".$arrGPdoDB['db_tablepre']."user` (
			  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'id',
			  `user_id` int(10) unsigned NOT NULL  COMMENT '用户id',
			  `nick_name` varchar(20) default NULL COMMENT '昵称',
			  `user_type` tinyint(1) NOT NULL default '0' COMMENT '用户类型(0=普通会员，1=商家)',
			  `user_group` smallint(1) NOT NULL default '0' COMMENT '用户所属权限组',
			  `user_grade` tinyint(1) NOT NULL default '0' COMMENT '等级，星级',
			  `province` mediumint(6) default NULL COMMENT '省',
			  `city` mediumint(6) default NULL COMMENT '市',
			  `area` mediumint(6) default NULL COMMENT '区',
			  `sex` tinyint(3) NOT NULL default '0' COMMENT '性别',
			  `birthday` date COMMENT '年龄，根据生日来推算',
			  `signature` varchar(30) default NULL COMMENT '个性签名',
			  `thumbnail` varchar(20) default NULL COMMENT '会员头像',
			  `integrity_grade` smallint(5) unsigned zerofill NOT NULL DEFAULT '00000' COMMENT '诚信等级(5个0，第1位=身份认证，第2位=手机认证，第3位=视频认证，值0=未认证，1=已认证)',
			  `education_type` tinyint(3) NOT NULL default '0' COMMENT '学历类型',
			  `marriage_type` tinyint(3) NOT NULL default '0' COMMENT '婚姻类型',
			  `total_credit` int(10) NOT NULL default '0' COMMENT '累计信用',
			  `good_evaluate` decimal(16,0) NOT NULL COMMENT '好评率',
			  `structon_tb` text NOT NULL,
			  `url_short` varchar(25) NOT NULL COMMENT '推广链接',
			  `lastlog` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '最后登录时间',
			  `submit_date` datetime default '0000-00-00 00:00:00' COMMENT '注册时间',
			  `topflag` tinyint(1) default '0',
			  `recommendflag` tinyint(1) default '0' COMMENT '有头像排前',
			  `clicktimes` int(10) unsigned NOT NULL default '0' COMMENT '人气',
			  `pass` tinyint(4) default '1' COMMENT '审核状态',
			  `is_check` tinyint(1) default '0' COMMENT '需要审核',
			  `friend_num` int( 10 ) NOT NULL COMMENT '好友数量',
			  `friend_fans` int( 10 ) NOT NULL COMMENT '粉丝数量',
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `user_id` (`user_id`),
			  KEY `total_credit` (`total_credit`),
			  KEY `province` (`province`),
			  KEY `city` (`city`),
			  KEY `area` (`area`)
			) ENGINE=MyISAM {$extend} COMMENT='网站用户表' ;";
}catch(Exception $e){
	echo $e->getMessage();
	exit;
}

foreach($sql as $val){
	$objWebInit->db->query($val);
}

$arrTemp = array();
$arrTemp['id'] = 1;
$arrTemp['user_id'] = 1;
$arrTemp['user_group'] = 3;
$arrTemp['sex'] = 1;
$arrTemp['nick_name'] = 'ArthurXF';
$arrTemp['intro'] = '我是一名光荣的U客，诚交其他U客好友，需要帮助均可联系我!';

$objWebInit->saveInfo($arrTemp,0,false);

if(empty($arrModule)){
	check::AlertExit('网站用户系统安装成功',"$strWEB_ROOT_pre$strWEBADMIN_ROOT/");
}
?>