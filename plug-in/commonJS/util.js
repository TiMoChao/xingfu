var domain = "";
function setDefaultInput(id,msg){
    var txtObj = $("#"+ id);

    var defObj;
    if($.trim(txtObj.attr("type")).toUpperCase() =="PASSWORD"){
        txtObj.after('<input type="text" id="def_'+id+'" />');
        defObj = $("#def_"+id);
        defObj.val(msg);
        defObj.attr("style", txtObj.attr("style") );
        defObj.attr("name", "def_" + txtObj.attr("name") );
        defObj.attr("class", txtObj.attr("class") );
        defObj.attr("size", txtObj.attr("size") );
        defObj.css("color","#BEBEBE");
    }else{
        defObj = txtObj.clone();
        defObj.attr("name","def_" + txtObj.attr("name"));
        defObj.attr("id","def_" + id);
        defObj.val(msg);
        defObj.css("color", "#BEBEBE");
        txtObj.after(defObj);
    }

    txtObj.hide();
    defObj.show();

    var removeDefObj = function(){
        defObj.remove();
        txtObj.show();
        txtObj.focus();
    };

    defObj.focus(removeDefObj);

    txtObj.blur(function(){
        if(txtObj.val()==""){
            txtObj.hide();
            txtObj.after(defObj);
            defObj.focus(removeDefObj);
            defObj.show();
        }
    });

    if(txtObj.val() !=""){
        defObj.remove();
        txtObj.show();
    };
}


function loadSysMsg(){
    $.post(domain+"/sysmsg/ajax.php?act=load",{},function(data){
        if(data!=""&&data!=undefined){
            var html = '<div class="messages_tips"><a class="close" href="javascript:void(0)" onclick="FixedLayer.hide()" title="关闭">关闭</a>'+
                    '<span class="messages_tips_list">' + data + '</span></div>';
            FixedLayer.show(html,{top:0,min_top:30,right:220,width:148});
        }
    },"html");
}

function cleanAllSysMsg(id){
    $.post(domain+"/sysmsg/ajax.php?act=clean",{},function(data){
        $("#"+id).hide();
    },"html");
}



function isEmail(strEmail) {
    if (strEmail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1) return true;
    else return false;
}



