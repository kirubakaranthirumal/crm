<?php
error_reporting(0);
$con=mysql_connect("localhost","root","");
mysql_select_db("chat",$con);
$resultopen=mysql_query("select * from tickets where ticket_status='1'");
$resultonhold=mysql_query("select * from tickets where ticket_status='2'");
$resultclosed=mysql_query("select * from tickets where ticket_status='3'");

$data=array("open"=>mysql_num_rows($resultopen),"onhold"=>mysql_num_rows($resultonhold),"closed"=>mysql_num_rows($resultclosed));
echo json_encode($data);
?>