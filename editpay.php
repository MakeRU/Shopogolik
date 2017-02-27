<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{

if (isset($_GET['no']))
{
    $payno = $_GET['no'];
}
	
if (empty($_POST))
{


$PayResult = mysql_query("SELECT * FROM `payment` WHERE `id_pay`='{$payno}'");	
$SelectRow = mysql_fetch_assoc($PayResult);
$payid = $SelectRow['id_pay'];
$paydate = $SelectRow['Date'];
$paybank = $SelectRow['id_bank'];
$paysum = $SelectRow['Sum'];
$payuser = $SelectRow['id_user'];
$paycomm = $SelectRow['Comment'];
$payaccept = $SelectRow['Accept'];

	print '<a href="delpay.php?no='.$payid.'">Удалить платеж</a>';

	?>
	
<form action="editpay.php" method="post">
	<table>
		<tr>
			<td>№ платежа:</td>
			<td><input type="text" name="id" value="<?php echo $payid;?>"></td>
		</tr>
		<tr>
			<td>Дата:</td>
			<td><input type="date" name="Data" value=<?php echo $paydate;?> ></td>
		</tr>
		<tr>
			<td>УЗ:</td>
			<td><select name="User" size="1" />
			<?php 
			$UserResult = mysql_query("SELECT * FROM users ORDER BY `login` ASC");
			while($SelectRow = mysql_fetch_assoc($UserResult)){
				$k = $SelectRow['id'];
				if ($k==$payuser){$sel = " selected";} else {$sel="";};
				$x = "<option value=".$k." ".$sel.">".$SelectRow['login']."</option>";
				echo $x;
				}
			?>></td>
		</tr>
		<tr>
			<td>Банк:</td>
			<td><select name="Bank" size="1" />
			<?php 
			$BankResult = mysql_query("SELECT * FROM bank ORDER BY `id_bank` ");
			while($SelectRow = mysql_fetch_assoc($BankResult)){
				$k = $SelectRow['id_bank'];
				if ($k==$paybank){$sel = " selected";} else {$sel="";};
				$x = "<option value=".$k." ".$sel.">".$SelectRow['bank']."</option>";
				echo $x;} ?>></td>
		</tr>		
		<tr>
			<td>Сумма:</td>
			<td><input type="text" name="Sum" size="120" value="<?php echo $paysum;?>"></td>
		</tr>
		<tr>
			<td>Комментарий:</td>
			<td><input type="text" name="Comment" size="120" value="<?php echo $paycomm;?>"></td>
		</tr>
		<tr>
			<td>Подтверждение:</td>
			<td><input type="text" name="Accept" size="120" value="<?php echo $payaccept;?>"></td>
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

	$payid = (isset($_POST['id'])) ? mysql_real_escape_string($_POST['id']) : '';	
	$paydate = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
	$payuser = (isset($_POST['User'])) ? mysql_real_escape_string($_POST['User']) : '';
	$paybank = (isset($_POST['Bank'])) ? mysql_real_escape_string($_POST['Bank']) : '';	
	$paysum = (isset($_POST['Sum'])) ? mysql_real_escape_string($_POST['Sum']) : '';
	$paycomm = (isset($_POST['Comment'])) ? mysql_real_escape_string($_POST['Comment']) : '';
	$payaccept = (isset($_POST['Accept'])) ? mysql_real_escape_string($_POST['Accept']) : '';
	

		$query = "UPDATE `payment`
					SET
						`Date`='{$paydate}',					
						`id_user`='{$payuser}',		
						`id_bank`='{$paybank}',
						`Comment`='{$paycomm}',
						`Sum`='{$paysum}',
						`Accept`='{$payaccept}'
					WHERE `id_pay`='{$payid}'";
		$sql = mysql_query($query) or die(mysql_error());	
		
	header('Location: allpay.php');
	}
}
include "footer.php"; 
?>