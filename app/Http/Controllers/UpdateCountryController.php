<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class UpdateCountryController extends Controller{

	 public function show($id,Request $request){
		
		Session::forget('countryUpdateSuccess');
		Session::forget('countrySuccess');	
		 
		$inputArray = $cinputArray = array();

		$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['countryId'] = $id;
		}

		if(!empty($inputArray['submit'])){

			if(
				(!empty($inputArray['country_name']))
				&&
				(!empty($inputArray['country_short_name']))
				&&
				(!empty($inputArray['country_code']))
				&&
				(!empty($inputArray['country_flag']))
			){
				if(!empty($inputArray['country_name'])){
					$cinputArray['countryName'] = $inputArray['country_name'];
				}

				if(!empty($inputArray['country_short_name'])){
					$cinputArray['StortName'] = $inputArray['country_short_name'];
				}

				if(!empty($inputArray['country_flag'])){
					$cinputArray['countryFlags'] = $inputArray['country_flag'];
				}

				if(!empty($inputArray['country_code'])){
					$cinputArray['countryCode'] = $inputArray['country_code'];
				}

				$results = SELF::UpdateCountryPost("http://cgwrestapi-env.us-west-2.elasticbeanstalk.com/updatecountry",$cinputArray);
				
				$country_results="";
				if(!empty($cinputArray)){
					$country_results = SELF::EditCountryPost("http://cgwrestapi-env.us-west-2.elasticbeanstalk.com/findcountry",$cinputArray);
				}
				
				$responseArray = array();
				if(!empty($results)){
					$responseArray = json_decode($results);
				}

				if(!empty($responseArray)){
					$countryArray = $responseArray;
				}

				$userId = session()->get('userId');
				$usertype = session()->get('userType');

				if(!empty($userId)){
					session()->put('countryUpdateSuccess','Country has been updated successfully');
					return view('admin.country.edit_country', ['countrydata' => $countryArray, 'id' => $userId]);					
				}
				else{
					return redirect('admin/login_user');
				}
			}
		}
		else{

			Session::forget('countryUpdateSuccess');

			if(!empty($cinputArray)){
				$results = SELF::EditCountryPost("http://cgwrestapi-env.us-west-2.elasticbeanstalk.com/findcountry",$cinputArray);
			}

			$responseArray = array();

			$countryArray = array();
			if(!empty($results)){
				$responseArray = json_decode($results);
			}
			
			if(!empty($responseArray)){
				$countryArray = $responseArray;
			}

			//print"<pre>";
			//print_r($countryListArray);
			//exit;

			$userId = session()->get('userId');

			if(!empty($userId)){
				return view('admin.country.edit_country',['countrydata' => $countryArray,'id' => $userId]);
			}
			else{
				return redirect('admin/login_user');
			}
		}
    }

    public function UpdateCountryPost($url,$params){

		$json_string = '';

		if(!empty($params['countryId'])){
			$fields['countryId'] = $params['countryId'];
		}

		if(!empty($params['countryName'])){
			$fields['countryName'] = $params['countryName'];
		}

		if(!empty($params['StortName'])){
			$fields['StortName'] = $params['StortName'];
		}

		if(!empty($params['countryCode'])){
			$fields['countryCode'] = $params['countryCode'];
		}

		if(!empty($params['countryFlags'])){
			$fields['countryFlags'] = $params['countryFlags'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}

		//echo $json_string;
		//exit;

		$service_url = $url;

		/*
		print"<pre>";
		print_r($fields);
		exit;

		echo $service_url;
		exit;
		*/

		//echo $json_string;
		//exit;

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

		print"<pre>";
		print_r($responseArray);
		exit;

    	$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.users.add_user');
			//return view('admin.users.add_user')->with('leads', json_decode($leads, true));
		}
		else{
			return redirect('admin/login_user');
		}
    }

    public function store(Request $request){

    	echo "here3";
    	exit;

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
			return view('admin.users.add_user');
		}
		else{
			return redirect('admin/login_user');
		}
    }

    public function EditCountryPost($url,$params){

		$json_string = '';
		if(!empty($params['countryId'])){
			$fields['countryId'] = $params['countryId'];
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