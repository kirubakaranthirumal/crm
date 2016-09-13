<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Department;
use App\Category;
use App\Priority;
use App\Source;
use App\Type;
use App\SmtpMail;

class UpdateTicketController extends Controller
{

	 public function show($id,Request $request){


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
			$departmentArray = $this->retrieveAllDepartmentInfo($params);
			$categoryArray = $this->retrieveAllCategoryInfo($params);
			$priorityArray = $this->retrieveAllPriorityInfo($params);
			$sourceArray = $this->retrieveAllSourceInfo($params);
			$typeArray = $this->retrieveAllTypeInfo($params);

		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		$department=array();
		$category=array();
		$priority=array();
		$source=array();
		$type=array();

		foreach($departmentArray as $deptVal){
					$department[] = $deptVal;
				}
		foreach($categoryArray as $categoryVal){
			$category[] = $categoryVal;
		}
		foreach($priorityArray as $priorityVal){
			$priority[] = $priorityVal;
		}
		foreach($sourceArray as $sourceVal){
			$source[] = $sourceVal;
		}
		foreach($typeArray as $typeVal){
			$type[] = $typeVal;
		}

	 	$appinputArray = $appResponseArray = array();

		$appinputArray['userSesId'] = 1;

		$appresults = "";
		if(!empty($appinputArray)){
			$appresults = SELF::ListAppPost("http://106.51.0.187:8090/cgwfollowon/listapp",$appinputArray);
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


		$groupid="";
        //if(!empty($inputArray['ticketGroupId'])){
        //	$groupid = $inputArray['ticketGroupId'];
        //}

		$inputArray = $cinputArray = array();

		//$input = $request->all();
		$inputArray = $request->all();

		if(!empty($id)){
			$cinputArray['ticketId'] = $id;
		}

		if(!empty($inputArray['submit'])){

			$file_ext_array = array();
			$extensions = "";

			/*
			print"<pre>";
			print_r($inputArray);
			print"<pre>";
			print_r($_FILES);
			exit;
			*/

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
				(!empty($inputArray['description']))
			){

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

				if(!empty($inputArray['description'])){
					$cinputArray['ticketText'] = $inputArray['description'];
				}

				if(!empty(session()->get('userId'))){
					$cinputArray['modifiedBy'] = session()->get('userId');
				}

				if(!empty($file_name)){
					$cinputArray['attachmentUrl'] = $file_name;
				}

					//print"<pre>";
					//print_r($cinputArray);
					//exit;

					$results = SELF::UpdateTicketPost("http://106.51.0.187:8090/cgwfollowon/updateticket",$cinputArray);

					$ticketdata = $results;

					$responseArray = array();

					if(!empty($results)){
						$responseArray = json_decode($results);
					}

					//print"<pre>";
					//print_r($responseArray);
					//exit;

					$smtpObj = new SmtpMail();

					$ticketId = "";
					if(!empty($id)){
						$ticketId = $id;
					}

					$to="";
					if(!empty($inputArray['requester_email'])){
						$to = $inputArray['requester_email'];

						$name = "";
						if(!empty($inputArray['requester_name'])){
							$name = $inputArray['requester_name'];
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

					$userId = session()->get('userId');

					if(!empty($userId)){
						session()->put('ticketUpdateSuccess','Ticket has been updated successfully');
	return view('admin.ticket_form.edit_tickets',['ticketdata'=>$ticketdata]);
					}
					else{
						return redirect('admin/login_user');
					}
				}
			}
		}
		else{

			Session::forget('ticketUpdateSuccess');

			if(!empty($cinputArray)){
				$results = SELF::EditTicketPost("http://106.51.0.187:8090/cgwfollowon/findticket",$cinputArray);
			}

			$ticketdata = $results;

			$responseArray = array();

			if(!empty($results)){
				$responseArray = json_decode($results);
			}

			$ticketArray=array();
			if(!empty($responseArray->ticketList)){
				foreach($responseArray->ticketList as $responseVal){
					$ticketArray = $responseVal;
				}
			}

		 /* 	print"<pre>";
			print_r($ticketArray);
			exit;
 */
			$userId = session()->get('userId');

			if(!empty($userId)){

				if(!empty($ticketArray->ticketGroupId)){
					return view('admin.ticket_form.edit_tickets',['req_groupid'=>$ticketArray->ticketGroupId,'ticketdata'=>$ticketArray,'app_data'=>$appListArray,'department'=>$department,'category'=>$category,'type'=>$type,'priority'=>$priority,'source'=>$source]);
				}
				else{
					return view('admin.ticket_form.edit_tickets',['ticketdata'=>$ticketArray,'app_data'=>$appListArray,'department'=>$department,'category'=>$category,'type'=>$type,'priority'=>$priority,'source'=>$source]);
				}
			}
			else{
				return redirect('admin/login_user');
			}
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

    public function UpdateTicketPost($url,$params){

		$json_string = '';

		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
		}

		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
		}

		if(!empty($params['ticketId'])){
			$fields['ticketId'] = $params['ticketId'];
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

		if(!empty($params['modifiedBy'])){
			$fields['modifiedBy'] = $params['modifiedBy'];
		}

		if(!empty($params['attachmentUrl'])){
			$fields['attachmentUrl'] = $params['attachmentUrl'];
		}

		//{"userId":"4","firstName":"admin","lastName":"kirubakaranthirumal@nutech.com","email":"kirubakaranthirumal@nutech.com","password":"123456","userType":"1","status":"2","gender":"1","groupId":"1","createdBy":21}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}

		//echo $json_string;
		//exit;

		$service_url = $url;

		//echo $json_string;
		//exit;

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



    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

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

    public function EditTicketPost($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['ticketId'])){
			$fields['ticketId'] = $params['ticketId'];
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
}