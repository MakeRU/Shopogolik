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
	
include "menu.php";	

if (isset($_GET['no']))
{
    $ordno = $_GET['no'];
	$pack = $_GET['pack'];
	$country = $_GET['Country'];
	
	$query = "INSERT
				INTO `contpack`
				SET
					`id_pack`='{$pack}',
					`id_ord`='{$ordno}'";
	$sql1 = mysql_query($query) or die(mysql_error());

		
	$query = "UPDATE `order`
				SET
				`Status`='��������'
				WHERE `id_order`='{$ordno}'";
	$sqlord = mysql_query($query) or die(mysql_error());
	
}
	if ($country == 'Fr') $locat = "Location: newcontfr.php?pack=".$pack;
		else $locat = "Location: newcont.php?pack=".$pack;
	header($locat);	
	
}	


	
	

else
{
	die('������ ������, ��� ������ �� �����������. � <a href="login.php">��������������</a>');
}

	


include "footer.php"; 
?>