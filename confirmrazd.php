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
$razdstat = $SelectRow['stat'];


	if ($razdstat == "�������")
		{
		$query = "UPDATE `users`
					SET
						`id_razd`='{$razdno}'
					WHERE `id`='{$_SESSION['user_id']}'";
		$sql = mysql_query($query) or die(mysql_error());	
		}
	 header('Location: razd.php');
	}

}
include "footer.php"; 
?>