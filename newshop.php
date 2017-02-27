<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{
if (empty($_POST))
{

?>
	
<form action="newshop.php" method="post">
	<table>
		<tr>
			<td>Магазин:</td>
			<td><input type="text" name="Name"></td>
		</tr>
		<tr>
			<td>Адрес:</td>
			<td><input type="text" name="URL"></td>
		</tr>
		<tr>
			<td>Цвет:</td>
			<td><input type="text" name="Color" value="345689"></td> 
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Сохранить" ></td>
		</tr>		
	</table>
</form>


	
<?php
	
}
else
{
	// обрабатывае пришедшие данные функцией mysql_real_escape_string перед вставкой в таблицу БД

	$shopname = (isset($_POST['Name'])) ? mysql_real_escape_string($_POST['Name']) : '';
	$shopurl = (isset($_POST['URL'])) ? mysql_real_escape_string($_POST['URL']) : '';
	$shopcol = (isset($_POST['Color'])) ? mysql_real_escape_string($_POST['Color']) : '';
	
	

	
	// проверяем на наличие ошибок (например, длина логина и пароля)
	
		
		$query = "INSERT
					INTO `shop`
					SET
						`shop`='{$shopname}',		
						`url`='{$shopurl}',					
						`col`='{$shopcol}'";
		$sql = mysql_query($query) or die(mysql_error());
	
		
		print '<h4>Магазин сохранен</h4><a href="shop.php">Все магазины</a>';
	}
}
include "footer.php"; 
?>