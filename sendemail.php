<?php

include "header.php"; 


session_start();

include ('mysql.php');

if (isset($_SESSION['user_id']))
{
	$query = "SELECT *
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





if (isset($_GET['pack']))
{
    $packno = $_GET['pack'];


//	mail("davydov.maxim@gmail.com", "Package", "Здравствуйте! \n Пришла посылка. \n Ваши заказы:", 
//		"From: shopogolik@shopogolik-life.ru \r\n"."X-Mailer: PHP/" . phpversion()); 	
	
	
//echo $pack; 
	
$parampack = $packno;	

	echo "<h4 align='center'>Рассылка сообщений по посылке № ".$parampack."</h4>";
		
	$query = "SELECT * 
				FROM `userpack`
				WHERE `id_pack`='{$parampack}'";
	$sql = mysql_query($query) or die(mysql_error());
	
	$num = 0;
	
	if($sql)
	{
		// определяем таблицу и заголовок

		echo "<table border=1 align='center'>";
		echo "<tr align='center'>
				<td></td>
				<td>Участник закупки</td>
		          <td>Письмо</td></tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($pack = mysql_fetch_array($sql))
		{
	
			$query = "SELECT * 
				FROM `users`
				WHERE `id`='{$pack['id_user']}'";
			$usn = mysql_query($query) or die(mysql_error());
			$us = mysql_fetch_assoc($usn);
			$uname = $us['login'];
			$umail = $us['Email'];
			
			if ($umail == "") {$send = "Не указан";}
			else 
				{
				$to = $umail;
				$headers = "From: Shopogolik <shopogolik.life@gmail.com> \r\n";
				$subject = "Посылка";  
				$message = "Здравствуйте, ".$uname."! \n Вы получили это сообщение, потому что вам пришла посылочка. \n 
Чтобы узнать что вам пришло, какие транспортные и где можно забрать заказ – вам необходимо зайти 
в свой личный кабинет на нашем сайте http://www.shopogolik-life.ru в разделы Посылки и Раздачи. \n \n 
Желаем вам, чтобы все подошло и ждем от вас хвастов. \n  \n
С уважением, Жанна и Олеся! \n \n ";
				$res = mail($to, $subject, $message, $headers); 
				if ($res) {$send = "Отправлено";} else {$send = "Ошибка";}
				}
		
//			sleep(1);
			
			$num = $num + 1;
			
			echo "<tr bgcolor='".$cname."'>
					<td>".$num."</td>
					<td><a href=\"".htmlspecialchars($umes,ENT_QUOTES)."\" target='_blank'>".$uname."&nbsp;</td>
			        <td>".$send."&nbsp;</td></td>
					</tr>";
		}
		echo "</table>";
	}
	

}	

}
else
{
	die('Доступ закрыт, даём ссылку на авторизацию. — <a href="login.php">Авторизоваться</a>');
}



include "footer.php"; 

?>