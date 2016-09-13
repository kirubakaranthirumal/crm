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

class TicketsController extends Controller{

	 /**
	 * Show a list of users
	 * @return \Illuminate\View\View
	 */

	public function index(Request $request){

		Session::forget('ticketSuccess');
		Session::forget('ticketError');

		Session::forget('departmentSuc');
		Session::forget('categorySuc');
		Session::forget('prioritySuc');
		Session::forget('sourceSuc');
		Session::forget('typeSuc');

		Session::forget('departmentDelSuc');
		Session::forget('categoryDelSuc');
		Session::forget('priorityDelSuc');
		Session::forget('sourceDelSuc');
		Session::forget('typeDelSuc');

		$successArray = $errorArray = $departmentArray = $categoryArray = $priorityArray = $sourceArray = $typeArray = array();
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
			$departmentArray = $this->retrieveAllActiveDepartmentInfo($params);
			$categoryArray = $this->retrieveAllActiveCategoryInfo($params);
			$priorityArray = $this->retrieveAllActivePriorityInfo($params);
			$sourceArray = $this->retrieveAllActiveSourceInfo($params);
			$typeArray = $this->retrieveAllActiveTypeInfo($params);
			$statusArray = $this->retrieveAllActiveStatusInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		$department=array();
		$category=array();
		$priority=array();
		$source=array();
		$type=array();
		$status=array();

		if(!empty($departmentArray)){
			foreach($departmentArray as $deptVal){
				$department[] = $deptVal;
			}
		}

		if(!empty($categoryArray)){
			foreach($categoryArray as $categoryVal){
				$category[] = $categoryVal;
			}
		}

		if(!empty($priorityArray)){
			foreach($priorityArray as $priorityVal){
				$priority[] = $priorityVal;
			}
		}

		if(!empty($sourceArray)){
			foreach($sourceArray as $sourceVal){
				$source[] = $sourceVal;
			}
		}

		if(!empty($typeArray)){
			foreach($typeArray as $typeVal){
				$type[] = $typeVal;
			}
		}

		if(!empty($statusArray)){
			foreach($statusArray as $statusVal){
				$status[] = $statusVal;
			}
		}

		/* 	 print"<pre>";
		print_r($type);
		exit; */

		$userId = session()->get('userId');

		$cinputArray = $appResponseArray = array();

		$cinputArray['userSesId'] = 1;

		$appresults = "";
		if(!empty($cinputArray)){
			$appresults = SELF::ListAppPost("http://106.51.0.187:8090/cgwfollowon/listapp",$cinputArray);
		}

		if(!empty($appresults)){
			$appResponseArray = json_decode($appresults);
		}

		$appListArray = array();
		if(!empty($appResponseArray->AppDetails)){
			foreach($appResponseArray->AppDetails as $responseVal){
				$appListArray[] = $responseVal;
			}
		}

		//print"<pre>";
		//print_r($status);
		//exit;

		if(!empty($userId)){
			return view('admin.ticket_form.add_tickets',['app_data'=>$appListArray,'department'=>$department,'category'=>$category,'type'=>$type,'priority'=>$priority,'source'=>$source,'status'=>$status]);
		}
		else{
			return redirect('admin/login_user');
		}
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

	public function store(Request $request){

		$message = $upload_path = "";
		$input = $request->all();

		$appinputArray = $appResponseArray = array();

		$appinputArray['userSesId'] = 1;

		$appresults = "";
		if(!empty($appinputArray)){
			$appresults = SELF::ListAppPost("http://106.51.0.187:8090/cgwfollowon/listapp",$appinputArray);
		}

		//print_r($appresults);
		//exit;

		if(!empty($appresults)){
			$appResponseArray = json_decode($appresults);
		}

		$appListArray = array();
		if(!empty($appResponseArray->AppDetails)){
			foreach($appResponseArray->AppDetails as $responseVal){
				$appListArray[] = $responseVal;
			}
		}

		$inputArray = $cinputArray = array();

		$inputArray = $request->all();

		/*
		print"<pre>";
		print_r($inputArray);
		print_r($_FILES);
		exit;
		*/

		//print"<pre>";
		//print_r($inputArray);
		//exit;

		//echo rand();
		//exit;
?>
<?php

		$file_ext_array = array();
		$extensions = "";

		$departmentArray = $this->retrieveAllActiveDepartmentInfo($input);
		$categoryArray = $this->retrieveAllActiveCategoryInfo($input);
		$priorityArray = $this->retrieveAllActivePriorityInfo($input);
		$sourceArray = $this->retrieveAllActiveSourceInfo($input);
		$typeArray = $this->retrieveAllActiveTypeInfo($input);
		$statusArray = $this->retrieveAllActiveStatusInfo($input);

		$department=array();
		$category=array();
		$priority=array();
		$source=array();
		$type=array();
		$status=array();

		if(!empty($departmentArray)){
			foreach($departmentArray as $deptVal){
				$department[] = $deptVal;
			}
		}

		if(!empty($categoryArray)){
			foreach($categoryArray as $categoryVal){
				$category[] = $categoryVal;
			}
		}

		if(!empty($priorityArray)){
			foreach($priorityArray as $priorityVal){
				$priority[] = $priorityVal;
			}
		}

		if(!empty($sourceArray)){
			foreach($sourceArray as $sourceVal){
				$source[] = $sourceVal;
			}
		}

		if(!empty($typeArray)){
			foreach($typeArray as $typeVal){
				$type[] = $typeVal;
			}
		}

		if(!empty($statusArray)){
			foreach($statusArray as $statusVal){
				$status[] = $statusVal;
			}
		}

		if(isset($_FILES['ticket_attachment'])){

			$errors = array();

			//$file_name = $_FILES['ticket_attachment']['name'];

			$file_size =$_FILES['ticket_attachment']['size'];
			$file_tmp =$_FILES['ticket_attachment']['tmp_name'];
			$file_type=$_FILES['ticket_attachment']['type'];

			$file_ext_array = explode('.',$_FILES['ticket_attachment']['name']);

			if(!empty($file_ext_array['1'])){
				$file_ext = $file_ext_array['1'];
				$file_name = rand().".".$file_ext;

				$upload_path = "upload/tickets/";

				$extensions = array("jpeg","jpg","png","doc","docx");

				if(in_array($file_ext,$extensions)=== false){
					$errors[] = "extension not allowed";
				}

				if($file_size > 2097152){
					$errors[]='File size must be excately 2 MB';
				}

				if(empty($errors)==true){
					move_uploaded_file($file_tmp,$upload_path.$file_name);
				}
			}
		}

		$uploadError = array();

		//print"<pre>";
		//print_r($inputArray);
		//exit;

		if(empty($errors)){

			if(
				(!empty($inputArray['requester_name']))
				&&
				(!empty($inputArray['requester_email']))
				&&
				(!empty($inputArray['subject']))
				&&
				(!empty($inputArray['source']))
				&&
				(!empty($inputArray['category']))
				&&
				(!empty($inputArray['status']))
				&&
				(!empty($inputArray['priority']))
				&&
				(!empty($inputArray['group']))
				&&
				(!empty($inputArray['type']))
				&&
				(!empty($inputArray['employee']))
				&&
				(!empty($inputArray['editor']))
			 ){

			 	//echo "here2";
			 	//exit;

			 	if(!empty($inputArray['application'])){
					$cinputArray['appId'] = $inputArray['application'];
				}

				if(!empty($inputArray['event'])){
					$cinputArray['eventId'] = $inputArray['event'];
				}

				if(!empty($inputArray['requester_name'])){
					$cinputArray['requestorName'] = $inputArray['requester_name'];
				}

				if(!empty($inputArray['requester_email'])){
					$cinputArray['portalUserEmailId'] = $inputArray['requester_email'];
				}

				if(!empty($inputArray['subject'])){
					$cinputArray['ticketSubject'] = $inputArray['subject'];
				}

				if(!empty($inputArray['source'])){
					$cinputArray['ticketSource'] = $inputArray['source'];
				}

				if(!empty($inputArray['category'])){
					$cinputArray['ticketCatId'] = $inputArray['category'];
				}

				if(!empty($inputArray['status'])){
					$cinputArray['status'] = $inputArray['status'];
				}

				if(!empty($inputArray['priority'])){
					$cinputArray['priority'] = $inputArray['priority'];
				}

				if(!empty($inputArray['group'])){
					$cinputArray['ticketGroupId'] = $inputArray['group'];
				}

				if(!empty($inputArray['type'])){
					$cinputArray['type'] = $inputArray['type'];
				}

				if(!empty($inputArray['employee'])){
					$cinputArray['ticketAssignedUser'] = $inputArray['employee'];
				}

				//print"<pre>";
				//print_r($inputArray);
				//exit;

				if(!empty($inputArray['editor'])){
					$cinputArray['ticketText'] = $inputArray['editor'];
				}

				if(!empty(session()->get('userId'))){
					$cinputArray['createdBy'] = session()->get('userId');
				}

				if(!empty($file_name)){
					$cinputArray['attachmentUrl'] = $file_name;
				}

				if(!empty($inputArray['deadline'])){
					$cinputArray['deadLine'] = $inputArray['deadline'];
				}

				//print"<pre>";
				//print_r($cinputArray);
				//exit;

				$results = SELF::AddTicketPost("http://106.51.0.187:8090/cgwfollowon/createtickets",$cinputArray);
			}
		}
		else{
			$uploadError = $errors;
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print_r(explode("@",$inputArray['requester_name']));

		//print"<pre>";
		//print_r($responseArray);
		//exit;

		$smtpObj = new SmtpMail();

		//print"<pre>";
		//print_r($smtpObj);
		//exit;

		$ticketId = "";
		if(!empty($responseArray->TicketId)){
			$ticketId = $responseArray->TicketId;
		}

		//print"<pre>";
		//print_r($results);
		//exit;

		/*
		$ticketinputArray = array();
		if(!empty($ticketId)){
			$ticketinputArray['ticketId'] = $ticketId;
		}

		$ticketresults = "";
		if(!empty($ticketinputArray)){
			$ticketresults = SELF::ShowTicketDetails("http://106.51.0.187:8090/cgwfollowon/findticket",$ticketinputArray);
		}

		$tckdetailresponseArray = array();
		if(!empty($ticketresults)){
			$tckdetailresponseArray = json_decode($ticketresults);
		}

		$ticketDetailArray = array();
		if(!empty($tckdetailresponseArray->ticketList)){
			foreach($tckdetailresponseArray->ticketList as $responseVal){
				$ticketDetailArray = $responseVal;
			}
		}

		$user_name = "";
		$user_name_array = array();
		if(!empty($inputArray['requester_name'])){
			$user_name_array = explode("@",$inputArray['requester_name']);
		}
		*/

		$to="";
		if(!empty($inputArray['requester_email'])){
			$to = $inputArray['requester_email'];

			$name = "";
			if(!empty($inputArray['requester_name'])){
				$name = $inputArray['requester_name'];
			}

			$from = "support@cricketgateway.com";
			$subject = "Regarding ticket created notification";

			$message = "<html><body>";
			$message .= "<table style=\"border-color: #666;border:0px;\" cellpadding=\"10\">";
			$message .= "<tr style=\"background: #eee;\"><td><strong><center>Ticket Create Notification</center></strong></td></tr>";
			$message .= "<tr><td> Hi <strong>".$name."</strong>, </td></tr>";
			$message .= "<tr><td><span style=\"padding:50px;\"> We created a ticket based on the issue you have raised us. You will be intimated once the ticket have been fixed. Yout Ticket ID is <strong>".$ticketId."</strong></span></td></tr>";
			$message .= "<tr><td>Thanks Regards<br>Follow On</td></tr>";
			$message .= "</table>";
			$message .= "</body></html>";

			//$message = "Hi ".$name."<br><br><span> We created a ticket based on the issue you have raised us. You will be intimated once the ticket have been fixed. Yout Ticket ID is <bold>".$ticketId."</bold><br><br>";
			//$message .= "Thanks Regards<br>.";
			//$message .= "Follow On";
		}

		//echo $message;
		//exit;

		include('smtpwork.php');
		//exit;

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				Session::forget('ticketError');
				session()->put('ticketSuccess','Ticket has been created successfully');
				return view('admin.ticket_form.add_tickets',['app_data'=>$appListArray]);
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
			Session::forget('ticketSuccess');
			session()->put('ticketError','Cannot create ticket');
		}

		$userId = session()->get('userId');
		if(!empty($userId)){
			return view('admin.ticket_form.add_tickets',['upload_error'=>$uploadError,'app_data'=>$appListArray]);
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

     public function AddTicketPost($url,$params){

		$json_string = '';

		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
		}

		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
		}

		if(!empty($params['requestorName'])){
			$fields['requestorName'] = $params['requestorName'];
		}

		if(!empty($params['portalUserEmailId'])){
			$fields['portalUserEmailId'] = $params['portalUserEmailId'];
		}

		if(!empty($params['ticketSubject'])){
			$fields['ticketSubject'] = $params['ticketSubject'];
		}

		if(!empty($params['ticketSource'])){
			$fields['ticketSource'] = $params['ticketSource'];
		}

		if(!empty($params['ticketCatId'])){
			$fields['ticketCatId'] = $params['ticketCatId'];
		}

		if(!empty($params['status'])){
			$fields['status'] = $params['status'];
		}

		if(!empty($params['priority'])){
			$fields['priority'] = $params['priority'];
		}

		if(!empty($params['ticketGroupId'])){
			$fields['ticketGroupId'] = $params['ticketGroupId'];
		}

		if(!empty($params['type'])){
			$fields['type'] = $params['type'];
		}

		if(!empty($params['ticketAssignedUser'])){
			$fields['ticketAssignedUser'] = $params['ticketAssignedUser'];
		}

		if(!empty($params['ticketText'])){
			$fields['ticketText'] = $params['ticketText'];
		}

		if(!empty($params['createdBy'])){
			$fields['createdBy'] = $params['createdBy'];
		}

		if(!empty($params['attachmentUrl'])){
			$fields['attachmentUrl'] = $params['attachmentUrl'];
		}

		if(!empty($params['deadLine'])){
			$fields['deadLine'] = $params['deadLine'];
		}

		$fields['portelUserId'] = "0";
		$fields['modifiedBy'] = "0";

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
	public function retrieveAllDepartmentInfo($params){
		$departmentObj = new Department();
		$resultArray = $departmentObj->retrieveAll($params);
		return $resultArray;
	}

	//retrieve All department records info
	public function retrieveAllCategoryInfo($params){
		$categoryObj = new Category();
		$resultArray = $categoryObj->retrieveAll($params);
		return $resultArray;
	}

	//retrieve All priority records info
	public function retrieveAllPriorityInfo($params){
		$priorityObj = new Priority();
		$resultArray = $priorityObj->retrieveAll($params);
		return $resultArray;
	}

	//retrieve All source records info
	public function retrieveAllSourceInfo($params){
		$sourceObj = new Source();
		$resultArray = $sourceObj->retrieveAll($params);
		return $resultArray;
	}

	//retrieve All type records info
	public function retrieveAllTypeInfo($params){
		$typeObj = new Type();
		$resultArray = $typeObj->retrieveAll($params);
		return $resultArray;
	}

	public function retrieveAllActiveDepartmentInfo(){
		$departmentObj = new Department();
		$resultArray = $departmentObj->retrieveAllActive();
		return $resultArray;
	}

	//retrieve All department records info
	public function retrieveAllActiveCategoryInfo($params){
		$categoryObj = new Category();
		$resultArray = $categoryObj->retrieveAllActive($params);
		return $resultArray;
	}

	//retrieve All priority records info
	public function retrieveAllActivePriorityInfo($params){
		$priorityObj = new Priority();
		$resultArray = $priorityObj->retrieveAllActive($params);
		return $resultArray;
	}

	//retrieve All source records info
	public function retrieveAllActiveSourceInfo($params){
		$sourceObj = new Source();
		$resultArray = $sourceObj->retrieveAllActive($params);
		return $resultArray;
	}

	//retrieve All type records info
	public function retrieveAllActiveTypeInfo($params){
		$typeObj = new Type();
		$resultArray = $typeObj->retrieveAllActive($params);
		return $resultArray;
	}

	//retrieve All type records info
	public function retrieveAllActiveStatusInfo($params){
		$statusObj = new Status();
		$resultArray = $statusObj->retrieveAllActive($params);
		return $resultArray;
	}

	public function load_group_user(Request $request){

		$message = '';

		$inputArray = $cinputArray = array();

		$inputArray = $request->all();

		if(!empty($inputArray['groupId'])){
			$results = SELF::loadEmpByGroupId("http://106.51.0.187:8090/cgwfollowon/findcrmgroupusers",$inputArray);
		}

		$responseArray = $groupUserListArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print"<pre>";
		//print_r($responseArray);
		//exit;

		$groupUserListArray = array();
		if(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseVal){
				$groupUserListArray[] = $responseVal;
			}
		}

		//print"<pre>";
		//print_r($groupUserListArray);
		//exit;

		$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.ticket_form.select_group_user', ['userdata' => $groupUserListArray]);
		}
		//else{
		//	return redirect('admin/login_user');
		//}
	 }

