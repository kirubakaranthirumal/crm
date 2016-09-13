<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model {

	protected $table = 'crm_category_new';
	public $timestamps = false;

	/*
	*insert record in db
	*
	*@param $recordObj
	*@return if inserted return last insert id else return false
	*/
	public function insert($recordObj){

		//print"<pre>";
		//print_r($recordObj);
		//exit;

		$category = DB::insert('INSERT INTO '.$this->table.' (cat_name,cat_desc,status,created_on,created_by) values (?, ?, ?, ?, ?)', [$recordObj->cat_name,$recordObj->cat_desc,$recordObj->status,$recordObj->created_on,$recordObj->created_by]);

		if(!empty($category)){
			return $category;
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

		$categoryArray = array();

		/*
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
				$query->orderBy("cat_id","DESC");
			}

			if(!empty($params['pageNo'])&&($params['pageNo']=='1')){
				$query->take($params['recordsCount']);
			}
			else{
				$query->skip(($params['pageNo']-1)*$params['recordsCount'])->take($params['recordsCount']);
			}
		}

		$categoryObj = $query->get();
		*/

		$cat_query = "SELECT * FROM ".$this->table;

		$categoryObj = DB::select($cat_query);

		//print"<pre>";
		//print_r($categoryObj);
		//exit;

		if($categoryObj){
			foreach($categoryObj as $categoryObjElement) {
				$categoryArray[] = $this->_mapKeys($categoryObjElement);
			}
		}

		//print"<pre>";
		//print_r($categoryArray);
		//exit;

		return $categoryArray;
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
	public function retrieveByWhere($catId){
		$category = DB::table($this->table)->where('cat_id', $catId)->first();
		return $category;
	}

	/*
	*update record in db
	*
	*@param $id,  $inputArray
	*@return if updated return updated id else return false
	*/
	public function updateById($catId,$inputArray){

		$upd_sql = "UPDATE ".$this->table." SET cat_name='"
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

		//$del_sql = "DELETE FROM ".$this->table." WHERE cat_id = ".$categoryId;

		$del_sql = "UPDATE ".$this->table." SET status = 2 WHERE cat_id = ".$categoryId;

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
	private function _mapKeys($categoryObj){

		$mappedArray = array();

		$mappedArray['categoryId'] = $categoryObj->cat_id;
		$mappedArray['categoryName'] = $categoryObj->cat_name;
		$mappedArray['categoryDescription'] = $categoryObj->cat_desc;
		$mappedArray['categoryStatus'] = $categoryObj->status;
		$mappedArray['categoryCreatedOn'] = ($categoryObj->created_on != "0000-00-00 00:00:00")?$categoryObj->created_on:null;
		$mappedArray['categoryCreatedBy'] = $categoryObj->created_by;
		$mappedArray['categoryModifiedOn'] = ($categoryObj->modified_on != "0000-00-00 00:00:00")?$categoryObj->modified_on:null;
		$mappedArray['categoryModifiedBy'] = $categoryObj->modified_by;

		return $mappedArray;
	}
}



