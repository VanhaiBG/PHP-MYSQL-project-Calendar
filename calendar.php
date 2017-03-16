<link rel="stylesheet" type="text/css" href="css/calendar.css?v=1.1">

<?php

/* draws a calendar */
function draw_calendar($month,$year){

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Понеделник','Вторник','Сряда','Четвъртък','Петък');
	$weekends = array('Събота','Неделя');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td>' . '<td class="calendar-day-weekends">'.implode('</td><td class="calendar-day-weekends">',$weekends).'</td></tr>';



	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year)-1);
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td  class="calendar-day">';
			/* add in the day number */
			$calendar.= '<div class="day-number"><a href="events.php">'.$list_day.'</a></div>';
			
			

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
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


	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;


	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';

	
	/* all done, return result */
	return $calendar;
}

////////

function random_number() {
	srand(time());
	return (rand() % 7);
}


/* date settings */
$month = (int) (!empty($_GET['month']) ? $_GET['month'] : date('m'));
$year = (int) (!empty($_GET['year']) ? $_GET['year'] : date('Y'));

/* select month control */
$select_month_control = '';
for($x = 1; $x <= 12; $x++) {
	$select_month_control.= ''.date('F',mktime(0,0,0,$x,1,$year)).'';
}
$select_month_control.= '';

/* select year control */
$year_range = 7;
$select_year_control = '';
for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
	$select_year_control.= ''.$x.'';
}
$select_year_control.= '';

/* "next month" control */
$next_month_link = '<a href="$year + 1).' . '"rel="nofollow">Next Month >></a>';

/* "previous month" control */
$previous_month_link = '<a href="$year - 1).'. '" rel="nofollow"><< 	Previous Month</a>';


/* bringing the controls together */
$controls = ''.$select_month_control.$select_year_control.'       '.$previous_month_link.'     '.$next_month_link.' ';

/* get all events for the given month */
$events = array();
$query = "SELECT title, DATE_FORMAT(date,'%Y-%m-%D') AS date FROM meeting WHERE date LIKE '$year-$month%' ";
$result = mysql_query($query,$mysql) or die('cannot get results!');
while($row = mysql_fetch_assoc($result)) {
	$events[$row['date']][] = $row;

}


echo ''.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'';
echo ''.$controls.'';
echo '';
echo draw_calendar($month,$year,$events);
echo '';
