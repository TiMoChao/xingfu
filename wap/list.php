<?php
/**
 * 商用物业搜索列表文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	wap
 */
require_once('config/config.inc.php');
require_once("class/wap.class.php");

$objWebInit = new wap();

if (empty($_GET['page'])) {
	$intPage = 1 ;
} else {
	$intPage = intval($_GET['page']);
}
$arrWhere = array();
$arrLink = array();
$arrWhere[] = "pass='1'";

foreach($arrGMeta as $k => $v){
	if(in_array($k,array('useradmin','uploadfile','templates','plug-in','html','data','config','compile','cache',substr(__WEBADMIN_ROOT,1),'install'))){
		continue;
	}
	
	if(in_array($k,array('wap','user','logs','ads','links','emaillist','phonelist','mcenter','archives','keywords','rss','sitemap','guest'))){
		//$arrModuleDirs[$k]['id'] = $v;
		//$arrModuleDirs[$k]['state'] = 2;
		continue;
	}
	if($v['cache'] != 1)  continue;
	
	if(!empty($v)){
		$arrModuleDirs[$k]['id'] = $k;
		$arrModuleDirs[$k]['cache'] = $v['cache'];
		$arrModuleDirs[$k]['name'] = $v['name'];
	}
}
$isOK = 0;
foreach($arrModuleDirs as $v){
	if($_GET['mod'] == $v['id']) $isOK = 1;
}

if(empty($isOK)) check::AlertExit('未知栏目',-1);

if (empty($_GET['mod'])) {
	include_once('include/title.php');
	include_once('include/head.php');
	$myText = new HAW_text($arrGWeb['name'].'欢迎您!');
	$objHaw->add_text($myText);
	include_once('include/foot.php');
	exit;
}
if (!empty($_GET['mod'])) {
	$strModuleID = strval($_GET['mod']);
	include_once('../'.$strModuleID.'/config/var.inc.php');
	$arrLink[] = 'mod=' . $strModuleID;
	$_SESSION['wapmod'] = $strModuleID;
}
$strWhere = implode(' AND ',$arrWhere);
$strWhere = 'where '.$strWhere;
$intStart = ($intPage-1)*$objWebInit->arrGPage['page_size'];
$arrInfoList = check::getAPI($strModuleID,"getInfoList","$strWhere^ ORDER BY topflag DESC,submit_date DESC^$intStart^$arrGPage[page_size]^id,title,clicktimes");

$intRows = $arrInfoList['COUNT_ROWS'];
unset($arrInfoList['COUNT_ROWS']);

//翻页跳转
if (!empty($arrLink)) $strLink = implode('&',$arrLink);
$arrListPage= $objWebInit->makeInfoListPage($intRows,$strLink,$link_type=2);
//print_r($arrListPage);

include_once('include/title.php');
include_once('include/head.php');
$myForm = new HAW_form("search.php",HAW_METHOD_POST);
$myInput = new HAW_input('keywords','',"关键字：");
$myForm->add_input($myInput);
$mySubmit = new HAW_submit("搜索");
$mySubmit->br = 0;
$myForm->add_submit($mySubmit);
$objHaw->add_form($myForm);

$myText = new HAW_text($arrGMeta[$strModuleID]['name'].'栏目：');
$objHaw->add_text($myText);

$intRowNum = ($intPage-1)*$arrGPage['page_size']+1;
foreach($arrInfoList as $k=>$v){
	$v['title'] = check::csubstr($v['title'],0,$arrMHaw['list_charnum']);
	$myText = new HAW_text($intRowNum.":");
	$myText->br = 0;
	$objHaw->add_text($myText);
	$myLink = new HAW_link($v['title'], "detail.php?id=".$v['id']."&mod=".$strModuleID."&page=".$intPage);
	$myLink->br = 0;
	$objHaw->add_link($myLink);
	$myText = new HAW_text(" (".$v['clicktimes'].")");
	$objHaw->add_text($myText);
	$intRowNum++;
}


if(!empty($arrListPage['pagedown'])){
	$myLink = new HAW_link('下页', $_SERVER["PHP_SELF"]."?page=".$arrListPage['pagedown'].'&'.$strLink);
	$myLink->set_br(0);
	$objHaw->add_link($myLink);
}
if(!empty($arrListPage['pageup'])){
	$myLink = new HAW_link('上页', $_SERVER["PHP_SELF"]."?page=".$arrListPage['pageup'].'&'.$strLink);
	$myLink->set_br(0);
	$objHaw->add_link($myLink);
}
if(!empty($arrListPage['page_count'])){
	$myLink = new HAW_link('末页', $_SERVER["PHP_SELF"]."?page=".$arrListPage['page_count'].'&'.$strLink);
	$myLink->set_br(0);
	$objHaw->add_link($myLink);
}
$myLink = new HAW_link('首页', $_SERVER["PHP_SELF"]."?page=1".'&'.$strLink);
$objHaw->add_link($myLink);

$myText = new HAW_text($arrListPage['pagenav']);
$objHaw->add_text($myText);
/*
2/39页
总350条
至<input name="ridpage"  format="*N" value="0" size="2" emptyok="true"/>页
<anchor title="GO">GO<go href="list.aspx?CD=31930&amp;menuid=1139428" method="post">
<postfield name="total" value="350" />
<postfield name="page" value="$(ridpage)" /></go></anchor>
*/
include_once('include/foot.php');
?>