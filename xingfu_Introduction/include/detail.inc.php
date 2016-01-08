<?php
/**
 * 兴甫简介 列表文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	xingfu_Introduction
 */
require_once('config/config.inc.php');
require_once("class/xingfu_Introduction.class.php");

$objWebInit = new xingfu_Introduction();
$objWebInit->db();

if($_GET['id'] === null) exit;
$intID = intval($_GET['id']);
$arrInfo = $objWebInit->getInfo($intID);

if(!empty($arrInfo['linkurl'])){
	header("Location:".$arrInfo['linkurl']."");
}

if($arrInfo['id'] == ''||$arrInfo['pass'] == 0) {
	echo "<script language=JavaScript>
			alert('该页面已经删除！');
			parent.location='/';
		  </script>";
}

if(!empty($arrInfo['meta_Title'])) $strTitle = $arrInfo['meta_Title'];
else  $strTitle = $arrInfo['title'];
if(!empty($arrInfo['meta_Description'])) $strDescription = $arrInfo['meta_Description'];
else  $strDescription = $strTitle.','.$arrInfo['summary'];
if(!empty($arrInfo['meta_Keywords'])) $strKeywords = $arrInfo['meta_Keywords'];
else  $strKeywords = $arrInfo['title'];

//下五条
$strWhereNext = "where id < $intID";
$arrInfoListNext = $objWebInit->getInfoList($strWhereNext,' ORDER BY topflag DESC,submit_date DESC,id DESC',0,5,'id,title,submit_date,bedeck','',false);


// 输出到模板
$arrMOutput["smarty_assign"]['arrData'] = $arrInfo;
$arrMOutput["smarty_assign"]['arrInfoListNext'] = $arrInfoListNext;
$arrMOutput["smarty_assign"]['FileCallPath'] = $objWebInit->arrGPic['FileCallPath'];
$arrMOutput["smarty_assign"]['arrMType'] = $arrMType;
$arrMOutput["smarty_assign"]['arrGWeb']['css'][] = 'xingfu_Introduction02.css';
$arrMOutput['smarty_assign']['Title'] = $strTitle.' - '.$arrGWeb['name'];
$arrMOutput['smarty_assign']['Description'] = $strDescription.' - '.$arrGWeb['name'];
$arrMOutput['smarty_assign']['Keywords'] = $strKeywords.' - '.$arrGWeb['name'];
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'detail.html';
$objWebInit->output($arrMOutput);
?>