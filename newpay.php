<?php
include "header.php"; 


session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{
if (empty($_POST))
{
	?>
	
	<h3>������� ������ ������ �������</h3>
	
<form action="newpay.php" method="post">
	<table>
		<tr>
			<td>���� �������:</td>
			<td><input type="date" name="Data" value=<?php echo date("Y-m-d",time()+3*60*60);?> /></td>
		</tr>
		<tr>
			<td>����:</td>
			<td><select name="Bank" size="1" />
<?php
$BankResult = mysql_query("SELECT * FROM bank");
while($SelectRow = mysql_fetch_assoc($BankResult)){
echo "<option value={$SelectRow['id_bank']}>{$SelectRow['bank']}</option>";
}
?>			</td>
		</tr>
		<tr>
			<td>�����:</td>
			<td><input type="text" name="Sum" /></td>
		</tr>
		<tr>
			<td>������ ������� (� ��������� / � ��������� ��� / � �����:</td>
			<td><input type="text" name="Comment" size=100></td>
		</tr>
		<tr>
			<td>��� ��������� �� ��������� ����������� ������� �� ���� ��������� �����!!!</td>
			<td></td>
		</tr>
		<tr>
			<td>������� ���, �������� � ������ ����� �������, ��� ��� ���������!!!</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="���������" /></td>
		</tr>		
	</table>
</form>
	
	
	<?php
}
else
{




	// ����������� ��������� ������ �������� mysql_real_escape_string ����� �������� � ������� ��
	
	$payuser = (isset($_SESSION['user_id'])) ? mysql_real_escape_string($_SESSION['user_id']) : '';
	$paydate = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
 	$paytime = date("G:i",time()+3*60*60);
//	$paytime = (isset($_POST['Time'])) ? mysql_real_escape_string($_POST['Time']) : '';
	$paybank = (isset($_POST['Bank'])) ? mysql_real_escape_string($_POST['Bank']) : '';
	$paysum = (isset($_POST['Sum'])) ? mysql_real_escape_string($_POST['Sum']) : '';
	$paycom = (isset($_POST['Comment'])) ? mysql_real_escape_string($_POST['Comment']) : '';

	
	// ��������� �� ������� ������ (��������, ����� ������ � ������)
	
		
		$query = "INSERT
					INTO `payment`
					SET
						`id_user`='{$payuser}',
						`Date`='{$paydate}',
						`Time`='{$paytime}',
						`id_bank`='{$paybank}',
						`Sum`='{$paysum}',
						`Comment`='{$paycom}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		
		echo "<p align='center'><img src='Images/spasibo.jpg'></p>"; 
		print '<h4 align="center">������ ������</h4>';
//		print '<a href="payment.php">�������</a>';
	}
}

include "footer.php"; 
?>