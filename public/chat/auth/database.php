<?php
error_reporting(0);
$mode="live";
if($mode=="development"){
$dbh = new PDO("mysql:host=localhost;dbname=chat", "root", "");
$con=mysql_connect("localhost","root","");
mysql_select_db("chat");
}
else
{
$dbh = new PDO("mysql:host=10.11.0.187;dbname=chat", "root", "");
$con=mysql_connect("localhost","root","");
mysql_select_db("chat");
}
?>
