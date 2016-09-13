<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AppEventDeleteController extends Controller
{    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

	public function show($id,Request $request){

		$inputArray = $request->all();

		//Session::forget('DeleteEventSuccess');

		//print"<pre>";
		//print_r($inputArray);
		//exit;

		$appId="";
		if(!empty($inputArray['app_id'])){
			$appId = $inputArray['app_id'];
		}

		//echo $appId;

		Session::forget('DeleteEventSuccess');
		Session::forget('DeleteEventError');
		$userId = session()->get('userId');

        $cinputArray = array();

        if(!empty($appId)){
            $cinputArray['appId'] = $appId;
        }
      	if(!empty($id)){
			$cinputArray['eventId'] = $id;
        }

		if(!empty($cinputArray)){
		 	$delete = SELF::DeleteEventList("http://106.51.0.187:8090/cgwfollowon/deleteevent",$cinputArray);
		 	$results = SELF::ListEventPost("http://106.51.0.187:8090/cgwfollowon/listappevent",$cinputArray);
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

		//print"<pre>";
		//print_r($responseArray);
		//exit;

		if(!empty($responseArray->AppDetails)){
        	foreach($responseArray->AppDetails as $responseVal){
				$appListArray[] = $responseVal;
			}
		}

		//print"<pre>";
		//print_r($responseArray);
		//exit;

		if((!empty($delResponseArray->status)) && ($delResponseArray->status == "200")){
            if(!empty($delResponseArray->msg)){
                Session::forget('DeleteEventError');
                session()->put('DeleteEventSuccess','Event disabled successfully');
                if(!empty($userId)){
                	return view('admin.event.event_list',['app_id'=>$appId,'appdata' => $appListArray]);
                }
            }
			else{
				return redirect('admin/login_user');
			}
		}

	}

	public function DeleteEventList($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
		}

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


    public function ListEventPost($url,$params){

        $json_string = '';

        if(!empty($params['eventId'])){
            $fields['eventId'] = $params['eventId'];
        }

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
}
