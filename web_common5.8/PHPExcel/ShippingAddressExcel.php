<?php
//设置PHPExcel类库的include path  
set_include_path('.' . PATH_SEPARATOR . __WEBCOMMON_ROOT . '/PHPExcel/' . PATH_SEPARATOR . get_include_path());
class ShippingAddressExcel {
	
	/**
	 * excel导出
	 * 
	 * @param string	$fileName		文件名 save.xls
	 * @param array $keyList		字段名与标题对应关系
	 * @param array $arrData		要导出的数据
	 * @param bolean $isFile			true 保存文件 false 输出浏览器
	 * @param string $type			生成excel格式 excel2003 xls
	 */
	static function createWriter($fileName, $keyList, $arrData, $isFile = false, $type = 'Excel5') {
		require_once 'PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		require_once 'PHPExcel/IOFactory.php';
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		
		//将keyList 插入到要输出数组的第一个
		array_unshift($arrData, $keyList);
		
		//循环想数组写入excel
		foreach ( $arrData as $key => $value ) {
			$i = 0;
			foreach ( $keyList as $k => $v ) {
				$num = self::parseColumnNum($i);
				$row = $key + 1;
				$objWorksheet->setCellValue($num . $row, "$value[$k]");
				if($k=="status"&&($value[$k]=="已发货"||$value[$k]=="交易完成")){
					$objWorksheet->getStyle($num . $row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				}
				$objWorksheet->getStyle($num.$row)->getNumberFormat()->setFormatCode('@');
				$i ++;
			}
		}
		
		if ($isFile == true) {
			//#TODO 生成文件的保存路径为设置
			//生成文件 
			$objWriter->save($fileName);
		} else {
			//输出到浏览器
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header('Content-Disposition:inline;filename="' . $fileName . '"');
			header("Content-Transfer-Encoding: binary");
			header("Expires: Mon, 26 Jul 1984 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			$objWriter->save('php://output');
		}
	}


	/**
	 * excel导出
	 * 
	 * @param string	$fileName		文件名 save.xls
	 * @param array $keyList		字段名与标题对应关系
	 * @param array $arrData		要导出的数据
	 * @param bolean $isFile			true 保存文件 false 输出浏览器
	 * @param string $type			生成excel格式 excel2003 xls
	 */
	static function createWriter_he($fileName,$keyList,$arrData,$keyList2=array(),$tuan,$isFile=false,$type = 'Excel5') {
		require_once 'PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		require_once 'PHPExcel/IOFactory.php';
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$tuan['in_price']=(float)$tuan['in_price'];
		
		//将keyList 插入到要输出数组的第一个
		//设置标题
		$objWorksheet->mergeCells('E1:F1');
		$objWorksheet->setCellValue('E1',"财务对账单");//设置值
		$objWorksheet->getStyle("E1")->getFont()->setSize(14);
		$objWorksheet->getStyle("E1")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		$objWorksheet->getStyle("E1")->getFont()->setBold(true);

		//设置团信息
		$objWorksheet->setCellValue('A2',"团购名称:");//设置值
		$objWorksheet->getStyle("A2")->getFont()->setSize(12);
		$objWorksheet->getStyle("A2")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

		$objWorksheet->mergeCells('B2:D2');
		$objWorksheet->setCellValue('B2',$tuan['title']);//设置值

		$objWorksheet->setCellValue('F2',"商品编号:");//设置值
		$objWorksheet->getStyle("F2")->getFont()->setSize(12);
		$objWorksheet->getStyle("F2")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

		$objWorksheet->setCellValue('G2',$tuan['id']);//设置值

		$objWorksheet->setCellValue('A3',"团购详细:");//设置值
		$objWorksheet->getStyle("A3")->getFont()->setSize(12);
		$objWorksheet->getStyle("A3")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

		$objWorksheet->mergeCells('B3:L3');
		$objWorksheet->setCellValue('B3',$tuan['title_detail']);//设置值
		
		$objWorksheet->setCellValue('A4',"开团时间:");//设置值
		$objWorksheet->getStyle("A4")->getFont()->setSize(12);
		$objWorksheet->getStyle("A4")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

		$objWorksheet->setCellValue('B4',date("Y-m-d H:i:s",$tuan['begintime']));//设置值

		$objWorksheet->setCellValue('F4',"下架时间:");//设置值
		$objWorksheet->getStyle("F4")->getFont()->setSize(12);
		$objWorksheet->getStyle("F4")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

		$objWorksheet->setCellValue('G4',date("Y-m-d H:i:s",$tuan['overtime']));//设置值
		
		$objWorksheet->mergeCells('A6:L6');
		$objWorksheet->setCellValue('A6',"应收帐款明细");//设置值
		$objWorksheet->getStyle("A6")->getFont()->setSize(12);
		$objWorksheet->getStyle("A6")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);

		
		//生成列表头
		foreach ($keyList as $k => $v ){
			$objWorksheet->setCellValue(self::parseColumnNum($k)."7", $v);
		}
		//统计数据变量
		$p_num=0;$p_money=0;$ep_money=0;$to_money=0;$apliy_money=0;$kuai_money=0;$z_money=0;$t_num=0;
		//循环想数组写入excel
		foreach ( $arrData as $key => $value ) {
			$value['price']=(float)$value['price'];	$value['expressmoney']=(float)$value['expressmoney'];
			$value['pay_money']=(float)$value['pay_money'];$value['account_pay']=(float)$value['account_pay'];
			$row=$key+8;
			for($i=0;$i<18;$i++){
				$num = self::parseColumnNum($i);
				//序号
				if($num =="A"){
					$objWorksheet->setCellValue($num . $row, $key+1);
				}
				//订单编号
				if($num =="B"){
					$objWorksheet->setCellValue($num . $row," ".$value['order_id']);
					$objWorksheet->getStyle($num.$row)->getNumberFormat()->setFormatCode('@');
				}
				//销售单价
				if($num =="C"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$value['price']));
				}
				//购买数量
				if($num =="D"){
					$objWorksheet->setCellValue($num . $row,$value['product_num']);
					$p_num+=$value['product_num'];
					if($value['status']==5){
						$t_num+=$value['product_num'];
					}
				}
				//商品金额
				if($num =="E"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",($value['price']*$value['product_num'])));
					$p_money+=round($value['price']*$value['product_num'],2);
				}
				//快递费
				if($num =="F"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$value['expressmoney']));
					$ep_money+=$value['expressmoney'];
				}
				//是否积分兑换快递费
				if($num =="G"){
					$text = $value['expresstype']==1?"是":"否";
					$objWorksheet->setCellValue($num . $row,$text);
					if($value['expresstype']==1){
						$objWorksheet->getStyle($num . $row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					}
				}
				//优惠金额
				if($num =="H"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$value['yh_money']));
					$objWorksheet->getStyle($num . $row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				}
				//应付总金额
				if($num =="I"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$value['pay_money']));
					$objWorksheet->getStyle($num . $row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$to_money+=$value['pay_money'];
				}
				//账户付款
				if($num =="J"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$value['account_pay']));
					$objWorksheet->getStyle($num . $row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$z_money+=$value['account_pay'];
				}
				//在线支付
				if($num =="K"){
					$m=$value['pay_money']-$value['account_pay'];
					//if($value['expresstype']==1){
					//	$m=$m-$value['expressmoney'];
					//}
					if($value['paytype']==1){
						$apliy_money=$apliy_money+$m;
					}
					else if($value['paytype']==2){
						$kuai_money=$kuai_money+$m;
					}else{
						$apliy_money=$apliy_money+$m;
					}
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$m));
					$objWorksheet->getStyle($num . $row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				}
				//支付前余额
				if($num =="L"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$value['account_before']));
				}

				//账户余额
				if($num =="M"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$value['account_money']));
				}

				//付款方式
				if($num=="N"){
					$type_arr=array(1=>'支付宝',2=>'快钱',3=>'余额付款');
					if($value['account_pay']>0){
						if($value['account_pay']!=$value['pay_money']){
							if(floatval($m)>0){
								$objWorksheet->setCellValue($num.$row,"支付宝+账户");
							}else{
								$objWorksheet->setCellValue($num.$row,$type_arr[3]);
							}
						}else{
							$objWorksheet->setCellValue($num.$row,$type_arr[3]);
						}
					}else{
						$objWorksheet->setCellValue($num.$row,$type_arr[1]);
					}
				}
				//姓名
				if($num=="O"){
					$objWorksheet->setCellValue($num.$row,$value['user_name']);
				}
				//用户ID
				if($num=="P"){
					$objWorksheet->setCellValue($num.$row,$value['user_id']);
				}
				//手机号码
				if($num=="Q"){
					$objWorksheet->setCellValue($num.$row," ".$value['phone']);
				}
				//订单状态
				if($num=="R"){
					$status_array=array(2=>'已付款',4=>'已发货',5=>'已退款',7=>'交易完成',8=>'已收货',9=>"申请退款");
					$objWorksheet->setCellValue($num.$row,$status_array[$value['status']]);
					if($value['status']==5){
						$objWorksheet->getStyle($num . $row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					}
				}
				if($num=="S"){
					$objWorksheet->setCellValue($num.$row,$value['manager_msg']);
				}
			}
			$row++;
		}

		$r=8+count($arrData);
		$objWorksheet->setCellValue('C'.$r,"合计:");//设置值
		$objWorksheet->getStyle("C".$r)->getFont()->setSize(12);
		$objWorksheet->getStyle("C".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
		
		$objWorksheet->setCellValue("D".$r,$p_num);
		$objWorksheet->setCellValue("E".$r,sprintf("%01.2f",$p_money));
		$objWorksheet->setCellValue("F".$r,sprintf("%01.2f",$ep_money));
		$objWorksheet->setCellValue("I".$r,sprintf("%01.2f",$to_money));
		$objWorksheet->getStyle("I".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		$objWorksheet->setCellValue("J".$r,sprintf("%01.2f",$z_money));
		$objWorksheet->getStyle("J".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);

		$objWorksheet->setCellValue("K".$r,sprintf("%01.2f",$apliy_money));
		$objWorksheet->getStyle("K".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		$objWorksheet->setCellValue("N".$r,sprintf("%01.2f",$kuai_money));
		$objWorksheet->getStyle("N".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);

		$r=$r+2;
		$objWorksheet->setCellValue('A'.$r,"应付帐款");//设置值
		$objWorksheet->getStyle("A".$r)->getFont()->setSize(12);
		$objWorksheet->getStyle("A".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		$r++;
		
		//生成列表头
		foreach ($keyList2 as $k => $v ){
			$objWorksheet->setCellValue(self::parseColumnNum($k).$r, $v);
		}
		$r++;
		$objWorksheet->setCellValue('A'.$r,sprintf("%01.2f",$tuan['in_price']));
		$objWorksheet->setCellValue('B'.$r,$p_num-$t_num);//设置值
		$objWorksheet->setCellValue('C'.$r,sprintf("%01.2f", ($p_num-$t_num)*$tuan['in_price']));$r++;

		//$objWorksheet->setCellValue('H'.$r,"财务签字:");
		//$objWorksheet->getStyle("H".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		//$r=$r+2;

		//$objWorksheet->setCellValue('A'.$r,"收款方:");$objWorksheet->mergeCells('B'.$r.':C'.$r);
		//$objWorksheet->getStyle("A".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		//$objWorksheet->setCellValue('G'.$r,"电话(TEL):");$objWorksheet->mergeCells('H'.$r.':I'.$r);
		//$objWorksheet->getStyle("G".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);$r++;

		//$objWorksheet->setCellValue('A'.$r,"收款账户:");$objWorksheet->mergeCells('B'.$r.':I'.$r);
		//$objWorksheet->getStyle("A".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);$r++;

		//$objWorksheet->setCellValue('A'.$r,"预付款(%):");$objWorksheet->mergeCells('B'.$r.':C'.$r);
		//$objWorksheet->getStyle("A".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		//$objWorksheet->setCellValue('G'.$r,"最晚支付时间:");$objWorksheet->mergeCells('H'.$r.':I'.$r);
		//$objWorksheet->getStyle("G".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		//$r++;

		//$objWorksheet->setCellValue('A'.$r,"余款:");$objWorksheet->mergeCells('B'.$r.':C'.$r);
		//$objWorksheet->getStyle("A".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		//$objWorksheet->setCellValue('G'.$r,"最晚支付时间:");$objWorksheet->mergeCells('H'.$r.':I'.$r);
		//$objWorksheet->getStyle("G".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		if ($isFile == true) {
			//#TODO 生成文件的保存路径为设置
			//生成文件 
			$objWriter->save($fileName);
		} else {
			//输出到浏览器
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header('Content-Disposition:inline;filename="' . $fileName . '"');
			header("Content-Transfer-Encoding: binary");
			header("Expires: Mon, 26 Jul 1984 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			$objWriter->save('php://output');
		}
	}
	
	/**
	 * excel导出
	 * 
	 * @param string	$fileName		文件名 save.xls
	 * @param array $keyList		字段名与标题对应关系
	 * @param array $arrData		要导出的数据
	 * @param bolean $isFile			true 保存文件 false 输出浏览器
	 * @param string $type			生成excel格式 excel2003 xls
	 */
	static function createWriter_market($fileName,$keyList,$arrData,$isFile=false,$type = 'Excel5') {
		require_once 'PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		require_once 'PHPExcel/IOFactory.php';
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		
		//将keyList 插入到要输出数组的第一个
		//设置标题
		$objWorksheet->mergeCells('E1:F1');
		$objWorksheet->setCellValue('E1',"专场财务对账单");//设置值
		$objWorksheet->getStyle("E1")->getFont()->setSize(14);
		$objWorksheet->getStyle("E1")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		$objWorksheet->getStyle("E1")->getFont()->setBold(true);
		
		//生成列表头
		foreach ($keyList as $k => $v ){
			$objWorksheet->setCellValue(self::parseColumnNum($k)."2", $v);
		}
		//统计数据变量
		$p_num=0;$p_money=0;$ep_money=0;$to_money=0;$apliy_money=0;$kuai_money=0;$z_money=0;$t_num=0;
		//循环想数组写入excel
		foreach ( $arrData as $key => $value) {
			$value['price']=(float)$value['price'];	$value['expressmoney']=(float)$value['expressmoney'];
			$value['pay_money']=(float)$value['pay_money'];$value['account_pay']=(float)$value['account_pay'];
			$row=$key+3;
			for($i=0;$i<16;$i++){
				$num = self::parseColumnNum($i);
				//序号
				if($num =="A"){
					$objWorksheet->setCellValue($num . $row, $key+1);
				}
				//订单编号
				if($num =="B"){
					$objWorksheet->setCellValue($num . $row," ".$value['order_id']);
					$objWorksheet->getStyle($num.$row)->getNumberFormat()->setFormatCode('@');
				}
				//购买数量
				if($num =="C"){
					$objWorksheet->setCellValue($num . $row,$value['product_num']);
					$p_num+=$value['product_num'];
					if($value['status']==5){
						$t_num+=$value['product_num'];
					}
				}
				//快递费
				if($num =="D"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$value['expressmoney']));
					$ep_money+=$value['expressmoney'];
				}
				//是否积分兑换快递费
				if($num =="E"){
					$text = $value['expresstype']==1?"是":"否";
					$objWorksheet->setCellValue($num . $row,$text);
					if($value['expresstype']==1){
						$objWorksheet->getStyle($num . $row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					}
				}
				//应付总金额
				if($num =="F"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$value['pay_money']));
					$objWorksheet->getStyle($num . $row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$to_money+=$value['pay_money'];
				}
				//账户付款
				if($num =="G"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$value['account_pay']));
					$objWorksheet->getStyle($num . $row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$z_money+=$value['account_pay'];
				}
				//在线支付
				if($num =="H"){
					$m=$value['pay_money']-$value['account_pay'];
					//if($value['expresstype']==1){
					//	$m=$m-$value['expressmoney'];
					//}
					if($value['paytype']==1){
						$apliy_money=$apliy_money+$m;
					}
					else if($value['paytype']==2){
						$kuai_money=$kuai_money+$m;
					}else{
						$apliy_money=$apliy_money+$m;
					}
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$m));
					$objWorksheet->getStyle($num . $row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				}
				//支付前余额
				if($num =="I"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$value['account_before']));
				}

				//账户余额
				if($num =="J"){
					$objWorksheet->setCellValue($num . $row,sprintf("%01.2f",$value['account_money']));
				}

				//付款方式
				if($num=="K"){
					$type_arr=array(1=>'支付宝',2=>'快钱',3=>'余额付款');
					if($value['account_pay']>0){
						if($value['account_pay']!=$value['pay_money']){
							if(floatval($m)>0){
								$objWorksheet->setCellValue($num.$row,"支付宝+账户");
							}else{
								$objWorksheet->setCellValue($num.$row,$type_arr[3]);
							}
						}else{
							$objWorksheet->setCellValue($num.$row,$type_arr[3]);
						}
					}else{
						$objWorksheet->setCellValue($num.$row,$type_arr[1]);
					}
				}
				//姓名
				if($num=="L"){
					$objWorksheet->setCellValue($num.$row,$value['user_name']);
				}
				//用户ID
				if($num=="M"){
					$objWorksheet->setCellValue($num.$row,$value['user_id']);
				}
				//手机号码
				if($num=="N"){
					$objWorksheet->setCellValue($num.$row," ".$value['phone']);
				}
				//订单状态
				if($num=="O"){
					$status_array=array(2=>'已付款',4=>'已发货',5=>'已退款',7=>'交易完成',8=>'已收货',9=>"申请退款");
					$objWorksheet->setCellValue($num.$row,$status_array[$value['status']]);
					if($value['status']==5){
						$objWorksheet->getStyle($num . $row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					}
				}
				if($num=="P"){
					$objWorksheet->setCellValue($num.$row,$value['manager_msg']);
				}
			}
			$row++;
		}

		$r=3+count($arrData);
		$objWorksheet->setCellValue('A'.$r,"合计:");//设置值
		$objWorksheet->getStyle("A".$r)->getFont()->setSize(12);
		$objWorksheet->getStyle("A".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
		
		$objWorksheet->setCellValue("C".$r,$p_num);
		$objWorksheet->setCellValue("D".$r,sprintf("%01.2f",$ep_money));
		$objWorksheet->setCellValue("F".$r,sprintf("%01.2f",$to_money));
		$objWorksheet->getStyle("F".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		$objWorksheet->setCellValue("G".$r,sprintf("%01.2f",$z_money));
		$objWorksheet->getStyle("G".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);

		$objWorksheet->setCellValue("H".$r,sprintf("%01.2f",$apliy_money));
		$objWorksheet->getStyle("H".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		$objWorksheet->setCellValue("I".$r,sprintf("%01.2f",$kuai_money));
		$objWorksheet->getStyle("I".$r)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		
		if ($isFile == true) {
			//#TODO 生成文件的保存路径为设置
			//生成文件 
			$objWriter->save($fileName);
		} else {
			//输出到浏览器
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header('Content-Disposition:inline;filename="' . $fileName . '"');
			header("Content-Transfer-Encoding: binary");
			header("Expires: Mon, 26 Jul 1984 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			$objWriter->save('php://output');
		}
	}

	static function createReader($fileName, $keyList, $type = 'Excel5') {
		require_once 'PHPExcel/IOFactory.php';
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load($fileName);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		
		//字段名与标题对应关系的字段名提取出来
		$keyList = array_keys($keyList);
		
		$arr = array();
		foreach ( $objWorksheet->getRowIterator() as $key => $row ) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
			$arr[$key] = array();
			foreach ( $cellIterator as $k => $cell ) {
				//将值赋予相应的字段名
				$arr[$key][$keyList[$k]] = trim($cell->getValue());
			}
		}
		//删除第一个元素（从excel读取的标题）
		array_shift($arr);
		return $arr;
	}
	/**
	 * 索引转变为字母（10进制转换为26进制）
	 * 比如0=A, 1=>B, 26=>AA
	 * @param int $j
	 * @return str
	 */
	static function parseColumnNum($j) {
		$tempCellAsc = '';
		if ($j > 25) {
			$multiple = floor($j / 26) - 1;
			$residue = $j % 26;
			$tempCellAsc = self::parseColumnNum($multiple) . self::parseColumnNum($residue);
		} else {
			$tempCellAsc = chr($j + 65);
		}
		return $tempCellAsc;
	}
}

/*example*
//字段名与标题对应关系
$keyList = array(
		'name' => ' 姓名', 
		'sex' => '性别');
//要写入的数据
$arrData = array(
		array(
				'name' => '张三', 
				'sex' => '男'), 
		array(
				'name' => '李四', 
				'sex' => '女'), 
		array(
				'name' => 'xxx', 
				'sex' => 'x'), 
		array(
				'name' => 'xxx', 
				'sex' => 'x'));

//写入excel
//ShippingAddressExcel::createWriter('save.xls', $keyList, $arrData);


//读取excel
//$inputData = ShippingAddressExcel::createReader('save.xls', $keyList);
//print_r($inputData);
/**/
		
?>