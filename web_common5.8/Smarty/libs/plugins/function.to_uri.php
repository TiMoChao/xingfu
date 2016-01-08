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
function smarty_function_to_uri($params, &$smarty){
	extract($params);
	if(empty($data)) return;

	if(is_array($data)){
		$arrTemp = array();
		foreach($data as $k => $v){
			$arrTemp[] = $k.'='.$v;
		}
		$strUri = implode('&',$arrTemp);
	}else $strUri = $data;
	return $strUri;
}
/* vim: set expandtab: */

?>
