<?php
/**
 * 系统安装 索引文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	install
 */
 
require_once('config/config.inc.php');
$ver_path ='/en';
if(empty($_SESSION['install_date'])) $_SESSION['install_date'] = time();

$objWebInit = new ArthurXF();
if(file_exists(__WEB_ROOT.'/data/install.lock')) check::AlertExit('BIWEB网站系统已经安装,请勿重复安装！',-1);

$_GET['step'] = $_GET['step'] ? $_GET['step'] : '1' ;
if($_GET['step']==1){
	$_SESSION['session_test'] = 1;
	$arrMOutput["smarty_assign"]['step'] = 1;
	$arrMOutput["smarty_assign"]['info'] = '阅读版权协议';
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'step1.html';
	$arrMOutput['smarty_assign']['Title'] =  $arrMOutput["smarty_assign"]['info'].' - BIWEB WMS安装第一步';
}elseif($_GET['step']==2){
	$arrMOutput["smarty_assign"]['step'] = 2;
	$arrMOutput["smarty_assign"]['info'] = '阅读安装说明';
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'step2.html';
	$arrMOutput['smarty_assign']['Title'] =  $arrMOutput["smarty_assign"]['info'].' - BIWEB WMS安装第二步';
}elseif($_GET['step']==3){
	$arrDirs = array(
		'../data/'=>array('explain'=>'可写配置参数目录','popedom'=>'权限为 0777'),
		'../cache/'=>array('explain'=>'缓存存放目录连同下属所有目录','popedom'=>'权限为 0777'),
		'../html/'=>array('explain'=>'纯静态页面存放目录连同下属所有目录','popedom'=>'权限为 0777'),
		'../compile/'=>array('explain'=>'smarty模板编译目录','popedom'=>'权限为 0777'),
		'../uploadfile/'=>array('explain'=>'文件上传存放目录连同下属所有目录','popedom'=>'权限为 0777'),
		'../sitemap.xml'=>array('explain'=>'google sitemap文件','popedom'=>'权限为 0666'),
		'../templates'=>array('explain'=>'模板目录(所有子目录都要有写权限)','popedom'=>'权限为 0777'),
	);
	$intStop = 0;
	foreach($arrDirs as $k=>$v){
		if (is_writable($k)) {
			$arrDirs[$k]['writable'] = true;
		}else{
			$arrDirs[$k]['writable'] = false;
			$intStop = 1;
		}
	}
	$arrSysInfo = array();
	$arrSysInfo['os'] = PHP_OS;
	$arrSysInfo['php'] = PHP_VERSION;
	if(function_exists('mysql_connect')) $arrSysInfo['mysql'] = true;
	else{
		$arrSysInfo['mysql'] = false;
		$intStop = 1;
	}
	foreach(get_loaded_extensions() as $key=>$value){
		if($value == 'PDO') $arrSysInfo['PDO'] = true;
		if($value == 'pdo_mysql') $arrSysInfo['pdo_mysql'] = true;
		if($value == 'gd') $arrSysInfo['GD'] = true;
	}
	if(empty($arrSysInfo['PDO']) || empty($arrSysInfo['pdo_mysql']) || empty($arrSysInfo['GD'])){
		$intStop = 1;
	}
	if(empty($_SESSION['session_test'])){
		$intStop = 1;
	}
	if(ini_get('allow_url_fopen')){
		$arrSysInfo['allow_url_fopen'] = true;

		if(@file_get_contents('http://www.baidu.com')){
			$arrSysInfo['file_get_contents'] = true;
		}else{
			$arrSysInfo['file_get_contents'] = false;
		}
	}else{
		$arrSysInfo['allow_url_fopen'] = false;
		$arrSysInfo['file_get_contents'] = false;
	}


	$arrSysInfo['upload'] = ini_get("upload_max_filesize");

	$arrMOutput['smarty_assign']['arrSysInfo'] = $arrSysInfo;
	$arrMOutput['smarty_assign']['arrDirs'] = $arrDirs;
	$arrMOutput['smarty_assign']['intStop'] = $intStop;
	$arrMOutput["smarty_assign"]['step'] = 3;
	$arrMOutput["smarty_assign"]['info'] = '检查系统环境';
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'step3.html';
	$arrMOutput['smarty_assign']['Title'] = $arrMOutput["smarty_assign"]['info'].' - BIWEB WMS安装第三步';
}elseif($_GET['step']==4){
	$arrMOutput["smarty_assign"]['step'] = 4;
	$arrMOutput["smarty_assign"]['info'] = '设置中文版数据库及管理员信息';
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'step4.html';
	$arrMOutput['smarty_assign']['Title'] = $arrMOutput["smarty_assign"]['info'].' - BIWEB WMS安装第四步';
}elseif($_GET['step']==5){
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty($_POST['db_host'])||empty($_POST['db_port'])||empty($_POST['db_user'])||empty($_POST['db_name'])){
			check::AlertExit("错误：数据库地址、端口、用户名和库名信息必须填写!",-1);
		}
		if(empty($_POST['password'])||empty($_POST['user_name'])||empty($_POST['real_name'])||empty($_POST['email'])) check::AlertExit("错误：管理员的信息必须全部填写!",-1);
		if($_POST['password'] != $_POST['password_c']) check::AlertExit("错误：两次输入的密码不相同!",-1);
		if(!empty($_POST['mc_type']) && $_POST['mc_type']){
			//使用已安装的用户中心
			if(empty($_POST['m_db_host'])||empty($_POST['m_db_port'])||empty($_POST['m_db_user'])||empty($_POST['m_db_name'])){
				check::AlertExit("错误：用户中心数据库地址、端口、用户名和库名信息必须填写!",-1);
			}

			if(!$connect=@mysql_connect($_POST['m_db_host'].':'.$_POST['m_db_port'],$_POST['m_db_user'],$_POST['m_db_password'])) check::AlertExit("错误：用户中心数据库连接不成功!",-1);
			if(!@mysql_select_db($_POST['m_db_name'],$connect)) check::AlertExit("错误：用户中心".$_POST['m_db_name']."库不存在!",-1);
			$_SESSION['mc_type'] = $_POST['mc_type'];
		}else{
			unset($_SESSION['mc_type']);//新安装用户中心
			if(empty($_POST['password'])||empty($_POST['user_name'])||empty($_POST['real_name'])||empty($_POST['email'])) check::AlertExit("错误：管理员的信息必须全部填写!",-1);
			$_SESSION['user_name'] = $_POST['user_name'];
			$_SESSION['real_name'] = $_POST['real_name'];
			$_SESSION['email'] = $_POST['email'];
			if(!empty($_POST['user_pass_type']) && $_POST['user_pass_type'])
				$_SESSION['password'] = check::strEncryption($_POST['password'],$_POST['jamstr']);
			else $_SESSION['password'] = $_POST['password'];
			$_SESSION['install_type'] = $_POST['install_type'];
			$_SESSION['user_pass_type'] = $_POST['user_pass_type'];
			$_SESSION['jamstr'] = $_POST['jamstr'];
			unset($_POST['user_name']);
			unset($_POST['real_name']);
			unset($_POST['email']);
			unset($_POST['password']);
			unset($_POST['password_c']);
			unset($_POST['install_type']);
			$_POST['m_db_host'] = $_POST['db_host'];
			$_POST['m_db_port'] = $_POST['db_port'];
			$_POST['m_db_user'] = $_POST['db_user'];
			$_POST['m_db_name'] = $_POST['db_name'];
			$_POST['m_db_password'] = $_POST['db_password'];
			$_POST['m_db_tablepre'] = $_POST['db_tablepre'];
		}

		$_SESSION['db_host'] = $_POST['db_host'];
		$_SESSION['db_port'] = $_POST['db_port'];
		$_SESSION['db_user'] = $_POST['db_user'];
		$_SESSION['db_name'] = $_POST['db_name'];
		$_SESSION['db_password'] = $_POST['db_password'];

		unset($arrGWeb);
		$strFilename = '../data/webconfig.inc.php';
		foreach($_POST as $k=>$v){
			if($k == 'biweb') continue;
			$arrGWeb[$k] = $v;
		}
		$arrGWeb['install_date'] = $_SESSION['install_date'];
		if(ini_get('allow_url_fopen') && @file_get_contents('http://www.baidu.com')){
			$arrGWeb['file_static'] = '0';//本来设置是1，生成静态的，但是很多用户没配置404，故设置为0
		}else{
			$arrGWeb['file_static'] = '0';
		}

		$virtual_path = $_SERVER['SCRIPT_NAME'];
		$virtual_path = substr($virtual_path, 0, strpos($virtual_path, '/install'));
		$arrGWeb['WEB_ROOT_pre'] = $virtual_path;

		$somecontent = '<?php' . "\n" . '$arrGWeb = ' . var_export( $arrGWeb, true ) . ';' . "\n" . '$arrGMeta = ' . var_export( $arrGMeta, true ) . ';' . "\n" . '?>';

		// 首先我们要确定文件存在并且可写。
		if (!$handle = fopen($strFilename, 'w')) {
			 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
		}

		// 将$somecontent写入到我们打开的文件中。
		if (fwrite($handle, $somecontent) === FALSE) {
			check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
		}
		fclose($handle);
	}elseif(empty($arrGPdoDB['db_name']) || empty($arrGPdoDB['db_user'])){
		check::AlertExit("错误：数据库名和数据库用户名必须填写!",-1);
	}

	//为第五步显示内容
	$arrTreeDirs = array();
	check::mapTreeDirs('../',false,false);

	$arrModuleDirs = array();
	$arrNoDirs = array('en','useradmin','uploadfile','templates','plug-in','html','data','config','compile','cache',substr(__WEBADMIN_ROOT,1),'install');
	$arrMustDirs = array('wap','user','rss','sitemap','links','guest','archives','keywords','ads','emaillist','phonelist','logs');

	if(!empty($_POST['mc_type']) && $_POST['mc_type']){
		$arrNoDirs[] = 'mcenter';
	}else $arrMustDirs[] = 'mcenter';

	foreach($arrTreeDirs as $k => $v){
		if(in_array($v,$arrNoDirs)){
			continue;
		}
		if(!is_dir('../'.$v.'/config')) continue;
		if(!file_exists('../'.$v.'/config/var.inc.php')) continue;

		if(in_array($v,$arrMustDirs)){
			$arrModuleDirs[$k]['state'] = 2;
		}else $arrModuleDirs[$k]['state'] = 0;
		$arrModuleDirs[$k]['id'] = $v;
		include('../'.$v.'/config/var.inc.php');
		$arrModuleDirs[$k]['name'] = $arrGWeb['module_name'];	
	}

	$arrMOutput["smarty_assign"]['arrModuleDirs'] = $arrModuleDirs;
	$arrMOutput["smarty_assign"]['step'] = 5;
	$arrMOutput["smarty_assign"]['info'] = '选择需要安装的栏目';
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'step5.html';
	$arrMOutput['smarty_assign']['Title'] = $arrMOutput["smarty_assign"]['info'].' - BIWEB WMS安装第五步';
}elseif($_GET['step']==6){
	//数据库连接
	$objWebInit->db();

	$charset = str_replace('-', '', $arrGWeb['charset']);
	$extend = $objWebInit->db->getAttribute(PDO::ATTR_SERVER_VERSION) > '4.1' ? " DEFAULT CHARSET={$charset} " : "";

	//写入频道数组
	$strWEB_ROOT_pre = $arrGWeb['WEB_ROOT_pre'];
	unset($arrGWeb);
	$strFilename = __WEB_ROOT.'/data/webconfig.inc.php';
	@include($strFilename);

	if(!is_file(__WEB_ROOT.'/data/install.lock')){
		$arrGMeta = array();
		$arrGMeta['index']['name'] = '网站首页';
		$arrGMeta['index']['meta'] = array(
										  'Title' => '',
										  'Description' => '',
										  'Keywords' => '',
										);
		$arrGMeta['user']['name'] = '用户系统';
		$arrGMeta['user']['admin'] = array(
											array ('href' => '../mcenter/admin/',
												   'name' => '用户中心管理',)
											);
		$arrGMeta['user']['meta'] = array(
										  'Title' => $arrGMeta['user']['name'],
										  'Description' => $arrGMeta['user']['name'],
										  'Keywords' => $arrGMeta['user']['name'],
										);
		$arrGWeb['templates_id'] = '1';
		$arrGWeb['smarty_caching'] = '0';
		$arrGWeb['smarty_cache_lifetime'] = '43200';
		$arrGWeb['SquidTime'] = '0';
		$arrGWeb['PDO_CACHE'] = '0';
		$arrGWeb['PDO_CACHE_LIFETIME'] = '43200';
		$arrGWeb['MEM_CACHE'] = '0';
		$arrGWeb['FileExt_state'] = '0';
		$arrGWeb['URL_static'] = '1';
		$arrGWeb['file_suffix'] = '.html';
		$arrGWeb['file_static'] = '0';
		$arrGWeb['name'] = 'BIWEB WMS SEO效果最好的网站管理系统';
		$arrGWeb['host'] = 'www.biweb.cn';
		$arrGWeb['company'] = '上海网务网络信息有限公司';
		$arrGWeb['service_swh'] = '1';
		$arrGWeb['service'] =  array('qq' =>array (0 => '280809391',),);

		//写入webconfig.inc.php
		$somecontent = '<?php' . "\n" . '$arrGWeb = ' . var_export( $arrGWeb, true ) . ';' . "\n" . '$arrGMeta = ' . var_export( $arrGMeta, true ) . ';' . "\n" . '?>';

		if (!$handle = fopen($strFilename, 'w')) {
			 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
		}

		// 将$somecontent写入到我们打开的文件中。
		if (fwrite($handle, $somecontent) === FALSE) {
			check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
		}
		fclose($handle);

		//写入illegal.inc.php
		@include('illegal.inc.php');
		$somecontent = '<?php' . "\n" . '$arrGIllegal = ' . var_export( $arrGIllegal, true ) . ';' . "\n" . '?>';
		$strFilename =  __WEB_ROOT.'/data/illegal.inc.php';
		if (!$handle = fopen($strFilename, 'w')) {
			 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
		}
		// 将$somecontent写入到我们打开的文件中。
		if (fwrite($handle, $somecontent) === FALSE) {
			check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
		}
		fclose($handle);

		//写入keywords.inc.php
		@include('keywords.inc.php');
		$somecontent = '<?php' . "\n" . '$arrGKeywords = ' . var_export( $arrGKeywords, true ) . ';' . "\n" . '?>';
		$strFilename =  __WEB_ROOT.'/data/keywords.inc.php';
		if (!$handle = fopen($strFilename, 'w')) {
			 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
		}
		// 将$somecontent写入到我们打开的文件中。
		if (fwrite($handle, $somecontent) === FALSE) {
			check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
		}
		fclose($handle);

		//写入navigate.inc.php
		@include('navigate.inc.php');
		$somecontent = '<?php' . "\n" . '$arrGNavigate = ' . var_export( $arrGNavigate, true ) . ';' . "\n" . '?>';
		$strFilename =  __WEB_ROOT.'/data/navigate.inc.php';
		if (!$handle = fopen($strFilename, 'w')) {
			 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
		}
		// 将$somecontent写入到我们打开的文件中。
		if (fwrite($handle, $somecontent) === FALSE) {
			check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
		}
		fclose($handle);

		//写入smtp.inc.php
		$arrMsmtp = array (
		  0 => 
		  array (
			'host' => 'smtp.gmail.com',
			'port' => '465',
			'username' => 'biwebposter1@gmail.com',
			'password' => 'biweb1poster',
			'ssl' => 'ssl',
			'auth' => true,
			'replyuname' => '',
			'replymail' => '',
			'pass' => 1,
		  ),
		);
		$somecontent = '<?php' . "\n" . '$arrMsmtp = ' . var_export( $arrMsmtp, true ) . ';' . "\n" . '?>';
		$strFilename =  __WEB_ROOT.'/data/smtp.inc.php';
		if (!$handle = fopen($strFilename, 'w')) {
			 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
		}
		// 将$somecontent写入到我们打开的文件中。
		if (fwrite($handle, $somecontent) === FALSE) {
			check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
		}
		fclose($handle);

		//各栏目安装
		if(!empty($_POST['install_module'])){
			$arrModule = $_POST['install_module'];
			//增加一些必安装的栏目
			$arrModule[] = 'logs';
			if(empty($_SESSION['mc_type'])) $arrModule[] = 'mcenter';
			$arrModule[] = 'user';
			$arrModule[] = 'archives';
			$arrModule[] = 'ads';
			$arrModule[] = 'links';
			$arrModule[] = 'emaillist';
			$arrModule[] = 'phonelist';
			unset($ver_path);
			foreach($arrModule as $v){
				$sql = array();
				if(file_exists('../'.$v.'/install.php')) include('../'.$v.'/install.php');
			}
		}
		file_put_contents(__WEB_ROOT.'/data/install.lock',1);
	}
	
	unset($_SESSION);	
	session_destroy();
	include('config/config.inc.php');
	$arrMOutput["smarty_assign"]['step'] = 6;
	$arrMOutput["smarty_assign"]['info'] = '中文版安装完成';
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'step6.html';
	$arrMOutput['smarty_assign']['Title'] = $arrMOutput["smarty_assign"]['info'].' - BIWEB WMS安装第六步';
}elseif($_GET['step']==7){
	$arrMOutput["smarty_assign"]['step'] = 7;
	$arrMOutput["smarty_assign"]['info'] = '设置英文版数据库及管理员信息';
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'step7.html';
	$arrMOutput['smarty_assign']['Title'] = $arrMOutput["smarty_assign"]['info'].' - BIWEB WMS安装第七步';
}elseif($_GET['step']==8){
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty($_POST['db_host'])||empty($_POST['db_port'])||empty($_POST['db_user'])||empty($_POST['db_name'])){
			check::AlertExit("错误：数据库地址、端口、用户名和库名信息必须填写!",-1);
		}
		if(empty($_POST['password'])||empty($_POST['user_name'])||empty($_POST['real_name'])||empty($_POST['email'])) check::AlertExit("错误：管理员的信息必须全部填写!",-1);
		if($_POST['password'] != $_POST['password_c']) check::AlertExit("错误：两次输入的密码不相同!",-1);
		$_SESSION['user_name'] = $_POST['user_name'];
		$_SESSION['real_name'] = $_POST['real_name'];
		$_SESSION['email'] = $_POST['email'];
		if(!empty($_POST['user_pass_type']) && $_POST['user_pass_type'])
			$_SESSION['password'] = check::strEncryption($_POST['password'],$_POST['jamstr']);
		else $_SESSION['password'] = $_POST['password'];
		$_SESSION['install_type'] = $_POST['install_type'];
		$_SESSION['user_pass_type'] = $_POST['user_pass_type'];
		$_SESSION['jamstr'] = $_POST['jamstr'];
		unset($_POST['user_name']);
		unset($_POST['real_name']);
		unset($_POST['email']);
		unset($_POST['password']);
		unset($_POST['password_c']);
		unset($_POST['install_type']);

		unset($arrGWeb);
		$strFilename = '..'.$ver_path.'/data/webconfig.inc.php';
		//include($strFilename);
		foreach($_POST as $k=>$v){
			if($k == 'biweb') continue;
			$arrGWeb[$k] = $v;
		}
		$arrGWeb['install_date'] = $_SESSION['install_date'];
		if(ini_get('allow_url_fopen') && @file_get_contents('http://www.baidu.com')){
			$arrGWeb['file_static'] = '1';
		}else{
			$arrGWeb['file_static'] = '0';
		}

		$virtual_path = $_SERVER['SCRIPT_NAME'];
		$virtual_path = substr($virtual_path, 0, strpos($virtual_path, '/install'));
		$arrGWeb['WEB_ROOT_pre'] = $virtual_path;

		$somecontent = '<?php' . "\n" . '$arrGWeb = ' . var_export( $arrGWeb, true ) . ';' . "\n" . '$arrGMeta = ' . var_export( $arrGMeta, true ) . ';' . "\n" . '?>';

		// 首先我们要确定文件存在并且可写。
		if (!$handle = fopen($strFilename, 'w')) {
			 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
		}

		// 将$somecontent写入到我们打开的文件中。
		if (fwrite($handle, $somecontent) === FALSE) {
			check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
		}
		fclose($handle);
	}elseif(empty($arrGPdoDB['db_name']) || empty($arrGPdoDB['db_user'])){
		check::AlertExit("错误：数据库名和数据库用户名必须填写!",-1);
	}

	$arrTreeDirs = array();
	check::mapTreeDirs('..'.$ver_path,false,false);

	$arrModuleDirs = array();

	foreach($arrTreeDirs as $k => $v){
		if(in_array($v,array('en','useradmin','uploadfile','templates','plug-in','html','data','config','compile','cache',substr(__WEBADMIN_ROOT,1),'install'))){
			continue;
		}
		if(!is_dir('../'.$v.'/config')) continue;

		if(in_array($v,array('wap','user','rss','sitemap','links','guest','archives','keywords'))){
			$arrModuleDirs[$k]['state'] = 2;
		}else $arrModuleDirs[$k]['state'] = 0;
		$arrModuleDirs[$k]['id'] = $v;
		@include('..'.$ver_path.'/'.$v.'/config/var.inc.php');
		$arrModuleDirs[$k]['name'] = $arrGWeb['module_name'];		
	}
	$arrMOutput["smarty_assign"]['arrModuleDirs'] = $arrModuleDirs;
	$arrMOutput["smarty_assign"]['step'] = 8;
	$arrMOutput["smarty_assign"]['info'] = '选择需要安装的栏目';
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'step8.html';
	$arrMOutput['smarty_assign']['Title'] = $arrMOutput["smarty_assign"]['info'].' - BIWEB WMS安装第八步';
}elseif($_GET['step']==9){
	$charset = str_replace('-', '', $arrGWeb['charset']);
	unset($arrGWeb);
	$strFilename = __WEB_ROOT.$ver_path.'/data/webconfig.inc.php';
	@include($strFilename);
	//数据库参数
	@include(__WEB_ROOT.$ver_path.'/config/pdodb.inc.php');
	//连接数据库
	$objWebInit->db($arrGPdoDB);

	
	$extend = $objWebInit->db->getAttribute(PDO::ATTR_SERVER_VERSION) > '4.1' ? " DEFAULT CHARSET={$charset} " : "";

	//写入频道数组
	$virtual_path = $_SERVER['SCRIPT_NAME'];
	$virtual_path = substr($virtual_path, 0, strpos($virtual_path, '/install'));
	$arrGWeb['WEB_ROOT_pre'] = $virtual_path.$ver_path;
	$strWEB_ROOT_pre = $arrGWeb['WEB_ROOT_pre'];
	
		
	if(!file_exists(__WEB_ROOT.$ver_path.'/data/install.lock')){
		$arrGMeta = array();
		$arrGMeta['index']['name'] = '网站首页';
		$arrGMeta['index']['meta'] = array(
										  'Title' => '',
										  'Description' => '',
										  'Keywords' => '',
										);
		$arrGMeta['user']['name'] = '用户系统';
		$arrGMeta['user']['admin'] = array(
											array ('href' => '../user/admin/',
												   'name' => '网站会员管理',)
											);
		$arrGMeta['user']['meta'] = array(
										  'Title' => $arrGMeta['user']['name'],
										  'Description' => $arrGMeta['user']['name'],
										  'Keywords' => $arrGMeta['user']['name'],
										);
		$arrGMeta['links']['name'] = '友情链接';
		$arrGMeta['links']['admin'] = array(
											array ('href' => '../links/admin/',
												   'name' => '友情链接管理',)
											);
		$arrGMeta['links']['meta'] = array(
										  'Title' => $arrGMeta['links']['name'],
										  'Description' => $arrGMeta['links']['name'],
										  'Keywords' => $arrGMeta['links']['name'],
										);
		$arrGWeb['templates_id'] = '1';
		$arrGWeb['smarty_caching'] = '0';
		$arrGWeb['smarty_cache_lifetime'] = '43200';
		$arrGWeb['SquidTime'] = '0';
		$arrGWeb['PDO_CACHE'] = '0';
		$arrGWeb['PDO_CACHE_LIFETIME'] = '43200';
		$arrGWeb['MEM_CACHE'] = '0';
		$arrGWeb['FileExt_state'] = '0';
		$arrGWeb['URL_static'] = '1';
		$arrGWeb['file_suffix'] = '.html';
		$arrGWeb['file_static'] = '0';
		$arrGWeb['name'] = 'BIWEB WMS SEO效果最好的网站管理系统';
		$arrGWeb['host'] = 'www.biweb.cn';
		$arrGWeb['company'] = '上海网务网络信息有限公司';
		$arrGWeb['service_swh'] = '1';
		$arrGWeb['service'] =  array('qq' =>array (0 => '280809391',),);

		//写入webconfig.inc.php
		$somecontent = '<?php' . "\n" . '$arrGWeb = ' . var_export( $arrGWeb, true ) . ';' . "\n" . '$arrGMeta = ' . var_export( $arrGMeta, true ) . ';' . "\n" . '?>';

		if (!$handle = fopen($strFilename, 'w')) {
			 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
		}

		// 将$somecontent写入到我们打开的文件中。
		if (fwrite($handle, $somecontent) === FALSE) {
			check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
		}
		fclose($handle);

		//写入illegal.inc.php
		@include('illegal.inc.php');
		$somecontent = '<?php' . "\n" . '$arrGIllegal = ' . var_export( $arrGIllegal, true ) . ';' . "\n" . '?>';
		$strFilename =  __WEB_ROOT.$ver_path.'/data/illegal.inc.php';
		if (!$handle = fopen($strFilename, 'w')) {
			 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
		}
		// 将$somecontent写入到我们打开的文件中。
		if (fwrite($handle, $somecontent) === FALSE) {
			check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
		}
		fclose($handle);

		//写入keywords.inc.php
		@include('keywords.inc.php');
		$somecontent = '<?php' . "\n" . '$arrGKeywords = ' . var_export( $arrGKeywords, true ) . ';' . "\n" . '?>';
		$strFilename =  __WEB_ROOT.$ver_path.'/data/keywords.inc.php';
		if (!$handle = fopen($strFilename, 'w')) {
			 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
		}
		// 将$somecontent写入到我们打开的文件中。
		if (fwrite($handle, $somecontent) === FALSE) {
			check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
		}
		fclose($handle);

		//写入navigate.inc.php
		@include('navigate.inc.php');
		$somecontent = '<?php' . "\n" . '$arrGNavigate = ' . var_export( $arrGNavigate, true ) . ';' . "\n" . '?>';
		$strFilename =  __WEB_ROOT.'/data/navigate.inc.php';
		if (!$handle = fopen($strFilename, 'w')) {
			 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
		}
		// 将$somecontent写入到我们打开的文件中。
		if (fwrite($handle, $somecontent) === FALSE) {
			check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
		}
		fclose($handle);

		//写入smtp.inc.php
		$arrMsmtp = array (
		  0 => 
		  array (
			'host' => 'smtp.gmail.com',
			'port' => '465',
			'username' => 'biwebposter1@gmail.com',
			'password' => 'biweb1poster',
			'ssl' => 'ssl',
			'auth' => true,
			'replyuname' => '',
			'replymail' => '',
			'pass' => 1,
		  ),
		);
		$somecontent = '<?php' . "\n" . '$arrMsmtp = ' . var_export( $arrMsmtp, true ) . ';' . "\n" . '?>';
		$strFilename =  __WEB_ROOT.$ver_path.'/data/smtp.inc.php';
		if (!$handle = fopen($strFilename, 'w')) {
			 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
		}
		// 将$somecontent写入到我们打开的文件中。
		if (fwrite($handle, $somecontent) === FALSE) {
			check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
		}
		fclose($handle);

		//各栏目安装
		if(!empty($_POST['install_module'])){
			$arrModule = $_POST['install_module'];

			//增加一些必安装的栏目
			$arrModule[] = 'user';
			foreach($arrModule as $v){
				$sql = array();
				include('..'.$ver_path.'/'.$v.'/install.php');
			}
		}
		file_put_contents(__WEB_ROOT.$ver_path.'/data/install.lock',1);


	}else check::AlertExit('BIWEB网站系统已经安装,请勿重复安装！',-1);

	unset($_SESSION['session_test']);
	include('config/config.inc.php');
	$arrMOutput["smarty_assign"]['step'] = 9;
	$arrMOutput["smarty_assign"]['info'] = '英文版安装完成';
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'step9.html';
	$arrMOutput['smarty_assign']['Title'] = $arrMOutput["smarty_assign"]['info'].' - BIWEB WMS安装第九步';
}
// 输出到模板
$objWebInit->output($arrMOutput);
?>