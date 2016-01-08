<?php
/**
 * 共享内存登录日志生成文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	logshare
 */
define('__WEB_ROOT', dirname(__FILE__)."/../..");
define('__LOG_NUMS',30);
require_once(__WEB_ROOT."/config/global.inc.php");

//日志操作内存存储块
include_once(__WEBCOMMON_ROOT . '/SharedMemory/SharedMemory.php');
$objShared = System_SharedMemory::factory();
//$objShared->rm($arrGPdoDB['db_name'].'login');exit;
$arrCache_log = $objShared->get($arrGPdoDB['db_name'].'login');

$strTitle ='';
if ($arrLog) {
        $strTitle ="<div class='time'>".date("H:i",$arrLog['time'])."</div><div class='uname' title='{$arrLog['name']}'>{$arrLog['name']}</div><div class='money'>{$arrLog['content']}</div>";
}

if (!empty($strTitle)) {
    if(empty($arrCache_log)) {
		$arrCache_log['user_log'][$arrLog['time']] = array('action'=>$strTitle);
        $objShared->set($arrGPdoDB['db_name'].'login', $arrCache_log);
    }else {
		//if(!empty($_SESSION['user_id'])) {
			
			////array_unshift($arrCache_log['user_log'], array('action'=>$strTitle,'time'=>time()));
        //}
		
		$arrCache_log['user_log'][$arrLog['time']] = array('action'=>$strTitle);

		krsort($arrCache_log['user_log']);
//echo count($arrCache_log['user_log']);
		//只保留最新的__LOG_NUMS个数据
		if(count($arrCache_log['user_log']) >= __LOG_NUMS) array_pop($arrCache_log['user_log']);
        $objShared->set($arrGPdoDB['db_name'].'login', $arrCache_log);
    }
}
?>