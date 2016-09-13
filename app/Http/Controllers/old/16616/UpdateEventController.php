<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateEventController extends Controller
{

	 public function show($id,Request $request){

		Session::forget('EventUpdateSuccess');
		Session::forget('EventUpdateError');


		$inputArray = $cinputArray = array();

		//$input = $request->all();
		$inputArray = $request->all();



		if(!empty($id)){
			$cinputArray['eventId'] = $id;
		}

		$appId="";
		if(!empty($inputArray['app_id'])){
			$appId = $inputArray['app_id'];
		}

		if(!empty($inputArray['submit'])){

			if(
				(!empty($inputArray['event_name']))
				&&
				(!empty($inputArray['status']))
				&&
				(!empty($inputArray['description']))
			){

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
				$cinputArray['createdBy'] = session()->get('userId');
			}

				$results = SELF::UpdateEventPost("http://106.51.0.187:8090/cgwfollowon/updateevent",$cinputArray);

				$eventdata = $results;

				$responseArray = array();

				if(!empty($results)){
					$responseArray = json_decode($results);
				}

				if((!empty($responseArray->status)) && ($responseArray->status == "200")){
					if(!empty($responseArray->msg)){
						Session::forget('EventUpdateError');
						session()->put('EventUpdateSuccess','Event has been Update successfully');
						return view('admin.event.event_edit',['app_id'=>$appId,'eventdata' => $responseArray]);
					}
				}
				elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
					Session::forget('EventUpdateSuccess');
					session()->put('EventUpdateError','Cannot Update Event');
					return view('admin.event.event_edit',['app_id'=>$appId,'eventdata' => $responseArray]);
				}
			}
		}
		else{

			//Session::forget('userUpdateSuccess');

			if(!empty($cinputArray)){
				$results = SELF::EditEventPost("http://106.51.0.187:8090/cgwfollowon/findevent",$cinputArray);
			}

			$eventdata = $results;

			$responseArray = array();
			if(!empty($results)){
				$responseArray = json_decode($results);
			}
			//print"<pre>";
			//print_r($responseArray);
			//exit;
			$userId = session()->get('userId');
			if(!empty($userId)){
				//echo "appId-".$appId;
				//exit;
				return view('admin.event.event_edit', ['app_id'=>$appId,'eventdata' => $responseArray]);
			}
			else{
				return redirect('admin/login_user');
			}
		}
    }

    public function UpdateEventPost($url,$params){

		$json_string = '';


		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
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
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(){

		//echo "index";
		//exit;
		//$leads = '{"error":false,"member":[{"id":"1","firstName":"first","lastName":"last","phoneNumber":"0987654321","email":"email@yahoo.com","owner":{"id":"10","firstName":"first","lastName":"last"}}]}';

		Session::forget('AppUpdateSuccess');
		Session::forget('AppUpdateError');
		$inputArray = $cinputArray = array();

		//$input = $request->all();
		//$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['eventId'] = $id;
		}
		if(!empty($cinputArray)){
			$results = SELF::EditEventPost("http://106.51.0.187:8090/cgwfollowon/findevent",$cinputArray);
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
			return view('admin.event.event_edit');
			//return view('admin.users.add_user')->with('leads', json_decode($leads, true));
		}
		else{
			return redirect('admin/login_user');
		}
    }
    public function EditEventPost($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}
		// echo $json_string;
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