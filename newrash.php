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
	
<form action="newrash.php" method="post">
	<table>
		<tr>
			<td>����:</td>
			<td><input type="date" name="Data" value=<?php echo date("Y-m-d",time());?> /></td>
		</tr>
		<tr>
			<td>�������:</td>
			<td><select name="Shop" size="1" />
<?php
$ShopResult = mysql_query("SELECT * FROM shop");
while($SelectRow = mysql_fetch_assoc($ShopResult)){
echo "<option value={$SelectRow['id_shop']}>{$SelectRow['shop']}</option>";
}
?>			</td>
		</tr>
		<tr>
			<td>�����:</td>
			<td><input type="text" name="Order" /></td>
		</tr>
		<tr>
			<td>������� (USD):</td>
			<td><input type="text" name="SumUS" /></td>
		</tr>
		<tr>
			<td>������� (RU):</td>
			<td><input type="text" name="SumRU" /></td>
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
	$payshop = (isset($_POST['Shop'])) ? mysql_real_escape_string($_POST['Shop']) : '';
	$payord = (isset($_POST['Order'])) ? mysql_real_escape_string($_POST['Order']) : '';
	$paysumus = (isset($_POST['SumUS'])) ? mysql_real_escape_string($_POST['SumUS']) : '';
	$paysumru = (isset($_POST['SumRU'])) ? mysql_real_escape_string($_POST['SumRU']) : '';

	$query = "SELECT sum(Sum_RU)
				FROM `order`
				WHERE `id_shop`='{$payshop}' AND `Data`='{$paydate}'";
	$sql = mysql_query($query) or die(mysql_error());

	
	$sumord = mysql_result($sql, 0); 
	$payprofit = $sumord - $paysumru;
	
	// ��������� �� ������� ������ (��������, ����� ������ � ������)
	
		
		$query = "INSERT
					INTO `rashod`
					SET
						`id_user`='{$payuser}',
						`data`='{$paydate}',
						`id_shop`='{$payshop}',
						`order`='{$payord}',
						`sum_USD`='{$paysumus}',
						`sum_RU`='{$paysumru}',
						`Profit`='{$payprofit}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		
		print '<h4>������ ������</h4><a href="rashod.php">������</a>';
		header('Location: rashod.php');
	}
}

include "footer.php"; 
?>