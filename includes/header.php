<html>
	<head>
		<meta charset="UTF-8">
		<title><?= $title ?></title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	</head>
	<body>
<?php
session_name("mysession");
session_start();
include('includes/dbconnect.php');
include('includes/functions.php');
?>
<h1>Календар</h1>