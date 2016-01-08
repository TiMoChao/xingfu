<?php
/**
 * rss详细文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	rss
 */
require_once('config/config.inc.php');
require_once("class/rss.class.php");

$objWebInit = new rss();
//数据库连接参数

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

if (empty($_GET['page'])) {
	$intPage = 1 ;
} else {
	$intPage = intval($_GET['page']);
}
if (!empty($_GET['mod'])) {
	$strModuleID = strval($_GET['mod']);
	include_once('../'.$strModuleID.'/config/var.inc.php');
}else{
	check::AlertExit('未知栏目',-1);
	exit;
}
//类别ID
$arrWhere = array();
$arrLink = array();
$arrWhere[] = "pass='1'";

if(!empty($_GET['type_id'])){
	$intTypeID = intval($_GET['type_id']);
	$arrWhere[] = "type_roue_id  like '%:".$intTypeID.":%'";
	$arrLink[] = 'type_id=' . $intTypeID;
}
$strWhere = implode(' AND ',$arrWhere);
$strWhere = 'where '.$strWhere;

$arrInfoList = check::getAPI($strModuleID,"getInfoList","$strWhere^ ORDER BY topflag DESC,submit_date DESC^0^$arrGPage[page_size]^true^^0");

$strDomain = 'http://'.$_SERVER['HTTP_HOST'];
$objRss = new UniversalFeedCreator();
$objRss->useCached();
$objRss->title = $arrGMeta[$strModuleID]['meta']['Title'].'RSS订阅 -'.$arrGWeb['name'];
$objRss->description = $arrGMeta[$strModuleID]['meta']['Description'].'RSS订阅 -'.$arrGWeb['name'];
$objRss->descriptionTruncSize = 500;
$objRss->descriptionHtmlSyndicated = true;

$objRss->link = $strDomain."/".$strModuleID.'/';
$objRss->syndicationURL = $strDomain.'/'.$_SERVER["PHP_SELF"];

foreach($arrInfoList as $key => $val){
	$objItem = new FeedItem();
    $objItem->title = $val['title'];
	$strDir = ceil($val['id']/$arrGCache['cache_filenum']);
	if($arrGWeb['URL_static']){
		if($arrGWeb['file_static']){
			$strUrl = $strDomain.'/'.$arrGWeb['cache_url'].'/'.$strModuleID.'-'.$strDir.'/'.$val['id'].$arrGWeb['file_suffix'];
		}else $strUrl = $strDomain.'/'.$strModuleID.'/detail/id-'.$val['id'].$arrGWeb['file_suffix'];
	}else $strUrl = $strDomain.'/'.$strModuleID.'/detail.php?id='.$val['id'];
    $objItem->link = $strUrl;
    $objItem->description = $val['summary'];

    //optional
    $objItem->descriptionTruncSize = 500;
    $objItem->descriptionHtmlSyndicated = true;

    $objItem->date = strtotime($val['submit_date']);
    $objItem->source = $strDomain;
    $objItem->author = $_SERVER['HTTP_HOST'];

    $objRss->addItem($objItem);
}

echo $objRss->saveFeed("RSS2.0", $arrGSmarty['cache_dir'].$objRss->_generateFilename());
?>