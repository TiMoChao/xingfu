<?php
/**
 * 快钱支付基本设置文件
 *
 */
require_once('../config/config.inc.php');
require_once('../checklogin.php');

$objWebInit = new ArthurXF();
//smarty参数
$objWebInit->arrGSmarty = $arrGSmarty;

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','pay')) {
	check::AlertExit('对不起，您没有读权限',-1);
}
$strFilename = '../../data/quickmoney.inc.php';
if(file_exists($strFilename)) include($strFilename);

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w','pay')) {
		check::AlertExit('对不起，您没有写权限',-1);
	}
	unset($_POST['okgo']);
	unset($_POST['Submit']);

	$somecontent = '<?php' . "\n" . '$arrGQuickMoneyParam= ' . var_export( $_POST, true ) . ';' . "\n" .'?>';

	if (!$handle = fopen($strFilename, 'w')) {
		 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
	}

	// 将$somecontent写入到我们打开的文件中。
	if (fwrite($handle, $somecontent) === FALSE) {
		check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
	}
	fclose($handle);
	check::Alert("成功地写入到文件 $strFilename !",-1);

}

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '快钱设置管理';
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['arrGQuickMoneyParam'] = $arrGQuickMoneyParam;
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'siteset/quickmoneypay.htm';
$objWebInit->output($arrMOutput);
?>