	 public function load_group_user_email(Request $request){

	 	$message = '';

		$inputArray = $cinputArray = array();

		$inputArray = $request->all();

		if(!empty($inputArray['groupId'])){
			$results = SELF::loadEmpByGroupId("http://106.51.0.187:8090/cgwfollowon/findcrmgroupusers",$inputArray);
		}

		$responseArray = $groupUserListArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print"<pre>";
		//print_r($responseArray);
		//exit;

		$groupUserListArray = array();
		if(!empty($responseArray->ticketList)){
			foreach($responseArray->ticketList as $responseVal){
				$groupUserListArray[] = $responseVal;
			}
		}

		//print"<pre>";
		//print_r($groupUserListArray);
		//exit;

		$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.ticket_form.select_group_user_email', ['userdata' => $groupUserListArray]);
		}
		//else{
		//	return redirect('admin/login_user');
		//}
	 }

	 public function loadEmpByGroupId($url,$params){

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

    public function addticket(){

    	if(!empty(session()->get('userId'))){
			return view('admin.ticket_form.add_tickets');
		}
		else{
			return redirect('admin/login_user');
		}
    }


    public function viewtickets(){

    	if(!empty(session()->get('userId'))){
			return view('admin.ticket_form.view_tickets');
		}
		else{
			return redirect('admin/login_user');
			//header('Location:login_user');
			//exit;
		}
    }

    public function detailtickets()
    {
    	if(!empty(session()->get('userId'))){
			return view('admin.ticket_form.ticket_details');
		}
		else{
			return redirect('admin/login_user');
			//header('Location:login_user');
			//exit;
		}
    }
    public function postreply()
    {
    	if(!empty(session()->get('userId'))){
			return view('admin.ticket_form.post_reply');
		}
		else{
			return redirect('admin/login_user');
			//header('Location:login_user');
			//exit;
		}
    }

   	/**
     * Show a user edit page
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::lists('title', 'id');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update our user information
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user->update($input);

        return redirect()->route('users.index')->withMessage(trans('quickadmin::admin.users-controller-successfully_updated'));
    }

    /**
     * Destroy specific user
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        User::destroy($id);

        return redirect()->route('users.index')->withMessage(trans('quickadmin::admin.users-controller-successfully_deleted'));
    }

	//retrieve All type records info
	public function retrieveAllStatusInfo($params){
		$statusObj = new Status();
		$resultArray = $statusObj->retrieveAll($params);
		return $resultArray;
	}
}