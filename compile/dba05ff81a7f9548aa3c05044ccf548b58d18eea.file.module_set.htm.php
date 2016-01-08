<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:04:59
         compiled from "/Volumes/data/wochacha_program/xingfu/admin/config/../../admin/templats/siteset/module_set.htm" */ ?>
<?php /*%%SmartyHeaderCode:197933887256629aabc87a03-20996737%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dba05ff81a7f9548aa3c05044ccf548b58d18eea' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/admin/config/../../admin/templats/siteset/module_set.htm',
      1 => 1449168508,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '197933887256629aabc87a03-20996737',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="ccc2">
	<ul>
		<li><img src="../images/warn.gif" align="absmiddle"> 本功能可允许您安装和卸载网站功能栏目，有些操作会涉及到数据，请谨慎使用；！<br />
		<font color="#ff6600">
	1.配置文件分类的安装，是将分类设定保存在配置文件中，其优势是服务器开销较小，缺点是只能一级分类，适用于一些固定分类的栏目！<br />
	2.数据库分类的安装，是使用数据库做为分类系统，其优势可以无限级分类，缺点是服务器开销较大，适用于一些增减分类较多的栏目<br />
	3.保留数据库卸载栏目，是卸载栏目时保留原有的数据库数据，再次安装时数据不变！<br />
	4.删除数据库卸载栏目，是卸载栏目时将数据库数据同时删除，再次安装时数据已空，删除数据无法还原请谨慎操作！</font>
		</li>
	</ul>
</div>
<div id="biweb">
<table border="0" cellspacing="0" cellpadding="0" class="biweb">
    <tr class="firstr">
    <td colspan="3"><?php echo (($tmp = @$_smarty_tpl->getVariable('strNav')->value)===null||$tmp==='' ? ($_smarty_tpl->getVariable('arrGWeb')->value['module_name'])."管理" : $tmp);?>
</td>
    </tr>
		<?php  $_smarty_tpl->tpl_vars['arrData'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrModuleDirs')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrData']->key => $_smarty_tpl->tpl_vars['arrData']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['arrData']->key;
?>
    <tr>
      <td width="15%"><?php echo $_smarty_tpl->tpl_vars['arrData']->value['name'];?>
(<?php echo $_smarty_tpl->tpl_vars['arrData']->value['id'];?>
)：</td>
      <td>
			<?php if ($_smarty_tpl->tpl_vars['arrData']->value['state']==2){?>系统栏目<?php }?><?php if ($_smarty_tpl->tpl_vars['arrData']->value['state']==1){?>已安装<?php }?><?php if ($_smarty_tpl->tpl_vars['arrData']->value['state']==0){?><font color=red>未安装</font><?php }?></td>
    <td><?php if ($_smarty_tpl->tpl_vars['arrData']->value['state']==1){?><a href="?id=<?php echo $_smarty_tpl->tpl_vars['arrData']->value['id'];?>
&type=1&ac=del">1.保留数据库卸载栏目</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?id=<?php echo $_smarty_tpl->tpl_vars['arrData']->value['id'];?>
&type=0&ac=del" onclick="return confirm('此操作非常危险，会丢失本栏目所有数据，确认卸载吗？');">2.删除数据库卸载栏目</a><?php }?><?php if ($_smarty_tpl->tpl_vars['arrData']->value['state']==0){?><a href="?id=<?php echo $_smarty_tpl->tpl_vars['arrData']->value['id'];?>
&ac=install"><font color=red>1.数据库分类的安装</font></a><?php }?>
			</td>
    </tr>
		<?php }} ?>
</table>
</div>
