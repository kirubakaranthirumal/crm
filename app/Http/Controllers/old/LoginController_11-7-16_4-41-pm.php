<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller{

	public function index(){
	   	Session::forget('userSuccess');
    	Session::forget('userError');
	   	Session::forget('loginError');
	   	Session::forget('userTypeError');

	   	$cinputArray = $appResponseArray = array();

	   	$cinputArray['userSesId'] = 1;

		$appresults = "";
		if(!empty($cinputArray)){
			$appresults = SELF::ListAppPost("http://106.51.0.187:8090/cgwfollowon/listapp",$cinputArray);
		}

		if(!empty($appresults)){
			$appResponseArray = json_decode($appresults);
		}

		$appListArray = array();
		if(!empty($appResponseArray->AppDetails)){
			foreach($appResponseArray->AppDetails as $responseVal){
				$appListArray[] = $responseVal;
			}
		}

		return view('auth.login',['app_data'=>$appListArray]);
	}

	public function store(Request $request){

		session_start();

		Session::forget('userTypeError');

		$appinputArray = $appResponseArray = array();

		$appinputArray['userSesId'] = 1;

		$appresults = "";
		if(!empty($appinputArray)){
			$appresults = SELF::ListAppPost("http://106.51.0.187:8090/cgwfollowon/listapp",$appinputArray);
		}

		if(!empty($appresults)){
			$appResponseArray = json_decode($appresults);
		}

		$appListArray = array();
		if(!empty($appResponseArray->AppDetails)){
			foreach($appResponseArray->AppDetails as $responseVal){
				$appListArray[] = $responseVal;
			}
		}

		$inputArray = array();

		$inputArray = $request->all();

		//list all app
		$cinputArray = $appResponseArray = array();

		$cinputArray['userSesId'] = 1;

		$appresults = "";
		if(!empty($cinputArray)){
			$appresults = SELF::ListAppPost("http://106.51.0.187:8090/cgwfollowon/listapp",$cinputArray);
		}

		if(!empty($appresults)){
			$appResponseArray = json_decode($appresults);
		}

		$appListArray = array();
		if(!empty($appResponseArray->AppDetails)){
			foreach($appResponseArray->AppDetails as $responseVal){
				$appListArray[] = $responseVal;
			}
		}

		if((!empty($inputArray['email'])) && (!empty($inputArray['password']))){
			$results = SELF::LoginPost("http://106.51.0.187:8090/cgwfollowon/crmlogin",$inputArray);
		}

		//return view('admin.users.add_user')->with('message', json_decode($message, true));

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print"<pre>";
		//print_r($responseArray);
		//exit;

		$userTypeValidationError = array();
		if((!empty($responseArray->userType)) && ($responseArray->userType != 1)){
			if((empty($inputArray['application'])) || (empty($inputArray['event']))){
				$userTypeValidationError['userType'] = "Select application and event to procced with login for this type of users";
			}
		}

		if(!empty($userTypeValidationError)){
			Session::forget('loginError');
			session()->put('userTypeError',$userTypeValidationError['userType']);
			return view('auth.login',['app_data'=>$appListArray,'error'=>$userTypeValidationError]);
		}
		else{
			if((!empty($responseArray->status)) && ($responseArray->status == "200")){
				if((!empty($responseArray->userName)) && (!empty($responseArray->userId)) && (!empty($responseArray->email))){

					session()->put('userId', $responseArray->userId);
					session()->put('userType', $responseArray->userType);
					session()->put('userName', $responseArray->userName);
					session()->put('email', $responseArray->email);

					$userType="";
					$userType = session()->get('userType');

					if((!empty($userType)) && ($userType != 1)){
						if(!empty($inputArray['application'])){
							session()->put('appId', $inputArray['application']);
						}
						if(!empty($inputArray['event'])){
							session()->put('eventId', $inputArray['event']);
						}
					}

					if(!empty($responseArray->eventView)){
						session()->put('eventView' , $responseArray->eventView);
					}
					if(!empty($responseArray->eventCreate)){
						session()->put('eventCreate' , $responseArray->eventCreate);
					}
					if(!empty($responseArray->eventEdit)){
						session()->put('eventEdit' , $responseArray->eventEdit);
					}
					if(!empty($responseArray->eventDelete)){
						session()->put('eventDelete' , $responseArray->eventDelete);
					}

					if(!empty($responseArray->appView)){
						session()->put('appView' , $responseArray->appView);
					}
					if(!empty($responseArray->appCreate)){
						session()->put('appCreate' , $responseArray->appCreate);
					}
					if(!empty($responseArray->appEdit)){
						session()->put('appEdit' , $responseArray->appEdit);
					}
					if(!empty($responseArray->appDelete)){
						session()->put('appDelete' , $responseArray->appDelete);
					}

					if(!empty($responseArray->userView)){
						session()->put('userView' , $responseArray->userView);
					}
					if(!empty($responseArray->userCreate)){
						session()->put('userCreate' , $responseArray->userCreate);
					}
					if(!empty($responseArray->userEdit)){
						session()->put('userEdit' , $responseArray->userEdit);
					}
					if(!empty($responseArray->userDelete)){
						session()->put('userDelete' , $responseArray->userDelete);
					}

					if(!empty($responseArray->ticketView)){
						session()->put('ticketView' , $responseArray->ticketView);
					}
					if(!empty($responseArray->ticketCreate)){
						session()->put('ticketCreate' , $responseArray->ticketCreate);
					}
					if(!empty($responseArray->ticketEdit)){
						session()->put('ticketEdit' , $responseArray->ticketEdit);
					}
					if(!empty($responseArray->ticketDelete)){
						session()->put('ticketDelete' , $responseArray->ticketDelete);
					}

					if(!empty($responseArray->serviceView)){
						session()->put('serviceView' , $responseArray->serviceView);
					}
					if(!empty($responseArray->serviceCreate)){
						session()->put('serviceCreate' , $responseArray->serviceCreate);
					}
					if(!empty($responseArray->serviceEdit)){
						session()->put('serviceEdit' , $responseArray->serviceEdit);
					}
					if(!empty($responseArray->serviceDelete)){
						session()->put('serviceDelete' , $responseArray->serviceDelete);
					}

					$_SESSION['userId'] = $responseArray->userId;
					$_SESSION['userType'] = $responseArray->userType;
					$_SESSION['userName'] = $responseArray->userName;
					$_SESSION['email'] = $responseArray->email;

					if(!empty($responseArray->eventView)){
						$_SESSION['eventView'] = $responseArray->eventView;
					}
					if(!empty($responseArray->eventCreate)){
						$_SESSION['eventCreate'] = $responseArray->eventCreate;
					}
					if(!empty($responseArray->eventEdit)){
						$_SESSION['eventEdit'] = $responseArray->eventEdit;
					}
					if(!empty($responseArray->eventDelete)){
						$_SESSION['eventDelete'] = $responseArray->eventDelete;
					}

					if(!empty($responseArray->appView)){
						$_SESSION['appView'] = $responseArray->appView;
					}
					if(!empty($responseArray->appCreate)){
						$_SESSION['appCreate'] = $responseArray->appCreate;
					}
					if(!empty($responseArray->appEdit)){
						$_SESSION['appEdit'] = $responseArray->appEdit;
					}
					if(!empty($responseArray->appDelete)){
						$_SESSION['appDelete'] = $responseArray->appDelete;
					}

					if(!empty($responseArray->userView)){
						$_SESSION['userView'] = $responseArray->userView;
					}
					if(!empty($responseArray->userCreate)){
						$_SESSION['userCreate'] = $responseArray->userCreate;
					}
					if(!empty($responseArray->userEdit)){
						$_SESSION['userEdit'] = $responseArray->userEdit;
					}
					if(!empty($responseArray->userDelete)){
						$_SESSION['userDelete'] = $responseArray->userDelete;
					}

					if(!empty($responseArray->ticketView)){
						$_SESSION['ticketView'] = $responseArray->ticketView;
					}
					if(!empty($responseArray->ticketCreate)){
						$_SESSION['ticketCreate'] = $responseArray->ticketCreate;
					}
					if(!empty($responseArray->ticketEdit)){
						$_SESSION['ticketEdit'] = $responseArray->ticketEdit;
					}
					if(!empty($responseArray->ticketDelete)){
						$_SESSION['ticketDelete'] = $responseArray->ticketDelete;
					}

					if(!empty($responseArray->serviceView)){
						$_SESSION['serviceView'] = $responseArray->serviceView;
					}
					if(!empty($responseArray->serviceCreate)){
						$_SESSION['serviceCreate'] = $responseArray->serviceCreate;
					}
					if(!empty($responseArray->serviceEdit)){
						$_SESSION['serviceEdit'] = $responseArray->serviceEdit;
					}
					if(!empty($responseArray->serviceDelete)){
						$_SESSION['serviceDelete'] = $responseArray->serviceDelete;
					}

					/*
					print"<pre>";
					print_r($responseArray);
					print"<hr>";
					print_r(Session::all());
					//print"<hr>";
					//print_r($_SESSION);
					exit;
					*/

					//print"<pre>";
					//print_r(Session::all());
					//exit;

					if(!empty($userType)){
						if($userType==1){
							return redirect('admin/dashboard');
						}
						elseif($userType==2){
							return redirect('emp-dashboard');
						}
						elseif($userType==3){
							return redirect('emp-dashboard');
						}
					}

					//return view('admin.users.add_user')->with('message', json_decode($responseArray, true));
				}
			}
			elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
				session()->put('loginError','User Does not Exist');
				return view('auth.login');
			}
		}
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

	public function LoginPost($url,$params){

		$json_string = '';

		$fields = array(
		   "email" => $params['email'],
		   "password" => $params['password']
		);

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

	 public function LogoutPost($url,$params){

		$json_string = '';

		$fields = array(
		   "userId" => $params
		);

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

	public function logout(){

		$userId = session()->get('userId');

		if(!empty($userId)){
			$results = SELF::LogoutPost("http://106.51.0.187:8090/cgwfollowon/crmlogout",$userId);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			Session::flush();
			return redirect('admin/login_user');
		}
	}

    /**
     * Show a user edit page
     *
     * @param $id
     *
     * @return \Illuminate\View\View
    */
    public function edit($id){
    	$user  = User::findOrFail($id);
        $roles = Role::lists('title', 'id');
	    return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update our user information
     *
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */

	public function update(Request $request, $id){
		return redirect()->route('users.index')->withMessage(trans('quickadmin::admin.users-controller-successfully_updated'));
	}

    /**
     * Destroy specific user
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        User::destroy($id);

        return redirect()->route('users.index')->withMessage(trans('quickadmin::admin.users-controller-successfully_deleted'));
    }
}