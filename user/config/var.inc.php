<?php
/**
 * 用户功能全局变量配置文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	user
 */

//数据库参数
/*
//本栏目使用其他的数据库就取消此段注释
$arrGPdoDB = array();
$arrGPdoDB['db_driver'] = "mysql";
$arrGPdoDB['db_host'] = 'localhost';
$arrGPdoDB['db_name'] = '';
$arrGPdoDB['db_char'] = "utf8";
$arrGPdoDB['dsn'] = $arrGPdoDB['db_driver'].":host=".$arrGPdoDB['db_host'].";dbname=".$arrGPdoDB['db_name'].";charset=".$arrGPdoDB['db_char'];
$arrGPdoDB['db_user'] = '';
$arrGPdoDB['db_password'] = '';
*/
$arrGPdoDB['db_table'] = 'user';
$arrGPdoDB['db_table_field']=array('id'=>'','user_id'=>'','nick_name'=>'','user_type'=>0,'user_group'=>0,'user_grade'=>0,'province'=>'','city'=>'','area'=>'','sex'=>0,'birthday'=>'','signature'=>'','thumbnail'=>'','integrity_grade'=>0,'education_type'=>0,'marriage_type'=>0,'total_credit'=>0,'good_evaluate'=>0,'structon_tb'=>array('user_popedom','good_at_language','serve_state','serve_ensure','identification','animal','constellation','blood','build','nationality','nation','habit','school','intro','sports','cate','pet','idol','game','film','music','books','want_palce','been_palce','amusement','digital_products','f_birthday','f_education','f_integrity','f_thumbnail','f_marriage','f_palce','height','sports_type','crephoto','friend'),'url_short'=>'','lastlog'=>date('Y-m-d H:i:s'),'submit_date'=>date('Y-m-d H:i:s'),'topflag'=>0,'recommendflag'=>0,'clicktimes'=>0,'pass'=>1,'is_check'=>0,'friend_num'=>0,'friend_fans'=>0);
//字段数组，将要显示的字段名称写入该数组

//网站公用参数（栏目数据）
$arrGWeb['module_name'] = '会员信息系统';
$arrGWeb['module_id'] = 'user';

//上传图片参数
$arrGPic['FileMaxSize'] = 500 * 1024;
$arrGPic['FileCallPath'] = $arrGWeb['WEB_ROOT_pre']."/uploadfile/".$arrGWeb['module_id'];
$arrGPic['FileSavePath'] = __WEB_ROOT."/uploadfile/".$arrGWeb['module_id']."/";
$arrGPic['FileListPicSize'] = array('s'=>array(30,37),'m'=>array(50,61));
$arrGPic['FileSourPicSize'] = array(110,135);
?>
