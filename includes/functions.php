<link rel="stylesheet" type="text/css" href="assets/css/style.css?v=1.1">
<?php
//<input type="$type" name="$name" value="$value" placeholder="$placeholder">
function input($type, $name, $value = NULL, $placeholder = NULL, $id = NULL){
	echo "<input type='".$type."' name='".$name."' value='". $value ."' placeholder='".$placeholder."' id='".$id."' class='input'>";
}

//Logout (redirect to index.php)
function logout() {
	if (!isset($_SESSION['user_nickname'])) {
		header('Location: index.php');
	}
	else {
		echo "<div class='loginform'>".$_SESSION['user_nickname']." | <a href='logout.php'>Изход</a></div><br>";
	}
}

//Calendar
function draw_calendar($month,$year){
	//Draw table
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
	//Table headings
	$headings = array('Пн','Вт','Ср','Чт','Пт');
	$weekends = array('Сб','Нд');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td>' . '<td class="calendar-day-weekends">'.implode('</td><td class="calendar-day-weekends">',$weekends).'</td></tr>';
	//Days and weeks vars now...
	$running_day = date('w',mktime(0,0,0,$month,1,$year)-1);
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();
	//Row for week one
	$calendar .= '<tr class="calendar-row">';
	//Print "blank" days until the first of the current week
	for($x = 0; $x < $running_day; $x++):
		$calendar .= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;
	//Keep going with days...
	$today = date('d');
	$current_month = date('m');

	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar .= '<td  class="calendar-day">';
			//Add in the day number
			if ($list_day==$today) {
				$calendar.= '<div class="today"><a href="calendar.php?'.$today.'">'.$today.'</a></div>';
			}
			else {
				$calendar.= '<div class="day-number"><a href="calendar.php?'.$list_day.'">'.$list_day.'</a></div>';
			}
		//QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY! IF MATCHES FOUND, PRINT THEM!
		$calendar .= str_repeat('<p> </p>',2);
		$calendar .= '</td>';
		if($running_day == 6):
			$calendar .= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;
	//Finish the rest of the days in the week
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar .= "<td class='calendar-day-np'> </td>";
		endfor;
	endif;
	//Final row
	$calendar.= '</tr>';
	//End the table
	$calendar.= '</table>';
	//All done, return result
	return $calendar;
}

//Calendar name on month
function date_month($month) {
	switch ($month) {
		case 1:
			echo "Януари";
			break;
		case 2:
			echo "Февруари";
			break;
		case 3:
			echo "Март";
			break;
		case 4:
			echo "Април";
			break;
		case 5:
			echo "Май";
			break;
		case 6:
			echo "Юни";
			break;
		case 7:
			echo "Юли";
			break;
		case 8:
			echo "Август";
			break;
		case 9:
			echo "Септември";
			break;
		case 10:
			echo "Октомври";
			break;
		case 11:
			echo "Ноември";
			break;
		case 12:
			echo "Декември";
			break;
	}
}

//Form for input events in calendar
function form_events($url_string) {
	echo '<form action="calendar.php?'.$url_string.'" method="post" class="input">';
			input('text', 'event_name', '', 'Име на събитието*');
			input('text', 'event_description', '', 'Описание');
			input('submit', 'submit', 'Добави');
	echo '</form>';
}

function flag($connect, $my_username, $date) {
	$read_query = "SELECT `user_id` FROM `users` WHERE `user_nickname`='".$my_username."'";
	$result = mysqli_query($connect, $read_query);
	mysqli_num_rows($result);
	$row_id = mysqli_fetch_assoc($result);
	$select_query_views = "SELECT * FROM `events` WHERE `event_date`='$date' AND `user_id`='".$row_id['user_id']."' AND `date_deleted` IS NULL";
	$result_views = mysqli_query($connect, $select_query_views);
	mysqli_num_rows($result_views);
	$row = mysqli_fetch_assoc($result_views);
	$date_day = date('Y-m-d');
	while ($row = mysqli_fetch_assoc($result_views)) {
		if ($date_day == $row['event_date']) {
			echo "ДНЕС";
		}
		elseif ($date_day > $row['event_date'] && $row['event_date']) {
			echo "ПРЕДСТОИ";
		}
		else {
			echo "НАБЛИЖАВА";
		}
	}
}
//View all events in calendar
function events_view($connect, $date, $my_username, $flag) {
	$read_query = "SELECT `user_id` FROM `users` WHERE `user_nickname`='".$my_username."'";
	$result = mysqli_query($connect, $read_query);
	mysqli_num_rows($result);
	$row_id = mysqli_fetch_assoc($result);
	$select_query_views = "SELECT * FROM `events` WHERE `date_deleted` IS NULL AND `user_id`='".$row_id['user_id']."'";
	$result_views = mysqli_query($connect, $select_query_views);
	if (mysqli_num_rows($result_views) > 0) {
		echo "<table class='table input'>
			<th>Име на събитието</th>
			<th>Описание</th>
			<th>Флаг на събитието</th>
			<th>Дата на добавяне</th>
			<th colspan='2'>Функции</th>";
		while ($row = mysqli_fetch_assoc($result_views)) {
			echo "<tr>
					<td>".$row['event_name']."</td>
					<td>".$row['event_description']."</td>
					<td>".$flag."</td>
					<td>".$row['date_add']."</td>
					<td><a href='update.php?event_id=".$row['event_id']."'>Промени</a></td><td><a href='delete.php?event_id=".$row['event_id']."'>Изтрий</a></td>
					</tr>";
		}
		echo "</table>";
	}
	else {
		echo "<br><div class='input'>Нямате добавени събития в календара.</div>";
	}
}