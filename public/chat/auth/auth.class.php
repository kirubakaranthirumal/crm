<?php
error_reporting(0);
session_start();
require_once("../includes/constants.php");
/*
* Auth class
* Works with PHP 5.4 and above.
*/

class Auth
{
	private $dbh;
	public $config;
	public $lang;

	/*
	* Initiates database connection
	*/

	public function __construct(\PDO $dbh, $config, $lang)
	{
		$this->dbh = $dbh;
		$this->config = $config;
		$this->lang = $lang;

		if (version_compare(phpversion(), '5.5.0', '<')) {
			require("files/password.php");
		}
	}

	/*
	* Logs a user in
	* @param string $email
	* @param string $password
	* @param bool $remember
	* @return array $return
	*/
	public function newchatroom($uid, $name)
	{
		if ($name=='') {
			$return['error'] = true;
			$return['message'] = "Please enter chat room name";
		}
		else if ($this->isNameTaken($name)) {
			$return['error'] = true;
			$return['message'] = "Chat Room Already Exists";
		}
		else
		{
		$query = $this->dbh->prepare("INSERT INTO {$this->config->table_chatroom} (uid, name, cdate) VALUES (?, ?, ?)");
		$query->execute(array($uid, mysql_real_escape_string($name),date('Y-m-d')));
		$return['error'] = false;
		$return['message'] = $this->lang["chat_room_created"];
		$return['stream'] = $name;
		}
		return $return;
	}
	public function approvechatroom($cid, $rid)
	{
		$chatroom=$this->getRoom($rid);
		$query = $this->dbh->prepare("UPDATE {$this->config->table_invitations} set is_approved=? where  cid=? and rid=?");
		$query->execute(array('1',$cid,$rid));
		$query = $this->dbh->prepare("INSERT INTO {$this->config->table_last_session} (uid,utype,last_stream_id,last_stream) values(?,?,?,?)");
		$query->execute(array($cid,'2',$rid,$chatroom['name']));
		return $return;
	}
	public function joinchatroom($cid, $name,$rid,$type)
	{
		if ($name=='') {
			$return['error'] = true;
			$return['message'] = "Please enter your name";
		}
		else
		{

		$query = $this->dbh->prepare("UPDATE {$this->config->table_invitations} SET is_joined = ? WHERE cid = ? and id=?");
		$query->execute(array('1',$cid,$rid));
		$query = $this->dbh->prepare("UPDATE {$this->config->table_contacts} SET name = ? WHERE id = ?");
		$query->execute(array($name,$cid));
		$online = $this->getOnlineUser($cid,$type,$rid);
		if($online!='')
		{
			$query = $this->dbh->prepare("update {$this->config->table_online} set rid='".$rid."' where uid='".$online."' and otype='".$type."'");
			$query->execute();	
		}
		else
		{
			$query = $this->dbh->prepare("insert into {$this->config->table_online} values('','2','".$cid."','".$rid."','".$type."')");
			$query->execute();	
		}

		$stream=$this->getRoom($rid);
		$_SESSION['chat_cid']=$cid;
		$_SESSION['chat_utype']=$type;
		$_SESSION['chat_rid']=$rid;
		$_SESSION['stream']=$stream['name'];
		$return['error'] = false;
		$return['message'] = $this->lang["chat_room_created"];
		$return['stream'] = $name;
		$return['cid'] = $cid;
		$return['rid'] = $rid;
		}
		return $return;
	}
	public function login($email, $password, $remember = 1,$ltype,$uname_type,$name)
	{
		$return['error'] = true;
		$check=$this->getUserSessionUID($email);
		if($ltype=='social')
		{
			if (!$this->isEmailTaken($email)) {
				$this->register($email,"iptl","iptl","email");
			}
		$uid = $this->getUID(strtolower($email));
		$uname = $this->getUname(strtolower($email));
		$promocode = $this->getPromoCode(strtolower($email));		
		if($check)
		{
			$return['error'] = true;
			$return['message'] = "A session already exists do you want to continue?";
		}
		else
		{
		$return['error'] = false;
		$return['message'] = $this->lang["logged_in"];
		$sessiondata = $this->addSession($user['uid'], $remember);
		$return['hash'] = $sessiondata['hash'];
		$return['expire'] = $sessiondata['expiretime'];
		$_SESSION[USERID]=$uid;
		$_SESSION[USEREMAIL]=$email;	
		$_SESSION[PROMOCODE]=$promocode;	
		$_SESSION[USERFULLNAME]=$uname;
		setcookie(COOKIE_USERNAME, $uname, time() + (86400 * 30), "/"); // 86400 = 1 day
		setcookie(COOKIE_USERID, $uid, time() + (86400 * 30), "/"); // 86400 = 1 day	
		}
		}
		else
		{
		if($check)
		{
			$return['error'] = true;
			$return['message'] = "A session already exists do you want to continue?";
		}
		else
		{
		$return['error'] = true;
		/*if($email=='' && $password=='') {
			$return['message'] = $this->lang["email_password_empty"];
			return $return;
		}*/
		if($email=='') {
			$return['message'] = $this->lang["email_empty"];
			return $return;
		}
			$validateEmail = $this->validateEmail($email);
			if ($validateEmail['error'] == 1) {
				//$this->addAttempt();

				$return['message'] = $this->lang["email_invalid"];
				return $return;
			} 
		
		if (!$this->isEmailTaken($email)) {
			//$this->addAttempt();

			$return['message'] = $this->lang["email_not_taken"];
			return $return;
		}
		if($password=='') {
			$return['message'] = $this->lang["password_empty"];
			return $return;
		}
		if ($this->isBlocked()) {
			$return['message'] = $this->lang["user_blocked"];
			return $return;
		}		
		$validatePassword = $this->validatePassword($password);
		if($validatePassword['error'] == 1) {
			//$this->addAttempt();

			$return['message'] = $this->lang["password_incorrect"];
			return $return;
		} elseif($remember != 0 && $remember != 1) {
			//$this->addAttempt();

			$return['message'] = $this->lang["remember_me_invalid"];
			return $return;
		}
		
		$uid = $this->getUID(strtolower($email));
		$uname = $this->getUname(strtolower($email));
		$promocode = $this->getPromoCode(strtolower($email));
		if(!$uid) {
			//$this->addAttempt();

			$return['message'] = $this->lang["email_incorrect"];
			return $return;
		}

		$user = $this->getUser($uid);

		if (!password_verify($password, $user['password'])) {
			//$this->addAttempt();

			$return['message'] = $this->lang["password_incorrect"];
			return $return;
		}

		if ($user['isactive'] != 1) {
			//$this->addAttempt();

			$return['message'] = $this->lang["account_inactive"];
			return $return;
		}

		$sessiondata = $this->addSession($user['uid'], $remember);

		if($sessiondata == false) {
			$return['message'] = $this->lang["system_error"] . " #01";
			return $return;
		}
		$return['error'] = false;
		$return['message'] = $this->lang["logged_in"];
		//$query = $this->dbh->prepare("UPDATE {$this->config->table_menu} SET displayName = 'Logout',titleapps='Logout',link='#logout' WHERE menuid = 108");
		//$query->execute(array("Logout"));
		
		
		$return['hash'] = $sessiondata['hash'];
		$return['uid'] = $uid;
		$return['expire'] = $sessiondata['expiretime'];
		$_SESSION[USERID]=$uid;
		$_SESSION['chat_utype']="1";
		$_SESSION[USEREMAIL]=$email;
		$_SESSION[PROMOCODE]=$promocode;				
		$_SESSION[USERFULLNAME]=$uname;
		setcookie(COOKIE_USERNAME, $uname, time() + (86400 * 30), "/"); // 86400 = 1 day
		setcookie(COOKIE_USERID, $uid, time() + (86400 * 30), "/"); // 86400 = 1 day	
		$query = $this->dbh->prepare("update {$this->config->table_users} set is_online='1' where email='".$email."'");
		$query->execute();
		$online = $this->getOnlineUser($uid,'1','');
		$lastsession = $this->getLastStream($uid,'1');
		$rid=$lastsession['last_stream_id'];
		if($online['uid']!='')
		{
			$query = $this->dbh->prepare("update {$this->config->table_online} set is_active='1',rid='".$rid."' where uid='".$online['uid']."' and otype='1'");
			$query->execute();	
		}
		else
		{
			$query = $this->dbh->prepare("insert into {$this->config->table_online} values('','1','".$uid."','".$rid."','1')");
			$query->execute();	
		}

	}
	}
		
		return $return;
	}

