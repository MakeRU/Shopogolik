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
	$partyno = $row['Concurs'];
	// показываем защищенные от гостей данные.

	
include "menu.php";	


print '<p class="H1" >Ќаш праздник в боулинге  8 июн€.</p>';

echo  "<table border=0><tr> <td> <img  src='Images/Party1.jpg'> </td></tr></table>";
echo  "<p><img  src='Images/Party2.jpg'></p>";
echo  "<p><img  src='Images/Party3.jpg'></p>";
echo  "<p><img  src='Images/Party4.jpg'></p>";
echo  "<p><img src='Images/Party5.jpg'></p>";
echo  "<p><img  src='Images/Party6.jpg'></p>";
echo  "<p><img src='Images/Party7.jpg'></p>";
echo  "<p><img  src='Images/Party8.jpg'></p>";
echo  "<p><img src='Images/Party9.jpg'></p>";
echo  "<p><img src='Images/Party10.jpg'>";

print '<p class="H1" >продолжение следует....</p>';	
}
else
{
	die('ƒоступ закрыт, даЄм ссылку на авторизацию. Ч <a href="login.php">јвторизоватьс€</a>');
}

	


include "footer.php"; 
?>