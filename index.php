<?php
$title = 'Начало';
include('includes/header.php');
$redirect = "<a href='index.php'>Върнете се към формата.</a>";
if (!empty($_POST['submit_login'])) {
	$_SESSION['user_nickname'] = $_POST['user_nickname'];
	$_SESSION['user_password'] = $_POST['user_password'];
	if ($_SESSION['user_nickname'] && $_SESSION['user_password']) {
		$select_query_login_check = "SELECT `user_nickname`, `user_password` FROM `users` WHERE `user_nickname`='$_SESSION[user_nickname]' AND `user_password`='$_SESSION[user_password]' AND `date_deleted` IS NULL";
		$result_login = mysqli_query($connect, $select_query_login_check);
		if (mysqli_num_rows($result_login) > 0) {
			$row = mysqli_fetch_assoc($result_login);
			if ($row['user_nickname'] = $_SESSION['user_nickname'] && $row['user_password'] = $_SESSION['user_password']) {
				header('Location: login.php');
			}
		}
		else {
			echo "Въвели сте грешно потребителско име или парола!<br>$redirect";
		}
	}
	else {
		echo "Не сте въвели всички полета!<br>$redirect";
	}
}
//Login form
else {
?>
<form action="index.php" method="post" class="form">
<?php
	input('text', 'user_nickname', '', 'Потребителско име');
	input('password', 'user_password', '', 'Парола');
	input('submit', 'submit_login', 'Вход');
?>
</form>
<?php
	//Variables for the registration form
	if (!empty($_POST['submit_register'])) {
		$user_nickname = $_POST['user_nickname'] ?? '';
		$user_email = $_POST['user_email'] ?? '';
		$user_password = $_POST['user_password'] ?? '';
		$user_password_repeat = $_POST['user_password_repeat'] ?? '';
		$user_name = $_POST['user_name'] ?? '';
		$user_surname = $_POST['user_surname'] ?? '';
		$user_sex = $_POST['user_sex'] ?? '';
		$user_born = $_POST['user_born_year']."-".$_POST['user_born_month']."-".$_POST['user_born_day'];
		//Check completed name, email and password
		if ($user_nickname && $user_email && $user_password == $user_password_repeat) {
			$valid_email = $user_email;
			$valid_email = filter_var($valid_email, FILTER_SANITIZE_EMAIL);
			//Check the length of the name and password
			$count_nickname = strlen($user_nickname);
			$count_password = strlen($user_password);
			if ($count_nickname < 3 || $count_password < 6) {
				echo "Потребителското Ви име трябва да съдържа поне 3 символа, а паролата Ви поне 6!<br>$redirect";
			}
			//Check if the email is valid
			elseif (filter_var($valid_email, FILTER_VALIDATE_EMAIL) === false) {
				echo "Имейл адреса Ви е невалиден!<br>$redirect";
			}
			//Check for existing name and email
			else {
				$select_query_register_check = "SELECT `user_nickname`, `user_email` FROM `users` WHERE `user_nickname`='$user_nickname' OR `user_email`='$user_email' AND `date_deleted` IS NULL";
				$result = mysqli_query($connect, $select_query_register_check);
				if (mysqli_num_rows($result) > 0) {
					$row = mysqli_fetch_assoc($result);
					if ($row['user_nickname'] == $user_nickname || $row['user_email'] == $user_email) {
						echo "Името или имейла вече се използват!<br>$redirect";
					}
				}
				//Successful registration
				else {
					$insert_query_register = "INSERT INTO `users`(`user_nickname`, `user_email`, `user_password`, `user_name`, `user_surname`, `user_sex`, `user_born`, `date_register`) VALUES ('$user_nickname', '$user_email', '$user_password', '$user_name', '$user_surname', '$user_sex', '$user_born', '$date')";
					if (mysqli_query($connect, $insert_query_register)) {
								echo "Успешна регистрация!<br>
									Вече може да ползвате Вашето потребителско име (или имейл) и парола.<br>$redirect";
					}
				}
			}
		}
		else {
			if ($user_password !== $user_password_repeat) {
				echo "Паролата Ви не съвпада!<br>$redirect";
			}
			else {
				echo "Полетата със знак * са задължителни!<br>$redirect";
			}
		}
	}
	//Registration form
	else {
?>
	<form action="index.php" method="post">
<?php
		echo "<h4>Регистрация</h4>";
		input('text', 'user_nickname', '', 'Потребителско име*');
		input('text', 'user_email', '', 'Е-поща*');
		input('password', 'user_password', '', 'Парола*');
		input('password', 'user_password_repeat', '', 'Повтори паролата*');
		input('text', 'user_name', '', 'Име');
		input('text', 'user_surname', '', 'Фамилия');
		echo "Мъж";
		input('radio', 'user_sex', 'Мъж');
		echo "Жена";
		input('radio', 'user_sex', 'Жена');
		echo "Рожденна дата";
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
		input('reset', 'reset', 'Изчисти данните');
?>
	</form>
<?php
	}
}
include('includes/footer.php');