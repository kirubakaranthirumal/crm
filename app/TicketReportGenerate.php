<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class TicketReportGenerate extends Model {

	protected $table = 'crm_tickets';
	public $timestamps = false;

	/*
	*insert record in db
	*
	*@param $recordObj
	*@return if inserted return last insert id else return false
	*/
	public function insert($recordObj){

		/* print"<pre>";
		print_r($recordObj);
		exit; */

		$category = DB::insert('INSERT INTO crm_category_new (cat_name,cat_desc,status,created_on,created_by) values (?, ?, ?, ?, ?)', [$recordObj->cat_name,$recordObj->cat_desc,$recordObj->status,$recordObj->created_on,$recordObj->created_by]);

		if(!empty($category)){
			return $category;
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

		$categoryArray = array();

		if(!empty($params)){

			$whrClause = array();
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
			else{
				$query->orderBy("ticket_id","DESC");
			}

			if(!empty($params['pageNo'])&&($params['pageNo']=='1')){
				$query->take($params['recordsCount']);
			}
			else{
				$query->skip(($params['pageNo']-1)*$params['recordsCount'])->take($params['recordsCount']);
			}
		}

		$ticketObj = $query->get();
		
		$ticketArray=array();

		if($ticketObj){
			foreach($ticketObj as $ticketObjElement) {
				$ticketArray[] = $this->_mapKeys($ticketObjElement);
			}
		}


		return $ticketArray;
	}

	/*
	*retrive record from db
	*
	*@paramkey $whrClause
	*@return result array
	*/
	public function retrieveByWhereInput($inputArray){

		/* print"<pre>";
		print_r($inputArray);
		exit; */
		$group=$inputArray['group'];
		$tickets_by_group= DB::table('crm_tickets')->where('ticket_groupid', $group)->first();
		return $tickets_by_group;
	}
	public function retrieveByWhere($groupId) {

		$groupArray = array();

		//$groupObj = SELF::where($whrClause)->get();

		$Groupdata = DB::table('crm_tickets')->where('ticket_groupid', $groupId)->first();

		return $Groupdata;
	}

	public function filter($recordObj){

		$filter_sql = "SELECT * FROM crm_tickets ";

		if(!empty($recordObj)){
			$filter_sql .= $recordObj;
		}

		/*
		print"<pre>";
		print_r($filter_sql);
		exit;
		*/

		//echo $filter_sql;

		$tickets_by_filter = DB::select($filter_sql);

		$ticketArray = array();
		if(!empty($tickets_by_filter)){
			foreach($tickets_by_filter as $ticketsObjElement) {
				$ticketArray[] = $this->_mapKeys($ticketsObjElement);
			}
		}

		return $ticketArray;
	}
	/*
	*update record in db
	*
	*@param $id,  $inputArray
	*@return if updated return updated id else return false
	*/
	public function updateById($catId,$inputArray){

		$upd_sql = "UPDATE crm_category_new SET cat_name='"
					.$inputArray['cat_name'].
				   "', cat_desc='"
				   .$inputArray['cat_desc'].
				   "', status="
				   .$inputArray['status'].
				   ", modified_on=NOW(), modified_by="
				   .$inputArray['modified_by']." WHERE cat_id = ".$catId;

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

	public function deleteById($categoryId){

		$del_sql = "DELETE FROM crm_category_new WHERE cat_id=".$categoryId;

		$category = DB::delete($del_sql);

		if(!empty($category)){
			return $category;
		}
		else{
			return false;
		}
	}

	/*
	Set Array Key
	*/
	private function _mapKeys($ticketObj){

		$mappedArray = array();

		$mappedArray['ticketId'] = $ticketObj->ticket_id;
		$mappedArray['requestorName'] = $ticketObj->requestor_name;
		$mappedArray['ticketSubject'] = $ticketObj->ticket_subject;
		$mappedArray['ticketText'] = $ticketObj->ticket_text;
		$mappedArray['ticketType'] = $ticketObj->ticket_type;
		$mappedArray['priority'] = $ticketObj->priority;
		$mappedArray['status'] = $ticketObj->status;
		$mappedArray['ticketAssigneduser'] = $ticketObj->ticket_assigneduser;
		$mappedArray['ticketGroupid'] = $ticketObj->ticket_groupid;
		$mappedArray['ticketSource'] = $ticketObj->ticket_source;
		$mappedArray['createdOn'] = ($ticketObj->create_on != "0000-00-00 00:00:00")?$ticketObj->create_on:null;
		$mappedArray['createdBy'] = $ticketObj->create_by;
		$mappedArray['modifiedOn'] = ($ticketObj->modified_on != "0000-00-00 00:00:00")?$ticketObj->modified_on:null;
		$mappedArray['modifiedBy'] = $ticketObj->modified_by;

		return $mappedArray;
	}
}



