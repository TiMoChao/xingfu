<?php
/**
 * 网站架构公用全局变量配置文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	frame
 */
//ini_set('session.cookie_domain', '.biweb.cn');	//同域名多系统共享session
@session_start();
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('PRC');
//网站底层功能类
define('__WEBCOMMON_ROOT', __WEB_ROOT .'/web_common5.8');	//web_common在网站目录内
//define('__WEBCOMMON_ROOT', __WEB_ROOT .'/../web_common5.8');	//web_common在网站目录外
define('__WEBADMIN_ROOT', '/admin');	//网站后台管理目录，修改此处需对应修改目录


//常用函数库
include_once('common.fun.php');
//setCookieFormReferer();

//网站公用参数变量 版权信息请不要擅自删除，如需删除请访问biweb.cn购买授权
define('v','BIWEB V5.86');		//版本号
@include_once(__WEB_ROOT .'/data/webconfig.inc.php');
@include_once(__WEB_ROOT .'/data/navigate.inc.php');
$arrGWeb['navigate']=$arrGNavigate;
$arrGWeb['Powered'] = 'Powered by <b><a href="http://www.biweb.cn" title="BIWEB商务智能网站系统" target="_blank"><span style="color: #FF9900">'.v.'</span></a></b>';
$arrGWeb['Copyright'] = 'Copyright &copy; 2005-'.date('Y').' <b><a href="http://'.$arrGWeb['host'].'" title="'.$arrGWeb['company'].'" >'.$arrGWeb['name'].'</a></b>, All Rights Reserved .';		//版权信息
$arrGWeb['module_name'] = '设置';	//设置模块名称
$arrGWeb['module_id'] = 'index';	//设置模块id
$arrGWeb['templats_root'] = $arrGWeb['WEB_ROOT_pre'].'/templates/'.$arrGWeb['templates_id'];	//模版的目录
$arrGWeb['cache_url'] = '/html';
$arrGWeb['charset'] = 'utf-8';
$arrGWeb['db_summary_len'] = 100;	//摘要生成长度设定
$arrGWeb['css'] = array('style.css');	//网站调用CSS，可以支持数组和字符串
$arrGWeb['js'] = array('jquery.min.js','jquery.lazyload.js');


//页面数据提交之后回调
header('Cache-control: private');

//客户端缓存
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Expires: ' .gmdate ('D, d M Y H:i:s', time() + $arrGWeb['SquidTime']). " GMT");

if($arrGWeb['MEM_CACHE']!=0) eval(menload_file(__WEBCOMMON_ROOT . '/check.class.php',$arrGWeb['MEM_CACHE']));
else include_once(__WEBCOMMON_ROOT . '/check.class.php');
if($arrGWeb['MEM_CACHE']!=0) eval(menload_file(__WEBCOMMON_ROOT . '/php_common.php',$arrGWeb['MEM_CACHE']));
else include_once(__WEBCOMMON_ROOT . '/php_common.php');
require_once(__WEBCOMMON_ROOT . '/smarty.class.php');
if(class_exists('PDO')){
	if($arrGWeb['MEM_CACHE']!=0) eval(menload_file(__WEBCOMMON_ROOT . '/pdodb.class.php',$arrGWeb['MEM_CACHE']));
	else include_once(__WEBCOMMON_ROOT . '/pdodb.class.php');
}
if($arrGWeb['MEM_CACHE']!=0) eval(menload_file(__WEBCOMMON_ROOT . '/gdimage.class.php',$arrGWeb['MEM_CACHE']));
else include_once(__WEBCOMMON_ROOT . '/gdimage.class.php');
if($arrGWeb['MEM_CACHE']!=0) eval(menload_file(__WEBCOMMON_ROOT . '/pdo_page.class.php',$arrGWeb['MEM_CACHE']));
else include_once(__WEBCOMMON_ROOT . '/pdo_page.class.php');
if($arrGWeb['MEM_CACHE']!=0) eval(menload_file(__WEBCOMMON_ROOT . '/cache.class.php',$arrGWeb['MEM_CACHE']));
else include_once(__WEBCOMMON_ROOT . '/cache.class.php');
if($arrGWeb['MEM_CACHE']!=0) eval(menload_file(__WEBCOMMON_ROOT . '/timer.class.php',$arrGWeb['MEM_CACHE']));
else include_once(__WEBCOMMON_ROOT . '/timer.class.php');

