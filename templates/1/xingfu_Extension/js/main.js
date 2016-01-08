
window.onload = function (){
	$(".h-i-bimg").css("display","block");
	
	carouselToggle($(".btnprev1"),$(".btnnext1"),$(".cont-right"),$(".cont-right .glidediv"));
	carouselToggle3($(".pr-b"),$(".ne-b"),$(".h-i-bimg ul"),$(".h-i-bimg ul li"),$(".xf-jj-lbt"),$(".h-i-bimg"));
	carouselToggle1($(".proLeft"),$(".proRight"),$(".pro-box ul.pro-ul li"),$(".pro-box ul.pro-ul1 li"),"proLiBack");
	carouselToggle1(null,null,$(".img-glide li"),$(".cons-ul li"),"consBack");
	clickListA($(".n-c-cul:eq(0) .culli"),$(".n-c-rib .n-c-riul"),"down-back",function (){
		$(".rtib-po").text($(this).find("a p").text());
	});
	carouselToggle2($(".pr-b1"),$(".ne-b1"),$(".xf-fc-bcul1 li"),$(".xf-fc-bcbtn li"),"liback1");
	carouselToggle4($(".xf-pr"),$(".xf-ne"),$(".xf-news-ul"),$(".xf-news-ul li"));
	carouselToggle4($(".xf-pro"),$(".xf-neo"),$(".xf-news-ulo"),$(".xf-news-ulo li"));
	carouselToggle4($(".xf-pr1"),$(".xf-ne1"),$(".yey-top-ulo"),$(".yey-top-ulo li"));
	clickListA($(".xf-news-llist li"),$(".xf-news-listbox .xf-news-inlist"),"xf-news-liback");
	carouselToggle5(null,null,$(".xf-is-rbox #hhh"),$(".is-qh-ysul li"),"ahb");
	$(".h-i-bimg ul li").height($(".h-i-bimg ul li").find("img").height());
	
	//分页调用---261行
	page({
		
		id : 'fy-btnb',
		nowNum : 1,
		allNum : 10,
		callBack : function(now,all){
			
		}
	
	});
};


function clickListA(mub,dfb,addClass){
	var textContLength = mub.length;
	for(var i = 0; i < textContLength; i++){
		mub.eq(i).click(function(){
			var iIndex = $(this).index();
			$(this).addClass(addClass).siblings().removeClass(addClass);
			if(iIndex = i){
				dfb.eq($(this).index()).css("display","block").siblings().css("display","none");
			}
		});
	}
}

var carouselToggle4 =  function (leftBtn,rightBtn,mainBox,childBox){
	childBox.width(childBox.parent().parent().width());
	
	mainBox.width(childBox.width() * childBox.length + 2);
	var distances = childBox.width();
	var now = 0;
	function teb(){
		mainBox.stop().animate({
			left: -(now) * distances
		},500);
	};
	leftBtn.click(function (){
		now--;
		if(now == -1){ 
			now = childBox.length - 1;
		}
		teb();
	});
	rightBtn.click(function (){
		now++;
		if(now == childBox.length){
			now = 0;
		}
		teb();
	});
};

var carouselToggle =  function (leftBtn,rightBtn,mainBox,childBox){
	childBox.width($(window).width());
	mainBox.width(childBox.width() * childBox.length + 2);
	var distances = childBox.width();
	var now = 0;
	function teb(){
		mainBox.stop().animate({
			left: -(now) * distances
		},500);
	};
	leftBtn.click(function (){
		now--;
		if(now == -1){
			now = childBox.length - 1;
		}
		teb();
	});
	rightBtn.click(function (){
		now++;
		if(now == childBox.length){
			now = 0;
		}
		teb();
	});
};

var carouselToggle5 =  function (leftBtn,rightBtn,childBox,objLi,adClas){
	var now = 0;
	var ObjLiLength = objLi.length;
	//var timer = null;
	for(var i = 0; i < ObjLiLength; i++){
		objLi.eq(i).click(function(){
			now = $(this).index();
			teb();
		});
	}
	function teb(){
		objLi.eq(now).find("a").addClass(adClas).parent().siblings().find("a").removeClass(adClas);
		childBox.eq(now).css("display","block");
		childBox.eq(now).stop().animate({
			opacity:'1'
		},600);
		childBox.eq(now).siblings().css({"display":"none","opacity":"0.2"});
	};
	/*$("body,html").scroll(function (){
		now--;
		if(now == -1){
			now = childBox.length - 1;
		}
		teb();
	});
	rightBtn.click(function (){
		now++;
		if(now == childBox.length){
			now = 0;
		}
		teb();
	});*/
};

var carouselToggle1 =  function (leftBtn,rightBtn,childBox,objLi,adClas){
	var now = 0;
	var ObjLiLength = objLi.length;
	//var timer = null;
	for(var i = 0; i < ObjLiLength; i++){
		objLi.eq(i).click(function(){
			now = $(this).index();
			teb();
		});
	}
	function teb(){
		objLi.eq(now).addClass(adClas).siblings().removeClass(adClas);
		childBox.eq(now).css("display","block");
		childBox.eq(now).stop().animate({
			opacity:'1'
		},600);
		childBox.eq(now).siblings("li").css({"display":"none","opacity":"0.2"});
	};
};

