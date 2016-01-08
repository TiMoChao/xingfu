<?php
/**
 * 10658短信接口封装类文件
 * 使用方法：
 * 实例化BizSMS类，并调用setParam方法，设置接口的基本参数（参见：根目录/data/sms.inc.php），然后调用sendShortMessage方法发送短信
 *
 */

class BizSMS {
	//var $username='shyj6163' ;//Username=企业编号+用户名
	//var $password='yesshou' ;//Password=接入密码的Md5加密字符串
	//var $url="http://www.smsadmin.cn/smsmarketing/wwwroot/api/post_send/";//发送短信的地址
	//var $url_1="http://www.smsadmin.cn/smsmarketing/wwwroot/api/user_info/";//查询余额的地址
	//var $wsdlURL='';//wsdlURL

	/**
	 * PHP5的构造函数
	 * @author	肖飞
	 * @return  void
	 */
	function __construct() {
		include(__WEB_ROOT.'/data/sms.inc.php');
		if(empty($arrMBizParam)) {
			echo "Fail: arrMBizParam is empty!";
			return false;
		}
		$this->setParam($arrMBizParam);
	}

	/**
	 * PHP4的构造函数
	 * @author	肖飞
	 * @version	2012/5/18
	 * @return  void
	 */
	function BizSMS() {
		$this->__construct();
	}

	function setParam($arr){		
		$this->username=$arr['username'];
		$this->password=$arr['password'];
		$this->url=$arr['wsdlURL_send'];
		$this->url_1=$arr['wsdlURL_query'];
	}
	
	
	/**
	 * 发送短信方法
	 *  $mobiles 为手机号码，支持群发，多个手机号用英文分号“;”号分隔（半角逗号），未尾不需要加”;”英文分号
	 *	$msg 为发送的内容。
	 *  $dtime 时间(时间为空为立即发送,格式:2007-12-01 00:00:00)
	 */
	function sendShortMessage($mobiles,$msg,$dtime=null){
		$data = array(
			"uid"=>$this->username,
			"pwd"=>$this->password,
			"mobile"=>$mobiles,
			"msg"=>iconv("UTF-8","GB2312",$msg), 
			"dtime"=>$dtime
		);
		$re=$this->posttohost($this->url,$data);
		return iconv("GB2312","UTF-8",$re);
	}

	/**
	 *  获得短信账户信息
	 */
	function getMsgInfo(){
		$query = "?uid={$this->username}&pwd={$this->password}";
		$url = $this->url_1.$query;
		$re=$this->posttohost($url,array());
		return iconv("GB2312","UTF-8",$re);
	}
	
	/**
	 *  发送验证码
	 */
	function sendAuthCode($phone,$msg){
		$url = "http://chufa.lmobile.cn/submitdata/service.asmx/g_Submit";
		$data = array(
			"sname"=>"dlsh0056",
			"spwd"=>"87654321",
			"scorpid"=>"",
			"sprdid"=>"1012818",
			"sdst"=>$phone,
			"smsg"=>$msg
		);
		$strReturnCode=$this->posttohost($url,$data);
		$xml = simplexml_load_string($strReturnCode);
		return $xml->State;
	}

	/**
	 *  取回验证码
	 */
	function getAuthCodeResult(){
		$url = "http://chufa.lmobile.cn/submitdata/service.asmx/Sm_GetRemain";
		$data = array(
			"sname"=>"dlsh0056",
			"spwd"=>"87654321",
			"scorpid"=>"",
			"sprdid"=>"1012818"
		);
		$strReturnCode=$this->posttohost($url,$data);
		$xml = simplexml_load_string($strReturnCode);
		if($xml->State == "0"){
			return $xml->Remain;
		}else{
			return $xml->State;
		};
	}

	/*
	*	php 模拟 post 提交数据 的方法
	*	$url 提交地址 相当于表单的 action
	*	$data 数组形式 提交的数据
	*/
	function posttohost($url, $data,$get=false) {
		/* 解析url */
		$url = parse_url ( $url );
		if (! $url)
			return "couldn’t parse url";
		if (! isset ( $url ['port'] )) {
			$url ['port'] = "";
		}
		if (! isset ( $url ['query'] )) {
			$url ['query'] = "";
		}

		/* 处理post 数据 */
		$encoded = "";
		while ( list ( $k, $v ) = each ( $data ) ) {
			$encoded .= ($encoded ? "&" : "");
			$encoded .= rawurlencode ( $k ) . "=" . rawurlencode ( $v );
		}
		$fp = fsockopen ( $url ['host'], $url ['port'] ? $url ['port'] : 80 );
		if (! $fp)
			return "Failed to open socket to $url[host]";
		
		/* 建立post 请求 */
		fputs ( $fp, sprintf ( "POST %s%s%s HTTP/1.0\n", $url ['path'], $url ['query'] ? "?" : "", $url ['query'] ) );
		fputs ( $fp, "Host: $url[host]\n" );
		fputs ( $fp, "Content-type: application/x-www-form-urlencoded\n" );
		fputs ( $fp, "Content-length: " . strlen ( $encoded ) . "\n" );
		fputs ( $fp, "Connection: close\n\n" );
		fputs ( $fp, "$encoded\n" );
		
		$line = fgets ( $fp, 1024 );
		if (! @eregi( "^HTTP/1\.. 200", $line )) {
			return;
		}
		$results = "";
		$inheader = 1;
		while ( ! feof ( $fp ) ) {
			$line = fgets ( $fp, 1024 );
			if ($inheader && ($line == "\n" || $line == "\r\n")) {
				$inheader = 0;
			} elseif (! $inheader) {
				$results .= $line;
			}
		}
		fclose ( $fp );
		return $results;
	}
}

?>
