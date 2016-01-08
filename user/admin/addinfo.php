<?php
/**
 * 会员栏目新增管理文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id $
 * @package		ArthurXF
 * @subpackage	user
 */
require_once('../config/config.inc.php');
require_once("../class/user.class.php");
require_once ('../..'.__WEBADMIN_ROOT.'/checklogin.php');

$objWebInit = new user();
$objWebInit->db();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w',$arrGWeb['module_id'])) {
	check::AlertExit('对不起，您没有写权限',-1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$strPassword	= trim($_POST['password']) ;
	$strOldPassword= trim($_POST['oldpassword']) ;
	$strUser_name	= trim($_POST['user_name']);

	$_POST['user_ip'] = check::getIP();
	
	if($_POST['user_group']==3){
		unset($_POST['user_popedom']);
	}

	if (empty($strUser_name)) {
		check::AlertExit("用户名不能为空!",-1);
	}
	if (empty($strPassword)) {
		check::AlertExit("密码不能为空!", -1);
	}
	if (empty($_POST['nick_name'])) {
		check::AlertExit("用户昵称不能为空!",-1);
	}	

	$strWhere = "where user_name='".$_POST['user_name']."'";
	$arrInfo = check::getAPI('mcenter','getUserWhere',"$strWhere^user_id");	
	if(!empty($arrInfo)){
		check::AlertExit("错误：用户名已被注册!",-1);
	}
	
	//生日转换
	$_POST['birthday'] = date('Y-m-d',strtotime($_POST['year'].'-'.$_POST['month'].'-'.$_POST['day']));
	unset($_POST['year']);
	unset($_POST['month']);
	unset($_POST['day']);

	//会员密码处理
	if(!empty($arrGWeb['user_pass_type'])){
		$_POST['password']=check::strEncryption($_POST['password'],$arrGWeb['jamstr']);
	}

	$intID = $objWebInit->saveInfo($_POST,0,false,true);
	if ($intID) {
		$arrData['user_id'] = $intID;
		$arrData['add_date'] = date('Y-m-d H:i:s');
		$strData = check::getAPIArray($arrData);
		check::getAPI('mcenter','updateUser',$strData);		
	} else {
		check::AlertExit('注册失败',-1);
	}
	check::WindowLocation($arrGWeb['WEB_ROOT_pre'].'/mcenter/admin/index.php');
}

$arrTemp = array();
foreach($arrGMeta as $k => $v){
	if($k != 'index') $arrTemp[$k] = $v['name'];
}

// 输出到模板
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['arrGMeta'] = $arrTemp;
$arrMOutput["smarty_assign"]['arrMType'] = $arrMType;//性别
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'user_edit.htm';
$objWebInit->output($arrMOutput);
?>