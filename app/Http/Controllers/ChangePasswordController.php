<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{

	 public function show($id,Request $request){

		Session::forget('ChangePasswordSuccess');
		Session::forget('ChangePasswordError');

		$userId = session()->get('userId');

		$inputArray = $cinputArray = array();

		//$input = $request->all();
		$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['userId'] = $id;
		}

		if(!empty($inputArray['submit'])){
			if(
				(!empty($inputArray['old_password']))
				&&
				(!empty($inputArray['new_password']))
			){

			//if(!empty($inputArray['email'])){
			//	$cinputArray['email'] = $inputArray['email'];
			//}

			if(!empty($inputArray['old_password'])){
				$cinputArray['oldPassword'] = $inputArray['old_password'];
			}

			if(!empty($inputArray['new_password'])){
				$cinputArray['newPassword'] = $inputArray['new_password'];
			}

				//print"<pre>";
				//print_r($cinputArray);
				//exit;

				$results = SELF::UpdatePasswordPost("http://106.51.0.187:8090/cgwfollowon/changepassword",$cinputArray);

				$change_password = $results;

				$responseArray = array();

				if(!empty($results)){
					$responseArray = json_decode($results);
				}

				//print"<pre>";
				//print_r($responseArray);
				//exit;
			}
		}

		/*
		else{

			//Session::forget('userUpdateSuccess');

			if(!empty($cinputArray)){
				$results = SELF::EditUserPost("http://106.51.0.187:8090/cgwfollowon/findcrmuser",$cinputArray);
			}

			$appdata = $results;

			$responseArray = array();
			 $userListArray = array();
			if(!empty($results)){
				$responseArray = json_decode($results);
			}
		}
		*/

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				Session::forget('ChangePasswordError');
				session()->put('ChangePasswordSuccess',$responseArray->msg);
				return view('admin.users.change_password',['usrId'=>$userId]);
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
			Session::forget('ChangePasswordSuccess');
			session()->put('ChangePasswordError',$responseArray->msg);
			//echo "here2";
			//exit;
			return view('admin.users.change_password',['usrId'=>$userId]);
		}
		else{
			//echo "here3";
			//exit;
			return view('admin.users.change_password',['usrId'=>$userId]);
		}
    }

    public function UpdatePasswordPost($url,$params){

		$json_string = '';

		/*
		if(!empty($params['email'])){
			$fields['email'] = $params['email'];
		}
		*/

		if(!empty($params['userId'])){
			$fields['userId'] = $params['userId'];
		}

		if(!empty($params['oldPassword'])){
			$fields['oldPassword'] = $params['oldPassword'];
		}
		if(!empty($params['newPassword'])){
			$fields['newPassword'] = $params['newPassword'];
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


    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(){

		//$leads = '{"error":false,"member":[{"id":"1","firstName":"first","lastName":"last","phoneNumber":"0987654321","email":"email@yahoo.com","owner":{"id":"10","firstName":"first","lastName":"last"}}]}';

		Session::forget('ChangePasswordSuccess');
		Session::forget('ChangePasswordError');
		$inputArray = $cinputArray = array();

		//$input = $request->all();
		//$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['userId'] = $id;
		}

		if(!empty($cinputArray)){
			$results = SELF::EditUserPost("http://106.51.0.187:8090/cgwfollowon/findcrmuser",$cinputArray);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print"<pre>";
		//print_r($responseArray);
		//exit;

    	$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.users.change_password');
			//return view('admin.users.add_user')->with('leads', json_decode($leads, true));
		}
		else{
			return redirect('admin/login_user');
		}
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

    }