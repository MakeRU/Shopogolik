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

if (isset($_GET['pack']))
{
	$parampack = $_GET['pack'];
	
		
		$query = "SELECT * 
				FROM `contpack`
				WHERE `id_pack`='{$parampack}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		if($sql)
		{
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($pack = mysql_fetch_array($sql))
		{
			//echo $gotnum;

			$ordno = $pack['id_ord'];
//			echo $ordno;
			
//				$query = "SELECT * 
//							FROM `order`
//							WHERE `id_order`='{$ordno}'";
//				$ordp = mysql_query($query) or die(mysql_error());
//				$ord = mysql_fetch_assoc($ordp);
				
//			if ($ord['Status'] == "�������")
			{
				//echo $ord['Status'];
			
				$query = "UPDATE `order`
					SET
						`Status`='��������'
					WHERE `id_order`='{$ordno}'";
				$sqlord = mysql_query($query) or die(mysql_error());
		
		
			}
		}
		}
		
	$locat = "Location: package.php?pack=".$parampack;
	header($locat);	
}	
}

	
	

else
{
	die('������ ������, ��� ������ �� �����������. � <a href="login.php">��������������</a>');
}

	


include "footer.php"; 
?>