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
require_once('../../phonelist/class/phonelist.class.php');
require_once('../../phonelist/config/var.inc.php');

$objWebInit = new phonelist();

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
	$arrWhere[] = "title != ''";
	// 构造搜索条件和翻页参数
	if (!empty($_POST['title'])) {
		$arrWhere[] = "title LIKE '%" . $_POST['title'] . "%' ";
	}
	if (!empty($_POST['pass']) && ($_POST['pass'] == '1' || $_POST['pass'] == '0')) {
		$arrWhere[] = "pass='".$_POST['pass']."'";
	}

	$strWhere = implode(' AND ', $arrWhere);
	if (!empty($strWhere))	$strWhere = ' WHERE '.$strWhere;
	if(!isset($_POST['page'])||$_POST['page']=='') $_POST['page'] = 1;
	$strOrder = '';
	$arrInfoList = $objWebInit->getInfoList($strWhere,$strOrder,($_POST['page']-1)*$_POST['type_id'],$_POST['type_id'],'title',false);
	unset($arrInfoList['COUNT_ROWS']);

	$arrSMS = array();
	if($arrInfoList) {
		foreach($arrInfoList as $v){
			if(!empty($v['title']))	$arrSMS[] = $v['title'];
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
$arrMOutput["smarty_assign"]['strNav'] = '本站订阅手机号码提取';
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'sms/sms_user.htm';
$objWebInit->output($arrMOutput);
?>