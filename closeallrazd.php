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

	$query = "SELECT * 
				FROM `razd`";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		while($razd = mysql_fetch_array($sql))
		{
		$stat = "�������";
		
		$query = "UPDATE `razd`
					SET
						`stat`='{$stat}'
					WHERE `id`='{$razd['id']}'";
		$sqlrazd = mysql_query($query) or die(mysql_error());
		}
	}
	$locat = "Location: allrazd.php";
	header($locat);	
	
}	


	
	

else
{
	die('������ ������, ��� ������ �� �����������. � <a href="login.php">��������������</a>');
}

	


include "footer.php"; 
?>