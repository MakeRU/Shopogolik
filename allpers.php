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
	
//	print '<h1>������������, ' . $welcome . '.</h1>';

include "menu.php";	


// print '<p><a href="newuser.php">����� �������� �������</a></p>';
	
	$query = "SELECT * 
				FROM `users`
				ORDER BY `login` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ���������� ������� � ���������
		echo "<table border=1 align='center'>";
		echo "<tr><td>�������� �������</td><td>���</td><td>�������</td><td>E-mail</td>
			<td>�����</td><td>����� �������</td>
			<td>���</td>
			<td>������</td></tr>";
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
			
			$dateshow = date("Y-m-d",time()-72*60*60);
			
			$query = "SELECT *
				FROM `payment`
				WHERE `id_user`='{$prs['id']}' AND
				`Accept`='{$acc}' AND 
				`Date` > '{$dateshow}'";
			$countp = mysql_query($query) or die(mysql_error());
			$cp = mysql_num_rows($countp);
			
			
			if (($cp < 1) && ($bal < 0))
			{
			$cname = "EE00EE";
			};
			
			
			$query = "SELECT `place` 
				FROM `razd`
				WHERE `id`='{$prs['id_razd']}'";
			$rsn = mysql_query($query) or die(mysql_error());
			$rpl = mysql_fetch_assoc($rsn);
			$place = '*'.$rpl['place'].'*';
			if ($prs['id_razd'] == 0) {$place = $prs['Razd'];}
			
			if (strlen($prs['Name']) > 0)  
				{$loc = "<a href=allpersdata.php?user=".$prs['id'].">".$prs['Name']."</a>";}
				else
				{$loc = "<a href=allpersdata.php?user=".$prs['id'].">".$prs['Name']." -></a>";}
			
			echo "<tr bgcolor='".$cname."'>
					<td><a href=\"".htmlspecialchars($prs['mes'],ENT_QUOTES)."\" target='_blank'>".$prs['login']."&nbsp;</a></td>
					<td>".$loc."&nbsp</td>
					<td>".$prs['Tel']."&nbsp;</td>
					<td>".$prs['Email']."&nbsp;</td>
					<td>".$prs['Adress']."&nbsp;</td>
					<td>".$place."</td>
					<td>".$prs['Code']."</td>
					<td>".$bal."</td></tr>";
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