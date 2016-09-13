<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\SmtpMail;

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

		print"<pre>";
		print_r($results);
		exit;

		$ticketdata = $results;
		$historydata= $history;

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		$responseArray1 = array();
		if(!empty($history)){
			$responseArray1 = json_decode($history);
		}

		$ticketDetailArray = array();
		if(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseVal){
				$ticketDetailArray = $responseVal;
			}
		}

		//print"<pre>";
		//print_r($ticketDetailArray);
		//exit;

		//print"<pre>";
		//print_r($responseArray);
		//print"<pre>";
		//print_r($ticketDetailArray);
		//exit;

		$historyDetailArray = array();
		if(!empty($responseArray1->ticketList)){
			foreach($responseArray1->ticketList as $responseVal1){
				$historyDetailArray = $responseVal1;
			}
		}

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


			$smtpObj = new SmtpMail();

			$ticketId = "";
			if(!empty($id)){
				$ticketId = $id;
			}

			print"<pre>";
			print_r($ticketDetailArray);
			exit;

			$to="";
			if(!empty($ticketDetailArray['requester_email'])){
				$to = $ticketDetailArray['requester_email'];

				$name = "";
				if(!empty($ticketDetailArray['requestorName'])){
					$name = $ticketDetailArray['requestorName'];
				}

				$from = "support@cricketgateway.com";
				$subject = "Regarding ticket update notification";

				$message = "<html><body>";
				$message .= "<table style=\"border-color: #666;border:0px;\" cellpadding=\"10\">";
				$message .= "<tr style=\"background: #eee;\"><td><strong><center>Ticket Update Notification</center></strong></td></tr>";
				$message .= "<tr><td> Hi <strong>".$name."</strong>, </td></tr>";
				$message .= "<tr><td><span style=\"padding:50px;\"> We updated your ticket. You will be intimated once the ticket have been fixed. Yout Ticket ID is <strong>".$ticketId."</strong></span></td></tr>";
				$message .= "<tr><td>Thanks Regards<br>Follow On</td></tr>";
				$message .= "</table>";
				$message .= "</body></html>";
			}

			//echo $message;
			//exit;

			include('smtpwork.php');
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
			//return view('admin.ticket_form.ticket_details')->with('ticketdata', $ticketDetailArray,'historydata', $historyDetailArray);

			return view('admin.ticket_form.ticket_details',['ticketdata'=>$ticketDetailArray,'historydata'=>$responseArray1]);
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