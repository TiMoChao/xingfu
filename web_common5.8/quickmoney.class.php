<?php

/**
 * 快钱支付接口封装类文件
 * 
 * 
 *
 */
class QuickMoney {

	var $merchantAcctId="";//人民币网关账户号

	var $key="";//人民币网关密钥

	var $inputCharset="1";//字符集.固定选择值。可为空。

	var $pageUrl="";//接受支付结果的页面地址.与[bgUrl]不能同时为空。必须是绝对地址。

	var $bgUrl="";//服务器接受支付结果的后台地址.与[pageUrl]不能同时为空。必须是绝对地址。
	
	var $version="";//网关版本.固定值

	var $language="1";//语言种类.固定选择值。

	var $signType="1";//签名类型.固定值
   
	var $payerName="";//支付人姓名

	var $payerContactType="";	//支付人联系方式类型.固定选择值

	var $payerContact="";//支付人联系方式

	var $orderId='';//商户订单号

	var $orderAmount="";//订单金额
	
	var $orderTime='';//订单提交时间

	var $productName="";//商品名称

	var $productNum="";//商品数量

	var $productId="";//商品代码

	var $productDesc="";//商品描述
	
	var $ext1="";//扩展字段1

	var $ext2="";//扩展字段2
	
	var $quickMoneyURL='';//快钱的提交地址

	/**
	 * 00：组合支付（网关支付页面显示快钱支持的各种支付方式，推荐使用）
	 * 10：银行卡支付（网关支付页面只显示银行卡支付）.
	 * 11：电话银行支付（网关支付页面只显示电话支付）.
	 * 12：快钱账户支付（网关支付页面只显示快钱账户支付）.
	 * 13：线下支付（网关支付页面只显示线下支付方式）.
	 * 14：B2B支付（网关支付页面只显示B2B支付，但需要向快钱申请开通才能使用）
	 */
	var $payType="";//支付方式.固定选择值

	var $bankId="";//银行代码

	var $redoFlag="0";//同一订单禁止重复提交标志

	var $pid="";//快钱的合作伙伴的账户号

	var $signMsg;//签名
	
	
	/**
	 * 设置快钱接口的基本参数
	 * 要设置的项包括：
	 * 人民币网关账户号、人民币网关密钥、网关版本、语言种类、签名类型、支付方式、银行代码、同一订单禁止重复提交标志、快钱的合作伙伴的账户号
	 */
	function setBaseParam($arr){
		$this->merchantAcctId=$arr['merchantAcctId'];
		$this->key=$arr['key'];
		$this->version=$arr['version'];
		$this->payType=$arr['payType'];
		$this->quickMoneyURL=$arr['quickMoneyURL'];
	}
	
	/**
	 * 设置快钱接口的应用参数
	 * 要设置的项包括：
	 * 接受支付结果的页面地址、商户订单号、订单金额、订单提交时间{(后面的参数为可选参数)、支付人姓名、支付人联系方式类型、支付人联系方式、商品名称、商品数量、商品代码、商品描述、扩展字段}
	 */
	function setParam($arr){
		$this->pageUrl=$arr['pageUrl'];
		$this->orderId=$arr['orderId'];
		$this->orderAmount=$arr['orderAmount'];
		$this->orderTime=$arr['orderTime'];
		if (array_key_exists('ext1', $arr)) {
			$this->ext1=$arr['ext1'];
		}
		if (array_key_exists('ext2', $arr)) {
			$this->ext2=$arr['ext2'];
		}
	}
	
