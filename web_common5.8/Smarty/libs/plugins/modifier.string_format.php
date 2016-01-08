<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty string_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     string_format<br>
 * Purpose:  format strings via sprintf
 * @link http://smarty.php.net/manual/en/language.modifier.string.format.php
 *          string_format (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_string_format($string, $format)
{
	if(strpos($format,'f') or strpos($format,'F')){
		$fl = $string - (int)$string;
		if($fl == 0){
			$format = str_replace('f','d',$format);
			$format = str_replace('F','d',$format); 
		}
	}
    return sprintf($format, $string);
}

/* vim: set expandtab: */

?>
