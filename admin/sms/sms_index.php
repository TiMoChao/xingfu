<?php
/**
 * SMS通道管理文件
 *
 */
require_once('../config/config.inc.php');
require_once('../checklogin.php');

$objWebInit = new ArthurXF();

//访问权限检查
if (!$objWebInit->checkPopedomG($_SESSION['user_id'],'r','sms')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

$strFilename = "../../data/sms.inc.php";
if(file_exists($strFilename)) include($strFilename);
if ($_SERVER["REQUEST_METHOD"] == "POST"&&$_POST['act']=="xx"){
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w','sms')) {
		check::AlertExit('对不起，您没有写权限',-1);
	}
	if(empty($_POST['username'])) check::AlertExit("错误：用户名没填!",-1);
	
	if(empty($_POST['password'])) check::AlertExit("错误：密码没填!",-1);
	
	if(empty($_POST['wsdlURL_send'])) check::AlertExit("错误：短信发送接口地址没填!",-1);
	unset($_POST['okgo']);
	unset($_POST['Submit']);
	$somecontent = '<?php' . "\n" . '$arrMBizParam = ' . var_export( $_POST, true ) . ';' . "\n" . '?>';
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

$strFilename = "../../data/yx_sms.inc.php";
if(file_exists($strFilename)) include($strFilename);
if ($_SERVER["REQUEST_METHOD"] == "POST"&&$_POST['act']=="yx"){
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w','sms')) {
		check::AlertExit('对不起，您没有写权限',-1);
	}
	if(empty($_POST['username'])) check::AlertExit("错误：用户名没填!",-1);
	
	if(empty($_POST['password'])) check::AlertExit("错误：密码没填!",-1);
	
	if(empty($_POST['wsdlURL_send'])) check::AlertExit("错误：短信发送接口地址没填!",-1);
	unset($_POST['okgo']);
	unset($_POST['Submit']);
	$somecontent = '<?php' . "\n" . '$yx_arrMBizParam = ' . var_export( $_POST, true ) . ';' . "\n" . '?>';
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
$arrMOutput["smarty_assign"]['strNav'] = '短信通道_10658';
$arrMOutput["smarty_assign"]['arrMBizParam'] = $arrMBizParam;
$arrMOutput["smarty_assign"]['yx_arrMBizParam'] = $yx_arrMBizParam;
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'sms/sms_list_1.htm';
$objWebInit->output($arrMOutput);
?>