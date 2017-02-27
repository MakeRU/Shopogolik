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

	print '<p><a href="newordeng.php">Новый заказ Англия</a></p>';
	
if (empty($_POST))
{
?>	
	
<form action="allordeng.php" method="post">
	<table>
		<tr>
			<td>Удалить ордер №</td>
			<td><input type="text" name="DelNum"></td>
			<td><input type="submit" value="Удалить" ></td>
		</tr>
		<tr>
			<td>Редактировать ордер №</td>
			<td><input type="text" name="EdNum"></td>
			<td><input type="submit" value="Редактировать" ></td>
		</tr>
	</table>
</form>


<?php	
}
else
{
	$delnum = (isset($_POST['DelNum'])) ? mysql_real_escape_string($_POST['DelNum']) : '';
    $ednum = (isset($_POST['EdNum'])) ? mysql_real_escape_string($_POST['EdNum']) : '';		
	
	if ($delnum > 1)
	{	$query = "DELETE FROM `order` 
				WHERE `id_order` = '{$delnum}'";
		$sql = mysql_query($query) or die(mysql_error());
		header('Location: allordgr.php');
	}	
	
	if ($ednum > 1)
	{
		$locat = "Location: editord.php?no=".$ednum;
		header($locat);
		exit;
	}

}	

/*    $payshop = 15;
	$query = "SELECT sum(Sum_RU)
				FROM `order`
				WHERE `id_shop`='{$payshop}'";
	$sql = mysql_query($query) or die(mysql_error());
	$sumord = mysql_result($sql, 0); 
	echo $sumord;
*/	

    $st="Заказан";
	$query = "SELECT * 
				FROM `order`
				WHERE `Status` = '{$st}'
				ORDER BY `Data` DESC, `id_shop` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// определяем таблицу и заголовок
		echo "<table border=0>";
		echo "<tr><td>Ордер</td>
				<td>Участник закупки</td>
				  <td>Дата</td>
		          <td>Магазин</td>
				  <td>Описание</td>				  
				  <td>Наименование</td>
				  <td>Артикул</td>
				  <td>Цвет</td>
				  <td>Размер</td>
				  <td>Кол-во</td>
				  <td>Цена (&#8364)</td>
				  <td>Доставка (&#8364)</td>
				  <td>Скидка сайта</td>
				  <td>Налог </td>
				  <td>Орг</td>
				  <td>Сумма (&#8364)</td>
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
			
			if ($ocountry == "England")
			{
			echo "<tr bgcolor='".$cname."'>
					<td>".$ed."&nbsp;</td>
					<td><a href=\"".htmlspecialchars($umes,ENT_QUOTES)."\" target='_blank'>".$uname."&nbsp;</td>
			         <td>".$oname."&nbsp;</td>
					  <td>".$ord['Data']."&nbsp;</td>					  
					  <td>".$ord['Description']."&nbsp;</td>	
					  <td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$ord['Articul']."&nbsp;</a></td>
					  <td>".$ord['Code']."&nbsp;</td>
					  <td>".$ord['Color']."&nbsp;</td>
					  <td>".$ord['Size']."&nbsp;</td>
					  <td>".$ord['Quantity']."&nbsp;</td>					  
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
else
{
	die('Доступ закрыт, даём ссылку на авторизацию. — <a href="login.php">Авторизоваться</a>');
}

	


include "footer.php"; 
?>