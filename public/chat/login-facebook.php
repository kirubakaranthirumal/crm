<?php
require_once('includes/constants.php');
require_once 'facebook/facebook.php';
require_once 'includes/fbconfig.php';
require_once 'includes/functions.php';
session_start();
$facebook = new Facebook(array(
            'appId' => APP_ID,
            'secret' => APP_SECRET,
            ));

$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
    if (!empty($user_profile )) {
        # User info ok? Let's print it (Here we will be adding the login and registering routines)
  
        $username = $user_profile['name'];
		$uid = $user_profile['id'];
		$email = $user_profile['email'];
        $user = new User();
        $userdata = $user->checkUser($uid, 'facebook', $username,$email,$twitter_otoken,$twitter_otoken_secret,$country);
        if(!empty($userdata)){
            session_start();
            $_SESSION[USERID]=$userdata['id'];
            $_SESSION[OAUTHID] = $uid;
            $_SESSION[USERFULLNAME] = $userdata['user_name'];
			$_SESSION[USEREMAIL] = $userdata['email'];
            $_SESSION[OAUTHPROVIDER] = $userdata['oauth_provider'];
            $_SESSION[PROMOCODE]=$userdata['promo_code'];
            setcookie(USERID, $userdata['id'], time() + (86400 * 30), "/"); // 86400 = 1 day
            setcookie(USERFULLNAME, $userdata['user_name'], time() + (86400 * 30), "/"); // 86400 = 1 day
            header('location:login.php');
        }
    } else {
        # For testing purposes, if there was an error, let's kill the script
        die("There was an error.");
    }
} else {
    # There's no active session, let's generate one
	$login_url = $facebook->getLoginUrl(array( 'req_perms'=>'email','scope' => 'email'));
    header("Location: " . $login_url);
}
?>
