<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: AUTHORIZATION');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

include("languages/en_GB.php");
include("config.class.php");
include("auth.class.php");

$data='';
include("database.php");
include_once('includes/host_conf.php');
include_once('includes/mysql.lib.php');
$obj=new connect;

$config = new Config($dbh);
$auth = new Auth($dbh, $config, $lang);
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
@$username = $request->username;
@$password = $request->password;
@$login_type = $request->login_type;
@$uname_type = $request->uname_type;
@$full_name = $request->full_name;
@$hash = $request->hash;
@$username = $_REQUEST['username'];
@$password = $_REQUEST['password'];
@$login_type = $_REQUEST['login_type'];
@$uname_type = $_REQUEST['uname_type'];
@$full_name = $_REQUEST['full_name'];
@$room_name = $_REQUEST['roomname'];
@$procode = $_REQUEST['procode'];
@$hash = $_REQUEST['hash'];

session_start();
@$type=$_REQUEST['type'];

switch($type)
{
	case 'login':
	$data=$auth->login($username,$password,"0",$login_type,$uname_type);
	if($data['error']=='false')
	{
		//$_SESSION['iptlworlduser2015']=$data['uid'];
	}
	$_SESSION['stream']=$obj->getRow("chat_last_session","last_stream","where uid='".$data['uid']."'");
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
	@$cpassword = $_REQUEST['cpassword'];
	$data=$auth->register($username,$password,$cpassword,$uname_type,$full_name,$procode,$country_id_fetch,$ip_self);
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
	case 'send-invitations':
	$email = $_REQUEST['friendemail'];
	$stream = $_REQUEST['stream'];
	$uid = $_REQUEST['uid'];
	if($email!='')
   	{
   		$cid=$obj->getRow("chat_contacts","id","where email='".$email."'");
   		$check=$obj->getRow("chat_invitations","id","where cid='".$cid."' and rid='".$stream."'");
  		$data=$auth->requestInvitation($email,$stream,$uid,$check);  
  			
  	}	
	break;
	case 'chatroom':
	$data=$auth->newchatroom($username,$room_name);
	break;
	case 'approvechatroom':
	$cid = $_REQUEST['cid'];
	$rid = $_REQUEST['rid'];
	$data=$auth->approvechatroom($cid,$rid);
	break;
	case 'joinchatroom':
	$name = $_REQUEST['name'];
	$cid = $_REQUEST['cid'];
	$rid = $_REQUEST['rid'];
	$data=$auth->joinchatroom($cid,$name,$rid,'2');
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
if($type!='send-invitations'){
echo $data['error']."~".$data['message']."~".$type."~".$data['email']."~".$room_name."~".$data['cid']."~".$data['rid'];
}
else
{
	if($data['error']=='1')
	{
		echo "<br><br><center>".$data['message'];
	}
	else
	{
	echo "<br><br><center>".$data['message'];
	}

}
/*if(!isset($_COOKIE[$config->cookie_name]) || !$auth->checkSession($_COOKIE[$config->cookie_name])) {
    header('HTTP/1.0 403 Forbidden');
    echo "Forbidden";

    exit();
}*/
?>