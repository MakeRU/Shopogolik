<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{
if (empty($_POST))
{


//echo $rate;
//echo $paramshop;

$pack = "WTF";
if (isset($_GET['pack']))
{
    $packno = $_GET['pack'];
	
	
}
$parampack = $packno;

$RateResult = mysql_query("SELECT * FROM `package` WHERE `id_pack`='{$parampack}'");	
$SelectRow = mysql_fetch_assoc($RateResult);
$rate = $SelectRow['Rate'];	
$cost = $SelectRow['Cost'];	

	print '<p><a href="package.php?pack='.$packno.'">Вернуться в посылку</a></p>';
	
	?>
	
	<h3>Введите вес заказа</h3>
	
<form action="newweight.php" method="post">
	<table>
		<tr>
			<td>Посылка №:</td>
			<td><input type="text" name="Pack" value=<?php echo $packno;?>></td>
		</tr>
		<tr>
			<td>Участник закупки:</td>
			<td><select name="User" size="1" >
<?php
$UserResult = mysql_query("SELECT * FROM users ORDER BY `login` ASC");
while($SelectRow = mysql_fetch_assoc($UserResult)){
$us = $SelectRow['id'];
	$query = "SELECT * 
				FROM `userpack`
				WHERE `id_pack`='{$packno}' AND
					  `id_user`='{$us}'";
	$coun = mysql_query($query) or die(mysql_error());
	$ct = mysql_num_rows($coun);
	if ($ct > 0) {
echo "<option value={$SelectRow['id']}>{$SelectRow['login']}</option>";
}
}
?>			</td>
		</tr>
		<tr>
			<td>Вес (гр):</td>
			<td><input type="text" name="Weight" ></td>
		</tr>
		<tr>
			<td>Цена за кг (USD):</td>
			<td><input type="text" name="Cost_USD" value=<?php echo $cost;?>></td>
		</tr>
		<tr>
			<td>Курс:</td>
			<td><input type="text" name="Rate" value=<?php echo $rate;?>></td>
		</tr>
		<tr>
			<td>Доп расходы (руб):</td>
			<td><input type="text" name="AddRU" value="0" ></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Внести вес" ></td>
		</tr>		
	</table>
</form>


	
	<?php
	
//			<tr>
//			<td>Сумма (USD):</td>
//			<td><input type="text" name="Sum_USD" /></td>
//		</tr>
//				<tr>
//			<td>Сумма (руб):</td>
//			<td><input type="text" name="Sum_RU" /></td>
//		</tr>
}
else
{
	// обрабатывае пришедшие данные функцией mysql_real_escape_string перед вставкой в таблицу БД
	
	$packno = (isset($_POST['Pack'])) ? mysql_real_escape_string($_POST['Pack']) : '';
	$wuser = (isset($_POST['User'])) ? mysql_real_escape_string($_POST['User']) : '';
	$weight = (isset($_POST['Weight'])) ? mysql_real_escape_string($_POST['Weight']) : '';
	$wcost = (isset($_POST['Cost_USD'])) ? mysql_real_escape_string($_POST['Cost_USD']) : '';
	$wadd = (isset($_POST['AddRU'])) ? mysql_real_escape_string($_POST['AddRU']) : '';
	$wrate = (isset($_POST['Rate'])) ? mysql_real_escape_string($_POST['Rate']) : '';
	
	$wsum = 5*round(($wcost *$wrate *$weight / 1000 + $wadd )/5);

	// проверяем на наличие ошибок (например, длина логина и пароля)


	$parampack = $packno;
//	echo "Номер посылки ".$packno;
	
		$query = "UPDATE `userpack`
					SET
						`weight`='{$weight}',
						`addsum`='{$wadd}',
						`sum`='{$wsum}'
					WHERE `id_pack`='{$parampack}' AND `id_user`='{$wuser}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		$locat = "Location: newweight.php?pack=".$parampack;
		header($locat);
	}
}
include "footer.php"; 
?>