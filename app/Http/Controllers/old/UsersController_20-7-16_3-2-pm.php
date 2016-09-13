<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(){

    	Session::forget('userSuccess');
    	Session::forget('userError');

    	Session::forget('userDelSuccess');
    	Session::forget('userDelError');

		$userId = session()->get('userId');

		$params = array();

		$departmentArray = $this->retrieveAllActiveDepartmentInfo($params);

		//print"<pre>";
		//print_r($departmentArray);
		//exit;

		if(!empty($userId)){
			return view('admin.users.add_user',['department'=>$departmentArray]);
		}
		else{
			return redirect('admin/login_user');
		}
    }

    public function store(Request $request){

    	$message = '';
    	$input = $request->all();

		$inputArray = $cinputArray = array();

		$inputArray = $request->all();

		if(
			(!empty($inputArray['firstname']))
			&&
			(!empty($inputArray['email']))
			&&
			(!empty($inputArray['password']))
			&&
			(!empty($inputArray['type']))
			&&
			(!empty($inputArray['status']))
			&&
			(!empty($inputArray['gender']))
			&&
			(!empty($inputArray['group']))
		){

			if(!empty($inputArray['firstname'])){
				$cinputArray['firstName'] = $inputArray['firstname'];
			}

			if(!empty($inputArray['lastname'])){
				$cinputArray['lastName'] = $inputArray['lastname'];
			}

			if(!empty($inputArray['email'])){
				$cinputArray['email'] = $inputArray['email'];
			}

			if(!empty($inputArray['password'])){
				$cinputArray['password'] = $inputArray['password'];
			}

			if(!empty($inputArray['type'])){
				$cinputArray['userType'] = $inputArray['type'];
			}

			if(!empty($inputArray['status'])){
				$cinputArray['status'] = $inputArray['status'];
			}

			if(!empty($inputArray['gender'])){
				$cinputArray['gender'] = $inputArray['gender'];
			}

			if(!empty($inputArray['group'])){
				$cinputArray['groupId'] = $inputArray['group'];
			}

			if(!empty(session()->get('userId'))){
				$cinputArray['createdBy'] = session()->get('userId');
			}

			$results = SELF::AddUserPost("http://106.51.0.187:8090/cgwfollowon/addcrmuser",$cinputArray);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print"<pre>";
		//print_r($results);
		//exit;

		$departmentArray = $this->retrieveAllActiveDepartmentInfo();

		//return view('admin.users.add_user')->with('message', json_decode($message, true));

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				//Session::flash('success', 'User successfully created.');
				Session::forget('userError');
				session()->put('userSuccess','User has been created successfully');
				//$message = '{"success":true,"msg":[{"sucMsg":"User has been added"}}]}';
				//return view('admin.users.add_user')->with('leads', json_decode($leads, true));
				//return redirect()->back()->with('message',$responseArray);

				/*
				print"<pre>";
				print_r(session()->all());
				exit;
				*/

				return view('admin.users.add_user');
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
			/*
			print"<pre>";
			print_r(session()->all());
			exit;
			*/

			Session::forget('userSuccess');
			session()->put('userError','Email address already exist');
		}

		$userId = session()->get('userId');
		if(!empty($userId)){
			return view('admin.users.add_user',['department'=>$departmentArray]);
		}
		else{
			return redirect('admin/login_user');
		}
    }

    public function AddUserPost($url,$params){

    	$json_string = '';

		if(!empty($params['firstName'])){
			$fields['firstName'] = $params['firstName'];
		}

		if(!empty($params['lastName'])){
			$fields['lastName'] = $params['lastName'];
		}

		if(!empty($params['email'])){
			$fields['email'] = $params['email'];
		}

		if(!empty($params['password'])){
			$fields['password'] = $params['password'];
		}

		if(!empty($params['cpassword'])){
			$fields['cpassword'] = $params['cpassword'];
		}

		if(!empty($params['userType'])){
			$fields['userType'] = $params['userType'];
		}

		if(!empty($params['status'])){
			$fields['status'] = $params['status'];
		}

		if(!empty($params['gender'])){
			$fields['gender'] = $params['gender'];
		}

		if(!empty($params['groupId'])){
			$fields['groupId'] = $params['groupId'];
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

    public function viewuser(){

    	$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.users.view_user');
		}
		else{
			return redirect('admin/login_user');
			//header('Location:login_user');
			//exit;
		}
	}

	public function userdetails($id){

		$inputArray = $cinputArray = array();

		//$input = $request->all();
		//$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['userId'] = $id;
		}

		if(!empty($cinputArray)){
			$results = SELF::EditUserPost("http://106.51.0.187:8090/cgwfollowon/findcrmuser",$cinputArray);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.users.user_details');
		}
		else{
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

       $userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.users.user_details');
		}
		else{
			return redirect('admin/login_user');
		}
    }

     public function show($id){

     	$inputArray = $cinputArray = array();

     	if(!empty($id)){
			$cinputArray['userId'] = $id;
		}

		if(!empty($cinputArray)){
			$results = SELF::EditUserPost("http://106.51.0.187:8090/cgwfollowon/findcrmuser",$cinputArray);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.users.user_details');
		}
		else{
			return redirect('admin/login_user');
		}
    }

    public function EditUserPost($url,$params){

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

	public function retrieveAllDepartmentInfo($params){
		$departmentObj = new Department();
		$resultArray = $departmentObj->retrieveAll($params);
		return $resultArray;
	}

	public function retrieveAllActiveDepartmentInfo(){
		$departmentObj = new Department();
		$resultArray = $departmentObj->retrieveAllActive();
		return $resultArray;
	}
}