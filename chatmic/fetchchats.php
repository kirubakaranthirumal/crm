<?php
error_reporting(0);
$con=mysql_connect("localhost","root","");
mysql_select_db("chat",$con);
$result=mysql_query("select * from chat_history where chat_status='1'");
while($row=mysql_fetch_array($result))
{
	$chats[]=array("subject"=>$row['subject'],"email"=>$row['email']);
}
$data=array("chats"=>$chats,"chatcount"=>mysql_num_rows($result));
echo json_encode($data);
?>