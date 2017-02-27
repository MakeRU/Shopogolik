<?php

include "header.php"; 


session_start();

include ('mysql.php');

if (isset($_SESSION['user_id']))
{
	$query = "SELECT `login`
				FROM `users`
				WHERE `id`='{$_SESSION['user_id']}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	
	// если нету такой записи с пользователем
	// ну вдруг удалили его пока он лазил по сайту.. =)
	// то надо ему убить ID, установленный в сессии, чтобы он был гостем
	if (mysql_num_rows($sql) != 1)
	{
		header('Location: login.php?logout');
		exit;
	}
	
	$row = mysql_fetch_assoc($sql);
	
	$welcome = $row['login'];
	// показываем защищенные от гостей данные.
	
include "menu.php";	

if (isset($_GET['pack']))
{
	$parampack = $_GET['pack'];
	
		
		$query = "SELECT * 
				FROM `contpack`
				WHERE `id_pack`='{$parampack}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		if($sql)
		{
		// так как запрос возвращает несколько строк, применяем цикл
		while($pack = mysql_fetch_array($sql))
		{
			//echo $gotnum;

			$ordno = $pack['id_ord'];
//			echo $ordno;
			
//				$query = "SELECT * 
//							FROM `order`
//							WHERE `id_order`='{$ordno}'";
//				$ordp = mysql_query($query) or die(mysql_error());
//				$ord = mysql_fetch_assoc($ordp);
				
//			if ($ord['Status'] == "Заказан")
			{
				//echo $ord['Status'];
			
				$query = "UPDATE `order`
					SET
						`Status`='Получено'
					WHERE `id_order`='{$ordno}'";
				$sqlord = mysql_query($query) or die(mysql_error());
		
		
			}
		}
		}
		
	$locat = "Location: package.php?pack=".$parampack;
	header($locat);	
}	
}

	
	

else
{
	die('Доступ закрыт, даём ссылку на авторизацию. — <a href="login.php">Авторизоваться</a>');
}

	


include "footer.php"; 
?>