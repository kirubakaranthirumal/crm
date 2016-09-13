<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AppCreateController extends Controller{

	 /**
	 * Show a list of users
	 * @return \Illuminate\View\View
	 */

	public function index(){

		Session::forget('AppSuccess');
		Session::forget('AppError');

		$userId = session()->get('userId');
		return view('admin.app.create_app');
	}

	public function store(Request $request){
		
		$message = '';
		$input = $request->all();

		$inputArray = $cinputArray = array();

		$inputArray = $request->all();
		
		if(
			(!empty($inputArray['app_name']))
			&&
			(!empty($inputArray['app_url']))
			&&
			(!empty($inputArray['status']))
			&&
			(!empty($inputArray['description']))
		){

			if(!empty($inputArray['app_name'])){
				$cinputArray['appName'] = $inputArray['app_name'];
			}
			if(!empty($inputArray['app_url'])){
				$cinputArray['appUrl'] = $inputArray['app_url'];
			}
			if(!empty($inputArray['status'])){
				$cinputArray['status'] = $inputArray['status'];
			}
			if(!empty($inputArray['description'])){
				$cinputArray['appDesc'] = $inputArray['description'];
			}

			if(!empty(session()->get('userId'))){
				$cinputArray['createdBy'] = session()->get('userId');
			}

			$results = SELF::CreateAppPost("http://106.51.0.187:8090/cgwfollowon/createapplication",$cinputArray);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}
		
			//print "<pre>";
			//print_r($responseArray);
			//exit;
		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				Session::forget('AppError');
				session()->put('AppSuccess','Ticket has been created successfully');
				return view('admin.app.create_app');
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
			Session::forget('AppSuccess');
			session()->put('AppError','Cannot create ticket');
		}

		$userId = session()->get('userId');
		if(!empty($userId)){
			return view('admin.app.create_app');
		}
		else{
			return redirect('admin/login_user');
		}
    }

     public function CreateAppPost($url,$params){

		$json_string = '';

		if(!empty($params['appName'])){
			$fields['appName'] = $params['appName'];
		}
		if(!empty($params['appUrl'])){
			$fields['appUrl'] = $params['appUrl'];
		}
		if(!empty($params['status'])){
			$fields['status'] = $params['status'];
		}

		if(!empty($params['appDesc'])){
			$fields['appDesc'] = $params['appDesc'];
		}

		if(!empty($params['createdBy'])){
			$fields['createdBy'] = $params['createdBy'];
		}

		//$fields['portelUserId'] = "0";
		//$fields['modifiedBy'] = "0";

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