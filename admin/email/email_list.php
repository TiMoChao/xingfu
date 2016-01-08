<?php
/**
 * EMAIL营销后台管理栏目搜索抓取文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	email
 */
require_once('../config/config.inc.php');
require_once('../checklogin.php');
require_once('../../emaillist/class/emaillist.class.php');
require_once('../../emaillist/config/var.inc.php');

$objWebInit = new emaillist();
//数据库连接参数
$objWebInit->db();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','email')) {
	check::AlertExit('对不起，您没有权限访问此页',-1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	unset($_POST['okgo']);
	//print_r($_POST);


	$arrWhere = array();
	// 构造搜索条件和翻页参数
	if (!empty($_POST['title'])) {
		$arrWhere[] = "title LIKE '%" . $_POST['title'] . "%' ";
	}
	$arrWhere[] = "pass=1";

	$strWhere = implode(' AND ', $arrWhere);
	if (!empty($strWhere))	$strWhere = ' WHERE '.$strWhere;

	if(!isset($_POST['page'])||$_POST['page']=='') $_POST['page'] = 1;
	$strOrder = ' Order by id ';
	$arrInfoList = $objWebInit->getInfoList($strWhere,$strOrder,($_POST['page']-1)*$_POST['type_id'],$_POST['type_id']);
	unset($arrInfoList['COUNT_ROWS']);

	$arrEmail = array();
	if($arrInfoList) {
		foreach($arrInfoList as $v){
			if(!empty($v['title'])) $arrEmail[] = $v['title'];
		}
		$arrEmail = array_unique($arrEmail);
		$strEmail = implode("\r\n",$arrEmail);
	}
	$arrMOutput["smarty_assign"]['strEmailCount'] = count($arrEmail);
	$arrMOutput["smarty_assign"]['strEmail'] = $strEmail;
	
	$arrMOutput["smarty_assign"]['strEmailPage'] = ++$_POST['page'];
	//print_r($arrEmail);
	//exit;
}

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '订阅邮件Email提取';
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'email/email_list.htm';
$objWebInit->output($arrMOutput);
?>