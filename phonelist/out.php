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
//require_once('../'.__WEBADMIN_ROOT.'/checklogin.php');

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

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (empty($_POST['title'])){
		check::AlertExit("请填写手机!",-1);
	}
	if (empty($_POST['yzm'])){
		check::AlertExit("请填写验证码!",-1);
	}
	if(!check::CheckMobilePhone($_POST['title'])){
		check::AlertExit("请填写正确的手机号码!",-1);
	}
	if($_POST['mobilecode']!=$_POST['yzm']){
		check::AlertExit("验证码输入错误!",-1);
	}else{
		$arrTemp = $objWebInit->getInfoWhere("where title='$_POST[title]'");
		if(empty($arrTemp)){//存在
			check::AlertExit("该手机还没订阅哦!",-1);
		}else{
			unset($_POST);
			unset($_POST['button']);
			unset($_POST['button2']);
			unset($_POST['yzm']);
			unset($_POST['mobilecode']);
			$_POST['pass']='0';
			$_POST['submit_date']=date("Y-m-d H:i:s");
			$_POST = array_merge($arrTemp,$_POST);
			$objWebInit->saveInfo($_POST,1);
		}		
	}
}

$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'out.html';
$objWebInit->output($arrMOutput);

?>