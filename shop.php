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

	print '<p><a href="newshop.php">Новый магазин</a></p>';
	
if (empty($_POST))
{
?>	
	
<form action="shop.php" method="post">
	<table>
		<tr>
			<td>Редактировать магазин №</td>
			<td><input type="text" name="EdNum"></td>
			<td><input type="submit" value="Редактировать" ></td>
		</tr>
	</table>
</form>


<?php	
}
else
{
    $ednum = (isset($_POST['EdNum'])) ? mysql_real_escape_string($_POST['EdNum']) : '';		
	
	if ($ednum > 1)
	{
		$query = "UPDATE `param`
					SET
						`edshop`='{$ednum}'";
		$sql = mysql_query($query) or die(mysql_error());
		header('Location: editshop.php');
		exit;
	}

}	

	
	$query = "SELECT * 
				FROM `shop`
				ORDER BY `shop` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// определяем таблицу и заголовок
		echo "<table border=0>";
		echo "<tr><td>№</td>
		          <td>Магазин</td>
				  <td>Адрес</td>
				  <td>Цвет</td></tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($shop = mysql_fetch_array($sql))
		{
			$cname = $shop['col'];
			
			echo "<tr bgcolor='".$cname."'><td>".$shop['id_shop']."&nbsp;</td>
					<td>".$shop['shop']."&nbsp;</td>
					  <td><a href=\"".htmlspecialchars($shop['url'],ENT_QUOTES)."\" target='_blank'>".$shop['url']."&nbsp;</a></td>
					  <td>".$shop['col']."&nbsp;</td></tr>";			
		}
		echo "</table>";
	}
	

}
else
{
	die('Доступ закрыт, даём ссылку на авторизацию. — <a href="login.php">Авторизоваться</a>');
}

	


include "footer.php"; 
?>