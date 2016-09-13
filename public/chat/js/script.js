function getHTTPObject() {
  var xmlhttp;

  if(window.XMLHttpRequest){
    xmlhttp = new XMLHttpRequest();
  }
  else if (window.ActiveXObject){
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    if (!xmlhttp){
        xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
    }

}
  return xmlhttp;


}
var http = getHTTPObject(); // We create the HTTP Object
var site_url="https://beta.cricketgateway.com/chat/auth/";
/*
	Funtion Name=requestInfo
	Param = url >> Url to call : id = Passing div id for multiple use ~ as a seprator for eg. div1~div2 :
	redirectPage >> if you like to redirect to other page once the event success then
	the response text = 1 and the redirectPage not left empty
*/
function login()
{
	var username=document.getElementById('username').value;
	var password=document.getElementById('password').value;
	var login_type='normal';
	requestInfo3(site_url+'login_dev.php?type=login&username='+username+'&password='+encodeURIComponent(password)+'&login_type='+login_type,'error','');
	return false;
}
function joinchatroom()
{
	var name=document.getElementById('name').value;
	var cid=document.getElementById('cid').value;
	var rid=document.getElementById('rid').value;
	requestInfo3(site_url+'login_dev.php?type=joinchatroom&name='+name+'&cid='+cid+'&rid='+rid,'error','');
	return false;
}
function forgot()
{
	var username=document.getElementById('username').value;
	var login_type='normal';
	requestInfo3(site_url+'login_dev.php?type=forgot-pass&username='+username,'error','');
	return false;
}
function addchatroom()
{
	var name=document.getElementById('roomname').value;
	var username=document.getElementById('username').value;

	requestInfo3(site_url+'login_dev.php?type=chatroom&username='+username+'&roomname='+name,'error','');
	return false;
}
function approve(cid,rid)
{

	requestInfo3(site_url+'login_dev.php?type=approvechatroom&cid='+cid+'&rid='+rid,rid,'');
	return false;
}
function register()
{
	alert(site_url);
	var username=document.getElementById('username').value;
	var password=document.getElementById('password').value;
	var cpassword=document.getElementById('cpassword').value;
	var fullname=document.getElementById('fullname').value;
	var procode=document.getElementById('procode').value;
	var login_type='normal';
	requestInfo3(site_url+'login_dev.php?type=register&username='+username+'&password='+encodeURIComponent(password)+'&login_type='+login_type+'&procode='+procode+'&cpassword='+encodeURIComponent(cpassword)+'&uname_type=email&full_name='+fullname,'error','');
	return false;
}
function getSub(val)
{
requestInfo5('getSub.php?cid='+val,'subcid','');
}
function getSubc(val)
{
requestInfo5('getSubc.php?subcid='+val,'level2subid','');
}
function checksession(val)
{
requestSession('get_user_session.php?referer=iptl-tv','','');
}
function getMatch(val)
{
requestInfo5('getMatch.php?d='+val,'category','');
}
function takephoto()
{
sweetAlert('Please take another photo to upload');
}
function photolimitover()
{
sweetAlert("You have reached today's limit");
}
function loadmypoints()
{

requestInfo5('my_points.php','mypoints','');
	//alert();
}