	/*
	* Creates a new user, adds them to database
	* @param string $email
	* @param string $password
	* @param string $repeatpassword
	* @return array $return
	*/

	public function register($email, $password, $repeatpassword,$uname_type,$full_name,$procode,$country,$ipaddress)
	{
		$return['error'] = true;

		if ($this->isBlocked()) {
			$return['message'] = $this->lang["user_blocked"];
			return $return;
		}
		if($full_name=='') {
			$return['message'] = $this->lang["name_empty"];
			return $return;
		}
		if(strlen($full_name)<3) {
			$return['message'] = $this->lang["name_short"];
			return $return;
		}
		if($email=='') {
			$return['message'] = $this->lang["email_empty"];
			return $return;
		}
		$validateEmail = $this->validateEmail($email);
		if ($validateEmail['error'] == 1) {
			$return['message'] = $validateEmail['message'];
			return $return;
		}
		if ($this->isEmailTaken($email)) {
			//$this->addAttempt();
			$return['message'] = $this->lang["email_taken"];
			return $return;
		}
		if($password=='') {
			$return['message'] = $this->lang["password_empty"];
			return $return;
		}
		
		if (strlen($password) < 6) {
			$return['message'] = $this->lang["password_short"];
			return $return;
		}
		
		$validatePassword = $this->validatePassword($password);
		if ($validatePassword['error'] == 1) {
			$return['message'] = $this->lang["password_wrong"];
			return $return;
		}
		if($repeatpassword=='') {
			$return['message'] = $this->lang["cpassword_empty"];
			return $return;
		}
		if($password !== $repeatpassword) {
			$return['message'] = $this->lang["password_nomatch"];
			return $return;
		}
		if($procode!=''){
			if ($this->isInvalidPromoCode($procode)) {
				//$this->addAttempt();
				$return['message'] = $this->lang["promo_code_invalid"];
				return $return;
			}
		}
		

		$addUser = $this->addUser($email, $password,$uname_type,$full_name,$procode,$country,$ipaddress);

		if($addUser['error'] != 0) {
			$return['message'] = $addUser['message'];
			return $return;
		}

		$return['error'] = false;
		$return['otp']=$addUser['otp'];
		$_SESSION['chat_utype']="1";
		$return['message'] = $this->lang["register_success"];
		$return['email']=$email;
		$uid = $this->getUID(strtolower($email));
		$uname = $this->getUname(strtolower($email));
		$promocode = $this->getPromoCode(strtolower($email));
		$_SESSION[USERID]=$uid;
		$_SESSION[USEREMAIL]=$email;	
		$_SESSION[PROMOCODE]=$promocode;	
		$_SESSION[USERFULLNAME]=$uname;
		setcookie(COOKIE_USERNAME, $uname, time() + (86400 * 30), "/"); // 86400 = 1 day
		setcookie(COOKIE_USERID, $uid, time() + (86400 * 30), "/"); // 86400 = 1 day
		$query = $this->dbh->prepare("update {$this->config->table_users} set is_online='1' where email='".$email."'");
		$query->execute();	
		return $return;
	}

	/*
	* Activates a user's account
	* @param string $key
	* @return array $return
	*/

	public function activate($key)
	{
		$return['error'] = true;

		if($this->isBlocked()) {
			$return['message'] = $this->lang["user_blocked"];
			return $return;
		}

		if(strlen($key) <13) {
			//$this->addAttempt();

			$return['message'] = $this->lang["activationkey_invalid"].$key;
			return $return;
		}

		$getRequest = $this->getRequest($key, "activation");

		if($getRequest['error'] == 1) {
			$return['message'] = $getRequest['message'];
			return $return;
		}

		if($this->getUser($getRequest['uid'])['isactive'] == 1) {
			//$this->addAttempt();
			$this->deleteRequest($getRequest['id']);

			$return['message'] = $this->lang["system_error"] . " #02";
			return $return;
		}

		$query = $this->dbh->prepare("UPDATE {$this->config->table_users} SET isactive = ? WHERE id = ?");
		$query->execute(array(1, $getRequest['uid']));

		$this->deleteRequest($getRequest['id']);

		$return['error'] = false;
		$return['message'] = $this->lang["account_activated"];

		return $return;
	}

