<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:55:54
         compiled from "/Volumes/data/wochacha_program/xingfu/xingfu_admissions/config/../../templates/1/xingfu_admissions/index.html" */ ?>
<?php /*%%SmartyHeaderCode:20087906565662a69a631442-46873701%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '85460b883931eadfbe4aaaa1a17ef9b4f1515edc' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/xingfu_admissions/config/../../templates/1/xingfu_admissions/index.html',
      1 => 1449168841,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20087906565662a69a631442-46873701',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_url')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/function.url.php';
if (!is_callable('smarty_modifier_imgurl')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.imgurl.php';
?><link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/css/style.css"/>

<div class="n-back">
    <div class="content_box clb">
        <div><img style="width:100%;" src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/news-img.jpg" /></div>
        <div class="n-c-b clb">
            <div class="n-c-lb">
                <span class="n-c-ts"></span>
                <ul class="n-c-cul">
                    <li class="culli"><a href="<?php echo smarty_function_url(array('url'=>'/xingfu_news/'),$_smarty_tpl);?>
">
                        <p>Xing_Fu News<br/>兴甫新闻</p>
                    </a></li>
                    <li class="culli"><a href="<?php echo smarty_function_url(array('url'=>'/xingfu_Notice/'),$_smarty_tpl);?>
">
                        <p>Xin Fu Notice<br/>网站公告</p>
                    </a></li>
                    <li class="down-back culli"><a href="<?php echo smarty_function_url(array('url'=>'/xingfu_admissions/'),$_smarty_tpl);?>
">
                        <p>Xin Fu Admissions<br/>招生简介</p>
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
                <div class="n-c-rt"><span class="n-c-rtib"><p class="rtib-po">招生简介</p></span><span class="n-c-rtwzb">您现在所在的位置： <a href="<?php echo smarty_function_url(array('url'=>'/'),$_smarty_tpl);?>
">首页</a> > <a href='<?php echo smarty_function_url(array('url'=>"/xingfu_news/"),$_smarty_tpl);?>
'>新闻中心</a> > <a href='#'>招生简介</a></span></div>
                <div class="n-c-rib">
                    <div class="n-c-riul" style="display:block;">


                        <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfoList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
                        <p class="f_center" style="padding: 0px; margin-top: 26px; margin-bottom: 26px; font-size: 14px; text-align: center; color: rgb(37, 37, 37); font-family: 宋体, sans-serif; line-height: 24px; white-space: normal; background-color: rgb(255, 255, 255);">
                            <img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_admissions');?>
/s/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['title']);?>
" width="191" height="191"/>
                        </p>
                        <p style="padding: 0px; margin-top: 26px; margin-bottom: 26px; font-size: 14px; text-indent: 2em; color: rgb(37, 37, 37); font-family: 宋体, sans-serif; line-height: 24px; text-align: justify; white-space: normal; background-color: rgb(255, 255, 255);">
                            <?php echo $_smarty_tpl->tpl_vars['arrNews']->value['intro'];?>

                        </p>
                        <?php }} ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

