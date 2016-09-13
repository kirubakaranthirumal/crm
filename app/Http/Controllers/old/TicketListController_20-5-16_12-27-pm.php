<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TicketListController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(Request $request){

		$inputArray = $request->all();

		$userId = session()->get('userId');

      	//print"<pre>";
        //print_r($inputArray);
        //exit;

		$tabId="";
        if(!empty($inputArray['tab_id'])){
        	$tabId = $inputArray['tab_id'];
        }

		if(!empty($tabId)){
			if($tabId=="1"){
				$cinputArray['Id'] = "1";
           		$results = SELF::ListUserPost("http://192.168.1.15:8080/cgwfollowon/listalltickets",$cinputArray);
			}
			else{
				if($tabId=="2"){
					$cinputArray['status'] = "1";
				}
				elseif($tabId=="3"){
					$cinputArray['status'] = "2";
				}
				elseif($tabId=="4"){
					$cinputArray['status'] = "3";
				}
				elseif($tabId=="5"){
					$cinputArray['status'] = "4";
				}
				elseif($tabId=="6"){
					$cinputArray['status'] = "5";
				}
				elseif($tabId=="7"){
					$cinputArray['status'] = "6";
				}
				$results = SELF::ListUserPost("http://192.168.1.15:8080/cgwfollowon/searcspecifichticketlist",$cinputArray);
			}
        }
        else{
           	$cinputArray['Id'] = "1";
           	$results = SELF::ListUserPost("http://192.168.1.15:8080/cgwfollowon/listalltickets",$cinputArray);
        }

        $responseArray = array();

        $ticketListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		if(!empty($responseArray->Crmticketlist)){
        	foreach($responseArray->Crmticketlist as $responseVal){
				$ticketListArray[] = $responseVal;
			}
		}
		elseif(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseVal){
				$ticketListArray[] = $responseVal;
			}
		}

		$countinputArray = array();
		$countinputArray['userId'] = $userId;
		$statusResultCount = SELF::TicketCount("http://192.168.1.15:8080/cgwfollowon/dashboardcount",$countinputArray);

		$ticketCountArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		if(!empty($countResponseArray->ticketStatusCounts)){
			foreach($countResponseArray->ticketStatusCounts as $countResponseVal){
				$ticketCountArray[] = $countResponseVal;
			}
		}

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
            if(!empty($responseArray->msg)){
                //Session::forget('userListError');
                //session()->put('userSuccess','User has been created successfully');
                if(!empty($userId)){
                	return view('admin.ticket_form.tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId]);
                }
            }
        }
        elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
            //Session::forget('userSuccess');
            //session()->put('userListError','Email address already exist');
        }

        if(!empty($userId)){
            return view('admin.ticket_form.tickets_list',['ticketdata' => $ticketListArray]);
		}
		else{
			return redirect('admin/login_user');
		}
    }

     public function store(Request $request){

     	$inputArray = $request->all();

		$userId = session()->get('userId');

		print"<pre>";
		print_r($inputArray);
		exit;

		$tabId="";
		if(!empty($inputArray['tab_id'])){
			$tabId = $inputArray['tab_id'];
		}

		if(!empty($tabId)){
			if($tabId=="1"){
				$cinputArray['Id'] = "1";
				$results = SELF::ListUserPost("http://192.168.1.15:8080/cgwfollowon/listalltickets",$cinputArray);
			}
			else{
				if($tabId=="2"){
					$cinputArray['status'] = "1";
				}
				elseif($tabId=="3"){
					$cinputArray['status'] = "2";
				}
				elseif($tabId=="4"){
					$cinputArray['status'] = "3";
				}
				elseif($tabId=="5"){
					$cinputArray['status'] = "4";
				}
				elseif($tabId=="6"){
					$cinputArray['status'] = "5";
				}
				elseif($tabId=="7"){
					$cinputArray['status'] = "6";
				}
				$results = SELF::ListUserPost("http://192.168.1.15:8080/cgwfollowon/searcspecifichticketlist",$cinputArray);
			}
		}
		else{
			$cinputArray['Id'] = "1";
			$results = SELF::ListUserPost("http://192.168.1.15:8080/cgwfollowon/listalltickets",$cinputArray);
		}

		$responseArray = array();

		$ticketListArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		if(!empty($responseArray->Crmticketlist)){
			foreach($responseArray->Crmticketlist as $responseVal){
				$ticketListArray[] = $responseVal;
			}
		}
		elseif(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseVal){
				$ticketListArray[] = $responseVal;
			}
		}

		$countinputArray = array();
		$countinputArray['userId'] = $userId;
		$statusResultCount = SELF::TicketCount("http://192.168.1.15:8080/cgwfollowon/dashboardcount",$countinputArray);

		$ticketCountArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		if(!empty($countResponseArray->ticketStatusCounts)){
			foreach($countResponseArray->ticketStatusCounts as $countResponseVal){
				$ticketCountArray[] = $countResponseVal;
			}
		}

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				//Session::forget('userListError');
				//session()->put('userSuccess','User has been created successfully');
				if(!empty($userId)){
					return view('admin.ticket_form.tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId]);
				}
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
			//Session::forget('userSuccess');
			//session()->put('userListError','Email address already exist');
		}

		if(!empty($userId)){
			return view('admin.ticket_form.tickets_list',['ticketdata' => $ticketListArray]);
		}
		else{
			return redirect('admin/login_user');
		}
    }

    public function ListUserPost($url,$params){

		$json_string = '';
		$fields = array();
		if(!empty($params['Id'])){
			$fields['Id'] = $params['Id'];
		}
		elseif(!empty($params['status'])){
			$fields['status'] = $params['status'];
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

    public function TicketCount($url,$params){

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
}
