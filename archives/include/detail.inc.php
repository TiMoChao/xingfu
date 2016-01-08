<?php
/**
 * 档案列表文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	archives
 */
require_once('config/config.inc.php');
require_once("class/archives.class.php");

$objWebInit = new archives();
$objWebInit->db();

$arrWhere = array();
$arrWhere[] = "type_title_english = '".$_GET['name']."'";
$strWhere = implode(' AND ', $arrWhere);
$strWhere = 'where '.$strWhere;
$arrInfo = $objWebInit->getInfoWhere($strWhere);

if(!empty($arrInfo['meta_Title'])) $strTitle = $arrInfo['meta_Title'];
else  $strTitle = $arrInfo['module_name'];
if(!empty($arrInfo['meta_Description'])) $strDescription = $arrInfo['meta_Description'];
else  $strDescription = $strTitle.','.$arrInfo['module_name'];
if(!empty($arrInfo['meta_Keywords'])) $strKeywords = $arrInfo['meta_Keywords'];
else  $strKeywords = $arrInfo['module_name'];



// 输出到模板
$arrMOutput["smarty_assign"]['arrInfo'] = $arrInfo;
$arrMOutput["smarty_assign"]['strTypeTitle'] = $strTypeTitle;
$arrMOutput['smarty_assign']['Title'] = $strTitle.' - '.$arrGWeb['name'];
$arrMOutput['smarty_assign']['Description'] = $strDescription.' - '.$arrGWeb['name'];
$arrMOutput['smarty_assign']['Keywords'] = $strKeywords.' - '.$arrGWeb['name'];
$arrMOutput['smarty_assign']['arrGWeb']['css'][] = 'company.css';
$arrMainDir = $arrGSmarty['main_dir'].'detail.html';
$arrMOutput["smarty_assign"]['MAIN'] = $arrMainDir;
$objWebInit->output($arrMOutput);
?>
