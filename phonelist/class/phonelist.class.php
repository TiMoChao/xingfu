<?php
/**
 * 手机管理功能类文件
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	phonelist
 */

class phonelist extends ArthurXF{
	public $thisModel = 'phonelist';

	//xml方法
	/**
	 * 生成XML信息类型列表
	 * @author	肖飞
	 * @param	string $strXML    请求xml字符串
	 * @return  void
	 */
	function makeInfoTypeListXML($strXML){
		$objXML = new xml();
		$objXML->loadXML( $strXML );
		$string = "//Values/*";
		$objXML->objXpath = new DOMXPath($objXML->objXML);
		$arrData = $objXML->gNodeName($string);
		$objXML = new xml();
		if($arr = $this->getTypeList($arrData['phonelist_type_parentid'])){
			$root = $objXML->cElement("PHPToFlash");
			$arrReturn = array(array("Result"=>"1"));
			$objXML->cElementChild("Return",$root,$arrReturn);
			foreach ($arr as $key=>$val){
				$arrReturn = array($val);
				$objXML->cElementChild("TypeList",$root,$arrReturn);
			}
			echo $objXML->saveXML();
		}else{
			$root = $objXML->cElement("ExceptionDataSet");
			$arrReturn = array(array("PKID"=>"20","Info"=>"系统无法找到信息列表","Remark"=>"在请求信息列表时找不到列表"));
			$objXML->cElementChild("Exception",$root,$arrReturn);
			echo $objXML->saveXML();
		}
	}

	function saveInfo($arrData,$intModify=0,$isAlert=true,$isLastID=false){
		global $arrGWeb;
		$arr = array();
		$arr = check::SqlInjection($this->saveTableFieldG($arrData));

		if($intModify == 0){
			if($this->insertInfo($arr)){
				if($isAlert)
					check::Alert("恭喜你，订阅成功！系统将返回到首页",$arrGWeb['WEB_ROOT_pre'].'/index.php');
				else 
					return true;
			}else{
				if($isAlert)
					check::Alert("订阅失败",-1);
				else 
					return false;
			}
		}else{
			if($this->updateInfo($arr)){
				if($isAlert)
					check::Alert("退订成功！系统将返回到首页",$arrGWeb['WEB_ROOT_pre'].'/index.php');
				else 
					return true;
			}else{
				if($isAlert)
					check::Alert("退订失败",$arrGWeb['WEB_ROOT_pre'].'/index.php');
				else 
					return false;
			}
		}

	}
}
?>