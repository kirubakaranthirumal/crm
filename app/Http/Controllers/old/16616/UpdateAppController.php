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

	 	
		Session::forget('AppUpdateSuccess');
		Session::forget('AppUpdateError');
	 	//$leads = '{"error":false,"member":[{"id":"1","firstName":"first","lastName":"last","phoneNumber":"0987654321","email":"email@yahoo.com","owner":{"id":"10","firstName":"first","lastName":"last"}}]}';

		$inputArray = $cinputArray = array();

		//$input = $request->all();
		$inputArray = $request->all();
	
		
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
				//print"<pre>";
				//print_r($cinputArray);
				//exit;
				$results = SELF::UpdateAppPost("http://106.51.0.187:8090/cgwfollowon/updateapp",$cinputArray);

				$appdata = $results;

				$responseArray = array();

				if(!empty($results)){
					$responseArray = json_decode($results);
				}

				//print"<pre>";
				//print_r($responseArray);
				//exit;
					if((!empty($responseArray->status)) && ($responseArray->status == "200")){
						if(!empty($responseArray->msg)){
							Session::forget('AppUpdateError');
							session()->put('AppUpdateSuccess','App has been Update successfully');
							return view('admin.app.edit_app');
						}
					}
					elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
						Session::forget('AppUpdateSuccess');
						session()->put('AppUpdateError','Cannot Update ');
					}

				$userId = session()->get('userId');

				if(!empty($userId)){
					//session()->put('userUpdateSuccess','User has been updated successfully');
					return view('admin.app.edit_app')->with('appdata', json_decode($appdata, true));
				}
				else{
					return redirect('admin/login_user');
				}
			}
		}
		else{

			//Session::forget('userUpdateSuccess');

			if(!empty($cinputArray)){
				$results = SELF::EditAppPost("http://106.51.0.187:8090/cgwfollowon/findapp",$cinputArray);
			}

			$appdata = $results;

			$responseArray = array();
			 $appListArray = array();
			if(!empty($results)){
				$responseArray = json_decode($results);
			}
			//print"<pre>";
			//print_r($responseArray);
			//exit;
			
			//print"<pre>";
			//print_r($responseArray);
			//exit;

			$userId = session()->get('userId');

			if(!empty($userId)){
				return view('admin.app.edit_app', ['editapp' => $responseArray]);
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

    
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

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