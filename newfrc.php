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


	
if (empty($_POST))
{
?>	
	
	<h3>������� ������</h3>
	
<form action="newfrc.php" method="post">
	<table>
		<tr>
			<td>����:</td>
			<td><input type="date" name="Data" value=<?php echo date("Y-m-d",time());?> ></td>
		</tr>
		<tr>
			<td>�������:</td>
			<td><select name="Shop" size="1" >
<?php
$ShopResult = mysql_query("SELECT * FROM shop"); //  WHERE `Country` = 'France'");
while($SelectRow = mysql_fetch_assoc($ShopResult)){
$k = $SelectRow['id_shop'];
if ($k==$paramshop){$sel = " selected";} else {$sel="";};
$x = "<option value=".$k." ".$sel.">".$SelectRow['shop']."</option>";
echo $x;
//echo "<option value={$SelectRow['id_shop']}".($k==$userYear)?" selected":"".">{$SelectRow['shop']}</option>";
}
//$x .= "<option value='$k'".($k==$userYear)?" selected":"".">".$k."</option>";
?>			</td> 
		</tr>
		<tr>
			<td>�����:</td>
			<td><input type="text" name="order" size="120"></td>
		</tr>
		<tr>
			<td>�������:</td>
			<td><input type="text" name="track" size="120"></td>
		</tr>
		<tr>
			<td>������:</td>
			<td><input type="text" name="status" size="120"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="������" ></td>
		</tr>
	</table>
</form>


	
	<?php
}
else
{
	// ����������� ��������� ������ �������� mysql_real_escape_string ����� �������� � ������� ��
	
	$orddate = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
	$ordshop = (isset($_POST['Shop'])) ? mysql_real_escape_string($_POST['Shop']) : '';
	$ordtrack = (isset($_POST['track'])) ? mysql_real_escape_string($_POST['track']) : '';
	$ordord = (isset($_POST['order'])) ? mysql_real_escape_string($_POST['order']) : '';	
	$ordstat = (isset($_POST['status'])) ? mysql_real_escape_string($_POST['status']) : '';
	
		
		$query = "INSERT
					INTO `france`
					SET
						`date`='{$orddate}',					
						`id_shop`='{$ordshop}',					
						`order`='{$ordord}',		
						`track`='{$ordtrack}',					
						`status`='{$ordstat}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		header('Location: france.php');

}
}
else
{
	die('������ ������, ��� ������ �� �����������. � <a href="login.php">��������������</a>');
}

	


include "footer.php"; 
?>