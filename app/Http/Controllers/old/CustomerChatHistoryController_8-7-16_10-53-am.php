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

		if(!empty($userId)){
			return view('admin.customer.customer_chat_history');
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

		$chatHistoryArray = $chatHistoryObj->updateStatusById($inputArray['chatId'],$inputArray);

		//print"<pre>";
		//print_r($chatHistoryArray);
		//exit;

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

		$userId = session()->get('userId');

		$chatHistoryArray = $chatHistoryObj->retrieveAll($inputArray);

		//print"<pre>";
		//print_r($chatHistoryArray);
		//exit;

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