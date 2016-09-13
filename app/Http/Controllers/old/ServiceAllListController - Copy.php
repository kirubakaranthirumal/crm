<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ServiceAllListController extends Controller
{    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(){

		Session::forget('DeleteServiceSuccess');
    	Session::forget('DeleteServiceError');

        $userId = session()->get('userId');

	    $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

        if(!empty($cinputArray)){
		 	 $results = SELF::ListServicePost("http://106.51.0.187:8090/cgwfollowon/servicelist",$cinputArray);
		}

        $responseArray = array();

        $serviceListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		if(!empty($responseArray->list)){
        	foreach($responseArray->list as $responseVal){
				$serviceListArray[] = $responseVal;
			}
		}
       /*  print"<pre>";
		print_r($serviceListArray);
		exit; */ 

		if(!empty($userId)){
            return view('admin.service.service_all_list', ['servicelist' => $serviceListArray]);
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
            $cinputArray['appId'] = $id;
        }

		if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

		if(!empty($cinputArray)){
		 	$delete = SELF::DeleteAppList("http://106.51.0.187:8090/cgwfollowon/deleteapplication",$cinputArray);
		 	$results = SELF::ListAppPost("http://106.51.0.187:8090/cgwfollowon/listapp",$cinputArray);
		}

        $responseArray = $delResponseArray = array();

        if(!empty($delete)){
            $delResponseArray = json_decode($delete);
        }
			//print"<pre>";
			//print_r($delResponseArray);
			//exit;
		 $appListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		if(!empty($responseArray->AppDetails)){
        	foreach($responseArray->AppDetails as $responseVal){
				$appListArray[] = $responseVal;
			}
		}

		if((!empty($delResponseArray->status)) && ($delResponseArray->status == "200")){
            if(!empty($delResponseArray->msg)){
                Session::forget('DeleteAppError');
                session()->put('DeleteAppSuccess','User has been deleted successfully');
                if(!empty($userId)){
                	return view('admin.app.app_list',['appdata' => $appListArray]);
                }
            }
			else{
				return redirect('admin/login_user');
			}
		}

	}

	public function DeleteAppList($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
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


    public function ListServicePost($url,$params){

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
