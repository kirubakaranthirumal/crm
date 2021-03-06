<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\TicketReportGenerate;
use App\Department;

class TicketReportGenController extends Controller{

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index(Request $request){

		Session::forget('contentManageSuc');
		Session::forget('contentManageDelSuc');
		Session::forget('menuNameError');
		Session::forget('menuNameUpdateError');

		$successArray = $errorArray = $ticketReportArray = array();

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
			$ticketReportArray = $this->retrieveAllTicketReportInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}
		
			$userId = session()->get('userId');

		$cinputArray = $appResponseArray = array();

		$cinputArray['userSesId'] = 1;

		$appresults = "";
		if(!empty($cinputArray)){
			$appresults = SELF::ListAppPost("http://106.51.0.187:8090/cgwfollowon/listapp",$cinputArray);
		}

		if(!empty($appresults)){
			$appResponseArray = json_decode($appresults);
		}

		$appListArray = array();
		if(!empty($appResponseArray->AppDetails)){
			foreach($appResponseArray->AppDetails as $responseVal){
				$appListArray[] = $responseVal;
			}
		}

		return view('admin.ticket_form.tickets_report',['app_data'=>$appListArray,'ticketdetails'=>$ticketReportArray]);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  Request  $request
	* @return Response
	*/

	public function store(Request $request){


		
		Session::forget('contentManageSuc');
		Session::forget('contentManageDelSuc');
		Session::forget('menuNameError');

		$statusCode = "200";
		$status = "Success";
		$userId = $ticketId = "";

		$inputArray = $request->all();
		
		$userId = Session::get('userId');

		if(!empty($userId)){
			$inputArray['create_by'] = $userId;
		}

		
		$successArray = $errorArray = $ticketReportArray = array();

				$groupId = $this->ticketFilter($inputArray);
				 
		$successArray = $errorArray = $ticketReportArray = array();
		
			$params = $request->all();
		if(!empty($params['pageNo'])) $params['pageNo'] = $params['pageNo'];
		else $params['pageNo']=env('PAGE_NO');
					
		if(!empty($params['recordsCount'])) $params['recordsCount'] = $params['recordsCount'];
		else $params['recordsCount']=env('RECORD_COUNT');

		if(!empty($params['pageNo'])) $params['pageNo'] = $params['pageNo'];
		else $params['pageNo']=env('PAGE_NO');

		if(!empty($params['sortingColumn'])) $params['sortingColumn'] = $params['sortingColumn'];
		else $params['sortingColumn']=env('SORTING_COLUMN');

		if(!empty($params['sortingOrder'])) $params['sortingOrder'] = $params['sortingOrder'];
		else $params['sortingOrder']=env('SORTING_ORDER');
		
		try{
			$ticketReportArray = $this->filter($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		} 
			
		/* 	 print"<pre>";
			print_r($ticketReportArray);
			exit;  */
	
	     return view('admin.ticket_form.tickets_report',['ticketReportArray'=>$ticketReportArray]);
	}

	//to validate menu name is already exist in table
	public function ticketIsExist($inputArray){

		$ticketObj = new TicketReportGenerate();

		//$WhrClause = array();
		//$WhrClause['menu_name'] = $inputArray['menu_name'];

		$ticketModel = $ticketObj->filter($inputArray);

		if($ticketModel){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id, Request $request){

		Session::forget('contentManageSuc');
		Session::forget('contentManageDelSuc');

		$successArray = $errorArray = $ticketReportArray = array();

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
			$ticketReportArray = $this->retrieveAllTicketReportInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}


		return view('admin.ticket_form.tickets_report',['menucontent'=>$ticketReportArray]);
	}

	//create new department
	public function ticketFilter($inputArray){
		
		//set model object
		$ticketObj = new TicketReportGenerate();

		$ticketObj->group = (isset($inputArray['group'])?trim($inputArray['group']):"");
		$ticketObj->employee = (isset($inputArray['employee'])?trim($inputArray['employee']):"");
		$ticketObj->priority = (isset($inputArray['priority'])?trim($inputArray['priority']):"");
		$ticketObj->source = (isset($inputArray['source'])?trim($inputArray['source']):"");
		$ticketObj->status = (isset($inputArray['status'])?trim($inputArray['status']):"");
		$ticketObj->status = (isset($inputArray['status'])?trim($inputArray['status']):"");
		$ticketObj->application = (isset($inputArray['application'])?trim($inputArray['application']):"");
		$ticketObj->event = (isset($inputArray['event'])?trim($inputArray['event']):"");
		//$ticketObj->start_date = (isset($inputArray['start_date'])?trim($inputArray['start_date']):"");
		$ticketObj->start_date=date('Y-m-d H:i:s',strtotime((isset($inputArray['start_date'])?trim($inputArray['start_date']):"")));
		$ticketObj->end_date=date('Y-m-d H:i:s',strtotime((isset($inputArray['end_date'])?trim($inputArray['end_date']):"")));
		//$ticketObj->end_date = (isset($inputArray['end_date'])?trim($inputArray['end_date']):"");
		$ticketObj->category = (isset($inputArray['category'])?trim($inputArray['category']):"");
		$ticketObj->create_by = (isset($inputArray['create_by'])?trim($inputArray['create_by']):"0");
		$ticketObj->modified_on = date('0000-00-00 00:00:00');
		$ticketObj->modified_by = (isset($inputArray['modified_by'])?trim($inputArray['modified_by']):"0");

		$ticketId = $ticketObj->filter($ticketObj);

		if($ticketId){
			return $ticketId;
		}
		else{
			return false;
		}
	}
		public function load_group_user(Request $request){

		$message = '';

		$inputArray = $cinputArray = array();

		$inputArray = $request->all();

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

		if(!empty($userId)){
			return view('admin.ticket_form.select_group_user', ['userdata' => $groupUserListArray]);
		}
		//else{
		//	return redirect('admin/login_user');
		//}
	}
	
		public function ListAppPost($url,$params){

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

	 public function loadEmpByGroupId($url,$params){

		$json_string = '';

		if(!empty($params['groupId'])){
			$fields['groupId'] = $params['groupId'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}

		//$json_string = '{"groupId":"1"}';

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
	
	
	//retrieve department records info
	public function retrieveInfo($contentmanageId){
		$contentmanageObj = new TicketReportGenerate();
		$WhrClause['id'] = $contentmanageId;
		$contentmanageModel = $contentmanageObj->retrieveById($WhrClause);
		return $contentmanageModel;
	}
	
	public function filter($params){
		$contentmanageObj = new TicketReportGenerate();
		$contentmanageModel = $contentmanageObj->filter($params);
		return $contentmanageModel;
	} 
	//retrieve All department records info
	public function retrieveAllTicketReportInfo($params){
		$contentmanageObj = new TicketReportGenerate();
		$resultArray = $contentmanageObj->retrieveAll($params);
		return $resultArray;
	}

	//update department details
	public function updateById($contentmanageId, $inputArray){
		$contentmanageObj = new TicketReportGenerate();
		$contentmanageObj->updateById($contentmanageId, $inputArray);
	}

	//delete a record
	public function deleteById($id){
		$contentmanageObj = new TicketReportGenerate();
		$result = $contentmanageObj->deleteById($id);
	}
}