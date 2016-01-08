<?php
/**
 * 网站留言后台管理栏目首页文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	message
 */
require_once('../config/config.inc.php');
require_once("../class/message.class.php");
require_once ('../..'.__WEBADMIN_ROOT.'/checklogin.php');
$objWebInit = new message();
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
		if (!empty($_GET['title'])) {
			$arrWhere[] = "structon_tb LIKE '%" . $_GET['title'] . "%'";
			$arrLink[] = 'title=' . $_GET['title'];
		}
		if ($_GET['pass'] == '1' || $_GET['pass'] == '0') {
			$arrWhere[] = "pass='".$_GET['pass']."'";
			$arrLink[] = 'pass=' . $_GET['pass'];
		}
		if (!empty($_GET['type_id'])) {
			$arrWhere[] = "type_id='".$_GET['type_id']."'";
			$arrLink[] = 'type_id=' . $_GET['type_id'];
		}
		if(!empty($_GET['state'])) {
			$arrWhere[] = 'state = "' . $_GET['state'] . '"';
			$arrLink[] = 'state=' . $_GET['state'];
		}
	} else {
		//访问权限检查
		if($_GET['action']=='del'){
			if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'d')) {
				check::AlertExit('对不起，您没有删除权限',-1);
			}
		}else{
			if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w')) {
				check::AlertExit('对不起，您没有写权限',-1);
			}
		}
		$objWebInit->doInfoAction($_GET['action'],$_POST['select']);
	}
}
$strWhere = implode(' AND ', $arrWhere);
if (!empty($strWhere))	$strWhere = ' WHERE '.$strWhere;

if(empty($_GET['sort'])) $strOrder = ' ORDER BY submit_date DESC';
elseif($_GET['sort'] == 1) $strOrder = ' ORDER BY topflag DESC,submit_date DESC';
elseif($_GET['sort'] == 2) $strOrder = ' ORDER BY recommendflag DESC,submit_date DESC';
elseif($_GET['sort'] == 3) $strOrder = ' ORDER BY ID DESC';
elseif($_GET['sort'] == 4) $strOrder = ' ORDER BY ID ASC';
$arrLink[] = 'sort=' . $_GET['sort'];

if(!isset($_GET['page'])||$_GET['page']=='') $_GET['page'] = $arrGPage['page'];
$arrData = $objWebInit->getInfoList($strWhere,$strOrder,($_GET['page']-1)*$arrGPage['page_size'],$arrGPage['page_size']);

//翻页跳转link
$strLink = '';
if (!empty($arrLink))	$strLink = implode('&',$arrLink);
$strPage= $objWebInit->makeInfoListPage($arrData['COUNT_ROWS'],$strLink);
unset($arrData['COUNT_ROWS']);



// 输出到模板
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['get'] = $_GET;
$arrMOutput["smarty_assign"]['FileCallPath'] = $arrGPic['FileCallPath'];
$arrMOutput["smarty_assign"]['arrInfo'] = $arrData;
$arrMOutput["smarty_assign"]['arrGState'] = $arrGState;
$arrMOutput["smarty_assign"]['strPage'] = $strPage;
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'index.htm';
$objWebInit->output($arrMOutput);
?>