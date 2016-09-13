<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserTicketListController extends Controller
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
				//$cinputArray['Id'] = "1";
				$cinputArray['loginuserType'] = "1";
           		$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listalltickets",$cinputArray);
			}
			else{
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

				if(!empty($userId)){
					$cinputArray['ticketAssignedUser'] = $userId;
        		}

				//print"<pre>";
        		//print_r(Session::all());

        		$user_type = "";

        		//echo session()->get('userType');
        		if(!empty(session()->get('userType'))){
        			$user_type = session()->get('userType');
        		}

        		//echo $user_type;
        		//exit;

        		if(!empty(session()->get('userType'))){
					$cinputArray['loginuserType'] = $user_type;
        		}

				//print"<pre>";
				//print_r($cinputArray);
				//exit;

				if(!empty($cinputArray)){
					$results = SELF::ListUserPostFilterUser("http://106.51.0.187:8090/cgwfollowon/searcspecifichticketlist",$cinputArray);
				}

				//print"<pre>";
				//print_r($results);
				//exit;
			}
        }
        else{
           	$cinputArray['Id'] = "1";
           	$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listalltickets",$cinputArray);
        }

        $responseArray = array();

        $ticketListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		//print"<pre>";
		//print_r($responseArray);
		//exit;

		if(!empty($responseArray->Crmticketlist)){
        	foreach($responseArray->Crmticketlist as $responseVal){
				$ticketListArray[] = $responseVal;
			}
		}
		elseif(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseDataVal){
				$ticketListDataArray[] = $responseDataVal;
			}
		}

		if(!empty($ticketListDataArray)){
			foreach($ticketListDataArray as $responseVal){
				$ticketListArray[] = $responseVal;
				//$ticketListArray['agingHours'][] = strtotime($responseVal->createdOn);
			}
		}

		//print"<pre>";
		//print_r($ticketListArray);
		//exit;

		$countinputArray = array();
		$countinputArray['ticketAssignedUser'] = $userId;
		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/crmuserdashboardcount",$countinputArray);

		$ticketCountArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		if(!empty($countResponseArray)){
			//foreach($countResponseArray->ticketStatusCounts as $countResponseVal){
				$ticketCountArray[] = $countResponseArray;
			//}
		}

		//print"<pre>";
		//print_r($ticketCountArray);
		//exit;

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
            if(!empty($responseArray->msg)){
                //Session::forget('userListError');
                //session()->put('userSuccess','User has been created successfully');
                if(!empty($userId)){
                	return view('admin.ticket_form.user_tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId]);
                }
            }
        }
        elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
            //Session::forget('userSuccess');
            //session()->put('userListError','Email address already exist');
        }

        if(!empty($userId)){
            return view('admin.ticket_form.user_tickets_list',['ticketdata' => $ticketListArray]);
		}
		else{
			return redirect('admin/login_user');
		}
    }


     public function searchTicketWithStatus($ipArray,$tId){

     	$filtercinputArray = array();

     	$res = "";
     	if((!empty($tId)) && ($tId != "1")){
			if($tId=="2"){
				$filtercinputArray['status'] = "1";
			}
			elseif($tId=="3"){
				$filtercinputArray['status'] = "2";
			}
			elseif($tId=="4"){
				$filtercinputArray['status'] = "3";
			}
			elseif($tId=="5"){
				$filtercinputArray['status'] = "4";
			}
			elseif($tId=="6"){
				$filtercinputArray['status'] = "5";
			}
			elseif($tId=="7"){
				$filtercinputArray['status'] = "6";
			}

			//if(!empty($ipArray['submit'])){

				if(!empty($ipArray['priority'])){
					$filtercinputArray['priority'] = $ipArray['priority'];
				}

				if(!empty($ipArray['source'])){
					$filtercinputArray['ticketSource'] = $ipArray['source'];
				}

				if(!empty($ipArray['created_on'])){
					$filtercinputArray['createdOn'] = $ipArray['created_on'];
				}
			//}

			//print"<pre>";
			//print_r($filtercinputArray);
			//exit;
		}
		else{

			//print"<pre>";
			//print_r($ipArray);
			//exit;

			//if(!empty($ipArray['submit'])){

				if(!empty($ipArray['priority'])){
					$filtercinputArray['priority'] = $ipArray['priority'];
				}

				if(!empty($ipArray['source'])){
					$filtercinputArray['ticketSource'] = $ipArray['source'];
				}

				if(!empty($ipArray['created_on'])){
					$filtercinputArray['createdOn'] = date("Y-m-d",strtotime($ipArray['created_on']));
				}
			//}
		}

		$res = SELF::ListUserPostFilter("http://106.51.0.187:8090/cgwfollowon/searcspecifichticketlist",$filtercinputArray);

		return $res;
     }

     public function searchTicketWithoutStatus($ipArray,$tId){

		$filtercinputArray = array();

		$res = "";
		if(!empty($ipArray['submit'])){

			if(empty($ipArray['group'])){
				$filtercinputArray['ticketGroupId'] = $ipArray['group'];
			}

			if(empty($ipArray['employee'])){
				$filtercinputArray['ticketAssignedUser'] = $ipArray['employee'];
			}

			if(empty($ipArray['priority'])){
				$filtercinputArray['priority'] = $ipArray['priority'];
			}

			if(empty($ipArray['source'])){
				$filtercinputArray['ticketSource'] = $ipArray['source'];
			}

			if(!empty($ipArray['created_on'])){
				$filtercinputArray['createdOn'] = date("Y-m-d",strtotime($ipArray['created_on']));
			}
		}

		$res = SELF::ListUserPostFilter("http://106.51.0.187:8090/cgwfollowon/searcspecifichticketlist",$filtercinputArray);

		return $res;
     }

     public function store(Request $request){

     	$inputArray = $request->all();

		$userId = session()->get('userId');

		$tabId="";
		if(!empty($inputArray['tab_id'])){
			$tabId = $inputArray['tab_id'];
		}

		$responseArray = $ticketListArray = array();

		if(!empty($tabId)){
			$results = SELF::searchTicketWithStatus($inputArray,$tabId);
		}
		else{
			$results = SELF::searchTicketWithoutStatus($inputArray,$tabId);
		}

		//print"<pre>";
		//print_r($results);
		//exit;

		if(!empty($results)){
			$responseArray = json_decode($results);
		}
		elseif(!empty($searchResults)){
			$responseArray = json_decode($searchResults);
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
		$countinputArray['ticketAssignedUser'] = $userId;
		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/crmuserdashboardcount",$countinputArray);

		$ticketCountArray = $countResponseArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		//print"<pre>";
		//print_r($countResponseArray);
		//exit;

		$countinputArray = array();
		$countinputArray['ticketAssignedUser'] = $userId;
		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/crmuserdashboardcount",$countinputArray);

		$ticketCountArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		if(!empty($countResponseArray)){
			//foreach($countResponseArray->ticketStatusCounts as $countResponseVal){
				$ticketCountArray[] = $countResponseArray;
			//}
		}

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				if(!empty($userId)){
					return view('admin.ticket_form.user_tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId,'error'=>'errorArray']);
				}
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
		}

		/*
		if(!empty($userId)){
			return view('admin.ticket_form.tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId,'error'=>'errorArray']);
		}
		else{
			return redirect('admin/login_user');
		}
		*/
    }

    public function ListUserPostFilterUser($url,$params){

		$json_string = '';
		$fields = array();

		if(!empty($params['ticketAssignedUser'])){
			$fields['ticketAssignedUser'] = $params['ticketAssignedUser'];
		}

		if(!empty($params['status'])){
			$fields['status'] = $params['status'];
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

		//print"<pre>";
		//print_r($curl_response);
		//exit;

		curl_close($curl);

		return $curl_response;
	}


    public function ListUserPostFilter($url,$params){

		$json_string = '';
		$fields = array();

		if(!empty($params['ticketGroupId'])){
			$fields['ticketGroupId'] = $params['ticketGroupId'];
		}

		if(!empty($params['ticketAssignedUser'])){
			$fields['ticketAssignedUser'] = $params['ticketAssignedUser'];
		}

		if(!empty($params['priority'])){
			$fields['priority'] = $params['priority'];
		}

		if(!empty($params['ticketSource'])){
			$fields['ticketSource'] = $params['ticketSource'];
		}

		if(!empty($params['createdOn'])){
			$fields['createdOn'] = $params['createdOn'];
		}

		if(!empty($params['status'])){
			$fields['status'] = $params['status'];
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

		//print"<pre>";
		//print_r($curl_response);
		//exit;

		curl_close($curl);

		return $curl_response;
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

    public function TicketCount($url,$params){

        $json_string = '';

        if(!empty($params['ticketAssignedUser'])){
            $fields['ticketAssignedUser'] = $params['ticketAssignedUser'];
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

        //echo $curl_response;
        //exit;

        curl_close($curl);

        return $curl_response;
    }
}
