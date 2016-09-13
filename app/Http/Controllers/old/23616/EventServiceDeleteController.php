<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EventServiceDeleteController extends Controller
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
		if(!empty($inputArray['event_id'])){
			$eventId = $inputArray['event_id'];
		}

		//echo $appId;

		Session::forget('DeleteEventSuccess');
		Session::forget('DeleteEventError');
		$userId = session()->get('userId');

        $cinputArray = array();

        if(!empty($appId)){
            $cinputArray['eventId'] = $eventId;
        }
      	if(!empty($id)){
			$cinputArray['serviceId'] = $id;
        }

		if(!empty($cinputArray)){
		 	$delete = SELF::DeleteServiceList("http://192.168.1.202:8085/demo/deleteservice",$cinputArray);
		 	$results = SELF::ListServicePost("http://192.168.1.202:8085/demo/servicelistbyid",$cinputArray);
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
                	return view('admin.service.service_list',['app_id'=>$appId,'appdata' => $appListArray]);
                }
            }
			else{
				return redirect('admin/login_user');
			}
		}

	}

	public function DeleteServiceList($url,$params){

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


    public function ListServicePost($url,$params){

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
