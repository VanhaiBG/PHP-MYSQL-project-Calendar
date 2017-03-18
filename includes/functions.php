<?php
function input($type, $name, $value = NULL, $placeholder = NULL){
	echo "<input type='".$type."' name='".$name."' value='". $value ."' placeholder='".$placeholder."'>";
}
function logout() {
	echo "<a href='profile.php'>".$_SESSION['user_nickname']."</a> | <a href='logout.php'>Изход</a>";
}
function draw_calendar($month,$year){
	//Draw table
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
	//Table headings
	$headings = array('Пон','Вт','Ср','Чет','Пет');
	$weekends = array('Съб','Нед');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td>' . '<td class="calendar-day-weekends">'.implode('</td><td class="calendar-day-weekends">',$weekends).'</td></tr>';
	//Days and weeks vars now...
	$running_day = date('w',mktime(0,0,0,$month,1,$year)-1);
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();
	//Row for week one
	$calendar.= '<tr class="calendar-row">';
	//Print "blank" days until the first of the current week
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;
	//Keep going with days...
	$today=date('d');
	$current_month=date('m');

	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td  class="calendar-day">';
			//Add in the day number
			if ($list_day==$today) {
				$calendar.= '<div class="today"><a href="events.php">'.$today.'</a></div>';
			}
			else {
				$calendar.= '<div class="day-number"><a href="events.php">'.$list_day.'</a></div>';
			}
		//QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY! IF MATCHES FOUND, PRINT THEM!
		$calendar.= str_repeat('<p> </p>',2);
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
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
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;
	//Final row
	$calendar.= '</tr>';
	//End the table
	$calendar.= '</table>';
	//All done, return result
	return $calendar;
}
function date_month($month) {
	switch ($month) {
		case ($month == 1):
			echo "Януари";
			break;
		case ($month == 2):
			echo "Февруари";
			break;
		case ($month == 3):
			echo "Март";
			break;
		case ($month == 4):
			echo "Април";
			break;
		case ($month == 5):
			echo "Май";
			break;
		case ($month == 6):
			echo "Юни";
			break;
		case ($month == 7):
			echo "Юли";
			break;
		case ($month == 8):
			echo "Август";
			break;
		case ($month == 9):
			echo "Септември";
			break;
		case ($month == 10):
			echo "Октомври";
			break;
		case ($month == 11):
			echo "Ноември";
			break;
		case ($month == 12):
			echo "Декември";
			break;
		default:
			echo "not a valid date";
			break;
	}
}