<?php
include('includes/header.php');
if (isset($_SESSION['user_nickname'])) {
?>
<ul>
	<li><a href="login.php">Начало</a></li>
	<li><a href="calendar.php">Календар</a>
		<ul>
			<li>Добави</li>
			<li>Преглед</li>
		</ul>
	</li>
	<li><a href="profile.php">Профил</a></li>
</ul>
<?php
	logout();
}
else {
	logout();
}