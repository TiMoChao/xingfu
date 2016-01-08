<?php /* Smarty version Smarty-3.0.7, created on 2015-12-05 16:04:54
         compiled from "/Volumes/data/wochacha_program/xingfu/admin/config/../../admin/templats/main_frame.htm" */ ?>
<?php /*%%SmartyHeaderCode:93207046156629aa64958f6-77760613%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b151df37837d997d6b0d8e25d2845911c35acbe6' => 
    array (
      0 => '/Volumes/data/wochacha_program/xingfu/admin/config/../../admin/templats/main_frame.htm',
      1 => 1449168507,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '93207046156629aa64958f6-77760613',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_api')) include '/Volumes/data/wochacha_program/xingfu/web_common5.8/Smarty/libs/plugins/modifier.api.php';
?><html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>BIWEB系统管理首页  - powered by BIWEB</title>
<link href='css/biweb.css' rel='stylesheet' type='text/css'>
<script type='text/javascript' src='js/biweb.js'></script>
</head>
<body ondblclick="Submit_onDoubleclick()">
<div class='bodytitle' style="height:33px;">
    <div class='bodytitleleft'></div>
    <div class='bodytitletxt'>兴甫武校管理首页</div>
    <div class='bodytitleright'></div>
    <div class='iicon'>
        <a href='javascript:window.location.reload();' class='img1'>　　 刷新</a>
        <a href='javascript:history.back();' class='img2'>　　 后退</a>
        <a href='javascript:history.go(1);' class='img3'>　　 前进</a>
    </div>
</div>
<div class="ccc2">
<ul style="">
您好! <font color="#FF6600"><strong><?php echo $_SESSION['user_name'];?>
</strong></font>。您的IP是：<font color="#FF6600"><strong><?php echo $_SERVER['REMOTE_ADDR'];?>
</strong></font>，您登陆的时间是：<font color="#FF6600"><strong><?php echo date("Y-m-d　H:i:s");?>
</strong></font>
</ul>
<div class="clr"></div>
</div>
<div id="biweb">
<script language='javascript' src='js/site.js'></script>
<table width="100%" cellspacing="0" cellpadding="0" align="center" class="biweb">
	<tr class="firstr">
	 <td colspan="5">
	 <span class="title">数据统计</span></td>
	</tr>
	<!--<tr>-->
		<!--<td>用户数：<b><a href="../user/admin">-->
		<!--<?php $_smarty_tpl->tpl_vars["totalUser"] = new Smarty_variable(smarty_modifier_api($_smarty_tpl->getVariable('_t')->value,'user','getInfoWhere','where 1=1^count(id) as id'), null, null);?><?php echo $_smarty_tpl->getVariable('totalUser')->value['id'];?>
</a></b>-->
		<!--</td>-->
		<!--<td>邮件订阅：<b><a href="../emaillist/admin">-->
		<!--<?php $_smarty_tpl->tpl_vars["totalEmail"] = new Smarty_variable(smarty_modifier_api($_smarty_tpl->getVariable('_t')->value,'emaillist','getInfoWhere','where 1=1^count(id) as id'), null, null);?><?php echo $_smarty_tpl->getVariable('totalEmail')->value['id'];?>
</a></b>-->
		<!--</td> -->
		<!--<td>手机订阅：<b><a href="../phonelist/admin">-->
		<!--<?php $_smarty_tpl->tpl_vars["totalMobile"] = new Smarty_variable(smarty_modifier_api($_smarty_tpl->getVariable('_t')->value,'phonelist','getInfoWhere','where 1=1^count(id) as id'), null, null);?><?php echo $_smarty_tpl->getVariable('totalMobile')->value['id'];?>
</a></b>-->
		<!--</td> 		-->
	<!--</tr>-->
</table>
</div>
<div id="biweb">
<table width="100%" cellspacing="0" cellpadding="0" align="center" class="biweb">
	<tr class="firstr">
	 <td colspan="2">
	 <span class="title">服务器信息</span></td>
	</tr>
	<tr>
		<td width="50%"><h5>服务器环境:</h5><?php echo $_smarty_tpl->getVariable('arrInfo')->value['serverinfo'];?>
</td>
		<td><h5>数据库版本:</h5><?php echo $_smarty_tpl->getVariable('arrInfo')->value['databaseinfo'];?>
</td>
	</tr>
	<tr>
		<td><h5>register_globals</h5><?php echo $_smarty_tpl->getVariable('arrInfo')->value['onoff'];?>
</td>
		<td><h5>文件上传:</h5><?php echo $_smarty_tpl->getVariable('arrInfo')->value['fileupload'];?>
</td>
	</tr>
</table>
</div>
<div id="biweb">
<table cellspacing="0" cellpadding="0" width="100%" align="center" class="biweb">
	<tr bgcolor="#f5fbff">
		<td width="15" bgcolor="#f5fbff" style="font-weight:bold">网站信息</td>
		<td bgcolor="white" style="padding:15px;" class="other">    
			<h5>Alexa排名：</h5><p id="alexaInfo">正在加载，请稍等……</p><br />
			<h5>网站收录：</h5>
			<label for="selSeo">搜索引擎：</label>
			<select id="selSeo" onchange="selSeo(this.value)">
				<option value="0">请选择搜索引擎</option>
				<option value="google">Google</option>
				<option value="baidu">百度</option>
				<option value="yahoo">Yahoo</option>
				<option value="bing">必应</option>
				<option value="sogou">搜狗</option>
				<option value="youdao">有道</option>
			</select>
			<div style="margin-top: 10px;" id="seoInfo">未选择搜索引擎</div>
		</td>
	</tr>
</table>
</div>
<div id="biweb">
<table width="100%" cellspacing="0" cellpadding="0" align="center" class="biweb">
	<tr class="firstr">
	 <td colspan="2">
	 <span class="title">开发团队</span></td>
	</tr>
	<tr>
		<td width="50%"><h5>版权所有:</h5><a href="http://www.bizeway.com" title='上海网务网络信息有限公司' target="_blank">上海网务网络信息有限公司</a></td>
		<td><h5>总策划兼项目经理:</h5>肖飞(ArthurXF@qq.com)</td>
	</tr>
	<tr>
		<td><h5>公司网站:</h5><a href="http://www.bizeway.com" title='http://www.bizeway.com' target="_blank">http://www.bizeway.com</a></td>
		<td><h5>产品网站:</h5><a href="http://www.biweb.cn" title='http://www.biweb.cn' target="_blank">http://www.biweb.cn</a></td>
	</tr>
</table>
</div>
<div class="copyright"><?php echo $_smarty_tpl->getVariable('arrGWeb')->value['Powered'];?>
 <?php echo $_smarty_tpl->getVariable('arrGWeb')->value['Copyright'];?>
</div>
</body></html>
<!-- Alexa & Gr 的 Ajax 载入 -->
<script type="text/javascript">

var domain = '<?php echo $_smarty_tpl->getVariable('arrGWeb')->value['host'];?>
';
// 测试用域名
//var domain = location.host;

var $ = function(n) { return document.getElementById(n) };
var xmlHttp;
function makeRequest(queryString,process,val) {
	var msXml = new Array();
	msXml[0] = "Microsoft.XMLHTTP";
	msXml[1] = "MSXML2.XMLHTTP.5.0";
	msXml[2] = "MSXML2.XMLHTTP.4.0";
	msXml[3] = "MSXML2.XMLHTTP.3.0";
	msXml[4] = "MSXML2.XMLHTTP";
	if (window.XMLHttpRequest) {
		xmlHttp = new XMLHttpRequest();
	} else {
		for (var i = 0; i < msXml.length; i++) {
			try {
				xmlHttp = new ActiveXObject(msXml[i]);
			} catch (e) {
				continue;
			}
		}
	}
	if(val == 1) xmlHttp.onreadystatechange = getAlexa;
	else if(val == 2) xmlHttp.onreadystatechange = getSeo;
	xmlHttp.open('post',process, true);
	xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlHttp.send(queryString);
}

function getAlexa() {
	if(xmlHttp.readyState==4) { 
		if(xmlHttp.status==200) {
			$('alexaInfo').innerHTML = xmlHttp.responseText;
		}
	}	
}

function getSeo() {
	if(xmlHttp.readyState==4) { 
		if(xmlHttp.status==200) {
			$('seoInfo').innerHTML =  xmlHttp.responseText;
		}
	}	
}

// Alexa 的 Ajax 载入
makeRequest("domain="+domain,'tools/alexa/doalexa.php',1);



// gr 值的 Ajax 载入
function selSeo(v) {
	$('seoInfo').innerHTML = '正在加载，请稍等……';
	if(v) makeRequest('domain='+domain+'&job='+v,'tools/gr/seo.php',2);
}

</script>