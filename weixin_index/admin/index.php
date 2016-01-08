<?php
/**
 * 微信首页后台管理栏目首页文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	weixin_index
 */
require_once('../config/config.inc.php');
require_once("../class/weixin_index.class.php");
require_once ('../..'.__WEBADMIN_ROOT.'/checklogin.php');
$objWebInit = new weixin_index();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

//数据库连接
$objWebInit->db();

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
			$intTypeID = intval($_GET['type_id']);
			$arrWhere[] = "type_id='".$intTypeID."' or type_roue_id like '%:$intTypeID:%'";
			$arrLink[] = 'type_id='.$intTypeID;
		}
		if(!empty($_GET['state'])) {
			$intState = intval($_GET['state']);
			$arrWhere[] = " state = '$intState' ";
			$arrLink[] = 'state=' . $intState;
		}
	} else {
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

if (!empty($_GET['title'])) {
	$strKeywords = strval(urldecode($_GET['title']));
	if($strKeywords[0] == '/'){
		//精确查询ID
		$strKeywords = substr($strKeywords,1);
		if(is_numeric($strKeywords)) $arrWhere[] = "id = '" . $strKeywords . "'";
	}else{
		$arrWhere[] = "title LIKE '%" . $_GET['title'] . "%'";
	}
	$arrLink[] = 'title=' . $_GET['title'];
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
$arrData = $objWebInit->getInfoList($strWhere,$strOrder,($_GET['page']-1)*$arrGPage['page_size'],$arrGPage['page_size'],true);

//翻页跳转link
$strLink = '';
if (!empty($arrLink))	$strLink = implode('&',$arrLink);
$strPage= $objWebInit->makeInfoListPage($arrData['COUNT_ROWS'],$strLink);
unset($arrData['COUNT_ROWS']);

$arrMType = $objWebInit->getTypeList();

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
$arrMOutput["smarty_assign"]['FileCallPath'] = $arrGPic['FileCallPath'];
$arrMOutput["smarty_assign"]['arrMType'] = $arrMType;
$arrMOutput["smarty_assign"]['arrTypeB'] = $arrMTypeB;
$arrMOutput["smarty_assign"]['arrInfo'] = $arrData;
$arrMOutput["smarty_assign"]['strPage'] = $strPage;
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'index.htm';
$objWebInit->output($arrMOutput);
?>