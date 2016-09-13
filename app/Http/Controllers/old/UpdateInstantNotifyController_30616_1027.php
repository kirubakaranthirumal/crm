<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\SmtpMail;

class UpdateInstantNotifyController extends Controller{

	public function index(Request $request){

		$inputArray = $cinputArray = $responseArray = array();

		$inputArray = $request->all();

		//print"<pre>";
		//print_r(session::all());
		//exit;

		$userId = session()->get('userId');

		if(!empty($userId)){
			$cinputArray['ticketAssignedUser'] = $userId;
		}

		$results = "";
		if(!empty($cinputArray)){
			$results = SELF::UpdateMyNewTicketNotification("http://106.51.0.187:8090/cgwfollowon/updateusernotification",$cinputArray);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print"<pre>";
		//print_r($responseArray);
		//exit;
	}

	public function UpdateMyNewTicketNotification($url,$params){

		$json_string = '';

		if(!empty($params['ticketAssignedUser'])){
			$fields['ticketAssignedUser'] = $params['ticketAssignedUser'];
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