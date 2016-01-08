//设定一个全局的表单检查结果
//1111111111111111
var checkResult=false;
var errorIcon="<span class=\"tip_wrong\"></span>";
var rightIcon="<span class='tip_right'></span>";
var userNameIsRight=false,txtPwd1IsRight=false,txtPwd2IsRight=false,recommendIsRight=true;
var ddlQuestionIsRight=false,txtAnswerIsRight=false,txtEmailIsRight=false;
var txtValidateCodeIsRight=false,ddlSexIsRight=false;setCityIsRight=false;
var nickNameIsRight=false;
function getCookie(objName){
	var arrStr = document.cookie.split("; ");
	for(var i = 0;i < arrStr.length;i ++){
		var temp = arrStr[i].split("=");
		if(temp[0] == objName) return unescape(temp[1]);
	} 
}
var longUser = getCookie('recommend_user_id');
var mailObj=null;
var isR=false;
$(
function()
{	
	initalStyle();
	setUserNameBlurCheckFunction();
	setNickNameBlurCheckFunction();
	setDDLSexBlur();
	checkPassword();
	checkRepeatPwd();
	setDDLQuestionBlur();
	setEmailBlur();
	setValidateCode();
	setEmailMenu();
}
)
var select_email="";
function setEmailMenu(){
	$(document).click(
		function()
		{
			$("#email_hint").hide();
		}
	);
	
	$("#email_hint,#txtEmail").keyup(
	function(e)
	{
			if(e.keyCode==9)
			{	
				var visible=$("#email_hint").is(":visible");
				$("#email_hint").hide();
				if(visible)
				{
					$("#txtEmail").blur();
					$("#txtValidateCode").focus();
				}
			}
	}
	);

	$('#txtEmail').bind('keyup',function(_e){
		mailObj=document.getElementById("txtEmail");
		switch(_e.keyCode)
		{
			case 13:
				break;
			case 9:
				$('#txtEmail').val(select_email);
				$('#email_hint').hide();
				break;
			case 38 :
				var a_now_i = null;
				$('#email_hint>a').each(function(_i,_v){
					if($(_v).attr('class')=='on')
					{
						a_now_i = _i;
						$(_v).removeClass('on');
					}
				});
				
				if(a_now_i==null){
					$($('#email_hint>a')[$('#email_hint>a').length-1]).addClass('on');
					select_email = $($('#email_hint>a')[$('#email_hint>a').length-1]).html();
					
				}else{
					$($('#email_hint>a')[a_now_i-1]).addClass('on');
					select_email = $($('#email_hint>a')[a_now_i-1]).html();
					
				}
				$('#txtEmail').val(select_email);
			break;
			
			case 40:
				var a_now_i = null;
				$('#email_hint>a').each(function(_i,_v){
				if($(_v).attr('class')=='on')
				{
					a_now_i = _i;
					$(_v).removeClass('on');
				}
			});
				if(a_now_i==null){
				$('#email_hint>a:first').addClass('on');
				select_email = $('#email_hint>a:first').html();
				}else{
				$($('#email_hint>a')[a_now_i+1]).addClass('on');
				select_email = $($('#email_hint>a')[a_now_i+1]).html();
				}
				$('#txtEmail').val(select_email);
			break;
			default:
				var mail_fix = ["qq.com","163.com","126.com","sina.com","gmail.com","vip.qq.com","yahoo.com.cn","yahoo.cn","21cn.com","tom.com"];
				var list_html = '<h1 style="font-size:12px;color:#666">请选择邮箱后缀</h1>';
				if($(this).val().length>0)
				{
					list_html+="<a onclick=\"javascript:$('#txtEmail').val('"+$(this).val()+"');$('#email_hint').hide();$('#txtEmail').blur();\" href=\"javascript:;\">"+$(this).val()+"</a>";
				}
				
				for(var i=0; i<mail_fix.length; i++)
				{
					if($(this).val().indexOf('@')<0)
					{
						list_html += ' <a href="javascript:;"  onclick="javascript:$(\'#txtEmail\').val(\''+$(this).val()+'@'+mail_fix[i]+'\');$(\'#email_hint\').hide();$(\'#txtEmail\').blur();">'+$(this).val()+'@'+mail_fix[i]+'</a>';
					}else{
						var mail_a = $(this).val().split('@');
						if(mail_fix[i].indexOf(mail_a[1])==0)
						{
							list_html += ' <a href="javascript:;"   onclick="javascript:$(\'#txtEmail\').val(\''+mail_a[0]+'@'+mail_fix[i]+'\');$(\'#email_hint\').hide();$(\'#txtEmail\').blur();">'+mail_a[0]+'@'+mail_fix[i]+'</a>';
						}
					}
				}
				$('#email_hint').show();
				$('#email_hint').html(list_html);
			break;
		}
	});
}

