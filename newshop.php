<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{
if (empty($_POST))
{

?>
	
<form action="newshop.php" method="post">
	<table>
		<tr>
			<td>�������:</td>
			<td><input type="text" name="Name"></td>
		</tr>
		<tr>
			<td>�����:</td>
			<td><input type="text" name="URL"></td>
		</tr>
		<tr>
			<td>����:</td>
			<td><input type="text" name="Color" value="345689"></td> 
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

	$shopname = (isset($_POST['Name'])) ? mysql_real_escape_string($_POST['Name']) : '';
	$shopurl = (isset($_POST['URL'])) ? mysql_real_escape_string($_POST['URL']) : '';
	$shopcol = (isset($_POST['Color'])) ? mysql_real_escape_string($_POST['Color']) : '';
	
	

	
	// ��������� �� ������� ������ (��������, ����� ������ � ������)
	
		
		$query = "INSERT
					INTO `shop`
					SET
						`shop`='{$shopname}',		
						`url`='{$shopurl}',					
						`col`='{$shopcol}'";
		$sql = mysql_query($query) or die(mysql_error());
	
		
		print '<h4>������� ��������</h4><a href="shop.php">��� ��������</a>';
	}
}
include "footer.php"; 
?>