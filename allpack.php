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
	
	echo "<table align='center' border=0><tr>";
	print '<td><a href="newpack.php">Новая посылка</a></td>';
	print '<td><a href="dbord.php">Проверка дублей</a></td>';
	echo "</tr></table>";

	$query = "SELECT * 
				FROM `package`
				ORDER BY `Status`, `Date_raz` DESC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// определяем таблицу и заголовок
		echo "<table border=1>";
		echo "<tr><td>№</td>
				<td>Дата</td>
				  <td>Цена (кг)</td>
				  <td>Стоимость (руб)</td>
				  <td>Курс</td>
				  <td>Статус</td>
				  <td>Дата разбора</td>
				  <td>Комментарий</td>
				  <td>На кого оформлена</td>
				  <td></td><td></td>
				  </tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($pack = mysql_fetch_array($sql))
		{
			$query = "SELECT sum(sum)
				FROM `userpack`
				WHERE `id_pack`='{$pack['id_pack']}'";
			$sqlsum = mysql_query($query) or die(mysql_error());
			$sumrus = mysql_result($sqlsum, 0); 
			
			$cname = '#F5F5F5';
			if ($pack['usr_razb'] == 415) {$cname = '#4682B4';};
			if ($pack['usr_razb'] == 2) {$cname = '#FFB90F';};
			
			$no = "<a href=package.php?pack=".$pack['id_pack'].">Показать</a>";
			$ed = "<a href=editpackage.php?pack=".$pack['id_pack'].">Редактировать</a>";
			echo "<tr bgcolor='".$cname."'>
					<td>".$pack['id_pack']."&nbsp;</td>
					<td>".$pack['Date']."&nbsp;</td>
					<td>".$pack['Cost']."&nbsp;</td>
					<td>".$sumrus."&nbsp;</td>
					<td>".$pack['Rate']."&nbsp;</td>
					<td>".$pack['Status']."&nbsp;</td>
					<td>".$pack['Date_raz']."&nbsp;</td>
					<td>".$pack['Comment']."&nbsp;</td>
					<td>".$pack['Reciev']."&nbsp;</td>
					<td>".$no."&nbsp;</td>
					<td>".$ed."&nbsp;</td>
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