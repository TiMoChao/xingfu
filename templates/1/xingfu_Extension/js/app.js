window.onload = function (){
	
	var aImg = document.getElementsByName('img');
	var aLi = document.getElementsByName('li');
	
	aImg.offsetHeight = aLi.offsetHeight;
	carouselToggle4($(".app-topul"),$(".app-topul li"),$(".li-in a"));
};


var carouselToggle4 =  function (mainBox,childBox,btnA){
	mainBox.width(childBox.width() * childBox.length + 2);
	childBox.width($(window).width());
	var distances = childBox.width();
	var now = 0;
	function teb(){
		mainBox.stop().animate({
			left: -(now) * distances
		},500);
		//btnA.eq(now).addClass("active-li1").removeClass("active-li1");
		//$(".li-inb p").text(liP.eq(now));
	};
		mainBox.on("swiperight",function (){
			now--;
			if(now == -1){
				now = childBox.length - 1;
			}
			teb();
		});
		mainBox.on("swipeleft",function (){
			now++;
			if(now == childBox.length){
				now = 0;
			}
			teb();
		});                      
	//});
	
};

