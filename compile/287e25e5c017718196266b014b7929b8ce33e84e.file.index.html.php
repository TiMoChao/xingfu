<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:29:19
         compiled from "/Volumes/data/wochacha_program/xingfu/xingfu_school/config/../../templates/1/xingfu_school/index.html" */ ?>
<?php /*%%SmartyHeaderCode:8779832275662a05f9ab583-54191121%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '287e25e5c017718196266b014b7929b8ce33e84e' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/xingfu_school/config/../../templates/1/xingfu_school/index.html',
      1 => 1449168842,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8779832275662a05f9ab583-54191121',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_imgurl')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.imgurl.php';
if (!is_callable('smarty_modifier_api')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.api.php';
if (!is_callable('smarty_function_url')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/function.url.php';
if (!is_callable('smarty_modifier_csubstr')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.csubstr.php';
if (!is_callable('smarty_modifier_bedeck')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.bedeck.php';
if (!is_callable('smarty_modifier_date_format')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.date_format.php';
?>
<div class="yey-home-box">

    <div class="yey-home-nbox"><!-- nei box -->
        <div class="xf-yey-topbox"><!-- top box -->
            <div class="xf-yey-topnbox clb">
                <div class="xf-yey-tti">
                    <div class="xf-yey-tle clb">
                        <i class="yey-top-imgo"></i>
                        <div class="yey-top-i2b"><i class="yey-top-imgt"></i></div>
                    </div>
                    <div class="yey-top-top-boxt clb">
                        <div class="yey-top-lunbob">
                            <div class="yey-top-lunbo1">
                                <a href="javascript:;" class="xf-pr1"></a>
                                <a href="javascript:;" class="xf-ne1"></a>
                                <ul class="yey-top-ulo clb">
                                    <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfoList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
                                    <li><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_school');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['title']);?>
" /></li>
                                    <?php }} ?>
                                </ul>
                            </div>
                        </div>
                        <div class="yey-top-rightbox">
                            <div class="yey-top-ribj clb">
                                <ul>
                                    <?php  $_smarty_tpl->tpl_vars['arrdata'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_school_class','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^9^id,title,summary,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrdata']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrdata']->key => $_smarty_tpl->tpl_vars['arrdata']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrdata']['index']++;
?>
                                    <!--<li>小一班</li>-->
                                    <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['arrdata']['index']==0){?>

                                     <a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>
                    <?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school_class/detail.php?id=".($_smarty_tpl->tpl_vars['arrdata']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrdata']->value['summary']);?>
">
                                    <li> <?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrdata']->value['title'],0,3),$_smarty_tpl->tpl_vars['arrdata']->value['bedeck']);?>
</li>

                                    <?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['arrdata']['index']==3){?>

                                     <a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>
                    <?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school_class/detail.php?id=".($_smarty_tpl->tpl_vars['arrdata']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrdata']->value['summary']);?>
">
                                    <li><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrdata']->value['title'],0,3),$_smarty_tpl->tpl_vars['arrdata']->value['bedeck']);?>
</li>

                                    <?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['arrdata']['index']==6){?>

                                     <a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>
                    <?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school_class/detail.php?id=".($_smarty_tpl->tpl_vars['arrdata']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrdata']->value['summary']);?>
">
                                    <li> <?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrdata']->value['title'],0,3),$_smarty_tpl->tpl_vars['arrdata']->value['bedeck']);?>
</li>


                                    <?php }else{ ?>
                                     <a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>
                    <?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school_class/detail.php?id=".($_smarty_tpl->tpl_vars['arrdata']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrdata']->value['summary']);?>
">
                                    <li class="ribj-left"><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrdata']->value['title'],0,3),$_smarty_tpl->tpl_vars['arrdata']->value['bedeck']);?>
</li>
                                    <?php }?>

                                    <?php }} ?>
                                </ul>
                            </div>
                            <div class="yey-top-ricb">
                                <p class="yey-top-riti">通知公告</p>
                                <ul>

                                    <?php  $_smarty_tpl->tpl_vars['arrdata'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_school_Notice','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^8^id,title,summary,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrdata']->key => $_smarty_tpl->tpl_vars['arrdata']->value){
?>
                                    <li> <a href="<?php if ($_smarty_tpl->tpl_vars['arrdata']->value['linkurl']!=''){?>
                    <?php echo $_smarty_tpl->tpl_vars['arrdata']->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school_Notice/detail.php?id=".($_smarty_tpl->tpl_vars['arrdata']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrdata']->value['summary']);?>
">
                                        <?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrdata']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrdata']->value['bedeck']);?>
</li>
                                    <?php }} ?>


                                    <!--<?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfoList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>-->
                                    <!--<?php if ($_smarty_tpl->tpl_vars['arrNews']->value['type_id']==2){?>-->
                                    <!--<li> <a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>-->
                    <!--<?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
">-->
                                        <!--<?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</li>-->
                                    <!--<?php }?>-->
                                    <!--<?php }} ?>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="yey-top-yszq">
            <div class="yey-top-ysnb clb">
                <div class="yey-yszq-lbox clb">
                    <div class="yey-yszq-tb">
                        <i></i>
                    </div>
                    <div class="yey-yszq-bb">
                        <ul>

                            <?php  $_smarty_tpl->tpl_vars['arrdata'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_school_show','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^3^id,title,thumbnail,summary,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrdata']->key => $_smarty_tpl->tpl_vars['arrdata']->value){
?>
                            <li>
                                <div class="yszq-timgb"><a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>
                    <?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school_show/detail.php?id=".($_smarty_tpl->tpl_vars['arrdata']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrdata']->value['summary']);?>
"></a><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrdata']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_school_show');?>
/s/<?php echo $_smarty_tpl->tpl_vars['arrdata']->value['thumbnail'];?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrdata']->value['title']);?>
" width="226" height="149"/></a></div>
                                <div class="yszq-pti"><p><a href="<?php echo smarty_function_url(array('url'=>"/xingfu_school_show/detail.php?id=".($_smarty_tpl->tpl_vars['arrdata']->value['id'])),$_smarty_tpl);?>
"><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrdata']->value['title'],0,24),$_smarty_tpl->getVariable('arrNews')->value['bedeck']);?>
</a></p></div>
                                <div class="yszq-contb"><p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrdata']->value['summary']);?>
</p></div>
                                <div class="yszq-btnb"><a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>
                    <?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school_show/"),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrdata']->value['summary']);?>
">
                                    MORE</a></div>
                            </li>
                            <?php }} ?>


                            <!--<?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfoList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>-->
                            <!--<?php if ($_smarty_tpl->tpl_vars['arrNews']->value['type_id']==3){?>-->
                            <!--<li>-->

                                <!--<div class="yszq-timgb"><a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>-->
                    <!--<?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
"></a><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_school');?>
/s/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['title']);?>
" width="226" height="149"/></a></div>-->
                                <!--<div class="yszq-pti"><p><a href="javascript:;"><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</a></p></div>-->
                                <!--<div class="yszq-contb"><p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
</p></div>-->
                                <!--<div class="yszq-btnb"><a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>-->
                    <!--<?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
">-->
                                    <!--MORE</a></div>-->
                            <!--</li>-->
                            <!--<?php }?>-->
                            <!--<?php }} ?>-->


                        </ul>
                    </div>
                </div>
                <div class="yey-yszq-rbox clb">


                    <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_school_Basic_courses','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^1^id,title,summary,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
                    <div class="yszq-rti"><p>园本课程</p></div>
                    <div class="yszq-tcti">
                        <div><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</div>
                        <div><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
</div>
                    </div>
                    <div class="yszq-rimgb">
                        <img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_school_Basic_courses');?>
/s/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['title']);?>
" width="178" height="102"/>
                    </div>
                    <div class="yszq-ribtnb">
                        <a href="<?php echo smarty_function_url(array('url'=>"/xingfu_school_Basic_courses/"),$_smarty_tpl);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
">
                        MORE</a>
                    </div>
                    <?php }} ?>



                    <!--<?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfoList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>-->
                    <!--<?php if ($_smarty_tpl->tpl_vars['arrNews']->value['type_id']==4){?>-->
                    <!--<div class="yszq-rti"><p>园本课程</p></div>-->
                    <!--<div class="yszq-tcti">-->
                        <!--<div><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</div>-->
                        <!--<div><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
</div>-->
                    <!--</div>-->
                    <!--<div class="yszq-rimgb">-->
                        <!--<img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_school');?>
/s/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['title']);?>
" width="178" height="102"/>-->
                    <!--</div>-->
                    <!--<div class="yszq-ribtnb">-->
                        <!--<a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>-->
                    <!--<?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
">-->
                        <!--MORE</a>-->
                    <!--</div>-->
                    <!--<?php }?>-->
                    <!--<?php }} ?>-->

                </div>
            </div>
        </div>
        <div class="yey-jcsj-box">
            <div class="yey-top-ysnb clb">
                <div class="yey-jcsj-lbox clb">
                    <div class="yey-jcsj-tb">
                        <i></i>
                    </div>
                    <div class="jcsj-lbinb clb">
                        <div class="jcsj-limgib">


                            <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_school_moment','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^1^id,title,thumbnail,summary,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
                            <div class="jcsj-limgb">
                                <img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_school_moment');?>
/s/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['title']);?>
" width="191" height="191"/>
                            </div>
                            <div class="jcsj-lab">
                                <a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>
                    <?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school_moment/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
">
                                <?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</a>
                            </div>
                            <?php }} ?>


                            <!--<?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfoList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>-->
                            <!--<?php if ($_smarty_tpl->tpl_vars['arrNews']->value['type_id']==5){?>-->

                            <!--<div class="jcsj-limgb">-->
                                <!--<img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_school');?>
/s/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['title']);?>
" width="191" height="191"/>-->
                            <!--</div>-->
                            <!--<div class="jcsj-lab">-->
                                <!--<a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>-->
                    <!--<?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
">-->
                                <!--<?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</a>-->
                            <!--</div>-->
                            <!--<?php }?>-->
                            <!--<?php }} ?>-->

                        </div>
                        <div class="jcsj-lrinb">
                            <div class="jcsj-lrtib">
                                <p>园所新闻</p>
                            </div>
                            <div class="jcsj-lrlistb">
                                <ul>

                                    <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_school_news','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^8^id,title,submit_date,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>

                                    <li> <a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>
                    <?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school_news/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
">
                                        <?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</a><span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['arrNews']->value['submit_date'],"%Y/%m/%d");?>
</span></li>
                                    <?php }} ?>


                                    <!--<?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfoList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>-->
                                    <!--<?php if ($_smarty_tpl->tpl_vars['arrNews']->value['type_id']==6){?>-->

                                    <!--<li> <a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>-->
                    <!--<?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
">-->
                                        <!--<?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</a><span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['arrNews']->value['submit_date'],"%Y/%m/%d");?>
</span></li>-->
                                    <!--<?php }?>-->
                                    <!--<?php }} ?>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="yey-jcsj-rbox">
                    <div class="jcsj-lrtib">
                        <p>园丁风采</p>
                    </div>

                    <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_school_teacher','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^1^id,title,thumbnail,summary,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>

                    <div class="jcsj-rcimgb">
                        <img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_school_teacher');?>
/s/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['title']);?>
" width="195" height="129"/>
                    </div>
                    <div class="yszq-ribtnb">
                        <a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>
                    <?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school_teacher/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
">
                        <?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</a>
                    </div>
                    <?php }} ?>

                    <!--<?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrInfoList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>-->
                    <!--<?php if ($_smarty_tpl->tpl_vars['arrNews']->value['type_id']==4){?>-->
                    <!--<div class="jcsj-rcimgb">-->
                        <!--<img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_school');?>
/s/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['title']);?>
" width="195" height="129"/>-->
                    <!--</div>-->
                    <!--<div class="yszq-ribtnb">-->
                        <!--<a href="<?php if ($_smarty_tpl->getVariable('arrData')->value['linkurl']!=''){?>-->
                    <!--<?php echo $_smarty_tpl->getVariable('arrData')->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_school/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['arrNews']->value['summary']);?>
">-->
                        <!--<?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</a>-->
                    <!--</div>-->
                    <!--<?php }?>-->
                    <!--<?php }} ?>-->

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/js/main.js"></script>
