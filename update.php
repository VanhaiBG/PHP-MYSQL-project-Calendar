<?php
$title = 'Календар';
include('includes/menu.php');
$event_id = $_GET['event_id'] ?? '';
$read = "SELECT `user_id` FROM `users` WHERE `user_nickname`='".$my_username."'";
$result_id = mysqli_query($connect, $read);
mysqli_num_rows($result_id);
$row_id = mysqli_fetch_assoc($result_id);
$read_query = "SELECT * FROM `events` WHERE `event_id`=$event_id AND `user_id`='".$row_id['user_id']."'";
$result = mysqli_query($connect, $read_query);
if (mysqli_num_rows($result) !== 0) {
	$row = mysqli_fetch_assoc($result);
	if (isset($_POST['submit'])) {
		$event_id_post = $_POST['event_id'] ?? '';
		$event_name = $_POST['event_name'] ?? '';
		$event_description = $_POST['event_description'] ?? '';
		$update_query = "UPDATE `events` SET `event_name`='$event_name', `event_description`='$event_description' WHERE `event_id`='$event_id_post'";
		$result_update = mysqli_query($connect, $update_query);
		if ($result_update) {
			return header('Location: calendar.php');
		} else {
		echo "Error: " . $update_query . " - " . mysqli_error($connect);
		}
	}
?>
	<form method="post" action="update.php">
		<input type="text" name="event_name" value="<?= $row['event_name']?>" placeholder="Име на събитието">
		<input type="text" name="event_description" value="<?= $row['event_description']?>" placeholder="Описание">
		<input type="hidden" name="event_id" value="<?= $row['event_id']?>">
		<input type="submit" name="submit" value="запиши">	
	</form>
<?php
}
else {
	echo "Error: " . $read_query . " - " . mysqli_error($connect);
	var_dump($read_query);
}
include('includes/footer.php');