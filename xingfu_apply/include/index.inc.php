<?php
/**
 * 网站留言 列表文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	xingfu_apply
 */

//header ("Cache-Control: no-cache, must-revalidate");
//header ("Pragma: no-cache");
require_once('config/config.inc.php');
require_once("class/xingfu_apply.class.php");

$objWebInit = new xingfu_apply();
$objWebInit->db();

//安装检查
if($arrGMeta['xingfu_apply']['name'] === null){
	echo 'BIWEB网站系统网站留言功能栏目尚未安装，如需安装成配置文件分类，请配置好config/type.inc.php后，<a href=install.php>点击安装</a>，如要使用数据库分类，直接<a href=install.php>点击安装</a>';
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if(empty($_POST['name']) || $_POST['name'] == '姓名') check::AlertExit('对不起，姓名必须填写!',-1);
	if(empty($_POST['sex']) || $_POST['sex'] == '性别') check::AlertExit('对不起，性别必须填写!',-1);
	if(empty($_POST['age']) || $_POST['age'] == '年龄') check::AlertExit('对不起，年龄必须填写!',-1);
	if(empty($_POST['iphone']) || $_POST['iphone'] == '联系电话') check::AlertExit('对不起，联系电话必须填写!',-1);
	if(empty($_POST['class']) || $_POST['class'] == '所报班级')	check::AlertExit('对不起，所报班级必须填写!!',-1);
    if(empty($_POST['address']) || $_POST['address'] == '家庭住址')	check::AlertExit('对不起，家庭地址必须填写!!',-1);
    if(empty($_POST['ethnic']) || $_POST['ethnic'] == '民族')	check::AlertExit('对不起，民族必须填写!!',-1);
	$strIP = check::getip();
	$_POST['user_ip'] = $strIP;
	$objWebInit->saveInfo($_POST,0);
	check::AlertExit("",$arrGWeb['WEB_ROOT_pre']."/xingfu_apply/");
}

if(!isset($_GET['page'])||$_GET['page']=='') $_GET['page'] = $arrGPage['page'];

$arrInfoList = $objWebInit->getInfolist("where pass=1","ORDER BY submit_date DESC",($_GET['page']-1)*$arrGPage['page_size'],$arrGPage['page_size'],'*','');
$intRows = $arrInfoList['COUNT_ROWS'];
unset($arrInfoList['COUNT_ROWS']);

//静态url处理
$strLink = '';
if($arrGWeb['URL_static']){
	if (!empty($arrLink)) $strLink = str_replace('=','-',implode('-',$arrLink));
}else{
	if (!empty($arrLink)) $strLink = implode('&',$arrLink);
}

//翻页跳转link
$strPage= $objWebInit->makeInfoListPage($intRows,$strLink,$link_type=$arrGWeb['URL_static'],'4');

$arrMOutput["smarty_assign"]['arrInfoList'] = $arrInfoList;
$arrMOutput["smarty_assign"]['strPage'] = $strPage;
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'index.html';
$objWebInit->output($arrMOutput);
?>