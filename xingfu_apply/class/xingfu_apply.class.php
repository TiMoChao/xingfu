<?php
/**
 * 网站留言功能类文件
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	xingfu_apply
 */

class xingfu_apply extends ArthurXF{
	public $tablename1 = 'xingfu_apply_type';
	public $tablename2 = 'xingfu_apply';
	public $thisModel = 'xingfu_apply';


	/**
	 * 保存信息内容
	 * @author	肖飞
	 * @param	int $arrData    信息信息数组
	 * @return  void
	 */
	function saveInfo($arrData,$intModify=0,$isAlert=true){
		$arr = array();
		$arr = check::SqlInjection($this->saveTableFieldG($arrData));

		if($intModify == 0){
			if(!empty($_SESSION['user_id'])) $arr['user_id'] = intval($_SESSION['user_id']);
			if($this->insertInfo($arr)){
				if($isAlert) check::Alert("预约成功，我们会尽快通知您，祝您生活愉快",-1);
				check::AlertExit("",$arrGWeb['WEB_ROOT_pre']."/xingfu_apply/");
			}else{
				check::Alert("发布失败",-1);;
			}
		}else{
			if($this->updateInfo($arr)){
				check::Alert("修改成功！");
			}else{
				check::Alert("修改失败");;
			}
		}

	}
}
?>