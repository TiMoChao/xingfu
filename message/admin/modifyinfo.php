<?php
/**
 * 网站留言后台管理栏目修改文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	message
 */
require_once('../config/config.inc.php');
require_once("../class/message.class.php");
require_once ('../..'.__WEBADMIN_ROOT.'/checklogin.php');

$objWebInit = new message();
$objWebInit->db();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

// 取得文章信息
$arrInfo = $objWebInit->getInfo($_REQUEST['id']);


if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$arrInfo['id'] = $_POST['id'];
	$arrInfo['state'] = $_POST['state'];
	$arrInfo['remark'] = $_POST['remark'];
	$objWebInit->saveInfo($arrInfo,1);
	check::WindowLocation('index.php',$_SERVER["QUERY_STRING"]);
}



// 输出到模板
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['arrData'] = $arrInfo;
$arrMOutput["smarty_assign"]['arrGState'] = $arrGState;
$arrMOutput["smarty_assign"]['action_type'] = "save";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'submit.htm';
$objWebInit->output($arrMOutput);
?>