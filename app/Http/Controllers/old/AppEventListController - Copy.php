<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AppEventListController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

	public function show($id){


			Session::forget('DeleteEventSuccess');
			Session::forget('DeleteEventError');
			 $userId = session()->get('userId');

	        $cinputArray = array();

	        if(!empty($userId)){
	            $cinputArray['appId'] = $id;
	        }


			if(!empty($cinputArray)){
			 	$results = SELF::ListAppPost("http://106.51.0.187:8090/cgwfollowon/takeevents",$cinputArray);
			}

	        $responseArray = array();
			$eventListArray = array();

	        $userListArray = array();
	        if(!empty($results)){
	            $responseArray = json_decode($results);
	        }

			if(!empty($responseArray->eventIds)){
	        	foreach($responseArray->eventIds as $responseVal){
					$eventListArray[] = $responseVal;
				}
			}

			if(!empty($eventListArray)){
				foreach($eventListArray as $eventListVal){
					$eventIdArray[] = $eventListVal;
				}
			}

			$cinputArray1 = array();
			$checkedeventlist=array();
			if(!empty($eventIdArray)){
				foreach($eventIdArray as $eventId){
					$cinputArray1['eventId'] = $eventId->eventId;
					$serviceresults = SELF::ListEventPost2("http://106.51.0.187:8090/cgwfollowon/findevent",$cinputArray1);

					if(!empty($serviceresults)){
						$responseArray2 = json_decode($serviceresults);
					}
					$checkedeventlist[] = $responseArray2;
				}
			}
		/* 	print"<pre>";
			print_r($checkedservicelist);
			exit; */
		/* 	print"<pre>";
			print_r($checkedservicelist);
			exit; */
	      if(!empty($userId)){
	                	return view('admin.event.event_list', ['appid' => $id,'appdata' => $checkedeventlist]);
	                }
				else{
					return redirect('admin/login_user');
				}
		}

	public function load_event(Request $request){

		$inputArray = $cinputArray = array();
		$appResponseArray = $appListArray = $eventIdResponseArray = array();
		$eventinputArray = $responseArray2 = $appeventlist = array();

		$inputArray = $request->all();

		if(!empty($inputArray['appId'])){
			$cinputArray['appId'] = $inputArray['appId'];
		}

		$app_event_results="";
		if(!empty($cinputArray)){
			$app_event_results = SELF::ListEventPost("http://106.51.0.187:8090/cgwfollowon/activeeventsbyid",$cinputArray);
		}

		if(!empty($app_event_results)){
			$eventResponseArray = json_decode($app_event_results);
		}

		if(!empty($eventResponseArray->activeEvents)){
			foreach($eventResponseArray->activeEvents as $responseVal){
				$appeventlist[] = $responseVal;
			}
		}

		/*
		print"<pre>";
		print_r($appeventlist);
		exit;
		*/

		$userId = session()->get('userId');

		$eventId="";
		if(!empty($inputArray['eventId'])){
			$eventId = $inputArray['eventId'];
		}

		return view('admin.ticket_form.select_event_by_app', ['eventid' => $eventId,'eventdata' => $appeventlist]);
	}

    public function FindEventPost($url,$params){

        $json_string = '';

        if(!empty($params['eventId'])){
            $fields['eventId'] = $params['eventId'];
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

    public function ListEventPost2($url,$params){

		$json_string = '';

		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
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


    public function ListEventPost($url,$params){

			$json_string = '';

			if(!empty($params['appId'])){
				$fields['appId'] = $params['appId'];
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


	public function ListAppPost($url,$params){

	        $json_string = '';

	        if(!empty($params['appId'])){
	            $fields['appId'] = $params['appId'];
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
