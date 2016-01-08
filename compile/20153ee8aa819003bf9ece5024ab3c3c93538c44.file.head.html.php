<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:29:21
         compiled from "/Volumes/data/wochacha_program/xingfu/xingfu_ImgShow/config/../../templates/1/theme/head.html" */ ?>
<?php /*%%SmartyHeaderCode:6606347935662a061a538c4-99379786%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '20153ee8aa819003bf9ece5024ab3c3c93538c44' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/xingfu_ImgShow/config/../../templates/1/theme/head.html',
      1 => 1449168840,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6606347935662a061a538c4-99379786',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_url')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/function.url.php';
?>
<div class="header-box clb">
    <div class="n-i-nb clb">
        <div class="logo-i-b">
            <a href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/logo1.png" /></a>
        </div>
        <div class="nav-list-b clb">
            <ul>
<li>
                    <?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable($_SERVER['REQUEST_URL'], null, null);?>
                    <?php $_smarty_tpl->tpl_vars['is_alpha'] = new Smarty_variable(strpos($_smarty_tpl->getVariable('url')->value,'xingfu_'), null, null);?>
                    <?php if ($_smarty_tpl->getVariable('is_alpha')->value==''){?>
                    <a class="" href="<?php echo smarty_function_url(array('url'=>'/'),$_smarty_tpl);?>
">首页</a>
                    <?php }else{ ?>
                    <a class="nav-a" href="<?php echo smarty_function_url(array('url'=>'/'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->getVariable('is_alpha')->value;?>
</a>
                    <?php }?>
                </li>
                <li>
                    <?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable($_SERVER['REQUEST_URI'], null, null);?>
                    <?php $_smarty_tpl->tpl_vars['is_alpha'] = new Smarty_variable(strpos($_smarty_tpl->getVariable('url')->value,'xingfu_news'), null, null);?>
                      <?php if ($_smarty_tpl->getVariable('is_alpha')->value!=''){?>
                      <a class="nav-a"  href="<?php echo smarty_function_url(array('url'=>'/xingfu_news/'),$_smarty_tpl);?>
">兴甫新闻</a>
                      <?php }else{ ?>
                    <a href="<?php echo smarty_function_url(array('url'=>'/xingfu_news/'),$_smarty_tpl);?>
">兴甫新闻</a>
                    <?php }?>
                </li>
                <li>
                    <?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable($_SERVER['REQUEST_URI'], null, null);?>
                    <?php $_smarty_tpl->tpl_vars['is_alpha'] = new Smarty_variable(strpos($_smarty_tpl->getVariable('url')->value,'xingfu_school'), null, null);?>
                    <?php if ($_smarty_tpl->getVariable('is_alpha')->value!=''){?>
                    <a  class="nav-a" href="<?php echo smarty_function_url(array('url'=>'/xingfu_school/'),$_smarty_tpl);?>
">星甫幼儿园</a>
                    <?php }else{ ?>
                    <a href="<?php echo smarty_function_url(array('url'=>'/xingfu_school/'),$_smarty_tpl);?>
">星甫幼儿园</a>
                    <?php }?>
                </li>
                <li>
                    <?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable($_SERVER['REQUEST_URI'], null, null);?>
                    <?php $_smarty_tpl->tpl_vars['is_alpha'] = new Smarty_variable(strpos($_smarty_tpl->getVariable('url')->value,'xingfu_ImgShow'), null, null);?>
                    <?php if ($_smarty_tpl->getVariable('is_alpha')->value!=''){?>
                    <a  class="nav-a" href="<?php echo smarty_function_url(array('url'=>'/xingfu_ImgShow/'),$_smarty_tpl);?>
">兴甫风采</a>
                    <?php }else{ ?>
                    <a href="<?php echo smarty_function_url(array('url'=>'/xingfu_ImgShow/'),$_smarty_tpl);?>
">兴甫风采</a>
                    <?php }?>
                </li>
                <li>

                    <?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable($_SERVER['REQUEST_URI'], null, null);?>
                    <?php $_smarty_tpl->tpl_vars['is_alpha'] = new Smarty_variable(strpos($_smarty_tpl->getVariable('url')->value,'xingfu_teaching'), null, null);?>
                    <?php if ($_smarty_tpl->getVariable('is_alpha')->value!=''){?>
                    <a  class="nav-a" href="<?php echo smarty_function_url(array('url'=>'/xingfu_teaching/'),$_smarty_tpl);?>
">武术教学</a>
                    <?php }else{ ?>
                    <a href="<?php echo smarty_function_url(array('url'=>'/xingfu_teaching/'),$_smarty_tpl);?>
">武术教学</a>
                    <?php }?>
                </li>
                <li>

                    <?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable($_SERVER['REQUEST_URI'], null, null);?>
                    <?php $_smarty_tpl->tpl_vars['is_alpha'] = new Smarty_variable(strpos($_smarty_tpl->getVariable('url')->value,'xingfu_coach'), null, null);?>
                    <?php if ($_smarty_tpl->getVariable('is_alpha')->value!=''){?>
                    <a  class="nav-a" href="<?php echo smarty_function_url(array('url'=>'/xingfu_coach/'),$_smarty_tpl);?>
">名师风采</a>
                    <?php }else{ ?>
                    <a href="<?php echo smarty_function_url(array('url'=>'/xingfu_coach/'),$_smarty_tpl);?>
">名师风采</a>
                    <?php }?>
                </li>
            </ul>
        </div>
    </div>
</div>