//设置提交按钮是否处于激活状态
function setBtnOkStatus(){
	var enable=userNameIsRight && txtPwd1IsRight &&txtPwd2IsRight && ddlQuestionIsRight && txtAnswerIsRight && txtEmailIsRight &&txtValidateCodeIsRight &&recommendIsRight && ddlSexIsRight && setCityIsRight;
	if(enable)
	{
		$("#btnOK").removeAttr("disabled");
		$("#btnOK").attr("enable","1");
		$("#btnOk").removeAttr("title");
		$("#btnOK").removeClass().addClass("agreesubmit_ok hover");
	}
	else{
		$("#btnOK").attr("enable","0");
		$("#btnOk").attr("title","请完善以上注册信息后，再提交注册。");
		$("#btnOK").removeClass().addClass("agreesubmit");
		$("#btnOK").attr("disabled","disabled");
	}

}

$(
function(){
	$("#btnOK").click(function()
			{
				$('#email_hint').hide();
					if(mailObj!=null)
					{
						return false;
					}
			
			});
}
)

//设置表单提交时执行的检查
function setFormDefaultState(){
		$("#form1").submit(
		function(e)
		{
			$('#email_hint').hide();
			var enableSubmit=userNameIsRigh && nickNameIsRightt && txtPwd1IsRight &&txtPwd2IsRight && ddlQuestionIsRight && txtAnswerIsRight && txtEmailIsRight &&txtValidateCodeIsRight &&recommendIsRight;//
			if(!$("#read").attr("checked"))
			{
				alert("您必须同意用户服务协议才能进行注册。");
				return false;
			}
			return enableSubmit;
		}
	)
}


//初始化页面控件的样式
function initalStyle(){
	setInputFocusStyle("txtUserName","登录帐号，请保持在4-21个字符内（7个汉字、数字、英文和下划线），注册成功后不可更改。");
	setInputBlurStyle("txtUserName");

	setInputFocusStyle("txtNickName","用于对外显示，可使用英文或中文，不得超过14个字符，注册成功后可更改。");
	setInputBlurStyle("txtNickName");
		
	setInputFocusStyle("txtPwd1","请保持在6-21个字符，推荐使用英文加数字或符号的组合密码。");
	setInputBlurStyle("txtPwd1");
	
	setInputFocusStyle("txtPwd2","请再次输入密码。");
	setInputBlurStyle("txtPwd2");
	setQuestionAndAnswer();

	setInputFocusStyle("recommend_user_id","推荐人可以辅助指导您更好的使用本站，注册本站必须填写推荐人ID，如没有推荐人，可以从右侧随机挑选一个今天活跃的推荐人！</a>");
	setInputBlurStyle("recommend_user_id");

	setInputFocusStyle("txtEmail","请输入您的常用邮箱。");
	setInputBlurStyle("txtEmail");
	
	setValidateCodeStyle();
	
	setFormDefaultState();
	setBtnOKStyle();
	$("#btnOK").attr("disabled","disabled");
	$("#btnOK").attr("enable","0");
}



//设置验证码输入框的样式
function setValidateCodeStyle(){
	$("#txtValidateCode").focus(
	function()
	{
		$(this).removeClass().addClass("vala f2");
		$("#txtValidateCode").siblings("span[class*='tip']").remove();
		$(this).parent().siblings().remove();
	}
	).blur(
		function()
		{
			var code=$.trim($(this).val());
			var flag=code.length>0;
			//删除样式
			$(this).removeClass().addClass("vala");
		}
	)

}

