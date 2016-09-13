<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Database\PostgresConnection\pdo;

use DB;

class Priority extends Model {

	protected $table = 'crm_ticket_priority_new';
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

		$priority = DB::insert('INSERT INTO '.$this->table.' (priority_name,priority_desc,status,created_on,created_by) values (?, ?, ?, ?, ?)', [$recordObj->priority_name,$recordObj->priority_desc,$recordObj->status,$recordObj->created_on,$recordObj->created_by]);
		//$priorityId = DB::lastInsertId();

		//$lastInsertedId = DB::connection('pgsql')->pdo->lastInsertId();

		//$data = [ 'priority_name' => $recordObj->priority_name , 'priority_desc' => $recordObj->priority_desc, 'status' => $recordObj->status ,'created_on' => $recordObj->created_on ,'created_by' => $recordObj->created_by ];
		//$id = DB::table('crm_ticket_priority')->insertGetId( $data );


		if(!empty($priority)){
			return $priority;
		}
		else{
			return false;
		}

		/*
		$recordObj->save();
		if(!empty($recordObj->priority_id)){
			return $recordObj->priority_id;
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

		$priorityArray = array();

		$prior_query = "SELECT * FROM ".$this->table;

		$priorityObj = DB::select($prior_query);

		if($priorityObj){
			foreach($priorityObj as $priorityObjElement) {
				$priorityArray[] = $this->_mapKeys($priorityObjElement);
			}
		}

		//print"<pre>";
		//print_r($priorityArray);
		//exit;

		return $priorityArray;
	}

	public function retrieveAllActive() {

		$groupArray = array();

		$group_sql = "SELECT * FROM ".$this->table." WHERE status = 1";

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
	public function retrieveByWhere($priorId){
		$priority = DB::table($this->table)->where('priority_id', $priorId)->first();
		return $priority;
	}

	/*
	*update record in db
	*
	*@param $id,  $inputArray
	*@return if updated return updated id else return false
	*/
	public function updateById($priorityId,$inputArray){

		$upd_sql = "UPDATE ".$this->table." SET priority_name='"
					.$inputArray['priority_name'].
				   "', priority_desc='"
				   .$inputArray['priority_desc'].
				   "', status="
				   .$inputArray['status'].
				   ", modified_on=NOW(), modified_by="
				   .$inputArray['modified_by']." WHERE priority_id = ".$priorityId;

		//echo $upd_sql;
		//exit;

		$category = DB::update($upd_sql);

		if(!empty($category)){
			return $category;
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
	public function deleteById($priorId){

		//$del_sql = "DELETE FROM ".$this->table." WHERE priority_id = ".$priorId;

		$del_sql = "UPDATE ".$this->table." SET status = 2 WHERE priority_id = ".$priorId;

		$priority = DB::delete($del_sql);

		if(!empty($priority)){
			return $priority;
		}
		else{
			return false;
		}
	}

	/*
	Set Array Key
	*/
	private function _mapKeys($priorityObj){

		$mappedArray = array();

		$mappedArray['priorityId'] = $priorityObj->priority_id;
		$mappedArray['priorityName'] = $priorityObj->priority_name;
		$mappedArray['priorityDescription'] = $priorityObj->priority_desc;
		$mappedArray['priorityStatus'] = $priorityObj->status;
		$mappedArray['priorityCreatedOn'] = ($priorityObj->created_on != "0000-00-00 00:00:00")?$priorityObj->created_on:null;
		$mappedArray['priorityCreatedBy'] = $priorityObj->created_by;
		$mappedArray['priorityModifiedOn'] = ($priorityObj->modified_on != "0000-00-00 00:00:00")?$priorityObj->modified_on:null;
		$mappedArray['priorityModifiedBy'] = $priorityObj->modified_by;

		return $mappedArray;
	}

}



