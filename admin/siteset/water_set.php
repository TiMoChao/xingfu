<?php
/**
 * 后台管理栏目缓冲设置文件
 *
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 * @subpackage	admin
 */
require_once('../config/config.inc.php');
require_once('../checklogin.php');

$objWebInit = new ArthurXF();
//smarty参数
$objWebInit->arrGSmarty = $arrGSmarty;

//访问权限检查
if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'r','siteset')) {
	check::AlertExit('对不起，您没有读权限',-1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (! $objWebInit->checkPopedomG($_SESSION['user_id'],'w','siteset')) {
		check::AlertExit('对不起，您没有写权限',-1);
	}
	unset($_POST['okgo']);
	unset($arrGWeb);
	$strFilename = '../../data/webconfig.inc.php';
	include($strFilename);
	//获取请求中的数据
	$isWaterMark = intval($_POST['waterMark']);//根据水印开启的状态取属性
	$arrGWeb['waterMark']=$isWaterMark;
	if(!empty($isWaterMark)){
		if($isWaterMark==1){//图片水印
			$arrGWeb['waterPos']= $_POST['waterPos'];//水印位置
			$arrGWeb['waterMode']= $_POST['waterMode'];//水印模式
			if(isset($_FILES) && !empty($_FILES['waterImage']) && $_FILES['waterImage']['size']>0) {   
				$water_info = getimagesize($_FILES['waterImage']['tmp_name']);
				switch($water_info[2]){  //取得水印图片的格式           
					case 1:$fileName = 'waterImage.gif';break;             
					case 2:$fileName = 'waterImage.jpeg';break;             
					case 3:$fileName = 'waterImage.png';break;             
					default:check::AlertExit('对不起，图片格式必须是gif、jpeg或png中的一种',-1);         
				}    
				if (move_uploaded_file($_FILES['waterImage']['tmp_name'], __WEB_ROOT."/data/".$fileName))     {         
					$arrGWeb['waterImage'] = $fileName;//水印图片
				}else{
					check::AlertExit('对不起，水印图片上传失败',-1);
				}
			}else{
				if(empty($arrGWeb['waterImage'])) check::AlertExit('对不起，水印图片必须上传',-1);
			}			
		}elseif($isWaterMark==2){//文字水印
			$arrGWeb['bgColor']= $_POST['bgColor'];//水印背景颜色
			$arrGWeb['fgColor']= $_POST['fgColor'];//水印字体颜色
			$arrGWeb['navColor']= $_POST['navColor'];//导航块颜色
			$arrGWeb['width']= $_POST['width'];//水印宽度
			$arrGWeb['height']= $_POST['height'];//水印高度
			$arrGWeb['xPic']= $_POST['xPic'];//水印左上角X坐标
			$arrGWeb['yPic']= $_POST['yPic'];//水印左上角Y坐标
			$arrGWeb['text0']= $_POST['text0'];//水印内容
			$arrGWeb['text1']= $_POST['text1'];//水印内容
		}
	}

	$somecontent = '<?php' . "\n" . '$arrGWeb = ' . var_export( $arrGWeb, true ) . ';' . "\n" . '$arrGMeta = ' . var_export( $arrGMeta, true ) . ';' . "\n" . '?>';

	if (!$handle = fopen($strFilename, 'w')) {
		 check::AlertExit("错误：不能打开文件 $strFilename !",-1);
	}

	// 将$somecontent写入到我们打开的文件中。
	if (fwrite($handle, $somecontent) === FALSE) {
		check::AlertExit("错误：不能写入到文件 $strFilename !",-1);
	}
	fclose($handle);
	check::AlertExit("成功地写入到文件 $strFilename !",'water_set.php');

}

// 输出到模板
$arrMOutput["smarty_assign"]['strNav'] = '网站水印设置';
$arrMOutput["template_file"] = "admin.html";
$arrMOutput["smarty_assign"]['MAIN'] = $arrGSmarty['admin_main_dir'].'siteset/water_set.htm';
$objWebInit->output($arrMOutput);
?>