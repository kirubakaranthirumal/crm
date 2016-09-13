<?php
session_start();
header('Access-Control-Allow-Origin: *');
error_reporting(0);
    $text = $_POST['subject'];
	if($_POST['name']=='')
	{
		$chatname=$_SESSION['userName'];
	}
	else
	{
	$chatname=$_POST['name'];
	}
	if($_POST['usertype']=='admin')
		{
		$textcolor="green";
		$chatname=$_SESSION['userName'];
		}
		else
		{
		$textcolor="red";
		$chatname=$_POST['name'];
	}
	$dbconn3 = pg_connect("host=106.51.0.187 port=5432 dbname=crm_followon user=postgres password=welcome-123");

	if($_POST['type']=='new')
	{
	session_destroy();
	session_start();
	$dbname="crm_followon";
	$host="106.51.0.187";
	$dbuser="postgres";
	$dbpass="welcome-123";
	//$dbh = new PDO("pgsql:dbname=$dbname;host=$host", $dbuser, $dbpass);

	$chat_email=$_POST['name'];
	$subject=$_POST['subject'];
	$filename=$_POST['chatfile'];
	//$rating=$_POST['rating'];
	$rating=5;

	$chat_query = "insert into crm_chat(chat_type, chat_subject, chat_email, chat_rating, chat_file, chat_status, chat_created_on) values(1,'$subject','$chat_email',$rating,'$filename',1,now())";

	//echo $chat_query;
	//exit;

	pg_query($chat_query);
	pg_query("insert into crm_chat_history(chat_id,chat_text) values('".$filename."','<div class='msgln'>(".date("g:i A").") <b>".$chatname."</b>: <span style='color:".$textcolor.";'>".stripslashes(htmlspecialchars($text))."</span><br></div>')");
	$_SESSION['chatfilename']=$_POST['chatfile'];
	}
	else
	{
	$filename=$_POST['filename'];
	}

    $fp = fopen("loghtml/log.".$filename.".html", 'a');
    fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$chatname."</b>: <span style='color:".$textcolor.";'>".stripslashes(htmlspecialchars($text))."</span><br></div>");
    fclose($fp);
    if($_POST['name']!=''){
    $_SESSION['chatusername']=$_POST['name'];
    }
    echo $_SESSION['chatfilename']."~".$chatname;


?>
