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
		$email = "kirubakaran.thirumal@gmail.com";
		$password = "kiruba*1984";
		$folder_mail_count = "0";

		$connection = imap_open($server, $email, $password);
		$mailboxes = imap_list($connection, $server, '*');

		//print"<pre>";
		//print_r($sidebar_data_set);
		//exit;

		//$sidebar_data_set = session()->get("sidebarMailArray");

		//print"<pre>";
		//print_r($_SESSION);
		//exit;

		if(empty($_SESSION['sidebarMailArray'])){
			if(!empty($mailboxes)){
				foreach($mailboxes as $key=>$mailboxval){
					$dns = $mailboxval;
					$openmail = imap_open($dns,$email,$password ) or die("Cannot Connect ".imap_last_error());
					if($openmail){
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

		$mfolder="";
		if(!empty($folderid)){
			if($fid!="INBOX"){
				$mfolder="{imap.gmail.com:993/ssl}[Gmail]/".$folderid;
			}
			else{
				$mfolder="{imap.gmail.com:993/ssl}".$folderid;
			}
		}
		else{
			$mfolder="{imap.gmail.com:993/ssl}INBOX";
		}

		//$openemailcnt = imap_open($mfolder,$email,$password) or die("Cannot Connect ".imap_last_error());
		//$folder_mail_count = imap_num_msg($openemailcnt);

		$msgDetail="";
		$header="";
		$header_data = array();

		if(!empty($id)){

			//$overview = imap_fetch_overview($openmaildetail,$id,0);
			//$headers=imap_fetchheader($openmaildetail, $id);

			$openmaildetail = imap_open($mfolder,$email,$password) or die("Cannot Connect ".imap_last_error());

			$email_number = imap_msgno($openmaildetail,2);
			$overviews = imap_fetch_overview($openmaildetail,$email_number,0);

			if(!empty($overviews[0])){
				$mess = $overviews[0];
			}

			//print"<pre>";
			//print_r($mess);
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

			//print"<pre>";
			//print_r($msgHeader);
			//exit;

			//$refs = array_filter(explode(' ', htmlentities($mess->references)));




			$msgDetail = imap_fetchbody($openmaildetail,$id,2);
			$msgDetail = quoted_printable_decode($msgDetail);
		}

		//echo imap_utf7_decode($msgDetail) . ",";

		//print"<pre>";
		//print_r($overview);
		//exit;

		$sideBarData = array();
		if(isset($_SESSION['sidebarMailArray'])){
			$sideBarData = $_SESSION['sidebarMailArray'];
		}
		elseif(!empty($sidebarMailArray)){
			$sideBarData = $sidebarMailArray;
		}

		if(!empty($userId)){
			return view('admin.mailbox.readmail', ['folderid' => $folderid,'fid' => $fid,'sidebarmail' => $sideBarData,'header_array' => $headerArray,'msg_detail'=>$msgDetail,'msg_header'=>$msgHeader]);
		}
		else{
			return redirect('admin/login_user');
		}
	}
}
