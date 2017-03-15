<?php
$title = 'Начало';
include('includes/header.php');
?>
<!-- Login form -->
<form action="index.php" method="post" class="form">
	<?php
	input('text', 'user_nickname', '', 'Е-поща или име');
	input('password', 'user_password', '', 'Парола');
	input('submit', 'submit_login', 'Вход');
	?>
</form>
<?php
//Register form
if (!empty($_POST['submit_register'])) {
	$user_nickname = $_POST['user_nickname'] ?? '';
	$user_email = $_POST['user_email'] ?? '';
	$user_password = $_POST['user_password'] ?? '';
	$user_password_repeat = $_POST['user_password_repeat'] ?? '';
	$user_name = $_POST['user_name'] ?? '';
	$user_surname = $_POST['user_surname'] ?? '';
	$user_sex = $_POST['user_sex'] ?? '';
	$user_born = $_POST['user_born_year']."-".$_POST['user_born_month']."-".$_POST['user_born_day'];
	//Checked Nickname, Email and Password
	if ($user_nickname && $user_email && $user_password == $user_password_repeat) {
		// $select_query_register_check = "SELECT `user_nickname`, `user_email` FROM `users` WHERE `user_nickname`='$user_nickname' OR `user_email`='$user_email'";
		// //Check repetitive Nickname or Email
		// if ($select_query_register_check) {
		// 	echo "Името или имейла вече се ползват от друг потребител!<br><a href='index.php'>Върнете се в началната страница.</a>";
		// }
		// else {
			$insert_query_register = "INSERT INTO `users`(`user_nickname`, `user_email`, `user_password`, `user_name`, `user_surname`, `user_sex`, `user_born`, `date_register`) VALUES ('$user_nickname', '$user_email', '$user_password', '$user_name', '$user_surname', '$user_sex', '$user_born', '$date')";
			if (mysqli_query($connect, $insert_query_register)) {
				echo "Успешна регистрация!<br><a href='index.php'>Върнете се в началната страница.</a>";
			}
		// }
	}
	else {
		echo "Полетата със знак * са задължителни!<br><a href='index.php'>Върнете се в началната страница.</a>";
	}
}
else {
?>
<form action="index.php" method="post">
	<?php
	echo "<h4>Регистрация</h4>";
	input('text', 'user_nickname', '', 'Потребителско име*');
	input('text', 'user_email', '', 'Електронна поща*');
	input('password', 'user_password', '', 'Парола*');
	input('password', 'user_password_repeat', '', 'Повтори паролата*');
	input('text', 'user_name', '', 'Име');
	input('text', 'user_surname', '', 'Фамилия');
	input('radio', 'user_sex', 'Мъж');
	input('radio', 'user_sex', 'Жена');
	?>
	<select name="user_born_year">
		<option value="0">година</option>
		<?php
		for ($a=2017; $a>=1950; $a--) {
			echo "<option value='$a'>$a</option>";
		}
		?>
	</select>
	<select name="user_born_month">
		<option value="0">месец</option>
		<?php
		for ($j=1; $j<=12; $j++) {
			echo "<option value='$j'>$j</option>";
		}
		?>
	</select>
	<select name="user_born_day">
		<option value="0">ден</option>
		<?php
		for ($i=1; $i<=31; $i++) {
			echo "<option value='$i'>$i</option>";
		}
		?>
	</select>
	<?php
	input('submit', 'submit_register', 'Регистрация');
	?>
</form>
<?php
}
include('includes/footer.php');