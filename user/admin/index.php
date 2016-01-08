<?php
/**
 * 会员栏目首页文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	user
 */
require_once('../config/config.inc.php');
require_once("../class/user.class.php");
require_once ('../..'.__WEBADMIN_ROOT.'/checklogin.php');

$objWebInit = new user();
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
			$strKeywords = strval(urldecode($_GET['title']));
			if($strKeywords[0] == '/'){
				//精确查询ID
				$_GET['pass'] = null;
				$_GET['user_type'] =null;
				$strKeywords = substr($strKeywords,1);
				if(is_numeric($strKeywords)) $arrWhere[] = "user_id = '" . $strKeywords . "'";
			}else{
				$arrWhere[] = "user_name LIKE '%" . $strKeywords . "%' or real_name LIKE '%" . $strKeywords . "%' or structon_tb LIKE '%" . $strKeywords . "%'";
			}
			$arrLink[] = 'title=' . $_GET['title'];
		}

		if ($_GET['user_type'] == '1' || $_GET['user_type'] == '0') {
			$intTypeID = intval($_GET['user_type']);
			$arrWhere[] = "user_type='".$intTypeID."'";
			$arrLink[] = 'user_type='.$intTypeID;
		}
		if ($_GET['pass'] == '1' || $_GET['pass'] == '0') {
			$arrWhere[] = "pass='".$_GET['pass']."'";
			$arrLink[] = 'pass=' . $_GET['pass'];
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

if(!isset($_GET['page'])||$_GET['page']=='') $_GET['page'] = $arrGPage['page'];
$arrData = $objWebInit->getUserList(($_GET['page']-1)*$arrGPage['page_size'],$arrGPage['page_size'],$strWhere,' ORDER by is_check desc,pass desc,user_id desc');
if($arrData == "") $arrData=null;

//翻页跳转
$strLink = '';
if (!empty($arrLink))	$strLink = implode('&',$arrLink);
$strPage= $objWebInit->makeInfoListPage($arrData['COUNT_ROWS'],$strLink);
unset($arrData['COUNT_ROWS']);

//print_r($arrData);
// 输出到模板
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['arrData'] = $arrData;
$arrMOutput["smarty_assign"]['strPage'] = $strPage;
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'index.htm';
$objWebInit->output($arrMOutput);
?>