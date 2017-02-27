<?php	
	$query = "SELECT sum(Sum_RU)
				FROM `order`
				WHERE `id_user`='{$_SESSION['user_id']}'";
	$sql = mysql_query($query) or die(mysql_error());
	$summ = mysql_result($sql, 0); 
			
	$query = "SELECT sum(sum)
				FROM `userpack`
				WHERE `id_user`='{$_SESSION['user_id']}'";
	$sqlpm = mysql_query($query) or die(mysql_error());
	$sumpm = mysql_result($sqlpm, 0); 
	
	$acc='Подтверждено';	
	$query = "SELECT sum(Sum)
				FROM `payment`
				WHERE `id_user`='{$_SESSION['user_id']}' AND 
				`Accept`='{$acc}'";
	$sql = mysql_query($query) or die(mysql_error());
	$sump = mysql_result($sql, 0); 
	
	$bal = $sump - $summ - $sumpm;
	
	$query = "SELECT *
				FROM `users`
				WHERE `id`='{$_SESSION['user_id']}'";
	$sql = mysql_query($query) or die(mysql_error());
	$idrazdq = mysql_fetch_assoc($sql);
	$idrazd = $idrazdq['id_razd'];
	
	$query = "SELECT *
				FROM `users`
				WHERE `id`='{$_SESSION['user_id']}'";
	$sql = mysql_query($query) or die(mysql_error());
	$idrazdq = mysql_fetch_assoc($sql);
	$idrazd = $idrazdq['id_razd'];
	$code = $idrazdq['Code'];
	

	print '<p class="H1" >Здравствуйте, ' . $welcome . '.</p>';
    if($_SESSION['user_id'] > 1)
	 {
	 print '<p class="H1" >Ваш баланс: ' . $bal . ' руб.</p>';	
	 }
	 
	print '<p class="H1" >Внимание! При оплате в банке, говорите что назначение перевода - пополнение счета! Если платите он-лайн, то ни в коем случае, в комментариях ничего не писать!</p>';		
	
	if ($idrazd > 0) 
	 {
	 	$query = "SELECT *
				FROM `razd`
				WHERE `id`='{$idrazd}'";
	$sql = mysql_query($query) or die(mysql_error());
	$razdq = mysql_fetch_assoc($sql);
	$razd = $razdq['place'];
	print '<p class="H1" ><blink>Вы записаны на раздачу: ' . $razd . '</blink></p>';	
	if ($idrazd > 30) {print '<p class="H1" ><blink>Ваше кодовое слово: ' . $code . '</blink></p>';	}
	}	
	 
	echo "<table align='center' border=0><tr>";	
	print '<td></td>';
	print '<td><a href="http://forum.sibmama.ru/viewtopic.php?t=1390159&start=0">Наша тема на форуме</a></td>';
	print '<td><a href="rules.php">Правила</a></td>';
	print '<td><a href="news.php">Новости</a></td>';
	print '<td><a href="person.php">Личная информация</a></td>';
	print '<td><a href="order.php">Мои заказы</a></td>';
	print '<td><a href="archorder.php">Архив заказов</a></td>';
	print '<td><a href="payment.php">Мои платежи</a></td>';
	print '<td><a href="pack.php">Посылки</a></td>';	
	print '<td><a href="razd.php">Раздачи</a></td>';	
	print '<td><a href="bill.php">Реквизиты</a></td>';
	print '<td><a href="concurs.php">Конкурс</a></td></tr>';
	if($_SESSION['user_id'] < 3) 
	{
		print '<tr><td><a href="allpers.php">Все участники закупок</a></td>';	
		print '<td><a href="shop.php">Все магазины</a></td>';	
		print '<td><a href="allordusa.php">Заказы USA</a></td>';
		print '<td><a href="allordfr.php">Заказы France</a></td>';
	//	print '<td><a href="allordgr.php">Заказы Germany</a></td>';
		print '<td><a href="allordeng.php">Заказы England</a></td>';
		print '<td><a href="archord.php?year=15">Архив заказов</a></td>';
		print '<td><a href="allpay.php">Все платежи</a></td>';
		print '<td><a href="allpack.php">Все посылки</a></td>';	
		print '<td><a href="allrazd.php">Все раздачи</a></td>';			
		print '<td><a href="rashod.php">Расходы</a></td>';	
		print '<td><a href="register.php">Регистрация</a></td></tr>';	
	}
/*	if($_SESSION['user_id'] == 415) 
	{
		print '<tr><td></td>';	
		print '<td><a href="allordusa_415.php">Заказы USA</a></td>';
		print '<td><a href="allordfr_415.php">Заказы France</a></td>';
		print '<td><a href="allordgr_415.php">Заказы Germany</a></td>';
		print '<td><a href="archord_415.php">Архив заказов</a></td>';
		print '<td><a href="allpack_415.php">Все посылки</a></td>';	
		print '<td><a href="allrazd.php">Все раздачи</a></td>';	
	}
*/	
	echo "</table>";
	print '<hr>';
?>	