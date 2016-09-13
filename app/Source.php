<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Database\PostgresConnection\pdo;

use DB;

class Source extends Model {

	protected $table = 'crm_ticket_source_new';
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

		$source = DB::insert('INSERT INTO '.$this->table.' (source_name,source_desc,status,created_on,created_by) values (?, ?, ?, ?, ?)', [$recordObj->source_name,$recordObj->source_desc,$recordObj->status,$recordObj->created_on,$recordObj->created_by]);
		//$priorityId = DB::lastInsertId();

		//$lastInsertedId = DB::connection('pgsql')->pdo->lastInsertId();

		//$data = [ 'priority_name' => $recordObj->priority_name , 'priority_desc' => $recordObj->priority_desc, 'status' => $recordObj->status ,'created_on' => $recordObj->created_on ,'created_by' => $recordObj->created_by ];
		//$id = DB::table('crm_ticket_priority')->insertGetId( $data );

		if(!empty($source)){
			return $source;
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

		$sourceArray = array();

		$source_query = "SELECT * FROM ".$this->table;

		$sourceObj = DB::select($source_query);

		if($sourceObj){
			foreach($sourceObj as $sourceObjElement) {
				$sourceArray[] = $this->_mapKeys($sourceObjElement);
			}
		}

		//print"<pre>";
		//print_r($sourceArray);
		//exit;

		return $sourceArray;
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
	public function retrieveByWhere($sourceId){
		$source = DB::table($this->table)->where('source_id', $sourceId)->first();
		return $source;
	}

	/*
	*update record in db
	*
	*@param $id,  $inputArray
	*@return if updated return updated id else return false
	*/
	public function updateById($sourceId,$inputArray){

		$upd_sql = "UPDATE ".$this->table." SET source_name='"
					.$inputArray['source_name'].
				   "', source_desc='"
				   .$inputArray['source_desc'].
				   "', status="
				   .$inputArray['status'].
				   ", modified_on=NOW(), modified_by="
				   .$inputArray['modified_by']." WHERE source_id = ".$sourceId;

		//echo $upd_sql;
		//exit;

		$source = DB::update($upd_sql);

		if(!empty($source)){
			return $source;
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
	public function deleteById($sourceId){

		//$del_sql = "DELETE FROM ".$this->table." WHERE source_id = ".$sourceId;

		$del_sql = "UPDATE ".$this->table." SET status = 2 WHERE source_id = ".$sourceId;

		$source = DB::delete($del_sql);

		if(!empty($source)){
			return $source;
		}
		else{
			return false;
		}
	}

	/*
	Set Array Key
	*/
	private function _mapKeys($sourceObj){

		$mappedArray = array();

		$mappedArray['sourceId'] = $sourceObj->source_id;
		$mappedArray['sourceName'] = $sourceObj->source_name;
		$mappedArray['sourceDescription'] = $sourceObj->source_desc;
		$mappedArray['sourceStatus'] = $sourceObj->status;
		$mappedArray['sourceCreatedOn'] = ($sourceObj->created_on != "0000-00-00 00:00:00")?$sourceObj->created_on:null;
		$mappedArray['sourceCreatedBy'] = $sourceObj->created_by;
		$mappedArray['sourceModifiedOn'] = ($sourceObj->modified_on != "0000-00-00 00:00:00")?$sourceObj->modified_on:null;
		$mappedArray['sourceModifiedBy'] = $sourceObj->modified_by;

		return $mappedArray;
	}

}



