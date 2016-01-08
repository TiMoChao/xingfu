<?PHP
require_once('../../web_common5.8/domxml.class.php');
if (!empty($_GET['title'])){
	$strXML = file_get_contents('http://keyword.discuz.com/related_kw.html?title='.$_GET['title'].'&ocs='.$_GET['ocs']);
	$objXml = new domxml;
	$objXml->loadXML($strXML);
	$arrXml = $objXml->gElement('kw');
	if(!empty($arrXml)) echo implode(' ',$arrXml);
	else echo $arrXml;
}
?>