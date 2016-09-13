<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ChatHistory extends Model {

	protected $table = 'crm_chat';
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

		$chatHistoryArray = array();
		$chat_history_query = "SELECT * FROM ".$this->table." WHERE chat_status = 1 AND (chat_type = 1 OR chat_type = 2) ";
		$chatHistoryObj = DB::select($chat_history_query);
		if(!empty($chatHistoryObj)){
			foreach($chatHistoryObj as $chatHistoryObjElement) {
				$chatHistoryArray[] = $this->_mapKeys($chatHistoryObjElement);
			}
		}
		$chatData['chats'] = $chatHistoryArray;
		return $chatData;
	}

	public function retrieveAllHistory() {

		$chatArray = array();
		$chat_sql = "SELECT * FROM ".$this->table." WHERE chat_status = 2";
		$chatObj = DB::select($chat_sql);
		if(!empty($chatObj)){
			foreach($chatObj as $chatObjElement){
				$chatArray[] = $this->_mapKeys($chatObjElement);
			}
		}
		return $chatArray;
	}

	public function getChatByWhere($params, $userId){
		$chatData = array();
		$chat_history_query = "SELECT * FROM ".$this->table." WHERE chat_status = 1 AND chat_type = 3 AND chat_attended_by = ".$userId;
		$chatHistoryObj = DB::select($chat_history_query);
		if(!empty($chatHistoryObj)){
			foreach($chatHistoryObj as $chatHistoryObjElement) {
				$chatHistoryArray[] = $this->_mapKeys($chatHistoryObjElement);
			}
			$chatData['empchats'] = $chatHistoryArray;
		}

		return $chatData;
	}

	public function getOnChat($params, $userId){
		$chatData = array();
		$chat_history_query = "SELECT * FROM ".$this->table." WHERE chat_status = 2 AND chat_attended_by = ".$userId;
		$chatHistoryObj = DB::select($chat_history_query);
		if(!empty($chatHistoryObj)){
			foreach($chatHistoryObj as $chatHistoryObjElement) {
				$chatHistoryArray[] = $this->_mapKeys($chatHistoryObjElement);
			}
			$chatData['onchats'] = $chatHistoryArray;
		}
		
		return $chatData;
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


	public function updateStatusById($chatId,$attendId,$inputArray){

		$upd_sql = "UPDATE ".$this->table." SET chat_status = 2, chat_attended_by = ".$attendId." WHERE chat_id = ".$chatId;

		//echo $upd_sql;
		//exit;

		$chat = DB::update($upd_sql);

		if(!empty($chat)){

			$chatHistory = array();

			$group_sql = "SELECT * FROM ".$this->table." WHERE chat_id = ".$chatId;

			$chatHistoryObj = DB::select($group_sql);

			if($chatHistoryObj){
				foreach($chatHistoryObj as $chatHistoryObjElement) {
					$chatHistory = $chatHistoryObjElement->chat_file;
					//$chatHistory = $this->_mapKeys($chatHistoryObjElement);
				}
			}
		}

		if(!empty($chatHistory)){
			return $chatHistory;
		}
		else{
			return false;
		}
	}

	public function chatClose($chatFile){

		$upd_sql = "UPDATE ".$this->table." SET chat_status = 3 WHERE chat_file = '".$chatFile."'";

		$chat = DB::update($upd_sql);

		if(!empty($chat)){
			return $chat;
		}
		else{
			return "0";
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
	private function _mapKeys($chatHistoryObj){

		$mappedArray = array();

		/*
			{"chats":[{"subject":"Hello How Are You","email":"michaleraj2008@gmail.com"},{"subject":"hello","email"
			:"michaleraj2008@gmail.com"}],"chatcount":2}
		*/

		$mappedArray['id'] = $chatHistoryObj->chat_id;
		$mappedArray['subject'] = $chatHistoryObj->chat_subject;
		$mappedArray['email'] = $chatHistoryObj->chat_email;
		//$mappedArray['chatAttendedBy'] = $chatHistoryObj->chat_attended_by;
		$mappedArray['status'] = $chatHistoryObj->chat_status;

		return $mappedArray;
	}
}



