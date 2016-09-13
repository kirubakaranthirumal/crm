<!DOCTYPE html>
<html>
<head>
<style>
body {background-color:lightgray}
h1   {color:blue}
p    {color:green}
</style>
</head>
<body>
<script>
function getStream()
{
        var stream_name = document.getElementById('name').value;
		var yes_checked = document.getElementById('example_0').checked;
		var no_checked = document.getElementById('example_1').checked;		
		
        if(stream_name=='')
        {
                document.getElementById('error').innerHTML = "Please enter Stream name";
        }
        if(stream_name!='')
        {
			if(yes_checked==true)
			{
				window.location.href="examplem3u8.new.php?stream="+stream_name;
			}
			else
			{
                document.getElementById('error').innerHTML = "Please Accept Agreement";			
			}
        }

}
</script>
<center>
<form >

  <div class='conlabel'>Broadcast Name:
      <input type="text" id="name" value = "" placeholder=""  />
       <span id = "error">*</span>
       <input type="button" name="submit" value="Submit" onClick="getStream()" /></div>
<br>
  <div class='conlabel'></div>
  
  <div class='conlabel'>Before watching the live video <br>Please go through the Terms and Conditions and<br>  Privacy Policy below.<br>
If you feel that there is objectionable content <br>in these video please email to us at <br>info@i-ascendance.com giving the Stream name <br>in the subject and we will remove the content <br>within 24 hours of receiving the email:
<a href="mailto:info@i-ascenance.com" >Send Mail</a>
</p>
 Do you agree to te Terms and Conditions and Privacy Policy?</div>
  <table width="100">
          <tr>
            <td><label>
              <input onClick="document.getElementById('name').disabled=false;document.getElementById('field2').disabled=true;getStream()" type="radio" name="example" value="Yes" id="example_0" required/>
              Yes</label></td>
      </tr>
      <tr>
        <td><label>
          <input onClick="document.getElementById('name').disabled=true;document.getElementById('field2').disabled=false" type="radio" name="example" value="No" id="example_1" required/>No</label></td>
      </tr>
<a href="/Legal/PrivacyPolicy" >Privacy Policy     </a>
&nbsp;&nbsp;<a href="/Legal/Disclaimer" > Disclaimer</a>

</table>
</form>
</center>
</body>
</html>
