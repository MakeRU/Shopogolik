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



$RateResult = mysql_query("SELECT * FROM `param`");	
$SelectRow = mysql_fetch_assoc($RateResult);
$parampack = $SelectRow['pack'];	

if (isset($_GET['pack']))
{
    $packno = $_GET['pack'];
}
$parampack = $packno;

if (empty($_POST))
{
?>	
	
<form action="newcont.php" method="post">
	<table>
			<tr>
			<td>������� �:</td>
			<td><input type="text" name="Pack" value=<?php echo $packno;?>></td>
		</tr>
		<tr>
			<td>�������� ������ �� ��������:</td>
<td><select name="Shop" size="1" >
<?php
$ShopResult = mysql_query("SELECT * FROM shop");
while($SelectRow = mysql_fetch_assoc($ShopResult))
{
$k = $SelectRow['id_shop'];
if ($k==$ordshop){$sel = " selected";} else {$sel="";};
$x = "<option value=".$k." ".$sel.">".$SelectRow['shop']."</option>";
echo $x;
}
?>			</td> 
		</tr>
		<tr>
			<td>��</td>
			<td><input type="date" name="Date" value=<?php echo date("Y-m-d",time());?> ></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="��������" /></td>
		</tr>
	</table>
</form>


<?php	
}
else
{
	$packno = (isset($_POST['Pack'])) ? mysql_real_escape_string($_POST['Pack']) : '';
	$packshop = (isset($_POST['Shop'])) ? mysql_real_escape_string($_POST['Shop']) : '';		
	$packdate = (isset($_POST['Date'])) ? mysql_real_escape_string($_POST['Date']) : '';	
	
	// echo $packshop;
	
    	$parampack = $packno;
	
	$st="�������";	
		$query = "SELECT * 
				FROM `order`
				WHERE `id_shop`='{$packshop}' AND 
						`Data`='{$packdate}' AND 
						`Status`='{$st}'";
		$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// ��� ��� ������ ���������� ��������� �����, ��������� ����
		while($ord = mysql_fetch_array($sql))
		{
		$query = "INSERT
					INTO `contpack`
					SET
						`id_pack`='{$parampack}',
						`id_ord`='{$ord['id_order']}'";
		$sql1 = mysql_query($query) or die(mysql_error());

		}
		$locat = "Location: package.php?pack=".$parampack;
		header($locat);
	}

}	

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
		          <td>�������</td>
				  <td>�������</td>
				  <td>����</td>
				  <td>����</td>
				  <td>�����</td>
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
			
			$loc = "<a href=ordtopack.php?no=".$ord['id_order']."&pack=".$parampack.">��������</a>";
			
			echo "<tr bgcolor='".$cname."'>
					<td>".$ord['id_order']."&nbsp;</td>
					<td><a href=\"".htmlspecialchars($umes,ENT_QUOTES)."\" target='_blank'>".$uname."&nbsp;</td>
			         <td>".$oname."&nbsp;</td>
					  <td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$ord['Articul']."&nbsp;</a></td>
					  <td>".$ord['Data']."&nbsp;</td>
					  <td>".$ord['Cost_USD']."&nbsp;</td>
					  <td>".$ord['Sum_USD']."&nbsp;</td>					  
					  <td>".$ord['Sum_RU']."&nbsp;</td>
					  <td>".$ord['Rate']."&nbsp;</td>
					  <td>".$ord['Status']."&nbsp;</td>
					  <td>".$loc."&nbsp;</td></tr>";			
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