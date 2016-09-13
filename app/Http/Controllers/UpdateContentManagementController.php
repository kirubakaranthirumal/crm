<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\ContentManagement;

class UpdateContentManagementController extends Controller{


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
			$inputArray['create_by'] = $userId;
		}

		/* 	print"<pre>";
		print_r($inputArray);
		exit; */
		$menuId = $this->createMenu($inputArray);

		//list data code starts here
		$successArray = array();
		if(!empty($menuId)){
			session()->put('contentManageSuc','Menu has been created successfully');
		}
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

		$successArray =array();
		if(!empty($menuId)){
			session()->put('contentManageSuc','Menu has been created successfully');
		}

		if((!empty($menuId))){
			//$request->session()->flash('alert-success', 'DepartMent Created Successfully');
			//return view('admin.users.settings',['department'=>$departmentArray]);
			//return redirect('AddDept')->withInput();
			//return redirect('admin/settings')->withInput();
			//return view('admin.users.settings');

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

		Session::forget('contentManageUpdSuc');
		Session::forget('menuNameUpdateError');

		$userId = Session::get('userId');

		$params = $request->all();

		$setId="";
		if(!empty($params['set_id'])){
			$setId = $params['set_id'];
		}

		/*$setTypeId="";
		if(!empty($params['settings_type'])){
			$setTypeId = $params['settings_type'];
		}
		*/

		$menuObj = new ContentManagement();

		$menuValArray  = array();
		$menuUpdArrray = array();

		if(!empty($userId)){
			$params['modified_by'] = $userId;
		}
		else{
			$params['modified_by'] = 1;
		}

		//print"<pre>";
		//print_r($params);
		//exit;

		if(!empty($params['submit'])){

			$nameArray = array();
			$nameArray = $this->menuIsExistUpdate($params,$id);

			if(!empty($nameArray)){
				$errorArray['menuNameUpdateError'] = "Error : Menu name already exist";
				session()->put('menuNameUpdateError',"Error : Menu name already exist");
			}

			if(empty($errorArray)){
				$menuUpdArrray = $menuObj->updateById($id,$params);
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

		if(!empty($setId)){
			if($setId=="1"){
				$menuValArray = $menuObj->retrieveByWhere($id);
			}
		}

		$contentManageArray = $ParentMenuArray = array();

		try{
			$contentManageArray = $this->retrieveAllContentManageInfo($params);
			$ParentMenuArray = $this->retrieveAllContentManageParentInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		if(!empty($menuUpdArrray)){
			session()->put('contentManageUpdSuc','Menu has been Updated successfully');
		}

		if((!empty($menuId))){
			//$request->session()->flash('alert-success', 'DepartMent Created Successfully');
			//return view('admin.users.settings',['department'=>$departmentArray]);
			//return redirect('AddDept')->withInput();
			//return redirect('admin/settings')->withInput();
			return view('admin.users.contentmanage');
		}

		return view('admin.users.edit_contentmanage',['menucontent'=>$contentManageArray,'set_id'=>$setId,'menuval'=>$menuValArray,'parent_menu'=>$ParentMenuArray,'cid'=>$id]);
	}

	//to validate menu name is already exist in table
	public function menuIsExistUpdate($inputArray,$id){

		$menuObj = new ContentManagement();

		//$WhrClause = array();
		//$WhrClause['menu_name'] = $inputArray['menu_name'];

		$menuModel = $menuObj->retrieveByWhereNameUpdate($inputArray,$id);

		if($menuModel){
			return true;
		}
		else{
			return false;
		}
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
	}

	//create new department
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
	}

	//create new category
	public function createCategory($inputArray){

		//set model object
		$catObj = new Category();

		$catObj->cat_name = (isset($inputArray['cat_name'])?trim($inputArray['cat_name']):"");
		$catObj->cat_desc = (isset($inputArray['cat_desc'])?trim($inputArray['cat_desc']):"");
		$catObj->status = (isset($inputArray['status'])?trim($inputArray['status']):"");
		$catObj->created_on = date('Y-m-d H:i:s');
		$catObj->created_by = (isset($inputArray['create_by'])?trim($inputArray['create_by']):"0");
		$catObj->modified_on = date('0000-00-00 00:00:00');
		$catObj->modified_by = (isset($inputArray['modified_by'])?trim($inputArray['modified_by']):"0");

		//print"<pre>";
		//print_r($catObj);
		//exit;

		$catId = $catObj->insert($catObj);

		if($catId){
			return $catId;
		}
		else{
			return false;
		}
	}

	//create new priority
	public function createPriority($inputArray){

		//set model object
		$priorObj = new Priority();

		$priorObj->priority_name = (isset($inputArray['priority_name'])?trim($inputArray['priority_name']):"");
		$priorObj->priority_desc = (isset($inputArray['priority_desc'])?trim($inputArray['priority_desc']):"");
		$priorObj->status = (isset($inputArray['status'])?trim($inputArray['status']):"");
		$priorObj->created_on = date('Y-m-d H:i:s');
		$priorObj->created_by = (isset($inputArray['create_by'])?trim($inputArray['create_by']):"0");
		$priorObj->modified_on = date('0000-00-00 00:00:00');
		$priorObj->modified_by = (isset($inputArray['modified_by'])?trim($inputArray['modified_by']):"0");

		//print"<pre>";
		//print_r($priorObj);
		//exit;

		$priorId = $priorObj->insert($priorObj);

		if($priorId){
			return $priorId;
		}
		else{
			return false;
		}
	}

	//create new source
	public function createSource($inputArray){

		//set model object
		$sourceObj = new Source();

		$sourceObj->source_name = (isset($inputArray['source_name'])?trim($inputArray['source_name']):"");
		$sourceObj->source_desc = (isset($inputArray['source_desc'])?trim($inputArray['source_desc']):"");
		$sourceObj->status = (isset($inputArray['status'])?trim($inputArray['status']):"");
		$sourceObj->created_on = date('Y-m-d H:i:s');
		$sourceObj->created_by = (isset($inputArray['create_by'])?trim($inputArray['create_by']):"0");
		$sourceObj->modified_on = date('0000-00-00 00:00:00');
		$sourceObj->modified_by = (isset($inputArray['modified_by'])?trim($inputArray['modified_by']):"0");

		//print"<pre>";
		//print_r($sourceObj);
		//exit;

		$sourceId = $sourceObj->insert($sourceObj);

		if($sourceId){
			return $sourceId;
		}
		else{
			return false;
		}
	}

	//create new type
	public function createType($inputArray){

		//set model object
		$typeObj = new Type();

		$typeObj->type_name = (isset($inputArray['type_name'])?trim($inputArray['type_name']):"");
		$typeObj->type_desc = (isset($inputArray['type_desc'])?trim($inputArray['type_desc']):"");
		$typeObj->status = (isset($inputArray['status'])?trim($inputArray['status']):"");
		$typeObj->created_on = date('Y-m-d H:i:s');
		$typeObj->created_by = (isset($inputArray['create_by'])?trim($inputArray['create_by']):"0");
		$typeObj->modified_on = date('0000-00-00 00:00:00');
		$typeObj->modified_by = (isset($inputArray['modified_by'])?trim($inputArray['modified_by']):"0");

		$typeId = $typeObj->insert($typeObj);

		if($typeId){
			return $typeId;
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

	//retrieve All department records info
	public function retrieveAllContentManageParentInfo($params){
		$contentmanageObj = new ContentManagement();
		$resultArray = $contentmanageObj->retrieveAllParentMenu($params);
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