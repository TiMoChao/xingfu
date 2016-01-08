<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:56:53
         compiled from "/Volumes/data/wochacha_program/xingfu/config/../templates/1/index.html" */ ?>
<?php /*%%SmartyHeaderCode:508266945662a6d53d0352-95337028%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd45cb9da5f0d214ffa50cdeb201ee73b83d83a0b' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/config/../templates/1/index.html',
      1 => 1449305807,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '508266945662a6d53d0352-95337028',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_api')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.api.php';
if (!is_callable('smarty_modifier_imgurl')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.imgurl.php';
if (!is_callable('smarty_function_url')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/function.url.php';
if (!is_callable('smarty_modifier_csubstr')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.csubstr.php';
if (!is_callable('smarty_modifier_bedeck')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.bedeck.php';
if (!is_callable('smarty_modifier_date_format')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.date_format.php';
?>
    <!--<link rel="stylesheet" href="css/style.css" type="text/css"/>-->
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/css/style.css"/>

<div>
    <!-- ---------- 轮播 ---------- -->
    <div class="h-i-bimg clb">
        <div class="xf-jj-tinb">
            <div data-status="1" class="xf-jj-lbt">
                <p>武术是中华民族传统文化的魁宝，是中国传统文化中一颗璀璨的明珠。贵阳兴甫武术学校是我省武术老拳师（周辛甫，原贵州省武术协会副主席）名字命名的一所专业武术培训机构，学校创办二十二年，在国际、全国、省、市各大型武术比赛中，共获金牌445块、银牌258块、铜牌176块的优异成绩。教学模式新颖，教练教学经验丰富，环境优雅。</p>
                <!--<div class="xf-jj-ab clb"><a href="javascript:;">更多兴甫荣誉</a></div>-->
            </div>
        </div>
        <span class="pr-b">&lt;</span>
        <span class="ne-b">&gt;</span>
        <ul class="clb">


            <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_pic','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^10^id,title,summary,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
            <li><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_pic');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>"  width="1920" height="671"/></li>
            <?php }} ?>
            <!--<li><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/lunbo/1.jpg"/></li>-->
            <!--<li><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/lunbo/2.jpg"/></li>-->
        </ul>


    </div>

    <!-- ---------- 公告跑马灯 ---------- -->
    <div class="h-c-topb clb">
        <div class="h-c-topnb">
            <div class="h-c-tLimg"><i></i><marquee>
                <!--网站公告：2015秋季招生活动开始啦-->
                <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_Notice','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^6^id,title,summary,structon_tb,submit_date,type_id,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']++;
?>
                <?php if ($_smarty_tpl->tpl_vars['arrNews']->value['type_id']==1){?>
                <!--<a href="<?php echo smarty_function_url(array('url'=>"/xingfu_Notice/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
"><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</a>-->
                <?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>

                <?php }?>
                <?php }} ?>
            </marquee></div>
            <!--<div class="h-c-tLinput"><input type="text" value="请输入搜索内容" /><i title="搜索"></i></div>-->
        </div>
    </div>

    <!-- ---------- 兴甫简介 ---------- -->
    <div class="xf-jj-box">
        <div class="xf-jj-topb">
            <span><i></i></span>
        </div>
        <div class="xf-jj-nb clb">
            <div class="xf-jj-leftb"><!-- left start -->
                <h3 class="xf-jj-title">Xing Fu Introduction<br/>兴甫简介</h3>
                <div class="xf-jj-pb">
                    <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_Introduction','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^10^id,title,summary,structon_tb,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
                   <p><?php echo smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['summary'],0,255);?>
...</p>
                    <?php }} ?>
                    <!--<p>贵阳市体校兴甫武术学校经贵州省体育局和云岩区教育局批准于1994年成立，是一所“以文为主、文武兼修”，实行全日制、寄宿制（住读）教学和业余武术训练两种教学方式，实行半军事化封闭式管理的新型文武学校。</p>-->
                    <!--<p>学校全面贯彻党的教育方针，坚持“严格管理，争创一流文武学校，培养德艺双馨人才”的办学宗旨，按国家教委规定开设小学至高中全部文化课程，...</p>-->
                    <!--<p>学校全面贯彻党的教育方针，坚持“严格管理，争创一流文武学校，培养德艺双馨人才”的办学宗旨，按国家教委规定开设小学至高中全部文化课程，...</p>-->
                </div>
                <div class="xf-jj-btnb clb"><a href="<?php echo smarty_function_url(array('url'=>'/xingfu_Introduction/'),$_smarty_tpl);?>
">更多关于兴甫 &gt; &gt;
                    <span class="btnb-top"></span>
                    <span class="btnb-left"></span>
                    <span class="btnb-right"></span>
                    <span class="btnb-bottom"></span>
                </a></div>
            </div><!-- left end -->

            <div class="xf-jj-rightb"><!-- right start -->
                <div>
                    <div class="video-h1" id="CuPlayer">

                        <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_teaching','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^1^id,title,summary,structon_tb,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
?>
                        <?php if (!empty($_smarty_tpl->tpl_vars['arrNews']->value['video'])){?>
                        <?php  $_smarty_tpl->tpl_vars['video'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['arrNews']->value['video']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['video']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['video']->key => $_smarty_tpl->tpl_vars['video']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['video']->key;
 $_smarty_tpl->tpl_vars['video']->index++;
 $_smarty_tpl->tpl_vars['video']->first = $_smarty_tpl->tpl_vars['video']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['video']['first'] = $_smarty_tpl->tpl_vars['video']->first;
?>
                        <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['video']['first']){?>
                        <script type='text/javascript' src='<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/plug-in/flvplayer/swfobject.js'></script>
                        <?php }?><center>
                        <?php if ($_smarty_tpl->tpl_vars['video']->value['video']!=''){?>
                        <div id='vpreview<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['arrNews']['index'];?>
'>The player will show in this paragraph</div>
                        <script type='text/javascript'>
                            var s1 = new SWFObject('<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/plug-in/flvplayer/flvplayer.swf','player','546','327','9');
                            s1.addParam('allowfullscreen','true');
                            s1.addParam('allowscriptaccess','true');
                            s1.addParam('flashvars','file=<?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_teaching');?>
<?php echo $_smarty_tpl->tpl_vars['video']->value['video'];?>
&image=<?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_teaching');?>
b/<?php echo $_smarty_tpl->tpl_vars['video']->value['videopic'];?>
');
                            s1.write('vpreview<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['arrNews']['index'];?>
');
                        </script>
                        <?php }elseif($_smarty_tpl->tpl_vars['video']->value['video_link']!=''){?>
                        <embed src="<?php echo $_smarty_tpl->tpl_vars['video']->value['video_link'];?>
" quality="high" width="580" height="400" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed><br>
                        <?php }?></center><br>
                        <?php }} ?>
                        <?php }?>
                        <?php }} ?>

                        <!--<strong>兴甫武术学校 提示：您的Flash Player版本过低，请<a href="index.html">点此进行网页播放器升级</a>！</strong>-->
                    </div>
                </div>
            </div><!-- right end -->
        </div>
    </div>
    <!-- ------------ xing fu feng cai ------------- -->
    <div class="xf-fc-box clb">
        <div class="xf-fc-nbox">
            <div class="xf-fc-title"></div>
            <div class="xf-fc-bib clb">
                <div class="xf-fc-blb"><!-- left info box -->
                    <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_ImgShow','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^3^3^id,title,summary,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']++;
?>
                    <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['arrNews']['index']==0){?>
                    <div class="xf-fc-blt mouback"><a href="javascript:;"><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" width="250" height="248"/></a></div>

                    <?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['arrNews']['index']==1){?>
                    <div class="xf-fc-blc mouback"><a href="javascript:;"><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" width="250" height="248"/></a></div>

                    <?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['arrNews']['index']==2){?>
                    <div class="xf-fc-blb1 mouback"><a href="javascript:;"><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" width="250" height="248"/></a></div>

                    <?php }?>
                    <?php }} ?>
                    <!--<div class="xf-fc-blt mouback"><a class="xf-fc-io" href="javascript:;"></a></div>-->
                    <!--<div class="xf-fc-blc mouback"><a href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-1.jpg" /></a></div>-->
                    <!--<div class="xf-fc-blb1 mouback"><a href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-2.jpg" /></a></div>-->
                </div>
                <div class="xf-fc-bcb"><!-- content info box -->
                    <div class="xf-fc-bct clb"><!-- content lun bo -->
                        <span class="pr-b1">&lt;</span>
                        <span class="ne-b1">&gt;</span>
                        <ul class="xf-fc-bcul1">
                            <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_ImgShow','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^3^id,title,summary,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']++;
?>
                            <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['arrNews']['index']==0){?>
                            <li style="display:block;"><a href="<?php echo smarty_function_url(array('url'=>'/xingfu_ImgShow/'),$_smarty_tpl);?>
"><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>"/></a><div class="xf--fc-bcbin"><a href="<?php echo smarty_function_url(array('url'=>'/xingfu_ImgShow/'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['arrNews']->value['title'];?>
</a></div></li>

                            <?php }else{ ?>
                            <li><a href="<?php echo smarty_function_url(array('url'=>'/xingfu_ImgShow/'),$_smarty_tpl);?>
"><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>"/></a><div class="xf--fc-bcbin"><a href="<?php echo smarty_function_url(array('url'=>'/xingfu_ImgShow/'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['arrNews']->value['title'];?>
</a></div></li>

                            <?php }?>

                            <?php }} ?>
                            <!--<li style="display:block;"><a href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-3.jpg" /></a><div class="xf--fc-bcbin"><a href="javascript:;">兴甫武术学校黑山杯</a></div></li>-->
                            <!--<li><a href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-1.jpg" /></a><div class="xf--fc-bcbin"><a href="javascript:;">兴甫武术学校黑山杯</a></div></li>-->
                            <!--<li><a href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-2.jpg" /></a><div class="xf--fc-bcbin"><a href="javascript:;">兴甫武术学校黑山杯</a></div></li>-->
                        </ul>
                        <ul class="xf-fc-bcbtn clb">
                            <li class="liback1"></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <div class="xf-fc-bcb1"><!-- content lun bo -->
                        <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_ImgShow','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^9^2^id,title,summary,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']++;
?>
                        <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['arrNews']['index']==0){?>
                        <div class="xf-fc-bcb1l">
                            <img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" width="250" height="248"/>                        </div>
                        <?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['arrNews']['index']==1){?>
                        <div class="xf-fc-bcb1r mouback">
                            <img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" width="250" height="248"/>
                        </div>
                        <?php }?>
                        <?php }} ?>
                        <!--<div class="xf-fc-bcb1l">-->
                            <!--<img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-4.jpg" />-->
                        <!--</div>-->
                        <!--<div class="xf-fc-bcb1r mouback">-->
                            <!--<img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-5.jpg" />-->
                        <!--</div>-->
                    </div>
                </div>
                <div class="xf-fc-brb"><!-- right lun bo -->
                    <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_ImgShow','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^6^3^id,title,summary,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']++;
?>
                    <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['arrNews']['index']==0){?>
                    <div class="xf-fc-brbt mouback"><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" width="250" height="248"/></div>

                    <?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['arrNews']['index']==1){?>
                    <div class="xf-fc-brbc mouback"><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" width="250" height="248"/></div>

                    <?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['arrNews']['index']==2){?>
                    <div class="xf-fc-brbb mouback"><<img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_ImgShow');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>" width="250" height="248"/></div>

                    <?php }?>
                    <?php }} ?>
                    <!--<div class="xf-fc-brbt"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-6.jpg" /></div>-->
                    <!--<div class="xf-fc-brbc mouback"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-7.jpg" /></div>-->
                    <!--<div class="xf-fc-brbb mouback"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-8.jpg" /></div>-->
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------- ming shi feng cai ------------------- -->
    <div class="xf-ms-box">
        <div class="xf-ms-nbox">
            <div class="xf-ms-tti"></div>
            <div class="xf-ms-tconb clb">
                <ul>
                    <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_coach','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^4^id,title,summary,structon_tb,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']++;
?>
                     <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['arrNews']['index']==0){?>
                    <li class="xf-ms-Li" style="margin-left: 75px;"><div class="xf-ms-Lidiv"><a class="xf-ms-Lia1" href="<?php echo smarty_function_url(array('url'=>"/xingfu_coach/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
"><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_coach');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>"/></a></div>
                        <a class="xf-ms-Lia2" href="<?php if ($_smarty_tpl->tpl_vars['arrNews']->value['linkurl']!=''){?>
                        <?php echo $_smarty_tpl->tpl_vars['arrNews']->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_coach/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>">
                        <?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</a>
                    </li>
                    <?php }else{ ?>
                    <li class="xf-ms-Li file" style="margin-left: 75px;"><div class="xf-ms-Lidiv"><a class="xf-ms-Lia1" href="<?php echo smarty_function_url(array('url'=>"/xingfu_coach/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
"><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_coach');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>"/></a></div>
                        <a class="xf-ms-Lia2" href="<?php if ($_smarty_tpl->tpl_vars['arrNews']->value['linkurl']!=''){?>
                        <?php echo $_smarty_tpl->tpl_vars['arrNews']->value['linkurl'];?>
<?php }else{ ?><?php echo smarty_function_url(array('url'=>"/xingfu_coach/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
<?php }?>">
                        <?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</a>
                    </li>
                    <?php }?>
                    <?php }} ?>
                    <!--<li class="xf-ms-Li file"><div class="xf-ms-Lidiv"><a class="xf-ms-Lia1" href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/jl-1.png" /></a></div><a class="xf-ms-Lia2" href="javascript:;">李教练</a></li>-->
                    <!--<li class="xf-ms-Li flle"><div class="xf-ms-Lidiv"><a class="xf-ms-Lia1" href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/jl-2.png" /></a></div><a class="xf-ms-Lia2" href="javascript:;">李教练</a></li>-->
                    <!--<li class="xf-ms-Li flle"><div class="xf-ms-Lidiv"><a class="xf-ms-Lia1" href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/jl-3.png" /></a></div><a class="xf-ms-Lia2" href="javascript:;">李教练</a></li>-->
                    <!--<li class="xf-ms-Li flle"><div class="xf-ms-Lidiv"><a class="xf-ms-Lia1" href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/jl-4.png" /></a></div><a class="xf-ms-Lia2" href="javascript:;">李教练</a></li>-->
                    <!--<li class="xf-ms-Li flle"><div class="xf-ms-Lidiv"><a class="xf-ms-Lia1" href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/jl-5.png" /></a></div><a class="xf-ms-Lia2" href="javascript:;">李教练</a></li>-->
                </ul>
            </div>
        </div>
    </div>
    <!-- ----------------- xing fu xin wen ------------------- -->
    <div class="xf-news-box">
        <div class="xf-news-nbox">
            <div class="xf-news-tti"></div>
            <div class="xf-news-conb clb">
                <div class="xf-news-leftb">
                    <ul class="xf-news-llist clb">
                        <li class="xf-news-liback">最新资讯<span class="xf-news-j">◆</span></li>
                        <li>网站公告<span class="xf-news-j">◆</span></li>
                    </ul>
                    <div class="xf-news-listbox">
                        <ul style="display:block;" class="xf-news-inlist clb">

                            <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_news','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^6^id,title,summary,structon_tb,submit_date,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']++;
?>
                            <li class="clb"><a href="<?php echo smarty_function_url(array('url'=>"/xingfu_news/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
"><i></i><p><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</p></a><span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['arrNews']->value['submit_date'],"%Y/%m/%d");?>
</span></li>
                            <?php }} ?>

                            <!--<li class="clb"><a href="<?php echo smarty_function_url(array('url'=>"/xingfu_news/detail.php?id=".($_smarty_tpl->getVariable('arrNews')->value['id'])),$_smarty_tpl);?>
"><i></i><p><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->getVariable('arrNews')->value['title'],0,24),$_smarty_tpl->getVariable('arrNews')->value['bedeck']);?>
</p></a><span><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('arrNews')->value['submit_date'],"%Y/%m/%d");?>
</span></li>-->
                            <!--<li class="clb"><a href="javascript:;"><i></i><p>澳门国际武术比赛武术太？张山鼓励兴甫队员并合影.....</p></a><span>2015/03/13</span></li>-->
                            <!--<li class="clb"><a href="javascript:;"><i></i><p>澳门国际武术比赛武术太？张山鼓励兴甫队员并合影.....</p></a><span>2015/03/13</span></li>-->
                            <!--<li class="clb"><a href="javascript:;"><i></i><p>澳门国际武术比赛武术太？张山鼓励兴甫队员并合影.....</p></a><span>2015/03/13</span></li>-->
                            <!--<li class="clb"><a href="javascript:;"><i></i><p>澳门国际武术比赛武术太？张山鼓励兴甫队员并合影.....</p></a><span>2015/03/13</span></li>-->
                            <!--<li class="clb"><a href="javascript:;"><i></i><p>澳门国际武术比赛武术太？张山鼓励兴甫队员并合影.....</p></a><span>2015/03/13</span></li>-->
                        </ul>
                        <ul class="xf-news-inlist clb">
                            <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_Notice','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^6^id,title,summary,structon_tb,submit_date,type_id,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']++;
?>
                            <?php if ($_smarty_tpl->tpl_vars['arrNews']->value['type_id']==2){?>
                            <li class="clb"><a href="<?php echo smarty_function_url(array('url'=>"/xingfu_Notice/detail.php?id=".($_smarty_tpl->tpl_vars['arrNews']->value['id'])),$_smarty_tpl);?>
"><i></i><p><?php echo smarty_modifier_bedeck(smarty_modifier_csubstr($_smarty_tpl->tpl_vars['arrNews']->value['title'],0,24),$_smarty_tpl->tpl_vars['arrNews']->value['bedeck']);?>
</p></a><span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['arrNews']->value['submit_date'],"%Y/%m/%d");?>
</span></li>
                            <?php }?>
                            <?php }} ?>
                            <!--<li class="clb"><a href="javascript:;"><i></i><p>2澳门国际武术比赛武术太？张山鼓励兴甫队员并合影.....</p></a><span>2015/03/13</span></li>-->
                            <!--<li class="clb"><a href="javascript:;"><i></i><p>澳门国际武术比赛武术太？张山鼓励兴甫队员并合影.....</p></a><span>2015/03/13</span></li>-->
                            <!--<li class="clb"><a href="javascript:;"><i></i><p>澳门国际武术比赛武术太？张山鼓励兴甫队员并合影.....</p></a><span>2015/03/13</span></li>-->
                            <!--<li class="clb"><a href="javascript:;"><i></i><p>澳门国际武术比赛武术太？张山鼓励兴甫队员并合影.....</p></a><span>2015/03/13</span></li>-->
                            <!--<li class="clb"><a href="javascript:;"><i></i><p>澳门国际武术比赛武术太？张山鼓励兴甫队员并合影.....</p></a><span>2015/03/13</span></li>-->
                            <!--<li class="clb"><a href="javascript:;"><i></i><p>澳门国际武术比赛武术太？张山鼓励兴甫队员并合影.....</p></a><span>2015/03/13</span></li>-->
                        </ul>
                    </div>
                </div>
                <div class="xf-news-rightb">
                    <div class="xf-news-rinb">
                        <a href="javascript:;" class="xf-pr"></a>
                        <a href="javascript:;" class="xf-ne"></a>
                        <ul class="xf-news-ul clb">

                            <?php  $_smarty_tpl->tpl_vars['arrNews'] = new Smarty_Variable;
 $_from = smarty_modifier_api($_smarty_tpl->getVariable('arr')->value,'xingfu_news','getInfoList',"where pass=1^ ORDER BY topflag DESC,submit_date DESC^0^6^id,title,summary,structon_tb,submit_date,thumbnail,bedeck^^0"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['arrNews']->key => $_smarty_tpl->tpl_vars['arrNews']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['arrNews']['index']++;
?>
                            <?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?>
                            <?php }else{ ?>
                            <li><a><img src="<?php if (empty($_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'])){?><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['templats_root'];?>
/images/nopic.jpg<?php }else{ ?><?php echo smarty_modifier_imgurl($_smarty_tpl->getVariable('FileCallPath')->value,'xingfu_news');?>
/b/<?php echo $_smarty_tpl->tpl_vars['arrNews']->value['thumbnail'];?>
<?php }?>"/></a></li>
                            <?php }?>
                            <?php }} ?>
                            <!--<li><a><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-9.jpg" /></a></li>-->
                            <!--<li><a><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-8.jpg" /></a></li>-->
                            <!--<li><a><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/by/fc-7.jpg" /></a></li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------- lian xi wo men  ------------------- -->
    <div class="xf-lx-box">
        <div class="xf-lx-nbox clb">
            <div class="xf-lx-leftbox"><!-- left box -->
                <div class="xf-lx-tiimg"></div>
                <div class="xf-lx-erweima">
                    <img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/xfewm.jpg" />
                </div>
                <div class="xf-lx-wxjj">
                    微信扫一扫<br/>
                    关注我们相关信息
                </div>
                <div class="xf-lx-lianxilist">
                    <ul>
                        <li>服务热线 : 0851-85617199</li>
                        <li>联 系 人 : 李教练</li>
                        <li>校方邮箱 : 3319353372@qq.com</li>
                        <li>邮政编码 : 467000</li>
                        <li>学校地址 : 贵阳市云岩区宝山北路111号</li>
                    </ul>
                </div>
            </div>

            <form action="<?php echo smarty_function_url(array('url'=>'/xingfu_apply/'),$_smarty_tpl);?>
" method="post" name="messageform">
                <table cellspacing="5" cellpadding="0" border="0" id="mess_table">

                    <div class="xf-lx-rightbox clb"><!-- right box -->
                        <div class="inp-box">
                            <input type="text" value="姓名" name="name" id="name"/>
                        </div>
                        <div class="inp-box">
                            <input type="text" value="年龄" name="age" id="age"/>
                        </div>
                        <div class="inp-box">
                            <select name="sex" id="sex"><option value="nodu">性别</option><option value="男">男</option><option value="女">女</option></select>
                        </div>
                        <div class="inp-box">
                            <select name="ethnic" id="ethnic"><option value="nodu">民族</option value='汉族'><option>汉</option></select>
                        </div>
                        <div class="inp-box">
                            <input type="text" value="家庭住址" name="address" id="address" />
                        </div>
                        <div class="inp-box">
                            <input type="text" value="联系电话" name="iphone"  id="iphone"/>
                        </div>
                        <div class="inp-box">
                            <input type="text" value="文化班级" name="class_type" id="class_type"/>
                        </div>
                        <div class="inp-box">
                            <select id="class" name="class"><option value="nodu">所报班级</option><option value="大班">大班</option></select>
                        </div>
                        <div class="inp-box">
                            <input type="text" value="家长微信号" name="weichat" id="weichat" />
                        </div>
                        <div class="clb">
                            <!--<button class="liyy-btn"><input type="button" value="立即预约" onClick="messageform.submit();"/></button>-->
                            <button class="liyy-btn" onClick="messageform.submit();">立即预约</button>
                        </div>
                        <div class="l-mapb">
                            <div id="l-map"></div>
                            <!--  <div class="xy-qhd"><button class="wx-btn xy-bab">兴甫武校</button><button class="yeyh-btn">星甫幼儿园</button></div> -->
                        </div>
                    </div>
                </table>
            </form>


        </div>
    </div>

</div>

    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=tbZhmxa0Werk7IZ7Zbg7TBML"></script>

    <script type="text/javascript">
        /* var oDiv = $(".wx-btn").offset();
         var oDivTop = oDiv.top;
         //alert(oDivTop);

         $(window).scroll(function (){
         if($(window).scrollTop() > (oDivTop - $(window).height())){
         alert("到了");
         }
         }) */


        //百度地图API功能
        var map = new BMap.Map("l-map");            // 创建Map实例
        map.centerAndZoom(new BMap.Point(106.729821,26.585491), 11);
        var local = new BMap.LocalSearch(map, {
            renderOptions: {map: map, panel: "r-result"}
        });
        local.search("兴甫","星甫");
    </script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/js/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/js/main.js"></script>