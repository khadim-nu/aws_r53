<?php
session_start();
// documentaions http://www.orderingdisorder.com/aws/route-53/
function get_served(){
	require_once('r53.php');
	//////////////////
	require_once('/connectivity/aws_keys.php');
	$keys=aws_keys();
	$access_key=$keys['access_key'];
	$secret_key=$keys['secret_key'];
//////////////////////////
	$r53 = new Route53($access_key, $secret_key);

//print_r('createHostedZone<br>');

	$result = $r53->createHostedZone('google.com', 'abclllllldef', 'no cooment here');
	var_dump($result);

}
get_served();
