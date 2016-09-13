<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\ChatHistory;

class CustomerChatHistoryController extends Controller{

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index(Request $request){

		$errorArray = $inputArray = array();

		$inputArray = $request->all();

		$userId = session()->get('userId');

		$chatHisObj = new ChatHistory();

		$chatHistoryArray = $chatHisObj->retrieveAllHistory($inputArray);

		//print"<pre>";
		//print_r($chatHistoryArray);
		//exit;

		if(!empty($userId)){
			return view('admin.customer.customer_chat_history',['chat_history' => $chatHistoryArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function custchathisupd(Request $request){

		$chatHistoryObj = new ChatHistory();

		$chatHistoryArray = array();

		$errorArray = $inputArray = array();

		$inputArray = $request->all();

		//print"<pre>";
		//print_r($inputArray);
		//exit;

		$userId = session()->get('userId');

		$chatHistoryArray = $chatHistoryObj->updateStatusById($inputArray['chatId'],$userId,$inputArray);

		return $chatHistoryArray;
	}

	public function custchathiscls(Request $request){
		
		
		
		$chatHistoryObj = new ChatHistory();
		$chatHistoryArray = array();
		$errorArray = $inputArray = array();

		$inputArray = $request->all();
		if(!empty($inputArray['file']) && count($inputArray) > 0){
			$chatFile = $inputArray['file'];
		}

		$userId = session()->get('userId');

		$chatHistoryArray = $chatHistoryObj->chatClose($chatFile);

		return $chatHistoryArray;
	}	
	

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function fetch_chat(Request $request){
		
		header('Access-Control-Allow-Origin: *');

		$chatHistoryObj = new ChatHistory();

		$chatHistoryArray = array();

		$errorArray = $inputArray = array();

		$inputArray = $request->all();
		
		//print"<pre>";
		//print_r($inputArray);
		//exit;

		$userId = session()->get('userId');

		$chatHistoryArray = $chatHistoryObj->retrieveAll($inputArray);

		//print"<pre>";
		//print_r($chatHistoryArray);
		//exit;

		return $chatHistoryArray;

	}

	public function fetch_emp_chat(Request $request){
		
		header('Access-Control-Allow-Origin: *');

		$chatHistoryObj = new ChatHistory();

		$chatHistoryArray = array();

		$errorArray = $inputArray = array();

		$inputArray = $request->all();

		$userId = session()->get('userId');

		$chatHistoryArray = $chatHistoryObj->getChatByWhere($inputArray, $userId);

		return $chatHistoryArray;		
	}

	public function fetch_on_chat(Request $request){
		
		header('Access-Control-Allow-Origin: *');
		$chatHistoryObj = new ChatHistory();
		$chatHistoryArray = $inputArray = array();
		$inputArray = $request->all();
		$userId = session()->get('userId');
		$chatHistoryArray = $chatHistoryObj->getOnChat($inputArray, $userId);
		return $chatHistoryArray;
	}
	
	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function ticket_count(Request $request){

		echo "count";
		exit;

		$errorArray = $inputArray = array();

		$inputArray = $request->all();

		$userId = session()->get('userId');
	}
}