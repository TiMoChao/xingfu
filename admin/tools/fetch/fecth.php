<?php
/**
 * 非法信息过滤后台管理栏目首页文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	fetch
 */
require_once('../../config/config.inc.php');
require_once('../../checklogin.php');

$objWebInit = new ArthurXF();

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','tools')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

$strFilename = '../../../data/fetch.inc.php';
@include($strFilename);

if(isset($_GET['action'])){
	if(empty($arrGFetch[$_GET['id']])) check::AlertExit('您还没设置采集器呢',-1);
	$objSnoopy = new Snoopy; 
	$objSnoopy->cache_time = 200;
	set_time_limit(0);
	ignore_user_abort();

	if(empty($_GET['url'])){
		//列表页抓取
		$objSnoopy->fetch($arrGFetch[$_GET['id']]['list_url']);
		$string = $objSnoopy->results;
		if(empty($string)) $string = file_get_contents($arrGFetch[$_GET['id']]['list_url']);
		if(empty($string)) check::AlertExit('列表页数据源无法抓取！',-1);
		if(!empty($arrGFetch[$_GET['id']]['list_charset']) && $arrGFetch[$_GET['id']]['list_charset'] != 'UTF-8'){
			$string = iconv($arrGFetch[$_GET['id']]['list_charset'], 'UTF-8'.'//IGNORE', $string);
			//$string = mb_convert_encoding($string, 'UTF-8',$arrGFetch[$_GET['id']]['list_charset']);
		}
		
		//列表页前部截取
		if(!empty($arrGFetch[$_GET['id']]['delimiter_lt'])){
			foreach($arrGFetch[$_GET['id']]['delimiter_lt'] as $k => $v){
				$intPostion = stripos($string,$v);
				if($intPostion === false) check::AlertExit('列表页前部截取'.($k+1).'未成功，请检查！',-1);
				if(!empty($v)){
					$string = substr($string,$intPostion+strlen($v));
				}
			}
		}
		//列表页尾部截取
		if(!empty($arrGFetch[$_GET['id']]['delimiter_lb'])){
			foreach($arrGFetch[$_GET['id']]['delimiter_lb'] as $k => $v){
				$intPostion = stripos($string,$v);
				if($intPostion === false) check::AlertExit('列表页尾部截取'.($k+1).'未成功，请检查！',-1);
				if(!empty($v)){
					$string = substr($string,0,$intPostion);
				}
			}
		}
		//详细链接抓取
		if(!empty($arrGFetch[$_GET['id']]['delimiter_lm'])){
			foreach($arrGFetch[$_GET['id']]['delimiter_lm'] as $v){
				if(!empty($v)){
					if(is_array($string)) {
						$arrData = array();
						if(empty($v[0])||empty($v[1])) check::AlertExit('数据已转化为数组，此时分隔符和取位不能为空',-1);
						foreach($string as $v1){
							$arrTemp = explode($v[0], $v1);
							if(empty($arrTemp[$v[1]])) continue;
							if(!empty($v[2])) $arrTemp[$v[1]] = str_replace($v[2],$v[3],$arrTemp[$v[1]]);
							if($arrGFetch[$_GET['id']]['wholelink'] && !empty($arrGFetch[$_GET['id']]['list_host'])){
								if(stripos($arrTemp[$v[1]],'http') === false) $arrData[] = $arrGFetch[$_GET['id']]['list_host'].$arrTemp[$v[1]];
							}else $arrData[] = $arrTemp[$v[1]];
						}
						$string = $arrData;
					}else{
						$arrTemp = explode($v[0], $string);
						if(empty($v[1])) $string = $arrTemp;
						else{
							if(empty($v[2])) $string = $arrTemp[$v[1]];
							else $string = str_replace($v[2],$v[3],$arrTemp[$v[1]]);
						}
					}
				}
			}
			$arrListUrl = $string;
		}else{
			$arrListUrl = $objSnoopy->_striplinks($string);
			if($arrListUrl && $arrGFetch[$_GET['id']]['list_host']){
				foreach($arrListUrl as $k => $v){
					if($v[0] == '/') $arrListUrl[$k] = $arrGFetch[$_GET['id']]['list_host'].$v;
					else $arrListUrl[$k] = $arrGFetch[$_GET['id']]['list_host'].'/'.$v;
				}
			}
		}
	}else $arrListUrl = array($_GET['url']);

	//查找链接屏蔽码，如果找到直接过滤
	if(!empty($arrListUrl)){
		if(!empty($arrGFetch[$_GET['id']]['delimiter_ls'])){
			foreach($arrGFetch[$_GET['id']]['delimiter_ls'] as $k => $v){
				if(!empty($v)){
					foreach($arrListUrl as $k1 =>$v1){
						$intPostion = stripos($v1,$v);
						if($intPostion !== false) unset($arrListUrl[$k1]);
					}
				}
			}
		}
	}
	if(empty($arrListUrl)) $arrListUrl = $string;
	if($_GET['action'] === 'listtest') {echo "list:&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php'>返回</a><pre>";print_r($arrListUrl);echo "</pre>";exit;}
	if($_GET['action'] == 'fetchlist'){
		echo "单条采集列表:&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php'>返回</a><br />";
		if(is_array($arrListUrl)){
			foreach($arrListUrl as $k => $v){
				echo "<a href='$v' target=_blank>$v</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='fecth.php?id=$_GET[id]&action=fetch&url=".urlencode($v)."'>采集</a><br />";
			}
		}else{
			echo "没采集到列表！";
		}
		exit;
	}
	
	//根据列表链接，采集详细页面内容
	$string = '';
	if(empty($arrListUrl)) check::AlertExit('没采集到列表！',-1);
	foreach($arrListUrl as $key => $val){
		if(empty($val)) check::AlertExit('详细页链接有错误，请执行列表页测试，找出错误！',-1);
		if(strpos(strtolower($val),'http://') !== 0)  check::AlertExit('详细页链接有错误，请执行列表页测试，找出错误！',-1);
		$objSnoopy->fetch($val);
		$string = $objSnoopy->results;
		if(empty($string)) $string = file_get_contents($arrGFetch[$_GET['id']]['list_url']);
		if(empty($string)) check::AlertExit('详细页数据源无法抓取！',-1);
		
		if(!empty($arrGFetch[$_GET['id']]['list_charset']) && $arrGFetch[$_GET['id']]['list_charset'] != 'UTF-8'){
			$string = iconv($arrGFetch[$_GET['id']]['list_charset'], 'UTF-8'.'//IGNORE', $string);
			//$string = mb_convert_encoding($string , 'UTF-8',$arrGFetch[$_GET['id']]['list_charset']);
		}

		//查找屏蔽码，如果找到直接返回
		if(!empty($arrGFetch[$_GET['id']]['delimiter_ds'])){
			foreach($arrGFetch[$_GET['id']]['delimiter_ds'] as $k => $v){
				if(!empty($v)){
					$intPostion = stripos($string,$v);
					if($intPostion !== false) check::AlertExit(($k+1).'号屏蔽码屏蔽了该详细页，如有误，请调整该屏蔽码！',-1);
				}
			}
		}
		//详细页前部截取
		if(!empty($arrGFetch[$_GET['id']]['delimiter_dt'])){
			foreach($arrGFetch[$_GET['id']]['delimiter_dt'] as $k => $v){
				$intPostion = stripos($string,$v);
				if($intPostion === false) check::AlertExit('详细页前部截取'.($k+1).'未成功，请检查！',-1);
				if(!empty($v)){
					$string = substr($string,$intPostion+strlen($v));
				}
			}
		}
		//详细页尾部截取
		if(!empty($arrGFetch[$_GET['id']]['delimiter_db'])){
			foreach($arrGFetch[$_GET['id']]['delimiter_db'] as $k => $v){
				$intPostion = stripos($string,$v);
				if($intPostion === false) check::AlertExit('详细页尾部截取'.($k+1).'未成功，请检查！',-1);
				if(!empty($v)){
					$string = substr($string,0,$intPostion);
				}
			}
		}

		//详细页字段
		if(!empty($arrGFetch[$_GET['id']]['delimiter_dw'])){
			$arrSave = array();
			foreach($arrGFetch[$_GET['id']]['delimiter_dw'] as $k => $v){
				if(!empty($v[0])){
					$strTemp = '';
					if($v[1]){
						$intPostion = stripos($string,$v[1]);
						if($intPostion === false) check::AlertExit('详细页字段'.($k+1).'前部截取未成功，请检查！',-1);
						$string = trim(substr($string,$intPostion+strlen($v[1])));
						//$arrSave[$v[0]] = $string;
						$strTemp = $string;
					}else check::AlertExit('详细页字段'.($k+1).'前部截取位不能为空，请检查！',-1);
					if($v[2]){						
						$intPostion = stripos($string,$v[2]);
						if($intPostion === false) {print_r($string);exit;}//check::AlertExit('详细页字段'.($k+1).'尾部截取未成功，请检查！',-1);
						$strTemp = trim(substr($strTemp,0,$intPostion));
						$string = trim(substr($string,$intPostion+strlen($v[2])));
					}else check::AlertExit('详细页字段'.($k+1).'尾部截取位不能为空，请检查！',-1);
					$strTemp = $objSnoopy->stripHtml_a($strTemp);
					$strTemp = $objSnoopy->stripJs($strTemp);	
					switch($v[3]){
						case 0:
							$arrImg = $objSnoopy->fetchimg($strTemp);
							if(!empty($arrImg)){
								foreach($arrImg as $k1 => $v1){
									if(stripos($v1,'http') === false){
										$arrImg[$k1] = $arrGFetch[$_GET['id']]['list_host'].$v1;
										$strTemp = str_replace($v1,$arrImg[$k1],$strTemp);
									}
								}
							}
							break;
						case 1:
							$strTemp = $objSnoopy->_striptext($strTemp);
							break;
						case 2:
							$strTemp = $objSnoopy->stripHtml_img($strTemp);
							break;
						case 3:
							$arrImg = $objSnoopy->fetchimg($strTemp);
							if(!empty($arrImg)){
								$strDir = '/uploadfile/'.date('Ym').'/image/';
								$strSaveDir = '../../..'.$strDir;
								foreach($arrImg as $k1 => $v1){
									//检查图片路径是否完整，不完整要补全
									$isQuan = 1;
									if(stripos($v1,'http') === false){
										$isQuan = 0;
									}
									$FileExt=strtolower(strrchr($v1,'.'));
									$strFileName = time().'_'.$k1.$FileExt;
									$strSaveFileName = $strSaveDir.$strFileName;
									$strCallFileName = $strDir.$strFileName;
									if($isQuan) $objSnoopy->fetch($v1);
									else $objSnoopy->fetch($arrGFetch[$_GET['id']]['list_host'].$v1);
									$strImg = $objSnoopy->results;
									if(!empty($strImg)) $isOK = check::write_file($strSaveFileName,$strImg);
									if($isOK) $strTemp = str_replace($v1,$strCallFileName,$strTemp);
								}
							}
							break;
					}
					$arrSave[$v[0]] .= $strTemp;
					if(empty($arrSave[$v[0]])) check::AlertExit('标题采集为空，请检查！',-1);
					if($v[0] == 'title'){
						$arrInfoWhere = check::getAPI($arrGFetch[$_GET['id']]['module_id'],'getInfoWhere',"WHERE `title` = '$strTemp'^id");
						if(!empty($arrInfoWhere)) {
							echo '<font color="red">采集过了!</font><br />'; 
							if($_GET['action'] == 'fetch') check::AlertExit('采集过了!',-1);
							else continue;
						}
					}
				}
			}
		}
		if($_GET['action'] == 'detailtest') {echo "<a href=
	'$val' target=_blank>$val</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php'>返回</a><pre>";print_r($arrSave);echo "</pre>";exit;}
		
		//存入数据库
		if($_GET['action'] == 'fetchall'||$_GET['action'] == 'fetch') {
			if(empty($arrGFetch[$_GET['id']]['module_id']))  check::AlertExit('存入栏目必须选择！',-1);
			if(in_array($arrGFetch[$_GET['id']]['module_id'],array('mcenter','account','certification','comments','friend','message','payment','usermoney','logs','archives','ads','links','phonelist','emaillist','keywords','user'))){
				 check::AlertExit('非法栏目！',-1);
			}
			echo "<a href='$val' target=_blank>$val</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:history.go(-1);'>返回</a><pre>";print_r($arrSave);echo "</pre>";
			

			$arrSave['type_id'] = $arrGFetch[$_GET['id']]['type_id'];
			//if(!empty($arrSave['intro'])) $arrSave['summary'] = check::csubstr(trim(str_replace("&nbsp;"," ",str_replace("\r\n","",strip_tags($arrSave['intro'])))),0,250);
			if(!empty($arrSave['intro'])) $arrSave['summary'] = check::csubstr(check::stripText($arrSave['intro']),0,250);
			if(!empty($arrGFetch[$_GET['id']]['delimiter_df'])){
				foreach($arrGFetch[$_GET['id']]['delimiter_df'] as $k => $v){
					if(!empty($v[0])){
						$arrSave[$v[0]] = $v[1];
					}
				}
			}
			$strData = check::getAPIArray($arrSave);
			check::getAPI($arrGFetch[$_GET['id']]['module_id'],'saveInfo',"$strData^0^0");
			echo ' <font color="green">采集成功!</font><br />';
			if($_GET['action'] == 'fetch') exit;
		}
	}

}

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '数据采集器';
$arrMOutput["smarty_assign"]['arrInfo'] = $arrData;
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'tools/fetch/index.htm';
$objWebInit->output($arrMOutput);
?>