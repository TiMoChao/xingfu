<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:29:21
         compiled from "/Volumes/data/wochacha_program/xingfu/xingfu_ImgShow/config/../../templates/1/xingfu_ImgShow/index.html" */ ?>
<?php /*%%SmartyHeaderCode:2511688815662a061acffc1-44496738%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8cd8c213e4e56f187c665381adb220653065674' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/xingfu_ImgShow/config/../../templates/1/xingfu_ImgShow/index.html',
      1 => 1449168842,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2511688815662a061acffc1-44496738',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_imgurl')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.imgurl.php';
if (!is_callable('smarty_modifier_csubstr')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.csubstr.php';
if (!is_callable('smarty_modifier_bedeck')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.bedeck.php';
?> <div id="hb">
     <div class="xf-is-box clb">
         <div class="xf-is-lbox">
             <div>
             </div>
         </div>
         <div class="xf-is-rbox clb">
             <ul id="hhh" style="display:block; opacity:1;">

                 <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfoList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
                 <?php if ($_smarty_tpl->tpl_vars['arrNews']->value['type_id']==1){?>
                 <li><a href="javascript:;">
                     <img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>"/>
                    </a><div class="is-jx-box"><p><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</p></div><div class="is-xx-box">
                     <p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
</p></div></li>
                 <?php }?>
                 <?php }} ?>

             </ul>
             <ul id="hhh">
                 <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfoList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
                 <?php if ($_smarty_tpl->tpl_vars['arrNews']->value['type_id']==2){?>
                 <li><a href="javascript:;">
                     <img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" width="450" height="282"/></a><div class="is-jx-box"><p><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</p></div><div class="is-xx-box">
                     <p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
</p></div></li>
                 <?php }?>
                 <?php }} ?>
             </ul>
             <ul id="hhh">
                 <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfoList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
                 <?php if ($_smarty_tpl->tpl_vars['arrNews']->value['type_id']==3){?>
                 <li><a href="javascript:;">
                     <img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" width="450" height="282"/></a><div class="is-jx-box"><p><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</p></div><div class="is-xx-box">
                     <p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
</p></div></li>
                 <?php }?>
                 <?php }} ?>
             </ul>
         </div>
     </div>
     <div class="is-qh-box">
         <div class="is-qh-topbtnb"><a href="javascript:;"></a></div>
         <div class="is-qh-hideb">
             <ul class="is-qh-ysul">
                 <li><a class="is-qh-ysa ahb" href="javascript:;">1</a></li>
                 <li><a class="is-qh-ysa" href="javascript:;">2</a></li>
                 <li><a class="is-qh-ysa" href="javascript:;">3</a></li>
             </ul>
             <div class="is-qh-gdic"></div>
         </div>
         <div class="is-qh-btobtnb"><a href="javascript:;"></a></div>
     </div>
 </div>
 <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/js/jquery-1.8.3.js"></script>
 <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/js/main.js"></script>
 <script>
     /* $(".xf-is-rbox ul li").hover(function(event){
      });
      $(".xf-is-rbox ul li").mouseout(function(event){
      $(this).find(".is-xx-box").stop().animate({bottom:'-100%'},300,function(){$(this).parent().find(".is-jx-box").stop().animate({bottom:'0'},300);});
      }); */

     //$(".xf-is-rbox ul li").each(function() {
     $(".xf-is-rbox ul li").hover(function() {
                 $(this).find(".is-jx-box").stop().animate({bottom:'-30px'},300);
                 $(this).find(".is-xx-box").stop().animate({bottom:'0%'},400);
             },
             function() {
                 $(this).find(".is-xx-box").stop().animate({bottom:'-100%'},300);
                 $(this).find(".is-jx-box").stop().animate({bottom:'0'},400);

             });
     //});

     $("#hb").height($(window).height());
 </script>

