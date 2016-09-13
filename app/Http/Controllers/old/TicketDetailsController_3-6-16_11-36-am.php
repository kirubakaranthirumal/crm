<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TicketDetailsController extends Controller
{

	public function show($id,Request $request){

		Session::forget('PostreplySuccess');
    	Session::forget('PostreplyError');


		$inputArray = $cinputArray = array();

		//$input = $request->all();
		$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['ticketId'] = $id;
		}

		if(!empty($cinputArray)){
		 $results = SELF::ShowTicketDetails("http://106.51.0.187:8090/cgwfollowon/findticket",$cinputArray);
		 $history = SELF::HistoryTicketDetails("http://106.51.0.187:8090/cgwfollowon/searchtickethistory",$cinputArray);
		}
		$ticketdata = $results;
		$historydata= $history;

		//print_r $ticketdata;
		//exit;

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		$responseArray1 = array();
	     if(!empty($history)){
			$responseArray1 = json_decode($history);
		  }

		//print"<pre>";
	   // print_r($responseArray);
		//print"<pre>";
	    //print_r($responseArray1);
		//exit;

		$userId = session()->get('userId');

		if(!empty($inputArray['submit'])){
			if(!empty($id)){
			$cinputArray['ticketId'] = $id;
		}

			if(!empty($inputArray['description1'])){
				$cinputArray['description'] = $inputArray['description1'];
			}
			if(!empty($userId)){
				$cinputArray['createdBy'] = $userId;
			}
			if(!empty($responseArray->ticketAssignedauser)){
				$cinputArray['assignedUser']=$responseArray->ticketAssignedauser;
			}
			if(!empty($inputArray['status'])){
				$cinputArray['changedTicketStatusAs'] = $inputArray['status'];
			}

			if(!empty($cinputArray)){
		 $postreply = SELF::PostReplyComments("http://106.51.0.187:8090/cgwfollowon/ticketpostreply",$cinputArray);
		}
		$reply = $postreply;
		$responseArray2 = array();
		if(!empty($postreply)){
			$responseArray2 = json_decode($postreply);
		}
		//print"<pre>";
	    //print_r($responseArray2);
		//exit;
		}
		if((!empty($responseArray2->status)) && ($responseArray2->status == "200")){
			if(!empty($responseArray2->msg)){
				//Session::flash('success', 'User successfully created.');
				Session::forget('PostreplyError');
				session()->put('PostreplySuccess','Comment has been created successfully');

				/*
				print"<pre>";
				print_r(session()->all());
				exit;
				*/

				//return view('admin.ticket_form.ticket_details');
			}
		}
		elseif((!empty($responseArray2->status)) && ($responseArray2->status == "201")){
			/*
			print"<pre>";
			print_r(session()->all());
			exit;
			*/

			Session::forget('PostreplySuccess');
			session()->put('PostreplyError','Comment unable to send successfully');
		}

		$userId = session()->get('userId');
		if(!empty($userId)){
			//return view('admin.users.user_details');
			//return view('admin.ticket_form.ticket_details')->with('ticketdata', json_decode($ticketdata, true),'historydata', json_decode($historydata, true));

			return view('admin.ticket_form.ticket_details',['ticketdata'=>$responseArray,'historydata'=>$responseArray1]);
		}
		else{
			return redirect('admin/login_user');
		}
	}



    public function ShowTicketDetails($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['ticketId'])){
			$fields['ticketId'] = $params['ticketId'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
			//echo $json_string;
		}

		$service_url = $url;

		$curl = curl_init($service_url);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept-Language: en_US')
		);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);

		$curl_response = curl_exec($curl);

		curl_close($curl);

		return $curl_response;
	}

    public function HistoryTicketDetails($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['ticketId'])){
			$fields['ticketId'] = $params['ticketId'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
			//echo $json_string;
		}

		$service_url = $url;

		$curl = curl_init($service_url);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept-Language: en_US')
		);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);

		$curl_response = curl_exec($curl);

		curl_close($curl);

		return $curl_response;
	}
	 public function PostReplyComments($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['ticketId'])){
			$fields['ticketId'] = $params['ticketId'];
		}
		if(!empty($params['createdBy'])){
			$fields['createdBy'] = $params['createdBy'];
		}
		if(!empty($params['description'])){
			$fields['description'] = $params['description'];
		}
		if(!empty($params['assignedUser'])){
			$fields['assignedUser'] = $params['assignedUser'];
		}
		if(!empty($params['changedTicketStatusAs'])){
			$fields['changedTicketStatusAs'] = $params['changedTicketStatusAs'];
		}
		if(!empty($fields)){
			$json_string = json_encode($fields);

		}

		//echo $json_string;
		//exit;

		$service_url = $url;

		$curl = curl_init($service_url);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept-Language: en_US')
		);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);

		$curl_response = curl_exec($curl);

		curl_close($curl);

		return $curl_response;
	}


}