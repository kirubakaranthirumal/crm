<?php
/*
 * test_smtp.php
 *
 * @(#) $Header: /home/mlemos/cvsroot/smtp/test_smtp.php,v 1.18 2009/04/11 22:23:24 mlemos Exp $
 *
 */

	require("smtp.php");

	require("sasl.php");

	$from="support@cricketgateway.com";    /* Change this to your address like "me@mydomain.com"; */
	$sender_line=__LINE__;

	if(strlen($from)==0)
		die("Please set the messages sender address in line ".$sender_line." of the script ".basename(__FILE__)."\n");
	if(strlen($to)==0)
		die("Please set the messages recipient address in line ".$recipient_line." of the script ".basename(__FILE__)."\n");

	$smtp = new \smtp_class;

	$smtp->host_name="n1plcpnl0090.prod.ams1.secureserver.net"; //IP address       /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
	$smtp->host_port=25;                /* Change this variable to the port of the SMTP server to use, like 465 */
	$smtp->ssl=0;                       /* Change this variable if the SMTP server requires an secure connection using SSL */
	$smtp->start_tls=0;                 /* Change this variable if the SMTP server requires security by starting TLS during the connection */
	$smtp->localhost="n1plcpnl0090.prod.ams1.secureserver.net";       /* Your computer address */
	$smtp->direct_delivery=0;           /* Set to 1 to deliver directly to the recepient SMTP server */
	$smtp->timeout=100;                  /* Set to the number of seconds wait for a successful connection to the SMTP server */
	$smtp->data_timeout=0;              /* Set to the number seconds wait for sending or retrieving data from the SMTP server.
	                                       Set to 0 to use the same defined in the timeout variable */
	$smtp->debug=1;                     /* Set to 1 to output the communication with the SMTP server */
	$smtp->html_debug=1;                /* Set to 1 to format the debug output as HTML */
	$smtp->pop3_auth_host="";           /* Set to the POP3 authentication host if your SMTP server requires prior POP3 authentication */
	$smtp->user="followon@nu-live.com"; /* Set to the user name if the server requires authetication */
	$smtp->realm="";                    /* Set to the authetication realm, usually the authentication user e-mail domain */
	$smtp->password="welcome-123";                 /* Set to the authetication password */
	$smtp->workstation="";              /* Workstation name for NTLM authentication */
	$smtp->authentication_mechanism=""; /* Specify a SASL authentication method like LOGIN, PLAIN, CRAM-MD5, NTLM, etc..
	                                       Leave it empty to make the class negotiate if necessary */

	//echo $smtp->SendMessage($from, array($to), array("From: $from",	"To: $to","Subject: $subject","Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")),"$message");
	//exit;

	/*
	$headers = "From: " . strip_tags($_POST['req-email']) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
	$headers .= "CC: susan@example.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	*/

	$header_array = array(
			"From: $from",
			"To: $to",
			"Subject: $subject",
			"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z"),
			"MIME-Version: 1.0",
			"Content-Type: text/html; charset=ISO-8859-1"
		);

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

	//Function SendMessage($sender,$recipients,$headers,$body)
	if($smtp->SendMessage($from, array($to), $header_array, $message)){
		//echo "Message sent to $to OK.\n";
		//exit;
	}
	else
		//echo "Cound not send the message to $to.\nError: ".$smtp->error."\n";
		//exit;

?>
