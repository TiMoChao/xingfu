<?php
/**
 * 会员信息栏目首页文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	mcenter
 */
require_once('../config/config.inc.php');
require_once("../class/mcenter.class.php");
require_once ('../..'.__WEBADMIN_ROOT.'/checklogin.php');

$objWebInit = new mcenter();
$objWebInit->db();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

$arrWhere = array();
$arrLink = array();
if(isset($_GET['action'])){
	if($_GET['action']=='search') {
		// 构造搜索条件和翻页参数
		$arrLink[] = 'action=search';
		$_GET['title'] = trim($_GET['title']);
		if (!empty($_GET['title'])) {
			$strKeywords = strval(urldecode($_GET['title']));
			if($strKeywords[0] == '/'){
				//精确查询ID
				$_GET['status'] = null;
				$_GET['user_type'] =null;
				$strKeywords = substr($strKeywords,1);
				if(is_numeric($strKeywords)) $arrWhere[] = "user_id = '" . $strKeywords . "'";
			}else{
				$arrWhere[] = "user_name LIKE '%" . $strKeywords . "%' or real_name LIKE '%" . $strKeywords . "%'  or nick_name LIKE '%" . $strKeywords . "%'  or email LIKE '%" . $strKeywords . "%' or mobile LIKE '%" . $strKeywords . "%'";
			}
			$arrLink[] = 'title=' . $_GET['title'];
		}
		if ($_GET['status'] == '1' || $_GET['status'] == '0' || $_GET['status'] == '2' || $_GET['status'] == '3' || $_GET['status'] == '4'|| $_GET['status'] == '5') {			
			$arrWhere[] = "status='".$_GET['status']."'";			
			$arrLink[] = 'status=' . $_GET['status'];
		}

	} else {
		$objWebInit->doInfoAction($_GET['action'],$_POST['select']);
	}
}

$strWhere = implode(' AND ', $arrWhere);
if (!empty($strWhere))	$strWhere = ' WHERE '.$strWhere;

if(empty($_GET['sort'])) $strOrder = ' ORDER BY submit_date DESC';
elseif($_GET['sort'] == 1) $strOrder = ' ORDER BY user_id DESC';
elseif($_GET['sort'] == 2) $strOrder = ' ORDER BY user_id ASC';
$arrLink[] = 'sort=' . $_GET['sort'];

if(!isset($_GET['page'])||$_GET['page']=='') $_GET['page'] = $arrGPage['page'];
$arrData = $objWebInit->getUserList($strWhere,$strOrder,($_GET['page']-1)*$arrGPage['page_size'],$arrGPage['page_size']);

//翻页跳转
$strLink = '';
if (!empty($arrLink))	$strLink = implode('&',$arrLink);
$strPage= $objWebInit->makeInfoListPage($arrData['COUNT_ROWS'],$strLink);
unset($arrData['COUNT_ROWS']);

// 输出到模板
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['arrInfo'] = $arrData;
$arrMOutput["smarty_assign"]['strPage'] = $strPage;
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'index.htm';
$objWebInit->output($arrMOutput);
?>