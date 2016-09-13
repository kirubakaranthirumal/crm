<?php
	namespace App\Http\Controllers;

	class TwitterController extends Controller {

		public function buildBaseString($baseURI, $method, $params) {
			$r = array();
			ksort($params);
			foreach($params as $key=>$value){
				$r[] = "$key=" . rawurlencode($value);
			}
			return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
		}

		public function buildAuthorizationHeader($oauth) {
			$r = 'Authorization: OAuth ';
			$values = array();
			foreach($oauth as $key=>$value)
			$values[] = "$key=\"" . rawurlencode($value) . "\"";
			$r .= implode(', ', $values);
			return $r;
		}

		/**
		* Show the application welcome screen to the user.
		*
		* @return Response
		*/
		public function index(){

			$userId = session()->get('userId');

			$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

			$oauth_access_token = "735382078439706625-pPUMf0H0AgUkPdprfAPYTcJIvdkhPWG";
			$oauth_access_token_secret = "bkb4xpjRmlbFyqQ1Ey69BTJ5PlhqCd0aeLEcgHQywQfQW";
			$consumer_key = "JstGmMEk9HcvrNDOIwCQHnOsm";
			$consumer_secret = "u4wXrvuIu2DRaTOCBlUv1BFTeRyw6G5RAMmY5zzpWh6jTud2U6";

			$oauth = array( 'oauth_consumer_key' => $consumer_key,
							'oauth_nonce' => time(),
							'oauth_signature' => 'H4ogngjLalxCAvjCmoPmSNkW%2BDw%3D',
							'oauth_signature_method' => 'HMAC-SHA1',
							'oauth_token' => $oauth_access_token,
 							'oauth_timestamp' => time(),
 							'oauth_version' => '1.0'
 						  );

 			//print"<pre>";
 			//print_r($oauth);
 			//exit;

			$base_info = SELF::buildBaseString($url, 'GET', $oauth);
			$composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
			$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
			$oauth['oauth_signature'] = $oauth_signature;

			// Make requests
			$header = array(SELF::buildAuthorizationHeader($oauth), 'Expect:');
			$options = array( CURLOPT_HTTPHEADER => $header,
							  //CURLOPT_POSTFIELDS => $postfields,
							  CURLOPT_HEADER => false,
							  CURLOPT_URL => $url,
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_SSL_VERIFYPEER => false);

			$feed = curl_init();
			curl_setopt_array($feed, $options);
			$json = curl_exec($feed);
			curl_close($feed);

			$twitter_data = json_decode($json);

			//print it out
			//print"<pre>";
			//print_r($twitter_data);

			if(!empty($userId)){
				return view('admin.twitter',['twitter_data'=>$twitter_data]);
			}
			else{
				return redirect('admin/login_user');
			}
		}
	}
?>