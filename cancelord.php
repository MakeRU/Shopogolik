<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{

if (isset($_GET['no']))
{
    $ordno = $_GET['no'];
	$ordstat = "Отмена";
	$ordsru = 0;
	
	// проверяем на наличие ошибок (например, длина логина и пароля)
	
		
		$query = "UPDATE `order`
					SET
						`Sum_RU`='{$ordsru}',
						`Status`='{$ordstat}'
					WHERE `id_order`='{$ordno}'";
		$sql = mysql_query($query) or die(mysql_error());
	
		
		print '<h4>Ордер сохранен</h4><a href="allordusa.php">Все заказы USA</a>';
		header('Location: allordusa.php');
}
}
include "footer.php"; 
?>