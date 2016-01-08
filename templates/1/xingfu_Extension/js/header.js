$(document).ready(function(){
	
	var getQueryString = function(name) {
	    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	    var r = window.location.search.substr(1).match(reg);
	    if (r != null) return unescape(r[2]); return null;
	};	
	
	if(getQueryString("nav") == "1"){
		$(".header-content .topnav li:eq(0)").addClass("active").siblings().removeClass("active");
	}
	if(getQueryString("nav") == "2"){
		$(".header-content .topnav li:eq(1)").addClass("active").siblings().removeClass("active");
	}
	if(getQueryString("nav") == "4"){
		$(".header-content .topnav li:eq(3)").addClass("active").siblings().removeClass("active");
	}
	if(getQueryString("nav") == "6"){
		$(".header-content .topnav li:eq(5)").addClass("active").siblings().removeClass("active");
	}
	
});