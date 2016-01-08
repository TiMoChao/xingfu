<?php
/**
 * 招聘中心 列表文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	weixin_news
 */
require_once('config/config.inc.php');
require_once("class/weixin_news.class.php");

$objWebInit = new weixin_news();
$objWebInit->iscached($arrMOutput);
$objWebInit->db();

if (empty($_GET['page'])) {
	$intPage = 1 ;
} else {
	$intPage = intval($_GET['page']);
}
$arrWhere = array();
$arrLink = array();
$arrWhere[] = "pass='1'";
$type_title = '';

if (!empty($_GET['type_id'])) {
	$intTypeID = intval($_GET['type_id']);
	$type_id = $intTypeID - 1;
	$type_title = $arrMType[$type_id]['type_title'];
    $objWebInit->fetchAllChildID($_REQUEST['type_id'], $arrMType, $arrChild) ;
    $typeStr=implode( $arrChild['type_id'], ',');
    $arrWhere[] = "type_id in ( ".$typeStr.")";
	$arrLink[] = "type_id=".$intTypeID;
}


if(!empty($arrMType)){
	foreach($arrMType as $k => $v){
		if($v['type_id'] == intval($_GET['type_id'])){
			$arrMOutput["smarty_assign"]['strTypeTitle'] = $v['type_title'];
			break;
		}
	}
}

$strWhere = implode(' AND ',$arrWhere);
$strWhere = 'where '.$strWhere;

$arrInfoList = $objWebInit->getInfoList($strWhere,' ORDER BY topflag DESC,submit_date DESC',($intPage-1)*$arrGPage['page_size'],$arrGPage['page_size'],'id,type_id,title,thumbnail,submit_date,bedeck,summary');
$arrInfoListTmp = $objWebInit->getInfoList($strWhere,' ORDER BY topflag DESC,submit_date DESC',($intPage-1)*$arrGPage['page_size'],$arrGPage['page_size'],'structon_tb');

for($i = 0 ;$i < count($arrInfoListTmp) - 1; $i++){
    $TmpVideo[$i] = $arrInfoListTmp[$i]['video'];
}

for($i = 0 ;$i < count($arrInfoList) - 1; $i++){
    $arrInfoList[$i]['video'] = $TmpVideo[$i] ;
}

//print_r($arrInfoListTmp);die;
//print_r($arrInfoList);die;

$intRows = $arrInfoList['COUNT_ROWS'];
unset($arrInfoList['COUNT_ROWS']);
//print_r($arrInfoList);die;
// 单条信息跳转详细页
/*
if($intRows == '1'){//有单条记录
	$strUrl = $arrGWeb['WEB_ROOT_pre'].'/'.$arrGWeb['module_id'].'/detail.php?id='.$arrInfoList[0]['id'];
	header("Location: $strUrl");
	exit;
}
*/
if($_GET['type'] != '') {
    $gettype = $_GET['type'];
}
else{
    $gettype = 2;
}
//静态url处理
$strLink = '';
if($arrGWeb['URL_static']){
	if (!empty($arrLink)) $strLink = str_replace('=','-',implode('-',$arrLink));
}else{
	if (!empty($arrLink)) $strLink = implode('&',$arrLink);
}


//翻页跳转link
$strPage= $objWebInit->makeInfoListPage($intRows,$strLink,$link_type=$arrGWeb['URL_static'],'3');

// 输出到模板
$arrMOutput["smarty_assign"]['requesttype'] = $gettype;
$arrMOutput["smarty_assign"]['arrInfoList'] = $arrInfoList;
$arrMOutput["smarty_assign"]['strPage'] = $strPage;
$arrMOutput["smarty_assign"]['arrMType'] = $arrMType;
$arrMOutput["smarty_assign"]['type_title'] = $type_title;
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'index.html';
$objWebInit->output($arrMOutput);
?>