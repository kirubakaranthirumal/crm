<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chat</title>
<link type="text/css" rel="stylesheet" href="css/style1.css" />


<!-- Contact Form CSS files -->
<link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />


<script src="js/script.js"></script>
</head>
 
<?php
include_once('includes/database.php');
session_start();
if (array_key_exists("login", $_GET)) {
    $oauth_provider = $_GET['oauth_provider'];
    if ($oauth_provider == 'twitter') {
        header("Location: login-twitter.php");
    } else if ($oauth_provider == 'facebook') {
        header("Location: login-facebook.php");
    }
}
error_reporting(0);
if($_SESSION['stream'] != '') {
	$fname = "loghtml/log.".$_SESSIO['stream'].".html";
        $t=time();
        $nfname=$fname.".".$t;
        $mvstatus=rename($fname,$nfname);
	touch($fname);
	chmod($fname,0777);
	$_SESSION['chatfile'] = $fname;
}
// Login Form
function loginForm(){
    echo'
    <div id="loginform">
    <form onsubmit="javascript:return login();" method="post">        
        <div class="loginwrapper">
            <div class="loginheading">Please login to continue:</div>
            <div class="logincontent">
            <div class="fieldrow">
                <div class="loginlabel">
                    <label for="name">Email:</label></div>
                <div>
                    <input type="text" name="username" id="username" tabindex="1" />
                </div>
            </div>
            <div class="fieldrow">
                <div class="loginlabel">
                    <label for="name">Password:</label>
                </div>
                <div>
                    <input type="password" name="password" id="password" tabindex="2" />
                </div>
            </div>
            <div class="loginwrapper">
                <div style="text-align:left;float:left;width:120px">&nbsp;</div>
                <div>
                    <input type="submit" name="enter" id="enter" value="Login" onclick="login()" />
                    <div id="error" class="error"></div>
                </div>
            </div>
             </div>
            <div style="text-align:center"><span style="color:#ACD8F0;">_____</span> Alternatively you can login using <span style="color:#ACD8F0;">_____</span></div>
            <div class="navigation">
                <a href="?login&oauth_provider=facebook" class="social btn"><!-- ng-click added here-->
                    <img src="img/fb-icon.png"  class="img-responsive"></img>
                </a> 
                <a href="?login&oauth_provider=twitter" class="social btn"><!-- ng-click added here-->
                    <img src="img/tw-icon.png" class="img-responsive"></img>
                </a> 
            </div>       
        <div class="secondarymenu">New User? <a href="index.new.php?mode=register">click here</a> to Register.<br><a href="index.new.php?mode=forgot-password">Forgot Password</a></span>
    </div>
    </form>
    </div>
    ';
}
// Register Form
function registerForm(){
    echo'
    <div id="loginform">
    <form onsubmit="javascript:return register();" method="post">        
        <div class="loginwrapper">
            <div class="loginheading">Register Now</div>
            <div class="logincontent">
            <div class="fieldrow">
                <div class="loginlabel">
                    <label for="name">Display Name:</label></div>
                <div>
                    <input type="text" name="fullname" id="fullname" tabindex="1" />
                </div>
            </div>
            <div class="fieldrow">
                <div class="loginlabel">
                    <label for="name">Email(Username):</label></div>
                <div>
                    <input type="text" name="username" id="username" tabindex="2"/>
                </div>
            </div>
            <div class="fieldrow">
                <div class="loginlabel">
                    <label for="name">Password:</label>
                </div>
                <div>
                    <input type="password" name="password" tabindex="3" id="password"/>
                </div>
            </div>
            <div class="fieldrow">
                <div class="loginlabel">
                    <label for="name">Confirm Password:</label>
                </div>
                <div>
                    <input type="text" name="cpassword" tabindex="4" id="cpassword"/>
                    <input type="hidden" name="procode" id="procode">
                </div>
            </div>
            <div class="loginwrapper">
                <div style="text-align:left;float:left;width:120px">&nbsp;</div>
                <div>
                    <input type="submit" name="enter" id="enter" value="Login" />
                    <div id="error" class="error"></div>
                </div>
            </div>
        </div>
        <div class="secondarymenu">Already Registered? <a href="index.new.php">click here</a> to Login.
        <br>Forgot Password? <a href="index.new.php?mode=forgot-password">click here</a></div>
    </div>
    </form>
    </div>
    ';
}
// Forgot Password Form
function forgotpassForm(){
    echo'
    <div id="loginform">
    <form onsubmit="javascript:return forgot();" method="post">        
        <div class="loginwrapper">
            <div class="loginheading">Enter e-mail ID to retrieve password reset link</div>
            <div class="logincontent">            
            <div class="fieldrow">
                <div class="loginlabel">
                    <label for="name">Email:</label></div>
                <div>
                    <input type="text" name="username" id="username" tabindex="2"/>
                </div>
            </div>            
            <div class="loginwrapper">
                <div style="text-align:left;float:left;width:120px">&nbsp;</div>
                <div>
                    <input type="submit" name="enter" id="enter" value="Get Mail" />
                    <div id="error" class="error"></div>
                </div>
            </div>
        </div>
        <div class="secondarymenu">New User? <a href="index.new.php?mode=register">click here</a> to Register.<br>Already Registered? <a href="index.new.php">click here</a> to Login.
        <br></div>
    </div>
    </form>
    </div>
    ';
}
 
