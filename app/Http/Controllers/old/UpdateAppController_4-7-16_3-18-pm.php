<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateAppController extends Controller
{

	 public function show($id,Request $request){
		$userId = session()->get('userId');
		Session::forget('AppUpdateSuccess');
		Session::forget('AppUpdateError');
	 	//$leads = '{"error":false,"member":[{"id":"1","firstName":"first","lastName":"last","phoneNumber":"0987654321","email":"email@yahoo.com","owner":{"id":"10","firstName":"first","lastName":"last"}}]}';

		$inputArray = $cinputArray = array();

		//$input = $request->all();
		$inputArray = $request->all();
	if(!empty($userId)){
		$cinputArray['userSesId'] = $userId;
		}
		if(!empty($cinputArray)){
		$results = SELF::ListEventPost("http://106.51.0.187:8090/cgwfollowon/eventlist",$cinputArray);
		}
		$responseArray=array();
        $eventListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		foreach($responseArray->eventList as $responseVal){
				$eventListArray[] = $responseVal;
			}
			$postServiceArray = array();
		foreach($eventListArray as $eventListVal){
			$post_name ="";
			$post_name = "event_".$eventListVal->eventId;
				if(!empty($inputArray[$post_name])){
					$postServiceArray[] = $inputArray[$post_name];
				}
			}

		if(!empty($id)){
			$cinputArray['appId'] = $id;
		}
			//print"<pre>";
			//print_r($cinputArray);
			//exit;
		if(!empty($inputArray['submit'])){

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
				/* print"<pre>";
				print_r($cinputArray);
				exit; */

				$results = SELF::UpdateAppPost("http://106.51.0.187:8090/cgwfollowon/updateapp",$cinputArray);
			}
				$responseArray = array();

				if(!empty($results)){
					$responseArray = json_decode($results);
				}
					if(((!empty($postServiceArray)) && (!empty($responseArray->status=="200"))))
					{
						$appeventinput=array();
						$getevenlist=array();
						if(!empty($id)){
						$appId=$id;
						if(!empty($postServiceArray)){
							foreach ($postServiceArray as $value) {
								$appeventinput['eventId']  = $value;
								$appeventinput['appId']  = $appId;
								$getevenlist['appId']=$appId;
							//	print"<pre>";
								//print_r($appeventinput);

								$results = SELF::CreateAppEventPost("http://106.51.0.187:8090/cgwfollowon/appevent",$appeventinput);
							    $checkedlist = SELF::GetEventListPost("http://106.51.0.187:8090/cgwfollowon/takeevents",$getevenlist);
							}
							//exit;
						}
					}
					}

						$responseArray = array();
						if(!empty($results)){
					$responseArray = json_decode($results);
					}
					$responseArray1 = array();
						if(!empty($checkedlist)){
					$responseArray1 = json_decode($checkedlist);
					}
					foreach($responseArray1->eventIds as $responseVal){
						$eventSelectArray[] = $responseVal;
					}
					/* print"<pre>";
					print_r($responseArray);
					print_r($eventSelectArray);
					exit; */
					if((!empty($responseArray->status)) && ($responseArray->status == "200")){
						if(!empty($responseArray->msg)){
							Session::forget('AppUpdateError');
							session()->put('AppUpdateSuccess','App has been Update successfully');
							return view('admin.app.edit_app',['eventdata' => $eventListArray,'checkedevent'=>$eventSelectArray]);
						}
					}
					elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
						Session::forget('AppUpdateSuccess');
						session()->put('AppUpdateError','Cannot Update ');
					}

				$userId = session()->get('userId');

				if(!empty($userId)){
					//session()->put('userUpdateSuccess','User has been updated successfully');
					return view('admin.app.edit_app',['editapp' => $appresponse,'eventdata' => $eventListArray,'checkedevent'=>$eventSelectArray]);
				}
				else{
					return redirect('admin/login_user');
				}
			}

		else{

			//Session::forget('userUpdateSuccess');

			if(!empty($cinputArray)){
				$results = SELF::EditAppPost("http://106.51.0.187:8090/cgwfollowon/findapp",$cinputArray);
				$selectevent = SELF::EditAppPost("http://106.51.0.187:8090/cgwfollowon/takeevents",$cinputArray);
			}
			$appdata = $results;
			$checkevent=$selectevent;
			$responseArray = array();
			$responseArray2 = array();
			$appListArray = array();
			$eventSelectArray=array();
			if(!empty($results)){
				$responseArray = json_decode($results);
			}
			if(!empty($selectevent)){
				$responseArray2 = json_decode($selectevent);
			}
/* 		 	print"<pre>";
			print_r($responseArray2);
			exit;   */
			if(!empty($responseArray2->eventIds))
			{
			foreach($responseArray2->eventIds as $responseVal){
				$eventSelectArray[] = $responseVal;
			}
			}
			//$eventresponse=$responseArray2;
			$appresponse=$responseArray;
			//print"<pre>";
			//print_r($responseArray);
		$userId = session()->get('userId');
			if(!empty($userId)){
		$cinputArray['userSesId'] = $userId;
		}
		if(!empty($cinputArray)){
		$results = SELF::ListEventPost("http://106.51.0.187:8090/cgwfollowon/eventlist",$cinputArray);
		}
		$responseArray=array();
        $eventListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }
	/* 	print"<pre>";
		print_r($responseArray);
		exit; */
		foreach($responseArray->eventList as $responseVal){
				$eventListArray[] = $responseVal;
			}
		/* 	print"<pre>";
			print_r($appresponse);
			print_r($eventSelectArray);
			print_r($eventListArray);
			exit;  */

			$userId = session()->get('userId');

			if(!empty($userId)){
				return view('admin.app.edit_app', ['editapp' => $appresponse,'eventdata' => $eventListArray,'checkedevent'=>$eventSelectArray]);
				//return view('admin.users.edit_user')->with('userdata', json_decode($userdata, true));
			}
			else{

				return redirect('admin/login_user');
			}
		}
    }

    public function UpdateAppPost($url,$params){

		$json_string = '';

		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
		}

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
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */
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
	 public function GetEventListPost($url,$params){

		$json_string = '';

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
    public function index(){

		//$leads = '{"error":false,"member":[{"id":"1","firstName":"first","lastName":"last","phoneNumber":"0987654321","email":"email@yahoo.com","owner":{"id":"10","firstName":"first","lastName":"last"}}]}';

		Session::forget('AppUpdateSuccess');
		Session::forget('AppUpdateError');
		$inputArray = $cinputArray = array();

		//$input = $request->all();
		//$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['appId'] = $id;
		}

		if(!empty($cinputArray)){
			$results = SELF::EditAppPost("http://106.51.0.187:8090/cgwfollowon/findapp",$cinputArray);
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
			return view('admin.app.edit_app');
			//return view('admin.users.add_user')->with('leads', json_decode($leads, true));
		}
		else{
			return redirect('admin/login_user');
		}
    }
    public function EditAppPost($url,$params){

		$json_string = '';

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