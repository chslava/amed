<?php


//@ini_set('display_errors', '0');
//error_reporting(0);


error_reporting(E_ALL);
ini_set('display_errors', 1);


?>
<?php 
	require_once("include/config.php");
	require_once("include/head.php");

				
	switch ($content_change)
	{
		// Ievietojam titullapu
		case 0:
			require_once("include/header.php");
			require_once("include/titul.php");
			require_once("include/footer.php");
			break;
		
		// Ievietojam teksta lapu
		case 1:
			require_once("include/header.php");
			require_once("include/text.php");
			require_once("include/footer.php");
			break;
		
		// Ievietojam kategoriju
		case 2:
			require_once("include/header.php");
			require_once("include/category.php");
			require_once("include/footer.php");
			break;
		
		// Ievietojam preci
		case 3:
			require_once("include/header.php");
			require_once("include/item.php");
			require_once("include/footer.php");
			break;
		
		// Preču grozs
		case 4:
			require_once("include/header.php");
			require_once("include/basket.php");
			require_once("include/footer.php");
			break;
		
		// Pasūtījuma noformēšana
		case 5:
			require_once("include/header.php");
			require_once("include/order.php");
			require_once("include/footer.php");
			break;
		
		// Pasūtījuma noformēšana
		case 6:
			require_once("include/header.php");
			require_once("include/order-ok.php");
			require_once("include/footer.php");
			break;
		
		// Reģistrācijas anketa
		case 7:
			require_once("include/header.php");
			require_once("include/register.php");
			require_once("include/footer.php");
			break;
		
		// Teksts pēc reģistrācijas anketas
		case 8:
			require_once("include/header.php");
			require_once("include/register-ok.php");
			require_once("include/footer.php");
			break;
		
		// Aizmirsi paroli
		case 9:
			require_once("include/header.php");
			require_once("include/remember.php");
			require_once("include/footer.php");
			break;
		
		// Aizmirsi paroli OK
		case 10:
			require_once("include/header.php");
			require_once("include/remember-ok.php");
			require_once("include/footer.php");
			break;
			
		// Mani dati
		case 11:
			require_once("include/header.php");
			require_once("include/my-data.php");
			require_once("include/footer.php");
			break;
		
		// Mani dati OK
		case 12:
			require_once("include/header.php");
			require_once("include/my-data-ok.php");
			require_once("include/footer.php");
			break;
		
		// Login
		case 13:
			require_once("include/header.php");
			require_once("include/login.php");
			require_once("include/footer.php");
			break;
		
		// Pirkumu vēsture
		case 14:
			require_once("include/header.php");
			require_once("include/my-orders.php");
			require_once("include/footer.php");
			break;
		
		// Pirkumu vēsture
		case 15:
			require_once("include/header.php");
			require_once("include/repeat-ok.php");
			require_once("include/footer.php");
			break;
		
		// Ievietojam titullapu
		default:
			require_once("include/header.php");
			require_once("include/my-data-ok.php");
			require_once("include/footer.php");
	}


	mysqli_close($result_db); 