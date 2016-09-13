<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AppEventListController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(){

		Session::forget('DeleteEventSuccess');
    	Session::forget('DeleteEventError');

        $userId = session()->get('userId');

	    $cinputArray = array();

       /* if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }
		     if(!empty($cinputArray)){
		 	$results = SELF::ListAppPost("http://106.51.0.187:8090/cgwfollowon/listapp",$cinputArray);
		}

        $responseArray = array();

        $appListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }
		//print"<pre>";
		//print_r($responseArray);
		//exit;
		if(!empty($responseArray->AppDetails)){
        	foreach($responseArray->AppDetails as $responseVal){
				$appListArray[] = $responseVal;
			}
		}
	*/
		//print "<pre>";
		//print_r('appdata' => $appListArray);
		//exit;

            $cinputArray['appId'] = 1;

        if(!empty($cinputArray)){
		 	$results = SELF::ListEventPost("http://106.51.0.187:8090/cgwfollowon/listappevent",$cinputArray);
		}

        $responseArray = array();

        $eventListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }
		print"<pre>";
		print_r($responseArray);
		exit;
		if(!empty($responseArray->AppDetails)){
        	foreach($responseArray->AppDetails as $responseVal){
				$eventListArray[] = $responseVal;
			}
		}

		if(!empty($userId)){
            return view('admin.event.event_list', ['eventdata' => $eventListArray]);
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
		 	//$delete = SELF::DeleteUserList("http://106.51.0.187:8090/cgwfollowon/deletecrmuser",$cinputArray);
		 	$results = SELF::ListEventPost("http://106.51.0.187:8090/cgwfollowon/listappevent",$cinputArray);
		}

        $responseArray = array();
		$eventListArray = array();
      /*   if(!empty($delete)){
            $delResponseArray = json_decode($delete);
        }
 */
        //print"<pre>";
        //print_r($delResponseArray);
        //exit;

        $userListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		if(!empty($responseArray->AppDetails)){
        	foreach($responseArray->AppDetails as $responseVal){
				$eventListArray[] = $responseVal;
			}
		}

		//print "<pre>";
		//print_r($eventListArray);
		//exit;
		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
            if(!empty($responseArray->msg)){
                //Session::forget('DeleteAppError');
                //session()->put('DeleteAppSuccess','User has been deleted successfully');
                if(!empty($userId)){
                	return view('admin.event.event_list', ['appdata' => $eventListArray]);
                }
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


    public function ListEventPost($url,$params){

        $json_string = '';

        if(!empty($params['appId'])){
            $fields['appId'] = $params['appId'];
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
	/* public function ListAppPost($url,$params){

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
 */
}
