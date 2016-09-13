<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller{

	public function index(){
		if(!empty(session()->get('userId'))){
			header('Location:admin/dashboard');
			exit;
		}
		else{
			return view('auth.login');
		}
	}

	public function store(Request $request){

		$inputArray = array();

		$inputArray = $request->all();

		if((!empty($inputArray['email'])) && (!empty($inputArray['password']))){
			$results = SELF::LoginPost("http://192.168.1.15:8080/cgwfollowon/crmlogin",$inputArray);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if((!empty($responseArray->userName)) && (!empty($responseArray->userId)) && (!empty($responseArray->email))){
				session()->put('userId', $responseArray->userId);
				session()->put('userName', $responseArray->userName);
				session()->put('email', $responseArray->email);

				//print"<pre>";
				//print_r(session()->get('email'));
				//exit;

				header('Location:admin/dashboard');
				exit;
			}
		}

		return view('auth.login');
    }

    public function LoginPost($url,$params){

		$json_string = '';

		$fields = array(
		   "email" => $params['email'],
		   "password" => $params['password']
		);

		$json_string = json_encode($fields);

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
		//Session::forget('userId');
		//Session::forget('userName');
		//Session::forget('email');

		//echo session()->get('userId');
		//echo session()->get('userName');
		//echo session()->get('email');

		Session::flush();

		echo session()->get('userId');
		echo session()->get('userName');
		echo session()->get('email');

		echo "here";
		exit;

		header('Location:login_user');
		exit;
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