<?PHP
define("ROOT_DIR",dirname(__FILE__));
class ecodeflv {
  var $fromFile;   //上传来的文件
  var $toFilePath;  //保存文件路径
  var $toPicPath;  //保存图片路径
  var $mpeg; //ffmpeg.exe文件的路径
  var $mencode; //mencode.exe文件的路径
  var $cmdToFile; //转换文件命令
  var $cmdToPic;  //转换图片命令
  var $toFileName; //转换后的文件名
  var $mpegComm; //ffmpeg.exe的转换命令
  var $mencodeComm; //mencode.exe的命令
  var $mpegType;
  var $mencodeType;
  var $midi; //mdi.exe的路径
  var $cmdMidi; //mdi.exe的命令
//初始化类
  function ecodeflv($fromFile,$toFilePath,$toPicPath,$mpeg,$mencode,$midi) {
   $this->mpegComm = false;
   $this->mencodeComm = false;
   $this->fromFile = $fromFile;
   $this->toFilePath = $toFilePath;
   $this->toPicPath = ROOT_DIR."/".$toPicPath;
   $this->mpeg = ROOT_DIR.$mpeg;
   $this->mencode = ROOT_DIR.$mencode;
   $this->midi = ROOT_DIR.$midi;
   $this->mpegType=array (
       "audio/x-mpeg"=>".mp3",
       "video/mpeg"=>".mpeg",
       "video/3gpp"=>".3gp",
       "video/x-ms-asf"=>".asf",
       "video/x-msvideo"=>".avi"
   );
   $this->mencodeType = array(
       "application/vnd.rn-realmedia"=>".rm",
       "audio/x-pn-realaudio"=>".rmvb",
       "audio/x-ms-wmv"=>".wmv",
   );
  }

//检查文件类型

  function checkType() {
    if(function_exists(mime_content_type)){
     return false;
    }else{
     //$contentType = mime_content_type($this->fromFile);
     $exe = "D:\server\php\extras\magic";
     $handel = new finfo(FILEINFO_MIME, $exe);
     $contentType =  $handel->file($this->fromFile);
    }
    foreach($this->mpegType as $index=>$key){
     if($contentType == $index){
      $name = md5(date("Ymd").time());
      $this->toFileName = $name;
      $this->$mpegComm = true;
      return true;
     }
    }
    foreach($this->mencodeType as $index=>$key){
      if($contentType == $index){
      $name = md5(date("Ymd").time());
      $this->toFileName = $name;
      $this->mencodeComm = true;
      return true;
         }else{
       return false;
      }
    }
  }

//设置文件，图片大小
  function setSize($flvSize,$picSize) {
    $flvWidth = $flvSize[0];
    $flvHeight = $flvSize[1];
    $picWidth = $picSize[0];
    $picHeight = $picSize[1];
    $picName = $this->toPicPath.$this->toFileName.".jpg";
    $flvName = $this->toFilePath.$this->toFileName.".flv";
    $toMdi = ROOT_DIR."/".$flvName;
    $size = $picWidth."x".$picHeight;
    if($this->mpegComm){
      $this->cmdToFile= "$this->mpeg -i $this->fromFile -y -ab 56 -ar 22050 -b 500 -r 15 -s $flvWith*$flvHeight $flvName";
    }
    elseif($this->mencodeComm){
      $this->cmdToFile = "$this->mencode $this->fromFile  -vf scale=$flvWidth:$flvHeight -ffourcc FLV1 -of lavf -ovc lavc -lavcopts vcodec=flv:vbitrate=70:acodec=mp3:abitrate=56:dia=-1 -ofps 25 -srate 22050 -oac mp3lame -o $flvName";
    }
    $this->cmdToPic = "$this->mpeg -i $toMdi -y -f image2 -ss 8 -t 0.003 -s $size $picName";
    $this->cmdMidi = "$this->midi $toMdi /k";
    echo $this->cmdToPic;
  }

//开始转换
  function toEcode() {
    set_time_limit(0);
    exec($this->cmdToFile,$flvStatus)
    exec($this->cmdToPic,$picStatus);
    exec($this->cmdMidi,$mStatus);
  }

 }
?>