<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AssignPrivilegeController extends Controller
{

	 public function show($id,Request $request){
		Session::forget('AssignUpdateSuccess');
		Session::forget('AssignUpdateError');
	 

		$inputArray = $cinputArray = array();

		//$input = $request->all();
		$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['puserId'] = $id;
		}
		if(!empty($inputArray['submit'])){

			if(
			(!empty($inputArray['app_create']))
			||
			(!empty($inputArray['app_edit']))
			||
			(!empty($inputArray['app_delete']))
			||
			(!empty($inputArray['app_view']))
			||
			(!empty($inputArray['evt_create']))
			||
			(!empty($inputArray['evt_edit']))
			||
			(!empty($inputArray['evt_delete']))
			||
			(!empty($inputArray['evt_view']))
			||
			(!empty($inputArray['ser_create']))
			||
			(!empty($inputArray['ser_edit']))
			||
			(!empty($inputArray['ser_delete']))
			||
			(!empty($inputArray['ser_view']))
			||
			(!empty($inputArray['usr_create']))
			||
			(!empty($inputArray['usr_edit']))
			||
			(!empty($inputArray['usr_delete']))
			||
			(!empty($inputArray['usr_view']))
			||
			(!empty($inputArray['tk_create']))
			||
			(!empty($inputArray['tk_edit']))
			||
			(!empty($inputArray['tk_delete']))
			||
			(!empty($inputArray['tk_view'])) 
			){
			if(!empty($inputArray['app_create'])){
				$cinputArray['appCreate'] = $inputArray['app_create'];
			}
			else{
				$cinputArray['appCreate'] = '0';
			}
			 if(!empty($inputArray['app_edit'])){
				$cinputArray['appEdit'] = $inputArray['app_edit'];
			}
			else{
				$cinputArray['appEdit'] = '0';
			}
			 if(!empty($inputArray['app_delete'])){
				$cinputArray['appDelete'] = $inputArray['app_delete'];
			}
			else{
				$cinputArray['appDelete'] = '0';
			}
		 	if(!empty($inputArray['app_view'])){
				$cinputArray['appView'] = $inputArray['app_view'];
			}
			else{
				$cinputArray['appView'] = '0';
			}
			if(!empty($inputArray['evt_create'])){
				$cinputArray['eventCreate'] = $inputArray['evt_create'];
			}
			else{
				$cinputArray['eventCreate'] = '0';
			}
			if(!empty($inputArray['evt_edit'])){
				$cinputArray['eventEdit'] = $inputArray['evt_edit'];
			} 
			else{
				$cinputArray['eventEdit'] = '0';
			}
			if(!empty($inputArray['evt_delete'])){
				$cinputArray['eventDelete'] = $inputArray['evt_delete'];
			} 
			else{
				$cinputArray['eventDelete'] = '0';
			}
			if(!empty($inputArray['evt_view'])){
				$cinputArray['eventView'] = $inputArray['evt_view'];
			} 
			else{
				$cinputArray['eventView'] = '0';
			}
			if(!empty($inputArray['ser_create'])){
				$cinputArray['serviceCreate'] = $inputArray['ser_create'];
			}
			else{
				$cinputArray['serviceCreate'] = '0';
			}
			if(!empty($inputArray['ser_edit'])){
				$cinputArray['serviceEdit'] = $inputArray['ser_edit'];
			} 
			else{
				$cinputArray['serviceEdit'] = '0';
			}
			if(!empty($inputArray['ser_delete'])){
				$cinputArray['serviceDelete'] = $inputArray['ser_delete'];
			} 
			else{
				$cinputArray['serviceDelete'] = '0';
			}
			if(!empty($inputArray['ser_view'])){
				$cinputArray['serviceView'] = $inputArray['ser_view'];
			} 
			else{
				$cinputArray['serviceView'] = '0';
			}
				if(!empty($inputArray['usr_create'])){
				$cinputArray['userCreate'] = $inputArray['usr_create'];
			}
			else{
				$cinputArray['userCreate'] = '0';
			}
			if(!empty($inputArray['usr_edit'])){
				$cinputArray['userEdit'] = $inputArray['usr_edit'];
			} 
			else{
				$cinputArray['userEdit'] = '0';
			}
			if(!empty($inputArray['usr_delete'])){
				$cinputArray['userDelete'] = $inputArray['usr_delete'];
			} 
			else{
				$cinputArray['userDelete'] = '0';
			}
			if(!empty($inputArray['usr_view'])){
				$cinputArray['userView'] = $inputArray['usr_view'];
			} 
			else{
				$cinputArray['userView'] = '0';
			}
			if(!empty($inputArray['tk_create'])){
				$cinputArray['ticketCreate'] = $inputArray['tk_create'];
			}
			else{
				$cinputArray['ticketCreate'] = '0';
			}
			if(!empty($inputArray['tk_edit'])){
				$cinputArray['ticketEdit'] = $inputArray['tk_edit'];
			} 
			else{
				$cinputArray['ticketEdit'] = '0';
			}
			if(!empty($inputArray['tk_delete'])){
				$cinputArray['ticketDelete'] = $inputArray['tk_delete'];
			} 
			else{
				$cinputArray['ticketDelete'] = '0';
			}
			if(!empty($inputArray['tk_view'])){
				$cinputArray['ticketView'] = $inputArray['tk_view'];
			} 
			else{
				$cinputArray['ticketView'] = '0';
			}
			if(!empty(session()->get('userId'))){
				$cinputArray['createdBy'] = session()->get('userId');
			}
			}
			//print"<pre>";
			//print_r($cinputArray);
			//exit;
			
				
				$results = SELF::UpdatePrivilegePost("http://106.51.0.187:8090/cgwfollowon/createuserprivelege",$cinputArray);
				$privilege = SELF::EditAssignPost("http://106.51.0.187:8090/cgwfollowon/separateprivilegeuserlist",$cinputArray);

				$userdata = $results;
				$userprivilege=$privilege;
			
				$responseArray = $userprivilege=array();
			

				if(!empty($privilege)){
					$responseArray = json_decode($privilege);
				}
				
					if((!empty($responseArray->status)) && ($responseArray->status == "200")){
						if(!empty($responseArray->msg)){
							Session::forget('AssignUpdateError');
							session()->put('AssignUpdateSuccess','Event has been Update successfully');
							return view('admin.privilege.assign_privilege',['userdata' => $responseArray]);
						}
					}
					elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
						Session::forget('AssignUpdateSuccess');
						session()->put('AssignUpdateError','Cannot Update Event');
						return view('admin.privilege.assign_privilege',['userdata' => $responseArray]);
					}

			/* 	$userId = session()->get('userId');

				if(!empty($userId)){
					//session()->put('userUpdateSuccess','User has been updated successfully');
					return view('admin.event.event_edit')->with('eventdata', json_decode($eventdata, true));
				}
				else{
					return redirect('admin/login_user');
				} */
			
		}
		else{

			//Session::forget('userUpdateSuccess');

			if(!empty($cinputArray)){
				$results = SELF::EditAssignPost("http://106.51.0.187:8090/cgwfollowon/separateprivilegeuserlist",$cinputArray);
			}
		
	
			$userdata = $results;

			  $responseArray = array();
			  $userListArray = array();
			if(!empty($results)){
				$responseArray = json_decode($results);
			}
			//print"<pre>";
			//print_r($responseArray);
			//exit;
			$userId = session()->get('userId');
			if(!empty($userId)){
				return view('admin.privilege.assign_privilege', ['userdata' => $responseArray]);
				//return view('admin.users.edit_user')->with('userdata', json_decode($userdata, true));
			}
			else{
				return redirect('admin/login_user');
			}
		}
    }

    public function UpdatePrivilegePost($url,$params){

		$json_string = '';
		
		if(!empty($params['puserId'])){
			$fields['puserId'] = $params['puserId'];
		}
		if(!empty($params['appCreate'])){
			$fields['appCreate'] = $params['appCreate'];
		}
		else{
			$fields['appCreate'] = '0';
		}
		if(!empty($params['appEdit'])){
			$fields['appEdit'] = $params['appEdit'];
		}
		else{
			$fields['appEdit'] = '0';
		}

		if(!empty($params['appDelete'])){
			$fields['appDelete'] = $params['appDelete'];
		}
		else{
			$fields['appDelete'] = '0';
		}

		if(!empty($params['appView'])){
			$fields['appView'] = $params['appView'];
		}
		else{
			$fields['appView'] = '0';
		}
		if(!empty($params['eventCreate'])){
			$fields['eventCreate'] = $params['eventCreate'];
		}
		else{
			$fields['eventCreate'] = '0';
		}
		if(!empty($params['eventEdit'])){
			$fields['eventEdit'] = $params['eventEdit'];
		}
		else{
			$fields['eventEdit'] = '0';
		}

		if(!empty($params['eventDelete'])){
			$fields['eventDelete'] = $params['eventDelete'];
		}
		else{
			$fields['eventDelete'] = '0';
		}

		if(!empty($params['eventView'])){
			$fields['eventView'] = $params['eventView'];
		}
		else{
			$fields['eventView'] = '0';
		}
		if(!empty($params['serviceCreate'])){
			$fields['serviceCreate'] = $params['serviceCreate'];
		}
		else{
			$fields['serviceCreate'] = '0';
		}
		if(!empty($params['serviceEdit'])){
			$fields['serviceEdit'] = $params['serviceEdit'];
		}
		else{
			$fields['serviceEdit'] = '0';
		}

		if(!empty($params['serviceDelete'])){
			$fields['serviceDelete'] = $params['serviceDelete'];
		}
		else{
			$fields['serviceDelete'] = '0';
		}

		if(!empty($params['serviceView'])){
			$fields['serviceView'] = $params['serviceView'];
		}
		else{
			$fields['serviceView'] = '0';
		}
		if(!empty($params['userCreate'])){
			$fields['userCreate'] = $params['userCreate'];
		}
		else{
			$fields['userCreate'] = '0';
		}
		if(!empty($params['userEdit'])){
			$fields['userEdit'] = $params['userEdit'];
		}
		else{
			$fields['userEdit'] = '0';
		}

		if(!empty($params['userDelete'])){
			$fields['userDelete'] = $params['userDelete'];
		}
		else{
			$fields['userDelete'] = '0';
		}

		if(!empty($params['userView'])){
			$fields['userView'] = $params['userView'];
		}
		else{
			$fields['userView'] = '0';
		}
		if(!empty($params['ticketCreate'])){
			$fields['ticketCreate'] = $params['ticketCreate'];
		}
		else{
			$fields['ticketCreate'] = '0';
		}
		if(!empty($params['ticketEdit'])){
			$fields['ticketEdit'] = $params['ticketEdit'];
		}
		else{
			$fields['ticketEdit'] = '0';
		}

		if(!empty($params['ticketDelete'])){
			$fields['ticketDelete'] = $params['ticketDelete'];
		}
		else{
			$fields['ticketDelete'] = '0';
		}

		if(!empty($params['ticketView'])){
			$fields['ticketView'] = $params['ticketView'];
		}
		else{
			$fields['ticketView'] = '0';
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

		
		Session::forget('AssignUpdateSuccess');
		Session::forget('AssignUpdateError');
		$inputArray = $cinputArray = array();

		//$input = $request->all();
		//$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['puserId'] = $id;
		}
		if(!empty($cinputArray)){
			$results = SELF::EditAssignPost("http://106.51.0.187:8090/cgwfollowon/separateprivilegeuserlist",$cinputArray);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		print"<pre>";
		print_r($responseArray);
		exit;

    	$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.privilege.assign_privilege');
			//return view('admin.users.add_user')->with('leads', json_decode($leads, true));
		}
		else{
			return redirect('admin/login_user');
		}
    }  
    public function EditAssignPost($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['puserId'])){
			$fields['puserId'] = $params['puserId'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}
		 //echo $json_string;
		// exit;
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