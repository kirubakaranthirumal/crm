<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Database\PostgresConnection\pdo;

use DB;

class SocialMedia extends Model {

	protected $table = 'crm_ticket_social_media_settings_new';
	public $timestamps = false;

	/*
	*insert record in db
	*
	*@param $recordObj
	*@return if inserted return last insert id else return false
	*/
	public function insert($recordObj){

		$social = DB::insert('INSERT INTO '.$this->table.' (sms_type, sms_user_id, sms_user_password, sms_consumer_key, sms_consumer_secret, sms_access_token, sms_access_token_secret, sms_oauth_callback, sms_desc, sms_status, created_on, created_by) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$recordObj->sms_type,	$recordObj->sms_user_id, $recordObj->sms_user_password,	$recordObj->sms_consumer_key, $recordObj->sms_consumer_secret, $recordObj->sms_access_token, $recordObj->sms_access_token_secret, $recordObj->sms_oauth_callback, $recordObj->sms_desc, $recordObj->sms_status, $recordObj->created_on, $recordObj->created_by]);

		//print"<pre>";
		//print_r($social);
		//exit;

		if(!empty($social)){
			return $social;
		}
		else{
			return false;
		}

		/*
		$recordObj->save();
		if(!empty($recordObj->sms_id)){
			return $recordObj->sms_id;
		}
		else{
			return false;
		}
		*/
	}

	/*
	*retrive all based on params record from db
	*
	*@paramkey
	*@return result array
	*/
	public function retrieveAll($params) {

		$socialArray = array();

		$socialObj = DB::select('SELECT * FROM '.$this->table);

		if($socialObj){
			foreach($socialObj as $socialObjElement) {
				$socialArray[] = $this->_mapKeys($socialObjElement);
			}
		}

		//print"<pre>";
		//print_r($socialArray);
		//exit;

		return $socialArray;
	}

	public function retrieveAllActive() {

		$socialArray = array();

		$db_sql = "SELECT * FROM ".$this->table." WHERE social_status = 1";

		$socialObj = DB::select($db_sql);

		if($socialObj){
			foreach($socialObj as $socialObjElement) {
				$socialArray[] = $this->_mapKeys($socialObjElement);
			}
		}

		return $socialArray;
	}

	/*
	*retrive record from db
	*
	*@paramkey $whrClause
	*@return result array
	*/
	public function retrieveByWhere($smsId){

		$socialArray = array();

		$db_sql = "SELECT * FROM ".$this->table." WHERE sms_id = ".$smsId;

		$socialObj = DB::select($db_sql);

		if($socialObj){
			foreach($socialObj as $socialObjElement) {
				$socialArray = $this->_mapKeys($socialObjElement);
			}
		}

		//print"<pre>";
		//print_r($socialArray);
		//exit;

		return $socialArray;
	}

	/*
	*update record in db
	*
	*@param $id,  $inputArray
	*@return if updated return updated id else return false
	*/
	public function updateById($smsId,$inputArray){

		/*
			sms_id
			sms_type,
			sms_user_id,
			sms_user_password,
			sms_consumer_key,
			sms_consumer_secret,
			sms_access_token,
			sms_access_token_secret,
			sms_oauth_callback,
			sms_desc,
			sms_status,
			created_on,
			created_by,
			modified_on,
			modified_by
		*/

		$upd_sql = "UPDATE ".$this->table." SET sms_type='"
					.$inputArray['sms_type'].
				   "', sms_user_id='"
				   .$inputArray['sms_user_id'].
				   "', sms_user_password='"
				   .$inputArray['sms_user_password'].
				    "', sms_consumer_key='"
				   .$inputArray['sms_consumer_key'].
				    "', sms_consumer_secret='"
				   .$inputArray['sms_consumer_secret'].
				    "', sms_access_token='"
				   .$inputArray['sms_access_token'].
				    "', sms_access_token_secret='"
				   .$inputArray['sms_access_token_secret'].
				    "', sms_oauth_callback='"
				   .$inputArray['sms_oauth_callback'].
				    "', sms_desc='"
				   .$inputArray['sms_desc'].
				    "', sms_status='"
				   .$inputArray['sms_status'].
				   "', modified_on=NOW(), modified_by='"
				   .$inputArray['modified_by']."' WHERE sms_id = ".$smsId;

		//echo $upd_sql;
		//exit;

		$smsObj = DB::update($upd_sql);

		if(!empty($smsObj)){
			return $smsObj;
		}
		else{
			return false;
		}
	}

	/*
	*delete record in db
	*
	*@param $id
	*/
	public function deleteById($smsId){

		$del_sql = "UPDATE ".$this->table." SET sms_status = 2 WHERE sms_id = ".$smsId;

		$status = DB::delete($del_sql);

		if(!empty($status)){
			return $status;
		}
		else{
			return false;
		}
	}

	/*
	Set Array Key
	*/
	private function _mapKeys($smsObj){

		$mappedArray = array();

		/*
		sms_id
		sms_type,
		sms_user_id,
		sms_user_password,
		sms_consumer_key,
		sms_consumer_secret,
		sms_access_token,
		sms_access_token_secret,
		sms_oauth_callback,
		sms_desc,
		sms_status,
		created_on,
		created_by,
		modified_on,
		modified_by
		*/

		$mappedArray['smsId'] = $smsObj->sms_id;
		$mappedArray['smsType'] = $smsObj->sms_type;
		$mappedArray['smsUserId'] = $smsObj->sms_user_id;
		$mappedArray['smsUserPassword'] = $smsObj->sms_user_password;
		$mappedArray['smsConsumerKey'] = $smsObj->sms_consumer_key;
		$mappedArray['smsConsumerSecret'] = $smsObj->sms_consumer_secret;
		$mappedArray['smsAccessToken'] = $smsObj->sms_access_token;
		$mappedArray['smsAccessTokenSecret'] = $smsObj->sms_access_token_secret;
		$mappedArray['smsOauthCallback'] = $smsObj->sms_oauth_callback;
		$mappedArray['smsDesc'] = $smsObj->sms_desc;
		$mappedArray['smsStatus'] = $smsObj->sms_status;
		$mappedArray['smsCreatedOn'] = ($smsObj->created_on != "0000-00-00 00:00:00")?$smsObj->created_on:null;
		$mappedArray['smsCreatedBy'] = $smsObj->created_by;
		$mappedArray['smsModifiedOn'] = ($smsObj->modified_on != "0000-00-00 00:00:00")?$smsObj->modified_on:null;
		$mappedArray['smsModifiedBy'] = $smsObj->modified_by;

		return $mappedArray;
	}
}