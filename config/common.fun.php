<?php
/**
 * 网站架构公用全局函数文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	frame
 */
/**
 * 去除PHP的标记符号
 * @author	肖飞 (ArthurXF)
 * @param	string	$string			php文件字符串
 * @return  string
 */
function strip_php($string){
	$arr = array('<?PHP','<?php','<?','?>');
	foreach($arr as $v){
		$string = str_replace($v,'',$string);
	}
	return $string;
}

/**
 * 加载文件进入共享内存中
 * @author	肖飞 (ArthurXF)
 * @param	string	$string			php文件路径
 * @param	string	$strVarName		共享内存的名字
 * @param	bool	$isCache		是否使用共享内存 0=不使用 1=使用 2=更新
 * @return  string
 */
function menload_file($string,$isCache=1,$strVarName=''){
	global $arrGWeb;
	if(!file_exists($string)) return;
	if($isCache == 0){
		$strShared = file_get_contents($string);
	}else{
		if(empty($strVarName)) $strVarName =$arrGWeb['install_date'].basename($string);
		include_once(__WEBCOMMON_ROOT . '/SharedMemory/SharedMemory.php');

		$objShared = System_SharedMemory::factory();
		if($isCache == 2) $objShared->rm($strVarName);
		$strShared = $objShared->get($strVarName);
		
		if(empty($strShared)){
			$objShared->set($strVarName, file_get_contents($string));
			$strShared = $objShared->get($strVarName);
		}
	}
	return strip_php($strShared);
}

/**
 *  异步传输共享内存中更新
 * @author	肖飞 (ArthurXF)
 * @param	array	 	$arrData				保存的内容
 * @param	string	$strVarName		共享内存的名字
 * @param	bool	$isSave		是否保存到共享内存 0=取出 1=保存 2=更新
 * @return  string
 */
function menload_paylog($isSave=1,$arrData=array(),$strVarName=''){
	global $arrGWeb;
	$objShared = System_SharedMemory::factory();
	if(empty($strVarName)) $strVarName =$arrGWeb['install_date'].'paylog';
	//$objShared->rm($strVarName);//调试用
	$strPayLog = $objShared->get($strVarName);
	if(!empty($strPayLog)) $arrPayLog = json_decode($strPayLog,TRUE);
	if($isSave == 1){
		$arrPayLog[$arrData['user_id']] = $arrData;
	}elseif($isSave == 0){
		if(!empty($arrPayLog)&&array_key_exists($_SESSION['user_id'],$arrPayLog)){
			$_SESSION = array_merge($_SESSION,$arrPayLog[$_SESSION['user_id']]);
			unset($arrPayLog[$_SESSION['user_id']]);
		}
		unset($_SESSION['orderId']);
		unset($_SESSION['order']);
		unset($_SESSION['savemoney']);
		unset($_SESSION['task']);
		unset($_SESSION['paytype']);
		unset($_SESSION['paymoney']);
		unset($_SESSION['yue']);
	}
	$objShared->set($strVarName, json_encode($arrPayLog));
	return true;
}

function menload_paylog_2($isSave=1,$arrData=array(),$strVarName=''){
	global $arrGWeb;
	$objShared = System_SharedMemory::factory();
	if(empty($strVarName)) $strVarName =$arrGWeb['install_date'].'paylog2';
	//$objShared->rm($strVarName);//调试用
	$strPayLog = $objShared->get($strVarName);
	if(!empty($strPayLog)) $arrPayLog = json_decode($objShared->get($strVarName),TRUE);
	if($isSave == 1){
		$arrPayLog[$arrData['user_id']] = $arrData;
	}elseif($isSave == 0){
		if(!empty($arrPayLog)&&array_key_exists($_SESSION['user_id'],$arrPayLog)){
			$_SESSION = array_merge($_SESSION,$arrPayLog[$_SESSION['user_id']]);
			unset($arrPayLog[$_SESSION['user_id']]);
		}
		unset($_SESSION['order_id']);
		unset($_SESSION['order']);
		unset($_SESSION['savemoney']);
		unset($_SESSION['task']);
		unset($_SESSION['paytype']);
		unset($_SESSION['paymoney']);
		unset($_SESSION['yue']);
		unset($_SESSION['market']);unset($_SESSION['market_express_money']);unset($_SESSION['total_money']);unset($_SESSION['total_num']);
		unset($_SESSION['market_order_id']);unset($_SESSION['invite_reward']);unset($_SESSION['charge_fund']);unset($_SESSION['groupon_num']);
	}
	$objShared->set($strVarName, json_encode($arrPayLog));
	return true;
}

function count_referer($isSave=1,$uid=null){
	global $arrGWeb;
	$objShared = System_SharedMemory::factory();
	if(empty($strVarName)) $strVarName =$arrGWeb['install_date'].'referer';
	$arrPayLog = json_decode($objShared->get($strVarName),TRUE);
	if($isSave == 1){
		$arrPayLog[$uid] = 1;
	}elseif($isSave == 0){
		if(!empty($arrPayLog)&&array_key_exists($_SESSION['user_id'],$arrPayLog)){
			$host = empty($_COOKIE['referer_host'])?"5217u.com":$_COOKIE['referer_host'];
			$time = date("Y-m-d");
			$referer = check::getAPI("referer","getInfoWhere","where host='{$host}' and time='{$time}'^*");
			if(empty($referer)){
				$arr_referer = array();
				$arr_referer['time']=$time;
				$arr_referer['host']=$host;
				$arr_referer['buy_times']=1;
				$str_referer = check::getAPIArray($arr_referer);
				check::getAPI("referer","saveInfo","$str_referer^0^0");
			}else{
				$referer['buy_times']+=1;
				$str_referer = check::getAPIArray($referer);
				check::getAPI("referer","saveInfo","$str_referer^1^0");
			}
			unset($arrPayLog[$_SESSION['user_id']]);
		}
	}
	$objShared->set($strVarName, json_encode($arrPayLog));
	return true;
}

function setCookieFormReferer(){
	$url = $_SERVER['HTTP_REFERER'];
	if(!empty($url)){
		$arrTemp = parse_url($url);
		$strHost = $arrTemp['host'];
		if(!preg_match("/5217u.com/i",$strHost)){
			$dis_time=strtotime(date("Y-m-d",time()+24*3600))-time();
			setcookie("referer_host",$strHost,time()+$dis_time, '/');
		}
	}
}
?>