//静态优化URL处理文件
if($arrGWeb['MEM_CACHE']!=0) eval(menload_file(__WEB_ROOT . '/config/static.fun.php',$arrGWeb['MEM_CACHE']));
else include_once(__WEB_ROOT . '/config/static.fun.php');
//smarty不缓存执行函数集
if($arrGWeb['MEM_CACHE']!=0) eval(menload_file(__WEB_ROOT . '/config/smarty.fun.php',$arrGWeb['MEM_CACHE']));
else include_once(__WEB_ROOT . '/config/smarty.fun.php');
//底层可选功能模块配置文件
if($arrGWeb['MEM_CACHE']!=0) eval(menload_file(__WEB_ROOT . '/config/module.inc.php',$arrGWeb['MEM_CACHE']));
else include_once(__WEB_ROOT . '/config/module.inc.php');

//针对smarty3的修复
spl_autoload_register('__autoload');

//繁体转换
if(empty($_SESSION['langset'])){
	$_SESSION['langset'] = 'zh_cn';
}
if($arrGWeb['isSubUrl']){
	if(strpos($_SERVER['HTTP_HOST'],$arrGWeb['subPre']) === false) $_SESSION['langset'] = 'zh_cn';
	else	$_SESSION['langset'] = 'zh_tw';
}elseif(empty($_SESSION['langset'])){
	$_SESSION['langset'] = 'zh_cn';
}

//取的网站前缀，用于退出等功能
if(empty($_SESSION['WEB_ROOT_pre'])){
	$_SESSION['WEB_ROOT_pre'] = $arrGWeb['WEB_ROOT_pre'];
}

//取得浏览器版本
if(empty($_SESSION['browser'])){
	$_SESSION['browser'] = check::BrowserVer();
}

//数据库全局配置文件
include_once(__WEB_ROOT . '/config/pdodb.inc.php');

//静态页面缓存参数
$arrGCache = array();
$arrGCache['cache_root'] = __WEB_ROOT .$arrGWeb['cache_url'];
$arrGCache['cache_filenum'] = 2500;	//同一目录存放多少个文件，建议不超过3000

//上传图片处理参数
$arrGPic = array();
$arrGPic['waterMark'] = $arrGWeb['waterMark'];
$arrGPic['waterPos'] = $arrGWeb['waterPos'];
$arrGPic['waterImage'] = $arrGWeb['waterImage'];
$arrGPic['zoomMode'] = $arrGWeb['zoomMode'];

//smarty参数
$arrGSmarty = array();
$arrGSmarty['left_delimiter']  =  '<?{';
$arrGSmarty['right_delimiter'] =  '}?>';
//$arrGSmarty['template_dir'] = __WEB_ROOT.'/templates/'.$arrGWeb['templates_id'];
$arrGSmarty['template_dir'] = __WEB_ROOT.'/templates/1';
$arrGSmarty['admin_template_dir'] = __WEB_ROOT.__WEBADMIN_ROOT.'/templats/';
$arrGSmarty['cache_dir'] = __WEB_ROOT.'/cache/';
$arrGSmarty['compile_dir'] = __WEB_ROOT.'/compile/';
$arrGSmarty['plugins_dir'] = array(SMARTY_PLUGINS_DIR);
$arrGSmarty['config_dir'] = __WEB_ROOT.'/config';
$arrGSmarty['caching'] = $arrGWeb['smarty_caching'];
$arrGSmarty['cache_lifetime'] = $arrGWeb['smarty_cache_lifetime'];
$arrGSmarty['cache_modified_check'] = false;
$arrGSmarty['compile_check'] = true;
$arrGSmarty['smarty_debug'] =false;
//print_r($arrGSmarty);die;
?>
