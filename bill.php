<?php
include "header.php"; 


session_start();

include ('mysql.php');

if (isset($_SESSION['user_id']))
{
	// показываем защищенные от гостей данные.
	
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

	print '<h2>Банковские реквизиты</h2>';
	print '<h3>Сбербанк</h3>';
	print '<p>ФИО: 	ДАВЫДОВ МАКСИМ НИКОЛАЕВИЧ</p>';
	//print '<p>Номер счета карты: 	408 17 810 0 44070411278</p>';
    print '<p>Номер карты: 	4276440011756829</p>';	
	print '<p style="color:#ff0000">Назначение платежа: пополнение счета</p>';
	print '<hr>';
	print '<h3>Сбербанк</h3>';
	print '<p>ФИО: 	ДАВЫДОВА ОЛЕСЯ АЛЕКСАНДРОВНА</p>';
	//print '<p>Номер счета карты: 	408 17 810 0 44070411278</p>';
    print '<p>Номер карты: 	4276440010191481</p>';	
	print '<p style="color:#ff0000">Назначение платежа: пополнение счета</p>';
	print '<hr>';
	print '<h3>Альфабанк</h3>';
	print '<p>ФИО: 	ДАВЫДОВ МАКСИМ НИКОЛАЕВИЧ</p>';
	print '<p>Номер счета: 	40817810208110019877</p>';
	print '<p>Код: 	7789</p>';
	print '<p>Банк получателя: 	ОАО «Альфа-Банк»</p>';
	print '<p>БИК: 	044525593</p>';
	print '<p>Кор. Счет: 	30101810200000000593</p>';
	print '<p>ИНН Банка: 	7728168971</p>';
	print '<p>КПП Банка: 	775001001</p>';
	print '<p style="color:#ff0000">Назначение платежа: пополнение счета</p>';
	

}
else
{
	die('Доступ закрыт, даём ссылку на авторизацию. — <a href="login.php">Авторизоваться</a>');
}

include "footer.php"; 
?>