<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Database\PostgresConnection\pdo;

use DB;

class Customer extends Model {

	protected $table = 'cg_register';
	public $timestamps = false;

	/*
	*insert record in db
	*
	*@param $recordObj
	*@return if inserted return last insert id else return false
	*/
	public function insert($recordObj){
		$ticket_type = DB::insert('INSERT INTO crm_ticket_type (type_name,type_desc,status,created_on,created_by) values (?, ?, ?, ?, ?)', [$recordObj->type_name,$recordObj->type_desc,$recordObj->status,$recordObj->created_on,$recordObj->created_by]);
		if(!empty($ticket_type)){
			return $ticket_type;
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

		$typeArray = array();

		if(!empty($params)){

			$whrClause = array();
			$query =SELF::where($whrClause);

			if(!empty($params['startDate'])){
				 $query->where('created_on', '>=', $params['startDate']);
			}
			elseif(!empty($params['endDate'])){
				$query->where('created_on', '<=', $params['endDate']);
			}

			//if(!empty($params['startDate'])&&(!empty($params['endDate']))){
			//	$query->where('created_on', '>=', $params['startDate'])->where('created_on', '<=', $params['endDate']);
			//}

			if((!empty($params['sortingColumn']))&&(!empty($params['sortingOrder']))){
				 $query->orderBy($params['sortingColumn'],$params['sortingOrder']);
			}
			else{
				$query->orderBy("type_id","DESC");
			}

			if(!empty($params['pageNo'])&&($params['pageNo']=='1')){
				$query->take($params['recordsCount']);
			}
			else{
				$query->skip(($params['pageNo']-1)*$params['recordsCount'])->take($params['recordsCount']);
			}
		}

		$typeObj = $query->get();

		if($typeObj){
			foreach($typeObj as $typeObjElement) {
				$typeArray[] = $this->_mapKeys($typeObjElement);
			}
		}

		//print"<pre>";
		//print_r($typeArray);
		//exit;

		return $typeArray;
	}

	/*
	*retrive record from db
	*
	*@paramkey $whrClause
	*@return result array
	*/
	public function retrieveByWhere($typeId){
		$userData = DB::select('SELECT * FROM cg_register WHERE register_type = '.$typeId);
		//print"<pre>";
		//print_r($userData);
		//exit;
		return $userData;
	}

	/*
	*update record in db
	*
	*@param $id,  $inputArray
	*@return if updated return updated id else return false
	*/
	public function updateById($typeId,$inputArray){

		$upd_sql = "UPDATE crm_ticket_type SET type_name='"
							.$inputArray['type_name'].
						   "', type_desc='"
						   .$inputArray['type_desc'].
						   "', status="
						   .$inputArray['status'].
						   ", modified_on=NOW(), modified_by="
						   .$inputArray['modified_by']." WHERE type_id = ".$typeId;

		//echo $upd_sql;
		//exit;

		$ticketType = DB::update($upd_sql);

		if(!empty($ticketType)){
			return $ticketType;
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
	public function deleteById($typeId){

		$del_sql = "DELETE FROM crm_ticket_type WHERE type_id=".$typeId;

		$ticket_type = DB::delete($del_sql);

		if(!empty($ticket_type)){
			return $ticket_type;
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

		$mappedArray['typeId'] = $sourceObj->type_id;
		$mappedArray['typeName'] = $sourceObj->type_name;
		$mappedArray['typeDescription'] = $sourceObj->type_desc;
		$mappedArray['typeStatus'] = $sourceObj->status;
		$mappedArray['typeCreatedOn'] = ($sourceObj->created_on != "0000-00-00 00:00:00")?$sourceObj->created_on:null;
		$mappedArray['typeCreatedBy'] = $sourceObj->created_by;
		$mappedArray['typeModifiedOn'] = ($sourceObj->modified_on != "0000-00-00 00:00:00")?$sourceObj->modified_on:null;
		$mappedArray['typeModifiedBy'] = $sourceObj->modified_by;

		return $mappedArray;
	}

}



