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
$rate = $SelectRow['rate'];
$paramshop = $SelectRow['shop'];
$paramship = $SelectRow['ship'];
//echo $rate;
//echo $paramshop;
	?>
	
	<h3>Введите данные новой посылки</h3>
	
<form action="newpack.php" method="post">
	<table>
		<tr>
			<td>Дата:</td>
			<td><input type="date" name="Data" value=<?php echo date("Y-m-d",time());?> ></td>
		</tr>
		<tr>
			<td>Вес (кг):</td>
			<td><input type="text" name="Weight"></td>
		</tr>
		<tr>
			<td>Цена за кг. (USD):</td>
			<td><input type="text" name="Cost" value="23"></td>
		</tr>
		<tr>
			<td>Курс:</td>
			<td><input type="text" name="Rate" value=<?php echo $rate;?>></td>
		</tr>
		<tr>
			<td>На кого оформлена:</td>
			<td><input type="text" name="Reciev" ></td>
		</tr>
		<tr>
			<td>Комментарий:</td>
			<td><input type="text" name="Comm" size="120"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Добавить посылку" ></td>
		</tr>		
	</table>
</form>


	
	<?php
	
}
else
{
	// обрабатывае пришедшие данные функцией mysql_real_escape_string перед вставкой в таблицу БД
	
	$packdate = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
	$packweig = (isset($_POST['Weight'])) ? mysql_real_escape_string($_POST['Weight']) : '';
	$packcost = (isset($_POST['Cost'])) ? mysql_real_escape_string($_POST['Cost']) : '';
	$packrate = (isset($_POST['Rate'])) ? mysql_real_escape_string($_POST['Rate']) : '';
	$packcomm = (isset($_POST['Comm'])) ? mysql_real_escape_string($_POST['Comm']) : '';
	$packreciev = (isset($_POST['Reciev'])) ? mysql_real_escape_string($_POST['Reciev']) : '';
	$packst = "Отправлена";
	$packus = $packcost * $packweig;
	$packru = $packus * $packrate;
	
	// проверяем на наличие ошибок (например, длина логина и пароля)
	
		
		$query = "INSERT
					INTO `package`
					SET
						`Date`='{$packdate}',					
						`Weight`='{$packweig}',					
						`Cost`='{$packcost}',		
						`Sum_USD`='{$packus}',					
						`Sum_RU`='{$packru}',
						`Rate`='{$packrate}',
						`Comment`='{$packcomm}',
						 `Reciev`='{$packreciev}',
						`Status`='{$packst}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		
		print '<h4>Посылка добавлена</h4><a href="allpack.php">Посылки</a>';
	}
}
include "footer.php"; 
?>