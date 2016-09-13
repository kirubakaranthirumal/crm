<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserUpdateTicketController extends Controller
{

	 public function show($id,Request $request){

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

		//print"<pre>";
		//print_r($inputArray);
		//exit;

		$tabId="";
		if(!empty($inputArray['tab_id'])){
			$tabId = $inputArray['tab_id'];
        }

		if(!empty($id)){
			$cinputArray['ticketId'] = $id;
		}

		if(!empty($inputArray['submit'])){

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

			if(!empty($inputArray['application'])){
				$cinputArray['appId'] = $inputArray['application'];
			}

			if(!empty($inputArray['event'])){
				$cinputArray['eventId'] = $inputArray['event'];
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

				$results = SELF::UpdateTicketPost("http://106.51.0.187:8090/cgwfollowon/updateticket",$cinputArray);

				$ticketdata = $results;

				$responseArray = array();

				if(!empty($results)){
					$responseArray = json_decode($results);
				}

				//print"<pre>";
				//print_r($responseArray);
				//exit;

				$userId = session()->get('userId');

				if(!empty($userId)){
					session()->put('ticketUpdateSuccess','Ticket has been updated successfully');
					//return view('admin.ticket_form.edit_tickets')->with('ticketdata', json_decode($ticketdata, true));
					return view('admin.ticket_form.user_edit_tickets',['tab_id'=>$tabId]);
				}
				else{
					return redirect('admin/login_user');
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

			//print"<pre>";
			//print_r($ticketArray);
			//exit;

			$userId = session()->get('userId');

			if(!empty($userId)){
				if(!empty($ticketArray->ticketGroupId)){
					return view('admin.ticket_form.user_edit_tickets',['req_groupid'=>$ticketArray->ticketGroupId,'ticketdata'=>$ticketArray,'app_data'=>$appListArray,'tab_id'=>$tabId]);
				}
				else{
					return view('admin.ticket_form.user_edit_tickets',['ticketdata'=>$ticketArray,'app_data'=>$appListArray,'tab_id'=>$tabId]);
				}
			}
			else{
				return redirect('admin/login_user');
			}
		}
    }

    public function UpdateTicketPost($url,$params){

		$json_string = '';

		if(!empty($params['ticketId'])){
			$fields['ticketId'] = $params['ticketId'];
		}

		if(!empty($params['appId'])){
			$fields['appId'] = $params['appId'];
		}

		if(!empty($params['eventId'])){
			$fields['eventId'] = $params['eventId'];
		}

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

		//print"<pre>";
		//print_r($fields);
		//exit;

		//{"userId":"4","firstName":"admin","lastName":"kirubakaranthirumal@nutech.com","email":"kirubakaranthirumal@nutech.com","password":"123456","userType":"1","status":"2","gender":"1","groupId":"1","createdBy":21}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}

		//echo $json_string;
		//exit;

		$service_url = $url;

		/*
		print"<pre>";
		print_r($fields);
		exit;

		echo $service_url;
		exit;
		*/

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



    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */



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