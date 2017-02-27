<?php
include "header.php"; 


session_start();

include ('mysql.php');


if (isset($_SESSION['user_id']))
{
if (empty($_POST))
{
?>
	
	<h3>Введите данные нового перевода</h3>
	
<form action="newtrans.php" method="post">
	<table>
		<tr>
			<td>Дата:</td>
			<td><input type="date" name="Data" value=<?php echo date("Y-m-d",time());?> ></td>
		</tr>
		<tr>
			<td>Кому:</td>
			<td><select name="Pers" size="1" >
<?php
$pers = "Jannulya";
echo "<option value={$pers}>{$pers}</option>";
$pers = "SuperCharm";
echo "<option value='{$pers}'>{$pers}</option>";
?>			</td>
		</tr>
		<tr>
			<td>Комментарий:</td>
			<td><input type="text" name="Comm" size=100></td>
		</tr>
		<tr>
			<td>Сумма:</td>
			<td><input type="text" name="Sum" ></td>
		</tr>
			<td></td>
			<td><input type="submit" value="Сохранить" ></td>
		</tr>		
	</table>
</form>
	
	
<?php
} 
else
{
	// обрабатывае пришедшие данные функцией mysql_real_escape_string перед вставкой в таблицу БД
	
	$payuser = (isset($_POST['Pers'])) ? mysql_real_escape_string($_POST['Pers']) : '';
	$paydate = (isset($_POST['Data'])) ? mysql_real_escape_string($_POST['Data']) : '';
	$paycomm = (isset($_POST['Comm'])) ? mysql_real_escape_string($_POST['Comm']) : '';
	$paysumru = (isset($_POST['Sum'])) ? mysql_real_escape_string($_POST['Sum']) : '';


	// проверяем на наличие ошибок (например, длина логина и пароля)
	
		
		$query = "INSERT
					INTO `transfer`
					SET
						`date`='{$paydate}',
						`pers`='{$payuser}',
						`summa`='{$paysumru}',
						`comment`='{$paycomm}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		
		print '<h4>Перевод внесен</h4><a href="rashod.php">Расходы</a>';
		header('Location: rashod.php');
	} 
}

include "footer.php"; 
?>