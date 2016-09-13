<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Department extends Model {

	protected $table = 'crm_department_new';
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
		//print_r($recordObj->priority_name);
		exit;
		*/

		$department = DB::insert('INSERT INTO '.$this->table.' (dept_name, dept_desc, status, created_on, created_by) values (?, ?, ?, ?, ?)', [$recordObj->dept_name,$recordObj->dept_desc,$recordObj->status,$recordObj->created_on,$recordObj->created_by]);

		if(!empty($department)){
			return $department;
		}
		else{
			return false;
		}

		/*
		$recordObj->save();
		if(!empty($recordObj->id)){
			return $recordObj->id;
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

		$groupArray = array();

		$group_sql = "SELECT * FROM ".$this->table;

		$groupObj = DB::select($group_sql);

		if($groupObj){
			foreach($groupObj as $groupObjElement) {
				$groupArray[] = $this->_mapKeys($groupObjElement);
			}
		}

		//print"<pre>";
		//print_r($groupArray);
		//exit;

		return $groupArray;
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
	public function retrieveByWhere($deptId) {

		$groupArray = array();

		//$groupObj = SELF::where($whrClause)->get();

		$department = DB::table($this->table)->where('dept_id', $deptId)->first();

		return $department;
	}

	/*
	*update record in db
	*
	*@param $id,  $inputArray
	*@return if updated return updated id else return false
	*/
	public function updateById($deptId,$inputArray){

		//$deptObj = SELF::find($deptId);

		$upd_sql = "UPDATE ".$this->table." SET dept_name='"
					.$inputArray['dept_name'].
				   "', dept_desc='"
				   .$inputArray['dept_desc'].
				   "', status="
				   .$inputArray['status'].
				   ", modified_on=NOW(), modified_by="
				   .$inputArray['modified_by']." WHERE dept_id = ".$deptId;

		//echo $upd_sql;
		//exit;

		$department = DB::update($upd_sql);

		if(!empty($department)){
			return $department;
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
	public function deleteById($deptId){

		//$del_sql = " DELETE FROM ".$this->table." WHERE dept_id = ".$deptId;

		$del_sql = "UPDATE ".$this->table." SET status = 2 WHERE dept_id = ".$deptId;

		$department = DB::delete($del_sql);

		if(!empty($department)){
			return $department;
		}
		else{
			return false;
		}
	}

	/*
	Set Array Key
	*/
	private function _mapKeys($deptObj){

		$mappedArray = array();

		$mappedArray['deptId'] = $deptObj->dept_id;
		$mappedArray['deptName'] = $deptObj->dept_name;
		$mappedArray['deptDescription'] = $deptObj->dept_desc;
		$mappedArray['deptStatus'] = $deptObj->status;
		$mappedArray['deptCreatedOn'] = ($deptObj->created_on != "0000-00-00 00:00:00")?$deptObj->created_on:null;
		$mappedArray['deptCreatedBy'] = $deptObj->created_by;
		$mappedArray['deptModifiedOn'] = ($deptObj->modified_on != "0000-00-00 00:00:00")?$deptObj->modified_on:null;
		$mappedArray['deptModifiedBy'] = $deptObj->modified_by;

		return $mappedArray;
	}

}



