<?php
function insert_getSession(){
	global $arrGWeb;
	if(!empty($_SESSION['user_name'])){
		$strHtml = '<span color=#FF6600 style="width:40px; height:14px; overflow:hidden">欢迎您，'.$_SESSION['nick_name'].'</span>&nbsp;&nbsp;<a href="' . $arrGWeb['WEB_ROOT_pre'] .'/useradmin/" target="_self" title="'.$_SESSION['nick_name'].'" style="text-decoration:underline; color:red"><font color=#FF6600 class="alink">[修改资料]</font></a>&nbsp;&nbsp;<a href="' . $arrGWeb['WEB_ROOT_pre'] . '/user/logout.php" target="_self" style="text-decoration:underline; color:red"><font color=#FF6600 class="alink">[退出]</font></a>';
	}else{
		$strHtml = '您还没有 <a href="'.$arrGWeb['WEB_ROOT_pre'].'/user/login.php" style="text-decoration:underline; color:red">登录</a> 或者 <a href="'.$arrGWeb['WEB_ROOT_pre'].'/user/regin.php" style="text-decoration:underline; color:red">注册</a>';
	}

	return $strHtml;
}
?>
