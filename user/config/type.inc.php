<?php
//类型
$arrMType = array();
$arrMType['year']			= range(1960,date('Y'));
$arrMType['month']			= range(1,12);
$arrMType['day']			= range(1,31);
$arrMType['sex']			= array(0=>'不限',1=>'男',2=>'女');
$arrMType['blood']			= array('请选择','A','B','AB','O');
$arrMType['constellation']	= array('请选择','白羊座','金牛座','双子座','巨蟹座','狮子座','处女座','天秤座','天蝎座','射手座','山羊座','水瓶座','双鱼座');
$arrMType['education']		= array(0=>'不限','初中','高中/中专','大学/大专','硕士/双学士','博士','博士后');
$arrMType['marriage']		= array(0=>'不限','单身','已婚','离异','丧偶');
$arrMType['photo']			= array(0=>'不限',1=>'有',2=>'没有');
$arrMType['identification_f']	= array(0=>'不限',1=>'通过',2=>'没有');
$arrMType['age']			= array(0=>'不限',1=>'18~25岁',2=>'26~35岁',3=>'36~45岁',4=>'46~55岁');
$arrMType['logintime']		= array(0=>'不限',1=>'三天之内',2=>'一周之内',3=>'两周之内',4=>'一月之内');
$arrMType['animal']			= array('请选择','鼠','牛','虎','兔','龙','蛇','马','羊','猴','鸡','狗','猪');
$arrMType['build']			= array('请选择','瘦','较瘦','匀称','苗条','高挑','丰满','健壮','魁梧','胖','较胖');
$arrMType['nationality']	= array('--保密--','中国大陆','中国台湾','中国香港','中国澳门','韩国','朝鲜','瑙鲁','印度尼西亚','美国','加拿大','日本','俄罗斯','英国','德国','意大利','法国','芬兰','瑞典','瑞士','南非','蒙古','越南','缅甸','泰国','老挝','菲律宾','西班牙','葡萄牙','阿尔巴尼亚','阿尔及利亚','阿富汗','阿根廷','阿拉伯联合酋长国','阿拉伯叙利亚共和国','阿鲁巴','阿曼','阿塞拜疆','埃及','埃塞俄比亚','爱尔兰','爱沙尼亚','安道尔','安哥拉','安圭拉','安提瓜和巴布达','奥地利','澳大利亚','巴巴多斯','巴布亚新几内亚','巴哈马','巴基斯坦','巴勒斯坦','巴拉圭','巴林','巴拿马','巴西','白俄罗斯','百慕大','保加利亚','北马里亚纳','贝宁','比利时','冰岛','波多黎各','波兰','波斯尼亚和黑塞哥维那','玻利维亚','伯利兹','博茨瓦纳','不丹','布基纳法索','布隆迪','布维岛','赤道几内亚','大阿拉伯利比亚民众国','丹麦','东帝汶','多哥','多米尼加共和国','多米尼克','厄瓜多尔','厄立特里亚','法罗群岛','梵蒂冈城国','斐济','佛得角','冈比亚','刚果','哥伦比亚','哥斯达黎加','格林纳达','格陵兰','格鲁吉亚','古巴','关岛','圭亚那','哈萨克斯坦','海地','荷兰','荷属安的列斯','赫德和麦克唐纳群岛','洪都拉斯','基里巴斯','吉布提','吉尔吉斯斯坦','几内亚','几内亚比绍','加纳','加蓬','柬埔寨','捷克共和国','津巴布韦','喀麦隆','卡塔尔','开曼群岛','科摩罗','科特迪瓦','科威特','克罗地亚','肯尼亚','库克群岛','拉脱维亚','莱索托','黎巴嫩','立陶宛','利比里亚','列支敦士登','卢森堡','卢旺达','罗马尼亚','马达加斯加','马尔代夫','马耳他','马拉维','马来西亚','马里','马绍尔群岛','毛里求斯','毛利塔尼亚','蒙特塞拉特','孟加拉国','秘鲁','密克罗尼西亚联邦','摩尔多瓦','摩洛哥','摩纳哥','莫桑比克','墨西哥','纳米比亚','南极洲','南斯拉夫','尼泊尔','尼加拉瓜','尼日尔','尼日利亚','纽埃','挪威','诺福克岛','帕劳群岛','皮特凯恩','前南斯拉夫马其顿共和国','萨尔瓦多','萨摩亚','塞拉利昂','塞内加尔','塞浦路斯','塞舌尔','沙特阿拉伯','圣诞岛','圣多美和普林西比','圣赫勒拿','圣基茨和尼维斯','圣卢西亚','圣马力诺','斯里兰卡','斯洛伐克共和国','斯洛文尼亚','斯瓦尔巴岛和扬马延岛','斯威士兰','苏丹','苏里南','所罗门群岛','索马里','塔吉克斯坦','坦桑尼亚','汤加','特克斯和凯科斯群岛','特立尼达和多巴哥','突尼斯','图瓦卢','土耳其','土库曼斯坦','托克劳','瓦努阿图','危地马拉','委内瑞拉','文莱','乌干达','乌克兰','乌拉圭','乌兹别克斯坦','西撒哈拉','希腊','新加坡','新西兰','匈牙利','牙买加','亚美尼亚','也门','伊拉克','伊朗伊斯兰共和国','以色列','约旦','赞比亚','扎伊尔','乍得','直布罗陀','智利','中非共和国');
$arrMType['nation']			= array('--保密--','汉族','藏族','朝鲜族','蒙古族','回族','满族','维吾尔族','壮族','彝族','苗族','其它民族');
$arrMType['habit']			= array('请选择','浪漫迷人','成熟稳重','风趣幽默','乐天达观','活泼可爱','忠厚老实','淳朴害羞','温柔体贴','多愁善感','新潮时尚','热辣动感','豪放不羁');
$arrMType['language']		= array('汉语','粤语','闽南语','英语','法语','德语','日语','俄语','韩语','泰语','马来语','印度语','阿拉伯语','西班牙语','葡萄牙语','意大利语','挪威语','瑞士语','芬兰语','其他语种');
$arrMType['province']		= array(110000=>'北京',120000=>'天津',130000=>'河北省',140000=>'山西省',150000=>'内蒙古',210000=>'辽宁省',220000=>'吉林省',230000=>'黑龙江省',310000=>'上海',320000=>'江苏省',330000=>'浙江省',340000=>'安徽省',350000=>'福建省',360000=>'江西省',370000=>'山东省',410000=>'河南省',420000=>'湖北省',430000=>'湖南省',440000=>'广东省',450000=>'广西自治区',460000=>'海南省',500000=>'重庆',510000=>'四川省',520000=>'贵州省',530000=>'云南省',540000=>'西藏自治区',610000=>'陕西省',620000=>'甘肃省',630000=>'青海省',640000=>'宁夏自治区',650000=>'新疆自治区',710000=>'台湾省',810000=>'香港行政区',820000=>'澳门行政区',990000=>'海外',0=>'全国/不限');
$arrMType['ser_ensure']		= array('资料真实','中止赔偿');
$arrMType['ser_state']		= array('我想接任务','我暂时不接任务');
$arrMType['identification']	= array('身份证','护照','港澳通行证','港澳台同胞证','户口本','驾驶执照','毕业证','学位证','房产证','工作证','职称证','收入证明','残疾人证','其它证件');
$arrMType['sports']			= array('足球','篮球','网球','排球','乒乓球','羽毛球','橄榄球','高尔夫球','骑马','爬山','游泳','划船','攀岩','蹦极','野营','探险','武术','射击','跑步','其他活动');
$arrMType['cate']			= array('中国菜','印度菜','泰国菜','法国菜','意大利菜','俄罗斯菜','日本菜','烧烤','健康食品','素食','快餐','巧克力和甜点','其他','无特别爱好');
$arrMType['amusement']		= array('饭店','商场','剧院','酒吧','电影院','音乐会','迪斯科','网吧','温泉','图书馆/书店','咖啡厅','游乐场','卡拉OK','体育馆','逛街','在自己/朋友家','其它','不想说');
$arrMType['digital_products']= array('手机','相机','笔记本','mp3/mp4','电玩','电脑');
$arrMType['sports_type']	= array('我以后告诉你','每天锻炼','每周至少一次','每月几次','没时间锻炼','集中时间锻炼','不喜欢锻炼');
$arrMType['cre_type']		= array(1=>'身份证',2=>'护照',3=>'港澳通行证',4=>'港澳台同胞证',5=>'驾驶证');

