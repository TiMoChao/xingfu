<?php
/*
 * 手机管理数据库安装文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * modified		2009-1-3
 */

include_once(dirname(__FILE__).'/config/config.inc.php');
include_once(dirname(__FILE__).'/class/phonelist.class.php');

$objWebInit = new phonelist();
$objWebInit->db();

if(empty($charset)) $charset = str_replace('-', '', $arrGWeb['charset']);
if(empty($extend)) $extend = $objWebInit->db->getAttribute(PDO::ATTR_SERVER_VERSION) > '4.1' ? " DEFAULT CHARSET={$charset} " : "";

$intDbSummaryLen = $arrGWeb['db_summary_len'];
//写入频道数组
if(empty($strWEB_ROOT_pre)) $strWEB_ROOT_pre = $arrGWeb['WEB_ROOT_pre'];
if(empty($strWEBADMIN_ROOT)) $strWEBADMIN_ROOT = __WEBADMIN_ROOT;
unset($arrGWeb);
$strFilename = __WEB_ROOT.'/data/webconfig.inc.php';
include($strFilename);
$arrGMeta['phonelist']['name'] = '手机管理';
$arrGMeta['phonelist']['cache'] = 0;		//该栏目是否生成静态页，0=不可以，1=可以
if(!is_array($arrMType)||empty($arrMType)){
	$arrGMeta['phonelist']['admin'] = array(
									array(
										  'href'=>'../phonelist/admin/category.php',
										  'name'=>'订阅手机分类',),
									array(
										  'href'=>'../phonelist/admin/index.php',
										  'name'=>'订阅手机管理',),
									);
}else{
	$arrGMeta['phonelist']['admin'] = array(
									array(
										  'href'=>'../phonelist/admin/index.php',
										  'name'=>'订阅手机管理',),
									);
}
$arrGMeta['phonelist']['meta'] = array(
									  'Title' => $arrGMeta['phonelist']['name'],
									  'Description' => $arrGMeta['phonelist']['name'],
									  'Keywords' => $arrGMeta['phonelist']['name'],
									);
$somecontent = '<?php' . "\n" . '$arrGWeb = ' . var_export( $arrGWeb, true ) . ';' . "\n" . '$arrGMeta = ' . var_export( $arrGMeta, true ) . ';' . "\n" . '?>';

// 首先我们要确定文件存在并且可写。
if (is_writable($strFilename)) {

	if (!$handle = fopen($strFilename, 'w')) {
		 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
	}

	// 将$somecontent写入到我们打开的文件中。
	if (fwrite($handle, $somecontent) === FALSE) {
		check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
	}
	fclose($handle);
} else {
	check::AlertExit("错误：文件 $strFilename 不可写!",-1);
}

//sql语句
if($_SESSION['install_type']) $sql[] = "DROP TABLE IF EXISTS `".$arrGPdoDB['db_tablepre']."phonelist`;";
$sql[] = "CREATE TABLE IF NOT EXISTS `".$arrGPdoDB['db_tablepre']."phonelist` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type_id` tinyint(3) unsigned default '0',
  `type_roue_id` varchar(80) default NULL,
  `title` varchar(100) default NULL,
  `structon_tb` text,
  `submit_date` datetime default '0000-00-00 00:00:00',
  `pass` tinyint(1) default '1',
  PRIMARY KEY  (`id`),
  KEY `submit_date` (`submit_date`)
) ENGINE=MyISAM {$extend} COMMENT='手机管理表' ;";

if($_SESSION['install_type']) $sql[] = "DROP TABLE IF EXISTS `".$arrGPdoDB['db_tablepre']."phonelist_type`;";
$sql[] = "CREATE TABLE IF NOT EXISTS `".$arrGPdoDB['db_tablepre']."phonelist_type` (
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
) ENGINE=MyISAM  {$extend} COMMENT='手机分类表' ;";

foreach($sql as $val){
	$objWebInit->db->query($val);
}
if(empty($arrModule)){
	check::AlertExit('手机管理系统安装成功',"$strWEB_ROOT_pre$strWEBADMIN_ROOT/");
}
?>