<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller{

	public function index(){
		return view('auth.login');
	}

	public function store(Request $request){

		$inputArray = array();

		$inputArray = $request->all();

		//print"<pre>";
		//print_r($inputArray);

		if((!empty($inputArray['email'])) && (!empty($inputArray['password']))){

			/*
			$url="http://192.168.1.15:8080/cgwfollowon/crmlogin?email=".$inputArray['email']."&password=".$inputArray['password'];

			$ch = curl_init();	//Initialising cURL session

			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Accept-Language: en_US')
			);

			//Setting cURL options
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_URL, $url);
			$results = curl_exec($ch);	//Executing cURL session
			curl_close($ch);	//Closing cURL session

			//print"<pre>";
			//print_r($results);
			*/

			$results = LoginController::LoginPost("http://192.168.1.15:8080/cgwfollowon/crmlogin",$inputArray);

			print"<pre>";
			print_r($results);
		}

		return view('auth.login');
    }

    public function LoginPost($url,$params){

		$fields = array(
		   "email" => $params['email'],
		   "password" => $params['password']
		);

		//($fields)

		echo json_encode($fields);
		exit;

		$json_string = '{"email":"rameshkumar@gmail.com","password":"123456"}';

		$service_url = $url;
		$curl = curl_init($service_url);

		//$curl_post_data = array(
		//	"user_id" => 42,
		//	"emailaddress" => 'lorna@example.com',
		//);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Accept-Language: en_US')
		);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $j_string);
		$curl_response = curl_exec($curl);

		echo $curl_response;
		exit;

		print"<pre>";
		print_r($curl_response);
		exit;

		curl_close($curl);


		/*
		$post_field_string = http_build_query($fields,'','&');

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept-Language: en_US')
		);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);
		curl_setopt($ch, CURLOPT_POST, true);

		$response = curl_exec($ch);

		print"<pre>";
		print_r($response);
		exit;

		curl_close ($ch);

		return $response;
		*/

		/*
    	$postData = '';
		//create name value pairs seperated by &
		foreach($fields as $k => $v){
			$postData .= $k . '='.$v.'&';
		}

		$postData = rtrim($postData, '&');

		//print"<pre>";
		//print_r($postData);
		//exit;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept-Language: en_US')
		);

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, count($postData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

		$output=curl_exec($ch);

		print"<pre>";
		print_r($output);
		exit;

		curl_close($ch);
		*/

		return $output;
	}

    /**
     * Show a user edit page
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::lists('title', 'id');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update our user information
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user->update($input);

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