function loadvalues()
{

requestInfo5('leaderboards.php','todayleaderboard~leagueleaderboard','');

	//alert();

}

 function updatephoto()
      {
requestInfo2('mobile/photoshare/self_photo.php','photolist~photoleft~','');
document.getElementById('uploadbtnlink').removeAttribute("onclick");
document.getElementById('uploadbtnlink').setAttribute('onclick','takephoto();');
      }
      function checkphotolimit()
      {
requestInfo2('mobile/photoshare/check_photo_limit.php','photolist~photoleft','');
document.getElementById('uploadbtnlink').removeAttribute("onclick");
document.getElementById('uploadbtnlink').setAttribute('onclick','takephoto();');
      }
      function requestInfo2(url,id,redirectPage) {
		var temp=new Array();
			http.open("GET", url, true);
			http.onreadystatechange = function() {
				if (http.readyState == 4) {
				  if(http.status==200) {
			  		var results=http.responseText;
					if(redirectPage=="" || results!="1") {

						var temp=id.split("~"); // To display on multiple div
						//alert(temp.length);
						var r=results.split("~"); // To display multiple data into the div
						//alert(temp.length);
						if(temp.length>1) {
							for(i=0;i<temp.length;i++) {

								document.getElementById(temp[i]).innerHTML=r[i];
							}
						} else {
							document.getElementById('load').innerHTML = '';
							document.getElementById(id).innerHTML = results;
						}
					} else {

						window.location.href=redirectPage;
					}
				  }
  				}
			};
			http.send(null);
       }
	   function requestInfo3(url,id,redirectPage) {
//alert(redirectPage);
		document.getElementById(id).innerHTML="Validating..."
		var temp=new Array();
			http.open("GET", url, true);
			http.onreadystatechange = function() {
				if (http.readyState == 4) {
				  if(http.status==200) {
			  		var results=http.responseText;
					if(redirectPage=="" || results!="1") {

						var temp=id.split("~"); // To display on multiple div
						//alert(temp.length);
						var r=results.split("~"); // To display multiple data into the div
						//alert(temp.length);

						if(temp.length>1) {
							for(i=0;i<temp.length;i++) {
								if(temp[i]=='feesdetail')
								{
								document.getElementById(temp[i]).innerHTML=r[i];
								}
								else
								{
								document.getElementById(temp[i]).value=r[i];
								}
							}
						} else {
						var message=results.split("~");
						if(message[0]=='1')
						{
							document.getElementById(id).innerHTML = message[1];
						}
						else
						{
							if(message[2]=='login')
							{
								document.getElementById(id).innerHTML="Loggging In. Please Wait...";
								location.href="index.php";
							}
							else if(message[2]=='register')
							{
								document.getElementById(id).innerHTML="Registering. Please Wait...";
								location.href="index.php";
								//sendmail(message[3]);
							}
							else if(message[2]=='forgot-pass')
							{
								//document.getElementById(id).innerHTML="Sending E-Mail. Please Wait...";
								document.getElementById("loginheading").innerHTML="Email has been sent";
								document.getElementById("logincontent").innerHTML="Password reset link has been sent to your email address";
								document.getElementById("secondarymenu").innerHTML='Remember password? <a href="index.php">click here to Login</a>';
								document.getElementById("username").value='';
							}
							else if(message[2]=='chatroom')
							{
								alert("Chat Room Created Successfully");
								//document.getElementById(id).innerHTML="Sending E-Mail. Please Wait...";
								location.href="setstream.php?stream="+message[4];
								document.getElementById("name").value='';
							}
							else if(message[2]=='joinchatroom')
							{
								//document.getElementById(id).innerHTML="Sending E-Mail. Please Wait...";
								location.href="index.php?chatstatus=joined&cid="+message[5]+"&stream="+message[6];
								document.getElementById("name").value='';
							}
							else if(message[2]=='approvechatroom')
							{
								//document.getElementById(id).innerHTML="Sending E-Mail. Please Wait...";
								//location.href="index.php?chatstatus=joined&cid="+message[5]+"&stream="+message[6];
								document.getElementById(id).innerHTML='Approved';
							}

						}
							}
					} else {

						window.location.href=redirectPage;
					}
				  }
  				}
			};
			http.send(null);
       }
	   function requestInfo4(url,id,redirectPage) {
		var temp=new Array();
			http.open("GET", url, true);
			http.onreadystatechange = function() {
				if (http.readyState == 4) {
				  if(http.status==200) {
			  		var results=http.responseText;
					if(redirectPage=="" || results!="1") {

						var temp=id.split("~"); // To display on multiple div
						//alert(temp.length);
						var r=results.split("~"); // To display multiple data into the div
						//alert(temp.length);
						if(temp.length>1) {
							for(i=0;i<temp.length;i++) {
								//alert(temp[i]);
								 var id1=temp[i]+"1";
								document.getElementById(id1).innerHTML = r[i];
								document.getElementById(temp[i]).value=r[i];
							}
						} else {
							document.getElementById(id).value = results;
										}
					} else {

						window.location.href=redirectPage;
					}
				  }
  				}
			};
			http.send(null);
       }
	    function requestInfo5(url,id,redirectPage) {
		var temp=new Array();
			http.open("GET", url, true);
			http.onreadystatechange = function() {
				if (http.readyState == 4) {
				  if(http.status==200) {
			  		var results=http.responseText;
					if(redirectPage=="") {

						var temp=id.split("~"); // To display on multiple div
						//alert(temp.length);
						var r=results.split("~"); // To display multiple data into the div
						//alert(temp.length);
						if(temp.length>1) {
							for(i=0;i<temp.length;i++) {

								document.getElementById(temp[i]).innerHTML=r[i];
							}
						} else {
							//alert(results);
							document.getElementById(id).innerHTML = results;
						}
					} else {

						window.location.href=redirectPage;
					}
				  }
  				}
			};
			http.send(null);
       }

       function requestInfo7(url,id,redirectPage,type) {

		var temp=new Array();
			http.open("GET", url, true);
			http.onreadystatechange = function() {
				if (http.readyState == 4) {
				  if(http.status==200) {
			  		var results=http.responseText;
					if(redirectPage=="") {

						var temp=id.split("~"); // To display on multiple div
						//alert(temp.length);
						var r=results.split("~"); // To display multiple data into the div
						//alert(temp.length);
						if(temp.length>1) {

							for(i=0;i<temp.length;i++) {
								if(type=='4' || type=='5'){

									if(i>=0 && i<=2){
										document.getElementById(temp[i]).innerHTML=r[i];
										}
										else
										{
										document.getElementById(temp[i]).value=r[i];
									}
									}
									else
									{
										if(i>=0 && i<=1){
										document.getElementById(temp[i]).innerHTML=r[i];
										}
										else
										{
										document.getElementById(temp[i]).value=r[i];
									}
									}
							}
						} else {
							//alert(results);
							document.getElementById(id).innerHTML = results;
						}
					} else {

						window.location.href=redirectPage;
					}
				  }
  				}
			};
			http.send(null);
       }
       function requestInfo8(url,id,redirectPage,type) {

		var temp=new Array();
			http.open("GET", url, true);
			http.onreadystatechange = function() {
				if (http.readyState == 4) {
				  if(http.status==200) {
			  		var results=http.responseText;
			  		document.getElementById('fullname').value='';
					document.getElementById('username').value='';
					document.getElementById('password').value='';
					document.getElementById('cpassword').value='';
					document.getElementById('procode').value='';
					document.getElementById('error').innerHTML='';
					swal(http.responseText);

				  }
  				}
			};
			http.send(null);
       }

       function requestSession(url,id,redirectPage) {
		var temp=new Array();
			http.open("GET", url, true);
			http.onreadystatechange = function() {
				if (http.readyState == 4) {
				  if(http.status==200) {
			  		var results=http.responseText;
					if(redirectPage=="") {

						var temp=id.split("~"); // To display on multiple div
						//alert(temp.length);
						var r=results.split("~"); // To display multiple data into the div
						//alert(temp.length);
						if(temp.length>1) {
							for(i=0;i<temp.length;i++) {

								document.getElementById(temp[i]).innerHTML=r[i];
							}
						} else {
							if(results=='true')
							{
								location.href="iptl_subscription.php";
							}
							else
							{
							location.href="login.php?referer=iptl-subscription";
						}
						}
					} else {

						window.location.href=redirectPage;
					}
				  }
  				}
			};
			http.send(null);
       }
	   function requestInfo6(url,id,redirectPage) {
		var temp=new Array();
			http.open("GET", url, true);
			http.onreadystatechange = function() {
				if (http.readyState == 4) {
				  if(http.status==200) {
			  		var results=http.responseText;
					if(redirectPage=="") {

						var temp=id.split("~"); // To display on multiple div
						//alert(temp.length);
						var r=results.split("~"); // To display multiple data into the div
						//alert(temp.length);
						if(temp.length>1) {
							for(i=0;i<temp.length;i++) {
								document.getElementById(temp[i]).value=r[i];
							}
						} else {
							//alert(results);
							document.getElementById(id).value = results;
						}
					} else {

						window.location.href=redirectPage;
					}
				  }
  				}
			};
			http.send(null);
       }

