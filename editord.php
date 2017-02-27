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



if (isset($_GET['no']))
{
    $ordno = $_GET['no'];
}
$paramedord = $ordno;

if (empty($_POST))
{

$OrdResult = mysql_query("SELECT * FROM `order` WHERE `id_order`='{$paramedord}'");	
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
$orddesc = $SelectRow['Description'];
$ordcode = $SelectRow['Code'];
$ordcol = $SelectRow['Color'];
$ordsize = $SelectRow['Size'];
$ordquan = $SelectRow['Quantity'];
$ordcomm = $SelectRow['Comment'];
$ordtax = $SelectRow['Tax'];
$ordorg = $SelectRow['Org_USD'];
$ordsus = $SelectRow['Sum_USD'];
$ordsru = $SelectRow['Sum_RU'];
$ordrate = $SelectRow['Rate'];
$ordstat = $SelectRow['Status'];


	echo "<table align='center' border=0><tr>";
	print '<td><a href="cancelord.php?no='.$ordid.'">Отменить ордер</a></td>';
	print '<td><a href="lostord.php?no='.$ordid.'">Потеря</a></td>';
	echo "</tr></table>";	

	?>
	
<form action="editord.php" method="post">
	<table>
		<tr>
			<td>№ ордера:</td>
			<td><input type="text" name="id" value="<?php echo $ordid;?>"></td>
		</tr>
	<tr>
			<td>Участник закупки:</td>
			<td><select name="User" size="1" >
<?php
$UserResult = mysql_query("SELECT * FROM users ORDER BY `login` ASC");
while($SelectRow = mysql_fetch_assoc($UserResult)){
$k = $SelectRow['id'];
if ($k==$orduser){$sel = " selected";} else {$sel="";};
$x = "<option value=".$k." ".$sel.">".$SelectRow['login']."</option>";
echo $x;
//echo "<option value={$SelectRow['id']}>{$SelectRow['login']}</option>";
}
?>			</td>
		</tr>
		<tr>
			<td>Дата:</td>
			<td><input type="date" name="Data" value=<?php echo $orddate;?> ></td>
		</tr>
		<tr>
			<td>Магазин:</td>
			<td><select name="Shop" size="1" >
<?php
$ShopResult = mysql_query("SELECT * FROM shop");
while($SelectRow = mysql_fetch_assoc($ShopResult)){
$k = $SelectRow['id_shop'];
if ($k==$ordshop){$sel = " selected";} else {$sel="";};
$x = "<option value=".$k." ".$sel.">".$SelectRow['shop']."</option>";
echo $x;
}

?>			</td> 
		</tr>
		<tr>
			<td>Описание:</td>
			<td><input type="text" name="Description" size="120" value="<?php echo $orddesc;?>"></td>
		</tr>
		<tr>
			<td>Наименование:</td>
			<td><input type="text" name="Articul" size="120" value="<?php echo $ordart;?>"></td>
		</tr>
		<tr>
			<td>Ссылка:</td>
			<td><input type="text" name="URL" size="120" value="<?php echo $ordurl;?>"></td>
		</tr>
		<tr>
			<td>Артикул:</td>
			<td><input type="text" name="Code" size="120" value="<?php echo $ordcode;?>"></td>
		</tr>
		<tr>
			<td>Цвет:</td>
			<td><input type="text" name="Color" size="120" value="<?php echo $ordcol;?>"></td>
		</tr>
		<tr>
			<td>Размер:</td>
			<td><input type="text" name="Size" size="120" value="<?php echo $ordsize;?>"></td>
		</tr>
		<tr>
			<td>Количество:</td>
			<td><input type="text" name="Quantity" size="120" value="<?php echo $ordquan;?>"></td>
		</tr>
		<tr>
			<td>Цена (USD):</td>
			<td><input type="text" name="Cost_USD" value=<?php echo $ordcost;?>></td>
		</tr>
		<tr>
			<td>Доставка:</td>
			<td><input type="text" name="Ship_USD" value=<?php echo $ordship;?>></td>
		</tr>
		<tr>
			<td>Скидка (%):</td>
			<td><input type="text" name="Disc" value=<?php echo $orddisc;?> ></td>
		</tr>
		<tr>
			<td>Налог (%):</td>
			<td><input type="text" name="Tax" value=<?php echo $ordtax;?> ></td>
		</tr>
		<tr>
			<td>Орг (%):</td>
			<td><input type="text" name="Org_USD" value=<?php echo $ordorg;?> ></td>
		</tr>
		<tr>
			<td>Курс:</td>
			<td><input type="text" name="Rate" value=<?php echo $ordrate;?>></td>
		</tr>
		<tr>
			<td>Примечание:</td>
			<td><input type="text" name="Comment" size="120" value="<?php echo $ordcomm;?>"></td>
		</tr>		
		<tr>
			<td>Статус:</td>
			<td><select name="Status" size=1>
			<?php
			if ($ordstat == "Заказан"){$sel = " selected";} else {$sel="";}; 
			echo "<option value='Заказан' ".$sel.">Заказан</option>";
			if ($ordstat == "Получено"){$sel = " selected";} else {$sel="";}; 
			echo "<option value='Получено' ".$sel.">Получено</option>";
			if ($ordstat == "Отмена"){$sel = " selected";} else {$sel="";}; 
			echo "<option value='Отмена' ".$sel.">Отмена</option>";
			if ($ordstat == "Потеря"){$sel = " selected";} else {$sel="";}; 
			echo "<option value='Потеря' ".$sel.">Потеря</option>";
			?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Сохранить" ></td>
		</tr>		
	</table>
</form>


	
	<?php
	
//			<tr>
//			<td>Сумма (USD):</td>
//			<td><input type="text" name="Sum_USD" /></td>
//		</tr>
//				<tr>
//			<td>Сумма (руб):</td>
//			<td><input type="text" name="Sum_RU" /></td>
//		</tr>
}
else
{
	// обрабатывае пришедшие данные функцией mysql_real_escape_string перед вставкой в таблицу БД

	$ordid = (isset($_POST['id'])) ? mysql_real_escape_string($_POST['id']) : '';	
	$orduser = (isset($_POST['User'])) ? mysql_real_escape_string($_POST['User']) : '';
	$orddate = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
	$ordshop = (isset($_POST['Shop'])) ? mysql_real_escape_string($_POST['Shop']) : '';
	$ordart = (isset($_POST['Articul'])) ? mysql_real_escape_string($_POST['Articul']) : '';
	$ordurl = (isset($_POST['URL'])) ? mysql_real_escape_string($_POST['URL']) : '';	
	$ordcost = (isset($_POST['Cost_USD'])) ? mysql_real_escape_string($_POST['Cost_USD']) : '';
	$ordship = (isset($_POST['Ship_USD'])) ? mysql_real_escape_string($_POST['Ship_USD']) : '';
	$orddisc = (isset($_POST['Disc'])) ? mysql_real_escape_string($_POST['Disc']) : '';
	$ordtax = (isset($_POST['Tax'])) ? mysql_real_escape_string($_POST['Tax']) : '';
	$ordorg = (isset($_POST['Org_USD'])) ? mysql_real_escape_string($_POST['Org_USD']) : '';
	$orddesc = (isset($_POST['Description'])) ? mysql_real_escape_string($_POST['Description']) : '';
	$ordcode = (isset($_POST['Code'])) ? mysql_real_escape_string($_POST['Code']) : '';
	$ordcol = (isset($_POST['Color'])) ? mysql_real_escape_string($_POST['Color']) : '';
	$ordsize = (isset($_POST['Size'])) ? mysql_real_escape_string($_POST['Size']) : '';
	$ordquan = (isset($_POST['Quantity'])) ? mysql_real_escape_string($_POST['Quantity']) : '';
	$ordcomm = (isset($_POST['Comment'])) ? mysql_real_escape_string($_POST['Comment']) : '';
	$ordrate = (isset($_POST['Rate'])) ? mysql_real_escape_string($_POST['Rate']) : '';
	$ordstat = (isset($_POST['Status'])) ? mysql_real_escape_string($_POST['Status']) : '';
	$ordprof = (isset($_POST['Profit'])) ? mysql_real_escape_string($_POST['Profit']) : '';
	
	if ($ordorg == 1) {$ordsus = $ordcost * $ordquan * ((100-$orddisc)/100) *((100+ $ordtax) /100) + $ordorg + $ordship;}
	else {$ordsus = $ordcost * $ordquan * ((100-$orddisc)/100) *((100+ $ordtax) /100)*((100+ $ordorg) /100) + $ordship;}
	
// Подсчет суммы для Бидз
	if ($ordshop == 15) 
	{
	$ordsus = $ordcost*$ordquan *(1 + 0.03 + 0.065 + ($ordorg) /100);
	$ordorg = 15;
	if ($ordcost <= 5) 
		{	
			$ordsus = $ordcost + 0.03*$ordcost + 0.065*$ordcost  + 1;
			$ordorg = 1;
		}
		$orddisc = 0;
		$ordship = 0;
		$ordtax = 6.5;
	}

	// Подсчет суммы для Amazon
	if ($ordshop == 7) 
	{
	$ordsus = $ordcost * $ordquan * ((100-$orddisc)/100) *((100+ $ordtax) /100)*((100+ $ordorg) /100) + $ordship;
	
	if ($ordcost <= 5) 
		{	
			$ordsus = $ordcost * $ordquan * ((100-$orddisc)/100) *((100+ $ordtax) /100) + 1 + $ordship;
			$ordorg = 1;
		}
	}
	
	$ordsru = 5*round($ordsus * $ordrate / 5);	
	
	
	$RateResult = mysql_query("SELECT * FROM `param`");	
    $SelectRow = mysql_fetch_assoc($RateResult);
    $paramedord = $SelectRow['edord'];
	
	
	// проверяем на наличие ошибок (например, длина логина и пароля)
	
		
		$query = "UPDATE `order`
					SET
						`id_user`='{$orduser}',					
						`id_shop`='{$ordshop}',					
						`Articul`='{$ordart}',		
						`ordurl`='{$ordurl}',					
						`Data`='{$orddate}',
						`Cost_USD`='{$ordcost}',
						`Ship_USD`='{$ordship}',
						`Discount`='{$orddisc}',
						`Description`='{$orddesc}',
						`Code`='{$ordcode}',
						`Color`='{$ordcol}',
						`Size`='{$ordsize}',
						`Quantity`='{$ordquan}',
						`Comment`='{$ordcomm}',
						`Tax`='{$ordtax}',
						`Org_USD`='{$ordorg}',
						`Sum_USD`='{$ordsus}',
						`Sum_RU`='{$ordsru}',
						`Rate`='{$ordrate}',
						`Status`='{$ordstat}'
					WHERE `id_order`='{$ordid}'";
		$sql = mysql_query($query) or die(mysql_error());
	
		
		print '<h4>Ордер сохранен</h4><a href="allordusa.php">Все заказы USA</a>';
		header('Location: allordusa.php');
	}
}
include "footer.php"; 
?>