$arrTemp = array();
$arrTemp[] = '145以下';
for($i=145;$i<=195;$i++) $arrTemp[] = $i.'厘米';
$arrTemp[] = '195以上';
$arrMType['height']			= $arrTemp;
$arrMType['reg_question']	= array('请选择密码提示问题！','您父亲的名字是？','您母亲的名字是？','您的职业是？');
$arrMType['intro']	= array('我的性格比较开朗，随和，关心周围的任何事，并且对生活充满了信心，我是一个热爱生活的U客。','在外地求学的几年生活，我养成了坚强的性格,这种性格使我克服了学习和生活中的一些困难，希望大家能够认可我，多给我机会，我的U客口号是：世上无难事，只要肯攀登！','我是一个活泼开朗的人，我爱好看书，很喜欢打篮球，也很喜欢学习，更喜欢旅游，愿结交真诚的U客。','总体来说我是个安静的人，但如果在朋友面前说我内向，会遭致异口同声的鄙视与反对。我向往的生活是像U客般的自由自在。','我是一个热爱生活、享受生活、追求、创造美好生活的人，天生一副热心肠，独乐乐不如众乐乐，喜欢分享美好的事物，拥有一颗好奇的心。','人生最重要的不是所在的位置，而是所朝的方向，愿结交志同道合的驴友。','我喜欢回味生活，周游世界，也许那并不是快乐的回忆，但它能让我懂的更多。','我喜欢旅游，网球，F1，音乐。我在业余时间最大的消遣是听歌，泡U客网。','我性格开朗，温柔大方，善解人意，没有什么脾气，因为理解的多，所以也就没有脾气了，你愿意和我一起感受世界，体验U客生活吗？','我看漫画，看心理学，看各种小说以及散文。喜欢在不同的心境的时候看不同的文字。喜欢文字里那种跳跃的思维方式，加入U客只是为了满足自己的猎奇心理！','我喜欢旅游。我在业余时间最大的消遣是看电影上U客网。我憧憬的生活是自由自在。','本人为人善良，为人正直，是一个平常的不能再平常的U客。','我很平凡，但是我绝不缺乏生活的热情和生命的梦想。U客网是能够让我实现梦想的地方！','我热爱U客生活，做U客，即能旅游，又能交友，真是太好了。','我通过做U客，赚取了我人生的第一桶金。','今天你U了吗？','热爱旅游，热爱交友，热爱U客','我爱互助游，我爱U客生活！','U客网让我赚到了人生第一桶金，我会再接再励做个好U客！','互助游真的好时尚，U客互助是我体验最好的旅游方式','全球U客是一家，旅游互助靠大家！','U客生活改变了我的人生，我热爱做U客！','我是专业的U客，找我服务，体验不一样的旅游！','U客真的又玩又能挣钱吗？');
?>