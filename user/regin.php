<?php
/**
 * 会员栏目注册文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	user
 */
require_once('config/config.inc.php');
require_once('class/user.class.php');

$objWebInit = new user();
$objWebInit->db();


if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	/*
	if(!check::validEmail($_POST['email'])){
		check::AlertExit("错误：请输入有效的电子邮箱!",-1);
	}
	*/

	if(!check::CheckUser($_POST['user_name'])) {
		check::AlertExit("输入的用户名必须是4-21字符之间的数字、字母!",-1);
	}

	$strWhere = "where email='".$_POST['email']."'";
	$arrInfo = check::getAPI('mcenter','getUserWhere',"$strWhere^user_id");
		if(!empty($arrInfo)){
		check::AlertExit("错误：该邮箱已被使用!",-1);
	}

	$strWhere = "where user_name='".$_POST['user_name']."'";
	$arrInfo = check::getAPI('mcenter','getUserWhere',"$strWhere^user_id");	
	if(!empty($arrInfo)){
		check::AlertExit("错误：用户名已被注册!",-1);
	}

	$arrIllegal=array('admin','管理员','客服');
	foreach($arrIllegal as $v){
		if(stripos($_POST['user_name'],$v)!==false) {
			check::AlertExit("输入的登录帐号包含非法字符!",-1);
		}
	}

	if(!is_numeric($_POST['mobile']) or strlen($_POST['mobile'])>12) {
		check::AlertExit("电话必须为数字并且不能大于12!",-1);
	}
	
	if(!check::CheckPost($_POST['postcode'])) {
		check::AlertExit("邮编不符合要求",-1);
	}

	if(!check::CheckPassword($_POST['password'])) {
		check::AlertExit("输入的密码必须是4-21字符之间的数字、字母!",-1);
	}

	if($_POST['password']!=$_POST['password_c']) {
		check::AlertExit("两次输入的密码不一致!",-1);
	}

	if($_POST['authCode'] != $_SESSION['captcha']){
		check::AlertExit("错误：验证码不匹配!",-1);
	}
	
	$arrData = array();
	$arrData['user_name'] = strip_tags(trim($_POST['user_name']));
	if(!empty($arrGWeb['user_pass_type']))	$arrData['password'] = check::strEncryption($_POST['password'],$arrGWeb['jamstr']);
	else $arrData['password'] = $_POST['password'];
	$arrData['real_name'] = strip_tags(trim($_POST['real_name']));
	$arrData['nick_name'] = strip_tags(trim($_POST['nick_name']));
	$arrData['postcode'] = $_POST['postcode'];
	$arrData['mobile'] = $_POST['mobile'];
	$arrData['email'] = $_POST['email'];
	$arrData['corp_name'] = $_POST['corp_name'];
	$arrData['contact_address'] = $_POST['contact_address'];
	$arrData['question'] = $_POST['question'];
	$arrData['answer'] = $_POST['answer'];
	$arrData['sex'] = $_POST['sex'];
	$arrData['tel'] = $_POST['tel'];
	$arrData['province'] = $_POST['province'];
	$arrData['city'] = $_POST['city'];
	$arrData['area'] = $_POST['area'];
	$arrData['user_ip']		= check::getIP();
	$arrData['submit_date']	= date('Y-m-d H:i:s');
	$arrData['session_id'] = session_id();
	
	$intID = $objWebInit->saveInfo($arrData,0,false,true);
	if ($intID) {
		$_SESSION['user_id']	= $intID;
		$_SESSION = array_merge($_SESSION,$arrData);

		$arrTemp['user_id'] = $intID;
		$arrTemp['add_date'] = date('Y-m-d H:i:s');
		$strData = check::getAPIArray($arrTemp);
		check::getAPI('mcenter','updateUser',$strData);		

		echo "<script>alert('注册完成');window.location='{$arrGWeb['WEB_ROOT_pre']}/';</script>";
		exit ();
	} else {
		check::AlertExit('注册失败',-1);
	}
}

$strTitle = $arrGWeb['name'].'-注册';
$strDescription = $strTitle;
$strKeywords = $strTitle;

// 输出到模板
$arrMOutput['smarty_assign']['Title'] = $strTitle.' - '.$arrGWeb['name'];
$arrMOutput['smarty_assign']['Description'] = $strDescription.' - '.$arrGWeb['name'];
$arrMOutput['smarty_assign']['Keywords'] = $strKeywords.' - '.$arrGWeb['name'];
$arrMOutput["smarty_assign"]['arrGWeb']['css'][] = 'reg.css';
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'register.html';
$objWebInit->output($arrMOutput);
?>
