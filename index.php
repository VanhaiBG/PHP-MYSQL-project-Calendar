<?php
$title = 'Начало';
include('includes/header.php');
$redirect = "<br><a href='index.php'>Върнете се назад.</a>";
echo "<div class='feat'>Реализирайте уеб-приложение, в което всеки регистриран потребител може след вход в приложението /проверка с потребителско име и парола/ да записва своите задачи. Всяка една - има заглавие, описание и краен срок за изпълнение. Потребителят вижда списъкът със задачите си и за всяка една от тях съответния флаг. Ако крайният срок на задачата е Днес, флагът е ДНЕС. Ако задачата трябва да бъде изпълнена в рамките на една седмица - без днешния ден - флагът й е ПРЕДСТОИ. Всички останали задачи, за които срокът не е изтекъл, са със флаг НАБЛИЖАВА.<br>Потребителят трябва да вижда броя на задачите със всеки Флаг и да може да ги преглежда на отделен и общ списък. Задачите трябва да могат да се подреждат по ред на записване в базата данни, по срок за изпълнение, по азбучен ред на заглавието на задачата. Трябва да може да търси сред задачите по ключова дума във заглавието и описанието, по флаг и по дата на изпълнение. Задачите с флаг - ПРЕДСТОИ И НАБЛИЖАВА, могат да бъдат редактирани. Задачите с флаг НАБЛИЖАВА, могат да бъдат и изтривани. За останалите флагове това не е позволено. Задачите с изтекъл срок получават флаг ИЗПЪЛНЕНИ.</div>";
if (!empty($_POST['submit_login'])) {
	$_SESSION['user_nickname'] = $_POST['user_nickname'];
	$_SESSION['user_password'] = $_POST['user_password'];
	if ($_SESSION['user_nickname'] && $_SESSION['user_password']) {
		$select_query_login_check = "SELECT `user_nickname`, `user_password` FROM `users` WHERE `user_nickname`='$_SESSION[user_nickname]' AND `user_password`='$_SESSION[user_password]' AND `date_deleted` IS NULL";
		$result_login = mysqli_query($connect, $select_query_login_check);
		if (mysqli_num_rows($result_login) > 0) {
			$row = mysqli_fetch_assoc($result_login);
			if ($row['user_nickname'] = $_SESSION['user_nickname'] && $row['user_password'] = $_SESSION['user_password']) {
				header('Location: calendar.php');
			}
		}
		else {
			echo "<div class='regform'>Въвели сте грешно потребителско име или парола!".$redirect."</div>";
		}
	}
	else {
		echo "<div class='regform'>Не сте въвели всички полета!".$redirect."</div>";
	}
}
//Login form
else {
?>
<form action="index.php" method="post" class="loginform">
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
			$user_email = filter_var($user_email, FILTER_SANITIZE_EMAIL);
			//Check the length of the name and password
			if (mb_strlen($user_nickname) < 3 || mb_strlen($user_password) < 6) {
				echo "<div class='regform'>Потребителското Ви име трябва да съдържа поне 3 символа, а паролата Ви поне 6!".$redirect."</div>";
			}
			//Check if the email is valid
			elseif (filter_var($user_email, FILTER_VALIDATE_EMAIL) === false) {
				echo "<div class='regform'>Имейл адреса Ви е невалиден!".$redirect."</div>";
			}
			//Check for existing name and email
			else {
				$select_query_register_check = "SELECT `user_nickname`, `user_email` FROM `users` WHERE `user_nickname`='$user_nickname' OR `user_email`='$user_email' AND `date_deleted` IS NULL";
				$result = mysqli_query($connect, $select_query_register_check);
				if (mysqli_num_rows($result) > 0) {
					$row = mysqli_fetch_assoc($result);
					if ($row['user_nickname'] == $user_nickname || $row['user_email'] == $user_email) {
						echo "<div class='regform'>Името или имейла вече се използват!".$redirect."</div>";
					}
				}
				//Successful registration
				else {
					$insert_query_register = "INSERT INTO `users`(`user_nickname`, `user_email`, `user_password`, `user_name`, `user_surname`, `user_sex`, `user_born`, `date_register`) VALUES ('$user_nickname', '$user_email', '$user_password', '$user_name', '$user_surname', '$user_sex', '$user_born', '$date')";
					if (mysqli_query($connect, $insert_query_register)) {
								echo "<div class='regform'>Успешна регистрация!<br>
									Вече може да използвате Вашето потребителско име и парола.".$redirect."</div>";
					}
				}
			}
		}
		else {
			if ($user_password !== $user_password_repeat) {
				echo "<div class='regform'>Паролата Ви не съвпада!".$redirect."</div>";
			}
			else {
				echo "<div class='regform'>Полетата със знак * са задължителни!".$redirect."</div>";
			}
		}
	}
	//Registration form
	else {
?> 
	<form action="index.php" method="post" class="regform">
<?php
		echo "<h4 class='title'>Регистрация</h4>";
		input('text', 'user_nickname', '', 'Потребителско име*');
		input('text', 'user_email', '', 'Е-поща*');
		echo "<br>";
		input('password', 'user_password', '', 'Парола*');
		input('password', 'user_password_repeat', '', 'Повтори паролата*');
		echo "<br>";
		input('text', 'user_name', '', 'Име');
		input('text', 'user_surname', '', 'Фамилия');
		echo "<br>";
		echo "Рожденна дата";
?>
		<select name="user_born_day">
			<option value="0">ден</option>
<?php
			for ($i=1; $i<=31; $i++) {
				echo "<option value='$i'>$i</option>";
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
		<select name="user_born_year">
			<option value="0">година</option>
<?php
			for ($a=date('Y'); $a>=1950; $a--) {
				echo "<option value='$a'>$a</option>";
			}
?>
		</select>
<?php
		echo "<br>";
		echo "<label for='male'>Мъж</label>";
		input('radio', 'user_sex', 'Мъж', '', 'male');
		echo "<label for='female'>Жена</label>";
		input('radio', 'user_sex', 'Жена', '', 'female');
		echo "<br>";
		input('submit', 'submit_register', 'Регистрация');
		input('reset', 'reset', 'Изчисти данните');
?>
	</form>
<?php
	}
}
include('includes/footer.php');