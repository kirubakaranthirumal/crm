<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class EmailTemplate extends Model {

	protected $table = 'crm_email_template_new';
	public $timestamps = false;

	/*
	*insert record in db
	*
	*@param $recordObj
	*@return if inserted return last insert id else return false
	*/
	public function insert($recordObj){

		$recordObj->template_attachment = 1;
		$recordObj->template_user_group = 1;

		//print"<pre>";
		//print_r($recordObj);
		//exit;

		/*

			template_cat_id integer NOT NULL,
			template_name character varying(255) NOT NULL,
			template_from character varying(255) NOT NULL,
			template_subject character varying(255) NOT NULL,
			template_attachment character varying(255) NOT NULL,
			template_user_group character varying(255) NOT NULL,
			template_user_field character varying(255) NOT NULL,
			template_merged_fld_val character varying(255) NOT NULL,
			template_body text,

		*/

		$email_template = DB::insert('INSERT INTO crm_email_template_new (template_cat_id, template_name, template_desc, template_from, template_subject, template_attachment, template_user_group,	template_user_field, template_merged_fld_val, template_body, template_status, created_on, created_by) values	(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$recordObj->template_cat_id, $recordObj->template_name, $recordObj->template_desc, $recordObj->template_from, $recordObj->template_subject, $recordObj->template_attachment, $recordObj->template_user_group, $recordObj->template_user_field, $recordObj->template_merged_fld_val, $recordObj->template_body, $recordObj->template_status, $recordObj->created_on, $recordObj->created_by]);

		if(!empty($email_template)){
			return $email_template;
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

		$emailTemplateArray = array();

		if(!empty($params)){

			$whrClause = array();

			$query =SELF::where($whrClause);

			if(!empty($params['startDate'])){
				 $query->where('created_on', '>=', $params['startDate']);
			}
			elseif(!empty($params['endDate'])){
				$query->where('created_on', '<=', $params['endDate']);
			}

			if((!empty($params['sortingColumn']))&&(!empty($params['sortingOrder']))){
				$query->orderBy($params['sortingColumn'],$params['sortingOrder']);
			}
			else{
				$query->orderBy("template_id","DESC");
			}

			if(!empty($params['pageNo'])&&($params['pageNo']=='1')){
				$query->take($params['recordsCount']);
			}
			else{
				$query->skip(($params['pageNo']-1)*$params['recordsCount'])->take($params['recordsCount']);
			}
		}

		$emailTemplateArray = array();

		$email_template = DB::select('SELECT * FROM crm_email_template_new LEFT JOIN crm_users ON crm_email_template_new.created_by = crm_users.crm_userid');

		//$email_template = DB::select('SELECT template_id, template_cat_id, template_name, template_desc, template_from, template_subject, template_attachment, template_user_group, template_user_field, template_merged_fld_val, template_body, template_status, created_on, created_by, modified_on, modified_by FROM crm_email_template_new');

		//$emailTemplateObj = $query->get();

		if($email_template){
			foreach($email_template as $emailTemplateObjElement) {
				$emailTemplateArray[] = $this->_mapKeys($emailTemplateObjElement);
			}
		}

		//print"<pre>";
		//print_r($emailTemplateArray);
		//exit;

		return $emailTemplateArray;
	}


	/*
	*retrive all based on params record from db
	*
	*@paramkey
	*@return result array
	*/
	public function retrieveAllCategoryTemplate($params) {

		$emailTemplateArray = array();

		/*
		if(!empty($params)){

			$whrClause = array();

			$query =SELF::where($whrClause);

			if((!empty($params['sortingColumn']))&&(!empty($params['sortingOrder']))){
				$query->orderBy($params['sortingColumn'],$params['sortingOrder']);
			}
			else{
				$query->orderBy("template_id","DESC");
			}

			if(!empty($params['pageNo'])&&($params['pageNo']=='1')){
				$query->take($params['recordsCount']);
			}
			else{
				$query->skip(($params['pageNo']-1)*$params['recordsCount'])->take($params['recordsCount']);
			}
		}
		*/

		$emailTemplateArray = array();

		$email_template = "";
		if(!empty($params['catId'])){
			$email_template = DB::select('SELECT * FROM crm_email_template_new LEFT JOIN crm_users ON crm_email_template_new.created_by = crm_users.crm_userid WHERE template_cat_id = '.$params['catId']);
		}
		else{
			$email_template = DB::select('SELECT * FROM crm_email_template_new LEFT JOIN crm_users ON crm_email_template_new.created_by = crm_users.crm_userid');
		}

		//$email_template = DB::select('SELECT template_id, template_cat_id, template_name, template_desc, template_from, template_subject, template_attachment, template_user_group, template_user_field, template_merged_fld_val, template_body, template_status, created_on, created_by, modified_on, modified_by FROM crm_email_template_new');

		//$emailTemplateObj = $query->get();

		if($email_template){
			foreach($email_template as $emailTemplateObjElement) {
				$emailTemplateArray[] = $this->_mapKeys($emailTemplateObjElement);
			}
		}

		//print"<pre>";
		//print_r($emailTemplateArray);
		//exit;

		return $emailTemplateArray;
	}

	/*
	*retrive all based on params record from db
	*
	*@paramkey
	*@return result array
	*/
	public function retrieveSingle($params) {

		$templateArray = array();

		$template_query = "";

		//print"<pre>";
		//print_r($params);
		//exit;

		$email_template = "";

		if((!empty($params['template_category'])) && (!empty($params['template_name']))){
			$template_query = "SELECT * FROM crm_email_template_new";
			$template_query .= " LEFT JOIN crm_users ON crm_email_template_new.created_by = crm_users.crm_userid ";
			//$template_query .= " LEFT JOIN cg_register ON crm_email_template_new.template_cat_id = cg_register.register_type ";
			$template_query .= " WHERE template_cat_id = ".$params['template_category']." AND template_id = ".$params['template_name'];
		}
		else{
			$template_query = "SELECT * FROM crm_email_template_new LEFT JOIN crm_users ON crm_email_template_new.created_by = crm_users.crm_userid ";
		}

		//echo $template_query;
		//exit;

		$email_template = DB::select($template_query);

		if($email_template){
			foreach($email_template as $emailTemplateObjElement) {
				$templateArray = $this->_mapKeys($emailTemplateObjElement);
			}
		}

		//print"<pre>";
		//print_r($templateArray);
		//exit;

		return $templateArray;
	}

	/*
	*retrive record from db
	*
	*@paramkey $whrClause
	*@return result array
	*/
	public function retrieveByWhere($whereStr){

		$emailTemplateArray = array();

		$emailTemplate = "";

		//$emailTemplate = DB::table('crm_email_template_new')->where($whereStr)->first();

		$template_sql = "SELECT * FROM crm_email_template_new LEFT JOIN crm_users ON crm_email_template_new.created_by = crm_users.crm_userid WHERE template_id = ".$whereStr['template_id'];

		//echo $template_sql;
		//exit;

		$email_template = DB::select($template_sql);

		//$email_template = DB::select('SELECT template_id, template_cat_id, template_name, template_desc, template_from, template_subject, template_attachment, template_user_group, template_user_field, template_merged_fld_val, template_body, template_status, created_on, created_by, modified_on, modified_by FROM crm_email_template_new WHERE template_id = '.$whereStr['template_id']);

		if($email_template){
			foreach($email_template as $emailTemplateObjElement) {
				$emailTemplateArray = $this->_mapKeys($emailTemplateObjElement);
			}
		}

		//print"<pre>";
		//print_r($emailTemplateArray);
		//exit;

		return $emailTemplateArray;
	}

	/*
	*update record in db
	*
	*@param $id,  $inputArray
	*@return if updated return updated id else return false
	*/
	public function updateById($templateId,$inputArray){

		$upd_sql = "UPDATE crm_email_template_new SET template_name='"
					.$inputArray['template_name'].
				   "', template_cat_id='"
				   .$inputArray['template_category'].
				   "', template_desc='"
				   .$inputArray['template_desc'].
				   "', template_from='"
				   .$inputArray['template_from'].
				   "', template_subject='"
				   .$inputArray['template_subject'].
				   "', template_attachment='"
				   .$inputArray['template_attachment'].
				   "', template_user_group='"
				   .$inputArray['template_user_group'].
				   "', template_user_field='"
				   .$inputArray['template_user_field'].
				   "', template_merged_fld_val='"
				   .$inputArray['template_merged_fld_val'].
				   "', template_body='"
				   .$inputArray['editor'].
				   "', template_status="
				   .$inputArray['status'].
				   ", modified_on=NOW(), modified_by="
				   .$inputArray['modified_by']." WHERE template_id = ".$templateId;

		//echo $upd_sql;
		//exit;

		$emailTemplate = DB::update($upd_sql);

		if(!empty($emailTemplate)){
			return $emailTemplate;
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
	public function deleteById($templateId){

		$del_sql = "DELETE FROM crm_email_template_new WHERE template_id=".$templateId;

		$emailTemplate = DB::delete($del_sql);

		if(!empty($emailTemplate)){
			return $emailTemplate;
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

		$mappedArray['templateId'] = $deptObj->template_id;
		$mappedArray['templateCatId'] = $deptObj->template_cat_id;
		$mappedArray['templateName'] = $deptObj->template_name;
		$mappedArray['templateDescription'] = $deptObj->template_desc;
		$mappedArray['templateFrom'] = $deptObj->template_from;
		$mappedArray['templateSubject'] = $deptObj->template_subject;
		$mappedArray['templateAttachment'] = $deptObj->template_attachment;
		$mappedArray['templateUserGroup'] = $deptObj->template_user_group;
		$mappedArray['templateUserField'] = $deptObj->template_user_field;
		$mappedArray['templateMergedFldVal'] = $deptObj->template_merged_fld_val;
		$mappedArray['templateBody'] = $deptObj->template_body;
		$mappedArray['templateStatus'] = $deptObj->template_status;
		$mappedArray['templateCreatedOn'] = ($deptObj->created_on != "0000-00-00 00:00:00")?$deptObj->created_on:null;
		$mappedArray['templateCreatedBy'] = $deptObj->created_by;
		$mappedArray['templateModifiedOn'] = ($deptObj->modified_on != "0000-00-00 00:00:00")?$deptObj->modified_on:null;
		$mappedArray['templateModifiedBy'] = $deptObj->modified_by;

		if(!empty($deptObj->crm_userid)){
			$mappedArray['userId'] = $deptObj->crm_userid;
		}

		if(!empty($deptObj->first_name)){
			$mappedArray['templateCreatedByFirstName'] = $deptObj->first_name;
		}

		if(!empty($deptObj->last_name)){
			$mappedArray['templateCreatedByLastName'] = $deptObj->last_name;
		}

		if(!empty($deptObj->email)){
			$mappedArray['templateCreatedByEmail'] = $deptObj->email;
		}

		return $mappedArray;
	}

}



