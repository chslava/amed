<?php
$error = array();
if(isset($_GET["code"]))
{
	$check_client = mysql_query("select * from clients where code='$_GET[code]'");
	if($client_exists = mysql_fetch_array($check_client))
	{
		$result = mysql_query("update clients set statuss='2' where id='$client_exists[id]' and statuss != '3'");
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
		
		$contracts = array(2 => $e[41], 1 => $e[42]);
		
		if($client_exists["statuss"] == 1)
		{
			
			if($client_exists["person"] == 2)
			{
				$contract_id = $client_exists["person_contract"];
				$saturs_txt = "";
				$saturs_txt .= "$e[77] $eol$eol";
				$saturs_txt .= "$e[91] $client_exists[company_name]$eol";
				$saturs_txt .= "$e[92] $client_exists[company_code]$eol";
				$saturs_txt .= "$e[86] $eol$eol";
				$saturs_txt .= "$e[87] $client_exists[company_phone]$eol";
				
				$saturs_txt .= "$e[89] $client_exists[company_deliver]$eol";
				
				
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
						<td colspan=\"2\">$e[77]</td>
					</tr>
					<tr>
						<td>$e[91]</td>
						<td>$client_exists[person_name]</td>
					</tr>
					<tr>
						<td>$e[92]</td>
						<td>$client_exists[person_code]</td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;</td>
					</tr>
					<tr>
						<td colspan=\"2\">$e[86]</td>
					</tr>
					<tr>
						<td>$e[87]</td>
						<td>$client_exists[person_phone]</td>
					</tr>
					<tr>
						<td>$e[89]</td>
						<td>$client_exists[person_deliver]</td>
					</tr>
					
				</table>
				</body>
				</html>";
			}
			else
			{
				$contract_id = $client_exists["company_contract"];
				$saturs_txt = "";
				$saturs_txt .= "$e[77] $eol$eol";
				$saturs_txt .= "$e[80] $client_exists[company_name]$eol";
				$saturs_txt .= "$e[81] $client_exists[company_code]$eol";
				$saturs_txt .= "$e[82] $client_exists[company_address]$eol";
				$saturs_txt .= "$e[83] $client_exists[company_bank]$eol";
				$saturs_txt .= "$e[84] $client_exists[company_bank_code]$eol";
				$saturs_txt .= "$e[85] $client_exists[company_account]$eol";
				$saturs_txt .= "$e[86] $eol$eol";
				$saturs_txt .= "$e[87] $client_exists[company_phone]$eol";
				
				$saturs_txt .= "$e[89] $client_exists[company_deliver]$eol";
				
				
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
						<td colspan=\"2\">$e[77]</td>
					</tr>
					<tr>
						<td>$e[80]</td>
						<td>$client_exists[company_name]</td>
					</tr>
					<tr>
						<td>$e[81]</td>
						<td>$client_exists[company_code]</td>
					</tr>
					<tr>
						<td>$e[82]</td>
						<td>$client_exists[company_address]</td>
					</tr>
					<tr>
						<td>$e[83]</td>
						<td>$client_exists[company_bank]</td>
					</tr>
					<tr>
						<td>$e[84]</td>
						<td>$client_exists[company_bank_code]</td>
					</tr>
					<tr>
						<td>$e[85]</td>
						<td>$client_exists[company_account]</td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;</td>
					</tr>
					<tr>
						<td colspan=\"2\">$e[86]</td>
					</tr>
					<tr>
						<td>$e[87]</td>
						<td>$client_exists[company_phone]</td>
					</tr>
					<tr>
						<td>$e[89]</td>
						<td>$client_exists[company_deliver]</td>
					</tr>
					
				</table>
				</body>
				</html>";
			}
							
			require_once 'swift/swift_required.php';
			
			//Create the Transport
			$transport = Swift_MailTransport::newInstance();
			
			//Create the Mailer using your created Transport
			$mailer = Swift_Mailer::newInstance($transport);
			
			//Create a message
			$message = Swift_Message::newInstance($e[114])
			  ->setFrom(array($e[34] => $e[35]))
			  ->setTo(array($e[34] => $e[35]))
			  ->setBody($saturs_txt)
			  ->addPart($saturs_html, 'text/html')
			  ;
			 
			$message->setPriority(1);
			$message->setSender($e[34]);
			$message->setReturnPath($e[34]);
			  		  
			//Send the message
			$numSent = $mailer->send($message);	
		}
	}
	else
	{
		$error[0] = 1;
	}			
	mysql_free_result($check_client);
}
else
{
	$error[0] = 1;
}
?>