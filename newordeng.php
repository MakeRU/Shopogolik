<?php

include "header.php"; 

session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{
if (empty($_POST))
{

$RateResult = mysql_query("SELECT * FROM `param`");	
$SelectRow = mysql_fetch_assoc($RateResult);
$rate = $SelectRow['rateEU'];
$paramshop = $SelectRow['shop'];
$paramuser = $SelectRow['user'];
$paramship = $SelectRow['ship'];
$paramorg = $SelectRow['org'];
$paramdisc = $SelectRow['Discount'];
$paramtax = $SelectRow['Tax'];
//echo $rate;
//echo $paramshop;
	?>
	
	<h3>Введите данные нового заказа</h3>
	
<form action="newordeng.php" method="post">
	<table>
		<tr>
			<td>Участник закупки:</td>
			<td><select name="User" size="1" >
<?php
$UserResult = mysql_query("SELECT * FROM users ORDER BY `login` ASC");
while($SelectRow = mysql_fetch_assoc($UserResult)){
$k = $SelectRow['id'];
if ($k==$paramuser){$sel = " selected";} else {$sel="";};
$x = "<option value=".$k." ".$sel.">".$SelectRow['login']."</option>";
echo $x;
}
?>			</td>
		</tr>
		<tr>
			<td>Дата:</td>
			<td><input type="date" name="Data" value=<?php echo date("Y-m-d",time());?> ></td>
		</tr>
		<tr>
			<td>Магазин:</td>
			<td><select name="Shop" size="1" >
<?php
$ShopResult = mysql_query("SELECT * FROM shop ORDER BY `shop` ASC");
while($SelectRow = mysql_fetch_assoc($ShopResult)){
$k = $SelectRow['id_shop'];
if ($k==$paramshop){$sel = " selected";} else {$sel="";};
$x = "<option value=".$k." ".$sel.">".$SelectRow['shop']."</option>";
echo $x;
//echo "<option value={$SelectRow['id_shop']}".($k==$userYear)?" selected":"".">{$SelectRow['shop']}</option>";
}
//$x .= "<option value='$k'".($k==$userYear)?" selected":"".">".$k."</option>";
?>			</td> 
		</tr>
		<tr>
			<td>Описание:</td>
			<td><input type="text" name="Description" size="120"></td>
		</tr>
		<tr>
			<td>Наименование:</td>
			<td><input type="text" name="Articul" size="120"></td>
		</tr>		
		<tr>
			<td>Артикул:</td>
			<td><input type="text" name="Code" size="120"></td>
		</tr>
		<tr>
			<td>Ссылка:</td>
			<td><input type="text" name="URL" size="120"></td>
		</tr>
		<tr>
			<td>Цвет:</td>
			<td><input type="text" name="Color" size="120"></td>
		</tr>
		<tr>
			<td>Размер:</td>
			<td><input type="text" name="Size" size="120"></td>
		</tr>
		<tr>
			<td>Количество:</td>
			<td><input type="text" name="Quantity" size="120" value = "1"></td>
		</tr>
		<tr>
			<td>Цена (EUR):</td>
			<td><input type="text" name="Cost_USD" ></td>
		</tr>
		<tr>
			<td>Доставка (EUR):</td>
			<td><input type="text" name="Ship_USD" value=<?php echo $paramship;?>></td>
		</tr>
		<tr>
			<td>Скидка (%):</td>
			<td><input type="text" name="Disc" value=<?php echo $paramdisc;?> ></td>
		</tr>
		<tr>
			<td>Налог (%):</td>
			<td><input type="text" name="Tax" value=<?php echo $paramtax;?> ></td>
		</tr>
		<tr>
			<td>Орг (%):</td>
			<td><input type="text" name="Org_USD" value=<?php echo $paramorg;?> ></td>
		</tr>
		<tr>
			<td>Курс:</td>
			<td><input type="text" name="Rate" value=<?php echo $rate;?>></td>
		</tr>
		<tr>
			<td>Примечание:</td>
			<td><input type="text" name="Comment" size="120"></td>
		</tr>			
		<tr>
			<td></td>
			<td><input type="submit" value="Внести заказ" ></td>
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
	$ordprof = (isset($_POST['Profit'])) ? mysql_real_escape_string($_POST['Profit']) : '';
	
	if ($ordorg == 1) {$ordsus = $ordcost *$ordquan * ((100-$orddisc)/100) *((100+ $ordtax) /100) + $ordorg + $ordship;}
	else {$ordsus = $ordcost * $ordquan *((100-$orddisc)/100) *((100+ $ordtax) /100)*((100+ $ordorg) /100) + $ordship;}
// Подсчет суммы для Бидз
	if ($ordshop == 15) 
	{
	$ordsus = $ordcost*(1 + 0.03 + 0.065 + ($ordorg) /100);
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
	
	$ordsru = 5*round($ordsus * $ordrate / 5);
	
	// проверяем на наличие ошибок (например, длина логина и пароля)
	
		
		$query = "INSERT
					INTO `order`
					SET
						`id_user`='{$orduser}',					
						`id_shop`='{$ordshop}',					
						`Articul`='{$ordart}',		
						`ordurl`='{$ordurl}',
						`Description`='{$orddesc}',
						`Code`='{$ordcode}',
						`Color`='{$ordcol}',
						`Size`='{$ordsize}',
						`Quantity`='{$ordquan}',
						`Comment`='{$ordcomm}',					
						`Data`='{$orddate}',
						`Cost_USD`='{$ordcost}',
						`Ship_USD`='{$ordship}',
						`Org_USD`='{$ordorg}',
						`Discount`='{$orddisc}',
						`Tax`='{$ordtax}',
						`Sum_USD`='{$ordsus}',
						`Sum_RU`='{$ordsru}',
						`Rate`='{$ordrate}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		$idparam = 0;
		$query = "UPDATE `param`
					SET
						`rateEU`='{$ordrate}',
						`shop`='{$ordshop}',
						`user`='{$orduser}',
						`org`='{$ordorg}',
						`ship`='{$ordship}',
						`Discount`='{$orddisc}',
						`Tax`='{$ordtax}'";
					//WHERE `id`='{$idparam}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		header('Location: newordeng.php');
	}
}
include "footer.php"; 
?>