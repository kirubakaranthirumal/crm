<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TicketsController extends Controller{

	 /**
	 * Show a list of users
	 * @return \Illuminate\View\View
	 */

	public function index(){

		Session::forget('ticketSuccess');
		Session::forget('ticketError');

		$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.ticket_form.add_tickets');
		}
		else{
			return redirect('admin/login_user');
		}
	}

	public function store(Request $request){

		$message = $upload_path = "";
		$input = $request->all();

		$inputArray = $cinputArray = array();

		$inputArray = $request->all();

		/*
		print"<pre>";
		print_r($inputArray);
		print_r($_FILES);
		exit;
		*/
?>
<?php

	$file_ext_array = array();
	$extensions = "";

	if(isset($_FILES['ticket_attachment'])){

		$errors = array();

		$file_name = $_FILES['ticket_attachment']['name'];
		$file_size =$_FILES['ticket_attachment']['size'];
		$file_tmp =$_FILES['ticket_attachment']['tmp_name'];
		$file_type=$_FILES['ticket_attachment']['type'];

		//$file_ext=strtolower(end(explode('.',$_FILES['ticket_attachment']['name'])));
		//$file_ext=strtolower(end(explode('.',$_FILES['ticket_attachment']['name'])));
		$file_ext_array = explode('.',$_FILES['ticket_attachment']['name']);

		if(!empty($file_ext_array['1'])){
			$file_ext = $file_ext_array['1'];
		}

		//echo $file_ext;
		//echo $file_name;
		//exit;

		//$upload_path = public_path();
		//$upload_path .= "\upload\tickets\";

		$upload_path = "upload/tickets/";

		//print"<pre>";
		//print_r($upload_path);
		//exit;

		//print"<pre>";
		//print_r(explode('.',$_FILES['ticket_attachment']['name']));
		//exit;

		$extensions = array("jpeg","jpg","png");

		if(in_array($file_ext,$extensions)=== false){
			$errors[] = "extension not allowed, please choose a JPEG or PNG file.";
		}

		if($file_size > 2097152){
			$errors[]='File size must be excately 2 MB';
		}

		if(empty($errors)==true){
			//$test = move_uploaded_file($file_tmp,$upload_path.$file_name);
			//print_r($test);
			//echo "Success";
			//exit;
		}
		else{
			//print_r($errors);
			//exit;
		}
	}




		/*

		$target_dir = "uploads/";
		$target_file = $target_dir.basename($_FILES["ticket_attachment"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		//if(isset($_POST["submit"])){
		    $check = getimagesize($_FILES["ticket_attachment"]["tmp_name"]);
		    if($check !== false){
		        echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    }
		    else{
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		//}

		// Check if file already exists
		if(file_exists($target_file)){
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}

		// Check file size
		if ($_FILES["ticket_attachment"]["size"] > 50000000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0){
		    echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		}
		else{
		    if(move_uploaded_file($_FILES["ticket_attachment"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["ticket_attachment"]["name"]). " has been uploaded.";
		    }
		    else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}

		exit;
		*/

		/*
			$imageTempName = $request->file('photo')->getPathname();
			$imageName = $request->file('photo')->getClientOriginalName();
			$path = base_path() . '/public/uploads/consultants/images/';
			$request->file('photo')->move($path , $imageName);
			DB::table('consultants')->where('photo', $imageTempName)->update(['photo' => $imageName]);
		*/

		/*
			$photo = $request->file('photo');
			$destinationPath = base_path() . '/public/uploads/images/consultants/';
			$photo->move($destinationPath, $photo->getClientOriginalName());
			$consultant = Consultant::create($request->all());
			return $consultant;
			flash('Your consultant has been created');
			return redirect('content-management-system/consultants');
		*/

		if(
			(!empty($inputArray['requester_name']))
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

			if(!empty($inputArray['requester_name'])){
				$cinputArray['requestorName'] = $inputArray['requester_name'];
			}

			if(!empty($inputArray['requester_name'])){
				$cinputArray['requestorName'] = $inputArray['requester_name'];
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
				$cinputArray['createdBy'] = session()->get('userId');
			}

			//print"<pre>";
			//print_r($cinputArray);
			//exit;

			$results = SELF::AddTicketPost("http://106.51.0.187:8090/cgwfollowon/createtickets",$cinputArray);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				Session::forget('ticketError');
				session()->put('ticketSuccess','Ticket has been created successfully');
				return view('admin.ticket_form.add_tickets');
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
			Session::forget('ticketSuccess');
			session()->put('ticketError','Cannot create ticket');
		}

		$userId = session()->get('userId');
		if(!empty($userId)){
			return view('admin.ticket_form.add_tickets');
		}
		else{
			return redirect('admin/login_user');
		}
    }

     public function AddTicketPost($url,$params){

		$json_string = '';

		if(!empty($params['requestorName'])){
			$fields['requestorName'] = $params['requestorName'];
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

		$fields['portelUserId'] = "0";
		$fields['modifiedBy'] = "0";

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}

		//$json_string = '{"requestorName":"kiruba","portelUserId":"0","ticketSubject":"testticket","ticketText":"test desc","type":"1","priority":"1","status":"1","createdBy":"1","ticketSource":"1","modifiedBy":"0","ticketCatId":"12","ticketAssignedUser":"1","ticketGroupId":"1"}';

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
}