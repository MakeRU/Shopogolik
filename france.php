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

	print '<p><a href="newfrc.php">�����</a></p>';
	
if (empty($_POST))
{
?>	
	
<form action="france.php" method="post">
	<table>
		<tr>
			<td>������������� �</td>
			<td><input type="text" name="EdNum"></td>
			<td><input type="submit" value="�������������" ></td>
		</tr>
	</table>
</form>


<?php	
}
else
{
	$ednum = (isset($_POST['EdNum'])) ? mysql_real_escape_string($_POST['EdNum']) : '';		
	
	
	if ($ednum > 1)
	{
		$query = "UPDATE `param`
					SET
						`edfrc`='{$ednum}'";
		$sql = mysql_query($query) or die(mysql_error());
		header('Location: editfrc.php');
		exit;
	}

}	

	
	$query = "SELECT * 
				FROM `france`
				ORDER BY `date` DESC, `id_shop` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=0>";
		echo "<tr><td></td>
				  <td>����</td>
		          <td>�������</td>
				  <td>�����</td>
				  <td>�������</td>
				  <td>������</td>
				  </tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($frc = mysql_fetch_array($sql))
		{
			$query = "SELECT `shop` 
				FROM `shop`
				WHERE `id_shop`='{$frc['id_shop']}'";
			$ordn = mysql_query($query) or die(mysql_error());
			$orn = mysql_fetch_assoc($ordn);
			$oname = $orn['shop'];
			
			$query = "SELECT `col` 
				FROM `shop`
				WHERE `id_shop`='{$frc['id_shop']}'";
			$ordc = mysql_query($query) or die(mysql_error());
			$orcn = mysql_fetch_assoc($ordc);
			$cname = $orcn['col'];
			
			echo "<tr bgcolor='".$cname."'>
					<td>".$frc['id']."&nbsp;</td>
					<td>".$frc['date']."&nbsp;</td>			         
					<td>".$oname."&nbsp;</td>
					<td>".$frc['order']."&nbsp;</td>
					<td>".$frc['track']."&nbsp;</td>
					<td>".$frc['status']."&nbsp;</td></tr>";			
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