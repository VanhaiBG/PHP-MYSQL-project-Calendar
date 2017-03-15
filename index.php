<?php
$title = 'Home page';
include('includes/header.php');
?>
<form action="index.php" method="post" class="form">
	<?php
	input('text', 'user_nickname', '', 'Е-поща или име');
	input('password', 'user_password', '', 'Парола');
	input('submit', 'submit', 'Вход');
	?>
</form>

<form action="index.php" method="post">
	<?php
	echo "<h4>Регистрация</h4>";
	input('text', 'user_nickname', '', 'Потребителско име*');
	input('text', 'user_email', '', 'Електронна поща*');
	input('password', 'user_password', '', 'Парола*');
	input('password', 'user_password', '', 'Повтори паролата*');
	input('text', 'user_name', '', 'Име');
	input('text', 'user_surname', '', 'Фамилия');
	input('radio', 'user_sex', 'male');
	input('radio', 'user_sex', 'female');
	?>
	<select name="user_born">
		<option value="0">ден</option>
		<?php
		for ($i=1; $i<=31; $i++) {
			echo "<option value='$i'>$i</option>";
		}
		?>
	</select>
	<select name="user_born">
		<option value="0">месец</option>
		<?php
		for ($j=1; $j<=12; $j++) {
			echo "<option value='$j'>$j</option>";
		}
		?>
	</select>
	<select name="user_born">
		<option value="0">година</option>
		<?php
		for ($a=2017; $a>=1950; $a--) {
			echo "<option value='$a'>$a</option>";
		}
		?>
	</select>
	<?php
	input('submit', 'submit', 'Регистрация');
	?>
</form>
<?php
include('includes/footer.php');