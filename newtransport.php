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
$parampack = $SelectRow['pack'];
$rate = $SelectRow['rate'];	
//echo $rate;
//echo $paramshop;

if (isset($_GET['pack']))
{
    $packno = $_GET['pack'];
}
$parampack = $packno;

	print '<p><a href="package.php?pack='.$packno.'">��������� � �������</a></p>';

	?>
	
	<h3>������� �������������� �������</h3>
	
<form action="newtransport.php" method="post">
	<table>
			<tr>
			<td>������� �:</td>
			<td><input type="text" name="Pack" value=<?php echo $packno;?>></td>
		</tr>
		<tr>
			<td>�������� �������:</td>
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
			<td>��� ������� (���):</td>
			<td><input type="text" name="AddRU" value="0" ></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="������" ></td>
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
else
{
	// ����������� ��������� ������ �������� mysql_real_escape_string ����� �������� � ������� ��
	
	$packno = (isset($_POST['Pack'])) ? mysql_real_escape_string($_POST['Pack']) : '';	
	$wuser = (isset($_POST['User'])) ? mysql_real_escape_string($_POST['User']) : '';
	$wadd = (isset($_POST['AddRU'])) ? mysql_real_escape_string($_POST['AddRU']) : '';
	


	// ��������� �� ������� ������ (��������, ����� ������ � ������)

	$parampack = $packno;

	$query =mysql_query( "Select * FROM `userpack`
				WHERE `id_pack`='{$parampack}' AND `id_user`='{$wuser}'");
	$qweight = mysql_fetch_assoc($query);
	$wsum = $qweight['sum'];

	echo $wsum;
	$wsum = $wsum + $wadd;
	
	echo $wsum;
	
		$query = "UPDATE `userpack`
					SET
						`addsum`='{$wadd}',
						`sum`='{$wsum}'
					WHERE `id_pack`='{$parampack}' AND `id_user`='{$wuser}'";
		$sql = mysql_query($query) or die(mysql_error());
		
	$locat = "Location: newtransport.php?pack=".$parampack;
	header($locat);		
    
	}
}
include "footer.php"; 
?>