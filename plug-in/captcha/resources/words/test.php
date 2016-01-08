<?php
$arr = file('en.php');
foreach($arr as $k => $v){
	if(strlen(trim($v)) > 6) {
		echo $v.' '.strlen(trim($v)).'<br>';
		unset($arr[$k]);
	}
}
file_put_contents('en1.php',$arr);
?>