<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PrivilegeUpdateUsersController extends Controller
{

	 public function show($id,Request $request){

		$inputArray = $cinputArray = array();

		$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['userId'] = $id;
		}

		if(!empty($inputArray['submit'])){

			if(
				(!empty($inputArray['firstname']))
				&&
				(!empty($inputArray['email']))
				&&
				(!empty($inputArray['type']))
				&&
				(!empty($inputArray['status']))
				&&
				(!empty($inputArray['gender']))
				&&
				(!empty($inputArray['group']))
			){

				if(!empty($inputArray['firstname'])){
					$cinputArray['firstName'] = $inputArray['firstname'];
				}

				if(!empty($inputArray['lastname'])){
					$cinputArray['lastName'] = $inputArray['lastname'];
				}

				if(!empty($inputArray['email'])){
					$cinputArray['email'] = $inputArray['email'];
				}

				if(!empty($inputArray['password'])){
					$cinputArray['password'] = $inputArray['password'];
				}

				if(!empty($inputArray['type'])){
					$cinputArray['userType'] = $inputArray['type'];
				}

				if(!empty($inputArray['status'])){
					$cinputArray['status'] = $inputArray['status'];
				}

				if(!empty($inputArray['gender'])){
					$cinputArray['gender'] = $inputArray['gender'];
				}

				if(!empty($inputArray['group'])){
					$cinputArray['groupId'] = $inputArray['group'];
				}

				if(!empty(session()->get('userId'))){
					$cinputArray['createdBy'] = session()->get('userId');
				}

				$results = SELF::UpdateUserPost("http://106.51.0.187:8090/cgwfollowon/updatecrmuser",$cinputArray);

				$userdata = $results;

				$responseArray = array();

				if(!empty($results)){
					$responseArray = json_decode($results);
				}

				$userListArray = array();
				if(!empty($responseArray->ticketList)){
					foreach($responseArray->ticketList as $responseVal){
						$userListArray[] = $responseVal;
					}
				}

				$userId = session()->get('userId');

				if(!empty($userId)){
					session()->put('userUpdateSuccess','User has been updated successfully');
					return view('admin.users.privilege_edit_user', ['userdata' => $userListArray]);
					//return view('admin.users.edit_user')->with('userdata', json_decode($userdata, true));
				}
				else{
					return redirect('admin/login_user');
				}
			}
		}
		else{

			Session::forget('userUpdateSuccess');

			if(!empty($cinputArray)){
				$results = SELF::EditUserPost("http://106.51.0.187:8090/cgwfollowon/findcrmuser",$cinputArray);
			}

			$userdata = $results;

			$responseArray = array();

			if(!empty($results)){
				$responseArray = json_decode($results);
			}

			$userListArray = array();
			if(!empty($responseArray->ticketList)){
				foreach($responseArray->ticketList as $responseVal){
					$userListArray = $responseVal;
				}
			}

			//print"<pre>";
			//print_r($userListArray);
			//exit;

			$userId = session()->get('userId');

			if(!empty($userId)){
				//return view('admin.users.edit_user')->with('userdata', json_decode($userListArray, true));
				return view('admin.users.privilege_edit_user', ['userdata' => $userListArray]);
			}
			else{
				return redirect('admin/login_user');
			}
		}
    }

    public function UpdateUserPost($url,$params){

		$json_string = '';

		if(!empty($params['userId'])){
			$fields['userId'] = $params['userId'];
		}

		if(!empty($params['firstName'])){
			$fields['firstName'] = $params['firstName'];
		}

		if(!empty($params['lastName'])){
			$fields['lastName'] = $params['lastName'];
		}

		if(!empty($params['email'])){
			$fields['email'] = $params['email'];
		}

		if(!empty($params['password'])){
			$fields['password'] = $params['password'];
		}

		if(!empty($params['cpassword'])){
			$fields['cpassword'] = $params['cpassword'];
		}

		if(!empty($params['userType'])){
			$fields['userType'] = $params['userType'];
		}

		if(!empty($params['status'])){
			$fields['status'] = $params['status'];
		}

		if(!empty($params['gender'])){
			$fields['gender'] = $params['gender'];
		}

		if(!empty($params['groupId'])){
			$fields['groupId'] = $params['groupId'];
		}

		if(!empty($params['createdBy'])){
			$fields['createdBy'] = $params['createdBy'];
		}

		//print"<pre>";
		//print_r($fields);
		//exit;

		//{"userId":"4","firstName":"admin","lastName":"kirubakaranthirumal@nutech.com","email":"kirubakaranthirumal@nutech.com","password":"123456","userType":"1","status":"2","gender":"1","groupId":"1","createdBy":21}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}

		//echo $json_string;
		//exit;

		$service_url = $url;

		/*
		print"<pre>";
		print_r($fields);
		exit;

		echo $service_url;
		exit;
		*/

		//echo $json_string;
		//exit;

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



    public function EditUserPost($url,$params){

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

    /**
     * Update our user information
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
  
}