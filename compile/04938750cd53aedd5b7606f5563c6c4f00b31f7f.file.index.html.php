<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:29:18
         compiled from "/Volumes/data/wochacha_program/xingfu/xingfu_news/config/../../templates/1/xingfu_news/index.html" */ ?>
<?php /*%%SmartyHeaderCode:10042871155662a05e4f8f77-67481595%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04938750cd53aedd5b7606f5563c6c4f00b31f7f' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/xingfu_news/config/../../templates/1/xingfu_news/index.html',
      1 => 1449169054,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10042871155662a05e4f8f77-67481595',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_url')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/function.url.php';
if (!is_callable('smarty_modifier_csubstr')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.csubstr.php';
if (!is_callable('smarty_modifier_bedeck')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.bedeck.php';
if (!is_callable('smarty_modifier_date_format')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.date_format.php';
?>
 <div class="n-back">
     <div class="content_box clb">
         <div><img style="width:100%;" src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/news-img.jpg" /></div>
         <div class="n-c-b clb">
             <div class="n-c-lb">
                 <span class="n-c-ts"></span>
                 <ul class="n-c-cul">
                     <li class="down-back culli"><a href="<?php echo smarty_function_url(array('url'=>'/xingfu_news/'),$_smarty_tpl);?>
">
                         <p>Xing_Fu News<br/>兴甫新闻</p>
                     </a></li>
                     <li class="culli"><a href="<?php echo smarty_function_url(array('url'=>'/xingfu_Notice/'),$_smarty_tpl);?>
">
                         <p>Xing Fu Notice<br/>网站公告</p>
                     </a></li>
                     <li class="culli"><a href="<?php echo smarty_function_url(array('url'=>'/xingfu_admissions/'),$_smarty_tpl);?>
">
                         <p>Xing Fu Admissions<br/>招生简介</p>
                     </a></li>
                     <li class="culli"><a href="<?php echo smarty_function_url(array('url'=>'/xingfu_Introduction/'),$_smarty_tpl);?>
">
                         <p>Introduce<br/>兴甫简介</p>
                     </a>
                     </li>
                 </ul>
             </div>
             <div class="n-c-rb">
                 <div style="width:100%; background:#FF5953; height:30px;"></div>
                 <div class="n-c-rt"><span class="n-c-rtib"><p class="rtib-po">新闻资讯</p></span><span class="n-c-rtwzb">您现在所在的位置： <a href="<?php echo smarty_function_url(array('url'=>'/'),$_smarty_tpl);?>
">首页</a> > <a href='<?php echo smarty_function_url(array('url'=>"/xingfu_news/"),$_smarty_tpl);?>
'>新闻中心</a></span></div>


                 <div class="n-c-rib">
                     <div class="n-c-riul" style="display:block;">
                         <ul class="riul-ulb">
                             <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfoList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
                             <li class="riul-li clb"><a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>
							<?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_news/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
"><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</a><span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['arrNews']->value['submit_date'],"%Y-%m-%d");?>
</span></li>
                             <?php }} ?>
                         </ul>

                         <div class="fy-btnb clb">
                             <?php echo $_smarty_tpl->getVariable('strPage')->value;?>

                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
</div>
 <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/js/jquery-1.8.3.js"></script>
 <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/js/main.js"></script>
