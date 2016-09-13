<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chat</title>

<!-- Contact Form CSS files -->

<script src="js/script.js"></script>

<style>

#loginform,#chat{
padding:10px;
background:#3c8dbc;
width:30%;
position:fixed;
right:0px;
bottom:0px;
color:white;
}
#chatbox {
    text-align:left;
    margin:0 auto;
    margin-bottom:25px;
    padding:10px;
    background:#fff;
    height:365px;
    color:black;
    border:1px solid #ACD8F0;
    overflow:auto; }
</style>
</head>
<body>
<?php error_reporting(0);
session_start();
?>
<div id="loginform">
	<div id="entryform" style="padding-bottom:20px;">
    <form  onsubmit="javascript:return addchatroom();" action="" method="post">
    <span id="close" style="float:right;">X</span>
        <p>Please enter your name & subject to start chat:</p>
        <div style="padding-bottom:10px;padding-left:20px;padding-top:10px;">
        <div style="text-align:left;float:left;width:20%;">
        <label for="name">Name:</label></div>
        <div  style="width:70%;">
        <input type="text" name="name" id="name"/>
        <input type="hidden" name="rating" id="rating" value="5"/>
        </div>
        </div>
        <div style="padding-bottom:10px;padding-left:20px;padding-top:10px;">
		        <div style="text-align:left;float:left;width:20%;">
		        <label for="name">Subject:</label></div>
		        <div  style="width:70%;">
		        <input type="text" name="subject" id="msg"/>
		        </div>
        </div>

        <div style="padding-bottom:10px;padding-left:20px;">
        <div style="text-align:left;float:left;width:   20%"></div>
        <div style="width:70%;">
        <input type="hidden" name="username" id="username" value='.$_SESSION['chat_uid'].' />
        <input type="submit" name="submitmsg" id="submitmsg" style="float:right;" value="Start Chat" />
        </div>
        </div>
        <div id="error" class="error"></div>
    </form>
    </div>
    <div id="button" ><input type="button" value="Live Chat" id="livechat" /></div>
    </div>
    <div id="chat">
    <span id="closechat" style="float:right;clear:both">X</span>
		<div id="chatbox"></div>
		<div width="100%"><input type="text" id="msg1"><input type="button" id="submitmsg1" value="submit"><input type="hidden" name="name1" id="name1"></div>

	</div>
<div id="basic-modal-content"></div>
<script type='text/javascript' src='js/jquery.js'></script>
<script type='text/javascript' src='js/jquery.simplemodal.js'></script>
<script>
$(document).ready(function() {
      $("#entryform").hide();
      $("#chat").hide();
      $("#livechat").click(function() {
  			 $("#entryform").show("slow");
	  });
	  $("#close").click(function() {
	    			 $("#entryform").hide("slow");
	  });
	  $("#closechat").click(function() {
	  	    			 $("#chat").hide("slow");
$.get( "closechat.php", function( data ) {
});


	  });
});


	$("#submitmsg").click(function(){
	var str4 = "post.new.php";
	        var streamname = "firstchat";

	        var postfilename = str4.concat("?stream=",streamname);
			var clientmsg = $("#msg").val();
			var clientname = $("#name").val();
			var rating = $("#rating").val();
        if(clientmsg!=''){
		$.post(postfilename, {subject: clientmsg,name:clientname,rating:rating,type:'new',chatfile:'<?php echo "chat_".rand(0,99999999999);?>'},function( data ) {
			console.log(data);
			 loadLog(data);
   //setInterval (loadLog(data), 2500);
});
                $("#msg").attr("value", "");
                document.getElementById("msg").value = "";
               // setInterval (loadLog, 2500);
                //loadLog();
                $("#entryform").hide();
                $("#chat").show("slow");

    }
    return false;
	});
	$("#submitmsg").keypress(function(){
		var str4 = "post.new.php";
		        var streamname = "firstchat";

		        var postfilename = str4.concat("?stream=",streamname);
			var clientmsg = $("#msg").val();
			var clientname = $("#name").val();
			var rating = $("#rating").val();
	        if(clientmsg!=''){
			$.post(postfilename, {subject: clientmsg,name:clientname,rating:rating, type:'new',chatfile:'<?php echo "chat_".rand(0,99999999999);?>'},function( data ) {
			console.log(data);
			 loadLog(data);

});
	                $("#msg").attr("value", "");
	                document.getElementById("msg").value = "";

	                //loadLog();
	                $("#entryform").hide();
	                $("#chat").show("slow");
	                $("#msg1").focus();

	    }
	    return false;
	});
	$("#submitmsg1").click(function(){
			var str4 = "post.new.php";
			        var streamname = "firstchat";

			        var postfilename = str4.concat("?stream=",streamname);
				var clientmsg = $("#msg").val();
				var clientname = $("#name").val();
				var rating = $("#rating").val();
		        if(clientmsg!=''){
				$.post(postfilename, {subject: clientmsg, name:clientname, rating:rating, type:'onhold'},function( data ) {
			console.log(data);
   loadLog(data);
});
		                $("#msg1").attr("value", "");
		                document.getElementById("msg1").value = "";
		                //loadLog();


		                $("#msg1").focus();

		    }
		    return false;
	});
$("#submitmsg1").keypress(function(){

	var str4 = "post.new.php";
	        var streamname = "firstchat";

	        var postfilename = str4.concat("?stream=",streamname);
		var clientmsg = $("#msg1").val();
		var clientname = $("#name1").val();
		var rating = $("#rating").val();
        if(clientmsg!=''){
		$.post(postfilename, {subject: clientmsg, name:clientname, rating:rating, type:'onhold'},function( data ) {
			console.log(data);
   loadLog(data);
});
                $("#msg1").attr("value", "");
                document.getElementById("msg1").value = "";

                //loadLog();


                $("#msg1").focus();

    }
    return false;
	});

	//loadLog();

	function loadLog(filename){

	                var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
	                var str1 = "loghtml/log.";
	                var str2 = "firstchat";
	//alert(str2);
	                var str3 = ".html";

	                        var filename =  "loghtml/log."+filename+".html";


	                $.ajax({
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
</script>
</body>
</html>
