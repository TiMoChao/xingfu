<?php
/**
 * 会员栏目登陆文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	user
 */
require_once('config/config.inc.php');
require_once("class/user.class.php");

$objWebInit = new user();
$objWebInit->db();

if(empty($_SESSION['jumpURL'])){
	$_SESSION['jumpURL'] = $_SERVER['HTTP_REFERER'];
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if (empty($_POST['authCode'])||$_POST['authCode']!=$_SESSION['captcha']){
		check::AlertExit("错误：验证码不匹配!",-1);
	}
	
	if ($objWebInit->userLogin($_POST,$arrGWeb['user_pass_type'],$arrGWeb['jamstr'])){
		// 选择了记住用户名，用cookie的方式记录下来, 只记录用户名
		if(!empty($_POST['SafeControl'])){// 需要记录
			setcookie('User', $_POST['User'], time()+32140800, '/'); // 默认有效期1年，
			setcookie('User_check', $_POST['SafeControl'], time()+32140800, '/');
		}else{// 取消记录
			setcookie('User', $_POST['User'], time()-100, '/'); // 不需要记录，让Cookie 过期
			setcookie('User_check', $_POST['SafeControl'], time()-100, '/');
		}				

		if(!empty($_SESSION['jumpURL'])){
			$strUrl = $_SESSION['jumpURL'];
		}else{
			$strUrl = $arrGWeb['WEB_ROOT_pre'].'/useradmin/';
		}
		unset($_SESSION['jumpURL']);
		header("Location: $strUrl");
		exit;
	}
}

$strTitle = $arrGWeb['name'];
$strDescription = $strTitle;
$strKeywords = $strTitle;

// 输出到模板
$arrMOutput['smarty_assign']['Title'] = $strTitle.' - 登录';
$arrMOutput['smarty_assign']['Description'] = $strDescription.' - '.$arrGWeb['name'];
$arrMOutput['smarty_assign']['Keywords'] = $strKeywords.' - '.$arrGWeb['name'];
$arrMOutput["smarty_assign"]['arrGWeb']['css'][] = 'reg.css';
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['main_dir'].'login.html';
$objWebInit->output($arrMOutput);
?>