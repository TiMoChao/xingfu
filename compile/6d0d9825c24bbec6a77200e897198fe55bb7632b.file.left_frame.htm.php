<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:04:54
         compiled from "/Volumes/data/wochacha_program/xingfu/admin/config/../../admin/templats/left_frame.htm" */ ?>
<?php /*%%SmartyHeaderCode:59312952556629aa625d947-94351978%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d0d9825c24bbec6a77200e897198fe55bb7632b' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/admin/config/../../admin/templats/left_frame.htm',
      1 => 1449168507,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '59312952556629aa625d947-94351978',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<link rel="stylesheet" type="text/css" href="css/menu.css" />
<script type="text/javascript" src="js/ShowLeft.js"></script>
</head>
<body>
<div id="my_menu" class="biweb">
<span class="top">
<a href="../" target="_blank">网站首页</a> <a href="main_frame.php" target="main">后台首页</a>
</span>
<dl id="webmanage">
<?php if ($_smarty_tpl->getVariable('arrPop')->value['webmanage']==1){?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrLeft')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
	<?php if ($_smarty_tpl->getVariable('arrPop')->value[$_smarty_tpl->getVariable('key')->value]==1){?>
	<div>
	<span><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</span>
	<?php  $_smarty_tpl->tpl_vars['arrData'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrLeft')->value[$_smarty_tpl->getVariable('key')->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrData']->key => $_smarty_tpl->tpl_vars['arrData']->value){
?>
	<a href="<?php echo $_smarty_tpl->tpl_vars['arrData']->value['href'];?>
" target="main"><?php echo $_smarty_tpl->tpl_vars['arrData']->value['name'];?>
</a>
	<?php }} ?>	
	</div>
	<?php }?>
<?php }} ?>
<?php }?>
</dl>
<dl id="siteset" style="display:none" >
<?php if ($_smarty_tpl->getVariable('arrPop')->value['siteset']==1){?>
	<div>
	<span>系统设置</span>
	<a href="siteset/logo.php" target="main" >Logo设置</a>
	<a href="siteset/siteset.php" target="main" >信息设置</a>
	<a href="siteset/navigate.php" target="main" >导航设置</a>
	<a href="siteset/phpinfo.php" target="main" >系统环境</a>
	<a href="siteset/systemset.php" target="main" >系统设定</a>
	<a href="siteset/skin_set.php" target="main" >模板设定</a>
	<a href="siteset/template_index.php" target="main" >模板编辑</a>
	<a href="siteset/module_set.php" target="main" >栏目装卸</a>
	<a href="siteset/cache_set.php" target="main" >缓存设置</a>
	<a href="siteset/water_set.php" target="main" >水印设置</a>
	<a href="siteset/big5_set.php" target="main" >繁简设置</a>
  </div>
  <div>
	<span>支付设置</span>
	<a href="siteset/alipay.php" target="main" >支付宝设置</a>
	<a href="siteset/99bill.php" target="main" >快钱设置</a>
  </div>
<?php }?>
</dl>
<dl id="fetch" style="display:none" >
<?php if ($_smarty_tpl->getVariable('arrPop')->value['fetch']==1){?>
	<div>
	<span>数据采集</span>
	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrFetch')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
		<?php  $_smarty_tpl->tpl_vars['arrData'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrFetch')->value[$_smarty_tpl->getVariable('key')->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrData']->key => $_smarty_tpl->tpl_vars['arrData']->value){
?>
	<a href="<?php echo $_smarty_tpl->tpl_vars['arrData']->value['href'];?>
" target="main" ><?php echo $_smarty_tpl->tpl_vars['arrData']->value['name'];?>
</a>
		<?php }} ?>
	<?php }} ?>
  </div>
<?php }?>
</dl>
<dl id="seo" style="display:none" >
<?php if ($_smarty_tpl->getVariable('arrPop')->value['seo']==1){?>
	<div>
	<span>网站优化</span>
	<a href="seo/meta_set.php" target="main" >网页SEO优化</a>
	<a href="seo/link_set.php" target="main" >链接优化</a>
	<a href="seo/web_update.php" target="main" >更新静态页面</a>
	<a href="seo/google_sitemap.php" target="main" >Google Sitemaps</a>
  </div>
<?php }?>
</dl>
<dl id="backup" style="display:none" >
<?php if ($_smarty_tpl->getVariable('arrPop')->value['backup']==1){?>
	<div>
	<span>数据管理</span>
	<a href="backup/sql_backup.php" target="main" >数据备份</a>
	<a href="backup/sql_restore.php" target="main" >数据还原</a>
	<a href="backup/sql_optimize.php" target="main" >数据优化</a>
  </div>
<?php }?>
</dl>
<dl id="tools" style="display:none" >
<?php if ($_smarty_tpl->getVariable('arrPop')->value['tools']==1){?>
	<div>
	<span>网站工具</span>
	<a href="tools/keywordsad/" target="main" >关键字广告</a>
	<a href="tools/illegal/" target="main" >非法信息过滤</a>
	<a href="tools/fetch/" target="main" >数据采集器</a>
  </div>
<?php }?>
</dl>
<dl id="email" style="display:none" >
<?php if ($_smarty_tpl->getVariable('arrPop')->value['email']==1){?>
	<div>
	<span>邮件营销</span>
	<a href="email/email_user.php" target="main" >会员邮件提取</a>
	<a href="email/email_list.php" target="main" >订阅邮件提取</a>
	<a href="email/smtp/index.php" target="main" >SMTP邮局设定</a>
	<a href="email/email_sender.php" target="main" >邮件设定发送</a>
	</div>
	<div>
	<span>短信营销</span>
	<a href="sms/sms_index.php" target="main" >短信通道设定</a>
	<a href="sms/sms_user.php" target="main" >会员手机提取</a>
	<a href="sms/sms_list.php" target="main" >订阅手机提取</a>
	<a href="sms/sms_sender.php" target="main" >营销短信发送</a>
  </div>
<?php }?>
</dl>
</div>
</body>
</html>