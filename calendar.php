<link rel="stylesheet" type="text/css" href="assets/css/calendar.css?v=1.1">
<?php
$title = 'Календар';
include('includes/header.php');
include('menu.php');
logout();
if (!empty($_GET['submit'])) {
	
}
else {
	echo "<form action='calendar.php' method='get'>";
	input('submit', 'back', 'Назад');
	echo "</form>";
	$month = date('m');
	$year = date('Y');
	echo date_month($month)." $year";
	echo "<form action='calendar.php' method='get'>";
	input('submit', 'forward', 'Напред');
	echo "</form>";
	echo draw_calendar($month, $year);
}
echo '<h2>March 2017</h2>';
echo draw_calendar(3,2017);
include('includes/footer.php');