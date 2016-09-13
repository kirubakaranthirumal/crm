<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\EmailTemplate;

class EmailTemplateController extends Controller{

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index(Request $request){

		Session::forget('templateUpdSuc');
		Session::forget('templateSuc');
		Session::forget('templateDelSuc');

		$successArray = $errorArray = $templateArray = array();

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
			$emailTemplateArray = $this->retrieveAllTemplateInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		//print"<pre>";
		//print_r($emailTemplateArray);
		//exit;

		return view('admin.template.email_template_list',['email_template'=>$emailTemplateArray]);
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
		$userId = $templateId = "";

		$inputArray = $request->all();

		$userId = Session::get('userId');

		if(!empty($userId)){
			$inputArray['create_by'] = $userId;
		}

		$templateId = $this->createTemplate($inputArray);

		//list data code starts here
		$successArray = $errorArray = $emailTemplateArray = array();

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
			$emailTemplateArray = $this->retrieveAllTemplateInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		$successArray =array();

		if(!empty($templateId)){
			session()->put('templateSuc','Template has been created successfully');
		}

		if(!empty($templateId)){
			return view('admin.add_email_template',['email_template'=>$emailTemplateArray]);
		}
		else{
			//throw new exception("Error while creating department",'1131');
		}
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id, Request $request){

		$templateCategory = array();

		$templateCategory[] = array("varCatId"=>"1","varCatName"=>"category1");
		$templateCategory[] = array("varCatId"=>"2","varCatName"=>"category2");
		$templateCategory[] = array("varCatId"=>"3","varCatName"=>"category3");

		$userId = Session::get('userId');

		Session::forget('templateSuc');

		$successArray = $errorArray = $emailTemplateInfo = array();

		$params = $request->all();

		try{
			$emailTemplateInfo = $this->retrieveTemplateInfo($id);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		//print"<pre>";
		//print_r($emailTemplateInfo);
		//exit;

		$emailTemplateUpdArrray = array();
		if(!empty($params['submit'])){

			$params['template_attachment'] = "1";
			$params['template_user_group'] = "1";

			$params['modified_on'] = date('Y-m-d H:i:s');
			$params['modified_by'] = $userId;

			$emailTemplateUpdArrray = SELF::updateById($id,$params);
		}

		if(!empty($emailTemplateUpdArrray)){
			session()->put('templateUpdSuc','Template has been Updated successfully');
			return view('admin.template.edit_email_template',['email_template'=>$emailTemplateInfo,'template_category'=>$templateCategory]);
		}
		else{
			return view('admin.template.edit_email_template',['email_template'=>$emailTemplateInfo,'template_category'=>$templateCategory]);
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

		echo "here2";
		exit;

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

	public function _setUpdateDefaultValues(){
		$inputArray['modified_on'] = date('Y-m-d H:i:s');
	}

	//create new template
	public function createTemplate($inputArray){

		//set model object
		$emailTemplateObj = new EmailTemplate();

		$emailTemplateObj->type_name = (isset($inputArray['template_name'])?trim($inputArray['template_name']):"");
		$emailTemplateObj->type_desc = (isset($inputArray['template_desc'])?trim($inputArray['template_desc']):"");
		$emailTemplateObj->status = (isset($inputArray['status'])?trim($inputArray['status']):"");
		$emailTemplateObj->created_on = date('Y-m-d H:i:s');
		$emailTemplateObj->created_by = (isset($inputArray['create_by'])?trim($inputArray['create_by']):"0");
		$emailTemplateObj->modified_on = date('0000-00-00 00:00:00');
		$emailTemplateObj->modified_by = (isset($inputArray['modified_by'])?trim($inputArray['modified_by']):"0");

		$emailTemplateId = $emailTemplateObj->insert($emailTemplateObj);

		if($emailTemplateId){
			return $emailTemplateId;
		}
		else{
			return false;
		}
	}

	//retrieve All template records info
	public function retrieveAllTemplateInfo($params){
		$templateObj = new EmailTemplate();
		$resultArray = $templateObj->retrieveAll($params);
		return $resultArray;
	}

	//retrieve single template records info
	public function retrieveTemplateInfo($templateId){

		$where_str_array = array();

		$where_str_array['template_id'] = $templateId;

		$templateObj = new EmailTemplate();
		$resultArray = $templateObj->retrieveByWhere($where_str_array);
		return $resultArray;
	}

	//update template details
	public function updateById($templateId, $inputArray){
		$templateObj = new EmailTemplate();
		$templateObj->updateById($templateId, $inputArray);
		return $templateObj;
	}

	//delete a record
	public function deleteById($id){
		$templateObj = new EmailTemplate();
		$result = $templateObj->deleteById($id);
	}
}