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

		Session::forget('DeleteTicketSuccess');
    	Session::forget('DeleteTicketError');

		$inputArray = $request->all();

		$userId = session()->get('userId');

      	//print"<pre>";
        //print_r($inputArray);
        //exit;

		$tabId="";
        if(!empty($inputArray['tab_id'])){
        	$tabId = $inputArray['tab_id'];
        }

		//print"<pre>";
		//print_r(Session::all());
		//exit;


		if(!empty($tabId)){
			if($tabId=="1"){
				$cinputArray['loginuserType'] = "1";
           		$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listalltickets",$cinputArray);
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

				if(!empty($cinputArray)){
					$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/searcspecifichticketlist",$cinputArray);
				}
			}
        }
        else{
        	$cinputArray['loginuserType'] = "1";
           	$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listalltickets",$cinputArray);
        }

        $responseArray = array();

        $ticketListArray = $ticketSortDataArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		$ticketListDataArray = array();
		if(!empty($responseArray->Crmticketlist)){
        	foreach($responseArray->Crmticketlist as $responseVal){
				$ticketListArray[] = $responseVal;
			}
		}
		elseif(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseDataVal){
				//$ticketSortDataArray[] = $responseDataVal;
				$ticketListDataArray[] = $responseDataVal;
			}
		}

		if(!empty($ticketListDataArray)){
			foreach($ticketListDataArray as $responseVal){
				$ticketListArray[] = $responseVal;
				//$ticketListArray['agingHours'][] = strtotime($responseVal->createdOn);
			}
		}

		$countinputArray = array();
		$countinputArray['loginuserType'] = "1";
		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/dashboardcount",$countinputArray);

		$ticketCountArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		if(!empty($countResponseArray->ticketStatusCounts)){
			foreach($countResponseArray->ticketStatusCounts as $countResponseVal){
				$ticketCountArray[] = $countResponseVal;
			}
		}

		//print"<pre>";
		//print_r($ticketCountArray);
		//exit;

		//print"<pre>";
		//print_r($ticketListDataArray);
		//exit;

		/*
		usort($ticketListDataArray, 'sortByOrder');

		function sortByOrder($a, $b) {
			return $a['ticketId'] - $b['ticketId'];
		}*/

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

	public function show($id){

		Session::forget('DeleteTicketSuccess');
    	Session::forget('DeleteTicketError');
		 $userId = session()->get('userId');

        $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['ticketId'] = $id;
        }

		if(!empty($userId)){
            $cinputArray['userId'] = $userId;
        }

		if(!empty($cinputArray)){
		 	$delete = SELF::DeleteTicketList("http://106.51.0.187:8090/cgwfollowon/deleteticket",$cinputArray);
		 	$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listalltickets",$cinputArray);
		}
		       $tabId="";
        if(!empty($inputArray['tab_id'])){
        	$tabId = $inputArray['tab_id'];
        }

		if(!empty($tabId)){
			if($tabId=="1"){
				$cinputArray['Id'] = "1";
           		$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listalltickets",$cinputArray);
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

				if(!empty($cinputArray)){
					$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/searcspecifichticketlist",$cinputArray);
				}
			}
        }
        else{
        	$cinputArray['Id'] = "1";
           	$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listalltickets",$cinputArray);
        }
        $responseArray = $delResponseArray = array();

        if(!empty($delete)){
            $delResponseArray = json_decode($delete);
        }

        //print"<pre>";
        //print_r($delResponseArray);
        //exit;

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
		$countinputArray['userId'] = $userId;
		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/dashboardcount",$countinputArray);

		$ticketCountArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		if(!empty($countResponseArray->ticketStatusCounts)){
			foreach($countResponseArray->ticketStatusCounts as $countResponseVal){
				$ticketCountArray[] = $countResponseVal;
			}
		}


		if((!empty($delResponseArray->status)) && ($delResponseArray->status == "200")){
            if(!empty($delResponseArray->msg)){
                Session::forget('DeleteTicketError');
                session()->put('DeleteTicketSuccess','Ticket has been deleted successfully');
                if(!empty($userId)){
                	return view('admin.ticket_form.tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId]);
                }
            }
			if(!empty($userId)){
				return view('admin.ticket_form.tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId]);
			}
			else{
				return redirect('admin/login_user');
			}
		}
		elseif((!empty($delResponseArray->status)) && ($delResponseArray->status == "201")){

			Session::forget('DeleteTicketSuccess');
			session()->put('DeleteTicketError','Ticket Delete Failed..');
		}

	}

	public function DeleteTicketList($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['ticketId'])){
			$fields['ticketId'] = $params['ticketId'];
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

				if(!empty($ipArray['group'])){
					$filtercinputArray['ticketGroupId'] = $ipArray['group'];
				}

				if(!empty($ipArray['employee'])){
					$filtercinputArray['ticketAssignedUser'] = $ipArray['employee'];
				}

				if(!empty($ipArray['priority'])){
					$filtercinputArray['priority'] = $ipArray['priority'];
				}

				if(!empty($ipArray['source'])){
					$filtercinputArray['ticketSource'] = $ipArray['source'];
				}

				if(!empty($ipArray['created_on'])){
					$filtercinputArray['createdOn'] = date("Y-m-d",strtotime($ipArray['created_on']));
					//echo date("Y-m-d",strtotime($ipArray['created_on']));
				}

				//print"<pre>";
				//print_r($filtercinputArray);
				//exit;
			//}
		}
		else{

			//print"<pre>";
			//print_r($ipArray);
			//exit;

			//if(!empty($ipArray['submit'])){

				if(!empty($ipArray['group'])){
					$filtercinputArray['ticketGroupId'] = $ipArray['group'];
				}

				if(!empty($ipArray['employee'])){
					$filtercinputArray['ticketAssignedUser'] = $ipArray['employee'];
				}

				if(!empty($ipArray['priority'])){
					$filtercinputArray['priority'] = $ipArray['priority'];
				}

				if(!empty($ipArray['source'])){
					$filtercinputArray['ticketSource'] = $ipArray['source'];
				}

				if(!empty($ipArray['created_on'])){
					$filtercinputArray['createdOn'] = date("Y-m-d",strtotime($ipArray['created_on']));
				}

				//print"<pre>";
				//print_r($filtercinputArray);
				//exit;
			//}
		}

		$res = SELF::ListUserPostFilter("http://106.51.0.187:8090/cgwfollowon/searcspecifichticketlist",$filtercinputArray);

		return $res;
     }

     public function searchTicketWithoutStatus($ipArray,$tId){

		$filtercinputArray = array();

		$res = "";
		//if(!empty($ipArray['submit'])){

			if(!empty($ipArray['group'])){
				$filtercinputArray['ticketGroupId'] = $ipArray['group'];
			}

			if(!empty($ipArray['employee'])){
				$filtercinputArray['ticketAssignedUser'] = $ipArray['employee'];
			}

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

		//print"<pre>";
		//print_r($inputArray);
		//exit;

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
		$countinputArray['userId'] = $userId;
		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/dashboardcount",$countinputArray);

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
				if(!empty($userId)){
					return view('admin.ticket_form.tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId,'error'=>'errorArray']);
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

		if(!empty($params['loginuserType'])){
			$fields['loginuserType'] = $params['loginuserType'];
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

        if(!empty($params['loginuserType'])){
            $fields['loginuserType'] = $params['loginuserType'];
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
