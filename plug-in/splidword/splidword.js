function splidword(data){	
	var title = data;
	var url = '../../plug-in/splidword/splidword.php';
	var pars = 'title='+title+'&ocs=utf-8';
	var myAjax = new Ajax.Request(
	url,
	{
	method: 'get',
	parameters: pars,
	onComplete: showResponse
	});
}
function showResponse(originalRequest){
	$('tag').value = originalRequest.responseText;
}