	/*
	* Creates a reset key for an email address and sends email
	* @param string $email
	* @return array $return
	*/

	public function requestReset($email)
	{
		$return['error'] = true;

		

		if ($this->isBlocked()) {
			$return['message'] = $this->lang["user_blocked"];
			return $return;
		}

		$validateEmail = $this->validateEmail($email);

		if ($validateEmail['error'] == 1) {
			$return['message'] = $this->lang["email_invalid"];
			return $return;
		}

		if (!$this->isEmailTaken($email)) {
			//$this->addAttempt();
			$return['message'] = $this->lang["email_not_taken"];
			return $return;
		}
		$query = $this->dbh->prepare("SELECT id FROM {$this->config->table_users} WHERE email = ?");
		$query->execute(array($email));

		if ($query->rowCount() == 0) {
			//$this->addAttempt();

			$return['message'] = $this->lang["email_incorrect"];
			return $return;
		}

		$addRequest = $this->addRequest($query->fetch(PDO::FETCH_ASSOC)['id'], $email, "reset");
		if ($addRequest['error'] == 1) {
			//$this->addAttempt();

			$return['message'] = $addRequest['message'];
			return $return;
		}

		$return['error'] = false;
		$return['message'] = $this->lang["reset_requested"];

		return $return;
	}

	public function requestInvitation($email,$stream,$uid,$check)
	{
		$return['error'] = true;

		

		/*if ($this->isBlocked()) {
			$return['message'] = $this->lang["user_blocked"];
			return $return;
		}*/

		$validateEmail = $this->validateEmail($email);

		if ($validateEmail['error'] == 1) {
			$return['message'] = $this->lang["email_invalid"];
			return $return;
		}
		$query = $this->dbh->prepare("SELECT id FROM {$this->config->table_users} WHERE email = ?");
		$query->execute(array($email));

		if ($query->rowCount() == 0) {
			//$this->addAttempt();

			//$return['message'] = $this->lang["email_incorrect"];
			//return $return;
		}
		
		if($check=='')
		{
		$addRequest = $this->addRequest($query->fetch(PDO::FETCH_ASSOC)['id'], $email, "invitation",'','',$stream,$uid);
		if ($addRequest['error'] == 1) {
			//$this->addAttempt();

			$return['message'] = $addRequest['message'];
			return $return;
		}

			$return['error'] = false;
			$return['message'] = "Invitation has been sent";
		}
		else
		{
			$return['error'] = true;
			$return['message'] = "Invitation already has been sent";
		}
		return $return;
	}

	/*
	* Logs out the session, identified by hash
	* @param string $hash
	* @return boolean
	*/

	public function logout($hash)
	{
		//$query = $this->dbh->prepare("UPDATE {$this->config->table_menu} SET displayName = 'Login/Register',titleapps='Login/Register',link='/login' WHERE menuid = 108");
		//$query->execute(array("Login/Register"));
		//if (strlen($hash) != 40) {
		//	return false;
		//}

		return $this->deleteSession($hash);
	}

    /*
    * Provides a randomly generated salt for hashing the password
    * @return string
    */

    public function getSalt()
    {
        return substr(strtr(base64_encode(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)), '+', '.'), 0, 22);
    }

	/*
	* Hashes provided password with Bcrypt
	* @param string $password
	* @param string $password
	* @return string
	*/

	public function getHash($password)
	{
		return password_hash($password, PASSWORD_BCRYPT, ['salt' => $this->getSalt(), 'cost' => $this->config->bcrypt_cost]);
	}

	/*
	* Gets UID for a given email address and returns an array
	* @param string $email
	* @return array $uid
	*/

	public function getUID($email)
	{
		$query = $this->dbh->prepare("SELECT id FROM {$this->config->table_users} WHERE email = ?");
		$query->execute(array($email));

		if($query->rowCount() == 0) {
			return false;
		}

		return $query->fetch(PDO::FETCH_ASSOC)['id'];
	}

	public function getUname($email)
	{
		$query = $this->dbh->prepare("SELECT user_name FROM {$this->config->table_users} WHERE email = ?");
		$query->execute(array($email));

		if($query->rowCount() == 0) {
			return false;
		}

		return $query->fetch(PDO::FETCH_ASSOC)['user_name'];
	}


