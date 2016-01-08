<?php
/*
 * 单页介绍数据库安装文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * modified		2009-1-3
 */

include_once(dirname(__FILE__).'/config/config.inc.php');
include_once(dirname(__FILE__).'/class/archives.class.php');

$objWebInit = new archives();
//数据库连接
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
$arrGMeta['archives']['name'] = '单页介绍';
$arrGMeta['archives']['cache'] = 1;//该栏目是否生成静态页，0=不可以，1=可以
$arrGMeta['archives']['admin'] = array(								
								array(
									  'href'=>'../archives/admin/index.php',
									  'name'=>'单页介绍管理',),
								);
$arrGMeta['archives']['meta'] = array(
									  'Title' => $arrGMeta['archives']['name'],
									  'Description' => $arrGMeta['archives']['name'],
									  'Keywords' => $arrGMeta['archives']['name'],
									);
$somecontent = '<?php' . "\n" . '$arrGWeb = ' . var_export( $arrGWeb, true ) . ';' . "\n" . '$arrGMeta = ' . var_export( $arrGMeta, true ) . ';' . "\n" . '?>';

// 写入文件
file_put_contents($strFilename,$somecontent);

//sql语句
if($_SESSION['install_type']) $sql[] = "DROP TABLE IF EXISTS `".$arrGPdoDB['db_tablepre']."archives`;";
$sql[] = "CREATE TABLE IF NOT EXISTS `".$arrGPdoDB['db_tablepre']."archives` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `module_name` varchar(30) default NULL COMMENT '标识名',
  `type_title_english` varchar(80) default NULL,
  `structon_tb` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM {$extend} COMMENT='单页介绍表' ;";


$sql[] = "REPLACE INTO `".$arrGWeb[db_name]."`.`".$arrGPdoDB['db_tablepre']."archives` (`id`,`module_name`,`type_title_english`) VALUES 
('1', '联系我们', 'contact'), 
('2', '公司介绍', 'company'),
('3', '人才招聘', 'jobs');";



foreach($sql as $val){
	$objWebInit->db->query($val);
}
if(empty($arrModule)){
	check::AlertExit('单页介绍系统安装成功',"$strWEB_ROOT_pre$strWEBADMIN_ROOT/");
}
?>