<?php
//ielâdçjam funkcijas

require_once("config.php");

unset($_SESSION["valid_user"]);
session_destroy();

header("Location: index.php");
exit;

?>
