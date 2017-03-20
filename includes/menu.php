<?php
include('includes/header.php');
$my_username = $_SESSION['user_nickname'];
if (isset($my_username)) {
	logout();
}
else {
	logout();
}