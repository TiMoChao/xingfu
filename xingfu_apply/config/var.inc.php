<?php
/**
 * 网站留言功能公有全局变量配置文件（可被block访问的网站配置全局变量）
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	xingfu_apply
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
*/
$arrGPdoDB['db_table'] = 'xingfu_apply';
$arrGPdoDB['db_table1'] = 'xingfu_apply_type';
$arrGPdoDB['db_table_field']=array('id'=>'','type_id'=>1,'user_id'=>1,'structon_tb'=>array('name','age','sex','ethnic','address','iphone','class_type','class','weichat'),'submit_date'=>date('Y-m-d H:i:s'),'state'=>1,'user_ip'=>'','pass'=>1);   //字段数组，将要显示的字段名称写入该数组

//网站公用参数（栏目数据）
$arrGWeb['module_name'] = '网站留言';
$arrGWeb['module_id'] = 'xingfu_apply';
$arrGWeb['cache_xingfu_apply_url'] = $arrGWeb['cache_url'].'/'.$arrGWeb['module_id'];

//上传图片参数
$arrGPic = array();
$arrGPic['FileMaxSize'] = 80 * 1024;
$arrGPic['FileCallPath'] = "/uploadfile/".$arrGWeb['module_id']."/";
$arrGPic['FileSavePath'] = __WEB_ROOT."/uploadfile/".$arrGWeb['module_id']."/";
$arrGPic['FileListPicSize'] = 0;

//静态页面缓存参数
$arrGCache['cache_root'] = $arrGCache['cache_root'].'/'.$arrGWeb['module_id'];

//网站留言处理参数
$arrGState = array();
$arrGState[1] = '未处理';
$arrGState[2] = '处理中';
$arrGState[3] = '无效客户反馈';
$arrGState[4] = '处理完成';
?>