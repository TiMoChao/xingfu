<?php
/**
 * 非法信息过滤后台管理栏目首页文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	fetch
 */
require_once('../../config/config.inc.php');
require_once('../../checklogin.php');

$objWebInit = new ArthurXF();
//smarty参数
$objWebInit->arrGSmarty = $arrGSmarty;
$arrGPage['page_size'] = 20;
$objWebInit->arrGPage = $arrGPage;

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','tools')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

$strFilename = '../../../data/fetch1.inc.php';
@include($strFilename);

if(isset($_GET['action'])){
	if($_GET['action']=='del') {
		if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'d','tools')) {
			check::AlertExit('对不起，您没有删权限',-1);
		}
		foreach ($_POST['select'] as $val){
			unset($arrGFetch[$val]);
		}
	}
	if($_GET['action']=='check') {
		if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w','tools')) {
			check::AlertExit('对不起，您没有写权限',-1);
		}
		foreach ($_POST['select'] as $val){
			$arrGFetch[$val]['pass'] = 1;
		}
	}
	if($_GET['action']=='uncheck') {
		if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w','tools')) {
			check::AlertExit('对不起，您没有写权限',-1);
		}
		foreach ($_POST['select'] as $val){
			$arrGFetch[$val]['pass'] = 0;
		}
	}
	$somecontent = '<?php' . "\n" . '$arrGFetch = ' . var_export( $arrGFetch, true ) . ';' . "\n" . '?>';

	if (!$handle = fopen($strFilename, 'w')) {
		 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
	}

	// 将$somecontent写入到我们打开的文件中。
	if (fwrite($handle, $somecontent) === FALSE) {
		check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
	}
	fclose($handle);
	check::Alert("成功地写入到文件 $strFilename !");
}
//生成当前页显示数据
if(empty($_GET['page'])) $start = 0;
else $start = intval($_GET['page']);
if($start > 0 ) $start -= 1;
$start *= $arrGPage['page_size'];
$max = $start+$arrGPage['page_size'];
$intTemp = 0;
$arrData = array();
if(!empty($arrGFetch)){
	foreach($arrGFetch as $k => $v){
		if($intTemp == $max) break;
		if($intTemp >= $start) $arrData[$k] = $v;
		$intTemp++;
	}
}
$intRows = count($arrGFetch);
//静态url处理
if (!empty($arrLink)) $strLink = implode('&',$arrLink);
else $strLink = '';
//翻页跳转link
$strPage= $objWebInit->makeInfoListPage($intRows,$strLink);

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '数据采集器';
$arrMOutput["smarty_assign"]['arrInfo'] = $arrData;
$arrMOutput["smarty_assign"]['start'] = $start;
$arrMOutput["smarty_assign"]['max'] = $max;
$arrMOutput["smarty_assign"]['strPage'] = $strPage;
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'tools/fetch/index1.htm';
$objWebInit->output($arrMOutput);
?>