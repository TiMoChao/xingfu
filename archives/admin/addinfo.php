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
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w')) {
	check::AlertExit('对不起，您没有写权限',-1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	
	$arrTemp = $objWebInit->getInfoWhere("where type_title_english='".$_POST['type_title_english']."'",'module_name');
	if(!empty($arrTemp)) check::AlertExit('英文标识名称不能重复！',-1);

	if (empty($_POST['module_name'])) check::AlertExit("错误：单页名称不能为空!",-1);
	if (empty($_POST['type_title_english'])) check::AlertExit("错误：英文标识名称!",-1);
	if (empty($_POST['intro'])) check::AlertExit("错误：内容不能为空!",-1);

	$objWebInit->saveInfo($_POST,0,0);
	//更新smarty缓存文件或纯静态文件
	$objWebInit->updateCache($_POST['type_title_english'],'',$arrMOutput);
	check::WindowLocation('index.php','page='.$_GET['page']);
}

//detree饼状图加载
//###############################################################
define('__WEB_ROOT', dirname(__FILE__)."/../..");
$templateDir = __WEB_ROOT.'/templates/'.$arrGWeb['templates_id'];

$arrTreeFiles = array();
check::mapTreeFiles($templateDir,true);
$arrTreeFiles = str_replace($templateDir.'/','',$arrTreeFiles);

//过滤类型
$arrFile	  = array('.html','.htm','.js','.css');
$arrFilesDirs = array();

foreach($arrTreeFiles as $v){
	$isContinue = false;
	foreach($arrFile as $v1){
		if(strpos($v,$v1)) $isContinue = true;
	}
	if(!$isContinue) continue;

	$arrTemp = array();
	$arrTemp = explode('/',$v);

	$arrFilesDirs[] = $arrTemp;
}

//转换数组结构
$arrTemp = array();
$n = 0;
foreach($arrFilesDirs as $k=>$v){
	$len = count($v);
	if($len == 1){
		$arrTemp[$n] = $v;
	}else{
		$strTemp = '';
		for($i=0;$i<$len-1;$i++){
			if(empty($strTemp)) $strTemp=$v[$i];
			else $strTemp.='-'.$v[$i];
		}
		$arrTemp[$n][] = $strTemp;
		$arrTemp[$n][] = $v[$i];
	}
	$n++;
}

$arrFilesDirs = $arrTemp;

$arrTemp = array();
$arrDataJs = array();
$arrHave = array();
$n = 1;
foreach($arrFilesDirs as $k=>$v){
	$len = count($v);
	$fId = $n;

	if($len == 1){
		$arrTemp['key']	 = $n;
		$arrTemp['fId']  = 0;
		$arrTemp['file'] = $v[0];
		$arrTemp['link'] = $v[0]; 

		$arrDataJs[] = $arrTemp;
		$n++;
	}else{
		$arrT = array();
		$arrT = explode('-',$v['0']);
		$intLen = count($arrT);
		for($i=0;$i<$intLen;$i++){
			$arrTemp['key']	= $n;
			$strTemp = check::dirsString($arrT,$i);
			if(!isset($arrHave[$strTemp]) || empty($arrHave[$strTemp])){ //暂时没有这个变量存在
				$arrHave[$strTemp] = $n;

				if($i == 0) $arrTemp['fId'] = 0;
				else $arrTemp['fId']  = $arrHave[check::dirsString($arrT,$i-1)];
				$arrTemp['file'] = $arrT[$i];
				$arrTemp['link'] = '';
				$arrDataJs[] = $arrTemp;
				$n++;
			}
		}
		
		$strT = implode('/',explode('-',$v['0']));
		$arrTemp['key']	 = $n;
		$arrTemp['fId']  = $arrHave[$v[0]];
		$arrTemp['file'] = $v[1];
		$arrTemp['link'] = $strT.'/'.$v[1];
		$n++;

		$arrDataJs[] = $arrTemp;

	}
}

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '单页管理';
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['arrDataJsSmt'] = $arrDataJs;
$arrMOutput["smarty_assign"]['strvaltest'] = $_GET['path'];
$arrMOutput["smarty_assign"]['arrType'] = 'add';
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'submit.html';
$objWebInit->output($arrMOutput);
?>