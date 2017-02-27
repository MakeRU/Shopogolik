<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{

if (isset($_GET['no']))
{
    $ordno = $_GET['no'];

$OrdResult = mysql_query("SELECT * FROM `order` WHERE `id_order`='{$ordno}'");	
$SelectRow = mysql_fetch_assoc($OrdResult);
$ordid = $SelectRow['id_order'];
$orduser = $SelectRow['id_user'];
$orddate = $SelectRow['Data'];
$ordshop = $SelectRow['id_shop'];
$ordart = $SelectRow['Articul'];
$ordurl = $SelectRow['ordurl'];	
$ordcost = $SelectRow['Cost_USD'];
$ordship = $SelectRow['Ship_USD'];
$orddisc = $SelectRow['Discount'];
$ordtax = $SelectRow['Tax'];
$ordorg = $SelectRow['Org_USD'];
$ordsus = $SelectRow['Sum_USD'];
$ordsru = $SelectRow['Sum_RU'];
$ordrate = $SelectRow['Rate'];
$ordstat = $SelectRow['Status'];


	
	
	if ($ordorg == 1) {$orgsu = 1;}
	else {$orgsu = $ordcost * ((100-$orddisc)/100) *((100+ $ordtax) /100)*(($ordorg) /100);}
	
// Подсчет суммы для Бидз
	if ($ordshop == 15) 
	{
	$orgsu = $ordcost* ($ordorg) /100;
	if ($ordcost <= 5) 
		{	
			$orgsu = 1;
		}
	}	

	// Подсчет суммы для Amazon
	if ($ordshop == 7) 
	{
	$orgsu = $ordcost * ((100-$orddisc)/100) *((100+ $ordtax) /100)*(($ordorg) /100);
	
	if ($ordcost <= 5) 
		{	
			
			$orgsu = 1;
		}
	}
	
	$ordsru = 5*round(($orgsu + $ordship)* $ordrate / 5);	
	$ordstat = "Потеря";
	

	
	// проверяем на наличие ошибок (например, длина логина и пароля)
	
		
		$query = "UPDATE `order`
					SET
						`Sum_RU`='{$ordsru}',
						`Status`='{$ordstat}'
					WHERE `id_order`='{$ordid}'";
		$sql = mysql_query($query) or die(mysql_error());
	
		
		print '<h4>Ордер сохранен</h4><a href="allordusa.php">Все заказы USA</a>';
		header('Location: allordusa.php');
	}
}
include "footer.php"; 
?>