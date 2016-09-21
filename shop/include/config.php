<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Thu, 1 Jan 1970");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header('Content-Type: text/html; charset=utf-8');

session_name("amedicallv");
session_start();
$ses_id = session_id();
$ip = $_SERVER['REMOTE_ADDR'];
$user_id = 0;

function ValArrayGet($arr){
global $_GET;
   foreach ($arr as $key1 => $elem1) {
     $elem1 = strip_tags($elem1);
     $elem1 = addslashes($elem1);
     $elem1 = preg_replace("/select|delete|insert|update|create|kill|drop|\;|\'|\"/i","",$elem1);
	  $elem1 = str_replace("\\\\\\","\\",$elem1);
	  $elem1 = str_replace("\\\\","\\",$elem1);
	  $elem1 = str_replace("\\","\"",$elem1);

	  $change_from=array("\"","\'");
		$change_to=array("&quot;","");

       $_GET[$key1]=str_replace($change_from,$change_to,$elem1);
   }
}
function ValArrayPost($arr){
global $_POST;

   foreach ($arr as $key1 => $elem1) {
	   if (!is_array($elem1))
	   {
		 $elem1 = strip_tags($elem1);
		 $elem1 = addslashes($elem1);
		 $elem1 = preg_replace("/select|delete|insert|update|create|kill|drop|\;|\'|\"/i","",$elem1);
		 $elem1 = str_replace("\\\\\\","\\",$elem1);
		 $elem1 = str_replace("\\\\","\\",$elem1);
		 $elem1 = str_replace("\\","\"",$elem1);

		 $change_from=array("\"","\'");
	$change_to=array("&quot;","");


		 $_POST[$key1]=str_replace($change_from,$change_to,$elem1);
	   }
	}
}
ValArrayGet($_GET);
ValArrayPost($_POST);

$error = array();

$encoding = "charset=utf-8";//Page encoding

$url = 'http://';
if(!getenv('APPLICATION_ENV')){define('APPLICATION_ENV','production');}else{define('APPLICATION_ENV',getenv('APPLICATION_ENV'));}
if(APPLICATION_ENV == 'development'){
	$url .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	$db_host="localhost"; //MySql hostname
	$db_user="amedical";//MySql username
	$db_password="ur8phee9ien2wohs";//MySql password
	$db_name="amedical";//MySql database name
}
else{
	$url .= str_replace('\\','',$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));
	$db_host = "sql-05.deac.lv";
	$db_user="amedical";//MySql username
	$db_password="ur8phee9ien2wohs";//MySql password
	$db_name="amedical";//MySql database name
}
$root_dir =  $url;

$img_dir = $root_dir."include/images/";//Images directory

$css_dir = $root_dir."css/";//CSS style sheet directory
$css_file =  "css/style.css";

$d1 = $d2 = $d3 = $d4 = $d5 = $d6 = $d7 = $d1_value = $d2_value = $d3_value = $d4_value = $d5_value = $d6_value = $d7_value = 0;
$languages = array ("lv","en","ru","ee","lt");//List of languages
$coupon_discount = 0;
$coupon_text = "";

$coupon_discount1 = 0;
$coupon_text1 = "";
$category_discount = 2;

$result_db = mysql_connect($db_host,$db_user,$db_password);
mysql_select_db($db_name,$result_db);

mysql_query("SET NAMES utf8");

function login($username, $password)
{
	$password=md5($password);
	$password=md5($password);

	$result = mysql_query("select * from clients where email='$username' and password = '$password' and statuss = '2'");

	if (!$result)
	return 0;
	if (mysql_num_rows($result)>0)
	return 1;
	else
	return 0;
}

function AddStatistic($ip,$user_id,$ses_id,$url,$comment,$status)
{
	$result = mysql_query("insert into user_statistic value (
	'',
	'$ip',
	'$user_id',
	'$ses_id',
	'".time()."',
	'$url',
	'$comment',
	'$status')");

	echo mysql_error();
}

$datax = array();

$datax["lv"] = array(
/* 0 */ 	"<a href=\"http://www.webstyle.lv/lv/majas-lapa-pakalpojumi/majas-lapas-izveide\" title=\"Mājas lapas izveide\" target=\"_blank\">Mājas lapas izveide WEBstyle.lv</a>"
);

