<?php
/**
 * 会员信息栏目新增管理文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id $
 * @package		ArthurXF
 * @subpackage	mcenter
 */
require_once('../config/config.inc.php');
require_once("../class/mcenter.class.php");
require_once ('../..'.__WEBADMIN_ROOT.'/checklogin.php');

$objWebInit = new mcenter();
$objWebInit->db();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w')) {
	check::AlertExit('对不起，您没有写权限',-1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if(!check::CheckUser($_POST['user_name'])) {
		check::AlertExit("输入的用户名必须是4-21字符之间的数字、字母,或7个中文!",-1);
	}
	if(!check::CheckPassword($_POST['password'])) {
		check::AlertExit("输入的密码必须是4-21字符之间的数字、字母!",-1);
	}
	if(!check::CheckEmailAddr($_POST['email'])) {
		check::AlertExit("输入的email必须是合法的email!",-1);
	}
	if(!check::CheckMobilePhone($_POST['mobile'])) {
		check::AlertExit("输入的手机必须是合法的手机号码!",-1);
	}
	
	$arr = $objWebInit->getUserWhere(" Where user_name='".$_POST['user_name']."'");
	if (!empty($arr)) {
		check::AlertExit($_POST['user_name'] . ", 该用户名已被占用",-1);
	}
	
	$arr = $objWebInit->getUserWhere(" Where email='".$_POST['email']."'");
	if (!empty($arr)) {
		check::AlertExit($_POST['email'] . ", 该email已被占用",-1);
	}

	$arr = $objWebInit->getUserWhere(" Where mobile='".$_POST['mobile']."'");
	if (!empty($arr)) {
		check::AlertExit($_POST['mobile'] . ", 该手机已被占用",-1);
	}

	$_POST['user_ip'] = check::getIP();

	
	//图片上传
	for($i=0;$i<count($_FILES);$i++){
		$num = $i;
		if($_FILES['Filedata'.$num]['name'] != ""){
			$_POST['photo'.$i] = $objWebInit->uploadInfoImage($_FILES['Filedata'.$num],$num,$_POST['csize'.$i]);
			unset($_POST['csize'.$i]);
		}
		unset($_POST['savefilename'.$i]);
	}

	//生日转换
	$_POST['birthday'] = date('Y-m-d',strtotime($_POST['year'].'-'.$_POST['month'].'-'.$_POST['day']));
	unset($_POST['year']);
	unset($_POST['month']);
	unset($_POST['day']);

	//会员信息密码处理
	if(!empty($arrGWeb['user_pass_type'])){
		$_POST['password']=check::strEncryption($_POST['password'],$arrGWeb['jamstr']);
	}
	$objWebInit->saveInfo($_POST,0);
	check::WindowLocation('./index.php', '1');
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

// 输出到模板
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['arrGMeta'] = $arrTemp;
$arrMOutput["smarty_assign"]['arrMType'] = $arrMType;//性别
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'user_edit.htm';
$objWebInit->output($arrMOutput);
?>