	/**
	 * 生成签名
	 */
	function getSignmsg(){
		$signmsgval = '';
		$signmsgval = $this->appendParam($signmsgval, "inputCharset", $this->inputCharset);
		$signmsgval = $this->appendParam($signmsgval, "pageUrl", $this->pageUrl);
		$signmsgval = $this->appendParam($signmsgval, "bgUrl", $this->bgUrl);
		$signmsgval = $this->appendParam($signmsgval, "version", $this->version);
		$signmsgval = $this->appendParam($signmsgval, "language", $this->language);
		$signmsgval = $this->appendParam($signmsgval, "signType", $this->signType);
		$signmsgval = $this->appendParam($signmsgval, "merchantAcctId", $this->merchantAcctId);
		$signmsgval = $this->appendParam($signmsgval, "payerName", $this->payerName);
		$signmsgval = $this->appendParam($signmsgval, "payerContactType", $this->payerContactType);
		$signmsgval = $this->appendParam($signmsgval, "payerContact", $this->payerContact);
		$signmsgval = $this->appendParam($signmsgval, "orderId", $this->orderId);
		$signmsgval = $this->appendParam($signmsgval, "orderAmount", $this->orderAmount);
		$signmsgval = $this->appendParam($signmsgval, "orderTime", $this->orderTime);
		$signmsgval = $this->appendParam($signmsgval, "productName", $this->productName);
		$signmsgval = $this->appendParam($signmsgval, "productNum", $this->productNum);
		$signmsgval = $this->appendParam($signmsgval, "productId", $this->productId);
		$signmsgval = $this->appendParam($signmsgval, "productDesc", $this->productDesc);
		$signmsgval = $this->appendParam($signmsgval, "ext1", $this->ext1);
		$signmsgval = $this->appendParam($signmsgval, "ext2", $this->ext2);
		$signmsgval = $this->appendParam($signmsgval, "payType", $this->payType);
		$signmsgval = $this->appendParam($signmsgval, "bankId", $this->bankId);
		$signmsgval = $this->appendParam($signmsgval, "redoFlag", $this->redoFlag);
		$signmsgval = $this->appendParam($signmsgval, "pid", $this->pid);
		$signmsgval = $this->appendParam($signmsgval, "key", $this->key);
		$signmsg    = strtoupper(md5($signmsgval));
		return $signmsg;
	}
	
	/**
	 * 生成快钱的html代码
	 */
	function getQuickMoneyHtml(){
		$this->signMsg = $this->getSignmsg();
		$def_url  = '<div style="text-align:center"><form name="kqPay" style="text-align:center;" method="post" action="'.$this->quickMoneyURL.'">';// target="_blank"
		$def_url .= "<input type='hidden' name='inputCharset' value='" . $this->inputCharset . "' />";
		$def_url .= "<input type='hidden' name='bgUrl' value='" . $this->bgUrl . "' />";
		$def_url .= "<input type='hidden' name='pageUrl' value='" . $this->pageUrl . "' />";
		$def_url .= "<input type='hidden' name='version' value='" . $this->version . "' />";
		$def_url .= "<input type='hidden' name='language' value='" . $this->language . "' />";
		$def_url .= "<input type='hidden' name='signType' value='" . $this->signType . "' />";
		$def_url .= "<input type='hidden' name='signMsg' value='" . $this->signMsg . "' />";
		$def_url .= "<input type='hidden' name='merchantAcctId' value='" . $this->merchantAcctId . "' />";
		$def_url .= "<input type='hidden' name='payerName' value='" . $this->payerName . "' />";
		$def_url .= "<input type='hidden' name='payerContactType' value='" . $this->payerContactType . "' />";
		$def_url .= "<input type='hidden' name='payerContact' value='" . $this->payerContact . "' />";
		$def_url .= "<input type='hidden' name='orderId' value='" . $this->orderId . "' />";
		$def_url .= "<input type='hidden' name='orderAmount' value='" . $this->orderAmount . "' />";
		$def_url .= "<input type='hidden' name='orderTime' value='" . $this->orderTime . "' />";
		$def_url .= "<input type='hidden' name='productName' value='" . $this->productName . "' />";
		$def_url .= "<input type='hidden' name='payType' value='" . $this->payType . "' />";
		$def_url .= "<input type='hidden' name='productNum' value='" . $this->productNum . "' />";
		$def_url .= "<input type='hidden' name='productId' value='" . $this->productId . "' />";
		$def_url .= "<input type='hidden' name='productDesc' value='" . $this->productDesc . "' />";
		$def_url .= "<input type='hidden' name='ext1' value='" . $this->ext1 . "' />";
		$def_url .= "<input type='hidden' name='ext2' value='" . $this->ext2 . "' />";
		$def_url .= "<input type='hidden' name='bankId' value='" . $this->bankId . "' />";
		$def_url .= "<input type='hidden' name='redoFlag' value='" . $this->redoFlag ."' />";
		$def_url .= "<input type='hidden' name='pid' value='" . $this->pid . "' />";
		$def_url .= "<input type='submit' name='submit' value='立即支付' />";
		$def_url .= "</form></div></br>";
		
		return $def_url;
	}
	
