<?php
/**
 * 后台管理导航基本设置文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	admin
 */
require_once('../config/config.inc.php');
require_once('../checklogin.php');
//require_once('../../data/navigate.inc.php');

$objWebInit = new ArthurXF();
//smarty参数
$objWebInit->arrGSmarty = $arrGSmarty;

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','siteset')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w','siteset')) {
		check::AlertExit('对不起，您没有写权限',-1);
	}
	$navigate_new=array();
	foreach($_POST['sort'] as $k=>$v){
		$navigate_new[$k]['sort'] = $v;
	}
	
	foreach($_POST['navName'] as $k=>$v){
		$navigate_new[$k]['navName'] = $v;
	}

	foreach($_POST['navLink'] as $k=>$v){
		$navigate_new[$k]['navLink'] = $v;
		if($v=='/'){
			$navigate_new[$k]['module_id'] = 'index';
		}else{
			$link=explode('/',$v);
			$navigate_new[$k]['module_id'] = $link[1];
		}
	}

	foreach($_POST['navTip'] as $k=>$v){
		$navigate_new[$k]['navTip'] = $v;
	}
	
	foreach($_POST['target'] as $k=>$v){
		$navigate_new[$k]['target'] = $v;
	}
	
	//进行排序
	$arrTmp=array();
	foreach($navigate_new as $k=>$v){
		
		$arrTmp[$v['sort'].'_'.$k]=$v;
	}
	
	sort($arrTmp);

	$navigate_new=array();
	foreach($arrTmp as $k=>$v){
		$v['sort']=$k+1;
		$navigate_new[$k]=$v;
	}
	$strFilename = '../../data/navigate.inc.php';
	@include($strFilename);
	$somecontent = '<?php' . "\n" . '$arrGNavigate = ' . var_export( $navigate_new, true ) . ';' . "\n" . '?>';

	if (!$handle = fopen($strFilename, 'w')) {
		 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
	}

	// 将$somecontent写入到我们打开的文件中。
	if (fwrite($handle, $somecontent) === FALSE) {
		check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
	}

	fclose($handle);
	check::Alert("成功地写入到文件 $strFilename !");
	check::WindowLocation('navigate.php');
}

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '网站导航设置管理';
$arrMOutput["smarty_assign"]['arrGWeb'] = $arrGWeb;
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'siteset/navigate.htm';
$objWebInit->output($arrMOutput);
?>