<?php
session_start();
include_once('includes/host_conf.php');
include_once('includes/mysql.lib.php');
$obj=new connect;
$rid=$obj->getRow("chat_rooms","id","where name='".$_GET['stream']."'");
if(isset($_SESSION['chat_uid']))
{
$obj->query("update chat_online set rid='".$rid."',is_active='1' where uid='".$_SESSION['chat_cid']."' and otype='".$_SESSION['chat_utype']."'");
}
else
{
$obj->query("update chat_online set rid='".$rid."' where uid='".$_SESSION['chat_uid']."' and otype='".$_SESSION['chat_utype']."'");	
}

$_SESSION['stream']=$_GET['stream'];
$_SESSION['chat_rid']=$rid;

header('location:index.php');
?>