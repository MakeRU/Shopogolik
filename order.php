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

	
	
    $st="�������";
	$query = "SELECT * 
				FROM `order`
				WHERE `id_user`='{$_SESSION['user_id']}' AND `Status` = '{$st}'
				ORDER BY `Data` DESC, `id_shop` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=0>";
		echo "<tr><td>����</td><td>�������</td><td>������� (��� ������� ����������� �������� ������ ��� Ideeli, Bidz)</td>
				<td>���� ($/&#8364)</td>
				<td>������ ����� (%)</td>
				<td>����� (%)</td>
				<td>��� (%)</td>
				<td>��������</td><td>����</td>
				<td>�����</td>
				<td></td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($ord = mysql_fetch_array($sql))
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
			
			$articul =$ord['Description']." ".$ord['Articul']." ".$ord['Code']." ".$ord['Color']." ".$ord['Size']." ".$ord['Quantity']." ".$ord['Comment'];
			
			echo "<tr bgcolor='".$cname."'><td>".$ord['Data']."&nbsp;</td><td>".$oname."
			&nbsp </td>
			<td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$articul."&nbsp;</a></td>
			<td>".$ord['Cost_USD']."
			&nbsp;</td>
			<td>".$ord['Discount']."&nbsp;</td>
			<td>".$ord['Tax']."&nbsp;</td>
			<td>".$ord['Org_USD']."&nbsp;</td>
			<td>".$ord['Ship_USD']."&nbsp;</td>
			<td>".$ord['Rate']."&nbsp;</td>
			<td>".$ord['Sum_RU']."&nbsp;</td>
			<td>".$ord['Status']."&nbsp;</td>
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