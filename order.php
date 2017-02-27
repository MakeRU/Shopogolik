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

	
	
    $st="Заказан";
	$query = "SELECT * 
				FROM `order`
				WHERE `id_user`='{$_SESSION['user_id']}' AND `Status` = '{$st}'
				ORDER BY `Data` DESC, `id_shop` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// определяем таблицу и заголовок
		echo "<table border=0>";
		echo "<tr><td>Дата</td><td>Магазин</td><td>Артикул (при нажатии открывается картинки заказа для Ideeli, Bidz)</td>
				<td>Цена ($/&#8364)</td>
				<td>Скидка сайта (%)</td>
				<td>Налог (%)</td>
				<td>Орг (%)</td>
				<td>Доставка</td><td>Курс</td>
				<td>Сумма</td>
				<td></td></tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($ord = mysql_fetch_array($sql))
		{
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
			
			$articul =$ord['Description']." ".$ord['Articul']." ".$ord['Code']." ".$ord['Color']." ".$ord['Size']." ".$ord['Quantity']." ".$ord['Comment'];
			
			echo "<tr bgcolor='".$cname."'><td>".$ord['Data']."&nbsp;</td><td>".$oname."
			&nbsp </td>
			<td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$articul."&nbsp;</a></td>
			<td>".$ord['Cost_USD']."
			&nbsp;</td>
			<td>".$ord['Discount']."&nbsp;</td>
			<td>".$ord['Tax']."&nbsp;</td>
			<td>".$ord['Org_USD']."&nbsp;</td>
			<td>".$ord['Ship_USD']."&nbsp;</td>
			<td>".$ord['Rate']."&nbsp;</td>
			<td>".$ord['Sum_RU']."&nbsp;</td>
			<td>".$ord['Status']."&nbsp;</td>
			</tr>";
		}
		echo "</table>";
	}
	

}
else
{
	die('Доступ закрыт, даём ссылку на авторизацию. — <a href="login.php">Авторизоваться</a>');
}



include "footer.php"; 

?>