<?php

require_once("rtf/Rtf.php");

//ieldjam funkcijas
require_once("../config.php");
//prbaudam, vai lietotjs ir reistrjies
require_once($wolf_path."check.php");

$ord=mysql_query("Select * from orders where id='$name'");
$pas=mysql_fetch_array($ord);
mysql_free_result($ord);

$ord_valsts=mysql_query("Select * from country where id='$pas[country]'");
$pas_valsts=mysql_fetch_array($ord_valsts);
mysql_free_result($ord_valsts);

$ord_zieds=mysql_query("Select * from flowers where id='$pas[parent_id]'");
$pas_zieds=mysql_fetch_array($ord_zieds);
mysql_free_result($ord_zieds);

$change_from=array("&quot;");
$change_to=array("\"");

//Rtf document
$rtf = new Rtf();
//Section
$null = $null;
$sect = &$rtf->addSection();


// SIA FLORENS INTERNATIONAL
$par = new ParFormat('center');
$sect->writeText("<b>$fakss[0]</b>", new Font(14, 'Times New Roman'), $par);

// Melna lînija
$parBlack = new ParFormat('center');
$parBlack->setBackColor('#000000');
$parBlack->setSpaceBefore(2);
$parBlack->setSpaceAfter(3);

$fontSmall = new Font(1);

$sect->emptyParagraph($fontSmall, $parBlack);

// Ðodienas datums
$par = new ParFormat('left');
$sect->writeText("<b>".date("d.m.Y")."</b>, $fakss[1]", new Font(12, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(3);
$parEnter->setSpaceAfter(3);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Kam:
$par = new ParFormat('left');
$adrese=str_replace($change_from,$change_to,$pas_valsts["adrese"]);
$sect->writeText("$fakss[2] <b>$adrese</b>", new Font(12, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(3);
$parEnter->setSpaceAfter(3);
$sect->emptyParagraph($fontMiddle, $parEnter);

// No kâ
$par = new ParFormat('left');
$sect->writeText("$fakss[3]", new Font(12, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(12);
$parEnter->setSpaceAfter(6);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Lûdzam piegâdât ziedus...
$par = new ParFormat('left');
$sect->writeText("<b>$fakss[4]</b>", new Font(12, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(6);
$parEnter->setSpaceAfter(3);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Ziedu sastâvs
$par = new ParFormat('left');
if($pas["big_small"]==2)
{
	$sastavs=str_replace($change_from,$change_to,$pas_zieds["sastavs_small"]);
}
else
{
	$sastavs=str_replace($change_from,$change_to,$pas_zieds["sastavs_big"]);
}
$sect->writeText("<b>$fakss[5]</b> $sastavs", new Font(12, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(3);
$parEnter->setSpaceAfter(3);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Cena
$par = new ParFormat('left');
$total_p = $pas["total_price"]/2;
$cena = number_format($total_p, 2, '.','');
$sect->writeText("<b>$fakss[6] $cena $fakss[7]</b>", new Font(14, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(3);
$parEnter->setSpaceAfter(3);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Piegâdes datums
$pieg_datums = date("d.m.Y",$pas["del_time"]);
$piegade_m = array("","9.00-10.00","10.00-11.00","11.00-12.00","12.00-13.00","13.00-14.00","14.00-15.00","15.00-16.00","16.00-17.00","17.00-18.00","18.00-19.00");
if($pas[p_laiks]>0)
{
	$p_laiks_ir =", ".$piegade_m[$pas[p_laiks]];
}
else
{
	$p_laiks_ir ="";
}
$diena = date("w",$pas["del_time"]);

$par = new ParFormat('left');
$par->setBorders(new BorderFormat(1, '#666666'));
$par->setSpaceBetweenLines(2);
$sect->writeText("	$fakss[8] <b>$pieg_datums, $dienas[$diena] $p_laiks_ir</b><br>", new Font(14, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(3);
$parEnter->setSpaceAfter(3);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Ziedu saòçmçjs
$par = new ParFormat('left');
$sect->writeText("<b>$fakss[9]</b>", new Font(12, 'Times New Roman'), $par);

// Vârds, uzvârds, E-pasts, Iela, Telefons, Vieta
$par = new ParFormat('left');
$par->setBorders(new BorderFormat(1, '#666666'));
$par->setSpaceBetweenLines(2);

$vieta = $pas["delivery"];

$iela = $pas["address1"]." ".$pas["address2"]." ".$pas_valsts["name_lv"]." ".$pas["del_state"]." ".$pas["del_zip"];
$iela=str_replace($change_from,$change_to,$iela);

$sect->writeText("	$fakss[10] <b>$pas[first_name] $pas[last_name]</b>\n\r
	$fakss[11] <b>$pas[email]</b>\n\r
	$fakss[12] <b>$pas[phone]</b>\n\r
	$fakss[13] <b>$iela</b>\n\r
	$fakss[14] <b>$pieg_vieta[$vieta]</b>\n\r
	$orders[38] <b>$pas[company]</b>\n\r
	", new Font(12, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(3);
$parEnter->setSpaceAfter(3);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Teksts kartiòâ
$par = new ParFormat('left');
$kartina = $pas["card_text"]." ".$pas["card_name"];
$kartina = str_replace("\n","",$kartina);
$kartina = trim($kartina);
$sect->writeText("$fakss[15] <b>$kartina</b>", new Font(12, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(12);
$parEnter->setSpaceAfter(12);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Apmaksa
$par = new ParFormat('left');
$sect->writeText("<b>$fakss[16]</b>", new Font(12, 'Times New Roman'), $par);
$sect->writeText("<b>$fakss[17]</b>", new Font(12, 'Times New Roman'), $par);
$sect->writeText("$fakss[18]", new Font(12, 'Times New Roman'), $par);
$sect->writeText("$fakss[19]", new Font(12, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(6);
$parEnter->setSpaceAfter(6);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Rekvizîti
$par = new ParFormat('left');
$sect->writeText("<b>$fakss[20]</b> $fakss[21]", new Font(12, 'Times New Roman'), $par);
$sect->writeText("<b>$fakss[22]</b>", new Font(12, 'Times New Roman'), $par);
$sect->writeText("$fakss[23]", new Font(12, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(6);
$parEnter->setSpaceAfter(6);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Apmaksu garantçjam
$sect->writeText("$fakss[24]", new Font(12, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(3);
$parEnter->setSpaceAfter(3);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Paldies par sadarbîbu
$sect->writeText("$fakss[25]", new Font(12, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(3);
$parEnter->setSpaceAfter(3);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Ar sveicieniem
$sect->writeText("$fakss[26]", new Font(12, 'Times New Roman'), $par);

// Enter
$fontMiddle = new Font(2);
$parEnter = new ParFormat('center');
$parEnter->setSpaceBefore(6);
$parEnter->setSpaceAfter(6);
$sect->emptyParagraph($fontMiddle, $parEnter);

// Ar sveicieniem
$par = new ParFormat('center');
$sect->writeText("<i>$fakss[27]</i>", new Font(10, 'Times New Roman'), $par);
$sect->emptyParagraph($fontSmall, $parBlack);
$par = new ParFormat('center');
$sect->writeText("$fakss[28]", new Font(12, 'Times New Roman'), $par);

$rtf->sendRtf();

?>