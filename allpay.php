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

	echo "<table align='center' border=0><tr>";
	print '<td><a href="newpaypers.php">����� ������</a></td>';
	echo "</tr></table>";	

	$dateshow = date("Y-m-d",time()-360*60*60);

	$query = "SELECT * 
				FROM `payment`
				WHERE (`Date` > '{$dateshow}') OR (`Accept` IS NULL)
				ORDER BY `Accept` ASC, `Date` DESC, `Sum` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table  border=1 align='center'>";
		echo "<tr><td>����</td><td>�����</td><td>����</td><td>�������� �������</td><td>�����</td>
			<td>�����������</td><td>�������������</td>
			<td></td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($pay = mysql_fetch_array($sql))
		{
			$query = "SELECT `bank` 
				FROM `bank`
				WHERE `id_bank`='{$pay['id_bank']}'";
			$bkn = mysql_query($query) or die(mysql_error());
			$bk = mysql_fetch_assoc($bkn);
			$bname = $bk['bank'];
			
			$query = "SELECT `login` 
				FROM `users`
				WHERE `id`='{$pay['id_user']}'";
			$usn = mysql_query($query) or die(mysql_error());
			$us = mysql_fetch_assoc($usn);
			$uname = $us['login'];
			
			$loc = "<a href=confirmpay.php?no=".$pay['id_pay'].">�����������</a>";
			if ($pay['Accept'] == "������������") {$loc = $pay['Accept'];};
			
			$ed = "<a href=editpay.php?no=".$pay['id_pay'].">�������������</a>";
			
			echo "<tr>
				<td>".$pay['Date']."&nbsp;</td>
				<td>".$pay['Time']."&nbsp;</td>
				<td>".$bname."&nbsp;</td>
				<td>".$uname."&nbsp;</td>
				<td>".$pay['Sum']."&nbsp;</td>
				<td>".$pay['Comment']."&nbsp;</td>
				<td>".$loc."&nbsp;</td>
				<td>".$ed."&nbsp;</td>
				</tr>";
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