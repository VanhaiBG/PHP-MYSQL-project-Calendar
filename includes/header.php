<html>
	<head>
		<meta charset="UTF-8">
		<title><?= $title ?></title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css?v=1.1">
	</head>
	<body>
<?php
session_name("mysession");
session_start();
include('includes/dbconnect.php');
include('includes/functions.php');
?>
<div class="header"><a href="calendar.php"><h1 class="title">Календар</h1></a></div>