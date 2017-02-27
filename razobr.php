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
			
				$query = "SELECT * 
							FROM `order`
							WHERE `id_order`='{$ordno}'";
				$ordp = mysql_query($query) or die(mysql_error());
				$ord = mysql_fetch_assoc($ordp);
				
			if ($ord['Status'] == "Получено")
			{
				//echo $ord['Status'];
				
				$query = "SELECT * 
							FROM `userpack`
							WHERE `id_pack`='{$parampack}' AND
								  `id_user`='{$ord['id_user']}'";
				$coun = mysql_query($query) or die(mysql_error());
				$ct = mysql_num_rows($coun);

				//echo $ct;
				
				if ($ct == 0)
				{
					$query = "INSERT
					INTO `userpack`
					SET
						`id_pack`='{$parampack}',
						`id_user`='{$ord['id_user']}'";
					$sql1 = mysql_query($query) or die(mysql_error());
				}
			}
		}
		}
		
		$date_raz = date("Y-m-d",time()+3*60*60);
		$userrazb = 
		$query = "UPDATE `package`
					SET
						`Status`='Разобрана',
						`Date_raz`='{$date_raz}',
						`usr_razb`='{$_SESSION['user_id']}'
					WHERE `id_pack`='{$parampack}'";
		$sql = mysql_query($query) or die(mysql_error());
		
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