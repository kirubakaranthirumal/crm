<?php
	namespace App\Http\Controllers;

	use Session;

	class FbPageController extends Controller {

		public function index(){

			$results = "";

			//https://graph.facebook.com/v2.6/me/feed?access_token=EAACEdEose0cBAJroPkCRBtQT4SFA4HnPEAW6lbtIE0vBYElEZBSG7WTWMfg49154M9cz23LrfhdZBoF2gFq40MydcmvdmvDxJJVitqaw0q5VOpN5KbCA5r00khfO7WxOMNY2iVh8fVRYZBQn3Qs3Vk8MhC1z8hdDmkFmOBHqgZDZD

			$cinputArray = $responseArray = array();

			$results = SELF::ListFbPagePost("https://graph.facebook.com/v2.6/270629016631935/feed?access_token=EAACEdEose0cBAE9LdqVgNjH3wwjrs2ARJycuZAPw4afD9OcJ04wh4dZCHKlM1g6SuRPOfKM22ZA8zpJvuVR9Xy9k7LQjwoeYm4qZBbyqdz1uYZAXZAAferWmnXZCHEuv7pzYv5t7JHMA7bW6t5GVHRJYZB4ktjwbzLpf7t9my70oigZDZD",$cinputArray);

			if(!empty($results)){
				$responseArray = json_decode($results);
			}

			//print"<pre>";
			//print_r($responseArray);
			//exit;

			$fbPostArray = array();
			if(!empty($responseArray->data)){
				$fbPostArray = $responseArray->data;
			}

			//print"<pre>";
			//print_r($fbPostArray);
			//exit;

			$fbPostIdArray = array();
			if(!empty($responseArray)){
				foreach($responseArray->data as $fbPostVal){
					//print"<pre>";
					//print_r($fbPostVal);
					//exit;
					$fbPostIdArray[] = $fbPostVal->id;
				}
			}

			//like code starts here
			$likeinputArray = $likeResponseArray = array();

			$like_url = "";
			if(!empty($fbPostIdArray)){
				foreach($fbPostIdArray as $fbPostIdVal){
					$like_url = "https://graph.facebook.com/v2.6/".$fbPostIdVal."/likes?access_token=EAACEdEose0cBAFHrFP6cWzZBOYpliuhhMQQsc4FsmmIlYdJAdI93S5oc9K2TUmOOk4yRoDIZA1TUybsSsECpD1CwrdKLmBCAG1G10g1gIvx8VcQZCASw6tOLxGGI6NzL7z4wIsqLtNTSeHKK9rOyCuGcu9afXE72bdbMgbV3gZDZD";
					$like_results = SELF::FbLikeForAPost($like_url,$likeinputArray);

					if(!empty($like_results)){
						$likeResponseArray[$fbPostIdVal] = json_decode($like_results);
					}
				}
			}
			//like code end here


			//print"<pre>";
			//print_r($likeResponseArray);
			//exit;

			//comment code starts here
			$commentinputArray = $commentResponseArray = array();

			$comment_url = "";
			if(!empty($fbPostIdArray)){
				foreach($fbPostIdArray as $fbPostIdVal){

					$comment_url = "https://graph.facebook.com/v2.6/".$fbPostIdVal."/comments?access_token=EAACEdEose0cBAAoooDJWygc3AHy5rP1fNEV7Kh3rRZAriJZBzc2GPbVUnhNX6azsNUDSPPXbKNCdOaNsvL4r4qHCxhar49dGqqyt52cAnmXA2oadLH148EAO6SIcnAQAi9mq8Wy6XN5U6S4ekck0bKPRAq2BiD8sCRF9U9uwZDZD";
					$comment_results = SELF::FbCommentForAPost($comment_url,$commentinputArray);

					if(!empty($comment_results)){
						$commentResponseArray[$fbPostIdVal] = json_decode($comment_results);
					}
				}
			}
			//comment code end here

			/*
			$fbPostDispArray = array();
			if(!empty($responseArray)){
				foreach($responseArray->data as $fbPostVal){
					$fbPostDispArray[] = $fbPostVal;

					if(!empty($likeResponseArray[$fbPostVal->id])){
						$post_id = $fbPostVal->id;

						//print"<pre>";
						//print_r($post_id);
						//exit;

						if(!empty($likeResponseArray[$post_id])){
							//$fbPostDispArray['like'][$post_id] = $likeResponseArray[$post_id];
						}

						//print"<pre>";
						//print_r($fbPostDispArray);
						//exit;
					}

					//$fbPostVal->id

					//print"<pre>";
					//print_r($fbPostVal->id);
					//exit;

				}
				//exit;
			}

			//print"<pre>";
			//print_r($fbPostDispArray);
			//exit;
			*/

			$userId = session()->get('userId');

			if(!empty($userId)){
				return view('admin.fbpage',['fbpage' => $fbPostArray,'fblike' => $likeResponseArray,'fbcomment' => $commentResponseArray]);
			}
			else{
				return redirect('admin/login_user');
			}
		}

		public function ListFbPagePost($url,$params){

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			$curl_response = curl_exec($ch);

			curl_close($ch);

			return $curl_response;
    	}

    	public function FbLikeForAPost($url,$params){

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			$curl_response = curl_exec($ch);

			curl_close($ch);

			return $curl_response;
    	}

    	public function FbCommentForAPost($url,$params){

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			$curl_response = curl_exec($ch);

			curl_close($ch);

			return $curl_response;
    	}
	}
?>