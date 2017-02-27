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
$paramedfrc = $SelectRow['edfrc'];

$FranceResult = mysql_query("SELECT * FROM `france` WHERE `id`='{$paramedfrc}'");	
$SelectRow = mysql_fetch_assoc($FranceResult);
$frcid = $SelectRow['id'];
$frcdate = $SelectRow['date'];
$frcshop = $SelectRow['id_shop'];
$frcord = $SelectRow['order'];
$frctrack = $SelectRow['track'];	
$frcstat = $SelectRow['status'];

	?>
	
<form action="editfrc.php" method="post">
	<table>
		<tr>
			<td>№:</td>
			<td><input type="text" name="id" value="<?php echo $frcid;?>"></td>
		</tr>
		<tr>
			<td>Дата:</td>
			<td><input type="date" name="Data" value=<?php echo $frcdate;?> ></td>
		</tr>
		<tr>
			<td>Магазин:</td>
			<td><select name="Shop" size="1" >
<?php
$ShopResult = mysql_query("SELECT * FROM shop");
while($SelectRow = mysql_fetch_assoc($ShopResult)){
$k = $SelectRow['id_shop'];
if ($k==$frcshop){$sel = " selected";} else {$sel="";};
$x = "<option value=".$k." ".$sel.">".$SelectRow['shop']."</option>";
echo $x;
}
?>			</td> 
		</tr>
		<tr>
			<td>Заказ:</td>
			<td><input type="text" name="order" size="120" value="<?php echo $frcord;?>"></td>
		</tr>
		<tr>
			<td>Трекинг:</td>
			<td><input type="text" name="track" size="120" value="<?php echo $frctrack;?>"></td>
		</tr>
		<tr>
			<td>Статус:</td>
			<td><input type="text" name="status" size="120" value="<?php echo $frcstat;?>"></td>
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

	$ordid = (isset($_POST['id'])) ? mysql_real_escape_string($_POST['id']) : '';
	$orddate = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
	$ordshop = (isset($_POST['Shop'])) ? mysql_real_escape_string($_POST['Shop']) : '';
	$ordtrack = (isset($_POST['track'])) ? mysql_real_escape_string($_POST['track']) : '';
	$ordord = (isset($_POST['order'])) ? mysql_real_escape_string($_POST['order']) : '';	
	$ordstat = (isset($_POST['status'])) ? mysql_real_escape_string($_POST['status']) : '';
	

		
		$query = "UPDATE `france`
					SET
						`date`='{$orddate}',					
						`id_shop`='{$ordshop}',					
						`order`='{$ordord}',		
						`track`='{$ordtrack}',					
						`status`='{$ordstat}'
					WHERE `id`='{$ordid}'";
		$sql = mysql_query($query) or die(mysql_error());

		
		header('Location: france.php');
	}
}
include "footer.php"; 
?>