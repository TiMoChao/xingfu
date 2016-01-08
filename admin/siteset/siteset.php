<?php
/**
 * 后台管理栏目基本设置文件
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
	$arrTemp = array();
	$arrTemp['cache_url'] = $arrGWeb['cache_url'];
	$arrTemp['cache_dir'] = $arrGSmarty['cache_dir'];
	$arrTemp['compile_dir'] = $arrGSmarty['compile_dir'];
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
	@set_time_limit(0);
	check::delTreeDirs('../..'.$arrTemp['cache_url'].'/',false);
	check::delTreeDirs($arrTemp['cache_dir'],false);
	check::delTreeDirs($arrTemp['compile_dir'],false);
	check::Alert("成功地写入到文件 $strFilename !");

	check::WindowLocation('siteset.php');
}
// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '网站信息设置管理';
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'siteset/siteset.htm';
$objWebInit->output($arrMOutput);
?>
