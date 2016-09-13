<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateEventController extends Controller{

	 public function show($id,Request $request){

		$userId = session()->get('userId');
		Session::forget('EventUpdateSuccess');
		Session::forget('EventUpdateError');

		$inputArray = $cinputArray = array();

		//$input = $request->all();
		$inputArray = $request->all();

		if(!empty($userId)){
			$cinputArray['userSesId'] = $userId;
		}

		if(!empty($cinputArray)){
			$results = SELF::ListServicePost("http://106.51.0.187:8090/cgwfollowon/activeservices",$cinputArray);
		}

		$responseArray=array();
        $serviceListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		if(!empty($responseArray->activeServices)){
			foreach($responseArray->activeServices as $responseVal){
				$serviceListArray[] = $responseVal;
			}
		}

		//print"<pre>";
		//print_r($serviceListArray);
		//exit;

		$postServiceArray = array();
		if(!empty($serviceListArray)){
			foreach($serviceListArray as $serviceListVal){
				$post_name ="";
				$post_name = "service_".$serviceListVal->serviceId;
				if(!empty($inputArray[$post_name])){
					$postServiceArray[] = $inputArray[$post_name];
				}
			}
		}

		$message = '';
		$input = $request->all();

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
				(!empty($inputArray['editor']))
			){

			if(!empty($inputArray['event_name'])){
				$cinputArray['eventName'] = $inputArray['event_name'];
			}
			if(!empty($inputArray['status'])){
				$cinputArray['status'] = $inputArray['status'];
			}
			if(!empty($inputArray['editor'])){
				$cinputArray['eventDesc'] = $inputArray['editor'];
			}
			if(!empty(session()->get('userId'))){
				$cinputArray['createdBy'] = session()->get('userId');
			}

				$results = SELF::UpdateEventPost("http://106.51.0.187:8090/cgwfollowon/updateevent",$cinputArray);
			}
				$responseArray = array();

				if(!empty($results)){
					$responseArray = json_decode($results);
				}
					/* print"<pre>";
					print_r($responseArray);
					exit;  */
						if(((!empty($postServiceArray)) && (!empty($responseArray->status="200"))))
				{
					$eventserviceinput=array();
					$getevenlist=array();
					//$eventId=$responseArray->EventId;

					if(!empty($id)){
						$eventId = $id;
					if(!empty($postServiceArray)){
						foreach ($postServiceArray as $value) {
							$eventserviceinput['serviceId']  = $value;
							$eventserviceinput['eventId']  = $eventId;
							$getevenlist['eventId']=$eventId;
							$results = SELF::CreateAppEventPost("http://106.51.0.187:8090/cgwfollowon/eventservice",$eventserviceinput);
							$checkedlist = SELF::GetEventListPost("http://106.51.0.187:8090/cgwfollowon/takeservices",$getevenlist);

							}

					}
					}
				}
				$responseArray = array();
					if(!empty($results)){
						$responseArray = json_decode($results);
					}
					$responseArray1 = $serviceSelectArray = array();
					if(!empty($checkedlist)){
						$responseArray1 = json_decode($checkedlist);
						foreach($responseArray1->serviceIds as $responseVal){
							$serviceSelectArray[] = $responseVal;
						}
					}
					/*
					print"<pre>";
					print_r($responseArray1);
					exit;
					*/


				if((!empty($responseArray->status)) && ($responseArray->status == "200")){
					if(!empty($responseArray->msg)){
						if(!empty($id)){
						$eventId = $id;
						Session::forget('EventUpdateError');
						session()->put('EventUpdateSuccess','Event has been Update successfully');
						return view('admin.event.event_edit',['event_id'=>$eventId,'allservice'=>$serviceListArray,'checkedservice'=>$serviceSelectArray]);
						}
					}
				}
				elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
					Session::forget('EventUpdateSuccess');
					session()->put('EventUpdateError','Cannot Update Event');
					return view('admin.event.event_edit',['allservice'=>$serviceListArray,'checkedservice'=>$serviceSelectArray]);
			}
		}
		else{

			//Session::forget('userUpdateSuccess');

			if(!empty($cinputArray)){
				$results = SELF::EditEventPost("http://106.51.0.187:8090/cgwfollowon/findevent",$cinputArray);
				$selectservice = SELF::EditEventPost("http://106.51.0.187:8090/cgwfollowon/takeservices",$cinputArray);
			}

			$eventdata = $results;
			$checkservice=$selectservice;
			$responseArray = array();
			$checkedservicelist=array();

			if(!empty($results)){
				$responseArray = json_decode($results);
			}

			$responseArray2 = array();
			if(!empty($selectservice)){
				$responseArray2 = json_decode($selectservice);
			}

			if(!empty($responseArray2->serviceIds)){
				foreach($responseArray2->serviceIds as $responseVal){
					$checkedservicelist[] = $responseVal;
				}
			}

		/* 	 print"<pre>";
			print_r($responseArray);
			print_r($serviceListArray);
			print_r($checkedservicelist);
			exit;  */
			$userId = session()->get('userId');
			if(!empty($userId)){
				//echo "appId-".$appId;
				//exit;
				//return view('admin.event.event_edit', ['app_id'=>$appId,'eventdata' => $responseArray]);
				return view('admin.event.event_edit', ['eventdata' => $responseArray,'allservice'=>$serviceListArray,'checkedservice'=>$checkedservicelist]);
			}
			else{
				return redirect('admin/login_user');
			}
		}
    }
	public function GetEventListPost($url,$params){

		$json_string = '';

		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
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
		if(!empty($params['serviceId'])){
			$fields['serviceId'] = $params['serviceId'];
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

  public function ListServicePost($url,$params){

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