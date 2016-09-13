<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CreateTicketNotificationController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

	public function index(Request $request){


	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id, Request $request){

		session()->put('createTicktSuccess','Ticket has been created successfully');

		$userId = Session::get('userId');

		$params = $request->all();

		//list all notification
		$cinputArray = array();
		if(!empty($userId)){
			$cinputArray['userId'] = $userId;
		}

		$results = SELF::ListNotification("http://106.51.0.187:8090/cgwfollowon/notificationticketlist",$cinputArray);

		$ticketListArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		$notificationListArray = array();
		if(!empty($responseArray->notificationTicketlist)){
			foreach($responseArray->notificationTicketlist as $responseVal){
				$notificationListArray[] = $responseVal;
			}
		}

		//update read status
		$updreadstatusipArray = array();
		$updreadstatusipArray['notificationId'] = $id;

		$readstatusResult = SELF::UpdateTicketReadStatus("http://106.51.0.187:8090/cgwfollowon/updatereadstatus",$updreadstatusipArray);

		$responseArray = array();
		if(!empty($readstatusResult)){
			$responseArray = json_decode($readstatusResult);
		}

		$notificationArray = array();
		if(!empty($responseArray)){
			$notificationArray = $responseArray;
		}

		//print"<pre>";
		//print_r($notificationArray);
		//exit;

		if(!empty($notificationArray)){

			if(!empty($notificationArray->userEmail)){
				$cinputArray['requestorName'] = $notificationArray->userEmail;
			}

			if(!empty($notificationArray->title)){
				$cinputArray['ticketSubject'] = $notificationArray->title;
			}

			if(!empty($notificationArray->categoryType)){
				$cinputArray['ticketCatId'] = $notificationArray->categoryType;
			}

			if(!empty($notificationArray->description)){
				$cinputArray['ticketText'] = $notificationArray->description;
			}

			if(!empty($notificationArray->ticketSourceType)){
				$cinputArray['ticketSource'] = $notificationArray->ticketSourceType;
			}

			if(!empty($notificationArray->portalUserId)){
				$cinputArray['portelUserId'] = $notificationArray->portalUserId;
			}

			if(!empty(session()->get('userId'))){
				$cinputArray['createdBy'] = session()->get('userId');
			}

			//print"<pre>";
			//print_r($cinputArray);
			//exit;

			$results = SELF::AddTicketPost("http://106.51.0.187:8090/cgwfollowon/createtickets",$cinputArray);

			$createticketrespArray = array();
			if(!empty($results)){
				$createticketrespArray = json_decode($results);
			}


		}

		//print"<pre>";
		//print_r($createticketrespArray);
		//exit;

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				session()->put('createTicktSuccess','Ticket has been created successfully');
				return view('admin.ticket_form.notification_list',['notificationdata' => $notificationListArray]);
			}
		}
        elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){}

		if(!empty($userId)){
			return view('admin.ticket_form.notification_list',['notificationdata' => $notificationListArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	public function AddTicketPost($url,$params){

		$json_string = '';

		if(!empty($params['requestorName'])){
			$fields['requestorName'] = $params['requestorName'];
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
			$fields['status'] = 1;
		}

		if(!empty($params['priority'])){
			$fields['priority'] = 1;
		}

		if(!empty($params['ticketText'])){
			$fields['ticketText'] = $params['ticketText'];
		}

		if(!empty($params['portelUserId'])){
			$fields['portelUserId'] = $params['portelUserId'];
		}

		if(!empty($params['createdBy'])){
			$fields['createdBy'] = $params['createdBy'];
		}

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

	public function ListNotification($url,$params){

		$json_string = '';
		$fields = array();

		if(!empty($params['userId'])){
			$fields['userId'] = $params['userId'];
		}

		if(!empty($params['type'])){
			$fields['type'] = $params['type'];
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

		//print"<pre>";
		//print_r($curl_response);
		//exit;

		curl_close($curl);

		return $curl_response;
	 }


	public function CreateTicket($url,$params){

		$json_string = '';
		$fields = array();

		if(!empty($params['notificationId'])){
			$fields['notificationId'] = $params['notificationId'];
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

	public function UpdateTicketReadStatus($url,$params){

		$json_string = '';
		$fields = array();

		if(!empty($params['notificationId'])){
			$fields['notificationId'] = $params['notificationId'];
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


     public function store(Request $request){

     	$inputArray = $request->all();

		$userId = session()->get('userId');

		$tabId="";
		if(!empty($inputArray['tab_id'])){
			$tabId = $inputArray['tab_id'];
		}

		$responseArray = $ticketListArray = array();

		if(!empty($tabId)){
			$results = SELF::searchTicketWithStatus($inputArray,$tabId);
		}
		else{
			$results = SELF::searchTicketWithoutStatus($inputArray,$tabId);
		}

		//print"<pre>";
		//print_r($results);
		//exit;

		if(!empty($results)){
			$responseArray = json_decode($results);
		}
		elseif(!empty($searchResults)){
			$responseArray = json_decode($searchResults);
		}

		if(!empty($responseArray->Crmticketlist)){
			foreach($responseArray->Crmticketlist as $responseVal){
				$ticketListArray[] = $responseVal;
			}
		}
		elseif(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseVal){
				$ticketListArray[] = $responseVal;
			}
		}

		$countinputArray = array();
		$countinputArray['ticketAssignedUser'] = $userId;
		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/crmuserdashboardcount",$countinputArray);

		$ticketCountArray = $countResponseArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		//print"<pre>";
		//print_r($countResponseArray);
		//exit;

		$countinputArray = array();
		$countinputArray['ticketAssignedUser'] = $userId;
		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/crmuserdashboardcount",$countinputArray);

		$ticketCountArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		if(!empty($countResponseArray)){
			//foreach($countResponseArray->ticketStatusCounts as $countResponseVal){
				$ticketCountArray[] = $countResponseArray;
			//}
		}

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				if(!empty($userId)){
					return view('admin.ticket_form.user_tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId,'error'=>'errorArray']);
				}
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
		}

		/*
		if(!empty($userId)){
			return view('admin.ticket_form.tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId,'error'=>'errorArray']);
		}
		else{
			return redirect('admin/login_user');
		}
		*/
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
