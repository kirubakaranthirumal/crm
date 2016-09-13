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

		/* print"<pre>";
		print_r($contentManageArray);
		exit;  */

		return view('admin.users.contentmanage',['menucontent'=>$contentManageArray]);
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

	/*//retrieve All department records info
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
 */
	//update department details
	public function updateById($contentmanageId, $inputArray){
		$contentmanageObj = new ContentManagement();
		$contentmanageObj->updateById($contentmanageId, $inputArray);
	}

	//delete a record
	public function deleteById($id){
		$contentmanageObj = new ContentManagement();
		$result = $contentmanageObj->deleteById($id);
	}
}