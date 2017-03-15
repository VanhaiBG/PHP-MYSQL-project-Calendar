<html>
	<head>
		<meta charset="UTF-8">
		<title><?= $title ?></title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	</head>
	<body>
<?php
session_set_cookie_params('3600');
session_start();
include('includes/dbconnect.php');
include('includes/form.php');