<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{

	$query = "SELECT `login`
				FROM `users`
				WHERE `id`='{$_SESSION['user_id']}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	
	// ���� ���� ����� ������ � �������������
	// �� ����� ������� ��� ���� �� ����� �� �����.. =)
	// �� ���� ��� ����� ID, ������������� � ������, ����� �� ��� ������
	if (mysql_num_rows($sql) != 1)
	{
		header('Location: login.php?logout');
		exit;
	}
	
	$row = mysql_fetch_assoc($sql);
	
	$welcome = $row['login'];
	// ���������� ���������� �� ������ ������.
	
//	print '<h1>������������, ' . $welcome . '.</h1>';

include "menu.php";	

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
$paycomm = $SelectRow['Comment'];
$payacc = $SelectRow['Accept'];
$payuser = $SelectRow['id_user'];

if (($payacc <> "������������") && ($payuser == $_SESSION['user_id']))

{
	?>
	
<form action="editpaym.php" method="post">
	<table>
		<tr>
			<td><input type="hidden" name="id" value="<?php echo $payid;?>"></td>
		</tr>
		<tr>
			<td>����:</td>
			<td><input type="date" name="Data" value=<?php echo $paydate;?> ></td>
		</tr>
			<td>����:</td>
			<td><select name="Bank" size="1" />
<?php
$BankResult = mysql_query("SELECT * FROM bank");
while($SelectRow = mysql_fetch_assoc($BankResult)){
$k = $SelectRow['id_bank'];
if ($k==$paybank){$sel = " selected";} else {$sel="";};
$x = "<option value=".$k." ".$sel.">".$SelectRow['bank']."</option>";
echo $x;
}
?>			</td>
		<tr>
			<td>�����:</td>
			<td><input type="text" name="Sum" value="<?php echo $paysum;?>"></td>
		</tr>
		<tr>
			<td>�����������:</td>
			<td><input type="text" name="Comment" size="120" value="<?php echo $paycomm;?>"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="���������" ></td>
		</tr>		
	</table>
</form>


	
	<?php
	
//			<tr>
//			<td>����� (USD):</td>
//			<td><input type="text" name="Sum_USD" /></td>
//		</tr>
//				<tr>
//			<td>����� (���):</td>
//			<td><input type="text" name="Sum_RU" /></td>
//		</tr>
}
}
else
{
	// ����������� ��������� ������ �������� mysql_real_escape_string ����� �������� � ������� ��

	$payid = (isset($_POST['id'])) ? mysql_real_escape_string($_POST['id']) : '';	
	$paydate = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
	$paybank = (isset($_POST['Bank'])) ? mysql_real_escape_string($_POST['Bank']) : '';
	$paysum = (isset($_POST['Sum'])) ? mysql_real_escape_string($_POST['Sum']) : '';	
	$paycomm = (isset($_POST['Comment'])) ? mysql_real_escape_string($_POST['Comment']) : '';
	
//echo $paysum;

		$query = "UPDATE `payment`
					SET
						`Date`='{$paydate}',					
						`id_bank`='{$paybank}',		
						`Sum`='{$paysum}',
						`Comment`='{$paycomm}'
					WHERE `id_pay`='{$payid}'";
		$sql = mysql_query($query) or die(mysql_error());	
	
	
	 header('Location: payment.php');
	}

}
include "footer.php"; 
?>