<?php
include "header.php"; 


session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{
if (empty($_POST))
{
	?>
	
	<h3>Введите данные нового платежа</h3>
	
<form action="newpaypers.php" method="post">
	<table>
		<tr>
			<td>Дата платежа:</td>
			<td><input type="date" name="Data" value=<?php echo date("Y-m-d",time()+3*60*60);?> /></td>
		</tr>
		<tr>
			<td>Банк:</td>
			<td><select name="Bank" size="1" />
<?php
$BankResult = mysql_query("SELECT * FROM bank");
while($SelectRow = mysql_fetch_assoc($BankResult)){
echo "<option value={$SelectRow['id_bank']}>{$SelectRow['bank']}</option>";
}
?>			</td>
		</tr>
		<tr>
			<td>Участник закупки:</td>
			<td><select name="User" size="1" >
<?php
$UserResult = mysql_query("SELECT * FROM users ORDER BY `login` ASC");
while($SelectRow = mysql_fetch_assoc($UserResult)){
echo "<option value={$SelectRow['id']}>{$SelectRow['login']}</option>";
}
?>			</td>
		</tr>		
		<tr>
			<td>Сумма:</td>
			<td><input type="text" name="Sum" /></td>
		</tr>
		<tr>
			<td>Данные платежа (№ терминала / № транзакции / № отделения / карта / и т.д.):</td>
			<td><input type="text" name="Comment" size=100></td>
		</tr>
		<tr>
			<td>Статус:</td>
			<td><input type="text" name="Accept" size=100 value="Подтверждено"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Сохранить" /></td>
		</tr>		
	</table>
</form>
	
	
	<?php
}
else
{




	// обрабатывае пришедшие данные функцией mysql_real_escape_string перед вставкой в таблицу БД
	
	$payuser = (isset($_POST['User'])) ? mysql_real_escape_string($_POST['User']) : '';
	$paydate = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
 	$paytime = date("G:i",time()+3*60*60);
//	$paytime = (isset($_POST['Time'])) ? mysql_real_escape_string($_POST['Time']) : '';
	$paybank = (isset($_POST['Bank'])) ? mysql_real_escape_string($_POST['Bank']) : '';
	$paysum = (isset($_POST['Sum'])) ? mysql_real_escape_string($_POST['Sum']) : '';
	$paycom = (isset($_POST['Comment'])) ? mysql_real_escape_string($_POST['Comment']) : '';
	$payacc = (isset($_POST['Accept'])) ? mysql_real_escape_string($_POST['Accept']) : '';
	
	// проверяем на наличие ошибок (например, длина логина и пароля)
	
		
		$query = "INSERT
					INTO `payment`
					SET
						`id_user`='{$payuser}',
						`Date`='{$paydate}',
						`Time`='{$paytime}',
						`id_bank`='{$paybank}',
						`Sum`='{$paysum}',
						`Comment`='{$paycom}',
						`Accept`='{$payacc}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		header('Location: allpay.php');		
		

	}
}

include "footer.php"; 
?>