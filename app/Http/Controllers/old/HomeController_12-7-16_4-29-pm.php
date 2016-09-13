<?php
namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

		if(!empty($userId)){
			return view('admin.dashboard',['ticketcountdata' => $ticketCountArray,'ticketdata' => $ticketListArray,'maildata'=>$notificationListArray,'activeuser' => $activeuserListArray,'inactiveuser' => $inactiveuserListArray]);
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
}