function newChatRoom(){
    echo'
    <div id="loginform">
    <form  onsubmit="javascript:return addchatroom();" action="" method="post">
        <p>Please enter room name continue:</p>
        <div style="padding-bottom:10px;padding-left:20px;padding-top:10px;">
        <div style="text-align:left;float:left;width:20%;">
        <label for="name">Room Name:</label></div>
        <div  style="width:70%;">
        <input type="text" name="roomname" id="roomname"/>
        </div>
        </div>
        
        <div style="padding-bottom:10px;padding-left:20px;">
        <div style="text-align:left;float:left;width:   20%"></div>
        <div style="width:70%;">
        <input type="hidden" name="username" id="username" value='.$_SESSION['chat_uid'].' />
        <input type="submit" name="enter" id="enter" value="Save" onclick="addchatroom()" />
        </div>
        </div>
        <div id="error" class="error"></div>
    </form>
    </div>
    ';
}
 
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
        //$_SESSION['stream'] = $_GET['stream'];
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}
?>

<?php
if(!isset($_SESSION['chat_uid'])){
    if($_GET['mode']=='register')
    {
        registerForm();
    }
    else if($_GET['mode']=='forgot-password')
    {
        forgotpassForm();
    }
    else
    {
        loginForm();
    }
}
else if($_GET['mode']=='newchatroom')
{
newChatRoom();
}
else
{
$cls=$db->get("chat_last_session", ["last_stream"], [
    "uid" => $_SESSION['chat_uid']
]);    
?>
<div id="wrapper">      <!-- Start of Wrapper -->
    <div id="content">     <!-- Start of Content -->
        <div id="leftcontent"> <!-- Start of Left Content -->
            <div id="menu">
            <span class="menuitems"><a href="index.new.php?mode=newchatroom">New Chat Room</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="logout.php?logout">Logout</a></span>
            <p class="welcome">Welcome, <b><?php echo $_SESSION['chat_uname']; ?></b></p>
            <?php if($_SESSION['stream']==''){ if($cls['last_stream']!=''){?><p class="currentchatroom">Chat Room : <b><?php echo $cls['last_stream'];?></p><?php } }else{?><p class="currentchatroom">Chat Room : <b><?php echo $_SESSION['stream'];?></p><?php } ?>
    <!--        <p class="logout"><a id="exit" href="#">Exit Chat</a></p> -->
            <div style="clear:both"></div>
            </div>    
            <div id="chatbox"></div>
            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" size="50" />
                <input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
            </form>
        </div>
        <div id="rightcontent"> <!-- Start of Right Content -->
            <span class="chatroomheading">My Chat Rooms </span>
            <div id="mychatrooms"> 
                <?php 
                $datarooms=$db->select("chat_rooms", ["name"], [
                    "uid" => $_SESSION['chat_uid']
                ]);
                foreach($datarooms as $rooms){
               
                    echo "<li class='chatroomlist'>";
                        if($rooms['name']!=$_SESSION['stream']){
                            echo "<a href='setstream.php?stream=".$rooms['name']."'>".$rooms['name']."</a>";
                        }
                        else
                        {
                         echo $rooms['name']." (Current)";
                        }
                    echo "<a style='float:right;' href='javascript:invite(\"".$rooms['name']."\");'>Invite</a></li>";
                }
                ?>
            </div> 
            <span class="whoisonlineheading">Whois Online </span>
            <div id="whoisonline"> 
                <?php 
                $data=$db->select("chat_register", ["user_name"], [
                    "is_online" => 1
                ]);
                foreach($data as $online){
               
                    echo "<li class='chatroomlist'>".$online['user_name']."</li>";
                }
                ?>
            </div>
        </div>      <!-- End of Right Content -->
    </div> <!-- End of Content -->
</div>  <!-- End of Wrapper -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
function invite(cstream) {
    $.ajax({type:'POST', 
    url: 'getcontacts.php',
    data:{stream:cstream}, 
    success: function(response) {
            
        $('body').find('#basic-modal-content').html(response);
        $('#basic-modal-content').modal();

        
    }});

    return false;
}
function submitForm() {

    $.ajax({type:'POST', 
    url: 'email_send.php',
    data:$('#ContactForm').serialize(), 
    success: function(response) {
            
        $('#ContactForm').find('.form_result').html(response);
         $("#modal-form").css("display","none");

        
    }});

    return false;
}
$(document).ready(function(){

    $('#selecctall').click(function(event) {  //on click 
        alert("ASD");
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });


    <?php if(isset($_SESSION['chat_uid'])){?> loadLog(); <?php } ?>
	//If user submits the form
        var str4 = "post.new.php";
        var streamname = "<?php echo $_SESSION['stream']; ?>";

        var postfilename = str4.concat("?stream=",streamname);

	$("#submitmsg").click(function(){	
		var clientmsg = $("#usermsg").val();
        if(clientmsg!=''){
		$.post(postfilename, {text: clientmsg});				
                $("#usermsg").attr("value", "");
                document.getElementById("usermsg").value = "";
                loadLog();
		
    }
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
                var str2 = "<?php echo $_SESSION['stream'];?>";
//alert(str2);
                var str3 = ".html";
                <?php if($_SESSION['stream']==''){                        
                        ?>
                        var filename =  "loghtml/log.<?php echo $cls['last_stream'];?>.html";
                        <?php
                    }
                    else
                    {
                        ?>
                //var filename = str1.concat(str2,str3);
                var filename =  "loghtml/log.<?php echo $_SESSION['stream'];?>.html";
//                var filename = "<?php echo $_SESSION['chatfile'];?>";
                <?php }
                ?>
                //alert(filename);
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
	<?php if(isset($_SESSION['chat_uid'])){?>
	setInterval (loadLog, 2500);	//Reload file every 2500 ms or x ms if you w
    <?php }
    ?>
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
  
<div id="basic-modal-content"></div>
<script type='text/javascript' src='js/jquery.js'></script>
<script type='text/javascript' src='js/jquery.simplemodal.js'></script>
</body>
</html>
