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
	 	$cinputArray = array();

        if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

        if(!empty($cinputArray)){
		 	$results = SELF::ListEventPost("http://106.51.0.187:8090/cgwfollowon/activeevents",$cinputArray);
		}

        $responseArray = array();
        $eventListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		//print"<pre>";
		//print_r($responseArray);
		//exit;

		if(!empty($responseArray->activeEvents)){
        	foreach($responseArray->activeEvents as $responseVal){
				$eventListArray[] = $responseVal;
			}
		}

		//print"<pre>";
		//print_r($eventListArray);
		//exit;

		//print"<pre>";
		//print_r($eventListArray);
		//exit;
		if(!empty($userId)){
            return view('admin.app.create_app', ['eventdata' => $eventListArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}
	public function store(Request $request){
		$userId = session()->get('userId');

		$message = '';
		$input = $request->all();

		$inputArray = $cinputArray = array();

		$inputArray = $request->all();
		if(!empty($userId)){
		$cinputArray['userSesId'] = $userId;
		}
		if(!empty($cinputArray)){
		$results = SELF::ListEventPost("http://106.51.0.187:8090/cgwfollowon/activeevents",$cinputArray);
		}
		$responseArray=array();
        $eventListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		//print"<pre>";
		//print_r($responseArray);
		//exit;
		if(!empty($responseArray->activeEvents)){
			foreach($responseArray->activeEvents as $responseVal){
				$eventListArray[] = $responseVal;
			}
		}

		$postServiceArray = array();
		foreach($eventListArray as $eventListVal){
			$post_name ="";
			$post_name = "event_".$eventListVal->eventId;
				if(!empty($inputArray[$post_name])){
					$postServiceArray[] = $inputArray[$post_name];
				}
			}


		//print"<pre>";
		//print_r($inputArray);
		//print"<hr>";
		//print_r($postServiceArray);
		//exit;

		if(
			/* (!empty($postServiceArray))
			&&   */
			(!empty($inputArray['app_name']))
			&&
			(!empty($inputArray['app_url']))
			&&
			(!empty($inputArray['status']))
			&&
			(!empty($inputArray['description']))
		){
		/* 	if(!empty($postServiceArray)){
				foreach ($postServiceArray as $value) {
					$cinputArray['EventId']  = $value;
					print"<pre>";
					print_r($cinputArray);
					}
				exit;
			} */
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
		if(((!empty($postServiceArray)) && (!empty($responseArray->ApplicationId))))
		{
			$appeventinput=array();
			$appId=$responseArray->ApplicationId;
			if(!empty($postServiceArray)){
				foreach ($postServiceArray as $value) {
					$appeventinput['eventId']  = $value;
					$appeventinput['appId']  = $appId;
					$results = SELF::CreateAppEventPost("http://106.51.0.187:8090/cgwfollowon/appevent",$appeventinput);
				}
			}
		}
		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}
		//print"<pre>";
		//print_r($responseArray);
		//exit;
		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				Session::forget('AppError');
				session()->put('AppSuccess','App has been created successfully');
				return view('admin.app.create_app',['eventdata' => $eventListArray]);
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
			Session::forget('AppSuccess');
			session()->put('AppError','Cannot create App');
		}

		$userId = session()->get('userId');
		if(!empty($userId)){
			return view('admin.app.create_app',['eventdata' => $eventListArray]);
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
 public function CreateAppEventPost($url,$params){

		$json_string = '';

		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
		}
		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
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
	public function ListEventPost($url,$params){

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