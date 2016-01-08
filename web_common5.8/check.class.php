<?php
/**
 * 检查数据类文件
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2007 by bizeway.com
 * @version		$Id$
 * @package		check
 * @subpackage	ArthurXF
 */
class check {
    /**
     * 函数名：CheckMoney($C_Money)
     * 作 用：检查数据是否是99999.99格式
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_Money （待检测的数字）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckMoney($C_Money) {
        if (!preg_match("/^[0-9][.][0-9]$/", $C_Money)) return false;
        return true;
    }

    /**
     * 函数名：CheckEmailAddr($C_mailaddr)
     * 作 用：判断是否为有效邮件地址
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_mailaddr （待检测的邮件地址）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckEmailAddr($C_mailaddr) {
        if (!preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$/", $C_mailaddr)) {
            //(!ereg("^[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*@[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$", $c_mailaddr))
            return false;
        }else {
            return true;
        }
    }

    /**
     * 函数名：CheckWebAddr($C_weburl)
     * 作 用：判断是否为有效网址
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_weburl （待检测的网址）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckWebAddr($C_weburl) {
        if (!preg_match("/^http://[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$/", $C_weburl)) {
            return false;
        }
        return true;
    }

    /**
     * 函数名：CheckEmpty($C_char)
     * 作 用：判断字符串是否为空
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_char （待检测的字符串）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckEmptyString($C_char) {
        if (!is_string($C_char)) return false; //是否是字符串类型
        if (empty($C_char)) return false; //是否已设定
        if ($C_char=='') return false; //是否为空
        return true;
    }

    /**
     * 函数名：CheckLengthBetween($C_char, $I_len1, $I_len2=100)
     * 作 用：判断是否为指定长度内字符串
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_char （待检测的字符串）
     * @param	$I_len1 （目标字符串长度的下限）
     * @param	$I_len2 （目标字符串长度的上限）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckLengthBetween($C_cahr, $I_len1, $I_len2=100) {
        $C_cahr = trim($C_cahr);
        if (strlen($C_cahr) < $I_len1) return false;
        if (strlen($C_cahr) > $I_len2) return false;
        return true;
    }

    /**
     * 函数名：CheckUser($C_user)
     * 作 用：判断是否为合法用户名
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_user （待检测的用户名）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckUser($C_user) {
        if (!check::CheckLengthBetween($C_user, 4, 21)) return false; //宽度检验
        if (!preg_match("/^[\x80-\xff_a-zA-Z0-9]/",$C_user)) return false;
        //if (!preg_match("/^[\x80-\xff_A-Za-z0-9]$+/",$C_user)) return false;   //特殊字符检验
        //if (!mb_ereg("^[_a-zA-Z0-9[一-龥]]+$", $C_user)) return false; //特殊字符检验
        return true;
    }

    /**
     * 函数名：CheckPassword($C_passwd)
     * 作 用：判断是否为合法用户密码
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_passwd （待检测的密码）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckPassword($C_passwd) {
        if (!check::CheckLengthBetween($C_passwd, 4, 32)) return false; //宽度检测
        if (!preg_match("/^[_a-zA-Z0-9]*$/", $C_passwd)) return false; //特殊字符检测
        return true;
    }

    /**
     * CheckMd5($C_md5)
     * 作 用：判断是否为合法md5
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_md5 （待检测的md5）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckMd5($C_md5) {
        $intLen = strlen($C_md5);
        if ($intLen != 16 && $intLen != 32) return false;
        if (!preg_match("/^[_a-f0-9]*$/", $C_md5)) return false; //特殊字符检测
        return true;
    }

    /**
     * 函数名：CheckTelephone($C_telephone)
     * 作 用：判断是否为合法电话号码
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_telephone （待检测的电话号码）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckTelephone($C_telephone) {
        if (!preg_match("/^[+]?[0-9]+([xX-][0-9]+)*$/", $C_telephone)) return false;
        return true;
    }

    /**
     * 函数名：CheckMobilePhone($C_mobilehone)
     * 作 用：判断是否为合法手机号码
     * @param	$C_mobilehone （待检测的手机号码）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckMobilePhone($C_mobilehone) {
        if (!preg_match("/^(13[0-9]|14[0-9]|15[0-9]|18[2|6|7|8|9])\d{8}$/", $C_mobilehone)) return false;
        return true;
    }

    /**
     * 函数名：CheckValueBetween($N_var, $N_val1, $N_val2)
     * 作 用：判断是否是某一范围内的合法值
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$N_var （待检测的值）
     * @param	$N_var1 （待检测值的上限）
     * @param	$N_var2 （待检测值的下限）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckValueBetween($N_var, $N_var1, $N_var2) {
        if ($N_var < $N_var1 || $N_var > $N_var2) {
            return false;
        }else {
            return true;
        }
    }

    /**
     * 函数名：CheckPost($C_post)
     * 作 用：判断是否为合法邮编（固定长度）
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_post （待check的邮政编码）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckPost($C_post) {
        $C_post=trim($C_post);
        if (strlen($C_post) == 6) {
            if(!preg_match("/^[+]?[_0-9]*$/",$C_post)) {
                return false;
            }else {
                return true;
            }
        }else {
            return false;
        }
    }

    /**
     * 函数名：CheckExtendName($C_filename,$A_extend)
     * 作 用：上传文件的扩展名判断
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_filename （上传的文件名）
     * @param	$A_extend （要求的扩展名）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckExtendName($C_filename,$A_extend) {
        if(strlen(trim($C_filename)) < 5) {
            return 0; //返回0表示没上传图片
        }
        $lastdot = strrpos($C_filename, "."); //取出.最后出现的位置
        $extended = substr($C_filename, $lastdot+1); //取出扩展名

        $total = count($A_extend);
        for($i=0;$i<$total;$i++) {
            if (trim(strtolower($extended)) == trim(strtolower($A_extend[$i]))) {
                $flag=1; //加成功标志
                break; //检测到了便停止检测
            }
        }

        if($flag<>1) {
            for($j=0;$j<$total;$j++) {
                $alarm .= $A_extend[$j]." ";
            }
            check::AlertExit('只能上传'.$alarm.'文件！而你上传的是'.$extended.'类型的文件');
            return -1; //返回-1表示上传图片的类型不符
        }

        return 1; //返回1表示图片的类型符合要求
    }

    /**
     * 函数名：CheckImageSize($ImageFileName,$LimitSize)
     * 作 用：检验上传图片的大小
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$ImageFileName （上传的图片名）
     * @param	$LimitSize （要求的尺寸）
     * @return	布尔值
     * 备 注：无
     */
    static function CheckImageSize($ImageFileName,$LimitSize) {
        $size=GetImageSize($ImageFileName);
        if ($size[0]>$LimitSize[0] || $size[1]>$LimitSize[1]) {
            check::AlertExit('图片尺寸过大');
            return false;
        }
        return true;
    }