$datax["ru"] = array(
/* 0 */ 	"<a href=\"http://www.webstyle.lv/ru/majas-lapas-pakalpojumi/web-lapu-izveide\" title=\"Создание WEB страниц\" target=\"_blank\">Создание WEB страниц WEBstyle.lv</a>"
);

$datax["en"] = array(
/* 0 */ 	"<a href=\"http://www.webstyle.lv/en/web-pages-service/web-creation\" title=\"Creation of web pages\" target=\"_blank\">Creation of web pages WEBstyle.lv</a>"
);


$default_language = "lv";
if(!empty($_GET["url"]))
{
	$_GET["lang"]=substr($_GET["url"], 0, 3);
	$_GET["lang"]=str_replace("/","",$_GET["lang"]);

	$_GET["url"]=substr($_GET["url"], 3);

	$a=0;
	for($n=0;$n<count($languages);$n++)
	{
		if($_GET["lang"]==$languages[$n])
		{
			$a++;
		}

	}
	if($a==0)
	{
		$_GET["lang"]=$default_language;
	}
}
else
{
	if(!isset($_GET["lang"]))
	{
		$_GET["lang"]=$default_language;
	}
	$_GET["url"]="";
}

if($_GET["lang"] == "en")
{
	$change_lang = "lv";
}
else
{
	$change_lang = "en";
}

$e = array();
$valo = "text_".$_GET["lang"];
$ev=mysql_query("Select * from texts order by id asc");
while($es=mysql_fetch_array($ev))
{
	$gid = $es["id"];
	$e[$gid] = $es[$valo];
}

$parbaudits = "off";
$user_discount = 0;
$user_points = 0;
$coupon_type = 0;
$coupon_accept = 0;
if(isset($_SESSION["valid_user"]))
{
	$use=mysql_query("Select * from clients where email='$_SESSION[valid_user]' and id='$_SESSION[user_id]' and statuss = '2'");
	if($uses=mysql_fetch_array($use))
	{
		if($uses["coupon"] == 2)
		{
			$tagad = time();
			if($tagad >= $uses["coupon_start_time"] && $tagad <= $uses["coupon_end_time"])
			{
				$coupon_discount = $uses["coupon_value"];
				$coupon_text = $uses["coupon_code"];
				$coupon_type = 2;
			}
		}

		if($uses["person"] == 2)
		{
			$lietotajs = $uses["person_name"];
		}
		else
		{
			$lietotajs = $uses["company_name"];
		}
		$parbaudits = "ok";
		$user_id = $_SESSION['user_id'];

		$data = time();
		if($data >= $uses["coefficient_start_time"] && $data <= $uses["coefficient_end_time"])
		{
			$user_discount = $uses["coefficient"];
			$d1 = 2;
			$d1_value = $uses["coupon_value"];
		}

		//Pārbaudam lietotāja punktus
		$user_points = 0;
		$query = mysql_query("select * from points where client_id = '$user_id'");
		while($mysql = mysql_fetch_array($query))
		{
			$user_points = $user_points + $mysql["value"];
		}
		$user_points = round($user_points,2);
	}
	else
	{
		$parbaudits="off";
	}
}
else
{
	$parbaudits="off";
}

$title = $e[1];
$description = $e[2];
$keywords = $e[3];

$content_change = 0;
$tabula="content";
$izveleta = "";
$izv_id = 0;
$id = 0;
$parent_id = "";
$anketa = 0;
$rezultats = 0;


$name_lang = "name_".$_GET["lang"];
$url_lang = "url_".$_GET["lang"];
$title_lang = "title_".$_GET["lang"];
$description_lang = "description_".$_GET["lang"];
$keywords_lang = "keywords_".$_GET["lang"];
$link_lang = "link_".$_GET["lang"];
$target_lang = "target_".$_GET["lang"];
$text_lang = "text_".$_GET["lang"];
$country_lang = "country_".$_GET["lang"];
$producer_lang = "producer_".$_GET["lang"];
$sablons = 0;
$teksts = "";
$catalog_id = 0;
$cat_type = 0;
$time_discount = 0;

