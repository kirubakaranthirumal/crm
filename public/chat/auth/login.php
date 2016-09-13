<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: AUTHORIZATION');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
header('Content-type: application/json');
include("languages/en_GB.php");
include("config.class.php");
include("auth.class.php");
$data='';
include("database.php");

$config = new Config($dbh);
$auth = new Auth($dbh, $config, $lang);
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
@$username = $request->username;
@$password = $request->password;
@$login_type = $request->login_type;
@$uname_type = $request->uname_type;
@$full_name = $request->full_name;
@$procode = $request->procode;
@$hash = $request->hash;
session_start();
@$type=$request->type;
switch($type)
{
	case 'login':
	$data=$auth->login($username,$password,"0",$login_type,$uname_type,$full_name);
	if($data['error']=='false')
	{
		//$_SESSION['iptlworlduser2015']=$data['uid'];
	}
	break;
	case 'logout':
	session_destroy();
	$cookie_name = "iptlworlduser";
	setcookie($cookie_name, "", time()-3600);
	$data=$auth->logout($_SESSION['iptlworlduser2015']);
	
	break;
	case 'teams':
	$data=$auth->getTeam();
	break;
	case 'register':
	@$cpassword = $request->cpassword;
	$data=$auth->register($username,$password,$cpassword,$uname_type,$full_name,$procode);
	break;
	case 'activation':
	@$key = $request->key;
	$data=$auth->activate($key);
	break;
	case 'resend-activation-code':
	@$user = $request->user;
	$data=$auth->resendActivation($user,$uname_type);
	break;
	case 'forgot-pass':
	$data=$auth->requestReset($username);
	break;
}
/*if($_GET['type']=='activation')
{
@$key = $_GET['key'];
$data=$auth->activate($key);
echo "<br/><br/><center>Your account has been activated</center>";
}
else
{*/
echo json_encode($data);


/*if(!isset($_COOKIE[$config->cookie_name]) || !$auth->checkSession($_COOKIE[$config->cookie_name])) {
    header('HTTP/1.0 403 Forbidden');
    echo "Forbidden";

    exit();
}*/
?>