<?php

include "header.php"; 


session_start();

include ('mysql.php');

if (isset($_SESSION['user_id']))
{
	$query = "SELECT *
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

	$query = "SELECT `id_pack`, `id_ord`, count(*) FROM `contpack`
    GROUP BY `id_ord` HAVING COUNT(*)>1";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{

		// так как запрос возвращает несколько строк, применяем цикл
		while($pack = mysql_fetch_array($sql))
		{	
		echo "<table border=0 align='center'>";
		echo "<tr align='center'><td>Ордер</td>
				<td>Участник закупки</td>
		          <td>Магазин</td>
				  <td>Артикул</td>
				  <td>Дата</td>
				  <td>Цена</td>
				  <td>Посылки</td>";

		  $ordno = $pack['id_ord'];

//		echo $ordno;	
		
		$query = "SELECT * 
				FROM `order`
				WHERE `id_order`='{$ordno}'";
			$ordp = mysql_query($query) or die(mysql_error());
			$ord = mysql_fetch_assoc($ordp);
		
			$query = "SELECT `shop` 
				FROM `shop`
				WHERE `id_shop`='{$ord['id_shop']}'";
			$ordn = mysql_query($query) or die(mysql_error());
			$orn = mysql_fetch_assoc($ordn);
			$oname = $orn['shop'];
			
			$query = "SELECT `col` 
				FROM `shop`
				WHERE `id_shop`='{$ord['id_shop']}'";
			$ordc = mysql_query($query) or die(mysql_error());
			$orcn = mysql_fetch_assoc($ordc);
			$cname = $orcn['col'];
			
			$query = "SELECT * 
				FROM `users`
				WHERE `id`='{$ord['id_user']}'";
			$usn = mysql_query($query) or die(mysql_error());
			$us = mysql_fetch_assoc($usn);
			$uname = $us['login'];
			$umes = $us['mes'];
			
			
			
			$query = "SELECT * 
				FROM `contpack`
				WHERE `id_ord`='{$ordno}'";
			$sql1 = mysql_query($query) or die(mysql_error());
	
			if($sql1)
			{	
			while($pack1 = mysql_fetch_array($sql1))
			{
			$packno = $pack1['id_pack'];
			echo "<tr bgcolor='".$cname."'>
					<td>".$ord['id_order']."&nbsp;</td>
					<td><a href=\"".htmlspecialchars($umes,ENT_QUOTES)."\" target='_blank'>".$uname."&nbsp;</td>
			         <td>".$oname."&nbsp;</td>
					  <td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$ord['Articul']."&nbsp;</a></td>
					  <td>".$ord['Data']."&nbsp;</td>
					  <td>".$ord['Cost_USD']."&nbsp;</td>
					  <td>".$packno."&nbsp;</td>
				</tr>";	
			}
			}
			
		echo "</table>";
		}
		

		
		}
	
	

	

}
else
{
	die('Доступ закрыт, даём ссылку на авторизацию. — <a href="login.php">Авторизоваться</a>');
}



include "footer.php"; 

?>