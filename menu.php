<?php	
	$query = "SELECT sum(Sum_RU)
				FROM `order`
				WHERE `id_user`='{$_SESSION['user_id']}'";
	$sql = mysql_query($query) or die(mysql_error());
	$summ = mysql_result($sql, 0); 
			
	$query = "SELECT sum(sum)
				FROM `userpack`
				WHERE `id_user`='{$_SESSION['user_id']}'";
	$sqlpm = mysql_query($query) or die(mysql_error());
	$sumpm = mysql_result($sqlpm, 0); 
	
	$acc='������������';	
	$query = "SELECT sum(Sum)
				FROM `payment`
				WHERE `id_user`='{$_SESSION['user_id']}' AND 
				`Accept`='{$acc}'";
	$sql = mysql_query($query) or die(mysql_error());
	$sump = mysql_result($sql, 0); 
	
	$bal = $sump - $summ - $sumpm;
	
	$query = "SELECT *
				FROM `users`
				WHERE `id`='{$_SESSION['user_id']}'";
	$sql = mysql_query($query) or die(mysql_error());
	$idrazdq = mysql_fetch_assoc($sql);
	$idrazd = $idrazdq['id_razd'];
	
	$query = "SELECT *
				FROM `users`
				WHERE `id`='{$_SESSION['user_id']}'";
	$sql = mysql_query($query) or die(mysql_error());
	$idrazdq = mysql_fetch_assoc($sql);
	$idrazd = $idrazdq['id_razd'];
	$code = $idrazdq['Code'];
	

	print '<p class="H1" >������������, ' . $welcome . '.</p>';
    if($_SESSION['user_id'] > 1)
	 {
	 print '<p class="H1" >��� ������: ' . $bal . ' ���.</p>';	
	 }
	 
	print '<p class="H1" >��������! ��� ������ � �����, �������� ��� ���������� �������� - ���������� �����! ���� ������� ��-����, �� �� � ���� ������, � ������������ ������ �� ������!</p>';		
	
	if ($idrazd > 0) 
	 {
	 	$query = "SELECT *
				FROM `razd`
				WHERE `id`='{$idrazd}'";
	$sql = mysql_query($query) or die(mysql_error());
	$razdq = mysql_fetch_assoc($sql);
	$razd = $razdq['place'];
	print '<p class="H1" ><blink>�� �������� �� �������: ' . $razd . '</blink></p>';	
	if ($idrazd > 30) {print '<p class="H1" ><blink>���� ������� �����: ' . $code . '</blink></p>';	}
	}	
	 
	echo "<table align='center' border=0><tr>";	
	print '<td></td>';
	print '<td><a href="http://forum.sibmama.ru/viewtopic.php?t=1390159&start=0">���� ���� �� ������</a></td>';
	print '<td><a href="rules.php">�������</a></td>';
	print '<td><a href="news.php">�������</a></td>';
	print '<td><a href="person.php">������ ����������</a></td>';
	print '<td><a href="order.php">��� ������</a></td>';
	print '<td><a href="archorder.php">����� �������</a></td>';
	print '<td><a href="payment.php">��� �������</a></td>';
	print '<td><a href="pack.php">�������</a></td>';	
	print '<td><a href="razd.php">�������</a></td>';	
	print '<td><a href="bill.php">���������</a></td>';
	print '<td><a href="concurs.php">�������</a></td></tr>';
	if($_SESSION['user_id'] < 3) 
	{
		print '<tr><td><a href="allpers.php">��� ��������� �������</a></td>';	
		print '<td><a href="shop.php">��� ��������</a></td>';	
		print '<td><a href="allordusa.php">������ USA</a></td>';
		print '<td><a href="allordfr.php">������ France</a></td>';
	//	print '<td><a href="allordgr.php">������ Germany</a></td>';
		print '<td><a href="allordeng.php">������ England</a></td>';
		print '<td><a href="archord.php?year=15">����� �������</a></td>';
		print '<td><a href="allpay.php">��� �������</a></td>';
		print '<td><a href="allpack.php">��� �������</a></td>';	
		print '<td><a href="allrazd.php">��� �������</a></td>';			
		print '<td><a href="rashod.php">�������</a></td>';	
		print '<td><a href="register.php">�����������</a></td></tr>';	
	}
/*	if($_SESSION['user_id'] == 415) 
	{
		print '<tr><td></td>';	
		print '<td><a href="allordusa_415.php">������ USA</a></td>';
		print '<td><a href="allordfr_415.php">������ France</a></td>';
		print '<td><a href="allordgr_415.php">������ Germany</a></td>';
		print '<td><a href="archord_415.php">����� �������</a></td>';
		print '<td><a href="allpack_415.php">��� �������</a></td>';	
		print '<td><a href="allrazd.php">��� �������</a></td>';	
	}
*/	
	echo "</table>";
	print '<hr>';
?>	