<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerDetailsController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(){

/* 		Session::forget('DeleteUserSuccess');
    	Session::forget('DeleteUserError'); */

        $userId = session()->get('userId');

	    $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

        if(!empty($cinputArray)){
		 	$results = SELF::ListUserPost("http://106.51.0.187:8090/cgwfollowon/listcrmusers",$cinputArray);
		}



        $responseArray = array();

        $userListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }



		if(!empty($responseArray->Crmuserlist)){
        	foreach($responseArray->Crmuserlist as $responseVal){
				$userListArray[] = $responseVal;
			}
		}

		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
            if(!empty($responseArray->msg)){
                //Session::forget('userListError');
                //session()->put('userSuccess','User has been created successfully');
                if(!empty($userId)){
                	return view('admin.users.customer_details', ['userdata' => $userListArray]);
                }
            }
        }
        elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
            //Session::forget('userSuccess');
            //session()->put('userListError','Email address already exist');
        }

		if(!empty($userId)){
            return view('admin.users.customer_details', ['userdata' => $userListArray]);
		}
		else{
			return redirect('admin/login_user');
		}
    }

	    public function store(Request $request){

    	$message = '';
    	$input = $request->all();

		$inputArray = $cinputArray = array();

		$inputArray = $request->all();

		if(
			(!empty($inputArray['userid']))
			||
			(!empty($inputArray['name']))
			||
			(!empty($inputArray['email']))
			||
			(!empty($inputArray['transaction']))
		){
			if(!empty($inputArray['userid'])){
				$cinputArray['customerId'] = $inputArray['userid'];
			}
			else{
				$cinputArray['customerId'] = '';
			}

			if(!empty($inputArray['name'])){
				$cinputArray['customerName'] = $inputArray['name'];
			}
			else{
				$cinputArray['customerName'] = '';
			}
			if(!empty($inputArray['email'])){
				$cinputArray['customerEmail'] = $inputArray['email'];
			}
			else{
				$cinputArray['customerEmail'] = '';
			}

			if(!empty($inputArray['transaction'])){
				$cinputArray['transactionId'] = $inputArray['transaction'];
			}
			else{
				$cinputArray['transactionId'] = '';
			}

			//$results = SELF::GetLoginInfo("http://106.51.0.187:8090/cgwfollowon/accesslogininfo",$cinputArray);

			$results = SELF::GetCustomerInfo("http://106.51.0.187:8090/cgwfollowon/accesscustomerinfo",$cinputArray);

			$responseArray=array();
			$registerinfoArray = array();
			$passArray = array();
			$loginInfoArray = array();
			if(!empty($results)){
			$responseArray = json_decode($results);
		}

		//print"<pre>";
		//print_r($responseArray);
		//exit;

		if(!empty($responseArray->registerInfo)){
        	foreach($responseArray->registerInfo as $responseVal){
				$registerinfoArray[] = $responseVal;
			}
		}
		if(!empty($responseArray->pass)){
        	foreach($responseArray->pass as $responseVal){
				$passArray[] = $responseVal;
			}
		}

		if(!empty($responseArray->loginInfo)){
        	foreach($responseArray->loginInfo as $responseVal){
				$loginInfoArray[] = $responseVal;
			}
		}
		$customerdetails=array($registerinfoArray,$passArray,$loginInfoArray);
		//print"<pre>";
		//print_r($customerdetails);
		//exit;

		//print"<pre>";
		//print_r($registerinfoArray);
		//print_r($passArray);
	    //print_r($loginInfoArray);
		//exit;

		$userId = session()->get('userId');
		if(!empty($userId)){

            return view('admin.users.customer_details', ['customerdetails'=>$customerdetails,'registerinfo' => $registerinfoArray,'passinfo' => $passArray,'logininfo' => $loginInfoArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}
}

    public function GetCustomerInfo($url,$params){

    	$json_string = '';

		if(!empty($params['customerId'])){
			$fields['customerId'] = $params['customerId'];
		}

		if(!empty($params['customerName'])){
			$fields['customerName'] = $params['customerName'];
		}

		if(!empty($params['customerEmail'])){
			$fields['customerEmail'] = $params['customerEmail'];
		}

		if(!empty($params['transactionId'])){
			$fields['transactionId'] = $params['transactionId'];
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


    public function ListUserPost($url,$params){

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
}
