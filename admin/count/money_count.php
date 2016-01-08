<?php
/**
 * 后台下单量统计文件
 *
 * @author		王璐
 * @package		count
 * @subpackage	admin
 */
require_once('../config/config.inc.php');
require_once('../checklogin.php');

$objWebInit = new ArthurXF();

//数据库连接参数
$objWebInit->setDBG($arrGPdoDB);
//smarty参数
$objWebInit->arrGSmarty = $arrGSmarty;
$objWebInit->db();
//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','count')) {
	check::AlertExit('对不起，您没有权限访问此页',-1);
}
$arrData=array();
$intDays=7;
if(isset($_GET['intDays'])&&intval($_GET['intDays'])>0){
	$intDays=intval($_GET['intDays']);
}
$intInterval = 24*60*60;
$intDate=time();
if(isset($_GET['end'])&&!empty($_GET['end'])){
	$intDate=strtotime($_GET['end']);
}
$arrMOutput["smarty_assign"]['intOverTime'] = $intDate;
for($i=1;$i<=$intDays;$i++){
	$intTmp=$intDate;
	$intDate=$intDate-$intInterval;
	$strWhere="where submit_date > '".date("Y-m-d", $intDate)." 24:00:00' and submit_date< '".date("Y-m-d", $intTmp)." 24:00:00'";
	$strWhere.=" and status in (2,4,7,8)";
	$strSQL = "SELECT sum(pay_money) as '".date("Y-m-d", $intTmp)."' FROM ".$arrGWeb['db_tablepre']."order ".$strWhere;
	$rs = $objWebInit->db->query($strSQL);
	$arrData =array_merge($arrData,current($rs->fetchall(PDO::FETCH_ASSOC)));
}
$arrMOutput["smarty_assign"]['intBeginTime'] = $intTmp;
ksort($arrData);
$strLabel='';
$strValue='';
$isFlag=true;
$intMaxValue=0;
$intCount = 0;
foreach ($arrData as $key => $value) {
	if($isFlag){
		$isFlag=false;
	}else{
		$strLabel.=',';
		$strValue.=',';
	}
	if($value==null){
		$value=0;
		$arrData[$key]=0;
	}
	$strLabel.='"'.$key.'"';

	$strValue.=$value;
	if($intMaxValue<$value){
		$intMaxValue=$value;
	}
	$intCount +=$value;
}
if($intMaxValue<=10){
	$intStep=1;
	$intMaxValue=10;
}else{
	$intStep = ceil($intMaxValue/10);
	$intMaxValue=$intStep*10;
}
$strChart='{"title_":{"text":"Custom tooltip","style":"{font-size: 20px; font-family: Verdana; text-align: center;}"},';
$strChart.='"elements":[';
$strChart.='{';
$strChart.='"type":      "line",';
$strChart.='"colour":    "#6495ED",';
$strChart.='"text":"销售额（元）",';
$strChart.='"font-size": 10,';
$strChart.='"values" :   ['.$strValue.']';
$strChart.='}';
$strChart.='],';
$strChart.='"x_axis":{';
$strChart.='"colour":    "#FFA54F",';
$strChart.='"labels":{"rotate": "vertical","labels": ['.$strLabel.']}';
$strChart.='},';
$strChart.='"y_axis":{';
$strChart.='"colour":"#FFA54F",';
$strChart.='"min":"0",';
$strChart.='"max":"'.$intMaxValue.'",';
$strChart.='"steps":"'.$intStep.'"';
$strChart.='}';
$strChart.='}';
// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '销售额分析';
$arrMOutput["smarty_assign"]['arrData'] = $arrData;
$arrMOutput["smarty_assign"]['intCount'] = $intCount;
$arrMOutput["smarty_assign"]['intDays'] = $intDays;
$arrMOutput["smarty_assign"]['strChart'] = $strChart;
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'count/money_count.htm';
$objWebInit->output($arrMOutput);
?>