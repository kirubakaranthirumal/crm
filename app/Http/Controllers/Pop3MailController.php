<?php
namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Pop3MailController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    /*
    public function index(Request $request){

    	$inputArray = $request->all();
    	$headerArray = array();

		$server = '{imap.gmail.com:993/ssl}';
		$email = "kirubakaran.thirumal@gmail.com";
		$password = "kiruba*1984";
		$folder_mail_count = "0";

    	$mb = imap_open($server, $email, $password);

		$messageCount = imap_num_msg($mb);
		for($MID = 1;$MID <= $messageCount;$MID++){
		   $EmailHeaders = imap_headerinfo( $mb, $MID );
		   $Body = imap_fetchbody( $mb, $MID, 1 );
		   //doSomething($EmailHeaders, $Body );
		   //echo $EmailHeaders;

		   $headerArray[] = $EmailHeaders;

		   //print"<pre>";
		   //print_r($EmailHeaders);
		}


		$email = "kirubakaran.thirumal@gmail.com";
		$password = "kiruba*1984";

		// open IMAP connection
		//$mail = imap_open('{mail.server.com:143}',      'username', 'password');
		// or, open POP3 connection
		$mail = imap_open('{gmail.com:110/pop3}', $email, $password);

		// grab a list of all the mail headers
		$headers = imap_headers($mail);

		// grab a header object for the last message in the mailbox
		$last = imap_num_msg($mail);
		$header = imap_header($mail, $last);

		// grab the body for the same message
		$body = imap_body($mail, $last);

		// close the connection
		imap_close($mail);


		print"<pre>";
		print_r($header);

    }
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

		//print"<pre>";
		//print_r($mailboxes);
		//exit;

		//echo count($mailboxes);

		/*
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
		*/



		//print"<pre>";
		//print_r($mailboxes['0']);
		//exit;

		$openmail = imap_open($mailboxes['6'],$email,$password ) or die("Cannot Connect ".imap_last_error());

		echo imap_num_msg ($openmail);
		exit;

		for($i=1; $i<=9; $i++){

			$openmail = imap_open($mailboxes['0'],$email,$password ) or die("Cannot Connect ".imap_last_error());

			$header = imap_header($openmail,$i);
			echo "";
			echo $header->Subject." (".$header->Date.")"."<BR>";

			//$msg = imap_fetchbody($openmail,$i,"",FT_PEEK);

			if(!empty($msg)){
				//$messageArray[] = explode(":",$msg);
				//$messageArray[] = explode(":",$msg);
			}
		}

		//print"<pre>";
		//print_r($messageArray);
		//exit;

		if(!empty($userId)){
			//return view('admin.mailbox.mailbox',['mfolder' => $mfolder,'folderid' => $folderid,'fid' => $fid,'sidebarmail' => $sidebarMailArray,'header_array' => $headerArray]);
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
