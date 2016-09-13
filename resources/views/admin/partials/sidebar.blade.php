<!-- =================================================
================= CONTROLS Content ===================
================================================== -->
<div id="controls">

				<!-- ================================================
                ================= SIDEBAR Content ===================
                ================================================= -->
                <aside id="sidebar">


                    <div id="sidebar-wrap">

                        <div class="panel-group slim-scroll" role="tablist">

		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<?php
				$username = "";
				if(!empty(session()->get('userName'))){
					$username = session()->get('userName');
				}
				if(!empty($username)){
			?>
					<div class="pull-left image">
						<img src="{{ asset("/admin-lte/dist/img/images.png") }}" class="img-circle size-50x50" alt="User Image" />
					</div>
			<?php
				}
			?>
			<!-- Status -->
			<?php
				if(!empty($username)){
			?>
					<div class="pull-left info">
						<p><?=(!empty($username)?$username:"")?></p>
						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
			<?php
				}
			?>
		</div>
		<div class="clearfix"></div>
		<div class="panel panel-default">
			<div class="panel-heading" role="tab">
				<h4 class="panel-title">
					<a data-toggle="collapse" href="#sidebarNav">
						Navigation <i class="fa fa-angle-up"></i>
					</a>
				</h4>
			</div>

		<?php

			//use Illuminate\Http\Request;
			//Request $request;
			//$inputArray = $request->all();


			//print_r($inputArray);
			//exit;


			$userId = session()->get('userId');

			$usertype = "";
			if(!empty(session()->get('userType'))){
				$usertype = session()->get('userType');
			}


			$ipArray = $cpArray = array();

			if(!empty($userId)){
				$cpArray['userSesId'] = $userId;
			}

			$eventresults="";
			if(!empty($cpArray)){
				$eventresults = ListEventPost("http://106.51.0.187:8090/cgwfollowon/activeevents",$cpArray);
			}

			$eventResponseArray=array();
			$eventArray = array();
			if(!empty($eventresults)){
				$eventResponseArray = json_decode($eventresults);
			}

			if(!empty($eventResponseArray->activeEvents)){
				foreach($eventResponseArray->activeEvents as $responseVal){
					$eventArray[] = $responseVal;
				}
			}

			//print"<pre>";
			//print_r($eventArray);
			//exit;

			function ListEventPost($url,$params){

				$json_string = '';

				if(!empty($params['userSesId'])){
					$fields['userSesId'] = $params['userSesId'];
				}

				if(!empty($fields)){
					$json_string = json_encode($fields);
				}

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

				curl_close($curl);

				return $curl_response;
			}
		?>
		<?php
			//print"<pre>";
			//print_r(Session::all());
			//exit;
		?>

		<?php
			//print"<pre>";
			//print_r(session::all());
			//exit;

			$sidebar_req_url = "";

			$sidebar_req_url = Request::url();

			$host= gethostname();
			$ip = gethostbyname($host);

			//echo $ip;
			//exit;

			$ip_length="";
			if(!empty($ip)){
				if($ip == "192.168.1.53"){
					$ip_length = "52";
					if(!empty($usertype)){
						if($usertype == "1"){
							$ip_length2="52";
						}
						else{
							$ip_length2="46";
						}
					}
				}
				else{
					$ip_length = "74";
					if(!empty($usertype)){
						if($usertype == "1"){
							$ip_length2="74";
						}
						else{
							$ip_length2="58";
						}
					}
				}
			}

			//echo "usertype-".$usertype."<br>";
			//echo "ip_length-".$ip_length."<br>";
			//echo "ip_length2-".$ip_length2."<br>";

			//public ip 192.168.1.15

			$sub_sidebar_req_url=$sub_sidebar_req_url1="";
			if(!empty($usertype)){
				if($usertype == "1"){
					if(!empty($sidebar_req_url)){
						$sub_sidebar_req_url = substr($sidebar_req_url,$ip_length);
						$sub_sidebar_req_url1 = substr($sidebar_req_url,$ip_length);
					}

					//echo $sub_sidebar_req_url;
					//echo $sub_sidebar_req_url1;

					$find_char = '/';
					if(!empty($sub_sidebar_req_url1)){
						$pos = strpos($sub_sidebar_req_url1,$find_char);
					}

					if(!empty($pos)){
						$sub_sidebar_req_url_array = array();
						$sub_sidebar_req_url_array = explode("/",$sub_sidebar_req_url1);
						if(!empty($sub_sidebar_req_url_array['0'])){
							$sub_sidebar_req_url = $sub_sidebar_req_url_array['0'];
						}
					}
				}
				else{
					if(!empty($sidebar_req_url)){
						$sub_sidebar_req_url = substr($sidebar_req_url,$ip_length2);
						$sub_sidebar_req_url1 = substr($sidebar_req_url,$ip_length);

						//echo $sub_sidebar_req_url."<br>";
						//echo $sub_sidebar_req_url1."<br>";
					}

					$find_char = '/';
					if(!empty($sub_sidebar_req_url1)){
						$pos = strpos($sub_sidebar_req_url1,$find_char);
					}

					if(!empty($pos)){
						$sub_sidebar_req_url_array = array();
						$sub_sidebar_req_url_array = explode("/",$sub_sidebar_req_url);

						//print"<pre>";
						//print_r($sub_sidebar_req_url_array);
						//exit;

						if(!empty($sub_sidebar_req_url_array['0'])){
							$sub_sidebar_req_url = $sub_sidebar_req_url_array['0'];
						}
					}

					//echo $sub_sidebar_req_url;
				}
			}

			//echo "sub_sidebar_req_url-".$sub_sidebar_req_url."<br>";
			//echo "sub_sidebar_req_url1-".$sub_sidebar_req_url1."<br>";

			//dashboard
			$dashboard_class = "class=\"treeview\"";
			$dashboard_css = "style=\"display:none;\"";
			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "dashboard"){
					$dashboard_class = "class=\"active open\"";
					$dashboard_css = "style=\"display:block;\"";
				}
				elseif($sub_sidebar_req_url == "emp-dashboard"){
					$dashboard_class = "class=\"active open\"";
					$dashboard_css = "style=\"display:block;\"";
				}
			}

			//admin user
			$admin_user_class = "class=\"treeview\"";
			$admin_user_css = "style=\"display:none;\"";

			$add_admin_style = "";
			$view_admin_style = "";
			$admin_login_style = "";

			//echo $sub_sidebar_req_url;
			//exit;

			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "add_user"){
					$admin_user_class = "class=\"active open\"";
					$admin_user_css = "style=\"display:block;\"";
					$add_admin_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "view_user"){
					$admin_user_class = "class=\"active open\"";
					$admin_user_css = "style=\"display:block;\"";
					$view_admin_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "edit_user"){
					$admin_user_class = "class=\"active open\"";
					$admin_user_css = "style=\"display:block;\"";
					$add_admin_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "user_details"){
					$admin_user_class = "class=\"active open\"";
					$admin_user_css = "style=\"display:block;\"";
					$view_admin_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "user_log_status"){
					$admin_user_class = "class=\"active open\"";
					$admin_user_css = "style=\"display:block;\"";
					$admin_login_style = "style=\"color:#22beef;\"";
				}
			}

			if(!empty($sub_sidebar_req_url1)){
				if($sub_sidebar_req_url1 == "add_user"){
					$admin_user_class = "class=\"active open\"";
					$admin_user_css = "style=\"display:block;\"";
					$add_admin_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "puser"){
					$admin_user_class = "class=\"active open\"";
					$admin_user_css = "style=\"display:block;\"";
					$view_admin_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "puser"){
					$admin_user_class = "class=\"active open\"";
					$admin_user_css = "style=\"display:block;\"";
					$view_admin_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "privilege_user_details"){
					$admin_user_class = "class=\"active open\"";
					$admin_user_css = "style=\"display:block;\"";
					$view_admin_style = "style=\"color:#22beef;\"";
				}

				//sub_sidebar_req_url
				//privilege_user_details
			}

			$my_ticket_class = "";
			$my_ticket_css = "style=\"display:hidden;\"";
			$my_ticket_style = "";

			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "my_tickets"){
					$my_ticket_class = "class=\"active open\"";
					$my_ticket_css = "style=\"display:block;\"";
					$my_ticket_style = "style=\"color:#22beef;\"";
				}
			}

			//echo $sub_sidebar_req_url;
			//exit;

			//ticket
			$ticket_class = "class=\"treeview\"";
			$ticket_css = "style=\"display:none;\"";

			$email_notify_class = "class=\"treeview\"";
			$email_notify_css = "style=\"display:none;\"";

			$social_ticket_class = "class=\"treeview\"";
			$social_ticket_css = "style=\"display:none;\"";

			$add_ticket_style = "";
			$view_ticket_style = "";
			$email_ticket_style = "";
			$twitter_ticket_style = "";
			$facebook_ticket_style = "";

			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "add_tickets"){
					$ticket_class = "class=\"active open\"";
					$ticket_css = "style=\"display:block;\"";
					$add_ticket_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "view_tickets"){
					$ticket_class = "class=\"active open\"";
					$ticket_css = "style=\"display:block;\"";
					$view_ticket_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "edit_ticket"){
					$ticket_class = "class=\"active open\"";
					$ticket_css = "style=\"display:block;\"";
					$add_ticket_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "ticket_details"){
					$ticket_class = "class=\"active open\"";
					$ticket_css = "style=\"display:block;\"";
					$view_ticket_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "emailnotification"){
					$ticket_class = "class=\"active open\"";
					$ticket_css = "style=\"display:block;\"";

					$email_notify_class = "class=\"treeview open\"";
					$email_notify_css = "style=\"display:block;\"";

					$email_ticket_style = "style=\"color:#22beef;\"";

				}
				elseif($sub_sidebar_req_url == "tweet"){
					$ticket_class = "class=\"active open\"";
					$ticket_css = "style=\"display:block;\"";

					$social_ticket_class = "class=\"treeview open\"";
					$social_ticket_css = "style=\"display:block;\"";

					$twitter_ticket_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "fbpage"){
					$ticket_class = "class=\"active open\"";
					$ticket_css = "style=\"display:block;\"";

					$social_ticket_class = "class=\"treeview open\"";
					$social_ticket_css = "style=\"display:block;\"";

					$facebook_ticket_style = "style=\"color:#22beef;\"";
				}
			}


			if(!empty($sub_sidebar_req_url1)){
				if($sub_sidebar_req_url1 == "padd_tickets"){
					$ticket_class = "class=\"active open\"";
					$ticket_css = "style=\"display:block;\"";
					$add_ticket_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "pticket"){
					$ticket_class = "class=\"active open\"";
					$ticket_css = "style=\"display:block;\"";
					$view_ticket_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "emailnotification"){
					$ticket_class = "class=\"active open\"";
					$ticket_css = "style=\"display:block;\"";

					$email_notify_class = "class=\"treeview open\"";
					$email_notify_css = "style=\"display:block;\"";

					$email_ticket_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "tweet"){
					$ticket_class = "class=\"active open\"";
					$ticket_css = "style=\"display:block;\"";

					$social_ticket_class = "class=\"active open\"";
					$social_ticket_css = "style=\"display:block;\"";

					$twitter_ticket_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "fbpage"){
					$ticket_class = "class=\"active open\"";
					$ticket_css = "style=\"display:block;\"";

					$social_ticket_class = "class=\"active open\"";
					$social_ticket_css = "style=\"display:block;\"";

					$facebook_ticket_style = "style=\"color:#22beef;\"";
				}
			}

			//echo $social_ticket_class;
			//exit;

			//privilege
			$privilege_class = "class=\"treeview\"";
			$privilege_css = "style=\"display:none;\"";

			$privilege_style = "";
			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "user_privileges"){
					$privilege_class = "class=\"active open\"";
					$privilege_css = "style=\"display:block;\"";

					$privilege_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "assign_privilege"){
					$privilege_class = "class=\"active open\"";
					$privilege_css = "style=\"display:block;\"";

					$privilege_style = "style=\"color:#22beef;\"";
				}
			}

			//app event service
			$aes_class = "class=\"treeview\"";
			$aes_css = "style=\"display:none;\"";

			$app_class = "class=\"treeview\"";
			$app_css = "style=\"display:none;\"";

			$event_class = "class=\"treeview\"";
			$event_css = "style=\"display:none;\"";

			$ser_class = "class=\"treeview\"";
			$ser_css = "style=\"display:none;\"";

			$create_app_style = "";
			$list_app_style = "";

			$create_event_style = "";
			$list_event_style = "";

			$create_service_style = "";
			$list_service_style = "";

			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "create_app"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$app_class = "class=\"active open\"";
					$app_css = "style=\"display:block;\"";

					$create_app_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "list_app"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$app_class = "class=\"active open\"";
					$app_css = "style=\"display:block;\"";

					$list_app_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "edit_app"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$app_class = "class=\"active open\"";
					$app_css = "style=\"display:block;\"";

					$list_app_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "create_event"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$event_class = "class=\"active open\"";
					$event_css = "style=\"display:block;\"";

					$create_event_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "event_all_list"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$event_class = "class=\"active open\"";
					$event_css = "style=\"display:block;\"";

					$list_event_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "event_edit"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$event_class = "class=\"active open\"";
					$event_css = "style=\"display:block;\"";

					$list_event_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "create_service"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$ser_class = "class=\"active open\"";
					$ser_css = "style=\"display:block;\"";

					$create_service_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "service_all_list"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$ser_class = "class=\"active open\"";
					$ser_css = "style=\"display:block;\"";

					$list_service_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "event_list"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$event_class = "class=\"active open\"";
					$event_css = "style=\"display:block;\"";

					$list_event_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "service_list"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$ser_class = "class=\"active open\"";
					$ser_css = "style=\"display:block;\"";

					$list_service_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "service_edit"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$ser_class = "class=\"active open\"";
					$ser_css = "style=\"display:block;\"";

					$list_service_style = "style=\"color:#22beef;\"";
				}

			}

			if(!empty($sub_sidebar_req_url1)){
				if($sub_sidebar_req_url1 == "create_app"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$app_class = "class=\"active open\"";
					$app_css = "style=\"display:block;\"";

					$create_app_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "list_app"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$app_class = "class=\"active open\"";
					$app_css = "style=\"display:block;\"";

					$list_app_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "create_event"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$event_class = "class=\"active open\"";
					$event_css = "style=\"display:block;\"";

					$create_event_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "event_all_list"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$event_class = "class=\"active open\"";
					$event_css = "style=\"display:block;\"";

					$list_event_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "create_service"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$ser_class = "class=\"active open\"";
					$ser_css = "style=\"display:block;\"";

					$create_service_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "service_all_list"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$ser_class = "class=\"active open\"";
					$ser_css = "style=\"display:block;\"";

					$list_service_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "event_list"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$ser_class = "class=\"active open\"";
					$ser_css = "style=\"display:block;\"";

					$list_service_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "service_list"){
					$aes_class = "class=\"active open\"";
					$aes_css = "style=\"display:block;\"";

					$ser_class = "class=\"active open\"";
					$ser_css = "style=\"display:block;\"";

					$list_service_style = "style=\"color:#22beef;\"";
				}
			}

			//echo $sub_sidebar_req_url1;
			//exit;

			//cms
			$cms_class = "class=\"treeview\"";
			$cms_css = "style=\"display:none;\"";

			$cms_style = "";
			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "contentmanage"){
					$cms_class = "class=\"active open\"";
					$cms_css = "style=\"display:block;\"";

					$cms_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "edit_menu"){
					$cms_class = "class=\"active open\"";
					$cms_css = "style=\"display:block;\"";

					$cms_style = "style=\"color:#22beef;\"";
				}
			}

			//mailbox
			$mailbox_class = "class=\"treeview\"";
			$mailbox_css = "style=\"display:none;\"";

			$mailbox_read_style="";
			$mailbox_compose_style="";
			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "composemail"){
					$mailbox_class = "class=\"active open\"";
					$mailbox_css = "style=\"display:block;\"";

					$mailbox_compose_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "mailbox"){
					$mailbox_class = "class=\"active open\"";
					$mailbox_css = "style=\"display:block;\"";

					$mailbox_read_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "readmail"){
					$mailbox_class = "class=\"active open\"";
					$mailbox_css = "style=\"display:block;\"";

					$mailbox_read_style = "style=\"color:#22beef;\"";
				}
			}

			//chat
			$chat_class = "class=\"treeview\"";
			$chat_css = "style=\"display:none;\"";

			$customer_chat_style = "";

			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "customerchathistory"){
					$chat_class = "class=\"active open\"";
					$chat_css = "style=\"display:block;\"";

					$customer_chat_style = "style=\"color:#22beef;\"";
				}
			}

			if(!empty($sub_sidebar_req_url1)){
				if($sub_sidebar_req_url1 == "customerchathistory"){
					$chat_class = "class=\"active open\"";
					$chat_css = "style=\"display:block;\"";

					$customer_chat_style = "style=\"color:#22beef;\"";
				}
			}

			//echo $sub_sidebar_req_url1;
			//exit;

			$mail_to_employees_class = "class=\"treeview\"";
			$mail_to_employees_css = "style=\"display:none;\"";

			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "empsendmail"){
					$mail_to_employees_class = "class=\"active open\"";
					$mail_to_employees_css = "style=\"display:block;\"";
				}
			}
			if(!empty($sub_sidebar_req_url1)){
				if($sub_sidebar_req_url1 == "empsendmail"){
					$mail_to_employees_class = "class=\"active open\"";
					$mail_to_employees_css = "style=\"display:block;\"";
				}
			}


			$report_class = "class=\"treeview\"";
			$report_css = "style=\"display:none;\"";

			$report_style = "";
			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "ticket_report"){
					$report_class = "class=\"active open\"";
					$report_css = "style=\"display:block;\"";

					$report_style = "style=\"color:#22beef;\"";
				}
			}

			if(!empty($sub_sidebar_req_url1)){
				if($sub_sidebar_req_url1 == "ticket_report"){
					$report_class = "class=\"active open\"";
					$report_css = "style=\"display:block;\"";

					$report_style = "style=\"color:#22beef;\"";
				}
			}

			//customer
			$customer_class = "class=\"treeview\"";
			$customer_css = "style=\"display:none;\"";

			$customer_info_style = "";
			$customer_log_style = "";
			$customer_feed_style = "";

			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "customer_info"){
					$customer_class = "class=\"active open\"";
					$customer_css = "style=\"display:block;\"";

					$customer_info_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "customer_log_status"){
					$customer_class = "class=\"active open\"";
					$customer_css = "style=\"display:block;\"";

					$customer_log_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "feedback_list"){
					$customer_class = "class=\"active open\"";
					$customer_css = "style=\"display:block;\"";

					$customer_feed_style = "style=\"color:#22beef;\"";
				}
			}

			if(!empty($sub_sidebar_req_url1)){
				if($sub_sidebar_req_url1 == "customer_info"){
					$customer_class = "class=\"active open\"";
					$customer_css = "style=\"display:block;\"";

					$customer_info_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "customer_log_status"){
					$customer_class = "class=\"active open\"";
					$customer_css = "style=\"display:block;\"";

					$customer_log_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "feedback_list"){
					$customer_class = "class=\"active open\"";
					$customer_css = "style=\"display:block;\"";

					$customer_feed_style = "style=\"color:#22beef;\"";
				}
			}

			//ticket settings
			$ticket_settings_class = "class=\"treeview\"";
			$ticket_settings_css = "style=\"display:none;\"";

			$temp_class = "class=\"treeview\"";
			$temp_css = "style=\"display:none;\"";

			$ticket_settings_style = "";
			$mail_settings_style = "";
			$social_settings_style = "";

			$create_template_style = "";
			$template_list_style = "";
			$send_mail_style = "";

			if(!empty($sub_sidebar_req_url)){
				if($sub_sidebar_req_url == "settings"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$ticket_settings_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "edit_dept"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$ticket_settings_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "edit_cat"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$ticket_settings_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "edit_prior"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$ticket_settings_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "edit_source"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$ticket_settings_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "edit_type"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$ticket_settings_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "edit_status"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$ticket_settings_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "mailaccsettings"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$mail_settings_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "smsettings"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$social_settings_style = "style=\"color:#22beef;\"";
				}

				elseif($sub_sidebar_req_url == "create_template"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$temp_class = "class=\"active open\"";
					$temp_css = "style=\"display:block;\"";

					$create_template_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "list_template"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$temp_class = "class=\"active open\"";
					$temp_css = "style=\"display:block;\"";

					$template_list_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "edit_template"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$temp_class = "class=\"active open\"";
					$temp_css = "style=\"display:block;\"";

					$template_list_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url == "sendmail"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$temp_class = "class=\"active open\"";
					$temp_css = "style=\"display:block;\"";

					$send_mail_style = "style=\"color:#22beef;\"";
				}
			}

			if(!empty($sub_sidebar_req_url1)){
				if($sub_sidebar_req_url1 == "settings"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$ticket_settings_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "mailaccsettings"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$mail_settings_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "smsettings"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$social_settings_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "edit_sms"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$social_settings_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "create_template"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$temp_class = "class=\"active open\"";
					$temp_css = "style=\"display:block;\"";

					$create_template_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "list_template"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$temp_class = "class=\"active open\"";
					$temp_css = "style=\"display:block;\"";

					$template_list_style = "style=\"color:#22beef;\"";
				}
				elseif($sub_sidebar_req_url1 == "sendmail"){
					$ticket_settings_class = "class=\"active open\"";
					$ticket_settings_css = "style=\"display:block;\"";

					$temp_class = "class=\"active open\"";
					$temp_css = "style=\"display:block;\"";

					$send_mail_style = "style=\"color:#22beef;\"";
				}
			}

			//echo $sub_sidebar_req_url1;
			//exit;
		?>
		<div id="sidebarNav" class="panel-collapse collapse in" role="tabpanel">
			<div class="panel-body">
		@if(isset($usertype))
			@if($usertype == 1)
			<!-- ===================================================
					================= NAVIGATION Content ===================
					==================================================== -->
					<ul class="sidebar-menu" id="navigation">
					<li <?=(!empty($dashboard_class)?$dashboard_class:"")?>>
						<a href="{{ url(config('quickadmin.route').'/dashboard') }}">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<li <?=(!empty($admin_user_class)?$admin_user_class:"")?>>
						<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Ticket Admin Management</span> </a>
						<ul class="treeview-menu" <?=(!empty($admin_user_css)?$admin_user_css:"")?>>
							<li><a href="{{ url(config('quickadmin.route').'/add_user') }}" <?=(!empty($add_admin_style)?$add_admin_style:"")?>><i class="fa fa-user-plus" aria-hidden="true"></i> <span>Add User</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/view_user') }}" <?=(!empty($view_admin_style)?$view_admin_style:"")?>><i class="fa fa-list" aria-hidden="true"></i> <span>View Users</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/user_log_status') }}" <?=(!empty($admin_login_style)?$admin_login_style:"")?>><i class="fa fa-genderless"></i> <span>Ticket Admin Status</span></a></li>
						</ul>
					</li>
					<li <?=(!empty($ticket_class)?$ticket_class:"")?>>
						<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets Management</span> </a>
						<ul class="treeview-menu" <?=(!empty($ticket_css)?$ticket_css:"")?>>
							<li><a href="{{ url(config('quickadmin.route').'/add_tickets') }}" <?=(!empty($add_ticket_style)?$add_ticket_style:"")?>><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Add Ticket</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/view_tickets') }}" <?=(!empty($view_ticket_style)?$view_ticket_style:"")?>><i class="fa fa-list" aria-hidden="true"></i> <span>View Tickets</span></a></li>
							<li <?=(!empty($email_notify_class)?$email_notify_class:"")?>>
								<a href="#"><i class="fa fa-tags" aria-hidden="true"></i><span>Email Notifications</span> </a>
								<ul class="treeview-menu" <?=(!empty($email_notify_css)?$email_notify_css:"")?>>
									<li><a href="{{ url(config('quickadmin.route').'/emailnotification') }}" <?=(!empty($email_ticket_style)?$email_ticket_style:"")?>><i class="fa fa-envelope" aria-hidden="true"></i> <span>E-Mail Tickets</span></a></li>
								</ul>
							</li>
							<li class="treeview">
							<li <?=(!empty($social_ticket_class)?$social_ticket_class:"")?>>
								<a href="#"><i class="fa fa-wifi" aria-hidden="true"></i><span>Social Media</span> </a>
								<ul class="treeview-menu" <?=(!empty($social_ticket_css)?$social_ticket_css:"")?>>
									<li><a href="{{ url(config('quickadmin.route').'/tweet') }}" <?=(!empty($twitter_ticket_style)?$twitter_ticket_style:"")?>><i class="fa fa-twitter" aria-hidden="true"></i> <span>Twitter</span></a></li>
									<li><a href="{{ url(config('quickadmin.route').'/fbpage') }}" <?=(!empty($facebook_ticket_style)?$facebook_ticket_style:"")?>><i class="fa fa-facebook" aria-hidden="true"></i> <span>Facebook</span></a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li <?=(!empty($privilege_class)?$privilege_class:"")?>>
						<a href="#"><i class="fa fa-lock" aria-hidden="true"></i><span>Access Management</span> </a>
						<ul class="treeview-menu" <?=(!empty($privilege_css)?$privilege_css:"")?>>
							<li><a href="{{ url(config('quickadmin.route').'/user_privileges') }}" <?=(!empty($privilege_style)?$privilege_style:"")?>><i class="fa fa-lock" aria-hidden="true"></i> <span>Manage Privileges</span></a></li>
						</ul>
					</li>
					<li <?=(!empty($aes_class)?$aes_class:"")?>>
						<a href="#"><i class="fa fa-book" aria-hidden="true"></i><span>App Event Service</span> </a>
						<ul class="treeview-menu" <?=(!empty($aes_css)?$aes_css:"")?>>
							<li <?=(!empty($app_class)?$app_class:"")?>>
								<a href="#"><i class="fa fa-paint-brush" aria-hidden="true"></i><span>Application</span> </a>
								<ul class="treeview-menu" <?=(!empty($app_css)?$app_css:"")?>>
									<li><a href="{{ url(config('quickadmin.route').'/create_app') }}" <?=(!empty($create_app_style)?$create_app_style:"")?>><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create App</span></a></li>
									<li><a href="{{ url(config('quickadmin.route').'/list_app') }}" <?=(!empty($list_app_style)?$list_app_style:"")?>><i class="fa fa-list" aria-hidden="true"></i> <span>App List</span></a></li>
								</ul>
							</li>
							<li <?=(!empty($event_class)?$event_class:"")?>>
								<a href="#"><i class="fa fa-pencil" aria-hidden="true"></i><span>Event</span> </a>
								<ul class="treeview-menu" <?=(!empty($event_css)?$event_css:"")?>>
									<li><a href="{{ url(config('quickadmin.route').'/create_event') }}" <?=(!empty($create_event_style)?$create_event_style:"")?>><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create Event</span></a></li>
									<li><a href="{{ url(config('quickadmin.route').'/event_all_list') }}" <?=(!empty($list_event_style)?$list_event_style:"")?>><i class="fa fa-list" aria-hidden="true"></i> <span>All Events List</span></a></li>
								</ul>
							</li>
							<li <?=(!empty($ser_class)?$ser_class:"")?>>
								<a href="#"><i class="fa fa-bolt" aria-hidden="true"></i><span>Service</span> </a>
								<ul class="treeview-menu" <?=(!empty($ser_css)?$ser_css:"")?>>
									<li><a href="{{ url(config('quickadmin.route').'/create_service') }}" <?=(!empty($create_service_style)?$create_service_style:"")?>><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create Service</span></a></li>
									<li><a href="{{ url(config('quickadmin.route').'/service_all_list') }}" <?=(!empty($list_service_style)?$list_service_style:"")?>><i class="fa fa-list" aria-hidden="true"></i> <span>All Services List</span></a></li>
								</ul>
							</li>
						</ul>
					</li>

					<li <?=(!empty($ticket_settings_class)?$ticket_settings_class:"")?>>
						<a href="#"><i class="fa fa-wrench" aria-hidden="true"></i><span>Settings</span> </a>
						<ul class="treeview-menu" <?=(!empty($ticket_settings_css)?$ticket_settings_css:"")?>>
							<li><a href="{{ url(config('quickadmin.route').'/settings') }}" <?=(!empty($ticket_settings_style)?$ticket_settings_style:"")?>><i class="fa fa-ticket" aria-hidden="true"></i><span>Ticket Settings</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/mailaccsettings')}}" <?=(!empty($mail_settings_style)?$mail_settings_style:"")?>><i class="fa fa-envelope" aria-hidden="true"></i><span>Mail Account Settings</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/smsettings') }}" <?=(!empty($social_settings_style)?$social_settings_style:"")?>><i class="fa fa-wifi" aria-hidden="true"></i><span>Social Media Settings</span></a></li>
							<li <?=(!empty($temp_class)?$temp_class:"")?>>
								<a href="#"><i class="fa fa-envelope" aria-hidden="true"></i><span>E-Mail Template</span> </a>
								<ul class="treeview-menu" <?=(!empty($temp_css)?$temp_css:"")?>>
									<li><a href="{{ url(config('quickadmin.route').'/create_template') }}" <?=(!empty($create_template_style)?$create_template_style:"")?>><i class="fa fa-envelope" aria-hidden="true"></i> <span>Create Template</span></a></li>
									<li><a href="{{ url(config('quickadmin.route').'/list_template') }}" <?=(!empty($template_list_style)?$template_list_style:"")?>><i class="fa fa-envelope" aria-hidden="true"></i> <span>Template List</span></a></li>
									<li><a href="{{ url(config('quickadmin.route').'/sendmail') }}" <?=(!empty($send_mail_style)?$send_mail_style:"")?>><i class="fa fa-envelope" aria-hidden="true"></i> <span>Send E-Mail</span></a></li>
								</ul>
							</li>
						</ul>
					</li>
				<li <?=(!empty($cms_class)?$cms_class:"")?>>
				   <a href="#"><i class="fa fa-edit" aria-hidden="true"></i><span>CMS</span> </a>
				   <ul class="treeview-menu" <?=(!empty($cms_css)?$cms_css:"")?>>
					  <li><a href="{{ url(config('quickadmin.route').'/contentmanage') }}" <?=(!empty($cms_style)?$cms_style:"")?>><i class="fa fa-edit" aria-hidden="true"></i><span>CMS List</span></a></li>
				   </ul>
				</li>
				<li <?=(!empty($mailbox_class)?$mailbox_class:"")?>>
					<a href="#"><i class="fa fa-envelope" aria-hidden="true"></i><span>Mail Box</span> </a>
					<ul class="treeview-menu" <?=(!empty($mailbox_css)?$mailbox_css:"")?>>
						<li><a href="{{ url(config('quickadmin.route').'/composemail') }}" <?=(!empty($mailbox_compose_style)?$mailbox_compose_style:"")?>><i class="fa fa-envelope"></i> <span>Compose</span></a></li>
						<li><a href="{{ url(config('quickadmin.route').'/mailbox') }}" <?=(!empty($mailbox_read_style)?$mailbox_read_style:"")?>><i class="fa fa-envelope"></i> <span>Read</span></a></li>
					</ul>
				</li>
				<li <?=(!empty($mail_to_employees_class)?$mail_to_employees_class:"")?>>
					<a href="{{ url(config('quickadmin.route').'/empsendmail') }}"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Mail To Internal Users</span></a>
				</li>
				<li <?=(!empty($chat_class)?$chat_class:"")?>>
					<a href="#"><i class="fa fa-wechat" aria-hidden="true"></i><span>Chat</span> </a>
					<ul class="treeview-menu" <?=(!empty($chat_css)?$chat_css:"")?>>
						<li><a href="{{ url(config('quickadmin.route').'/customerchathistory') }}" <?=(!empty($customer_chat_style)?$customer_chat_style:"")?>><i class="fa fa-fw fa-wechat" aria-hidden="true"></i> <span>Chat Notifications</span></a></li>					</ul>
				</li>
				<li <?=(!empty($customer_class)?$customer_class:"")?>>
					<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Customer Management</span> </a>
					<ul class="treeview-menu" <?=(!empty($customer_css)?$customer_css:"")?>>
						<li><a href="{{ url(config('quickadmin.route').'/customer_info')}}" <?=(!empty($customer_info_style)?$customer_info_style:"")?>><i class="fa fa-user-secret"></i> <span>Customer Details</span></a></li>
						<li><a href="{{ url(config('quickadmin.route').'/customer_log_status')}}" <?=(!empty($customer_log_style)?$customer_log_style:"")?>><i class="fa fa-users" aria-hidden="true"></i> <span>Customer Status</span></a></li>
						<li><a href="{{ url(config('quickadmin.route').'/feedback_list')}}" <?=(!empty($customer_feed_style)?$customer_feed_style:"")?>><i class="fa fa-cloud-upload" aria-hidden="true"></i> <span>Customer Feedback</span></a></li>
					</ul>
				</li>
				<li <?=(!empty($report_class)?$report_class:"")?>>
					<a href="{{ url(config('quickadmin.route').'/ticket_report') }}"><i class="fa fa-book"></i> <span>Reports</span></a>
				</li>
			</ul>
			@elseif($usertype == 2)
				<ul class="sidebar-menu" id="navigation" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li <?=(!empty($dashboard_class)?$dashboard_class:"")?>>
						<a href="{{ url('emp-dashboard') }}">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<?php
						//print"<pre>";
						//print_r(Session::all());
						//exit;

						//echo $dashboard_class;
						//echo $sub_sidebar_req_url;

						$user_list_show = $ticket_list_show = $app_list_show = $event_list_show = $service_list_show = "";
						$user_add_show = $ticket_add_show = $app_add_show = $event_add_show = $service_add_show = "";

						$user_list_show = session()->get('userView');
						$ticket_list_show = session()->get('ticketView');
						$app_list_show = session()->get('appView');
						$event_list_show = session()->get('eventView');
						$service_list_show = session()->get('serviceView');

						$user_add_show = session()->get('userCreate');
						$ticket_add_show = session()->get('ticketCreate');
						$app_add_show = session()->get('appCreate');
						$event_add_show = session()->get('eventCreate');
						$service_add_show = session()->get('serviceCreate');

						//echo $ticket_list_show;

						//print"<pre>";
						//print_r(Session::all());
						//print"<hr>";
						//print_r($_SESSION);
						//exit;

						//echo $my_ticket_class;

						//if(!empty($user_list_show)){
					?>
						<li <?=(!empty($admin_user_class)?$admin_user_class:"")?>>
							<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Ticket Admin Management</span> </a>
							<ul class="treeview-menu" <?=(!empty($admin_user_css)?$admin_user_css:"")?>>
								<?php
									if(!empty($user_add_show)){
								?>
									<li><a href="{{ url(config('quickadmin.route').'/add_user') }}" <?=(!empty($add_admin_style)?$add_admin_style:"")?>><i class="fa fa-user-plus" aria-hidden="true"></i> <span>Add User</span></a></li>
								<?php
									}
								?>

								<?php
									if(!empty($user_list_show)){
								?>
										<li><a href="{{ url(config('quickadmin.route').'/puser') }}" <?=(!empty($view_admin_style)?$view_admin_style:"")?>><i class="fa fa-list" aria-hidden="true"></i> <span>View User</span></a></li>
								<?php
									}
								?>
							</ul>
						</li>
					<?php
						//}
					?>
					<li <?=(!empty($my_ticket_class)?$my_ticket_class:"")?>>
						<a href="{{ url('my_tickets?tab_id=3') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>My Tickets</span></a>
					</li>
					<?php
						//if(!empty($ticket_list_show)){
					?>
						<li <?=(!empty($ticket_class)?$ticket_class:"")?>>
							<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets Management</span> </a>
							<ul class="treeview-menu" <?=(!empty($ticket_css)?$ticket_css:"")?>>
								<?php
									if(!empty($ticket_add_show)){
								?>
									<li><a href="{{ url(config('quickadmin.route').'/padd_tickets') }}" <?=(!empty($add_ticket_style)?$add_ticket_style:"")?>><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Add Ticket</span></a></li>
								<?php
									}
								?>
								<?php
									if(!empty($ticket_list_show)){
								?>
										<li><a href="{{ url(config('quickadmin.route').'/pticket') }}" <?=(!empty($view_ticket_style)?$view_ticket_style:"")?>><i class="fa fa-list" aria-hidden="true"></i> <span>View Tickets</span></a></li>
								<?php
									}
								?>

								<li <?=(!empty($social_ticket_class)?$social_ticket_class:"")?>>
									<a href="#"><i class="fa fa-wifi" aria-hidden="true"></i><span>Social Media</span> </a>
									<ul class="treeview-menu" <?=(!empty($social_ticket_css)?$social_ticket_css:"")?>>
										<li><a href="{{ url(config('quickadmin.route').'/tweet') }}" <?=(!empty($twitter_ticket_style)?$twitter_ticket_style:"")?>><i class="fa fa-twitter" aria-hidden="true"></i> <span>Twitter</span></a></li>
										<li><a href="{{ url(config('quickadmin.route').'/fbpage') }}" <?=(!empty($facebook_ticket_style)?$facebook_ticket_style:"")?>><i class="fa fa-facebook" aria-hidden="true"></i> <span>Facebook</span></a></li>
									</ul>
								</li>
							</ul>
						</li>
					<?php
						//}
					?>

					<li <?=(!empty($aes_class)?$aes_class:"")?>>
						<a href="#"><i class="fa fa-book" aria-hidden="true"></i><span>App Event Service</span> </a>
						<ul class="treeview-menu" <?=(!empty($aes_css)?$aes_css:"")?>>
							<?php
								//if(!empty($app_list_show)){
							?>
								<li <?=(!empty($app_class)?$app_class:"")?>>
									<?php
										//if((!empty($app_add_show)) && (!empty($app_list_show))){
									?>
											<a href="#"><i class="fa fa-paint-brush" aria-hidden="true"></i><span>Application</span> </a>
											<ul class="treeview-menu" <?=(!empty($app_css)?$app_css:"")?>>
												<?php
													if(!empty($app_add_show)){
												?>
														<li><a href="{{ url(config('quickadmin.route').'/create_app') }}" <?=(!empty($create_app_style)?$create_app_style:"")?>><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create App</span></a></li>
												<?php
													}
												?>
												<?php
													if(!empty($app_list_show)){
												?>
														<li><a href="{{ url(config('quickadmin.route').'/list_app') }}" <?=(!empty($list_app_style)?$list_app_style:"")?>><i class="fa fa-list" aria-hidden="true"></i> <span>App List</span></a></li>
												<?php
													}
												?>
											</ul>
									<?php
										//}
									?>
								</li>
							<?php
								//}
							?>
							<?php
								//if(!empty($event_list_show)){
							?>
									<li <?=(!empty($event_class)?$event_class:"")?>>
										<?php
											//if((!empty($event_add_show)) && (!empty($event_list_show))){
										?>
											<a href="#"><i class="fa fa-pencil" aria-hidden="true"></i><span>Event</span> </a>
											<ul class="treeview-menu" <?=(!empty($event_css)?$event_css:"")?>>
												<?php
													if(!empty($event_add_show)){
												?>
														<li><a href="{{ url(config('quickadmin.route').'/create_event') }}" <?=(!empty($create_event_style)?$create_event_style:"")?>><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create Event</span></a></li>
												<?php
													}
												?>
												<?php
													if(!empty($event_list_show)){
												?>
														<li><a href="{{ url(config('quickadmin.route').'/event_all_list') }}" <?=(!empty($list_event_style)?$list_event_style:"")?>><i class="fa fa-list" aria-hidden="true"></i> <span>All Events List</span></a></li>
												<?php
													}
												?>
											</ul>
										<?php
											//}
										?>
									</li>
							<?php
								//}
							?>

							<?php
								//if(!empty($service_list_show)){
							?>
								<li <?=(!empty($ser_class)?$ser_class:"")?>>
									<?php
										//if((!empty($service_add_show)) && (!empty($service_list_show))){
									?>
											<a href="#"><i class="fa fa-bolt" aria-hidden="true"></i><span>Service</span> </a>
											<ul class="treeview-menu" <?=(!empty($ser_css)?$ser_css:"")?>>
												<?php
													if(!empty($service_add_show)){
												?>
														<li><a href="{{ url(config('quickadmin.route').'/create_service') }}" <?=(!empty($create_service_style)?$create_service_style:"")?>><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create Service</span></a></li>
												<?php
													}
												?>
												<?php
													if(!empty($service_list_show)){
												?>
														<li><a href="{{ url(config('quickadmin.route').'/service_all_list') }}" <?=(!empty($list_service_style)?$list_service_style:"")?>><i class="fa fa-list" aria-hidden="true"></i> <span>All Services List</span></a></li>
												<?php
													}
												?>

											</ul>
										<?php
											//}
										?>
								</li>
							<?php
								//}
							?>
						</ul>
					</li>


					<!--

						<li <?=(!empty($ticket_settings_class)?$ticket_settings_class:"")?>>
							<a href="#"><i class="fa fa-wrench" aria-hidden="true"></i><span>Settings</span> </a>
							<ul class="treeview-menu" <?=(!empty($ticket_settings_css)?$ticket_settings_css:"")?>>
								<li><a href="{{ url(config('quickadmin.route').'/settings') }}" <?=(!empty($ticket_settings_style)?$ticket_settings_style:"")?>><i class="fa fa-ticket" aria-hidden="true"></i><span>Ticket Settings</span></a></li>
								<li><a href="{{ url(config('quickadmin.route').'/mailaccsettings')}}" <?=(!empty($mail_settings_style)?$mail_settings_style:"")?>><i class="fa fa-envelope" aria-hidden="true"></i><span>Mail Account Settings</span></a></li>
								<li><a href="{{ url(config('quickadmin.route').'/smsettings') }}" <?=(!empty($social_settings_style)?$social_settings_style:"")?>><i class="fa fa-wifi" aria-hidden="true"></i><span>Social Media Settings</span></a></li>
								<li <?=(!empty($temp_class)?$temp_class:"")?>>
									<a href="#"><i class="fa fa-envelope" aria-hidden="true"></i><span>E-Mail Template</span> </a>
									<ul class="treeview-menu" <?=(!empty($temp_css)?$temp_css:"")?>>
										<li><a href="{{ url(config('quickadmin.route').'/create_template') }}" <?=(!empty($create_template_style)?$create_template_style:"")?>><i class="fa fa-envelope" aria-hidden="true"></i> <span>Create Template</span></a></li>
										<li><a href="{{ url(config('quickadmin.route').'/list_template') }}" <?=(!empty($template_list_style)?$template_list_style:"")?>><i class="fa fa-envelope" aria-hidden="true"></i> <span>Template List</span></a></li>
										<li><a href="{{ url(config('quickadmin.route').'/sendmail') }}" <?=(!empty($send_mail_style)?$send_mail_style:"")?>><i class="fa fa-envelope" aria-hidden="true"></i> <span>Send E-Mail</span></a></li>
									</ul>
								</li>
							</ul>
						</li>

					-->

					<li <?=(!empty($ticket_settings_class)?$ticket_settings_class:"")?>>
						<a href="#"><i class="fa fa-wrench" aria-hidden="true"></i><span>Settings</span> </a>
						<ul class="treeview-menu" <?=(!empty($ticket_settings_css)?$ticket_settings_css:"")?>>
							<li><a href="{{ url(config('quickadmin.route').'/settings') }}" <?=(!empty($ticket_settings_style)?$ticket_settings_style:"")?>><i class="fa fa-ticket" aria-hidden="true"></i><span>Ticket Settings</span></a></li>
							<li <?=(!empty($temp_class)?$temp_class:"")?>>
								<a href="#"><i class="fa fa-envelope" aria-hidden="true"></i><span>E-Mail Template</span> </a>
								<ul class="treeview-menu" <?=(!empty($temp_css)?$temp_css:"")?>>
									<li><a href="{{ url(config('quickadmin.route').'/create_template') }}" <?=(!empty($create_template_style)?$create_template_style:"")?>><i class="fa fa-envelope" aria-hidden="true"></i> <span>Create Template</span></a></li>
									<li><a href="{{ url(config('quickadmin.route').'/list_template') }}" <?=(!empty($template_list_style)?$template_list_style:"")?>><i class="fa fa-envelope" aria-hidden="true"></i> <span>Template List</span></a></li>
									<li><a href="{{ url(config('quickadmin.route').'/sendmail') }}" <?=(!empty($send_mail_style)?$send_mail_style:"")?>><i class="fa fa-envelope" aria-hidden="true"></i> <span>Send E-Mail</span></a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li <?=(!empty($mail_to_employees_class)?$mail_to_employees_class:"")?>>
						<a href="{{ url(config('quickadmin.route').'/empsendmail') }}"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Mail To Internal Users</span></a>
					</li>
					<!--<li class="treeview">
						<a href="#"><i class="fa fa-wechat" aria-hidden="true"></i><span>Chat</span> </a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/customerchathistory') }}"><i class="fa fa-fw fa-wechat" aria-hidden="true"></i> <span>Customer Chat</span></a></li>
						</ul>
					</li>-->
					<li <?=(!empty($chat_class)?$chat_class:"")?>>
					<a href="#"><i class="fa fa-wechat" aria-hidden="true"></i><span>Chat</span> </a>
					<ul class="treeview-menu" <?=(!empty($chat_css)?$chat_css:"")?>>
						<li><a href="{{ url(config('quickadmin.route').'/customerchathistory') }}" <?=(!empty($customer_chat_style)?$customer_chat_style:"")?>><i class="fa fa-fw fa-wechat" aria-hidden="true"></i> <span>Chat Notifications</span></a></li>					</ul>
					</li>

					<!--

						<li <?=(!empty($customer_class)?$customer_class:"")?>>
							<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Customer Management</span> </a>
							<ul class="treeview-menu" <?=(!empty($customer_css)?$customer_css:"")?>>
								<li><a href="{{ url(config('quickadmin.route').'/customer_info')}}" <?=(!empty($customer_info_style)?$customer_info_style:"")?>><i class="fa fa-user-secret"></i> <span>Customer Details</span></a></li>
								<li><a href="{{ url(config('quickadmin.route').'/customer_log_status')}}" <?=(!empty($customer_log_style)?$customer_log_style:"")?>><i class="fa fa-users" aria-hidden="true"></i> <span>Customer Status</span></a></li>
							</ul>
						</li>

					-->
					<li <?=(!empty($customer_class)?$customer_class:"")?>>
						<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Customer Management</span> </a>
						<ul class="treeview-menu" <?=(!empty($customer_css)?$customer_css:"")?>>
							<li><a href="{{ url(config('quickadmin.route').'/customer_info') }}" <?=(!empty($customer_info_style)?$customer_info_style:"")?>><i class="fa fa-user-secret"></i> <span>Customer Details</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/customer_log_status') }}" <?=(!empty($customer_log_style)?$customer_log_style:"")?>><i class="fa fa-users" aria-hidden="true"></i> <span>Customer Status</span></a></li>
						</ul>
					</li>
					<li <?=(!empty($report_class)?$report_class:"")?>>
						<a href="{{ url(config('quickadmin.route').'/ticket_report') }}"><i class="fa fa-book"></i> <span>Reports</span></a>
					</li>
				</ul>
			@elseif($usertype == 3)
				<ul class="sidebar-menu" id="navigation" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li <?=(!empty($dashboard_class)?$dashboard_class:"")?>>
						<a href="{{ url('emp-dashboard') }}">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<?php
						$user_list_show = $ticket_list_show = $app_list_show = $event_list_show = $service_list_show = "";
						$user_add_show = $ticket_add_show = $app_add_show = $event_add_show = $service_add_show = "";

						$user_list_show = session()->get('userView');
						$ticket_list_show = session()->get('ticketView');
						$app_list_show = session()->get('appView');
						$event_list_show = session()->get('eventView');
						$service_list_show = session()->get('serviceView');

						$user_add_show = session()->get('userCreate');
						$ticket_add_show = session()->get('ticketCreate');
						$app_add_show = session()->get('appCreate');
						$event_add_show = session()->get('eventCreate');
						$service_add_show = session()->get('serviceCreate');

						if(!empty($user_list_show)){
					?>
						<!--<li class="treeview">
							<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Ticket Admin Management</span> </a>
							<ul class="treeview-menu">
								<?php
									if(!empty($user_add_show)){
								?>
									<li><a href="{{ url(config('quickadmin.route').'/add_user') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> <span>Add User</span></a></li>
								<?php
									}
								?>
								<li><a href="{{ url(config('quickadmin.route').'/puser') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>View User</span></a></li>

							</ul>
						</li>-->
					<?php
						}
					?>
					<li <?=(!empty($my_ticket_class)?$my_ticket_class:"")?>>
						<a href="{{ url('my_tickets?tab_id=3') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>My Tickets</span></a>
					</li>
					<?php
						if(!empty($ticket_list_show)){
					?>
						<!--<li class="treeview">
							<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets Management</span> </a>
							<ul class="treeview-menu">
								<?php
									if(!empty($ticket_add_show)){
								?>
									<li><a href="{{ url(config('quickadmin.route').'/padd_tickets') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Add Ticket</span></a></li>
								<?php
									}
								?>
								<?php
									if(!empty($ticket_list_show)){
								?>
										<li><a href="{{ url(config('quickadmin.route').'/pticket') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>View Tickets</span></a></li>
								<?php
									}
								?>
								<li class="treeview">
									<a href="#"><i class="fa fa-wifi" aria-hidden="true"></i><span>Social Media</span> </a>
									<ul class="treeview-menu">
										<li><a href="{{ url(config('quickadmin.route').'/tweet') }}"><i class="fa fa-twitter" aria-hidden="true"></i> <span>Twitter</span></a></li>
										<li><a href="../facebook/index.php"><i class="fa fa-facebook" aria-hidden="true"></i> <span>Facebook</span></a></li>
									</ul>
								</li>
							</ul>
						</li>-->
					<?php
						}
					?>
					<!--
					<li class="treeview">
						<a href="#"><i class="fa fa-book" aria-hidden="true"></i><span>App Event Service</span> </a>
						<ul class="treeview-menu">
							<?php
								//if(!empty($app_list_show)){
							?>
								<li class="treeview">
									<?php
										//if((!empty($app_add_show)) && (!empty($app_list_show))){
									?>
											<a href="#"><i class="fa fa-paint-brush" aria-hidden="true"></i><span>Application</span> </a>
											<ul class="treeview-menu">
												<?php
													if(!empty($app_add_show)){
												?>
														<li><a href="{{ url(config('quickadmin.route').'/create_app') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create App</span></a></li>
												<?php
													}
												?>
												<?php
													if(!empty($app_list_show)){
												?>
														<li><a href="{{ url(config('quickadmin.route').'/list_app') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>App List</span></a></li>
												<?php
													}
												?>
											</ul>
									<?php
										//}
									?>
								</li>
							<?php
								//}
							?>
							<?php
								//if(!empty($event_list_show)){
							?>
									<li class="treeview">
										<?php
											//if((!empty($event_add_show)) && (!empty($event_list_show))){
										?>
											<a href="#"><i class="fa fa-pencil" aria-hidden="true"></i><span>Event</span> </a>
											<ul class="treeview-menu">
												<?php
													if(!empty($event_add_show)){
												?>
														<li><a href="{{ url(config('quickadmin.route').'/create_event') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create Event</span></a></li>
												<?php
													}
												?>
												<?php
													if(!empty($event_list_show)){
												?>
														<li><a href="{{ url(config('quickadmin.route').'/event_all_list') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>All Events List</span></a></li>
												<?php
													}
												?>
											</ul>
										<?php
											//}
										?>
									</li>
							<?php
								//}
							?>

							<?php
								//if(!empty($service_list_show)){
							?>
								<li class="treeview">
									<?php
										//if((!empty($service_add_show)) && (!empty($service_list_show))){
									?>
											<a href="#"><i class="fa fa-bolt" aria-hidden="true"></i><span>Service</span> </a>
											<ul class="treeview-menu">
												<?php
													if(!empty($service_add_show)){
												?>
														<li><a href="{{ url(config('quickadmin.route').'/create_service') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create Service</span></a></li>
												<?php
													}
												?>
												<?php
													if(!empty($service_list_show)){
												?>
														<li><a href="{{ url(config('quickadmin.route').'/service_all_list') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>All Services List</span></a></li>
												<?php
													}
												?>

											</ul>
										<?php
											//}
										?>
								</li>
							<?php
								//}
							?>
						</ul>
					</li>-->


					<li <?=(!empty($social_ticket_class)?$social_ticket_class:"")?>>
						<a href="#"><i class="fa fa-wifi" aria-hidden="true"></i><span>Social Media</span> </a>
						<ul class="treeview-menu" <?=(!empty($social_ticket_css)?$social_ticket_css:"")?>>
							<li><a href="{{ url(config('quickadmin.route').'/tweet') }}" <?=(!empty($twitter_ticket_style)?$twitter_ticket_style:"")?>><i class="fa fa-twitter" aria-hidden="true"></i> <span>Twitter</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/fbpage') }}" <?=(!empty($facebook_ticket_style)?$facebook_ticket_style:"")?>><i class="fa fa-facebook" aria-hidden="true"></i> <span>Facebook</span></a></li>
						</ul>
					</li>

					<!--
					<li class="treeview">
						<a href="#"><i class="fa fa-wifi" aria-hidden="true"></i><span>Social Media</span> </a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/tweet') }}"><i class="fa fa-twitter" aria-hidden="true"></i> <span>Twitter</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/fbpage') }}"><i class="fa fa-facebook" aria-hidden="true"></i> <span>Facebook</span></a></li>
						</ul>
					</li>-->


					<li <?=(!empty($mail_to_employees_class)?$mail_to_employees_class:"")?>>
						<a href="{{ url(config('quickadmin.route').'/empsendmail') }}"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Mail To Internal Users</span></a>
					</li>
					<li <?=(!empty($chat_class)?$chat_class:"")?>>
						<a href="#"><i class="fa fa-wechat" aria-hidden="true"></i><span>Chat</span> </a>
						<ul class="treeview-menu" <?=(!empty($chat_css)?$chat_css:"")?>>
							<li><a href="{{ url(config('quickadmin.route').'/customerchathistory') }}" <?=(!empty($customer_chat_style)?$customer_chat_style:"")?>><i class="fa fa-fw fa-wechat" aria-hidden="true"></i> <span>Chat Notifications</span></a></li>
						</ul>
					</li>
					<li <?=(!empty($customer_class)?$customer_class:"")?>>
						<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Customer Management</span> </a>
						<ul class="treeview-menu" <?=(!empty($customer_css)?$customer_css:"")?>>
							<li><a href="{{ url(config('quickadmin.route').'/customer_info')}}" <?=(!empty($customer_info_style)?$customer_info_style:"")?>><i class="fa fa-user-secret"></i> <span>Customer Details</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/customer_log_status')}}" <?=(!empty($customer_log_style)?$customer_log_style:"")?>><i class="fa fa-users" aria-hidden="true"></i> <span>Customer Status</span></a></li>
						</ul>
					</li>
					<!--
					<li class="treeview">
						<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Customer Management</span> </a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/customer_info') }}"><i class="fa fa-user-secret"></i> <span>Customer Details</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/customer_log_status') }}"><i class="fa fa-users" aria-hidden="true"></i> <span>Customer Status</span></a></li>
						</ul>
					</li>-->
				</ul>
			@endif
		@endif
					</div>
				</div>
			</div>

			<!--<div class="panel charts panel-default">
                                <div class="panel-heading" role="tab">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#sidebarCharts">
                                            Orders Summary <i class="fa fa-angle-up"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="sidebarCharts" class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body">
                                        <div class="summary">

                                            <div class="media">
                                                <a class="pull-right" role="button" tabindex="0">
                                                    <span class="sparklineChart"
                                                          values="5, 8, 3, 4, 6, 2, 1, 9, 7"
                                                          sparkType="bar"
                                                          sparkBarColor="#92424e"
                                                          sparkBarWidth="6px"
                                                          sparkHeight="36px">
                                                    Loading...</span>
                                                </a>
                                                <div class="media-body">
                                                    This week sales
                                                    <h4 class="media-heading">26, 149</h4>
                                                </div>
                                            </div>

                                            <div class="media">
                                                <a class="pull-right" role="button" tabindex="0">
                                                    <span class="sparklineChart"
                                                          values="2, 4, 5, 3, 8, 9, 7, 3, 5"
                                                          sparkType="bar"
                                                          sparkBarColor="#397193"
                                                          sparkBarWidth="6px"
                                                          sparkHeight="36px">
                                                    Loading...</span>
                                                </a>
                                                <div class="media-body">
                                                    This week balance
                                                    <h4 class="media-heading">318, 651</h4>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel settings panel-default">
                                <div class="panel-heading" role="tab">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#sidebarControls">
                                            General Settings <i class="fa fa-angle-up"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="sidebarControls" class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="row">
                                              <label class="col-xs-8 control-label">Switch ON</label>
                                              <div class="col-xs-4 control-label">
                                                <div class="onoffswitch greensea">
                                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch-on" checked="">
                                                  <label class="onoffswitch-label" for="switch-on">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                  </label>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <div class="row">
                                              <label class="col-xs-8 control-label">Switch OFF</label>
                                              <div class="col-xs-4 control-label">
                                                <div class="onoffswitch greensea">
                                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch-off">
                                                  <label class="onoffswitch-label" for="switch-off">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                  </label>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                    </div>
                                </div>
                            </div>-->
		</div>
	</div>
	<!-- /.sidebar -->
</aside>


<aside id="rightbar">
	<div role="tabpanel">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#users" aria-controls="users" role="tab" data-toggle="tab"><i class="fa fa-users"></i></a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="users">
				<input type="hidden" id="luserid" name="luserid" value="<?php echo session()->get('userId'); ?>" />
				<input type="hidden" id="lusername" name="lusername" value="<?php echo session()->get('userName'); ?>" />

				<h6><strong>Online</strong> TicketAdmins</h6>
				<ul ng-controller="OnLineUserController">
					<li ng-repeat="ou in onuser" class="online">
						<div class="media">
							<a class="pull-left thumb thumb-sm" role="button" tabindex="0">
								<img class="media-object img-circle" src="{{asset("/images/images.png")}}" alt>
							</a>
							<div class="media-body">
								<a id="<%ou.userId%>" href="" onclick="register_popup(this.id)">
									<span class="media-heading" ng-bind="ou.userName"></span>
								</a>

								<span style="top:8px" class="badge badge-outline status"></span>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>

	</div>

</aside>
                <!--/ RIGHTBAR Content -->
</div>