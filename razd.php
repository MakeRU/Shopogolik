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

// print '<p class="H1">��������!</p>'; 
// print '<p class="H1">������ �� ������� ������/����� ����� ������� ������� 12-��.</p>'; 
// print '<p class="H1">������� �������, 3.08. ���. ����� 89137128435, ���� 89529301151.</p>'; 

echo "<p align='center'><img src='Images/Gift.jpg'></p>";	



/*
print '<p class="H2">������ ���������� ��� ������</p>'; 
	
print '<p>��������� - ������� � ������� (���� � ������)<br>';
print '��������������� - ������� ����, ����� ������<br>';
print '��������� + �������� -  (���� � ������)<br>';
print '������� - ����� ������, ������� ����<br>';
print '�� ������ - ����� (���� � ������)<br>';
print '��� �������� + ��������� - ������� ����, ������� ������<br>';
print '���� - ������� ����, c���� ������<br>';
print '��� ��������� - � ����� ������, � ������� ����<br>';
print '�������� - � ������� (���� � ������) ����� �������! 10� (20� �������������)<br>';
print '�������������� - �� ������� ����, ����� ������)<br>';
print '������������� - �� ������� ����, ����� ������, ����� ����<br>';
print '���������� � ��� ����������� ������� - � ����� ���� � ������<br>';
print '��Ш��� - � �������, (���� � ������) ����� �������! 10� (20� �������������)<br>';
print '���������������� - � �������, ����� ��Ш. (���� � ������) ����� �������! 10� (20� �������������)<br>';
print '���� - �������� � �������, ����� ��Ш.(���� � ������) ����� �������! 10� (20� �������������)<br>';
print '�������� - � �������, ����� ��Ш.(���� � ������) ����� �������! 10� (20� �������������)<br>';
print '��������� - � �������, ����� ��Ш.(���� � ������) ����� �������! 10� (20� �������������)<br>';
print '���� �������������� �� ���� �����������. ������� �� �������� <br>';
print '���������� ����� �������� � <a href="http://forum.sibmama.ru/viewtopic.php?t=564628">���� ��� �������</a></p>';
*/

print '<hr>';	

$RateResult = mysql_query("SELECT * FROM `param`");	
$SelectRow = mysql_fetch_assoc($RateResult);
$date_rcr = $SelectRow['Date_rcr'];


print '<p class="H2"><big><big><big>��������! ������ ���� � ��� ����-logistics '.$date_rcr.'!!!</big></big></big></p>'; 
print '���������� � ������� ������ ����� �������� � <a href="http://forum.sibmama.ru/viewtopic.php?t=984316">���� ��� ����-logistics</a></p>';

print '<hr>';	


//	print '<p class="H2">�������� �����, ��� �� ������ �������� ��� �����</p>'; 
//	print '<p class="H2">��������� ��� ��� ����� �������� �������� ��������� ���� �������.</p>'; 

//	print '<p class="H2"><big><big><big>���� ���� ���������� �� Vente  ������� �� ����������.</big></big></big></p>'; 
//	print '<p class="H2"><big><big><big>�������� �� ���� ���������!</big></big></big></p>'; 
	
	print '<p class="H1">������ �� �������</p>'; 
	print '<p class="H2">(������� ����� �������� �������� �������)</p>'; 
// print '<p class="H1">��������!</p>'; 
 // print '<p class="H1">������ �� ������� ������ ����� ������� �����.</p>'; 	
	// print '<p class="H1">��������! ���������� � ����� � ������� ������� � ������ �������� ������� 6-�� ���!!!</p>'; 

	echo "<table border=1>";
	echo "<tr>
			<td>�����</td>
			<td></td>
		</tr>";
			
	$st = "�������";
	for ($i=51; $i<=55; $i++) 
	{
		$query = "SELECT * 
					FROM `razd`
					WHERE `stat`='{$st}' AND `id` = '{$i}'";
		$sql = mysql_query($query) or die(mysql_error());		
		$razd = mysql_fetch_assoc($sql);	
		
		if ($razd['id'] > 0)
		{
		$loc = "<a href=confirmrazd.php?no=".$razd['id'].">����������</a>";
		if ($idrazd == $razd['id']) {$loc = "";};
			
		echo "<tr>
				<td>".$razd['place']."&nbsp;</td>
				<td>".$loc."&nbsp;</td>
			</tr>";	
			}
	}
	
	echo "</table>";
	
	print '<p class="H1">������ � ��� ��� �������� </p>'; 
	
	echo "<table border=1>";
	echo "<tr>
			<td>�����</td>
			<td></td>
		</tr>";
			
	$st = "�������";
	for ($i=1; $i<=38; $i++) 
	{
		$query = "SELECT * 
					FROM `razd`
					WHERE `stat`='{$st}' AND `id` = '{$i}'";
		$sql = mysql_query($query) or die(mysql_error());		
		$razd = mysql_fetch_assoc($sql);	
		
		if ($razd['id'] > 0)
		{
		$loc = "<a href=confirmrazd.php?no=".$razd['id'].">����������</a>";
		if ($idrazd == $razd['id']) {$loc = "";};
			
		echo "<tr>
				<td>".$razd['place']."&nbsp;</td>
				<td>".$loc."&nbsp;</td>
			</tr>";	
			}
	}
	echo "</table>";	

	

}
else
{
	die('������ ������, ��� ������ �� �����������. � <a href="login.php">��������������</a>');
}

	


include "footer.php"; 
?>