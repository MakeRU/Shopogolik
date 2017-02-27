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


	echo "<table align='center' border=0><tr>";
	print '<td><a href="newconts.php?pack='.$packno.'">Добавить заказы</a></td>';
	print '<td><a href="newcont.php?pack='.$packno.'">Добавить один заказ</a></td>';
	print '<td><a href="newcontfr.php?pack='.$packno.'">Добавить заказ (France)</a></td>';
	print '<td><a href="newweight.php?pack='.$packno.'">Добавить вес</a></td>';
	print '<td><a href="newtransport.php?pack='.$packno.'">Добавить транспортные</a></td>';
//	print '<td><a href="allrecieve.php?pack='.$packno.'">Пометить все как пришедшие</a></td>';
	print '<td><a href="alldel.php?pack='.$packno.'">Удалить все непришедшие</a></td>';
	print '<td><a href="razobr.php?pack='.$packno.'">Разобрана</a></td>';
	print '<td><a href="sendemail.php?pack='.$packno.'">Отправить всем email</a></td>';
	echo "</tr></table>";	

//echo $pack; 
	
$parampack = $packno;	

	
	$query = "SELECT sum(weight)
				FROM `userpack`
				WHERE `id_pack`='{$parampack}'";
	$sql = mysql_query($query) or die(mysql_error());
	$sumweight = mysql_result($sql, 0); 
	
	$query = "SELECT sum(sum)
				FROM `userpack`
				WHERE `id_pack`='{$parampack}'";
	$sql = mysql_query($query) or die(mysql_error());
	$sumrus = mysql_result($sql, 0); 

	$query = "SELECT * 
				FROM `userpack`
				WHERE `id_pack`='{$parampack}'";
	$sql = mysql_query($query) or die(mysql_error());
	
	$num = 0;
	
	if($sql)
	{
		// определяем таблицу и заголовок
		echo "<h4 align='center'>Посылка № ".$parampack.". Общий вес: ".$sumweight." г. Общая сумма: ".$sumrus." руб.</h4>";
		echo "<table border=1 align='center'>";
		echo "<tr align='center'>
				<td></td>
				<td>Участник закупки</td>
		          <td>Вес (гр)</td>
					<td>РЦРР (руб)</td> 
				  <td>Сумма (руб)</td>
				  <td>Раздача</td>
				  <td>Баланс</td>
				  <td>E-mail</td></tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($pack = mysql_fetch_array($sql))
		{
	
			$query = "SELECT * 
				FROM `users`
				WHERE `id`='{$pack['id_user']}'";
			$usn = mysql_query($query) or die(mysql_error());
			$us = mysql_fetch_assoc($usn);
			$uname = $us['login'];
			$urazd = $us['id_razd'];
			$umes = $us['mes'];
			$umail = $us['Email'];
		
			$query = "SELECT sum(Sum_RU)
				FROM `order`
				WHERE `id_user`='{$pack['id_user']}'";
			$sqlm = mysql_query($query) or die(mysql_error());
			$summ = mysql_result($sqlm, 0); 
			
	
			$query = "SELECT sum(sum)
				FROM `userpack`
				WHERE `id_user`='{$pack['id_user']}'";
			$sqlpm = mysql_query($query) or die(mysql_error());
			$sumpm = mysql_result($sqlpm, 0); 
			
			$acc='Подтверждено';	
			$query = "SELECT sum(Sum)
				FROM `payment`
				WHERE `id_user`='{$pack['id_user']}' AND
				`Accept`='{$acc}'";
			$sqlp = mysql_query($query) or die(mysql_error());
			$sump = mysql_result($sqlp, 0); 
			
			
			$bal = $sump - $summ - $sumpm;
						
			if ($bal < 0) {$cname = "FA8072";};
			if ($bal >= 0) {$cname = "00BFFF";};			
			
			
			$query = "SELECT `place` 
				FROM `razd`
				WHERE `id`='{$urazd}'";
			$rsn = mysql_query($query) or die(mysql_error());
			$rpl = mysql_fetch_assoc($rsn);
			$place = '*'.$rpl['place'].'*';
			if ($us['id_razd'] == 0) {$place = $us['Razd'];}

			$num = $num + 1;
			
			echo "<tr bgcolor='".$cname."'>
					<td>".$num."</td>
					<td><a href=\"".htmlspecialchars($umes,ENT_QUOTES)."\" target='_blank'>".$uname."&nbsp;</td>
			        <td>".$pack['weight']."&nbsp;</td>
					<td>".$pack['addsum']."&nbsp;</td>
					<td>".$pack['sum']."&nbsp;</td>
					<td>".$place."&nbsp;</td>
					<td>".$bal."&nbsp;</td>
					<td>".$umail."&nbsp;</td>
					</tr>";
		}
		echo "</table>";
	}
	
	$recievord = 0;
	$allord = 0;
	
	$query = "SELECT * 
				FROM `contpack`
				WHERE `id_pack`='{$parampack}'";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// так как запрос возвращает несколько строк, применяем цикл
		while($pack = mysql_fetch_array($sql))
		{
			$ordno = $pack['id_ord'];
			$packno = $pack['id_pack'];
			
			$query = "SELECT * 
				FROM `order`
				WHERE `id_order`='{$ordno}'";
			$ordp = mysql_query($query) or die(mysql_error());
			$ord = mysql_fetch_assoc($ordp);
			
			if ($ord['Status'] == "Получено") {$recievord = $recievord + 1;};
			
			$allord = $allord + 1;
		}
	}
	
	
	$query = "SELECT * 
				FROM `contpack`
				WHERE `id_pack`='{$parampack}'";
	$sql = mysql_query($query) or die(mysql_error());
	
	if($sql)
	{
		// определяем таблицу и заголовок
		echo "<h4 align='center'>Содержимое посылки № ".$parampack."</h4>";
		echo "<h4 align='center'>Всего в посылке: ".$recievord." / ".$allord."</h4>";
		echo "<table border=0 align='center'>";
		echo "<tr align='center'><td>Ордер</td>
				<td>Участник закупки</td>
		          <td>Магазин</td>
				  <td>Артикул</td>
				  <td>Дата</td>
				  <td>Цена</td>
				  <td>Статус</td>
				  <td></td></tr>";
		// так как запрос возвращает несколько строк, применяем цикл
		while($pack = mysql_fetch_array($sql))
		{
			$ordno = $pack['id_ord'];
			$packno = $pack['id_pack'];
			$query = "SELECT * 
				FROM `package`
				WHERE `id_pack`='{$packno}'";
			$pck = mysql_query($query) or die(mysql_error());
			$pc = mysql_fetch_assoc($usn);
			$pckst = $pc['Status'];
			
			$query = "SELECT * 
				FROM `order`
				WHERE `id_order`='{$ordno}'";
			$ordp = mysql_query($query) or die(mysql_error());
			$ord = mysql_fetch_assoc($ordp);

echo $pckst;			
//			if ((($pckst=="Разобрана") && ($ord['Status']== "Получено")) || 
//					($pckst=="Получена"))
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
			
			$query = "SELECT * 
				FROM `users`
				WHERE `id`='{$ord['id_user']}'";
			$usn = mysql_query($query) or die(mysql_error());
			$us = mysql_fetch_assoc($usn);
			$uname = $us['login'];
			$umes = $us['mes'];
			
			$loc = "<a href=recieveord.php?no=".$ord['id_order']."&pack=".$parampack.">Пришел</a>";
			if ($ord['Status'] == "Получено") {$loc = "Получено";};
			
	//		$del = "<a href=deleteord.php?no=".$ord['id_order']."&pack=".$parampack.">Удалить</a>";
			$del = "<a href=deleterec.php?no=".$pack['id']."&pack=".$parampack.">Удалить</a>";
			
			$articul =$ord['Description']." ".$ord['Articul']." ".$ord['Code']." ".$ord['Color']." ".$ord['Size']." ".$ord['Quantity']." ".$ord['Comment'];
			
			echo "<tr bgcolor='".$cname."'>
					<td>".$ord['id_order']."&nbsp;</td>
					<td><a href=\"".htmlspecialchars($umes,ENT_QUOTES)."\" target='_blank'>".$uname."&nbsp;</td>
			         <td>".$oname."&nbsp;</td>
					  <td><a href=\"".htmlspecialchars($ord['ordurl'],ENT_QUOTES)."\" target='_blank'>".$articul."&nbsp;</a></td>
					  <td>".$ord['Data']."&nbsp;</td>
					  <td>".$ord['Cost_USD']."&nbsp;</td>
					  <td>".$loc."&nbsp;</td>
					  <td>".$del."&nbsp;</td>
				</tr>";	

		}
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