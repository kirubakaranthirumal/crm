<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\lib\TwitterAPIExchange;

class SocialMediaController extends Controller{

	public $settings = array(
            'oauth_access_token' => "749905022121484288-pa0gejV2kcUMAJbmWXIPmUtcgGe83B8",
            'oauth_access_token_secret' => "eIzDoeQJWmAsKrfHW1r9GGuI69a6oTGUKJ0MFzFZkyVj7",
            'consumer_key' => "5P7DEeR2uKd0joiz4H0FAlKTB",
            'consumer_secret' => "fzeeQOU1JJDicA31hKOVmKjkzEIJav2khqM9vMGv3NIPhgb7br"
        );

    public function tweet(){

        $notify_url = 'https://api.twitter.com/1.1/statuses/mentions_timeline.json';
		$home_url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
        $getfield = '';
        $requestMethod = 'GET';

		$twitter = new TwitterAPIExchange($this->settings);

		$notify_json = $twitter->setGetfield($getfield)
                    ->buildOauth($notify_url, $requestMethod)
                    ->performRequest();

		//echo "<pre>";
		//print_r($notify_json);
		//exit;

		$home_json = $twitter->setGetfield($getfield)
                    ->buildOauth($home_url, $requestMethod)
                    ->performRequest();


        $notify_tweet_obj = json_decode($notify_json);
		$home_tweet_obj = json_decode($home_json);
		$user_info = $home_tweet_obj['0']->user;

		return view('admin.users.twitter_info',['notify_tweet_data'=>$notify_tweet_obj, 'home_tweet_data'=>$home_tweet_obj, 'user_info'=>$user_info]);


    }


	public function reply(Request $request){

		$inputArr = $request->all();
		//print_r($inputArr);
		//exit;
		$url = 'https://api.twitter.com/1.1/statuses/update.json';
		$requestMethod = 'POST';

		if(!empty($inputArr['id'])){

			/** POST fields required by the URL above. See relevant docs as above **/
			$postfields = array(
				'status' => '@'.$inputArr['screen_name'].' '.$inputArr['status'],
				'in_reply_to_status_id' => $inputArr['id']
			);
		}else{
			$postfields = array(
				'status' => $inputArr['status']
			);
		}
		/** Perform a POST request and echo the response **/
		$twitter = new TwitterAPIExchange($this->settings);

		$twitter->buildOauth($url, $requestMethod)
					 ->setPostfields($postfields)
					 ->performRequest();

		//exit;
		return redirect()->back();


	}


	public function store(Request $request){
		$inputArr = $request->all();
		//print_r($inputArr);
		//exit;
		$url = 'https://api.twitter.com/1.1/statuses/update.json';
		$requestMethod = 'POST';

		if(!empty($inputArr['id'])){

			/** POST fields required by the URL above. See relevant docs as above **/
			$postfields = array(
				'status' => '@'.$inputArr['screen_name'].' '.$inputArr['status'],
				'in_reply_to_status_id' => $inputArr['id']
			);
		}else{
			$postfields = array(
				'status' => $inputArr['status']
			);
		}
		/** Perform a POST request and echo the response **/
		$twitter = new TwitterAPIExchange($this->settings);

		$twitter->buildOauth($url, $requestMethod)
					 ->setPostfields($postfields)
					 ->performRequest();

		//exit;
		return redirect()->back();
	}

}