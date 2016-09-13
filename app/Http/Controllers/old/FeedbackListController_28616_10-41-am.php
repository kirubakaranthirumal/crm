<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\FeedbackModel;

class FeedbackListController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(Request $request){

		    Session::forget('feedbackDelSuc');
        $userId = session()->get('userId');

	    $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

		$successArray = $errorArray = $feedbackContentArray = array();

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
			$feedbackContentArray = $this->retrieveAllFeedbackContentInfo($params);
		}
		catch(Exception $e){
			$errorArray[$e->getCode()] = $e->getMessage();
		}
		
		$feedback_list=array();
			foreach($feedbackContentArray as $feedVal){
				$feedback_list[] = $feedVal;
					}	
				
		return view('admin.users.customer_feedback_list',['feedlist'=>$feedback_list]);
    }

	public function show($id){

		Session::forget('DeleteUserSuccess');
    	Session::forget('DeleteUserError');
		 $userId = session()->get('userId');

        $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['userId'] = $id;
        }

		if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

		if(!empty($cinputArray)){
		 	$delete = SELF::DeleteUserList("http://106.51.0.187:8090/cgwfollowon/deletecrmuser",$cinputArray);
		 	$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listcrmusers",$cinputArray);
		}

        $responseArray = $delResponseArray = array();

        if(!empty($delete)){
            $delResponseArray = json_decode($delete);
        }

        //print"<pre>";
        //print_r($delResponseArray);
        //exit;

        $userListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }

		if(!empty($responseArray->Crmuserlist)){
        	foreach($responseArray->Crmuserlist as $responseVal){
				$userListArray[] = $responseVal;
			}
		}

		if((!empty($delResponseArray->status)) && ($delResponseArray->status == "200")){
            if(!empty($delResponseArray->msg)){
                Session::forget('DeleteUserError');
                session()->put('DeleteUserSuccess','User has been deleted successfully');
                if(!empty($userId)){
                	return view('admin.users.users_list',['userdata' => $userListArray]);
                }
            }
			if(!empty($userId)){
				return view('admin.users.users_list', ['userdata' => $userListArray]);
			}
			else{
				return redirect('admin/login_user');
			}
		}

	}

	public function DeleteUserList($url,$params){

		$json_string = '';

		$json_string = '';

		if(!empty($params['userId'])){
			$fields['userId'] = $params['userId'];
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


   //retrieve department records info
	public function retrieveInfo($feedbackId){
		$feedcontentObj = new FeedbackModel();
		$WhrClause['id'] = $feedbackId;
		$feedcontentModel = $feedcontentObj->retrieveById($WhrClause);
		return $feedcontentModel;
	}

	//retrieve All department records info
	public function retrieveAllFeedbackContentInfo($params){
		$feedcontentObj = new FeedbackModel();
		$resultArray = $feedcontentObj->retrieveAll($params);
		return $resultArray;
	}

	//update department details
	public function updateById($feedbackId, $inputArray){
		$feedcontentObj = new FeedbackModel();
		$feedcontentObj->updateById($feedbackId, $inputArray);
	}

	//delete a record
	public function deleteById($id){
		$feedcontentObj = new FeedbackModel();
		$result = $feedcontentObj->deleteById($id);
	}
}
