<?php
/**
 * rss列表文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	rss
 */
require_once('config/config.inc.php');
require_once("class/rss.class.php");

$objWebInit = new rss();

foreach($arrGMeta as $k => $v){
	if(in_array($k,array('useradmin','uploadfile','templates','plug-in','html','data','config','compile','cache',substr(__WEBADMIN_ROOT,1),'install'))){
		continue;
	}
	
	if(in_array($k,array('wap','user','logs','ads','links','emaillist','phonelist','mcenter','archives','keywords','rss','sitemap','guest'))){
		//$arrModuleDirs[$k]['id'] = $v;
		//$arrModuleDirs[$k]['state'] = 2;
		continue;
	}
	if($v['cache'] != 1)  continue;
	
	if(!empty($v)){
		$arrModuleDirs[$k]['id'] = $k;
		$arrModuleDirs[$k]['cache'] = $v['cache'];
		$arrModuleDirs[$k]['name'] = $v['name'];
	}
}


foreach($arrModuleDirs as $k => $v){
	if(!empty($v['cache'])&&$v['cache'] == 1){
		$arrInfoList[$k] = array('name'=>$v['name']);
		if(is_file('../data/'.$k.'/'.$k.'_type.php')){
			@include('../data/'.$k.'/'.$k.'_type.php');
		}
		if(!empty($arrMType)){
			foreach($arrMType as $key => $val){
				if(empty($val['type_link'])) $arrInfoList[$k]['type'][] = array('type_id'=>$val['type_id'],'name'=>$val['type_title']);
			}
		}else{
			$objWebInit->tablename1 = $arrGPdoDB['db_tablepre'].$k.'_type';
			$arrType = check::getAPI($k,"getTypeList","");
			$strType = check::getAPIArray($arrType);
			$arrMType = check::getAPI($k,"formatTypeList","0^$strType^0");
			if(!empty($arrMType)){
				foreach($arrMType as $key => $val){
					if(empty($val['type_link'])) $arrInfoList[$k]['type'][] = array('type_id'=>$val['type_id'],'name'=>$val['type_title']);
				}
			}
		}
	}
}

// 输出到模板
$arrMOutput["smarty_assign"]['arrInfoList'] = $arrInfoList;
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'index.html';
$objWebInit->output($arrMOutput);

?>