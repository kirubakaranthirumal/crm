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

		$userId = session()->get('userId');

		$mailBoxListArray = array();



		$server = '{imap.gmail.com:993/ssl}';

		$email = "kirubakaran.thirumal@gmail.com";
		$password = "kiruba*1984";

		$connection = imap_open($server, $email, $password);
		$mailboxes = imap_list($connection, $server, '*');

		//print"<pre>";
		//print_r($mailboxes);
		//exit;

		$this->readMail($mailboxes,$email,$password);

		if(!empty($userId)){
			if((!empty($responseArray->status)) && ($responseArray->status == "200")){
				return view('admin.mail.mailbox',['mailboxdata' => $mailBoxListArray]);
			}
			elseif((!empty($responseArray->status)) && ($responseArray->status == "201")){
				return view('admin.mail.email_notification_list',['mailboxdata' => $mailBoxListArray]);
			}
		}
		else{
			return redirect('admin/login_user');
		}
	}

	public function readMail($mailboxes, $email, $password){

		$dns = "";
		$openmail = "";
		if(!empty($mailboxes)){
			foreach($mailboxes as $mailboxval){

				print"<pre>";
				print_r($mailboxval);
				//exit;

				//$dns = "{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";
				$dns = "{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";
				$openmail = imap_open($dns,$email,$password) or die("Cannot Connect ".imap_last_error());
			}
			exit;
		}

		print"<pre>";
		print_r($openmail);
		exit;

		if ($openmail) {

			echo  "You have ".imap_num_msg($openmail). " messages in your inbox";

			for($i=1; $i <= 100; $i++) {

				$header = imap_header($openmail,$i);
				echo "
	";
				echo $header->Subject." (".$header->Date.")";
			}

			$msg = imap_fetchbody($openmail,1,"","FT_PEEK");

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
}
