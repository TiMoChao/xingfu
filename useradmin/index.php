<?php
/**
 * 用户后台首页文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 */
require_once('config/config.inc.php');
require_once("../user/class/user.class.php");
require_once("checklogin.php");

$objWebInit = new user();
$objWebInit->db();


if ($_SERVER["REQUEST_METHOD"] == "POST"){	
	unset($_POST['user_name']);
	unset($_POST['email']);	//禁止修改邮箱和登录帐号
	
	$arrIllegal=array('admin','管理员','客服');
	foreach($arrIllegal as $v){
		if(stripos($_POST['real_name'],$v)!==false) {
			check::AlertExit("输入的昵称包含非法字符!",-1);
		}
	}
	if(!is_numeric($_POST['mobile']) or strlen($_POST['mobile'])>12) {
		check::AlertExit("电话必须为数字并且不能大于12!",-1);
	}
	
	if(!check::CheckPost($_POST['postcode'])) {
		check::AlertExit("邮编不符合要求",-1);
	}

	$arrUserTableData = array();
	$arrUserTableData['user_id'] = $_SESSION['user_id'];
	$arrUserTableData['nick_name'] = strip_tags($_POST['real_name']);	//昵称用真实姓名代替	

	$strDataInfo = check::getAPIArray($arrUserTableData);
	check::getAPI('user','updateUser',$strDataInfo);


	$_POST['user_id'] = $_SESSION['user_id'];	
	foreach($_POST as $key=>$value){
		$_SESSION[$key] = $value;
	}
	$_SESSION['nick_name'] = $_POST['real_name'];
	
	$_POST['nick_name'] = $_POST['real_name'];
	$strData = check::getAPIArray($_POST);
	check::getAPI('mcenter','updateUser',$strData);
	check::AlertExit('修改成功!',-1);
}

//输出到模板
$arrMOutput["smarty_assign"]['arrData'] = $arrInfo;
$arrMOutput["smarty_assign"]['arrGWeb']['css'][] = 'reg.css';
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'index.html';
$objWebInit->output($arrMOutput);
?>