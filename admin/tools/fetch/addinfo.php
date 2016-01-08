<?php
/**
 * 非法信息过滤后台管理栏目新增文件
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

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','tools')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w','tools')) {
		check::AlertExit('对不起，您没有写权限',-1);
	}
	$strFilename = '../../../data/fetch.inc.php';
	@include($strFilename);
	unset($_POST['okgo']);
	unset($_POST['ltCnt']);
	unset($_POST['lbCnt']);
	unset($arrGFetch[$_POST['id']]);
	foreach($_POST['delimiter_lt'] as $k => $v){
		if(empty($v)) unset($_POST['delimiter_lt'][$k]);
	}
	foreach($_POST['delimiter_lb'] as $k => $v){
		if(empty($v)) unset($_POST['delimiter_lb'][$k]);
	}
	foreach($_POST['delimiter_ls'] as $k => $v){
		if(empty($v)) unset($_POST['delimiter_ls'][$k]);
	}
	foreach($_POST['delimiter_lm'] as $k => $v){
		if(empty($v[0])) unset($_POST['delimiter_lm'][$k]);
	}
	foreach($_POST['delimiter_dt'] as $k => $v){
		if(empty($v)) unset($_POST['delimiter_dt'][$k]);
	}
	foreach($_POST['delimiter_db'] as $k => $v){
		if(empty($v)) unset($_POST['delimiter_db'][$k]);
	}
	foreach($_POST['delimiter_ds'] as $k => $v){
		if(empty($v)) unset($_POST['delimiter_ds'][$k]);
	}
	foreach($_POST['delimiter_dw'] as $k => $v){
		if(empty($v[0])) unset($_POST['delimiter_dw'][$k]);
	}
	foreach($_POST['delimiter_df'] as $k => $v){
		if(empty($v[0])) unset($_POST['delimiter_df'][$k]);
	}
	if($_POST['wholelink']){
		if(!empty($_POST['list_host'])) if(strpos(strtolower($_POST['list_host']),'http://') !== 0) $_POST['list_host'] = 'http://'.$_POST['list_host'];
	}
	if($_POST['onlytext']){
		$_POST['imglink'] = 0;
		$_POST['downimg'] = 0;
	}
	$arrGFetch[$_POST['title']] = array('list_url'=>$_POST['list_url'],'list_charset'=>strtoupper($_POST['list_charset']),'wholelink'=>$_POST['wholelink'],'list_host'=>$_POST['list_host'],'list_separator'=>$_POST['list_separator'],'delimiter_ls'=>$_POST['delimiter_ls'],'delimiter_lt'=>$_POST['delimiter_lt'],'delimiter_lb'=>$_POST['delimiter_lb'],'delimiter_lm'=>$_POST['delimiter_lm'],'delimiter_dt'=>$_POST['delimiter_dt'],'delimiter_db'=>$_POST['delimiter_db'],'delimiter_ds'=>$_POST['delimiter_ds'],'delimiter_dw'=>$_POST['delimiter_dw'],'delimiter_df'=>$_POST['delimiter_df'],'module_id'=>$_POST['module_id'],'type_id'=>$_POST['type_id'],'pass'=>1);

	$somecontent = '<?php' . "\n" . '$arrGFetch = ' . var_export( $arrGFetch, true ) . ';' . "\n" . '?>';

	// 首先我们要确定文件存在并且可写。
	if (!$handle = fopen($strFilename, 'w')) {
		  check::AlertExit("错误：不能以'写'模式打开文件 $strFilename !",-1);
	}

	// 将$somecontent写入到我们打开的文件中。
	if (fwrite($handle, $somecontent) === FALSE) {
		check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
	}
	fclose($handle);

	if(empty($_GET['page']))
		$page = '';
	else
		$page = 'page=' . $_GET['page'];

	check::WindowLocation('index.php',$page);
}

foreach($arrGMeta as $k => $v){
	//设定网站功能栏目管理权限
	if(in_array($k,array('mcenter','account','certification','comments','friend','message','payment','usermoney','logs','archives','ads','links','phonelist','emaillist','keywords','user'))){
		continue;
	}
	//设定网站后台管理左栏显示栏目
	if(!empty($v['admin']) && $v['admin'] != ''){
		$arrModule[$k] = $v['name'];
	}
}

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '数据采集器';
$arrMOutput["smarty_assign"]['arrModule'] = $arrModule;
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'tools/fetch/submit.htm';
$objWebInit->output($arrMOutput);
?>