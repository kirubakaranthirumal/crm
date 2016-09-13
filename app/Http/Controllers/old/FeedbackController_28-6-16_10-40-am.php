<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\FeedbackModel;


class FeedbackController extends Controller{

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index(Request $request){

		Session::forget('feedsendSucc');
		$successArray = $errorArray = $feedbackContentArray = array();

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
			$feedbackContentArray = $this->retrieveAllFeedbackContentInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		/* print"<pre>";
		print_r($feedbackContentArray);
		exit;  */
		
		return view('pages.feedback');
		session()->put('feedsendSucc','Feedback has been sent successfully');
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  Request  $request
	* @return Response
	*/

	public function store(Request $request){
	
		Session::forget('feedsendSucc');
		
		$statusCode = "200";
		$status = "Success";
		$userId = $feedId = "";

		$inputArray = $request->all();
			
		/* $userId = Session::get('userId'); */

	/* 	if(!empty($userId)){
			$inputArray['create_by'] = $userId;
		} */
	/* 	print"<pre>";
		print_r($inputArray);
		exit; */
		$feedId = $this->createFeedback($inputArray);
			
	    $successArray = $errorArray = $feedbackContentArray = array();
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
			$feedbackContentArray = $this->retrieveAllFeedbackContentInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}
		
	
		if((!empty($feedId))){			
			//$request->session()->flash('alert-success', 'DepartMent Created Successfully');
			//return view('admin.users.settings',['department'=>$departmentArray]);
			//return redirect('AddDept')->withInput();
			//return redirect('admin/settings')->withInput();
			//return view('admin.users.settings');
			session()->put('feedsendSucc','Feedback has been sent successfully');
			
			return view('pages.feedback');
		}
		else{				
			return view('pages.feedback');
		}
			
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id, Request $request){

		Session::forget('feedsendSucc');

		$successArray = $errorArray = $feedbackContentArray = array();

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
			$feedbackContentArray = $this->retrieveAllFeedbackContentInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		//print"<pre>";
		//print_r($departmentArray);
		//exit;

		return view('pages.feedback');
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
	public function createFeedback($inputArray){

		//set model object
		$feedObj = new FeedbackModel();
		
		$feedObj->feed_type = (isset($inputArray['feedback_type'])?trim($inputArray['feedback_type']):"");
		$feedObj->name = (isset($inputArray['name'])?trim($inputArray['name']):"");
		$feedObj->email = (isset($inputArray['email'])?trim($inputArray['email']):"");
		$feedObj->subject = (isset($inputArray['subject'])?trim($inputArray['subject']):"");
		$feedObj->mobile_no = (isset($inputArray['mobile_no'])?trim($inputArray['mobile_no']):"");
		$feedObj->message = (isset($inputArray['message'])?trim($inputArray['message']):"");
		$feedObj->status= (isset($inputArray['status'])?trim($inputArray['status']):"");
		$feedObj->created_on = date('Y-m-d H:i:s');
		$feedObj->created_by =1;
		//$feedObj->created_by = (isset($inputArray['create_by'])?trim($inputArray['create_by']):"0");
		$feedObj->modified_on = date('0000-00-00 00:00:00');
		$feedObj->modified_by = (isset($inputArray['modified_by'])?trim($inputArray['modified_by']):"0");

		$feedId = $feedObj->insert($feedObj);
		
		if($feedId){
			return $feedId;
		}
		else{
			return false;
		}
	}

	//retrieve department records info
	public function retrieveInfo($feedbackId){
		$feedcontentObj = new FeedbackModel();
		$WhrClause['id'] = $feedbackId;
		$feedcontentModel = $feedcontentObj->retrieveById($WhrClause);
		return $feedcontentModel;
	}

	//retrieve All department records info
	public function retrieveAllFeedbackContentInfo($params){
		$feedcontentObj = new FeedbackModel();
		$resultArray = $feedcontentObj->retrieveAll($params);
		return $resultArray;
	}

	//update department details
	public function updateById($feedbackId, $inputArray){
		$feedcontentObj = new FeedbackModel();
		$feedcontentObj->updateById($feedbackId, $inputArray);
	}

	//delete a record
	public function deleteById($id){
		$feedcontentObj = new FeedbackModel();
		$result = $feedcontentObj->deleteById($id);
	}
}