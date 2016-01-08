<?php
require_once('../config/config.inc.php');
require_once('../../user/class/user.class.php');

$objWebInit = new user();
//smarty参数
$objWebInit->arrGSmarty = $arrGSmarty;

$strFileNameB = __WEB_ROOT.'/data/tourplan/tourplan_type_b.php'; //后台用带├格式化的缓存
$strFileName  = __WEB_ROOT.'/data/tourplan/tourplan_type.php'; //排列后的原始数据缓存
eval(menload_file($strFileNameB,$arrGWeb['MEM_CACHE']));
eval(menload_file($strFileName,$arrGWeb['MEM_CACHE']));

$tourplaMType = $arrMTypeF;
$tourplaType = $arrMType;
unset($arrMTypeF);
unset($arrMType);

$strOrder = ' ORDER BY end_date ASC';
$strTime = date('Y-m-d H:i:s',time());
$strWhere = " where pass>0 and pass<3 and end_date > '".$strTime."'";
$arrInfoList = check::getAPI('tourplan','getInfoList',"$strWhere^$strOrder^0^10^*^^false");
$arrRoue =array();
foreach($arrInfoList as $k => $v){
	$arrRoue = $objWebInit->getRoueList($v['type_roue_id'],$tourplaType,true);
	$arrInfoList[$k]['type_roue'] = $arrRoue[2];
}


$strFileNameB = __WEB_ROOT.'/data/task/task_type_b.php'; //后台用带├格式化的缓存
$strFileName  = __WEB_ROOT.'/data/task/task_type.php'; //排列后的原始数据缓存
eval(menload_file($strFileNameB,$arrGWeb['MEM_CACHE']));
eval(menload_file($strFileName,$arrGWeb['MEM_CACHE']));


require_once( __WEB_ROOT.'/task/config/type.inc.php');

$strOrder = ' ORDER BY begin_date asc';
$strTime = date('Y-m-d',time());
$strWhere = " where pass>0 and pass<3 and begin_date > '".$strTime."'";
$arrTaskList = check::getAPI('task','getInfoList',"$strWhere^$strOrder^0^10^*^^false");
$arrTaskRoue =array();
foreach($arrTaskList as $k => $v){
	$arrTaskRoue = $objWebInit->getRoueList($v['type_roue_id'],$arrMType,true);
	$arrTaskList[$k]['type_roue'] = $arrTaskRoue[2];
}

//print_r($arrTaskList);

$arrMOutput["smarty_assign"]['arrGWeb']['WEB_ROOT_pre'] = 'http://www.5217u.com';

$arrMOutput["smarty_assign"]['strNav'] = '任务活动邮件';
$arrMOutput["smarty_assign"]['arrMTypeF'] = $arrMTypeF;
$arrMOutput["smarty_assign"]['arrMType'] = $arrMType;
$arrMOutput["smarty_assign"]['arrInfoList'] = $arrInfoList;
$arrMOutput["smarty_assign"]['arrTaskList'] = $arrTaskList;
//$arrMOutput["template_file"] = "admin.html";
//$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'email/dingyue.htm';
$arrMOutput['template_file'] = $arrGSmarty['admin_main_dir'].'email/dingyue.htm';
$objWebInit->output($arrMOutput);
?>