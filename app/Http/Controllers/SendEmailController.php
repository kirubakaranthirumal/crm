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

		//print"<pre>";
		//print_r($templateArray);
		//print"<hr>";
		//print_r($userArray);
		//exit;

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

				/*		
				$sender_line=__LINE__;
				
				if(strlen($from)==0)
					die("Please set the messages sender address in line ".$sender_line." of the script ".basename(__FILE__)."\n");
				if(strlen($to)==0)
					die("Please set the messages recipient address in line ".$recipient_line." of the script ".basename(__FILE__)."\n");

				//$smtp = new smtp_class;
				$smtp = new \smtp_class;

				$smtp->host_name="n1plcpnl0090.prod.ams1.secureserver.net"; //IP address       
				$smtp->host_port=25;               
				$smtp->ssl=0;                       
				$smtp->start_tls=0;                 
				$smtp->localhost="n1plcpnl0090.prod.ams1.secureserver.net"; 
				$smtp->direct_delivery=0;           
				$smtp->timeout=100;                 
				$smtp->data_timeout=0;              
													
				$smtp->debug=1;                     
				$smtp->html_debug=1;                
				$smtp->pop3_auth_host="";           
				$smtp->user="followon@nu-live.com"; 
				$smtp->realm="";                    
				$smtp->password="welcome-123";      
				$smtp->workstation="";              
				$smtp->authentication_mechanism=""; 
													
				$header_array = array(
						"From: $from",
						"To: $to",
						"Subject: $subject",
						"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z"),
						"MIME-Version: 1.0",
						"Content-Type: text/html; charset=ISO-8859-1"
					);
				*/
				
				require_once('PHPMailer-master/PHPMailerAutoload.php');
				
				$mail = new \PHPMailer();

				if(!empty($message)){
					$body = $message;
				}

				if(!empty($emailArr['0'])){	
					$mailinputArray['toAddress'] = $emailArr['0'];
				}

				$mail->IsSMTP(); // telling the class to use SMTP
				//$mail->Host       = "mail.yourdomain.com"; // SMTP server
				$mail->SMTPDebug  = 2;             // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
				$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
				$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
				$mail->Username   = "cricketgatewayipl@gmail.com";  // GMAIL username
				$mail->Password   = "admin-123";            // GMAIL password
				
				if(!empty($from)){
					$mail->SetFrom("cricketgatewayipl@gmail.com",'');
				}
				else{
					$mail->SetFrom('cricketgatewayipl@gmail.com','');
				}
				
				if(!empty($from)){
					$mail->AddReplyTo("cricketgatewayipl@gmail.com","");
				}
				else{
					$mail->AddReplyTo("cricketgatewayipl@gmail.com","");
				}
				
				if(!empty($subject)){
					$mail->Subject = $subject;
				}
				
				$mail->AltBody    = "<BR>"; // optional, comment out and test
				$mail->MsgHTML($body);
				$address = $to;
				$mail->AddAddress($address, "");
				
				//print"<pre>";
				//print_r($mail);
				//exit;

				//Function SendMessage($sender,$recipients,$headers,$body)
				/*
				if($mail->Send()){
					session()->put('mailSendSuccess','Mail sent successfully');
					//echo "Message sent to $to OK.\n";
					//exit;
				}
				else{
					session()->put('mailSendError','Error sending mail');
					//echo "Cound not send the message to $to.\nError: ".$smtp->error."\n";
					//exit;
				}
				*/
				
				session()->put('mailSendSuccess','Mail has been sent successfully');
				
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