<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty CSS function plugin
 *
 * Type:     function<br>
 * Name:     css<br>
 * Purpose:  生成CSS调用处理
 *           with a single space or supplied replacement string.<br>
 * Example:  {css name=$name dir=$dir}
 * Date:     September 25th, 2002
 * @link http://smarty.php.net/manual/en/language.function.url.php
 *          strip (Smarty online manual)
 * @author   ArthurXF <ArthurXF at gmail dot com>
 * @version  1.0
 * @param string
 * @param string
 * @return string
 */
function smarty_function_html_css($params, &$smarty){
	global $arrGWeb;
	extract($params);
	if(empty($name)) return;
	if (!isset($name)) {
        $smarty->trigger_error("html_css: missing 'name' parameter");
        return;
    }
	if(empty($dir)){
		$dir = $arrGWeb['templats_root'].'/css/';
	}
	$strCSS = '';
	if(is_array($name)){
		$name = array_unique($name);
		foreach($name as $v){
			if(!empty($v)) $strCSS .= '<link href="'.$dir.$v.'" rel="stylesheet" type="text/css" />';
		}
	}else $strCSS ='<link href="'.$dir.$name.'" rel="stylesheet" type="text/css" />';
	return $strCSS;
}

/* vim: set expandtab: */

?>
