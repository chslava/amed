<?php

if (strtoupper(substr(PHP_OS,0,3)=='WIN'))
{ 
	$eol="\r\n"; 
}
elseif (strtoupper(substr(PHP_OS,0,3)=='MAC'))
{ 
	$eol="\r"; 
} 
else
{ 
	$eol="\n"; 
}	
	
$saturs_txt = "";
$saturs_txt .= "$e[121]: $x";
	
$saturs_html ="<html>
	<head>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	<style>
			
				body, tr, td, table, div {
					font-family: Tahoma, Geneva, sans-serif;
					font-size:12px;
					color:#000000;
				}				
			
			</style>
	</head>
	
	<body>
	<table cellpadding=\"3\" cellspacing=\"1\">
		<tr>
			<td>$e[121]: $x</td>
		</tr>
	</table>
	</body>
	</html>";

if($zz["person"] == 1)
{
	$client_name  = $zz["company_name"];
}
else
{
	$client_name = $zz["person_name"];
}
				
require_once 'swift/swift_required.php';

//Create the Transport
$transport = Swift_MailTransport::newInstance();
	
//Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);
		
//Create a message
$message = Swift_Message::newInstance($e[122])
  ->setFrom(array($e[34] => $e[35]))
  ->setTo(array($zz["email"] => $client_name))
  ->setBody($saturs_txt)
  ->addPart($saturs_html, 'text/html')
  ;
 
$message->setPriority(1);
$message->setSender($e[34]);
$message->setReturnPath($e[34]);
$message->setReplyTo("$_POST[email]");
$message->setDate(time());
  		  
//Send the message
$numSent = $mailer->send($message);		

?>