//双击效果。<body  onDblClick="Submit_onDoubleclick()">
function Submit_onDoubleclick(){
	try{
		if(window.parent.document.getElementsByName("biweb")[0].cols=="165,*"){
			window.parent.document.getElementsByName("biweb")[0].cols="0,*";
		} else {
			window.parent.document.getElementsByName("biweb")[0].cols="165,*"
		}
	}catch (e){}
} 

function UseLinkUrl(){
    if (document.form1.uselink.checked == true){
    		document.form1.linkurl.disabled = false;
        ArticleContent.style.display = 'none';
    }
    else{
        document.form1.linkurl.disabled = true;
        ArticleContent.style.display = '';
    }
}

function showSkinImg(value){
	if(value!= '') {
		document.images.img.src = '../../templates/'+value+'/skin/skin.png';
	}
}

function checkForm(varForm)
{
	if(typeof(varForm.real_name) != "undefined"){
		if(varForm.real_name.value == "")
		{
			alert('会员姓名不能为空！');
			varForm.real_name.focus();
			return false;
		}
	}
	
	if(typeof(varForm.sex) != "undefined"){
		if(varForm.sex.value === "")
		{
			alert('性别必须选择！');
			varForm.sex.focus();
			return false;
		}
	}
	if(typeof(varForm.province) != "undefined"){
		if(varForm.province.value == '省份')
		{
			alert('所在地必须选择！');
			varForm.province.focus();
			return false;
		}
	}
	if(typeof(varForm.birthday) != "undefined"){
		if(varForm.birthday.value == "0")
		{
			alert('出生年必须选择！');
			varForm.birthday.focus();
			return false;
		}
	}
	if(typeof(varForm.type_id) != "undefined"){
		if(varForm.type_id.value == 0)
		{
			alert('所属类型必须选择！如未建立，请先到分类栏目建立分类！');
			varForm.type_id.focus();
			return false;
		}
	}
	if(typeof(varForm.longtitle) != "undefined"){
		if(varForm.longtitle.value == "")
		{
			alert('标题不能为空！');
			varForm.longtitle.focus();
			return false;
		}
	}
	if(typeof(varForm.title) != "undefined"){
		if(varForm.title.value == "")
		{
			alert('标题不能为空！');
			varForm.title.focus();
			return false;
		}
	}
    if(typeof(varForm.uselink) != "undefined"){
		if(varForm.uselink.checked == true && (varForm.linkurl.value == "" || varForm.linkurl.value == "http://") )
		{
			alert('转向地址不能为空！');
			varForm.linkurl.focus();
			return false;
		}
	}
	if(typeof(varForm.intro) != "undefined"){
		if(varForm.uselink.checked == false)
		{

			if(typeof(eWebEditor1) != "undefined" && eWebEditor1.getHTML() == "" ){
				alert('内容不能为空！');
				return false;
			}else{
				if(typeof(FCKeditorAPI) != "undefined"){
					if(GetMessageLength('intro') == 0){
						alert('内容不能为空！');
						return false;
					}
				}else if(varForm.intro.value == ""){
					alert('内容不能为空！');
					return false;
				}
			}			
		}
	}

    return true
    
}

//显示指定的js对象的所有属性和值，obj是对象，objid是名称
function showprop(obj,objid){
	var str = '';
	if (typeof(obj) == "undefined"){
		obj = eval(objid);
	}
	for(x in obj){
		if (x==0){
			alert('null   object');
			break;
		}else{
			str += objid+"[\""+x+"\"]="+obj[x]+"<br />\n";
		} //</else>
	}//for结束
	return str;
} 

function doChange(objText, objDrop)
{
    if (!objDrop) return;
    var str = objText.value;
    var arr = str.split("|");
    var nIndex = objDrop.selectedIndex;
    objDrop.length=1;
    for (var i=0; i<arr.length; i++){
        objDrop.options[objDrop.length] = new Option(arr[i], arr[i]);
    }
    objDrop.selectedIndex = nIndex;
}
function SelectPicChange(){
    document.form1.d_picurl.value = document.form1.d_picture.options[document.form1.d_picture.selectedIndex].value;
}
function checkspace(checkstr) {
	var str = '';
	for(i = 0; i < checkstr.length; i++) {
		str = str + ' ';
	}
	return (str == checkstr);
}

