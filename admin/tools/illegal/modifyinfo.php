<?php
/**
 * 非法信息过滤后台管理栏目修改文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	illegal
 */
require_once('../../config/config.inc.php');
require_once('../../checklogin.php');

$objWebInit = new ArthurXF();
//smarty参数
$objWebInit->arrGSmarty = $arrGSmarty;

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','tools')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

$strFilename = '../../../data/illegal.inc.php';
include($strFilename);
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w','tools')) {
		check::AlertExit('对不起，您没有写权限',-1);
	}
	unset($_POST['okgo']);
	unset($arrGIllegal[$_POST['id']]);
	$arrGIllegal[$_POST['title']] = array('replace'=>$_POST['replace'],'pass'=>1);

	$somecontent = '<?php' . "\n" . '$arrGIllegal = ' . var_export( $arrGIllegal, true ) . ';' . "\n" . '?>';

	if (!$handle = fopen($strFilename, 'w')) {
		  check::AlertExit("错误：不能以'写'模式打开文件 $strFilename !",-1);
	}

	// 将$somecontent写入到我们打开的文件中。
	if (fwrite($handle, $somecontent) === FALSE) {
		check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
	}
	fclose($handle);

	check::WindowLocation('index.php','page='.$_GET['page']);
}


// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '非法信息过滤';
$arrMOutput["smarty_assign"]['arrData'] = $arrGIllegal[$_GET['id']];
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'tools/illegal/submit.htm';
$objWebInit->output($arrMOutput);
?>