<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CountryController extends Controller{

	/**
	* Show a list of users
	* @return \Illuminate\View\View
	*/
    public function index(){
    	Session::forget('countrySuccess');
    	Session::forget('countryError');
    	
		$userId = session()->get('userId');

		$params = array();
		
		return view('admin.country.add_country');
		
		/*
		if(!empty($userId)){
			return view('admin.country.add_country');
		}
		else{
			return redirect('admin/login_user');
		}
		*/
    }

    public function store(Request $request){
		
		$message = '';
		
    	$input = $request->all();
		$inputArray = $cinputArray = array();
		$inputArray = $request->all();
		
		if(
			(!empty($inputArray['country_name']))
			&&
			(!empty($inputArray['country_flag']))
			&&
			(!empty($inputArray['country_short_name']))
			&&
			(!empty($inputArray['country_code']))
		){

			if(!empty($inputArray['country_name'])){
				$cinputArray['countryName'] = $inputArray['country_name'];
			}

			if(!empty($inputArray['country_short_name'])){
				$cinputArray['StortName'] = $inputArray['country_short_name'];
			}

			if(!empty($inputArray['country_code'])){
				$cinputArray['countryCode'] = $inputArray['country_code'];
			}

			if(isset($_FILES['country_flag'])){

				$errors = array();

				//$file_name = $_FILES['country_flag']['name'];

				$file_size =$_FILES['country_flag']['size'];
				$file_tmp =$_FILES['country_flag']['tmp_name'];
				$file_type=$_FILES['country_flag']['type'];

				$file_ext_array = explode('.',$_FILES['country_flag']['name']);

				if(!empty($file_ext_array['1'])){
					$file_ext = $file_ext_array['1'];
					$file_name = rand().".".$file_ext;

					$upload_path = "upload/country/";

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
				
				if(!empty($inputArray['country_flag'])){
					$cinputArray['countryFlags'] = $inputArray['country_flag'];
				}
			}
			
			$results = SELF::AddCountryPost("http://cgwrestapi-env.us-west-2.elasticbeanstalk.com/createcountry",$cinputArray);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}
		
		//print"<pre>";
		//print_r($responseArray);
		//exit;
		
		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
			if(!empty($responseArray->msg)){
				Session::forget('countryError');
				session()->put('countrySuccess','Country has been created successfully');
				return view('admin.country.add_country');
			}
		}
		elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
			Session::forget('countrySuccess');
			session()->put('countryError','Country address already exist');
		}
		
		$userId = session()->get('userId');
		if(!empty($userId)){
			return view('admin.country.add_country');
		}
		else{
			return redirect('admin/login_user');
		}
    }

    public function AddCountryPost($url,$params){
		
    	$json_string = '';
		if(!empty($params['countryName'])){
			$fields['countryName'] = $params['countryName'];
		}

		if(!empty($params['countryFlags'])){
			$fields['countryFlags'] = $params['countryFlags'];
		}

		if(!empty($params['StortName'])){
			$fields['StortName'] = $params['StortName'];
		}

		if(!empty($params['countryCode'])){
			$fields['countryCode'] = $params['countryCode'];
		}

		if(!empty($params['mobileDigits'])){
			$fields['mobileDigits'] = $params['mobileDigits'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}
		
		//echo $json_string;
		//exit;

		$service_url = $url;
		$curl = curl_init($service_url);
		
		//echo $json_string;
		//exit;

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

    public function viewcountry(){
		
    	$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.country.view_country');
		}
		else{
			return redirect('admin/login_user');
		}
	}

	public function countrydetails($id){

		$inputArray = $cinputArray = array();

		if(!empty($id)){
			$cinputArray['userId'] = $id;
		}

		if(!empty($cinputArray)){
			$results = SELF::EditCountryPost("http://106.51.0.187:8090/cgwfollowon/findcrmuser",$cinputArray);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		$userId = session()->get('userId');
		if(!empty($userId)){
			return view('admin.country.view_country');
		}
		else{
			return redirect('admin/login_user');
		}
	}

    /**
     * Show a user edit page
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id){

       $userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.country.country_details');
		}
		else{
			return redirect('admin/login_user');
		}
    }

     public function show($id){

     	$inputArray = $cinputArray = array();

     	if(!empty($id)){
			$cinputArray['userId'] = $id;
		}

		if(!empty($cinputArray)){
			$results = SELF::EditCountryPost("http://106.51.0.187:8090/cgwfollowon/findcrmuser",$cinputArray);
		}

		$responseArray = array();
		if(!empty($results)){
			$responseArray = json_decode($results);
		}

		$userId = session()->get('userId');

		if(!empty($userId)){
			return view('admin.country.country_details');
		}
		else{
			return redirect('admin/login_user');
		}
    }

    public function EditCountryPost($url,$params){

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
}