<?php
session_start();
// if(!empty($_SESSION['user'])){
require 'vendor/autoload.php';
use Aws\Route53\Route53Client;

//////////////////
require_once('/connectivity/aws_keys.php');
$keys=aws_keys();
$access_key=$keys['access_key'];
$secret_key=$keys['secret_key'];
//////////////////////////

$client = Route53Client::factory(
	array(
		'version' => 'latest',
		'region'  => "us-east-1",
		'credentials' => array(
			'key' => $access_key,
			'secret'  => $secret_key,
			)
		)
	);

$result = $client->getHealthCheckStatus([
    'HealthCheckId' => $_POST['id'] // REQUIRED
]);

$data=array();
if(!empty($result)){
	$result=$result->toArray();
	$data['status']=true;
	$data['ip']=$result['HealthCheckObservations'][0]['IPAddress'];
	$data['health_status']=$result['HealthCheckObservations'][0]['StatusReport']['Status'];
}
else{
	$data['status']=false;
}

$_SESSION['health_check_get']=$data;

header("Location: /aws_r53/home.php");

// }
