<?php
/**
 * 会员登录检测文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	admin
 */
if(empty($_SESSION['user_id'])){
	
	//header("location:/user/login.php");	
	check::AlertExit("请先登录！","{$arrGWeb['WEB_ROOT_pre']}/user/login.php");
}

$arrGSmarty['caching'] = false;
?>