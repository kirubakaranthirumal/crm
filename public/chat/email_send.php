<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=utf-8');

$server_name=$_SERVER['SERVER_NAME'];
/* mysql connection */
include "includes/mysql_connection_cricketgateway.php";

require_once 'mandrill-api-php/src/Mandrill.php'; //Not required with Composer

   $email = $_REQUEST['check'];
   if($email!='')
   {
	echo $email2=implode(',',$email);
	try {
    $mandrill = new Mandrill('aff2j717lOpaMH5ET72wxQ');
    $message = array(
        'html' => utf8_encode("<!DOCTYPE html>
<html>
<head>

<meta name='viewport' content='width=device-width' />
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<title>cricketgateway</title>
<style>
* { 
	margin:0;
	padding:0;
}
* { font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; }

img { 
	max-width: 100%; 
}
.collapse {
	margin:0;
	padding:0;
}
body {
	-webkit-font-smoothing:antialiased; 
	-webkit-text-size-adjust:none; 
	width: 100%!important; 
	height: 100%;
}


/* ------------------------------------- 
		ELEMENTS 
------------------------------------- */
a { color: #2BA6CB;}

.btn {
	text-decoration:none;
	color: #FFF;
	background-color: #666;
	padding:10px 16px;
	font-weight:bold;
	margin-right:10px;
	text-align:center;
	cursor:pointer;
	display: inline-block;
}

p.callout {
	padding:15px;
	background-color:#ECF8FF;
	margin-bottom: 15px;
}
.callout a {
	font-weight:bold;
	color: #2BA6CB;
}

table.social {
/* 	padding:15px; */
	background-color: #ebebeb;
	
}
.social .soc-btn {
	padding: 3px 7px;
	font-size:12px;
	margin-bottom:10px;
	text-decoration:none;
	color: #FFF;font-weight:bold;
	display:block;
	text-align:center;
}
a.fb { background-color: #3B5998!important; }
a.tw { background-color: #1daced!important; }
a.gp { background-color: #DB4A39!important; }
a.ms { background-color: #000!important; }

.sidebar .soc-btn { 
	display:block;
	width:100%;
}

/* ------------------------------------- 
		HEADER 
------------------------------------- */
table.head-wrap { width: 100%;}

.header.container table td.logo { padding: 15px; }
.header.container table td.label { padding: 15px; padding-left:0px;}


/* ------------------------------------- 
		BODY 
------------------------------------- */
table.body-wrap { width: 100%;}


/* ------------------------------------- 
		FOOTER 
------------------------------------- */
table.footer-wrap { width: 100%;	clear:both!important;
}
.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
.footer-wrap .container td.content p {
	font-size:10px;
	font-weight: bold;
	
}


/* ------------------------------------- 
		TYPOGRAPHY 
------------------------------------- */
h1,h2,h3,h4,h5,h6 {
font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
}
h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

h1 { font-weight:200; font-size: 44px;}
h2 { font-weight:200; font-size: 37px;}
h3 { font-weight:500; font-size: 27px;}
h4 { font-weight:500; font-size: 23px;}
h5 { font-weight:900; font-size: 17px;}
h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

.collapse { margin:0!important;}

p, ul { 
	margin-bottom: 10px; 
	font-weight: normal; 
	font-size:14px; 
	line-height:1.6;
}
p.lead { font-size:17px; }
p.last { margin-bottom:0px;}

ul li {
	margin-left:5px;
	list-style-position: inside;
}

/* ------------------------------------- 
		SIDEBAR 
------------------------------------- */
ul.sidebar {
	background:#ebebeb;
	display:block;
	list-style-type: none;
}
ul.sidebar li { display: block; margin:0;}
ul.sidebar li a {
	text-decoration:none;
	color: #666;
	padding:10px 16px;
/* 	font-weight:bold; */
	margin-right:10px;
/* 	text-align:center; */
	cursor:pointer;
	border-bottom: 1px solid #777777;
	border-top: 1px solid #FFFFFF;
	display:block;
	margin:0;
}
ul.sidebar li a.last { border-bottom-width:0px;}
ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}



/* --------------------------------------------------- 
		RESPONSIVENESS
		Nuke it from orbit. It's the only way to be sure. 
------------------------------------------------------ */

/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
.container {
	display:block!important;
	max-width:600px!important;
	margin:0 auto!important; /* makes it centered */
	clear:both!important;
}

/* This should also be a block element, so that it will fill 100% of the .container */
.content {
	padding:15px;
	max-width:600px;
	margin:0 auto;
	display:block; 
}

/* Let's make sure tables in the content area are 100% wide */
.content table { width: 100%; }


/* Odds and ends */
.column {
	width: 300px;
	float:left;
}
.column tr td { padding: 15px; }
.column-wrap { 
	padding:0!important; 
	margin:0 auto; 
	max-width:600px!important;
}
.column table { width:100%;}
.social .column {
	width: 280px;
	min-width: 279px;
	float:left;
}

/* Be sure to place a .clear element after each set of columns, just to be safe */
.clear { display: block; clear: both; }


/* ------------------------------------------- 
		PHONE
		For clients that support media queries.
		Nothing fancy. 
-------------------------------------------- */
@media only screen and (max-width: 600px) {
	
	a[class='btn'] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

	div[class='column'] { width: auto!important; float:none!important;}
	
	table.social div[class='column'] {
		width:auto!important;
	}

}
</style>
</head>

<body bgcolor='#FFFFFF'>

<!-- HEADER -->
<table class='head-wrap' bgcolor='#999999'>
  <tr>
    <td></td>
    <td class='header container'><div class='content'>
        <table bgcolor='#999999'>
          <tr> </tr>
        </table>
      </div></td>
    <td></td>
  </tr>
</table>
<!-- /HEADER --> 

<!-- BODY -->
<table class='body-wrap'>
  <tr>
    <td></td>
    <td class='container' bgcolor='#FFFFFF'><div class='content'>
        <table>
          
            <img src='https://$server_name/images/cg_ipl_logo.gif' width='252' height='83' />
              <h3>$name</h3>
              <p >Thanks for Subscribing for the service</p>
              <p> You can view<span style='color:#df5e5e'> Live Streaming</span> and <span style='color:#2e818f'>Videotagcard</span> with <span style='color:#818e46'>Ultra Slow Motion</span> and <span style='color:#ca1d1d'>Frame by Frame</span> control Match Highlights</p>
              <p>for the Match(es) you have purchased</p>
              <h4>Your Purchase details are as below:</h4>
              <hr />
              <p style='color:#d01717; font-size:25px; font-weight:700'>$desc - $pce$</p>

              
              <!-- A Real Hero (and a real human being) --> 
              
              <br/>
              
              <!-- social & contact -->
              
              <table class='social' width='100%'>
                <tr>
                  <td><!--- column 1 -->
                    
                    <table align='left' class='column'>
                      <tr>
                        <td><h5 class=''>Connect with Us:</h5>
                          <p class=''><a href='https://www.facebook.com/cricketgateway?_rdr' class='soc-btn fb'><img src='https://$server_name/images/facebook.jpg' /></a> <a href='https://twitter.com/cricketgateway' class='soc-btn tw'><img src='https://$server_name/images/twitter.jpg' /></a> <a href='https://instagram.com/cricketgateway' class='soc-btn gp'><img src='https://$server_name/images/instagram.jpg' /></a></p></td>
                      </tr>
                    </table>
                    <!-- /column 1 --> 
                    
                    <!-- /column 1 --> 
                    
                    <!--- column 2 -->
                    
                    <table align='right' class='column'>
                      <tr>
                        <td><h5 class=''>Contact Info:</h5>
                          Email: <strong><a href='emailto:hseldon@trantor.com'>support@cricketgateway.com. </a></strong>
                          </p>
                          <p>All Rights Reserved.</p></td>
                      </tr>
                    </table>
                    
                    <!-- /column 2 --> 
                    
                    <span class='clear'></span></td>
                </tr>
              </table>
              
              <!-- /social & contact --></td>
          </tr>
        </table>
      </div></td>
    <td></td>
  </tr>
</table>
<!-- /BODY --> 

<!-- FOOTER -->
<table class='footer-wrap'>
  <tr>
    <td></td>
    <td class='container'><!-- content -->
      
      <div class='content'>
        <table>
          <tr>
            <td align='center'><p></p>
              <p>This Mail has been sent to you because you subscribed on cricketgateway.com. For Any help, please visit our feedback section: <a href='https://$server_name/index.php#feedback' target='_blank'>Feedback.</a> </p>
              <p style='font-size:9px'>Wotwerx Holding Ltd  by Followon Interactive Media Pvt. Ltd, 38, Developed Plot Industrial Estate, Perrungdi, Chennai 600096, India</p>
              </td>
          </tr>
        </table>
      </div>
      
      <!-- /content --></td>
    <td></td>
  </tr>
</table>
<!-- /FOOTER -->

</body>
</html>"),
        'text' => 'Welcome to Cricketgateway.com',
        'subject' => 'Chat Invitation',
        'from_email' => 'subscribe@cricketgateway.com',
        'from_name' => 'Cricket Gateway',
        'to' => array(
            array(
                'email' => $email2,
                'name' => 'Anand',
                'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => 'support@cricketgateway.com'),
        'important' => false,
        'track_opens' => null,
        'track_clicks' => null,
        'auto_text' => null,
        'auto_html' => null,
        'inline_css' => null,
        'url_strip_qs' => null,
        'preserve_recipients' => null,
        'view_content_link' => null,
        'bcc_address' => null,
        'tracking_domain' => null,
        'signing_domain' => null,
        'return_path_domain' => null,
        'merge' => false,
        'merge_language' => 'mailchimp',
        'global_merge_vars' => array(
            array(
                'name' => 'merge1',
                'content' => 'merge1 content'
            )
        ),
        'merge_vars' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'vars' => array(
                    array(
                        'name' => 'merge2',
                        'content' => 'merge2 content'
                    )
                )
            )
        ),
        'tags' => array('password-resets'),
        'subaccount' => null,
        'google_analytics_domains' => array(),
        'google_analytics_campaign' => null,
        'metadata' => array('website' => 'https://$server_name'),
        /*'recipient_metadata' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'values' => array('user_id' => 123456)
            )
        ),*/
        /*'attachments' => array(
            array(
                'type' => 'text/plain',
                'name' => 'myfile.txt',
                'content' => 'ZXhhbXBsZSBmaWxl'
            )
        ),*/
        'images' => array(
            array(
                'type' => 'image/png',
                'name' => 'IMAGECID',
                'content' => 'ZXhhbXBsZSBmaWxl'
            )
        )
    );
    $async = true;
    $ip_pool = 'Main Pool';
    $send_at = $timestamp;
    $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
	//print_r($result);
	if($result)
	{
		echo "Invitation Sent Successfully";
	}
    else{
		echo "Try again!!";	
	}
} catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
    throw $e;
}
   }
   
   else
   {
	   echo "Try Agian";
   }
?>