function SetFocus(element){
window.scrollTo(0,document.body.scrollHeight);
document.getElementById(element).focus();
return true;
}

/* Go to previous page */
function previouspage()
{
history.back(1);
}
function emptyValidation(fieldList) {
		var field=new Array();
		field=fieldList.split("~");
		var counter=0;
		for(i=0;i<field.length;i++) {
			if(document.getElementById(field[i]).value=="") {
				document.getElementById(field[i]).style.backgroundColor="#D1E6EF";
				counter++;
			} else {
				document.getElementById(field[i]).style.backgroundColor="#FFFFFF";
			}
		}
		if(counter>0) {
				alert("The Field mark as lightblue could not left empty");
				return false;

		}  else {
			return true;
		}

}

	function ev() {

		document.getElementById('load').innerHTML='<center>Loading please wait ...<br><img src="img/load_info.gif"></center>';
		var rollno=document.getElementById('rollno').value;
		var dob=document.getElementById('dob').value;
		var captcha=document.getElementById('captcha').value;

		requestInfo2('ev.php?mode=list&rollno='+rollno+'&dob='+dob+'&captcha='+captcha,'result','');
		document.getElementById('result').innerHTML='';

	}
	function sendmail(email) {
		document.getElementById('error').innerHTML='<center>Sending activation e-mail please wait ...</center>';

		requestInfo8('activation_mail.php?avnmail='+email,'error','');
		//document.getElementById('result').innerHTML='';

	}
