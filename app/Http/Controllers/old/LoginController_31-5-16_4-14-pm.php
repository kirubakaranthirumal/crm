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
    	return view('auth.login');
	}

	public function store(Request $request){

		$inputArray = array();

		$inputArray = $request->all();

		if((!empty($inputArray['email'])) && (!empty($inputArray['password']))){
			$results = SELF::LoginPost("http://106.51.0.187:8090/cgwfollowon/crmlogin",$inputArray);
		}

		//return view('admin.users.add_user')->with('message', json_decode($message, true));

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		/*
		print"<pre>";
		print_r($responseArray);
		exit;
		*/

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if((!empty($responseArray->userName)) && (!empty($responseArray->userId)) && (!empty($responseArray->email))){
				session()->put('userId', $responseArray->userId);
				session()->put('userType', $responseArray->userType);
				session()->put('userName', $responseArray->userName);
				session()->put('email', $responseArray->email);

				$userType="";
				$userType = session()->get('userType');

				if(!empty($userType)){
					if($userType==1){
						return redirect('admin/dashboard');
					}
					elseif($userType==2){
						return redirect('emp-dashboard');
					}
				}

				//return view('admin.users.add_user')->with('message', json_decode($responseArray, true));
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){

			session()->put('loginError','User Does not Exist');
			return view('auth.login');

		    //return redirect()->back()->with($results);
		    //return redirect()->back()->with('msg',[$responseArray->msg]);

			//if(!empty($responseArray->msg)){
			//	return redirect()->back()->with('msg',[$responseArray->msg]);
			//}
		}
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