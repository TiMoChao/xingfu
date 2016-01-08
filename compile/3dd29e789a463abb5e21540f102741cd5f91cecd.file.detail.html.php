<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:32:31
         compiled from "/Volumes/data/wochacha_program/xingfu/xingfu_coach/config/../../templates/1/xingfu_coach/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:21186799275662a11f50f3f4-29093577%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3dd29e789a463abb5e21540f102741cd5f91cecd' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/xingfu_coach/config/../../templates/1/xingfu_coach/detail.html',
      1 => 1449168835,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21186799275662a11f50f3f4-29093577',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_api')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.api.php';
if (!is_callable('smarty_function_url')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/function.url.php';
if (!is_callable('smarty_modifier_csubstr')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.csubstr.php';
if (!is_callable('smarty_modifier_bedeck')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.bedeck.php';
if (!is_callable('smarty_modifier_imgurl')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.imgurl.php';
?>

<div class="n-back">
    <div class="content_box clb">
        <div><img style="width:100%;" src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/news-img1.jpg" /></div>
        <div class="n-c-b clb">
            <div class="n-c-lb">
                <span class="n-c-ts"></span>
                <ul class="n-c-cul">

                    <li class="down-back culli"><a href="javascript:;">
                        <p>Norm style<br/>名师风采&nbsp;<i class="list-zkj"></i></p>
                    </a></li>
                    <div class="n-yey-b">
                        <ul>

                            <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_coach','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^100^id,title,summary,structon_tb,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
                            <li><a href="<?php if ($_smarty_tpl->tpl_vars['arrNews']->value['linkurl']!=''){?>
                            <?php echo $_smarty_tpl->tpl_vars['arrNews']->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_coach/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
"><i class="nlist-zkj"></i><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</a></li>
                            <?php }} ?>

                        </ul>
                    </div>
                </ul>
            </div>
            <div class="n-c-rb">
                <div style="width:100%; background:#FF5953; height:30px;"></div>
                <div class="n-c-rt"><span class="n-c-rtib"><p class="rtib-po">名师风采</p></span><span class="n-c-rtwzb">您现在所在的位置： <a href="<?php echo smarty_function_url(array('url'=>'/'),$_smarty_tpl);?>
">首页</a> > <a href="<?php echo smarty_function_url(array('url'=>"/xingfu_coach/"),$_smarty_tpl);?>
">名师风采</a>> <a href='#'><?php echo $_smarty_tpl->getVariable('arrData')->value['title'];?>
</a></span></div>
                <div class="">
                    <div class="jl-infob">

                        <div class="jl-topinb"><div class="jl-imgb">
                            <?php if (!empty($_smarty_tpl->getVariable('arrData',null,true,false)->value['photo'])){?>
                            <?php  $_smarty_tpl->tpl_vars['photo'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrData')->value['photo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['photo']->key => $_smarty_tpl->tpl_vars['photo']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['photo']->key;
?>
                            <?php if ($_smarty_tpl->tpl_vars['photo']->value['photo']!=''){?><br><center><img src="<?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_coach');?>
b/<?php echo $_smarty_tpl->tpl_vars['photo']->value['photo'];?>
" style="vertical-align: top; border: 0px;"alt="<?php echo $_smarty_tpl->tpl_vars['photo']->value['photo_narrate'];?>
"/><br><?php if ($_smarty_tpl->tpl_vars['photo']->value['photo_narrate']){?><?php echo $_smarty_tpl->tpl_vars['photo']->value['photo_narrate'];?>
<?php }?></center><br><?php }?>
                            <?php }} ?>
                            <?php }?>
                        </div><p class="jl-name"><?php echo $_smarty_tpl->getVariable('arrData')->value['title'];?>
</p></div>
                        <div class="jl-coninfb">
                            <div class="fxfc-tti"><p>教练简介</p></div>
                            <div class="jl-conbi">
                                <?php echo $_smarty_tpl->getVariable('arrData')->value['intro'];?>

                            </div>

                            <div class="fxfc-tti"><p>教练风采</p></div>
                            <div class="jl-imglib">
                                <div class="xf-news-rightbo">
                                    <div class="xf-news-rinbo">
                                        <a href="javascript:;" class="xf-pro"></a>
                                        <a href="javascript:;" class="xf-neo"></a>
                                        <ul class="xf-news-ulo clb">
                                            <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_coach','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^100^id,title,summary,structon_tb,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
                                            <li><a><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_coach');?>
/s/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['title']);?>
"/></a></li>
                                            <?php }} ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
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

