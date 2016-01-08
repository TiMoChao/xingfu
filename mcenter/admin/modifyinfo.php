<?php
/**
 * 会员信息栏目编辑删除管理文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id $
 * @package		ArthurXF
 * @subpackage	mcenter
 */
require_once('../config/config.inc.php');
require_once("../class/mcenter.class.php");
require_once('../..'.__WEBADMIN_ROOT.'/checklogin.php');

$objWebInit = new mcenter();
$objWebInit->db();


if ($_SERVER["REQUEST_METHOD"] == "POST"){

	//访问权限检查
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w')) {
		check::AlertExit('对不起，您没有写权限',-1);
	}
	if(!check::CheckUser($_POST['user_name'])) {
		check::AlertExit("输入的用户名必须是4-21字符之间的数字、字母,或7个中文!",-1);
	}
	if(!check::CheckPassword($_POST['password'])) {
		check::AlertExit("输入的密码必须是4-21字符之间的数字、字母!",-1);
	}
	if(empty($_POST['user_id'])){
		check::AlertExit("用户ID不能为空!",-1); 
	}
	if(empty($_POST['nick_name'])){
		check::AlertExit("用户昵称不能为空!",-1); 
	}
	//如果两次密码不一致，说明，需要更新密码
	if($_POST['password'] != $_POST['oldpassword']){
		if(!empty($arrGWeb['user_pass_type'])){
			$_POST['password']=check::strEncryption($_POST['password'],$arrGWeb['jamstr']);
		}
	}
	unset($_POST['oldpassword']);
	
	if($_POST['user_name'] != $_POST['olduser_name']){
		$arr = $objWebInit->getUserWhere(" Where user_name='".$_POST['user_name']."'");
		if (!empty($arr)) {
			check::AlertExit($_POST['user_name'] . ", 该用户名已被占用",-1);
		}
	}
	unset($_POST['olduser_name']);
	
	//生日转换
	$_POST['birthday'] = date('Y-m-d',strtotime($_POST['year'].'-'.$_POST['month'].'-'.$_POST['day']));
	unset($_POST['year']);
	unset($_POST['month']);
	unset($_POST['day']);

	//$arrInfo = array_merge($arrInfo,$_POST);
	// 不能修改 用户名称、用户密码、电子邮件
	//unset($_POST['email']);
	//unset($_POST['user_name']);
	//unset($_POST['password']);
	$objWebInit->saveInfo($_POST,1,0);

	$arrUser = array();
	$arrUser['user_id'] = $_POST['user_id'];
	$arrUser['nick_name'] = $_POST['nick_name'];
	$arrUser['sex'] = $_POST['sex'];
	$arrUser['birthday'] = $_POST['birthday'];
	$strUser = check::getAPIArray($arrUser);
	check::getAPI('user','updateUser',$strUser);

	check::WindowLocation('index.php',$_SERVER["QUERY_STRING"]);
}
if ($_GET['action'] == 'freeze') {
	//访问权限检查
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'d')) {
		check::AlertExit('对不起，您没有删权限',-1);
	}
	$userid	= intval($_GET['id']) ;
	$status = !intval($_GET['status']) ;
	if (empty($userid))	check::AlertExit("Submit Error!(userid empty)",1);

	$objWebInit->statusUser($userid,$status);

	$strUrl = $arrGWeb['WEB_ROOT_pre'].'/mcenter/admin/';
	check::AlertExit('执行完成！',$strUrl);
}
if ($_GET['action'] == 'edit') {
	//访问权限检查
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r')) {
		check::AlertExit('对不起，您没有读权限',-1);
	}
	$userid = intval($_GET['id']) ;

	if (empty($userid))	check::AlertExit("Submit Error!(userid empty)",1);


	$arrUserinfo = $objWebInit->getUser($userid);
	//print_r($arrUserinfo);

	//删除头像
	if($_GET['t'] == 'delphoto'){
		if(!empty($arrUserinfo['user_id'])){
			$arrTemp = array();
			$strOldSFile = $arrGPic['FileSavePath'].'s/'.$arrUserinfo['thumbnail'];
			$strOldBFile = $arrGPic['FileSavePath'].'b/'.$arrUserinfo['thumbnail'];
			$strOldMFile = $arrGPic['FileSavePath'].'m/'.$arrUserinfo['thumbnail'];
			if (is_file($strOldSFile)) {
				unlink($strOldSFile);
			}
			if (is_file($strOldBFile)) {
				unlink($strOldBFile);
			}
			if (is_file($strOldMFile)) {
				unlink($strOldMFile);
			}
			//unset($arrUserinfo['thumbnail']);
			$arrTemp['thumbnail'] = '';
			$arrTemp['user_id'] = $arrUserinfo['user_id'];
			$objWebInit->updateUser($arrTemp);

			//同步user表
			$arrTemp['recommendflag'] = 0;
			$strTemp = check::getAPIArray($arrTemp);
			check::getAPI('user','updateUser',$strTemp);
						check::WindowLocation("?action=edit&id=".$userid."");
		}else{
			check::AlertExit('删除失败！',-1);
		}
	}

	$arrTemp = array();
	foreach($arrGMeta as $k => $v){
		if($k != 'index') {
			$arrTemp[$k]['r'] = $v['name'];
			$arrTemp[$k]['w'] = '写';
			$arrTemp[$k]['d'] = '删';
			$arrTemp[$k]['x'] = '执行';
		}
	}
	$arrTemp['siteset']['r'] = '系统设定';
	$arrTemp['pay']['r'] = '在线支付';
	$arrTemp['seo']['r'] = 'SEO优化';
	$arrTemp['backup']['r'] = '数据备份';
	$arrTemp['tools']['r'] = '系统工具';
	$arrTemp['mail']['r'] = '邮件营销';
	$arrTemp['sms']['r'] = '短信营销';
	$arrTemp['count']['r'] = '统计数据';

	if(!array_key_exists("user_popedom",$arrUserinfo)){
		$arruserinfo["user_popedom"]=array();
	}
	//生日转换：年-月-日
	$arrBDTemp = explode('-',$arrUserinfo['birthday']);
	$arrUserinfo['year']	= $arrBDTemp[0];
	$arrUserinfo['month']	= $arrBDTemp[1];
	$arrUserinfo['day']		= $arrBDTemp[2];

	// 输出到模板
	$arrMOutput["smarty_assign"]['arrData'] = $arrUserinfo;
	$arrMOutput["smarty_assign"]['arrGMeta'] = $arrTemp;
	$arrMOutput["smarty_assign"]['arrMType'] = $arrMType;//性别
	$arrMOutput["template_file"] = "admin.html";
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'user_edit.htm';
	$objWebInit->output($arrMOutput);
}
?>
