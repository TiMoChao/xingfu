<?php
/**
 * 底层功能接口类文件
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		ArthurXF
 */
class ArthurXF{
	public $arrGPdoDB = array();
	public $arrGSmarty = array();
	public $arrGPage = array();
	public $arrGPic = array();
	public $db = null;
	public $objSmarty = null;

	/**
	 * PHP5的构造函数
	 * @author	肖飞
	 * @return  void
	 */
	function __construct() {
		Global $arrGPdoDB;
		Global $arrGSmarty;
		Global $arrGPage;
		Global $arrGPic;
		Global $arrGCache;
		Global $arrGWeb;
		if(empty($arrGPdoDB)) {
			echo "Fail: arrGPdoDB is empty!";
			return false;
		}else $this->arrGPdoDB = $arrGPdoDB;
		if(empty($arrGSmarty)) {
			echo "Fail: arrGSmarty is empty!";
			return false;
		}else $this->arrGSmarty = $arrGSmarty;
		$this->arrGPage = $arrGPage;
		$this->arrGPic = $arrGPic;
		$this->arrGCache = $arrGCache;
		$this->thisModel = $arrGWeb['module_id'];
	}

	/**
	 * PHP4的构造函数
	 * @author	肖飞
	 * @version	2011/9/21
	 * @return  void
	 */
	function ArthurXF() {
		$this->__construct();
	}

	/**
	 * 根据配置给栏目表名加前缀
	 * @author	肖飞
	 * @version	2009-3-13 modify by 2011/7/27
	 * @return  void
	 */
	function setDBG(){
		$i = 1;
		foreach($this->arrGPdoDB as $k => $v){
			if($k == 'db_tablepre' || $k == 'db_table_field') continue;
			if(strpos($k,'db_table') === 0){
				$this->{tablename.$i} = $this->arrGPdoDB['db_tablepre'].$v;
				$i++;
			}
		}
		if($i==1) {
			if(!in_array($this->thisModel,array('wap','index','rss','sitemap','guest'))) die($this->thisModel.'/var.inc.php中数据库配置信息未取得！');
		}
	}

	/**
	 * 连接数据库返回数据库链接句柄
	 * @author	肖飞
	 * @version	2011/7/27
	 * @return  void
	 */
	public function db($arrGPdoDB=null){
		if(!empty($arrGPdoDB)) $this->arrGPdoDB = $arrGPdoDB;
		$this->setDBG($this->arrGPdoDB);
		$this->db = $this->connectG();
	}

