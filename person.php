<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />

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

	
if (empty($_POST))
{
	?>
	
	<h3>Ваши личные данные</h3>
	
<form action="person.php" method="post">
<?php
$UserResult = mysql_query("SELECT * FROM users 	WHERE `id`='{$_SESSION['user_id']}'");
$row = mysql_fetch_assoc($UserResult);

$name = $row['Name'];
$tel = $row['Tel'];
$adr = $row['Adress'];
$razd = $row['Razd'];
$email = $row['Email'];

?>
	<table>
		<tr>
			<td>ФИО:</td>
			<td><input type="text" name="Name" size="70" value="<?php echo $name;?>"></td>
		</tr>
		<tr>
			<td>Телефон:</td>
			<td><input type="text" name="Tel" value="<?php print $tel;?> "></td>
		</tr>
		<tr>
			<td>Район проживания (для иногородних адрес полностью для отправки межгорода "Энергией"):</td>
			<td><input type="text" name="Adress" size="120" value="<?php echo $adr;?> "></td>
		</tr>
		<tr>
			<td>Предпочитаемое место получения заказа (город, академ, через систему РЦР):</td>
			<td><input type="text" name="Razd" size="120" value="<?php echo $razd;?>"></td>
		</tr>
		<tr>
			<td>Ваш e-mail:</td>
			<td><input type="text" name="Email" size="120" value="<?php echo $email;?>"></td>
		</tr>
		<tr>
			<td><input type="submit" value="Сохранить измененные данные" /></td>
			<td></td>
		</tr>		
	</table>
</form>

	
	<?php
}
else
{
	// обрабатывае пришедшие данные функцией mysql_real_escape_string перед вставкой в таблицу БД
	
	$prsname = (isset($_POST['Name'])) ? mysql_real_escape_string($_POST['Name']) : '';
	$prstel = (isset($_POST['Tel'])) ? mysql_real_escape_string($_POST['Tel']) : '';
	$prsadr = (isset($_POST['Adress'])) ? mysql_real_escape_string($_POST['Adress']) : '';
	$prsrazd = (isset($_POST['Razd'])) ? mysql_real_escape_string($_POST['Razd']) : '';
	$prsemail = (isset($_POST['Email'])) ? mysql_real_escape_string($_POST['Email']) : '';
	
	// проверяем на наличие ошибок (например, длина логина и пароля)
	
		
		$query = "UPDATE `users`
					SET
						`Name`='{$prsname}',					
						`Tel`='{$prstel}',					
						`Adress`='{$prsadr}',					
						`Razd`='{$prsrazd}',
						`Email`='{$prsemail}'
					WHERE `id`='{$_SESSION['user_id']}'";
		$sql = mysql_query($query) or die(mysql_error());


		print '<h4>Изменения внесены</h4>';
	}
}

include "footer.php"; 
?>