var LoginDialog = {
    show:function(){
        var msg = '<div class="tc_login"><form id="login_frm_1" action="'+domain+'"/user/login.php" method="post"><ul>';
        msg += '        <li class="error" style="display:none">Email地址\昵称或密码输入错误，请重新填写。</li>';
        msg += '        <li><span class="login_txt">邮箱地址：</span>';
        msg += '            <input name="User" type="text" class="input_bk" id="User_1" value="" />';
        msg += '        </li><li><span class="login_txt">密 码：</span>';
        msg += '            <input class="input_bk" type="password" name="Pass" id="Pass_1" />';
        msg += '        </li><li><span class="login_txt">&nbsp;</span>';
        msg += '            <input name="remenber" type="checkbox" id="remenber" checked="checked" /><label for="remenber">记住我</label>';
        msg += '        </li><li><span class="login_txt">&nbsp;</span>';
        msg += '            <input class="login_btn" onMouseOver="this.className=\'login_btn_hover\';" onMouseOut="this.className=\'login_btn\';" type="button" onclick="LoginDialog.login()" name="button2" id="button2" value=" " />';
        msg += '        &nbsp;<a href="'+domain+'/user/forgotten.php">忘记密码？</a></li>';
        msg += '        <li><div class="line"></div></li>';
        msg += '        <li><span class="login_txt">&nbsp;</span>还不是也瘦网会员 <a href="'+domain+'/user/regin.php"><img src="/templates/2/images/tc_btn02.jpg" alt="立即注册" width="62" height="24" align="absmiddle" /></a></li>';
        msg += '    </ul></form></div>';
        Win.dialog({
            'msg':msg,
            button: '<span></span>',
            align:"center",
            width:480,
            height:350,
            type:'alert',
            title:'登录'
        });
		$("#login_frm_1 #User_1").bind('focus', LoginDialog._onFocus);
		$("#login_frm_1 #User_1").bind('blur', LoginDialog._onBlur);
		$("#login_frm_1 #Pass_1").bind('focus', LoginDialog._onFocus);
		$("#login_frm_1 #Pass_1").bind('blur', LoginDialog._onBlur);
        setDefaultInput("User_1","输入邮箱地址");
    },
	
	_onFocus: function(){
		$(this).removeClass("input_bk");
        $(this).addClass("input_bk_c");
	},
	
	_onBlur: function(){
		$(this).removeClass("input_bk_c");
        $(this).addClass("input_bk"); 
	},

    login: function(){
        $.post(domain+"/user/ajax.php?d="+Math.random(),{
            User:$.trim($("#User_1").val()),
            Pass:$("#Pass_1").val()
        },function(data){
            if(Number(data)==0){
                $(".error").html("Email地址\昵称或密码输入错误，请重新填写。")
                $(".error").show();
                $("#User_1").focus();
                if(typeof(LoginDialog.loginFail)=="function"){
					LoginDialog.loginFail();
				}
				else if(typeof(LoginDialog.loginFail)=="string"){
                    eval(LoginDialog.loginFail);
				}
            }else{
                $(".error").hide();
                if(typeof(LoginDialog.loginSuccess)=="function"){
                    window.location.reload();
					//LoginDialog.loginSuccess();
				}
				else if(typeof(LoginDialog.loginSuccess)=="string"){
                    eval(LoginDialog.loginSuccess);
				}
            }
        },"text");
    },

    loginSuccess : function(){  
        window.location.reload();
    },

    loginFail: function(){},


	checkLogin: function (isLoginHander){
		$.post(domain+"/mblog/supervision.php?act=chklogin",{},function(data){
            switch(Number(data.status)){
                case 1:
					if(typeof(isLoginHander)=="function"){
						isLoginHander();
					}
					else if(typeof(isLoginHander)=="string"){
						eval(isLoginHander);
					}
                    break;
                default:
                    LoginDialog.loginSuccess = isLoginHander;
					LoginDialog.show();
                    break;
            };
        },"json");
	}
}

function getEvent(event) {
    var ev = event || window.event;
    if (!ev) {
        var c = this.getEvent.caller;
        while (c) {
           ev = c.arguments[0];
           if (ev && (Event == ev.constructor || MouseEvent  == ev.constructor)) {
                break;
            }
            c = c.caller;
        }
    }
    return ev;
}


/**
 * params width,height,autoClose
 */
var Pop = {
    _pop_id:"_common_pop",
    _params: {},
    open:function(msg,params){
        if(typeof(params.width)=="undefined") params.width = 180;
        if(typeof(params.height)=="undefined") params.height = 35;
        if(typeof(params.autoClose) == "undefined") params.autoClose = false;

        if(typeof(params.mx) != "undefined"){
            var mx = params.mx;
        }else{
            var ev = getEvent();
            var mx = ev.pageX ? ev.pageX : ev.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
        }
        if(typeof(params.my) != "undefined"){
            var my = params.my;
        }else{
            var ev = getEvent();
            var my = ev.pageY ? ev.pageY : ev.clientY + document.documentElement.scrollTop + document.body.scrollTop;
        }
        var x = Math.max(0, mx - (params.width / 2) );
        var y = my - params.height - 40;
        if( y < 0 ){
            y = my + params.height + 40;
        }

        Pop._params = params;
        _msg = '<div id="'+Pop._pop_id+'" class="common_pop" style="background:white;position:absolute;left:'+x+'px;top:'+y+'px;width:'+params.width+'px; height:'+params.height+'px;display:none">' +
            msg + "</div>";
        Pop.close(false);
        $("body").append(_msg);
        Pop._show();
    },

    close:function(animation){
        if($("#"+Pop._pop_id).attr("id") == Pop._pop_id){
            if(typeof(animation)!= 'boolean') animation = true;
            if(animation){
                $("#"+Pop._pop_id).slideUp("slow");
            }
            $("#"+Pop._pop_id).remove();
        }
    },

    _show:function(){
        $("#"+Pop._pop_id).slideDown("slow", function(){
            if(typeof(Pop._params.autoClose)!='undefined' && Pop._params.autoClose == true){
                setTimeout(Pop.close,1500);
            }
        });
    }
}

