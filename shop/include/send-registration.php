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
	$saturs_txt .= "$e[103]$eol$eol";
	$saturs_txt .= "$e[104]$eol";
	$saturs_txt .= "$e[105]$eol";
	$saturs_txt .= "$root_dir$_GET[lang]/register?code=$code$eol$eol";
	$saturs_txt .= "$e[110]: $email $eol";
	$saturs_txt .= "$e[111]: $pas $eol$eol";
	$saturs_txt .= "$e[106]$eol";
	$saturs_txt .= "$e[107]$eol";
	$saturs_txt .= "$e[108]$eol";
		
		
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
			<td>$e[103]</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>$e[104]</td>
		</tr>
		<tr>
			<td>$e[105]</td>
		</tr>
		<tr>
			<td><a href=\"$root_dir$_GET[lang]/register?code=$code\">$root_dir$_GET[lang]/register?code=$code</a></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>$e[110]: $email</td>
		</tr>
		<tr>
			<td>$e[111]: $pas</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>$e[106]</td>
		</tr>
		<tr>
			<td>$e[107]</td>
		</tr>
		<tr>
			<td>$e[108]</td>
		</tr>
	</table>
	</body>
	</html>";
		
	require_once 'swift/swift_required.php';

	//Create the Transport
	$transport = Swift_MailTransport::newInstance();

	//Create the Mailer using your created Transport
	$mailer = Swift_Mailer::newInstance($transport);
	
	//Create a message
	$message = Swift_Message::newInstance($e[109])
	  ->setFrom(array($e[34] => $e[35]))
	  ->setTo(array($email => $mail_name))
	  ->setBody($saturs_txt)
	  ->addPart($saturs_html, 'text/html')
	  ;
	  
	$message->setPriority(1);
	$message->setSender($e[34]);
	$message->setReturnPath($e[34]);
		  
	//Send the message
	$numSent = $mailer->send($message);
?>