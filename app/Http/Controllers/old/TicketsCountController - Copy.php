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

class TicketsCountController extends Controller{

	 /**
	 * Show a list of users
	 * @return \Illuminate\View\View
	 */

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(){

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

		//print"<pre>";
		//print_r($countResponseArray);
		//exit;

		if(!empty($countResponseArray)){
			$ticketCountArray = $countResponseArray;
		}

		if(!empty($userId)){
			return view('admin.emp_ticket_count_dashboard',['ticketcountdata' => $ticketCountArray]);
		}
		else{
			return redirect('admin/login_user');
			//header('Location:login_user');
			//exit;
		}
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

}