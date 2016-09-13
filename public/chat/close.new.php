<?php
	session_start();
	header('Access-Control-Allow-Origin: *');
	error_reporting(0);
	
	$filename = '';
	if($_POST['filename']!=''){
		$filename = $_POST['filename'];
	}	
	
	$dbconn3 = pg_connect("host=106.51.0.187 port=5432 dbname=crm_followon user=postgres password=welcome-123");

	if($_POST['type']=='closed'){
		$chat_query = "UPDATE crm_chat SET chat_status = '3' WHERE chat_file = ". $_POST['filename'];
	}
	
	$result = pg_query($chat_query);
	
	$fp = fopen("loghtml/log.".$_POST['filename'].".html", 'a');
	fwrite($fp, "<span style='color:red;'>Conversation closed</span><br></div>");
	fclose($fp);
	
	echo $filename."~".'end';
	
?>