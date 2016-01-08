<?php
/**
 * SMS发送文件
 *
 */
require_once('../config/config.inc.php');
require_once('../checklogin.php');
@include_once('../../data/sms.inc.php');//导入消息短信接口的基本参数
@include_once('../../data/yx_sms.inc.php');//导入营销短信接口的基本参数

if(empty($arrMBizParam['username'])||empty($arrMBizParam['password'])||empty($yx_arrMBizParam['username'])||empty($yx_arrMBizParam['password'])) {
	check::AlertExit('请您先设置短信接口和营销短信接口的用户名和密码！',-1);
}
$objWebInit = new ArthurXF();
//smarty参数
$objWebInit->arrGSmarty = $arrGSmarty;

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','sms')) {
	check::AlertExit('对不起，您没有读权限',-1);
}


if(!empty($_GET['act'])&&$_GET['act']=='recvSms'){
	$objSms = new BizSMS();
	$objSms->setParam($yx_arrMBizParam);//设置商务领航短信接口的基本参数
	$strResult = $objSms->queryRecvSms();
	if($strResult=='false'){
		check::Alert("接收失败!",-1);
	}else{
		echo $strResult;
		exit;
	}

}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'x','sms')) {
		check::AlertExit('对不起，您没有执行权限',-1);
	}
	if(empty($_POST['spacemark'])) check::AlertExit("错误：间隔符没填!",-1);
    	
	if(empty($_POST['mobiles'])) check::AlertExit("错误：手机号没填!",-1);
  
	if(empty($_POST['content'])) check::AlertExit("错误：短信内容没填!",-1);
	//解析手机号开始
	$strSpacemark = $_POST['spacemark'];
	$strMobiles = $_POST['mobiles'];
	$arrMobiles = explode($strSpacemark,$strMobiles);
	$arrValidMobiles = array();
	foreach($arrMobiles as $v){
		$v = trim($v);
		if(check::CheckMobilePhone($v)){
			$arrValidMobiles[]=$v;
		}
		
	}
	if(count($arrValidMobiles)==0) check::AlertExit("错误：填写的手机号都不合法!",-1);
	$strMobiles = implode(";",$arrValidMobiles);
	//解析手机号完成
	

	$objSms = new BizSMS();	
	$objSms->setParam($yx_arrMBizParam);//设置商务领航短信接口的基本参数
	$strResult = $objSms->sendShortMessage($strMobiles,$_POST['content']);//从页面中获取手机号和短信内容
	$strReturnCode=substr($strResult,0,1);
	if ($strReturnCode=="0"){
		check::Alert("发送成功!");
	} else if ($strReturnCode=="1"){
		check::Alert("用户名或密码错误!",-1);
	} else if ($strReturnCode=="2"){
		check::Alert("余额不足!",-1);
	} else if ($strReturnCode=="3"){
		check::Alert("超过发送最大量100条!",-1);
	} else if ($strReturnCode=="4"){
		check::Alert("此用户不允许发送",-1);
	} else if ($strReturnCode=="5"){
		check::Alert("手机号或发送信息不能为空",-1);
	} else if ($strReturnCode=="6"){
		check::Alert("超过每次提交100个号码的下发限制!",-1);
	} else if ($strReturnCode=="7"){
		check::Alert("超过XX个字,请修改后发送!",-1);
	} else if ($strReturnCode=="8"){
		check::Alert("用户已冻结，请联系客服人员",-1);
	} else if ($strReturnCode=="0009"){
		check::Alert("参数无效!",-1);
	} else {
		check::Alert("未知错误!",-1);
	}
}
$objSms = new BizSMS();	
$objSms->setParam($yx_arrMBizParam);
$message = $objSms->getMsgInfo();

$objSms->setParam($arrMBizParam);
$message_xx = $objSms->getMsgInfo();
// 输出到模板
$arrMOutput["smarty_assign"]['message'] =$message;
$arrMOutput["smarty_assign"]['message_xx'] =$message_xx;
$arrMOutput["smarty_assign"]['strNav'] = '短信按照设定发送_10658';
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'sms/sms_sender_1.htm';
$objWebInit->output($arrMOutput);
?>