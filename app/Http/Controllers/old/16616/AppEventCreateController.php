<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AppEventCreateController extends Controller{

	 /**
	 * Show a list of users
	 * @return \Illuminate\View\View
	 */

    public function index(){
		
		Session::forget('AppEventSuccess');
    	Session::forget('AppEventError');
		
        $userId = session()->get('userId');
		
	    $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

        if(!empty($cinputArray)){
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
		}

		if(!empty($userId)){
            return view('admin.event.event_create', ['appdata' => $appListArray]);
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
			(!empty($inputArray['app_name']))
			&&
			(!empty($inputArray['event_name']))
			&&
			(!empty($inputArray['status']))
			&&
			(!empty($inputArray['description']))
		){
			
			if(!empty($inputArray['app_name'])){
				$cinputArray['appId'] = $inputArray['app_name'];
			}
			if(!empty($inputArray['event_name'])){
				$cinputArray['eventName'] = $inputArray['event_name'];
			}

			if(!empty($inputArray['status'])){
				$cinputArray['status'] = $inputArray['status'];
			}
			if(!empty($inputArray['description'])){
				$cinputArray['eventDesc'] = $inputArray['description'];
			}
			
			if(!empty(session()->get('userId'))){
				$cinputArray['createdBy'] = $cinputArray['userSesId'];
			}

			$results = SELF::CreateEventPost("http://106.51.0.187:8090/cgwfollowon/createevent",$cinputArray);
		}
			$responseArray = array();
			if(!empty($results)){
				$responseArray = json_decode($results);
			}
		//print"<pre>";
		//print_r($responseArray);
		//exit;
		if(!empty($cinputArray)){
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
		}
		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				Session::forget('AppEventError');
				session()->put('AppEventSuccess','Event has been created successfully');
				return view('admin.event.event_create', ['appdata' => $appListArray]);
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
			Session::forget('AppEventSuccess');
			session()->put('AppEventError','Cannot create event');
		}

		$userId = session()->get('userId');
		
		if(!empty($userId)){
			return view('admin.event.event_create', ['appdata' => $appListArray]);
		}
		else{
			return redirect('admin/login_user');
		}
    }
     public function CreateEventPost($url,$params){

		$json_string = '';

		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
		}
		if(!empty($params['eventName'])){
			$fields['eventName'] = $params['eventName'];
		}
		if(!empty($params['status'])){
			$fields['status'] = $params['status'];
		}

		if(!empty($params['eventDesc'])){
			$fields['eventDesc'] = $params['eventDesc'];
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