<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmailNotificationController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(Request $request){

    	Session::forget('createTicktSuccess');

		$inputArray = $request->all();

		$userId = session()->get('userId');

		$cinputArray = $responseArray = array();

		if(!empty($userId)){
			$cinputArray['userId'] = $userId;
		}

      	$results = SELF::ListNotification("http://106.51.0.187:8090/cgwfollowon/listemailnotification",$cinputArray);

        $ticketListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		$notificationListArray = array();
		if(!empty($responseArray->AppDetails)){
        	foreach($responseArray->AppDetails as $responseVal){
				$notificationListArray[] = $responseVal;
			}
		}

		//print"<pre>";
		//print_r($notificationListArray);
		//exit;

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
            if(!empty($responseArray->msg)){
                
				if(!empty($userId)){
					return view('admin.mail.email_notification_list',['notificationdata' => $notificationListArray]);
				}
				else{
					return redirect('admin/login_user');
				}
				
			}
        }
        elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){}

        if(!empty($userId)){
            return view('admin.mail.email_notification_list',['notificationdata' => $notificationListArray]);
		}
		else{
			return redirect('admin/login_user');
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
					//return view('admin.ticket_form.user_tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId,'error'=>'errorArray']);
					return view('admin.mail.email_notification_list',['notificationdata' => $notificationListArray]);
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

    public function TicketCount($url,$params){

        $json_string = '';

        if(!empty($params['ticketAssignedUser'])){
            $fields['ticketAssignedUser'] = $params['ticketAssignedUser'];
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

        //echo $curl_response;
        //exit;

        curl_close($curl);

        return $curl_response;
    }
}
