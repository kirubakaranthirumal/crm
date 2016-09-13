<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PrivilegeUsersDetailsController extends Controller
{

	

     public function show($id){

     	$leads = '{"error":false,"member":[{"id":"1","firstName":"first","lastName":"last","phoneNumber":"0987654321","email":"email@yahoo.com","owner":{"id":"10","firstName":"first","lastName":"last"}}]}';

		$inputArray = $cinputArray = array();

     	//$input = $request->all();
		//$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['userId'] = $id;
		}

		//{"msg":"success","lastName":"radhan@gmail.com","gender":1,"groupId":1,"userId":21,"createdOn":"2016-05-17","firstName":"jeeva","createBy":0,"modifiedOn":"2016-05-17","modifiedBy":0,"userType":1,"email":"radhan@gmail.com","status":"200"}

		if(!empty($cinputArray)){
			$results = SELF::ShowUserDetailsPost("http://106.51.0.187:8090/cgwfollowon/findcrmuser",$cinputArray);
			$logs = SELF::UserLogsDetailsPost("http://106.51.0.187:8090/cgwfollowon/crmuserlogs",$cinputArray);
		}

	
		$userdata = $results;
		$userlogs= $logs;

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		$responseArray1 = array();
		if(!empty($logs)){
			$responseArray1 = json_decode($logs);
		}

		
		$userDetailArray = array();
		if(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseVal){
				$userDetailArray = $responseVal;
			}
		}
		

		$logsDetailArray = array();
		if(!empty($responseArray1->Crmuserhistory)){
			foreach($responseArray1->Crmuserhistory as $responseVal1){
				$logsDetailArray[] = $responseVal1;
			}
		}
			

	
		$userId = session()->get('userId');

		if(!empty($userId)){
			//return view('admin.users.user_details');
			//return view('admin.users.user_details')->with('userdata', json_decode($userdata, true));
			return view('admin.users.privilege_user_details', ['userdata' => $userDetailArray,'logsdata' => $logsDetailArray]);

		}
		else{
			return redirect('admin/login_user');
		}
    }

    public function ShowUserDetailsPost($url,$params){

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
	 public function UserLogsDetailsPost($url,$params){

		$json_string = '';

		$json_string = '';

		
		if(!empty($params['userId'])){
			$fields['userId'] = $params['userId'];
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