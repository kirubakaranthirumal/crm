<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Database\PostgresConnection\pdo;

use DB;

class Status extends Model {

	protected $table = 'crm_ticket_status_new';
	public $timestamps = false;

	/*
	*insert record in db
	*
	*@param $recordObj
	*@return if inserted return last insert id else return false
	*/
	public function insert($recordObj){

		/*
		print"<pre>";
		print_r($recordObj);
		print_r($recordObj->priority_name);
		exit;
		*/

		$status = DB::insert('INSERT INTO '.$this->table.' (status_name, status_desc, status,created_on, created_by) values (?, ?, ?, ?, ?)', [$recordObj->status_name,$recordObj->status_desc,$recordObj->status,$recordObj->created_on,$recordObj->created_by]);
		//$priorityId = DB::lastInsertId();

		//$lastInsertedId = DB::connection('pgsql')->pdo->lastInsertId();

		if(!empty($status)){
			return $status;
		}
		else{
			return false;
		}

		/*
		$recordObj->save();
		if(!empty($recordObj->status_id)){
			return $recordObj->status_id;
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

		$statusArray = array();

		$status_query = "SELECT * FROM ".$this->table;

		$statusObj = DB::select($status_query);

		if($statusObj){
			foreach($statusObj as $statusObjElement) {
				$statusArray[] = $this->_mapKeys($statusObjElement);
			}
		}

		//print"<pre>";
		//print_r($statusArray);
		//exit;

		return $statusArray;
	}

	public function retrieveAllActive() {

		$groupArray = array();

		$group_sql = "SELECT * FROM ".$this->table." WHERE status = 1 ORDER BY status_id ASC";

		$groupObj = DB::select($group_sql);

		if($groupObj){
			foreach($groupObj as $groupObjElement) {
				$groupArray[] = $this->_mapKeys($groupObjElement);
			}
		}

		return $groupArray;
	}

	/*
	*retrive record from db
	*
	*@paramkey $whrClause
	*@return result array
	*/
	public function retrieveByWhere($statusId){
		$status = DB::table($this->table)->where('status_id', $statusId)->first();
		return $status;
	}

	/*
	*update record in db
	*
	*@param $id,  $inputArray
	*@return if updated return updated id else return false
	*/
	public function updateById($statusId,$inputArray){

		$upd_sql = "UPDATE ".$this->table." SET status_name='"
					.$inputArray['status_name'].
				   "', status_desc='"
				   .$inputArray['status_desc'].
				   "', status="
				   .$inputArray['status'].
				   ", modified_on=NOW(), modified_by="
				   .$inputArray['modified_by']." WHERE status_id = ".$statusId;

		//echo $upd_sql;
		//exit;

		$status = DB::update($upd_sql);

		if(!empty($status)){
			return $status;
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
	public function deleteById($statusId){

		//$del_sql = "DELETE FROM ".$this->table." WHERE status_id = ".$statusId;

		$del_sql = "UPDATE ".$this->table." SET status = 2 WHERE status_id = ".$statusId;

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
	private function _mapKeys($statusObj){

		$mappedArray = array();

		$mappedArray['statusId'] = $statusObj->status_id;
		$mappedArray['statusName'] = $statusObj->status_name;
		$mappedArray['statusDescription'] = $statusObj->status_desc;
		$mappedArray['statusStatus'] = $statusObj->status;
		$mappedArray['statusCreatedOn'] = ($statusObj->created_on != "0000-00-00 00:00:00")?$statusObj->created_on:null;
		$mappedArray['statusCreatedBy'] = $statusObj->created_by;
		$mappedArray['statusModifiedOn'] = ($statusObj->modified_on != "0000-00-00 00:00:00")?$statusObj->modified_on:null;
		$mappedArray['statusModifiedBy'] = $statusObj->modified_by;

		return $mappedArray;
	}
}