//设置密码提示问题答案获得焦点时的样式
function setQuestionAndAnswer(){
	$("#txtAnswer,#ddlQuestion").focus(
		function()
		{
			$(this).parent().parent().parent().parent().removeClass().addClass("out_on");
			if($(this).attr("id")=="txtAnswer"){$(this).removeClass().addClass("w250 false");}
			if($(this).attr("id")=="txtAnswer")
			{
				$("#txtAnswer").parent().parent().children().remove("p").end().append("<p class=\"text\">请输入2-20位字符。</p>");
			}
			else
			{
				$("#txtAnswer").parent().parent().children().remove("p").end().append("<p class=\"text\">密码提示问题及答案对于保护您的帐号安全极为重要，请您一定要牢记。</p>");
			}
			removeErrorStyle($(this));
			
		}
	).blur(
		function()
		{
			$(this).parent().parent().parent().parent().removeClass();
			$("#txtAnswer").removeClass().addClass("w250");
			$("#txtAnswer").parent().parent().children().remove("p");
		}
	)
}

//设置输入框获得焦点时的样式
function setInputFocusStyle(id,innerText){
	if(id==null ||id.length<=0){
		return;
	}
	
	id="#"+id;
	$(id).focus(
		function(){
			removeErrorStyle($(this));
			//设置当前文本框的样式
			$(this).removeClass().addClass("w250 false");
			if(id=="#txtUserName")
			{
				$(this).addClass("f14");
				//`~~~~~~~~~~~~
		if( longUser != null ){
			document.getElementById("recommend_user_id").readOnly= true;
		}
		if(document.getElementById("recommend_user_id").value != ''){
			setRecommend_user_idBlurCheckFunction();
		};

			}
			//设置当前文本框的所在的父层之父层之父层的样式
			$(this).parent().parent().parent().removeClass().addClass("reg_single on");
			//添加文本内容
			var html="<p class=\"text\">"+innerText+"</p>";
			$(this).parent().parent().children().remove("p").end().append(html);
			if(id != '#recommend_user_id') {
				$("#recommend_user_id").parent().parent().parent().removeClass().addClass("reg_single");
				$("#recommend_user_id").removeClass().addClass("w250");
				$("#recommend_user_id").parent().parent().children().remove("p");
			}else{
				if ( longUser == null ){
					setRecommend_user_idBlurCheckFunction();
					getAjaxRecommendId();
					return;
				};
				if(!recommendIsRight){
					//setRecommend_user_idBlurCheckFunction();
					//推荐人框空和未空
					if(document.getElementById("recommend_user_id").value == ''){
						getAjaxRecommendId();
					}else{
						setTimeout("getAjaxRecommendId();",1500);
					};
				};
				//\\
			}
			
		}
	)
}

//移除经验证的错误样式,inputObj为jquery的对象 
function removeErrorStyle(inputObj){
	inputObj.next("span").remove();
	inputObj.parent().siblings("div[class='tips_box v2']").remove();
}

//设置输入框失去焦点时的样式
function setInputBlurStyle(id){
	if(!id){
		return;
	}
	id="#"+id;
	$(id).blur(
		function(){
			if(id != '#recommend_user_id') {
				//设置当前文本框的样式
				$(this).removeClass().addClass("w250");
				//设置当前文本框的所在的父层之父层之父层的样式
				$(this).parent().parent().parent().removeClass().addClass("reg_single");
				//删除提示文本
				$(this).parent().parent().children().remove("p");
			}else{
				//设置当前文本框的所在的父层之父层之父层的样式
				$(this).parent().parent().parent().removeClass().addClass("reg_single");
				//删除提示文本
				$(this).parent().parent().children().remove("p");
				//设置当前文本框的样式
				$(this).removeClass().addClass("w250");
				if($(id).val() !=  ''){
					setRecommend_user_idBlurCheckFunction();
				}else{
					//$("#recommend_user_id").parent().next("div[class='tips_rbox v2'],div.tips_rbox").remove();
					//setTimeout('$("#recommend_user_id").parent().next("div[class=\'tips_rbox v2\'],div.tips_rbox").remove();',1500);
					//setErrorTip("recommend_user_id","请输入推荐人ID。");
					recommendIsRight =false ;
				}
				
			}
		}
	)
	
}

