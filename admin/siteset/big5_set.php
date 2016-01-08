<?php
/**
 * 后台管理栏目缓冲设置文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	admin
 */
require_once('../config/config.inc.php');
require_once('../checklogin.php');

$objWebInit = new ArthurXF();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','siteset')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w','siteset')) {
		check::AlertExit('对不起，您没有写权限',-1);
	}
	if(strpos($_POST['subPre'],'.') === false ){
		check::AlertExit("错误:缺少最后的点号!",-1);
	}
	unset($_POST['okgo']);
	unset($arrGWeb);
	$strFilename = '../../data/webconfig.inc.php';
	include($strFilename);
	foreach($_POST as $k=>$v){
		$arrGWeb[$k] = $v;
	}

	$somecontent = '<?php' . "\n" . '$arrGWeb = ' . var_export( $arrGWeb, true ) . ';' . "\n" . '$arrGMeta = ' . var_export( $arrGMeta, true ) . ';' . "\n" . '?>';

	if (!$handle = fopen($strFilename, 'w')) {
		 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
	}

	// 将$somecontent写入到我们打开的文件中。
	if (fwrite($handle, $somecontent) === FALSE) {
		check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
	}
	fclose($handle);
	check::AlertExit("成功地写入到文件 $strFilename !",-1);
}

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '中文繁简转换设置';
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'siteset/big5_set.htm';
$objWebInit->output($arrMOutput);
?>