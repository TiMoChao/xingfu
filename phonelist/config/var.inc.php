<?php
/**
 * 手机管理功能公有全局变量配置文件（可被block访问的网站配置全局变量）
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	phonelist
 */

//
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
$arrGPdoDB['db_tablepre'] = '';
$arrGPdoDB['htmlspecialchars'] = array('intro','summary','tag');
*/
$arrGPdoDB['db_table'] = 'phonelist';
$arrGPdoDB['db_table1'] = 'phonelist_type';
//$arrGPdoDB['db_table_field']=array('id'=>'','type_id'=>1,'type_roue_id'=>'','user_id'=>1,'tag'=>'','title'=>'','title_md5'=>'','mailbox_host'=>'','product_a'=>'','product_b'=>'','product_c'=>'','product_d'=>'','product_e'=>'','product_f'=>'','product_g'=>'','product_h'=>'','structon_tb'=>array(),'pass'=>1,'submit_date'=>date('Y-m-d H:i:s'));   //字段数组，将要显示的字段名称写入该数组
//$arrGPdoDB['htmlspecialchars'] = array('intro','summary','tag');

$arrGPdoDB['db_table_field']=array('id'=>'','type_id'=>1,'type_roue_id'=>'','title'=>'','structon_tb'=>array(),'submit_date'=>date('Y-m-d H:i:s'),'pass'=>1);   //字段数组，将要显示的字段名称写入该数组

//网站公用参数（栏目数据）
$arrGWeb['module_name'] = '手机管理';
$arrGWeb['module_id'] = 'phonelist';
$arrGWeb['cache_phonelist_url'] = $arrGWeb['cache_url'].'/'.$arrGWeb['module_id'];
$arrGWeb['db_summary_len'] = 100;	//摘要生成长度设定,不能超过255,安装后修改，需要去手动调整表字段长度

//上传图片参数
$arrGPic['FileMaxSize'] = 150 * 1024;
$arrGPic['FileCallPath'] = $arrGWeb['WEB_ROOT_pre']."/uploadfile/".$arrGWeb['module_id']."/";
$arrGPic['FileSavePath'] = __WEB_ROOT."/uploadfile/".$arrGWeb['module_id']."/";
$arrGPic['FileListPicSize'] = 0;
$arrGPic['FileSourPicSize'] = 600;

//静态页面缓存参数
$arrGCache['cache_root'] = $arrGCache['cache_root'].'/'.$arrGWeb['module_id'];

//分类缓存
$strFileNameB = __WEB_ROOT.'/data/'.$arrGWeb['module_id'].'/'.$arrGWeb['module_id'].'_type_b.php'; //后台用带├格式化的缓存
$strFileName  = __WEB_ROOT.'/data/'.$arrGWeb['module_id'].'/'.$arrGWeb['module_id'].'_type.php'; //排列后的原始数据缓存
eval(menload_file($strFileNameB,$arrGWeb['MEM_CACHE']));
eval(menload_file($strFileName,$arrGWeb['MEM_CACHE']));
?>