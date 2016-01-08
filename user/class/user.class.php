<?php
/**
 * 会员功能类文件
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	user
 */
class user extends ArthurXF{
	/**
	 * 取得会员详细信息
	 * @author	肖飞
	 * @param	int $intUserID    会员id
	 * @return  array
	 */
	public function getUser($intUserID,$field = '*',$pass=null,$isMcenter=true){
		if(!empty($intUserID)) $strWhere = ' WHERE user_id ='.$intUserID;
		if(!empty($pass)) $strWhere .=" and pass='$pass'";
		if($isMcenter){
			$arrData = check::getAPI('mcenter','getUserWhere',"$strWhere^$field");
			if(empty($arrData)) check::AlertExit("与用户中心通讯失败，请稍后再试!",-1);
			$tmp=$this->getInfoWhere($strWhere,$field);
			if(empty($tmp)){
				//Mcenter有信息，但本系统未注册，则自动注册。
				$arrTemp = array();
				$arrTemp['user_id'] = $intUserID;
				$arrTemp['eamil'] = $arrData['email'];
				$arrTemp['pass'] = $arrData['pass'];
				$intID = $this->saveInfo($arrTemp,0,false,false);
				$tmp =$this->getInfoWhere($strWhere,$field);
			}
			$_SESSION['pass']=$tmp['pass'];
			$arrData = array_merge($arrData,$tmp);
		}else $arrData = $this->getInfoWhere($strWhere,$field);
		return $arrData;
	}

	/**
	 * 取得会员详细信息(用where条件)
	 * @author	肖飞
	 * @param	string $strWhere    where条件
	 * @param	bool		$isMcF    是否Mcenter先执行
	 * @param	bool		$isMcenter    是否Mcenter要执行
	 * @return  array
	 */
	public function getUserWhere($strWhere=null,$field = '*',$isMcF=true,$isMcenter=true){
		if($isMcF){
			if($isMcenter){
				$arrData = check::getAPI('mcenter','getInfoWhere',"$strWhere^$field");
				if(empty($arrData)) check::AlertExit("与用户中心通讯失败，请稍后再试!",-1);
				$arrData = array_merge($arrData,$this->getInfoWhere($strWhere,$field));
			}else $arrData = $this->getInfoWhere($strWhere,$field);
		}else{
			$arrData = $this->getInfoWhere($strWhere,$field);
			if($isMcenter){
				$arrData = check::getAPI('mcenter','getInfoWhere',"$strWhere^$field");
				if(empty($arrData)) check::AlertExit("与用户中心通讯失败，请稍后再试!",-1);
				$arrData = array_merge($arrData,$this->getInfoWhere($strWhere,$field));
			}
		}
		return $arrData;
	}