$choosen = "";

if(!isset($_GET["search"]))
{
	$_GET["search"] = "";
}

if(!isset($_GET["type"]))
{
	$_GET["type"] = 1;
}

$change_session = 0;
if(isset($_GET["t"]))
{
	$_SESSION["t"] = $_GET["t"];
}

if(!isset($_SESSION["t"]))
{
	$_SESSION["t"] = 1;
}

$search_on = 0;
if(!isset($_GET["speciality"]))
{
	$_GET["speciality"] = 0;
}

if(!isset($_GET["branch"]))
{
	$_GET["branch"] = 0;
}

if(!isset($_GET["sequence"]))
{
	$_GET["sequence"] = 0;
}

if(!isset($_GET["search"]))
{
	$_GET["search"] = "";
}

if($_GET["speciality"] > 0 || $_GET["branch"] > 0 || $_GET["search"] != '')
{
	$search_on = 1;
}

if(isset($_GET["change"]))
{
	$_SESSION["t"] = 2;
}


if(isset($_POST["change-basket"]))
{
	$ch = mysql_query("select * from basket where ip = '$ip' and session_id = '$ses_id' and id = '$_GET[item_id]'");
	$exists=mysql_fetch_array($ch);

	if($_POST["quantity"] > 0)
	{
		$result = mysql_query("update basket set count = '$_POST[quantity]' where id = '$_GET[item_id]'");
	}

	$query = mysql_query("select * from content where template = '3' and lang = '$_GET[lang]'");
	$mysql = mysql_fetch_array($query);
	//Mainīts preces skaits preču grozā
	AddStatistic($ip,$user_id,$ses_id,$url,'',2);
	$links = $root_dir.$_GET["lang"]."/$mysql[url]";
	header("Location: $links");
	exit;
}

$parent_category_id = 0;
if(!isset($_SESSION['industry'])){ $_SESSION['industry'] = 2;}
$query=mysql_query("Select * from categories where statuss='2' and parent_id = '0' and industry = '$_SESSION[industry]' order by place asc limit 0,1");
if($mysql=mysql_fetch_array($query))
{
	$parent_category_id = $mysql['id'];
}