var carouselToggle2 =  function (leftBtn,rightBtn,childBox,objLi,adClas){
	var now = 0;
	var ObjLiLength = objLi.length;
	var timer = null;
	for(var i = 0; i < ObjLiLength; i++){
		objLi.eq(i).click(function(){
			now = $(this).index();
			teb();
		});
	}
	function teb(){
		objLi.eq(now).addClass(adClas).siblings().removeClass(adClas);
		childBox.eq(now).css("display","block");
		childBox.eq(now).stop().animate({
			opacity:'1'
		},600);
		childBox.eq(now).siblings("li").css({"display":"none","opacity":"0.2"});
	};
	leftBtn.click(function (){
		now--;
		if(now == -1){
			now = childBox.length - 1;
		}
		teb();
	});
	rightBtn.click(function (){
		now++;
		if(now == childBox.length){
			now = 0;
		}
		teb();
	});

	timer = setInterval(function(){rightBtn.click()},5000);
	childBox.mouseover(function(){
		clearInterval(timer);
	})
	childBox.mouseout(function(){
		timer = setInterval(function(){rightBtn.click();},5000);
	})
};


//私人订制的JS其他地方可能不适用0。0！！！
var carouselToggle3 =  function (leftBtn,rightBtn,mainBox,childBox,infoShow,homeBox){
	childBox.width($(window).width());
	mainBox.width(childBox.width() * childBox.length + 2);
	var distances = childBox.width();
	var now = 0;
	var timer = null;
	function teb(){
		mainBox.stop().animate({
			left: -(now) * distances
		},500);
		
	};
	function infoAnimate(){
		infoShow.stop().animate({
			bottom:'-150px',
			opacity:'0'
		},800,
		function(){
			if(leftBtn.click()){
				now--;
				if(now == -1){
					now = childBox.length - 1;
				}
				teb();
			}else{
				now++;
				if(now == childBox.length){
					now = 0;
				}
				teb();
			}
			infoShow.stop().animate({ 
				bottom:'10px',opacity:'1'
			},800);
		});
	}
	
	leftBtn.click(function (){
		if(infoShow.is(":animated")){
			return false;
		}else{
			infoAnimate()
		}
	});
	rightBtn.click(function (){
		if(infoShow.is(":animated")){
			return false;
		}else{
			infoAnimate()
		}
	});
	
	timer = setInterval(function(){rightBtn.click()},5000);
	homeBox.mouseover(function(){
		clearInterval(timer);
	})
	homeBox.mouseout(function(){
		timer = setInterval(function(){rightBtn.click()},5000);
	})
};


//分页下面主要代码部分---调用在20行
var page = function (opt){
	if(!opt.id){return false};
	var obj = document.getElementById(opt.id);
	var nowNum = opt.nowNum || 1;
	var allNum = opt.allNum || 5;
	var callBack = opt.callBack || function(){};

	
	if( nowNum>=4 && allNum>=6 ){
		var oA = document.createElement('a');
		oA.href = '#1';
		oA.innerHTML = '首页';
		obj.appendChild(oA);
	}
	if(nowNum>=2){
		var oA = document.createElement('a');
		oA.href = '#' + (nowNum - 1);
		oA.innerHTML = '上一页';
		obj.appendChild(oA);
	}
	if(allNum<=5){
		for(var i=1;i<=allNum;i++){
			var oA = document.createElement('a');
			oA.href = '#' + i;
			if(nowNum == i){
				oA.innerHTML = i;
				oA.className = 'fy-yb';
			}
			else{
				oA.innerHTML = i;
			}
			obj.appendChild(oA);
		}	
	}
	else{
		for(var i=1;i<=5;i++){
			var oA = document.createElement('a');
			if(nowNum == 1 || nowNum == 2){
				oA.href = '#' + i;
				if(nowNum == i){
					oA.innerHTML = i;
					oA.className = 'fy-yb';
				}
				else{
					oA.innerHTML =  i;
				}
			}
			else if( (allNum - nowNum) == 0 || (allNum - nowNum) == 1 ){
				oA.href = '#' + (allNum - 5 + i);
				if((allNum - nowNum) == 0 && i==5){
					oA.innerHTML = (allNum - 5 + i);
					oA.className = 'fy-yb';
				}
				else if((allNum - nowNum) == 1 && i==4){
					oA.innerHTML = (allNum - 5 + i);
					oA.className = 'fy-yb';
				}
				else{
					oA.innerHTML = (allNum - 5 + i);
				}
			}
			else{
				oA.href = '#' + (nowNum - 3 + i);
				if(i==3){
					oA.innerHTML = (nowNum - 3 + i);
					oA.className = 'fy-yb';
				}
				else{
					oA.innerHTML = (nowNum - 3 + i);
				}
			}
			obj.appendChild(oA);
		}
	}
	if( (allNum - nowNum) >= 1 ){
		var oA = document.createElement('a');
		oA.href = '#' + (nowNum + 1);
		oA.innerHTML = '下一页';
		obj.appendChild(oA);
	}
	if( (allNum - nowNum) >= 3 && allNum>=6 ){
		var oA = document.createElement('a');
		oA.href = '#' + allNum;
		oA.innerHTML = '尾页';
		obj.appendChild(oA);
	}
	callBack(nowNum,allNum);
	var aA = obj.getElementsByTagName('a');
	for(var i=0;i<aA.length;i++){
		aA[i].onclick = function(){
			var nowNum = parseInt(this.getAttribute('href').substring(1));
			obj.innerHTML = '';
			page({
				id : opt.id,
				nowNum : nowNum,
				allNum : allNum,
				callBack : callBack
			});
			
			return false;
		};
	}
}