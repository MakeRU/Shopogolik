<?php
include "header.php"; 


session_start();

include ('mysql.php');

if (isset($_SESSION['user_id']))
{
	// ���������� ���������� �� ������ ������.
	
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

	print '<h2>���������� ���������</h2>';
	print '<h3>��������</h3>';
	print '<p>���: 	������� ������ ����������</p>';
	//print '<p>����� ����� �����: 	408 17 810 0 44070411278</p>';
    print '<p>����� �����: 	4276440011756829</p>';	
	print '<p style="color:#ff0000">���������� �������: ���������� �����</p>';
	print '<hr>';
	print '<h3>��������</h3>';
	print '<p>���: 	�������� ����� �������������</p>';
	//print '<p>����� ����� �����: 	408 17 810 0 44070411278</p>';
    print '<p>����� �����: 	4276440010191481</p>';	
	print '<p style="color:#ff0000">���������� �������: ���������� �����</p>';
	print '<hr>';
	print '<h3>���������</h3>';
	print '<p>���: 	������� ������ ����������</p>';
	print '<p>����� �����: 	40817810208110019877</p>';
	print '<p>���: 	7789</p>';
	print '<p>���� ����������: 	��� ������-����</p>';
	print '<p>���: 	044525593</p>';
	print '<p>���. ����: 	30101810200000000593</p>';
	print '<p>��� �����: 	7728168971</p>';
	print '<p>��� �����: 	775001001</p>';
	print '<p style="color:#ff0000">���������� �������: ���������� �����</p>';
	

}
else
{
	die('������ ������, ��� ������ �� �����������. � <a href="login.php">��������������</a>');
}

include "footer.php"; 
?>