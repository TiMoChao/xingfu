<?php
/**
 * 网站留言后台分类管理文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	xingfu_apply
 */
require_once('../config/config.inc.php');
require_once("../class/xingfu_apply.class.php");
require_once ('../../admin/checklogin.php');
$objWebInit = new xingfu_apply();
$arrMOutput["template_file"] = "admin.html";
$objWebInit->db();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r')) {
	check::AlertExit('对不起，您没有读权限',-1);
}
if(isset($_GET['action'])){
	if($_GET['action']=='del'){
		//访问权限检查
		if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'d')) {
			check::AlertExit('对不起，您没有删除权限',-1);
		}	
	}else{
		//访问权限检查
		if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w')) {
			check::AlertExit('对不起，您没有写权限',-1);
		}
	}
	switch ($_GET['action']){
		// 显示新增页面
		case 'add':
			$arrTypeList = $objWebInit->getTypeList();
			$arrTypeList = $objWebInit->formatTypeList(0,$arrTypeList);
			$arrMOutput["smarty_assign"]['arrData'] = $arrTypeList;
			$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'add_category.htm';
			$objWebInit->output($arrMOutput);
			break;
		// 新增网站留言类型
		case 'insert':
			if (empty($_POST['type_title']))   {
				check::AlertExit("错误：提交数据为空!",-1);
			}
			$objWebInit->makeInsertType($_POST);
			unset($_GET['action']);
			break;
		// 删除网站留言类型
		case 'del':
			$id = intval($_GET['id']);
			if (empty($id))   {
				check::AlertExit("错误：提交数据为空!",-1);
			}
			$objWebInit->deleteType($id);
			unset($_GET['action']);
			break;
		// 编辑网站留言类型
		case 'edit':
			$id = intval($_GET['id']);
			if (empty($id))   {
				check::AlertExit("错误：提交数据为空!",-1);
			}
			$arrTypeList = $objWebInit->getTypeList();
			$arrType = array();
			foreach ($arrTypeList as $k => $types){
				if ($types['type_id'] == $id) {
					$arrType = $types;
				}
			}
			$arrTypeList = $objWebInit->formatTypeList(0,$arrTypeList);
			$arrMOutput["smarty_assign"]['type_id'] = $id;
			$arrMOutput["smarty_assign"]['arrType'] = $arrType;
			$arrMOutput["smarty_assign"]['arrData'] = $arrTypeList;
			$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'edit_category.htm';
			$objWebInit->output($arrMOutput);
			break;
		// 更新网站留言类别
		case 'update':
			if (empty($_POST['type_title']))   {
				check::AlertExit("错误：提交数据为空!",-1);
			}
			$objWebInit->makeUpdateType($_POST);
			unset($_GET['action']);
			break;
	}
}
if(!isset($_GET['action'])){
	// 网站留言类型列表
	$arrTypeList = $objWebInit->getTypeList();
	$arrTypeList = $objWebInit->formatTypeList(0,$arrTypeList);
	// 输出到模板
	$arrMOutput["smarty_assign"]['arrData'] = $arrTypeList;
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'category.htm';
	$objWebInit->output($arrMOutput);
}
?>