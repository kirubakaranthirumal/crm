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

    public function index(Request $request){

    	Session::forget('composeSuccess');

		session_start();

    	$userId = session()->get('userId');

    	$inputArray = $request->all();
    	$headerArray = array();

    	$fid="";
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

		$sideBarData = array();
		if(isset($_SESSION['sidebarMailArray'])){
			$sideBarData = $_SESSION['sidebarMailArray'];
		}
		elseif(!empty($sidebarMailArray)){
			$sideBarData = $sidebarMailArray;
		}

		if(!empty($userId)){
			return view('admin.mailbox.compose',['mfolder' => $mfolder,'folderid' => $folderid,'fid' => $fid,'sidebarmail' => $sideBarData,'header_array' => $headerArray]);
		}
		else{
			return redirect('admin/login_user');
		}
	}

    public function store(Request $request){

    	$inputArray = $request->all();
    	$headerArray = array();

    	$userId = session()->get('userId');

    	$fid="";
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

		$sideBarData = array();
		if(isset($_SESSION['sidebarMailArray'])){
			$sideBarData = $_SESSION['sidebarMailArray'];
		}
		elseif(!empty($sidebarMailArray)){
			$sideBarData = $sidebarMailArray;
		}

		//send mail code starts here
		$to="";
		if(!empty($inputArray['comTo'])){
			$to = $inputArray['comTo'];
			if(!empty($to)){
				$emailArr[] = $to;
			}
			
			$name = "";
			if(!empty($inputArray['comTo'])){
				$name = $inputArray['comTo'];
			}

			$subject = "";
			if(!empty($inputArray['comSubject'])){
				$subject = $inputArray['comSubject'];
			}

			$message = "";
			if(!empty($inputArray['editor'])){
				$message = addslashes($inputArray['editor']);
			}

			$from = "cricketgatewayipl@gmail.com";
		}
		
		if(!empty($from)){
			$mailinputArray['fromAddress'] = $from;
		}

		if(!empty($message)){
			$mailinputArray['message'] = $message;
		}

		if(!empty($subject)){
			$mailinputArray['subject'] = $subject;
		}
		
		if(!empty($emailArr['0'])){	
			$mailinputArray['toAddress'] = $emailArr['0'];
		}	
		
		//print"<pre>";
		//print_r($mailinputArray);
		//exit;
		
		/*
		$envelope["from"]= "joe@example.com";
		$envelope["to"]  = "kirubakaran.srm@gmail.com";
		$envelope["cc"]  = "kirubakaran.thirumal@nutechnologyinc.com";
		
		//print"<pre>";
		//print_r($envelope);
		//exit;
		
		$part1["type"] = TYPEMULTIPART;
		$part1["subtype"] = "mixed";
		
		//$filename = "/tmp/imap.c.gz";
		//$fp = fopen($filename, "r");
		//$contents = fread($fp, filesize($filename));
		//fclose($fp);
		
		$part2["type"] = TYPEAPPLICATION;
		$part2["encoding"] = ENCBINARY;
		$part2["subtype"] = "octet-stream";
		//$part2["description"] = basename($filename);
		//$part2["contents.data"] = $contents;

		$part3["type"] = TYPETEXT;
		$part3["subtype"] = "plain";
		$part3["description"] = "description3";
		$part3["contents.data"] = "contents.data3\n\n\n\t";

		$body[1] = $part1;
		$body[2] = $part2;
		$body[3] = $part3;
		
		print"<pre>";
		print_r($envelope);
		print"<pre>";
		print_r($body);
		exit;
		
		echo nl2br(imap_mail_compose($envelope, $body));
		exit;
		*/		
		
		/*
		$to = "kirubakaran.srm@gmail.com";
		$subject = "Test Email";
		$body = "This is only a test.";
		$headers = "From: kirubakaran.srm@gmail.com\r\n".
		"Reply-To: kirubakaran.srm@gmail.com\r\n";
		$cc = null;
		$bcc = null;
		$return_path = "kirubakaran.srm@gmail.com";
		
		echo imap_mail($to, $subject, $body, $headers, $cc, $bcc, $return_path);
		exit;
		*/
		
		$sendmailresult="";
		if(!empty($mailinputArray)){
			$sendmailresult = SELF::send_email("http://106.51.0.187:8090/cgwfollowon/sendmail",$mailinputArray);
		}
		
		$responseArray = array();
		if(!empty($sendmailresult)){
			$responseArray = json_decode($sendmailresult);
		}
		
		//print"<pre>";
		//print_r($responseArray);
		//exit;
		
		//include('smtpworkgmail.php');
		
		require_once('PHPMailer-master/PHPMailerAutoload.php');
		//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

		$mail = new \PHPMailer();
		
		if(!empty($message)){
			$body = $message;
		}

		if(!empty($emailArr['0'])){	
			$mailinputArray['toAddress'] = $emailArr['0'];
		}

		$mail->IsSMTP(); // telling the class to use SMTP
		//$mail->Host       = "mail.yourdomain.com"; // SMTP server
		$mail->SMTPDebug  = 2;             // enables SMTP debug information (for testing)
										   // 1 = errors and messages
										   // 2 = messages only
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
		$mail->Username   = "cricketgatewayipl@gmail.com";  // GMAIL username
		$mail->Password   = "admin-123";            // GMAIL password
		
		if(!empty($from)){
			$mail->SetFrom($from,'');
		}
		else{
			$mail->SetFrom('cricketgatewayipl@gmail.com','');
		}
		
		if(!empty($from)){
			$mail->AddReplyTo($from,"");
		}
		else{
			$mail->AddReplyTo("cricketgatewayipl@gmail.com","");
		}
		
		if(!empty($subject)){
			$mail->Subject = $subject;
		}
		
		$mail->AltBody    = "Test"; // optional, comment out and test
		$mail->MsgHTML($body);
		$address = $to;
		$mail->AddAddress($address, "");
		
		//$mail->AddAttachment("images/phpmailer.gif");      // attachment
		//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
		
		/*
		if($mail->Send()){
			echo "Message sent to $to OK.\n";
		} 
		else{
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		*/
		//exit;
		
		/*
		//Function SendMessage($sender,$recipients,$headers,$body)
		if($mail->Send($from, array($to), $header_array, $message)){
			echo "Message sent to $to OK.\n";
			exit;
		}
		else{
			echo "Cound not send the message to $to.\nError: ".$smtp->error."\n";
			exit;
		}
		*/

		session()->put('composeSuccess','Mail has been sent successfully');
		//send mail code end here

		if(!empty($userId)){
			return view('admin.mailbox.compose',['mfolder' => $mfolder,'folderid' => $folderid,'sidebarmail' => $sideBarData,'header_array' => $headerArray]);
			//return view('admin.mailbox.compose');
		}
		else{
			return redirect('admin/login_user');
		}
    }
	
	public function send_email($url,$inputArray){

		$json_string = '';
		$fields['mailType'] = "1";
		
		if(!empty($inputArray['fromAddress'])){
			$fields['fromAddress'] = $inputArray['fromAddress'];
		}

		if(!empty($inputArray['message'])){
			$fields['message'] = $inputArray['message'];
		}

		if(!empty($inputArray['subject'])){
			$fields['subject'] = $inputArray['subject'];
		}
		else{
			$fields['subject'] = "No Subject";
		}

		if(!empty($inputArray['toAddress'])){
			$fields['toAddress'] = $inputArray['toAddress'];
		}

		if(!empty($fields)){
			$json_string = json_encode($fields);
		}

		//echo $json_string;
		//exit;

		//print"<pre>";
		//print_r($inputArray);
		//exit;

		$service_url = $url;

		$curl = curl_init($service_url);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept-Language: en_US')
		);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);

		$curl_response = curl_exec($curl);

		//echo $curl_response;
		//exit;

		curl_close($curl);

		return $curl_response;
	}
}
