<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\EmailTemplate;

class EmailCreateTemplateController extends Controller{

	 /**
	 * Show a list of users
	 * @return \Illuminate\View\View
	 */

	public function index(){

		Session::forget('templateSuc');
		Session::forget('templateError');

		$userId = session()->get('userId');

		$templateCategory = array();

		$templateCategory[] = array("varCatId"=>"1","varCatName"=>"category1");
		$templateCategory[] = array("varCatId"=>"2","varCatName"=>"category2");
		$templateCategory[] = array("varCatId"=>"3","varCatName"=>"category3");

		//print"<pre>";
		//print_r($templateCategory);
		//exit;

		return view('admin.template.create_email_template',['template_category'=>$templateCategory]);
	}

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

		$templateCategory = array();

		$templateCategory[] = array("varCatId"=>"1","varCatName"=>"category1");
		$templateCategory[] = array("varCatId"=>"2","varCatName"=>"category2");
		$templateCategory[] = array("varCatId"=>"3","varCatName"=>"category3");

		if(!empty($templateId)){
			return view('admin.template.create_email_template',['template_category'=>$templateCategory,'email_template'=>$emailTemplateArray]);
		}
		else{
			//throw new exception("Error while creating department",'1131');
		}
	}

	//create new template
	public function createTemplate($inputArray){

		//print"<pre>";
		//print_r($inputArray);
		//exit;

		//set model object
		$emailTemplateObj = new EmailTemplate();

		$emailTemplateObj->template_cat_id = (isset($inputArray['template_category'])?trim($inputArray['template_category']):"");
		$emailTemplateObj->template_name = (isset($inputArray['template_name'])?trim($inputArray['template_name']):"");
		$emailTemplateObj->template_desc = (isset($inputArray['template_desc'])?trim($inputArray['template_desc']):"");
		$emailTemplateObj->template_from = (isset($inputArray['template_from'])?trim($inputArray['template_from']):"");
		$emailTemplateObj->template_subject = (isset($inputArray['template_subject'])?trim($inputArray['template_subject']):"");
		$emailTemplateObj->template_attachment = (isset($inputArray['template_attachment'])?trim($inputArray['template_attachment']):"");
		$emailTemplateObj->template_user_group = (isset($inputArray['template_cat_id'])?trim($inputArray['template_cat_id']):"");
		$emailTemplateObj->template_user_field = (isset($inputArray['template_user_field'])?trim($inputArray['template_user_field']):"");
		$emailTemplateObj->template_merged_fld_val = (isset($inputArray['template_merged_fld_val'])?trim($inputArray['template_merged_fld_val']):"");
		$emailTemplateObj->template_body = (isset($inputArray['template_body'])?trim($inputArray['template_body']):"");
		$emailTemplateObj->template_status = (isset($inputArray['template_status'])?trim($inputArray['template_status']):"");
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
}