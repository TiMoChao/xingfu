<?php
/**
 * 使用PDO的分页类文件
 * @author		Arthur(ArthurXF@gmail.com)
 * @copyright	(c) 2006 by bizeway.com
 * @version		$Id$
 * @package		pdo_page
 */

class pdo_page{
	/*分页显示参数设置*/
	public $page_size=0;  		//每页显示的记录数目
	public $link_num=5;   		//显示页码链接的数目
	public $page=1;  			//页码
	public $records=0; 		//表中记录总数
	public $page_count=0;  	//总页数
	public $pagestring='';    	//前后分页链接字符串
    public $pagestring2='';     //下一页的样式
	public $page_link='';     	//页码链接字符串
	public $page_select='';   	//表单跳转页字符串
	public $page_jump='';    	 //text筐输入页码跳转
	public $file_suffix='.html';		//静态链接后缀名
	public $first='首页';		//翻页文字
	public $prev='上一页';		//翻页文字
	public $next='下一页';		//翻页文字
	public $last='尾页';			//翻页文字
	public $go='转';			//翻页文字

	public $anchor='';		//锚链接

    public $js_fun='';

	/**
	 * 语言处理
	 * @author	肖飞
	 * @return	void
	 */
	function set_lang() {
		switch($this->lang){
			case 'en':
				$this->first = 'First';
				$this->prev = 'Previous';
				$this->next = 'Next';
				$this->last = 'Last';
				$this->go = 'Go';
			break;
		}
	}

	/**
	 * 页码处理
	 * @author		肖飞
	 * @return void
	 */
	function set_page(){
		if(isset($_REQUEST['page'])&&$_REQUEST['page']!=null){
			$this->page=intval($_REQUEST['page']);
		}
		else{
			$this->page=1;
		}
		$this->page_count= ceil($this->records/$this->page_size);
	}

	/**
	 * 翻页链接样式1（首页 上页 下页 尾页）
	 * @author	肖飞
	 * @param	array		$arrLink		翻页链接参数
	 * @param	int		$link_type		链接类型 0=普通 1=静态优化 2=Wap链接 3=js链接
	 * @return	void
	 */
	function page_link1($arrLink=null,$link_type=0){
		$link = $this->link_encode($arrLink,$link_type);

		if($link_type){
			//伪静态链接
			if($this->page==1){
				$this->pagestring.="[$this->first] | [$this->prev]";         //如果是首页，无链接
			}else{
				$this->pagestring.="[<a href=$_SERVER[SCRIPT_NAME]/page-1$link$this->file_suffix>$this->first</a>] | [<a href=$_SERVER[SCRIPT_NAME]/page-".($this->page-1)."$link$this->file_suffix id='back'>$this->prev</a>]"; //不为首页，有链接
			}
			$this->pagestring.=" | ";
			if($this->page==$this->page_count||$this->page_count==0){
				$this->pagestring.="[$this->next] | [$this->last]";           //如果是最后一页，无链接
			}else{
				$this->pagestring.="[<a href=$_SERVER[SCRIPT_NAME]/page-".($this->page+1)."$link$this->file_suffix  id='next'>$this->next</a>] | [<a href=$_SERVER[SCRIPT_NAME]/page-".$this->page_count."$link$this->file_suffix>$this->last</a>]"; //不是最后一页，有链接
			}
		}else{
			//动态化链接
			if($this->page==1){
				$this->pagestring.="[$this->first] | [$this->prev]";         //如果是首页，无链接
			}else{
				$this->pagestring.="[<a href=?page=1$link>首页</a>] | [<a href=?page=".($this->page-1)."$link id='back'>$this->prev</a>]"; //不为首页，有链接
			}
			$this->pagestring.=" | ";
			if($this->page==$this->page_count||$this->page_count==0){
				$this->pagestring.="[$this->next] | [$this->last]";           //如果是最后一页，无链接
			}else{
				$this->pagestring.="[<a href=?page=".($this->page+1)."$link id='next'>$this->next</a>] | [<a href=?page=".$this->page_count."$link >$this->last</a>]"; //不是最后一页，有链接
			}
		}
	}



