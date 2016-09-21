<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$rep=mysqli_query($result_db,"Select * from anketas where place<'$iz' and parent_id='$name' order by place desc limit 0, 1");

$place_old=$iz;
if($rop=mysqli_fetch_array($rep)){
$place_new=$rop["place"];

}
else{$place_new=$place_old;}
$nn=$rop["id"];
mysqli_free_result($rep);

$result = mysqli_query($result_db,"update anketas set place='$place_old' where id='$nn'"); 
$result = mysqli_query($result_db,"update anketas set place='$place_new' where id='$k'"); 

$links = "lauki.php".$li1."&name=$name";
header("Location: $links");
exit;
?>