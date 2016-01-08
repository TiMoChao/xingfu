<?php
/**
 * 会员栏目编辑删除管理文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id $
 * @package		ArthurXF
 * @subpackage	user
 */
require_once('../config/config.inc.php');
require_once("../class/user.class.php");
require_once('../..'.__WEBADMIN_ROOT.'/checklogin.php');

$objWebInit = new user();
$objWebInit->db();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w')) {
	check::AlertExit('对不起，您没有写权限',-1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	
	//mcenter，user两张表共有信息已mcenter为准 此段程序不能修改user表信息 修改mcenter表信息时如果和user表为共有信息user表也会修改		

	//生日转换
	$_POST['birthday'] = date('Y-m-d',strtotime($_POST['year'].'-'.$_POST['month'].'-'.$_POST['day']));
	unset($_POST['year']);
	unset($_POST['month']);
	unset($_POST['day']);

	$arrData = array();
	if($_POST['user_group']!=3){
		$arrData['user_popedom'] = $_POST['user_popedom'];
	}
	//如果两次密码不一致，说明，需要更新密码
	if($_POST['password'] != $_POST['oldpassword']){
		if(!empty($arrGWeb['user_pass_type'])){
			$_POST['password']=check::strEncryption($_POST['password'],$arrGWeb['jamstr']);
		}
	}
	unset($_POST['oldpassword']);
	$arrData['user_id'] = $_POST['user_id'];
	$arrData['birthday'] = $_POST['birthday'];
	$arrData['sex'] = $_POST['sex'];
	$arrData['user_group'] = $_POST['user_group'];
	unset($_POST);

	$objWebInit->saveInfo($arrData,1,false);
	check::AlertExit('修改成功！',$arrGWeb['WEB_ROOT_pre'].'/mcenter/admin/');
}

if ($_GET['action'] == 'edit') {

	$userid = intval($_GET['id']) ;
	if (empty($userid))	check::AlertExit("Submit Error!(userid empty)",1);

	$arrUserinfo = $objWebInit->getUser($userid,'*','',false);

	//mcenter，user两张表共有信息已mcenter为准	
	$strWhere = ' WHERE user_id ='.$userid;
	$field = 'user_name,password,real_name';
	$arrMcInfo = check::getAPI('mcenter','getUserWhere',"$strWhere^$field");
	
	$arrUserinfo = array_merge($arrUserinfo,$arrMcInfo);

	$arrTemp = array();
	foreach($arrGMeta as $k => $v){
		if($k != 'index') $arrTemp[$k] = $v['name'];
	}


	//生日转换：年-月-日
	$arrBDTemp = explode('-',$arrUserinfo['birthday']);
	$arrUserinfo['year']	= $arrBDTemp[0];
	$arrUserinfo['month']	= $arrBDTemp[1];
	$arrUserinfo['day']		= $arrBDTemp[2];

	// 输出到模板
	$arrMOutput["smarty_assign"]['get'] = $_GET;
	$arrMOutput["smarty_assign"]['arrData'] = $arrUserinfo;
	$arrMOutput["smarty_assign"]['arrGMeta'] = $arrTemp;
	$arrMOutput["smarty_assign"]['arrMType'] = $arrMType;//性别
	$arrMOutput["template_file"] = "admin.html";
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'user_edit.htm';
	$objWebInit->output($arrMOutput);
}
?>