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

print '<p class="H1"> <big><big>�� ���� �� �����!!! </big></big></p>'; 	 
print '<hr>';

	$stat = "���������";
	$query = "SELECT * 
				FROM `package`
				WHERE `Status`='{$stat}'
				ORDER BY `Date_raz` DESC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($pack = mysql_fetch_array($sql))
		{
			$query = "SELECT * 
				FROM `userpack`
				WHERE `id_pack`='{$pack['id_pack']}' AND `id_user`='{$_SESSION['user_id']}'";
			$packsql = mysql_query($query) or die(mysql_error());
			$package = mysql_fetch_assoc($packsql);
			$ctp = mysql_num_rows($packsql);
			if ($ctp > 0) 
			{
			echo "<h4 align='center'>��� � ������� � ".$pack['id_pack']." (��������� ".$pack['Date_raz']."): ".$package['weight']."��. ��������: " 
				.$package['sum']." (� ��� ����� ������������: ".$package['addsum'].")</h4>";
		
			$query = "SELECT * 
				FROM `contpack`
				WHERE `id_pack`='{$pack['id_pack']}'";
			$ordsql = mysql_query($query) or die(mysql_error());
			if($ordsql)
			{
		// ���������� ������� � ���������

		echo "<table border=0 align='center'>";
		echo "<tr align='center'>
		          <td>�������</td>
				  <td>�������</td>
				  <td>��������� (���)</td>
				  <td>����</td>
				  <td>������</td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($ordn = mysql_fetch_array($ordsql))
		{
			$ordno = $ordn['id_ord'];
			
			$query = "SELECT * 
				FROM `order`
				WHERE `id_order`='{$ordno}' AND
				`id_user`='{$_SESSION['user_id']}'";
			$ordp = mysql_query($query) or die(mysql_error());
			$ord = mysql_fetch_assoc($ordp);
			$ct = mysql_num_rows($ordp);
			
			if ($ct > 0) 
			{
			
			$query = "SELECT `shop` 
				FROM `shop`
				WHERE `id_shop`='{$ord['id_shop']}'";
			$ordn = mysql_query($query) or die(mysql_error());
			$orn = mysql_fetch_assoc($ordn);
			$oname = $orn['shop'];
			
			$query = "SELECT `col` 
				FROM `shop`
				WHERE `id_shop`='{$ord['id_shop']}'";
			$ordc = mysql_query($query) or die(mysql_error());
			$orcn = mysql_fetch_assoc($ordc);
			$cname = $orcn['col'];
			
			
			echo "<tr bgcolor='".$cname."'>
			         <td>".$oname."&nbsp;</td>
					  <td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$ord['Articul']."&nbsp;</a></td>
					  <td>".$ord['Sum_RU']."&nbsp;</td>
					  <td>".$ord['Data']."&nbsp;</td>
					  <td>".$ord['Status']."&nbsp;</td></tr>";	
			}
		}
		echo "</table>";
		
		}
	}
	}

	
	
	
	}
	

}
else
{
	die('������ ������, ��� ������ �� �����������. � <a href="login.php">��������������</a>');
}



include "footer.php"; 

?>