//设置提交按钮的样式
function setBtnOKStyle(){
	$("#btnOK").hover(
	function()
	{
		if($(this).attr("enable")=="1")
		{
			$(this).removeClass().addClass("agreesubmit_ok hover");
		}
		
	},function()
	{
		if($(this).attr("enable")=="1")
		{
			$(this).removeClass().addClass("agreesubmit_ok");
		}
		
	}
	).click(
		function()
		{
			if($(this).attr("enable")=="1")
			{
				$(this).removeClass().addClass("agreesubmit_ok hover click");
			}
		}
	)
}

//设置用户名输入框失去焦点时的执行的相关检查
function setUserNameBlurCheckFunction(){
	$("#txtUserName").blur(
		function(){
			var userName=$(this).val();
			
			userNameCache=userName;
			var errorMessage="";//定义一个错误消息
			if(userName.length<=0)
			{
				errorMessage="请输入用户名。";
				setErrorTip("txtUserName",errorMessage);
				userNameIsRight=false;
				setBtnOkStatus();
				$(this).addClass("f14");
				return;
			}
			else{
				//进行正则表达式的检查
				var pattern=/^[\w\u4e00-\u9fa5]{4,14}$/;
				if(!pattern.test(userName))
				{
					errorMessage="4-14字符或2-7个中文内，不能包含非法字符。";
					setErrorTip("txtUserName",errorMessage);
					userNameIsRight=false;
					setBtnOkStatus();
					$(this).addClass("f14");
					return;
				}
			}

			//执行ajax检查 验证用户名，是否已经存在
			$.get(strAjaxUrlPre+"/mcenter/check_user.php",{pname:"user_name",random:Math.random(),pvalue:encodeURIComponent(userName)},function(data)
			{	
				if(data=="1")//检查正确
				{
					removeErrorStyle($("#txtUserName"));
					$("#txtUserName").after(rightIcon);
					userNameIsRight=true;
					setBtnOkStatus();
					$("#txtUserName").addClass("f14");
					if ( longUser == null ){
						document.getElementById("recommend_user_id").readOnly=false;
					return;
					}
					if ( longUser != null ){
						document.getElementById("recommend_user_id").readOnly= true;
					return;
					}
					document.getElementById("recommend_user_id").readOnly= true;//注意大小写
					
				}
				else{//检查失败
					setErrorTip("txtUserName",data);
					userNameIsRight=false;
					setBtnOkStatus();
					$("#txtUserName").addClass("f14");
				}
			})
		}
	)
}

//设置昵称输入框失去焦点时的执行的相关检查
function setNickNameBlurCheckFunction(){
	$("#txtNickName").blur(
		function(){
			var nickName=$(this).val();
			
			nickNameCache=nickName;
			var errorMessage="";//定义一个错误消息
			if(nickName.length<=0)
			{
				errorMessage="请输入昵称。";
				setErrorTip("txtNickName",errorMessage);
				nickNameIsRight=false;
				setBtnOkStatus();
				$(this).addClass("f14");
				return;
			}
			else{
				//进行正则表达式的检查
				var pattern=/^[\w\u4e00-\u9fa5]{4,14}$/;
				if(!pattern.test(nickName))
				{
					errorMessage="4-14字符或2-7个中文内，不能包含非法字符。";
					setErrorTip("txtNickName",errorMessage);
					nickNameIsRight=false;
					setBtnOkStatus();
					$(this).addClass("f14");
					return;
				}else{
					setRightIcon("txtNickName");
					nickNameIsRight=true;
					setBtnOkStatus();
				}
			}

		}
	)
}

