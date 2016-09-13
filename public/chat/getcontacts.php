<script>
$(document).ready(function(){
    $('#selecctall').click(function(event) {  //on click 
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
    });
</script>
<?php 
session_start();
include_once('includes/database.php');

$app=$db->select("chat_register", ["user_name","email"], [
               
                ]);
//<h3>Contact(s) List</h3>

$stream=$_REQUEST['stream'];
echo'<div style="border-bottom:1px solid #01496F;padding-bottom:5px"><span style="color:white">Invite your friends for the chat room "'.$_REQUEST['stream'].'"</span></div><form action="#" method="post" id="ContactForm" onsubmit="return submitForm();">
<div id="modal-form">
<div style="border-bottom:1px solid #01496F;padding-bottom:10px;padding-top:10px;"><span style="color:white">Enter Email : <input type="text" style="width:250px;" name="friendemail" id="friendemail">&nbsp;<input type="submit" name="submit" style="margin-left:45px;" value="Invite" /></span></div>
            <div class="form_result"> </div>
            <ul class="chk-container" style="list-style:none;height:280px;">
<li style="float:right;display:none"><input type="checkbox" id="selecctall" onclick="selectall()" style="display:none;"/> Selecct All</li>';
foreach($app as $app1)
{
                if($app1['user_name']!=='')
                {
                //echo'<li><input type="checkbox" class="checkbox1" name="check[]" value="'.$app1['email'].'">'.$app1['user_name'].'</li>';
                }
                else
                {
                    
                }
}   
    
echo'</ul>
<div style="border-top:1px solid #01496F;padding-top:10px">
<input type="hidden" name="type" id="type" value="send-invitations">
<input type="hidden" name="uid" id="uid" value="'.$_REQUEST['uid'].'">
<input type="hidden" name="stream" id="stream" value="'.$_REQUEST['stream'].'">


</div>
</div></form>';
?>