<?php
/*
 * 兴甫幼儿园_ 园所新闻数据库安装文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * modified		2009-1-3
 */

include_once(dirname(__FILE__).'/config/config.inc.php');
include_once(dirname(__FILE__).'/class/xingfu_school_news.class.php');

$objWebInit = new xingfu_school_news();
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
$arrGMeta['xingfu_school_news']['name'] = '兴甫幼儿园_ 园所新闻';
$arrGMeta['xingfu_school_news']['cache'] = 1;//该栏目是否生成静态页，0=不可以，1=可以
$arrGMeta['xingfu_school_news']['admin'] = array(
								array(
									  'href'=>'../xingfu_school_news/admin/category.php',
									  'name'=>'兴甫幼儿园_ 园所新闻分类',),
								array(
									  'href'=>'../xingfu_school_news/admin/index.php',
									  'name'=>'兴甫幼儿园_ 园所新闻管理',),
								);
$arrGMeta['xingfu_school_news']['meta'] = array(
									  'Title' => $arrGMeta['xingfu_school_news']['name'],
									  'Description' => $arrGMeta['xingfu_school_news']['name'],
									  'Keywords' => $arrGMeta['xingfu_school_news']['name'],
									);
$somecontent = '<?php' . "\n" . '$arrGWeb = ' . var_export( $arrGWeb, true ) . ';' . "\n" . '$arrGMeta = ' . var_export( $arrGMeta, true ) . ';' . "\n" . '?>';

//写入文件
file_put_contents($strFilename,$somecontent);

//sql语句
if($_SESSION['install_type']) $sql[] = "DROP TABLE IF EXISTS `".$arrGPdoDB['db_tablepre']."xingfu_school_news`;";
$sql[] = "CREATE TABLE IF NOT EXISTS `".$arrGPdoDB['db_tablepre']."xingfu_school_news` (
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
) ENGINE=MyISAM {$extend} COMMENT='兴甫幼儿园_ 园所新闻表' ;";

if($_SESSION['install_type']) $sql[] = "DROP TABLE IF EXISTS `".$arrGPdoDB['db_tablepre']."xingfu_school_news_type`;";
$sql[] = "CREATE TABLE IF NOT EXISTS `".$arrGPdoDB['db_tablepre']."xingfu_school_news_type` (
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
) ENGINE=MyISAM  {$extend} COMMENT='兴甫幼儿园_ 园所新闻分类表' ;";

foreach($sql as $val){
	$objWebInit->db->query($val);
}
if(empty($arrModule)){
	check::AlertExit('兴甫幼儿园_ 园所新闻系统安装成功',"$strWEB_ROOT_pre$strWEBADMIN_ROOT/");
}
?>