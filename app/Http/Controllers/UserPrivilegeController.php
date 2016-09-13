<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserPrivilegeController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(){

		
        $userId = session()->get('userId');
		
	    $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

        if(!empty($cinputArray)){
		 	$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/privilegeuserlist",$cinputArray);
		}

        $responseArray = array();

        $userListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		if(!empty($responseArray->userPrivilegelist)){
        	foreach($responseArray->userPrivilegelist as $responseVal){
				$userListArray[] = $responseVal;
			}
		}
			//print"<pre>";
			//print_r($userListArray);
			//exit;
        if((!empty($responseArray->status)) && ($responseArray->status == "200")){
            if(!empty($responseArray->msg)){
                //Session::forget('userListError');
                //session()->put('userSuccess','User has been created successfully');
                if(!empty($userId)){
                	return view('admin.privilege.user_privilege', ['userdata' => $userListArray]);
                }
            }
        }
        elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
            //Session::forget('userSuccess');
            //session()->put('userListError','Email address already exist');
        }
		
		if(!empty($userId)){
            return view('admin.users.users_list', ['userdata' => $userListArray]);
		}
		else{
			return redirect('admin/login_user');
		}
    }

    public function ListUserPost($url,$params){

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
}
