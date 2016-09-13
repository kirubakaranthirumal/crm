<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chat</title>
<link type="text/css" rel="stylesheet" href="css/style1.css" />
</head>
 
<?php
session_start();
error_reporting(0);
if(isset($_SESSION['chat_user_id'])){
header('location:login.new.php');
}
else
{
    
}
if($_GET['stream'] != '') {
	$_SESSION['stream'] = $_GET['stream'];
	$fname = "loghtml/log.".$_GET['stream'].".html";
        $t=time();
        $nfname=$fname.".".$t;
        $mvstatus=rename($fname,$nfname);
	touch($fname);
	chmod($fname,0777);
	$_SESSION['chatfile'] = $fname;
}
 
function loginForm(){
    $streamnameatlogin = $_SESSION['stream'];
    echo'
    <div id="loginform">
    <form action="index.new.php?stream='.$streamnameatlogin.'" method="post">
        <p>Please enter your name to continue:</p>
        <label for="name">User Name:</label>
        <input type="text" name="username" id="username" onkeyup="login();" />
        <label for="name">Password:</label>
        <input type="text" name="password" id="password"  onkeyup="login();" />
        <input type="hidden" name="stream" id="stream" value='.$streamnameatlogin.' />
        <input type="submit" name="enter" id="enter" value="Enter" />
    </form>
    </div>
    ';
}
 
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
        $_SESSION['stream'] = $_GET['stream'];
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}
?>

<?php
if(isset($_SESSION['name'])){
    loginForm();
}
else{
?>
<div id="wrapper">
    <div id="menu">
        <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
<!--        <p class="logout"><a id="exit" href="#">Exit Chat</a></p> -->
        <div style="clear:both"></div>
    </div>    
    <div id="chatbox"></div>
     
    <form name="message" action="">
        <input name="usermsg" type="text" id="usermsg" size="63" />
        <input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
    </form>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
	//If user submits the form
        var str4 = "post.new.php";
        var streamname = "<?php echo $_SESSION['stream']; ?>";

        var postfilename = str4.concat("?stream=",streamname);

	$("#submitmsg").click(function(){	
		var clientmsg = $("#usermsg").val();
		$.post(postfilename, {text: clientmsg});				
                $("#usermsg").attr("value", "");
                document.getElementById("usermsg").value = "";
		return false;
	});
	
$("#exit").click(function(){
				var exit = true;
//confirm("Are you sure you want to end the session?");
				if(exit==true){ destroy_session(); }
		});
	//Load the file containing the chat log
                function loadLog(){

                var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
                var str1 = "loghtml/log.";
                var str2 = "<?php echo $_GET['stream'];?>";
//alert(str2);
                var str3 = ".html";

                //var filename = str1.concat(str2,str3);
                var filename = "log.html";

//                var filename = "<?php echo $_SESSION['chatfile'];?>";
                $.ajax({
//                      url: "log.html",
                        url: filename,
                        cache: false,
                        success: function(html){
                                $("#chatbox").html(html); //Insert chat log into the #chatbox div
				
				//Auto-scroll			
				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
	
	setInterval (loadLog, 2500);	//Reload file every 2500 ms or x ms if you w
});
</script>
<?php
}
?>

<script type="text/javascript">
function destroy_session(){
     var thisphp = "index.new.php";
     var streamname = "<?php echo $_SESSION['stream']; ?>";

     var redirect = thisphp.concat("?stream=",streamname);
     var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                       window.location.href=redirect;
                    }
                }
                xmlhttp.open("GET", "destroy_session.php", true);
        xmlhttp.send();
}
</script>

<?php 
if(isset($_GET['logout'])){ 
     
    //Simple exit message
//    $fp = fopen("log.html", 'a');
    $chatfile = "loghtml/log.".$_SESSION['stream'].".html";
    $fp = fopen($chatfile, 'a');
    fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has left the chat session.</i><br></div>");
    fflush($fp);
    fclose($fp);
     
    session_destroy();
    header("Location: index.new.php?stream=".$_SESSION['stream']); //Redirect the user
}
?>

</body>
</html>