	/**
	 * 取得会员列表
	 * @author	肖飞
	 * @param	string	$strNewsTypeTitle    新闻类型标题
	 * @param	bool		$isMcF    是否Mcenter先执行
	 * @param	bool		$isMcenter    是否Mcenter要执行
	 * @return  void
	 */
	public function getUserList($strWhere,$strOrder,$offset,$limit,$field,$blCount = true,$isMcF=false,$isMcenter=true){
		$strOrder = empty($strOrder)? ' ORDER by pass,user_id desc' : $strOrder ;
		if($isMcF){
			$strWhere = empty($strWhere)?'':$strWhere;
			$arrData = check::getAPI('mcenter','getUserList',"$strWhere^$strOrder^0^0^*^^0");
			if(empty($arrData)) return null;
			if($isMcenter){
				$arrTemp = array();
				foreach($arrData as $k => $v){
					if(empty($v['user_id'])) continue;
					$arrTemp[] = $v['user_id'];
				}
				$strUserID = implode(',',$arrTemp);
				$strWhere = " Where user_id in($strUserID)";
				$arrDataUser = $this->getInfoList($strWhere,$strOrder,$offset,$limit);
				foreach($arrDataUser as $k => $v){
					if($k === 'COUNT_ROWS') continue;
					foreach($arrData as $k1 => $v1){
						if($v1['user_id'] == $v['user_id']) {
							$arrDataUser[$k] = array_merge($arrData[$k1],$arrDataUser[$k]);
							break;
						}
					}
				}
			}
		}else{			
			$arrDataUser = $this->getInfoList($strWhere,$strOrder,$offset,$limit,$field,null,$blCount);
			if(empty($arrDataUser)) return null;
			if($isMcenter){
				$arrTemp = array();
				foreach($arrDataUser as $k => $v){
					if($k === 'COUNT_ROWS') continue;
					$arrTemp[] = $v['user_id'];
				}
				if(count($arrTemp)>0){//如果满足条件的记录不存在，就不去mcenter中取数据。
					$strUserID = implode(',',$arrTemp);
					if(empty($strWhere)) $strWhere = " Where user_id in($strUserID)";
					else $strWhere .= " and user_id in($strUserID)";
					$arrData = check::getAPI('mcenter','getUserList',"$strWhere^$strOrder^0^0^*^^0");
					if(empty($arrData)) check::AlertExit("与用户中心通讯失败，请稍后再试!",-1);
					foreach($arrData as $k => $v){
						foreach($arrDataUser as $k1 => $v1){
							if($v1['user_id'] == $v['user_id']) {
								$arrDataUser[$k1] = array_merge($arrData[$k],$arrDataUser[$k1]);
								break;
							}
						}
					}
				}
			}
		}
		return $arrDataUser;
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
		if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
		if($result = $this->db->exec($strSQL)){
			if($this->arrGPdoDB['PDO_LOGS']) check::getAPI('logs','addLog',"1^$table^$where^$strSQL");
			return $result;
		}		
		if ($this->db->exec($strSQL)) {
			return true;
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
		unset($arrData['id']);
		return $this->updateDataG($this->tablename1,$arrData,$strWhere);
	}
	
	/**
	 * 会员登陆
	 * @author	肖飞
	 * @param	array $arrUser    会员信息数组
	 * @return  void
	 */
	public function userLogin($arrData,$isEncryption=0,$jamStr,$isAlert=true){
		$arrData['User'] = trim($arrData['User']);
		$arrData['Pass'] = trim($arrData['Pass']);
		if($isEncryption){
			$strPassTemp = check::strEncryption($arrData['Pass'],$jamStr);
		}
		if(($_SESSION['user_name']==$arrData['User']||$_SESSION['email']==$arrData['User']||$_SESSION['mobile']==$arrData['User'])&&$_SESSION['password']==$strPassTemp&&isset($_SESSION['user_group'])){
			return true;
		}
		$strData = check::getAPIArray($arrData);
		if(!check::getAPI('mcenter','userLogin',"$strData^$isEncryption^$jamStr")){
			if($isAlert) check::AlertExit("用户名或密码错误!",-1);
			return 0;
		}
		if(empty($_SESSION['user_id'])){
			if($isAlert) check::AlertExit("用户名或密码错误!",-1);
			else return 0;
		}
		
		$arr = $this->getInfoWhere("WHERE user_id = ".$_SESSION['user_id']);
		if(!empty($arr)){
			unset($arr['id']);
			$_SESSION = array_merge($_SESSION,$arr);
			$arrUpdate = array();
			$arrUpdate['lastlog'] = date('Y-m-d H:i:s');
			$arrUpdate['user_id'] = $arr['user_id'];
			$this->updateUser($arrUpdate);
			return 1;
		}else{
			//Mcenter有信息，但本系统未注册，则自动注册。
			$arrTemp = array();
			$arrTemp = $_SESSION;
			$intID = $this->saveInfo($arrTemp,0,false,false);
			if($intID){
				$this->userLogin($arrData,$isEncryption,$jamStr,$isAlert);
				return 1;
			}else{
				if($isAlert) check::AlertExit("会员信息不存在",-1);
				else return 0;
			}
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
	function saveInfo($arrData,$isModify=false,$isAlert=true,$isMcenter=false){	
		if($isMcenter){
			$strData = check::getAPIArray($arrData);
			if(!$intUserID = check::getAPI('mcenter','saveInfo',"$strData^$isModify^false")){
				if($isAlert) check::AlertExit("与用户中心通讯失败，请稍后再试!",-1);
				return 0;
			}
		}
		$arr = array();
		$arr = check::SqlInjection($this->saveTableFieldG($arrData,$isModify));
		if($isModify == 0){
			if(!empty($intUserID)) $arr['user_id'] = $intUserID;
			if($this->insertUser($arr)){
				if(!empty($intUserID)) return $intUserID;
				else return $this->lastInsertIdG();
			}else{
				if($blAlert) check::Alert("新增失败");
				return false;
			}
		}else{
			if($this->updateUser($arr) !== false){
				if($isAlert) check::Alert("修改成功！");
				else return true;
			}else{
				if($blAlert) check::Alert("修改失败");
				return false;
			}
		}
	}

	/**
	 * 验证用户信息是否存在
	 * @author	王巍
	 * @param	array $arrData    会员信息数组
	 * @return  array
	 */
	 public function checkUserPropertyExist($strWhere,$field = 'user_id,user_name'){
	 	$result = check::getAPI('mcenter','getUserWhere',"$strWhere^$field");
	 	return $result;
	 }

	 	 
	
	/**
	 * 删除会员详细信息
	 * @author	肖飞
	 * @param	int $intUserID    会员id
	 * @return  void
	 */
	public function deleteUser($intUserID){
		$strSQL = "DELETE FROM ".$this->arrGPdoDB['db_tablepre'].$this->tablename1." WHERE `user_id` = $intUserID";
		return $this->db->exec($strSQL);
	}

	
	/**
	 * 复原函数
	 * 会员中，多项选择时，保存值用','分隔，取出数据还原数组
	 * @author	嬴益虎
	 * @param	array  $arrData			需要处理的数据
	 * @param	array  $arrType			类型数组信息
	 * @return  array
	 */
	function getRecoverData($arrData, $arrType){
		$arrTemp = array();

		if(!empty($arrData) || $arrData == '0'){
			$arrTemp = explode(',',$arrData);
			$strTemp = '';

			foreach($arrTemp as $k=>$v){
				$strTemp .= $strTemp == '' ? $arrType[$v] : ','.$arrType[$v];
			}
		}
		return $strTemp;
	}
		
}
?>
