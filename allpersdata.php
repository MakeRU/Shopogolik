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

if (isset($_GET['user']))
{
    $userid = $_GET['user'];
}

if (isset($_GET['all_ord']))
{
    $all_ord = $_GET['all_ord'];
}
	
echo "<a href=allpersdata.php?user=".$userid."&all_ord=1>�������� ��� ������</a>";

		$query = "SELECT sum(Sum_RU)
				FROM `order`
				WHERE `id_user`='{$userid}'";
			$sqlm = mysql_query($query) or die(mysql_error());
			$summ = mysql_result($sqlm, 0); 
	
			$query = "SELECT sum(sum)
				FROM `userpack`
				WHERE `id_user`='{$userid}'";
			$sqlpm = mysql_query($query) or die(mysql_error());
			$sumpm = mysql_result($sqlpm, 0); 
	
			$acc='������������';	
			$query = "SELECT sum(Sum)
				FROM `payment`
				WHERE `id_user`='{$userid}' AND
				`Accept`='{$acc}'";
			$sqlp = mysql_query($query) or die(mysql_error());
			$sump = mysql_result($sqlp, 0); 
			
			$bal = $sump - $summ - $sumpm;
						
			if ($bal < 0) {$cname = "FA8072";};
			if ($bal >= 0) {$cname = "00BFFF";};
		
					
		$query = "SELECT * 
				FROM `users`
				WHERE `id` = '{$userid}'";
		$sql = mysql_query($query) or die(mysql_error());
		$prs = mysql_fetch_assoc($sql);
	
	echo "<p class='H2'><a href=\"".htmlspecialchars($prs['mes'],ENT_QUOTES)."\" target='_blank'>".$prs['login']."&nbsp;</a>
	 ������: ".$bal."</p>";

	if ($all_ord == 0)
	{ $dateshow = date("Y-m-d",time()-2160*60*60);
	
		$query = "SELECT * 
				FROM `payment`
				WHERE (`id_user`='{$userid}') AND (`Date` > '{$dateshow}')
				ORDER BY `Accept` ASC, `Date` DESC";
	$sql = mysql_query($query) or die(mysql_error());}

	if ($all_ord == 1)
	{ $query = "SELECT * 
				FROM `payment`
				WHERE (`id_user`='{$userid}') AND (`Date` > '{$dateshow}')
				ORDER BY `Accept` ASC";
	$sql = mysql_query($query) or die(mysql_error());}

	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table  border=1 align='center'>";
		echo "<tr><td>�����</td><td>����</td><td>�����</td><td>����</td><td>�������� �������</td><td>�����</td><td>�����������</td><td>�������������</td></tr>";
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
			
			echo "<tr><td>".$pay['id_pay']."&nbsp;</td>
				<td>".$pay['Date']."&nbsp;</td>
				<td>".$pay['Time']."&nbsp;</td>
				<td>".$bname."&nbsp;</td><td>".$uname."&nbsp;</td><td>".$pay['Sum']."&nbsp;</td><td>".$pay['Comment']."
			&nbsp;</td><td>".$pay['Accept']."&nbsp;</td></tr>";
		}
		echo "</table>";
	}
	
	
		$stat = "���������";
	$query = "SELECT * 
				FROM `package`
				WHERE `Status`='{$stat}' AND `Date_raz` > '{$dateshow}'
				ORDER BY `Date_raz` DESC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($pack = mysql_fetch_array($sql))
		{
			$query = "SELECT * 
				FROM `userpack`
				WHERE `id_pack`='{$pack['id_pack']}' AND `id_user`='{$userid}'";
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
				  <td>����</td>
				  <td>���� ($/EUR)</td>
				  <td>��������� (RUR)</td>
				  <td>������</td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($ordn = mysql_fetch_array($ordsql))
		{
			$ordno = $ordn['id_ord'];
			
			$query = "SELECT * 
				FROM `order`
				WHERE `id_order`='{$ordno}' AND
				`id_user`='{$userid}'";
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
					  <td>".$ord['Data']."&nbsp;</td>
					  <td>".$ord['Cost_USD']."&nbsp;</td>
					  <td>".$ord['Sum_RU']."&nbsp;</td>
					  <td>".$ord['Status']."&nbsp;</td></tr>";	
			}
		}
		echo "</table>";
		
		}
	}
	}

	}

    $st="�������";
	$query = "SELECT * 
				FROM `order`
				WHERE `Status` = '{$st}' AND `id_user` = {$userid}
				ORDER BY `Data` DESC, `id_shop` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=0>";
		echo "<tr><td>�����</td>
				<td>�������� �������</td>
		          <td>�������</td>
				  <td>�������</td>
				  <td>����</td>
				  <td>���� (USA)</td>
				  <td>�������� (USA)</td>
				  <td>������ �����</td>
				  <td>����� </td>
				  <td>���</td>
				  <td>����� (USA)</td>
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
//			if ($ocountry == "USA")
			{
			echo "<tr bgcolor='".$cname."'>
					<td>".$ord['id_order']."&nbsp;</td>
					<td><a href=\"".htmlspecialchars($umes,ENT_QUOTES)."\" target='_blank'>".$uname."&nbsp;</td>
			         <td>".$oname."&nbsp;</td>
					  <td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$ord['Articul']."&nbsp;</a></td>
					  <td>".$ord['Data']."&nbsp;</td>
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