//设置推荐人输入框失去焦点时的执行的相关检查
function setRecommend_user_idBlurCheckFunction(){
	var x = $("#recommend_user_id").val();
	var regs = /^\d\d*$/;

	if(x == "" || x==null){
		$("#recommend_user_id").parent().next("div[class='tips_rbox v2'],div.tips_rbox").remove();
		setErrorTip("recommend_user_id","推荐人的ID,必须输入或者选择!");
		$("#recommend_user_id").addClass("s250");
		recommendIsRight=false;
		setBtnOkStatus();
	}else if(regs.test(x) == false){
		$("#recommend_user_id").parent().next("div[class='tips_rbox v2'],div.tips_rbox").remove();
		setErrorTip("recommend_user_id","推荐人的ID,必须输入有效的数字!");
		$("#recommend_user_id").addClass("s250");
		recommendIsRight=false;
		setBtnOkStatus();
	}else{
		//执行ajax检查 验证推荐人，是否已经存在
		$.get(strAjaxUrlPre+"/mcenter/check_user.php",{pname:"recommend_user_id",random:Math.random(),pvalue:x},function(data)
		{	
			if(data=="1")//检查正确
			{
				$("#recommend_user_id").parent().next("div[class='tips_rbox v2'],div.tips_rbox").remove();
				setInputBlurStyle("recommend_user_id");
				recommendIsRight=true;
				setBtnOkStatus();
				setRightIcon("recommend_user_id");
					if ( longUser == null ){
						document.getElementById("recommend_user_id").readOnly=false;
					return;
					}
					if ( longUser != null ){
						document.getElementById("recommend_user_id").readOnly= true;
					}
					document.getElementById("recommend_user_id").readOnly= true;//注意大小写
			}else{//检查失败
				$("#recommend_user_id").parent().next("div[class='tips_rbox v2'],div.tips_rbox").remove();
				setErrorTip("recommend_user_id",data);
				recommendIsRight=false;
				setBtnOkStatus();
				$("#recommend_user_id").addClass("s250");
			}
		})
		
	}
}

//设置错误提示
function setErrorTip(id,errorMessage){
	id="#"+id;
	$(id).removeClass().addClass("w250 false_2");
	removeErrorStyle($(id));
	$(id).after(errorIcon);
	if($(id).parent().next("div[class='tips_box v2'],div.tips_box").length>0)
	{
			$(id).parent().next("div[class='tips_box v2'],div.tips_box").remove();
	}
	$(id).parent().after("<div class=\"tips_box v2\"><span class=\"w300\">"+errorMessage+"</span></div>");
}

//设置性别的失去焦点事件
function setDDLSexBlur(){
	$("#ddlSex").blur(
		function()
		{
			if($(this).val()=="0")
			{
				setErrorTip("ddlSex","请正确选择性别，选定后将无法修改！");
				$(this).addClass("s250");
				ddlSexIsRight=false;
				setBtnOkStatus();
			}
			else{
				removeErrorStyle($("#ddlSex"));
				ddlSexIsRight=true;
				setBtnOkStatus();
				setRightIcon("ddlSex");
			}
		}
	);
}
//省份下拉框事件
function setCity(optobj){
	$inp = $("#setcity").parent();
	val = $(optobj).parent().next().find("select").val();
	if(val=="")
	{
		errorMessage = '请选择所在城市！';
		$inp.removeClass().addClass("w250 false_2");
		removeErrorStyle($("#setcity"));
		$("#setcity").after(errorIcon);
		if($inp.parent().next("div[class='tips_box v2'],div.tips_box").length>0)
		{
			$inp.parent().next("div[class='tips_box v2'],div.tips_box").remove();
		}
		$inp.parent().after("<div class=\"tips_box v2\"><span class=\"w300\">"+errorMessage+"</span></div>");

		setCityIsRight=false;
		setBtnOkStatus();
	}
	else{
		removeErrorStyle($inp);
		setCityIsRight=true;
		setBtnOkStatus();
		setRightIcon("setcity");
	}
}
//城市下拉框事件
function setCity2(val){
	$inp = $("#setcity").parent();
	if(val=="")
	{
		errorMessage = '请选择所在城市！';
		$inp.removeClass().addClass("w250 false_2");
		removeErrorStyle($("#setcity"));
		$("#setcity").after(errorIcon);
		if($inp.parent().next("div[class='tips_box v2'],div.tips_box").length>0)
		{
			$inp.parent().next("div[class='tips_box v2'],div.tips_box").remove();
		}
		$inp.parent().after("<div class=\"tips_box v2\"><span class=\"w300\">"+errorMessage+"</span></div>");

		setCityIsRight=false;
		setBtnOkStatus();
	}
	else{
		removeErrorStyle($inp);
		setCityIsRight=true;
		setBtnOkStatus();
		setRightIcon("setcity");
	}
}

