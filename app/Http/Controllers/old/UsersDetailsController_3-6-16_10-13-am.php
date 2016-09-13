<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersDetailsController extends Controller
{

	public function index(){

		$leads = '{"error":false,"member":[{"id":"1","firstName":"first","lastName":"last","phoneNumber":"0987654321","email":"email@yahoo.com","owner":{"id":"10","firstName":"first","lastName":"last"}}]}';

		$inputArray = $cinputArray = array();

		//$input = $request->all();
		//$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['userId'] = $id;
		}

		if(!empty($cinputArray)){
			$results = SELF::EditUserDetailsPost("http://106.51.0.187:8090/cgwfollowon/findcrmuser",$cinputArray);
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
			//return view('admin.users.user_details');
			return view('admin.users.add_user')->with('leads', json_decode($leads, true));
		}
		else{
			return redirect('admin/login_user');
		}
	}

     public function show($id){

     	$leads = '{"error":false,"member":[{"id":"1","firstName":"first","lastName":"last","phoneNumber":"0987654321","email":"email@yahoo.com","owner":{"id":"10","firstName":"first","lastName":"last"}}]}';

		$inputArray = $cinputArray = array();

     	//$input = $request->all();
		//$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['userId'] = $id;
		}

		//{"msg":"success","lastName":"radhan@gmail.com","gender":1,"groupId":1,"userId":21,"createdOn":"2016-05-17","firstName":"jeeva","createBy":0,"modifiedOn":"2016-05-17","modifiedBy":0,"userType":1,"email":"radhan@gmail.com","status":"200"}

		if(!empty($cinputArray)){
			$results = SELF::EditUserDetailsPost("http://106.51.0.187:8090/cgwfollowon/findcrmuser",$cinputArray);
		}

		$userdata = $results;
		//echo $results;

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print"<pre>";
		//print_r($responseArray);
		//exit;

		$userId = session()->get('userId');

		if(!empty($userId)){
			//return view('admin.users.user_details');
			return view('admin.users.user_details')->with('userdata', json_decode($userdata, true));
		}
		else{
			return redirect('admin/login_user');
		}
    }

    public function EditUserDetailsPost($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['userId'])){
			$fields['userId'] = $params['userId'];
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