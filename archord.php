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

	echo "<table align='center' border=0><tr>";
	print '<td><a href="archord.php?year=15">Архив 2015</a></td>';
	print '<td><a href="archord.php?year=14">Архив 2014</a></td>';
	print '<td><a href="archord.php?year=13">Архив 2013</a></td>';
	print '<td><a href="archord.php?year=12">Архив 2012</a></td>';
	print '<td><a href="archord.php?year=10">Все</a></td>';
	echo "</tr></table>";	


if (isset($_GET['year']))
{
    $year = $_GET['year'];


    $st="Заказан";
	if ($year == 15)  { $query = "SELECT * 
				FROM `order`
				WHERE `Status` <> '{$st}' AND `Data` > '2014-12-31'
				ORDER BY `Data` DESC, `id_shop` ASC";}
	if ($year == 14)  { $query = "SELECT * 
				FROM `order`
				WHERE `Status` <> '{$st}' AND `Data` > '2013-12-31' AND `Data` < '2015-01-01'
				ORDER BY `Data` DESC, `id_shop` ASC";}
	if ($year == 13)  { $query = "SELECT * 
				FROM `order`
				WHERE `Status` <> '{$st}' AND `Data` > '2012-12-31' AND `Data` < '2014-01-01'
				ORDER BY `Data` DESC, `id_shop` ASC";}
	if ($year == 12)  { $query = "SELECT * 
				FROM `order`
				WHERE `Status` <> '{$st}' AND `Data` > '2011-12-31' AND `Data` < '2013-01-01'
				ORDER BY `Data` DESC, `id_shop` ASC";}
	if ($year == 10)  { $query = "SELECT * 
				FROM `order`
				WHERE `Status` <> '{$st}' 
				ORDER BY `Data` DESC, `id_shop` ASC";}				
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// определяем таблицу и заголовок
		echo "<table border=0>";
		echo "<tr><td>Ордер</td>
				<td>Участник закупки</td>
		          <td>Магазин</td>
				  <td>Артикул</td>
				  <td>Дата</td>
				  <td>Цена (USA)</td>
				  <td>Доставка (USA)</td>
				  <td>Скидка сайта</td>
				  <td>Налог </td>
				  <td>Орг</td>
				  <td>Сумма (USA)</td>
				  <td>Сумма (руб)</td>
				  <td>Курс</td>
				  <td>Статус</td></tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($ord = mysql_fetch_array($sql))
		{
			$query = "SELECT * 
				FROM `shop`
				WHERE `id_shop`='{$ord['id_shop']}'";
			$ordn = mysql_query($query) or die(mysql_error());
			$orn = mysql_fetch_assoc($ordn);
			$oname = $orn['shop'];
			$ocountry = $orn['Country'];			
//			echo $ocountry;
			
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
			
			$ed = "<a href=editord.php?no=".$ord['id_order'].">".$ord['id_order']."</a>";
//			if ($ocountry == "USA")
			{
			echo "<tr bgcolor='".$cname."'>
					<td>".$ed."&nbsp;</td>
					<td><a href=\"".htmlspecialchars($umes,ENT_QUOTES)."\" target='_blank'>".$uname."&nbsp;</td>
			         <td>".$oname."&nbsp;</td>
					  <td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$ord['Articul']."&nbsp;</a></td>
					  <td>".$ord['Data']."&nbsp;</td>
					  <td>".$ord['Cost_USD']."&nbsp;</td>
					  <td>".$ord['Ship_USD']."&nbsp;</td>
					  <td>".$ord['Discount']."&nbsp;</td>
					  <td>".$ord['Tax']."&nbsp;</td>					  
					  <td>".$ord['Org_USD']."&nbsp;</td>
					  <td>".$ord['Sum_USD']."&nbsp;</td>					  
					  <td>".$ord['Sum_RU']."&nbsp;</td>
					  <td>".$ord['Rate']."&nbsp;</td>
					  <td>".$ord['Status']."&nbsp;</td></tr>";			
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