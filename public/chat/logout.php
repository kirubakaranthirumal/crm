<?php 
 ob_start(); 
 session_start();
 include_once("auth/database.php");   
    //Simple exit message
//    $fp = fopen("log.html", 'a');
 	if(isset($_SESSION['stream'])){
	    $chatfile = "loghtml/log.".$_SESSION['stream'].".html";
	    $fp = fopen($chatfile, 'a');
	    //fwrite($fp, "<div class='msgln'>(".date("g:i A").") : <i>". $_SESSION['chat_uname'] ." has left the chat session.</i><br></div>");
	    fflush($fp);
	    fclose($fp);
	}	
	$stmt=$dbh->prepare("select id from chat_last_session where uid='".$_SESSION['chat_uid']."'");
	$stmt->execute();
	$count = $stmt->rowCount();
	if($count=='0'){$dbh->query("insert into chat_last_session values('','".$_SESSION['chat_uid']."','".$_SESSION['chat_utype']."','".$_SESSION['chat_rid']."','".$_SESSION['stream']."')"); }else{$dbh->query("update chat_last_session set last_stream='".$_SESSION['stream']."',last_stream_id='".$_SESSION['chat_rid']."' where uid='".$_SESSION['chat_uid']."' and utype='".$_SESSION['chat_utype']."'");}
    $dbh->query("update chat_register set is_online='0' where id='".$_SESSION['chat_uid']."'");
    $dbh->query("update chat_online set is_active='0' where uid='".$_SESSION['chat_uid']."' and otype='".$_SESSION['chat_utype']."'");
    session_destroy();
    header("location: index.php"); //Redirect the user

?>