public function getPromoCode($email)
	{
		$query = $this->dbh->prepare("SELECT promo_code FROM {$this->config->table_users} WHERE email = ?");
		$query->execute(array($email));

		if($query->rowCount() == 0) {
			return false;
		}

		return $query->fetch(PDO::FETCH_ASSOC)['promo_code'];
	}
	/*
	* Creates a session for a specified user id
	* @param int $uid
	* @param boolean $remember
	* @return array $data
	*/

	private function updatemenu()
	{
		


		$query = $this->dbh->prepare("UPDATE {$this->config->table_menu} SET displayName = ?, titleappas = ?,link=? WHERE menuid = ?");

		if(!$query->execute(array("Logout", "Logout","https://beta.cricketgateway.com/iptltest/www/index.html#logout","108"))) {
			return false;
		}

		$data['message'] = "success";
		return $data;
	}

	private function addSession($uid, $remember)
	{
		$ip = $this->getIp();
		$user = $this->getUser($uid);

		if(!$user) {
			return false;
		}

		$data['hash'] = sha1($this->config->site_key . microtime());
		$agent = $_SERVER['HTTP_USER_AGENT'];

		$this->deleteExistingSessions($uid);

		if($remember == true) {
			$data['expire'] = date("Y-m-d H:i:s", strtotime($this->config->cookie_remember));
			$data['expiretime'] = strtotime($data['expire']);
		} else {
			$data['expire'] = date("Y-m-d H:i:s", strtotime($this->config->cookie_remember));
			$data['expiretime'] = 0;
		}

		$data['cookie_crc'] = sha1($data['hash'] . $this->config->site_key);

		$query = $this->dbh->prepare("INSERT INTO {$this->config->table_sessions} (uid, hash, expiredate, ip, agent, cookie_crc) VALUES (?, ?, ?, ?, ?, ?)");

		if(!$query->execute(array($uid, $data['hash'], $data['expire'], $ip, $agent, $data['cookie_crc']))) {
			return false;
		}

		$data['expire'] = strtotime($data['expire']);
		return $data;
	}

	/*
	* Removes all existing sessions for a given UID
	* @param int $uid
	* @return boolean
	*/

	private function deleteExistingSessions($uid)
	{
		$query = $this->dbh->prepare("DELETE FROM {$this->config->table_sessions} WHERE uid = ?");

		return $query->execute(array($uid));
	}

	/*
	* Removes a session based on hash
	* @param string $hash
	* @return boolean
	*/

	private function deleteSession($hash)
	{
		$query = $this->dbh->prepare("DELETE FROM {$this->config->table_sessions} WHERE uid = ?");
		session_destroy();
		return $query->execute(array($hash));
	}

	/*
	* Function to check if a session is valid
	* @param string $hash
	* @return boolean
	*/

	public function checkSession($uid)
	{
		$ip = $this->getIp();

		if ($this->isBlocked()) {
			return false;
		}

		if (strlen($hash) != 40) {
			return false;
		}

		$query = $this->dbh->prepare("SELECT id, uid, expiredate, ip, agent, cookie_crc FROM {$this->config->table_sessions} WHERE uid = ?");
		$query->execute(array($uid));

		if ($query->rowCount() == 0) {
			return false;
		}

		$row = $query->fetch(PDO::FETCH_ASSOC);

		$sid = $row['id'];
		$uid = $row['uid'];
		$expiredate = strtotime($row['expiredate']);
		$currentdate = strtotime(date("Y-m-d H:i:s"));
		$db_ip = $row['ip'];
		$db_agent = $row['agent'];
		$db_cookie = $row['cookie_crc'];

		if ($currentdate > $expiredate) {
			$this->deleteExistingSessions($uid);

			return false;
		}

		if ($ip != $db_ip) {
			return false;
		}


		if ($db_cookie == sha1($hash . $this->config->site_key)) {
			return true;
		}
		if($uid!='')
		{
				return true;
		}

		return false;
	}

	/*
	* Retrieves the UID associated with a given session hash
	* @param string $hash
	* @return int $uid
	*/

	public function getSessionUID($hash)
	{
		$query = $this->dbh->prepare("SELECT uid FROM {$this->config->table_sessions} WHERE hash = ?");
		$query->execute(array($hash));

		if ($query->rowCount() == 0) {
			return false;
		}

		return $query->fetch(PDO::FETCH_ASSOC)['uid'];
	}
	public function getUserSessionUID($uid)
	{
		$query = $this->dbh->prepare("SELECT uid FROM {$this->config->table_sessions} WHERE uid = ?");
		$query->execute(array($uid));

		if ($query->rowCount() == 0) {
			return false;
		}

		return $query->fetch(PDO::FETCH_ASSOC)['uid'];
	}
	public function getOnlineUser($uid,$type,$rid)
	{
		$query = $this->dbh->prepare("SELECT uid FROM {$this->config->table_online} WHERE uid = ? and otype=?");
		$query->execute(array($uid,$type));

		if ($query->rowCount() == 0) {
			return false;
		}

		return $query->fetch(PDO::FETCH_ASSOC)['uid'];
	}
	public function getLastStream($uid,$type)
	{
		$query = $this->dbh->prepare("SELECT last_stream_id FROM {$this->config->table_last_session} WHERE uid = ? and utype=?");
		$query->execute(array($uid,$type));

		if ($query->rowCount() == 0) {
			return false;
		}

		return $query->fetch(PDO::FETCH_ASSOC)['last_stream_id'];
	}
	public function getRoom($rid)
	{
		$query = $this->dbh->prepare("SELECT name FROM {$this->config->table_rooms} WHERE id = ?");
		$query->execute(array($rid));

		if ($query->rowCount() == 0) {
			return false;
		}

		return $query->fetch(PDO::FETCH_ASSOC)['name'];
	}

	public function getInvitationId($email,$stream)
	{
		
		$query = $this->dbh->prepare("SELECT uid FROM {$this->config->table_invitations} WHERE $cid = ? and rid=? ");
		$query->execute(array($email,$stream));

		if ($query->rowCount() == 0) {
			return false;
		}

		return $query->fetch(PDO::FETCH_ASSOC)['uid'];
	}
	public function getContactId($email)
	{
		
		$query = $this->dbh->prepare("SELECT id FROM {$this->config->table_contacts} WHERE email = ?");
		$query->execute(array($email));

		if ($query->rowCount() == 0) {
			return false;
		}

		return $query->fetch(PDO::FETCH_ASSOC)['id'];
	}
	

	/*
	* Checks if an email is already in use
	* @param string $email
	* @return boolean
	*/

	private function isEmailTaken($email)
	{
		$query = $this->dbh->prepare("SELECT * FROM {$this->config->table_users} WHERE email = ?");
		$query->execute(array($email));

		if ($query->rowCount() == 0) {
			return false;
		}

		return true;
	}

	private function isNameTaken($name)
	{
		$query = $this->dbh->prepare("SELECT * FROM {$this->config->table_chatroom} WHERE name = ?");
		$query->execute(array($name));

		if ($query->rowCount() == 0) {
			return false;
		}

		return true;
	}

	/*
	* Checks if an promo code is already in use
	* @param string $promocode
	* @return boolean
	*/

	private function isInvalidPromoCode($procode)
	{
		$query = $this->dbh->prepare("SELECT * FROM {$this->config->table_users} WHERE promo_code = ?");
		$query->execute(array($procode));

		if ($query->rowCount() == 0) {
			return true;
		}

		return false;
	}

	/*
	* Adds a new user to database
	* @param string $email
	* @param string $password
	* @return int $uid
	*/

	private function addUser($email, $password,$uname_type,$full_name,$procode,$country,$ipaddress)
	{
		$return['error'] = true;

		$query = $this->dbh->prepare("INSERT INTO {$this->config->table_users}(email,password,pass,user_name,country_id,user_country_id,user_ipaddress) VALUES ('$email','$password','$password','$full_name','$country','$country','$ipaddress')");

		if(!$query->execute()) {
			$return['message'] = $this->lang["system_error"] . " #03";
			return $return;
		}

		$uid = $this->dbh->lastInsertId();
		$email = htmlentities(strtolower($email));

		$addRequest = $this->addRequest($uid, $email, "activation",$uname_type,$procode);

		if($addRequest['error'] == 1) {
			$query = $this->dbh->prepare("DELETE FROM {$this->config->table_users} WHERE id = ?");
			$query->execute(array($uid));

			$return['message'] = $addRequest['message'];
			return $return;
		}

		$password = $this->getHash($password);

		$query = $this->dbh->prepare("UPDATE {$this->config->table_users} SET email = ?, password = ?,isactive=? WHERE id = ?");

		if(!$query->execute(array($email, $password,'1', $uid))) {
			$query = $this->dbh->prepare("DELETE FROM {$this->config->table_users} WHERE id = ?");
			$query->execute(array($uid));

			$return['message'] = $this->lang["system_error"] . " #04";
			return $return;
		}
		$return['error'] = false;	
		$return['otp'] = $addRequest['otp'];			
		return $return;
	}

	/*
	* Gets user data for a given UID and returns an array
	* @param int $uid
	* @return array $data
	*/

	public function getUser($uid)
	{
		$query = $this->dbh->prepare("SELECT email, password,pass, isactive FROM {$this->config->table_users} WHERE id = ?");
		$query->execute(array($uid));

		if ($query->rowCount() == 0) {
			return false;
		}

		$data = $query->fetch(PDO::FETCH_ASSOC);

		if (!$data) {
			return false;
		}

		$data['uid'] = $uid;
		return $data;
	}
	public function getContact($email)
	{
		$query = $this->dbh->prepare("SELECT id,email FROM {$this->config->table_contacts} WHERE email = ?");
		$query->execute(array($email));

		if ($query->rowCount() == 0) {
			return false;
		}

		$data = $query->fetch(PDO::FETCH_ASSOC);

		if (!$data) {
			return false;
		}
		return $data;
	}
	public function getUserPromo($procode)
	{
		$query = $this->dbh->prepare("SELECT id FROM {$this->config->table_users} WHERE promo_code = ?");
		$query->execute(array($procode));

		if ($query->rowCount() == 0) {
			return false;
		}

		$data = $query->fetch(PDO::FETCH_ASSOC);

		if (!$data) {
			return false;
		}
		return $data;
	}

	public function getEvent($event)
	{
		$query = $this->dbh->prepare("SELECT event_id FROM {$this->config->table_events} WHERE event_name = ?");
		$query->execute(array($event));

		if ($query->rowCount() == 0) {
			return false;
		}

		$data = $query->fetch(PDO::FETCH_ASSOC);

		if (!$data) {
			return false;
		}
		
		return $data;
	}

	public function updatePoint($uid,$promo_code)
	{
		$query = $this->dbh->prepare("SELECT id FROM {$this->config->table_users} WHERE promo_code = ?");
		$query->execute(array($promo_code));

		if ($query->rowCount() == 0) {
			return false;
		}

		$data = $query->fetch(PDO::FETCH_ASSOC);

		if (!$data) {
			return false;
		}
		
		return $data;
	}
	
	public function getFeature($feature)
	{
		$query = $this->dbh->prepare("SELECT feature_id,points FROM {$this->config->table_features} WHERE feature_name = ?");
		$query->execute(array($feature));

		if ($query->rowCount() == 0) {
			return false;
		}

		$data = $query->fetch(PDO::FETCH_ASSOC);

		if (!$data) {
			return false;
		}
		return $data;
	}

	
	/*
	* Allows a user to delete their account
	* @param int $uid
	* @param string $password
	* @return array $return
	*/

	public function deleteUser($uid, $password)
	{
		$return['error'] = true;

		if ($this->isBlocked()) {
			$return['message'] = $this->lang["user_blocked"];
			return $return;
		}

		$validatePassword = $this->validatePassword($password);

		if($validatePassword['error'] == 1) {
			//$this->addAttempt();

			$return['message'] = $validatePassword['message'];
			return $return;
		}

		$getUser = $this->getUser($uid);

		if(!password_verify($password, $getUser['password'])) {
			//$this->addAttempt();

			$return['message'] = $this->lang["password_incorrect"];
			return $return;
		}

		$query = $this->dbh->prepare("DELETE FROM {$this->config->table_users} WHERE id = ?");

		if(!$query->execute(array($uid))) {
			$return['message'] = $this->lang["system_error"] . " #05";
			return $return;
		}

		$query = $this->dbh->prepare("DELETE FROM {$this->config->table_sessions} WHERE uid = ?");

		if(!$query->execute(array($uid))) {
			$return['message'] = $this->lang["system_error"] . " #06";
			return $return;
		}

		$query = $this->dbh->prepare("DELETE FROM {$this->config->table_requests} WHERE uid = ?");

		if(!$query->execute(array($uid))) {
			$return['message'] = $this->lang["system_error"] . " #07";
			return $return;
		}

		$return['error'] = false;
		$return['message'] = $this->lang["account_deleted"];

		return $return;
	}

	/*
	* Creates an activation entry and sends email to user
	* @param int $uid
	* @param string $email
	* @return boolean
	*/
