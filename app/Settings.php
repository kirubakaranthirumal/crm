<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Settings extends Model {

	protected $table = 'crm_department';
	public $timestamps = false;

	/*
	*insert record in db
	*
	*@param $recordObj
	*@return if inserted return last insert id else return false
	*/
	public function insert($recordObj){
		$recordObj->save();
		if(!empty($recordObj->id)){
			return $recordObj->id;
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

		$groupArray = array();
		/*
		if(!empty($params['startDate'])){
			$s_date = explode("/",$params['startDate']);
			$params['startDate'] = $s_date[2]."-".$s_date[1]."-".$s_date[0];
		}
		if(!empty($params['endDate'])){
			$e_date = explode("/",$params['endDate']);
			$params['endDate'] = $e_date[2]."-".$e_date[1]."-".$e_date[0];
		}
		*/

		if(!empty($params)){

			$whrClause = array();
			//$whrClause['order_user_id'] = $params['userId'];
			$query =SELF::where($whrClause);

			if(!empty($params['startDate'])){
				 $query->where('created_on', '>=', $params['startDate']);
			}elseif(!empty($params['endDate'])){
				$query->where('created_on', '<=', $params['endDate']);
			}

			//if(!empty($params['startDate'])&&(!empty($params['endDate']))){
			//	$query->where('created_on', '>=', $params['startDate'])->where('created_on', '<=', $params['endDate']);
			//}

			if((!empty($params['sortingColumn']))&&(!empty($params['sortingOrder']))){
				 $query->orderBy($params['sortingColumn'],$params['sortingOrder']);
			}
			if(!empty($params['pageNo'])&&($params['pageNo']=='1')){
				$query->take($params['recordsCount']);
			}
			else{
				$query->skip(($params['pageNo']-1)*$params['recordsCount'])->take($params['recordsCount']);
			}
		}

		$groupObj = $query->get();

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
	public function retrieveByWhere($whrClause) {

		$groupArray = array();

		$groupObj = SELF::where($whrClause)->get();

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
	public function retrieveByWhereOrder($whrClause) {

		$groupArray = array();

		$orderObj = SELF::where('id','=', $whrClause['group_id'] )->where('status','=',$whrClause['status'] )->get();

		$groupObj = SELF::where($whrClause)->get();

		if($groupObj){
			foreach($groupObj as $groupObjElement) {
				$groupArray[] = $this->_mapKeys($groupObjElement);
			}
		}
		return $groupArray;
	}

	/*
	*update record in db
	*
	*@param $id,  $inputArray
	*@return if updated return updated id else return false
	*/
	public function updateById($groupId,$inputArray){

		$groupObj = SELF::find($groupId);

		if (array_key_exists("groupId",$inputArray)){
			$groupObj->id = trim($inputArray['groupId']);
		}

		if (array_key_exists("groupName",$inputArray)){
			$groupObj->group_name = trim($inputArray['groupName']);
		}

		if (array_key_exists("groupDescription",$inputArray)){
			$groupObj->group_desc = trim($inputArray['groupDescription']);
		}

		if (array_key_exists("groupStatus",$inputArray)){
			$groupObj->status = trim($inputArray['groupStatus']);
		}

		if (array_key_exists("groupCreatedOn",$inputArray)){
			$groupObj->created_on = trim($inputArray['groupCreatedOn']);
		}

		if (array_key_exists("groupCreatedBy",$inputArray)){
			$groupObj->created_by = trim($inputArray['groupCreatedBy']);
		}

		$groupObj->save();
	}

	/*
	*delete record in db
	*
	*@param $id
	*/
	public function deleteById($groupId){
		$groupObj = SELF::where('id','=',$groupId)->delete();
	}

	/*
	Set Array Key
	*/
	private function _mapKeys($deptObj){

		$mappedArray = array();

		$mappedArray['deptId'] = $deptObj->id;
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



