<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{

if (isset($_GET['no']))
{
    $ordno = $_GET['no'];
	$ordstat = "������";
	$ordsru = 0;
	
	// ��������� �� ������� ������ (��������, ����� ������ � ������)
	
		
		$query = "UPDATE `order`
					SET
						`Sum_RU`='{$ordsru}',
						`Status`='{$ordstat}'
					WHERE `id_order`='{$ordno}'";
		$sql = mysql_query($query) or die(mysql_error());
	
		
		print '<h4>����� ��������</h4><a href="allordusa.php">��� ������ USA</a>';
		header('Location: allordusa.php');
}
}
include "footer.php"; 
?>