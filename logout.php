<?php
session_start();

	$_SESSION['user'] = "";
	header("Location: /aws_r53/index.php");


?>