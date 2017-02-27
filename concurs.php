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

echo  "<img align='right' src='Images/buket.jpg'>";
print '<p class="H1" >I место - Аня (анютка.4713) приз: 1000 р.</p>';
print '<p class="H1" >II место - Настя (Nastenok) приз: 500 р.</p>';
print '<p class="H1" >III место - Вика (Виктория Виктория) приз: 300 р. (или билеты в кино)</p>';

print '<hr>';
	

	$query = "SELECT `Concurs`
				FROM `users`
				WHERE `id`='{$_SESSION['user_id']}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($sql);
	$con = $row['Concurs'];

	

print '<p class="H1" >' . $res . '</p>';


print '<p class="H1" >Участница №1 - Аня (анютка.4713)</p>';

echo "<table align='center' border=0><tr><td>";
print '<p class="verse">В жизни нам не нужен допинг, <br>
Ведь у нас прекрасный шоппинг! <br>
И jannulya с super charm <br>
В раз его устроят нам! </p>';

print '<p class="verse">Фея - вот наша удача!  <br>
Не прошло двух дней - раздача!!  <br>
Наше дело, не забыть  <br>
Все посылки оплатить. </p>';

print '<p class="verse">Жанне ночью не до сна  <br>
Скоро снизится цена!!! <br>
Держит в страхе все магазы,  <br>
Будут наши все заказы! </p>';

print '<p class="verse">С бидза выкупят часы  <br>
От Армани лиф, трусы  <br>
И вообще не жизнь - А КАЙФ!!!  <br>
С ШОПОГОЛИК -супер-ЛАЙФ!!!!! </p>';
echo "</td><td><img align='right' src='Images/concurs1.jpg'></td></tr></table>";


print '<p class="H1" >Участница №2 - Вика (Виктория Виктория)</p>';

print '<p class="verse" align="center" >Один день из жизни простой российской женщины </p>';
print '<p class="verse" align="center">(у которой в доме есть интернет) или  </p>';
print '<p class="verse" align="center">СТИХ про ШОППИНГ</p>';

echo "<table align='center' border=0><tr><td><img align='right' src='Images/concurs2.jpg'></td><td>";
print '<p class="verse">Мой любимый допинг? <br>
Ну конечно - шоппинг! <br>
В теме « Шопоголик-лайф» <br>
шопиться ну просто в кайф! </p>';

print '<p class="verse">Открываю ссылку на магаз, <br>
скидываю девочкам заказ. <br>
Жанна и Олесенька всегда <br>
в теме поприветсвуют меня. <br>
Собираюсь купить часы, <br>
в итоге покупаю еще и трусы! <br>
Но это сейчас уже не важно! <br>
Дальше работаю по схеме отважно: <br>
деньги у мужа спросить, не забыть, <br>
чтобы без спешки потом оплатить. <br>
В тот же день, ура! Удача! <br>
Успеваю на раздачу! </p>';

print '<p class="verse">Мысли грустные долой! <br>
Что не подошло – в пристрой: <br>
«Девочки! Вот чудо-лиф! <br>
Нет не выдумка, не миф. <br>
Бюст волшебный у меня! <br>
Налетайте! Спеццена! <br>
Просто супер-предложенье, <br>
на все праздники везенье. <br>
А в итоге, ваш любимый <br>
будет сказочно счастливый!» </p>';

print '<p class="verse">Да, насыщен был денек… <br>
Набрала трусишек впрок . <br>
Буду ждать теперь посылку, <br>
Деньги складывать в копилку. <br>
Чтоб хватило мне на допинг, <br>
на любимый мною шоппинг!</p>'; 
echo "</td></tr></table>";

print '<p class="H1" >Участница №3 - Настя (Nastenok)</p>';

echo "<table align='center' border=0><tr><td>";
print '<p class="verse">Посмотрите на мой лиф, <br>
не подумайте,что миф    <br>
Я ношу вообще-то двойку,  <br>
ну а тут, уже пятерку! </p>';

print '<p class="verse">И красуюсь в нем теперь,  <br>
как успешная модель!  <br>
Самый-самый мой любимый,  <br>
надеваю – день счастливый! </p>';

print '<p class="verse">Не отдам его в пристрой -  <br>
предыдущие долой!  <br>
И у мужа теперь лайф,  <br>
рядом с мейдинформом в кайф </p>';
echo "</td><td><img align='right' src='Images/concurs3.jpg'></td></tr></table>";
}
else
{
	die('Доступ закрыт, даём ссылку на авторизацию. — <a href="login.php">Авторизоваться</a>');
}

	


include "footer.php"; 
?>