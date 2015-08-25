<?php
session_start();
// if(!empty($_SESSION['user'])){

require 'vendor/autoload.php';
use Aws\Route53Domains\Route53DomainsClient;

//////////////////
require_once('/connectivity/aws_keys.php');
$keys=aws_keys();
$access_key=$keys['access_key'];
$secret_key=$keys['secret_key'];
//////////////////////////

$client = Route53DomainsClient::factory(
	array(
		'version' => 'latest',
		'region'  => "us-east-1",
		'credentials' => array(
			'key' => $access_key,
			'secret'  => $secret_key,
			)
		)
	);
	//public function is_domain_available($domain)
	//{
$domain_name=$_POST['new_domain'];
$result = $client->checkDomainAvailability([
    'DomainName' => $_POST['new_domain'], // REQUIRED
    'IdnLangCode' => ''
    ]);
	//}
	//$result=is_domain_available($_POST['new_domain']);
if(!empty($result)){
	$result=$result->toArray();
	if(!empty($result)){
		$_SESSION['rdomain']=array("status"=>$result['Availability'],"domain"=>$domain_name);
	}
}
else{
	$_SESSION['rdomain']=array("status"=>"Some thing went wrong!","domain"=>$domain_name);
}

header("Location: /aws_r53/domain_home.php");


// }
?>