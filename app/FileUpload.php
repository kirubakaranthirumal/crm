<?php
//include_once("cThumbnail.php");
//include_once("cThumbnailap.php");

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class FileUpload extends Model {

	// member variable declaration
	var $uploadedfile_ary, $rename_filename,$filefieldname;
	var $prefix_str,$suffix_str,$unique;
	var $uploaded_max_size;
	var $errormessage,$uploaded_file_name;

	var $uploaded_ext_ary,$multiple_uploaded_ext_ary;
	var $uploaded_directory,$multiple_uploaded_directory;

	var $file_size,$file_type,$file_tmp_name,$file_error;
	var $file_name,$multiple_upload,$i;
	var $file_count;

	// uploaded max size should be in bytes

	function FileUpload ($upload_ary){


		//constructor to initialize of the uploaded array

		//not optional
		$this->uploadedfile_ary = $upload_ary['varUploadedFileAry'];

		if(!empty($upload_ary['varMultipleUploadedDirectory'])){
			$this->multiple_uploaded_directory=$upload_ary['varMultipleUploadedDirectory'];
		}
		else{
			$this->uploaded_directory=$upload_ary['varUploadedDirectory'];
		}


		// not an input
		$this->uploaded_file_name =array();

		//optional ;

		if(!empty($upload_ary['varRenameFileName'])){
			$this->rename_filename=$upload_ary['varRenameFileName'];
		}
		else{
			$this->rename_filename="";
		}

		if(!empty($upload_ary['varPrefixStr'])){
			$this->prefix_str=$upload_ary['varPrefixStr'];
		}
		else{
			$this->prefix_str="";
		}

		if(!empty($upload_ary['varSuffixStr'])){
			$this->suffix_str=$upload_ary['varSuffixStr'];
		}
		else{
			$this->suffix_str="";
		}

		if(!empty($upload_ary['varUnique'])){
			$this->unique=$upload_ary['varUnique'];
		}

		if(!empty($upload_ary['varExtAry'])){
			$this->uploaded_ext_ary =$upload_ary['varExtAry'];
		}
		else{
			$this->uploaded_ext_ary =array();
		}

		if(!empty($upload_ary['varMultipleExtAry'])){
			$this->multiple_uploaded_ext_ary =$upload_ary['varMultipleExtAry'];
		}
		else{
			$this->multiple_uploaded_ext_ary =array();
		}

		if(!empty($upload_ary['varMaxSize'])){
			$this->uploaded_max_size=$upload_ary['varMaxSize'];
		}
		else{
			//$this->uploaded_max_size=5242880;	// default will be 5 MB
		}

		//echo "this";
		//echo $this->uploaded_max_size;
		//exit;

		//for crop section
		if(!empty($upload_ary['varCropWidth'])){
			$this->img_crop_width=$upload_ary['varCropWidth'];
		}
		else{
			$this->img_crop_width="100";
		}

		if(!empty($upload_ary['varCropHeight'])){
			$this->img_crop_height=$upload_ary['varCropHeight'];
		}
		else{
			$this->img_crop_height="100";
		}

		$this->file_size="";
		$this->file_count="";
		$this->file_type="";
		$this->file_tmp_name="";
		$this->file_error="";
		$this->file_name="";

		$this->i="";	//multiple index
		$this->multiple_upload="";

		$this->errormessage=array();
	}

	function uploadFile(){

		// upload file
		// dont use move_uploaded_file ( will fall under version dependency)
		// use is_file_uploaded(filename) and use copy(source, destination)
		if(!empty($this->uploadedfile_ary)){

			foreach($this->uploadedfile_ary as $key => $upload_file){

				if(!empty($this->uploadedfile_ary[$key]['error'])){
					$this->file_error = $this->uploadedfile_ary[$key]['error'];
				}

				$this->filefieldname=$key;

				if(!empty($this->uploadedfile_ary[$this->filefieldname])){


					if(is_array($this->uploadedfile_ary[$this->filefieldname]['name']) && is_array($this->uploadedfile_ary[$this->filefieldname]['size']) && is_array($this->uploadedfile_ary[$this->filefieldname]['type'])){

						$this->multiple_upload=1;

						$ary_length=count($this->uploadedfile_ary[$this->filefieldname]['name']);


						for($this->i=0;$this->i<$ary_length;$this->i++){

							$this->file_size=$this->uploadedfile_ary[$this->filefieldname]['size'][$this->i];
							$this->file_type=$this->uploadedfile_ary[$this->filefieldname]['type'][$this->i];
							$this->file_name=$this->uploadedfile_ary[$this->filefieldname]['name'][$this->i];
							$this->file_tmp_name=$this->uploadedfile_ary[$this->filefieldname]['tmp_name'][$this->i];
							$this->file_error=$this->uploadedfile_ary[$this->filefieldname]['error'][$this->i];

							if(!empty($this->multiple_uploaded_ext_ary)){
								$this->uploaded_ext_ary = $this->multiple_uploaded_ext_ary[$this->i];
							}

							if(!empty($this->multiple_uploaded_directory)){
								$this->uploaded_directory = $this->multiple_uploaded_directory[$this->i];
							}

							$this->file_count=$this->file_count+1;

							$this->doUpload();

						}

					}
					else{

						$this->i="";
						$this->multiple_upload=0;

						$this->file_size=$this->uploadedfile_ary[$this->filefieldname]['size'];
						$this->file_type=$this->uploadedfile_ary[$this->filefieldname]['type'];
						$this->file_name=$this->uploadedfile_ary[$this->filefieldname]['name'];
						$this->file_tmp_name=$this->uploadedfile_ary[$this->filefieldname]['tmp_name'];

						if(!empty($this->multiple_uploaded_ext_ary[$this->filefieldname])){
							$this->uploaded_ext_ary = $this->multiple_uploaded_ext_ary[$this->filefieldname];
						}

						if(!empty($this->multiple_uploaded_directory[$this->filefieldname])){
							$this->uploaded_directory = $this->multiple_uploaded_directory[$this->filefieldname];
						}

						$this->file_count=$this->file_count+1;

						$this->doUpload();

					}
				}
			}
		}
		else{
			$this->setErrorMsg("Error : Invalid input to file upload ");
		}

		if($this->isErrorMsg()){
			return false;
		}
		else{
			return true;
		}
	}

	function doUpload(){

		if($this->checkUploadError()){

			if($this->checkFileSize()){

				if($this->validateFileExtension($this->file_name)){
					$new_name = "";

					if($this->unique==1){
						$timestamp=time();
						$timestamp=$timestamp.$this->file_count;
						$new_name =$timestamp."_".$this->file_name;
					}
					elseif($this->unique==2){

						$page_file_name=$this->file_name;

						$i = strrpos($page_file_name,".");

						if (!$i){
							return false;
						}

						$l = strlen($page_file_name) - $i;
						$ext = substr($page_file_name,$i+1,$l);
						$ext = strtolower($ext);

						$timestamp=time();
						$timestamp=$timestamp.$this->file_count;

						$new_name =$timestamp.".".$ext;

					}
					elseif(!empty($this->prefix_str)){
						$new_name =$this->prefix_str."_".$this->file_name;
					}
					elseif(!empty($this->suffix_str)){

						$page_file_name=$this->file_name;

						$i = strrpos($page_file_name,".");

						if (!$i){
							return false;
						}

						$l = strlen($page_file_name) - $i;
						$ext = substr($page_file_name,$i+1,$l);
						$ext = strtolower($ext);

						$page_file_name_only=substr($page_file_name,0,$i);

						$new_name =$page_file_name_only."_".$this->suffix_str.".".$ext;

					}
					else{
						$new_name=$this->file_name;
					}

					$new_name = $this->i.$new_name;


					if($this->isFileExists($this->uploaded_directory.$new_name)){

						if(is_uploaded_file($this->file_tmp_name)){

							if(!@move_uploaded_file($this->file_tmp_name,$this->uploaded_directory.$new_name)){

								//echo "here";
								$this->setErrorMsg("Error : File could not uploaded..");
							}
							else{

								$this->uploaded_file_name[] = $new_name;
								//echo $new_name;
								//$this->CopyImage();
							}
						}
						else{
							$this->setErrorMsg("Error : while upload Banner file");
						}

					}
				}
			}
		}
	}

	function CopyImage(){

		if(!empty($this->uploadedfile_ary)){

			//print_r($this->uploadedfile_ary);

			//$this->file_name=$this->uploadedfile_ary;

			set_time_limit(300);

			$page_file_name=$this->file_name;

			$i = strrpos($page_file_name,".");

			if (!$i){
				return false;
			}

			$l = strlen($page_file_name) - $i;
			$ext = substr($page_file_name,$i+1,$l);
			$ext = strtolower($ext);

			$newFilename=substr($this->uploaded_file_name[0], 0, -4)."_small.".$ext;

			if (substr(trim($this->file_name), -3) == "jpg" || substr($this->file_name, -3) == "JPG") {

				if (@copy($this->uploaded_directory.$this->uploaded_file_name[0], $this->uploaded_directory.$newFilename)) {

					$photouploaded = 1;

					//$msg.= "You uploaded the file: ".$newFilename." (".$this->file_size." bytes)<br>";

					$photo = new Thumbnailap($this->uploaded_directory.$newFilename);

					$photo->resize($this->img_crop_width,5000);

					$photo->save($this->uploaded_directory.$newFilename);

					$thumb = new Thumbnailap($this->uploaded_directory.$newFilename);

					$imgInfo = getimagesize($this->uploaded_directory.$newFilename);
					$imageWidth = $imgInfo[0];
					$imageHeight = $imgInfo[1];

					//CREATE A LONG WIDE IMAGE CROPPING FROM CENTER

					$startY = ($imageHeight/2)-89; // Subtract half the desired height

					/*
					echo $startY."<br>";
					echo $this->img_crop_width."<br>";
					echo $this->img_crop_height."<br>";
					exit;
					*/

					$thumb->crop(0,$startY,$this->img_crop_width,$this->img_crop_height);

					$thumb->save($this->uploaded_directory.$newFilename);

					//$this->uploaded_file_name[] = $newFilename;

					//unlink($this->file_tmp_name);

				}
				else {
					$this->setErrorMsg("ERROR: The file $newFilename could not copied and resized.");
				}

			}
			else {
				$this->setErrorMsg("The file ".$newFilename." was NOT copied and resized.<br />Only files with .jpg extension will be accepted.");
			}

		}
		else{
			$this->setErrorMsg("Error : Invalid input to file upload ");
		}

		if($this->isErrorMsg()){
			return false;
		}
		else{
			return true;
		}

	}

	function setZaazleThumbnail($directory_path,$image_url,$id,$itm_count){

		if(!empty($image_url) && !empty($directory_path) && !empty($id) && !empty($itm_count)){

			$newFilename="pw_".$id."_".$itm_count.".jpg";

			set_time_limit(300);

			if (@copy(''.$image_url.'', $directory_path.$newFilename)) {

				$photouploaded = 1;

				//$msg.= "You uploaded the file: ".$newFilename." (".$this->file_size." bytes)<br>";

				$photo = new Thumbnailap($directory_path.$newFilename);

				$photo->resize($this->img_crop_width,5000);

				$photo->save($directory_path.$newFilename);



				$thumb = new Thumbnailap($directory_path.$newFilename);

				$imgInfo = getimagesize($directory_path.$newFilename);
				$imageWidth = $imgInfo[0];
				$imageHeight = $imgInfo[1];

				//CREATE A LONG WIDE IMAGE CROPPING FROM CENTER

				$startY = ($imageHeight/2)-89; // Subtract half the desired height

				/*
				echo $startY."<br>";
				echo $this->img_crop_width."<br>";
				echo $this->img_crop_height."<br>";
				exit;
				*/

				$thumb->crop(0,$startY,$this->img_crop_width,$this->img_crop_height);

				$thumb->save($directory_path.$newFilename);



				//$this->uploaded_file_name[] = $newFilename;
				//unlink($this->file_tmp_name);

			}
			else {
				$this->setErrorMsg("ERROR: The file $newFilename could not copied and resized.");
			}
		}
		else{
			$this->setErrorMsg("Error : Invalid input to file upload ");
		}

		if($this->isErrorMsg()){
			return false;
		}
		else{
			return true;
		}

	}

	function setEzpThumbnail($directory_path,$image_url,$id,$itm_count){

			if(!empty($image_url) && !empty($directory_path) && !empty($id) && !empty($itm_count)){

				$newFilename="pw_".$id."_".$itm_count.".jpg";

				set_time_limit(300);

				if (@copy(''.$image_url.'', $directory_path.$newFilename)) {

					$photouploaded = 1;

					//$msg.= "You uploaded the file: ".$newFilename." (".$this->file_size." bytes)<br>";

					$photo = new Thumbnailap($directory_path.$newFilename);

					$photo->resize($this->img_crop_width,5000);

					$photo->save($directory_path.$newFilename);



					$thumb = new Thumbnailap($directory_path.$newFilename);

					$imgInfo = getimagesize($directory_path.$newFilename);
					$imageWidth = $imgInfo[0];
					$imageHeight = $imgInfo[1];

					//CREATE A LONG WIDE IMAGE CROPPING FROM CENTER

					$startY = ($imageHeight/2)-89; // Subtract half the desired height

					/*
					echo $startY."<br>";
					echo $this->img_crop_width."<br>";
					echo $this->img_crop_height."<br>";
					exit;
					*/

					$thumb->crop(0,$startY,$this->img_crop_width,$this->img_crop_height);

					$thumb->save($directory_path.$newFilename);



					//$this->uploaded_file_name[] = $newFilename;
					//unlink($this->file_tmp_name);

				}
				else {
					$this->setErrorMsg("ERROR: The file $newFilename could not copied and resized.");
				}
			}
			else{
				$this->setErrorMsg("Error : Invalid input to file upload ");
			}

			if($this->isErrorMsg()){
				return false;
			}
			else{
				return true;
			}

	}

	function setOrderItemThumbnail($directory_path,$image_url,$id){

		if(!empty($image_url) && !empty($directory_path) && !empty($id) ){

			if(strtolower(substr($image_url,-3))=="png"){
				$file_ext="png";
			}
			else{
				$file_ext="jpg";
			}

			$newFilename="Pw_".$id.".".$file_ext;

			set_time_limit(300);

			if (@copy(''.$image_url.'', $directory_path.$newFilename)) {

				$photouploaded = 1;

				//$msg.= "You uploaded the file: ".$newFilename." (".$this->file_size." bytes)<br>";

				$photo = new Thumbnailap($directory_path.$newFilename);


				$photo->resize($this->img_crop_width,5000);


				$photo->save($directory_path.$newFilename);




				$thumb = new Thumbnailap($directory_path.$newFilename);

				$imgInfo = getimagesize($directory_path.$newFilename);
				$imageWidth = $imgInfo[0];
				$imageHeight = $imgInfo[1];

				/*
				//CREATE A LONG WIDE IMAGE CROPPING FROM CENTER
				$startY = ($imageHeight/2)-89; // Subtract half the desired height
				//echo $startY."<br>";
				//echo $this->img_crop_width."<br>";
				//echo $this->img_crop_height."<br>";
				//exit;
				$thumb->crop(0,$startY,$this->img_crop_width,$this->img_crop_height);
				*/

				$thumbSize="100";

				$thumb->resizeAPIImage($imageWidth,$imageHeight,$thumbSize);

				$thumb->save($directory_path.$newFilename);

				//$this->uploaded_file_name[] = $newFilename;
				//unlink($this->file_tmp_name);
				return $newFilename;

			}
			else {
				$this->setErrorMsg("ERROR: The file $newFilename could not copied and resized.");
			}
		}
		else{
			$this->setErrorMsg("Error : Invalid input to file upload ");
		}

		if($this->isErrorMsg()){
			return false;
		}
		else{
			return true;
		}

	}

	function checkUploadError(){

		$error_message="";

		if(!empty($this->file_error)){

			switch ($this->file_error){

				case 1:
					$max_size_upload=ini_get('upload_max_filesize');
					$error_message="Error: File is bigger than the maximum upload limit of (".$max_size_upload.") mb. Please upload a smaller sized file or contact us for further assistance";
					break;
				case 2:
					$error_message="Error : File is bigger than this form allows.";
					break;
				case 3:
					$error_message="Error : Only part of the file was uploaded.";
					break;
				case 4:
					//$error_message="Error : No file was uploaded.";
					break;
				default:
					$error_message=$this->file_error;
			}

			if(!empty($error_message)){
				$this->setErrorMsg($error_message);
				return false;
			}
		}
		elseif(empty($this->file_name)){

			//$this->setErrorMsg("Error : No file was uploaded.");
			return false;
		}
		else{
			return true;
		}
	}

	function renameFile(){

		if(!empty($rename_filename)){
			if(isFileExists($this->uploaded_directory.$rename_filename)){
				if(rename($this->uploaded_directory.$uploaded_file_name,$this->uploaded_directory.$rename_filename)){
					return true;
				}
				else{
					$this->setErrorMsg("Error : while renaming uploaded file.");
					return false;
				}
			}
		}
		else{
			$this->setErrorMsg("Error : Invalid input to rename function.");
			return false;
		}
		// rename the file with the $rename_filename and return the file name if success otherwise error
	}

	function isFileExists($file_name){

		// check whether the file exist with the same name already in the uploaded folder.
		// call this function after making the filename ( if the prefix or suffix or unique set)

		// if exist then set error messagereturn false
		// else true

		if(file_exists($file_name)){
			$this->setErrorMsg("Error : File already exist.");
			return false;
		}
		else{
			return true;
		}
	}

	function checkFileSize(){

		//check whether the uploaded file size is not 0 and not greater than the max size.
		if(!empty($this->file_size) && !empty($this->uploaded_max_size) && $this->file_size>$this->uploaded_max_size){
			$this->setErrorMsg("Error : File is bigger than the maximim size. Maximum size allowed is ".$this->uploaded_max_size." bytes.");
			return false;
		}
		return true;
	}

	function validateFileExtension($validate_file_name){

		$i = strrpos($validate_file_name,".");

		if (!$i){
			return false;
		}

		$l = strlen($validate_file_name) - $i;
		$ext = substr($validate_file_name,$i+1,$l);
		$ext = strtolower($ext);

		//separating the file extension from the file name

		if (in_array($ext,$this->uploaded_ext_ary)){
			return true;
		}
		else{
			$this->setErrorMsg("Error : Invalid file type. Upload .".implode(" , .",$this->uploaded_ext_ary)." files only.");
			return false;
		}

	}

	function setErrorMsg($error){
		 //
		if( ($this->i!="" || $this->i==0 ) && !empty($this->multiple_upload)){

			$this->errormessage[$this->filefieldname][$this->i]=$error;
		}
		else{
			$this->errormessage[$this->filefieldname]=$error;
		}
		return true;
	}

	function isErrorMsg(){
		if(!empty($this->errormessage)){
			return true;
		}
		else{
			return false;
		}
	}

	function getErrorMsg(){
		return $this->errormessage;
		//	return current error message
	}
}
?>
