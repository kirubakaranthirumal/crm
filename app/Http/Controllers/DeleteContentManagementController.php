<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\ContentManagement;

class DeleteContentManagementController extends Controller{

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index(Request $request){

		Session::forget('contentManageSuc');

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
			$contentManageArray = $this->retrieveAllDepartmentInfo($params);

		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		//print"<pre>";
		//print_r($contentManageArray);
		//exit;

		return view('admin.users.contentmanage',['menucontent'=>$contentManageArray]);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  Request  $request
	* @return Response
	*/

	public function store(Request $request){

		$successArray = $errorArray = $responseArray = array();
		$statusCode = "200";
		$status = "Success";
		$userId = $menuId = "";

		$inputArray = $request->all();

		$userId = Session::get('userId');

		if(!empty($userId)){
			$inputArray['modified_by'] = $userId;
		}

		//print"<pre>";
		//print_r($inputArray);
		//exit;

			$menuId = $this->createMenu($inputArray);
		

		$successArray =array();
		if(!empty($menuId)){
			session()->put('contentManageSuc','Menu has been created successfully');
		}

		if((!empty($menuId))){
			//$request->session()->flash('alert-success', 'DepartMent Created Successfully');
			//return view('admin.users.settings',['department'=>$contentManageArray]);
			//return redirect('AddDept')->withInput();
			//return redirect('admin/settings')->withInput();
			return view('admin.users.contentmanage',['menucontent'=>$contentManageArray]);
		}
		else{
			//throw new exception("Error while creating department",'1131');
		}

		//return view('adddepartment');
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id, Request $request){

		Session::forget('contentManageDelSuc');
		$userId = Session::get('userId');

		$params = $request->all();

		$setId="";
		if(!empty($params['set_id'])){
			$setId = $params['set_id'];
		}
/* 
		$setTypeId="";
		if(!empty($params['settings_type'])){
			$setTypeId = $params['settings_type'];
		}
 */
		$menuObj = new ContentManagement();


		$menuValArray  = array();
		$menuUpdArrray = array();

		if(!empty($setId)){
			if($setId=="1"){
				$menuValArray = $menuObj->deleteById($id);
			}
		}

		//list data code starts here
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

		if(!empty($menuValArray)){
			session()->put('contentManageDelSuc','Menu has been Deleted successfully');
		}


		return view('admin.users.contentmanage',['menucontent'=>$contentManageArray,'set_id'=>$setId,'menuval'=>$menuValArray]);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  Request  $request
	* @param  int  $id
	* @return Response
	*/
	public function update($id, Request $request){
		//echo "updhere4";
		//exit;
		//return view('addadminuser');
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id){}

	//set default values
	/*
	public function _setDefaultValues(){
		$inputArray['createdOn'] = date('Y-m-d H:i:s');
		$inputArray['modifiedOn'] = date('0000-00-00 00:00:00');
	}
	*/

	/*
	*validate input data for category
	*
	*@param $inputArray
	*@return throw exception on error
	*/
/* 	private function _validateInputs($inputArray){

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
	private function setUpdateFields($inputArray){

		$updateArray = array();

		if(!empty($inputArray['dept_name'])){
			$updateArray['dept_name'] = $inputArray['dept_name'];
		}

		if(!empty($inputArray['dept_desc'])){
			$updateArray['dept_desc'] = $inputArray['dept_desc'];
		}

		if(!empty($inputArray['status'])){
			$updateArray['status'] = $inputArray['status'];
		}

		return $updateArray;
	} */

/* 	//create new department
	public function createDept($inputArray){

		//set model object
		$deptObj = new Department();

		$deptObj->dept_name = (isset($inputArray['dept_name'])?trim($inputArray['dept_name']):"");
		$deptObj->dept_desc = (isset($inputArray['dept_desc'])?trim($inputArray['dept_desc']):"");
		$deptObj->status = (isset($inputArray['status'])?trim($inputArray['status']):"");
		$deptObj->created_on = date('Y-m-d H:i:s');
		$deptObj->created_by = (isset($inputArray['create_by'])?trim($inputArray['create_by']):"0");
		$deptObj->modified_on = date('0000-00-00 00:00:00');
		$deptObj->modified_by = (isset($inputArray['modified_by'])?trim($inputArray['modified_by']):"0");

		$deptId = $deptObj->insert($deptObj);

		if($deptId){
			return $deptId;
		}
		else{
			return false;
		}
	} */

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