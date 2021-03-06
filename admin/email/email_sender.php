<?php
/**
 * EMAIL营销后台管理栏目搜索抓取文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	email
 */
require_once('../config/config.inc.php');
require_once('../checklogin.php');

$objWebInit = new ArthurXF();
//smarty参数
$objWebInit->arrGSmarty = $arrGSmarty;

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','email')) {
	check::AlertExit('对不起，您没有权限访问此页',-1);
}

$strFilename = '../../data/smtp.inc.php';
@include($strFilename);
if(empty($arrMsmtp)) check::AlertExit("错误：SMTP邮局尚未设定，请到SMTP邮局管理栏目设定后再来使用!",-1);
foreach($arrMsmtp as $k => $v){
	if($v['pass'] == 0) unset($arrMsmtp[$k]);
}
if(empty($arrMsmtp)) check::AlertExit("错误：有效的SMTP邮局尚未设定，请到SMTP邮局管理栏目设定后再来使用!",-1);

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	unset($_POST['okgo']);
	if(empty($_POST['strEmail'])) check::AlertExit("错误：邮件地址没填!",-1);
	set_time_limit(0);
	//ini_set('max_execution_time',0);
	ignore_user_abort();

	if(!empty($_POST['spacemark'])){
		if(strpos($_POST['strEmail'],$_POST['spacemark']) === false){
			$arrEmail = explode("\r\n",$_POST['strEmail']);
		}else{
			$arrEmail = explode($_POST['spacemark'],$_POST['strEmail']);
		}
	}else{
		$arrEmail = explode("\r\n",$_POST['strEmail']);
	}
	$arrMOutput["smarty_assign"]['strOldEmailCount'] = count($arrEmail);
	if(!empty($arrEmail)){
		$objShared = System_SharedMemory::factory();
		//$objShared->rm('log');
		$intSendNum = $objShared->get('emaillog');

		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

		$mail->IsSMTP(); // telling the class to use SMTP
		//$mail->IsMail();

		shuffle($arrMsmtp);
		
		$intSmtpKey = 0;
		/*
		$mail->CharSet = 'utf-8';
		$mail->Encoding    = "base64";
		$mail->SetLanguage = 'zh_cn';
		$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
		$mail->SMTPAuth   = $arrMsmtp[$intSmtpKey]['auth'];                  // enable SMTP authentication
		if($mail->SMTPSecure==1){
			//$mail->SMTPSecure = $arrMsmtp[$intSmtpKey]['ssl'];                 // sets the prefix to the servier
		}
		$mail->Host       = $arrMsmtp[$intSmtpKey]['host'];      // sets GMAIL as the SMTP server
		$mail->Port       = $arrMsmtp[$intSmtpKey]['port'];                   // set the SMTP port for the GMAIL server
		$mail->Username   = $arrMsmtp[$intSmtpKey]['username'];  // GMAIL username
		$mail->Password   = $arrMsmtp[$intSmtpKey]['password'];            // GMAIL password

		$mail->Subject = $_POST['title'];
		//$mail->SetFrom($_POST['sendmail'], $_POST['senduname']);
		*/
		
		$mail->Host = $arrMsmtp[$intSmtpKey]['host'];                     
		$mail->SMTPAuth = true;                   
		$mail->CharSet = "utf-8";             
		$mail->Encoding = "base64";
		$mail->Username = $arrMsmtp[$intSmtpKey]['username'];                          
		$mail->Password = $arrMsmtp[$intSmtpKey]['password'];              
		$mail->From = $arrMsmtp[$intSmtpKey]['username'];           
		$mail->FromName = "U客网";                
		$mail->Subject = $_POST['title'];

		if(empty($_POST['replymail'])) $_POST['replymail'] = $arrMsmtp[$intSmtpKey]['replymail'];
		if(empty($_POST['replyuname'])) $_POST['replyuname'] = $arrMsmtp[$intSmtpKey]['replyuname'];
		$mail->AddReplyTo($_POST['replymail'], $_POST['replyuname']);
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		$intKey = 0;
		$_POST['intro'] = strpos($_POST['intro'],'\r\n')===false?str_replace("<br>", "\r\n", $_POST['intro']):$_POST['intro'];
		
		foreach($arrEmail as $v){
			if(empty($v)) continue;
			if(!check::CheckEmailAddr($v)){continue;}
			if(!empty($_POST['linkurl'])){
				$smtv=$v;
				$mycontent2=file_get_contents($_POST['linkurl']."?email={$v}");
				$_POST['intro']=$mycontent2;
			}			
			//$_POST['intro'] = file_get_contents("http://5217u/usermoney/fanli.php?email={$v}");
			$objShared->set('emaillog', ++$intSendNum);		
			$mail->MsgHTML($_POST['intro']);
			$mail->AddAddress($v, substr($v,0,strpos($v,'@')));
			$intKey++;
			if($intKey == $_POST['type_id']) {
				$intKey = 0;
				try {
					$mail->Send();
					$mail->ClearAllRecipients();
				} catch (Exception $e) {
				}
				
			}
		}
		
		if($intKey != 0){
			try {
				$mail->Send();
			} catch (Exception $e) {
			}
		}
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();
		check::Alert("发送完毕!",-1);
	}

	//exit;
}

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = 'Email按照设定发送';
$arrMOutput["smarty_assign"]['arrMsmtp'] = $arrMsmtp[0];
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'email/email_sender.htm';
$objWebInit->output($arrMOutput);
?>