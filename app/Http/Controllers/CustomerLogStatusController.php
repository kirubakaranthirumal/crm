<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerLogStatusController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(){

		/*
		Session::forget('DeleteUserSuccess');
    	Session::forget('DeleteUserError');
    	*/

        $userId = session()->get('userId');

	    $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

        if(!empty($cinputArray)){
		 	$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/onlineusers",$cinputArray);
		}

        $responseArray = array();

        $activeuserListArray = array();
		$inactiveuserListArray = array();

        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		if(!empty($responseArray->onlineUsers)){
        	foreach($responseArray->onlineUsers as $responseVal){
				$activeuserListArray[] = $responseVal;
			}
		}

		if(!empty($responseArray->inActiveUsers)){
        	foreach($responseArray->inActiveUsers as $responseVal){
				$inactiveuserListArray[] = $responseVal;
			}
		}
		/* 	print"<pre>";
		print_r($activeuserListArray);
		print_r($inactiveuserListArray);
		exit; */
		//$activeuserListArray = array();
		$inactiveuserListArray = array();
		

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
            if(!empty($responseArray->msg)){
                //Session::forget('userListError');
                //session()->put('userSuccess','User has been created successfully');
                if(!empty($userId)){
                	return view('admin.users.customer_log_status', ['activeuser' => $activeuserListArray,'inactiveuser' => $inactiveuserListArray]);
                }
            }
        }
        elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
            //Session::forget('userSuccess');
            //session()->put('userListError','Email address already exist');
        }

		if(!empty($userId)){
            return view('admin.users.customer_log_status', ['activeuser' => $activeuserListArray,'inactiveuser' => $inactiveuserListArray]);
		}
		else{
			return redirect('admin/login_user');
		}
    }

	public function show($id){

		Session::forget('DeleteUserSuccess');
    	Session::forget('DeleteUserError');
		 $userId = session()->get('userId');

        $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['userId'] = $id;
        }
		if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

		if(!empty($cinputArray)){
		 	$delete = SELF::DeleteUserList("http://106.51.0.187:8090/cgwfollowon/deletecrmuser",$cinputArray);
		 	$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listcrmusers",$cinputArray);
		}

        $responseArray = $delResponseArray = array();

        if(!empty($delete)){
            $delResponseArray = json_decode($delete);
        }

        //print"<pre>";
        //print_r($delResponseArray);
        //exit;

        $userListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		if(!empty($responseArray->Crmuserlist)){
        	foreach($responseArray->Crmuserlist as $responseVal){
				$userListArray[] = $responseVal;
			}
		}

		if((!empty($delResponseArray->status)) && ($delResponseArray->status == "200")){
            if(!empty($delResponseArray->msg)){
                Session::forget('DeleteUserError');
                session()->put('DeleteUserSuccess','User has been deleted successfully');
                if(!empty($userId)){
                	return view('admin.users.users_list',['userdata' => $userListArray]);
                }
            }
			if(!empty($userId)){
				return view('admin.users.users_list', ['userdata' => $userListArray]);
			}
			else{
				return redirect('admin/login_user');
			}
		}

	}

	public function DeleteUserList($url,$params){

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
