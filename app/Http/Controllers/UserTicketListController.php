<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use App\Department;
use App\Category;
use App\Priority;
use App\Source;
use App\Type;
use App\SmtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserTicketListController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(Request $request){

		$successArray = $errorArray = $departmentArray = $categoryArray = $priorityArray = $sourceArray = $typeArray = $priorityDispArray = array();
		$inputArray = $request->all();

		$userId = session()->get('userId');
		$usertype=session()->get('userType');
		$appid=session()->get('appId');
		$eventid=session()->get('eventId');

      	//print"<pre>";
        //print_r($inputArray);
        //exit;

		$departmentArray = $this->retrieveAllActiveDepartmentInfo($inputArray);
		$categoryArray = $this->retrieveAllActiveCategoryInfo($inputArray);
		$priorityArray = $this->retrieveAllActivePriorityInfo($inputArray);
		$priorityDispArray = $this->retrieveAllPriorityInfo($inputArray);
		$sourceArray = $this->retrieveAllActiveSourceInfo($inputArray);
		$typeArray = $this->retrieveAllActiveTypeInfo($inputArray);

		$department=array();
		$category=array();
		$priority=array();
		$priorityDisp=array();
		$source=array();
		$type=array();

		if(!empty($departmentArray)){
			foreach($departmentArray as $deptVal){
				$department[] = $deptVal;
			}
		}

		if(!empty($categoryArray)){
			foreach($categoryArray as $categoryVal){
				$category[] = $categoryVal;
			}
		}

		if(!empty($priorityArray)){
			foreach($priorityArray as $priorityVal){
				$priority[] = $priorityVal;
			}
		}

		if(!empty($priorityDispArray)){
			foreach($priorityDispArray as $priorityVal){
				$priorityDisp[] = $priorityVal;
			}
		}

		if(!empty($priorityDisp)){
			foreach($priorityDisp as $priorityDispVal){
				$priorityDispData[$priorityDispVal['priorityId']] = $priorityDispVal;
			}
		}

		if(!empty($sourceArray)){
			foreach($sourceArray as $sourceVal){
				$source[] = $sourceVal;
			}
		}

		if(!empty($typeArray)){
			foreach($typeArray as $typeVal){
				$type[] = $typeVal;
			}
		}

		if(!empty($userId)){
			$cinputArray['ticketAssignedUser'] = $userId;
		}

		if(!empty($usertype)){
			//$cinputArray['loginuserType'] = $usertype;
		}

		if(!empty($appid)){
			$cinputArray['appId'] = $appid;
		}

		if(!empty($eventid)){
			$cinputArray['eventId'] = $eventid;
		}

		$tabId="";
        if(!empty($inputArray['tab_id'])){
        	$tabId = $inputArray['tab_id'];
        }

		if(!empty($tabId)){
			if($tabId=="1"){
				//$cinputArray['Id'] = "1";
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

				if(!empty($userId)){
					$cinputArray['ticketAssignedUser'] = $userId;
        		}

        		$user_type = "";

        		if(!empty(session()->get('userType'))){
        			$user_type = session()->get('userType');
        		}

        		if(!empty(session()->get('userType'))){
					//$cinputArray['loginuserType'] = $user_type;
        		}

				if(!empty($cinputArray)){
					$results = SELF::ListUserPostFilterUser("http://106.51.0.187:8090/cgwfollowon/searcspecifichticketlist",$cinputArray);
				}
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

		$ticketListDataArray = "";
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

		$countinputArray = array();
		$countinputArray['ticketAssignedUser'] = $userId;
		$countinputArray['appId'] = $appid;
		$countinputArray['eventId'] = $eventid;

		if(!empty($userId)){
			$countinputArray['ticketAssignedUser'] = $userId;
		}

		if(!empty($usertype)){
			$countinputArray['loginuserType'] = $usertype;
		}

		if(!empty($appid)){
			$countinputArray['appId'] = $appid;
		}

		if(!empty($eventid)){
			$countinputArray['eventId'] = $eventid;
		}

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
                //Session::forget('userListError');
                //session()->put('userSuccess','User has been created successfully');
                if(!empty($userId)){
                	return view('admin.ticket_form.user_tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId,'department'=>$department,'category'=>$category,'type'=>$type,'priority'=>$priority,'priorityDisp'=>$priorityDispData,'source'=>$source,'userType' => session()->get('userType')]);
                }
            }
        }
        elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
            //Session::forget('userSuccess');
            //session()->put('userListError','Email address already exist');
        }

        if(!empty($userId)){
            return view('admin.ticket_form.user_tickets_list',['ticketdata'=>$ticketListArray,'department'=>$department,'category'=>$category,'type'=>$type,'priority'=>$priority,'priorityDisp'=>$priorityDispData,'source'=>$source,'userType'=>session()->get('userType')]);
		}
		else{
			return redirect('admin/login_user');
		}
    }

     public function searchTicketWithStatus($ipArray,$tId){

     	$userId = session()->get('userId');
		$usertype=session()->get('userType');
		$appid=session()->get('appId');
		$eventid=session()->get('eventId');

		//print"<pre>";
		//print_r($inputArray);
		//exit;

		//print"<pre>";
		//print_r(Session::all());
		//exit;

		$filtercinputArray = array();

		if(!empty($userId)){
			$filtercinputArray['ticketAssignedUser'] = $userId;
		}

		if(!empty($usertype)){
			//$filtercinputArray['loginuserType'] = $usertype;
		}

		if(!empty($appid)){
			$filtercinputArray['appId'] = $appid;
		}

		if(!empty($eventid)){
			$filtercinputArray['eventId'] = $eventid;
		}

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

     	$successArray = $errorArray = $departmentArray = $categoryArray = $priorityArray = $sourceArray = $typeArray = $priorityDispArray = array();
     	$inputArray = $request->all();

		$userId = session()->get('userId');
		$appid=session()->get('appId');
		$eventid=session()->get('eventId');

		$tabId="";
		if(!empty($inputArray['tab_id'])){
			$tabId = $inputArray['tab_id'];
		}

		$departmentArray = $this->retrieveAllActiveDepartmentInfo($inputArray);
		$categoryArray = $this->retrieveAllActiveCategoryInfo($inputArray);
		$priorityArray = $this->retrieveAllActivePriorityInfo($inputArray);
		$priorityDispArray = $this->retrieveAllPriorityInfo($inputArray);
		$sourceArray = $this->retrieveAllActiveSourceInfo($inputArray);
		$typeArray = $this->retrieveAllActiveTypeInfo($inputArray);

		$department=array();
		$category=array();
		$priority=array();
		$priorityDisp=array();
		$source=array();
		$type=array();

		if(!empty($departmentArray)){
			foreach($departmentArray as $deptVal){
				$department[] = $deptVal;
			}
		}

		if(!empty($categoryArray)){
			foreach($categoryArray as $categoryVal){
				$category[] = $categoryVal;
			}
		}

		if(!empty($priorityArray)){
			foreach($priorityArray as $priorityVal){
				$priority[] = $priorityVal;
			}
		}

		if(!empty($priorityDispArray)){
			foreach($priorityDispArray as $priorityVal){
				$priorityDisp[] = $priorityVal;
			}
		}

		if(!empty($priorityDisp)){
			foreach($priorityDisp as $priorityDispVal){
				$priorityDispData[$priorityDispVal['priorityId']] = $priorityDispVal;
			}
		}

		if(!empty($sourceArray)){
			foreach($sourceArray as $sourceVal){
				$source[] = $sourceVal;
			}
		}

		if(!empty($typeArray)){
			foreach($typeArray as $typeVal){
				$type[] = $typeVal;
			}
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

		if(!empty($userId)){
			$countinputArray['ticketAssignedUser'] = $userId;
		}

		if(!empty($usertype)){
			$countinputArray['loginuserType'] = $usertype;
		}

		if(!empty($appid)){
			$countinputArray['appId'] = $appid;
		}

		if(!empty($eventid)){
			$countinputArray['eventId'] = $eventid;
		}

		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/crmuserdashboardcount",$countinputArray);

		$ticketCountArray = $countResponseArray = array();
		if(!empty($statusResultCount)){
			$countResponseArray = json_decode($statusResultCount);
		}

		//print"<pre>";
		//print_r($countResponseArray);
		//exit;

		/*
		$countinputArray = array();
		//$countinputArray['appId'] = $appid;
		//$countinputArray['eventId'] = $eventid;

		if(!empty($userId)){
			$countinputArray['ticketAssignedUser'] = $userId;
		}

		if(!empty($usertype)){
			//$cinputArray['loginuserType'] = $usertype;
		}

		if(!empty($appid)){
			$cinputArray['appId'] = $appid;
		}

		if(!empty($eventid)){
			$cinputArray['eventId'] = $eventid;
		}

		$statusResultCount = SELF::TicketCount("http://106.51.0.187:8090/cgwfollowon/crmuserdashboardcount",$countinputArray);
		*/

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
					return view('admin.ticket_form.user_tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId,'error'=>'errorArray','department'=>$department,'category'=>$category,'type'=>$type,'priority'=>$priority,'priorityDisp'=>$priorityDispData,'source'=>$source,'post'=>$inputArray]);
				}
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
		}

		/*
		if(!empty($userId)){
			return view('admin.ticket_form.user_tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId,'error'=>'errorArray','department'=>$department,'category'=>$category,'type'=>$type,'priority'=>$priority,'priorityDisp'=>$priorityDispData,'source'=>$source,'post'=>$inputArray]);
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

		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
		}

		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
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
		if(!empty($params['ticketAssignedUser'])){
			$fields['ticketAssignedUser'] = $params['ticketAssignedUser'];
		}

		if(!empty($params['loginuserType'])){
			$fields['loginuserType'] = $params['loginuserType'];
		}
		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
		}
		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
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
		if(!empty($params['loginuserType'])){
			$fields['loginuserType'] = $params['loginuserType'];
		}
		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
		}
		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
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

        //echo $curl_response;
        //exit;

        curl_close($curl);

        return $curl_response;
    }

	public function retrieveAllActiveDepartmentInfo(){
		$departmentObj = new Department();
		$resultArray = $departmentObj->retrieveAllActive();
		return $resultArray;
	}

	//retrieve All department records info
	public function retrieveAllActiveCategoryInfo($params){
		$categoryObj = new Category();
		$resultArray = $categoryObj->retrieveAllActive($params);
		return $resultArray;
	}

	//retrieve All priority records info
	public function retrieveAllActivePriorityInfo($params){
		$priorityObj = new Priority();
		$resultArray = $priorityObj->retrieveAllActive($params);
		return $resultArray;
	}

	//retrieve All source records info
	public function retrieveAllActiveSourceInfo($params){
		$sourceObj = new Source();
		$resultArray = $sourceObj->retrieveAllActive($params);
		return $resultArray;
	}

	//retrieve All type records info
	public function retrieveAllActiveTypeInfo($params){
		$typeObj = new Type();
		$resultArray = $typeObj->retrieveAllActive($params);
		return $resultArray;
	}

	public function retrieveAllActiveStatusInfo($params){
		$statusObj = new Status();
		$resultArray = $statusObj->retrieveAllActive($params);
		return $resultArray;
	}

	//retrieve All priority records info
	public function retrieveAllPriorityInfo($params){
		$priorityObj = new Priority();
		$resultArray = $priorityObj->retrieveAll($params);
		return $resultArray;
	}
}
