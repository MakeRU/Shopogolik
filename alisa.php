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

print '<p class="H1">���������� �� ����� �� ����� �� �����_!</p>'; 
print '<p> ��� �� �����, ��� ���� ���������� ���� � ������ ������ ������ ��� � �������, �� ������� ��� ��� ����� ��������� ������� - </p>'; 
echo "<p align='center'><img src='Images/Vente1.jpg'></p>"; 
print '<p>��� ���, ��� ������ �������� �����, ����� ���� ������� ����. ��� ���� ��� ����, ����� ��� ������ ��������, ���� ���� ��� ��� - epuise (�.�. �����������)
�� ���� ��� ���� ��� ��� - </p>'; 
echo "<p align='center'><img src='Images/Vente2.jpg'></p>"; 
print '<p>���� ���� ������� ��� ������� ���, � ���� ������ �����-������ XXXXXS ��� ����� ������ ��������, ����� ������� - ��� �� ��������� ��������! �� �� ���!!!! �������, ����� � �������� �������� ��������� ������ ��������
����� ����� �� �������� �������� ������ ��� (���� �������������) ������, �������� �� ������ "�������� � �������", �������� ������� ����������� ������� "��������, ���������� �� ������ �� �������", </p>'; 
echo "<p align='center'><img src='Images/Vente3.jpg'></p>"; 
print '<p>�� �� �� � ���� ������ �� �������� ��������, ������ ������ �� ������ "�������� � �������" (�� ���� ������ �� ������ �����) �� ��������� ��������� �������, ��� � ���� ��� ����� ����� �������� </p>'; 
print '<p>�����������, � ��������, ��� �������� �������� � ���� ������� ������ "�������� � �������" �������� ��������� � ������ ��-����, �� ���� ������ ���, � �� �����. ��������������, ���� �������� �� ���� ������ ����� 5, 10, 15, ... ������� ����, - � � ���� ������ ������ ��� ������ � ����-�� � ���� �� ������� �������, �� ����������� 1000000% �� �������� � ���. ����� ����� ������. � �� ��� ��� ������������� ��������� ��� �� ���� ������������ ������ (��������������� ��� ������� ��������). ���� ������ �� �������� � ����� ������, � ����� �������� � ���. ������, � ��� ���� �������� ���, ������� ���� ����������� ����� � "���������", �.�. �������� ������� �� ����� �� ����-�� ������, � ����� ��� ������ ����� ��������� ������ ���������� � ����� ������. � ��� ���� �� ���� ������ �������, ... ���� ��-�, ���� ������� ������ ������, ���� ������� ����� �� �������� ������ - ���������� ��� ���, � ���� ����� ������� � ������� ����. � ��� ���� ������� ���������� ������ �������</p>';
print '<p> ��� ����� ������ ������������ �� ������� � �������
�������, ����� ���� ������� �������� � ���������
�������!!!! �����!!!! ����� � 12-00 �� ��� ������������ �� ����, ����� ������ � ������ ��� ��������� �������, (��� ����������� ������ ������ �������� ����) � �� � ���� ������ ��� ������� �� ��������� ������! � ������ �������� ������������� ������ � ������ �� ������ "�������� � �������" �� ��������� :-)
� ������ ��� ������� ������� 3 ���� ��������� ������� ������� ����� </p>' ;
print '<p> �.�. �������� ����, ��� ���� ��� � ��� �� ������ ��� 1 ��������� � ��� ����� ���-�� �����, �� ������ �� ������. �� ���� ����� ����� ������ ���, ��� ���� ����������-��������, ����������-��������, � �� ������ �� �������� �� �������... ��� ���� �������� - ��������� �������������� ������� :-)  </p>';  




}
else
{
	die('������ ������, ��� ������ �� �����������. � <a href="login.php">��������������</a>');
}

include "footer.php"; 
?>