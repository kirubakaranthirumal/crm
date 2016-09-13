<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class FeedbackModel extends Model {

	protected $table = 'crm_feedback';
	public $timestamps = false;

	/*
	*insert record in db
	*
	*@param $recordObj
	*@return if inserted return last insert id else return false
	*/
	public function insert($recordObj){

/* 		print"<pre>";
		print_r($recordObj);
		exit; */

		$addfeedback = DB::insert('INSERT INTO crm_feedback (feed_type,feed_user_name, feed_email, feed_subject, feed_mobile, feed_desc,feed_status, feed_created_on, feed_created_by) values (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$recordObj->feed_type,$recordObj->name,$recordObj->email,$recordObj->subject,$recordObj->mobile_no,$recordObj->message,$recordObj->status,$recordObj->created_on,$recordObj->created_by]);

/* 		print"<pre>";
		print_r($addfeedback);
		exit; */
		if(!empty($addfeedback)){
			return $addfeedback;
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

		$feedbackArray = array();

		$feed_sql = "SELECT * FROM ".$this->table;

		$feedObj = DB::select($feed_sql);

		if($feedObj){
			foreach($feedObj as $feedObjElement) {
				$feedbackArray[] = $this->_mapKeys($feedObjElement);
			}
		}

		//print"<pre>";
		//print_r($feedbackArray);
		//exit;

		return $feedbackArray;
	}

	/*
	*retrive all based on params record from db
	*
	*@paramkey
	*@return result array
	*/
	public function retrieveAllParentMenu($params) {

		$groupArray = array();

		if(!empty($params)){

			$whrClause = array();
			//$whrClause['order_user_id'] = $params['userId'];
			$query =SELF::where($whrClause);

			if(!empty($params['startDate'])){
				 $query->where('created_on', '>=', $params['startDate']);
			}elseif(!empty($params['endDate'])){
				$query->where('created_on', '<=', $params['endDate']);
			}

			if((!empty($params['sortingColumn']))&&(!empty($params['sortingOrder']))){
				 $query->orderBy($params['sortingColumn'],$params['sortingOrder']);
			}
			else{
				$query->orderBy("menu_id","DESC");
			}

			if(!empty($params['pageNo'])&&($params['pageNo']=='1')){
				$query->take($params['recordsCount']);
			}
			else{
				$query->skip(($params['pageNo']-1)*$params['recordsCount'])->take($params['recordsCount']);
			}
		}

		$groupObj = $query->get();

		$content_management = DB::select('SELECT * FROM crm_menu_cms LEFT JOIN crm_users ON crm_menu_cms.menu_created_by = crm_users.crm_userid WHERE menu_parent_id = 0');

		$cmArray = array();
		if($content_management){
			foreach($content_management as $cmObjElement) {
				$cmArray[] = $this->_mapKeys($cmObjElement);
			}
		}

		//print"<pre>";
		//print_r($cmArray);
		//exit;

		return $cmArray;
	}

	/*
	*retrive record from db
	*
	*@paramkey $whrClause
	*@return result array
	*/



	public function retrieveInfo($feedId) {



		$whrClause = array();
			//$whrClause['order_user_id'] = $params['userId'];
			$query =SELF::where($whrClause);

		//$groupObj = SELF::where($whrClause)->get();

		//$menucontent = DB::table('crm_menu_cms')->where('menu_id', $menuId)->first();

		$select_sql = "SELECT FROM crm_feedback WHERE feed_id=".$feedId;

		$content_management = DB::select($select_sql);

		$cmArray = array();
		if($content_management){
			foreach($content_management as $cmObjElement) {
				$cmArray = $this->_mapKeys($cmObjElement);
			}
		}
		print"<pre>";
		print_r($cmArray);
		exit;
		return $cmArray;
	}

	/*
	*retrive record from db
	*
	*@paramkey $whrClause
	*@return result array
	*/
	public function retrieveByWhere($feedId) {

		$groupArray = array();

		//$groupObj = SELF::where($whrClause)->get();

		$feedback = DB::table('crm_feedback')->where('feed_id', $feedId)->first();
/*
		print"<pre>";
		print_r($feedback);
		exit; */
		return $feedback;
	}
	/*
	*retrive record from db
	*
	*@paramkey $whrClause
	*@return result array
	*/
	public function retrieveByWhereNameUpdate($params,$id){

		$groupArray = array();

		//$groupObj = SELF::where($whrClause)->get();

		//$menucontent = DB::table('crm_menu_cms')->where('menu_name', $menuName)->first();

		$select_sql = "SELECT * FROM crm_menu_cms LEFT JOIN crm_users ON crm_menu_cms.menu_created_by = crm_users.crm_userid "." WHERE menu_name = '".$params['menu_name']."' AND menu_id <> ".$id;

		//echo $select_sql;
		//exit;

		$content_management = DB::select($select_sql);

		$cmArray = array();
		if($content_management){
			foreach($content_management as $cmObjElement) {
				$cmArray = $this->_mapKeys($cmObjElement);
			}
		}

		//print"<pre>";
		//print_r($cmArray);
		//exit;

		return $cmArray;
	}

	/*
	*update record in db
	*
	*@param $id,  $inputArray
	*@return if updated return updated id else return false
	*/
	public function updateById($menuId,$inputArray){

		//$deptObj = SELF::find($deptId);

		$upd_sql = "UPDATE crm_menu_cms SET menu_parent_id='"
					.$inputArray['menu_parent'].
				   "',menu_name='"
					.$inputArray['menu_name'].
				   "', menu_title='"
				   .$inputArray['menu_title'].
				   "', menu_content='"
				   . htmlentities($inputArray['menu_desc']).
				   "',  menu_sort_order='"
				   .$inputArray['menu_sort'].
				   "',menu_visible="
				   .$inputArray['menu_visible'].
				   ",menu_status="
				   .$inputArray['status'].
				   ", menu_modified_on=NOW(), menu_modified_by="
				   .$inputArray['modified_by']." WHERE menu_id = ".$menuId;



		$menucontent = DB::update($upd_sql);
		/* 	print"<pre>";
			print_r($menucontent);
			exit; */
		if(!empty($menucontent)){
			return $menucontent;
		}
		else{
			return false;
		}
	}

		public function detailsById($feedId){

		/*  print"<pre>";
		print_r($feedId);
		exit; */

		$sel_sql = "SELECT FROM crm_feedback WHERE feed_id=".$feedId;

		$menucontent = DB::select($sel_sql);

		/* 	print"<pre>";
			print_r($menucontent);
			exit; */
		if(!empty($menucontent)){
			return $menucontent;
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
	public function deleteById($feedId){

		/* print"<pre>";
		print_r($feedId);
		exit;
 */
		$del_sql = "DELETE FROM crm_feedback WHERE feed_id=".$feedId;

		$menucontent = DB::delete($del_sql);

		if(!empty($menucontent)){
			return $menucontent;
		}
		else{
			return false;
		}
	}

	/*
	Set Array Key
	*/
	private function _mapKeys($feedObj){

		$mappedArray = array();
		$mappedArray['feed_id'] = $feedObj->feed_id;
		$mappedArray['feed_type'] = $feedObj->feed_type;
		$mappedArray['feed_name'] = $feedObj->feed_user_name;
		$mappedArray['feed_email'] = $feedObj->feed_email;
		$mappedArray['feed_subject'] = $feedObj->feed_subject;
		$mappedArray['feed_mobile'] = $feedObj->feed_mobile;
		$mappedArray['feed_desc'] = $feedObj->feed_desc;
		$mappedArray['feed_rating'] = $feedObj->feed_rating;
		$mappedArray['feed_status'] = $feedObj->feed_status;
		$mappedArray['feed_created_on'] = ($feedObj->feed_created_on != "0000-00-00 00:00:00")?$feedObj->feed_created_on:null;
		$mappedArray['feed_created_by'] = $feedObj->feed_created_by;
		//$mappedArray['menuModifiedOn'] = ($menuObj->menu_modified_on != "0000-00-00 00:00:00")?$menuObj->menu_modified_on:null;
		//$mappedArray['menuModifiedBy'] = $menuObj->menu_modified_by;

		return $mappedArray;
	}

}



