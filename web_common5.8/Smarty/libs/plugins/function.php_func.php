<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty PHP function plugin
 *
 * Type:     function<br>
 * Name:     PHP<br>
 * Purpose:  µ÷ÓÃPHPº¯Êý
 *           with a single space or supplied replacement string.<br>
 * Example:  {php_func name=$name arg=$dir}
 * Date:     2010-8-5
 * @link http://smarty.php.net/manual/en/language.function.url.php
 *          php_func (Smarty online manual)
 * @author   ArthurXF <ArthurXF at gmail dot com>
 * @version  1.0
 * @param string
 * @param string
 * @return string
 */
function smarty_function_php_func($params, &$smarty){
	extract($params);
	if(empty($name)) return;

	return $name($arg);
}
/* vim: set expandtab: */

?>
