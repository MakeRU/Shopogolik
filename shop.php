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

	print '<p><a href="newshop.php">����� �������</a></p>';
	
if (empty($_POST))
{
?>	
	
<form action="shop.php" method="post">
	<table>
		<tr>
			<td>������������� ������� �</td>
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
						`edshop`='{$ednum}'";
		$sql = mysql_query($query) or die(mysql_error());
		header('Location: editshop.php');
		exit;
	}

}	

	
	$query = "SELECT * 
				FROM `shop`
				ORDER BY `shop` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=0>";
		echo "<tr><td>�</td>
		          <td>�������</td>
				  <td>�����</td>
				  <td>����</td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($shop = mysql_fetch_array($sql))
		{
			$cname = $shop['col'];
			
			echo "<tr bgcolor='".$cname."'><td>".$shop['id_shop']."&nbsp;</td>
					<td>".$shop['shop']."&nbsp;</td>
					  <td><a href=\"".htmlspecialchars($shop['url'],ENT_QUOTES)."\" target='_blank'>".$shop['url']."&nbsp;</a></td>
					  <td>".$shop['col']."&nbsp;</td></tr>";			
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