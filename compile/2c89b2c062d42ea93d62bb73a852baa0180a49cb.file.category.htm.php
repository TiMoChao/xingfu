<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:22:43
         compiled from "/Volumes/data/wochacha_program/xingfu/xingfu_pic/config/../../xingfu_pic/admin/templats/category.htm" */ ?>
<?php /*%%SmartyHeaderCode:33052380256629ed3314e87-87916115%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c89b2c062d42ea93d62bb73a852baa0180a49cb' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/xingfu_pic/config/../../xingfu_pic/admin/templats/category.htm',
      1 => 1449168501,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '33052380256629ed3314e87-87916115',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" language="javascript">
function menuClick(menuid)
{
	var tr = document.getElementsByTagName("tr");
	for (var i = 0; i < tr.length; i++){
		var rmenu = document.getElementsByTagName("tr")[i];
		if(tr[i].id == menuid) rmenu.style.display = (rmenu.style.display == '') ? 'none' : '';
		
	}
	return false;
}
</script>
<div class="ccc2">
	<ul>
		<li>
			<!--<span class="right"><input type="button" onClick="location.href='category.php?action=add'" value="新增<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['module_name'];?>
分类" class="gray mini"></span>-->
	 </li>
	</ul>
</div>
<div id="biweb">
<table border="0" cellspacing="0" align="center" class="biweb">
<form action='?id=<?php echo $_smarty_tpl->getVariable('id')->value;?>
&action=' method="post" name="delform">
	<tr class="firstr">
		<th width='6%'>ID</th>
		<th><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['module_name'];?>
分类名称</th>
		<th width='12%'>用户阅读星级</th>
		<th width='12%'>用户发布星级</th>
		<th width='8%'>分类排序</th>
		<th width='6%'>状态</th>
		<!--<th width='12%'>操作</th>-->
	</tr>
	<?php  $_smarty_tpl->tpl_vars['arrData'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfo')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrData']->key => $_smarty_tpl->tpl_vars['arrData']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['arrData']->key;
?>
	<tr align=center <?php if ($_smarty_tpl->tpl_vars['arrData']->value['type_parentid']==0){?><?php $_smarty_tpl->tpl_vars["menu"] = new Smarty_variable(($_smarty_tpl->tpl_vars['key']->value), null, null);?> onClick="menuClick('<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
');" style="font-weight: bold ;background:#dff6ff;"<?php }else{ ?> id="<?php echo $_smarty_tpl->getVariable('menu')->value;?>
"<?php }?>>
		<td><?php echo $_smarty_tpl->tpl_vars['arrData']->value['type_id'];?>
</td>
		<td align='left'><?php echo $_smarty_tpl->tpl_vars['arrData']->value['type_title'];?>
</td>
		<td><?php if ($_smarty_tpl->tpl_vars['arrData']->value['type_read_grade']==0){?><i>无</i><?php }?><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['arrData']->value['type_read_grade']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>★<?php endfor; endif; ?></td>
		<td><?php if ($_smarty_tpl->tpl_vars['arrData']->value['type_write_grade']==0){?><i>无</i><?php }?><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['arrData']->value['type_write_grade']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>★<?php endfor; endif; ?></td>
		<td><?php echo $_smarty_tpl->tpl_vars['arrData']->value['type_sort'];?>
</td>
		<td><?php if ($_smarty_tpl->tpl_vars['arrData']->value['type_pass']==1){?>公布<?php }else{ ?>隐藏<?php }?></td>
		<!--<td><a href='category.php?action=edit&id=<?php echo $_smarty_tpl->tpl_vars['arrData']->value['type_id'];?>
'>编辑</a> | <a href='category.php?action=del&id=<?php echo $_smarty_tpl->tpl_vars['arrData']->value['type_id'];?>
' onclick="return confirm('确认删除');">删除</a></td> 		-->
	</tr>
	<?php }} ?>
	<tr>
		<td colspan='7'>
		<?php echo $_smarty_tpl->getVariable('strPage')->value;?>

		</td>
	</tr>
</form>
</table>
</div>