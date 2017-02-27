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

	print '<p><a href="newpay.php">Новый платеж</a></p>';
	
	print '<p class="H1" ><blink>Подтверждение платежа производится дин раз в сутки и может занять 3 рабочих банковских дня (суббота и воскресенье - выходные у банков)!!!</blink></p>';		
	print '<p class="H1" ><blink>Баланс пересчитается только после подтверждения платежа!!!</blink></p>';		
//	print '<p class="H1" ><blink>Подтверждение платежей проводится 1 раз в сутки!!!</blink></p>';		
	print '<p class="H1" ><blink>Пароль для РЦР запрашиваем в ЛС у SuperCharm после подтвеждения оплаты доставки!!!
	Идя в рцр за заказом напишите пароль на бумажке, я не всегда могу быть за компьютером, а на память все пароли не могу знать!!!</blink></p>';		

	$query = "SELECT * 
				FROM `payment`
				WHERE `id_user`='{$_SESSION['user_id']}'
				ORDER BY `Accept` ASC, `Date` DESC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// определяем таблицу и заголовок
		echo "<table border=1 align='center'>";
		echo "<tr><td>Дата</td><td>Банк</td><td>Сумма</td><td>Комментарий</td><td>Подтверждение</td></tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($pay = mysql_fetch_array($sql))
		{
			$query = "SELECT `bank` 
				FROM `bank`
				WHERE `id_bank`='{$pay['id_bank']}'";
			$bkn = mysql_query($query) or die(mysql_error());
			$bk = mysql_fetch_assoc($bkn);
			$bname = $bk['bank'];
			
			if ($pay['Accept'] == "Подтверждено") {$ed = "Подтверждено";}
			else {$ed = "<a href=editpaym.php?no=".$pay['id_pay'].">Изменить</a>";};
			
			echo "<tr><td>".$pay['Date']."&nbsp;</td><td>".$bname."
			&nbsp </td><td>".$pay['Sum']."&nbsp;</td><td>".$pay['Comment']."
			&nbsp;</td><td>".$ed."&nbsp;</td></tr>";
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