//登陆检测
function checkLoginForm()
{
	var frm = document.loginform
	if(frm.usercode.value == "")
	{
		alert('用户名不允许为空');
		frm.usercode.focus();
		return false;
	}
	if(frm.password.value == "")
	{
		alert('用户密码不允许为空');
		frm.password.focus();
		return false;
	}
	if(frm.authCode.value == "")
	{
		alert('验证码不允许为空');
		frm.authCode.focus();
		return false;
	}
	frm.submit()
	return true;
}


function doCheckAll(obj){
	var form = obj.form;
	for (var i=0;i<form.elements.length;i++){
		var e = form.elements[i];
		e.checked = obj.checked;
	}
}

function doAction(obj){
	var form = obj.form;
	var objCheckID = eval("form.checkid");
	if (!objCheckID){
		return;
	}
	var objCheckAction = eval("form.checkaction");
	if (!isChecked(objCheckID)){
		alert("请至少选择一条要操作的记录！");
		return;
	}
	if (!confirm("确定要执行此操作吗？")){
		return;
	}
	form.action=form.action+objCheckAction.options[objCheckAction.selectedIndex].value;
	form.submit();
}

function checkAction(sAction){
	var frm = document.delform;
	var boolFind = false ;
	for(i=0;i< frm.length;i++)  
	{ 
		e = frm.elements[i]; 
		if ( e.type=='checkbox'){
			if(e.checked){
				boolFind = true;
				break;
			}else{
				boolFind = false ;
			}			
		}		
	} 	
	
	if(boolFind){
		boolFind = confirm('您确定要操作吗？');
	}else{
		alert('请选择至少一条记录再操作！');
		boolFind = false;
	}
	if (boolFind == true){
		frm.action = frm.action + sAction
		frm.submit()
	}
}


function isChecked(obj){
	var i;
	if (obj.length==null){
		if(obj.checked){
			return true;
		}
	} else {
		for(var i=0; i<obj.length; i++){
			if(obj[i].checked){
				return true;
			}
		}
	}	
	return false;
}

// 以下为双击滚动
var currentpos,timer; 
function initialize() { 
	timer=setInterval("scrollwindow()",10);
} 
function sc(){
	clearInterval(timer);
}
function scrollwindow() {
	currentpos=document.body.scrollTop;
	window.scroll(0,++currentpos);
	if (currentpos != document.body.scrollTop) sc();
} 
//document.onmousedown=sc
//document.ondblclick=initialize

//弹窗
function g_OpenWindow(pageURL, innerWidth, innerHeight)
{	
	var ScreenWidth = screen.availWidth
	var ScreenHeight = screen.availHeight
	var StartX = (ScreenWidth - innerWidth) / 2
	var StartY = (ScreenHeight - innerHeight) / 2
	var wins = window.open(pageURL, 'OpenWin', 'left='+ StartX + ', top='+ StartY + ', Width=' + innerWidth +', height=' + innerHeight + ', resizable=yes, scrollbars=yes, status=no, toolbar=no, menubar=no, location=no')
	wins.focus();
}

//图片最大限制
function resizepic(thispic,width,height,scale){
	if(typeof(scale) != "undefined"){
		if(typeof(width) != "undefined"){
			if(thispic.width>width) thispic.width=width;
		}
		if(typeof(height) != "undefined"){
			if(thispic.height>height) thispic.height=height;
		}
	}else{
		if(thispic.width>thispic.height){
			if(typeof(width) != "undefined"){
				if(thispic.width>width) thispic.width=width;
			}
		}else{
			if(typeof(height) != "undefined"){
				if(thispic.height>height) thispic.height=height;
			}else{
				if(typeof(width) != "undefined"){
					if(thispic.width>width) thispic.width=width;
				}
			}
		}
	}
}

// 高亮显示当前行
function HighLightList(color,e){
	// 找对象
	var el = e;

	//var el = window.event.srcElement ? window.event.srcElement : window.event.target;
	var b=false;
	var tabElement=null;
	while (!b){
		el=GetParentElement(el, "TR")
		if (el){
			tabElement=GetParentElement(el, "TABLE");
			if (tabElement!=null && tabElement.className.toUpperCase()=="BIWEB"){
				break;
			}
			el=tabElement;
		}else{
			return;
		}
	}
	
	// 行下的单元格对象进行高亮处理
	for (var i=0;i<el.childNodes.length;i++){
		if (el.childNodes[i].tagName=="TD"){
			el.childNodes[i].style.backgroundColor=color;
		}
	}
}

