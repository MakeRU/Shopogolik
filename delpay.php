<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{

if (isset($_GET['no']))
{
    $payid = $_GET['no'];

		$query = "DELETE FROM `payment` 
				WHERE `id_pay`='{$payid}'";
		$sql = mysql_query($query) or die(mysql_error());	
		
	header('Location: allpay.php');
	}
}
include "footer.php"; 
?>