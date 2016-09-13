<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ContentManagement extends Model {


	protected $table = 'crm_menu_cms';
	public $timestamps = false;

	/*
	*insert record in db
	*
	*@param $recordObj
	*@return if inserted return last insert id else return false
	*/
	public function insert($recordObj){

		$addmenucontent = DB::insert('INSERT INTO crm_menu_cms (menu_app,menu_parent_id, menu_name, menu_title, menu_content, menu_sort_order,menu_visible,menu_status, menu_created_on, menu_created_by) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$recordObj->menu_app,$recordObj->menu_parent,$recordObj->menu_name,$recordObj->menu_title,$recordObj->menu_desc,$recordObj->menu_sort,$recordObj->menu_visible,$recordObj->status,$recordObj->created_on,$recordObj->created_by]);

		//print"<pre>";
		//print_r($addmenucontent);
		//exit;

		if(!empty($addmenucontent)){
			return $addmenucontent;
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

		/* print"<pre>";
		print_r($groupObj);
		exit;  */

		/*
		if($groupObj){
			foreach($groupObj as $groupObjElement) {
				$groupArray[] = $this->_mapKeys($groupObjElement);
			}
		}
		*/

		$content_management = DB::select('SELECT * FROM crm_menu_cms LEFT JOIN crm_users ON crm_menu_cms.menu_created_by = crm_users.crm_userid');

		$cmArray = array();
		if($content_management){
			foreach($content_management as $cmObjElement) {
				$cmArray[] = $this->_mapKeys($cmObjElement);
			}
		}

		/* print"<pre>";
		print_r($groupArray);
		exit; */

	/* 	print"<pre>";
		print_r($cmArray);
		exit; */

		return $cmArray;
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
	public function retrieveByWhere($menuId) {

		$groupArray = array();

		//$groupObj = SELF::where($whrClause)->get();

		//$menucontent = DB::table('crm_menu_cms')->where('menu_id', $menuId)->first();

		$select_sql = 'SELECT * FROM crm_menu_cms LEFT JOIN crm_users ON crm_menu_cms.menu_created_by = crm_users.crm_userid '.' WHERE menu_id = '.$menuId;

		$content_management = DB::select($select_sql);

		$cmArray = array();
		if($content_management){
			foreach($content_management as $cmObjElement) {
				$cmArray = $this->_mapKeys($cmObjElement);
			}
		}

		return $cmArray;
	}

	/*
	*retrive record from db
	*
	*@paramkey $whrClause
	*@return result array
	*/
	public function retrieveByWhereName($params){

		$groupArray = array();

		//$groupObj = SELF::where($whrClause)->get();

		//$menucontent = DB::table('crm_menu_cms')->where('menu_name', $menuName)->first();

		$select_sql = "SELECT * FROM crm_menu_cms LEFT JOIN crm_users ON crm_menu_cms.menu_created_by = crm_users.crm_userid "." WHERE menu_name = '".$params['menu_name']."'";

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
				   .$inputArray['editor'].
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

	/*
	*delete record in db
	*
	*@param $id
	*/
	public function deleteById($menuId){

		$del_sql = "DELETE FROM crm_menu_cms WHERE menu_id=".$menuId;

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
	private function _mapKeys($menuObj){

		$mappedArray = array();
		$mappedArray['menuId'] = $menuObj->menu_id;
		$mappedArray['menuParent'] = $menuObj->menu_parent_id;
		$mappedArray['menuName'] = $menuObj->menu_name;
		$mappedArray['menuTitle'] = $menuObj->menu_title;
		$mappedArray['menuDescription'] = $menuObj->menu_content;
		$mappedArray['menuSortOrder'] = $menuObj->menu_sort_order;
		$mappedArray['menuVisible'] = $menuObj->menu_visible;
		$mappedArray['menuStatus'] = $menuObj->menu_status;
		$mappedArray['menuCreatedOn'] = ($menuObj->menu_created_on != "0000-00-00 00:00:00")?$menuObj->menu_created_on:null;
		$mappedArray['menuCreatedBy'] = $menuObj->menu_created_by;
		$mappedArray['menuModifiedOn'] = ($menuObj->menu_modified_on != "0000-00-00 00:00:00")?$menuObj->menu_modified_on:null;
		$mappedArray['menuModifiedBy'] = $menuObj->menu_modified_by;

		return $mappedArray;
	}

}