private function send_invitation($email)
	{
		require 'PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;
		if($this->config->smtp) {
			$mail->isSMTP();
			$mail->Host = $this->config->smtp_host;
			$mail->SMTPAuth = $this->config->smtp_auth;
			if(!is_null($this->config->smtp_auth)) {
            			$mail->Username = $this->config->smtp_username;
            			$mail->Password = $this->config->smtp_password;
            		}
			$mail->Port = $this->config->smtp_port;

			if(!is_null($this->config->smtp_security)) {
				$mail->SMTPSecure = $this->config->smtp_security;
			}
		}

		$mail->From = $this->config->site_email;
		$mail->FromName = $this->config->site_name;
		$mail->addAddress($email);
		$mail->isHTML(true);		
		$mail->Subject = sprintf($this->lang['email_invitation_subject'], $this->config->site_name);
		$mail->Body = sprintf($this->lang['email_invitation_body'], $this->config->site_url, $this->config->site_activation_page, $key);
		$mail->AltBody = sprintf($this->lang['email_invitation_altbody'], $this->config->site_url, $this->config->site_activation_page, $key);
		$mail->send();
	}
	private function addRequest($uid, $email, $type,$uname_type,$procode,$stream,$uid_chat)
	{
		require 'PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;
		$user=$this->getUser($uid);
		$return['error'] = true;

		if($type != "activation" && $type != "reset" && $type != "invitation") {
			$return['message'] = $this->lang["system_error"] . " #08";
			return $return;
		}

		$query = $this->dbh->prepare("SELECT id, expire FROM {$this->config->table_requests} WHERE uid = ? AND type = ?");
		$query->execute(array($uid, $type));

		if($query->rowCount() > 0) {
			$row = $query->fetch(PDO::FETCH_ASSOC);

			$expiredate = strtotime($row['expire']);
			$currentdate = strtotime(date("Y-m-d H:i:s"));

			//if ($currentdate < $expiredate) {
			//	$return['message'] = $this->lang["reset_exists"];
			//	return $return;
			//}

			$this->deleteRequest($row['id']);
		}

		if($type == "activation" && $this->getUser($uid)['isactive'] == 1) {
			$return['message'] = $this->lang["already_activated"];
			return $return;
		}
		if($type=='activation')
		{
		$key = $this->getRandomKey(8);
		$expire = date("Y-m-d H:i:s", strtotime("+1 day"));
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
			$device="Mobile";
			$register_type="1";
		}
		else
		{
			$device="Web";
			$register_type="2";
		}
		$eventid=$this->getEvent("IPTL");
		$featureid=$this->getFeature("Register");
		$featurefr=$this->getFeature("Friend Referral");
		//If user enters promo code
		if($procode!='')
		{
		$promouser=$this->getUserPromo($procode);
		$query = $this->dbh->prepare("INSERT INTO {$this->config->table_gamification} (user_id,event_id,feature_id,game_feature_points) VALUES (?, ?, ?, ?)");
		$query->execute(array($promouser['id'],$eventid['event_id'], $featurefr['feature_id'],$featurefr['points']));
		$query = $this->dbh->prepare("INSERT INTO {$this->config->table_mypoints} (user_id, feature_id, user_points, event_id) VALUES (?, ?, ?, ?)");
		$query->execute(array($promouser['id'], $featurefr['feature_id'],$featurefr['points'], $eventid['event_id']));
		}

		//Update promo Code
		$query = $this->dbh->prepare("UPDATE {$this->config->table_users} SET promo_code = ?,referred_user_id=?,device_id=?,register_type=? WHERE id = ?");
		$query->execute(array($key,$promouser['id'],$device,$register_type, $uid));

		//mysql_query("insert into iptl_gamification(user_id,event_id,feature_id,game_feature_points) values ('".$uid."','".$eventid['event_id']."','".$featureid['feature_id']."','".$featureid['points']."')");
		//mysql_query("insert into iptl_gamification(user_id,event_id,feature_id,game_feature_points) values ('".$promouser['id']."','".$eventid['event_id']."','".$featurefr['feature_id']."','".$featurefr['points']."')");
		$query = $this->dbh->prepare("INSERT INTO {$this->config->table_mypoints} (user_id, feature_id, user_points, event_id) VALUES (?, ?, ?, ?)");
		$query->execute(array($uid, $featureid['feature_id'],$featureid['points'], $eventid['event_id']));
		
		$query = $this->dbh->prepare("INSERT INTO {$this->config->table_gamification} (user_id,event_id,feature_id,game_feature_points) VALUES (?, ?, ?, ?)");
		$query->execute(array($uid,$eventid['event_id'], $featureid['feature_id'],$featureid['points']));
		

		$query = $this->dbh->prepare("INSERT INTO {$this->config->table_requests} (uid, rkey, expire, type) VALUES (?, ?, ?, ?)");

		if(!$query->execute(array($uid, $key, $expire, $type))) {
			$return['message'] = $this->lang["system_error"] . " #09";
			return $return;
		}
		$request_id = $this->dbh->lastInsertId();
		
		
		
	}
		// Check configuration for SMTP parameters

		if($this->config->smtp) {
			$mail->isSMTP();
			$mail->Host = $this->config->smtp_host;
			$mail->SMTPAuth = $this->config->smtp_auth;
			if(!is_null($this->config->smtp_auth)) {
            			$mail->Username = $this->config->smtp_username;
            			$mail->Password = $this->config->smtp_password;
            		}
			$mail->Port = $this->config->smtp_port;

			if(!is_null($this->config->smtp_security)) {
				$mail->SMTPSecure = $this->config->smtp_security;
			}
		}

		$mail->From = $this->config->site_email;
		$mail->FromName = $this->config->site_name;
		$mail->addAddress($email);
		$mail->isHTML(true);

		$contact=$this->getContact($email);
		if ($this->getContact($email)) {
			//$this->addAttempt();
			$cid=$contact['id'];
		}
		else
		{
			$query = $this->dbh->prepare("INSERT INTO {$this->config->table_contacts} (uid,email) VALUES (?,?)");
			$query->execute(array($uid_chat,$email));
			$cid = $this->dbh->lastInsertId();
		}
		$query = $this->dbh->prepare("INSERT INTO {$this->config->table_invitations} (cid,uid,rid,is_joined,is_approved) VALUES (?, ?, ?, ?,?)");
		$query->execute(array($cid,$uid_chat,$stream,'0','0'));
		$chatinviteid = $this->dbh->lastInsertId();
		
		if($type == "activation") {
			$mail->Subject = sprintf($this->lang['email_activation_subject'], $this->config->site_name);
			$mail->Body = sprintf($this->lang['email_activation_body'], $this->config->site_url, $this->config->site_activation_page, $key);
			$mail->AltBody = sprintf($this->lang['email_activation_altbody'], $this->config->site_url, $this->config->site_activation_page, $key);
		} else if($type == "invitation"){
			$mail->Subject = sprintf($this->lang['email_invitation_subject'], $this->config->site_name);
			$mail->Body = sprintf($this->lang['email_invitation_body'], $this->config->site_url, $this->config->site_invitation_active_page, $cid,$chatinviteid);
			$mail->AltBody = sprintf($this->lang['email_invitation_altbody'], $this->config->site_url, $this->config->site_invitation_active_page,$cid, $chatinviteid);
		}
		else {
			$mail->Subject = sprintf($this->lang['email_reset_subject'], $this->config->site_name);
			$mail->Body = sprintf($this->lang['email_reset_body'], $this->config->site_url, $this->config->site_password_reset_page, $user['pass']);
			$mail->AltBody = sprintf($this->lang['email_reset_altbody'], $this->config->site_url, $this->config->site_password_reset_page, $key);
		}
		if($type != "activation"){
		//if($uname_type=='email'){
		if(!$mail->send()) {
			$this->deleteRequest($request_id);

			$return['message'] = $this->lang["system_error"] . " #10";
			return $return;
		//}
		}
	}
		$return['error'] = false;	
		$return['otp'] = $key;	
		return $return;
	}

	/*
	* Returns request data if key is valid
	* @param string $key
	* @param string $type
	* @return array $return
	*/

	private function getRequest($key, $type)
	{
		$return['error'] = true;

		$query = $this->dbh->prepare("SELECT id, uid, expire FROM {$this->config->table_requests} WHERE rkey = ? AND type = ?");
		$query->execute(array($key, $type));

		if ($query->rowCount() === 0) {
			//$this->addAttempt();

			$return['message'] = $this->lang[$type."key_incorrect"];
			return $return;
		}

		$row = $query->fetch();

		$expiredate = strtotime($row['expire']);
		$currentdate = strtotime(date("Y-m-d H:i:s"));

		if ($currentdate > $expiredate) {
			//$this->addAttempt();

			$this->deleteRequest($row['id']);

			$return['message'] = $this->lang[$type."key_expired"];
			return $return;
		}

		$return['error'] = false;
		$return['id'] = $row['id'];
		$return['uid'] = $row['uid'];

		return $return;
	}

	/*
	* Deletes request from database
	* @param int $id
	* @return boolean
	*/

	private function deleteRequest($id)
	{
		$query = $this->dbh->prepare("DELETE FROM {$this->config->table_requests} WHERE id = ?");
		return $query->execute(array($id));
	}

	/*
	* Verifies that a password is valid and respects security requirements
	* @param string $password
	* @return array $return
	*/

	private function validatePassword($password) {
		$return['error'] = true;

		if (strlen($password) < 6) {
			$return['message'] = $this->lang["password_short"];
			return $return;
		} elseif (strlen($password) > 150) {
			$return['message'] = $this->lang["password_long"];
			return $return;
		} /*elseif (!preg_match('@[A-Z]@', $password) || !preg_match('@[a-z]@', $password) || !preg_match('@[0-9]@', $password)) {
			$return['message'] = $this->lang["password_invalid"];
			return $return;
		}*/

		$return['error'] = false;
		return $return;
	}

	/*
	* Verifies that an email is valid
	* @param string $email
	* @return array $return
	*/

	private function validateEmail($email) {
		$return['error'] = true;
		if (strlen($email) ==0) {
			$return['message'] = $this->lang["email_empty"]."sad";
			return $return;
		}
		else if (strlen($email) < 5) {
			$return['message'] = $this->lang["email_short"];
			return $return;
		} elseif (strlen($email) > 100) {
			$return['message'] = $this->lang["email_long"];
			return $return;
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$return['message'] = $this->lang["email_invalid"];
			return $return;
		}

		$bannedEmails = json_decode(file_get_contents(__DIR__ . "/files/domains.json"));

		if(in_array(strtolower(explode('@', $email)[1]), $bannedEmails)) {
			$return['message'] = $this->lang["email_banned"];
			return $return;
		}

		$return['error'] = false;
		return $return;
	}


	/*
	* Allows a user to reset their password after requesting a reset key.
	* @param string $key
	* @param string $password
	* @param string $repeatpassword
	* @return array $return
	*/

	public function resetPass($key, $password, $repeatpassword)
	{
		$return['error'] = true;

		if ($this->isBlocked()) {
			$return['message'] = $this->lang["user_blocked"];
			return $return;
		}

		if(strlen($key) != 20) {
			$return['message'] = $this->lang["resetkey_invalid"];
			return $return;
		}

		$validatePassword = $this->validatePassword($password);

		if($validatePassword['error'] == 1) {
			$return['message'] = $validatePassword['message'];
			return $return;
		}

		if($password !== $repeatpassword) {
			// Passwords don't match
			$return['message'] = $this->lang["newpassword_nomatch"];
			return $return;
		}

		$data = $this->getRequest($key, "reset");

		if($data['error'] == 1) {
			$return['message'] = $data['message'];
			return $return;
		}

		$user = $this->getUser($data['uid']);

		if(!$user) {
			//$this->addAttempt();
			$this->deleteRequest($data['id']);

			$return['message'] = $this->lang["system_error"] . " #11";
			return $return;
		}

		if(password_verify($password, $user['password'])) {
			//$this->addAttempt();
			$this->deleteRequest($data['id']);

			$return['message'] = $this->lang["newpassword_match"];
			return $return;
		}

		$password = $this->getHash($password);

		$query = $this->dbh->prepare("UPDATE {$this->config->table_users} SET password = ? WHERE id = ?");
		$query->execute(array($password, $data['uid']));

		if ($query->rowCount() == 0) {
			$return['message'] = $this->lang["system_error"] . " #12";
			return $return;
		}

		$this->deleteRequest($data['id']);

		$return['error'] = false;
		$return['message'] = $this->lang["password_reset"];

		return $return;
	}

	/*
	* Recreates activation email for a given email and sends
	* @param string $email
	* @return array $return
	*/

	public function resendActivation($email,$uname_type)
	{
		$return['error'] = true;

		if ($this->isBlocked()) {
			$return['message'] = $this->lang["user_blocked"];
			return $return;
		}
		if($uname_type=='email')
		{
			$validateEmail = $this->validateEmail($email);

			if($validateEmail['error'] == 1) {
				$return['message'] = $validateEmail['message'];
				return $return;
			}
		}
		$query = $this->dbh->prepare("SELECT id FROM {$this->config->table_users} WHERE email = ?");
		$query->execute(array($email));

		if($query->rowCount() == 0) {
			//$this->addAttempt();

			$return['message'] = $this->lang["email_incorrect"];
			return $return;
		}

		$row = $query->fetch(PDO::FETCH_ASSOC);

		if ($this->getUser($row['id'])['isactive'] == 1) {
			//$this->addAttempt();

			$return['message'] = $this->lang["already_activated"];
			return $return;
		}

		$addRequest = $this->addRequest($row['id'], $email, "activation",$uname_type);

		if ($addRequest['error'] == 1) {
			//$this->addAttempt();

			$return['message'] = $addRequest['message'];
			return $return;
		}

		$return['error'] = false;
		$return['otp']=$addRequest['otp'];
		$return['message'] = $this->lang["activation_sent"];
		return $return;
	}

	/*
	* Changes a user's password
	* @param int $uid
	* @param string $currpass
	* @param string $newpass
	* @return array $return
	*/

	public function changePassword($uid, $currpass, $newpass, $repeatnewpass)
	{
		$return['error'] = true;

		if ($this->isBlocked()) {
			$return['message'] = $this->lang["user_blocked"];
			return $return;
		}

		$validatePassword = $this->validatePassword($currpass);

		if($validatePassword['error'] == 1) {
			//$this->addAttempt();

			$return['message'] = $validatePassword['message'];
			return $return;
		}

		$validatePassword = $this->validatePassword($newpass);

		if($validatePassword['error'] == 1) {
			$return['message'] = $validatePassword['message'];
			return $return;
		} elseif($newpass !== $repeatnewpass) {
			$return['message'] = $this->lang["newpassword_nomatch"];
			return $return;
		}

		$user = $this->getUser($uid);

		if(!$user) {
			//$this->addAttempt();

			$return['message'] = $this->lang["system_error"] . " #13";
			return $return;
		}

		if(!password_verify($currpass, $user['password'])) {
			//$this->addAttempt();

			$return['message'] = $this->lang["password_incorrect"];
			return $return;
		}

		$newpass = $this->getHash($newpass);

		$query = $this->dbh->prepare("UPDATE {$this->config->table_users} SET password = ? WHERE id = ?");
		$query->execute(array($newpass, $uid));

		$return['error'] = false;
		$return['message'] = $this->lang["password_changed"];
		return $return;
	}

	/*
	* Changes a user's email
	* @param int $uid
	* @param string $currpass
	* @param string $newpass
	* @return array $return
	*/

	public function changeEmail($uid, $email, $password)
	{
		$return['error'] = true;

		if ($this->isBlocked()) {
			$return['message'] = $this->lang["user_blocked"];
			return $return;
		}

		$validateEmail = $this->validateEmail($email);

		if($validateEmail['error'] == 1)
		{
			$return['message'] = $validateEmail['message'];
			return $return;
		}

		$validatePassword = $this->validatePassword($password);

		if ($validatePassword['error'] == 1) {
			$return['message'] = $this->lang["password_notvalid"];
			return $return;
		}

		$user = $this->getUser($uid);

		if(!$user) {
			//$this->addAttempt();

			$return['message'] = $this->lang["system_error"] . " #14";
			return $return;
		}

		if(!password_verify($password, $user['password'])) {
			//$this->addAttempt();

			$return['message'] = $this->lang["password_incorrect"];
			return $return;
		}

		if ($email == $user['email']) {
			//$this->addAttempt();

			$return['message'] = $this->lang["newemail_match"];
			return $return;
		}

		$query = $this->dbh->prepare("UPDATE {$this->config->table_users} SET email = ? WHERE id = ?");
		$query->execute(array($email, $uid));

		if ($query->rowCount() == 0) {
			$return['message'] = $this->lang["system_error"] . " #15";
			return $return;
		}

		$return['error'] = false;
		$return['message'] = $this->lang["email_changed"];
		return $return;
	}

	/*
	* Informs if a user is locked out
	* @return boolean
	*/

	private function isBlocked()
	{
		$ip = $this->getIp();

		$query = $this->dbh->prepare("SELECT count, expiredate FROM {$this->config->table_attempts} WHERE ip = ?");
		$query->execute(array($ip));

		if($query->rowCount() == 0) {
			return false;
		}

		$row = $query->fetch(PDO::FETCH_ASSOC);

		$expiredate = strtotime($row['expiredate']);
		$currentdate = strtotime(date("Y-m-d H:i:s"));

		if ($row['count'] == 1000) {
			if ($currentdate < $expiredate) {
				return true;
}
			$this->deleteAttempts($ip);
			return false;
		}

		if ($currentdate > $expiredate) {
			$this->deleteAttempts($ip);
		}

		return false;
	}

	/*
	* Adds an attempt to database
	* @return boolean
	*/

	private function addAttempt()
	{
		$ip = $this->getIp();

		$query = $this->dbh->prepare("SELECT count FROM {$this->config->table_attempts} WHERE ip = ?");
		$query->execute(array($ip));

		$row = $query->fetch(PDO::FETCH_ASSOC);

		$attempt_expiredate = date("Y-m-d H:i:s", strtotime("+30 minutes"));

		if (!$row) {
			$attempt_count = 1;

			$query = $this->dbh->prepare("INSERT INTO {$this->config->table_attempts} (ip, count, expiredate) VALUES (?, ?, ?)");
			return $query->execute(array($ip, $attempt_count, $attempt_expiredate));
		}

		$attempt_count = $row['count'] + 1;

		$query = $this->dbh->prepare("UPDATE {$this->config->table_attempts} SET count=?, expiredate=? WHERE ip=?");
		return $query->execute(array($attempt_count, $attempt_expiredate, $ip));
	}

	/*
	* Deletes all attempts for a given IP from database
	* @param string $ip
	* @return boolean
	*/

	private function deleteAttempts($ip)
	{
		$query = $this->dbh->prepare("DELETE FROM {$this->config->table_attempts} WHERE ip = ?");
		return $query->execute(array($ip));
	}

	/*
	* Returns a random string of a specified length
	* @param int $length
	* @return string $key
	*/

	public function getRandomKey($length = 8)
	{
		$chars = "A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W3X4Y5Z6A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W3X4Y5Z6";
		$key = "";

		for ($i = 0; $i < $length; $i++) {
			$key .= $chars{mt_rand(0, strlen($chars) - 1)};
		}

		return $key;
	}

	/*
	* Returns IP address
	* @return string $ip
	*/

	private function getIp()
	{
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
		   return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		   return $_SERVER['REMOTE_ADDR'];
		}
	}
}

?>
