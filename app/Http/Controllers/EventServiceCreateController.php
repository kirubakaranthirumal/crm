<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EventServiceCreateController extends Controller{

	 /**
	 * Show a list of users
	 * @return \Illuminate\View\View
	 */

    public function index(){

		Session::forget('EventServiceSuccess');
    	Session::forget('EventServiceError');

        $userId = session()->get('userId');

	    $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

       /*  if(!empty($cinputArray)){
		 	$results = SELF::ListAppPost("http://106.51.0.187:8090/cgwfollowon/listapp",$cinputArray);
		}

        $responseArray = array();

        $appListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }
		//print"<pre>";
		//print_r($responseArray);
		//exit;
		if(!empty($responseArray->AppDetails)){
        	foreach($responseArray->AppDetails as $responseVal){
				$appListArray[] = $responseVal;
			}
		} */

		if(!empty($userId)){
            return view('admin.service.service_create');/*  ['appdata' => $appListArray] */
		}
		else{
			return redirect('admin/login_user');
		}
    }

	public function store(Request $request){

		$message = '';
		$input = $request->all();

		$inputArray = $request->all();
		 $userId = session()->get('userId');

		  if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }
		if(
		/* (!empty($inputArray['app_name']))
			&& */
			(!empty($inputArray['service_name']))
			&&
			(!empty($inputArray['status']))
			&&
			(!empty($inputArray['editor']))
		){
		/*
			if(!empty($inputArray['app_name'])){
				$cinputArray['appId'] = $inputArray['app_name'];
			} */
			if(!empty($inputArray['service_name'])){
				$cinputArray['serviceName'] = $inputArray['service_name'];
			}

			if(!empty($inputArray['status'])){
				$cinputArray['status'] = $inputArray['status'];
			}
			if(!empty($inputArray['editor'])){
				$cinputArray['description'] = $inputArray['editor'];
			}

			if(!empty(session()->get('userId'))){
				$cinputArray['createdBy'] = $cinputArray['userSesId'];
			}

			//$results = SELF::CreateServicePost("http://106.51.0.187:8090/cgwfollowon/createservice",$cinputArray);
			$results = SELF::CreateServicePost("http://106.51.0.187:8090/cgwfollowon/createservice",$cinputArray);

		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print"<pre>";
		//print_r($results);
		//exit;

		/* 	if(!empty($cinputArray)){
		 	$results = SELF::ListAppPost("http://106.51.0.187:8090/cgwfollowon/listapp",$cinputArray);
		}

        $responseArray = array();

        $appListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }
		//print"<pre>";
		//print_r($responseArray);
		//exit;
		if(!empty($responseArray->AppDetails)){
        	foreach($responseArray->AppDetails as $responseVal){
				$appListArray[] = $responseVal;
			}
		} */

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				Session::forget('EventServiceError');
				session()->put('EventServiceSuccess','Event has been created successfully');
				 return view('admin.service.service_create');
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
			Session::forget('EventServiceSuccess');
			session()->put('EventServiceError','Cannot create event');
		}

		$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.service.service_create');
		}
		else{
			return redirect('admin/login_user');
		}
    }
     public function CreateServicePost($url,$params){

		$json_string = '';

	/* 	if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
		} */
		if(!empty($params['serviceName'])){
			$fields['serviceName'] = $params['serviceName'];
		}
		if(!empty($params['status'])){
			$fields['status'] = $params['status'];
		}

		if(!empty($params['description'])){
			$fields['description'] = $params['description'];
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

	public function ListAppPost($url,$params){

        $json_string = '';

        if(!empty($params['userSesId'])){
            $fields['userSesId'] = $params['userSesId'];
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