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

if(!empty($_GET['host'])){
	$where = "where 1=1 and host='{$_GET['host']}' and submit_date>='{$_GET['start']}' and submit_date<='{$_GET['end']}'";
	if(!empty($_GET['order_id'])){
		$where.=" and order_id like '%{$_GET['order_id']}%'";
	}
	if(!empty($_GET['product_name'])){
		$where.=" and product_name like '%{$_GET['product_name']}%'";
	}
	$arrData=check::getAPI("order","getInfoList","{$where}^order by submit_date desc^^^*");
	$total = 0;
	foreach($arrData as $da){
		if($da['status']!=1&&$da['status']!=3&&$da['status']!=5&&$da['status']!=6){
			$total+=floatval($da['price'])*$da['product_num'];
		}
	}
	$arrMOutput["smarty_assign"]['strNav'] = $_GET['host'].' 广告渠道统计';
	$arrMOutput["smarty_assign"]['arrData'] = $arrData;
	$arrMOutput["smarty_assign"]['start'] = $_GET['start'];
	$arrMOutput["smarty_assign"]['end'] = $_GET['end'];
	$arrMOutput["smarty_assign"]['host'] = $_GET['host'];
	$arrMOutput["smarty_assign"]['total'] = $total;
	$arrMOutput["smarty_assign"]['product_name'] = $_GET['product_name'];
	$arrMOutput["smarty_assign"]['order_id'] = $_GET['order_id'];
	$arrMOutput["template_file"] = "admin.html";
	$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'count/referer_detail.htm';
	$objWebInit->output($arrMOutput);
}

$where = "where 1=1 and host !=''";
if(empty($_POST['start'])){
	$start=date("Y-m-d");
}else{
	$start = $_POST['start'];
}
$where.=" and submit_date>='$start'";

if(empty($_POST['end'])){
	$end=date("Y-m-d")." 23:59:59";
}else{
	$end = $_POST['end']." 23:59:59";
}
$where.=" and submit_date<='$end'";

$strSQL = " select * from biweb_order ".$where;
$rs = $objWebInit->db->query($strSQL);
$arrData = $rs->fetchall(PDO::FETCH_ASSOC);
$arrTmp = array();
foreach($arrData as $rs){
	//echo $rs["host"];print_r($arrTmp);echo "<br/>";
	if( array_key_exists($rs['host'],$arrTmp)){
		if($rs['status']==1){
			$arrTmp[$rs['host']]['未付款']+=1;
		}elseif($rs['status']==3){
			$arrTmp[$rs['host']]['已取消']+=1;
		}elseif($rs['status']==5){
			$arrTmp[$rs['host']]['已退款']+=1;
		}elseif($rs['status']==6){
			$arrTmp[$rs['host']]['已过期']+=1;
		}else{
			$arrTmp[$rs['host']]['交易成功']+=1;
		}
	}else{
		$arrTmp[$rs['host']]['未付款']=0;
		$arrTmp[$rs['host']]['已取消']=0;
		$arrTmp[$rs['host']]['已退款']=0;
		$arrTmp[$rs['host']]['已过期']=0;
		$arrTmp[$rs['host']]['交易成功']=0;
		if($rs['status']==1){
			$arrTmp[$rs['host']]['未付款']+=1;
		}elseif($rs['status']==3){
			$arrTmp[$rs['host']]['已取消']+=1;
		}elseif($rs['status']==5){
			$arrTmp[$rs['host']]['已退款']+=1;
		}elseif($rs['status']==6){
			$arrTmp[$rs['host']]['已过期']+=1;
		}else{
			$arrTmp[$rs['host']]['交易成功']+=1;
		}
	}
}
// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '广告渠道统计';
$arrMOutput["smarty_assign"]['arrData'] = $arrTmp;
$arrMOutput["smarty_assign"]['start'] = $start;
$arrMOutput["smarty_assign"]['end'] = $end;
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'count/referer.htm';
$objWebInit->output($arrMOutput);
?>