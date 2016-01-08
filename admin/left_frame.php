<?php
/**
 * 会员后台管理栏目首页文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	admin
 */
require_once('config/config.inc.php');
require_once('checklogin.php');

$objWebInit = new ArthurXF();

$arrPopedom = $_SESSION['user_popedom'];
//设定常规管理模块管理权限
if(($_SESSION['user_group'] == 3) or (($_SESSION['user_group'] == 2) and (array_key_exists("siteset", $arrPopedom)))){
	$arrPop['siteset'] = 1;
}else{
	$arrPop['siteset'] = 0;
}
if(($_SESSION['user_group'] == 3) or (($_SESSION['user_group'] == 2) and (array_key_exists("fetch", $arrPopedom)))){
	$arrPop['fetch'] = 1;
}else{
	$arrPop['fetch'] = 0;
}
if(($_SESSION['user_group'] == 3) or (($_SESSION['user_group'] == 2) and (array_key_exists("backup", $arrPopedom)))){
	$arrPop['backup'] = 1;
}else{
	$arrPop['backup'] = 0;
}
if(($_SESSION['user_group'] == 3) or (($_SESSION['user_group'] == 2) and (array_key_exists("seo", $arrPopedom)))){
	$arrPop['seo'] = 1;
}else{
	$arrPop['seo'] = 0;
}
if(($_SESSION['user_group'] == 3) or (($_SESSION['user_group'] == 2) and (array_key_exists("tools", $arrPopedom)))){
	$arrPop['tools'] = 1;
}else{
	$arrPop['tools'] = 0;
}
if(($_SESSION['user_group'] == 3) or (($_SESSION['user_group'] == 2) and (array_key_exists("email", $arrPopedom)))){
	$arrPop['email'] = 1;
}else{
	$arrPop['email'] = 0;
}
if(($_SESSION['user_group'] == 3) or (($_SESSION['user_group'] == 2) and (array_key_exists("count", $arrPopedom)))){
	$arrPop['count'] = 1;
}else{
	$arrPop['count'] = 0;
}
$intTemp = 0;
foreach($arrGMeta as $k => $v){
	//设定网站功能栏目管理权限
	if($k == 'index') continue;
	if(($_SESSION['user_group'] == 3) or (($_SESSION['user_group'] == 2) and (array_key_exists($k, $arrPopedom)))){
		$arrPop[$v['name']] = 1;
		$intTemp = 1;
	}else{
		$arrPop[$v['name']] = 0;
	}
	//设定网站后台管理左栏显示栏目
	if(!empty($v['admin']) && $v['admin'] != ''){
		$arrLeft[$v['name']] = $v['admin'];
	}
	if(!empty($v['fetch']) && $v['fetch'] != '') $arrFetch[$k] = $v['fetch'];
}
if($intTemp) $arrPop['webmanage'] = 1;
else $arrPop['webmanage'] = 0;
if(empty($arrFetch)){
	$arrPop['fetch'] = 0;
}else $arrMOutput["smarty_assign"]['arrFetch'] = $arrFetch;

if(is_file('../archives/config/type.inc.php')){
	include_once('../archives/config/type.inc.php');
	$arrMOutput["smarty_assign"]['arrMArchivesType'] = $arrMArchivesType;
}

//smarty输出
$arrMOutput["smarty_assign"]['arrLeft'] = $arrLeft;
$arrMOutput["smarty_assign"]['arrPop'] = $arrPop;
$arrMOutput["template_file"] = "left_frame.htm";
$objWebInit->output($arrMOutput);
?>