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
    $razdno = $_GET['no'];
}
	
if (empty($_POST))
{


$RazdResult = mysql_query("SELECT * FROM `razd` WHERE `id`='{$razdno}'");	
$SelectRow = mysql_fetch_assoc($RazdResult);
$razdid = $SelectRow['id'];
$razdplace = $SelectRow['place'];

?>
	
<form action="editrazd.php" method="post">
	<table>
		<tr>
			<td><input type="hidden" name="id" value="<?php echo $razdid;?>"></td>
		</tr>
		<tr>
			<td>�����:</td>
			<td><input type="text" name="Place" size="150" value="<?php echo $razdplace;?>"></td>
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

else
{
	// ����������� ��������� ������ �������� mysql_real_escape_string ����� �������� � ������� ��

	$razdid = (isset($_POST['id'])) ? mysql_real_escape_string($_POST['id']) : '';	
	$razdplace = (isset($_POST['Place'])) ? mysql_real_escape_string($_POST['Place']) : '';
	
		$query = "UPDATE `razd`
					SET
						`place`='{$razdplace}'
					WHERE `id`='{$razdid}'";
		$sql = mysql_query($query) or die(mysql_error());	
	
	
	 header('Location: allrazd.php');
	}

}
include "footer.php"; 
?>