<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Department;
use App\Category;
use App\Priority;
use App\Source;
use App\Status;
use App\Type;
use App\SmtpMail;

class PrivilegeTicketListController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(Request $request){

		Session::forget('ticketSuccess');
		Session::forget('ticketError');

		Session::forget('departmentSuc');
		Session::forget('categorySuc');
		Session::forget('prioritySuc');
		Session::forget('sourceSuc');
		Session::forget('typeSuc');

		Session::forget('departmentDelSuc');
		Session::forget('categoryDelSuc');
		Session::forget('priorityDelSuc');
		Session::forget('sourceDelSuc');
		Session::forget('typeDelSuc');

		Session::forget('DeleteTicketSuccess');
		Session::forget('DeleteTicketError');

		$successArray = $errorArray = $departmentArray = $categoryArray = $priorityArray = $sourceArray = $typeArray = $priorityDispArray = array();
		$params = $request->all();

		//initialize record count,page number,sorting
		if(!empty($params['recordsCount'])) $params['recordsCount'] = $params['recordsCount'];
		else $params['recordsCount']=env('RECORD_COUNT');

		if(!empty($params['pageNo'])) $params['pageNo'] = $params['pageNo'];
		else $params['pageNo']=env('PAGE_NO');

		if(!empty($params['sortingColumn'])) $params['sortingColumn'] = $params['sortingColumn'];
		else $params['sortingColumn']=env('SORTING_COLUMN');

		if(!empty($params['sortingOrder'])) $params['sortingOrder'] = $params['sortingOrder'];
		else $params['sortingOrder']=env('SORTING_ORDER');

		try{
			$departmentArray = $this->retrieveAllActiveDepartmentInfo($params);
			$categoryArray = $this->retrieveAllActiveCategoryInfo($params);
			$priorityArray = $this->retrieveAllActivePriorityInfo($params);
			$priorityDispArray = $this->retrieveAllPriorityInfo($params);
			$sourceArray = $this->retrieveAllActiveSourceInfo($params);
			$typeArray = $this->retrieveAllActiveTypeInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

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
			if($tabId=="0"){
				$cinputArray['loginuserType'] = "1";
           		$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listalltickets",$cinputArray);
			}
			else{
				if($tabId=="1"){
					$cinputArray['status'] = "1";
				}
				elseif($tabId=="2"){
					$cinputArray['status'] = "2";
				}
				elseif($tabId=="3"){
					$cinputArray['status'] = "3";
				}
				elseif($tabId=="4"){
					$cinputArray['status'] = "4";
				}
				elseif($tabId=="5"){
					$cinputArray['status'] = "5";
				}
				elseif($tabId=="6"){
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

		//getting active status list
		$statusArray = $statusCountArray = array();
		$statusModalObj = new Status;
		$statusArray = $statusModalObj->retrieveAllActive();
				
		foreach($statusArray as $statusInfo){
			if($statusInfo['statusId'] == 1){
				$statusInfo['count'] = $ticketCountArray['0']->openStatuscount;
			}
			if($statusInfo['statusId'] == 2){
				$statusInfo['count'] = $ticketCountArray['0']->assignedStatuscount;
			}
			if($statusInfo['statusId'] == 3){
				$statusInfo['count'] = $ticketCountArray['0']->inprogressStatuscount;
			}
			if($statusInfo['statusId'] == 4){
				$statusInfo['count'] = $ticketCountArray['0']->closedStatuscount;
			}
			if($statusInfo['statusId'] == 5){
				$statusInfo['count'] = $ticketCountArray['0']->wfCusRescount;
			}
			if($statusInfo['statusId'] == 6){
				$statusInfo['count'] = $ticketCountArray['0']->wfTPartyRescount;
			}
			$statusCountArray[] = $statusInfo;
		}
		
    	if((!empty($responseArray->status)) && ($responseArray->status == "200")){
            if(!empty($responseArray->msg)){
                if(!empty($userId)){
                	return view('admin.ticket_form.privilege_tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId,'department'=>$department,'category'=>$category,'type'=>$type,'priority'=>$priority,'priorityDisp'=>$priorityDispData,'source'=>$source,'status'=>$statusCountArray]);
                }
            }
        }
        elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
            //Session::forget('userSuccess');
            //session()->put('userListError','Email address already exist');
        }

        if(!empty($userId)){
            return view('admin.ticket_form.privilege_tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId,'department'=>$department,'category'=>$category,'type'=>$type,'priority'=>$priority,'priorityDisp'=>$priorityDispData,'source'=>$source,'status'=>$statusCountArray]);
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
                	return view('admin.ticket_form.privilege_tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId]);
                }
            }
			if(!empty($userId)){
				return view('admin.ticket_form.privilege_tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId]);
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

     	$successArray = $errorArray = $departmentArray = $categoryArray = $priorityArray = $sourceArray = $typeArray = $priorityDispArray = array();

     	$inputArray = $request->all();

		$userId = session()->get('userId');

		$tabId="";
		if(!empty($inputArray['tab_id'])){
			$tabId = $inputArray['tab_id'];
		}

		$responseArray = $ticketListArray = array();

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
					return view('admin.ticket_form.privilege_tickets_list',['ticketdata' => $ticketListArray,'ticketcountdata'=> $ticketCountArray,'tab'=>$tabId,'department'=>$department,'category'=>$category,'type'=>$type,'priority'=>$priority,'priorityDisp'=>$priorityDispData,'source'=>$source,'error'=>'errorArray','post'=>$inputArray]);
				}
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
		}
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

    public function retrieveAllDepartmentInfo($params){
		$departmentObj = new Department();
		$resultArray = $departmentObj->retrieveAll($params);
		return $resultArray;
	}

	//retrieve All department records info
	public function retrieveAllCategoryInfo($params){
		$categoryObj = new Category();
		$resultArray = $categoryObj->retrieveAll($params);
		return $resultArray;
	}

	//retrieve All priority records info
	public function retrieveAllPriorityInfo($params){
		$priorityObj = new Priority();
		$resultArray = $priorityObj->retrieveAll($params);
		return $resultArray;
	}

	//retrieve All source records info
	public function retrieveAllSourceInfo($params){
		$sourceObj = new Source();
		$resultArray = $sourceObj->retrieveAll($params);
		return $resultArray;
	}

	//retrieve All type records info
	public function retrieveAllTypeInfo($params){
		$typeObj = new Type();
		$resultArray = $typeObj->retrieveAll($params);
		return $resultArray;
	}

	//retrieve All type records info
	public function retrieveAllStatusInfo($params){
		$statusObj = new Status();
		$resultArray = $statusObj->retrieveAll($params);
		return $resultArray;
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
		$resultArray = $typeObj->retrieveAll($params);
		return $resultArray;
	}
}
