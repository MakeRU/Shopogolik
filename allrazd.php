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
	print '<td><a href="newrazd.php">����� �������</a></td>';
	print '<td><a href="delrazduser.php">�������� � �������������</a></td>';
	print '<td><a href="closeallrazd.php">������� ���</a></td>';
	print '<td><a href="openallrcr.php">������� ��� ���</a></td>';
	echo "</tr></table>";	
	
	
	$query = "SELECT * 
				FROM `razd`
				ORDER BY `id`";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=1>";
		echo "<tr><td>�������</td>
				  <td>�����</td>
				  <td>���������</td>
				  <td></td>
				  <td></td>
				  <td></td>
				  </tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($razd = mysql_fetch_array($sql))
		{
			if ($razd['stat'] == "�������") 
			 { $cl = "7FFFD4"; $st = "<a href=closerazd.php?no=".$razd['id'].">�������</a>";}
			if ($razd['stat'] == "�������") 
			 { $cl = "CD5C5C"; $st = "<a href=openrazd.php?no=".$razd['id'].">�������</a>";}
			
			$ed = "<a href=editrazd.php?no=".$razd['id'].">��������</a>";
			$zr = "<a href=razdzero.php?no=".$razd['id'].">��������</a>";
			echo "<tr bgcolor='".$cl."'>
					<td>".$razd['id']."&nbsp;</td>
					<td>".$razd['place']."&nbsp;</td>
					<td>".$razd['stat']."&nbsp;</td>
					<td>".$st."&nbsp;</td>
					<td>".$ed."&nbsp;</td>
					<td>".$zr."&nbsp;</td>
				</tr>";			
		}
		echo "</table>";
	}
	

	print '<hr>';
	
	print '<p class="H1" >���</p>';		
	
	$rz_max = 51;
	$rz_min = 0;
	$query = "SELECT * 
				FROM `users` 
				WHERE `id_razd`>'{$rz_min}' AND `id_razd`<'{$rz_max}'
				ORDER BY `id_razd`, `login` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=1 align='center'>";
		echo "<tr><td>�������� �������</td><td>���</td><td>�������</td>
			<td>������� �������</td>
			<td>���</td>
			<td>������</td>
			<td></td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($prs = mysql_fetch_array($sql))
		{
			
			$query = "SELECT sum(Sum_RU)
				FROM `order`
				WHERE `id_user`='{$prs['id']}'";
			$sqlm = mysql_query($query) or die(mysql_error());
			$summ = mysql_result($sqlm, 0); 
	
			$query = "SELECT sum(sum)
				FROM `userpack`
				WHERE `id_user`='{$prs['id']}'";
			$sqlpm = mysql_query($query) or die(mysql_error());
			$sumpm = mysql_result($sqlpm, 0); 
	
			$acc='������������';	
			$query = "SELECT sum(Sum)
				FROM `payment`
				WHERE `id_user`='{$prs['id']}' AND
				`Accept`='{$acc}'";
			$sqlp = mysql_query($query) or die(mysql_error());
			$sump = mysql_result($sqlp, 0); 
			
			$bal = $sump - $summ - $sumpm;
						
			if ($bal < 0) {$cname = "FA8072";};
			if ($bal >= 0) {$cname = "00BFFF";};
			
			$query = "SELECT `place` 
				FROM `razd`
				WHERE `id`='{$prs['id_razd']}'";
			$rsn = mysql_query($query) or die(mysql_error());
			$rpl = mysql_fetch_assoc($rsn);
			$place = $rpl['place'];
			
			$loc = "<a href=allpersdata.php?user=".$prs['id'].">��������</a>";
			
			$code = $prs['Code'];
			 if (($code == '') && ($prs['id_razd'] > 50)) {$code = "<a href=addword.php?no=".$prs['id'].">������</a>";};
			
			echo "<tr bgcolor='".$cname."'>
					<td><a href=\"".htmlspecialchars($prs['mes'],ENT_QUOTES)."\" target='_blank'>".$prs['login']."&nbsp;</a></td>
					<td>".$prs['Name']."&nbsp</td>
					<td>".$prs['Tel']."&nbsp;</td>
					<td>".$place."</td>
					<td>".$code."</td>
					<td>".$bal."</td>
					<td>".$loc."</td></tr>";
		}
		echo "</table>";
	}

	print '<hr>';
	
	print '<p class="H1" >������� ������</p>';		
	
	$rz = 51;
	$query = "SELECT * 
				FROM `users` 
				WHERE `id_razd`='{$rz}'
				ORDER BY `id_razd`, `login` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=1 align='center'>";
		echo "<tr><td>�������� �������</td><td>���</td><td>�������</td>
			<td>������� �������</td>
			<td>���</td>
			<td>������</td>
			<td></td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($prs = mysql_fetch_array($sql))
		{
			
			$query = "SELECT sum(Sum_RU)
				FROM `order`
				WHERE `id_user`='{$prs['id']}'";
			$sqlm = mysql_query($query) or die(mysql_error());
			$summ = mysql_result($sqlm, 0); 
	
			$query = "SELECT sum(sum)
				FROM `userpack`
				WHERE `id_user`='{$prs['id']}'";
			$sqlpm = mysql_query($query) or die(mysql_error());
			$sumpm = mysql_result($sqlpm, 0); 
	
			$acc='������������';	
			$query = "SELECT sum(Sum)
				FROM `payment`
				WHERE `id_user`='{$prs['id']}' AND
				`Accept`='{$acc}'";
			$sqlp = mysql_query($query) or die(mysql_error());
			$sump = mysql_result($sqlp, 0); 
			
			$bal = $sump - $summ - $sumpm;
						
			if ($bal < 0) {$cname = "FA8072";};
			if ($bal >= 0) {$cname = "00BFFF";};
			
			$query = "SELECT `place` 
				FROM `razd`
				WHERE `id`='{$prs['id_razd']}'";
			$rsn = mysql_query($query) or die(mysql_error());
			$rpl = mysql_fetch_assoc($rsn);
			$place = $rpl['place'];
			
			$loc = "<a href=allpersdata.php?user=".$prs['id'].">��������</a>";
			
			$code = $prs['Code'];
			 if (($code == '') && ($prs['id_razd'] > 50)) {$code = "<a href=addword.php?no=".$prs['id'].">������</a>";};
			
			echo "<tr bgcolor='".$cname."'>
					<td><a href=\"".htmlspecialchars($prs['mes'],ENT_QUOTES)."\" target='_blank'>".$prs['login']."&nbsp;</a></td>
					<td>".$prs['Name']."&nbsp</td>
					<td>".$prs['Tel']."&nbsp;</td>
					<td>".$place."</td>
					<td>".$code."</td>
					<td>".$bal."</td>
					<td>".$loc."</td></tr>";
		}
		echo "</table>";
	}	
	
	print '<hr>';
	print '<p class="H1" >������� �����</p>';
	
	$rz = 53;
	$query = "SELECT * 
				FROM `users` 
				WHERE `id_razd`='{$rz}'
				ORDER BY `id_razd`, `login` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=1 align='center'>";
		echo "<tr><td>�������� �������</td><td>���</td><td>�������</td>
			<td>������� �������</td>
			<td>���</td>
			<td>������</td>
			<td></td></tr>";
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($prs = mysql_fetch_array($sql))
		{
			
			$query = "SELECT sum(Sum_RU)
				FROM `order`
				WHERE `id_user`='{$prs['id']}'";
			$sqlm = mysql_query($query) or die(mysql_error());
			$summ = mysql_result($sqlm, 0); 
	
			$query = "SELECT sum(sum)
				FROM `userpack`
				WHERE `id_user`='{$prs['id']}'";
			$sqlpm = mysql_query($query) or die(mysql_error());
			$sumpm = mysql_result($sqlpm, 0); 
	
			$acc='������������';	
			$query = "SELECT sum(Sum)
				FROM `payment`
				WHERE `id_user`='{$prs['id']}' AND
				`Accept`='{$acc}'";
			$sqlp = mysql_query($query) or die(mysql_error());
			$sump = mysql_result($sqlp, 0); 
			
			$bal = $sump - $summ - $sumpm;
						
			if ($bal < 0) {$cname = "FA8072";};
			if ($bal >= 0) {$cname = "00BFFF";};
			
			$query = "SELECT `place` 
				FROM `razd`
				WHERE `id`='{$prs['id_razd']}'";
			$rsn = mysql_query($query) or die(mysql_error());
			$rpl = mysql_fetch_assoc($rsn);
			$place = $rpl['place'];
			
			$loc = "<a href=allpersdata.php?user=".$prs['id'].">��������</a>";
			
			$code = $prs['Code'];
			 if (($code == '') && ($prs['id_razd'] > 50)) {$code = "<a href=addword.php?no=".$prs['id'].">������</a>";};
			
			echo "<tr bgcolor='".$cname."'>
					<td><a href=\"".htmlspecialchars($prs['mes'],ENT_QUOTES)."\" target='_blank'>".$prs['login']."&nbsp;</a></td>
					<td>".$prs['Name']."&nbsp</td>
					<td>".$prs['Tel']."&nbsp;</td>
					<td>".$place."</td>
					<td>".$code."</td>
					<td>".$bal."</td>
					<td>".$loc."</td></tr>";
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