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



if (empty($_POST))
{

	?>
	
<form action="changerate.php" method="post">
	<table>
		<tr>
			<td>Дата:</td>
			<td><input type="date" name="Data" value="2016-07-29"></td>
		</tr>
		<tr>
			<td>Магазин:</td>
			<td><select name="Shop" size="1" >
<?php
$ShopResult = mysql_query("SELECT * FROM shop");
while($SelectRow = mysql_fetch_assoc($ShopResult)){
$k = $SelectRow['id_shop'];
$sel="";
if ($k==70) {$sel = " selected";};
$x = "<option value=".$k." ".$sel.">".$SelectRow['shop']."</option>";
echo $x;
}

?>			</td> 
		</tr>
		<tr>
			<td>Курс:</td>
			<td><input type="text" name="Rate" value="0.0"></td>
		</tr>
	<tr>
			<td></td>
			<td><input type="submit" value="Изменить курс" ></td>
		</tr>		
	</table>
</form>


	
	<?php
	
}
else
{
	// обрабатывае пришедшие данные функцией mysql_real_escape_string перед вставкой в таблицу БД
	
	$orddate = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
	$ordshop = (isset($_POST['Shop'])) ? mysql_real_escape_string($_POST['Shop']) : '';
	$ordrate = (isset($_POST['Rate'])) ? mysql_real_escape_string($_POST['Rate']) : '';


	$query = "SELECT * 
				FROM `order`
				WHERE `Data` = '{$orddate}' AND `id_shop` = {$ordshop}";
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
			  <td>Сумма (USA)</td>
			  <td>Сумма (руб)</td>
			  <td>Курс</td>
			  <td>Курс (новый)</td>
			  <td>Сумма (руб)</td>
			</tr>";
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
			
			$ordsum = 5*round($ord['Sum_USD']*$ordrate/5);
			$ordid1 = $ord['id_order'];

	
		$query1 = "UPDATE `order`
					SET
						`Sum_RU`='{$ordsum}',
						`Rate`='{$ordrate}'
					WHERE `id_order`='{$ordid1}'";
		$sql1 = mysql_query($query1) or die(mysql_error());			
			
//			if ($ocountry == "USA")
			{
			echo "<tr bgcolor='".$cname."'>
					<td>".$ord['id_order']."&nbsp;</td>
					<td><a href=\"".htmlspecialchars($umes,ENT_QUOTES)."\" target='_blank'>".$uname."&nbsp;</td>
			         <td>".$oname."&nbsp;</td>
					  <td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$ord['Articul']."&nbsp;</a></td>
					  <td>".$ord['Data']."&nbsp;</td>
					  <td>".$ord['Sum_USD']."&nbsp;</td>					  
					  <td>".$ord['Sum_RU']."&nbsp;</td>
					  <td>".$ord['Rate']."&nbsp;</td>
					  <td>".$ordrate."&nbsp;</td> 
					  <td>".$ordsum."&nbsp;</td>
				</tr>";			
			}
		}
		echo "</table>";
	}
	}
}
include "footer.php"; 
?>