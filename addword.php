<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{

if (isset($_GET['no']))
{
    $userno = $_GET['no'];
}


if (empty($_POST))
{

$UserResult = mysql_query("SELECT * FROM users WHERE `id` = '{$userno}'");
$SelectRow = mysql_fetch_assoc($UserResult);
$username = $SelectRow['login'];


	print '<p><a href="allrazd.php">��������� � �������</a></p>';

	?>
	
	<h3>������� ������� �����</h3>
	
<form action="addword.php" method="post">
	<table>
			<tr>
			<td><input type="hidden" name="id" value="<?php echo $userno;?>"></td>
		</tr>
		<tr>
			<td>�������� �������:</td>
			<td><?php echo $username;?></td>
		</tr>
		<tr>
			<td>�����:</td>
			<td><input type="text" name="Word"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="������" ></td>
		</tr>		
	</table>
</form>


	
	<?php
}
else
{
	// ����������� ��������� ������ �������� mysql_real_escape_string ����� �������� � ������� ��
	
	$userno = (isset($_POST['id'])) ? mysql_real_escape_string($_POST['id']) : '';	
	$word = (isset($_POST['Word'])) ? mysql_real_escape_string($_POST['Word']) : '';	

	// ��������� �� ������� ������ (��������, ����� ������ � ������)

	
		$query = "UPDATE `users`
					SET
						`Code`='{$word}'
					WHERE `id`='{$userno}'";
		$sql = mysql_query($query) or die(mysql_error());
		
	$locat = "Location: allrazd.php";
	header($locat);		
    
	}
}
include "footer.php"; 
?>