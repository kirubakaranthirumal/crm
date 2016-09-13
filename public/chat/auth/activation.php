<?php
//header('Content-type: application/html');
include("languages/en_GB.php");
include("config.class.php");
include("auth.class.php");
include("database.php");
$data='';

$config = new Config($dbh);
$auth = new Auth($dbh, $config, $lang);


@$key = $_GET['key'];
$data=$auth->activate($key);
echo "<br><center><b>".$data['message']."</b>";


?>