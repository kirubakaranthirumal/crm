<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserTicketDetailsController extends Controller{

	public function show($id){

		$inputArray = $cinputArray = array();

		//$input = $request->all();
		//$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['ticketId'] = $id;
		}

		if(!empty($cinputArray)){
		 $results = SELF::ShowTicketDetails("http://106.51.0.187:8090/cgwfollowon/findticket",$cinputArray);
		}
		$ticketdata = $results;

		//print_r $ticketdata;
		//exit;

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print"<pre>";
	    //print_r($responseArray);
		//exit;

		$userId = session()->get('userId');

		if(!empty($userId)){
			//return view('admin.users.user_details');
			//return view('admin.ticket_form.user_ticket_details')->with('ticketdata', json_decode($ticketdata, true));
		}
		else{
			return redirect('admin/login_user');
		}
	}

    public function ShowTicketDetails($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['ticketId'])){
			$fields['ticketId'] = $params['ticketId'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
			//echo $json_string;
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