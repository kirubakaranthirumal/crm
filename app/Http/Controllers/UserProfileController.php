<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
	public function index(){
		
	$userId = session()->get('userId');
		$inputArray = $cinputArray = array();

     	//$input = $request->all();
		//$inputArray = $request->all();

		if(!empty($userId)){
			$cinputArray['userId'] = $userId;
		}
		if(!empty($cinputArray)){
			$results = SELF::UserProfilePost("http://106.51.0.187:8090/cgwfollowon/findcrmuser",$cinputArray);
		}
		$userdata = $results;
		//echo $results;

		$responseArray = array();
		$userListArray = array();
		if(!empty($userdata)){
			$responseArray = json_decode($userdata);
		}

		if(!empty($responseArray->ticketList)){
        	foreach($responseArray->ticketList as $responseVal){
				$userListArray[] = $responseVal;
			}
		}
		//print"<pre>";
		//print_r($userListArray);
		//exit;

		if(!empty($userId)){
			//return view('admin.users.user_details');
			  	return view('admin.users.user_profile', ['userdata' => $userListArray]);
			//return view('admin.users.user_details')->with('userdata', json_decode($userdata, true));
		}
		else{
			return redirect('admin/login_user');
		}
	}

  
    public function UserProfilePost($url,$params){

		$json_string = '';

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

}