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

	print '<p><a href="newrash.php">����� ������</a></p>';
	print '<p><a href="newtrans.php">����� �������</a></p>';
	
//	$actdate = new DateTime('09/17/2012');
 // echo 	$actdate;
	$query = "SELECT sum(sum_RU)
				FROM `rashod`
				WHERE `data` > '2012-09-16'";
	$sqlm = mysql_query($query) or die(mysql_error());
	$summ = mysql_result($sqlm, 0); 
	
	$query = "SELECT sum(summa)
				FROM `transfer`
				WHERE `date` > '2012-09-16'";
	$sqlp = mysql_query($query) or die(mysql_error());
	$sump = mysql_result($sqlp, 0); 
	
	print '<p class="H3" >����� ����� ��������: ' . $summ . ' ���.</p>';
	print '<p class="H3" >����� ����� ����������: ' . $sump . ' ���.</p>';	
	
	$bal = $sump - $summ;
	print '<p class="H3" >������: ' . $bal . ' ���.</p>';

	if (empty($_POST))
{
?>	
	
	<h3>��������� ������ �</h3>
	
<form action="rashod.php" method="post">
	<table>
		<tr>
			<td><input type="text" name="Num"></td>
			<td><input type="submit" value="���������" ></td>
		</tr>
	</table>
</form>
	
<?php	
}
else
{
	$rashnum = (isset($_POST['Num'])) ? mysql_real_escape_string($_POST['Num']) : '';
		
		$query = "UPDATE `rashod`
					SET
						`Stat`='���������'
					WHERE `id`='{$rashnum}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		header('Location: rashod.php');;
}
	
	echo "<h4 align='center'>�������</h4>";
	
//	$dateshow = date("Y-m-d",time()-360*60*60);
// WHERE `data` > '{$dateshow}'
	
	$query = "SELECT * 
				FROM `rashod`
				ORDER BY `data` DESC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=1 align='center'>";
		echo "<tr><td>�</td><td>����������</td><td>����</td><td>�������</td><td>�����</td>
		          <td>����� (USD)</td><td>����� (RU)</td><td>�������</td><td>������</td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($pay = mysql_fetch_array($sql))
		{
			$query = "SELECT `login` 
				FROM `users`
				WHERE `id`='{$pay['id_user']}'";
			$usrn = mysql_query($query) or die(mysql_error());
			$usn = mysql_fetch_assoc($usrn);
			$uname = $usn['login'];
			
			$query = "SELECT `shop` 
				FROM `shop`
				WHERE `id_shop`='{$pay['id_shop']}'";
			$ordn = mysql_query($query) or die(mysql_error());
			$orn = mysql_fetch_assoc($ordn);
			$sname = $orn['shop'];
			
			$ed = "<a href=editrash.php?rash=".$pay['id'].">".$pay['id']."</a>";
						
			echo "<tr><td>".$ed."&nbsp;</td>
					<td>".$uname."&nbsp;</td>
					<td>".$pay['data']."&nbsp;</td>
					<td>".$sname."&nbsp;</td>
					<td>".$pay['order']."&nbsp;</td>
					<td>".$pay['sum_USD']."&nbsp;</td>
					<td>".$pay['sum_RU']."&nbsp;</td>
					<td>".$pay['Profit']."&nbsp;</td>
					<td>".$pay['Stat']."&nbsp;</td>
					</tr>";
		}
		echo "</table>";
	}
	
	echo "<h4 align='center'>��������</h4>";	
	$query = "SELECT * 
				FROM `transfer`
				ORDER BY `date` DESC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=1 align='center'>";
		echo "<tr><td>�</td><td>����</td><td>����</td><td>�����</td>
		          <td>�����������</td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($pay = mysql_fetch_array($sql))
		{
			echo "<tr><td>".$pay['id']."&nbsp;</td>
					<td>".$pay['date']."&nbsp;</td>
					<td>".$pay['pers']."&nbsp;</td>
					<td>".$pay['summa']."&nbsp;</td>
					<td>".$pay['comment']."&nbsp;</td>
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