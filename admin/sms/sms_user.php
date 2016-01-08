<?php
/**
 * EMAIL营销后台管理栏目搜索抓取文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	sms
 */
require_once('../config/config.inc.php');
require_once('../checklogin.php');
require_once('../../mcenter/class/mcenter.class.php');
require_once('../../mcenter/config/var.inc.php');

$objWebInit = new mcenter();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','sms')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'x','sms')) {
		check::AlertExit('对不起，您没有执行权限',-1);
	}
	unset($_POST['okgo']);

	//数据库连接
	$objWebInit->db();

	$arrWhere=array();
	$arrWhere[] = "mobile != ''";
	// 构造搜索条件和翻页参数
	if (!empty($_POST['title'])) {
		$arrWhere[] = "mobile LIKE '%" . $_POST['title'] . "%' ";
	}
	if (!empty($_POST['pass']) && ($_POST['pass'] == '1' || $_POST['pass'] == '0')) {
		$arrWhere[] = "pass='".$_POST['pass']."'";
	}

	$strWhere = implode(' AND ', $arrWhere);
	if (!empty($strWhere))	$strWhere = ' WHERE '.$strWhere;
	if(!isset($_POST['page'])||$_POST['page']=='') $_POST['page'] = 1;
	$strOrder = ' Order by user_id ';
	$arrInfoList = $objWebInit->getUserList($strWhere,$strOrder,($_POST['page']-1)*$_POST['type_id'],$_POST['type_id'],'user_id,mobile',false);
	unset($arrInfoList['COUNT_ROWS']);

	$arrSMS = array();
	if($arrInfoList) {
		foreach($arrInfoList as $v){
			if(!empty($v['mobile']))	$arrSMS[] = $v['mobile'];
		}
		$arrSMS = array_unique($arrSMS);
		$strSMS = implode("\r\n",$arrSMS);
	}
	$arrMOutput["smarty_assign"]['strSMSCount'] = count($arrSMS);
	$arrMOutput["smarty_assign"]['strSMS'] = $strSMS;
	$arrMOutput["smarty_assign"]['strSMSPage'] = ++$_POST['page'];
//	echo '<pre>';print_r($arrSMS);
//	exit;
}

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '本站会员手机号码提取';
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'sms/sms_user.htm';
$objWebInit->output($arrMOutput);
?>