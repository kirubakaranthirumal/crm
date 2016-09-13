<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class MailAccountSetting extends Model {


	protected $table = 'crm_mail_account_configuration_new';
	public $timestamps = false;

	/*
	*insert record in db
	*
	*@param $recordObj
	*@return if inserted return last insert id else return false
	*/
	public function insert($recordObj){

		$addMailAccountSetting = DB::insert('INSERT INTO crm_mail_account_configuration_new
									(mail_app_id, mail_user_id, mail_user_password, mail_desc, mail_status, created_on, created_by)
									VALUES
									(?, ?, ?, ?, ?, ?, ?)', [$recordObj->mail_app_id, $recordObj->mail_user_id, $recordObj->mail_user_password, $recordObj->mail_desc, $recordObj->mail_status, $recordObj->created_on, $recordObj->created_by]);

		if(!empty($addMailAccountSetting)){
			return $addMailAccountSetting;
		}
		else{
			return false;
		}

	}

	/*
	*update record in db
	*
	*@param $id,  $inputArray
	*@return if updated return updated id else return false
	*/
	public function updateById($mailAccId,$inputArray){

		$upd_sql = "UPDATE crm_mail_account_configuration_new SET mail_app_id='"
					.$inputArray['mail_app_id'].
				   "',mail_user_id='"
					.$inputArray['mail_user_id'].
				   "', mail_user_password='"
				   .$inputArray['mail_user_password'].
				   "', mail_desc='"
				   .$inputArray['editor'].
				   "', mail_status='"
				   .$inputArray['mail_status'].
				   "', modified_on=NOW(), modified_by="
				   .$inputArray['modified_by']." WHERE mail_id = ".$mailAccId;

		$mailAccountSetting = DB::update($upd_sql);
		if(!empty($mailAccountSetting)){
			return $mailAccountSetting;
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
	public function deleteById($mailAccId){

		$del_sql = "DELETE FROM crm_mail_account_configuration_new WHERE mail_id=".$mailAccId;

		$mailAccSet = DB::delete($del_sql);

		if(!empty($mailAccSet)){
			return $mailAccSet;
		}
		else{
			return false;
		}
	}

	/*
	*retrive all based on params record from db
	*
	*@paramkey
	*@return result array
	*/
	public function retrieveAll($params) {

		$mailAccSetArray = $cmArray = array();

		if(!empty($params)){

			$whrClause = array();
			$query =SELF::where($whrClause);

			if((!empty($params['sortingColumn']))&&(!empty($params['sortingOrder']))){
				 $query->orderBy($params['sortingColumn'],$params['sortingOrder']);
			}
			else{
				$query->orderBy("mail_id","DESC");
			}

			if(!empty($params['pageNo'])&&($params['pageNo']=='1')){
				$query->take($params['recordsCount']);
			}
			else{
				$query->skip(($params['pageNo']-1)*$params['recordsCount'])->take($params['recordsCount']);
			}
		}

		$query->join('portal_application', 'crm_mail_account_configuration_new.mail_app_id', '=', 'portal_application.application_id');
		$query->select('crm_mail_account_configuration_new.*','portal_application.app_name as app_name');
		$mailAccSetArray = $query->get();

		if($mailAccSetArray){
			foreach($mailAccSetArray as $mailAccSetObj) {
				$cmArray[] = $this->_mapKeys($mailAccSetObj);
			}
		}

		return $cmArray;
	}

	/*
	Set Array Key
	*/
	private function _mapKeys($mailAccSetObj){

		$mappedArray = array();
		$mappedArray['mailId'] = $mailAccSetObj->mail_id;
		$mappedArray['mailAppId'] = $mailAccSetObj->mail_app_id;
		$mappedArray['mailAppName'] = $mailAccSetObj->app_name;
		$mappedArray['mailUserId'] = $mailAccSetObj->mail_user_id;
		$mappedArray['mailUserPassword'] = $mailAccSetObj->mail_user_password;
		$mappedArray['mailDesc'] = $mailAccSetObj->mail_desc;
		$mappedArray['mailStatus'] = $mailAccSetObj->mail_status;
		$mappedArray['createdOn'] = ($mailAccSetObj->created_on != "0000-00-00 00:00:00")?$mailAccSetObj->created_on:null;
		$mappedArray['createdBy'] = $mailAccSetObj->created_by;
		$mappedArray['modifiedOn'] = ($mailAccSetObj->modified_on != "0000-00-00 00:00:00")?$mailAccSetObj->modified_on:null;
		$mappedArray['modifiedBy'] = $mailAccSetObj->modified_by;

		return $mappedArray;
	}

		/*
	*retrive all based on params record from db
	*
	*@paramkey
	*@return result array
	*/
	public function retrieveByWhere($whrClause) {

		$mailAccSetArray = $cmArray = array();

		$query =SELF::where($whrClause);

		$query->join('portal_application', 'crm_mail_account_configuration_new.mail_app_id', '=', 'portal_application.application_id');
		$query->select('crm_mail_account_configuration_new.*','portal_application.app_name as app_name');

		$mailAccSetArray = $query->get();

		if($mailAccSetArray){
			foreach($mailAccSetArray as $mailAccSetObj) {
				$cmArray[] = $this->_mapKeys($mailAccSetObj);
			}
		}

		return $cmArray;
	}

}