var Layer = {
    _layer_id:"_common_layer",
    _params: {},
    _showing:false,
    show:function(html,params){
        if(typeof(params)=='undefined') params = {};
        if(typeof(params.width)=="undefined") params.width = 180;
        if(typeof(params.x)=="undefined") params.x = 0;
        if(typeof(params.y)=="undefined") params.y = 0;
        if(typeof(params.opt) == "undefined") params.opt = "click";

        Layer._params = params;
        _html = '<div id="'+Layer._layer_id+'" style="z-index:10000;background:white;position:absolute;left:'+params.x+'px;top:'+params.y+'px;width:'+params.width+'px;display:none">' +
            html + '<div class="clr"></div></div>';

        Layer.hide();
        $("body").append(_html);

        $("#"+Layer._layer_id).show();
        Layer._showing = true; //确定下面的单击事件第一次不执行
        $(document).bind(params.opt, Layer._onClick);
    },

    _onClick:function(event){
        if(Layer._showing){
            Layer._showing = false;
            return;
        }
        var target = event.target || event.srcElement;
        if(fInObj(target,Layer._layer_id) == false){
            Layer.hide();
        }
    },

    hide:function(){
        if($("#"+Layer._layer_id).attr("id") == Layer._layer_id){
            $(document).unbind(Layer._params.opt, Layer._onClick);
            $("#"+Layer._layer_id).remove();
        }
    }
    
}

