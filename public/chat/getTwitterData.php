<?php
ob_start();

require_once("twitter/twitteroauth.php");
require_once 'config/twconfig.php';
require_once 'config/functions.php';
require_once('includes/constants.php');
session_start();
$country=$_SESSION['iptlworld2015_country'];
if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
    // We've got everything we need
    $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
// Let's request the access token
    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
// Save it in a session var
    $_SESSION['access_token'] = $access_token;
// Let's get the user's info
    $user_info = $twitteroauth->get('account/verify_credentials');
// Print user's info
    echo '<pre>';
    print_r($user_info);
    echo '</pre><br/>';
    if (isset($user_info->error)) {
        // Something's wrong, go back to square 1  
        header('Location: login-twitter.php');
    } else {
	   $twitter_otoken=$_SESSION['oauth_token'];
	   $twitter_otoken_secret=$_SESSION['oauth_token_secret'];
	   $email='';
        $uid = $user_info->id;
        $username = $user_info->name;
        $user = new User();
        $userdata = $user->checkUser($uid, 'twitter', $username,$email,$twitter_otoken,$twitter_otoken_secret,$country);
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
    }
} else {
    // Something's missing, go back to square 1
    header('Location: login-twitter.php');
}
?>
