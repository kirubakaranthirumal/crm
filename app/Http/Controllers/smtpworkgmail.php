<?php
/*
 * test_smtp.php
 *
 * @(#) $Header: /home/mlemos/cvsroot/smtp/test_smtp.php,v 1.18 2009/04/11 22:23:24 mlemos Exp $
 *
 */

	require("smtp.php");

	require("sasl.php");

	$from="kirubakaran.thirumal@gmail.com";    /* Change this to your address like "me@mydomain.com"; */
	$sender_line=__LINE__;

	if(strlen($from)==0)
		die("Please set the messages sender address in line ".$sender_line." of the script ".basename(__FILE__)."\n");
	if(strlen($to)==0)
		die("Please set the messages recipient address in line ".$recipient_line." of the script ".basename(__FILE__)."\n");

	$smtp = new \smtp_class;
	
	/*
		ssl://smtp.gmail.com
		465
	*/	
	/*
	$mail->IsSMTP();

    //GMAIL config
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the server
    $mail->Host       = "ssl://smtp.gmail.com:465";      // sets GMAIL as the SMTP server

    $mail->Username   = "cricketgatewayipl@gmail.com";  // GMAIL username
    $mail->Password   = "welcome-123";            // GMAIL password
    $mail->SMTPDebug = 1;
    //End Gmail

    $mail->From       = "kirubakaran.srm@gmail.com";
    $mail->FromName   = "kirubakaran";
    $mail->Subject    = "No Subject";
    $mail->MsgHTML("Test Message");

    //$mail->AddReplyTo("reply@email.com","reply name");//they answer here, optional
    $mail->AddAddress("kirubakaran.srm@gmail.com","Name To");
    $mail->IsHTML(true); // send as HTML

    if(!$mail->Send()){
		//to see if we return a message or a value bolean
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
	else{
		echo "Message sent!";
	}	
	exit;
	*/
	
	//$smtp->host_name="smtp.gmail.com"; //IP address       /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
	//$smtp->host_port=587;                /* Change this variable to the port of the SMTP server to use, like 465 */
	//$smtp->ssl=1;                       /* Change this variable if the SMTP server requires an secure connection using SSL */
	//$smtp->start_tls=1;                 /* Change this variable if the SMTP server requires security by starting TLS during the connection */
	//$smtp->localhost="smtp.gmail.com";  /* Your computer address */
	//$smtp->direct_delivery=0;           /* Set to 1 to deliver directly to the recepient SMTP server */
	//$smtp->timeout=100;                  /* Set to the number of seconds wait for a successful connection to the SMTP server */
	//$smtp->data_timeout=0;              /* Set to the number seconds wait for sending or retrieving data from the SMTP server.
	                                       //Set to 0 to use the same defined in the timeout variable */
	//$smtp->debug=1;                     /* Set to 1 to output the communication with the SMTP server */
	//$smtp->html_debug=1;                /* Set to 1 to format the debug output as HTML */
	//$smtp->pop3_auth_host="";           /* Set to the POP3 authentication host if your SMTP server requires prior POP3 authentication */
	//$smtp->user="cricketgatewayipl@gmail.com"; /* Set to the user name if the server requires authetication */
	//$smtp->realm="";                    /* Set to the authetication realm, usually the authentication user e-mail domain */
	//$smtp->password="welcome-123";                 /* Set to the authetication password */
	//$smtp->workstation="";              /* Workstation name for NTLM authentication */
	//$smtp->authentication_mechanism=""; /* Specify a SASL authentication method like LOGIN, PLAIN, CRAM-MD5, NTLM, etc..
	                                       //Leave it empty to make the class negotiate if necessary */
	//print"<pre>";
	//print_r($smtp);
	//exit;
	
	//$smtp = new \smtp_class;

	//$smtp->host_name="n1plcpnl0090.prod.ams1.secureserver.net"; //IP address       /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
	//$smtp->host_port=25;                /* Change this variable to the port of the SMTP server to use, like 465 */
	//$smtp->ssl=0;                       /* Change this variable if the SMTP server requires an secure connection using SSL */
	//$smtp->start_tls=0;                 /* Change this variable if the SMTP server requires security by starting TLS during the connection */
	//$smtp->localhost="n1plcpnl0090.prod.ams1.secureserver.net";       /* Your computer address */
	//$smtp->direct_delivery=0;           /* Set to 1 to deliver directly to the recepient SMTP server */
	//$smtp->timeout=100;                  /* Set to the number of seconds wait for a successful connection to the SMTP server */
	//$smtp->data_timeout=0;              /* Set to the number seconds wait for sending or retrieving data from the SMTP server.
	                                       //Set to 0 to use the same defined in the timeout variable */
	//$smtp->debug=1;                     /* Set to 1 to output the communication with the SMTP server */
	//$smtp->html_debug=1;                /* Set to 1 to format the debug output as HTML */
	//$smtp->pop3_auth_host="";           /* Set to the POP3 authentication host if your SMTP server requires prior POP3 authentication */
	//$smtp->user="followon@nu-live.com"; /* Set to the user name if the server requires authetication */
	//$smtp->realm="";                    /* Set to the authetication realm, usually the authentication user e-mail domain */
	//$smtp->password="welcome-123";                 /* Set to the authetication password */
	//$smtp->workstation="";              /* Workstation name for NTLM authentication */
	//$smtp->authentication_mechanism=""; /* Specify a SASL authentication method like LOGIN, PLAIN, CRAM-MD5, NTLM, etc..
	                                      // Leave it empty to make the class negotiate if necessary */

	//echo $smtp->SendMessage($from, array($to), array("From: $from",	"To: $to","Subject: $subject","Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")),"$message");
	//exit;
	/*
	$header_array = array(
			"From: $from",
			"To: $to",
			"Subject: $subject",
			"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z"),
			"MIME-Version: 1.0",
			"Content-Type: text/html; charset=ISO-8859-1"
		);
	*/

	//print"<pre>";
	//print_r($header_array);
	//exit;

	//$from, array($to), $header_array, $message
	/*
	print"<pre>";
	print_r($from);
	print"<hr>";
	print_r(array($to));
	print"<hr>";
	print_r($header_array);
	print"<hr>";
	print_r($header_array);
	print"<hr>";
	print_r($smtp);
	exit;
	*/
	
	require_once('PHPMailer-master/PHPMailerAutoload.php');
	//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

	$mail             = new \PHPMailer();

	$body             = "Hellooifdskjsdlkf";

	$mail->IsSMTP(); // telling the class to use SMTP
	//$mail->Host       = "mail.yourdomain.com"; // SMTP server
	$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
									   // 1 = errors and messages
									   // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "kirubakaran.thirumal@gmail.com";  // GMAIL username
	$mail->Password   = "kiruba*1984";            // GMAIL password

	$mail->SetFrom('kirubakaran.thirumal@gmail.com', 'First Last');

	$mail->AddReplyTo("kirubakaran.thirumal@gmail.com","First Last");

	$mail->Subject    = "PHPMailer Test Subject via smtp (Gmail), basic";

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

	$mail->MsgHTML($body);

	$address = "kirubakaran.srm@gmail.com";
	$mail->AddAddress($address, "John Doe");

	//$mail->AddAttachment("images/phpmailer.gif");      // attachment
	//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

	if(!$mail->Send()){
		echo "Mailer Error: " . $mail->ErrorInfo;
	} 
	else{
		echo "Message sent!";
	}
	//exit;

	//Function SendMessage($sender,$recipients,$headers,$body)
	if($smtp->SendMessage($from, array($to), $header_array, $message)){
		echo "Message sent to $to OK.\n";
		exit;
	}
	else{
		echo "Cound not send the message to $to.\nError: ".$smtp->error."\n";
		exit;
	}
?>
