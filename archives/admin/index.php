<?php
/**
 * 单页介绍后台管理栏目首页文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	archives
 */
require_once('../config/config.inc.php');
require_once("../class/archives.class.php");
require_once ('../..'.__WEBADMIN_ROOT.'/checklogin.php');

$objWebInit = new archives();
$objWebInit->db();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

if(isset($_GET['action'])){
	if($_GET['action']=='del') {
		if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'d')) {
			check::AlertExit('对不起，您没有删除权限',-1);
		}
		$objWebInit->doInfoAction($_GET['action'],$_POST['select']);
	}
	
	//写入archives.inc.php
	$arrGArchives = array();
	$arrData = $objWebInit->getInfoList();
	unset($arrData['COUNT_ROWS']);
}
//生成当前页显示数据
$arrData = array();
if(!isset($_GET['page'])||$_GET['page']=='') $_GET['page'] = $arrGPage['page'];
$arrData = $objWebInit->getInfoList($strWhere,' ORDER BY id DESC ',($_GET['page']-1)*$arrGPage['page_size'],$arrGPage['page_size']);
$intRows = $arrData['COUNT_ROWS'];
unset($arrData['COUNT_ROWS']);
$_GET['id'] =1;
foreach ($arrData as $key => $value){
	$value['url'] = htmlentities("<?{url url='/archives/detail.php?name=".$value['type_title_english']."' cache='1'}?>",ENT_QUOTES,'UTF-8' );
	$arrData[$key] = $value;
}
//静态url处理
$strLink = '';
if (!empty($arrLink)) $strLink = implode('&',$arrLink);
//翻页跳转link
$strPage= $objWebInit->makeInfoListPage($intRows,$strLink);
// 输出到模板
$arrMOutput["smarty_assign"]['arrInfo'] = $arrData;
$arrMOutput["smarty_assign"]['start'] = $start;
$arrMOutput["smarty_assign"]['max'] = $max;
$arrMOutput["smarty_assign"]['strPage'] = $strPage;
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'index.html';
$objWebInit->output($arrMOutput);
?>
