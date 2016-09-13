<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\MailAccountSetting;

class MailAccountSettingController extends Controller{

	/**
	* Display a listing of the resource.
	* @return Response
	*/
	public function index(Request $request){

		Session::forget('contentManageSuc');
		Session::forget('contentManageDelSuc');
		Session::forget('menuNameUpdateError');

		$successArray = $errorArray = $contentManageArray = array();

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
			$mailAccSetArray = $this->retrieveAllInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

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

		return view('admin.users.mailaccsetting',['app_data'=>$appListArray,'mailAccSet'=>$mailAccSetArray]);
	}

	/**
	* Store a newly created resource in storage.
	* @param  Request  $request
	* @return Response
	*/

	public function store(Request $request){

		Session::forget('contentManageSuc');
		Session::forget('contentManageDelSuc');
		Session::forget('menuNameError');

		$statusCode = "200";
		$status = "Success";
		$userId = $mailId = "";

		$errorArray = array();

		$inputArray = $request->all();

		$userId = Session::get('userId');

		if(!empty($userId)){
			$inputArray['create_by'] = $userId;
		}

		if(empty($errorArray)){
			$mailId = $this->createMailAccSet($inputArray);
		}

	    $successArray = $errorArray = $contentManageArray = array();
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
			$mailAccSetArray = $this->retrieveAllInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

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

		if((!empty($mailId))){
			session()->put('contentManageSuc','Mail Account Setting has been created successfully');

			return view('admin.users.mailaccsetting',['app_data'=>$appListArray,'mailAccSet'=>$mailAccSetArray,'errorArray'=>$errorArray]);
		}
		else{
			return view('admin.users.mailaccsetting',['app_data'=>$appListArray,'mailAccSet'=>$mailAccSetArray]);
		}
	}

	//create new department
	public function createMailAccSet($inputArray){

		//set model object
		$mAccSetObj = new MailAccountSetting();

		$mAccSetObj->mail_app_id = (isset($inputArray['mail_app_id'])?trim($inputArray['mail_app_id']):"");
		$mAccSetObj->mail_user_id = (isset($inputArray['mail_user_id'])?trim($inputArray['mail_user_id']):"");
		$mAccSetObj->mail_user_password = (isset($inputArray['mail_user_password'])?trim($inputArray['mail_user_password']):"");
		$mAccSetObj->mail_desc = (isset($inputArray['editor'])?trim($inputArray['editor']):"");
		$mAccSetObj->mail_status = (isset($inputArray['mail_status'])?trim($inputArray['mail_status']):"");
		$mAccSetObj->created_on = date('Y-m-d H:i:s');
		$mAccSetObj->created_by = (isset($inputArray['create_by'])?trim($inputArray['create_by']):"0");

		$mailId = $mAccSetObj->insert($mAccSetObj);

		if($mailId){
			return $mailId;
		}
		else{
			return false;
		}
	}

	//retrieve department records info
	public function retrieveAllInfo($params){
		$mailAccSetObj = new MailAccountSetting();
		$mailAccSetModel = $mailAccSetObj->retrieveAll($params);
		return $mailAccSetModel;
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

	public function edit(Request $request, $id) {


		Session::forget('contentManageUpdSuc');
		Session::forget('menuNameUpdateError');

		$userId = Session::get('userId');

		$params = $request->all();
		$mailAccSetObj = new MailAccountSetting();

		$mailAccSetValArray = array();
		$mailAccSetUpdArray = array();

		if(!empty($userId)){
			$params['modified_by'] = $userId;
		}
		else{
			$params['modified_by'] = 1;
		}

		if(!empty($params['submit'])){

			//print"<pre>";
			//print_r($params);
			//exit;

			if(empty($errorArray)){
				$mailAccSetUpdArray = $mailAccSetObj->updateById($id,$params);
			}
		}

		//list data code starts here
		$successArray = $errorArray = $contentManageArray = array();

		//initialize record count,page number,sorting
		if(!empty($params['recordsCount'])) $params['recordsCount'] = $params['recordsCount'];
		else $params['recordsCount']=env('RECORD_COUNT');

		if(!empty($params['pageNo'])) $params['pageNo'] = $params['pageNo'];
		else $params['pageNo']=env('PAGE_NO');

		if(!empty($params['sortingColumn'])) $params['sortingColumn'] = $params['sortingColumn'];
		else $params['sortingColumn']=env('SORTING_COLUMN');

		if(!empty($params['sortingOrder'])) $params['sortingOrder'] = $params['sortingOrder'];
		else $params['sortingOrder']=env('SORTING_ORDER');

		$whrClause = array();
		$whrClause['mail_id'] = $id;
		$mailAccSetValArray = $mailAccSetObj->retrieveByWhere($whrClause);

		$mailAccSetArray = array();

		try{
			$mailAccSetArray = $this->retrieveAllInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		if(!empty($mailAccSetUpdArray)){
			session()->put('contentManageUpdSuc','Mail Account Setting has been Updated successfully');
		}

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

		if((!empty($menuId))){
			return view('admin.users.mailaccsettings');
		}

		return view('admin.users.edit_mailaccsetting',['app_data'=>$appListArray, 'mailAccSetArray'=>$mailAccSetArray,'mailAccSetVal'=>current($mailAccSetValArray),'mailAccSetId'=>$id]);
	}

	public function destroy(Request $request, $id){

		Session::forget('contentManageDelSuc');
		$userId = Session::get('userId');

		$params = $request->all();
		$mailAccSetObj = new MailAccountSetting();

		$mailAccSetValArray = array();
		$mailAccSetUpdArray = array();

		$mailAccSetValArray = $mailAccSetObj->deleteById($id);


		//list data code starts here
		$successArray = $errorArray = $contentManageArray = array();

		//initialize record count,page number,sorting
		if(!empty($params['recordsCount'])) $params['recordsCount'] = $params['recordsCount'];
		else $params['recordsCount']=env('RECORD_COUNT');

		if(!empty($params['pageNo'])) $params['pageNo'] = $params['pageNo'];
		else $params['pageNo']=env('PAGE_NO');

		if(!empty($params['sortingColumn'])) $params['sortingColumn'] = $params['sortingColumn'];
		else $params['sortingColumn']=env('SORTING_COLUMN');

		if(!empty($params['sortingOrder'])) $params['sortingOrder'] = $params['sortingOrder'];
		else $params['sortingOrder']=env('SORTING_ORDER');

		$mailAccSetArray = array();

		try{
			$mailAccSetArray = $this->retrieveAllInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}

		if(!empty($mailAccSetValArray)){
			session()->put('contentManageDelSuc','Mail Account Setting has been Deleted successfully');
		}

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

		if((!empty($menuId))){
			return view('admin.users.mailaccsettings');
		}

		return view('admin.users.mailaccsetting',['app_data'=>$appListArray,'mailAccSet'=>$mailAccSetArray]);

	}

}