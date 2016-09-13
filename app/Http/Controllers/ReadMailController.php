<?php
namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ReadMailController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function show($id,Request $request){

    	session_start();

		$inputArray = $request->all();
		$headerArray = array();

		//print"<pre>";
		//print_r($inputArray);
		//exit;

		$fid="";
		if(!empty($inputArray['fid'])){
			$fid=$inputArray['fid'];
		}

		$folderid="";
		if(!empty($inputArray['folderid'])){
			$folderid=$inputArray['folderid'];
		}

		$userId = session()->get('userId');

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

		//print"<pre>";
		//print_r($sidebarMailArray);
		//exit;

		$mfolder="";
		if(!empty($folderid)){
			if($folderid!="INBOX"){
				$mfolder="{imap.gmail.com:993/ssl/novalidate-cert}[Gmail]/".$folderid;
			}
			else{
				$mfolder="{imap.gmail.com:993/ssl/novalidate-cert}".$folderid;
			}
		}
		else{
			$mfolder="{imap.gmail.com:993/ssl/novalidate-cert}INBOX";
		}

		$msgDetail="";
		$header="";
		$header_data = array();

		$mess = "";
		$head_val = "";
		if(!empty($id)){
			$openmaildetail = imap_open($mfolder,$email,$password) or die("Cannot Connect ".imap_last_error());
			$email_number = imap_msgno($openmaildetail,$id);
			$overviews = imap_fetch_overview($openmaildetail,$email_number,0);
			
			$head_val = imap_header($openmaildetail,$email_number);

			if(!empty($overviews[0])){
				$mess = $overviews[0];
			}

			//print"<pre>";
			//print_r($header);
			//exit;

			$msgHeader = '';
			if(!empty($mess)){
				//$msgHeader= '<div class="toggler '.($mess->seen ? 'read' : 'unread').'">';
				$msgHeader = '<span class="subject">'.$mess->subject.'</span> ';
				$msgHeader.= '<span class="from">From <strong>'.$mess->from.'</strong></span>';
				//$msgHeader.= '<span class="to">'.$mess->to.'</span>';
				$msgHeader.= '<span class="date">Sent On'.date("d M Y h:i",strtotime($mess->date)).'</span>';
				$msgHeader.= '</div>';
			}

			//$refs = array_filter(explode(' ', htmlentities($mess->references)));

			$msgDetail = imap_fetchbody($openmaildetail,$id,2);
			$msgDetail = quoted_printable_decode($msgDetail);
		}

		//echo imap_utf7_decode($msgDetail) . ",";

		//print"<pre>";
		//print_r($msgHeader);
		//echo "<hr>";
		//print_r($msgDetail);
		//echo "<hr>";
		//print_r($headerArray);		
		//exit;

		$sideBarData = array();
		if(isset($_SESSION['sidebarMailArray'])){
			$sideBarData = $_SESSION['sidebarMailArray'];
		}
		elseif(!empty($sidebarMailArray)){
			$sideBarData = $sidebarMailArray;
		}

		if(!empty($userId)){
			return view('admin.mailbox.readmail', ['folderid' => $folderid,'fid' => $fid,'sidebarmail' => $sideBarData,'header_array' => $headerArray,'msg_detail'=>$msgDetail,'msg_header'=>$msgHeader,'folderid' => $folderid,'head_val' => $head_val]);
		}
		else{
			return redirect('admin/login_user');
		}
	}
}
