<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:14:24
         compiled from "/Volumes/data/wochacha_program/xingfu/xingfu_pic/config/../../xingfu_pic/admin/templats/submit.htm" */ ?>
<?php /*%%SmartyHeaderCode:176515766156629ce0747d20-42441934%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c8ac02e82b627c3e94fed1aa57f8d3d73a1d1cc8' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/xingfu_pic/config/../../xingfu_pic/admin/templats/submit.htm',
      1 => 1449168501,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '176515766156629ce0747d20-42441934',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_imgurl')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.imgurl.php';
?><script language="javascript" src="../../plug-in/PopCalender/popcalendar.js"></script> 
<script Language="JavaScript">dateformat='yyyy-mm-dd'</script>
<script src="../../plug-in/kindeditor/kindeditor.js" type="text/javascript"></script>
<script src="../../plug-in/kindeditor/lang/zh_CN.js" type="text/javascript"></script>
<script> KindEditor.ready(function(K) { K.create('textarea[name="intro"]'); }); </script>
<div class="ccc2">
	<ul>
		<li>
			<span class="right"><input type="button" onClick="javascript:history.back();" value="返回列表" class="gray mini"></span>
			当前位置：<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['module_name'];?>
管理
	 </li>
	</ul>
</div>
<form name="form1" id="form1" onsubmit="return checkform()" action="?<?php echo $_SERVER['QUERY_STRING'];?>
" method="post" enctype="multipart/form-data">
<div id="biweb">
<table class="biweb" align="center" cellspacing="0">
	<tr class="firstr">
		<td colspan="3">编辑<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['module_name'];?>
：</td> 
	</tr>	
	<tr>
    <td width="15%">所属分类：</td>
    <td><select size="1" name="type_id">
		<option value="0">请选择分类</option>
		<?php  $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrTypeB')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['type']->key => $_smarty_tpl->tpl_vars['type']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['type']->key;
?>
		<?php if ($_smarty_tpl->tpl_vars['type']->value['type_pass']==1&&is_array($_smarty_tpl->tpl_vars['type']->value)&&array_key_exists('type_title',$_smarty_tpl->tpl_vars['type']->value)){?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['type']->value['type_id'];?>
|<?php echo $_smarty_tpl->tpl_vars['type']->value['type_roue_id'];?>
" <?php if (!empty($_smarty_tpl->tpl_vars['type']->value['type_link'])){?>disabled='disabled'<?php }?> <?php if ($_smarty_tpl->tpl_vars['type']->value['type_id']==$_smarty_tpl->getVariable('arrData')->value['type_id']){?>selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['type']->value['type_title'];?>
</option>
		<?php }elseif($_smarty_tpl->tpl_vars['type']->value['type_pass']==1){?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->getVariable('arrData')->value['type_id']){?>selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
</option>    	
		<?php }?>
		<?php }} ?>
    	</select></td>
    <td><font color="red">*</font><span class=gray>分类</span></td></tr>
  <tr>
  	<td>图片标题：</td>
    <td><select size=1 name=bedeck>
	<option value="0">无修饰</option>
	<option value="1" <?php if ($_smarty_tpl->getVariable('arrData')->value['bedeck']==1){?>selected<?php }?>>1[加粗]</option>
	<option value="2" <?php if ($_smarty_tpl->getVariable('arrData')->value['bedeck']==2){?>selected<?php }?>>2[标红]</option>
	<option value="3" <?php if ($_smarty_tpl->getVariable('arrData')->value['bedeck']==3){?>selected<?php }?>>3[标绿]</option>
	<option value="4" <?php if ($_smarty_tpl->getVariable('arrData')->value['bedeck']==4){?>selected<?php }?>>4[标蓝]</option>
	<option value="5" <?php if ($_smarty_tpl->getVariable('arrData')->value['bedeck']==5){?>selected<?php }?>>5[标橙]</option>
	<option value="6" <?php if ($_smarty_tpl->getVariable('arrData')->value['bedeck']==6){?>selected<?php }?>>6[红粗]</option>
	<option value="7" <?php if ($_smarty_tpl->getVariable('arrData')->value['bedeck']==7){?>selected<?php }?>>7[绿粗]</option>
	<option value="8" <?php if ($_smarty_tpl->getVariable('arrData')->value['bedeck']==8){?>selected<?php }?>>8[蓝粗]</option>
	<option value="9" <?php if ($_smarty_tpl->getVariable('arrData')->value['bedeck']==9){?>selected<?php }?>>9[橙粗]</option>
	</select>
	<input maxLength=210 size=55 id=title name=title value="<?php echo $_smarty_tpl->getVariable('arrData')->value['title'];?>
" onblur="splidword(this.value);"></td>
    <td><font color="red">*</font><span class=gray>标题，最大70个中文</span></td></tr>
  <!--<tr>-->
    <!--<td>页面标题：</td>-->
    <!--<td><input maxLength=210 size=55 name=meta_Title value="<?php echo $_smarty_tpl->getVariable('arrData')->value['meta_Title'];?>
"></td>-->
    <!--<td><span class=gray>用于搜索引擎优化，不填系统会自动生成</span></td></tr>-->
   <!--<tr>-->
    <!--<td>页面摘要：</td>-->
    <!--<td><textarea name=meta_Description rows=3 cols=50><?php echo $_smarty_tpl->getVariable('arrData')->value['meta_Description'];?>
</textarea></td>-->
    <!--<td><span class=gray>用于搜索引擎优化，不填系统会自动生成</span></td></tr>-->
  <!--<tr>-->
    <!--<td>页面关键字：</td>-->
    <!--<td><textarea name=meta_Keywords rows=3 cols=50><?php echo $_smarty_tpl->getVariable('arrData')->value['meta_Keywords'];?>
</textarea></td>-->
    <!--<td><span class=gray>用于搜索引擎优化，不填系统会自动生成</span></td>-->
  <!--</tr> -->
  <!--<tr>-->
    <!--<td>公告标签：</td>-->
    <!--<td><input maxLength=50 size=50 id=tag name=tag value="<?php echo $_smarty_tpl->getVariable('arrData')->value['tag'];?>
"></td>-->
    <!--<td><span class=gray>文章关键字，可为多个，用空格间隔，用于相关文章关联</span></td>-->
  <!--</tr> -->
  <!--<tr>-->
    <!--<td>转向链接：</td>-->
    <!--<td><input id=linkurl type="text" <?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']==''){?>disabled<?php }?> maxLength=100 size=50 value='<?php echo (($tmp = @$_smarty_tpl->getVariable('arrData')->value['linkurl'])===null||$tmp==='' ? "http://" : $tmp);?>
' name=linkurl><label><input id=uselink onclick=UseLinkUrl(); type=checkbox <?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>checked<?php }?> -->
      <!--value=Yes name=uselink></label></td>-->
    <!--<td><span class=gray>公告内容直接连接到其他网站</span></td>-->
  <!--</tr> -->
  <!--<tr>-->
    <!--<td>公告作者：</td>-->
    <!--<td><input maxLength=50 size=50 name=author value="<?php echo $_smarty_tpl->getVariable('arrData')->value['author'];?>
">【<font style="CURSOR: hand" -->
      <!--onclick="document.form1.author.value='未知'" color=green>未知</font>】【<font -->
      <!--style="CURSOR: hand" onclick="document.form1.author.value='<?php echo $_SESSION['user_name'];?>
'" -->
      <!--color=green><?php echo $_SESSION['user_name'];?>
</font>】【<font style="CURSOR: hand" -->
      <!--onclick="document.form1.author.value='<?php echo $_SESSION['real_name'];?>
'" -->
    <!--color=green><?php echo $_SESSION['real_name'];?>
</font>】</td>-->
    <!--<td><span class=gray>公告的作者</span></td>-->
  <!--</tr>-->
  <!--<tr>-->
    <!--<td>公告来源：</td>-->
    <!--<td><input maxLength=50 size=50 name=source value="<?php echo $_smarty_tpl->getVariable('arrData')->value['source'];?>
"></td>-->
    <!--<td><span class=gray>公告来源</span></td>-->
  <!--</tr>-->
  <!--<tr>-->
    <!--<td>公告摘要：</td>-->
    <!--<td><textarea name=summary rows=6 cols=50><?php echo $_smarty_tpl->getVariable('arrData')->value['summary'];?>
</textarea></td>-->
    <!--<td><span class=gray>不填系统自动生成摘要，最大<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['db_summary_len'];?>
个中文</span></td>-->
  <!--</tr>   -->
  <tr id=ArticleContent <?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>style='display:none'<?php }?>>
    <td>图片描述：</td>
    <td colspan="2"><textarea id="intro" name="intro" style="width:680px;height:280px;visibility:hidden;"><?php echo $_smarty_tpl->getVariable('arrData')->value['intro'];?>
</textarea><font color="red">*</font><span class=gray>必填项</span></td>  
  </tr> 
  <tr>
    <td>上传图片：</td>
    <td colSpan=2>
	<table id="tb1" border=0 cellspacing=0 cellpadding=3 >
	<?php  $_smarty_tpl->tpl_vars['photo'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrData')->value['photo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['photo']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['photo']['total'] = $_smarty_tpl->tpl_vars['photo']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['photo']['index']=-1;
if ($_smarty_tpl->tpl_vars['photo']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['photo']->key => $_smarty_tpl->tpl_vars['photo']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['photo']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['photo']['index']++;
?>
	<tr>
	<td>
	<span>图片<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['index']+1;?>
：</span><input id="Filedata<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['index'];?>
" size=70 type=file value="上 传" name="Filedata<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['index'];?>
" />  <input type=button onclick='return deloldFj(this,<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['index'];?>
)' value='删除'><br />
	说明<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['index']+1;?>
：<input maxLength=50 size=70 name=photo_narrate<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['index'];?>
 value="<?php echo $_smarty_tpl->tpl_vars['photo']->value['photo_narrate'];?>
" />
	<div id="tip<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['index'];?>
" class=red></div>
	<div id="preview<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['index'];?>
"><?php if (!empty($_smarty_tpl->tpl_vars['photo']->value['photo'])){?><img src="<?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value);?>
b/<?php echo $_smarty_tpl->tpl_vars['photo']->value['photo'];?>
" boder="1" width=150 onload="resizepic(this,150)"><?php }?></div>
	</td>
	</tr>
	<?php }} ?>
	<tr>
	<td>
	<span>图片<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['total']+1;?>
：</span><input id="Filedata<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['total'];?>
" size=70 type=file value="上 传"  name="Filedata<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['total'];?>
" /> <input type=button onclick='return delFj(this,<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['total']+1;?>
)' value='删除'><br/>
	说明<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['total']+1;?>
：<input maxLength=50 size=70 name=photo_narrate<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['total'];?>
 value="" />
    <div id="tip<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['total']+1;?>
" class=red></div>
    <div id="preview<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['total']+1;?>
"></div>
	</td>
	</tr>
	</table>
    <a href="#" onclick="return addFj()">添加一张图片</a>&nbsp;&nbsp;(只能上传后缀为 <font color=red>.jpg .gif .png</font> 格式的图片)
	<input type="hidden" name="fjCnt" value="<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['photo']['total']+1;?>
" />
	</td>
  </tr> 
  <!--<tr>-->
    <!--<td>公告视频：</td>-->
    <!--<td colSpan=2>-->
	<!--<table id="tb2" border=0 cellspacing=0 cellpadding=3>-->
	<!--<?php  $_smarty_tpl->tpl_vars['video'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrData')->value['video']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['video']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['video']['total'] = $_smarty_tpl->tpl_vars['video']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['video']['index']=-1;
if ($_smarty_tpl->tpl_vars['video']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['video']->key => $_smarty_tpl->tpl_vars['video']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['video']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['video']['index']++;
?>-->
	<!--<tr>-->
	<!--<td>-->
	<!--<span>视频<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index']+1;?>
：</span><input id="vFiledata<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
" size=70 type=file value="上 传" name="vFiledata<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
" />  <input type=button onclick='return deloldFj1(this,<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
)' value='删除'><br />-->
	<!--外链<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index']+1;?>
：</span><input id="video_link<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
" size=70 type=text value="<?php echo $_smarty_tpl->tpl_vars['video']->value['video_link'];?>
" name="video_link<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
"> <br/>-->
	<!--<span>截图<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index']+1;?>
：</span><input id="pFiledata<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
" size=70 type=file value="上 传" name="pFiledata<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
" /><br/>-->
	<!--标题<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index']+1;?>
：<input maxLength=50 size=70 name=video_title<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
 value="<?php echo $_smarty_tpl->tpl_vars['video']->value['video_title'];?>
" /><br />-->
	<!--简介<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index']+1;?>
：<input maxLength=200 size=70 name=video_narrate<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
 value="<?php echo $_smarty_tpl->tpl_vars['video']->value['video_narrate'];?>
" /><br />-->
	<!--时长<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index']+1;?>
：<input type="text" name="video_time<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['video']->value['video_time'];?>
"> 例如：几分几秒-->
	<!--<div id="tip<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
" class=red></div>-->
	<!--<div id="preview<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
">-->
	<!--<?php if ($_smarty_tpl->tpl_vars['video']->value['video']!=''){?>-->
	<!--<div id='vpreview<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
'>The player will show in this paragraph</div>-->

	<!--<script type='text/javascript' src='../../plug-in/flvplayer/swfobject.js'></script>-->
	<!--<script type='text/javascript'>-->
	<!--var s1 = new SWFObject('../../plug-in/flvplayer/flvplayer.swf','player','400','300','9');-->
	<!--s1.addParam('allowfullscreen','true');-->
	<!--s1.addParam('allowscriptaccess','true');-->
	<!--s1.addParam('flashvars','file=<?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value);?>
<?php echo $_smarty_tpl->tpl_vars['video']->value['video'];?>
&image=<?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value);?>
b/<?php echo $_smarty_tpl->tpl_vars['video']->value['videopic'];?>
');-->
	<!--s1.write('vpreview<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['index'];?>
');-->
	<!--</script>-->
	<!--<?php }elseif(!empty($_smarty_tpl->tpl_vars['video']->value['video_link'])){?>-->
	<!--<embed src="<?php echo $_smarty_tpl->tpl_vars['video']->value['video_link'];?>
" quality="high" width="320" height="240" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>-->
	<!--<?php }?></div>-->
	<!--</td>-->
	<!--</tr>-->
	<!--<?php }} ?>-->
	<!--<tr>-->
	<!--<td>-->
	<!--<span>视频<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total']+1;?>
：</span><input id="vFiledata<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total'];?>
" size=70 type=file value="上 传" name="vFiledata<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total'];?>
"> <input type=button onclick='return delFj1(this,<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total']+1;?>
)' value='删除'> <span class=gray>和外链二选一上传即可</span><br/>-->
	<!--外链<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total']+1;?>
：</span><input id="video_link<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total'];?>
" size=70 type=text value="" name="video_link<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total'];?>
"> <span class=gray>格式必须为.swf，写全外部引用视频网址</span><br/>-->
	<!--<span>截图<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total']+1;?>
：</span><input id="pFiledata<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total'];?>
" size=70 type=file value="上 传" name="pFiledata<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total'];?>
" /> <span class=gray>视频文件未提交之前，该数据提交无效</span><br/>-->
	<!--标题<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total']+1;?>
：<input maxLength=50 size=70 name=video_title<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total'];?>
 value="" /> <span class=gray>视频文件未提交之前，该数据提交无效</span><br />-->
	<!--简介<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total']+1;?>
：<input maxLength=200 size=70 name=video_narrate<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total'];?>
 value="" /> <span class=gray>视频文件未提交之前，该数据提交无效</span><br />-->
	<!--时长<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total']+1;?>
：<input type="text" name="video_time<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total'];?>
" value=""> 例如：几分几秒  <span class=gray>视频文件未提交之前，该数据提交无效</span>-->
    <!--<div id="tip99<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total']+1;?>
" class=red></div>-->
    <!--<div id="preview99<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total']+1;?>
"></div>-->
	<!--</td>-->
	<!--</tr>-->
	<!--</table>-->
    <!--<a href="#" onclick="return addFj1()">添加一部视频</a>&nbsp;&nbsp;(只能上传后缀为 <font color=red>.flv</font> 格式的视频)-->
	<!--<input type="hidden" name="fjCnt1" value="<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['video']['total']+1;?>
" />-->
	<!--</td>-->
  <!--</tr>-->
  <tr>
    <td>发布时间：</td>
    <td><input type="text" name="submit_date" value="<?php echo $_smarty_tpl->getVariable('arrData')->value['submit_date'];?>
">
		<input TYPE="button" value="" onclick='popUpCalendar(this, form1.submit_date, dateformat,-1,-1,true)' style="background-image:url(../../plug-in/PopCalender/img/Button.gif);width:25px;height:17px;border:0px;padding:0px;"></td>
    <td><span class=gray>修改公告发布时间</span></td>
  </tr> 
  <!--<tr>-->
    <!--<td>公告属性：</td>-->
    <!--<td><input id=topflag type=text name=topflag size=1 value="<?php echo $_smarty_tpl->getVariable('arrData')->value['topflag'];?>
" ><label>固顶(列表) </label>-->
    	<!--<input id=recommendflag type=text name=recommendflag size=1 value="<?php echo $_smarty_tpl->getVariable('arrData')->value['recommendflag'];?>
" ><label>推荐(首页)</label>-->
		<!--<label><input id=hotflag onclick="javascript:document.form1.clicktimes.value=Math.round(Math.random()*1000)" -->
      <!--type=checkbox >随机点击 </label>-->
      <!--会员访问等级：<select size=1 name=stars>-->
      <!--<option value=5 <?php if ($_smarty_tpl->getVariable('arrData')->value['stars']==5){?>selected<?php }?>>★★★★★</option>-->
      <!--<option value=4 <?php if ($_smarty_tpl->getVariable('arrData')->value['stars']==4){?>selected<?php }?>>★★★★</option>-->
      <!--<option value=3 <?php if ($_smarty_tpl->getVariable('arrData')->value['stars']==3){?>selected<?php }?>>★★★</option>-->
      <!--<option value=2 <?php if ($_smarty_tpl->getVariable('arrData')->value['stars']==2){?>selected<?php }?>>★★</option>-->
      <!--<option value=1 <?php if ($_smarty_tpl->getVariable('arrData')->value['stars']==1){?>selected<?php }?>>★</option>-->
      <!--<option value=0 <?php if ($_smarty_tpl->getVariable('arrData')->value['stars']==0){?>selected<?php }?>>无</option></select></td>-->
    <!--<td><span class=gray>选择文章的一些属性，数字越大越排前，最大256</span></td>-->
  <!--</tr> -->
  <tr>
    <td>点击初始值：</td>
    <td><input maxLength=50 size=10 value="<?php echo $_smarty_tpl->getVariable('arrData')->value['clicktimes'];?>
" name=clicktimes></td>
    <td><span class=gray>这功能是提供给管理员作弊用的</span></td>
  </tr>  
	<tr>
      <td>&nbsp;</td>
      <td align=middle colspan=3><input type=submit id="okgo" name="okgo" value=确　定> <input type=reset value="重 置"></td>
  </tr>
	<?php  $_smarty_tpl->tpl_vars['photo'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrData')->value['photo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['photo']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['photo']['total'] = $_smarty_tpl->tpl_vars['photo']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['photo']['index']=-1;
if ($_smarty_tpl->tpl_vars['photo']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['photo']->key => $_smarty_tpl->tpl_vars['photo']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['photo']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['photo']['index']++;
?>
	<input type=hidden name=savephoto[] value="<?php echo $_smarty_tpl->tpl_vars['photo']->value['photo'];?>
">
	<?php }} ?>
	<table id="delphoto" border=0 cellspacing=0 cellpadding=0 >
	</table>
	<?php  $_smarty_tpl->tpl_vars['video'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrData')->value['video']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['video']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['video']['total'] = $_smarty_tpl->tpl_vars['video']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['video']['index']=-1;
if ($_smarty_tpl->tpl_vars['video']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['video']->key => $_smarty_tpl->tpl_vars['video']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['video']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['video']['index']++;
?>
	<input type=hidden name=savevideo[] value="<?php echo $_smarty_tpl->tpl_vars['video']->value['video'];?>
">
	<input type=hidden name=savevideopic[] value="<?php echo $_smarty_tpl->tpl_vars['video']->value['videopic'];?>
">
	<?php }} ?>
	<table id="delvideo" border=0 cellspacing=0 cellpadding=0 >
	</table>
	<input type=hidden name=savefilename1 value="<?php echo $_smarty_tpl->getVariable('arrData')->value['software'];?>
">
	<input type=hidden name=savefilename2 value="<?php echo $_smarty_tpl->getVariable('arrData')->value['package'];?>
">
	<input type=hidden name=user_id value="<?php echo $_smarty_tpl->getVariable('arrData')->value['user_id'];?>
">
  <input type=hidden name=id value="<?php echo $_smarty_tpl->getVariable('arrData')->value['id'];?>
">
</table>
</div>
</form>
<script language="javascript">
	function addFj(){
	  var oTb = document.getElementById("tb1");
	  var oTr = oTb.insertRow(-1);
	  var num = parseInt(document.form1.fjCnt.value)+1;
	  var no = parseInt(document.form1.fjCnt.value);
	  document.form1.fjCnt.value=num;
	  oTr.insertCell(0).innerHTML = "<span>图片"+num+"：</span><input id='file' name='Filedata"+no+"' type=file  size='70' /> <input type=button onclick='return delFj(this,"+num+")' value='删除'><br /><span>说明"+num+"：</span><input maxLength=50 size=70 name=photo_narrate"+no+"  /><br /><div id=tip"+num+" class=red></div><div id=preview"+num+"></div>";
	  return false;
	}

	function deloldFj(obj,No){
		var oTb = document.getElementById("delphoto");
		var oTr = oTb.insertRow(-1);
		var new_tr = obj.parentNode.parentNode.parentNode;
		oTr.insertCell(0).innerHTML = "<input type=hidden name=delphoto[] value="+No+">";
		new_tr.removeChild(obj.parentNode.parentNode);
		return false;
	}
	function delFj(obj,No){
		var num = parseInt(document.form1.fjCnt.value);
		var new_tr = obj.parentNode.parentNode.parentNode;
		new_tr.removeChild(obj.parentNode.parentNode);
		if (num == No){
			document.form1.fjCnt.value=num-1;
		}
		return false;
	}
</script>
<script language="javascript">
	function addFj1(){
	  var oTb = document.getElementById("tb2");
	  var oTr = oTb.insertRow(-1);
	  var num = parseInt(document.form1.fjCnt1.value)+1;
	  var no = parseInt(document.form1.fjCnt1.value);
	  document.form1.fjCnt1.value=num;
	  oTr.insertCell(0).innerHTML = "<span>视频"+num+"：</span><INPUT size=70 type=file value='上 传' name='vFiledata"+no+"' > <input type=button onclick='return delFj1(this,"+num+")' value='删除'><br/>外链"+num+"：</span><input size=70 type=text name=video_link"+no+" /><br /><span>截图"+num+"：</span><INPUT size=70 type=file value='上 传' name='pFiledata"+no+"' /><br/>标题"+num+"：<INPUT maxLength=50 size=70 name=video_title"+no+" /><br />简介"+num+"：<INPUT maxLength=200 size=70 name=video_narrate"+no+" /><br />时长"+num+"：<input type='text' name='video_time"+no+"'> 例如：几分几秒<br /><div id=tip99"+num+" class=red></div><div id=preview99"+num+"></div>";
	  return false;
	}

	function deloldFj1(obj,No){
		var oTb = document.getElementById("delvideo");
		var oTr = oTb.insertRow(-1);
		var new_tr = obj.parentNode.parentNode.parentNode;
		oTr.insertCell(0).innerHTML = "<INPUT type=hidden name=delvideo[] value="+No+">";
		new_tr.removeChild(obj.parentNode.parentNode);
		return false;
	}
	function delFj1(obj,No){
		var num = parseInt(document.form1.fjCnt1.value);
		var new_tr = obj.parentNode.parentNode.parentNode;
		new_tr.removeChild(obj.parentNode.parentNode);
		if (num == No){
			document.form1.fjCnt1.value=num-1;
		}
		return false;
	}
	
	/**
	 * 检查上传图片的，图片说明是否为空
	 * @author	嬴益虎 <whoneed@163.com>
	 * @return	boolean
	 */
	function checkPhotoNarrate(){
		var intLen = parseInt(document.form1.fjCnt.value);

		for(var i=0; i<intLen; i++){
			var objPhoto = document.getElementsByName('Filedata'+i);

			if(objPhoto['0'].value != ''){
				var objNar = document.getElementsByName('photo_narrate'+i);
				if(objNar['0'].value == ''){
					alert('警告：您的第 '+(i+1)+' 张图片,没有填写图片说明!');
					return false;
				}
			}
		}
		return true;
	}
</script>