<link rel="stylesheet" type="text/css" href="assets/css/calendar.css?v=1.1">
<?php
$title = 'Календар';
include('includes/menu.php');
echo "<form action='calendar.php' method='get'>";
input('submit', 'back', 'Назад');
echo "</form>";
$month = date('m');
$year = date('Y');
// back_forward_calendar($month, $year);
echo date_month($month)." $year";
echo "<form action='calendar.php' method='get'>";
input('submit', 'forward', 'Напред');
echo "</form>";
echo draw_calendar($month, $year);
include('includes/footer.php');