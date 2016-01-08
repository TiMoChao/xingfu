<?php
/**
 * 网站留言 列表文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	message
 */

//header ("Cache-Control: no-cache, must-revalidate");
//header ("Pragma: no-cache");
require_once('config/config.inc.php');
require_once("class/message.class.php");

$objWebInit = new message();
$objWebInit->db();

//安装检查
if($arrGMeta['message']['name'] === null){
	echo 'BIWEB网站系统网站留言功能栏目尚未安装，如需安装成配置文件分类，请配置好config/type.inc.php后，<a href=install.php>点击安装</a>，如要使用数据库分类，直接<a href=install.php>点击安装</a>';
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){

	if(empty($_POST['contact'])) check::AlertExit('对不起，姓名必须填写!',-1);
	if(empty($_POST['tel'])) check::AlertExit('对不起，联系电话必须填写!',-1);
	if(empty($_POST['email'])) check::AlertExit('对不起，E-Mail必须填写!',-1);
	if(empty($_POST['title'])) check::AlertExit('对不起，留言标题必须填写!',-1);
	if(empty($_POST['intro']))	check::AlertExit('对不起，留言内容必须填写!!',-1);
	$strIP = check::getip();
	$_POST['user_ip'] = $strIP;
	$objWebInit->saveInfo($_POST,0);
	check::AlertExit("",$arrGWeb['WEB_ROOT_pre']."/message/");
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