if(isset($_GET["url"]))
{
	if($_GET["url"] == "industry")
	{
		$_SESSION['industry'] = 1;
		$query = mysql_query("select * from content where template = '2' and lang = '$_GET[lang]'");
		$mysql = mysql_fetch_array($query);

		$links = $root_dir.$_GET["lang"].'/'.$mysql['url'];
		header("Location: $links");
		exit;
	}

	if($_GET["url"] == "medicine")
	{
		$_SESSION['industry'] = 2;
		$query = mysql_query("select * from content where template = '2' and lang = '$_GET[lang]'");
		$mysql = mysql_fetch_array($query);

		$links = $root_dir.$_GET["lang"].'/'.$mysql['url'];
		header("Location: $links");
		exit;
	}

	if($_GET["url"] == "get-banner")
	{
		$var = explode("||",$_GET["id"]);
		$saite_lang = "saite";
		$data=time();
		$end_data = mktime(0,0,0,date("m"),date("d"),date("Y"));
		if($content_change > 0)
		{
			$cats = " and category like '%*$var[0]*%'";
		}
		else
		{
			$cats = "";
		}

		$query = mysql_query("select * from banners where id = '$var[1]'");
		$mysql = mysql_fetch_array($query);

		$resb=mysql_query("SELECT * FROM banners where bdat>='$end_data' and sdat<='$data' and lang like '%*$_GET[lang]*%' and place > '$mysql[place]' and novietojums='1' and formats < '3' $cats order by place asc limit 0,1");

		$buttons = "";
		if($rowb=mysql_fetch_array($resb))
		{
			$ww = 1000;
			$hh = 150;

			if($rowb["formats"]=="2")
			{
				echo "1||".$root_dir."banners/$rowb[datne]?clickTAG=".$root_dir."include/ads.php?id=$_GET[lang]/$rowb[id]||$rowb[id]||$var[0]";
			}
			else
			{
				echo "2||<a href=\"".$root_dir."include/ads.php?id=$_GET[lang]/$rowb[id]\" target=\"_blank\"><img src=\"".$root_dir."banners/$rowb[datne]\" border=\"0\" width=\"$ww\" height=\"$hh\" /></a>||$rowb[id]||$var[0]";
			}
		}
		else
		{
			$resb1=mysql_query("SELECT * FROM banners where bdat>='$end_data' and sdat<='$data' and lang like '%*$_GET[lang]*%' and novietojums='1' and formats < '3' $cats order by place asc limit 0,1");
			if($rowb1=mysql_fetch_array($resb1))
			{
				$ww = 1000;
				$hh = 150;

				if($rowb1["formats"]=="2")
				{
					echo "1||".$root_dir."banners/$rowb1[datne]?clickTAG=".$root_dir."include/ads.php?id=$_GET[lang]/$rowb1[id]||$rowb1[id]||$var[0]";
				}
				else
				{
					echo "2||<a href=\"".$root_dir."include/ads.php?id=$_GET[lang]/$rowb1[id]\" target=\"_blank\"><img src=\"".$root_dir."banners/$rowb1[datne]\" border=\"0\" width=\"$ww\" height=\"$hh\" /></a>||$rowb1[id]||$var[0]";
				}
			}
		}
		exit;
	}
	if($_GET["url"] == "check-coupon")
	{
		$coupon_value = 0;
		if($_GET["coupon"] == $coupon_text)
		{
			//Ja kupona kods sakrīt ar klienta kupona kodu, piemērojam šo atlaidi
			$coupon_value = $uses["coupon_value"];
		}

		$tagad = time();
		$di = mysql_query("select * from discounts where '$tagad' >= start_time and '$tagad' <= end_time and type = '4' and coupon = '$_GET[coupon]' order by value desc limit 0,1");
		if($disc = mysql_fetch_array($di))
		{
		    $coupon_value = $disc["value"];
		}

		if($coupon_value > 0)
		{
			echo $coupon_value;
		}
		else
		{
			echo "0";
		}
		exit;
	}
	if($_GET["url"] == "order")
	{
		$tagad = time();
		$di = mysql_query("select * from discounts where '$tagad' >= start_time and '$tagad' <= end_time and type = '4' order by value desc limit 0,1");
		if($disc = mysql_fetch_array($di))
		{
			$coupon_discount1 = $disc["value"];
			$coupon_text1 = $disc["coupon"];
			$coupon_type = 1;

		}
		require_once("include/do-order.php");
		$content_change = 5;
	}

	if($_GET["url"] == "my-orders")
	{
		$content_change = 14;
	}

	if($_GET["url"] == "register")
	{
		$content_change = 7;
		if(isset($_GET["code"]))
		{
			require_once("include/send-registration-confirm.php");
			$content_change = 8;
		}
		else
		{
			require_once("include/do-register.php");
		}
	}
	if($_GET["url"] == "my-data")
	{
		if($parbaudits == "off")
		{
			$links = $root_dir.$_GET["lang"];
			header("Location: $links");
			exit;
		}
		$content_change = 11;
		require_once("include/do-my-data.php");
	}

	if($_GET["url"] == "my-data-ok")
	{
		if($parbaudits == "off")
		{
			$links = $root_dir.$_GET["lang"];
			header("Location: $links");
			exit;
		}
		$content_change = 12;
	}

	if($_GET["url"] == "logout")
	{
		//Lietotājs atslēdzies
		AddStatistic($ip,$user_id,$ses_id,$url,'',4);

		session_unset();
		session_destroy();

		$links = $root_dir.$_GET["lang"];
		header("Location: $links");
		exit;
	}

	if($_GET["url"] == "login")
	{
		$content_change = 13;
		require_once("include/do-login.php");
	}

	if($_GET["url"] == "register-ok")
	{
		$content_change = 8;
	}

	if($_GET["url"] == "repeat-order")
	{
		$query = mysql_query("select * from orders where id = '$_GET[id]' and user_id = '$user_id'");
		if($mysql = mysql_fetch_array($query))
		{
			$query1 = mysql_query("select * from ordered_items where parent_id = '$mysql[id]'");
			while($mysql1 = mysql_fetch_array($query1))
			{
				$query2 = mysql_query("select * from items where id = '$mysql1[item_id]' and buy = '1' and price > '0'");
				if($mysql2 = mysql_fetch_array($query2))
				{
					$ch = mysql_query("select * from basket where ip = '$ip' and session_id = '$ses_id' and user_id = '$user_id' and parent_id = '$mysql2[id]'");
					if($exists=mysql_fetch_array($ch))
					{
						$new_count = $mysql1["count"] + $exists["count"];
						$result = mysql_query("update basket set count = '$new_count' where id = '$exists[id]'");
					}
					else
					{
						$result = mysql_query("insert into basket values (
							'',
							'$ip',
							'$user_id',
							'$ses_id',
							'$mysql2[id]',
							'$mysql1[count]'

						)");

						//Atkārtoti ievietotas preces preču grozā
						AddStatistic($ip,$user_id,$ses_id,$url,'',9);
					}
				}
			}
		}
		else
		{
			$links = $root_dir.$_GET["lang"];
			header("Location: $links");
			exit;
		}
		$content_change = 15;
	}

	if($_GET["url"] == "order-ok")
	{
		$content_change = 6;
	}

	if($_GET["url"] == "remember")
	{
		$content_change = 9;
		require_once("include/do-remember.php");
	}

	if($_GET["url"] == "remember-ok")
	{
		$content_change = 10;
	}



	if($_GET["url"] == "d-basket")
	{

		$result = mysql_query("delete from basket where id = '$_GET[item_id]' and ip = '$ip' and session_id = '$ses_id'");
		$query = mysql_query("select * from content where template = '3' and lang = '$_GET[lang]'");
		$mysql = mysql_fetch_array($query);

		$links = $root_dir.$_GET["lang"]."/$mysql[url]";
		//Pievienota prece preču grozam
		AddStatistic($ip,$user_id,$ses_id,$url,'',1);

		header("Location: $links");
		exit;
	}

	if($_GET["url"] == "to-basket")
	{
		$quantity = $_GET["quantity"];
		$ch = mysql_query("select * from basket where ip = '$ip' and session_id = '$ses_id' and user_id = '$user_id' and parent_id = '$_GET[item_id]'");

		if($exists=mysql_fetch_array($ch))
		{
			$new_count = $quantity + $exists["count"];
			$result = mysql_query("update basket set count = '$new_count' where id = '$exists[id]'");
		}
		else
		{
			$result = mysql_query("insert into basket values (
				'',
				'$ip',
				'$user_id',
				'$ses_id',
				'$_GET[item_id]',
				'$quantity'

			)");

			//Pievienota prece preču grozam
			AddStatistic($ip,$user_id,$ses_id,$url,'',0);
		}

		if(isset($_GET["item_url"]))
		{
			$links = $root_dir.$_GET["lang"]."/".$_GET["item_url"];
		}
		else
		{
			$query = mysql_query("select * from content where template = '3' and lang = '$_GET[lang]'");
			$mysql = mysql_fetch_array($query);
			$links = $root_dir.$_GET["lang"]."/$mysql[url]";
		}
		header("Location: $links");
		exit;
	}

	if($_GET["url"] == "search")
	{
		$content_change = 5;
	}




	$f=mysql_query("Select * from items where url_lv='$_GET[url]' and (statuss= '2' or statuss = '3')");
	if($r=mysql_fetch_array($f))
	{
		$catalog_id = $r["parent_id"];
		$title = $r[$title_lang];
		$description  = $r[$description_lang];
		$keywords = $r[$keywords_lang];

		$izveleta = $r['name_lv'];
		if(!empty($r[$name_lang]))
		{
			$izveleta = $r[$name_lang];
		}
		$content_change = 3;

		$item_id = $r["id"];
		$item_text = $r['text_lv'];
		if(!empty($r[$text_lang]))
		{
			$item_text = $r[$text_lang];
		}
		$item_picture = $r["picture"];
		$item_discount_price = 0;
		$item_discount = $r["discount"];
		$item_statuss = $r["statuss"];
		$item_url = $r['url_lv'];
		$item_referals = $r["items"];
		$item_person = $r["person"];
		$item_code = $r["code"];
		$item_buy = $r["buy"];
		$item_copy = $r["copy"];


		$r1=mysql_query("Select * from categories where id = '$r[parent_id]'");
		$fe1=mysql_fetch_array($r1);
		$cat_type = $fe1["type"];

		$tagad = time();
		$di = mysql_query("select * from discounts where '$tagad' >= start_time and '$tagad' <= end_time and cats like '%*$r[parent_id]*%' and type < '3' order by value desc limit 0,1");
		if($disc = mysql_fetch_array($di))
		{
			$time_discount = $disc["value"];
		}


		$discount_image = 0;
		if($r["discount"] == 2)
		{
			if($r["discount_price"] > 0)
			{
			    $item_price = $r["price"] - $r["discount_price"];
			}
			else
			{
			    $item_price = $r["price"] - $r["price"] * $r["discount_percent"] / 100;
			}
			$discount_image = 1;
		}
		else
		{
			$item_price = $r["price"];
			// Ja ir piešķirta atlaide
			if($time_discount > 0)
			{
				$item_price = $item_price - $item_price * $time_discount / 100;
				$discount_image = 1;
			}

		}
		if($discount_image == 1)
		{
			$discount_image = '<div class="discount"></div>';
		}
		else
		{
			$discount_image  ="";
		}

		if($r["new"] == 2)
		{
			$new_image = '<div class="new"></div>';
		}
		else
		{
			$new_image  ="";
		}

		// Ja ir lietotāja atlaide
		$item_price = $item_price - $item_price * $user_discount / 100;
		$item_price = number_format(round($item_price,2),2,".","");



		if($_SESSION["t"] == 2){ $te = "2";}else{ $te = "1";}
		$query = mysql_query("select * from $tabula where template = '$te' and lang = '$_GET[lang]' and publish = 'on'");
		$mysql = mysql_fetch_array($query);
		mysql_free_result($query);
		$izv_id = $mysql["id"];
		$id = $mysql["id"];

		$sablons = $mysql["template"];
		$choosen = "<a href=\"$root_dir$_GET[lang]/$mysql[url]\" title=\"$mysql[name]\">$mysql[name]</a>&nbsp;&gt;&nbsp;";
	}


	$r=mysql_query("Select * from categories where statuss='2' and $url_lang = '$_GET[url]' and $url_lang <> ''");
	if($fe=mysql_fetch_array($r))
	{
		$title_lang = "title_".$_GET["lang"];
		$description_lang = "description_".$_GET["lang"];
		$keywords_lang = "keywords_".$_GET["lang"];

		$title = $fe[$title_lang];
		$description = $fe[$description_lang];
		$keywords = $fe[$keywords_lang];

		$catalog_id = $fe["id"];
		$izveleta = $fe[$name_lang];
		$teksts = $fe[$text_lang];
		$cat_type = $fe["type"];

		$category_discount = $fe['discount'];

		$content_change = 2;
		if($cat_type == 2)
		{
			$_SESSION["t"] = 2;
		}
		if($_SESSION["t"] == 2){ $te = "2";}else{ $te = "1";}


		$query = mysql_query("select * from $tabula where template = '$te' and lang = '$_GET[lang]' and publish = 'on'");
		$mysql = mysql_fetch_array($query);

		$izv_id = $mysql["id"];
		$id = $mysql["id"];
		$sablons = $mysql["template"];
		$choosen = "<a href=\"$root_dir$_GET[lang]/$mysql[url]\" title=\"$mysql[name]\">$mysql[name]</a>&nbsp;&gt;&nbsp;";

		$query = mysql_query("select * from items where  (statuss= '2' or statuss = '3') and parent_id = '$fe[id]'");
		$count = mysql_num_rows($query);

		$tagad = time();
		$di = mysql_query("select * from discounts where '$tagad' >= start_time and '$tagad' <= end_time and cats like '%*$fe[id]*%' and type < '3' order by value desc limit 0,1");
		if($disc = mysql_fetch_array($di))
		{
			$time_discount = $disc["value"];
		}

		if($te == 1)
		{
		    $filter = " and (type = '0' or type = '1')";
		}
		else
		{
		    $filter = " and (type = '0' or type = '2')";
		}

		if($fe['parent_id'] == 0)
		{
			$query1=mysql_query("Select * from categories where statuss='2' and parent_id = '$parent_category_id'$filter and industry = '$_SESSION[industry]' order by place asc limit 0,1");
			if($mysql1=mysql_fetch_array($query1))
			{
			    if($_GET['url'] != $mysql1[$url_lang])
			    {
			    	$links = $root_dir.$_GET["lang"]."/$mysql1[$url_lang]";
			    	header("Location: $links");
			    	exit;
			    }
			}
		}
		if($count == 0)
		{
			if($te == 1)
			{
				$filter = " and (type = '0' or type = '1')";
			}
			else
			{
				$filter = " and (type = '0' or type = '2')";
			}

			$r1=mysql_query("Select * from categories where statuss='2' and parent_id = '$fe[id]' $filter order by place asc limit 0,1");
			if($fe1=mysql_fetch_array($r1))
			{
				$links = $root_dir.$_GET["lang"]."/$fe1[$url_lang]";
				header("Location: $links");
				exit;
			}
		}
	}
}

