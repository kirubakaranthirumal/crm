<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\EmailTemplate;

class EmailTemplateDetailController extends Controller{

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id, Request $request){

		Session::forget('templateDelSuc');

		$userId = Session::get('userId');

		$params = $request->all();

		$emailTemplateObj = new EmailTemplate();

		try{
			$emailTemplateArray = $this->retrieveTemplateInfo($id);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		if(!empty($userId)){
			return view('admin.template.template_details',['email_template'=>$emailTemplateArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	//retrieve single template records info
	public function retrieveTemplateInfo($templateId){
		$where_str_array = array();
		$where_str_array['template_id'] = $templateId;
		$templateObj = new EmailTemplate();
		$resultArray = $templateObj->retrieveByWhere($where_str_array);
		return $resultArray;
	}

	//delete a record
	public function deleteById($id){
		$templateObj = new EmailTemplate();
		$result = $templateObj->deleteById($id);
	}
}