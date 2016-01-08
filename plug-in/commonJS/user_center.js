/*
*	Ajax 修改，保存 用户中心会员资料
*	@author	 嬴益虎 whoneed@163.com
*/
var oldElementValue;
var arrOldValue = new Array();　//创建一个数组,保存默认修改前的值

//点击修改 文本框
function inputModify(menuid)
{
	//oldElementValue = jQuery("#"+menuid).val();
	arrOldValue[menuid] = jQuery("#"+menuid).val();
	jQuery("#"+menuid+"_save").show();
	jQuery("#"+menuid+"_cancel").show();
	jQuery("#"+menuid+"_modify").hide();
	
	jQuery("#"+menuid).css("border","1px solid");
	jQuery("#"+menuid).removeAttr("readonly");
}

//点击取消 文本框
function inputCancel(menuid)
{
	//jQuery("#"+menuid).val(oldElementValue);
	jQuery("#"+menuid).val(arrOldValue[menuid]);
	jQuery("#"+menuid+"_save").hide();
	jQuery("#"+menuid+"_cancel").hide();
	jQuery("#"+menuid+"_modify").show();
	
	jQuery("#"+menuid).css("border","0px solid");
	jQuery("#"+menuid).attr("readonly","true");
}

//点击保存 普通文本框
function modifySave(param) {
	var strValue = jQuery('#'+param).val(); 
	if(strValue == ''){
		strValue = '暂未填写';
	}
	doAjaxSubmitData(param, strValue, WEB_ROOT_pre + '/user/adminu/modify_user.php', true);
	inputCancel(param);
	jQuery('#'+param).val(strValue);
}

//选择保存 单个下拉选择框
function modifySelectSave(strPName ,strValue, strText ){
	doAjaxSubmitData(strPName, strValue, WEB_ROOT_pre + '/user/adminu/modify_user.php', true);
	var menuid = strPName;
	jQuery("#"+menuid+"_cancel").hide();
	jQuery("#"+menuid+"_select").hide();
	jQuery("#"+menuid+"_input").show();
	jQuery("#"+menuid+"_modify").show();
	jQuery("#"+menuid+"_input").text(strText);
}


var strYear		= '';
var strMonth	= '';
var strDate		= '';

//修改状态
function changeVar(menuid, strValue){
	if(menuid == 'year') strYear = strValue;
	else if(menuid == 'month') strMonth = strValue;
	else if(menuid == 'day') strDate  = strValue;
}

//修改 生日选择框
function selectModify(menuid){
	jQuery("#"+menuid+"_save").show();
	jQuery("#"+menuid+"_cancel").show();
	jQuery("#"+menuid+"_select").show();
	jQuery("#"+menuid+"_input").hide();
	jQuery("#"+menuid+"_modify").hide();
}

//取消 生日选择框
function selectCancel(menuid){
	jQuery("#"+menuid+"_save").hide();
	jQuery("#"+menuid+"_cancel").hide();
	jQuery("#"+menuid+"_select").hide();
	jQuery("#"+menuid+"_input").show();
	jQuery("#"+menuid+"_modify").show();
}


//保存 生日选择框
function selectSave(menuid){
	if(strYear  == '') strYear  = jQuery('#year option:selected').text();
	if(strMonth == '') strMonth = jQuery('#month option:selected').text();
	if(strDate  == '') strDate  = jQuery('#day option:selected').text();

	var strValue = strYear+'-'+strMonth+'-'+strDate;
	if(strValue == '1950-1-1') {
		selectCancel(menuid);
		return;
	}
	var strPName = 'birthday';
	var doStrUrl = document.location.href;

	doAjaxSubmitData(strPName, strValue, '', true);
	selectCancel('birthday');
	jQuery("#"+menuid+"_input").text(strValue);
}

//地区选择，覆盖同名函数
function areaSubmit(strValue){
	if(strValue == '' || strValue == null){
		jQuery("#area_input").text('暂未填写');
	}else{

		var strProvince	= strValue.substring(0,2)+'0000';
		var strCity		= strValue.substring(0,4)+'00';

		doAjaxSubmitData('province', strProvince, '', false);
		doAjaxSubmitData('city', strCity, '', false);
		pcode = strProvince;
		ccode = strCity;
		jQuery("#area_input").text(getAreaName(pcode,ccode,'','-',1));
		selectCancel('area');
	}
	
}

//多项选择框 编辑
function checkModify(menuid, strValue){
	jQuery('#'+menuid).show();
	check_select(menuid, strValue);
}

//多项选择框 退出
function checkCancel(menuid){	
	jQuery('#'+menuid).hide();
}

//多项选择框 保存
function checkSave(menuid, strPName){	
	var oEvent = document.getElementById(menuid);
	var chks = oEvent.getElementsByTagName("INPUT");
	var strIds = '';
	var strValue = '';

	for(var i=0; i<chks.length; i++){
		if(chks[i].type=="checkbox"){
			if(chks[i].checked == true){
				strIds += strIds == ''?chks[i].value:','+chks[i].value ;
				strValue += strValue == ''? chks[i].attributes['c_name'].nodeValue :','+chks[i].attributes['c_name'].nodeValue ;
			}
		}
	}

	doAjaxSubmitData(strPName, strIds, '', true);
	if(strValue != ''){
		jQuery('#'+menuid+'_content').html(strValue);	
	}
	checkCancel(menuid);		

}

//统计选择项
function check_count(menuid, my , num){
	var oEvent = document.getElementById(menuid);
	var chks = oEvent.getElementsByTagName("INPUT");
	var count = 0;

	for(var i=0; i<chks.length; i++){
		if(chks[i].type=="checkbox"){
			if(chks[i].checked == true){
				count ++;
			}
			if(count > num){
				my.checked = false;
				alert('最多只有选择' + num + '项');
				return false;
			}
		}
	}
}

//默认值被选中
function check_select(menuid, strValue){
	var arrTemp = strValue.split(',');
	var intLen	= arrTemp.length;

	var oEvent = document.getElementById(menuid);
	var chks = oEvent.getElementsByTagName("INPUT");
	var isFCheck = 0;

	for(var i=0; i<chks.length; i++){
		if(chks[i].type=="checkbox"){
			isFCheck = 0;
			for(var j=0; j<intLen; j++){
				if(chks[i].value == arrTemp[j]){ 
					chks[i].checked = true;
					isFCheck = 1;
				}
			}

			if(isFCheck != '1') chks[i].checked = false;
		}
	}
}

//保存数据
//strPName:字段名	pvalue:字段值	strUrl:提交地址	isAlert:是否打印出错信息
function doAjaxSubmitData(strPName, pvalue, strUrl, isAlert){
	if(strPName == '' || strPName == null || pvalue == '' || pvalue == null) {alert('警告：不允许提交空值!'); return false;}

	var doStrUrl = '';	
	if(strUrl == '' || strUrl == null) doStrUrl = document.location.href;
	else doStrUrl = strUrl;

	jQuery.ajax({ 
		url: doStrUrl,
		type: "POST",
		data: {pname:strPName ,pvalue:pvalue },
		error: function() { alert('数据提交错误,请稍后修改!');},
		success: function(data) {
			if(data == 'OK'){
			}else if(data == 'format_error'){
				alert('数据格式出现异常,请重新修改!');
			}else{if(isAlert) alert('服务器忙，数据提交错误,请稍后修改!');}
		}
	});
}
