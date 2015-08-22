<?php
session_start();
if(empty($_SESSION['user'])){

	$base_url=$_SERVER['HTTP_HOST'];
	$link = mysql_connect('localhost', 'root', 'incubasys');
	if (!$link) {
		die('Could not connect:' . mysql_error());
	}
	else{
		mysql_select_db('aws', $link) or die('Could not select database.');
	}

	$query="select * from users where username='".$_POST['username']."' and password='".$_POST['password']."'";
	$result=mysql_query($query);

	$num=mysql_numrows($result);
	$user=array();
	while( $row = mysql_fetch_assoc( $result)){
    $user = $row; // Inside while loop
}

	mysql_close($link);

	if(!empty($user)){
		$_SESSION['user'] = $user;
		header("Location: /aws_r53/home.php");
	}
	else{
		$_SESSION['message'] = "Username or password is Incorrect!";
		header("Location: /aws_r53/index.php");
	}
}
else{
	header("Location: /aws_r53/home.php");
}
?>