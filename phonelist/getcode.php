<?php
/**
 * 手机管理 列表文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	phonelist
 */
require_once('config/config.inc.php');
require_once("class/phonelist.class.php");
require_once('../data/sms.inc.php');//导入商务领航短信接口的基本参数

$objWebInit = new phonelist();
//数据库连接参数
$objWebInit->setDBG($arrGPdoDB);
//smarty参数
$arrGSmarty['caching'] = false;
$objWebInit->arrGSmarty = $arrGSmarty;
//翻页参数
$objWebInit->arrGPage = $arrGPage;
$objWebInit->db();

$arrWhere = array();
$arrLink = array();
$arrWhere[] = "pass='1'";

$strLink = '';

if (empty($_GET['page'])) {
	$intPage = 1 ;
} else {
	$intPage = intval($_GET['page']);
}
$strWhere = implode(' AND ',$arrWhere);
$strWhere = 'where '.$strWhere;
	
if($_GET['code']=='domobilecode'){
	setcookie('intMobile',$_GET['title'],time()+1);
	$intMobileCode=rand(10000,99999);
	
	if($_COOKIE['intMobile']){
		//弹出js警告
		echo json_encode(array(	
			"status"=>"-1",
			"data" => "",
			"msg" => "请在两分钟以后再获取手机验证码",
		));
		exit;
	}else{
		//发手机验证码信息
		$objSms = new BizSMS();
		$objSms->setParam($arrMBizParam);//设置商务领航短信接口的基本参数
		$strResult = $objSms->sendShortMessage($_GET['title'],'您好，您现在正在获取手机验证码，您的短信验证码是：'.$intMobileCode);
		echo json_encode(array(	
			"status"=>"1",
			"data" => $intMobileCode,
			"msg" => "验证码已发送至您的手机，请注意查收",
		));
		exit;
	}
}
?>