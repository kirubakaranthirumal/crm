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
$email = $_REQUEST['check'];
if($email!='')
   {
  		$email2=implode(',',$email);
  		$data=$auth->requestReset($email2);
  	}
  	echo "Invitations has been sent";
