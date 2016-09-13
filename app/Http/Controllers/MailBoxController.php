<?php
namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MailBoxController extends Controller{

	/**
	* Show a list of users
	* @return \Illuminate\View\View
	*/
    public function index(Request $request){

    	session_start();

    	$userId = session()->get('userId');

		$inputArray = $request->all();
    	$headerArray = array();

    	$fid="INBOX";
    	if(!empty($inputArray['fid'])){
    		$fid=$inputArray['fid'];
    	}

		$sidebarMailArray = array();

		$server = '{imap.gmail.com:993/ssl}';
		$email = "cricketgatewayipl@gmail.com";
		$password = "admin-123";
		$folder_mail_count = "0";

		if(empty($_SESSION['sidebarMailArray'])){
			$mbox = imap_open("{imap.gmail.com:993/ssl/novalidate-cert}","cricketgatewayipl@gmail.com","admin-123", OP_HALFOPEN)
			or die("can't connect: " . imap_last_error());

			$list = imap_getmailboxes($mbox, "{imap.gmail.com:993/ssl/novalidate-cert}", "*");

			if(is_array($list)){
				foreach ($list as $key => $val){
					//$status = imap_status($mbox, $val->name, SA_ALL);
					$status = imap_status($mbox, $val->name, SA_MESSAGES);
					if($status){
						$sidebarMailArray[$key]['mailboxval'] = $val->name;
						$sidebarMailArray[$key]['foldercount'] = $status->messages;
					}
				}
			}
		}

		if(!empty($sidebarMailArray)){
			//session()->put("sidebarMailArray",$sidebarMailArray);
			$_SESSION['sidebarMailArray'] = $sidebarMailArray;
		}

		$mfolder="";
		$folderid = "";
		if(!empty($fid)){
			if($fid!="INBOX"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/".$fid;
			}
			else{
				$mfolder="{imap.gmail.com:993/ssl}".$fid;
			}
		}
		else{
			$mfolder="{imap.gmail.com:993/ssl}INBOX";
		}

		$openemailcnt = imap_open($mfolder,$email,$password);
		$folder_mail_count = imap_num_msg($openemailcnt);

		//header code starts
		if(!empty($folder_mail_count)){
			for($i=1; $i <= $folder_mail_count; $i++){

				$header = imap_header($openemailcnt,$i);

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

				$headerArray[] = $header_data;
			}
		}
		//header code end

		//print"<pre>";
		//print_r($headerArray);
		//exit;

		$sideBarData = array();
		if(isset($_SESSION['sidebarMailArray'])){
			$sideBarData = $_SESSION['sidebarMailArray'];
		}
		elseif(!empty($sidebarMailArray)){
			$sideBarData = $sidebarMailArray;
		}

		//print"<pre>";
		//print_r($sideBarData);
		//exit;

		if(!empty($userId)){
			return view('admin.mailbox.mailbox',['mfolder' => $mfolder,'folderid' => $folderid,'fid' => $fid,'sidebarmail' => $sideBarData,'header_array' => $headerArray,'mfold'=>$mfolder]);
		}
		else{
			return redirect('admin/login_user');
		}
	}
}
