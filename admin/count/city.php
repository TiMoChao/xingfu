<?php
/**
 * 后台区域用户量统计文件
 *
 * @author		王璐
 * @package		count
 * @subpackage	admin
 */
require_once('../config/config.inc.php');
require_once('../checklogin.php');
require_once('../../plug-in/area/area_code.php');

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
$intEnd = $intDate;
$arrMOutput["smarty_assign"]['intOverTime'] = $intDate;
for($i=1;$i<=$intDays;$i++){
	$intTmp=$intDate;
	$intDate=$intDate-$intInterval;
}
$arrMOutput["smarty_assign"]['intBeginTime'] = $intTmp;
$strSQL="SELECT count(a.id) as num,b.province FROM ".$arrGWeb['db_tablepre']."order as a left join ".$arrGWeb['db_tablepre']."address as b on a.address_id =b.id ";
$strSQL.=" WHERE a.submit_date > '".date("Y-m-d", $intDate)." 24:00:00' and a.submit_date < '".date("Y-m-d", $intEnd)." 24:00:00' and status in (2,4,7,8) and a.address_id>0 group by b.province order by num desc";

$rs = $objWebInit->db->query($strSQL);

$arrData =$rs->fetchall(PDO::FETCH_ASSOC);
$strValue='';
$strColor='';
$isFlag=true;

$arrColor=array("#C71585","#BF3EFF","#F08080","#8EE5EE","#FF3030","#FF00FF","#FFBBFF","#DEB887","#CAFF70","#C67171","#C1C1C1","#BF3EFF","#BC8F8F","#B0E2FF","#B03060","#AAAAAA","#A020F0","#9FB6CD","#9F79EE","#9ACD32","#97FFFF","#969696","#8E8E38","#8B8970","#7D26CD","#7A8B8B","#71C671","#708090","#68228B","#54FF9F","#383838","#0000CD","#8B1A1A","#BC8F8F","#008B00");
if(empty($arrData)){
	$strChart='{"title_":{"text":"Custom tooltip","style":"{font-size: 30px;}"},';
	$strChart.='"elements":[';
	$strChart.='{';
	$strChart.='"type":      "pie",';
	$strChart.='"start-angle":90,';
	$strChart.='"font-size": 10,';
	$strChart.='"values" :[]}';
	$strChart.=']';
	$strChart.='}';
}else{
	foreach ($arrData as $key => $value) {
		if($isFlag){
			$isFlag=false;
		}else{
			$strValue.=',';
			$strColor.=',';
		}
		if($value[num]==null){		
			$arrData[$key][num]=0;
		}
		if($value[province]==null){		
			$arrData[$key][provinceName]='地址不存在';
		}else if($value[province]==0){		
			$arrData[$key][provinceName]='其他';
		}else{
			$arrData[$key][provinceName]=$arrMArea[$arrData[$key][province]];	
		}
		
		$strValue.='{"value":'.$arrData[$key][num].',"label":"'.$arrData[$key][provinceName].'","font-size":12}';
		$strColor.='"'.$arrColor[$key].'"';
	}
	$strChart='{"title_":{"text":"Custom tooltip","style":"{font-size: 30px;}"},';
	$strChart.='"elements":[';
	$strChart.='{';
	$strChart.='"type":      "pie",';
	$strChart.='"tip":      "#percent#<br>#label#",';
	$strChart.='"alpha": 0.5,';
	$strChart.='"animate": [{"type":"bounce","distance":5},{"type":"fade"}],';
	$strChart.='"colours":   [ '.$strColor.'],';
	$strChart.='"start-angle":45,';
	$strChart.='"font-size": 10,';
	$strChart.='"values" :[';
	$strChart.=$strValue;
	$strChart.=']}';
	$strChart.=']';
	$strChart.='}';
}

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '订单用户区域分析';
$arrMOutput["smarty_assign"]['arrData'] = $arrData;
$arrMOutput["smarty_assign"]['intDays'] = $intDays;
$arrMOutput["smarty_assign"]['strChart'] = $strChart;
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'count/city.htm';
$objWebInit->output($arrMOutput);
?>