<?php
/**
 * 手机管理文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	phonelist
 */
if (is_object($objWebInit)) {
	if(!isset($objphonelist)){
		include_once(__WEB_ROOT."/phonelist/class/phonelist.class.php");
		include_once(__WEB_ROOT."/phonelist/config/var.inc.php");
		$objphonelist = new phonelist();
		$objphonelist->setDBG($arrGPdoDB);
		if(is_object($objWebInit->db)) $objphonelist->db = $objWebInit->db;
		else $objphonelist->db();
	}

	$arrTopphonelist = array();
	$arrTopphonelist = $objphonelist->getInfoList("where pass=1","  ORDER BY recommendflag DESC,clicktimes DESC,submit_date DESC", 0, 15,true);
	unset($arrTopphonelist['COUNT_ROWS']);

	// print_r($arrTopphonelist);
	// 输出到模板
	$arrMOutput["smarty_assign"]['arrTopphonelist'] = $arrTopphonelist;
}
?>