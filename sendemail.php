<?php

include "header.php"; 


session_start();

include ('mysql.php');

if (isset($_SESSION['user_id']))
{
	$query = "SELECT *
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
    $packno = $_GET['pack'];


//	mail("davydov.maxim@gmail.com", "Package", "������������! \n ������ �������. \n ���� ������:", 
//		"From: shopogolik@shopogolik-life.ru \r\n"."X-Mailer: PHP/" . phpversion()); 	
	
	
//echo $pack; 
	
$parampack = $packno;	

	echo "<h4 align='center'>�������� ��������� �� ������� � ".$parampack."</h4>";
		
	$query = "SELECT * 
				FROM `userpack`
				WHERE `id_pack`='{$parampack}'";
	$sql = mysql_query($query) or die(mysql_error());
	
	$num = 0;
	
	if($sql)
	{
		// ���������� ������� � ���������

		echo "<table border=1 align='center'>";
		echo "<tr align='center'>
				<td></td>
				<td>�������� �������</td>
		          <td>������</td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($pack = mysql_fetch_array($sql))
		{
	
			$query = "SELECT * 
				FROM `users`
				WHERE `id`='{$pack['id_user']}'";
			$usn = mysql_query($query) or die(mysql_error());
			$us = mysql_fetch_assoc($usn);
			$uname = $us['login'];
			$umail = $us['Email'];
			
			if ($umail == "") {$send = "�� ������";}
			else 
				{
				$to = $umail;
				$headers = "From: Shopogolik <shopogolik.life@gmail.com> \r\n";
				$subject = "�������";  
				$message = "������������, ".$uname."! \n �� �������� ��� ���������, ������ ��� ��� ������ ���������. \n 
����� ������ ��� ��� ������, ����� ������������ � ��� ����� ������� ����� � ��� ���������� ����� 
� ���� ������ ������� �� ����� ����� http://www.shopogolik-life.ru � ������� ������� � �������. \n \n 
������ ���, ����� ��� ������� � ���� �� ��� �������. \n  \n
� ���������, ����� � �����! \n \n ";
				$res = mail($to, $subject, $message, $headers); 
				if ($res) {$send = "����������";} else {$send = "������";}
				}
		
//			sleep(1);
			
			$num = $num + 1;
			
			echo "<tr bgcolor='".$cname."'>
					<td>".$num."</td>
					<td><a href=\"".htmlspecialchars($umes,ENT_QUOTES)."\" target='_blank'>".$uname."&nbsp;</td>
			        <td>".$send."&nbsp;</td></td>
					</tr>";
		}
		echo "</table>";
	}
	

}	

}
else
{
	die('������ ������, ��� ������ �� �����������. � <a href="login.php">��������������</a>');
}



include "footer.php"; 

?>