var FaceLayer = {
    _inputId:"",
    show:function(inputId){
        FaceLayer._inputId = inputId;
        var faces = [
            {icon:"冷笑话",value:"[冷笑话]",src:"jokes.gif"},
            {icon:"洗澡",value:"[洗澡]",src:"wash.gif"},
            {icon:"学习",value:"[学习]",src:"study.gif"},
            {icon:"拆弹",value:"[拆弹]",src:"chaidan.gif"},
            {icon:"丢垃圾",value:"[丢垃圾]",src:"diulaji.gif"},
            {icon:"拐带",value:"[拐带]",src:"guaidai.gif"},
            {icon:"恢复",value:"[恢复]",src:"huifu.gif"},
            {icon:"疗伤",value:"[疗伤]",src:"liaoshang.gif"},
            {icon:"泻药",value:"[泻药]",src:"xieyao.gif"},
            {icon:"咬人",value:"[咬人]",src:"yaoren.gif"},
            {icon:"炸弹",value:"[炸弹]",src:"zhadan.gif"}
        ];
        var html = '<div class="facepanel"><span class="jt"></span><ul>';
            for(var i=0; i<faces.length;i++){
                html += '<li><a href="javascript:void(0)" onclick="FaceLayer.selIcon(\''+faces[i].value+'\')" title="'+faces[i].icon+'"><img src="'+domain+'/plug-in/face/'+faces[i].src+'"/></a></li>';
            }
            html += '</ul></div>';

        var ev = getEvent();
        var  target =  ev.target || ev.srcElement;
        var pos = findPosition(target);

        Layer.show(html,{x:pos[0],y:pos[3]+5});
    },

    selIcon:function(value){
        if(FaceLayer._inputId!="" && $("#"+FaceLayer._inputId).attr("id") == FaceLayer._inputId ){
            var txtElem = document.getElementById(FaceLayer._inputId);
            range = txtElem.getAttribute("range") ? txtElem.getAttribute("range").split("|") : [0, 0];
            var str_1 = txtElem.value.slice(0, range[0]);
            var str_2 = txtElem.value.slice(range[1]);
            txtElem.value = str_1 + value + str_2;
            if(!document.selection) {
                txtElem.selectionStart = txtElem.value.length;
                txtElem.selectionEnd = txtElem.value.length;
            } else {
                var range = txtElem.createTextRange();
                range.collapse(1);
                range.moveStart("character", txtElem.value.length);
                range.moveEnd("character", txtElem.value.length);
                range.select();
            }
            txtElem.focus();
        }

        Layer.hide();
    },

    linkToFlag:function(content){
        var re = /<img style=['|"]vertical-align: middle;['|"] title=['|"]([^'|^"]+)['|"] src=['|"]([^'|^"]+)['|"][\/]{0,1}>/g;
        content = content.replace(re,"[$1]");
        return content;
    }
}

function savePos(event) {
    var elem = event.target || event.srcElement;
    var range = getRange(elem);
    elem.setAttribute("range", range.join("|"));
}


function getRange(elem) {
    var start = 0, end = 0;

    if(!document.selection) {
        start = elem.selectionStart;
        end = elem.selectionEnd;
    } else if(document.selection) {
        var range = document.selection.createRange(),
        range_all = document.body.createTextRange(),
        i = 0;

        range_all.moveToElementText(elem);

        for(; range_all.compareEndPoints("StartToStart", range) < 0; start++) {
            range_all.moveStart('character', 1);
        }

        for(; i<start; i++) {
            if(elem.value.charAt(i) == "\n") {
                start++;
            }
        }

        range_all = document.body.createTextRange();
        range_all.moveToElementText(elem);

        for(; range_all.compareEndPoints('StartToEnd', range) < 0; end++) {
            range_all.moveStart('character', 1);
        }

        for(i=0; i <= end; i++) {
            if(elem.value.charAt(i) == "\n") {
                end++;
            }
        }
    }
    return [start, end];
}

function fInObj(obj,id){
    while(obj){
        if(obj.id == id) return true;
        obj = obj.offsetParent;
    }
    return false;
}

function findPosition( oElement )
{
  var x2 = 0;
  var y2 = 0;
  var width = oElement.offsetWidth;
  var height = oElement.offsetHeight;
  if( typeof( oElement.offsetParent ) != 'undefined' )
  {
    for( var posX = 0, posY = 0; oElement; oElement = oElement.offsetParent )
    {
      posX += oElement.offsetLeft;
      posY += oElement.offsetTop;
    }
    x2 = posX + width;
    y2 = posY + height;
    return [ posX, posY ,x2, y2];

    } else{
      x2 = oElement.x + width;
      y2 = oElement.y + height;
      return [ oElement.x, oElement.y, x2, y2];
  }
}




function chkLength(){
    var s=$id('intro_con').value.length+1;
    if(s>300) $id('intro_con').value=$id('intro_con').value.substr(0,160-1);
    else $id('num_span').innerHTML=160-(s-1);
}

/**
     * 只能输入数字和小数点的方法
     */
function clearNoNum(obj)
{
    //先把非数字的都替换掉，除了数字和.
    obj.value = obj.value.replace(/[^\d.]/g,"");
    //必须保证第一个为数字而不是.
    obj.value = obj.value.replace(/^\./g,"");
    //保证只有出现一个.而没有多个.
    obj.value = obj.value.replace(/\.{2,}/g,".");
    //保证.只出现一次，而不能出现两次以上
    obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
}

function checkNumFormate(val, type){
    switch(type){
        case "int": //整数
            var reg = /^-?[1-9]\d*$/;
            return reg.test(val);
            break;
        case "pint": //正整数
            var reg = /^[1-9]\d*$/;
            return reg.test(val);
            break;
        case "nint": //负整数
            var reg = /^-[1-9]\d*$/;
            return reg.test("190");
            break;
        case "float":
            var reg = /^-?([1-9]\d*.\d*|0.\d*[1-9]\d*|0?.0+|0)$/;
            return reg.test(val);
            break;
        case "pfloat":
            var reg = /^[1-9]\d*.\d*|0.\d*[1-9]\d*$/;
            return reg.test(val);
            break;
        case "nfloat":
            var reg = /^-([1-9]\d*.\d*|0.\d*[1-9]\d*)$/;
            return reg.test(val);
            break;
        default:
            return false;
            break;
    }
}

function inInterval(val,min_val,max_val){
    return (val >= min_val && val<=max_val);
}


