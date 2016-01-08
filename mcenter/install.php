<?php
/*
 * 用户中心数据库安装文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * modified		2011/4/10
 */

include_once(dirname(__FILE__).'/config/config.inc.php');
include_once(dirname(__FILE__).'/class/mcenter.class.php');

$objWebInit = new mcenter();
$objWebInit->db();

if(empty($charset)) $charset = str_replace('-', '', $arrGWeb['charset']);
if(empty($extend)) $extend = $objWebInit->db->getAttribute(PDO::ATTR_SERVER_VERSION) > '4.1' ? " DEFAULT CHARSET={$charset} " : "";

$intDbSummaryLen = $arrGWeb['db_summary_len'];
//写入频道数组
if(empty($strWEB_ROOT_pre)) $strWEB_ROOT_pre = $arrGWeb['WEB_ROOT_pre'];
if(empty($strWEBADMIN_ROOT)) $strWEBADMIN_ROOT = __WEBADMIN_ROOT;

try{
	//sql语句
	if($_SESSION['install_type']) $sql[] = "DROP TABLE IF EXISTS `".$arrGPdoDB['db_tablepre']."mcenter`;";
	$sql[] = "CREATE TABLE IF NOT EXISTS `".$arrGPdoDB['db_tablepre']."mcenter` (
			  `user_id` int(10) unsigned NOT NULL auto_increment COMMENT '用户id',
			  `user_name` char(30) default NULL COMMENT '登录帐号',
			  `corp_name` char(60) default NULL COMMENT '公司名称',
			  `contact_address` char(60) default NULL COMMENT '联系地址',
			  `postcode` mediumint(6) default NULL COMMENT '邮编',			  
			  `real_name` char(20) default NULL COMMENT '真实姓名',
			  `nick_name` char(20) default NULL COMMENT '昵称',
			  `password` char(32) default NULL COMMENT '登录密码',
			  `paypassword` char(32) default NULL COMMENT '支付密码',
			  `question` tinyint(1) NOT NULL default '0' COMMENT '密码提示问题',
			  `answer` char(32) default NULL COMMENT '密码提示答案',
			  `user_money` decimal(10,2) NOT NULL COMMENT '用户帐户金额',
			  `user_score` int(10) unsigned NOT NULL COMMENT '用户积分',
			  `sb_money` int(10) unsigned NOT NULL COMMENT '售币',
			  `province` mediumint(6) default NULL COMMENT '省',
			  `city` mediumint(6) default NULL COMMENT '市',
			  `area` mediumint(6) default NULL COMMENT '区',
			  `sex` tinyint(1) NOT NULL default '0' COMMENT '性别',
			  `birthday` date COMMENT '年龄，根据生日来推算',
			  `email` char(40) default NULL COMMENT '电子邮件',
			  `tel` char(25) default NULL COMMENT '电话',
			  `mobile` char(15) default NULL COMMENT '手机',
			  `msn` char(40) default NULL COMMENT 'MSN',
			  `qq` decimal(16,0) default NULL COMMENT 'QQ',
			  `imghost` char(30) default NULL COMMENT '图像访问域名',
			  `thumbnail` char(20) default NULL COMMENT '会员头像',
			  `integrity_grade` smallint(5) unsigned zerofill NOT NULL DEFAULT '00000' COMMENT '诚信等级(5个0，第1位=身份认证，第2位=手机认证，第3位=视频认证，值0=未认证，1=已认证)',
			  `lastlog` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '最后登录时间',
			  `logtimes` int(10) unsigned default '0' COMMENT '登录次数',
			  `submit_date` datetime default '0000-00-00 00:00:00' COMMENT '注册时间',
			  `status` tinyint(4) default '1' COMMENT '状态,0=冻结，1=正常',
			  `recommend_user_id` int(10) unsigned NOT NULL default '0' COMMENT '推荐人user_id',
			  `add_date` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '加入网络时间',
			  `parentid` int(10) unsigned NOT NULL default '0',
			  `roue_id` char(255) default NULL,
			  `host` char(20) default NULL COMMENT '来路域名',
			  `user_ip` char(23) default NULL COMMENT '用户IP地址',
			  `is_photos` tinyint(1) default '1' COMMENT '是否显示照片,1=显示，2=网站会员可见，3认证会员可见，4有照片会员可见，5需要密码可见',
			  `photopassword` char(32) default NULL COMMENT '相册密码',
			  `session_id` char(32) default NULL COMMENT '用户SESSIONID',
			  `majia` tinyint(2) default 0 COMMENT '1为网站马甲,0为正常用户',
			  `last_promotion_money` int(7) default 0 COMMENT '上次推广奖励',
			  `promotion_money` int(7) default 0 COMMENT '推广奖励',
			  PRIMARY KEY  (`user_id`),
			  UNIQUE KEY `user_name` (`user_name`),
			  KEY `email` (`email`),
			  KEY `mobile` (`mobile`),
			  KEY `city` (`city`)
			) ENGINE=MyISAM {$extend} COMMENT='用户中心表' ;";


}catch(Exception $e){
	echo $e->getMessage();
	exit;
}

foreach($sql as $val){
	$objWebInit->db->query($val);
}


$arrTemp = array();
if(!empty($_SESSION['user_name'])) $arrTemp['user_name'] = $_SESSION['user_name'];
else $arrTemp['user_name'] = 'admin';
if(!empty($_SESSION['nick_name'])) $arrTemp['nick_name'] = $_SESSION['nick_name'];
else $arrTemp['nick_name'] = 'ArthurXF';
if(!empty($_SESSION['real_name'])) $arrTemp['real_name'] = $_SESSION['real_name'];
else $arrTemp['real_name'] = '肖先生';
if(!empty($_SESSION['email'])) $arrTemp['email'] = $_SESSION['email'];
else $arrTemp['email'] = 'arthurxf@gmail.com';
if(!empty($_SESSION['password'])) $arrTemp['password'] = $_SESSION['password'];
else $arrTemp['password'] = 'admin';

$arrTemp['user_id'] = 1;
$objWebInit->saveInfo($arrTemp,0);
unset($_SESSION['user_id']);

if(empty($arrModule)){
	check::AlertExit('用户中心系统安装成功',"$strWEB_ROOT_pre$strWEBADMIN_ROOT/");
}
?>