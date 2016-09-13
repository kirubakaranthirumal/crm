<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\EmailTemplate;

class DeleteEmailTemplateController extends Controller{

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

		$templateValArray = array();

		$templateValArray = $emailTemplateObj->deleteById($id);

		//list data code starts here
		$successArray = $errorArray = $templateArray = array();

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

		if(!empty($templateValArray)){
			session()->put('templateDelSuc','Template has been Deleted successfully');
		}

		return view('admin.template.email_template_list',['email_template'=>$emailTemplateArray]);
	}

	//retrieve All template records info
	public function retrieveAllTemplateInfo($params){
		$templateObj = new EmailTemplate();
		$resultArray = $templateObj->retrieveAll($params);
		return $resultArray;
	}

	//delete a record
	public function deleteById($id){
		$templateObj = new EmailTemplate();
		$result = $templateObj->deleteById($id);
	}
}