	/**
	 * 数据库连接
	 * @author	肖飞 <ArthurXF@gmail.com>
	 * @return  object
	 */
	protected function connectG(){
		$arrPdoDB = $this->arrGPdoDB;
		try {
		    $objPdoDB = new PdoDB($arrPdoDB['dsn'],$arrPdoDB['db_user'],$arrPdoDB['db_password'],array(PDO::ATTR_PERSISTENT => $arrPdoDB['PDO_ATTR_PERSISTENT'],PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
		} catch (PDOException $e) {
			$strMessage = $e->getMessage();
			if(strpos($strMessage,'[2003]') !==false) {
				echo '连接失败: 不能连接到本地的MYSQL数据库！<br />';
			}elseif(strpos($strMessage,'[1049]') !==false){
				//数据库不存在自动创建,by ArthurXF at 2009-6-16
				$strDsn = $arrPdoDB['db_driver'].':host='.$arrPdoDB['db_host'].';port='.$arrPdoDB['db_port'].';dbname=;charset='.$arrPdoDB['db_char'];
				$objPdoDB = new PdoDB($strDsn,$arrPdoDB['db_user'],$arrPdoDB['db_password'],array(PDO::ATTR_PERSISTENT => $arrPdoDB['PDO_ATTR_PERSISTENT'],PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
				$objPdoDB->exec('CREATE DATABASE `'.$arrPdoDB['db_name'].'`');

				//再次生成可用的数据库实例
				$objPdoDB = new PdoDB($arrPdoDB['dsn'],$arrPdoDB['db_user'],$arrPdoDB['db_password'],array(PDO::ATTR_PERSISTENT => $arrPdoDB['PDO_ATTR_PERSISTENT'],PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
			}elseif(strpos($strMessage,'[1045]') !==false){
				//用户名或密码错误
				echo 'Connection failed: ' . $strMessage.'<br /><br />';
				echo '数据库库名、用户名或密码错误，请将data\webconfig.inc.php中\'db_name\' ,\'db_user\',\'db_password\',修改成为正确的设置';
				exit;
			}
			if(!is_object($objPdoDB)) {
				echo 'Connection failed: ' . $strMessage.'<br /><br />';
				if($strMessage == 'could not find driver'){
					echo '请按照下面Loaded Configuration File中设定的路径找到PHP.ini，将其中的;extension=php_pdo_mysql.dll前面的;去掉，重启apache后再访问本页！';
					phpinfo();
				}
				exit;
			}
		}
		$objPdoDB->exec('set names utf8');
		$objPdoDB->exec("set sql_mode=''");
		return $objPdoDB;
	}

	/**
	 * 获取db中记录的数目
	 * @author	肖飞
	 * @param	string $table    数据库表名
	 * @param	string $where    查询条件
	 * @param	string $order	     排序条件
	 * @version	2007-11-21
	 * @return  array
	 */
	public function getRecordsG($table,$where='',$order=''){
		try {
			if(strpos(strtolower($order), 'group') !== false){
				$order = substr($order, strrpos($order,'by')+3);
				$strSQL = "select count(DISTINCT $order) as num from $table ".$where;
			}else $strSQL = "select count(*) as num from $table ".$where;
			$rs = $this->db->prepare($strSQL);
			$rs->execute();
			if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
			if($arrDate = $rs->fetch(PDO::FETCH_ASSOC)){
				return $arrDate['num'];
			}
		} catch (PDOException $e) {
		    echo 'Failed: ' . $e->getMessage().'<br><br>';
		}
	}

	/**
	 * 获取mysql函数运算返回的结果
	 * @author	肖飞
	 * @param	string $table		数据库表名
	 * @param	string $fun		执行的MYSQL函数
	 * @param	string $where   查询条件
	 * @version	2009-1-25
	 * @return  array
	 */
	public function getFuncitonG($table,$fun,$where=''){
		try {
			$table = $this->arrGPdoDB['db_tablepre'].$table;
			$strSQL = "select $fun from $table ".$where;
			$rs = $this->db->prepare($strSQL);
			$rs->execute();
			if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
			if($arrDate = $rs->fetch(PDO::FETCH_ASSOC)){
				return $arrDate;
			}
		} catch (PDOException $e) {
		    echo 'Failed: ' . $e->getMessage().'<br><br>';
		}
	}

	/**
	 * 根据查询条件查询数据记录
	 * @author	肖飞
	 * @param	string	$table				表名
	 * @param	string	$where				信息类型id
	 * @param	string	$limit				limit 查询条件
	 * @param	string	$field				查询字段
	 * @param	bool		$blFetch			是否通过采集得来的数据
	 * @param	array		$arrData			预处理数组
	 * @param	bool		$blCount			是否同时回传数据行数
	 * @param	bool		$blComplex		使用优化查询,超大数据量效果明显,小数据不建议使用
	 * @version	2007-11-21
	 * @return  Boolean
	 */
	public function selectDataG($table,$where = '',$limit = '',$field = '*',$blFetch = false,$arrData = array(),$blCount = false,$blComplex = false ){
		try {
			//$strSQL = "SELECT SQL_CALC_FOUND_ROWS $field from $table $where";		效率低下,在MYSQL版本未改进之前弃用
			$strSQL = "SELECT $field from $table $where $limit";
			if($this->arrGPdoDB['PDO_CACHE']) {
				$strCacheName = md5($strSQL);
				$strCacheDir = '';
				for($i=0;$i<16;$i+=2){
					//$strCacheDir .= '/'.$strCacheName[$i].$strCacheName[$i+1].$strCacheName[$i+2].$strCacheName[$i+3];
					$strCacheDir .= '/'.$strCacheName[$i].$strCacheName[$i+1];
				}

				$strCacheName = $strCacheDir.'SQL_'.$table.'_'.$strCacheName;
				$strCacheFile = $this->arrGPdoDB['PDO_CACHE_ROOT'].$strCacheName;
				$objCache = new cache($strCacheFile,$this->arrGPdoDB['PDO_CACHE_LIFETIME']);
				if($this->arrGPdoDB['PDO_CACHE']==1) {
					if($objCache->cache_is_active()) {
						eval(file_get_contents($strCacheFile));
						if($blCount){
							if($arr['COUNT_ROWS'] != '' ) $_SESSION['COUNT_ROWS'] = $arr['COUNT_ROWS'];
							else $arr['COUNT_ROWS'] = $_SESSION['COUNT_ROWS'];
						}else{
							unset($arr['COUNT_ROWS']);
						}
						return $arr;
					}
				}
			}
			if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
			$rs = $this->db->prepare($strSQL);
			$rs->execute($arrData);
			if($blFetch) $arr = $rs->fetch(PDO::FETCH_ASSOC);
			else  $arr = $rs->fetchall(PDO::FETCH_ASSOC);
			$rs = '';
			if($blCount){
					//$strSQL = "SELECT FOUND_ROWS()";		配合SQL_CALC_FOUND_ROWS使用的
					//$strSQL = "SELECT count(DISTINCT id) from $table $where";
					if(!$blComplex){
						$strSQL = "SELECT count(*) as num from $table $where";
						if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
						$rs = $this->db->query($strSQL);
						if(strpos($where,'GROUP') || strpos($where,'group')){
							$arrTemp = $rs->fetchall(PDO::FETCH_ASSOC);
							$arr['COUNT_ROWS'] = count($arrTemp);
						}else{
							$arrTemp = $rs->fetch(PDO::FETCH_ASSOC);
							$arr['COUNT_ROWS'] = $arrTemp['num'];
						}
					}
					if($arr['COUNT_ROWS'] != '' ) $_SESSION['COUNT_ROWS'] = $arr['COUNT_ROWS'];
					else $arr['COUNT_ROWS'] = $_SESSION['COUNT_ROWS'];

			}
			if($this->arrGPdoDB['PDO_CACHE']){
				if(isset($objCache)&&is_object($objCache)) {
					$somecontent = '<?php' . "\n" . '$arr = ' . var_export( $arr, true ) . ';' . "\n" . '?>';
					$objCache->write_file($somecontent);
				}
			}
			return $arr;
		} catch (PDOException $e) {
		    echo 'Failed: ' . $e->getMessage().'<br><br>';
		}
	}

	/**
	 * 插入数据记录
	 * @author	肖飞
	 * @param	string	$table		表名
	 * @param	array		$arrData    数据记录信息数组
	 * @version	2007-11-21
	 * @return  Boolean
	 */
	public function insertDataG($table,$arrData){
		try {
			$strSQL = "REPLACE INTO $table (";
			$strSQL .= '`';
			$strSQL .= implode('`,`', array_keys($arrData));
			$strSQL .= '`)';
			$strSQL .= " VALUES ('";
			$strSQL .= implode("','",$arrData);
			$strSQL .= "')";
			if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
			if($result = $this->db->exec($strSQL)){
				if($this->arrGPdoDB['PDO_LOGS']) check::getAPI('logs','addLog',"1^$table^$where^$strSQL");
				return $result;
			}
		} catch (PDOException $e) {
		    echo 'Failed: ' . $e->getMessage().'<br><br>';
		}
	}

	/**
	 * 返回最后插入数据的ID号
	 * @author	肖飞
	 * @version	2009-1-22
	 * @return  int
	 */
	public function lastInsertIdG(){
		 return $this->db->lastInsertId();
	}

	/**
	 * 取得将要插入数据记录的ID
	 * @author	肖飞
	 * @param	string	$table		表名
	 * @version	2009-6-24
	 * @return  Boolean
	 */
	public function getNextIDG($table){
		try {
			$strSQL = "SHOW TABLE STATUS like '$table'";
			$rs = $this->db->query($strSQL);
			$arr = $rs->fetch(PDO::FETCH_ASSOC);
			$intLastID = $arr['Auto_increment'];
			if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
			return $intLastID;
		} catch (PDOException $e) {
		    echo 'Failed: ' . $e->getMessage().'<br><br>';
		}
	}

	/**
	 * 修改数据记录
	 * @author	肖飞
	 * @param	string	$table		表名
	 * @param	array		$arrData	数据记录信息数组
	 * @param	string	$where	    SQL语句的where条件
	 * @version	2007-11-21
	 * @return  Boolean
	 */
	public function updateDataG($table,$arrData,$where=''){
		try {
			$strSQL = "	UPDATE $table SET ";
			foreach ($arrData as $k => $v) {
				if(strpos($v,'fun(')!==false){
					$v = str_ireplace('fun(','(',$v);
					$strSQL .= $k."=" . $v . ",";
				}else	$strSQL .= $k."='" . $v . "',";
			}
			$strSQL = substr($strSQL, 0, -1);
			$strSQL .= ' '.$where;
			if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
			if($result = $this->db->exec($strSQL)){
				if($this->arrGPdoDB['PDO_LOGS']) check::getAPI('logs','addLog',"2^$table^$where^$strSQL");
				return $result;
			}
		} catch (PDOException $e) {
		    die('Failed: ' . $e->getMessage().'<br><br>');
		}
	}

	/**
	 * 删除数据记录
	 * @author	肖飞
	 * @param	string	$table		表名
	 * @param	string	$where	    SQL语句的where条件
	 * @version	2007-11-21
	 * @return  Boolean
	 */
	public function deleteDataG($table,$where){
		try {
			$strSQL = "DELETE FROM $table $where";
			if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
			if($result = $this->db->exec($strSQL)){
				if($this->arrGPdoDB['PDO_LOGS']) check::getAPI('logs','addLog',"3^$table^$where^$strSQL");
				return $result;
			}
		} catch (PDOException $e) {
		    echo 'Failed: ' . $e->getMessage().'<br><br>';
		}
	}

	/**
	 * 数据库字段入库前结构处理
	 * @author	肖飞
	 * @param	array		$arrData			提交过来的数据数组
	 * @param	bool		$isModify			执行的是否修改动作
	 * @param	string	$GPdoDBKey	表字段配置在数组中的键名
	 * @param	bool		$enforce			强制跳过get_magic_quotes_gpc
	 * @version	2007-11-21
	 * @return  array
	 */
	public function saveTableFieldG($arrData=null,$isModify=false,$GPdoDBKey = "db_table_field", $enforce=true){
		$arrDB = $this->arrGPdoDB[$GPdoDBKey];
		$arrDBstb = $arrDB['structon_tb'];
		if(!$isModify){
			$arrConfirmDB = $arrDB;
		} else {
			$arrConfirmDB = array();
		}
		foreach ($arrData as $key=>$val){
			if(array_key_exists($key,$arrDB)) {
				if($arrData[$key] != ''){
					$arrConfirmDB[$key] = $arrData[$key];
				}
				unset($arrData[$key]);
			}else{
				if(!empty($arrDBstb)){
					if(!in_array($key,$arrDBstb)){
						unset($arrData[$key]);
					}
				}
			}
		}
		//$arrDB['structon_tb'] = serialize($arrData);		序列化在2.0升级中弃用
		if ($enforce){
			if(array_key_exists('structon_tb',$this->arrGPdoDB['db_table_field'])) {
				ArthurXF::arrayWhile($arrData);
				$arrConfirmDB['structon_tb'] = addslashes(var_export($arrData,true));
			}
		}
		if($_SESSION['langset'] == 'zh_tw'){
			foreach($arrConfirmDB	 as $k => $v){
				if(is_string($v)){
					$str = check::ConvertFJ($v);
					if($str) $arrConfirmDB[$k] = $str;
				}
			}
		}
		return $arrConfirmDB;
	}

	/**
	 * 数据库字段入库前结构数组递归处理
	 * @author	肖飞
	 * @param	array	$arrData	提交过来的数据数组
	 * @version	2008-8-28
	 * @return  array
	 */
	public function arrayWhile(&$arrData){
		 if(is_array($arrData)){
			 foreach($arrData as $k => $v){
				 if(is_array($v)){
					 ArthurXF::arrayWhile($v);
				 }else{
					 $arrData[$k] = stripslashes($v);
				 }
			 }
		 }
	 }

	/**
	 * 数据库字段出库后结构处理
	 * @author	肖飞
	 * @param	array	$arrData	直接从表中取回需要还原的数组
	 * @version	2009-3-14
	 * @return  array
	 */
	public function loadTableFieldG($arrData=null){
		$arrDB = $this->arrGPdoDB['db_table_field'];

		for($i=0;$i<count($arrData);$i++){
			//$arr = unserialize($arrData[$i]['structon_tb']);	反序列化在2.0升级中弃用
			if(!empty($arrData[$i]['structon_tb']) && $arrData[$i]['structon_tb'] !=''){
				$arrData[$i]['structon_tb'] = stripslashes($arrData[$i]['structon_tb']);
				$str = "\$arr = ".$arrData[$i]['structon_tb'].";";
				@eval($str);
				foreach ($arr as $k => $v){
					/* 检查structon_tb中的值如果key和外面的相同则跳过赋值，也就不覆盖外面的值，目前此功能取消了。
					$back = 0;
					foreach ($arrDB as $key=>$val){
						if($key == $k){
							$back = 1;
							break;
						}
					}
					if($back == 1) continue;
					else $arrData[$i][$k] = $v;
					*/
					$arrData[$i][$k] = $v;
				}
				unset($arrData[$i]['structon_tb']);
			}
		}

		return $arrData;
	}

	/**
	 * 翻页函数
	 * @author	肖飞 <ArthurXF@gmail.com>
	 * @param	int		$records		总记录数
	 * @param	string	$strLink			翻页链接
	 * @param	int		$link_type		链接类型 0=普通 1=静态优化 2=Wap链接 3=js链接
	 * @param	string	$link_style		链接样式 缺省为1:2:3:6 ,每个数字代表下面样式中的1行
	 * @param	int		$page_size		特定页面记录条数
	 * @return  string
	 */
	public function pageG($records,$link=null,$link_type=0,$link_style='1:2:3:6',$page_size=null,$js_fun=''){
		$objPage = new pdo_page;
	    //翻页参数
		$objPage->records = $records;
	    if(isset($this->arrGPage['page_size']) !== false) $objPage->page_size = $this->arrGPage['page_size'];
	    if(isset($this->arrGPage['link_num']) !== false) $objPage->link_num = $this->arrGPage['link_num'];
	    if(isset($this->arrGPage['page_count']) !== false) $objPage->page_count = $this->arrGPage['page_count'];
	    if(isset($this->arrGPage['pagestring']) !== false) $objPage->pagestring = $this->arrGPage['pagestring'];
	    if(isset($this->arrGPage['page_link']) !== false) $objPage->page_link = $this->arrGPage['page_link'];
	    if(isset($this->arrGPage['page_select']) !== false) $objPage->page_select = $this->arrGPage['page_select'];
	    if(isset($this->arrGPage['page_jump']) !== false) $objPage->page_jump = $this->arrGPage['page_jump'];
		if(isset($this->arrGPage['file_suffix']) !== false) $objPage->file_suffix = $this->arrGPage['file_suffix'];
		if(isset($this->arrGPage['lang']) !== false && !empty($this->arrGPage['lang'])) $objPage->lang = $this->arrGPage['lang'];
		else $objPage->lang = 'zh';
	    if($page_size!=null) $objPage->page_size = $page_size;
		$objPage->js_fun = $js_fun;
	    //翻页链接显示输出
	    $objPage->create_page();
		$objPage->page_link1($link,$link_type);
		$objPage->page_link5($link,$link_type);
		$objPage->page_link2($link,$link_type);
		$strPage = '';
		if($link_type == 0 || $link_type == 1 || $link_type == 3 ){
			$arrTemp = explode(':', $link_style);
			if($objPage->lang == 'zh'){
				foreach($arrTemp as $v){
					switch($v){
						case 1:
							$strPage .=  '<span class="pages">&nbsp;&nbsp;共'.$objPage->records.'个</span>';       //表中记录的总数
						break;
						case 2:
							$strPage .= '&nbsp;&nbsp;页次'.$objPage->page.'/'.$objPage->page_count.'&nbsp;&nbsp;';         //总页数
						break;
						case 3:
							$strPage .= '&nbsp;&nbsp;'.$objPage->pagestring.'&nbsp;&nbsp;';     //'首页'、'上一页'、'下一页'、'尾页'－－链接样式
						break;
						case 4:
							$strPage .=  '<span class="center">'.$objPage->page_link.'</span>';      //[1]、[2]、[3]－－链接样式
						break;
						case 5:
							$strPage .=  '<center>'.$objPage->page_select.'</center>';    //表单翻页样式
						break;
						case 6:
							$strPage .= '&nbsp;&nbsp;页码: '.$objPage->page_jump;
						break;
					}
				}
			}elseif($objPage->lang == 'en'){
				foreach($arrTemp as $v){
					switch($v){
						case 1:
							$strPage .=  '<span class="pages">&nbsp;&nbsp;'.$objPage->records.' results</span>';       //表中记录的总数
						break;
						case 2:
							$strPage .= '&nbsp;&nbsp;Pages '.$objPage->page.'/'.$objPage->page_count.'&nbsp;&nbsp;';         //总页数
						break;
						case 3:
							$strPage .= '&nbsp;&nbsp;'.$objPage->pagestring.'&nbsp;&nbsp;';     //'首页'、'上一页'、'下一页'、'尾页'－－链接样式
						break;
						case 4:
							$strPage .=  '<span class="center">'.$objPage->page_link.'</span>';      //[1]、[2]、[3]－－链接样式
						break;
						case 5:
							$strPage .=  '<center>'.$objPage->page_select.'</center>';    //表单翻页样式
						break;
						case 6:
							$strPage .= '&nbsp;&nbsp;Page Number: '.$objPage->page_jump;
						break;
					}
				}
			}
			return $strPage;
		}

		if($link_type == 2 ){
			$arrGPage['records'] = $objPage->records;
			$arrGPage['page'] = $objPage->page;
			$arrGPage['page_count'] = $objPage->page_count;
			if( (1<=$arrGPage['page']) && ($arrGPage['page']<=$arrGPage['page_count'])){
				if($arrGPage['page'] < $arrGPage['page_count']){
					$arrGPage['pagedown'] = $arrGPage['page']+1;
				}
				if( $arrGPage['page']>1 ){
					$arrGPage['pageup'] = $arrGPage['page']-1;
				}
			}
			$arrGPage['pagenav'] = $arrGPage['page'].'/'.$arrGPage['page_count'].'页 总'.$arrGPage['records'].'条';

			return $arrGPage;
		}
	}


	/**
	 * 验证用户访问权限
	 * @author	肖飞，（2011-04-18 王巍修改）
	 * @param	int $user_id    会员id
	 * @param	String $thisAction    操作（r:读;w:写,即添加和修改;d:删;x:执行）
	 * @param	String $thisModel    栏目或模块id
	 * @return  boolean
	 */
	public function checkPopedomG($user_id,$thisAction='r',$thisModel = '') {
		if(!empty($_SESSION['user_group']) && $_SESSION['user_group'] == 3){
			return true;
		}else{
			if(empty($thisModel)) $thisModel = $this->arrGPdoDB['db_table'];
			if(empty($_SESSION['user_group'])){
				$table = $this->arrGPdoDB['db_tablepre'].'user';
				$where = " WHERE user_id=".$user_id;
				$field = 'user_group,user_popedom';
				$blFetch = true;
				$arrUserInfo = $this->selectDataG($table,$where,$limit,$field,$blFetch,$arrData);
				if($arrUserInfo['user_group'] == 3){
					return true;
				}
				if($arrUserInfo['user_group'] == 2){
					$arrPopedom = $arrUserInfo['user_popedom'];
					if(array_key_exists($thisModel,$arrPopedom)){
						if ($thisAction=='r' || in_array($thisAction, $arrPopedom[$thisModel])) {
							return true;
						}
					}
				}
			//**************************************权限修改***************************************
			//修改人：王巍；
			//修改内容：采用user_popedom字段进行验证
			/*
			user_popedom是一个数组，结构如下：
			'user_popedom' => 
				array (
					'user' => 
						array (
						  0 => 'r',
						  1 => 'w',
						  2 => 'd',
						  3 => 'x',
						),
				)
			*/
			}elseif($_SESSION['user_group'] == 2 && !empty($_SESSION['user_popedom'])) {
				$arrPopedom = $_SESSION['user_popedom'];
				if(array_key_exists($thisModel,$arrPopedom)){
					if ($thisAction=='r' || in_array($thisAction, $arrPopedom[$thisModel])) {
						return true;
					}
				}
			}
			return false;
		}
	}

	/**
	 * 检查smarty缓存，有缓存直接输出缓存
	 * @author	肖飞 <ArthurXF@gmail.com>
	 * @param	array		$arrMOutput	smarty数组
	 * @param	string	$cache_id			缓存文件的ID
	 * @return	object
	 */
	 public function iscached($arrMOutput = array(),$cache_id=NULL) {
		$objSmarty = new SmartyTpl();
		if(empty($arrMOutput['template_dir'])) $objSmarty->setTemplateDir($this->arrGSmarty['template_dir']);
		else $objSmarty->setTemplateDir($arrMOutput['template_dir']);
		$objSmarty->setCompileDir($this->arrGSmarty['compile_dir']);
		$objSmarty->setCacheDir($this->arrGSmarty['cache_dir']);
		$objSmarty->plugins_dir = $this->arrGSmarty['plugins_dir'];
		$objSmarty->config_dir = $this->arrGSmarty['config_dir'];
		$arrMOutput['smarty_debug'] ? $objSmarty->compile_check = true : '';
		$arrMOutput['smarty_debug'] ? $objSmarty->debugging = true : '';
		$objSmarty->caching = $this->arrGSmarty['caching'];
		if($arrMOutput['template_file'] == 'admin.html') $objSmarty->caching = false;
		if($objSmarty->caching) {
			//$cache_id =  md5($_SERVER["SCRIPT_URL"]);
			if(empty($cache_id)) $objSmarty->cache_id = $_SESSION['langset'].$_GET['sub'].$_SERVER['REQUEST_URI'];
			$objSmarty->cache_lifetime = isset($this->arrGSmarty['cache_lifetime'])?$this->arrGSmarty['cache_lifetime']:3600;
			$objSmarty->cache_modified_check = isset($this->arrGSmarty['cache_modified_check'])?$this->arrGSmarty['cache_modified_check']:false;
			if($objSmarty->is_cached($arrMOutput['template_file'],$objSmarty->cache_id)){
				$this->objSmarty = $objSmarty;
				$objSmarty->display($arrMOutput['template_file'],$objSmarty->cache_id);
				exit;
			}
		}
		return $objSmarty;
	 }

	/**
	 * smarty输出函数
	 * @param	array		$arrMOutput	smarty数组
	 * @param	string	$cache_id			缓存文件的ID
	 * @return  void
	 */
	public function output($arrMOutput = array(),$cache_id=NULL){
		
		if (!is_object($this->objSmarty)) {
			$this->objSmarty = $this->iscached($arrMOutput);
		}
		if (!empty($arrMOutput['smarty_assign'])){
			while(list($key,$value) = each($arrMOutput['smarty_assign'])){
				$this->objSmarty->assign($key,$value);
			}
		}

		if($_SESSION['langset'] == 'zh_tw'){
			$this->objSmarty->autoload_filters = array('output' => array('langset'));
		}
		if(!empty($_GET['type']) && $_GET['type']=='doc') $arrMOutput['template_file'] = "framedoc.html";

		$this->objSmarty->display($arrMOutput['template_file'],$this->objSmarty->cache_id);
		exit;
	}

	/**
	 * XML输出函数
	 * @author	肖飞 <ArthurXF@gmail.com>
	 * @param	array	$arrMOutput	XML
	 * @param	bool	$switch				是否生成文件的标示开关
	 * @return	void
	 */
	public function outputXML($arrMOutput = array(),$switch=1){
		$objXML = new xml();
		if($switch==1){
			$objXML->createXml($arrMOutput);
		}else{
			$objXML->creatXmlFile($arrMOutput);
		}
	}

	/**
	 * WDDX中文反解函数
	 * flash中wddx编码中文传值给php后中文自动解码，php就无法正常解wddx包，为了正常传输wddx封包中文，则中文必须用[wddx]标签包括，例如[wddx]urlencode(中文)[/wddx]，
	 * 此函数调用了ubbcode，将封包中的中文编码后，正常解包，然后再将数组中编码的中文解码
	 * @author	肖飞
	 * @param	string	$strWDDX    请求wddx字符串
	 * @param	array		$arrKey			需要中文解码的变量数组
	 * @return	array
	 */
	public function WDDXdecode($strWDDX){
		$objUbbcode = new ubbcode();
		$strWDDX = stripslashes(nl2br($strWDDX));
		if(count($objUbbcode->ubbParameter($strWDDX))){
			$arrData = wddx_deserialize($strWDDX);
			$strData = var_export($arrData,true);
			$strData = $objUbbcode->parse($strData);
			eval("\$arrData = $strData;");
		}else{
			$strWDDX = $objUbbcode->parse($strWDDX);
			$arrData = wddx_deserialize($strWDDX);
		}
		return $arrData;
	}


	#################################################################################################

	/**
	 * 取得信息类型列表
	 * @author	肖飞
	 * @param	string $strInfoTypeTitle    信息类型标题
	 * @return  void
	 */
	public function getTypeList($where=null,$order=null,$limit=null){
		try{
			if($order == null) $order = ' order by type_sort desc,type_id ';
			$strSQL = "SELECT * FROM $this->tablename2 ".$where.$order.$limit;
			if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
			$rs = $this->db->query($strSQL);
			return $rs->fetchall(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
		    echo 'Failed: ' . $e->getMessage().'<br><br>';
		}
	}

	/**
	 * 取得所有叶子节点的信息类型列表
	 * @author	肖飞
	 * @return  array
	 */
	public function fetchTypeLeaf() {
		$arrType = $this->getTypeList();
		$arrParent = array();
		foreach ($arrType as $type) {
			$arrParent[] = $type['type_parentid'];
		}
		foreach ($arrType as $k => $type) {
			if (in_array($type['type_id'], $arrParent)) {
				unset($arrType[$k]);
			}
		}
		return $arrType;
	}


	/**
	 * 递归取出某类别的所有子类别
	 * @author	肖飞
	 * @param	int		$parentID		父类型id
	 * @param	array		$arrList			类别列表数组
	 * @param	array		$arrChild		所有子类别存入此数组
	 * @return  array
	 */
	public function fetchAllChildID($parentID, $arrList, &$arrChild=array()) {
		$arrChild['type_id'][] = $parentID;
		foreach ($arrList as $k => $list) {
			if ($list['type_parentid'] == $parentID) {
				array_push($arrChild, $list);
				$this->fetchAllChildID($list['type_id'], $arrList, $arrChild);
			}
		}
		return $arrChild;
	}

	/**
	 * 取得信息类型内容
	 * @author	肖飞
	 * @param	int		$type_id    信息类型ID
	 * @return  array
	 */
	public function getTypeInfo($type_id){
		$table = $this->tablename2;
		$where = " WHERE type_id=$type_id";
		$field = '*';
		$blFetch = true;
		$limit = '';
		return $this->selectDataG($table,$where,$limit,$field,$blFetch,$arrData);
	}

	/**
	 * 获取信息列表数据
	 * @author	肖飞
	 * @param	string	$where				信息类型id
	 * @param	string	$order				排序条件
	 * @param	int		$intStartID		信息数据起始ID
	 * @param	int		$intListNum		列表行数
	 * @param	string	$field				查询字段
	 * @param	array		$arrData			预处理数组
	 * @param	bool		$blCount			是否同时回传数据行数
	 * @param	bool		$blComplex		使用优化查询,超大数据量效果明显,小数据不建议使用
	 * @return  array
	 */
	public function getInfoList($where='',$order='',$intStartID = 0,$intListNum = 0,$field = '*',$arrData = array(),$blCount = true,$blComplex = false){
		$table = $this->tablename1;
		$arrData=(empty($arrData)?array():$arrData);
		$limit = '';
		if($blComplex){
			if($where != '') $where .= " and id <= ( SELECT id FROM `$table` $order LIMIT $intStartID, 1 )";
			else $where = " where id <= ( SELECT id FROM `$table` $order LIMIT $intStartID, 1 )";
		}
		if (!empty($order)) {
			$limit .= $order;
		}
		if (!empty($intListNum)) $limit .= " LIMIT " . $intStartID .','. $intListNum;
		$blFetch = false;
		if($field === true) {
			$arrDBfield = $this->arrGPdoDB['db_table_field'];
			unset($arrDBfield['structon_tb']);
			$field = implode(',',array_keys($arrDBfield));
		}
		$arrData = $this->selectDataG($table,$where,$limit,$field,$blFetch,$arrData,$blCount);
		if(isset($arrData[0]['structon_tb'])) $arrData = $this->loadTableFieldG($arrData);
		return $arrData;
	}

	/**
	 * 获取信息随机列表数据
	 * @author	肖飞
	 * @param	string	$where				信息类型id
	 * @param	string	$order				排序条件
	 * @param	int		$intStartID		信息数据起始ID
	 * @param	int		$intListNum		列表行数
	 * @param	string	$field				查询字段
	 * @param	array		$arrData			预处理数组
	 * @param	bool		$blCount			是否同时回传数据行数
	 * @param	bool		$blComplex		使用优化查询,超大数据量效果明显,小数据不建议使用
	 * @return  array
	 */
	public function getRandInfoList($where='',$order='',$intStartID = 0,$intListNum = 0,$field = '*',$arrData = array(),$blCount = false,$blComplex = false){
		$intRows = $this->getRecordsG($this->tablename1,$where,$order);
		$intMargin = $intRows - $intListNum;
		if($intMargin > 0) $intStartID = rand(0,$intMargin);

		$arrData = $this->getInfoList($where,$order,$intStartID,$intListNum,$field,$arrData,$blCount,$blComplex);
		$arrTempRand = array();
		$arrTemp = array();
		foreach($arrData as $k => $v){
			if(empty($v['topflag']) && empty($v['recommendflag'])) $arrTempRand[] = $v;
			else $arrTemp[] = $v;
		}
		shuffle($arrTempRand);

		$arrData = array_merge($arrTemp,$arrTempRand);
		return $arrData;
	}

	/**
	 * 获取信息类型从属关系列表数据
	 * @author	肖飞
	 * @param	int		$type_id    信息类型id或者类型路由
	 * @param	array	$arrMType   分类数组
	 * @param	bool	$isTitle    是否只回传title
	 * @param	string	$table			表名
	 * @return  void
	 */
	public function getRoueList($type_id,$arrMType=null,$isTitle=false){
		$arrRoueList = array();
		if(empty($arrMType)){
			if(!is_numeric($type_id)) {
				$arrTemp = explode(":",$type_id);
				$type_id = array_pop($arrTemp);
			}
			$strSQL = "Select type_roue_id from $this->tablename2 "." Where type_id ='".$type_id."'";
			$rs = $this->db->query($strSQL);
			$arr = $rs->fetch(PDO::FETCH_ASSOC);
			if($arr){
				$rs = null;
				$strRoueID = $arr['type_roue_id'];
				$arrTypeID = explode(":",$strRoueID);
				foreach ($arrTypeID as $key=>$val){
					if($val == null) continue;
					if($isTitle){
						$arrRoueList[$key] = $this->getTypeTitle($val);
					}else{
						$arrRoueList[$key]['type_id'] = $val;
						$arrRoueList[$key]['type_title'] = $this->getTypeTitle($val);
					}
				}
			}
		}else{
			if(is_numeric($type_id)){
				foreach($arrMType as $v){
					if($type_id == $v['type_id']){
						$type_id = $v['type_roue_id'];
						break;
					}
				}
			}
			$arrTemp = explode(":",$type_id);
			foreach($arrTemp as $k => $v){
				foreach($arrMType as $v1){
					if($v == $v1['type_id']){
						if($isTitle){
							$arrRoueList[$k] = $v1['type_title'];
						}else{
							$arrRoueList[$k]['type_id'] = $v;
							$arrRoueList[$k]['type_title'] = $v1['type_title'];
						}
					}
				}
			}
		}

		return $arrRoueList;
	}


	/**
	 * 取得信息内容
	 * @author	肖飞
	 * @param	int $intInfoID    信息ID
	 * @param	string	$table			表名
	 * @return  void
	 */
	public function getInfo($intInfoID,$field = '*',$pass=null,$add=false){
		try {
			if($add) $this->updateClicktimes(" Where id =".$intInfoID);
			if($pass!=null) $where= " and pass='$pass'";
			else $where='';
			$strSQL = "SELECT $field FROM $this->tablename1 ".
			" Where id ='".$intInfoID."'".$where;
			$rs = $this->db->query($strSQL);
			$arrData = $rs->fetchall(PDO::FETCH_ASSOC);
			if(!empty($arrData[0]['structon_tb'])) $arrData = $this->loadTableFieldG($arrData);
			if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
			return current($arrData);
		} catch (PDOException $e) {
		    echo 'Failed: ' . $e->getMessage().'<br><br>';
		}
	}

	/**
	 * 取得信息内容(用where条件)
	 * @author	肖飞
	 * @param	string $strWhere    where条件
	 * @param	string $field	    查询字段名
	 * @param	string	$table		表名
	 * @return  array
	 */
	public function getInfoWhere($strWhere=null,$field = '*',$table=''){
		try {
			$table = $table?$table:$this->tablename1;
			$strSQL = "SELECT $field FROM $table $strWhere";
			$rs = $this->db->query($strSQL);
			$arrData = $rs->fetchall(PDO::FETCH_ASSOC);
			if(!empty($arrData[0]['structon_tb'])) $arrData = $this->loadTableFieldG($arrData);
			if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
			return current($arrData);
		} catch (PDOException $e) {
		    echo 'Failed: ' . $e->getMessage().'<br><br>';
		}
	}

	/**
	 * 增加信息阅读次数
	 * @author	肖飞
	 * @param	string	$strWhere    where条件
	 * @param	int		$intRand		随机数
	 * @param	string	$table			表名
	 * @return	boolen
	 */
	public function updateClicktimes($strWhere,$intRand=1,$table=''){
		try {
			$table = $table?$table:$this->tablename1;
			$strSQL = "UPDATE $this->tablename1 SET clicktimes = clicktimes+$intRand ".$strWhere;
			$rs = $this->db->query($strSQL);
			if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
			return $rs;
		} catch (PDOException $e) {
		    echo 'Failed: ' . $e->getMessage().'<br><br>';
		}
	}

	/**
	 * 取得信息阅读次数
	 * @author	肖飞
	 * @param	int $intInfoID    信息ID
	 * @param	int $intRand	  随机数
	 * @param	string	$table		表名
	 * @return	void
	 */
	public function getClicktimes($intInfoID,$intRand=1,$table=''){
		try{
			$table = $table?$table:$this->tablename1;
			$this->updateClicktimes(" Where id =".$intInfoID,$intRand);
			$strSQL = "select clicktimes from $table ".
			" Where id =".$intInfoID;
			$rs = $this->db->query($strSQL);
			if($this->arrGPdoDB['PDO_DEBUG']) echo $strSQL.'<br><br>';
			return $rs->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
		    echo 'Failed: ' . $e->getMessage().'<br><br>';
		}
	}

	/**
	 * 取得信息记录最大id号+1
	 * @author	肖飞
	 * @param	string	$table		表名
	 * @return	int
	 */
	public function getMaxID($table = ''){
		$table = $table?$table:$this->tablename1;
		$intInfoID = $this->getNextIDG($table);
		return $intInfoID;
	}

	/**
	 * 取得信息类别最大id号+1
	 * @author	肖飞
	 * @param	string	$table		表名
	 * @return	int
	 */
	public function getTypeMaxID($table = ''){
		$table = $table?$table:$this->tablename2;
		$intInfoID = $this->getNextIDG($table);
		return $intInfoID;
	}


	/**
	 * 插入信息类型数据
	 * @author	肖飞
	 * @param	array $arrType    信息类型数组
	 * @param	string	$table		表名
	 * @return	boolen
	 */
	public function insertType($arrType,$table = ''){
		$table = $table?$table:$this->tablename2;
		return $this->insertDataG($table,$arrType);
	}

	/**
	 * 修改信息类型数据
	 * @author	肖飞
	 * @param	array		$arrType	信息类型数组
	 * @param	string	$table		表名
	 * @return	boolen
	 */
	public function updateType($arrType,$table = ''){
		$table = $table?$table:$this->tablename2;
		$strWhere = " WHERE `type_id` = '$arrType[type_id]'";
		unset($arrType['type_id']);
		return $this->updateDataG($table,$arrType,$strWhere);
	}


	/**
	 * 删除信息类型数据
	 * @author	肖飞
	 * @param	string	$intTypeID	信息类型id
	 * @param	string	$table			表名
	 * @return	boolen
	 */
	public function deleteType($intTypeID,$table = ''){
		$table = $table?$table:$this->tablename2;
		$strWhere = " where type_id = $intTypeID";
		$arrInfoList = $this->getInfoList($strWhere);
		if($arrInfoList['COUNT_ROWS'] > 0){
			unset($arrInfoList['COUNT_ROWS']);
			foreach ($arrInfoList as $k => $v) {
				$this->deleteInfo($v['id']);
			}
		}
		$arrTypeList = $this->getTypeList();
		$arrChild = $this->fetchAllChildID($intTypeID, $arrTypeList);
		$strSQL = "DELETE FROM $table WHERE `type_id` IN (" . implode(',', $arrChild['type_id']) . ")";
		return $this->db->exec($strSQL);
	}

	/**
	 * 生成类型缓存数据
	 * @author	肖飞
	 * @param	string $strModuleID    栏目ID
	 * @return	void
	 */
	public function makeTypeCache($strModuleID){
		//分类缓存
		$strFileNameB = __WEB_ROOT.'/data/'.$strModuleID.'/'.$strModuleID.'_type_b.php'; //后台用带├格式化的缓存
		$strFileName  = __WEB_ROOT.'/data/'.$strModuleID.'/'.$strModuleID.'_type.php'; //排列后的原始数据缓存
		// 原文件删除
		if(is_file($strFileNameB)) {
			unlink($strFileNameB);
		}
		if(is_file($strFileName)) {
			unlink($strFileName);
		}
		$arrMType = $this->getTypeList();
		$arrMType = $this->formatTypeList(0,$arrMType,false);
		$objCache = new cache($strFileName);
		$str='<?php'."\n".'$arrMType = '.var_export($arrMType,true).';'."\n".'?>';
		$objCache->write_file($str);

		$arrMTypeB = $this->formatTypeList(0,$arrMType);
		$objCache = new cache($strFileNameB);
		$str='<?php'."\n".'$arrMTypeB = '.var_export($arrMTypeB,true).';'."\n".'?>';
		$objCache->write_file($str);
		unset($_GET['action']);
		//更新共享内存
		eval(menload_file($strFileNameB,2));
		eval(menload_file($strFileName,2));
	}

	/**
	 * 插入信息
	 * @author	肖飞
	 * @param	array		$arrData	信息数组
	 * @param	string	$table		表名
	 * @return	boolen
	 */
	public function insertInfo($arrData,$table = ''){
		$table = $table?$table:$this->tablename1;
		return $this->insertDataG($table,$arrData);
	}

	/**
	 * 修改信息
	 * @author	肖飞
	 * @param	array $arrData    信息数组
	 * @param	string	$table		表名
	 * @return	boolen
	 */
	public function updateInfo($arrData,$table = ''){
		$table = $table?$table:$this->tablename1;
		$strWhere = " WHERE id = '$arrData[id]'";
		unset($arrData['id']);
		return $this->updateDataG($table,$arrData,$strWhere);
	}

	/**
	 * 修改信息内容(用where条件)
	 * @author	肖飞
	 * @param	string	$strWhere		where条件
	 * @param	array		$arrData		信息数组
	 * @param	string	$table			表名
	 * @return	boolen
	 */
	public function updateInfoWhere($strWhere,$arrData,$table = ''){
		$table = $table?$table:$this->tablename1;
		return $this->updateDataG($table,$arrData,$strWhere);
	}

	/**
	 * 覆盖信息
	 * @author	肖飞
	 * @param	array $arrData    信息数组
	 * @param	string	$table			表名
	 * @return  void
	 */
	public function replaceInfo($arrData,$table = ''){
		$table = $table?$table:$this->tablename1;
		$strSQL = "REPLACE INTO $table (";
		$strSQL .= '`';
		$strSQL .= implode('`,`', array_keys($arrData));
		$strSQL .= '`)';
		$strSQL .= " VALUES ('";
		$strSQL .= implode("','",$arrData);
		$strSQL .= "')";
		return $this->db->exec($strSQL);
	}

	/**
	 * 删除信息
	 * @author	肖飞
	 * @param	int		$intInfoID				信息id
	 * @param	array		$arrFile					需要删除的文件字段名
	 * @param	bool		$isUpdateCache	是否同步更新缓存
	 * @param	string	$table					表名
	 * @return  void
	 */
	public function deleteInfo($intInfoID,$arrFile=array('photo'),$isUpdateCache=true,$table = ''){
		$table = $table?$table:$this->tablename1;
		if($arr = $this->getInfo($intInfoID)){
			if(!empty($this->arrGPic['FileSavePath'])){
				foreach($arrFile as $val){
					if(!empty($arr[$val]) && is_array($arr[$val])){
						foreach($arr[$val] as $v){
							if(is_string($v)) {
								@unlink($this->arrGPic['FileSavePath'].$v);
								@unlink($this->arrGPic['FileSavePath'].'s/'.$v);
								@unlink($this->arrGPic['FileSavePath'].'m/'.$v);
								@unlink($this->arrGPic['FileSavePath'].'b/'.$v);
								@unlink($this->arrGPic['FileSavePath'].'f/'.$v);
							}
							if(is_array($v)){
								@unlink($this->arrGPic['FileSavePath'].$v[$val]);
								@unlink($this->arrGPic['FileSavePath'].'s/'.$v[$val]);
								@unlink($this->arrGPic['FileSavePath'].'m/'.$v[$val]);
								@unlink($this->arrGPic['FileSavePath'].'b/'.$v[$val]);
								@unlink($this->arrGPic['FileSavePath'].'f/'.$v[$val]);
							}
						}
					}elseif(!empty($arr[$val]) && is_string($arr[$val])){
						@unlink($this->arrGPic['FileSavePath'].$arr[$val]);
						@unlink($this->arrGPic['FileSavePath'].'s/'.$arr[$val]);
						@unlink($this->arrGPic['FileSavePath'].'m/'.$arr[$val]);
						@unlink($this->arrGPic['FileSavePath'].'b/'.$arr[$val]);
						@unlink($this->arrGPic['FileSavePath'].'f/'.$arr[$val]);
					}
				}
			}
		}else{
			check::AlertExit('ID号为 '.$intInfoID.' 的记录并不存在！',-1);
		}
		$strWhere = " WHERE `id` = $intInfoID";
		//清除缓存
		if($this->deleteDataG($table,$strWhere)){
			if($isUpdateCache) $this->updateCache($arr['id'],$arr['type_id'],$this->arrMOutput);
			return true;
		}
	}

	/**
	 * 删除信息信息附属文件
	 * @author	肖飞
	 * @param	int		$intInfoID		信息id
	 * @param	bool		$blAlert			是否出警告
	 * @param	array		$arrFile			需要删除的文件字段名
	 * @return  void
	 */
	public function deleteInfoPic($intInfoID,$blAlert=true,$arrFile=array('photo')){
		if($arr = $this->getInfo($intInfoID)){
			if(empty($this->arrGPic['FileSavePath'])) check::AlertExit('文件保存路径未提供，请检查配置文件arrGPic[FileSavePath]的参数！',-1);
			foreach($arrFile as $val){
				if(empty($arr[$val])) check::AlertExit('ID号为 '.$intInfoID.' 的记录并无附属文件！',-1);
				if(!empty($arr[$val]) && is_array($arr[$val])){
					foreach($arr[$val] as $v){
						if(is_string($v)) {
							@unlink($this->arrGPic['FileSavePath'].$v);
							@unlink($this->arrGPic['FileSavePath'].'s/'.$v);
							@unlink($this->arrGPic['FileSavePath'].'m/'.$v);
							@unlink($this->arrGPic['FileSavePath'].'b/'.$v);
							@unlink($this->arrGPic['FileSavePath'].'f/'.$v);
						}
						if(is_array($v)){
							@unlink($this->arrGPic['FileSavePath'].$v[$val]);
							@unlink($this->arrGPic['FileSavePath'].'s/'.$v[$val]);
							@unlink($this->arrGPic['FileSavePath'].'m/'.$v[$val]);
							@unlink($this->arrGPic['FileSavePath'].'b/'.$v[$val]);
							@unlink($this->arrGPic['FileSavePath'].'f/'.$v[$val]);
						}
					}
				}elseif(!empty($arr[$val]) && is_string($arr[$val])){
					@unlink($this->arrGPic['FileSavePath'].$arr[$val]);
				}
			}
			unset($arr[$val]);
			unset($arr['thumbnail']);
		}

		$arrData = $this->saveTableFieldG($arr);
		if($this->updateInfo($arrData)){
			if($blAlert) check::Alert('图片删除成功!');
		}else{
			if($blAlert) check::Alert('图片删除失败!');;
		}
	}

	/**
	 * 提前信息
	 * @author	肖飞
	 * @param	int		$intInfoID    信息id
	 * @param	string	$table			表名
	 * @return	boolen
	 */
	public function moveupInfo($intInfoID,$table = ''){
		$table = $table?$table:$this->tablename1;
		$arrData['submit_date'] = date('Y-m-d H:i:s');
		$strWhere = " WHERE `id` = $intInfoID";
		return $this->updateDataG($table,$arrData,$strWhere);
	}

	/**
	 * 隐藏/公布信息
	 * @author	肖飞
	 * @param	int		$intInfoID    信息id
	 * @param	string	$table			表名
	 * @return	boolen
	 */
	public function passInfo($intInfoID,$pass,$strWhere=null,$table = ''){
		$table = $table?$table:$this->tablename1;
		$arrData['pass'] = $pass;
		if(empty($strWhere)) $strWhere = " WHERE `id` = $intInfoID";
		return $this->updateDataG($table,$arrData,$strWhere);
	}

	/**
	 * 固顶/解固信息
	 * @author	肖飞
	 * @param	int		$intInfoID    信息id
	 * @param	string	$table			表名
	 * @return	boolen
	 */
	public function topInfo($intInfoID,$topflag,$table = ''){
		$table = $table?$table:$this->tablename1;
		$arrData['topflag'] = $topflag;
		$strWhere = " WHERE `id` = $intInfoID";
		return $this->updateDataG($table,$arrData,$strWhere);
	}

	/**
	 * 推荐/解除推荐信息
	 * @author	肖飞
	 * @param	int		$intInfoID    信息id
	 * @param	string	$table			表名
	 * @return	boolen
	 */
	public function recommendInfo($intInfoID,$recommendflag,$table = ''){
		$table = $table?$table:$this->tablename1;
		$arrData['recommendflag'] = $recommendflag;
		$strWhere = " WHERE `id` = $intInfoID";
		return $this->updateDataG($table,$arrData,$strWhere);
	}

	//逻辑功能
	/**
	 * 将类别按父子关系格式输出，并在title前加上缩进
	 * @author	肖飞
	 * @param	int		$root			起始节点
	 * @param	array		$arrList			类型数组
	 * @param	bool		$blSpace		缩进代码
	 * @param	int		$depth			缩进层次
	 * @param	array		$arrReturn	格式完输出数组
	 * @return	array
	 */
	public function formatTypeList($root, $arrList,$blSpace=true, &$depth=0, &$arrReturn=array()) {
		foreach ($arrList as $k => $list) {
			if ($list['type_parentid'] == $root) {
				$strSpace = '';
				$arrTemp = explode(':', $list['type_roue_id']);
				$total = count($arrTemp);
				for($i=0;$i<$total;$i++){
					if ($total == 3) break;
					if($arrTemp[$i] == null) continue;
					if($blSpace){
						if($i == 0) $strSpace .= '&nbsp;&nbsp;';
						if($arrTemp[$i] == $list['type_id'] ){

							$strSpace .= '├&nbsp;';
						}else{
							if($arrTemp[$i] != $list['type_parentid'])	$strSpace .= '│&nbsp;&nbsp;';
						}
					}
				}
				if($blSpace){
					if(empty($list['initial'])) $list['type_title'] = $strSpace . $list['type_title'];
					else $list['type_title'] = $strSpace .$list['initial'].' '.$list['type_title'];
				}
				$arrReturn[] = $list ;
				$depth++;
				$this->formatTypeList($list['type_id'], $arrList,$blSpace, $depth, $arrReturn);
				$depth--;
			}
		}
		return $arrReturn;
	}

	/**
	 * 生成信息类型列表
	 * @author	肖飞
	 * @return	array
	 */
	public function makeTypeList(){
		if($arrTypeList = $this->getTypeList()){
			// 得到父分类名称
			foreach ($arrTypeList as $k => $types) {
				 $arrTypeList[$k]['type_parent_title'] = '<i>ROOT</i>' ;
				foreach ($arrTypeList as $k1 => $types1) {
					if ($types['type_parentid'] == $types1['type_id']){
						$arrTypeList[$k]['type_parent_title'] = $types1['type_title'] ;
					}
				}
			}
		}
		return $arrTypeList;
	}

	/**
	 * 插入信息类型
	 * @author	肖飞
	 * @param	array	$arrData    提交的数据数组
	 * @return	void
	 */
	public function makeInsertType($arrData){
		if ($arrData['type_roue_id'] != ':0:'){
			$arrTemp = explode(':',$arrData['type_roue_id']);
			$arrData['type_parentid'] = max($arrTemp);
			if($arrData['type_id']) $arrData['type_roue_id'] .= $arrData['type_id'].':';
			else $arrData['type_roue_id'] .= $this->getTypeMaxID().':';
		}else{
			$arrData['type_parentid'] = 0;
			if($arrData['type_id']) $arrData['type_roue_id'] = ':'.$arrData['type_id'].':';
			else $arrData['type_roue_id'] = ':'.$this->getTypeMaxID().':';
		}

		$this->insertType($arrData);
	}

	/**
	 * 修改信息类型
	 * @author	肖飞
	 * @param	array	$arrData    提交的数据数组
	 * @return	void
	 */
	public function makeUpdateType($arrData){
		if ($arrData['type_roue_id'] != ':0:'){
			$arrTemp = explode(':',$arrData['type_roue_id']);
			$arrData['type_parentid'] = max($arrTemp);
			if($arrData['type_id'] == $arrData['type_parentid']) check::AlertExit('父类不能选择自己!',-1);
			$arrData['type_roue_id'] .= $arrData['type_id'].':';
		}else{
			$arrData['type_parentid'] = 0;
			$arrData['type_roue_id'] = ':'.$arrData['type_id'].':';
		}
		$this->updateType($arrData);
	}


	/**
	 * 生成信息列表
	 * @author	肖飞
	 * @param	string		$strWhere			查询条件
	 * @param	int			$intStartID		信息数据起始ID
	 * @param	int			$intListNum		列表行数
	 * @param	string		$order				排序条件
	 * @return	array or false
	 */
	public function makeInfoList($strWhere,$order=null,$intStartID,$intListNum = 20){
		if($arr = $this->getInfoList($strWhere,$order,$intStartID,$intListNum)){
			return $arr;
		}else{
			return false;
		}
	}

	/**
	 * 信息入库保存
	 * @author	肖飞
	 * @param	int $arrData		信息信息数组
	 * @param	int $intModify	是否修改
	 * @param	int $isAlert		是否出警告提示
	 * @param	int $isLastID		是否返回最后ID
	 * @return  void
	 */
	public function saveInfo($arrData,$intModify=0,$isAlert=true,$isLastID=false){
		//非法信息过滤
		@include_once(__WEB_ROOT.'/data/illegal.inc.php');
		if(!empty($arrGIllegal) && !empty($arrData['intro'])){
			foreach($arrGIllegal as $k => $v){
				if($v['pass'] == 1){
					$arrData['intro'] = str_ireplace($k,$v['replace'],$arrData['intro']);
					if(!empty($arrData['title'])) $arrData['title'] = str_ireplace($k,$v['replace'],$arrData['title']);
					if(!empty($arrData['summary'])) $arrData['summary'] = str_ireplace($k,$v['replace'],$arrData['summary']);
				}
			}
		}
		//关键词广告
		@include_once(__WEB_ROOT.'/data/keywords.inc.php');
		if(!empty($arrGKeywords) && !empty($arrData['intro'])){
			//原有链接的去除链接
			foreach($arrGKeywords as $k => $v){
				if($v['pass'] == 1){
					$arrData['intro'] =  preg_replace('/(<a.*?>\s*)('.$k.')(\s*<\/a>)/sui', '${2}', $arrData['intro']);
				}
			}
			//重新加上链接
			foreach($arrGKeywords as $k => $v){
				if($v['pass'] == 1){
					$arrData['intro'] = str_ireplace($k,"<a class=keyad target=_blank href=$v[url]>$k</a>",$arrData['intro']);
				}
			}
		}
		$arr = check::SqlInjection($this->saveTableFieldG($arrData));
		
		if($intModify == 0){
			if(array_key_exists('user_id',$arr)&&empty($arr['user_id'])) $arr['user_id'] = intval($_SESSION['user_id']);
			if($this->insertInfo($arr)){
				if($isAlert) check::Alert('发布成功!');
				if($isLastID) return $this->lastInsertIdG();
				else return true;
			}else{
				if($isAlert) check::Alert('发布失败!');
				return false;
			}
		}
		if($intModify == 1){
			
			if($this->updateInfo($arr) !== false){
				if($isAlert) check::Alert('修改成功!');
				return true;
			}else{
				if($isAlert) check::Alert('修改失败!');
				return false;
			}
		}
		if($intModify == 2){
			if($this->replaceInfo($arr)){
				if($isAlert) check::Alert('发布成功!');
				return true;
			}else{
				if($isAlert) check::Alert('发布失败!');
				return false;
			}
		}

	}

	/**
	 * 保存抓取其他网站的内容
	 * @author	肖飞
	 * @param	array $arrData    新闻信息数组
	 * @return	void
	 */
	public function saveFetchInfo($arrData){
		//非法信息过滤
		@include_once(__WEB_ROOT.'/data/illegal.inc.php');
		if(!empty($arrGIllegal) && !empty($arrData['intro'])){
			foreach($arrGIllegal as $k => $v){
				if($v['pass'] == 1){
					$arrData['title'] = str_ireplace($k,$v['replace'],$arrData['title']);
					$arrData['intro'] = str_ireplace($k,$v['replace'],$arrData['intro']);
				}
			}
		}
		//关键词广告
		@include_once(__WEB_ROOT.'/data/keywords.inc.php');
		if(!empty($arrGKeywords) && !empty($arrData['intro'])){
			foreach($arrGKeywords as $k => $v){
				if($v['pass'] == 1){
					$arrData['intro'] = str_ireplace($k,'<A href="'.$v[url].'" class=keyad target=_blank>$k</A>',$arrData['intro']);
				}
			}
		}
		$arr = array();
		$arr = check::SqlInjection($this->saveTableFieldG($arrData),true);
		$arr['user_id'] = intval($_SESSION['user_id']);
		if($this->insertInfo($arr)){
			echo ('<pre><font color=#ff0000>'.$arr['title'].'</font> 写入成功！</pre>');
		}else{
			echo ('<pre><font color=#ff0000>'.$arr['title'].'</font> 写入失败！</pre>');
		}

	}

	/**
	 * 上传信息图片
	 * @author	肖飞
	 * @param array	 	$arrFile					图片文件信息数组$_FILES
	 * @param int 			$num					图片的标号（用于多图上传）
	 * @param array		$FileListPicSize		缩略图压缩的尺寸(像素数组,存放目录小图s，中图m，例如：array('s'=>array(50,50),'m'=>array(100,100));)
	 * @param int 			$FileSourPicSize	原图压缩的尺寸（像素数组,存放目录b，例如：array(600,600)）
	 * @param int			$intInfoID				相关数据记录ID，标示新增还是修改。
	 * @param int			$intFetch				是否来自采集
	 * @param bool		$blTime				新文件名是否使用时间戳
	 * @param string		$FileExt					文件后缀名
	 * @return string
	 */
     public function uploadInfoImage($arrFile,$num=null,$FileListPicSize=0,$FileSourPicSize=0,$intInfoID=0,$intFetch=0,$blTime=true,$FileExt=''){
		if ($arrFile['error'] != 0) {
			switch($arrFile['error']){
				case 1:
					$strError = '文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
				break;
				case 2:
					$strError = '文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
				break;
				case 3:
					$strError = '文件只有部分被上传';
				break;
				case 4:
					$strError = '没有文件被上传';
				break;
				case 6:
					$strError = '找不到临时文件夹';
				break;
				case 7:
					$strError = '文件写入失败';
				break;
			}
			check::AlertExit('文件上传错误！('.$strError.')',-1);
		}
		if ($arrFile['name']) {
			$strFileType = strtolower($arrFile['type']);
			if (!in_array( $strFileType , array( 'image/jpg','image/jpeg', 'image/gif' , 'image/pjpeg','image/png','image/x-png'))) {
				check::AlertExit('文件类型不符合要求('.$arrFile['type'].')',-1);
			}
		}
		if($intInfoID == 0)	$intID = $this->getMaxID();
		else $intID = $intInfoID;
		$strDir = ceil($intID/$this->arrGCache['cache_filenum']);
		if(!is_dir($this->arrGPic['FileSavePath'])){
			@mkdir($this->arrGPic['FileSavePath']);
			@chmod($this->arrGPic['FileSavePath'],0777);
		}
		$strMakeDir = $this->arrGPic['FileSavePath'].'b/';
		if( !is_dir($strMakeDir) ){
			@mkdir ($strMakeDir);
			@chmod ($strMakeDir, 0777);
		}
		$strMakeDir = $strMakeDir.$strDir;
		if( !is_dir($strMakeDir) ){
			@mkdir ($strMakeDir);
			@chmod ($strMakeDir, 0777);
		}

		if($FileExt == '') $FileExt=strtolower(strrchr($arrFile['name'],'.'));  //取得上传文件扩展名
		if($blTime) $strTime = time();
		else $strTime = '';
		if(!empty($num)) {
			$strPhoto = $strDir.'/'.$intID.'_'.$strTime."_$num".$FileExt;  //存入数据库的图片访问路径
			$strPicName = $strMakeDir.'/'.$intID.'_'.$strTime."_$num".$FileExt;  //新图片路径及名称
		}else{
			$strPhoto = $strDir.'/'.$intID.'_'.$strTime.$FileExt;
			$strPicName = $strMakeDir.'/'.$intID.'_'.$strTime.$FileExt;
		}
		if(!empty($FileListPicSize)){
			//所有的图都生成缩略图
			$strMakeSmallDir = $this->arrGPic['FileSavePath'].'s/';
			if( !is_dir($strMakeSmallDir) ){
				@mkdir ($strMakeSmallDir);
				@chmod ($strMakeSmallDir, 0777);
			}
			$strMakeSmallDir = $strMakeSmallDir.$strDir;
			if( !is_dir($strMakeSmallDir) ){
				@mkdir ($strMakeSmallDir);
				@chmod ($strMakeSmallDir, 0777);
			}
			$strMakeMiddleDir = $this->arrGPic['FileSavePath'].'m/';
			if( !is_dir($strMakeMiddleDir) ){
				@mkdir ($strMakeMiddleDir);
				@chmod ($strMakeMiddleDir, 0777);
			}
			$strMakeMiddleDir = $strMakeMiddleDir.$strDir;
			if( !is_dir($strMakeMiddleDir) ){
				@mkdir ($strMakeMiddleDir);
				@chmod ($strMakeMiddleDir, 0777);
			}
			if(!empty($num)) {
				$strSmallPicName = $strMakeSmallDir.'/'.$intID.'_'.$strTime."_$num".$FileExt;
				$strMiddlePicName = $strMakeMiddleDir.'/'.$intID.'_'.$strTime."_$num".$FileExt;
			}else{
				$strSmallPicName = $strMakeSmallDir.'/'.$intID.'_'.$strTime.$FileExt;
				$strMiddlePicName = $strMakeMiddleDir.'/'.$intID.'_'.$strTime.$FileExt;
			}
			$arrTemp = getimagesize($arrFile['tmp_name']);
			$arrImageInfo["width"] = $arrTemp[0];
			$arrImageInfo["height"]= $arrTemp[1];

			if(is_array($FileListPicSize)){
				//生成s小缩略图
				if(!empty($FileListPicSize['s'])){
					Asido::Driver('gd');
					$i1 = Asido::Image($arrFile['tmp_name'], $strSmallPicName);
					if($FileListPicSize['s'][0] == 0) {//小图宽0
						if($FileListPicSize['s'][1] > 0) {
							Asido::height($i1, $FileListPicSize['s'][1]);
							$i1->save(ASIDO_OVERWRITE_ENABLED);
						}
					}elseif($FileListPicSize['s'][1] == 0) {//小图高0
						Asido::width($i1, $FileListPicSize['s'][0]);
						$i1->save(ASIDO_OVERWRITE_ENABLED);
					}elseif(Asido::resize($i1, $FileListPicSize['s'][0], $FileListPicSize['s'][1],$this->arrGPic['zoomMode'])){
						$i1->save(ASIDO_OVERWRITE_ENABLED);
					}else{
						check::AlertExit($strSmallPicName.'缩略图生成错误！',-1);
					}
				}
				//生成m中缩略图
				if(!empty($FileListPicSize['m'])){
					Asido::Driver('gd');
					$i1 = Asido::Image($arrFile['tmp_name'], $strMiddlePicName);
					if($FileListPicSize['m'][0] == 0) {
						if($FileListPicSize['m'][1] > 0) {
							Asido::height($i1, $FileListPicSize['m'][1]);
							$i1->save(ASIDO_OVERWRITE_ENABLED);
						}
					}elseif($FileListPicSize['m'][1] == 0) {
						Asido::width($i1, $FileListPicSize['m'][0]);
						$i1->save(ASIDO_OVERWRITE_ENABLED);
					}elseif(Asido::resize($i1, $FileListPicSize['m'][0], $FileListPicSize['m'][1],$this->arrGPic['zoomMode'])){
						$i1->save(ASIDO_OVERWRITE_ENABLED);
					}else{
						check::AlertExit($strMiddlePicName.'缩略图生成错误！',-1);
					}
				}
			}else{
				if(!empty($FileListPicSize)) check::AlertExit('缩略图的定义格式已经升级，请检查var.inc.php中$arrGPic[FileListPicSize]的定义！',-1);
			}
		}
		if(!empty($FileSourPicSize)){//原图容量>最大容量设定，就自动压缩原图
			if($intFetch) copy($arrFile['tmp_name'], $strPicName);
			else move_uploaded_file($arrFile['tmp_name'], $strPicName);
			if(is_array($FileSourPicSize)){
				Asido::Driver('gd');
				$i1 = Asido::Image($strPicName, $strPicName);
				if($FileSourPicSize[0] == 0) {//设定宽=0，则不定宽，定高压缩
					if($FileSourPicSize[1] > 0  && $FileSourPicSize[1] < $arrImageInfo['height']) {
						Asido::height($i1, $FileSourPicSize[1]);
						if($this->arrGPic['waterMark']) Asido::watermark($i1, __WEB_ROOT."/data/".$this->arrGPic['waterImage'], $this->arrGPic['waterPos'], ASIDO_WATERMARK_SCALABLE_ENABLED, 0.5);
						$i1->save(ASIDO_OVERWRITE_ENABLED);
					}
					return $strPhoto;
				}elseif($FileSourPicSize[1] == 0) {//设定高=0，则不定高，定宽压缩
					if($FileSourPicSize[0] > 0  && $FileSourPicSize[0] < $arrImageInfo['width']) {
						Asido::width($i1, $FileSourPicSize[0]);
						if($this->arrGPic['waterMark']) Asido::watermark($i1, __WEB_ROOT."/data/".$this->arrGPic['waterImage'], $this->arrGPic['waterPos'], ASIDO_WATERMARK_SCALABLE_ENABLED, 0.5);
						$i1->save(ASIDO_OVERWRITE_ENABLED);
					}
					return $strPhoto;
				}elseif(Asido::resize($i1, $FileSourPicSize[0], $FileSourPicSize[1],$this->arrGPic['zoomMode'])){//定宽，定高压缩
					if($this->arrGPic['waterMark']) Asido::watermark($i1, __WEB_ROOT."/data/".$this->arrGPic['waterImage'], $this->arrGPic['waterPos'], ASIDO_WATERMARK_SCALABLE_ENABLED, 0.5);
					$i1->save(ASIDO_OVERWRITE_ENABLED);
					return $strPhoto;
				}else{
					check::AlertExit($strPicName.'文件上传错误！',-1);
				}
			}else{
				if(!empty($FileSourPicSize)) check::AlertExit('原图的定义格式已经升级，请检查var.inc.php中$arrGPic[FileSourPicSize]的定义！',-1);
			}
		}else{
			//原图容量<=最大容量设定，就不压缩原图
			if($intFetch){
				if(copy($arrFile['tmp_name'], $strPicName)){
					return $strPhoto;
				}else{
					echo $strPicName.'文件上传错误！';exit;
				}
			}else{
				if(move_uploaded_file($arrFile['tmp_name'], $strPicName)){
					return $strPhoto;
				}else{
					check::AlertExit($strPicName.'文件上传错误！',-1);
				}
			}
		}
	}

	/**
	 * 上传文件
	 * @author	肖飞
	 * @param array	$arrFile			图片文件信息数组$_FILES
	 * @param int		$intInfoID		模板内容ID，标示新增还是修改
	 * @param int 		$num			文件的标号（用于多文件上传）
	 * @param int 		$arrFileExt		允许上传的文件后缀
	 * @return string
	 */
	public function uploadInfoFile($arrFile,$num=null,$intInfoID=0,$arrFileExt=array('.rar','.zip','.doc','.pdf','.txt','.xls','.xlsx')){
		$intInfoID=(is_null($intInfoID)?0:$intInfoID);

		if ($arrFile['error'] != 0) {
			switch($arrFile['error']){
				case 1:
					$strError = '文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
				break;
				case 2:
					$strError = '文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
				break;
				case 3:
					$strError = '文件只有部分被上传';
				break;
				case 4:
					$strError = '没有文件被上传';
				break;
				case 6:
					$strError = '找不到临时文件夹';
				break;
				case 7:
					$strError = '文件写入失败';
				break;
			}
			check::AlertExit('文件上传错误！('.$strError.')',-1);
		}

		if ($arrFile['name']) {
			$strFileExt = strrchr($arrFile['name'],'.');
			if (!in_array( strtolower($strFileExt) , $arrFileExt)) {
				check::AlertExit('文件类型不符合要求('.$strFileExt.')',-1);
			}
		}

		if($intInfoID == 0)	$intID = $this->getMaxID();
		else $intID = $intInfoID;
		$strDir = ceil($intID/$this->arrGCache['cache_filenum']);
		if(!is_dir($this->arrGPic['FileSavePath'])){
			@mkdir($this->arrGPic['FileSavePath']);
			@chmod($this->arrGPic['FileSavePath'],0777);
		}
		$strMakeDir = $this->arrGPic['FileSavePath'].'f/';
		if( !is_dir($strMakeDir) ){
			@mkdir ($strMakeDir);
			@chmod ($strMakeDir, 0777);
		}
		$strMakeDir = $strMakeDir.$strDir;
		if( !is_dir($strMakeDir) ){
			@mkdir ($strMakeDir);
			@chmod ($strMakeDir, 0777);
		}

		$strTime = time();
		if(!empty($num)) {
			$strfile = 'f/'.$strDir.'/'.$intID.'_'.$strTime."_$num".$strFileExt;  //存入数据库的文件访问路径
			$strFileName = $strMakeDir.'/'.$intID.'_'.$strTime."_$num".$strFileExt;  //新文件路径及名称
		}else{
			$strfile = 'f/'.$strDir.'/'.$intID.'_'.$strTime.$strFileExt;
			$strFileName = $strMakeDir.'/'.$intID.'_'.$strTime.$strFileExt;
		}

		if(move_uploaded_file($arrFile['tmp_name'], $strFileName)){
			return $strfile;
		}else{
			check::AlertExit($strFileName.'文件上传错误！',-1);
		}
	}

	/**
	 * 生成信息列表翻页
	 * @author	肖飞
	 * @param	int		$records		总记录数
	 * @param	string	$link				翻页链接
	 * @param	int		$link_type		链接类型 0=普通 1=静态优化 2=Wap链接
	 * @param	string	$link_style		链接样式 缺省为1:2:3:6 ,每个数字代表下面样式中的1行
	 * @param	int		$page_size	特定页面记录条数
	 * @param	string	$js_fun			需要执行的JavaScript函数
	 * @return  string
	 */
	public function makeInfoListPage($records,$link=null,$link_type=0,$link_style='1:2:3:6',$page_size=null,$js_fun=""){
		return $this->pageG($records,$link,$link_type,$link_style,$page_size,$js_fun);
	}


	/**
	 * 更新页面缓存（纯静态和smarty缓存）
	 * @author	肖飞
	 * @param	int		$id					记录ID数或者单页数组的KEY
	 * @param	int		$type_id			栏目类型ID 便于清除列表页的缓存
	 * @param	array		$arrMOutput	输出到smartyd的数组
	 * @return	void
	 */
	public function updateCache($id,$type_id=1,$arrMOutput = array()){
		global $arrGWeb,$arrGCache;
		if($arrGWeb['file_static']){
			//生成静态页面
			$intID = intval($id);
			$strDir = ceil($intID/$arrGCache['cache_filenum']);
			if(empty($intID)){
				//单页栏目
				$intID = $id;
				$strCacheFile = $arrGCache['cache_root'].'/'.$id.$arrGWeb['file_suffix'];
				@unlink($arrGCache['cache_root'].'/'.$id.'tw'.$arrGWeb['file_suffix']);
			}else{
				//其他栏目
				$strCacheFile = $arrGCache['cache_root'].'-'.$strDir.'/'.$intID.$arrGWeb['file_suffix'];
				@unlink($arrGCache['cache_root'].'-'.$strDir.'/'.$intID.'tw'.$arrGWeb['file_suffix']);
			}
			$objCache = new cache($strCacheFile,$arrGCache['cache_time']);
			$objCache->cache_start();
			$strContents = @file_get_contents('http://'.$_SERVER["HTTP_HOST"].$arrGWeb['WEB_ROOT_pre'].'/'.$arrGWeb['module_id'].'/detail.php?id='.$intID);
			if($strContents){
				echo $strContents;
			}
			$objCache->cache_end(false);

		}
		if($arrGWeb['URL_static']){
			//更新smarty缓存
			$objSmarty = new SmartyTpl();
			if(empty($arrMOutput['template_dir'])) $objSmarty->setTemplateDir($this->arrGSmarty['template_dir']);
			else $objSmarty->setTemplateDir($arrMOutput['template_dir']);
			$objSmarty->setCompileDir($this->arrGSmarty['compile_dir']);
			$objSmarty->setCacheDir($this->arrGSmarty['cache_dir']);
			$objSmarty->plugins_dir = $this->arrGSmarty['plugins_dir'];
			$arrMOutput['smarty_debug'] ='';
			$arrMOutput['smarty_debug'] ? $objSmarty->compile_check = true : '';
			$arrMOutput['smarty_debug'] ? $objSmarty->debugging = true : '';
			$objSmarty->caching = $this->arrGSmarty['caching'];
			if($objSmarty->caching) {
				$objSmarty->cache_lifetime = isset($this->arrGSmarty['cache_lifetime'])?$this->arrGSmarty['cache_lifetime']:3600;
				$objSmarty->cache_modified_check = isset($this->arrGSmarty['cache_modified_check'])?$this->arrGSmarty['cache_modified_check']:false;
			}
			if (!empty($arrMOutput['smarty_assign'])){
				while(list($key,$value) = each($arrMOutput['smarty_assign'])){
					$objSmarty->assign($key,$value);
				}
			}
			if($_SESSION['langset'] == 'zh_tw'){
				$objSmarty->autoload_filters = array('output' => array('langset'));
			}

			$objSmarty->clearCache($arrMOutput['template_file'],$_SESSION['langset'].'/');
			$objSmarty->clearCache($arrMOutput['template_file'],$_SESSION['langset'].'/index.php');
			$objSmarty->clearCache($arrMOutput['template_file'],$_SESSION['langset'].'/'.$arrGWeb['module_id'].'/');
			$objSmarty->clearCache($arrMOutput['template_file'],$_SESSION['langset'].'/'.$arrGWeb['module_id'].'/index.php');
			$objSmarty->clearCache($arrMOutput['template_file'],$_SESSION['langset'].'/'.$arrGWeb['module_id'].'/list/');
			$objSmarty->clearCache($arrMOutput['template_file'],$_SESSION['langset'].'/'.$arrGWeb['module_id'].'/list.php');
			$objSmarty->clearCache($arrMOutput['template_file'],$_SESSION['langset'].'/'.$arrGWeb['module_id'].'/list/type_id-'.$type_id.$arrGWeb['file_suffix']);
			$objSmarty->clearCache($arrMOutput['template_file'],$_SESSION['langset'].'/'.$arrGWeb['module_id'].'/list.php/type_id-'.$type_id.$arrGWeb['file_suffix']);
			$objSmarty->clearCache($arrMOutput['template_file'],$_SESSION['langset'].'/'.$arrGWeb['module_id'].'/list.php?type_id='.$type_id);

		}
		if($arrGWeb['PDO_CACHE']){
			if(!empty($this->arrGPdoDB['PDO_CACHE_ROOT'])) check::delTreeDirs($this->arrGPdoDB['PDO_CACHE_ROOT']);
		}

	}


	/**
	 * 执行信息操作
	 * @author	肖飞
	 * @param	string	$strAction		执行命令
	 * @param	array		$arrData		选中的操作数据id数组
	 * @param	array		$arrFile			需要删除的文件
	 * @return	boolen
	 */
	public function doInfoAction($strAction=null,$arrData=null,$arrFile=array('photo')){
		switch ($strAction){
			case 'del':
				foreach ($arrData as $key=>$val){
					if (! $this->checkPopedomG($_SESSION['user_id'],'d')) {
						check::AlertExit('对不起，您没有删除权限',-1);
					}
					$this->deleteInfo($val,$arrFile);
				}
				break;
			case 'delpic':
				foreach ($arrData as $key=>$val){
					if (! $this->checkPopedomG($_SESSION['user_id'],'d')) {
						check::AlertExit('对不起，您没有删除权限',-1);
					}
					$this->deleteInfoPic($val,$arrFile);
				}
				break;
			case 'moveup':
				foreach ($arrData as $key=>$val){
					if (! $this->checkPopedomG($_SESSION['user_id'],'x')) {
						check::AlertExit('对不起，您没有执行权限',-1);
					}
					$this->moveupInfo($val);
				}
				break;
			case 'check':
				foreach ($arrData as $key=>$val){
					if (! $this->checkPopedomG($_SESSION['user_id'],'x')) {
						check::AlertExit('对不起，您没有执行权限',-1);
					}
					$this->passInfo($val,1);
				}
				break;
			case 'uncheck':
				foreach ($arrData as $key=>$val){
					if (! $this->checkPopedomG($_SESSION['user_id'],'x')) {
						check::AlertExit('对不起，您没有执行权限',-1);
					}
					$this->passInfo($val,0);
				}
				break;
			case 'settop':
				foreach ($arrData as $key=>$val){
					if (! $this->checkPopedomG($_SESSION['user_id'],'x')) {
						check::AlertExit('对不起，您没有执行权限',-1);
					}
					$this->topInfo($val,1);
				}
				break;
			case 'unsettop':
				foreach ($arrData as $key=>$val){
					if (! $this->checkPopedomG($_SESSION['user_id'],'x')) {
						check::AlertExit('对不起，您没有执行权限',-1);
					}
					$this->topInfo($val,0);
				}
				break;
			case 'setrecommend':
				foreach ($arrData as $key=>$val){
					if (! $this->checkPopedomG($_SESSION['user_id'],'x')) {
						check::AlertExit('对不起，您没有执行权限',-1);
					}
					$this->recommendInfo($val,1);
				}
				break;
			case 'unsetrecommend':
				foreach ($arrData as $key=>$val){
					if (! $this->checkPopedomG($_SESSION['user_id'],'x')) {
						check::AlertExit('对不起，您没有执行权限',-1);
					}
					$this->recommendInfo($val,0);
				}
				break;
		}
		return true;
	}

}
?>