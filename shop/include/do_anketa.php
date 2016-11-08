<?php 

$change_from=array("'","\\","\"");
$change_to=array("`","","&quot;");


$p_cipari="^([0-9]+)$";
$p_epasts="^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$";

$an=mysqli_query($result_db,"Select * from anketas where id='$anketa'");
$anket=mysqli_fetch_array($an);
mysqli_free_result($an);

$check = 0;
$correct = 0;
$error = "";
$show_check = 0;

if(isset($_POST["submit"]))
{
	if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
  	$eol="\r\n"; 
	} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
  	$eol="\r"; 
	} else { 
 	$eol="\n"; 
	} 
	
	$saturs_txt = "";
	$saturs_html ="<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<style>
<!--
	body, tr, td, table, div {
	font-family:Verdana,Helvetica,sans-serif;
	font-size:11px;
	color:#000000;
	}
	
	-->
</style>
</head>

<body>
<table cellpadding=\"3\" cellspacing=\"1\">";

	
	$lauki=mysqli_query($result_db,"Select * from anketas where parent_id='$anketa' order by place asc");
	while($lauks=mysqli_fetch_array($lauki))
	{		
		//Ja nekas nav ierakstīts, vērtībai piešķiram tukšumu
		$value=$lauks["id"];
		if(!isset($_POST[$value]))
		{
			$_POST[$value] = ""; 
		}
		
		//Ja laukam ir jābūt obligāti aizpildītam, izmetam kļūdu
		if($lauks["field_fill"] == 2)
		{
			if(empty($_POST[$value]))
			{
				$check++;
			}
			$show_check++;
		}
		
		//Ja lauks ir jāpārbauda, vai tas ir pareizi aizpildīts, pārbaudam
		if($lauks["field_fill"] == 2)
		{
			if($lauks["field_check"]==1 && $check == 0)
			{
				if(!filter_var($_POST[$value], FILTER_VALIDATE_INT))
				{
					$error .="<h3 class=\"red\">$e[43]\"$lauks[field_name]\"! $e[37]</h3>";
					$correct++;
				}
			}
			
			if($lauks["field_check"]==4 && $check == 0){
				if(!filter_var($_POST[$value], FILTER_VALIDATE_EMAIL))
				{
					$error .="<h3 class=\"red\">$e[43]\"$lauks[field_name]\"!</h3>";
					$correct++;
				}
			}
		}
		
		//Ja ir izkrītošā izvēlne
		if($lauks["field_type"] == 1)
		{
			$mas = array(); $verti = explode("\n",$lauks["field_value"]);
			for($w=0;$w<count($verti);$w++)
			{
				$mas[$w] = $verti[$w];
			}
			
			$vi = $_POST[$value];
			$saturs_txt .= $lauks["field_name"].": ".$mas[$vi].$eol;
			$saturs_html .= "
			<tr>
				<td><b>$lauks[field_name]:</b> $mas[$vi]</td>
			</tr>";
		}
		
		//Ja ir atķeksējams lauciņš
		if($lauks["field_type"] == 2)
		{
			if($_POST[$value] == "on")
			{
				$atbilde= $e[41];
			}
			else
			{
				$atbilde= $e[42];
			}
			$saturs_txt .= $lauks["field_name"].": ".$atbilde.$eol;
			$saturs_html .= "
			<tr>
				<td><b>$lauks[field_name]:</b> $atbilde</td>
			</tr>";
		}
		
		//Vienas rindas teksta lauks
		if($lauks["field_type"] == 3)
		{
			$saturs_txt .= $lauks["field_name"].": ".$_POST[$value].$eol;
			$saturs_html .= "
			<tr>
				<td><b>$lauks[field_name]:</b> $_POST[$value]</td>
			</tr>";
		}
		
		
		// Ja ir vairāku rindu teksta lauks
		if($lauks["field_type"] == 4)
		{
			$saturs_txt .= $lauks["field_name"].":".$eol.$_POST[$value].$eol;
			$teksta_vertiba = str_replace("\n","<br>",$_POST[$value]);
			$saturs_html .= "
			<tr>
				<td><b>$lauks[field_name]:</b></td>
			</tr>
			<tr>
				<td>$teksta_vertiba</td>
			</tr>";
		}
		
		// Ja ir atstarpe
		if($lauks["field_type"] == 5)
		{
			$saturs_txt .= $eol.$eol;
		
			$saturs_html .= "
			<tr>
				<td>&nbsp;</td>
			</tr>";
			
			if(!empty($lauks["field_name"]))
			{
				$saturs_txt .= $lauks["field_name"].$eol.$eol;		
				$saturs_html .= "
				<tr>
					<td><b>$lauks[field_name]</b></td>
				</tr>";
			}
			else
			{
				$saturs_txt .= $eol.$eol;		
				$saturs_html .= "
				<tr>
					<td>&nbsp;</td>
				</tr>";
			}
		}				
	}
	mysqli_free_result($lauki);
	
	$saturs_html .= "</table></body></html>";
	
	
	
	if($error == "" && $correct == 0 && $check == 0)
	{
		$epasti = str_replace("\n","",$anket["email"]);
		$epasti = explode("<br>",$epasti);
		$all_emails = array();
		for($i=0;$i<count($epasti);$i++)
		{
			$san_mails = trim($epasti[$i]);	
			if(!empty($san_mails))
			{
				$all_emails[$san_mails] = $e[35];
			}
		}
		require_once 'swift/swift_required.php';

		//Create the Transport
		$transport = Swift_MailTransport::newInstance();
	
		//Create the Mailer using your created Transport
		$mailer = Swift_Mailer::newInstance($transport);
		
		//Create a message
		$message = Swift_Message::newInstance($anket["name"])
		  ->setFrom(array($e[34] => $e[35]))
		  ->setTo(
		  		$all_emails
			)
		  ->setBody($saturs_txt)
		  ->addPart($saturs_html, 'text/html')
		  ;
		  
		$message->setPriority(1);
		$message->setSender($e[34]);
		$message->setReturnPath($e[34]);
			  
		//Send the message
		$numSent = $mailer->send($message);
		
		$rezultats++;	
	}
}
else
{
	$lauki=mysqli_query($result_db,"Select * from anketas where parent_id='$anketa' order by place asc");
	while($lauks=mysqli_fetch_array($lauki))
	{		
		$value=$lauks["id"];
		$_POST[$value] = ""; 
		if($lauks["field_fill"] == 2)
		{
			$show_check++;
		}
	}
	mysqli_free_result($lauki);

}
?>