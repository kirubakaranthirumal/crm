<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersForgotPassController extends Controller{

  	public function index(Request $request){

  		Session::forget('ForgotPasswordSuccess');
		Session::forget('ForgotPasswordError');

		$inputArray = $request->all();

		return view('admin.users.forgot_password');
	}

	public function store(Request $request){

		$inputArray = $request->all();

		$cinputArray = array();

		if(!empty($inputArray['submit'])){

			if(!empty($inputArray['email'])){
				$cinputArray['email'] = $inputArray['email'];
			}

			$results = SELF::UpdatePasswordPost("http://106.51.0.187:8090/cgwfollowon/forgotpassword",$cinputArray);

			$change_password = $results;

			$responseArray = array();

			if(!empty($results)){
				$responseArray = json_decode($results);
			}

			//echo $responseArray->status;
			//exit;

			//print"<pre>";
			//print_r($responseArray);
			//exit;
		}

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				Session::forget('ForgotPasswordError');
				session()->put('ForgotPasswordSuccess','Password has been sent successfully');
				return view('admin.users.forgot_password',['post'=>$inputArray]);
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
			Session::forget('ChangePasswordSuccess');
			session()->put('ForgotPasswordError','Cannot Send Password');
			return view('admin.users.forgot_password',['post'=>$inputArray]);
		}
	}

	public function UpdatePasswordPost($url,$params){

		$json_string = '';

		if(!empty($params['email'])){
			$fields['email'] = $params['email'];
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