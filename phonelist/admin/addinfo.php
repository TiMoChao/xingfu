<?php
/**
 * 5117手机管理后台管理栏目新增文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	phonelist
 */
require_once('../config/config.inc.php');
require_once("../class/phonelist.class.php");
require_once('../..'.__WEBADMIN_ROOT.'/checklogin.php');

$objWebInit = new phonelist();
$objWebInit->db();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w')) {
	check::AlertExit('对不起，您没有写权限',-1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if (empty($_POST['type_id'])||empty($_POST['title'])){
		check::AlertExit("错误：有必填选项没填!",-1);
	}
	if(!check::CheckMobilePhone($_POST['title'])) check::AlertExit("错误：手机格式不对!",-1);
	
	//if($_POST['title'] != '') $_POST['title_md5'] = md5($_POST['title']);
	//判断是否发布重复信息
	$arrTemp = $objWebInit->getInfoList("where title='$_POST[title]'","", 0, 1);
	if($arrTemp['COUNT_ROWS']!=0) check::AlertExit("错误：相同的信息请不要重复发布！",-1);

	
	$objWebInit->saveInfo($_POST,0,false);

	//$objWebInit->updateCache($objWebInit->lastInsertIdG(),$_POST['type_id'],$arrMOutput);

	check::WindowLocation('index.php','page='.$_GET['page']);
}

if(!is_array($arrMType)||empty($arrMType)){
	$arrMType = $objWebInit->getTypeList();
	$arrMType = $objWebInit->formatTypeList(0,$arrMType);
}

// 输出到模板
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['arrMType'] = $arrMType;
$arrMOutput["smarty_assign"]['arrTypeB'] = $arrMTypeB;
$arrMOutput["smarty_assign"]['arrPhoneType'] = $arrPhoneType;
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'submit.htm';
$objWebInit->output($arrMOutput);
?>