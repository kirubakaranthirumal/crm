<?php
namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ComposeMailController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function store(Request $request){

    	$inputArray = $request->all();
    	$headerArray = array();

    	//print"<pre>";
    	//print_r($inputArray);
    	//exit;
    	$sidebarMailArray = array();

		$server = '{imap.gmail.com:993/ssl}';
		$email = "kirubakaran.thirumal@gmail.com";
		$password = "kiruba*1984";
		$folder_mail_count = "0";

		$connection = imap_open($server, $email, $password);
		$mailboxes = imap_list($connection, $server, '*');

		if(!empty($mailboxes)){
			foreach($mailboxes as $mailboxval){
				$dns = $mailboxval;
				$openmail = imap_open($dns,$email,$password ) or die("Cannot Connect ".imap_last_error());
				if($openmail){
					//echo  $mailboxval."<br>";
					//echo  imap_num_msg($openmail)."<br>";
					$sidebarMailArray[][$mailboxval] = imap_num_msg($openmail);
					$mailBoxCount = imap_num_msg($openmail);
				}
				else{
					echo "Failed reading messages!!";
				}
			}
		}

		$mfolder="";
		$folderid = "";
		if(!empty($fid)){
			if($fid == "1"){
				$mfolder="{imap.gmail.com:993/ssl}INBOX";
				$folderid = "1";
			}
			elseif($fid == "2"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/All Mail";
				$folderid = "2";
			}
			elseif($fid == "3"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Drafts";
				$folderid = "3";
			}
			elseif($fid == "4"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Important";
				$folderid = "4";
			}
			elseif($fid == "5"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Sent Mail";
				$folderid = "5";
			}
			elseif($fid == "6"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Spam";
				$folderid = "6";
			}
			elseif($fid == "7"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Starred";
				$folderid = "7";
			}
			elseif($fid == "8"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Trash";
				$folderid = "8";
			}
		}
		else{
			$mfolder="{imap.gmail.com:993/ssl}INBOX";
			$folderid = "1";
		}

		//print"<pre>";
		//print_r($sidebarMailArray);
		//exit;

		$openemailcnt = imap_open($mfolder,$email,$password) or die("Cannot Connect ".imap_last_error());

		$folder_mail_count = imap_num_msg($openemailcnt);

		$headerArray = $this->readMailFolderWise($mfolder,$email,$password,$folder_mail_count);

		//$this->readMail($mfolder,$email,$password,$folder_mail_count);

    	$to="";
		if(!empty($inputArray['comTo'])){
			$to = $inputArray['comTo'];

			$name = "";
			if(!empty($inputArray['comTo'])){
				$name = $inputArray['comTo'];
			}

			$subject = "";
			if(!empty($inputArray['comSubject'])){
				$subject = $inputArray['comSubject'];
			}

			$message = "";
			if(!empty($inputArray['comTextarea'])){
				$message = addslashes($inputArray['comTextarea']);
			}

			$from = "support@cricketgateway.com";

		}

		////echo $message;
		//exit;

		include('smtpwork.php');
		//exit;

		session()->put('composeSuccess','Mail has been sent successfully');
		//return view('admin.mailbox.compose');

		return view('admin.mailbox.compose',['mfolder' => $mfolder,'folderid' => $folderid,'sidebarmail' => $sidebarMailArray,'header_array' => $headerArray]);
    }

    public function index(Request $request){

    	$inputArray = $request->all();
    	$headerArray = array();

    	//print"<pre>";
    	//print_r($inputArray);
    	//exit;

		$fid="";
    	if(!empty($inputArray['fid'])){
    		$fid=$inputArray['fid'];
    	}

    	$userId = session()->get('userId');

		$sidebarMailArray = array();

		$server = '{imap.gmail.com:993/ssl}';
		$email = "kirubakaran.thirumal@gmail.com";
		$password = "kiruba*1984";
		$folder_mail_count = "0";

		$connection = imap_open($server, $email, $password);
		$mailboxes = imap_list($connection, $server, '*');

		if(!empty($mailboxes)){
			foreach($mailboxes as $mailboxval){
				$dns = $mailboxval;
   				$openmail = imap_open($dns,$email,$password ) or die("Cannot Connect ".imap_last_error());
				if($openmail){
					//echo  $mailboxval."<br>";
					//echo  imap_num_msg($openmail)."<br>";
					$sidebarMailArray[][$mailboxval] = imap_num_msg($openmail);
					$mailBoxCount = imap_num_msg($openmail);
				}
				else{
					echo "Failed reading messages!!";
				}
			}
		}

		$mfolder="";
		$folderid = "";
		if(!empty($fid)){
			if($fid == "1"){
				$mfolder="{imap.gmail.com:993/ssl}INBOX";
				$folderid = "1";
			}
			elseif($fid == "2"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/All Mail";
				$folderid = "2";
			}
			elseif($fid == "3"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Drafts";
				$folderid = "3";
			}
			elseif($fid == "4"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Important";
				$folderid = "4";
			}
			elseif($fid == "5"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Sent Mail";
				$folderid = "5";
			}
			elseif($fid == "6"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Spam";
				$folderid = "6";
			}
			elseif($fid == "7"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Starred";
				$folderid = "7";
			}
			elseif($fid == "8"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Trash";
				$folderid = "8";
			}
		}
		else{
			$mfolder="{imap.gmail.com:993/ssl}INBOX";
			$folderid = "1";
		}

		//print"<pre>";
		//print_r($sidebarMailArray);
    	//exit;

		$openemailcnt = imap_open($mfolder,$email,$password) or die("Cannot Connect ".imap_last_error());

		$folder_mail_count = imap_num_msg($openemailcnt);

		$headerArray = $this->readMailFolderWise($mfolder,$email,$password,$folder_mail_count);

		//$this->readMail($mfolder,$email,$password,$folder_mail_count);

		return view('admin.mailbox.compose',['mfolder' => $mfolder,'folderid' => $folderid,'fid' => $fid,'sidebarmail' => $sidebarMailArray,'header_array' => $headerArray]);

		/*
		if(!empty($userId)){
			return view('admin.mailbox.compose',['mfolder' => $mfolder,'folderid' => $folderid,'fid' => $fid,'sidebarmail' => $sidebarMailArray,'header_array' => $headerArray]);
		}
		else{
			return redirect('admin/login_user');
		}
		*/
	}

	public function readMail($mfolder,$email,$password,$folder_mail_count){

		$dns = "{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";
		$email = "kirubakaran.thirumal@gmail.com";

		$openmail = imap_open($mfolder,$email,$password) or die("Cannot Connect ".imap_last_error());

		if ($openmail) {

			$messageArray = array();

			for($i=1; $i <= $folder_mail_count; $i++) {

				$header = imap_header($openmail,$i);
				echo "";
				//echo $header->Subject." (".$header->Date.")";

				 $msg = imap_fetchbody($openmail,$i,"",FT_PEEK);

				if(!empty($msg)){
					//$messageArray[] = explode(":",$msg);
					$messageArray[] = explode(":",$msg);
				}

				 //print $msg;
			}


			foreach($messageArray as $messageVal){
				foreach($messageVal as $mess){

					//print"<pre>";
					//print_r($mess);

					if(strpos($mess, 'text/plain;') !== false){
						echo 'true';
						//$messageArray[] = explode(":",$msg);
					}
				}
			}
			//exit;

			//print"<pre>";
			//print_r($messageArray);
			//exit;

			//print"<pre>";
			//print_r($openmail);
			//exit;

			/*
			$msgBody = imap_fetchbody ($openmail, $i, "2.1");
			if ($msgBody == "") {
			   $portNo = "2.1";
			   $msgBody = imap_fetchbody ($openmail, $i, $portNo);
			}

			$msgBody = trim(substr(quoted_printable_decode($msgBody), 0, 200));

			*/
			echo $msg."<br><br><br>";
			imap_close($openmail);

		}
		else{
			echo "Failed reading messages!!";
		}
	}

	public function readMailFolderWise($mfolder, $email, $password, $folder_mail_count){

		$mini_message = array();
		$header_array = array();

		$openemail = imap_open($mfolder,$email,$password) or die("Cannot Connect ".imap_last_error());

		if($openemail){
			//echo  "You have ".imap_num_msg($openemail). " messages in your inbox";

			//print"<pre>";
			//print_r($folder_mail_count);
    		//exit;

			if(!empty($folder_mail_count)){
				for($i=1; $i <= $folder_mail_count; $i++){
					$header = imap_header($openemail,$i);


					//$msg_body = imap_fetchbody($openemail,5,"",FT_PEEK);

					//$msg_body = imap_fetchbody($openemail,$i,"",FT_PEEK);

					//$header_array[] = $header->Subject." (".$header->Date.")";

					//fromaddress

    				if(!empty($header->toaddress)){
						$header_data['toaddress'] = $header->toaddress;
					}
					else{
						$header_data['toaddress'] = "";
					}

					if(!empty($header->fromaddress)){
						$header_data['fromaddress'] = $header->fromaddress;
					}
					else{
						$header_data['fromaddress'] = "";
					}

					if(!empty($header->from['0']->mailbox)){
						$header_data['from'] = $header->from['0']->mailbox;
					}
					else{
						$header_data['from'] = "-";
					}

					if(!empty($header->to['0']->mailbox)){
						$header_data['to'] = $header->to['0']->mailbox;
					}
					else{
						$header_data['to'] = "-";
					}

					if(!empty($header->Subject)){
						$header_data['Subject'] = $header->Subject;
					}
					else{
						$header_data['Subject'] = "(No Subject)";
					}

					if(!empty($header->Msgno)){
						$header_data['Msgno'] = $header->Msgno;
					}

					if(!empty($header->MailDate)){
						$header_data['MailDate'] = $header->MailDate;
					}

					if(!empty($header->Size)){
						$header_data['Size'] = $header->Size;
					}

					if(!empty($header->udate)){
						$header_data['udate'] = $header->udate;
					}

					if(!empty($header->Date)){
						$header_data['Date'] = $header->Date;
					}

					$header_data['Date'] = $header->Date;

					$header_array[] = $header_data;
				}

				/*
				print"<pre>";
				print_r($msg_body);
				print"<hr>";
				exit;
				*/
			}

			/*
			$msg = "";
			if(!empty($header_array)){
				$msg = imap_fetchbody($openemail,1,"",FT_PEEK);
			}

			if(!empty($msg)){
				$mini_message[] = $msg;
			}
			*/

			/*
			$msgBody = imap_fetchbody ($openemail, $i, "2.1");

			if($msgBody == ""){
				$portNo = "2.1";
				$msgBody = imap_fetchbody ($openemail, $i, $portNo);
			}
			$msgBody = trim(substr(quoted_printable_decode($msgBody), 0, 200));
			*/

			//echo $msg."<br><br><br>";
			imap_close($openemail);
		}
		else{
			echo "Failed reading messages!!";
    	}

		//print"<pre>";
    	//print_r($header_array);
		//print"<hr>";
    	//print_r($mini_message);
    	//exit;

    	return $header_array;
	}
}
