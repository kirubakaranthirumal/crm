<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Database\PostgresConnection\pdo;

use DB;

class SmtpMail extends Model{

	static $mailFrom;
	static $mailFromName;
	static $mailTo;
	static $mailCc;
	static $mailSubject;
	static $mailMsg;
	static $mailMethod;

	static $mailHostName;
	static $mailLocalhost;
	static $mailUser;
	static $mailPassword;
	static $mailPort;

	static $result;

	static $errorArray;

	private static function init(){

		self::$mailMethod = "SMTP";  // SMTP or PHP

		self::$mailFrom = "";
		self::$mailFromName = "";
		self::$mailCc = "";
		self::$mailTo = array();
		self::$mailSubject = "";
		self::$mailMsg = "";

		self::$mailHostName = "";
		self::$mailLocalhost = "";
		self::$mailUser = "";
		self::$mailPassword = "";
		self::$mailPort= "";

		self::$result = "";

		self::$errorArray = array();
	}

	public static function send($param){

		self::init();

		if(!empty($param['mailHostName'])){
			self::$mailHostName = $param['mailHostName'];
			//$param['mailPort'] = "465";
		}
		else{
			self::$mailHostName = "email14.godaddy.com";
		}

		if(!empty($param['mailLocalhost'])){
			self::$mailLocalhost = $param['mailLocalhost'];
		}
		else{
			self::$mailLocalhost = "email14.godaddy.com";
		}

		if(!empty($param['mailUser'])){
			self::$mailUser = $param['mailUser'];
		}
		else{
			self::$mailUser = "kirubakaran.thirumal@nutechnologyinc.com";
		}

		if(!empty($param['mailPassword'])){
			self::$mailPassword = $param['mailPassword'];
		}
		else{
			self::$mailPassword = "RXVC-kSt9KBJ_O1vX-qQ5Q";
		}

		if(!empty($param['mailPort'])){
			self::$mailPort = $param['mailPort'];
		}
		else{
			self::$mailPort = "465";
		}

		if(!empty($param['from'])){
			self::$mailFrom = $param['from'];
		}
		else{
			self::$errorArray[] = "Error : From email address is missing.";
		}

		if(!empty($param['from_name'])){
			self::$mailFromName = $param['from_name'];
		}
		else{
			self::$mailFromName = "Cricket Gateway";
		}

		$param['to'] = array("kirubakaran.srm@gmail.com");


		print"<pre>";
		print_r($param);
		exit;
	}
}
