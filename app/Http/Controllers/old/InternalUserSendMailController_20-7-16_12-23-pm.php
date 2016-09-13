<?php
namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Department;
use App\Category;
use App\Priority;
use App\Source;
use App\Type;
use App\Status;
use App\SmtpMail;

class InternalUserSendMailController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(Request $request){

    	$inputArray = $request->all();

    	$userId = session()->get('userId');

		$departmentArray = array();

		try{
			$departmentArray = $this->retrieveAllDepartmentInfo($inputArray);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		$groupArray = array();
		if(!empty($departmentArray)){
			foreach($departmentArray as $departmentVal){
				$groupArray[] = $departmentVal;
			}
		}

		//print"<pre>";
		//print_r($appListArray);
		//exit;

		if(!empty($userId)){
			return view('admin.users.internal_users_compose_mail',['department' => $groupArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  Request  $request
	* @return Response
	*/

	public function store(Request $request){
		
		$emailArr = array();
		$inputArray = $request->all();

		$userId = session()->get('userId');

		//print"<pre>";
		//print_r($inputArray);
		//exit;
		$from = session()->get('email');
		
		$subject = "";
		if(!empty($inputArray['comSubject'])){
			$subject = $inputArray['comSubject'];
		}

		$message = "";
		if(!empty($inputArray['editor'])){
			$message = $inputArray['editor'];
		}
		
		$to="";
		if(!empty($inputArray['employee'])){
			$to = $inputArray['employee'];
			$emailArr[] = $to;
		}
		else{
			$emailGroup = array('groupId'=> $inputArray['group']);
			$emailArr = SELF::load_group_user_email($emailGroup);
		}

		//echo $message;
		//exit;
		
		if(!empty($emailArr) && count($emailArr) > 0){
			require("smtp.php");
			require("sasl.php");
			$smtp = new \smtp_class;
			foreach($emailArr as $to){

				$sender_line=__LINE__;

				if(strlen($from)==0)
					die("Please set the messages sender address in line ".$sender_line." of the script ".basename(__FILE__)."\n");
				if(strlen($to)==0)
					die("Please set the messages recipient address in line ".$recipient_line." of the script ".basename(__FILE__)."\n");

				//$smtp = new smtp_class;
				//$smtp = new \smtp_class;

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
				echo "<hr>".$message;
				*/

			}
		}
		
		
		//exit;
		

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

		$departmentArray = array();

		$departmentArray = $this->retrieveAllDepartmentInfo($inputArray);

		$groupArray = array();
		if(!empty($departmentArray)){
			foreach($departmentArray as $departmentVal){
				$groupArray[] = $departmentVal;
			}
		}

		if(!empty($userId)){
			return view('admin.users.internal_users_compose_mail',['department' => $groupArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	public function retrieveAllDepartmentInfo($params){
		$departmentObj = new Department();
		$resultArray = $departmentObj->retrieveAll($params);
		return $resultArray;
	}

	public function ListAppPost($url,$params){

		$json_string = '';

		if(!empty($params['userSesId'])){
			$fields['userSesId'] = $params['userSesId'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}

		$service_url = $url;

		$curl = curl_init($service_url);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept-Language: en_US')
		);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);

		$curl_response = curl_exec($curl);

		curl_close($curl);

		return $curl_response;
	}
	public function load_group_user_email($inputArray){

		if(!empty($inputArray['groupId'])){
			$results = SELF::loadEmpGroupId("http://106.51.0.187:8090/cgwfollowon/findcrmgroupusers",$inputArray);
		}

		$responseArray = $groupEmailListArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}
		
		if(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseVal){
				$groupEmailListArray[] = $responseVal->email;
			}
		}
		return $groupEmailListArray;
	}

	 public function loadEmpGroupId($url,$params){

		$json_string = '';

		if(!empty($params['groupId'])){
			$fields['groupId'] = $params['groupId'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}

		//$json_string = '{"groupId":"1"}';

		//echo $json_string;
		//exit;

		$service_url = $url;

		$curl = curl_init($service_url);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept-Language: en_US')
		);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);

		$curl_response = curl_exec($curl);

		curl_close($curl);

		return $curl_response;
	}	
}
