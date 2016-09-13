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

	public function show($id){

		Session::forget('DeleteEventSuccess');

		 $userId = session()->get('userId');

        $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['appId'] = $id;
        }

		if(!empty($cinputArray)){
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

		//if($eventListArray
                if(!empty($userId)){
                	return view('admin.event.event_list', ['appid' => $id,'appdata' => $eventListArray]);
                }
			else{
				return redirect('admin/login_user');
			}
		}

	public function load_event(Request $request){

		$inputArray = $cinputArray = array();

		$inputArray = $request->all();

		if(!empty($inputArray['appId'])){
			$cinputArray['appId'] = $inputArray['appId'];
		}

		$app_results="";
		if(!empty($cinputArray)){
			$app_results = SELF::ListEventPost("http://106.51.0.187:8090/cgwfollowon/listappevent",$cinputArray);
		}

		$appResponseArray = $appListArray = array();


		if(!empty($app_results)){
			$appResponseArray = json_decode($app_results);
		}

		if(!empty($appResponseArray->AppDetails)){
			foreach($appResponseArray->AppDetails as $responseVal){
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
