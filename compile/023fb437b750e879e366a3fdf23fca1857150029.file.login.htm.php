<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:04:42
         compiled from "/Volumes/data/wochacha_program/xingfu/user/config/../../admin/templats/login.htm" */ ?>
<?php /*%%SmartyHeaderCode:23325048456629a9ada1a89-70071044%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '023fb437b750e879e366a3fdf23fca1857150029' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/user/config/../../admin/templats/login.htm',
      1 => 1449168507,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23325048456629a9ada1a89-70071044',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html><head><title><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['name'];?>
管理后台 - BIWEB WMS</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/style.css" type=text/css rel=stylesheet>
<script language=Javascript src="js/login.js"></script>
<script language=Javascript type=text/Javascript>
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_nbGroup(event, grpName) { //v6.0
  var i,img,nbArr,args=MM_nbGroup.arguments;
  if (event == "init" && args.length > 2) {
    if ((img = MM_findObj(args[2])) != null && !img.MM_init) {
      img.MM_init = true; img.MM_up = args[3]; img.MM_dn = img.src;
      if ((nbArr = document[grpName]) == null) nbArr = document[grpName] = new Array();
      nbArr[nbArr.length] = img;
      for (i=4; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
        if (!img.MM_up) img.MM_up = img.src;
        img.src = img.MM_dn = args[i+1];
        nbArr[nbArr.length] = img;
    } }
  } else if (event == "over") {
    document.MM_nbOver = nbArr = new Array();
    for (i=1; i < args.length-1; i+=3) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = (img.MM_dn && args[i+2]) ? args[i+2] : ((args[i+1])? args[i+1] : img.MM_up);
      nbArr[nbArr.length] = img;
    }
  } else if (event == "out" ) {
    for (i=0; i < document.MM_nbOver.length; i++) {
      img = document.MM_nbOver[i]; img.src = (img.MM_dn) ? img.MM_dn : img.MM_up; }
  } else if (event == "down") {
    nbArr = document[grpName];
    if (nbArr)
      for (i=0; i < nbArr.length; i++) { img=nbArr[i]; img.src = img.MM_up; img.MM_dn = 0; }
    document[grpName] = nbArr = new Array();
    for (i=2; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = img.MM_dn = (args[i+1])? args[i+1] : img.MM_up;
      nbArr[nbArr.length] = img;
  } }
}
//-->
</script>
</head>
<body leftMargin=0 topMargin=0 marginwidth="1" marginheight="0"><!--Start Top-->
<table cellSpacing=0 cellPadding=0 width="100%" bgColor=#003399 border=0>
  <tbody>
  <tr height=40>
    <td vAlign=center><a href="/"><img src="<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['WEB_ROOT_pre'];?>
/templates/1/xingfu_Extension/images/logo1.png"></a></td>
    </tr></tbody></table><br><br><span
class=windowheader>
<CENTER><a href="/"><b><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['name'];?>
后台管理区</b></a></CENTER></span><br><br>
<script>
function enter(field,e)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;

	if (keycode == 13)
	{
	   checkLoginForm();
	}
}

</script>

<CENTER><FONT face="Verdana, Arial" color=red size=1><B></B></FONT> 
<form name=form1 onSubmit="return checkLoginForm();" action=?action=check method=post>
<table cellSpacing=0 cellPadding=0 width=344 align=center bgColor=#cccccc 
border=0>
  <tbody>
  <tr>
    <td valign="top"><img height=2 src="images/spacer.gif" width=1><table cellSpacing=0 cellPadding=0 width=330 align=center bgColor=#f5f5f5 
      border=0>
        <tbody>
        <tr>
          <td><img src="images/login_header.gif"></td></tr>
        <tr>
          <td class=maindesc align=middle><br>Enter your username and password 
            in the form below. </a>. <br><br>
            <table cellSpacing=0 cellPadding=4 width=250 align=center 
            bgColor=#f5f5f5 border=0>
              <tbody>
              <tr>
                <td class=maindescbig>用户名:</td>
                <td><input onkeypress="return enter(this, event);" 
                  value="admin" name=User></td></tr>
              <tr>
                <td class=maindescbig>密　码:</td>
                <td><input onkeypress="return enter(this, event);" 
                  type=password value="" name=Pass></td></tr>
			  <tr>
                <td class=maindescbig>验证码:</td>
                <td><input onkeypress="return enter(this, event);" 
                  type=text value="" name=authCode size=6> ←<img src="<?php echo $_smarty_tpl->getVariable('strAuthImgDir')->value;?>
" align='top'></td></tr>				  
              <tr>
                <td align=middle colSpan=2><a 
                  onmouseover="MM_nbGroup('over','login','images/button_login_over.jpg','images/button_login_down.jpg',1)" 
                  onclick="MM_nbGroup('down','group1','login','',1); checkLoginForm();" 
                  onmouseout="MM_nbGroup('out')" 
                  href="#"><img 
                  alt=Login src="images/button_login_normal.jpg" onload="" 
                  border=0 name=login></a>&nbsp; <a 
                  onmouseover="MM_nbGroup('over','cancel','images/button_cancel_over.jpg','images/button_cancel_down.jpg',1)" 
                  onclick="MM_nbGroup('down','group1','cancel','',1); document.form1.reset();" 
                  onmouseout="MM_nbGroup('out')" 
                  href="#"><img 
                  alt=Cancel src="images/button_cancel_normal.jpg" 
                  onload="" border=0 name=cancel></a>&nbsp; 
          </td></tr></tbody></table></td></tr></tbody></table><img height=2 
      src="images/spacer.gif" width=1></td></tr></tbody></table></form>
<P class=maindesc><a href="/" target="_blank">兴甫武校</a></P><br><br>
<div class=maindesc align=center>Powered by TiMoChao Copyright © 2014-2015 , All Rights Reserved .
</div></td></tr></table><br></CENTER></body></html>
