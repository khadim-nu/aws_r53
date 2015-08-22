<?php
session_start();
// documentaions http://www.orderingdisorder.com/aws/route-53/
function get_served(){
	require_once('r53.php');
	$access_key='AKIAJCE4ZDY4NPCMCZMA';
	$secret_key='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';
	$r53 = new Route53($access_key, $secret_key);

//print_r('createHostedZone<br>');

$result = $r53->createHostedZone('google.com', 'abclllllldef', 'no cooment here');
var_dump($result);

}
get_served();
