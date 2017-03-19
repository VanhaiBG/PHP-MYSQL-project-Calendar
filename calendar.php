<link rel="stylesheet" type="text/css" href="assets/css/calendar.css">
<?php
$title = 'Календар';
include('includes/menu.php');
$month = date('m');
$year = date('Y');
echo date_month($month)." $year";
echo draw_calendar($month, $year);
include('includes/footer.php');