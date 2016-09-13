<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Parvai Video in the Background</title>
    <meta name="description" content="Big Background Parvai Video" />
    <meta name="viewport" content="width=device-width">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:900&text=ABCDEFGHIJKLMNOPQRSTUVWXYZ' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="bower_components/BigVideo/css/bigvideo.css">
    <script src="bower_components/modernizr/modernizr-2.8.3.dev.js"></script>
    <link rel="stylesheet" href="css/m3u8.css">
    <script>
    	function hide_chat()
    	{
    		document.getElementById('wrapper').style.display="none";
    		document.getElementById('hide_chat').style.display="none";
    		document.getElementById('show_chat').style.display="block";

    	}
    	function show_chat()
		{
		    		document.getElementById('wrapper').style.display="block";
		    		document.getElementById('show_chat').style.display="none";
		    		document.getElementById('hide_chat').style.display="block";

    	}

    </script>
<style.
html,body,main {
    margin:0;
    padding:0;
}
</style>
</head>
<body>

    <div class="main">
<div id="overview" class="box" style="max-height: 400px; overflow: auto;">

    <?php
    	if($_GET['name'] != '')
    	{
    ?>
    <input type="button" id="hide_chat" value="Hide Messages" onclick="hide_chat()" />
    <input type="button" id="show_chat" value="Show Messages" onclick="show_chat()" style="display:none" />
    
    <?php } ?>

        
<?php
error_reporting(0);
session_start();

if($_GET['stream'] == ""){

?>
<p style="color:red">Please enter your stream</p>
<input type="button" value="Enter your stream here" onclick="window.location.href='getstream.php'" />
<?php
	}
if($_SESSION['stream'] != ""){


}
else if($_GET['name'] != '') {
	$_SESSION['name']=$_GET['name'];
	$_SESSION['stream'] = $_GET['stream'];
	$fname = "loghtml/log.".$_GET['stream'].".html";
	touch($fname);
	chmod($fname,0777);
	$_SESSION['chatfile'] = $fname;
}
function loginForm(){
if($_GET['stream']!='')
{
    echo'
    <div>
    <form action="examplem3u8.new.php?stream='.$_GET["stream"].' method="post">
           <p>Please enter your name to continue:</p>
           <label for="name" style="color:white">Name:</label>
           <input type="text" name="name" id="name" />
           <input type="hidden" name="stream" id="stream" value="'.$_GET["stream"].'" />
           <input type="submit" value="Enter" />
    </form>
    </div>
   ';
   echo "<br><input type='button' value='Exit' onclick=window.location.href='getstream.php' />";


   }
}

if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}

if(!isset($_SESSION['stream'])){
    loginForm();
}
else{
?>
<div id="wrapper">
    <div id="menu">
        <p class="welcome">Welcome, <b><?php echo $_GET['name']; ?></b></p>
        <p class="logout"><a id="exit" href="#">Exit Chat</a></p> <br>
        <div style="clear:both"></div>
    </div>
    <div id="chatbox" style="width:auto"></div>

    
</div></div>
<div id="setup" class="box">
<form name="message" action="">
        <input name="usermsg" type="text" id="usermsg"  />
        <input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
    </form>
<div class="toggle-btn">
            <label><input type="checkbox" checked id="video-toggle" /> Play Video</label>
        </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
	//If user submits the form
	var str1 = "post.new.php";
	var streamname = "<?php echo $_SESSION['stream']; ?>";

	var postfilename = str1.concat("?stream=",streamname);
	$("#submitmsg").click(function(){
		var clientmsg = $("#usermsg").val();
//alert(clientmsg);
		$.post(postfilename, {text: clientmsg});
		$("#usermsg").attr("value", "");
		//$("#usermsg").val() = "";
		document.getElementById("usermsg").value ="";
		return false;


	});

$("#exit").click(function(){

			destroy_session();
		});

	

	//Load the file containing the chat log
	function loadLog(){
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
		var str1 = "loghtml/log.";
		var str2 = "<?php echo $_GET['stream'];?>";
		var str3 = ".html";
//		var filename = str1.concat(str2,str3);
		var filename = "<?php echo $_SESSION['chatfile'];?>";
		$.ajax({
//			url: "loghtml/log.html",
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
     var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	               window.location.href="examplem3u8.new.php?stream=<?php echo $_GET['stream'] ?>";
	            }
	        }
	        xmlhttp.open("GET", "destroy_session.php", true);
        xmlhttp.send();
}
</script>
<?php
if(isset($_GET['logout'])){

    //Simple exit message
//    $fp = fopen("loghtml/log.".$_GET['stream']."html", 'a');
    $fp = fopen($_SESSION['chatfile'], 'a');
    fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has left the chat session.</i><br></div>");
    fclose($fp);

    session_destroy();
    header("Location: examplem3u8.new.php?stream=".$_SESSION['stream']); //Redirect the user
}
?>
</div>
    <!-- BigVideo Dependencies -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="bower_components/jquery/jquery.min.js"><\/script>')</script>
    <script src="bower_components/jquery-ui/ui/jquery-ui.js"></script>
    <script src="bower_components/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <!-- <script src="//vjs.zencdn.net/4.3/video.js"></script> -->
    <script src="bower_components/video.js/video.dev.js"></script>
    <script src="videohls/videojs-media-sources.js"></script>
    <script src="videohls/videojs.hls.js"></script>

    <!-- BigVideo -->
    <script src="bower_components/BigVideo/lib/bigvideo.js"></script>
 <script>
$(function() {

 var streamname = "<?php echo 'parvaivids/'.$_GET['stream'].'.m3u8'; ?>";
//alert(streamname);


            var BV = new $.BigVideo();
			BV.init();
//            if (Modernizr.touch) {
//                BV.show('img/background-dock.jpg');
//            } else {
//                BV.show('vids/dock.mp4',{ambient:true});
//                BV.show(streamname,{ambient:true});
                BV.show(streamname,{ambient:false});
//                BV.show(type: "vnd.apple.mpegurl", src: streamname);
//          }
            
// Video Play/Pause toggle
            $('#video-toggle').on('click', function(e) {
                if (this.checked)   BV.getPlayer().play();
                else                BV.getPlayer().pause();
            })



	    });


    </script>

    <!-- Demo -->

</body>
</html>
