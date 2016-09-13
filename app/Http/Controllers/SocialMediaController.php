<?php

namespace App\Http\Controllers;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\lib\TwitterAPIExchange;

class SocialMediaController extends Controller{

	public $settings = array(
            'oauth_access_token' => "749905022121484288-j04jdPDOsUtywyKM0RWl3zyyKWacDdZ",
            'oauth_access_token_secret' => "5BTR7D3SRN3OQK0ZafG8I5KrhWfUFC2I8QEDP2lhQSPxk",
            'consumer_key' => "7YFnMGXxIXZq5OAk4RKry65z3",
            'consumer_secret' => "WtYWLUoF8GbyZQhautu52RTALzO1TdCfBlItNvJq5d0q2wIeor"
        );

    public function tweet(){

        $notify_url = 'https://api.twitter.com/1.1/statuses/mentions_timeline.json';
		$home_url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
        $getfield = '';
        $requestMethod = 'GET';
		
		$twitter_notify = new TwitterAPIExchange($this->settings);

		$notify_json = $twitter_notify->setGetfield($getfield)
                    ->buildOauth($notify_url, $requestMethod)
                    ->performRequest();
		
		$twitter_home = new TwitterAPIExchange($this->settings);
		
		$home_json = $twitter_home->setGetfield($getfield)
                    ->buildOauth($home_url, $requestMethod)
                    ->performRequest();
					
		$notify_tweet_obj = json_decode($notify_json);
		$home_tweet_obj = json_decode($home_json);
		
		$user_info = array();
		if(isset($home_tweet_obj['0'])){
			$user_info = $home_tweet_obj['0']->user;
		}

		return view('admin.users.twitter_info',['notify_tweet_data'=>$notify_tweet_obj, 'home_tweet_data'=>$home_tweet_obj, 'user_info'=>$user_info]);
    }


	public function reply(Request $request){

		$inputArr = $request->all();
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
		
		return redirect()->back();

	}

	public function store(Request $request){
		
		$inputArr = $request->all();
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
		
		return redirect()->back();
	}

	public function getTweetFeed(){

		$tweeterarray = array();
		
		$notify_url = 'https://api.twitter.com/1.1/statuses/mentions_timeline.json';
		$home_url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
        $getfield = '';
        $requestMethod = 'GET';

		$twitter = new TwitterAPIExchange($this->settings);

		$notify_json = $twitter->setGetfield($getfield)
                    ->buildOauth($notify_url, $requestMethod)
                    ->performRequest();

		$home_json = $twitter->setGetfield($getfield)
                    ->buildOauth($home_url, $requestMethod)
                    ->performRequest();

        $notify_tweet_obj = json_decode($notify_json);
		$home_tweet_obj = json_decode($home_json);
		
		return view('admin.tweetfeed',['notify_tweet_data'=>$notify_tweet_obj, 'home_tweet_data'=>$home_tweet_obj]);
	}
}