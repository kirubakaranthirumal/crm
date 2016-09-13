<?php
namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Department;
use App\Category;
use App\Priority;
use App\Source;
use App\Type;
use App\Status;
use App\SmtpMail;

class InternalUserSendMailController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(Request $request){

    	Session::forget('mailSendSuccess');
		Session::forget('mailSendError');

    	$inputArray = $request->all();

    	$userId = session()->get('userId');

		$departmentArray = array();

		try{
			//$departmentArray = $this->retrieveAllDepartmentInfo($inputArray);
			$departmentArray = $this->retrieveAllActiveDepartmentInfo($inputArray);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		$groupArray = array();
		if(!empty($departmentArray)){
			foreach($departmentArray as $departmentVal){
				$groupArray[] = $departmentVal;
			}
		}

		if(!empty($userId)){
			return view('admin.users.internal_users_compose_mail',['department' => $groupArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  Request  $request
	* @return Response
	*/

	public function store(Request $request){

		$emailArr = array();
		$inputArray = $request->all();

		$userId = session()->get('userId');

		//print"<pre>";
		//print_r($inputArray);
		//exit;

		$from = session()->get('email');

		$subject = "";
		if(!empty($inputArray['comSubject'])){
			$subject = $inputArray['comSubject'];
		}

		$message = "";
		if(!empty($inputArray['editor'])){
			$message = $inputArray['editor'];
		}

		$to="";
		$mailType="";
		if(!empty($inputArray['employee'])){
			$to = $inputArray['employee'];
			$emailArr[] = $to;
			$mailType="1";
		}
		else{
			$emailGroup = array('groupId'=> $inputArray['group']);
			$emailArr = SELF::load_group_user_email($emailGroup);
			$mailType="2";
		}

		//print"<pre>";
		//print_r($emailArr);
		//exit;

		if(!empty($mailType)){
			$mailinputArray['mailType'] = $mailType;
			if($mailType==1){
				if(!empty($emailArr['0'])){
					$mailinputArray['toAddress'] = $emailArr['0'];
				}
			}
			elseif($mailType==2){
				if(!empty($emailArr)){
					$mailinputArray['multipleAdd'] = $emailArr;
				}
			}
		}

		if(!empty($from)){
			$mailinputArray['fromAddress'] = $from;
		}

		if(!empty($message)){
			$mailinputArray['message'] = $message;
		}

		if(!empty($subject)){
			$mailinputArray['subject'] = $subject;
		}

		$sendmailresult="";
		if(!empty($mailinputArray)){
			$sendmailresult = SELF::send_email("http://106.51.0.187:8090/cgwfollowon/sendmail",$mailinputArray);
		}

		$responseArray = array();
		if(!empty($sendmailresult)){
			$responseArray = json_decode($sendmailresult);
		}

		//print"<pre>";
		//print_r($mailinputArray);
		//exit;

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			session()->put('mailSendSuccess','Mail sent successfully');
			//echo "Message sent to $to OK.\n";
			//exit;
		}
		else{
			session()->put('mailSendError','Error sending mail');
			//echo "Cound not send the message to $to.\nError: ";
			//exit;
		}

		$departmentArray = array();

		$departmentArray = $this->retrieveAllActiveDepartmentInfo($inputArray);

		$groupArray = array();
		if(!empty($departmentArray)){
			foreach($departmentArray as $departmentVal){
				$groupArray[] = $departmentVal;
			}
		}

		if(!empty($userId)){
			return view('admin.users.internal_users_compose_mail',['department' => $groupArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	public function send_email($url,$inputArray){

		$json_string = '';
		if(!empty($inputArray['mailType'])){
			$fields['mailType'] = $inputArray['mailType'];
		}

		if(!empty($inputArray['fromAddress'])){
			$fields['fromAddress'] = $inputArray['fromAddress'];
		}

		if(!empty($inputArray['message'])){
			$fields['message'] = $inputArray['message'];
		}

		if(!empty($inputArray['subject'])){
			$fields['subject'] = $inputArray['subject'];
		}
		else{
			$fields['subject'] = "Subject";
		}

		if(!empty($inputArray['multipleAdd'])){
			$fields['multipleAdd'] = $inputArray['multipleAdd'];
		}
		elseif(!empty($inputArray['toAddress'])){
			$fields['toAddress'] = $inputArray['toAddress'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}

		//echo $json_string;
		//exit;

		//print"<pre>";
		//print_r($inputArray);
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

		//echo $curl_response;
		//exit;

		curl_close($curl);

		return $curl_response;
	}

	public function retrieveAllDepartmentInfo($params){
		$departmentObj = new Department();
		$resultArray = $departmentObj->retrieveAll($params);
		return $resultArray;
	}

	public function retrieveAllActiveDepartmentInfo(){
		$departmentObj = new Department();
		$resultArray = $departmentObj->retrieveAllActive();
		return $resultArray;
	}

	public function ListAppPost($url,$params){

		$json_string = '';

		if(!empty($params['userSesId'])){
			$fields['userSesId'] = $params['userSesId'];
		}

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

		curl_close($curl);

		return $curl_response;
	}
	public function load_group_user_email($inputArray){

		if(!empty($inputArray['groupId'])){
			$results = SELF::loadEmpGroupId("http://106.51.0.187:8090/cgwfollowon/findcrmgroupusers",$inputArray);
		}

		$responseArray = $groupEmailListArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		if(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseVal){
				$groupEmailListArray[] = $responseVal->email;
			}
		}
		return $groupEmailListArray;
	}

	 public function loadEmpGroupId($url,$params){

		$json_string = '';

		if(!empty($params['groupId'])){
			$fields['groupId'] = $params['groupId'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}

		//$json_string = '{"groupId":"1"}';

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