//检查密码输入框
function checkPassword(){
	$("#txtPwd1").blur(
		function()
		{
			var pwd=$(this).val();
			if(pwd.length<=0)
			{
				setErrorTip("txtPwd1","请输入登录密码。");
				txtPwd1IsRight=false;
				setBtnOkStatus();
				return;
			}
			if(pwd.length<6 || pwd.length>20)
			{
				setErrorTip("txtPwd1","请保持在6-21字符内。");
				txtPwd1IsRight=false;
				setBtnOkStatus();
				return;
			}
			
			if(!checkPasswordRule())
			{
				txtPwd1IsRight=false;
				setBtnOkStatus();
				return;
			}
			
			txtPwd1IsRight=true;
			setBtnOkStatus();
			
			removeErrorStyle($(this));
			//在这里添加密码安全性提示
			setRightIcon("txtPwd1");
			checkPwdSecurityLevel();
			checkRepeatPassword();
					
		}
	).keyup(
	function(){
		checkPasswordRule();
		}
	)
}

//检查密码的安全等级 
function checkPwdSecurityLevel(){
	var pwd=$("#txtPwd1").val();
	var level=0;
	if(/\d+/.test(pwd))
	{
		level++;
	}
	
	if(/[a-zA-Z]+/.test(pwd))
	{
		level++;
	}
	
	if(/[^a-zA-Z\d]+/.test(pwd))
	{
		level++;
	}
	
	var lowHtml="<div class=\"tips_box\"><span class=\"s1\"><a id=\"pass_s\" href=\"javascript:;\">密码安全性</a><em class=\"s1\"></em>弱</span></div>";
	var middleHtml="<div class=\"tips_box\"><span class=\"s2\"><a id=\"pass_s\" href=\"javascript:;\">密码安全性</a><em class=\"s2\"></em>中</span></div>";
	var highHtml="<div class=\"tips_box\"><span class=\"s3\"><a id=\"pass_s\" href=\"javascript:;\">密码安全性</a><em class=\"s3\"></em>强</span></div>";
	var html;
	switch(level)
	{
		case 1://安全等级低
			html=lowHtml;
			break;
		case 2://安全等级中
			html=middleHtml;
		break;
		case 3://安全等级高
			html=highHtml;
		break;
		default:break;
	}
	$("#txtPwd1").parent().next("div.tips_box").remove().end().after(html);
	$("#pass_s").hover(function(){
	var leftPosition=$(this).position().left+40;
	var topPostion=$(this).position().top-30;
	$("#pass_s_tips").show("fast").css({left:leftPosition,top:topPostion,position:'absolute'});
	},function(){$("#pass_s_tips").hide("fast");});

}


//检查密码的规则
function checkPasswordRule(){
	var pwd=$("#txtPwd1").val();
	//密码中含有字符
	if(pwd.indexOf(" ")!=-1)
	{
		setErrorTip("txtPwd1","密码不能使用空格，请更换密码。");
		txtPwd1IsRight=false;
		setBtnOkStatus();
		return false;
	}
	
	if(pwd.length>=6)//如果密码大于等于4时，检测是否有重复
	{
		var repeatPattern=/(.)\1{3,19}/;
		if(repeatPattern.test(pwd))
		{
			setErrorTip("txtPwd1","密码不允许使用连续字符，请更换密码。");
			txtPwd1IsRight=false;
			setBtnOkStatus();
			return false;
		}
	}
	txtPwd1IsRight=true;
	setBtnOkStatus();
	return true;
}
	
//检查重复密码	
function checkRepeatPwd(){
	$("#txtPwd2").blur(function(){checkRepeatPassword();})
}

function checkRepeatPassword(){
	if($("#txtPwd2").val().length<=0)
	{
		setErrorTip("txtPwd2","请再次输入密码。");
		txtPwd2IsRight=false;
		setBtnOkStatus();
		return;
	}
	
	if($("#txtPwd2").val()!=$("#txtPwd1").val())
	{
		setErrorTip("txtPwd2","2次输入密码输入不一致。");
		txtPwd2IsRight=false;
		setBtnOkStatus();
		return;
	}
	txtPwd2IsRight=true;
	setBtnOkStatus();
	setRightIcon("txtPwd2");
}

