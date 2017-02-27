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

// print '<p class="H1">Внимание!</p>'; 
// print '<p class="H1">Запись на раздачу академ/город будет открыта вечером 12-го.</p>'; 
// print '<p class="H1">Раздача сегодня, 3.08. Тел. Жанна 89137128435, Дима 89529301151.</p>'; 

echo "<p align='center'><img src='Images/Gift.jpg'></p>";	



/*
print '<p class="H2">График перебросов РЦР Академ</p>'; 
	
print '<p>РЦРРечной - вторник и пятница (туда и оттуда)<br>';
print 'РЦРЗаельцовский - вторник туда, среда оттуда<br>';
print 'РЦРМаркса + МЕЖГОРОД -  (туда и оттуда)<br>';
print 'РЦРНива - среда оттуда, четверг туда<br>';
print 'ЦР Бердск - среда (туда и оттуда)<br>';
print 'РЦР Калинина + РЦРВокзал - вторник туда, четверг оттуда<br>';
print 'ПИРР - вторник туда, cреда оттуда<br>';
print 'РЦР ЗАТУЛИНКА - в среду оттуда, в четверг туда<br>';
print 'РЦРЦентр - в четверг (туда и оттуда) Через изъятие! 10р (20р крупногабарит)<br>';
print 'РЦРУчительская - во вторник туда, среда оттуда)<br>';
print 'РЦРПервомайка - во вторник туда, среда оттуда, через РЦРУ<br>';
print 'РЦРГорский и РЦР Новосибирск Главный - в среду туда и оттуда<br>';
print 'РЦРЁлка - в пятницу, (туда и оттуда) Через изъятие! 10р (20р крупногабарит)<br>';
print 'РЦРСтаниславский - в пятницу, через РЦРЁ. (туда и оттуда) Через изъятие! 10р (20р крупногабарит)<br>';
print 'РЦРО - Кольцово в пятницу, через РЦРЁ.(туда и оттуда) Через изъятие! 10р (20р крупногабарит)<br>';
print 'РЦРВолна - в пятницу, через РЦРЁ.(туда и оттуда) Через изъятие! 10р (20р крупногабарит)<br>';
print 'РЦРДобрый - в пятницу, через РЦРЁ.(туда и оттуда) Через изъятие! 10р (20р крупногабарит)<br>';
print 'РЦРЩ осуществляется по мере возможности. Следите за списками <br>';
print 'Информацию можно уточнить в <a href="http://forum.sibmama.ru/viewtopic.php?t=564628">теме РЦР Академа</a></p>';
*/

print '<hr>';	

$RateResult = mysql_query("SELECT * FROM `param`");	
$SelectRow = mysql_fetch_assoc($RateResult);
$date_rcr = $SelectRow['Date_rcr'];


print '<p class="H2"><big><big><big>Внимание! Заказы сдам в ОВЗ Ника-logistics '.$date_rcr.'!!!</big></big></big></p>'; 
print 'Информацию о графике работы можно уточнить в <a href="http://forum.sibmama.ru/viewtopic.php?t=984316">теме ОВЗ Ника-logistics</a></p>';

print '<hr>';	


//	print '<p class="H2">Выберете место, где вы будете забирать ваш заказ</p>'; 
//	print '<p class="H2">Убедитесь что под вашим балансом появился выбранный вами вариант.</p>'; 

//	print '<p class="H2"><big><big><big>Пока идет распродажа на Vente  раздачи не проводятся.</big></big></big></p>'; 
//	print '<p class="H2"><big><big><big>Надеемся на ваше понимание!</big></big></big></p>'; 
	
	print '<p class="H1">Запись на раздачу</p>'; 
	print '<p class="H2">(Кодовое слово появится накануне раздачи)</p>'; 
// print '<p class="H1">Внимание!</p>'; 
 // print '<p class="H1">Запись на раздачу академ будет открыта позже.</p>'; 	
	// print '<p class="H1">Внимание! Информация о месте и времени раздачи в городе появится вечером 6-го мая!!!</p>'; 

	echo "<table border=1>";
	echo "<tr>
			<td>Место</td>
			<td></td>
		</tr>";
			
	$st = "Активна";
	for ($i=51; $i<=55; $i++) 
	{
		$query = "SELECT * 
					FROM `razd`
					WHERE `stat`='{$st}' AND `id` = '{$i}'";
		$sql = mysql_query($query) or die(mysql_error());		
		$razd = mysql_fetch_assoc($sql);	
		
		if ($razd['id'] > 0)
		{
		$loc = "<a href=confirmrazd.php?no=".$razd['id'].">Записаться</a>";
		if ($idrazd == $razd['id']) {$loc = "";};
			
		echo "<tr>
				<td>".$razd['place']."&nbsp;</td>
				<td>".$loc."&nbsp;</td>
			</tr>";	
			}
	}
	
	echo "</table>";
	
	print '<p class="H1">Запись в РЦР или межгород </p>'; 
	
	echo "<table border=1>";
	echo "<tr>
			<td>Место</td>
			<td></td>
		</tr>";
			
	$st = "Активна";
	for ($i=1; $i<=38; $i++) 
	{
		$query = "SELECT * 
					FROM `razd`
					WHERE `stat`='{$st}' AND `id` = '{$i}'";
		$sql = mysql_query($query) or die(mysql_error());		
		$razd = mysql_fetch_assoc($sql);	
		
		if ($razd['id'] > 0)
		{
		$loc = "<a href=confirmrazd.php?no=".$razd['id'].">Записаться</a>";
		if ($idrazd == $razd['id']) {$loc = "";};
			
		echo "<tr>
				<td>".$razd['place']."&nbsp;</td>
				<td>".$loc."&nbsp;</td>
			</tr>";	
			}
	}
	echo "</table>";	

	

}
else
{
	die('Доступ закрыт, даём ссылку на авторизацию. — <a href="login.php">Авторизоваться</a>');
}

	


include "footer.php"; 
?>