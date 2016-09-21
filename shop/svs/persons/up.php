<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");


$rep=mysqli_query($result_db,"Select * from carservices where place<'$_GET[iz]' order by place desc limit 0, 1");

$place_old=$_GET["iz"];
if($rop=mysqli_fetch_array($rep)){
$place_new=$rop["place"];

}
else{$place_new=$place_old;}
$nn=$rop["id"];
mysqli_free_result($rep);

$result = mysqli_query($result_db,"update carservices set place='$place_old' where id='$nn'"); 
$result = mysqli_query($result_db,"update carservices set place='$place_new' where id='$_GET[k]'"); 

$links = "index.php".$li1."&page=$_GET[page]";
header("Location: $links");
exit;
?>