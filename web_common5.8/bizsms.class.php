<?php
/**
 * 10658���Žӿڷ�װ���ļ�
 * ʹ�÷�����
 * ʵ����BizSMS�࣬������setParam���������ýӿڵĻ����������μ�����Ŀ¼/data/sms.inc.php����Ȼ�����sendShortMessage�������Ͷ���
 *
 */

class BizSMS {
	//var $username='shyj6163' ;//Username=��ҵ���+�û���
	//var $password='yesshou' ;//Password=���������Md5�����ַ���
	//var $url="http://www.smsadmin.cn/smsmarketing/wwwroot/api/post_send/";//���Ͷ��ŵĵ�ַ
	//var $url_1="http://www.smsadmin.cn/smsmarketing/wwwroot/api/user_info/";//��ѯ���ĵ�ַ
	//var $wsdlURL='';//wsdlURL

	/**
	 * PHP5�Ĺ��캯��
	 * @author	Ф��
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
	 * PHP4�Ĺ��캯��
	 * @author	Ф��
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
	 * ���Ͷ��ŷ���
	 *  $mobiles Ϊ�ֻ����룬֧��Ⱥ��������ֻ�����Ӣ�ķֺš�;���ŷָ�����Ƕ��ţ���δβ����Ҫ�ӡ�;��Ӣ�ķֺ�
	 *	$msg Ϊ���͵����ݡ�
	 *  $dtime ʱ��(ʱ��Ϊ��Ϊ��������,��ʽ:2007-12-01 00:00:00)
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
	 *  ��ö����˻���Ϣ
	 */
	function getMsgInfo(){
		$query = "?uid={$this->username}&pwd={$this->password}";
		$url = $this->url_1.$query;
		$re=$this->posttohost($url,array());
		return iconv("GB2312","UTF-8",$re);
	}
	
	/**
	 *  ������֤��
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
	 *  ȡ����֤��
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
	*	php ģ�� post �ύ���� �ķ���
	*	$url �ύ��ַ �൱�ڱ��� action
	*	$data ������ʽ �ύ������
	*/
	function posttohost($url, $data,$get=false) {
		/* ����url */
		$url = parse_url ( $url );
		if (! $url)
			return "couldn��t parse url";
		if (! isset ( $url ['port'] )) {
			$url ['port'] = "";
		}
		if (! isset ( $url ['query'] )) {
			$url ['query'] = "";
		}

		/* ����post ���� */
		$encoded = "";
		while ( list ( $k, $v ) = each ( $data ) ) {
			$encoded .= ($encoded ? "&" : "");
			$encoded .= rawurlencode ( $k ) . "=" . rawurlencode ( $v );
		}
		$fp = fsockopen ( $url ['host'], $url ['port'] ? $url ['port'] : 80 );
		if (! $fp)
			return "Failed to open socket to $url[host]";
		
		/* ����post ���� */
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
