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

	print '<p><a href="newpay.php">����� ������</a></p>';
	
	print '<p class="H1" ><blink>������������� ������� ������������ ��� ��� � ����� � ����� ������ 3 ������� ���������� ��� (������� � ����������� - �������� � ������)!!!</blink></p>';		
	print '<p class="H1" ><blink>������ ������������� ������ ����� ������������� �������!!!</blink></p>';		
//	print '<p class="H1" ><blink>������������� �������� ���������� 1 ��� � �����!!!</blink></p>';		
	print '<p class="H1" ><blink>������ ��� ��� ����������� � �� � SuperCharm ����� ������������ ������ ��������!!!
	��� � ��� �� ������� �������� ������ �� �������, � �� ������ ���� ���� �� �����������, � �� ������ ��� ������ �� ���� �����!!!</blink></p>';		

	$query = "SELECT * 
				FROM `payment`
				WHERE `id_user`='{$_SESSION['user_id']}'
				ORDER BY `Accept` ASC, `Date` DESC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=1 align='center'>";
		echo "<tr><td>����</td><td>����</td><td>�����</td><td>�����������</td><td>�������������</td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($pay = mysql_fetch_array($sql))
		{
			$query = "SELECT `bank` 
				FROM `bank`
				WHERE `id_bank`='{$pay['id_bank']}'";
			$bkn = mysql_query($query) or die(mysql_error());
			$bk = mysql_fetch_assoc($bkn);
			$bname = $bk['bank'];
			
			if ($pay['Accept'] == "������������") {$ed = "������������";}
			else {$ed = "<a href=editpaym.php?no=".$pay['id_pay'].">��������</a>";};
			
			echo "<tr><td>".$pay['Date']."&nbsp;</td><td>".$bname."
			&nbsp </td><td>".$pay['Sum']."&nbsp;</td><td>".$pay['Comment']."
			&nbsp;</td><td>".$ed."&nbsp;</td></tr>";
		}
		echo "</table>";
	}
	

}
else
{
	die('������ ������, ��� ������ �� �����������. � <a href="login.php">��������������</a>');
}



include "footer.php"; 

?>