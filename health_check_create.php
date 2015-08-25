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
$unique_key = md5(microtime().rand());
$result = $client->createHealthCheck([
    'CallerReference' => $unique_key, // REQUIRED
    'HealthCheckConfig' => [ // REQUIRED
    'FailureThreshold' => $_POST['FailureThreshold'],
    'FullyQualifiedDomainName' => $_POST['domain'].'.',
    'IPAddress' =>$_POST['ip'], //'52.2.79.232',
    'Port' => $_POST['port'],
    'RequestInterval' => $_POST['RequestInterval'],
    // 'ResourcePath' => '<string>',
    // 'SearchString' => '<string>',
        'Type' => $_POST['type']
        ],
        ]);

$data=array();
if(!empty($result)){
	$result=$result->toArray();
	$data['status']=true;
	$data['id']=$result['HealthCheck']['Id'];
	$data['ip']=$result['HealthCheck']['HealthCheckConfig']['IPAddress'];
	$data['port']=$result['HealthCheck']['HealthCheckConfig']['Port'];
	$data['type']=$result['HealthCheck']['HealthCheckConfig']['Type'];
	$data['domain']=$result['HealthCheck']['HealthCheckConfig']['FullyQualifiedDomainName'];
	$data['RequestInterval']=$result['HealthCheck']['HealthCheckConfig']['RequestInterval'];
	$data['FailureThreshold']=$result['HealthCheck']['HealthCheckConfig']['FailureThreshold'];
}
else{
	$data['status']=false;
}

$_SESSION['health_check']=$data;

header("Location: /aws_r53/home.php");

// }
