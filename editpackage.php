<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{

if (isset($_GET['pack']))
{
    $packno = $_GET['pack'];
}
	
if (empty($_POST))
{


$PackResult = mysql_query("SELECT * FROM `package` WHERE `id_pack`='{$packno}'");	
$SelectRow = mysql_fetch_assoc($PackResult);
$packid = $SelectRow['id_pack'];
$packdate = $SelectRow['Date'];
$packweight = $SelectRow['Weight'];
$packrate = $SelectRow['Rate'];
$packcost = $SelectRow['Cost'];
$packcomm = $SelectRow['Comment'];
$packreciev = $SelectRow['Reciev'];

	?>
	
<form action="editpackage.php" method="post">
	<table>
		<tr>
			<td>№ посылки:</td>
			<td><input type="text" name="id" value="<?php echo $packid;?>"></td>
		</tr>
		<tr>
			<td>Дата:</td>
			<td><input type="date" name="Data" value=<?php echo $packdate;?> ></td>
		</tr>
		<tr>
			<td>Курс:</td>
			<td><input type="text" name="Rate" value=<?php echo $packrate;?>></td>
		</tr>
		<tr>
			<td>Цена за кг:</td>
			<td><input type="text" name="Cost" value=<?php echo $packcost;?>></td>
		</tr>		
		<tr>
			<td>На кого оформлена:</td>
			<td><input type="text" name="Reciev" size="120" value="<?php echo $packreciev;?>"></td>
		</tr>
		<tr>
			<td>Комментарий:</td>
			<td><input type="text" name="Comment" size="120" value="<?php echo $packcomm;?>"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Сохранить" ></td>
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

	$packid = (isset($_POST['id'])) ? mysql_real_escape_string($_POST['id']) : '';	
	$packdate = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
	$packrate = (isset($_POST['Rate'])) ? mysql_real_escape_string($_POST['Rate']) : '';
	$packcost = (isset($_POST['Cost'])) ? mysql_real_escape_string($_POST['Cost']) : '';	
	$packreciev = (isset($_POST['Reciev'])) ? mysql_real_escape_string($_POST['Reciev']) : '';
	$packcomm = (isset($_POST['Comment'])) ? mysql_real_escape_string($_POST['Comment']) : '';
	

		$query = "UPDATE `package`
					SET
						`Date`='{$packdate}',					
						`Cost`='{$packcost}',		
						`Rate`='{$packrate}',
						`Comment`='{$packcomm}',
						`Reciev`='{$packreciev}'
					WHERE `id_pack`='{$packid}'	";
		$sql = mysql_query($query) or die(mysql_error());	
		
	header('Location: allpack.php');
	}
}
include "footer.php"; 
?>