//检测正确后，设置正确的图标
function setRightIcon(id){
	id="#"+id;
	$(id).next("span").remove();
	$(id).after(rightIcon);
}

//设置密码提示问题的失去焦点事件
function setDDLQuestionBlur(){
	$("#ddlQuestion").blur(
		function()
		{
			if($(this).val()=="0")
			{
				setErrorTip("ddlQuestion","请选择密码提示问题。");
				$(this).addClass("s250");
				ddlQuestionIsRight=false;
				setBtnOkStatus();
			}
			else{
				ddlQuestionIsRight=true;
				setBtnOkStatus();
				setRightIcon("ddlQuestion");
			}
		}
	);
	
	$("#txtAnswer").blur(
	function()
	{
		var answer=$(this).val();
		if(answer.length<=0)
		{
			setErrorTip("txtAnswer","请输入密码提示问题答案。");
			$(this).parent().siblings("p").text("请输入2-20位字符。");
			txtAnswerIsRight=false;
			setBtnOkStatus();
			return;
		}
		
		var isLaw=/^[\w\u4e00-\u9fa5]{2,20}$/.test(answer);
		if(!isLaw)
		{
			setErrorTip("txtAnswer","请输入2-20位字符。");
			txtAnswerIsRight=false;
			setBtnOkStatus();
			return;
		}
		$(this).parent().siblings("div[class='tips_box v2']").remove();
		setRightIcon("txtAnswer");
		txtAnswerIsRight=true;
		setBtnOkStatus();
		
		}
	);
}

//设置电子邮箱的失去焦点时检查
function setEmailBlur(){
	$("#txtEmail").blur(
		function()
		{
			var email=$(this).val();
			if(email.length<=0)
			{
				setErrorTip("txtEmail","请输入您的常用邮箱。");
				txtEmailIsRight=false;
				setBtnOkStatus();
				return;
			}
			
			var emailPattern=/^[_\.0-9a-z-]+@[_\.0-9a-z\-]+\.(com|cc|cn|tv|hk|name|mobi|net|biz|org|info|gov\.cn|com\.cn|net\.cn|org\.cn)$/;
			if(!emailPattern.test(email))
			{
				setErrorTip("txtEmail","请输入正确格式的邮箱。");
				txtEmailIsRight=false;
				setBtnOkStatus();
				return;
			}

			//执行ajax检查 验证email，是否已经存在
			$.get(strAjaxUrlPre+"/mcenter/check_user.php",{pname:"vemail",random:Math.random(),pvalue:email},function(data)
			{
				if(data=="1")//检查正确
				{
					setRightIcon("txtEmail");
					$("#txtEmail").parent().next().remove();
					txtEmailIsRight=true;
					mailObj=null;
					setBtnOkStatus();
				}else{//检查失败
					setErrorTip("txtEmail",data);
					txtEmailIsRight=false;
					setBtnOkStatus();
				}
			})			
		}
	)
}

// Ajax 调用随机推荐人的id
// @author	嬴益虎(whoneed@163.com)
function getAjaxRecommendId(){
	if(recommendIsRight){
	return;
	}
	// 取得随机推荐的会员相关数据
	$.get(strAjaxUrlPre+"/mcenter/get_recommend_user_id.php",{random:Math.random()},function(data)
	{			
		// 判断是否正确返回
		if(data == 'error' || data == ''){
			setErrorTip("recommend_user_id","没有网站推荐的推荐人");
		}else{
			var objUserTemp = data.split(';');
			var intLen		= objUserTemp.length;
			var objTemp		= '';
			var strMessage	= '';

			for(var i=0; i<intLen; i++){
				objTemp = objUserTemp[i].split(':');
				strMessage += "<a href='javascript:chooseRecommendId("+objTemp[0]+");' title='我是 "+objTemp[2]+" ,选择我吗?'><img src='"+strAjaxUrlPre+"/uploadfile/mcenter/s/"+objTemp[1]+"' width='25' height='30' border='0' /></a>&nbsp;" ;
			}
			
			id="#recommend_user_id";
			$(id).removeClass().addClass("w250 false_2");
			removeErrorStyle($(id));
			if($(id).parent().next("div[class='tips_rbox v2'],div.tips_rbox").length>0){
				$(id).parent().next("div[class='tips_rbox v2'],div.tips_rbox").remove();
			}
			$(id).parent().after("<div class=\"tips_rbox v2\"><span class=\"w200\">"+strMessage+" <span style='background:none;line-height:15px;position:relative'><a href='javascript:getAjaxRecommendId();' >点此随机更换推荐人</a><br />点击U客头像选择</span></span></div>");
		}
	});
}