if($content_change == 0)
{
	$r=mysql_query("Select * from $tabula where publish='on' and url='$_GET[url]' and lang='$_GET[lang]'");
	if($fe=mysql_fetch_array($r))
	{
		$content_change = 1;
		$id = $fe["id"];
		$_GET["lang"] = $fe["lang"];

		$title = $fe["title"];
		$description = $fe["description"];
		$keywords = $fe["keywords"];

		$teksts = $fe["text"];
		$izveleta = $fe["name"];
		$sablons = $fe["template"];
		$parent_id = $fe["parent_id"];

		$album = $fe["album"];

		//Produkti un E-veikals
		if($sablons == 1 || $sablons == 2)
		{
			$content_change = 2;
			$_SESSION["t"] = $sablons;
			if($_SESSION["t"] == 1)
			{
				$filter = " and (type = '0' or type = '1')";
			}
			else
			{
				$filter = " and (type = '0' or type = '2')";
			}

			if($_SESSION['industry'] > 0)
			{
				$filter .= " and industry = '$_SESSION[industry]'";
			}

			$r1=mysql_query("Select * from categories where statuss='2' and parent_id = '0' $filter order by place asc limit 0,1");
			if($fe1=mysql_fetch_array($r1))
			{
				$links = $root_dir.$_GET["lang"]."/$fe1[$url_lang]";
				header("Location: $links");
				exit;
			}
			else
			{
				if($_SESSION["t"] == 1)
				{
				    $filter = " and (type = '0' or type = '1')";
				}
				else
				{
				    $filter = " and (type = '0' or type = '2')";
				}
				if($_SESSION['industry'] == 1){$_SESSION['industry'] = 2;}else{$_SESSION['industry']=1;}
				$filter .= " and industry = '$_SESSION[industry]'";

				$r1=mysql_query("Select * from categories where statuss='2' and parent_id = '0' $filter order by place asc limit 0,1");
				if($fe1=mysql_fetch_array($r1))
				{
				    $links = $root_dir.$_GET["lang"]."/$fe1[$url_lang]";
				    header("Location: $links");
				    exit;
				}
			}
		}

		// Preču grozs
		if($sablons == 3)
		{
			$content_change = 4;
			//Lietotājs pieslēdzies
			AddStatistic($ip,$user_id,$ses_id,$url,'',5);
		}

		$anketa = $fe["form"];
		if($anketa>0)
		{
			require_once("do_anketa.php");
		}


		if($fe["parent_id"] == "0")
		{
			$izv_id = $fe["id"];

		}
		else
		{
			$par = $id;
			$zum = "on";
			$g = 0;
			while($zum == "on")
			{
				$izv=mysql_query("Select * from $tabula where id='$par' and publish='on'");
				$izve=mysql_fetch_array($izv);
				$par = $izve["parent_id"];

				if($par == 0)
				{
					$zum = "off";
					$izv_id = $izve["id"];
				}
			}
		}


	}
	mysql_free_result($r);
}

if($anketa > 0)
{
	$query=mysql_query("Select * from anketas where id='$anketa'");
	$mysql = mysql_fetch_array($query);
	$anketa_type = $mysql["type"];
}
?>