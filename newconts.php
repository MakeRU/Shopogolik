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
	
	// если нету такой записи с пользователем
	// ну вдруг удалили его пока он лазил по сайту.. =)
	// то надо ему убить ID, установленный в сессии, чтобы он был гостем
	if (mysql_num_rows($sql) != 1)
	{
		header('Location: login.php?logout');
		exit;
	}
	
	$row = mysql_fetch_assoc($sql);
	
	$welcome = $row['login'];
	// показываем защищенные от гостей данные.
	
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
	
<form action="newconts.php" method="post">
	<table>
			<tr>
			<td>ѕосылка є:</td>
			<td><input type="text" name="Pack" value=<?php echo $packno;?>></td>
		</tr>
		<tr>
			<td>ƒобавить заказы из магазина:</td>
<td><select name="Shop" size="1" >
<?php
$ShopResult = mysql_query("SELECT * FROM shop ORDER BY `shop`");
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
			<td>ќт</td>
			<td><input type="date" name="Date" value=<?php echo date("Y-m-d",time());?> ></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="ƒобавить" /></td>
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
	
	$st="«аказан";	
		$query = "SELECT * 
				FROM `order`
				WHERE `id_shop`='{$packshop}' AND 
						`Data`='{$packdate}' AND 
						`Status`='{$st}'";
		$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// так как запрос возвращает несколько строк, примен€ем цикл
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




}
else
{
	die('ƒоступ закрыт, даЄм ссылку на авторизацию. Ч <a href="login.php">јвторизоватьс€</a>');
}



include "footer.php"; 

?>