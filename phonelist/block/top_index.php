<?php
/**
 * 最新手机管理文件
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

	$arrphonelistList = array();
	$arrphonelistList = $objphonelist->getInfoList("where pass=1","  ORDER BY recommendflag DESC,submit_date DESC,clicktimes DESC", 0, 6,'*',null,false);

	 //print_r($arrphonelistList);
	// 输出到模板
	$arrMOutput["smarty_assign"]['arrphonelistList'] = $arrphonelistList;
}
?>