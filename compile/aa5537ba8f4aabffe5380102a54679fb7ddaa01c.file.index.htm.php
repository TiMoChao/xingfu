<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:14:20
         compiled from "/Volumes/data/wochacha_program/xingfu/xingfu_pic/config/../../xingfu_pic/admin/templats/index.htm" */ ?>
<?php /*%%SmartyHeaderCode:102674990056629cdca81068-13720040%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa5537ba8f4aabffe5380102a54679fb7ddaa01c' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/xingfu_pic/config/../../xingfu_pic/admin/templats/index.htm',
      1 => 1449168501,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '102674990056629cdca81068-13720040',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_bedeck')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.bedeck.php';
if (!is_callable('smarty_modifier_imgurl')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.imgurl.php';
?><div class="ccc2">
	<ul>
		<li>
		<form action="?" method="get">
			<span class="right"><input type="button" onClick="location.href='addinfo.php?page=<?php echo $_GET['page'];?>
'" value="新增<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['module_name'];?>
" class="gray mini"></span>
			<input type=hidden name="action" value='search'>
			标题：<input type=text size=15 name='title' value='<?php echo $_GET['title'];?>
'> 
		<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['module_name'];?>
类别：
		<select size=1 name='type_id'>
		<option value="0">所有类别</option>
		<?php  $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrTypeB')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['type']->key => $_smarty_tpl->tpl_vars['type']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['type']->key;
?>
		<?php if (is_array($_smarty_tpl->tpl_vars['type']->value)&&array_key_exists('type_title',$_smarty_tpl->tpl_vars['type']->value)){?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['type']->value['type_id'];?>
" <?php if (!empty($_smarty_tpl->tpl_vars['type']->value['type_link'])){?>disabled='disabled'<?php }?> <?php if ($_smarty_tpl->tpl_vars['type']->value['type_id']==$_GET['type_id']){?>selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['type']->value['type_title'];?>
</option>
		<?php }else{ ?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->getVariable('arrData')->value['type_id']){?>selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
</option>    	
		<?php }?>
		<?php }} ?>
    	</select>
		审核：<select name='pass' size=1>
		<option value=''>全部</option>
		<option value="1" <?php if ($_GET['pass']=='1'){?>selected=selected<?php }?>>已审核</option>
		<option value="0" <?php if ($_GET['pass']=='0'){?>selected=selected<?php }?>>未审核</option>
		</select> 
		排序：<select name='sort' size=1>
		<option value=''>按时间</option>
		<!--<option value="1" <?php if ($_GET['sort']=='1'){?>selected=selected<?php }?>>按固顶</option>-->
		<!--<option value="2" <?php if ($_GET['sort']=='2'){?>selected=selected<?php }?>>按推荐</option>-->
		<option value="3" <?php if ($_GET['sort']=='3'){?>selected=selected<?php }?>>按ID倒序</option>
		<option value="4" <?php if ($_GET['sort']=='4'){?>selected=selected<?php }?>>按ID正序</option>
		</select> 
		<input type=submit value='查 询' class='gray mini'>
		 /id号可精确查询
	 </form>
	 </li>
	</ul>
</div>
<div id="biweb">
<table border="0" cellspacing="0" align="center" class="biweb">
<form action='?<?php echo $_SERVER['QUERY_STRING'];?>
&action=' method="post" name="delform">
	<tr class="firstr">
		<th width='6%'>ID</th>
		<th><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['module_name'];?>
名称</th>
		<th width='20%'>类别</th>
		<th width='8%'>图片</th>
		<th width='6%'>点击</th>
		<th width='6%'>属性</th>
		<th width='6%'>审核</th>
		<th width='16%'>发布时间</th>
		<th width='4%' align=center><input type='checkbox' name='chkselectAll' onclick="doCheckAll(this)"></th>
	</tr>
	<?php  $_smarty_tpl->tpl_vars['arrData'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfo')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrData']->key => $_smarty_tpl->tpl_vars['arrData']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['arrData']->key;
?>
	<tr align=center>
		<td>&nbsp;<a href='modifyinfo.php?<?php echo $_SERVER['QUERY_STRING'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['arrData']->value['id'];?>
'><?php echo $_smarty_tpl->tpl_vars['arrData']->value['id'];?>
</a></td>
		<td align="left">&nbsp;
		<a href='modifyinfo.php?<?php echo $_SERVER['QUERY_STRING'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['arrData']->value['id'];?>
'><?php echo smarty_modifier_bedeck($_smarty_tpl->tpl_vars['arrData']->value['title'],$_smarty_tpl->tpl_vars['arrData']->value['bedeck']);?>
</a>
		</td>
		<td>&nbsp;
		<?php echo $_smarty_tpl->tpl_vars['arrData']->value['type_title'];?>

		</td>
		<td>&nbsp;
			<?php if ($_smarty_tpl->tpl_vars['arrData']->value['thumbnail']!=''){?><a href="<?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value);?>
b/<?php echo $_smarty_tpl->tpl_vars['arrData']->value['thumbnail'];?>
" target="_blank"><font color=red>有图</font></a><?php }?>
			<?php if ($_smarty_tpl->tpl_vars['arrData']->value['thumbnail']==''){?>无图<?php }?>
		</td>
		<td>&nbsp;<?php echo $_smarty_tpl->tpl_vars['arrData']->value['clicktimes'];?>
</td>
		<td>&nbsp;
			<?php if ($_smarty_tpl->tpl_vars['arrData']->value['topflag']!=0){?><font color=red>&nbsp;固<?php echo $_smarty_tpl->tpl_vars['arrData']->value['topflag'];?>
&nbsp;</font><?php }?>
			<?php if ($_smarty_tpl->tpl_vars['arrData']->value['recommendflag']!=0){?><font color=red>&nbsp;荐<?php echo $_smarty_tpl->tpl_vars['arrData']->value['recommendflag'];?>
&nbsp;</font><?php }?>
		</td>
		<td>&nbsp;
			<?php if ($_smarty_tpl->tpl_vars['arrData']->value['pass']==1){?>√<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['arrData']->value['pass']!=1){?><font color=red>&nbsp;×&nbsp;</font><?php }?>
			</td>
		<td align=center>&nbsp;<?php echo $_smarty_tpl->tpl_vars['arrData']->value['submit_date'];?>
</td>
		<td align=center>&nbsp;<input type=checkbox name=select[] value="<?php echo $_smarty_tpl->tpl_vars['arrData']->value['id'];?>
"></td>
	</tr>
	<?php }} ?>
	</tr>
	<tr>
		<td colspan='9'>
		<span  class="actionform">
		<form name='actionform' method="post">
		操作：<select name="selection">
		<option value='del'>删除</option>
		<option value='delpic'>删除图片</option>
		<!--<option value='moveup'>提前</option>-->
		<option value='check'>通过审核</option>
		<option value='uncheck'>取消通过</option>
		<!--<option value='settop'>固顶</option>-->
		<!--<option value='unsettop'>解固</option>-->
		<!--<option value='setrecommend'>设为推荐</option>-->
		<!--<option value='unsetrecommend'>解除推荐</option>-->
		</select> 
		<input type="button" class="gray mini" value='执行' onclick=javascript:index=document.getElementsByName('selection')[0].selectedIndex;checkAction(document.getElementsByName('selection')[0].options[index].value);>
		</form>
		</span>
		<?php echo $_smarty_tpl->getVariable('strPage')->value;?>

		</td>
	</tr>
</form>
</table>
</div>