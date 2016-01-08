//pic lazy load
function lazyload() {
	var d = $(".dynload");
	d.each(function () {
		if(typeof $(this).attr("imgsrc") != "undefined" && $(this).offset().top < $(document).scrollTop() + $(window).height()){
			$(this).hide().attr("src", $(this).attr("imgsrc"))["fadeIn"](200).removeAttr("imgsrc");
		}
	})
}
jQuery(document).ready(
	function($){
		$(window).scroll(function () {
			lazyload();
		});
	lazyload();
});