// 取标签名相同的父对象
function GetParentElement(obj, tag){
	while(obj!=null && obj.tagName!=tag)
		obj=obj.parentNode;
	return obj;
}


//列表页鼠标高亮
document.onmouseover=function(e){
	if(!e)e = window.event; 
	var Event = e.target?e.target:e.srcElement;
	HighLightList("#dff6ff",Event);
}
document.onmouseout=function(e){
	if(!e)e = window.event; 
	var Event = e.target?e.target:e.srcElement;
	HighLightList("",Event);
}

//html源代码输出替换函数
function toTXT(str){ 
     var RexStr = /\<|\>|\"|\'|\&/g 
     str = str.replace(RexStr, 
         function(MatchStr){ 
             switch(MatchStr){ 
                 case "<": 
                     return "& lt;"; 
                     break; 
                 case ">": 
                     return "& gt;"; 
                     break; 
                 case "\"": 
                     return "& quot;"; 
                     break; 
                 case "'": 
                     return "& #39;"; 
                     break; 
                 case "&": 
                     return "& amp;"; 
                     break; 
                 default : 
                     break; 
             } 
         } 
     ) 
     return str; 
} 


//复制粘贴板
function copyEmailCode(id){
	var testCode=document.getElementById(id).value;
	var spacemark=document.getElementById('spacemark').value;
	testCode=testCode.replace(/\r\n/gim,spacemark);
	if(copy2Clipboard(testCode)!=false){
		alert("内容复制到粘贴板，你可以使用Ctrl+V 粘贴到需要去的地方！");
	}
}

copy2Clipboard=function(txt){
	if(window.clipboardData){
		window.clipboardData.clearData();
		window.clipboardData.setData("Text",txt);
	}
	else if(navigator.userAgent.indexOf("Opera")!=-1){
		window.location=txt;
	}
	else if(window.netscape){
		try{
			netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
		}
		catch(e){
			alert("您的firefox安全限制限制您进行剪贴板操作，请在地址栏输入’about:config’将signed.applets.codebase_principal_support’设置为true’之后重试，相对路径为firefox根目录/greprefs/all.js");
			return false;
		}
		var clip=Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
		if(!clip)return;
		var trans=Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
		if(!trans)return;
		trans.addDataFlavor('text/unicode');
		var str=new Object();
		var len=new Object();
		var str=Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
		var copytext=txt;str.data=copytext;
		trans.setTransferData("text/unicode",str,copytext.length*2);
		var clipid=Components.interfaces.nsIClipboard;
		if(!clip)return false;
		clip.setData(trans,null,clipid.kGlobalClipboard);
	}
}

//option项添加disabled的ie6禁用
function optionDisabled(){
    if (document.getElementsByTagName){
        var s = document.getElementsByTagName("select");
        if (s.length > 0){
            window.select_current = new Array();
            for (var i=0, select; select = s[i]; i++){
				if(select.onfocus == null){
					select.onfocus = function(){
						window.select_current[this.id] = this.selectedIndex;
					}
				}
				if(select.onchange == null){
					select.onchange = function(){
						restore(this);
					}
				}
                emulate(select);
            }
        }
    }
}

function restore(e){
    if (e.options[e.selectedIndex].disabled){
        e.selectedIndex = window.select_current[e.id];
    }
}

function emulate(e){
    for (var i=0, option; option = e.options[i]; i++){
        if (option.disabled){
            option.style.color = "graytext";
        }else{
            option.style.color = "menutext";
        }
    }
} 

//window.onload调用多个函数
function addLoadEvent(func){ 
    var oldonload=window.onload; 
    if(typeof window.onload!='function'){ 
        window.onload=func; 
    }else{ 
        window.onload=function(){ 
            oldonload(); 
            func(); 
        } 
    } 
}

addLoadEvent(optionDisabled);

var track_errors=1;
function noError()
{
if (track_errors==1)
     {
        return true;
     }
}
window.onerror = noError;