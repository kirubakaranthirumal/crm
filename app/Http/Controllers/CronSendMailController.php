<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\User;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Department;
use App\SmtpMail;

class CronSendMailController extends Controller
{

	public function index(Request $request){

		$to = "kirubakaran.thirumal@nutechnologyinc.com";
	  	//$to = "kirubakaran.thirumal@nutechnologyinc.com";
		$from = "support@cricketgateway.com";
		$subject = "Regarding Cron Mail Send Notification";

		$message = "<html><body>";
		$message .= "<table style=\"border-color: #666;border:0px;\" cellpadding=\"10\">";
		$message .= "<tr style=\"background: #eee;\"><td><strong><center>Regarding Cron Mail Send Notification</center></strong></td></tr>";
		$message .= "<tr><td>Thanks Regards<br>Follow On</td></tr>";
		$message .= "</table>";
		$message .= "</body></html>";

		//echo $message;
		//exit;

		include('smtpwork.php');
		//exit;

	}
}