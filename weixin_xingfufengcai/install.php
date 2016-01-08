<?php
/*
 * 微信_名教风采数据库安装文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * modified		2009-1-3
 */

include_once(dirname(__FILE__).'/config/config.inc.php');
include_once(dirname(__FILE__).'/class/weixin_xingfufengcai.class.php');

$objWebInit = new weixin_xingfufengcai();
$objWebInit->db();

if(empty($charset)) $charset = str_replace('-', '', $arrGWeb['charset']);
if(empty($extend)) $extend = $objWebInit->db->getAttribute(PDO::ATTR_SERVER_VERSION) > '4.1' ? " DEFAULT CHARSET={$charset} " : "";

$intDbSummaryLen = $arrGWeb['db_summary_len'];
//写入频道数组
if(empty($strWEB_ROOT_pre)) $strWEB_ROOT_pre = $arrGWeb['WEB_ROOT_pre'];
if(empty($strWEBADMIN_ROOT)) $strWEBADMIN_ROOT = __WEBADMIN_ROOT;
unset($arrGWeb);
if(empty($ver_path)) $ver_path = '';
$strFilename = '..'.$ver_path.'/data/webconfig.inc.php';
include($strFilename);
$arrGMeta['weixin_xingfufengcai']['name'] = '微信_名教风采';
$arrGMeta['weixin_xingfufengcai']['cache'] = 1;//该栏目是否生成静态页，0=不可以，1=可以
$arrGMeta['weixin_xingfufengcai']['admin'] = array(
								array(
									  'href'=>'../weixin_xingfufengcai/admin/category.php',
									  'name'=>'微信_名教风采分类',),
								array(
									  'href'=>'../weixin_xingfufengcai/admin/index.php',
									  'name'=>'微信_名教风采管理',),
								);
$arrGMeta['weixin_xingfufengcai']['meta'] = array(
									  'Title' => $arrGMeta['weixin_xingfufengcai']['name'],
									  'Description' => $arrGMeta['weixin_xingfufengcai']['name'],
									  'Keywords' => $arrGMeta['weixin_xingfufengcai']['name'],
									);
$somecontent = '<?php' . "\n" . '$arrGWeb = ' . var_export( $arrGWeb, true ) . ';' . "\n" . '$arrGMeta = ' . var_export( $arrGMeta, true ) . ';' . "\n" . '?>';

//写入文件
file_put_contents($strFilename,$somecontent);

//sql语句
if($_SESSION['install_type']) $sql[] = "DROP TABLE IF EXISTS `".$arrGPdoDB['db_tablepre']."weixin_xingfufengcai`;";
$sql[] = "CREATE TABLE IF NOT EXISTS `".$arrGPdoDB['db_tablepre']."weixin_xingfufengcai` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type_id` tinyint(3) unsigned default '0',
  `type_roue_id` varchar(80) default NULL,
  `user_id` int(10) unsigned default '0',
  `tag` varchar(30) default NULL,
  `bedeck` tinyint(3) unsigned default '0',
  `title` varchar(100) default NULL,
  `title_md5` char(32) default NULL,
  `linkurl` varchar(100) default NULL,
  `summary` varchar(".$intDbSummaryLen.") default NULL,
  `structon_tb` mediumtext,
  `thumbnail` varchar(30) default NULL,
  `submit_date` datetime default '0000-00-00 00:00:00',
  `topflag` tinyint(1) default '0',
  `recommendflag` tinyint(1) default '0',
  `stars` tinyint(1) default '0',
  `clicktimes` mediumint(10) unsigned default '0',
  `pass` tinyint(1) default '1',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `type_id` (`type_id`),
  KEY `title_md5` (`title_md5`),
  KEY `submit_date` (`submit_date`)
) ENGINE=MyISAM {$extend} COMMENT='微信_名教风采表' ;";

if($_SESSION['install_type']) $sql[] = "DROP TABLE IF EXISTS `".$arrGPdoDB['db_tablepre']."weixin_xingfufengcai_type`;";
$sql[] = "CREATE TABLE IF NOT EXISTS `".$arrGPdoDB['db_tablepre']."weixin_xingfufengcai_type` (
  `type_id` int(10) unsigned NOT NULL auto_increment,
  `type_parentid` int(10) unsigned NOT NULL default '0',
  `type_roue_id` varchar(80) default NULL,
  `type_title` varchar(80) default NULL,
  `type_link` varchar(150) default NULL COMMENT '跳转链接',
  `type_sort` int(10) unsigned default NULL,
  `type_pass` tinyint(1) NOT NULL default '1',
  `type_read_grade` tinyint(1) NOT NULL default '0',
  `type_write_grade` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`type_id`),
  KEY `type_parentid` (`type_parentid`),
  KEY `type_sort` (`type_sort`)
) ENGINE=MyISAM  {$extend} COMMENT='微信_名教风采分类表' ;";

foreach($sql as $val){
	$objWebInit->db->query($val);
}
if(empty($arrModule)){
	check::AlertExit('微信_名教风采系统安装成功',"$strWEB_ROOT_pre$strWEBADMIN_ROOT/");
}
?>