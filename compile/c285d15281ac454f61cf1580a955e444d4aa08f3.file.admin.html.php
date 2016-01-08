<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 17:03:52
         compiled from "/Volumes/data/wochacha_program/xingfu/xingfu_Introduction/config/../../admin/templats/admin.html" */ ?>
<?php /*%%SmartyHeaderCode:7819550505662a878237ad5-46486973%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c285d15281ac454f61cf1580a955e444d4aa08f3' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/xingfu_Introduction/config/../../admin/templats/admin.html',
      1 => 1449168507,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7819550505662a878237ad5-46486973',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="zh" xmlns="http://www.w3.org/1999/xhtml" lang="zh">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>BIWEB系统管理首页  - powered by BIWEB</title>
<link href='<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
<?php echo @__WEBADMIN_ROOT;?>
/css/biweb.css' rel='stylesheet' type='text/css'>
<script type='text/javascript' src='<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
<?php echo @__WEBADMIN_ROOT;?>
/js/jquery.min.js'></script>
<script type='text/javascript' src='<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
<?php echo @__WEBADMIN_ROOT;?>
/js/biweb.js'></script>
</head>
<body ondblclick="Submit_onDoubleclick()">
<div class='bodytitle' style="height:33px;">
    <div class='bodytitleleft'></div>
    <div class='bodytitletxt'><?php echo (($tmp = @$_smarty_tpl->getVariable('strNav')->value)===null||$tmp==='' ? ($_smarty_tpl->getVariable('arrGWeb')->value['module_name'])."管理" : $tmp);?>
</div>
    <div class='bodytitleright'></div>
    <div class='iicon'>
        <a href='javascript:window.location.reload();' class='img1'>　　 刷新</a>
        <a href='javascript:history.back();' class='img2'>　　 后退</a>
        <a href='javascript:history.go(1);' class='img3'>　　 前进</a>
    </div>
	<div class="clr"></div>
</div>
<?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('MAIN')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<div class="copyright"><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['Powered'];?>
 <?php echo $_smarty_tpl->getVariable('arrGWeb')->value['Copyright'];?>
</div>
</body>
</html>