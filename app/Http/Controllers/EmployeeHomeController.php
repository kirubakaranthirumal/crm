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

class EmployeeHomeController extends Controller {

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

		$inputArray = $request->all();

		$userId = session()->get('userId');
		$usertype=session()->get('userType');
		$appid=session()->get('appId');
		$eventid=session()->get('eventId');

		$countinputArray = array();
		$countinputArray['ticketAssignedUser'] = $userId;
		$countinputArray['appId'] = $appid;
		$countinputArray['eventId'] = $eventid;
		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/crmuserdashboardcount",$countinputArray);

		$ticketCountArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		if(!empty($countResponseArray)){
			$ticketCountArray = $countResponseArray;
		}

		/*
		if(!empty($countResponseArray->ticketStatusCounts)){
			foreach($countResponseArray->ticketStatusCounts as $countResponseVal){
				$ticketCountArray[] = $countResponseVal;
			}
		}
		*/

		$tabId="";
		if(!empty($inputArray['tab_id'])){
			$tabId = $inputArray['tab_id'];
		}

		if(!empty($tabId)){
			if($tabId=="1"){
				$cinputArray['loginuserType'] = "1";
				$cinputArray['ticketAssignedUser'] = $userId;
				$cinputArray['appId'] = $appid;
				$cinputArray['eventId'] = $eventid;
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
			$cinputArray['ticketAssignedUser'] = $userId;
			$cinputArray['appId'] = $appid;
			$cinputArray['eventId'] = $eventid;

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

		//appId
		//eventId

		//session()->put('serviceEdit' , $responseArray->serviceEdit);

		//print"<pre>";
		//print_r(Session::all());
		//exit;


		$appIpArray = $appResponseArray = array();
		$eventIpArray = $eventResponseArray = array();

		/*
		if(!empty(session()->get('appId'))){
			$appIpArray['appId'] = session()->get('appId');
		}

		//print"<pre>";
		//print_r($cinputArray);
		//exit;

		$appdata="";
		if(!empty($appIpArray)){
			$appdata = SELF::App("http://106.51.0.187:8090/cgwfollowon/findapp",$appIpArray);
		}

		if(!empty($appdata)){
			$appResponseArray = json_decode($appdata);
		}

		if(!empty(session()->get('eventId'))){
			$eventIpArray['eventId'] = session()->get('eventId');
		}

		$eventdata="";
		if(!empty($eventIpArray)){
			$eventdata = SELF::Event("http://106.51.0.187:8090/cgwfollowon/findevent",$eventIpArray);
		}

		if(!empty($eventdata)){
			$eventResponseArray = json_decode($eventdata);
		}
		*/

		/*
		print"<pre>";
		print_r($appResponseArray);
		print"<hr>";
		print_r($eventResponseArray);
		exit;
		*/

		$priorityDispArray = array();

		$priorityDispArray = $this->retrieveAllPriorityInfo($inputArray);

		if(!empty($priorityDispArray)){
			foreach($priorityDispArray as $priorityVal){
				$priorityDisp[] = $priorityVal;
			}
		}

		if(!empty($priorityDisp)){
			foreach($priorityDisp as $priorityDispVal){
				$priorityDispData[$priorityDispVal['priorityId']] = $priorityDispVal;
			}
		}

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

		//print"<pre>";
		//print_r($statusDispValData);
		//print_r($statusDispValData[$ticketListArray['status']]['statusName']);
		//exit;

		if(!empty($userId)){
			return view('admin.emp_dashboard',['ticketcountdata' => $ticketCountArray,'ticketdata' => $ticketListArray,'maildata'=>$notificationListArray,'app'=>$appResponseArray,'event'=>$eventResponseArray,'priorityDisp'=>$priorityDispData]);
		}
		else{
			return redirect('admin/login_user');
			//header('Location:login_user');
			//exit;
		}
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
		//elseif(!empty($params['status'])){
		//	$fields['status'] = $params['status'];
		//}

		if(!empty($params['loginuserType'])){
			$fields['loginuserType'] = $params['loginuserType'];
		}

		if(!empty($params['ticketAssignedUser'])){
			$fields['ticketAssignedUser'] = $params['ticketAssignedUser'];
		}

		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
		}

		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
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

		if(!empty($params['ticketAssignedUser'])){
			$fields['ticketAssignedUser'] = $params['ticketAssignedUser'];
		}
		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
		}
			if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
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

    public function App($url,$params){

		$json_string = '';

		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
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

	 public function Event($url,$params){

		$json_string = '';

		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}
		// echo $json_string;
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
	
	public function getUserTickets(Request $request){

		$inputArray = $request->all();

		$userId = session()->get('userId');
		$usertype=session()->get('userType');
		$appid=session()->get('appId');
		$eventid=session()->get('eventId');

		$countinputArray = array();
		$countinputArray['ticketAssignedUser'] = $userId;
		$countinputArray['appId'] = $appid;
		$countinputArray['eventId'] = $eventid;
		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/crmuserdashboardcount",$countinputArray);

		$ticketCountArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		if(!empty($countResponseArray)){
			$ticketCountArray = $countResponseArray;
		}

		/*
		if(!empty($countResponseArray->ticketStatusCounts)){
			foreach($countResponseArray->ticketStatusCounts as $countResponseVal){
				$ticketCountArray[] = $countResponseVal;
			}
		}
		*/

		$tabId="";
		if(!empty($inputArray['tab_id'])){
			$tabId = $inputArray['tab_id'];
		}

		if(!empty($tabId)){
			if($tabId=="1"){
				$cinputArray['loginuserType'] = "1";
				$cinputArray['ticketAssignedUser'] = $userId;
				$cinputArray['appId'] = $appid;
				$cinputArray['eventId'] = $eventid;
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
			$cinputArray['ticketAssignedUser'] = $userId;
			$cinputArray['appId'] = $appid;
			$cinputArray['eventId'] = $eventid;

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

		//echo count($ticketListDataArray);
		$ticketList = array();
		
		if(!empty($ticketListDataArray)){
			foreach($ticketListDataArray as $responseVal){
				$ticketListArray[] = $responseVal;
				//$ticketListArray['agingHours'][] = strtotime($responseVal->createdOn);
			}
			foreach($ticketListArray as $tickets){
				$tickets->createdOn = date("m-d-Y H:i:s a", strtotime($tickets->createdOn));
				if($tickets->status == 2 || $tickets->status == 3 || $tickets->status == 4 ){
					$ticketList[] = $tickets;
				}
			}
		}

		$cinputArray = $emailResponseArray = array();

		//echo "<pre>";
		//print_r($ticketList);
		//exit;
		
		
		return $ticketList;
		
	}
	
}
