<?php 
include('includes/menu.php');
$event_id = $_GET['event_id'] ?? '';
$delete_query = "UPDATE `events` SET `date_deleted`='$date' WHERE `event_id`=$event_id";
$result = mysqli_query($connect, $delete_query);
if ($result) {
	return header('Location: calendar.php');  
}
else {
	echo "Error: " . $delete_query . " - " . mysqli_error($conn);
}