<?php
/**
 * wap搜索列表文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	wap
 */
require_once('config/config.inc.php');
require_once("class/wap.class.php");

$objWebInit = new wap();

include_once('include/title.php');
include_once('include/head.php');

$myText = new HAW_text($arrGWeb['name'].'欢迎您!');
$objHaw->add_text($myText);

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
		$myLink = new HAW_link($v['name'], "list.php?mod=".$k);
		$objHaw->add_link($myLink);
	}
}


include_once('include/foot.php');
?>