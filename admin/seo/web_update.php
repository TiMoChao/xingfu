<?php
/**
 * 后台管理栏目清空静态页面文件
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
//smarty参数
$objWebInit->arrGSmarty = $arrGSmarty;

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','seo')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

foreach($arrGMeta as $k => $v){
	if(in_array($k,array('useradmin','uploadfile','templates','plug-in','html','data','config','compile','cache',substr(__WEBADMIN_ROOT,1),'install'))){
		continue;
	}
	
	if(in_array($k,array('wap','user','logs','ads','links','emaillist','phonelist','mcenter','keywords','rss','sitemap','guest'))){
		//$arrModuleDirs[$k]['id'] = $v;
		//$arrModuleDirs[$k]['state'] = 2;
		continue;
	}
	
	if(!is_dir('../../'.$k.'/config')) continue;
	if($v['cache'] != 1)  continue;

	if(!empty($v)){
		$arrModuleDirs[$k]['id'] = $k;
		$arrModuleDirs[$k]['cache'] = $v['cache'];
		$arrModuleDirs[$k]['name'] = $v['name'];
	}
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['id'])){
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'x','seo')) {
		check::AlertExit('对不起，您没有执行权限',-1);
	}
	if($_GET['id'] != 'all'){
		$isOK = false;
		foreach($arrModuleDirs as $v){
			if($_GET['id'] == $v['id']) $isOK = true;
		}
		if(empty($isOK)) check::AlertExit("设定栏目非法，不允许操作!",-1);
	}
	if(strpos($_GET['id'],'./') !== false) check::AlertExit("设定栏目非法，不允许操作!",-1);
	@set_time_limit(0);
	if($_GET['id'] == 'all'){
		check::delTreeDirs('../..'.$arrGWeb['cache_url'].'/',false);
		//check::delTreeDirs($arrGSmarty['cache_dir'],false);
		//check::delTreeDirs($arrGSmarty['compile_dir'],false);
	}else{
		if(empty($arrGMeta[$_GET['id']]['cache'])) check::AlertExit("设定栏目不支持纯静态页面生成，不允许操作!",-1);
		check::delTreeDirs('../..'.$arrGWeb['cache_url'].'/'.$_GET['id'].'/',false);
	}
	if($_GET['ac'] == 'del') check::AlertExit("网站静态页面更新成功 !",-1);
	else{
		if($_GET['id'] == 'all'){
			foreach($arrModuleDirs as $val){
				if($val['id'] == 'archives') $arrInfoList = check::getAPI($val['id'],"getInfoList","where 1^^0^0^id,type_title_english^^0");
				else $arrInfoList = check::getAPI($val['id'],"getInfoList","where pass=1^^0^0^id^^0");
				if(!empty($arrInfoList)){
					foreach($arrInfoList as $v){
						if($val['id'] == 'archives') if(empty($v['type_title_english'])) continue;
						$intID = $v['id'];
						if(empty($intID)) continue;
						include_once('../../'.$val['id'].'/config/var.inc.php');
						$intNum = ceil($intID/$arrGCache['cache_filenum']);
						if($_SESSION['langset'] == 'zh_tw') $arrGWeb['file_suffix'] = 'tw'.$arrGWeb['file_suffix'];
						if($val['id'] == 'archives') $strDir = $arrGCache['cache_root'].'/'.$val['id'].'/'.$v['type_title_english'].$arrGWeb['file_suffix'];
						else $strDir = $arrGCache['cache_root'].'/'.$val['id'].'-'.$intNum.'/'.$intID.$arrGWeb['file_suffix'];
						$objCache = new cache($strDir);
						$objCache->cache_start(true);
						if($val['id'] == 'archives') $strContents = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/'.$val['id'].'/detail.php?name='.$v['type_title_english']);
						else $strContents = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/'.$val['id'].'/detail.php?id='.$intID);
						if($strContents){
							header("HTTP/1.1 200 OK");
							echo $strContents;
						}
						$objCache->cache_end(false);
					}
				}
			}
			check::AlertExit("网站静态页面已全部重新生成 !",-1);
		}else{
			if($_GET['id'] == 'archives') $arrInfoList = check::getAPI($_GET['id'],"getInfoList","where 1^^0^0^id,type_title_english^^0");
			else $arrInfoList = check::getAPI($_GET['id'],"getInfoList","where pass=1^^0^0^id^^0");
			if(!empty($arrInfoList)){
				foreach($arrInfoList as $v){
					if($_GET['id'] == 'archives') if(empty($v['type_title_english'])) continue;
					$intID = $v['id'];
					if(empty($intID)) continue;
					include_once('../../'.$_GET['id'].'/config/var.inc.php');
					$intNum = ceil($intID/$arrGCache['cache_filenum']);
					if($_SESSION['langset'] == 'zh_tw') $arrGWeb['file_suffix'] = 'tw'.$arrGWeb['file_suffix'];
					if($_GET['id'] == 'archives') $strDir = $arrGCache['cache_root'].'/'.$_GET['id'].'/'.$v['type_title_english'].$arrGWeb['file_suffix'];
					else $strDir = $arrGCache['cache_root'].'/'.$_GET['id'].'-'.$intNum.'/'.$intID.$arrGWeb['file_suffix'];
					$objCache = new cache($strDir);
					$objCache->cache_start(true);
					if($_GET['id'] == 'archives') $strContents = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['id'].'/detail.php?name='.$v['type_title_english']);
					else $strContents = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['id'].'/detail.php?id='.$intID);
					if($strContents){
						header("HTTP/1.1 200 OK");
						echo $strContents;
					}
					$objCache->cache_end(false);
				}
				check::AlertExit("网站静态页面已重新生成 !",-1);
			}

		}
	}

}

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '静态页面更新';
$arrMOutput["smarty_assign"]['arrModuleDirs'] = $arrModuleDirs;
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'seo/web_update.htm';
$objWebInit->output($arrMOutput);
?>