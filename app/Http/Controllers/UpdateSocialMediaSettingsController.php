<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Department;
use App\Category;
use App\Priority;
use App\Source;
use App\Type;
use App\SocialMedia;
use App\Status;

class UpdateSocialMediaSettingsController extends Controller{

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id, Request $request){

		Session::forget('socialUpdSuc');

		$userId = Session::get('userId');

		$inputArray = $request->all();

		$socialObj = new SocialMedia();

		$socialValArray = array();
		$socialUpdArrray = array();

		$socialValArray = $socialObj->retrieveByWhere($id);

		if(!empty($userId)){
			$inputArray['modified_by'] = $userId;
		}

		//print"<pre>";
		//print_r($params);
		//exit;

		if(!empty($inputArray['submit'])){
			$socialUpdArray = $socialObj->updateById($id,$inputArray);
		}

		/*
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
		*/








		try{
			$socialArray = $this->retrieveAllSocialInfo($id);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		if(!empty($socialUpdArray)){
			session()->put('socialUpdSuc','Social Media has been Updated successfully');
		}


		//print"<pre>";
		//print_r($socialArray);
		//exit;

		return view('admin.users.edit_smssettings',['sociallist'=>$socialArray,'social'=>$socialValArray]);
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

	//create new status
	public function createStatus($inputArray){

		//set model object
		$statusObj = new Status();

		$statusObj->status_name = (isset($inputArray['status_name'])?trim($inputArray['status_name']):"");
		$statusObj->status_desc = (isset($inputArray['status_desc'])?trim($inputArray['status_desc']):"");
		$statusObj->status = (isset($inputArray['status'])?trim($inputArray['status']):"");
		$statusObj->created_on = date('Y-m-d H:i:s');
		$statusObj->created_by = (isset($inputArray['create_by'])?trim($inputArray['create_by']):"0");
		$statusObj->modified_on = date('0000-00-00 00:00:00');
		$statusObj->modified_by = (isset($inputArray['modified_by'])?trim($inputArray['modified_by']):"0");

		$statusId = $statusObj->insert($statusObj);

		if($statusId){
			return $statusId;
		}
		else{
			return false;
		}
	}

	//retrieve All status records info
	public function retrieveAllSocialInfo($params){
		$socialObj = new SocialMedia();
		$resultArray = $socialObj->retrieveAll($params);
		return $resultArray;
	}

	//retrieve department records info
	public function retrieveInfo($socialId){
		$socialObj = new SocialMedia();
		$resultArray = $socialObj->retrieveByWhere($socialId);

		//print"<pre>";
		//print_r($resultArray);
		//exit;

		return $resultArray;
	}

	//retrieve All department records info
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

	//update department details
	public function updateById($socialId, $inputArray){
		$socialMediaObj = new SocialMedia();
		$socialMediaObj->updateById($socialId, $inputArray);
	}

	//delete a record
	public function deleteById($id){
		$departmentObj = new Department();
		$result = $departmentObj->deleteById($id);
	}
}