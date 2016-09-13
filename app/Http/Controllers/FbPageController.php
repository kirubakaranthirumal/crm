<?php
	namespace App\Http\Controllers;
	//namespace App\lib\facebookphpsdk\src;

	use Session;
	use Validator;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Hash;

	use App\lib\facebookphpsdk\src\Facebook\Facebook;

	class FbPageController extends Controller {

		public function index(){

			$page_id = "1056627197749548";
			$page_access_token="EAAYh8lMkiuoBAEs6ywU8hJvuVaP8O0JW0iHwNCxtRu34RaZCb9PDxtM78iqDbZCXERFMVMYUEr9LtNuUZBetahHYrI9itIlFEp1Hjf1CVNKVkrFreTcro3yMDXDw8Nc5jPy9I1ZCJo50GIzFKYdzQjgXPgXFET68RErOr69ACaa2INMZAqKuz";

			$results = "";

			$cinputArray = $responseArray = array();

			$results = SELF::ListFbPagePost("https://graph.facebook.com/v2.6/".$page_id."/feed?fields=message%2Cfrom%2Ccreated_time%2Cpicture%2Cid&access_token=".$page_access_token);

			if(!empty($results)){
				$responseArray = json_decode($results);
			}

			$fbPostArray = array();
			if(!empty($responseArray->data)){
				$fbPostArray = $responseArray->data;
			}

			//print"<pre>";
			//print_r($fbPostArray);
			//exit;

			$fbPostIdArray = array();
			if(!empty($responseArray->data)){
				foreach($responseArray->data as $fbPostVal){
					$fbPostIdArray[] = $fbPostVal->id;
				}
			}

			//like code starts here
			$likeinputArray = $likeResponseArray = array();

			$like_url = "";
			if(!empty($fbPostIdArray)){
				foreach($fbPostIdArray as $fbPostIdVal){

					$like_url = "https://graph.facebook.com/v2.6/".$fbPostIdVal."/likes?access_token=".$page_access_token;
					$like_results = SELF::FbLikeForAPost($like_url,$likeinputArray);
					$like_results = json_decode($like_results);
					if(!empty($like_results->data)){
						$likeResponseArray[$fbPostIdVal] = $like_results;
					}
				}
			}
			//like code end here

			//comment code starts here
			$commentinputArray = $commentResponseArray = array();

			$comment_url = "";
			if(!empty($fbPostIdArray)){
				foreach($fbPostIdArray as $fbPostIdVal){
					$comment_url = "https://graph.facebook.com/v2.6/".$fbPostIdVal."/comments?access_token=".$page_access_token;
					$comment_results = SELF::FbCommentForAPost($comment_url,$commentinputArray);

					if(!empty($comment_results)){
						$commentResponseArray[$fbPostIdVal] = json_decode($comment_results);
					}
				}
			}
			//comment code end here

			$userId = session()->get('userId');

			if(!empty($userId)){
				return view('admin.fbpage',['fbpage' => $fbPostArray,'fblike' => $likeResponseArray,'fbcomment' => $commentResponseArray,'access_token' => $page_access_token]);
			}
			else{
				return redirect('admin/login_user');
			}
		}


		public function store(Request $request){

			$inputArray = $appCommentResponseArray = array();
			$inputArray = $request->all();

			$comment_post_id = "";
			if(!empty($inputArray['post_id'])){
				$comment_post_id = $inputArray['post_id'];
			}

			$comment_message = "";
			if(!empty($inputArray['message'])){
				$comment_message = $inputArray['message'];
			}

			$post_comment_url = "";
			if(!empty($comment_post_id)){
				$post_comment_url = "https://graph.facebook.com/v2.6/".$comment_post_id."/comments";
			}

			$page_access_token="EAAYh8lMkiuoBAEs6ywU8hJvuVaP8O0JW0iHwNCxtRu34RaZCb9PDxtM78iqDbZCXERFMVMYUEr9LtNuUZBetahHYrI9itIlFEp1Hjf1CVNKVkrFreTcro3yMDXDw8Nc5jPy9I1ZCJo50GIzFKYdzQjgXPgXFET68RErOr69ACaa2INMZAqKuz";

			$app_comment_results = "";
			if(!empty($inputArray)){
				$app_comment_results = SELF::FbPostComment($post_comment_url,$inputArray,$page_access_token);
			}

			return redirect('admin/fbpage');
   		}

   		public function addpost(Request $request){

   			$inputArray = $appCommentResponseArray = array();

			$inputArray = $request->all();

			$page_id = "1056627197749548";
			$page_access_token="EAAYh8lMkiuoBAEs6ywU8hJvuVaP8O0JW0iHwNCxtRu34RaZCb9PDxtM78iqDbZCXERFMVMYUEr9LtNuUZBetahHYrI9itIlFEp1Hjf1CVNKVkrFreTcro3yMDXDw8Nc5jPy9I1ZCJo50GIzFKYdzQjgXPgXFET68RErOr69ACaa2INMZAqKuz";

			$comment_message = "";
			if(!empty($inputArray['message'])){
				$comment_message = $inputArray['message'];
			}

			$post_comment_url = "";
			if(!empty($comment_message)){
				$post_comment_url = "https://graph.facebook.com/v2.6/".$page_id."/posts?access_token=".$page_access_token;
			}

			$app_comment_results = "";
			if(!empty($inputArray)){
				$app_comment_results = SELF::FbAddAdminPagePost($post_comment_url,$inputArray,$page_access_token);
			}

			return redirect('admin/fbpage');
		}

   		public function FbAddAdminPagePost($url,$params,$page_access_token){

			$url = "https://graph.facebook.com/1056627197749548/feed";

			$attachment =  array(
				'access_token'  => $page_access_token,
				'message'       => $params['message'],
			);

			// set the target url
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$curl_response = curl_exec($ch);

			curl_close ($ch);

			$curl_response = json_decode($curl_response, TRUE);

			return $curl_response;
    	}

		public function FbPostComment($url,$params,$page_access_token){

			$attachment =  array(
				'access_token'  => $page_access_token,
				'message'       => $params['message'],
			);

			// set the target url
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$curl_response = curl_exec($ch);

			curl_close ($ch);

			$curl_response = json_decode($curl_response, TRUE);

			return $curl_response;
    	}

		public function ListFbPagePost($url){

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

		public function getFacebookFeed(){

			$page_id = "1056627197749548";
			$page_access_token="EAAYh8lMkiuoBAEs6ywU8hJvuVaP8O0JW0iHwNCxtRu34RaZCb9PDxtM78iqDbZCXERFMVMYUEr9LtNuUZBetahHYrI9itIlFEp1Hjf1CVNKVkrFreTcro3yMDXDw8Nc5jPy9I1ZCJo50GIzFKYdzQjgXPgXFET68RErOr69ACaa2INMZAqKuz";
			
			$results = "";

			$cinputArray = $responseArray = array();

			$results = SELF::ListFbPagePost("https://graph.facebook.com/v2.6/".$page_id."/feed?fields=message%2Cfrom%2Ccreated_time%2Cpicture%2Cid&access_token=".$page_access_token);

			if(!empty($results)){
				$responseArray = json_decode($results);
			}

			$fbPostArray = array();
			if(!empty($responseArray->data)){
				$fbPostArray = $responseArray->data;
			}
			/*
			echo "<pre>";
			print_r($fbPostArray);
			exit;
			*/
			return view('admin.facebookfeed',['fbpage' => $fbPostArray,'access_token' => $page_access_token]);
		}
		
	}
?>