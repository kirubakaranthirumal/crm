<?php
namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CountryListController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(){

		Session::forget('DeleteCountrySuccess');
    	Session::forget('DeleteCountryError');

        $userId = session()->get('userId');

	    $cinputArray = array();

        if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

        if(!empty($cinputArray)){
		 	$results = SELF::ListCountryPost("http://cgwrestapi-env.us-west-2.elasticbeanstalk.com/listcountry",$cinputArray);
		}

        $responseArray = array();

        $countryListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }
		
		//print"<pre>";
		//print_r($responseArray);
		//exit;
		
		if(!empty($responseArray->countryList)){
        	foreach($responseArray->countryList as $responseVal){
				$countryListArray[] = $responseVal;
			}
		}
		
		if((!empty($responseArray->status)) && ($responseArray->status == "200")){
            if(!empty($responseArray->msg)){
                if(!empty($userId)){
                	return view('admin.country.country_list', ['countrydata' => $countryListArray]);
                }
            }
        }
        elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
			
		}
		
		if(!empty($userId)){
            return view('admin.country.country_list', ['countrydata' => $countryListArray]);
		}
		else{
			return redirect('admin/login_user');
		}
    }

	public function show($id){
		
		Session::forget('DeleteCountrySuccess');
    	Session::forget('DeleteCountrySuccess');
		$userId = session()->get('userId');

        $cinputArray = array();

        if(!empty($id)){
            $cinputArray['countryId'] = $id;
        }

		if(!empty($userId)){
            $cinputArray['userSesId'] = $userId;
        }

		if(!empty($cinputArray)){
		 	$delete = SELF::DeleteCountryList("http://cgwrestapi-env.us-west-2.elasticbeanstalk.com/deletecountry",$cinputArray);
		 	$results = SELF::ListCountryPost("http://cgwrestapi-env.us-west-2.elasticbeanstalk.com/listcountry",$cinputArray);
		}

        $responseArray = $delResponseArray = array();

        if(!empty($delete)){
            $delResponseArray = json_decode($delete);
        }

        //print"<pre>";
        //print_r($delResponseArray);
        //exit;

		$countryListArray = array();
        if(!empty($results)){
            $responseArray = json_decode($results);
        }
		
		//print"<pre>";
		//print_r($responseArray);
		//exit;
		
		if(!empty($responseArray->countryList)){
        	foreach($responseArray->countryList as $responseVal){
				$countryListArray[] = $responseVal;
			}
		}

		if((!empty($delResponseArray->status)) && ($delResponseArray->status == "200")){
            if(!empty($delResponseArray->msg)){
                Session::forget('DeleteCountryError');
                session()->put('DeleteCountrySuccess','Country has been deleted successfully');
                if(!empty($userId)){
                	return view('admin.country.country_list',['countrydata' => $countryListArray]);
                }
            }
			if(!empty($userId)){
				return view('admin.country.country_list', ['countrydata' => $countryListArray]);
			}
			else{
				return redirect('admin/login_user');
			}
		}
	}

	public function DeleteCountryList($url,$params){

		$json_string = '';
		if(!empty($params['countryId'])){
			$fields['countryId'] = $params['countryId'];
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

    public function ListCountryPost($url,$params){

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