	/**
	 * 验证快钱支付的状态
	 * 如果成功返回true，否则返回false
	 */
	function payResultHandler(){
		$result = false;
		$merchantAcctId=trim($_REQUEST['merchantAcctId']);//获取人民币网关账户号
		
		$key=$this->key;//设置人民币网关密钥
		
		$version=trim($_REQUEST['version']);//获取网关版本
		
		$language=trim($_REQUEST['language']);//获取语言种类.固定选择值
		
		$signType=trim($_REQUEST['signType']);//签名类型.固定值
		
		$payType=trim($_REQUEST['payType']);//获取支付方式
		
		$bankId=trim($_REQUEST['bankId']);//获取银行代码
		
		$orderId=trim($_REQUEST['orderId']);//获取商户订单号
		
		$orderTime=trim($_REQUEST['orderTime']);//获取订单提交时间
		
		$orderAmount=trim($_REQUEST['orderAmount']);//获取原始订单金额
		
		$dealId=trim($_REQUEST['dealId']);//获取快钱交易号
		
		$bankDealId=trim($_REQUEST['bankDealId']);//获取银行交易号
		
		$dealTime=trim($_REQUEST['dealTime']);//获取在快钱交易时间
		
		$payAmount=trim($_REQUEST['payAmount']);//获取实际支付金额
		
		$fee=trim($_REQUEST['fee']);//获取交易手续费
		
		$ext1=trim($_REQUEST['ext1']);//获取扩展字段1
		
		$ext2=trim($_REQUEST['ext2']);//获取扩展字段2
		
		$payResult=trim($_REQUEST['payResult']);//获取处理结果
		
		$errCode=trim($_REQUEST['errCode']);//获取错误代码
		
		$signMsg=trim($_REQUEST['signMsg']);//获取加密签名串
		
		//生成加密串。必须保持如下顺序。
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"merchantAcctId",$merchantAcctId);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"version",$version);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"language",$language);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"signType",$signType);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"payType",$payType);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"bankId",$bankId);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"orderId",$orderId);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"orderTime",$orderTime);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"orderAmount",$orderAmount);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"dealId",$dealId);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"bankDealId",$bankDealId);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"dealTime",$dealTime);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"payAmount",$payAmount);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"fee",$fee);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"ext1",$ext1);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"ext2",$ext2);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"payResult",$payResult);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"errCode",$errCode);
		$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"key",$key);
		$merchantSignMsg= md5($merchantSignMsgVal);
		
		//商家进行数据处理，
		///首先进行签名字符串验证
		if(strtoupper($signMsg)==strtoupper($merchantSignMsg)){
			if($payResult==10&&$merchantAcctId==$this->merchantAcctId){//验证支付状态和商户号是否正确
				
				$result = true;
			}
		}
		return $result;
	}
	
	//功能函数。将变量值不为空的参数组成字符串
	Function appendParam($returnStr,$paramId,$paramValue){

		if($returnStr!=""){
			
				if($paramValue!=""){
					
					$returnStr.="&".$paramId."=".$paramValue;
				}
			
		}else{
		
			If($paramValue!=""){
				$returnStr=$paramId."=".$paramValue;
			}
		}
		
		return $returnStr;
	}
	//功能函数。将变量值不为空的参数组成字符串。结束
}




?>
