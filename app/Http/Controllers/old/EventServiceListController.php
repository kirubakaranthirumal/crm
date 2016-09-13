<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EventServiceListController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

	public function show($id){
		
		Session::forget('DeleteEventSuccess');
		Session::forget('DeleteEventSuccess');
		 $userId = session()->get('userId');

        $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['eventId'] = $id;
        }

		if(!empty($cinputArray)){
		 	$results = SELF::ListEventPost("http://192.168.1.202:8085/demo/takeservices",$cinputArray);
		}

        $responseArray = array();
		$serviceListArray = array();
		
        $userListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }
		
		if(!empty($responseArray->serviceIds)){
        	foreach($responseArray->serviceIds as $responseVal){
				$serviceListArray[] = $responseVal;
			}
		}	
		
		if(!empty($serviceListArray)){
			foreach($serviceListArray as $serviceListVal){
				$serviceIdArray[] = $serviceListVal;
			}
		}
		
		$cinputArray1 = array();
		if(!empty($serviceIdArray)){
			foreach($serviceIdArray as $serviceId){				
				$cinputArray1['serviceId'] = $serviceId->serviceId;
				$serviceresults = SELF::ListServicePost("http://192.168.1.202:8085/demo/viewservice",$cinputArray1);
				
				if(!empty($serviceresults)){
					$responseArray2 = json_decode($serviceresults);	
				}				
				$checkedservicelist[] = $responseArray2;					
			}
		}	
	/* 	print"<pre>";
		print_r($checkedservicelist);
		exit; */
		if(!empty($userId)){
			return view('admin.service.service_list', ['eventid' => $id,'servicedata' => $checkedservicelist]);
		}
		else{
			return redirect('admin/login_user');
		} 
	}

	public function load_event(Request $request){

		$inputArray = $cinputArray = array();

		$inputArray = $request->all();

		if(!empty($inputArray['eventId'])){
			$cinputArray['eventId'] = $inputArray['eventId'];
		}

		$app_results="";
		if(!empty($cinputArray)){
			$app_results = SELF::ListEventPost("http://106.51.0.187:8090/cgwfollowon/takeservices",$cinputArray);
		}

		$appResponseArray = $appListArray = array();


		if(!empty($app_results)){
			$appResponseArray = json_decode($app_results);
		}

		if(!empty($appResponseArray->list)){
			foreach($appResponseArray->list as $responseVal){
				$appListArray[] = $responseVal;
			}
		}

		//print"<pre>";
		//print_r($appResponseArray);
		//exit;

		if(!empty($inputArray['groupId'])){
			$results = SELF::loadEmpByGroupId("http://106.51.0.187:8090/cgwfollowon/findcrmgroupusers",$inputArray);
		}

		$responseArray = $groupUserListArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print"<pre>";
		//print_r($responseArray);
		//exit;

		$groupUserListArray = array();
		if(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseVal){
				$groupUserListArray[] = $responseVal;
			}
		}

		//print"<pre>";
		//print_r($groupUserListArray);
		//exit;

		$userId = session()->get('userId');

		return view('admin.ticket_form.select_event_by_app', ['eventdata' => $appListArray]);
	}

    public function ListEventPost($url,$params){

        $json_string = '';

        if(!empty($params['eventId'])){
            $fields['eventId'] = $params['eventId'];
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
    public function ListServicePost($url,$params){

        $json_string = '';

        if(!empty($params['serviceId'])){
            $fields['serviceId'] = $params['serviceId'];
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
