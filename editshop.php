<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{
if (empty($_POST))
{

$RateResult = mysql_query("SELECT * FROM `param`");	
$SelectRow = mysql_fetch_assoc($RateResult);
$paramshop = $SelectRow['edshop'];

echo $paramshop;

$shopResult = mysql_query("SELECT * FROM `shop` WHERE `id_shop`='{$paramshop}'");	
$SelectRow = mysql_fetch_assoc($shopResult);
$shopid = $SelectRow['id_shop'];
$shopname = $SelectRow['shop'];
$shopurl = $SelectRow['url'];
$shopcol = $SelectRow['col'];

	?>
	
<form action="editshop.php" method="post">
	<table>
		<tr>
			<td>№ магазина:</td>
			<td><input type="text" name="id" value="<?php echo $shopid;?>"></td>
		</tr>
		<tr>
			<td>Магазин:</td>
			<td><input type="text" name="Name" value="<?php echo $shopname;?>"></td>
		</tr>
		<tr>
			<td>Адрес:</td>
			<td><input type="text" name="URL" value="<?php echo $shopurl;?>"></td>
		</tr>
		<tr>
			<td>Цвет:</td>
			<td><input type="text" name="Color" value="<?php echo $shopcol;?>"></td> 
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

	$shopid = (isset($_POST['id'])) ? mysql_real_escape_string($_POST['id']) : '';	
	$shopname = (isset($_POST['Name'])) ? mysql_real_escape_string($_POST['Name']) : '';
	$shopurl = (isset($_POST['URL'])) ? mysql_real_escape_string($_POST['URL']) : '';
	$shopcol = (isset($_POST['Color'])) ? mysql_real_escape_string($_POST['Color']) : '';
	
	

	
	// проверяем на наличие ошибок (например, длина логина и пароля)
	
		
		$query = "UPDATE `shop`
					SET
						`shop`='{$shopname}',		
						`url`='{$shopurl}',					
						`col`='{$shopcol}'
					WHERE `id_shop`='{$shopid}'";
		$sql = mysql_query($query) or die(mysql_error());
	
		
		print '<h4>Магазин сохранен</h4><a href="shop.php">Все магазины</a>';
	}
}
include "footer.php"; 
?>