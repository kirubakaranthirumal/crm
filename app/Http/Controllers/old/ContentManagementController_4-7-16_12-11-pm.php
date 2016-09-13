<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\ContentManagement;

class ContentManagementController extends Controller{

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

		$successArray = $errorArray = $contentManageArray = array();

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
			$contentManageArray = $this->retrieveAllContentManageInfo($params);
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

		/* print"<pre>";
		print_r($contentManageArray);
		exit;  */

		return view('admin.users.contentmanage',['app_data'=>$appListArray,'menucontent'=>$contentManageArray]);
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
		$userId = $menuId = "";

		$errorArray = array();

		$inputArray = $request->all();

		$userId = Session::get('userId');

		if(!empty($userId)){
			$inputArray['create_by'] = $userId;
		}

		//print"<pre>";
		//print_r($inputArray);
		//exit;

		$nameArray = array();
		$nameArray = $this->menuIsExist($inputArray);

		if(!empty($nameArray)){
			$errorArray['menuNameError'] = "Error : Menu name already exist";
			session()->put('menuNameError',"Error : Menu name already exist");
		}

		if(empty($errorArray)){
			$menuId = $this->createMenu($inputArray);
		}

	    $successArray = $errorArray = $contentManageArray = array();
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
			$contentManageArray = $this->retrieveAllContentManageInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}


		if((!empty($menuId))){
			//$request->session()->flash('alert-success', 'DepartMent Created Successfully');
			//return view('admin.users.settings',['department'=>$departmentArray]);
			//return redirect('AddDept')->withInput();
			//return redirect('admin/settings')->withInput();
			//return view('admin.users.settings');
			session()->put('contentManageSuc','Menu has been created successfully');

			return view('admin.users.contentmanage',['menucontent'=>$contentManageArray,'errorArray'=>$errorArray]);
		}
		else{
			return view('admin.users.contentmanage',['menucontent'=>$contentManageArray]);
		}
	}

	//to validate menu name is already exist in table
	public function menuIsExist($inputArray){

		$menuObj = new ContentManagement();

		//$WhrClause = array();
		//$WhrClause['menu_name'] = $inputArray['menu_name'];

		$menuModel = $menuObj->retrieveByWhereName($inputArray);

		if($menuModel){
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

		$successArray = $errorArray = $contentManageArray = array();

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
			$contentManageArray = $this->retrieveAllContentManageInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		//print"<pre>";
		//print_r($departmentArray);
		//exit;

		return view('admin.users.contentmanage',['menucontent'=>$contentManageArray]);
	}



	/*
	*validate input data for category
	*
	*@param $inputArray
	*@return throw exception on error
	*/
	private function _validateInputs($inputArray){

		$errorArray = array();

		if(!empty($inputArray) && count($inputArray)>0){

			if(empty($inputArray['firstName'])){
				$errorArray['1126'] = "Empty First Name";
			}

			if(empty($inputArray['email'])){
				$errorArray['1127'] = "Empty E-Mail";
			}

			if(empty($inputArray['status'])){
				$errorArray['1128'] = "Empty Status";
			}
		}
		else {
			$errorArray['1129'] = "Empty admin user input";
		}

		//print_r($errorArray);
		//exit;

		//if error accurs throw exception
		//if(!empty($errorArray) & count($errorArray)>0){
		//	throw new Exception(serialize($errorArray),"1000");
		//}
		return $errorArray;
	}

	//validate update product inputs
	private function setUpdateFields($userOldArray,$inputArray){

		$updateArray = array();

		if(array_key_exists("firstName",$itemArray['0'])){
			$updateArray['firstName'] = $itemArray['0']['firstName'];
		}
		else{
			$updateArray['firstName'] = $cartOldArray['firstName'];
		}

		if(array_key_exists("lastName",$inputArray)){
			$updateArray['lastName'] = $inputArray['lastName'];
		}
		else{
			$updateArray['lastName'] = $cartOldArray['lastName'];
		}

		if(array_key_exists("email",$inputArray)){
			$updateArray['email'] = $inputArray['email'];
		}
		else{
			$updateArray['email'] = $cartOldArray['email'];
		}

		if(array_key_exists("status",$inputArray)){
			$updateArray['status'] = $inputArray['status'];
		}
		else{
			$updateArray['status'] = $cartOldArray['status'];
		}

		return $updateArray;
	}

	//create new department
	public function createMenu($inputArray){

		//set model object
		$menuObj = new ContentManagement();
		
		$menuObj->menu_app = (isset($inputArray['menu_app'])?trim($inputArray['menu_app']):"");
		$menuObj->menu_parent = (isset($inputArray['menu_parent'])?trim($inputArray['menu_parent']):"");
		$menuObj->menu_name = (isset($inputArray['menu_name'])?trim($inputArray['menu_name']):"");
		$menuObj->menu_title = (isset($inputArray['menu_title'])?trim($inputArray['menu_title']):"");
		$menuObj->menu_desc = (isset($inputArray['menu_desc'])?trim($inputArray['menu_desc']):"");
		$menuObj->menu_sort = (isset($inputArray['menu_sort'])?trim($inputArray['menu_sort']):"");
		$menuObj->menu_visible = (isset($inputArray['menu_visible'])?trim($inputArray['menu_visible']):"");
		$menuObj->status = (isset($inputArray['status'])?trim($inputArray['status']):"");
		$menuObj->created_on = date('Y-m-d H:i:s');
		$menuObj->created_by = (isset($inputArray['create_by'])?trim($inputArray['create_by']):"0");
		$menuObj->modified_on = date('0000-00-00 00:00:00');
		$menuObj->modified_by = (isset($inputArray['modified_by'])?trim($inputArray['modified_by']):"0");

		$menuId = $menuObj->insert($menuObj);

		if($menuId){
			return $menuId;
		}
		else{
			return false;
		}
	}

	//retrieve department records info
	public function retrieveInfo($contentmanageId){
		$contentmanageObj = new ContentManagement();
		$WhrClause['id'] = $contentmanageId;
		$contentmanageModel = $contentmanageObj->retrieveById($WhrClause);
		return $contentmanageModel;
	}

	//retrieve All department records info
	public function retrieveAllContentManageInfo($params){
		$contentmanageObj = new ContentManagement();
		$resultArray = $contentmanageObj->retrieveAll($params);
		return $resultArray;
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
		$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.ticket_form.select_group_user', ['userdata' => $groupUserListArray]);
		}
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
}