	/**
	 * 翻页链接样式2（1 2 3 4 5）
	 * @author		肖飞
	 * @param	string	$arrLink		翻页链接参数
	 * @param	string	$ldelim			翻页链接左修饰符
	 * @param	string	$rdelim			翻页链接右修饰符
	 * @param	int		$link_type		链接类型 0=普通 1=静态优化 2=Wap链接 3=js链接
	 * @return	void
	 */
	function page_link2($arrLink=null,$link_type=0,$ldelim='',$rdelim=''){
		$link = $this->link_encode($arrLink,$link_type);

		//页码链接字符串
		if($this->page > $this->link_num) $start = $this->page-$this->link_num;
		else $start = 1;

		if($link_type==1){
			//伪静态链接
			if(empty($_SERVER['PATH_INFO'])&&$start>1) check::AlertExit("错误：服务器不支持PATH_INFO，请到管理后台关闭静态链接优化选项!",-1);
			if(strpos($_SERVER['SCRIPT_NAME'],$_SERVER['PATH_INFO'])) $_SERVER['SCRIPT_NAME'] = str_replace($_SERVER['PATH_INFO'],'',$_SERVER['SCRIPT_NAME']);

			for($i=$start;$i<=$this->page+$this->link_num-1;$i++){
				if($i<=$this->page_count){
					if($i == $this->page) $this->page_link.='<span class="current">'.$ldelim.$i.$rdelim.'</span> ';
					else $this->page_link.="<a href=$_SERVER[SCRIPT_NAME]/page-".$i.$link.$this->file_suffix.'>'.$ldelim.$i.$rdelim.'</a> ';
					$last_page=$i;
				}
			}
			if($i-$this->link_num-1<1){
				$front_page=1;
			}else{
				$front_page=$this->page-1;
			}
			if(!empty($last_page) && $this->page==$this->page_count){
				$back_page=$last_page;
			}else{
				$back_page=$this->page+1;
			}
			if($this->page != 1) $this->page_link="<a href=$_SERVER[SCRIPT_NAME]/page-1".$link.$this->file_suffix.'>&lt;&lt;</a>'.' '."<a href=$_SERVER[SCRIPT_NAME]/page-".$front_page.$link.$this->file_suffix.'>&lt;</a>'.' '.$this->page_link.' ';
			if($this->page!=$this->page_count && $this->page_count!=0) $this->page_link=$this->page_link.' '."<a href=$_SERVER[SCRIPT_NAME]/page-".$back_page.$link.$this->file_suffix.'>&gt;</a>'.' '."<a href=$_SERVER[SCRIPT_NAME]/page-".$this->page_count.$link.$this->file_suffix.'>&gt;&gt;</a>';
		}elseif($link_type==3){
			//JS链接
			if(strpos($_SERVER['SCRIPT_NAME'],$_SERVER['PATH_INFO'])) $_SERVER['SCRIPT_NAME'] = str_replace($_SERVER['PATH_INFO'],'',$_SERVER['SCRIPT_NAME']);

			for($i=$start;$i<=$this->page+$this->link_num-1;$i++){
				if($i<=$this->page_count){
					if($i == $this->page) $this->page_link.='<span class="current">'.$ldelim.$i.$rdelim.'</span> ';
					else $this->page_link.="<a href=\"javascript:void(0)\" onclick=\"{$this->js_fun}('$_SERVER[SCRIPT_NAME]?page=".$i.$link."')\">".$ldelim.$i.$rdelim.'</a> ';
					$last_page=$i;
				}
			}
			if($i-$this->link_num-1<1){
				$front_page=1;
			}else{
				$front_page=$this->page-1;
			}
			if(!empty($last_page) && $this->page==$this->page_count){
				$back_page=$last_page;
			}else{
				$back_page=$this->page+1;
			}
			if($this->page != 1) $this->page_link="<a href=\"javascript:void(0)\" onclick=\"{$this->js_fun}('$_SERVER[SCRIPT_NAME]?page=1".$link."')\">&lt;&lt;</a>".' '."<a href=\"javascript:void(0)\" onclick=\"{$this->js_fun}('$_SERVER[SCRIPT_NAME]?page=".$front_page.$link."')\">&lt;</a>".' '.$this->page_link.' ';
			if($this->page!=$this->page_count && $this->page_count!=0) $this->page_link=$this->page_link.' '."<a href=\"javascript:void(0)\" onclick=\"{$this->js_fun}('$_SERVER[SCRIPT_NAME]?page=".$back_page.$link."')\">&gt;</a>".' '."<a href=\"javascript:void(0)\" onclick=\"{$this->js_fun}('$_SERVER[SCRIPT_NAME]?page=".$this->page_count.$link."')\">&gt;&gt;</a>";
		}else{
			//动态链接
			for($i=$start;$i<=$this->page+$this->link_num-1;$i++){
				if($i<=$this->page_count){
					if($i == $this->page) $this->page_link.='<span class="current">'.$ldelim.$i.$rdelim.'</span> ';
					else $this->page_link.='<a href=?page='.$i.$link.'>'.$ldelim.$i.$rdelim.'</a> ';
					$last_page=$i;
				}
			}
			if($i-$this->link_num-1<1){
				$front_page=1;
			}else{
				$front_page=$this->page-1;
			}
			if(!empty($last_page) && $this->page==$this->page_count){
				$back_page=$last_page;
			}else{
				$back_page=$this->page+1;
			}
			if($this->page != 1) $this->page_link='<a href=?page=1'.$link.'>&lt;&lt;</a>'.' '.'<a href=?page='.$front_page.$link.'>&lt;</a>'.' '.$this->page_link;
			if($this->page!=$this->page_count && $this->page_count!=0) $this->page_link=$this->page_link.' '.'<a href=?page='.$back_page.$link.'>&gt;</a>'.' '.'<a href=?page='.$this->page_count.$link.'>&gt;&gt;</a>';
		}
	}

