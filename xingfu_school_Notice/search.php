<?php
/**
 * 兴甫幼儿园_ 通知公告 列表文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	xingfu_school_Notice
 */
require_once('config/config.inc.php');
require_once("class/xingfu_school_Notice.class.php");

$objWebInit = new xingfu_school_Notice();
$objWebInit->db();

$arrWhere = array();
$arrLink = array();
$arrWhere[] = "pass='1'";

$strLink = '';

if(!empty($_REQUEST['keywords'])){
	$strKeywords = strval(urldecode($_REQUEST['keywords']));
	if($strKeywords[0] == '/'){
		//精确查询ID
		$strKeywords = substr($strKeywords,1);
		if(is_numeric($strKeywords)) $arrWhere[] = "id = '" . $strKeywords . "'";
	}else{
		$strKeywords = strval(urldecode($_REQUEST['keywords']));

		$objSP = new SplitWord();
		$strok = $objSP->SplitRMM($strKeywords);
		$arrKeywords = explode(' ', $strok);
		foreach($arrKeywords as $v){
			$v = trim($v);
			if(!empty($v)) $arrWhere[] = "tag LIKE '%$v%'";
		}
	}
	$arrLink[] = 'keywords=' . urlencode($strKeywords);
}else check::AlertExit("错误：关键词必须填写!",-1);
if (empty($_GET['page'])) {
	$intPage = 1 ;
} else {
	$intPage = intval($_GET['page']);
}
$strWhere = implode(' AND ',$arrWhere);
$strWhere = 'where '.$strWhere;

$arrInfoList = $objWebInit->getInfoList($strWhere,'  ORDER BY topflag DESC,submit_date DESC',($intPage-1)*$arrGPage['page_size'],$arrGPage['page_size']);
$intRows = $arrInfoList['COUNT_ROWS'];
unset($arrInfoList['COUNT_ROWS']);

// 输出到模板
if($intRows == '1'){//有单条记录
	$strUrl = $arrGWeb['WEB_ROOT_pre'].'/'.$arrGWeb['module_id'].'/detail.php?id='.$arrInfoList[0]['id'];
	header("Location: $strUrl");
	exit;
}

//翻页跳转link
$strPage= $objWebInit->makeInfoListPage($intRows,$strLink,$link_type=$arrGWeb['URL_static'],'4');

// 输出到模板
$arrMOutput["smarty_assign"]['arrInfoList'] = $arrInfoList;
$arrMOutput["smarty_assign"]['strPage'] = $strPage;
$arrMOutput["smarty_assign"]['page'] = $intPage;
$arrMOutput["smarty_assign"]['arrMType'] = $arrMType;
$arrMOutput["smarty_assign"]['strSearchTitle'] = $strKeywords."搜索结果";
$arrMOutput['smarty_assign']['Title'] = $strKeywords.'搜索结果 - '.$arrGWeb['name'];
$arrMOutput['smarty_assign']['Description'] = $strKeywords.'搜索结果 - '.$arrGWeb['name'];
$arrMOutput['smarty_assign']['Keywords'] = $strKeywords.'搜索结果 - '.$arrGWeb['name'];
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'list.html';
$objWebInit->output($arrMOutput);
?>