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

echo  "<img align='right' src='Images/buket.jpg'>";
print '<p class="H1" >I ����� - ��� (������.4713) ����: 1000 �.</p>';
print '<p class="H1" >II ����� - ����� (Nastenok) ����: 500 �.</p>';
print '<p class="H1" >III ����� - ���� (�������� ��������) ����: 300 �. (��� ������ � ����)</p>';

print '<hr>';
	

	$query = "SELECT `Concurs`
				FROM `users`
				WHERE `id`='{$_SESSION['user_id']}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($sql);
	$con = $row['Concurs'];

	

print '<p class="H1" >' . $res . '</p>';


print '<p class="H1" >��������� �1 - ��� (������.4713)</p>';

echo "<table align='center' border=0><tr><td>";
print '<p class="verse">� ����� ��� �� ����� ������, <br>
���� � ��� ���������� �������! <br>
� jannulya � super charm <br>
� ��� ��� ������� ���! </p>';

print '<p class="verse">��� - ��� ���� �����!  <br>
�� ������ ���� ���� - �������!!  <br>
���� ����, �� ������  <br>
��� ������� ��������. </p>';

print '<p class="verse">����� ����� �� �� ���  <br>
����� �������� ����!!! <br>
������ � ������ ��� ������,  <br>
����� ���� ��� ������! </p>';

print '<p class="verse">� ����� ������� ����  <br>
�� ������ ���, �����  <br>
� ������ �� ����� - � ����!!!  <br>
� ��������� -�����-����!!!!! </p>';
echo "</td><td><img align='right' src='Images/concurs1.jpg'></td></tr></table>";


print '<p class="H1" >��������� �2 - ���� (�������� ��������)</p>';

print '<p class="verse" align="center" >���� ���� �� ����� ������� ���������� ������� </p>';
print '<p class="verse" align="center">(� ������� � ���� ���� ��������) ���  </p>';
print '<p class="verse" align="center">���� ��� �������</p>';

echo "<table align='center' border=0><tr><td><img align='right' src='Images/concurs2.jpg'></td><td>";
print '<p class="verse">��� ������� ������? <br>
�� ������� - �������! <br>
� ���� � ���������-����� <br>
�������� �� ������ � ����! </p>';

print '<p class="verse">�������� ������ �� �����, <br>
�������� �������� �����. <br>
����� � ��������� ������ <br>
� ���� ������������� ����. <br>
��������� ������ ����, <br>
� ����� ������� ��� � �����! <br>
�� ��� ������ ��� �� �����! <br>
������ ������� �� ����� �������: <br>
������ � ���� ��������, �� ������, <br>
����� ��� ������ ����� ��������. <br>
� ��� �� ����, ���! �����! <br>
������� �� �������! </p>';

print '<p class="verse">����� �������� �����! <br>
��� �� ������� � � ��������: <br>
��������! ��� ����-���! <br>
��� �� �������, �� ���. <br>
���� ��������� � ����! <br>
���������! ��������! <br>
������ �����-�����������, <br>
�� ��� ��������� �������. <br>
� � �����, ��� ������� <br>
����� �������� ����������!� </p>';

print '<p class="verse">��, ������� ��� ����� <br>
������� �������� ����� . <br>
���� ����� ������ �������, <br>
������ ���������� � �������. <br>
���� ������� ��� �� ������, <br>
�� ������� ���� �������!</p>'; 
echo "</td></tr></table>";

print '<p class="H1" >��������� �3 - ����� (Nastenok)</p>';

echo "<table align='center' border=0><tr><td>";
print '<p class="verse">���������� �� ��� ���, <br>
�� ���������,��� ���    <br>
� ���� ������-�� ������,  <br>
�� � ���, ��� �������! </p>';

print '<p class="verse">� �������� � ��� ������,  <br>
��� �������� ������!  <br>
�����-����� ��� �������,  <br>
������� � ���� ����������! </p>';

print '<p class="verse">�� ����� ��� � �������� -  <br>
���������� �����!  <br>
� � ���� ������ ����,  <br>
����� � ������������ � ���� </p>';
echo "</td><td><img align='right' src='Images/concurs3.jpg'></td></tr></table>";
}
else
{
	die('������ ������, ��� ������ �� �����������. � <a href="login.php">��������������</a>');
}

	


include "footer.php"; 
?>