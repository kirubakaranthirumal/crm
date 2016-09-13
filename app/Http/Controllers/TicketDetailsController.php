<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Department;
use App\SmtpMail;

class TicketDetailsController extends Controller{

	public function show($id,Request $request){

		Session::forget('PostreplySuccess');
    	Session::forget('PostreplyError');
		Session::forget('ReassignSuccess');
		Session::forget('ReassignError');

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

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print"<pre>";
		//print_r($responseArray);
		//exit;

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

		$status=array();

		$statusArray = $this->retrieveAllActiveStatusInfo($inputArray);

		if(!empty($statusArray)){
			foreach($statusArray as $statusVal){
				$status[] = $statusVal;
			}
		}

		$historyDetailArray = array();
		if(!empty($responseArray1->ticketList)){
			foreach($responseArray1->ticketList as $responseVal1){
				$historyDetailArray[] = $responseVal1;
			}
		}

		//print"<pre>";
		//print_r($inputArray);
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

			$smtpObj = new SmtpMail();

			$ticketId = "";
			if(!empty($id)){
				$ticketId = $id;
			}

			$to="";
			if(!empty($ticketDetailArray->requester_email)){
				$to = $ticketDetailArray->requester_email;

				$name = "";
				if(!empty($ticketDetailArray->requestorName)){
					$name = $ticketDetailArray->requestorName;
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

			//include('smtpwork.php');
			//exit;
		}

		//Reassign
		if(!empty($inputArray['reassign_submit'])){

			if(!empty($id)){
				$cinputArray['ticketId'] = $id;
			}

			if(!empty($ticketDetailArray->portalUserEmailId)){
				$cinputArray['portalUserEmailId'] = $ticketDetailArray->portalUserEmailId;
			}
			else{
				$cinputArray['portalUserEmailId'] = "";
			}

			if(!empty($inputArray['group'])){
				$cinputArray['ticketGroupId'] = $inputArray['group'];
			}

			if(!empty($inputArray['employee'])){
				$cinputArray['ticketAssignedUser'] = $inputArray['employee'];
			}

			if(!empty($inputArray['re_status'])){
				$cinputArray['status'] = $inputArray['re_status'];
			}

			if(!empty($inputArray['reassign_desc'])){
				$cinputArray['comments'] = $inputArray['reassign_desc'];
			}

			if(!empty($inputArray['deadline'])){
				$cinputArray['deadLine'] = $inputArray['deadline'];
			}
			
			$cinputArray['notificationStatus'] = "1";
			
			if(!empty($userId)){
				$cinputArray['modifiedBy'] = $userId;
			}

			//print"<pre>";
			//print_r($cinputArray);
			//exit;

			$reassign = "";
			if(!empty($cinputArray)){
				$reassign = SELF::ReAssignTicket("http://106.51.0.187:8090/cgwfollowon/ticketreassign",$cinputArray);
			}

			$reply = $reassign;
			$responseArray3 = array();
			if(!empty($reassign)){
				$responseArray3 = json_decode($reassign);
			}

			//print"<pre>";
			//print_r($responseArray3);
			//exit;
		}

		$departmentArray = $department = array();

		try{
			$departmentArray = $this->retrieveAllDepartmentInfo($inputArray);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		if(!empty($departmentArray)){
			foreach($departmentArray as $deptVal){
				$department[] = $deptVal;
			}
		}

		//print"<pre>";
		//print_r($responseArray);
		//exit;
		/*
		print"<pre>";
		print_r(session()->all());
		exit;
		*/

		if((!empty($responseArray2->status)) && ($responseArray2->status == "200")){
			if(!empty($responseArray2->msg)){
				//Session::flash('success', 'User successfully created.');
				Session::forget('PostreplyError');
				session()->put('PostreplySuccess','Comment has been created successfully');
				//return view('admin.ticket_form.ticket_details');
			}
		}
		elseif((!empty($responseArray2->status)) && ($responseArray2->status == "201")){
			Session::forget('PostreplySuccess');
			session()->put('PostreplyError','Comment unable to send successfully');
		}

		if((!empty($responseArray3->status)) && ($responseArray3->status == "200")){
			if(!empty($responseArray3->msg)){
				//Session::flash('success', 'User successfully created.');
				Session::forget('PostreplyError');
				Session::forget('PostreplySuccess');
				Session::forget('ReassignError');
				session()->put('ReassignSuccess','Comment has been created successfully');
				//return view('admin.ticket_form.ticket_details');
			}
		}
		elseif((!empty($responseArray3->status)) && ($responseArray3->status == "201")){
			Session::forget('PostreplyError');
			Session::forget('PostreplySuccess');
			Session::forget('ReassignSuccess');
			session()->put('ReassignError','Comment unable to send successfully');
		}

		$userId = session()->get('userId');
		if(!empty($userId)){
			return view('admin.ticket_form.ticket_details',['ticketdata'=>$ticketDetailArray,'historydata'=>$historyDetailArray,'status'=>$status,'department'=>$department]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	public function ReAssignTicket($url,$params){

		$json_string = '';

		if(!empty($params['ticketId'])){
			$fields['ticketId'] = $params['ticketId'];
		}

		if(!empty($params['ticketGroupId'])){
			$fields['ticketGroupId'] = $params['ticketGroupId'];
		}

		if(!empty($params['ticketAssignedUser'])){
			$fields['ticketAssignedUser'] = $params['ticketAssignedUser'];
		}

		if(!empty($params['portalUserEmailId'])){
			$fields['portalUserEmailId'] = $params['portalUserEmailId'];
		}
		else{
			$fields['portalUserEmailId'] = "admin@nutech.com";
		}

		if(!empty($params['status'])){
			$fields['status'] = $params['status'];
		}

		if(!empty($params['comments'])){
			$fields['comments'] = $params['comments'];
		}

		if(!empty($params['deadline'])){
			$fields['deadline'] = $params['deadline'];
		}

		if(!empty($params['modifiedBy'])){
			$fields['modifiedBy'] = $params['modifiedBy'];
		}

		if(!empty($params['deadLine'])){
			$fields['deadLine'] = $params['deadLine'];
		}
		
		$fields['notificationStatus'] = $params['notificationStatus'];

		if(!empty($fields)){
			$json_string = json_encode($fields);
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

		//echo $curl_response;
		//exit;

		curl_close($curl);

		return $curl_response;
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

	//retrieve All type records info
	public function retrieveAllActiveStatusInfo($params){
		$statusObj = new Status();
		$resultArray = $statusObj->retrieveAllActive($params);
		return $resultArray;
	}

	public function retrieveAllDepartmentInfo($params){
		$departmentObj = new Department();
		$resultArray = $departmentObj->retrieveAll($params);
		return $resultArray;
	}
}