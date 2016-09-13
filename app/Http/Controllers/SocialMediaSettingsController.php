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
use App\Status;
use App\SocialMedia;

class SocialMediaSettingsController extends Controller{

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index(Request $request){

		Session::forget('socia1Suc');
		Session::forget('socialDelSuc');

		$successArray = $errorArray = $socialArray = array();

		$inputArray = $request->all();

		try{
			$socialArray = $this->retrieveAllSocialInfo($inputArray);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		//print"<pre>";
		//print_r($socialArray);
		//exit;

		$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.users.smsettings',['social'=>$socialArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  Request  $request
	* @return Response
	*/

	public function store(Request $request){

		$successArray = $errorArray = $responseArray =  $categoryArray = array();
		$statusCode = "200";
		$status = "Success";
		$smsId = "";

		$inputArray = $request->all();

		$userId = Session::get('userId');

		if(!empty($userId)){
			$inputArray['create_by'] = $userId;
		}

		$smsId = $this->createSocialMedia($inputArray);

		//list data code starts here
		$successArray = $errorArray = $socialArray = array();

		try{
			$socialArray = $this->retrieveAllSocialInfo($inputArray);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		$successArray =array();
		if(!empty($smsId)){
			session()->put('socia1Suc','Social Media has been created successfully');
		}

		if(!empty($smsId)){
			return view('admin.users.smsettings',['social'=>$socialArray]);
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

		Session::forget('departmentSuc');

		$successArray = $errorArray = $inputArray = $socialArray = array();

		$inputArray = $request->all();

		try{
			$socialArray = $this->retrieveAllSocialInfo($inputArray);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.users.smsettings',['social'=>$socialArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  Request  $request
	* @param  int  $id
	* @return Response
	*/
	public function update(Request $request, $id){
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
	public function createSocialMedia($inputArray){

		//set model object
		$socialmediaObj = new SocialMedia();

		/*
			sms_id
			sms_type,
			sms_user_id,
			sms_user_password,
			sms_consumer_key,
			sms_consumer_secret,
			sms_access_token,
			sms_access_token_secret,
			sms_oauth_callback,
			sms_desc,
			sms_status,
			created_on,
			created_by,
			modified_on,
			modified_by
		*/


		$socialmediaObj->sms_type = (isset($inputArray['sms_type'])?trim($inputArray['sms_type']):"");
		$socialmediaObj->sms_user_id = (isset($inputArray['sms_user_id'])?trim($inputArray['sms_user_id']):"");
		$socialmediaObj->sms_user_password = (isset($inputArray['sms_user_password'])?trim($inputArray['sms_user_password']):"");
		$socialmediaObj->sms_consumer_key = (isset($inputArray['sms_consumer_key'])?trim($inputArray['sms_consumer_key']):"");
		$socialmediaObj->sms_consumer_secret = (isset($inputArray['sms_consumer_secret'])?trim($inputArray['sms_consumer_secret']):"");
		$socialmediaObj->sms_access_token = (isset($inputArray['sms_access_token'])?trim($inputArray['sms_access_token']):"");
		$socialmediaObj->sms_access_token_secret = (isset($inputArray['sms_access_token_secret'])?trim($inputArray['sms_access_token_secret']):"");
		$socialmediaObj->sms_oauth_callback = (isset($inputArray['sms_oauth_callback'])?trim($inputArray['sms_oauth_callback']):"");
		$socialmediaObj->sms_desc = (isset($inputArray['sms_desc'])?trim($inputArray['sms_desc']):"");
		$socialmediaObj->sms_status = (isset($inputArray['sms_status'])?trim($inputArray['sms_status']):"");
		$socialmediaObj->created_on = date('Y-m-d H:i:s');
		$socialmediaObj->created_by = (isset($inputArray['create_by'])?trim($inputArray['create_by']):"0");
		$socialmediaObj->modified_on = date('0000-00-00 00:00:00');
		$socialmediaObj->modified_by = (isset($inputArray['modified_by'])?trim($inputArray['modified_by']):"0");

		$smsId = $socialmediaObj->insert($socialmediaObj);

		if($smsId){
			return $smsId;
		}
		else{
			return false;
		}
	}

	//retrieve All status records info
	public function retrieveAllSocialInfo($params){
		$socialmediaObj = new SocialMedia();
		$resultArray = $socialmediaObj->retrieveAll($params);
		return $resultArray;
	}

	//delete a record
	public function deleteById($id){
		$socialmediaObj = new SocialMedia();
		$result = $socialmediaObj->deleteById($id);
	}
}