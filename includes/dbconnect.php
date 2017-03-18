<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'calendar';
$connect = mysqli_connect($servername, $username, $password, $dbname) or die('Грешка при свързването с MySql базата данни!');
date_default_timezone_set("Europe/Sofia");
$date = date('Y-m-d');