<?php
/**
 * 用户中心功能公有全局变量配置文件（可被block访问的网站配置全局变量）
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	mcenter
 */

//
//数据库参数
//本栏目使用其他的数据库就取消此段注释
$arrGPdoDB = array();
$arrGPdoDB['db_driver'] = 'mysql';
if(empty($arrGWeb['m_db_host'])) $arrGPdoDB['db_host'] = 'localhost';
else $arrGPdoDB['db_host'] = $arrGWeb['m_db_host'];
if(empty($arrGWeb['m_db_port'])) $arrGPdoDB['db_port'] = '3306';
else $arrGPdoDB['db_port'] = $arrGWeb['m_db_port'];
if(empty($arrGWeb['m_db_name'])) $arrGPdoDB['db_name'] = '';
else $arrGPdoDB['db_name'] = $arrGWeb['m_db_name'];
$arrGPdoDB['db_char'] = "utf8";
$arrGPdoDB['dsn'] = $arrGPdoDB['db_driver'].':host='.$arrGPdoDB['db_host'].';port='.$arrGPdoDB['db_port'].';dbname='.$arrGPdoDB['db_name'].';charset='.$arrGPdoDB['db_char'];
if(empty($arrGWeb['m_db_user'])) $arrGPdoDB['db_user'] = '';
else $arrGPdoDB['db_user'] = $arrGWeb['m_db_user'];
if(empty($arrGWeb['m_db_password'])) $arrGPdoDB['db_password'] = '';
else $arrGPdoDB['db_password'] = $arrGWeb['m_db_password'];
if(empty($arrGWeb['m_db_tablepre'])) $arrGPdoDB['db_tablepre'] = 'biweb_';
else $arrGPdoDB['db_tablepre'] = $arrGWeb['m_db_tablepre'];
$arrGPdoDB['PDO_ATTR_PERSISTENT'] = true;
$arrGPdoDB['PDO_DEBUG'] = 0;
$arrGPdoDB['db_table'] = 'mcenter';
$arrGPdoDB['db_table_field']=array('user_id'=>'','user_name'=>'','corp_name'=>'','contact_address'=>'','postcode'=>'','real_name'=>'','nick_name'=>'','password'=>'','paypassword'=>'','question'=>'','answer'=>'','user_money'=>0,'user_score'=>0,'sb_money'=>0,'province'=>'','city'=>'','area'=>'','sex'=>1,'birthday'=>'','email'=>'','tel'=>'','mobile'=>'','msn'=>'','qq'=>'','imghost'=>'','thumbnail'=>'','lastlog'=>date('Y-m-d H:i:s'),'logtimes'=>0,'submit_date'=>date('Y-m-d H:i:s'),'status'=>1,'recommend_user_id'=>0,'add_date'=>date('Y-m-d H:i:s'),'parentid'=>'','roue_id'=>'','host'=>'','user_ip'=>'','session_id'=>'','majia'=>0,'last_promotion_money'=>0,'promotion_money'=>0);   //字段数组，将要显示的字段名称写入该数组
$arrGPdoDB['htmlspecialchars'] = array('intro','summary','tag');

//网站公用参数（栏目数据）
$arrGWeb['module_name'] = "用户中心";
$arrGWeb['module_id'] = 'mcenter';
$arrGWeb['cache_report_url'] = $arrGWeb['cache_url'].'/'.$arrGWeb['module_id'];
$arrGWeb['db_summary_len'] = 100;	//摘要生成长度设定,不能超过255,安装后修改，需要去手动调整表字段长度
//$arrGWeb['css'] = array('style.css');	//网站调用CSS，可以支持数组和字符串
//$arrGWeb['js'] = array('common.js');

//上传图片参数
$arrGPic = array();
$arrGPic['FileMaxSize'] = 500 * 1024;
$arrGPic['FileCallPath'] = $arrGWeb['WEB_ROOT_pre']."/uploadfile/".$arrGWeb['module_id'];
$arrGPic['FileSavePath'] = __WEB_ROOT."/uploadfile/".$arrGWeb['module_id']."/";
$arrGPic['FileListPicSize'] = array('s'=>array(30,37),'m'=>array(50,61));
$arrGPic['FileSourPicSize'] = array(110,135);

//静态页面缓存参数
$arrGCache['cache_root'] = $arrGCache['cache_root'].'/'.$arrGWeb['module_id'];

?>