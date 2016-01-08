<?php
/*
 *
 * 网站框架首页文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 */
 
require_once('config/config.inc.php');
$objWebInit = new ArthurXF();

if(empty($arrGPdoDB['db_name']) || empty($arrGPdoDB['db_user'])){
	header("Location: ./install/");
	exit;
}
//数据库连接参数
$objWebInit->db();
$objShared = System_SharedMemory::factory();
//$arrCache_log = $objShared->get($arrGPdoDB['db_name'].'login');
$arrCache_log = $objShared->get('5217ulogin');


//取出ads栏目在首页设置的图像广告
//$strWhere = "where pass=1 and position='index'";
//$arrBanner = check::getAPI('ads','getInfoList',"$strWhere^^^^*^^0");

//输出到模板
$arrMOutput["smarty_assign"]['arrCache_log'] = $arrCache_log;
$arrMOutput["smarty_assign"]['arrBanner'] = $arrBanner;
$arrMOutput["smarty_assign"]['MAIN'] = 'index.html';
$arrMOutput["smarty_assign"]['is_index'] = '1';
$objWebInit->output($arrMOutput);
?>