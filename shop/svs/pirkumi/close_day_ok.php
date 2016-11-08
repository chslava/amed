<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");
require_once("user_auth.php");

$domain     = 'https://secureshop.firstdata.lv';
$cert_url   = '../../certs/2851921_imakstore.pem';
$cert_pass  = '6zqBNUg5a';

require("../../Merchant.php");
$ecomm_url = $domain.':8443/ecomm/MerchantHandler';


$merchant = new Merchant($ecomm_url, $cert_url, $cert_pass, 1);

$resp = $merchant -> closeDay();    
//echo $resp;

$links = "index.php".$li1;
header("Location: $links");
exit;

?>