// 选择推荐的U客
// @author	嬴益虎(whoneed@163.com)
function chooseRecommendId(strUserId){
	id="#recommend_user_id";
	$(id).val(strUserId);

	$(id).removeClass().addClass("w250");
	$(id).parent().parent().parent().removeClass().addClass("reg_single");
	$(id).parent().parent().children().remove("p");
	$(id).parent().next("div[class='tips_rbox v2'],div.tips_rbox").remove();

	recommendIsRight=true;
	setBtnOkStatus();
	setRightIcon("recommend_user_id");
					if ( longUser == null ){
						document.getElementById("recommend_user_id").readOnly=false;
					return;
					}
					if ( longUser != null ){
						document.getElementById("recommend_user_id").readOnly= true;
					}
	document.getElementById("recommend_user_id").readOnly= true;//注意大小写
}

function showValidateCodeError(errorMessage){
	$("#txtValidateCode").removeClass().addClass("vala f");
	$("#txtValidateCode").siblings("span[class*='tip']").remove();
	$("#txtValidateCode").parent().append("<span class=\"tip_wrong\"></span>");
	$("#txtValidateCode").parent().next().remove();
	$("#txtValidateCode").parent().after("<div class=\"tips_box v2\"><span class=\"w300\">"+errorMessage+"</span></div>");

}

function setValidateCodeRight(){
	$("#txtValidateCode").siblings("span[class*='tip']").remove();
	$("#txtValidateCode").parent().append("<span class=\"tip_right\"></span>");
}

function checkValidateCode(){
	var vcode=$("#txtValidateCode").val();

	if(vcode.length<=0)
	{
		showValidateCodeError("请输入验证码。");
		txtValidateCodeIsRight=false
		setBtnOkStatus();
		return;
	}
	
	if(vcode.length>0 && vcode.length<4)
	{
		showValidateCodeError("输入错误，请重新输入。");
		txtValidateCodeIsRight=false
		setBtnOkStatus();
		return;
	}
	//var f=/^[\da-zA-Z]{4}$/.test(vcode);
	/*
	if(!f)
	{
		alert(f);
		showValidateCodeError("输入错误，请重新输入。");
		txtValidateCodeIsRight=false
		setBtnOkStatus();
		return;
	}
	*/

	//执行ajax检查 验证验证码，是否正确
	$.get(strAjaxUrlPre+"/mcenter/check_user.php",{pname:"vcode",random:Math.random(),pvalue:vcode},function(data)
	{
		if(data=="1")//检查正确
		{
			txtValidateCodeIsRight=true;
			setBtnOkStatus();
			$("#txtValidateCode").parent().next().remove();
			setValidateCodeRight();
		}else{//检查失败
			showValidateCodeError("输入错误，请重新输入。");
			txtValidateCodeIsRight=false
			setBtnOkStatus();
			return;
		}
	})

}

//设置验证码输入框的事件
function setValidateCode(){
	$("#txtValidateCode").keyup(
		function()
		{	
			if($(this).val().length<8)
			return;
			checkValidateCode();
		}
	).blur(function(){checkValidateCode();})
}




//输出用户名的错误消息
function showUserNameErrorMessage(message){
	alert(message);
	return;
}
//输出密码的错误 消息
function showPwdErrorMessage(message){
	alert(message);
	return;
}
//输出密码提示问题和答案的错误消息
function showQAErrorMessage(message){
	alert(message);
	return;
}

//输出电子邮箱的错误消息
function showEmailErrorMessage(message){
	alert(message);
	return;
}
//输出验证码的错误消息
function showValCodeErrorMessage(message){
	alert(message);
	return;
}

function showRegisterErrorMessage(message){
	alert(message);
	return;
}

	
	
