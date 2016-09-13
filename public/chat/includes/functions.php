<?php
$path = realpath($_SERVER["DOCUMENT_ROOT"]);
include_once "includes/database.php";
//include_once "$path/mobile/includes/maxmind.php";
//$country=$country_id_fetch;
session_start();
class User {

    function checkUser($uid, $oauth_provider, $username,$email,$twitter_otoken,$twitter_otoken_secret,$countryid) 
	{
        $query = mysql_query("SELECT * FROM `chat_register` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
            # User is already present
        } else {
            $chars = "A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W3X4Y5Z6A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W3X4Y5Z6";
        $key = "";

        for ($i = 0; $i < 8; $i++) {
            $key .= $chars{mt_rand(0, strlen($chars) - 1)};
        }

            #user not present. Insert a new Record
      
            $ip_self=$_SERVER['REMOTE_ADDR'];
        //echo "INSERT INTO `chat_register` (oauth_provider, oauth_uid, user_name,email,promo_code) VALUES ('$oauth_provider', $uid, '$username','$email','".mysql_real_escape_string($key)."')";
            $query = mysql_query("INSERT INTO `chat_register` (oauth_provider, oauth_uid,country_id,user_country_id,user_ipaddress, user_name,email,promo_code,device_id,isactive) VALUES ('$oauth_provider', '$uid', '$countryid','$countryid','$ip_self','$username','$email','".mysql_real_escape_string($key)."','web','1')") or die(mysql_error());
            $query = mysql_query("SELECT * FROM `chat_register` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'");
            $result = mysql_fetch_array($query);
            $uid=$result[0];
            
            return $result;
        }
        return $result;
    }

    

}

?>
