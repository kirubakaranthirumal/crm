<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateServiceController extends Controller
{

	 public function show($id,Request $request){

		Session::forget('ServiceUpdateSuccess');
		Session::forget('ServiceUpdateError');
		$inputArray = $cinputArray = array();

		//$input = $request->all();
		$inputArray = $request->all();
	
		
		if(!empty($id)){
			$cinputArray['serviceId'] = $id;
		}
			//print"<pre>";
			//print_r($cinputArray);
			//exit;
		if(!empty($inputArray['submit'])){

			if(
				(!empty($inputArray['service_name']))
				&&
				(!empty($inputArray['status']))
				&&
				(!empty($inputArray['description']))
			){
			if(!empty($inputArray['service_name'])){
				$cinputArray['serviceName'] = $inputArray['service_name'];
			}
			if(!empty($inputArray['status'])){
				$cinputArray['status'] = $inputArray['status'];
			}
			if(!empty($inputArray['description'])){
				$cinputArray['description'] = $inputArray['description'];
			}

			if(!empty(session()->get('userId'))){
				$cinputArray['createdBy'] = session()->get('userId');
			} 
				//print"<pre>";
				//print_r($cinputArray);
				//exit;
				$results = SELF::UpdateServicePost("http://106.51.0.187:8090/cgwfollowon/updateservice",$cinputArray);

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
							Session::forget('ServiceUpdateError');
							session()->put('ServiceUpdateSuccess','App has been Update successfully');
							return view('admin.service.service_edit');
						}
					}
					elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
						Session::forget('ServiceUpdateSuccess');
						session()->put('ServiceUpdateError','Cannot Update ');
					}

				$userId = session()->get('userId');

				if(!empty($userId)){
					//session()->put('userUpdateSuccess','User has been updated successfully');
					return view('admin.service.service_edit')->with('appdata', json_decode($appdata, true));
				}
				else{
					return redirect('admin/login_user');
				}
			}
		}
		else{

			//Session::forget('userUpdateSuccess');

			if(!empty($cinputArray)){
				$results = SELF::EditServicePost("http://106.51.0.187:8090/cgwfollowon/viewservice",$cinputArray);
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

			$userId = session()->get('userId');

			if(!empty($userId)){
				return view('admin.service.service_edit', ['editservice' => $responseArray]);
				//return view('admin.users.edit_user')->with('userdata', json_decode($userdata, true));
			}
			else{
				return redirect('admin/login_user');
			}
		}
    }

    public function UpdateServicePost($url,$params){

		$json_string = '';

		if(!empty($params['serviceId'])){
			$fields['serviceId'] = $params['serviceId'];
		}
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
		
		Session::forget('ServiceUpdateSuccess');
		Session::forget('ServiceUpdateError');
		$inputArray = $cinputArray = array();

		//$input = $request->all();
		//$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['serviceId'] = $id;
		}

		if(!empty($cinputArray)){
			$results = SELF::EditServicePost("http://106.51.0.187:8090/cgwfollowon/viewservice",$cinputArray);
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
			return view('admin.service.service_edit');
			//return view('admin.users.add_user')->with('leads', json_decode($leads, true));
		}
		else{
			return redirect('admin/login_user');
		}
    }
    public function EditServicePost($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['serviceId'])){
			$fields['serviceId'] = $params['serviceId'];
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