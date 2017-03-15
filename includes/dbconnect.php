<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'calendar';
$connect = mysqli_connect($servername, $username, $password, $dbname);
// date_default_timezone_set("Europe/Sofia");
// $date = date('d.m.Y');
// $insert_query_date = "INSERT INTO `users`(`date_register`, `date_deleted`) VALUES ('$date')";
// mysql_query($connect, $insert_query_date);