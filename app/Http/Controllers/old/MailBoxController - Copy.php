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


     public function getFolders($mailbox, $serverString) {

	     $list = imap_getmailboxes($mailbox, $serverString, "*");
	     if (is_array($list)) {
	         foreach ($list as $key => $val) {
	            $mapname = str_replace($serverString, "", imap_utf7_decode($val->name));

				//print"<pre>";
	            //print_r($mapname);
	            //exit;

	            //if ($mapname[0] != ".") {
	                $list_folders[$key]['name'] = $mapname;
	                $list_folders[$key]['delimiter'] = $val->delimiter;
	                $list_folders[$key]['attributes'] = $val->attributes;
	            //}

	         }
	     }
	     else {
	         echo "imap_getmailboxes failed: " . imap_last_error() . "\n";
	     }

	     return $list_folders;
	 }

	 public function IntToBin($number) {
	     $BitWaarde = 1;
	     $IntNum = $number;
	     $BinString = "";

	     if ($IntNum > 0) {

	         // bepaal de max bitwaarde aan de hand van $IntNum
	         while ($IntNum > $BitWaarde) {
	             $BitWaarde = $BitWaarde * 2;
	         }



	         // maken van een binaire string.
	         while ($BitWaarde >= 1 ) {
	             if ($IntNum < $BitWaarde) {
	                 if ($BinString != "") $BinString .= "0";
	             } else {
	                 $BinString .= "1";
	                 $IntNum = $IntNum-$BitWaarde;
	             }
	             $BitWaarde = $BitWaarde / 2;
	         }

	     }


	     return $BinString;
	 }

	public function Attributes($BinString) {

	     $BinInt = (int)$BinString;
	     if ($BinInt >=1000){
	         $setAttribute['LATT_UNMARKED'] = true;
	         $BinInt = $BinInt-1000;
	     } else $setAttribute['LATT_UNMARKED'] = false;

	     if ($BinInt >=100){
	         $setAttribute['LATT_MARKED'] = true;
	         $BinInt = $BinInt-100;
	     } else $setAttribute['LATT_MARKED'] = false;

	     if ($BinInt >=10){
	         $setAttribute['LATT_NOSELECT'] = true;
	         $BinInt = $BinInt-10;
	     } else $setAttribute['LATT_NOSELECT'] = false;

	     if ($BinInt >=1){
	         $setAttribute['LATT_NOINFERIORS'] = true;
	         $BinInt = $BinInt-1;
	     } else $setAttribute['LATT_NOINFERIORS'] = false;

	     return $setAttribute;
	 }





    public function index(Request $request){

    	session_start();

		/*
		$test = array();

    	$mbox = imap_open("{imap.gmail.com:993/ssl}", "kirubakaran.thirumal@gmail.com", "kiruba*1984", OP_HALFOPEN);

		//$test = SELF::getFolders($mbox, "{imap.gmail.com:993/ssl}");

		$mailserver = "imap.gmail.com";
		$port = "993/ssl";

		foreach (SELF::getFolders($mbox, "{imap.gmail.com:993/ssl}") as $key => $val) {
			$Attr = SELF::Attributes(SELF::IntToBin((int)$val['attributes']));

			//print"<pre>";
			//print_r($Attr);

			//if(!$Attr['LATT_NOINFERIORS']){
			//echo "<option value='".$val['name']."'>".$val['name']."</option>";
				echo $val['name']."<br>";
			//}

			$mbox2=imap_open( "{" . $mailserver . ":" . $port . "}".$val['name'], "kirubakaran.thirumal@gmail.com", "kiruba*1984");

			if($hdr = imap_check($mbox2)){
				echo $msgCount = $hdr->Nmsgs;
			}
		}
		exit;

		print"<pre>";
		print_r($test);
		exit;
		*/

		/*
		$mbox = imap_open("{imap.gmail.com:993/ssl}", "kirubakaran.thirumal@gmail.com", "kiruba*1984", OP_HALFOPEN)
		or die("can't connect: " . imap_last_error());

		$list = imap_getmailboxes($mbox, "{imap.gmail.com:993/ssl}", "*");

		if(is_array($list)){
			foreach ($list as $key => $val){

				print"<pre>";
				print_r($val);

				//echo "($key) ";
				//echo imap_utf7_decode($val->name) . ",";
				//echo "'" . $val->delimiter . "',";
				//echo $val->attributes . "<br />\n";
			}
			exit;
		}
		else {
			echo "imap_getmailboxes failed: " . imap_last_error() . "\n";
		}
		*/

		/*
		$mailserver = "imap.gmail.com";
		$port = "993/ssl";
		$user = "kirubakaran.thirumal@gmail.com";
		$pass = "kiruba*1984";

		if($mbox=imap_open( "{" . $mailserver . ":" . $port . "}INBOX", $user, $pass )){
			//echo "Connected\n";
		}
		else{
			//exit ("Can't connect: " . imap_last_error() ."\n");  echo "FAIL!\n";
		}

		if($hdr = imap_check($mbox)){
			echo $msgCount = $hdr->Nmsgs;
		}

		$config['Server_string'] = array(
			"0" => "kirubakaran.thirumal@gmail.com",
			"1" => "kiruba*1984"
		);

		imap_close($mbox);
		exit;
		*/

    	$inputArray = $request->all();
    	$headerArray = array();

    	$fid="INBOX";
    	if(!empty($inputArray['fid'])){
    		$fid=$inputArray['fid'];
    	}

    	$userId = session()->get('userId');

		$sidebarMailArray = array();

		$server = '{imap.gmail.com:993/ssl}';
		$email = "kirubakaran.thirumal@gmail.com";
		$password = "kiruba*1984";
		$folder_mail_count = "0";

		//$sidebar_data_set = session()->get("sidebarMailArray");

		//print"<pre>";
		//print_r($mailboxes);
		//exit;

		//print"<pre>";
		//print_r($_SESSION);
		//exit;

		/*
		if(empty($_SESSION['sidebarFolderArray'])){
			$connection = imap_open($server, $email, $password);
			$mailboxes = imap_list($connection, $server, '*');
		}

		if(!empty($mailboxes)){
			$_SESSION['sidebarFolderArray'] = $mailboxes;
		}
		*/

		$mailboxes = array(
			"0" => "{imap.gmail.com:993/ssl}INBOX",
			"1" => "{imap.gmail.com:993/ssl}[Gmail]/All Mail",
			"2" => "{imap.gmail.com:993/ssl}[Gmail]/Drafts",
			"3" => "{imap.gmail.com:993/ssl}[Gmail]/Important",
			"4" => "{imap.gmail.com:993/ssl}[Gmail]/Sent Mail",
			"5" => "{imap.gmail.com:993/ssl}[Gmail]/Spam",
			"6" => "{imap.gmail.com:993/ssl}[Gmail]/Starred",
			"7" => "{imap.gmail.com:993/ssl}[Gmail]/Trash"
		);

		if(empty($_SESSION['sidebarMailArray'])){
			if(!empty($mailboxes)){
				foreach($mailboxes as $key=>$mailboxval){
					$openmail = imap_open($mailboxval,$email,$password);
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

		//$headerArray = $this->readMailFolderWise($mfolder,$email,$password,$folder_mail_count);

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

	public function readMailFolderWise($mfolder, $email, $password, $folder_mail_count){

		$header_array = array();

		$openemail = imap_open($mfolder,$email,$password) or die("Cannot Connect ".imap_last_error());

		if($openemail){
			if(!empty($folder_mail_count)){
				for($i=1; $i <= $folder_mail_count; $i++){

					$header = imap_header($openemail,$i);

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
			}

			imap_close($openemail);
		}
		else{
			echo "Failed reading messages!!";
    	}

    	return $header_array;
	}
}
