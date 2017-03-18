<?php
session_name("mysession");
session_start();
session_destroy();
header('Location: index.php');