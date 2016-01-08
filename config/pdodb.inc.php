<?php
//数据库参数
$arrGPdoDB = array();
$arrGPdoDB['db_driver'] = 'mysql';
if(empty($arrGWeb['db_host'])) $arrGPdoDB['db_host'] = 'localhost';
else $arrGPdoDB['db_host'] = $arrGWeb['db_host'];
if(empty($arrGWeb['db_port'])) $arrGPdoDB['db_port'] = '3306';
else $arrGPdoDB['db_port'] = $arrGWeb['db_port'];
if(empty($arrGWeb['db_name'])) $arrGPdoDB['db_name'] = '';
else $arrGPdoDB['db_name'] = $arrGWeb['db_name'];
$arrGPdoDB['db_char'] = "utf8";
$arrGPdoDB['dsn'] = $arrGPdoDB['db_driver'].':host='.$arrGPdoDB['db_host'].';port='.$arrGPdoDB['db_port'].';dbname='.$arrGPdoDB['db_name'].';charset='.$arrGPdoDB['db_char'];
if(empty($arrGWeb['db_user'])) $arrGPdoDB['db_user'] = '';
else $arrGPdoDB['db_user'] = $arrGWeb['db_user'];
if(empty($arrGWeb['db_password'])) $arrGPdoDB['db_password'] = '';
else $arrGPdoDB['db_password'] = $arrGWeb['db_password'];
if(empty($arrGWeb['db_tablepre'])) $arrGPdoDB['db_tablepre'] = 'biweb_';
else $arrGPdoDB['db_tablepre'] = $arrGWeb['db_tablepre'];
$arrGPdoDB['PDO_ATTR_PERSISTENT'] = true;
if(isset($_SESSION['user_group']) && $_SESSION['user_group'] == 3){
	if(isset($_GET['debug'])) $arrGPdoDB['PDO_DEBUG'] = $_GET['debug'];
	else $arrGPdoDB['PDO_DEBUG'] = $arrGWeb['PDO_DEBUG'];
}else $arrGPdoDB['PDO_DEBUG'] = $arrGWeb['PDO_DEBUG'];
$arrGPdoDB['PDO_LOGS'] = $arrGWeb['PDO_LOGS'];
$arrGPdoDB['PDO_CACHE'] = $arrGWeb['PDO_CACHE'];
$arrGPdoDB['PDO_CACHE_ROOT'] = __WEB_ROOT .'/cache/PDO_CACHE';
$arrGPdoDB['PDO_CACHE_LIFETIME'] = $arrGWeb['PDO_CACHE_LIFETIME'];
$arrGPdoDB['htmlspecialchars'] = array('intro','summary','tag'); //不需要htmlspecialchars过滤的数据字段

//数据库句柄缓存数组
if(empty($arrGDBHandle)) $arrGDBHandle = array();
?>
