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
//echo $rate;
//echo $paramshop;
	?>
	
	<h3>������� ������ ����� �������</h3>
	
<form action="newrazd.php" method="post">
	<table>
		<tr>
			<td>����:</td>
			<td><input type="date" name="Data" value=<?php echo date("Y-m-d",time());?> ></td>
		</tr>
		<tr>
			<td>�����:</td>
			<td><input type="text" name="Place" size="120"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="���������" ></td>
		</tr>		
	</table>
</form>


	
	<?php
	

}
else
{
	// ����������� ��������� ������ �������� mysql_real_escape_string ����� �������� � ������� ��
	
	$razddate = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
	$razdpl = (isset($_POST['Place'])) ? mysql_real_escape_string($_POST['Place']) : '';
	
	// ��������� �� ������� ������ (��������, ����� ������ � ������)
	
		
		$query = "INSERT
					INTO `razd`
					SET
						`date`='{$razddate}',					
						`place`='{$razdpl}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		
		print '<h4>������� ���������</h4><a href="allrazd.php">��� �������</a>';
	}
}
include "footer.php"; 
?>