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

if (isset($_GET['user']))
{
    $userid = $_GET['user'];
}

if (isset($_GET['all_ord']))
{
    $all_ord = $_GET['all_ord'];
}
	
echo "<a href=allpersdata.php?user=".$userid."&all_ord=1>Показать все заказы</a>";

		$query = "SELECT sum(Sum_RU)
				FROM `order`
				WHERE `id_user`='{$userid}'";
			$sqlm = mysql_query($query) or die(mysql_error());
			$summ = mysql_result($sqlm, 0); 
	
			$query = "SELECT sum(sum)
				FROM `userpack`
				WHERE `id_user`='{$userid}'";
			$sqlpm = mysql_query($query) or die(mysql_error());
			$sumpm = mysql_result($sqlpm, 0); 
	
			$acc='Подтверждено';	
			$query = "SELECT sum(Sum)
				FROM `payment`
				WHERE `id_user`='{$userid}' AND
				`Accept`='{$acc}'";
			$sqlp = mysql_query($query) or die(mysql_error());
			$sump = mysql_result($sqlp, 0); 
			
			$bal = $sump - $summ - $sumpm;
						
			if ($bal < 0) {$cname = "FA8072";};
			if ($bal >= 0) {$cname = "00BFFF";};
		
					
		$query = "SELECT * 
				FROM `users`
				WHERE `id` = '{$userid}'";
		$sql = mysql_query($query) or die(mysql_error());
		$prs = mysql_fetch_assoc($sql);
	
	echo "<p class='H2'><a href=\"".htmlspecialchars($prs['mes'],ENT_QUOTES)."\" target='_blank'>".$prs['login']."&nbsp;</a>
	 Баланс: ".$bal."</p>";

	if ($all_ord == 0)
	{ $dateshow = date("Y-m-d",time()-2160*60*60);
	
		$query = "SELECT * 
				FROM `payment`
				WHERE (`id_user`='{$userid}') AND (`Date` > '{$dateshow}')
				ORDER BY `Accept` ASC, `Date` DESC";
	$sql = mysql_query($query) or die(mysql_error());}

	if ($all_ord == 1)
	{ $query = "SELECT * 
				FROM `payment`
				WHERE (`id_user`='{$userid}') AND (`Date` > '{$dateshow}')
				ORDER BY `Accept` ASC";
	$sql = mysql_query($query) or die(mysql_error());}

	
	if($sql)
	{
		// определяем таблицу и заголовок
		echo "<table  border=1 align='center'>";
		echo "<tr><td>Номер</td><td>Дата</td><td>Время</td><td>Банк</td><td>Участник закупки</td><td>Сумма</td><td>Комментарий</td><td>Подтверждение</td></tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($pay = mysql_fetch_array($sql))
		{
			$query = "SELECT `bank` 
				FROM `bank`
				WHERE `id_bank`='{$pay['id_bank']}'";
			$bkn = mysql_query($query) or die(mysql_error());
			$bk = mysql_fetch_assoc($bkn);
			$bname = $bk['bank'];
			
			$query = "SELECT `login` 
				FROM `users`
				WHERE `id`='{$pay['id_user']}'";
			$usn = mysql_query($query) or die(mysql_error());
			$us = mysql_fetch_assoc($usn);
			$uname = $us['login'];
			
			echo "<tr><td>".$pay['id_pay']."&nbsp;</td>
				<td>".$pay['Date']."&nbsp;</td>
				<td>".$pay['Time']."&nbsp;</td>
				<td>".$bname."&nbsp;</td><td>".$uname."&nbsp;</td><td>".$pay['Sum']."&nbsp;</td><td>".$pay['Comment']."
			&nbsp;</td><td>".$pay['Accept']."&nbsp;</td></tr>";
		}
		echo "</table>";
	}
	
	
		$stat = "Разобрана";
	$query = "SELECT * 
				FROM `package`
				WHERE `Status`='{$stat}' AND `Date_raz` > '{$dateshow}'
				ORDER BY `Date_raz` DESC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// так как запрос возвращает несколько строк, применяем цикл
		while($pack = mysql_fetch_array($sql))
		{
			$query = "SELECT * 
				FROM `userpack`
				WHERE `id_pack`='{$pack['id_pack']}' AND `id_user`='{$userid}'";
			$packsql = mysql_query($query) or die(mysql_error());
			$package = mysql_fetch_assoc($packsql);
			$ctp = mysql_num_rows($packsql);
			if ($ctp > 0) 
			{
			echo "<h4 align='center'>Вес в посылке № ".$pack['id_pack']." (разобрана ".$pack['Date_raz']."): ".$package['weight']."гр. Доставка: " 
				.$package['sum']." (В том числе транспортные: ".$package['addsum'].")</h4>";
		
			$query = "SELECT * 
				FROM `contpack`
				WHERE `id_pack`='{$pack['id_pack']}'";
			$ordsql = mysql_query($query) or die(mysql_error());
			if($ordsql)
			{
		// определяем таблицу и заголовок

		echo "<table border=0 align='center'>";
		echo "<tr align='center'>
		          <td>Магазин</td>
				  <td>Артикул</td>
				  <td>Дата</td>
				  <td>Цена ($/EUR)</td>
				  <td>Стоимость (RUR)</td>
				  <td>Статус</td></tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($ordn = mysql_fetch_array($ordsql))
		{
			$ordno = $ordn['id_ord'];
			
			$query = "SELECT * 
				FROM `order`
				WHERE `id_order`='{$ordno}' AND
				`id_user`='{$userid}'";
			$ordp = mysql_query($query) or die(mysql_error());
			$ord = mysql_fetch_assoc($ordp);
			$ct = mysql_num_rows($ordp);
			
			if ($ct > 0) 
			{
			
			$query = "SELECT `shop` 
				FROM `shop`
				WHERE `id_shop`='{$ord['id_shop']}'";
			$ordn = mysql_query($query) or die(mysql_error());
			$orn = mysql_fetch_assoc($ordn);
			$oname = $orn['shop'];
			
			$query = "SELECT `col` 
				FROM `shop`
				WHERE `id_shop`='{$ord['id_shop']}'";
			$ordc = mysql_query($query) or die(mysql_error());
			$orcn = mysql_fetch_assoc($ordc);
			$cname = $orcn['col'];
			
			
			echo "<tr bgcolor='".$cname."'>
			         <td>".$oname."&nbsp;</td>
					  <td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$ord['Articul']."&nbsp;</a></td>
					  <td>".$ord['Data']."&nbsp;</td>
					  <td>".$ord['Cost_USD']."&nbsp;</td>
					  <td>".$ord['Sum_RU']."&nbsp;</td>
					  <td>".$ord['Status']."&nbsp;</td></tr>";	
			}
		}
		echo "</table>";
		
		}
	}
	}

	}

    $st="Заказан";
	$query = "SELECT * 
				FROM `order`
				WHERE `Status` = '{$st}' AND `id_user` = {$userid}
				ORDER BY `Data` DESC, `id_shop` ASC";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// определяем таблицу и заголовок
		echo "<table border=0>";
		echo "<tr><td>Ордер</td>
				<td>Участник закупки</td>
		          <td>Магазин</td>
				  <td>Артикул</td>
				  <td>Дата</td>
				  <td>Цена (USA)</td>
				  <td>Доставка (USA)</td>
				  <td>Скидка сайта</td>
				  <td>Налог </td>
				  <td>Орг</td>
				  <td>Сумма (USA)</td>
				  <td>Сумма (руб)</td>
				  <td>Курс</td>
				  <td>Статус</td></tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($ord = mysql_fetch_array($sql))
		{
			$query = "SELECT * 
				FROM `shop`
				WHERE `id_shop`='{$ord['id_shop']}'";
			$ordn = mysql_query($query) or die(mysql_error());
			$orn = mysql_fetch_assoc($ordn);
			$oname = $orn['shop'];
			$ocountry = $orn['Country'];			
//			echo $ocountry;
			
			$query = "SELECT `col` 
				FROM `shop`
				WHERE `id_shop`='{$ord['id_shop']}'";
			$ordc = mysql_query($query) or die(mysql_error());
			$orcn = mysql_fetch_assoc($ordc);
			$cname = $orcn['col'];
			
			$query = "SELECT * 
				FROM `users`
				WHERE `id`='{$ord['id_user']}'";
			$usn = mysql_query($query) or die(mysql_error());
			$us = mysql_fetch_assoc($usn);
			$uname = $us['login'];
			$umes = $us['mes'];
//			if ($ocountry == "USA")
			{
			echo "<tr bgcolor='".$cname."'>
					<td>".$ord['id_order']."&nbsp;</td>
					<td><a href=\"".htmlspecialchars($umes,ENT_QUOTES)."\" target='_blank'>".$uname."&nbsp;</td>
			         <td>".$oname."&nbsp;</td>
					  <td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$ord['Articul']."&nbsp;</a></td>
					  <td>".$ord['Data']."&nbsp;</td>
					  <td>".$ord['Cost_USD']."&nbsp;</td>
					  <td>".$ord['Ship_USD']."&nbsp;</td>
					  <td>".$ord['Discount']."&nbsp;</td>
					  <td>".$ord['Tax']."&nbsp;</td>					  
					  <td>".$ord['Org_USD']."&nbsp;</td>
					  <td>".$ord['Sum_USD']."&nbsp;</td>					  
					  <td>".$ord['Sum_RU']."&nbsp;</td>
					  <td>".$ord['Rate']."&nbsp;</td>
					  <td>".$ord['Status']."&nbsp;</td></tr>";			
			}
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