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
	
//	print '<h1>Здравствуйте, ' . $welcome . '.</h1>';

include "menu.php";	

if (isset($_GET['no']))
{
    $razdno = $_GET['no'];
}
	
if (empty($_POST))
{


$RazdResult = mysql_query("SELECT * FROM `razd` WHERE `id`='{$razdno}'");	
$SelectRow = mysql_fetch_assoc($RazdResult);
$razdid = $SelectRow['id'];
$razdplace = $SelectRow['place'];

?>
	
<form action="editrazd.php" method="post">
	<table>
		<tr>
			<td><input type="hidden" name="id" value="<?php echo $razdid;?>"></td>
		</tr>
		<tr>
			<td>Место:</td>
			<td><input type="text" name="Place" size="150" value="<?php echo $razdplace;?>"></td>
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

	$razdid = (isset($_POST['id'])) ? mysql_real_escape_string($_POST['id']) : '';	
	$razdplace = (isset($_POST['Place'])) ? mysql_real_escape_string($_POST['Place']) : '';
	
		$query = "UPDATE `razd`
					SET
						`place`='{$razdplace}'
					WHERE `id`='{$razdid}'";
		$sql = mysql_query($query) or die(mysql_error());	
	
	
	 header('Location: allrazd.php');
	}

}
include "footer.php"; 
?>