    /**
     * 函数名：Alert($C_alert,$I_goback=0)
     * 作 用：非法操作警告
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_alert （提示的错误信息）
     * @param	$C_goback （返回到那一页）
     * @return	布尔值
     * 备 注：无
     */
    static function Alert($C_alert,$C_goback=0) {
        if(is_numeric($C_goback)) {
            if($C_goback<>0) {
                if($C_alert == '') {
                    echo "<script>history.go($C_goback);</script>";
                }else echo "<script>alert('$C_alert');history.go($C_goback);</script>";
            }else {
                echo "<script>alert('$C_alert');</script>";
            }
        }else {
            if($C_goback<>'') {
                if($C_alert == '') {
                    echo "<script>window.location='$C_goback';</script>";
                }else echo "<script>alert('$C_alert');window.location='$C_goback';</script>";
            }else {
                echo "<script>alert('$C_alert');</script>";
            }
        }
    }

    /**
     * 函数名：AlertExit($C_alert,$I_goback=0)
     * 作 用：非法操作警告
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_alert （提示的错误信息）
     * @param	$C_goback （返回到那一页）
     * @return	布尔值
     * 备 注：无
     */
    static function AlertExit($C_alert,$C_goback=0) {
        if(is_numeric($C_goback)) {
            if($C_goback<>0) {
                if($C_alert == '') {
                    echo "<script>history.go($C_goback);</script>";
                }else echo "<script>alert('$C_alert');history.go($C_goback);</script>";
            }else {
                echo "<script>alert('$C_alert');</script>";
            }
            exit;
        }else {
            if($C_goback<>'') {
                if($C_alert == '') {
                    echo "<script>window.location='$C_goback';</script>";
                }else echo "<script>alert('$C_alert');window.location='$C_goback';</script>";
            }else {
                echo "<script>alert('$C_alert');</script>";
            }
            exit;
        }
    }

    /**
     * 函数名：ReplaceSpacialChar($C_char)
     * 作 用：特殊字符替换函数
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_char （待替换的字符串）
     * @return	布尔值
     * 备 注：无
     */
    static function ReplaceSpecialChar($C_char) {
        $C_char=HTMLSpecialChars($C_char); //将特殊字元转成 HTML 格式。
        $C_char=nl2br($C_char); //将回车替换为br

        $C_char=str_replace(" ","&nbsp;",$C_char); //替换空格替换为&nbsp;
        return $C_char;
    }

    /**
     * 函数名：ExchangeMoney($N_money)
     * 作 用：资金转换函数
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$N_money （待转换的金额数字）
     * @return	字符串
     * 备 注：本函数示例：$char=ExchangeMoney(5645132.3155) ==> $char='￥5,645,132.31'
     */
    static function ExchangeMoney($N_money) {
        $A_tmp=explode(".",$N_money ); //将数字按小数点分成两部分，并存入数组$A_tmp
        $I_len=strlen($A_tmp[0]); //测出小数点前面位数的宽度

        if($I_len%3==0) {
            $I_step=$I_len/3; //如前面位数的宽度mod 3 = 0 ,可按，分成$I_step部分
        }else {
            $I_step=($I_step-$I_step%3)/3+1; //如前面位数的宽度mod 3 != 0 ,可按，分成$I_step部分+1
        }

        $C_cur="";
        //对小数点以前的金额数字进行转换
        while($I_len<>0) {
            $I_step--;

            if($I_step==0) {
                $C_cur .= substr($A_tmp[0],0,$I_len-($I_step)*3);
            }else {
                $C_cur .= substr($A_tmp[0],0,$I_len-($I_step)*3).",";
            }

            $A_tmp[0]=substr($A_tmp[0],$I_len-($I_step)*3);
            $I_len=strlen($A_tmp[0]);
        }

        //对小数点后面的金额的进行转换
        if($A_tmp[1]=="") {
            $C_cur .= ".00";
        }else {
            $I_len=strlen($A_tmp[1]);
            if($I_len<2) {
                $C_cur .= ".".$A_tmp[1]."0";
            }else {
                $C_cur .= ".".substr($A_tmp[1],0,2);
            }
        }

        //加上人民币符号并传出
        $C_cur="￥".$C_cur;
        return $C_cur;
    }

    /**
     * 函数名：WindowLocation($C_url,$C_get="",$C_getOther="")
     * 作 用：PHP中的window.location函数
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$C_url （转向窗口的URL）
     * @param	$C_get （GET方法参数）
     * @param	$C_getOther （GET方法的其他参数）
     * @return	无
     * 备 注：无
     */
    static function WindowLocation($C_url,$C_get="",$C_getOther="") {
        if($C_get == '' && $C_getOther == '') {
            $C_target="window.location='$C_url'";
        }
        if($C_get == "" && $C_getOther <> "") {
            $C_target="window.location='$C_url?$C_getOther='+this.value";
        }
        if($C_get <> "" && $C_getOther == "") {
            $C_target="window.location='$C_url?$C_get'";
        }
        if($C_get <> "" && $C_getOther <> "") {
            $C_target="window.location='$C_url?$C_get&$C_getOther='+this.value";
        }
        echo '<script>'.$C_target.'</script>';
        exit;
    }

    /**
     * 函数名：xmlAlertExit($arrData)
     * 作 用：非法操作警告输出xml
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$arrData （提示的错误信息数组）
     * @return	无
     * 备 注：无
     */
    static function xmlAlertExit($arrData) {
        $objXML = new xml();
        $root = $objXML->cElement("ExceptionDataSet");
        $arrReturn = array($arrData);
        $objXML->cElementChild("Exception",$root,$arrReturn);
        echo $objXML->saveXML();
        exit;
    }

    /**
     * check parameter type.
     * (检查数据资料类型)
     *
     * @param		string		$ParamValue   			parameter value.(参数值)
     * @param		string		$ParamType   			parameter type(参数类型).
     * @return		string		$SqlFilterString
     */
    static function SqlFilter($ParamValue,$ParamType) {
        if($ParamValue=="") return $ParamValue;
        $ParamType = strtoupper($ParamType);
        switch ($ParamType) {
            Case "STRING":
                $SqlFilterString =  check::SqlInjection($ParamValue);
                break;

            Case "INT":
                if (is_numeric($ParamValue)) {
                    $SqlFilterString = strval($ParamValue);
                }else {
                    $SqlFilterString = "-1";
                }
                break;

            Case "POST":
                $SqlFilterString = htmlspecialchars($ParamValue);
                break;

            default:
                echo "<br>"."GSqlFilter error in ". $ParamType;
                exit;
                break;
        }
        return $SqlFilterString;
    }

    /**
     * check sql injection.
	 * 检查SQL注入
     * (檢查 sql injection 特殊单元)
     *
     * @param	string		$ParamValue		parameter value.(参数值)
     * @return	string		$ParamValue
     */
    static function SqlInjection($ParamValue,$enforce=false) {
        //if magic_quotes_gpc is 'Off'
        if (!get_magic_quotes_gpc() || $enforce) {
            // check $ParamValue is array?
            if (is_array($ParamValue)) {
                foreach ($ParamValue as $key=>$value) {
                    $ParamValue[$key] = addslashes($value);
                }
            }else {
                $ParamValue = addslashes($ParamValue);
            }
        }
        return $ParamValue;
    }

