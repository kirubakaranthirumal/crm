<?php
error_reporting(0);
$mode="live";
if($mode=="development"){
$dbh = new PDO("mysql:host=localhost;dbname=test_chat", "root", "");
$con=mysql_connect("localhost","root","");
mysql_select_db("test_chat");
}
else
{
$dbh = new PDO("mysql:host=10.11.0.187;dbname=test_chat", "followondbuser", "followondbpa55");
$con=mysql_connect("10.11.0.187","followondbuser","followondbpa55");
mysql_select_db("test_chat");
}
?>
