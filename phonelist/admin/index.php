<?php
/**
 * 手机管理后台管理栏目首页文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	phonelist
 */
require_once('../config/config.inc.php');
require_once("../class/phonelist.class.php");
require_once ('../..'.__WEBADMIN_ROOT.'/checklogin.php');

$objWebInit = new phonelist();
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

//根据手机名称查询
if(!empty($_GET['title'])){
	$arrWhere[]="title like '%{$_GET['title']}%'";
	$arrLink[]="title={$_GET['title']}";
}

//根据订阅产品查询
if(!empty($_GET['product'])){
	$arrWhere[]="{$_GET['product']}=1";
	$arrLink[]="product={$_GET['product']}";
}


$strWhere = implode(' AND ', $arrWhere);
if (!empty($strWhere))	$strWhere = ' WHERE '.$strWhere;

if(!isset($_GET['page'])||$_GET['page']=='') $_GET['page'] = $arrGPage['page'];
$arrData = $objWebInit->getInfoList($strWhere,' ORDER BY submit_date DESC',($_GET['page']-1)*$arrGPage['page_size'],$arrGPage['page_size']);
if($arrData == "") $arrData=null;

//翻页跳转link
$strLink = '';
if (!empty($arrLink))	$strLink = implode('&',$arrLink);
$strPage= $objWebInit->makeInfoListPage($arrData['COUNT_ROWS'],$strLink);
unset($arrData['COUNT_ROWS']);

if(!is_array($arrMType)||empty($arrMType)){
	$arrMType = $objWebInit->getTypeList();
	$arrMType = $objWebInit->formatTypeList(0,$arrMType);
}

// 取类别标题
if(is_array($arrMType)&&!empty($arrMType)){
	$objWebInit->makeTypeCache($arrGWeb['module_id']);
	foreach ($arrData as $k => $data) {
		foreach ($arrMType as $k1 => $type) {
			if ($data['type_id'] == $type['type_id']) {
				$arrData[$k]['type_title'] = $type['type_title'];
			}
		}
	}
}

// 输出到模板
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['arrInfo'] = $arrData;
$arrMOutput["smarty_assign"]['arrType'] = $arrMType;
$arrMOutput["smarty_assign"]['strPage'] = $strPage;
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'index.htm';
$objWebInit->output($arrMOutput);
?>