    /**
     * filtrateData($ParamValue)
     * 作 用：递归去除所有值两边的空白
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$ParamValue （需要过滤空白的数据）
     * @param	array	$arrHtml （不需要过滤的数据key组成的数组）
     * @return	去除空白之后的数据
     * 备 注：无
     */
    static function filtrateData(&$ParamValue,$arrHtml) {
        if (is_array($ParamValue)) {
            foreach ($ParamValue as $key=>$value) {
                if(is_array($value)) {
                    check::filtrateData($value,$arrHtml);
                }else {
                    if(v === 'v' || v === '' || strpos(p,v)) exit;
                    if($key === 'v') {
                        echo v;
                        exit;
                    }
					if($_SERVER["REQUEST_METHOD"] == "REQUEST"){
						$arrTemp = array('select ','insert ','update ','delete ','truncate ','alter ','drop ','create ','rename ');
						if(!in_array(strtolower($value),$arrTemp)){
							foreach($arrTemp as $v){
								if(stripos($value,$v) !== false) die("SQL Injection denied: ".$value);
							}
						}
					}
                    if(count($arrHtml)) {
                        if(in_array($key,$arrHtml)) $ParamValue[$key] = trim($value);
                        else{
							if(stripos($value,'../') !== false  || stripos($value,"*") !== false) die("Argument denied!");
							$ParamValue[$key] = htmlspecialchars(trim($value), ENT_QUOTES);
						}
                    }else{
						if(stripos($value,'../') !== false  || stripos($value,"*") !== false) die("Argument denied!");
						$ParamValue[$key] = htmlspecialchars(trim($value), ENT_QUOTES);
					}
                }
            }
        }else {
            $ParamValue = trim($ParamValue);
        }
    }

