<?php
/**
 * 繁简转换设置文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	langset
 */
define('__WEB_ROOT', dirname(__FILE__)."/../..");
require_once(__WEB_ROOT."/config/global.inc.php");
if ( isset($_SERVER['HTTP_REFERER']) )    {
    $strMyUrl = $_SERVER['HTTP_REFERER'];
}else $strMyUrl = 'http://'.$_SERVER['HTTP_HOST'];

if($_SESSION['langset'] == 'zh_cn') {
	$_SESSION['langset'] = 'zh_tw';
	if($arrGWeb['isSubUrl']){
		$strHost = $arrGWeb['subPre'].str_replace('www.','',$_SERVER['HTTP_HOST']);
		if(strpos($strMyUrl,$arrGWeb['cache_url']) !== false) $strMyUrl = str_replace($arrGWeb['file_suffix'],'tw'.$arrGWeb['file_suffix'],$strMyUrl);
	}
}else{
	$_SESSION['langset'] = 'zh_cn';
	if($arrGWeb['isSubUrl']){
		$strHost = 'www.'.str_replace($arrGWeb['subPre'],'',$_SERVER['HTTP_HOST']);
		if(strpos($strMyUrl,$arrGWeb['cache_url']) !== false) $strMyUrl = str_replace('tw','',$strMyUrl);
	}
}

if($arrGWeb['isSubUrl']) $strUrl = str_replace($_SERVER['HTTP_HOST'],$strHost,$strMyUrl);
else $strUrl = $strMyUrl;

header("HTTP/1.1 301 Moved Permanently"); // 面向搜索引擎的友好模式
header("location:$strUrl");
?>