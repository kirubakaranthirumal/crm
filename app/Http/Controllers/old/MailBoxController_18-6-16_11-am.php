<?php
namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MailBoxController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

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
		if(!empty($fid)){
			if($fid == "1"){
				$mfolder="{imap.gmail.com:993/ssl}INBOX";
			}
			elseif($fid == "2"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/All Mail";
			}
			elseif($fid == "3"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Drafts";
			}
			elseif($fid == "4"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Important";
			}
			elseif($fid == "5"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Sent Mail";
			}
			elseif($fid == "6"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Spam";
			}
			elseif($fid == "7"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Starred";
			}
			elseif($fid == "8"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/Trash";
			}
		}
		else{
			$mfolder="{imap.gmail.com:993/ssl}INBOX";
		}

		$openemailcnt = imap_open($mfolder,$email,$password) or die("Cannot Connect ".imap_last_error());

		$folder_mail_count = imap_num_msg($openemailcnt);

		$headerArray = $this->readMailFolderWise($mfolder,$email,$password,$folder_mail_count);

		if(!empty($userId)){
			return view('admin.mailbox.mailbox',['fid' => $fid,'sidebarmail' => $sidebarMailArray,'header_array' => $headerArray]);
		}
		else{
			return redirect('admin/login_user');
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
					//$header_array[] = $header->Subject." (".$header->Date.")";

					//print"<pre>";
					//print_r($header);
    				//exit;

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

					if(!empty($header->Date)){
						$header_data['Date'] = $header->Date;
					}

					$header_data['Date'] = $header->Date;

					$header_array[] = $header_data;
				}
				//exit;
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