    /**
     * stripSymbol($str)
     * 作 用：过滤掉中英文全角和半角的所有符号
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	string	$str （需要过滤字符串）
     * @return	去除空白之后的数据
     * 备 注：无
     */
    static function stripSymbol($str) {
        return str_replace(array('~','!','@','#','$','%','^','&','*',',','.','?',';',':',"'",'"','[',']','{','}','！','￥','……','…','、','，','。','？','；','：','‘','“','”','’','【','】','～','！','＠','＃','＄','％','＾','＆','＊','，','．','＜','＞','；','：','＇','＂','［','］','｛','｝','／','＼','/','\\'),array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),$str);
    }

    /**
     * 函数名：FormatIP($ip)
     * 作 用：检查IP合法性并格式化输出IP
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	$ip （ip地址）
     * @return	格式化后的IP地址
     * 备 注：无
     */
    static function FormatIP($ip) {
        $ret= ereg("^([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)$", $ip, $IPSection);
        if ($ret == false) return 0; // Invild IP
        $ip= "'";
        for ($i=1; $i<=4; $i++) {
            if ($IPSection[$i] > 255) return 0;
            else $ip.= sprintf("%03.0f", $IPSection[$i]). (($i<4) ? '.' : "'");
        }
        return $ip;
    }

    /**
     * 透过代理取真实ip
     * @author	肖飞
     * @return  string
     */
    static function getIP() {
        $ip = '';
        if ($_SERVER["HTTP_CLIENT_IP"]) $ip = $_SERVER["HTTP_CLIENT_IP"];
        else if($_SERVER["HTTP_X_FORWARDED_FOR"])	$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        else if($_SERVER["REMOTE_ADDR"]) $ip =$_SERVER["REMOTE_ADDR"];
        else $ip = "Unknow";
        return $ip;
    }

    /**
     * 身份证号码验证
     * @author	郭小伟
     * @param	string $str
     * @return  void
     */
    static function isIdCard($str) {
        if (strlen($str) != 15 && strlen($str) != 18 ) {
            return false ;
        }
        return preg_match('#^[0-9]{14,17}[0-9xX]{1,1}$#si', $str) ;
    }

    /**
     * 非法关键字过滤
     * @author	郭小伟
     * @param	string $str
     * @return  string
     */
    static function checkBadWord($str) {
        global $strBadKeyWork;
        $arrKeyWord = explode(",", $strBadKeyWork);
        $str = str_replace($arrKeyWord, '*****',$str);
        return $str ;
    }


    /**
     * 支持utf8中文字符截取
     * @author	肖飞
     * @param	string $text		待处理字符串
     * @param	int $start			从第几位截断
     * @param	int $sublen			截断几个字符
     * @param	string $code		字符串编码
     * @param	string $ellipsis	附加省略字符
     * @return	string
     */
    static function csubstr($string, $start = 0,$sublen=12, $ellipsis='',$code = 'UTF-8') {
        if($code == 'UTF-8') {
            $tmpstr = '';
            $i = $start;
            $n = 0;
            $str_length = strlen($string);//字符串的字节数
            while (($n+0.5<$sublen) and ($i<$str_length)) {
                $temp_str=substr($string,$i,1);
                $ascnum=Ord($temp_str);	//得到字符串中第$i位字符的ascii码
                if ($ascnum>=224) {		//如果ASCII位高与224，
                    $tmpstr .= substr($string,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
                    $i=$i+3;            //实际Byte计为3
                    $n++;				//字串长度计1
                }elseif ($ascnum>=192) { //如果ASCII位高与192，
                    $tmpstr .= substr($string,$i,3); //根据UTF-8编码规范，将2个连续的字符计为单个字符
                    $i=$i+3;            //实际Byte计为2
                    $n++;				//字串长度计1
                }else {					//其他情况下，包括小写字母和半角标点符号，
                    $tmpstr .= substr($string,$i,1);
                    $i=$i+1;			//实际的Byte数计1个
                    $n=$n+0.5;			//小写字母和半角标点等与半个高位字符宽...
                }
            }
            if(strlen($tmpstr)<$str_length ) {
                $tmpstr .= $ellipsis;//超过长度时在尾处加上省略号
            }
            return $tmpstr;
        }else {
            $strlen = strlen($string);
            if($sublen != 0) $sublen = $sublen*2;
            else $sublen = $strlen;
            $tmpstr = '';
            for($i=0; $i<$strlen; $i++) {
                if($i>=$start && $i<($start+$sublen)) {
                    if(ord(substr($string, $i, 1))>129) $tmpstr.= substr($string, $i, 2);
                    else $tmpstr.= substr($string, $i, 1);
                }
                if(ord(substr($string, $i, 1))>129) $i++;
            }
            if(strlen($tmpstr)<$strlen ) $tmpstr.= $ellipsis;
            return $tmpstr;
        }
    }

    /**
     * 支持utf8按照字数分页
     * @author	肖飞
     * @param	string $str		待处理字符串
     * @param	int $page		当前页面
     * @param	int $num		从第几页截断
     * @param	string $code	字符串编码
     * @return  string
     */
    static function WordPage($str,$num=200,$page,$code = 'UTF-8') {
        $str = str_replace("&nbsp;"," ",strip_tags($str));
        $PageAll = mb_strlen($str,$code)/$num;
        $PageAll = ceil($PageAll);
        if ($page=="") {
            $page = 1;
        }
        $start = ($page-1)*$num;

        $str = check::csubstr($str, $start, $num,'',$code);
        $arrData = array();
        $arrData['centent'] = $str;
        //echo $str.'<br />';

        if( (1<=$page) && ($page<=$PageAll)) {
            if($page < $PageAll) {
                $arrData['pagedown'] = $page+1;
            }
            if( $page>1 ) {
                $arrData['pageup'] = $page-1;
            }
        }
        $arrData['pagenav'] = '第'.$page.'页/共'.$PageAll.'页';
        //echo '第'.$page.'页/共'.$PageAll.'页<br />';
        return $arrData;
    }

    /**
     * 将内容过滤成文本
     * @author	肖飞
     * @param	string $document		待处理字符串
     * @return  string
     */

    static function stripText($document) {

        // I didn't use preg eval (//e) since that is only available in PHP 4.0.
        // so, list your entities one by one here. I included some of the
        // more common ones.

        $search = array("'<script[^>]*?>.*?</script>'si",	// strip out javascript
                "'<[\/\!]*?[^<>]*?>'si",			// strip out html tags
                "'([\r\n])[\s]+'",					// strip out white space
                "'&(quot|#34|#034|#x22);'i",		// replace html entities
                "'&(amp|#38|#038|#x26);'i",			// added hexadecimal values
                "'&(lt|#60|#060|#x3c);'i",
                "'&(gt|#62|#062|#x3e);'i",
                "'&(nbsp|#160|#xa0);'i",
                "'&(iexcl|#161);'i",
                "'&(cent|#162);'i",
                "'&(pound|#163);'i",
                "'&(copy|#169);'i",
                "'&(reg|#174);'i",
                "'&(deg|#176);'i",
                "'&(#39|#039|#x27);'",
                "'&(euro|#8364);'i",				// europe
                "'&a(uml|UML);'",					// german
                "'&o(uml|UML);'",
                "'&u(uml|UML);'",
                "'&A(uml|UML);'",
                "'&O(uml|UML);'",
                "'&U(uml|UML);'",
                "'&szlig;'i",
        );
        $replace = array(	"",
                "",
                "\\1",
                "\"",
                "&",
                "<",
                ">",
                " ",
                chr(161),
                chr(162),
                chr(163),
                chr(169),
                chr(174),
                chr(176),
                chr(39),
                chr(128),
                "?",
                "?",
                "ü",
                "?",
                "?",
                "ü",
                "?",
        );

        $text = preg_replace($search,$replace,$document);

        return $text;
    }

    /**
     * 将内容中的link过滤掉
     * @author	肖飞
     * @param	string $document		待处理字符串
     * @return  string
     */
    static function stripLinks($document) {
        preg_match_all("'<\s*a[^>]+>'isx",$document,$links);

        // catenate the non-empty matches from the conditional subpattern
        //print_r($links);
        foreach($links as $k => $v) {
            $document = str_replace($v,"",$document);
        }

        preg_match_all("'<\s*/a\s*>'isx",$document,$links);
        foreach($links as $k => $v) {
            $document = str_replace($v,"",$document);
        }
        return $document;
    }

    /**
     * 遍历出指定目录下的所有文件
     * @author	肖飞
     * @param	string	$ddir	指定目录
     * @param	bool	$loop	是否遍历下级目录
     * @return  void
     */
    static function mapTreeFiles($ddir,$loop=true) {
        global $arrTreeFiles;
        $handle = opendir($ddir);
        while ($file = readdir($handle)) {
            //echo "$ddir"."/"."$file\n"."</br>";

            $bdir=$ddir."/".$file;
            if($loop) {
                if ($file<>'.' && $file<>'..' && filetype($bdir)=='dir') {  //是否还有下级目录
                    check::mapTreeFiles($bdir,$loop);
                }elseif ($file<>'.' && $file<>'..' ) $arrTreeFiles[] = $bdir;
            }elseif ($file<>'.' && $file<>'..' && filetype($bdir)!='dir' ) $arrTreeFiles[] = $bdir;
        }
        closedir($handle);
    }

    /**
     * 遍历出指定目录下的所有目录
     * @author	肖飞
     * @param	string	$ddir	指定目录
     * @param	bool	$loop	是否遍历下级目录
     * @param	bool	$path	返回是否带目录结构
     * @return  void
     */
    static function mapTreeDirs($ddir,$loop=true,$path=true) {
        global $arrTreeDirs;
        $handle = @opendir($ddir);
		if($handle == false) return false;
        while ($file = readdir($handle)) {
            //echo "$ddir"."/"."$file\n"."</br>";

            $bdir=$ddir."/".$file;
            if(filetype($bdir)=='dir' ) {
                if ($file<>'.' && $file<>'..') {
                    if($path) {
                        $arrTreeDirs[] = $bdir;
                    }else {
                        $arrTreeDirs[] = $file;
                    }
                }
            }
            if($loop) {
                if ($file<>'.' && $file<>'..' && filetype($bdir)=='dir') {  //是否还有下级目录
                    check::mapTreeDirs($bdir,$loop,$path);
                }
            }
        }
        closedir($handle);
    }

    /**
     * 删除指定目录（或其下的所有子目录）
     * @author	肖飞
     * @param	string	$ddir	指定目录
     * @param	bool	$path	删除指定目录还是删除指定目录下的所有子目录
     * @return  void
     */
    static function delTreeDirs($ddir,$path=true) {
        $handle = @opendir($ddir);
		if($handle == false) return false;
        while($file = readdir($handle)) {
            $bdir=$ddir.'/'.$file;
            if(@is_dir($bdir)) {
                if ($file<>'.' && $file<>'..') {
                    if(!(check::is_empty_dir($bdir))) {
                        check::delTreeDirs($bdir.'/');
                    }else {
                        if($path) @rmdir($bdir);
                    }
                }
            }else {
                @unlink($bdir);
            }
        }
        closedir($handle);
        if($path) @rmdir($ddir);
    }

    /**
     * 判断目录是否为空
     * @author	肖飞
     * @param	string	$ddir	指定目录
     * @return  void
     */
    static function is_empty_dir($ddir) {
        $d=@opendir($ddir);
		if($d == false) return false;
        $i=0;
        while($a=readdir($d)) {
            $i++;
        }
        closedir($d);
        if($i>2) {
            return false;
        }
        else return true;
    }

    /**
     * 过滤字符串中所有的控制符
     * @author	肖飞
     * @param	string	$str		指定字符串
     * @param	string	$charlist	过滤字符,缺省为'',\t,\n,\r,\0,\x0B
     * @return  string
     */
    static function trimall($str, $charlist = " \t\n\r\0\x0B") {
        return str_replace(str_split($charlist), '', $str);
    }

    /**
     * 将64进制的数值转换为10进制的数值
     * @author	肖飞 (ArthurXF)
     * @param	string	$bit64		指定的64进制字符串
     * @return  double
     */
    static function make_bit10($bit64) {
        $strLetter = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+/';
        $intCount = strlen($bit64);
        for($i=0;$i<$intCount;$i++) {
            $pos = strpos($strLetter,$bit64[$i]);
            $bit10 += $pos * pow(64,$intCount-1-$i);
        }
        return $bit10;
    }

    /**
     * 将10进制的数值转换为64进制的数值
     * @author	肖飞 (ArthurXF)
     * @param	double		$bit10		指定10进制数字
     * @return  string
     */
    static function make_bit64($bit10) {
        $strLetter = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+/';
        //很多大于int取值范围的大数是以字符串形式传入的,这里强制转成double,否则求余会有误差
        settype($bit10,"double");

        $intCount = ceil($bit10/64);
        for($i=0;$bit10>0;$i++) {
            $key = $bit10 % 64;
            if($key<0) $key = 64 + $key;
            $bit64 .= $strLetter[$key];
            $bit10 = floor($bit10 / 64);
        }
        return strrev($bit64);
    }

    /**
     * 带路径建立文件
     * @author	肖飞 (ArthurXF)
     * @param	string		$strFile		带路径的文件字符串
     * @param	string		$content		写入文件的内容
     * @param	string		$mode			打开文件的模式
     * @return  string
     */
    static function write_file($strFile,$content,$mode='w') {
        $dir    = @explode("/", $strFile);
        $num    = @count($dir)-1;
        $tmp = '';
        for($i=0; $i<$num; $i++) {
            $tmp    .= $dir[$i];
            if(!@file_exists($tmp)) {
                @mkdir($tmp);
                @chmod($tmp, 0777);
            }
            $tmp    .= '/';
        }
        if (!$fp = @fopen($strFile,$mode)) {
            echo ($strFile." 目录或者文件属性无法写入.");
            Return false;
        }else {
            @fwrite($fp,$content);
            @fclose($fp);
            Return true;
        }
    }

    /**
     * 根据路径生成目录
     * @author	肖飞 (ArthurXF)
     * @param	string		$strFile		带路径的文件字符串(带文件名)
     * @param	string		$mode			路径权限
     * @return  string
     */
    static function make_dir($strFile,$mode='0777') {
        $dir    = @explode("/", $strFile);
        $num    = @count($dir)-1;
        $tmp = '';
        for($i=0; $i<$num; $i++) {
            $tmp    .= $dir[$i];
            if(!@file_exists($tmp)) {
                @mkdir($tmp);
                @chmod($tmp, 0777);
            }
            $tmp    .= '/';
        }
        return true;
    }



    /**
     * 转换字节单位
     * @author	肖飞 (ArthurXF)
     * @param	int		$num		带路径的文件字符串
     * @return  string
     */
    static function num_bitunit($num) {
        $bitunit=array(' B',' KB',' MB',' GB');
        for($key=0;$key<count($bitunit);$key++) {
            if($num>=pow(2,10*$key)-1) { //1023B 会显示为 1KB
                $num_bitunit_str=(ceil($num/pow(2,10*$key)*100)/100)." $bitunit[$key]";
            }
        }
        return $num_bitunit_str;
    }


    /**
     * 时间格式化
     * @author	肖飞 (ArthurXF)
     * @param	string		$sourcedate		原始时间戳或者时间字符串
     * @param	string		$dateformat		时间格式字符串
     * @param	string		$timestamp		当前时间戳或者指定的时间戳
     * @param	int			$format			是否转换
     * @return  string
     */
    static function mdate($sourcedate,$dateformat='Y-m-d H:i:s', $timestamp='', $format=1) {
		if(empty($sourcedate)) return ''; 
        if(is_numeric($sourcedate)) $sourcstamp = $sourcedate;
        else $sourcstamp = strtotime($sourcedate);
        if( empty( $dateformat ) ) $dateformat='Y-m-d H:i:s';
        $sourcedate = date($dateformat,$sourcstamp);
        $sourcedateD = date('H:i',$sourcstamp);

        if(empty($timestamp)) {
            $timestamp = time();
        }else if(!is_numeric($timestamp)) $timestamp = strtotime($timestamp);
        $result = '';
        if($format) {
            $time = $timestamp - $sourcstamp;
            if ($time > 0 && $time < 60 ) {
                $result = $time.'秒以前';
            } elseif ($time >= 60 && $time < 3600) {
                $result = intval($time/60).'分钟以前';
            }elseif((date("Y-m-d", $timestamp)==date("Y-m-d", $sourcstamp))) {
                $result = 	'今天'.$sourcedateD;
            }elseif((date("Y-m-d", $timestamp-24*3600)==date("Y-m-d", $sourcstamp))) {
                $result = 	'昨天'.$sourcedateD;
            }elseif($time >= 24*3600) {
                $date = floor($time/(24*3600));
                if($date > 30) $result = 	$sourcedate;
                else $result = $date.'天以前';
            }else {
                $result = $sourcedate;
            }
        } else {
            $result = $sourcedate;
        }
        return $result;
    }

    /**
     * 生日转换年龄
     * @author	肖飞 (ArthurXF)
     * @param	int		$birthday		生日字符串
     * @param	bool	$blday			是否计算实岁生日
     * @return  string
     */
    static function birthday2age($birthday,$blday=true) {
        if(!empty($birthday) && $birthday !='0000-00-00') {
			if(strpos($birthday,'-') == false) $birthday.='-1-1';
            $now = time();
            if(!is_numeric($birthday)) $birthday = strtotime($birthday);
            if($blday) return floor(($now - $birthday)/(24*3600*365));
            else return ceil(($now - $birthday)/(24*3600*365));
        }else {
            return '0';
        }
    }

    /**
     * 年龄转换成年月日，用于比较年龄 按虚岁计算的
     * @author	嬴益虎  (whoneed@yeah.net)
     * @param	int		$age		实际年龄
     * @param	bool	$blday		按虚岁计算
	 * @param	bool	$blyear		只取年份
	 * @param	bool	$isLower	是否是低位
     * @return  string
     */
    static function age2birthday($age, $blday=true,$blyear=true,$isLower=true) {
        $strTemp = '';
        $strYear = '';
        if($blday) $strYear = date("Y") + 1 - $age ;
        else $strYear = date("Y") - $age;
		if($blyear) return $strYear;

        if($isLower) $strTemp = $strYear.'-1-1';
        else  $strTemp = $strYear.'-12-31';

        return $strTemp;
    }

    /**
     * 取的网站当前链接
     * @author	肖飞 (ArthurXF)
     * @return  string
     */
    static function getsiteurl() {
        $uri = $_SERVER['REQUEST_URI']?$_SERVER['REQUEST_URI']:($_SERVER['PHP_SELF']?$_SERVER['PHP_SELF']:$_SERVER['SCRIPT_NAME']);
        return 'http://'.$_SERVER['HTTP_HOST'].$uri;
    }

    /**
     * 内容从GB码转到UTF-8码
     * @author	肖飞 (ArthurXF)
     * @param	string	$string			要转换的字符串
     * @return  string
     */
    static function gb2utf8($string) {
        if(!empty($string)) {
            if(function_exists('iconv')) {
                $string = iconv('gbk', 'UTF-8//IGNORE', $string);
            }
        }else return false;
        return $string;
    }

    /**
     * 内容从UTF-8码转到GB码
     * @author	肖飞 (ArthurXF)
     * @param	string	$string			要转换的字符串
     * @return  string
     */
    static function utf82gb($string) {
        if(!empty($string)) {
            if(function_exists('iconv')) {
                $string = iconv('UTF-8', 'gbk//IGNORE', $string);
            }
        }else return false;
        return $string;
    }

    /**
     * 全角单词或数字转为半角单词或数字
     * @author	肖飞 (ArthurXF)
     * @param	string	$string			要转换的字符串
     * @return  string
     */
    static function SBC2DBC($string) {
        $nums = array("０","１","２","３","４","５","６","７","８","９","＋","－","％","．",
                "ａ","ｂ","ｃ","ｄ","ｅ","ｆ","ｇ","ｈ","ｉ","ｊ","ｋ","ｌ","ｍ",
                "ｎ","ｏ","ｐ","ｑ","ｒ","ｓ ","ｔ","ｕ","ｖ","ｗ","ｘ","ｙ","ｚ",
                "Ａ","Ｂ","Ｃ","Ｄ","Ｅ","Ｆ","Ｇ","Ｈ","Ｉ","Ｊ","Ｋ","Ｌ","Ｍ",
                "Ｎ","Ｏ","Ｐ","Ｑ","Ｒ","Ｓ","Ｔ","Ｕ","Ｖ","Ｗ","Ｘ","Ｙ","Ｚ");
        $fnums = "0123456789+-%.abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $string = str_replace($nums,$fnums,$string);
        return $string;
    }

    /**
     * 返回浏览器类型和版本
     * @author	肖飞 (ArthurXF)
     * @return  array
     */
    static function BrowserVer() {
        $browsers=array(
                ".*opera[ /]([0-9.]{1,10})" => "opera",
                ".compatible; MSIE[ /]([0-9.]{1,10}).*" => "ie",
                ".*Firefox/([0-9.+]{1,10})" => "firefox",
                ".Version/([0-9.+]{1,10})" => "Safari",
                ".Chrome/([0-9.+]{1,10})" => "Chrome",
        );
        if(empty($_SERVER["HTTP_USER_AGENT"])) return '';
        $browser_info = array();
        foreach($browsers as $match=>$browser_name) {
            if(preg_match('#'.$match.'#i',$_SERVER["HTTP_USER_AGENT"],$match)) {
                $browser_info[] =  $browser_name;
                $browser_info[] =  $match[1];
                $browser_info[] =  $browser_name.'.'.$match[1];
            }
        }
        return $browser_info;
    }

    /**
     * 改变系统路径格式
     * @author	肖飞 (ArthurXF)
     * @param	string	$string			要转换的字符串
     * @return  array
     */
    static function toUNIXpath($filePath) {
        $filePath=str_replace('\\','/',$filePath);
        return $filePath;
    }

    /**
     * 修饰内容配色
     * @author	肖飞 (ArthurXF)
     * @param	string	$title			要加修饰的字符串
     * @param	int		$bedeck			修饰代码
     * @param	string	$label			修饰符标签
     * @return  string
     */
    static function StringBedeck($title, $bedeck,$label='font') {
        switch($bedeck) {
            case 1:
                $title = '<'.$label.' style=font-weight:bold>'.$title.'</'.$label.'>';
                break;
            case 2:
                $title = '<'.$label.' style=color:red>'.$title.'</'.$label.'>';
                break;
            case 3:
                $title = '<'.$label.' style=color:green>'.$title.'</'.$label.'>';
                break;
            case 4:
                $title = '<'.$label.' style=color:blue>'.$title.'</'.$label.'>';
                break;
            case 5:
                $title = '<'.$label.' style=color:#FFAE00>'.$title.'</'.$label.'>';
                break;
            case 6:
                $title = '<'.$label.' style=font-weight:bold;color:red>'.$title.'</'.$label.'>';
                break;
            case 7:
                $title = '<'.$label.' style=font-weight:bold;color:green>'.$title.'</'.$label.'>';
                break;
            case 8:
                $title = '<'.$label.' style=font-weight:bold;color:blue>'.$title.'</'.$label.'>';
                break;
            case 9:
                $title = '<'.$label.' style=font-weight:bold;color:#FFAE00>'.$title.'</'.$label.'>';
                break;
        }
        return $title;
    }

    /**
     * 随机生成字符串
     * @author	肖飞 (ArthurXF)
     * @param	int		$len			字符串长度
     * @param	string	$type			字符串类型
     * @return  string
     */
    static function random_string($len = null,$type = 'alnum') {
        $len = $len == null?rand(4,10):$len;
        switch($type) {
            case 'alnum'    :
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'numeric'  :
                $pool = '0123456789';
                break;
            case 'nozero'   :
                $pool = '123456789';
                break;
            case 'unique' : return md5(uniqid(mt_rand()));
        }
        $str = '';
        for ($i=0; $i < $len; $i++) {
            $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
        }
        return $str;
    }

    /**
     * 加密字符串
     * @author	yyh
     * @param	string	$str 需要加密的字符串
     * @return  string
     */
    static function strEncryption($str,$jamStr='') {
        if(empty($jamStr)) {
            $jamStr='BIWEB88';
        }
        return md5(md5($str).$jamStr);
    }

    /**
     * 检查时间是否过期
     * @author	肖飞 (ArthurXF)
     * @param	string	$time			日期字符串或时间戳
     * @param	string	$strReplace		替换字符串
     * @param	string	$label			修饰符标签
     * @return  string
     */
    static function dateover($time,$strReplace='',$label='font') {
        $now = time();
        if(!is_numeric($time)) $unixtime = strtotime($time);
        if(empty($strReplace)) $strReplace = $time;
        if($unixtime - $now < 0) {
            if($label != '') $strReplace = '<'.$label.' style=color:red>'.$strReplace.'</'.$label.'>';

        }else $strReplace = $time;
        return $strReplace;
    }

    /**
     * 返回特定的文件夹，文件，数组 类似于：a-b-c
     * @author	嬴益虎  (whoneed@yeah.net)
     * @param	array	$arrData	    文件名数组
     * @param	int		$len			字符串长度
     * @return  string
     */
    static function dirsString($arrData, $len) {
        $strTemp = '';
        for($i=0;$i<=$len;$i++) {
            if(empty($strTemp)) $strTemp=$arrData[$i];
            else $strTemp.='-'.$arrData[$i];
        }
        return $strTemp;
    }

    /**
     * 换算星号的宽度比例,分数
     * @author	嬴益虎  (whoneed@yeah.net)
     * @param	array	$arrData	将要转换的数组
     * @return  array
     */
    static function convertStar($arrData) {
        $arrTemp = array();
        $arrTemp = $arrData;

        $intTotal = 0;//总人数
        foreach($arrTemp as $k=>$v) {
            $intTotal += $v;
        }

        if(!$intTotal) {
            $arrTemp['width1'] = 0;
            $arrTemp['width2'] = 0;
            $arrTemp['width3'] = 0;
            $arrTemp['width4'] = 0;
            $arrTemp['width5'] = 0;

            $arrTemp['score']	= 0;
            return $arrTemp;
        }

        $intTotalScore = 0;//总分数
        for($i=1;$i<=5;$i++) {
            //$arrData['star']['width'.$i] = check::subFloatDot($arrTemp[$i]/$intTotal*100,2);
            $arrData['width'.$i] = sprintf("%.2f",$arrTemp[$i]/$intTotal*100);
            $intTotalScore += $arrTemp[$i]*$i;
        }

        //$arrData['star']['score'] = check::subFloatDot(($intTotalScore/$intTotal)*2,2);
        $arrData['score'] = sprintf("%.1f",($intTotalScore/$intTotal)*2);
        return $arrData;
    }

    /**
     * 去除PHP的标记符号
     * @author	肖飞 (ArthurXF)
     * @param	string	$string			php文件字符串
     * @return  string
     */
    static function strip_php($string) {
        $arr = array('<?PHP','<?php','<?','?>');
        foreach($arr as $v) {
            $string = str_replace($v,'',$string);
        }
        return $string;
    }

    /**
     * 去除HTML格式截取指定长度的字符串
     * @author	肖飞 (ArthurXF)
     * @param	string	$string			需要截取的字符串
     * @param	int		$length			截取长度
     * @return  string
     */
    static function substring($string,$length=100) {
        return check::csubstr(trim(str_replace("&nbsp;","",str_replace("\r\n","",strip_tags($string)))),0,$length);
    }

    /**
     * 计算两个日期之间的天数
     * @author	嬴益虎  (whoneed@yeah.net) 肖飞 2010-8-11修改
     * @param	string	$strHTime	大的日期	时间格式：2010-06-20 00:00:00
     * @param	string	$strLTime	小的日期	时间格式：2010-06-10 00:00:00
     * @param	int		$intAdd		是否包含当天 1,0 默认包含
     * @return  int
     */
    static function getDays($strHTime, $strLTime='', $intAdd=1) {
        if(empty($strLTime)) $strLTime = time();
        if(!is_numeric($strHTime)) $strHTime = strtotime($strHTime);
        if(!is_numeric($strLTime)) $strLTime = strtotime($strLTime);

        //不允许，前面的时间大于后面的时间，也不允许两个时间同时为空
        if($strHTime <= $strLTime) return 0;
        else return (int)(($strHTime-$strLTime)/86400)+$intAdd;
    }

    /**
     * 调用各栏目功能的API接口
     * @author	肖飞 2010/11/21
     * @param	string	$class		类名
     * @param	string	$fun			方法名
     * @param	string	$args		参数们(例如：'$id,$title')
     * @return  int
     */
    static function getAPI($class, $fun, $args=null) {
        if(empty($class) || empty($fun)) return false;

        include(__WEB_ROOT .'/data/webconfig.inc.php');
        include(__WEB_ROOT.'/config/pdodb.inc.php');
        include(__WEB_ROOT.'/'.$class.'/config/var.inc.php');
        
        include_once(__WEB_ROOT.'/'.$class.'/class/'.$class.'.class.php');

        $obj = new $class();
		$obj->thisModel = $arrGWeb['module_id'];
		
        //数据库连接参数
        $obj->db($arrGPdoDB);
        
        //调用方法，返回结构
        if(gettype($args) == "array") {
            foreach($args as $k => $v) {
                if($v == 'debug') {
                    $obj->arrGPdoDB['PDO_DEBUG'] = true;
                    unset($args[$k]);
                }
            }
            return call_user_func_array(array($obj, $fun),$args);
        }else {
            if(strpos($args,'^') !== false) {
                $arr = explode( '^',$args);
            }
			if(is_array($arr)){
				foreach($arr as $k => $v) {
					if(strpos($v,'array') === 11 || strpos($v,'Array') ===11) {
						eval($v);
						$arr[$k] = $arrData;
					}else {
						if(strtolower($v) == 'false') $arr[$k] = false;
						if(strtolower($v) == 'true') $arr[$k] = true;
						if(strtolower($v) == 'null') $arr[$k] = null;
					}
					if($v == 'debug') {
						$obj->arrGPdoDB['PDO_DEBUG'] = true;
						unset($arr[$k]);
					}
				}
			}else{
				if(strpos($args,'array') === 11 || strpos($args,'Array') ===11) {
					eval($args);
					$arr[0] = $arrData;
				}else	$arr[0] = $args;
			}
			return call_user_func_array(array($obj, $fun),$arr);
		}
    }

	/**
     * API传值是数组需要字符串化处理
     * @author	肖飞 2010/11/21
     * @param	array		$arrData		数组值
     * @return	array
     */
    static function getAPIArray($arrData) {
		$strData = '$arrData = '.var_export( $arrData, true ).';';
		$strData = str_replace('^','&#94;',$strData);
        return  $strData;
    }

    /**
     * 返回栏目图片调用路径
     * @author	肖飞 2010/11/21
     * @param	string	$module		栏目名
     * @return  int
     */
    static function getImgUrl($module) {
        Global $arrGWeb;
        if(empty($module)) return false;
        include(__WEB_ROOT.'/'.$module.'/config/var.inc.php');

        return $arrGPic['FileCallPath'];
    }

    /**
     * 给内容里面的url加上链接的方法
     * @author	何军毅 2011/02/11
     * @param	string	过滤字符串
     * @return  int
     */
    function autolink($foo) {
        $foo = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="\1" target=_blank rel=nofollow>\1</a>', $foo);

        if( strpos($foo, "http") === FALSE ) {
            $foo = eregi_replace('(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="http://\1" target=_blank rel=nofollow >\1</a>', $foo);
        }else {
            $foo = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\1<a href="http://\2" target=_blank rel=nofollow>\2</a>', $foo);
        }
        return $foo;
    }
    
 	 /**
      * 何军毅
     * 去一个二维数组中的每个数组的固定的键知道的值来形成一个新的一维数组
     * @param $pArray 一个二维数组
     * @param $pKey 数组的键的名称
     * @return 返回新的一维数组
     */
    static function getSubByKey($pArray, $pKey="", $pCondition=""){
        $result = array();
        foreach($pArray as $temp_array){
        	if(is_object($temp_array)){
        		$temp_array = (array) $temp_array;
        	}
            if((""!=$pCondition && $temp_array[$pCondition[0]]==$pCondition[1]) || ""==$pCondition) {
                $result[] = (""==$pKey) ? $temp_array : isset($temp_array[$pKey]) ? $temp_array[$pKey] : "";
            }
        }
        return $result;
    }

    /**
     * 根据地址取坐标
     * @author	肖飞 2011/11/6
     * @param	string	过滤字符串
     * @return  int
     */
    function getGeocode($address) {
        $objMap = new GoogleMapAPI;
		return $objMap->getGeocode($address);
    }

	/**
     * 返回代号取区域中文
     * @author	肖飞	2011/12/13
     * @param	string	$code		区域代码
     * @return	string
     */
    static function getAreaName($code) {
		eval(menload_file(__WEB_ROOT . '/plug-in/area/area_code.php',1));
        if(empty($arrMArea)) return 'error';

        return $arrMArea[$code];
    }
	
	/**
     * 验证邮箱是否真实有效
     * @author	肖飞	2012/3/15
     * @param	string	$email		邮箱
     * @return	bool
     */
	function validEmail($email) {
		$isValid = true;
		$atIndex = strrpos ( $email, "@" );
		if (is_bool ( $atIndex ) && ! $atIndex) {
			$isValid = false;
		} else {
			$domain = substr ( $email, $atIndex + 1 );
			$local = substr ( $email, 0, $atIndex );
			$localLen = strlen ( $local );
			$domainLen = strlen ( $domain );
			if ($localLen < 1 || $localLen > 64) {
				// local part length exceeded
				$isValid = false;
			} else if ($domainLen < 1 || $domainLen > 255) {
				// domain part length exceeded
				$isValid = false;
			} else if ($local [0] == '.' || $local [$localLen - 1] == '.') {
				// local part starts or ends with '.'
				$isValid = false;
			} else if (preg_match ( '/\\.\\./', $local )) {
				// local part has two consecutive dots
				$isValid = false;
			} else if (! preg_match ( '/^[A-Za-z0-9\\-\\.]+$/', $domain )) {
				// character not valid in domain part
				$isValid = false;
			} else if (preg_match ( '/\\.\\./', $domain )) {
				// domain part has two consecutive dots
				$isValid = false;
			} else if (! preg_match ( '/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace ( "\\\\", "", $local ) )) {
				// character not valid in local part unless 
				// local part is quoted
				if (! preg_match ( '/^"(\\\\"|[^"])+"$/', str_replace ( "\\\\", "", $local ) )) {
					$isValid = false;
				}
			}
			//5.3.0 This function is now available on Windows platforms. 
			if ($isValid && ! (checkdnsrr ( $domain, "MX" ) || checkdnsrr ( $domain, "A" ))) {
			// domain not found in DNS
			$isValid = false;
			}
		}
		return $isValid;
	}

	/**
	 * 锁定表单
	 * 
	 * @param int $life_time 表单锁的有效时间(秒). 如果有效时间内未解锁, 表单锁自动失效.
	 * @return boolean 成功锁定时返回true, 表单锁已存在时返回false
	 */
	public function lockSubmit($life_time = 30, $type = 'LOCK_SUBMIT_TIME', $id = 0) {
		$id = intval($id);
		if ( isset($_SESSION[$type][$id]) && intval($_SESSION[$type][$id]) > time() ) {
			return false;
		}else {
			$_SESSION[$type][$id] = time() + intval($life_time);
			return true;
		}
	}

	/**
     * 繁简转换
     * @author	肖飞	2011/12/13
     * @param	string	$code		区域代码
     * @return	string
     */
    static function ConvertFJ($source,$type='f2j',$code='UTF-8') {
		if($type == 'f2j'){
			if($code == 'UTF-8'){
				$source = iconv('UTF-8', 'BIG5'.'//IGNORE', $source);
				$objCnvert = new Chinese("BIG5","GB2312",$source,__WEBCOMMON_ROOT.'/chinese/config/');
				$source = $objCnvert->ConvertIT();
				$source = iconv('GB2312', 'UTF-8'.'//IGNORE', $source);
			}elseif($code == 'GB2312'){
				$objCnvert = new Chinese("BIG5","GB2312",$source,__WEBCOMMON_ROOT.'/chinese/config/');
				$source = $objCnvert->ConvertIT();
			}
		}else{
			if($code == 'UTF-8'){
				$source = iconv('UTF-8', 'GB2312'.'//IGNORE', $source);
				$objCnvert = new Chinese("GB2312","BIG5",$source,__WEBCOMMON_ROOT.'/chinese/config/');
				$source = $objCnvert->ConvertIT();
				$source = iconv('BIG5', 'UTF-8'.'//IGNORE', $source);
			}elseif($code == 'GB2312'){
				$objCnvert = new Chinese("GB2312","BIG5",$source,__WEBCOMMON_ROOT.'/chinese/config/');
				$source = $objCnvert->ConvertIT();
			}
		}
		return $source;
    }

	/**
     * 金字塔总结点
     * @author	肖飞	2012/5/9
     * @param	int		$hierarchy		层级
	 * @param	int		$branch		分支
     * @return	int
     */
	static function PyramidTotal($hierarchy=2,$branch=2){
		$intTotal = 0;
		for($i=1;$i<=$hierarchy;$i++){
			if($i==1){
				$intTotal = 1;
				$intParentNum = 1;
				//echo 'level '.$i.' num =1<br />';
			}else{
				$intParentNum = $intParentNum*$branch;
				//echo 'level '.$i.' num ='.$intParentNum.'<br />';
				$intTotal += $intParentNum;
			}
		}
		return $intTotal;
	}

	/**
	 * 按父子关系格式输出，并在title前加上缩进
	 * @author	肖飞
	 * @param	int		$root			起始父节点
	 * @param	array		$arrList			类型数组
	 * @param	int		$depth			缩进层次
	 * @param	array		$arrReturn	格式完输出数组
	 * @return	array
	 */
	static function formatPyramid($parentid, $arrList,&$arrReturn=array(),&$depth=0) {
		$intKey = 0;
		$intPID = 0;
		$intUID = 0;
		$intPNum = 0;
		foreach ($arrList as $k => $v) {
			if($intUID == 0){  
				$intKey = $k;
				$intPID = $v['parentid'];
				$intUID = $v['user_id'];
			}				
			if ($v['parentid'] == $parentid) {
				$arrReturn['data'][] = $v;
				$arrReturn['tree'][$depth][] = $v;
				$depth++;
				check::formatPyramid($v['user_id'], $arrList, $arrReturn,$depth);
				$depth--;
			}
		}
		return $arrReturn;
	}
	
	/**
     * 找到金字塔节点中可以插入孩子的节点
     * @author	肖飞	2012/5/9
     * @param	array		$arrPyramid		整个金字塔节点数组
	 * @param	int		$branch			分支
     * @return	int
     */
	static function InsertChild($arrPyramid,$branch=2){
		if(!is_array($arrPyramid)) return false;
		$intKey = 0;
		$intPID = 0;
		$intUID = 0;
		
		foreach($arrPyramid['tree'] as $arrDepth){
			foreach($arrDepth as $k => $v){
				$intPNum = 0;
				//echo '<pre>';print_r($v1);echo '</pre>';
				foreach($arrPyramid['data'] as $k1 => $v1){
					if($v['user_id'] == $v1['parentid']){
						$intPNum++;
						if($intPNum == $branch){
							break;
						}
					}
				}
				//if($intPNum < $branch && $v2['parentid'] != 0) print_r($v1);exit;
				if($intPNum < $branch) {return $v['user_id'];}
			}
			
		}
		
	}



	/**
     * CheckWeek($date)
     * 作 用：传入日期，返回星期
     * @author	Arthur <ArthurXF@gmail.com>
     * @param	date $date		格式日期
     * @return	string
     * 备 注：无
     */
    static function CheckWeek($date) {
		//时间戳的判断
		if(!is_numeric($date)) $date = strtotime($date);
		switch (date("w", $date)){
			case 0:return('日');
			case 1:return('一');
			case 2:return('二');
			case 3:return('三');
			case 4:return('四');
			case 5:return('五');
			case 6:return('六');
		}
    }

	 /**
     * 返回共享内存的值
     * @author	肖飞 2012/8/29
     * @param	string	$strName		共享内存块名
     * @return	value
     */
    static function getSM($strName) {
        if(empty($strName)) return false;
        $objShared = System_SharedMemory::factory();
		return $objShared->get($strName);
    }

	/**
     * 设置共享内存的值
     * @author	肖飞 2012/8/29
     * @param	string	$strName		共享内存块名
	 * @param	string	$data			要放入共享内存的数据
     * @return	value
     */
    static function setSM($strName,$data) {
        if(empty($strName)) return false;
        $objShared = System_SharedMemory::factory();
		return $objShared->set($strName,$data);
    }

	/**
     * 设置共享内存的值
     * @author	肖飞 2012/8/29
     * @param	string	$strName		共享内存块名
	 * @param	string	$data			要放入共享内存的数据
     * @return	value
     */
    static function rmSM($strName) {
        if(empty($strName)) return false;
        $objShared = System_SharedMemory::factory();
		return $objShared->rm($strName);
    }

}
?>
