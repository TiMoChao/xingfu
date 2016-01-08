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
function smarty_function_html_js($params, &$smarty){
	global $arrGWeb;
	extract($params);
	if(empty($name)) return;
	if (!isset($name)) {
        $smarty->trigger_error("html_js: missing 'name' parameter");
        return;
    }
	if(empty($dir)){
		$dir = $arrGWeb['WEB_ROOT_pre'].'/plug-in/commonJS/';
	}

	$strJS = '';
	if(is_array($name)){
		$name = array_unique($name);
		foreach($name as $v){
			if(!empty($v)) $strJS .= '<script src="'.$dir.$v.'" type="text/javascript"></script>';
		}
	}else $strJS ='<script src="'.$dir.$name.'" type="text/javascript"></script>';
	return $strJS;
}

/* vim: set expandtab: */

?>
