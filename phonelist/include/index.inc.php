<?php
/**
 * 手机管理列表文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	phonelist
 */
require_once('config/config.inc.php');
require_once("class/phonelist.class.php");

$objWebInit = new phonelist();
//数据库连接参数
$objWebInit->setDBG($arrGPdoDB);
//smarty参数
$objWebInit->arrGSmarty = $arrGSmarty;
//翻页参数
$objWebInit->arrGPage = $arrGPage;
$objWebInit->db();
if($_REQUEST['act']=='order'){
	$info=$objWebInit->getInfoWhere(" where title='{$_POST['title']}'");
	if(!empty($info)){
			 $info = array_merge($info, $_POST);
			 $objWebInit->saveInfo($info,1,false);
		}else{
			$info=array();
			$info['title']      =$_POST['title'];
			$info['product_a']  = 1;
			$objWebInit->saveInfo($info,0,false);
		}
		echo 1;exit;
}
if (empty($_GET['page'])) {
	$intPage = 1 ;
} else {
	$intPage = intval($_GET['page']);
}
$arrWhere = array();
$arrLink = array();
$arrWhere[] = "pass='1'";

if (!empty($_GET['type_id'])) {
	$intTypeID = intval($_GET['type_id']);
	$arrWhere[] = "type_id='".$intTypeID."'";
	$arrLink[] = 'type_id=' . $intTypeID;

	if(is_array($arrMType)&&!empty($arrMType)){
		$arrMOutput["smarty_assign"]['strTypeTitle'] = $arrMType[$intTypeID];
	}else{
		$arrTypeInfo = $objWebInit->getTypeInfo($intTypeID);
		$strTypeTitle = $arrTypeInfo['type_title'];
		$arrMOutput["smarty_assign"]['strTypeTitle'] = $strTypeTitle;
	}
}


$strWhere = implode(' AND ',$arrWhere);
$strWhere = 'where '.$strWhere;

$arrInfoList = $objWebInit->getInfoList($strWhere,' ORDER BY topflag DESC,submit_date DESC',($intPage-1)*$arrGPage['page_size'],$arrGPage['page_size'],true);
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
$strPage= $objWebInit->makeInfoListPage($intRows,$strLink,$link_type=$arrGWeb['URL_static']);

if(!is_array($arrMType)||empty($arrMType)){
	$arrMType = $objWebInit->getTypeList();
	$arrMType = $objWebInit->formatTypeList(0,$arrMType);
}

//产品分类
include '../product/block/_menu.php';

//全站公用block
@include '../_block.php';


// 输出到模板
$arrMOutput["smarty_assign"]['arrInfoList'] = $arrInfoList;
$arrMOutput["smarty_assign"]['strPage'] = $strPage;
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'index.html';
$objWebInit->output($arrMOutput);

?>