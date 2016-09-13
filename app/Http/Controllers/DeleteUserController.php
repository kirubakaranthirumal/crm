<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeleteUserController extends Controller
{
     public function show($id){

			Session::forget('DeleteUserSuccess');
    	Session::forget('DeleteUserError');
		 $userId = session()->get('userId');

        $cinputArray = array();

        if(!empty($id)){
            $cinputArray['userId'] = $id;
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
		

		//print"<pre>";
		//print_r($userListArray);
		//exit;
        if((!empty($responseArray->status)) && ($responseArray->status == "200")){
            if(!empty($responseArray->msg)){
                Session::forget('DeleteUserError');
                session()->put('DeleteUserSuccess','User has been deleted successfully');
                //if(!empty($userId)){
                //	return view('admin.users.users_list');
                //}
            }
	/		if(!empty($userId)){
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

	public function ListUserPost($url,$params){

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
}