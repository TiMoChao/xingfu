<?php
/*
 * 在线留言数据库安装文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * modified		2009-1-3
 */

include_once(dirname(__FILE__).'/config/config.inc.php');
include_once(dirname(__FILE__).'/class/message.class.php');

$objWebInit = new message();
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
$arrGMeta['message']['name'] = '在线留言';
$arrGMeta['message']['cache'] = 0;	//该栏目是否生成静态页，0=不可以，1=可以
$arrGMeta['message']['admin'] = array(
								array(
									  'href'=>'../message/admin/index.php',
									  'name'=>'网站留言管理',),
								);
$arrGMeta['message']['meta'] = array(
									  'Title' => $arrGMeta['message']['name'],
									  'Description' => $arrGMeta['message']['name'],
									  'Keywords' => $arrGMeta['message']['name'],
									);
$somecontent = '<?php' . "\n" . '$arrGWeb = ' . var_export( $arrGWeb, true ) . ';' . "\n" . '$arrGMeta = ' . var_export( $arrGMeta, true ) . ';' . "\n" . '?>';

//写入文件
file_put_contents($strFilename,$somecontent);

//sql语句
if($_SESSION['install_type']) $sql[] = "DROP TABLE IF EXISTS `".$arrGPdoDB['db_tablepre']."message`;";
$sql[] = "CREATE TABLE IF NOT EXISTS `".$arrGPdoDB['db_tablepre']."message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` tinyint(3) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT '0',
  `author` varchar(30) default NULL,
  `structon_tb` mediumtext,
  `submit_date` datetime DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) unsigned DEFAULT 0 COMMENT '处理状态',
  `user_ip` char(23) default NULL COMMENT '用户IP地址',
  `pass` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `type_id` (`type_id`),
  KEY `submit_date` (`submit_date`)
) ENGINE=MyISAM {$extend} COMMENT='站内消息表' ;";

foreach($sql as $val){
	$objWebInit->db->query($val);
}
if(empty($arrModule)){
	check::AlertExit('在线留言系统安装成功',"$strWEB_ROOT_pre$strWEBADMIN_ROOT/");
}
?>