<?php
namespace App\Http\Controllers;
use Session;
use Validator;
use App\Department;
use App\Category;
use App\Priority;
use App\Source;
use App\Type;
use App\Status;
use App\SmtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\lib\facebookphpsdk\src\Facebook\Facebook;
use App\lib\TwitterAPIExchange;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */

	public function index(Request $request){
		
		Session::forget('mailSendSuccess');
		Session::forget('mailSendError');

		$userId = session()->get('userId');

		$countinputArray = array();
		$countinputArray['userId'] = $userId;
		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/dashboardcount",$countinputArray);

		$ticketCountArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		if(!empty($countResponseArray->ticketStatusCounts)){
			foreach($countResponseArray->ticketStatusCounts as $countResponseVal){
				$ticketCountArray[] = $countResponseVal;
			}
		}

		$inputArray = $request->all();

		$userId = session()->get('userId');

		$tabId="";
		if(!empty($inputArray['tab_id'])){
			$tabId = $inputArray['tab_id'];
		}

		if(!empty($tabId)){
			if($tabId=="1"){
				$cinputArray['loginuserType'] = "1";
				$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listalltickets",$cinputArray);
			}
			else{
				if($tabId=="2"){
					$cinputArray['status'] = "1";
				}
				elseif($tabId=="3"){
					$cinputArray['status'] = "2";
				}
				elseif($tabId=="4"){
					$cinputArray['status'] = "3";
				}
				elseif($tabId=="5"){
					$cinputArray['status'] = "4";
				}
				elseif($tabId=="6"){
					$cinputArray['status'] = "5";
				}
				elseif($tabId=="7"){
					$cinputArray['status'] = "6";
				}

				if(!empty($cinputArray)){
					$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/searcspecifichticketlist",$cinputArray);
				}
			}
		}
		else{
			//$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listalltickets",$cinputArray);

			$cinputArray['loginuserType'] = "1";
			$cinputArray['status'] = "1";

			$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/searcspecifichticketlist",$cinputArray);
		}

		$responseArray = array();

		$ticketListArray = $ticketSortDataArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		$ticketListDataArray = array();
		if(!empty($responseArray->Crmticketlist)){
			foreach($responseArray->Crmticketlist as $responseVal){
				$ticketListArray[] = $responseVal;
			}
		}
		elseif(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseDataVal){
				//$ticketSortDataArray[] = $responseDataVal;
				$ticketListDataArray[] = $responseDataVal;
			}
		}

		if(!empty($ticketListDataArray)){
			foreach($ticketListDataArray as $responseVal){
				$ticketListArray[] = $responseVal;
				//$ticketListArray['agingHours'][] = strtotime($responseVal->createdOn);
			}
		}

		$cinputArray = $emailResponseArray = array();

		$mail_results = SELF::ListNotification("http://106.51.0.187:8090/cgwfollowon/listemailnotification",$emailResponseArray);

		$notificationListArray = array();
		if(!empty($mail_results)){
			$emailResponseArray = json_decode($mail_results);
		}

		$notificationListArray = array();
		if(!empty($emailResponseArray->AppDetails)){
			foreach($emailResponseArray->AppDetails as $responseVal){
				$notificationListArray[] = $responseVal;
			}
		}

		//user login status
		$emplogincinputArray = array();

		if(!empty($userId)){
			$emplogincinputArray['userSesId'] = $userId;
		}

		$emploginresults = "";
		if(!empty($emplogincinputArray)){
			$emploginresults = SELF::ListActiveInactiveUser("http://106.51.0.187:8090/cgwfollowon/activeinactiveuser",$emplogincinputArray);
		}

		$emploginresponseArray = array();

		$activeuserListArray = array();
		$inactiveuserListArray = array();
		if(!empty($results)){
			$emploginresponseArray = json_decode($emploginresults);
		}

		if(!empty($emploginresponseArray->activeUser)){
			foreach($emploginresponseArray->activeUser as $responseVal){
				$activeuserListArray[] = $responseVal;
			}
		}

		if(!empty($emploginresponseArray->inActiveUsers)){
			foreach($emploginresponseArray->inActiveUsers as $responseVal){
				$inactiveuserListArray[] = $responseVal;
			}
		}

		//print"<pre>";
		//print_r($emploginresponseArray);
		//print_r($inactiveuserListArray);
		//exit;

		$departmentArray = array();

		$departmentArray = $this->retrieveAllActiveDepartmentInfo($inputArray);

		$groupArray = array();
		if(!empty($departmentArray)){
			foreach($departmentArray as $departmentVal){
				$groupArray[] = $departmentVal;
			}
		}

		//get facebook feed
		$page_access_token="EAAYh8lMkiuoBAEs6ywU8hJvuVaP8O0JW0iHwNCxtRu34RaZCb9PDxtM78iqDbZCXERFMVMYUEr9LtNuUZBetahHYrI9itIlFEp1Hjf1CVNKVkrFreTcro3yMDXDw8Nc5jPy9I1ZCJo50GIzFKYdzQjgXPgXFET68RErOr69ACaa2INMZAqKuz";
		$fbPostArray = array();
		$fbPostArray = SELF::getFacebookFeed();

		//get facebook feed
		$tweetArray = array();
		$tweetArray = SELF::getTweetFeed();

		if(isset($tweetArray->errors) && count($tweetArray->errors) > 0){
			$tweetArray = array();
		}

		$priorityDispArray = array();

		$priorityDispArray = $this->retrieveAllPriorityInfo($inputArray);

		if(!empty($priorityDispArray)){
			foreach($priorityDispArray as $priorityVal){
				$priorityDisp[] = $priorityVal;
			}
		}
		
		$priorityDispData = array();
		$statusDispValData = array();
		if(!empty($priorityDisp)){
			foreach($priorityDisp as $priorityDispVal){
				$priorityDispData[$priorityDispVal['priorityId']] = $priorityDispVal;
			}
		}

		//print"<pre>";
		//print_r($priorityDispData[5]['priorityName']);
		//exit;

		$statusDispArray = array();

		$statusDispArray = $this->retrieveAllStatusInfo($inputArray);

		if(!empty($statusDispArray)){
			foreach($statusDispArray as $statusVal){
				$statusDisp[] = $statusVal;
			}
		}
		
		if(!empty($statusDisp)){
			foreach($statusDisp as $statusDispVal){
				$statusDispValData[$statusDispVal['statusId']] = $statusDispVal;
			}
		}

		if(!empty($userId)){
			return view('admin.dashboard',['ticketcountdata' => $ticketCountArray,'ticketdata' => $ticketListArray,'maildata'=>$notificationListArray,'activeuser' => $activeuserListArray,'inactiveuser' => $inactiveuserListArray,'department' => $groupArray,'fbpage' => $fbPostArray,'tweetnotify'=>$tweetArray, 'access_token' => $page_access_token,'priorityDisp'=>$priorityDispData,'statusDisp'=>$statusDispValData]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	public function store(Request $request){
		
		$inputArray = $request->all();
		
		if($inputArray['submit'] == "Assign Ticket"){
			$cinputArray = array();

			//quick assign only assigning update so only status 2
			$cinputArray['status'] = "2";
			$cinputArray['ticketId'] = $inputArray['ticket_id'];
			
			if(!empty($inputArray['group'])){
				$cinputArray['ticketGroupId'] = $inputArray['group'];
			}

			if(!empty($inputArray['employee'])){
				$cinputArray['ticketAssignedUser'] = $inputArray['employee'];
			}

			if(!empty($inputArray['deadline'])){
				$cinputArray['deadLine'] = $inputArray['deadline'];
			}
			
			if(!empty(session()->get('userId'))){
				$cinputArray['modifiedBy'] = session()->get('userId');
			}
			
			$results = SELF::UpdateTicketPost("http://106.51.0.187:8090/cgwfollowon/ticketquickassign",$cinputArray);
			$requesterEmail = $inputArray['requester_email'];
			session()->put('mailSendSuccess','Ticket Assigned successfully');
			return redirect('admin/dashboard');
			//return redirect()->back();
	
		}		
		elseif($inputArray['submit'] == "Create Ticket"){
			
			$message = $upload_path = "";

			$inputArray = $cinputArray = array();

			$inputArray = $request->all();
			
			/* echo "<pre>";
			print_r($inputArray);
			exit; */

			$file_ext_array = array();
			$extensions = "";

			if(isset($_FILES['ticket_attachment'])){

				$errors = array();

				//$file_name = $_FILES['ticket_attachment']['name'];

				$file_size =$_FILES['ticket_attachment']['size'];
				$file_tmp =$_FILES['ticket_attachment']['tmp_name'];
				$file_type=$_FILES['ticket_attachment']['type'];

				$file_ext_array = explode('.',$_FILES['ticket_attachment']['name']);

				if(!empty($file_ext_array['1'])){
					$file_ext = $file_ext_array['1'];
					$file_name = rand().".".$file_ext;

					$upload_path = "upload/tickets/";

					$extensions = array("jpeg","jpg","png","doc","docx");

					if(in_array($file_ext,$extensions)=== false){
						$errors[] = "extension not allowed";
					}

					if($file_size > 2097152){
						$errors[]='File size must be excately 2 MB';
					}

					if(empty($errors)==true){
						move_uploaded_file($file_tmp,$upload_path.$file_name);
					}
				}
			}

			$uploadError = array();
			
			if(empty($errors)){

				if(
					(!empty($inputArray['requester_name']))
					&&
					(!empty($inputArray['requester_email']))
					&&
					(!empty($inputArray['subject']))
					&&
					(!empty($inputArray['source']))
					&&
					(!empty($inputArray['category']))
					&&
					(!empty($inputArray['status']))
					&&
					(!empty($inputArray['priority']))
					&&
					(!empty($inputArray['group']))
					&&
					(!empty($inputArray['type']))
					&&
					(!empty($inputArray['employee']))
					&&
					(!empty($inputArray['editor']))
				 ){

					if(!empty($inputArray['application'])){
						$cinputArray['appId'] = $inputArray['application'];
					}

					if(!empty($inputArray['event'])){
						$cinputArray['eventId'] = $inputArray['event'];
					}

					if(!empty($inputArray['requester_name'])){
						$cinputArray['requestorName'] = $inputArray['requester_name'];
					}

					if(!empty($inputArray['requester_email'])){
						$cinputArray['portalUserEmailId'] = $inputArray['requester_email'];
					}

					if(!empty($inputArray['subject'])){
						$cinputArray['ticketSubject'] = $inputArray['subject'];
					}

					if(!empty($inputArray['source'])){
						$cinputArray['ticketSource'] = $inputArray['source'];
					}

					if(!empty($inputArray['category'])){
						$cinputArray['ticketCatId'] = $inputArray['category'];
					}

					if(!empty($inputArray['status'])){
						$cinputArray['status'] = $inputArray['status'];
					}

					if(!empty($inputArray['priority'])){
						$cinputArray['priority'] = $inputArray['priority'];
					}

					if(!empty($inputArray['group'])){
						$cinputArray['ticketGroupId'] = $inputArray['group'];
					}

					if(!empty($inputArray['type'])){
						$cinputArray['type'] = $inputArray['type'];
					}

					if(!empty($inputArray['employee'])){
						$cinputArray['ticketAssignedUser'] = $inputArray['employee'];
					}

					if(!empty($inputArray['editor'])){
						$cinputArray['ticketText'] = $inputArray['editor'];
					}

					if(!empty(session()->get('userId'))){
						$cinputArray['createdBy'] = session()->get('userId');
					}

					if(!empty($file_name)){
						$cinputArray['attachmentUrl'] = $file_name;
					}

					if(!empty($inputArray['deadline'])){
						$cinputArray['deadLine'] = $inputArray['deadline'];
					}
					$cinputArray['notificationStatus'] = "1";
					
					$results = SELF::AddTicketPost("http://106.51.0.187:8090/cgwfollowon/createtickets",$cinputArray);
				}
			}
			else{
				$uploadError = $errors;
			}

			$responseArray = array();
			if(!empty($results)){
				$responseArray = json_decode($results);
			}

			$ticketId = "";
			if(!empty($responseArray->TicketId)){
				$ticketId = $responseArray->TicketId;
			}

			$to="";
			if(!empty($inputArray['requester_email'])){
				$to = $inputArray['requester_email'];

				$name = "";
				if(!empty($inputArray['requester_name'])){
					$name = $inputArray['requester_name'];
				}

				$from = "support@cricketgateway.com";
				$subject = "Regarding ticket created notification";

				$message = "<html><body>";
				$message .= "<table style=\"border-color: #666;border:0px;\" cellpadding=\"10\">";
				$message .= "<tr style=\"background: #eee;\"><td><strong><center>Ticket Create Notification</center></strong></td></tr>";
				$message .= "<tr><td> Hi <strong>".$name."</strong>, </td></tr>";
				$message .= "<tr><td><span style=\"padding:50px;\"> We created a ticket based on the issue you have raised us. You will be intimated once the ticket have been fixed. Yout Ticket ID is <strong>".$ticketId."</strong></span></td></tr>";
				$message .= "<tr><td>Thanks Regards<br>Follow On</td></tr>";
				$message .= "</table>";
				$message .= "</body></html>";

				//$message = "Hi ".$name."<br><br><span> We created a ticket based on the issue you have raised us. You will be intimated once the ticket have been fixed. Yout Ticket ID is <bold>".$ticketId."</bold><br><br>";
				//$message .= "Thanks Regards<br>.";
				//$message .= "Follow On";
			}
			
			$userId = session()->get('userId');
			
			if((!empty($responseArray->status)) && ($responseArray->status == "200")){
				Session::forget('mailSendSuccess');
				session()->put('mailSendSuccess','Ticket has been created successfully');
			}
			else{
				Session::forget('mailSendSuccess');
				session()->put('mailSendSuccess','Cannot create ticket, '.$responseArray->msg);
			}
			return redirect('admin/dashboard');
			
		}
		else{
			$userId = session()->get('userId');

			$countinputArray = array();
			$countinputArray['userId'] = $userId;
			$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/dashboardcount",$countinputArray);

			$ticketCountArray = array();
			if(!empty($statusResultCount)){
				$countResponseArray = json_decode($statusResultCount);
			}

			if(!empty($countResponseArray->ticketStatusCounts)){
				foreach($countResponseArray->ticketStatusCounts as $countResponseVal){
					$ticketCountArray[] = $countResponseVal;
				}
			}

			$inputArray = $request->all();

			$userId = session()->get('userId');

			//print"<pre>";
			//print_r($inputArray);
			//exit;

			$tabId="";
			if(!empty($inputArray['tab_id'])){
				$tabId = $inputArray['tab_id'];
			}

			//print"<pre>";
			//print_r(Session::all());
			//exit;

			if(!empty($tabId)){
				if($tabId=="1"){
					$cinputArray['loginuserType'] = "1";
					$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listalltickets",$cinputArray);
				}
				else{
					if($tabId=="2"){
						$cinputArray['status'] = "1";
					}
					elseif($tabId=="3"){
						$cinputArray['status'] = "2";
					}
					elseif($tabId=="4"){
						$cinputArray['status'] = "3";
					}
					elseif($tabId=="5"){
						$cinputArray['status'] = "4";
					}
					elseif($tabId=="6"){
						$cinputArray['status'] = "5";
					}
					elseif($tabId=="7"){
						$cinputArray['status'] = "6";
					}

					if(!empty($cinputArray)){
						$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/searcspecifichticketlist",$cinputArray);
					}
				}
			}
			else{
				//$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listalltickets",$cinputArray);

				$cinputArray['loginuserType'] = "1";
				$cinputArray['status'] = "1";

				$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/searcspecifichticketlist",$cinputArray);
			}

			//print"<pre>";
			//print_r($results);
			//exit;

			$responseArray = array();

			$ticketListArray = $ticketSortDataArray = array();
			if(!empty($results)){
				$responseArray = json_decode($results);
			}

			$ticketListDataArray = array();
			if(!empty($responseArray->Crmticketlist)){
				foreach($responseArray->Crmticketlist as $responseVal){
					$ticketListArray[] = $responseVal;
				}
			}
			elseif(!empty($responseArray->ticketList)){
				foreach($responseArray->ticketList as $responseDataVal){
					//$ticketSortDataArray[] = $responseDataVal;
					$ticketListDataArray[] = $responseDataVal;
				}
			}

			//echo count($ticketListDataArray);

			if(!empty($ticketListDataArray)){
				foreach($ticketListDataArray as $responseVal){
					$ticketListArray[] = $responseVal;
					//$ticketListArray['agingHours'][] = strtotime($responseVal->createdOn);
				}
			}

			$cinputArray = $emailResponseArray = array();

			$mail_results = SELF::ListNotification("http://106.51.0.187:8090/cgwfollowon/listemailnotification",$emailResponseArray);

			//print"<pre>";
			//print_r($mail_results);
			//exit;

			$notificationListArray = array();
			if(!empty($mail_results)){
				$emailResponseArray = json_decode($mail_results);
			}

			$notificationListArray = array();
			if(!empty($emailResponseArray->AppDetails)){
				foreach($emailResponseArray->AppDetails as $responseVal){
					$notificationListArray[] = $responseVal;
				}
			}

			//print"<pre>";
			//print_r($ticketListArray);
			//exit;

			//user login status
			$emplogincinputArray = array();

			if(!empty($userId)){
				$emplogincinputArray['userSesId'] = $userId;
			}

			$emploginresults = "";
			if(!empty($emplogincinputArray)){
				$emploginresults = SELF::ListActiveInactiveUser("http://106.51.0.187:8090/cgwfollowon/activeinactiveuser",$emplogincinputArray);
			}

			//print"<pre>";
			//print_r($emploginresults);
			//exit;

			$emploginresponseArray = array();

			$activeuserListArray = array();
			$inactiveuserListArray = array();
			if(!empty($results)){
				$emploginresponseArray = json_decode($emploginresults);
			}

			if(!empty($emploginresponseArray->activeUser)){
				foreach($emploginresponseArray->activeUser as $responseVal){
					$activeuserListArray[] = $responseVal;
				}
			}

			if(!empty($emploginresponseArray->inActiveUsers)){
				foreach($emploginresponseArray->inActiveUsers as $responseVal){
					$inactiveuserListArray[] = $responseVal;
				}
			}

			//print"<pre>";
			//print_r($emploginresponseArray);
			//print_r($inactiveuserListArray);
			//exit;


			//send mail to internal users starts here
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
					exit;
					*/
				}
			}

			//Function SendMessage($sender,$recipients,$headers,$body)
			if($smtp->SendMessage($from, array($to), $header_array, "$message")){
				session()->put('mailSendSuccess','Mail sent successfully');
				//echo "Message sent to $to OK.\n";
				//exit;
			}
			else{
				session()->put('mailSendError','Error sending mail');
				//echo "Cound not send the message to $to.\nError: ".$smtp->error."\n";
				//exit;
			}
			//send mail to internal users end here

			$departmentArray = array();

			$departmentArray = $this->retrieveAllActiveDepartmentInfo($inputArray);

			$groupArray = array();
			if(!empty($departmentArray)){
				foreach($departmentArray as $departmentVal){
					$groupArray[] = $departmentVal;
				}
			}

			if(!empty($userId)){
				
				return view('admin.dashboard',['ticketcountdata' => $ticketCountArray,'ticketdata' => $ticketListArray,'maildata'=>$notificationListArray,'activeuser' => $activeuserListArray,'inactiveuser' => $inactiveuserListArray,'department' => $groupArray]);
			}
			else{
				return redirect('admin/login_user');
				//header('Location:login_user');
				//exit;
			}
		}
		
		//return redirect()->back();
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

	public function retrieveAllActiveDepartmentInfo(){
		$departmentObj = new Department();
		$resultArray = $departmentObj->retrieveAllActive();
		return $resultArray;
	}

	 public function ListNotification($url,$params){

		$json_string = '';
		$fields = array();

		if(!empty($params['userId'])){
			$fields['userId'] = $params['userId'];
		}

		//if(!empty($fields)){
		//	$json_string = json_encode($fields);
		//}

		$json_string = '{}';

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


	 public function ListUserPost($url,$params){

			$json_string = '';
			$fields = array();
			if(!empty($params['Id'])){
				$fields['Id'] = $params['Id'];
			}
			elseif(!empty($params['status'])){
				$fields['status'] = $params['status'];
			}

			if(!empty($params['loginuserType'])){
				$fields['loginuserType'] = $params['loginuserType'];
			}

			if(!empty($fields)){
				$json_string = json_encode($fields);
			}

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

	 public function TicketCount($url,$params){

		$json_string = '';

		if(!empty($params['userId'])){
			$fields['userId'] = $params['userId'];
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

	public function ListActiveInactiveUser($url,$params){

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

	public function getFacebookFeed(){

		$page_id = "1056627197749548";
		$page_access_token="EAAYh8lMkiuoBAEs6ywU8hJvuVaP8O0JW0iHwNCxtRu34RaZCb9PDxtM78iqDbZCXERFMVMYUEr9LtNuUZBetahHYrI9itIlFEp1Hjf1CVNKVkrFreTcro3yMDXDw8Nc5jPy9I1ZCJo50GIzFKYdzQjgXPgXFET68RErOr69ACaa2INMZAqKuz";

		$results = "";

		$cinputArray = $responseArray = array();

		$results = SELF::ListFbPagePost("https://graph.facebook.com/v2.6/".$page_id."/feed?fields=message%2Cfrom%2Ccreated_time%2Cpicture%2Cid&access_token=".$page_access_token);

		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		$fbPostArray = array();
		if(!empty($responseArray->data)){
			$fbPostArray = $responseArray->data;
		}

		return $fbPostArray;
	}

	public function getTweetFeed(){

		$tweeterarray = array();

		$notify_url = 'https://api.twitter.com/1.1/statuses/mentions_timeline.json';
		$home_url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
        $getfield = '';
        $requestMethod = 'GET';

		$settings = array(
            'oauth_access_token' => "749905022121484288-j04jdPDOsUtywyKM0RWl3zyyKWacDdZ",
            'oauth_access_token_secret' => "5BTR7D3SRN3OQK0ZafG8I5KrhWfUFC2I8QEDP2lhQSPxk",
            'consumer_key' => "7YFnMGXxIXZq5OAk4RKry65z3",
            'consumer_secret' => "WtYWLUoF8GbyZQhautu52RTALzO1TdCfBlItNvJq5d0q2wIeor"
        );

		$twitter = new TwitterAPIExchange($settings);

		$notify_json = $twitter->setGetfield($getfield)
                    ->buildOauth($notify_url, $requestMethod)
                    ->performRequest();

		$home_json = $twitter->setGetfield($getfield)
                    ->buildOauth($home_url, $requestMethod)
                    ->performRequest();

        $notify_tweet_obj = json_decode($notify_json);
		$home_tweet_obj = json_decode($home_json);

		return $notify_tweet_obj;
	}

	public function ListFbPagePost($url){

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$curl_response = curl_exec($ch);

		curl_close($ch);

		return $curl_response;
	}

	//retrieve All priority records info
	public function retrieveAllPriorityInfo($params){
		$priorityObj = new Priority();
		$resultArray = $priorityObj->retrieveAll($params);
		return $resultArray;
	}


	public function retrieveAllStatusInfo($params){
		$statusObj = new Status();
		$resultArray = $statusObj->retrieveAll($params);
		return $resultArray;
	}

	public function UpdateTicketPost($url,$params){

		$json_string = '';

		if(!empty($params['ticketId'])){
			$fields['ticketId'] = $params['ticketId'];
		}

		if(!empty($params['status'])){
			$fields['status'] = $params['status'];
		}

		if(!empty($params['ticketGroupId'])){
			$fields['ticketGroupId'] = $params['ticketGroupId'];
		}

		if(!empty($params['ticketAssignedUser'])){
			$fields['ticketAssignedUser'] = $params['ticketAssignedUser'];
		}

		if(!empty($params['modifiedBy'])){
			$fields['modifiedBy'] = $params['modifiedBy'];
		}

		if(!empty($params['deadLine'])){
			$fields['deadLine'] = $params['deadLine'];
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

	public function AddTicketPost($url,$params){

		$json_string = '';

		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
		}

		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
		}

		if(!empty($params['requestorName'])){
			$fields['requestorName'] = $params['requestorName'];
		}

		if(!empty($params['portalUserEmailId'])){
			$fields['portalUserEmailId'] = $params['portalUserEmailId'];
		}

		if(!empty($params['ticketSubject'])){
			$fields['ticketSubject'] = $params['ticketSubject'];
		}

		if(!empty($params['ticketSource'])){
			$fields['ticketSource'] = $params['ticketSource'];
		}

		if(!empty($params['ticketCatId'])){
			$fields['ticketCatId'] = $params['ticketCatId'];
		}

		if(!empty($params['status'])){
			$fields['status'] = $params['status'];
		}

		if(!empty($params['priority'])){
			$fields['priority'] = $params['priority'];
		}

		if(!empty($params['ticketGroupId'])){
			$fields['ticketGroupId'] = $params['ticketGroupId'];
		}

		if(!empty($params['type'])){
			$fields['type'] = $params['type'];
		}

		if(!empty($params['ticketAssignedUser'])){
			$fields['ticketAssignedUser'] = $params['ticketAssignedUser'];
		}

		if(!empty($params['ticketText'])){
			$fields['ticketText'] = $params['ticketText'];
		}

		if(!empty($params['createdBy'])){
			$fields['createdBy'] = $params['createdBy'];
		}

		if(!empty($params['attachmentUrl'])){
			$fields['attachmentUrl'] = $params['attachmentUrl'];
		}

		if(!empty($params['deadLine'])){
			$fields['deadLine'] = $params['deadLine'];
		}
		
		$fields['notificationStatus'] = $params['notificationStatus'];
		$fields['portelUserId'] = "0";
		$fields['modifiedBy'] = "0";

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}

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
