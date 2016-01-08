<?php
/**
 * 用户中心功能类文件
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	mcenter
 */

class mcenter extends ArthurXF{

	#todo 会员信息入库接口
	
	/**
	 * 取得会员详细信息
	 * @author	肖飞
	 * @param	int $intUserID    会员id
	 * @return  array
	 */
	public function getUser($intUserID,$field = '*',$pass=null){
		if(!empty($intUserID)) $strWhere = ' WHERE user_id ='.$intUserID;
		if(!empty($pass)) $strWhere .=" and pass='$pass'";
		$arrData = $this->getInfoWhere($strWhere,$field);
		return $arrData;
	}

	/**
	 * 取得会员详细信息(用where条件)
	 * @author	肖飞
	 * @param	string $strWhere    where条件
	 * @return  array
	 */
	public function getUserWhere($strWhere=null,$field = '*'){
		if(empty($field)) $field = '*';
		$arrData = $this->getInfoWhere($strWhere,$field);
		return $arrData;
	}

	/**
	 * 取得会员列表
	 * @author	肖飞
	 * @param	string $strNewsTypeTitle    新闻类型标题
	 * @return  void
	 */
	public function getUserList($strWhere,$strOrder,$offset,$limit,$field = '*',$arrData = array(),$blCount = true){
		if(empty($field)) $field = '*';
		$arrData = $this->getInfoList($strWhere,$strOrder,$offset,$limit,$field,$arrData,$blCount);
		return $arrData;
	}

	/**
	 * 插入会员详细信息
	 * @author	肖飞
	 * @param	array $arrData    会员信息数组
	 * @return  void
	 */
	public function insertUser($arrData){
		$strSQL = "REPLACE INTO $this->tablename1 (";
		$strSQL .= '`';
		$strSQL .= implode('`,`', array_keys($arrData));
		$strSQL .= '`)';
		$strSQL .= " VALUES ('";
		$strSQL .= implode("','",$arrData);
		$strSQL .= "')";
		if ($this->db->exec($strSQL)) {
			return $this->db->lastInsertId();
		} else {
			return false ;
		}
	}

	/**
	 * 修改信息
	 * @author	肖飞
	 * @param	array $arrData    信息数组
	 * @return  void
	 */
	function updateUser($arrData){
		$strWhere = " WHERE user_id = '$arrData[user_id]'";
		unset($arrData['user_id']);
		return $this->updateDataG($this->tablename1,$arrData,$strWhere);
	}

	 /**
	 * 冻结/解冻信息
	 * @author	肖飞
	 * @param	int		$intInfoID    信息id
	 * @param	string	$table			表名
	 * @return	boolen
	 */
	public function statusUser($intUserID,$status){
		$arrData['status'] = $status;
		$arrData['user_id'] = $intUserID;
		return $this->updateUser($arrData);
	}

	/**
	 * 会员登陆
	 * @author	肖飞
	 * @param	array $arrUser    会员信息数组
	 * @return  void
	 */
	public function userLogin($arrData,$isEncryption=0,$jamStr,$isAlert=ture){
		if(!check::CheckUser($arrData['User']) && !check::CheckEmailAddr($_POST['User']) && !check::CheckMobilePhone($_POST['User'])) {
			if($isAlert)	check::AlertExit("输入的用户名必须是4-21字符之间的数字、字母,或7个中文!",-1);
			else return 0;
		}
		if(!check::CheckPassword($arrData['Pass'])) {
			if($isAlert)	check::AlertExit("输入的密码必须是4-21字符之间的数字、字母!",-1);
			return 0;
		}
		$strPassTemp = $arrData['Pass'];
		if($isEncryption){
			$strPassTemp=check::strEncryption($strPassTemp,$jamStr);
		}
		$strUserName = $arrData['User'];
		if($_SESSION['user_group'] == 3){
			$strSQL = "SELECT * FROM $this->tablename1 WHERE user_name = '".$strUserName."' and status=1";
			$rs = $this->db->query($strSQL);
		}else{
			$strSQL = "SELECT * FROM $this->tablename1 WHERE user_name = '".$strUserName."' and password = '".$strPassTemp."' and status=1";
			$rs = $this->db->query($strSQL);
			if(!$arr = $rs->fetch(PDO::FETCH_ASSOC)){
				$strSQL = "SELECT * FROM $this->tablename1 WHERE email  = '".$strUserName."' and password = '".$strPassTemp."' and status=1";
				$rs = $this->db->query($strSQL);
				if(!$arr = $rs->fetch(PDO::FETCH_ASSOC)){
					$strSQL = "SELECT * FROM $this->tablename1 WHERE mobile  = '".$strUserName."' and password = '".$strPassTemp."' and status=1";
					$rs = $this->db->query($strSQL);
					$arr = $rs->fetch(PDO::FETCH_ASSOC);
				}
			}

		}
		if($arr){
			if(is_array($_SESSION)) $_SESSION = array_merge($_SESSION,$arr);
			else $_SESSION = $arr;

			$arrUpdate = array();
			$arrUpdate['user_ip'] = check::getIP();
			$arrUpdate['lastlog'] = date('Y-m-d H:i:s');
			$arrUpdate['user_id'] = $arr['user_id'];
			$arrUpdate['logtimes'] = ++$arr['logtimes'];
			$arrUpdate['session_id'] = session_id();
			$this->updateUser($arrUpdate);
			return 1;
		}else{
			if($isAlert) check::AlertExit("用户名或密码错误",-1);
			else return 0;
		}
	}

	/**
	 * 保存会员信息
	 * @author	肖飞
	 * @param	int $arrData    数组
	 * @param	int $intModify    是否修改
	 * @param	bool $isAlert    数组
	 * @param	bool $isLastID    数组
	 * @return  void
	 */
	function saveInfo($arrData,$isModify=false,$isAlert=true){
		$arr = array();
		$arr = check::SqlInjection($this->saveTableFieldG($arrData,$isModify));
		
		if($isModify == 0){
			return $this->insertUser($arr);
		}else{
			if($this->updateUser($arr) !== false){
				if($isAlert) check::Alert("修改成功！");
				return true;
			}else{
				if($blAlert) check::Alert("修改失败！");
				return false;
			}
		}
	}		

}
?>
