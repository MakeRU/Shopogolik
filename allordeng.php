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

	print '<p><a href="newordeng.php">����� ����� ������</a></p>';
	
if (empty($_POST))
{
?>	
	
<form action="allordeng.php" method="post">
	<table>
		<tr>
			<td>������� ����� �</td>
			<td><input type="text" name="DelNum"></td>
			<td><input type="submit" value="�������" ></td>
		</tr>
		<tr>
			<td>������������� ����� �</td>
			<td><input type="text" name="EdNum"></td>
			<td><input type="submit" value="�������������" ></td>
		</tr>
	</table>
</form>


<?php	
}
else
{
	$delnum = (isset($_POST['DelNum'])) ? mysql_real_escape_string($_POST['DelNum']) : '';
    $ednum = (isset($_POST['EdNum'])) ? mysql_real_escape_string($_POST['EdNum']) : '';		
	
	if ($delnum > 1)
	{	$query = "DELETE FROM `order` 
				WHERE `id_order` = '{$delnum}'";
		$sql = mysql_query($query) or die(mysql_error());
		header('Location: allordgr.php');
	}	
	
	if ($ednum > 1)
	{
		$locat = "Location: editord.php?no=".$ednum;
		header($locat);
		exit;
	}

}	

/*    $payshop = 15;
	$query = "SELECT sum(Sum_RU)
				FROM `order`
				WHERE `id_shop`='{$payshop}'";
	$sql = mysql_query($query) or die(mysql_error());
	$sumord = mysql_result($sql, 0); 
	echo $sumord;
*/	

    $st="�������";
	$query = "SELECT * 
				FROM `order`
				WHERE `Status` = '{$st}'
				ORDER BY `Data` DESC, `id_shop` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=0>";
		echo "<tr><td>�����</td>
				<td>�������� �������</td>
				  <td>����</td>
		          <td>�������</td>
				  <td>��������</td>				  
				  <td>������������</td>
				  <td>�������</td>
				  <td>����</td>
				  <td>������</td>
				  <td>���-��</td>
				  <td>���� (&#8364)</td>
				  <td>�������� (&#8364)</td>
				  <td>������ �����</td>
				  <td>����� </td>
				  <td>���</td>
				  <td>����� (&#8364)</td>
				  <td>����� (���)</td>
				  <td>����</td>
				  <td>������</td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($ord = mysql_fetch_array($sql))
		{
			$query = "SELECT * 
				FROM `shop`
				WHERE `id_shop`='{$ord['id_shop']}'";
			$ordn = mysql_query($query) or die(mysql_error());
			$orn = mysql_fetch_assoc($ordn);
			$oname = $orn['shop'];
			$ocountry = $orn['Country'];			
//			echo $ocountry;
			
			$query = "SELECT `col` 
				FROM `shop`
				WHERE `id_shop`='{$ord['id_shop']}'";
			$ordc = mysql_query($query) or die(mysql_error());
			$orcn = mysql_fetch_assoc($ordc);
			$cname = $orcn['col'];
			
			$query = "SELECT * 
				FROM `users`
				WHERE `id`='{$ord['id_user']}'";
			$usn = mysql_query($query) or die(mysql_error());
			$us = mysql_fetch_assoc($usn);
			$uname = $us['login'];
			$umes = $us['mes'];
			
			$ed = "<a href=editord.php?no=".$ord['id_order'].">".$ord['id_order']."</a>";
			
			if ($ocountry == "England")
			{
			echo "<tr bgcolor='".$cname."'>
					<td>".$ed."&nbsp;</td>
					<td><a href=\"".htmlspecialchars($umes,ENT_QUOTES)."\" target='_blank'>".$uname."&nbsp;</td>
			         <td>".$oname."&nbsp;</td>
					  <td>".$ord['Data']."&nbsp;</td>					  
					  <td>".$ord['Description']."&nbsp;</td>	
					  <td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$ord['Articul']."&nbsp;</a></td>
					  <td>".$ord['Code']."&nbsp;</td>
					  <td>".$ord['Color']."&nbsp;</td>
					  <td>".$ord['Size']."&nbsp;</td>
					  <td>".$ord['Quantity']."&nbsp;</td>					  
					  <td>".$ord['Cost_USD']."&nbsp;</td>
					  <td>".$ord['Ship_USD']."&nbsp;</td>
					  <td>".$ord['Discount']."&nbsp;</td>
					  <td>".$ord['Tax']."&nbsp;</td>					  
					  <td>".$ord['Org_USD']."&nbsp;</td>
					  <td>".$ord['Sum_USD']."&nbsp;</td>					  
					  <td>".$ord['Sum_RU']."&nbsp;</td>
					  <td>".$ord['Rate']."&nbsp;</td>
					  <td>".$ord['Status']."&nbsp;</td></tr>";			
			}
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