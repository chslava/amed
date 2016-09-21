<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$rep=mysqli_query($result_db,"Select * from albums where id = '$_GET[k]'");
$rop=mysqli_fetch_array($rep);
mysqli_free_result($rep);


$rep=mysqli_query($result_db,"Select * from albums where place>'$_GET[iz]' and parent_id='$rop[parent_id]' order by place asc limit 0, 1");

$place_old=$_GET["iz"];
if($rop=mysqli_fetch_array($rep)){
$place_new=$rop["place"];

}
else{$place_new=$place_old;}
$nn=$rop["id"];
mysqli_free_result($rep);

$result = mysqli_query($result_db,"update albums set place='$place_old' where id='$nn'"); 
$result = mysqli_query($result_db,"update albums set place='$place_new' where id='$_GET[k]'"); 

$links = "index.php".$li1;
header("Location: $links");
exit;
?>