<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\EmailTemplate;
use App\SmtpMail;
use App\Customer;

class SendEmailController extends Controller{

	 /**
	 * Show a list of users
	 * @return \Illuminate\View\View
	 */

	public function index(){

		Session::forget('mailSendSuccess');
		Session::forget('mailSendError');

		$userId = session()->get('userId');

		$templateArray = $params = array();

		$templateCategory = array();

		$templateCategory[] = array("varCatId"=>"1","varCatName"=>"subscribed");
		$templateCategory[] = array("varCatId"=>"2","varCatName"=>"unsubscribed");

		//print"<pre>";
		//print_r($templateCategory);
		//exit;

		try{
			$templateArray = $this->retrieveAllTemplateInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		if(!empty($userId)){
			return view('admin.mail.send_email_template',['template_category'=>$templateCategory,'templatedata'=>$templateArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	public function load_template(Request $request){

		$inputArray = $templateArray = array();

		$inputArray = $request->all();

		$templateArray = $this->retrieveAllCategoryTemplateInfo($inputArray);

		//print"<pre>";
		//print_r($templateArray);
		//exit;

		return view('admin.mail.load_category_template',['templatedata'=>$templateArray]);
	}

	public function store(Request $request){

		$userId = "";
		$userId = session()->get('userId');

		$successArray = $errorArray = $templateArray = $inputArray = array();

		$inputArray = $request->all();

		$templateArray = $this->retrieveTemplateInfo($inputArray);

		$userArray = $this->retrieveUserInfo($inputArray);

		$fieldName = "";
		if(!empty($templateArray['templateUserField'])){
			if($templateArray['templateUserField'] == 1){
				$fieldName = "user_name";
			}
			elseif($templateArray['templateUserField'] == 2){
				$fieldName = "user_name";
			}
			elseif($templateArray['templateUserField'] == 3){
				$fieldName = "user_email";
			}
		}

		$from = "";
		if(!empty($templateArray['templateFrom'])){
			$from = $templateArray['templateFrom'];
		}

		$subject = "";
		if(!empty($templateArray['templateSubject'])){
			$subject = $templateArray['templateSubject'];
		}

		$message_body = "";
		if(!empty($templateArray['templateBody'])){
			$message_body = $templateArray['templateBody'];
		}

		//echo $message_body."<br>";
		//exit;

		/*
		print"<pre>";
		print_r($templateArray);
		print"<pre>";
		print_r($userArray);
		exit;
		*/

		require("smtp.php");
		require("sasl.php");

		//$smtpObj = new SmtpMail();

		if(!empty($userArray)){

			foreach($userArray as $userVal){

				//print"<pre>";
				//print_r($userVal);
				//exit;

				$to="";
				if(!empty($userVal->user_email)){
					$to = $userVal->user_email;
				}

				$name = "";
				if(!empty($userVal->$fieldName)){
					$name = $userVal->$fieldName;
				}

				$message_text = "";
				if(!empty($message_body)){
					$message_text = str_replace("@",$name,$message_body);
				}

				$message = "";
				if(!empty($message_text)){
					$message = addslashes($message_text);
				}

				//echo $from."<br>";

				//$from="support@cricketgateway.com";    /* Change this to your address like "me@mydomain.com"; */
				$sender_line=__LINE__;

				if(strlen($from)==0)
					die("Please set the messages sender address in line ".$sender_line." of the script ".basename(__FILE__)."\n");
				if(strlen($to)==0)
					die("Please set the messages recipient address in line ".$recipient_line." of the script ".basename(__FILE__)."\n");

				//$smtp = new smtp_class;
				$smtp = new \smtp_class;

				$smtp->host_name="n1plcpnl0090.prod.ams1.secureserver.net"; //IP address       /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
				$smtp->host_port=25;                /* Change this variable to the port of the SMTP server to use, like 465 */
				$smtp->ssl=0;                       /* Change this variable if the SMTP server requires an secure connection using SSL */
				$smtp->start_tls=0;                 /* Change this variable if the SMTP server requires security by starting TLS during the connection */
				$smtp->localhost="n1plcpnl0090.prod.ams1.secureserver.net";       /* Your computer address */
				$smtp->direct_delivery=0;           /* Set to 1 to deliver directly to the recepient SMTP server */
				$smtp->timeout=10;                  /* Set to the number of seconds wait for a successful connection to the SMTP server */
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
				$header_array = array(
						"From: $from",
						"To: $to",
						"Subject: $subject",
						"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z"),
						"MIME-Version: 1.0",
						"Content-Type: text/html; charset=ISO-8859-1"
					);

				/*
				print"<pre>";
				print_r($header_array);
				print"<pre>";
				print_r(array($to));
				//exit;
				*/

				//Function SendMessage($sender,$recipients,$headers,$body)
				if($smtp->SendMessage($from, array($to), $header_array, "$message")){
					session()->put('mailSendSuccess','Mail sent successfully');
					//echo "Message sent to $to OK.\n";
				}
				else{
					session()->put('mailSendError','Error sending mail');
					//echo "Cound not send the message to $to.\nError: ".$smtp->error."\n";
				}

				//include('smtpwork.php');
				//exit;
			}
			//exit;
		}

		//echo $message;
		//exit;

		if(!empty($userId)){
			return view('admin.mail.send_email_template');
		}
		else{
			return redirect('admin/login_user');
		}
	}

	//retrieve All template records info
	public function retrieveAllCategoryTemplateInfo($params){
		$templateObj = new EmailTemplate();
		$resultArray = $templateObj->retrieveAllCategoryTemplate($params);
		return $resultArray;
	}

	//retrieve template info
	public function retrieveTemplateInfo($params){

		//print"<pre>";
		//print_r($params);
		//exit;

		$templateObj = new EmailTemplate();
		$resultArray = $templateObj->retrieveSingle($params);
		return $resultArray;
	}

	//retrieve template info
	public function retrieveUserInfo($params){
		$customerObj = new Customer();
		$resultArray = $customerObj->retrieveByWhere($params['template_category']);
		return $resultArray;
	}


	//retrieveUserInfo

	//retrieve All template records info
	public function retrieveAllTemplateInfo($params){
		$templateObj = new EmailTemplate();
		$resultArray = $templateObj->retrieveAll($params);
		return $resultArray;
	}
}