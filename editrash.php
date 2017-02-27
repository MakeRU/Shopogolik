<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{

if (isset($_GET['rash']))
{
    $rashno = $_GET['rash'];
}
	
if (empty($_POST))
{


$RashResult = mysql_query("SELECT * FROM `rashod` WHERE `id`='{$rashno}'");	
$SelectRow = mysql_fetch_assoc($RashResult);
$rashid = $SelectRow['id'];
$rashidusr = $SelectRow['id_user'];
$rashdata = $SelectRow['data'];
$rashidshop = $SelectRow['id_shop'];
$rashord = $SelectRow['order'];
$rashUSD = $SelectRow['sum_USD'];
$rashRU = $SelectRow['sum_RU'];
$rashstat = $SelectRow['Stat']

	?>
	
<form action="editrash.php" method="post">
	<table>
		<tr>
			<td>№:</td>
			<td><input type="text" name="id" value="<?php echo $rashid;?>"></td>
		</tr>
		<tr>
			<td>Плательщик:</td>
			<td><select name="User" size="1" >
<?php
$UserResult = mysql_query("SELECT * FROM users ORDER BY `login` ASC");
while($SelectRow = mysql_fetch_assoc($UserResult)){
$k = $SelectRow['id'];
if ($k==$rashidusr){$sel = " selected";} else {$sel="";};
$x = "<option value=".$k." ".$sel.">".$SelectRow['login']."</option>";
echo $x;
//echo "<option value={$SelectRow['id']}>{$SelectRow['login']}</option>";
}
?>			</td>
		</tr>
		<tr>
			<td>Дата:</td>
			<td><input type="date" name="Data" value=<?php echo $rashdata;?> ></td>
		</tr>
		<tr>
			<td>Магазин:</td>
			<td><select name="Shop" size="1" >
<?php
$ShopResult = mysql_query("SELECT * FROM shop");
while($SelectRow = mysql_fetch_assoc($ShopResult)){
$k = $SelectRow['id_shop'];
if ($k==$rashidshop){$sel = " selected";} else {$sel="";};
$x = "<option value=".$k." ".$sel.">".$SelectRow['shop']."</option>";
echo $x;
}

?>			</td> 
		</tr>
		<tr>
			<td>Ордер:</td>
			<td><input type="text" name="Order" value="<?php echo $rashord;?>"></td>
		</tr>		
		<tr>
			<td>Сумма(руб):</td>
			<td><input type="text" name="SumRU" value="<?php echo $rashRU;?>"></td>
		</tr>
		<tr>
			<td>Сумма (USD):</td>
			<td><input type="text" name="SumUS" value="<?php echo $rashUSD;?>"></td>
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
	
	$rashid = (isset($_POST['id'])) ? mysql_real_escape_string($_POST['id']) : '';
	$rashuser = (isset($_POST['User'])) ? mysql_real_escape_string($_POST['User']) : '';
	$rashdata = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
	$rashshop = (isset($_POST['Shop'])) ? mysql_real_escape_string($_POST['Shop']) : '';
	$rashord = (isset($_POST['Order'])) ? mysql_real_escape_string($_POST['Order']) : '';
	$rashsumus = (isset($_POST['SumUS'])) ? mysql_real_escape_string($_POST['SumUS']) : '';
	$rashsumru = (isset($_POST['SumRU'])) ? mysql_real_escape_string($_POST['SumRU']) : '';
	
//	$query = "SELECT sum(Sum_RU)
//				FROM `order`
//				WHERE `id_shop`='{$rashshop}' AND `Data`='{$rashdata}'";
//	$sql = mysql_query($query) or die(mysql_error());

	
//	$sumord = mysql_result($sql, 0); 
//	$rashprofit = $sumord - $paysumru;

	//echo $rashord;
	
	echo $rashid;
	
	echo $rashuser;
	echo $rashdata;
	
	echo $rashshop;
	echo $rashord;
	
	echo $rashsumru;
	echo $rashsumus;
	

	
	
	$query = "UPDATE `rashod`
					SET
						`id_user`='{$rashuser}',
						`data`='{$rashdata}',
						`id_shop`='{$rashshop}',
						`order`='{$rashord}',
						`sum_USD`='{$rashsumus}',
						`sum_RU`='{$rashsumru}'
					WHERE `id`='{$rashid}'";
		$sql = mysql_query($query) or die(mysql_error());	
		
//	header('Location: rashod.php');
	}
}
include "footer.php"; 
?>