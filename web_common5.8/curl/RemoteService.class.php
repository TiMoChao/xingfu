<?php
/**
 * 通行证服务
 */
 //设置PHPExcel类库的include path  
set_include_path('.' . PATH_SEPARATOR . __WEBCOMMON_ROOT. '/curl/' . PATH_SEPARATOR . get_include_path());
class RemoteService {
	private $_curl = '';
	private $_postfix='biweb';
	public function __construct() {
		$this->init();
	}

	private function init(){
		@require_once 'CurlClient.class.php';
		$this->_curl = new CurlClient();
	}
	/**
	 * 简化处理curl函数 之后在引入封装的curl类供使用 auho
	 * @param unknown_type $remote
	 */	
	 public function getContent($remoteUrl, $method = 'GET', $postField = ''){
		return $this->_curl->call($remoteUrl, $method, $postField);
	 }
	 private function paserParams($params){
	 	$result='';
	 	$md5Str='';
	 	if(empty($params)){
	 		return '';
	 	}
	 	if(is_array($params)){
	 		foreach ($params as $key=>$value){
	 			$result .='/'.urlencode($value);
	 		}
	 		$md5Str =implode('', $params);
	 	}else{
	 		$result = '/'.urlencode($params);
	 		$md5Str =$params;
	 	}
	 	$md5Str.=$this->_postfix;
	 	return $result .='/'.md5($md5Str);
	 }
	 public function getAPI($remoteUrl,$params, $method = 'GET', $postField = ''){
	 	$url=$remoteUrl.$this->paserParams($params);
	 	
	 	$str = $this->_curl->call($url, $method, $postField);
//	 	echo $url;
//	 	echo '====='.$str;
	 	$arr =json_decode($str,TRUE);
		return $arr;
	 }
}
?>