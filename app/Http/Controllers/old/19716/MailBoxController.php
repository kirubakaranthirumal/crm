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

    	session_start();

    	$inputArray = $request->all();
    	$headerArray = array();

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

		//$sidebar_data_set = session()->get("sidebarMailArray");

		if(empty($_SESSION['sidebarMailArray'])){
			if(!empty($mailboxes)){
				foreach($mailboxes as $key=>$mailboxval){
					$dns = $mailboxval;
					$openmail = imap_open($dns,$email,$password) or die("Cannot Connect ".imap_last_error());
					if($openmail){
						//$sidebarMailArray[][$mailboxval] = imap_num_msg($openmail);
						$sidebarMailArray[$key]['mailboxval'] = $mailboxval;
						$sidebarMailArray[$key]['foldercount'] = imap_num_msg($openmail);
					}
					else{
						echo "Failed reading messages!!";
					}
				}
			}
		}

		if(!empty($sidebarMailArray)){
			//session()->put("sidebarMailArray",$sidebarMailArray);
			$_SESSION['sidebarMailArray'] = $sidebarMailArray;
		}

		/*
		print"<pre>";
		print_r($_SESSION);
		exit;
		*/

		//print"<pre>";
		//print_r(Session::all());
		//exit;

		$mfolder="";
		$folderid = "";
		if(!empty($fid)){
			if($fid!="INBOX"){
				$mfolder="{imap.gmail.com:993/ssl/novalidate-cert}[Gmail]/".$fid;
			}
			else{
				$mfolder="{imap.gmail.com:993/ssl/novalidate-cert}".$fid;
			}
		}
		else{
			$mfolder="{imap.gmail.com:993/ssl/novalidate-cert}INBOX";
		}

		$openemailcnt = imap_open($mfolder,$email,$password) or die("Cannot Connect ".imap_last_error());

		$folder_mail_count = imap_num_msg($openemailcnt);

		$headerArray = $this->readMailFolderWise($mfolder,$email,$password,$folder_mail_count);

		$sideBarData = array();
		if(isset($_SESSION['sidebarMailArray'])){
			$sideBarData = $_SESSION['sidebarMailArray'];
		}
		elseif(!empty($sidebarMailArray)){
			$sideBarData = $sidebarMailArray;
		}

		if(!empty($userId)){
			return view('admin.mailbox.mailbox',['mfolder' => $mfolder,'folderid' => $folderid,'fid' => $fid,'sidebarmail' => $sideBarData,'header_array' => $headerArray,'mfold'=>$mfolder]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

	public function readMail($mfolder,$email,$password,$folder_mail_count){

		$dns = "{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";
		$email = "kirubakaran.thirumal@gmail.com";

		$openmail = imap_open($mfolder,$email,$password) or die("Cannot Connect ".imap_last_error());

		if($openmail){

			$messageArray = array();

			for($i=1; $i <= $folder_mail_count; $i++){

				$header = imap_header($openmail,$i);
				echo "";
				//echo $header->Subject." (".$header->Date.")";

				$msg = imap_fetchbody($openmail,$i,"",FT_PEEK);

				if(!empty($msg)){
					//$messageArray[] = explode(":",$msg);
					$messageArray[] = explode(":",$msg);
				}
			}

			/*
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
