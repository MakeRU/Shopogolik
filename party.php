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
	$partyno = $row['Concurs'];
	// ���������� ���������� �� ������ ������.

	
include "menu.php";	


print '<p class="H1" >��� �������� � ��������  8 ����.</p>';

echo  "<table border=0><tr> <td> <img  src='Images/Party1.jpg'> </td></tr></table>";
echo  "<p><img  src='Images/Party2.jpg'></p>";
echo  "<p><img  src='Images/Party3.jpg'></p>";
echo  "<p><img  src='Images/Party4.jpg'></p>";
echo  "<p><img src='Images/Party5.jpg'></p>";
echo  "<p><img  src='Images/Party6.jpg'></p>";
echo  "<p><img src='Images/Party7.jpg'></p>";
echo  "<p><img  src='Images/Party8.jpg'></p>";
echo  "<p><img src='Images/Party9.jpg'></p>";
echo  "<p><img src='Images/Party10.jpg'>";

print '<p class="H1" >����������� �������....</p>';	
}
else
{
	die('������ ������, ��� ������ �� �����������. � <a href="login.php">��������������</a>');
}

	


include "footer.php"; 
?>