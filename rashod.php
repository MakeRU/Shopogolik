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

	print '<p><a href="newrash.php">Новая оплата</a></p>';
	print '<p><a href="newtrans.php">Новый перевод</a></p>';
	
//	$actdate = new DateTime('09/17/2012');
 // echo 	$actdate;
	$query = "SELECT sum(sum_RU)
				FROM `rashod`
				WHERE `data` > '2012-09-16'";
	$sqlm = mysql_query($query) or die(mysql_error());
	$summ = mysql_result($sqlm, 0); 
	
	$query = "SELECT sum(summa)
				FROM `transfer`
				WHERE `date` > '2012-09-16'";
	$sqlp = mysql_query($query) or die(mysql_error());
	$sump = mysql_result($sqlp, 0); 
	
	print '<p class="H3" >Общая сумма списаний: ' . $summ . ' руб.</p>';
	print '<p class="H3" >Общая сумма пополнений: ' . $sump . ' руб.</p>';	
	
	$bal = $sump - $summ;
	print '<p class="H3" >Баланс: ' . $bal . ' руб.</p>';

	if (empty($_POST))
{
?>	
	
	<h3>Пополнить платеж №</h3>
	
<form action="rashod.php" method="post">
	<table>
		<tr>
			<td><input type="text" name="Num"></td>
			<td><input type="submit" value="Пополнить" ></td>
		</tr>
	</table>
</form>
	
<?php	
}
else
{
	$rashnum = (isset($_POST['Num'])) ? mysql_real_escape_string($_POST['Num']) : '';
		
		$query = "UPDATE `rashod`
					SET
						`Stat`='Пополнено'
					WHERE `id`='{$rashnum}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		header('Location: rashod.php');;
}
	
	echo "<h4 align='center'>Платежи</h4>";
	
//	$dateshow = date("Y-m-d",time()-360*60*60);
// WHERE `data` > '{$dateshow}'
	
	$query = "SELECT * 
				FROM `rashod`
				ORDER BY `data` DESC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// определяем таблицу и заголовок
		echo "<table border=1 align='center'>";
		echo "<tr><td>№</td><td>Плательщик</td><td>Дата</td><td>Магазин</td><td>Ордер</td>
		          <td>Сумма (USD)</td><td>Сумма (RU)</td><td>Прибыль</td><td>Статус</td></tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($pay = mysql_fetch_array($sql))
		{
			$query = "SELECT `login` 
				FROM `users`
				WHERE `id`='{$pay['id_user']}'";
			$usrn = mysql_query($query) or die(mysql_error());
			$usn = mysql_fetch_assoc($usrn);
			$uname = $usn['login'];
			
			$query = "SELECT `shop` 
				FROM `shop`
				WHERE `id_shop`='{$pay['id_shop']}'";
			$ordn = mysql_query($query) or die(mysql_error());
			$orn = mysql_fetch_assoc($ordn);
			$sname = $orn['shop'];
			
			$ed = "<a href=editrash.php?rash=".$pay['id'].">".$pay['id']."</a>";
						
			echo "<tr><td>".$ed."&nbsp;</td>
					<td>".$uname."&nbsp;</td>
					<td>".$pay['data']."&nbsp;</td>
					<td>".$sname."&nbsp;</td>
					<td>".$pay['order']."&nbsp;</td>
					<td>".$pay['sum_USD']."&nbsp;</td>
					<td>".$pay['sum_RU']."&nbsp;</td>
					<td>".$pay['Profit']."&nbsp;</td>
					<td>".$pay['Stat']."&nbsp;</td>
					</tr>";
		}
		echo "</table>";
	}
	
	echo "<h4 align='center'>Переводы</h4>";	
	$query = "SELECT * 
				FROM `transfer`
				ORDER BY `date` DESC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// определяем таблицу и заголовок
		echo "<table border=1 align='center'>";
		echo "<tr><td>№</td><td>Дата</td><td>Кому</td><td>Сумма</td>
		          <td>Комментарий</td></tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($pay = mysql_fetch_array($sql))
		{
			echo "<tr><td>".$pay['id']."&nbsp;</td>
					<td>".$pay['date']."&nbsp;</td>
					<td>".$pay['pers']."&nbsp;</td>
					<td>".$pay['summa']."&nbsp;</td>
					<td>".$pay['comment']."&nbsp;</td>
					</tr>";
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