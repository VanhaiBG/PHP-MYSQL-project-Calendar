<link rel="stylesheet" type="text/css" href="assets/css/calendar.css">
<?php
$title = 'Календар';
include('includes/menu.php');
$month = date('m');
$year = date('Y');
echo date_month($month)." $year";
echo draw_calendar($month, $year);
$url_string = $_SERVER['QUERY_STRING'];
$days = date('t');
$day = date('d');
$event_name = $_POST['event_name'] ?? '';
		$event_description = $_POST['event_description'] ?? '';
$flag = flag($connect, $my_username, $date);
if ($url_string >= $day && $url_string <= $days) {
	$redirect = "<br><a href='calendar.php?".$url_string."'>Върнете се назад.</a>";
	if (!empty($_POST['submit'])) {
		if ($event_name || $event_description) {
			if (mb_strlen($event_name) <= 14) {
				$read_query = "SELECT `user_id` FROM `users` WHERE `user_nickname`='".$my_username."'";
				$result = mysqli_query($connect, $read_query);
				mysqli_num_rows($result);
				$row = mysqli_fetch_assoc($result);
				$event_date = date('Y-m')."-".$url_string;
				$insert_query_event = "INSERT INTO `events`(`event_name`, `event_description`, `event_date`, `user_id`, `date_add`) VALUES ('$event_name', '$event_description', '$event_date', '".$row['user_id']."', '$date')";
				if (mysqli_query($connect, $insert_query_event)) {
					form_events($url_string);
					echo "<div class='input'>Добавихте ново събитие!</div>";
					events_view($connect, $date, $my_username, $flag);
				}
			}
			else {
				form_events($url_string);
				echo "<div class='input'>Не може да използвате повече от 14 символа за „Име“!</div>";
				events_view($connect, $date, $my_username, $flag);
			}
		}
		else {
			form_events($url_string);
			echo "<div class='input'>Полето „Име на събитието“ е задължително.</div>";
			events_view($connect, $date, $my_username, $flag);
		}
	}
	else {
		form_events($url_string);
		if ($url_string >= $day && $url_string <= $days) {
			events_view($connect, $date, $my_username, $flag);
		}
	}
}
else {
	events_view($connect, $date, $my_username, $flag);
}
include('includes/footer.php');