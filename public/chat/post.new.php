<?php
session_start();
header('Access-Control-Allow-Origin: *');
error_reporting(0);

	//print_r($_POST);
	//exit;
	
	//Array ( [subject] => Hello [userid] => 1 [name] => Admin User [attenderid] => 3 [type] => new [chatfile] => 1470982608340 [chattype] => 3 )
	
	$text = $_POST['subject'];
	if($_POST['name']=='')
	{
		$chatname=$_SESSION['userName'];
	}
	else
	{
		$chatname=$_POST['name'];
	}
	
	if($_POST['userid']=='')
	{
		$chatfrom='';
	}
	else
	{
		$chatfrom=$_POST['userid'];
	}

	if($_POST['attenderid']=='')
	{
		$attendedby='';
	}
	else
	{
		$attendedby=$_POST['attenderid'];
	}	
	
	if($_POST['chattype']=='')
	{
		$chat_type = 1;
	}
	else
	{
		$chat_type = $_POST['chattype'];
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
	
	
	

	if($_POST['type']=='new'){
		session_destroy();
		session_start();
		$dbname="crm_followon";
		$host="106.51.0.187";
		$dbuser="postgres";
		$dbpass="welcome-123";
		//$dbh = new PDO("pgsql:dbname=$dbname;host=$host", $dbuser, $dbpass);
	
		//to check chat req is exist in db
		if($chat_type == '1'){
			$chat_query = "SELECT * FROM crm_chat WHERE chat_email = '".$_POST['name']."' AND (chat_status='1' OR chat_status='2') ORDER BY created_on DESC";
		}
		elseif($chat_type == '2'){
			$chat_query = "SELECT * FROM crm_chat WHERE chat_from = '".$_POST['userid']."' AND (chat_status='1' OR chat_status='2') ORDER BY created_on DESC";
		}
		else{
			$chat_query = "SELECT * FROM crm_chat WHERE chat_from = '".$_POST['userid']."' AND chat_attended_by = '".$_POST['attenderid']."' AND (chat_status='1' OR chat_status='2') ORDER BY created_on DESC";
		}
		
		//echo $chat_query;
		//exit;
		$dbconn3 = pg_connect("host=106.51.0.187 port=5432 dbname=crm_followon user=postgres password=welcome-123");
		$res = pg_query($dbconn3, $chat_query);
		
		//print_r($res);
		//exit;
		
		$row = pg_fetch_all($res);
		pg_close($dbconn3);
		//print_r($row);
		//exit;
		
		//if chat req is already exist then avoid new entry in db
		if(!empty($row) && count($row) > 0){
			if(!empty($row['0']['chat_file'])){
				$filename = $row['0']['chat_file'];
			}
		}
		else{
			$chat_email = $chatname;
			$subject = $_POST['subject'];
			$filename = $_POST['chatfile'];
			$chatfrom = $_POST['userid'];
			$attendedby = $_POST['attenderid'];
			//$rating=$_POST['rating'];
			$rating=5;
			$chat_query = "";

			if($chat_type == '1'){
				$chat_query = "insert into crm_chat(chat_type, chat_subject, chat_email, chat_rating, chat_file, chat_status, created_on) values('$chat_type','$subject','$chat_email', '$rating','$filename','1',now())";
			}else{
				$chat_query = "insert into crm_chat(chat_type, chat_subject, chat_email, chat_attended_by, chat_rating, chat_file, chat_status, created_on, chat_from) values('$chat_type','$subject','$chat_email','$attendedby', '$rating','$filename','1',now(), '$chatfrom')";
			}
			
			//pg_query($chat_query);
			$dbconn3 = pg_connect("host=106.51.0.187 port=5432 dbname=crm_followon user=postgres password=welcome-123");
			$res = pg_query($dbconn3, $chat_query);
			
			if(!$res){
			  echo pg_last_error($dbconn3);
			}
			
			pg_close($dbconn3);
			
			
		}
	}
	else {
		$filename=$_POST['filename'];
	}

    $fp = fopen("loghtml/log.".$filename.".html", 'a');
    fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$chatname."</b>: <span style='color:".$textcolor.";'>".stripslashes(htmlspecialchars($text))."</span><br></div>");
    fclose($fp);
    if($_POST['name']!=''){
		$chatname = $_POST['name'];
    }
    echo $filename."~".$chatname;


?>