	/**
	 * 翻页链接样式3（select选择提交跳转）
	 * @author		肖飞
	 * @param string $link	翻页链接参数
	 * @return int
	 */
	function page_link3($link=null){
		//select页码
		$this->page_select="<form action='' method=post><select name=page>";
		for($i=1;$i<=$this->page_count;$i++){
			if($i==$this->page){
				$this->page_select.="<option selected>$i</option>";
			}
			else{
				$this->page_select.="<option>$i</option>";
			}
		}
		$this->page_select.="</select><input type=submit value=$this->go></form>";
	}

	/**
	 * 翻页链接样式4（input输入from提交跳转）
	 * @author		肖飞
	 * @param string $link	翻页链接参数
	 * @return int
	 */
	function page_link4($link=null){
		//input跳转表单
		$this->page_jump="<form action='' method=post><input type=text size=1 name=page value=$this->page><input type=submit value=$this->go>";
	}

	/**
	 * 翻页链接样式5（input输入javascript提交跳转）
	 * @author		肖飞
	 * @param	array		$arrLink		翻页链接参数
	 * @param	int		$link_type		链接类型 0=普通 1=静态优化 2=Wap链接 3=js链接
	 * @return	void
	 */
	function page_link5($arrLink=null,$link_type=0){
		$link = $this->link_encode($arrLink,$link_type);

		if($link_type){
			//伪静态链接
			$this->page_jump="<input type='text' name='page' id='biwebpage' size=3 value='$this->page'> <input type='button' class='btn' name='b' value='$this->go'onclick=\" location.href='$_SERVER[SCRIPT_NAME]/page-'+document.getElementById('biwebpage').value+'$link.html$this->anchor'\">";
		}else{
			//动态链接
			$this->page_jump="<input type='text' name='page' id='biwebpage' size=3 value='$this->page'> <input type='button' class='btn' name='b' value='$this->go'onclick=\"location.href='?page='+document.getElementById('biwebpage').value+'$link'\">";
		}
	}

	/**
	 * 对数据进行URL编码
	 * @author		肖飞
	 * @param	array		$arrLink		翻页链接参数
	 * @param	int		$link_type		链接类型 0=普通 1=静态优化 2=Wap链接 3=js链接
	 * @return	string
	 */
	function link_encode($arrLink,$link_type=0){
		if(is_array($arrLink)){
			//如果是数组就直接给值编码
			foreach($arrLink as $k =>$v){
				$arrTemp = explode('=',$v);
				$str = $arrTemp[0].'='.urlencode($arrTemp[1]);
				$arrLink[$k] = $str;
			}
		}
		if(is_string($arrLink)){
			//如果是字符串就还原数组，为了兼容5.86之前版本
			if($link_type){
				$arrTemp = explode('-',$arrLink);
				$arrLink = array();
				$str = '';
				foreach($arrTemp as $k => $v){
					if($str == '') $str = $v;
					else{
						$arrLink[] = $str.'='.$v;
						$str = '';
					}
				}
			}else{
				$arrLink = explode('&',$arrLink);
			}
		}
		if($link_type){
			if (!empty($arrLink)){
				$strLink = str_replace('=','-',implode('-',$arrLink));
				if(!empty($strLink)&&$strLink[0]!='-'){
					$strLink="-".$strLink;
				}
			}
		}else{
			if (!empty($arrLink)) $strLink = implode('&',$arrLink);
			if(!empty($strLink)&&$strLink[0]!='&'){
				$strLink="&".$strLink;
				$strLink .= $this->anchor;
			}
		}
		return $strLink;
	}

	/**
	 * 建立分页
	 * @author		肖飞
	 * @return void
	 */
	function create_page(){
		$this->set_lang();
		$this->set_page();
		$this->file_suffix .= $this->anchor;
	}


}
/*使用样例
$page=new pdo_page;
//分页参数设置
$page->page_size=5;                                //每页显示记录的数目
$page->link_num=6;                                 //显示翻页链接的数目
$page->create_page();                              //生成分页
//翻页链接显示输出
echo '<center>共有'.$page->records.'条记录';       //表中记录的总数
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo '第'.$page->page.'页/';
echo '共'.$page->page_count.'页</center>';         //总页数
echo '<center>'.$page->pagestring.'</center>';     //'首页'、'上一页'、'下一页'、'尾页'－－链接样式
echo '<center>'.$page->page_link.'</center>';      //[1]、[2]、[3]－－链接样式
echo '<center>'.$page->page_select.'</center>';    //表单翻页样式
echo '<center>'.$page->page_jump.'</center>';
*/
?>