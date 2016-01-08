<?php
/**
 * 手机管理 列表文件
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
$arrGSmarty['caching'] = false;
//$objWebInit->arrGSmarty = $arrGSmarty;
//翻页参数
$objWebInit->arrGPage = $arrGPage;
$objWebInit->db();

if(!empty($_GET['u_mail']) && !empty($_GET['token'])){
	if($_GET['token']==md5($_GET['u_mail'].$arrGWeb['jamstr'])){//数据匹配，则标识为退订邮件
		$strWhere=" WHERE title='{$_GET['u_mail']}'";
		$objWebInit->updateDataG('biweb_phonelist',array('pass'=>'7'),$strWhere);
		echo "<script>alert('退订成功');window.close();</script>";exit;
	}
}
?>