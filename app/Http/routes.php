<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('admin/view_tickets','TicketsController@viewtickets');

Route::get('admin/post_reply','TicketsController@postreply');



Route::resource('admin/forgotpassword','UsersForgotPassController');

Route::group(['middleware' => ['web']], function(){

	//user controllers
	Route::resource('admin/dashboard','HomeController');
	
	Route::resource('admin/users','UserController');
	
	Route::resource('admin/add_user','UsersController');

	Route::resource('admin/edit_user','UpdateUsersController');

	Route::resource('admin/user_details','UsersDetailsController');

	Route::resource('admin/view_user','UserListController');

	//ticket controllers
	Route::resource('admin/add_tickets','TicketsController');
	Route::get('admin/load_group_user','TicketsController@load_group_user');

	Route::resource('admin/view_tickets','TicketListController');
	Route::get('admin/view_ticketsold','TicketsController@viewtickets');
	Route::resource('admin/edit_ticket','UpdateTicketController');
	Route::resource('admin/ticket_details','TicketDetailsController');

	Route::resource('admin/twitter','TwitterController');
	Route::resource('admin/facebook','FacebookController');

	Route::resource('admin/facebooknew','FacebookControllerNew');

	Route::resource('admin/twitternew','TwitterNewController');
	Route::resource('admin/process','TwitterNewController@process');

	Route::resource('admin/department','DepartmentController');

	Route::resource('admin/settings','SettingsController');

	Route::resource('admin/edit_dept','UpdateSettingsController');
	Route::resource('admin/edit_cat','UpdateSettingsController');
	Route::resource('admin/edit_prior','UpdateSettingsController');
	Route::resource('admin/edit_source','UpdateSettingsController');
	Route::resource('admin/edit_type','UpdateSettingsController');
	Route::resource('admin/edit_status','UpdateSettingsController');

	Route::resource('admin/del_dept','DeleteSettingsController');
	Route::resource('admin/del_cat','DeleteSettingsController');
	Route::resource('admin/del_prior','DeleteSettingsController');
	Route::resource('admin/del_source','DeleteSettingsController');
	Route::resource('admin/del_type','DeleteSettingsController');
	Route::resource('admin/del_status','DeleteSettingsController');

	//notification
	Route::resource('admin/notification', 'NotificationController');
	Route::resource('admin/createticketfromnotification', 'CreateTicketNotificationController');

	//App Routes
	Route::resource('admin/create_app','AppCreateController');
	Route::resource('admin/list_app','AppListController');
	Route::resource('admin/edit_app','UpdateAppController');

	//Event Routes
	Route::resource('admin/create_event','AppEventCreateController');
	Route::resource('admin/event_list','AppEventListController');
	Route::resource('admin/delete_event','AppEventDeleteController');
	Route::resource('admin/event_edit','UpdateEventController');
	Route::resource('admin/event_all_list','EventAllListController');
	Route::resource('admin/event_delete','EventDeleteController');

	//Services Routes
	Route::resource('admin/create_service','EventServiceCreateController');
	Route::resource('admin/service_list','EventServiceListController');
	Route::resource('admin/delete_service','EventServiceDeleteController');
	Route::resource('admin/service_edit','UpdateServiceController');
	Route::resource('admin/service_all_list','ServiceAllListController');
	Route::resource('admin/service_delete','ServiceDeleteController');

	//User Privilege Routes
	//Route::resource('admin/user_privileges','UserPrivilegeController');
	Route::resource('admin/user_privileges','UserPrivilegeController');
	Route::resource('admin/assign_privilege','AssignPrivilegeController');

	Route::get('admin/load_app_event', 'AppEventListController@load_event');

	//Employee Ticket related Pages
	Route::resource('emp-dashboard','EmployeeHomeController');
	Route::resource('empTickets','EmployeeHomeController@getUserTickets');
	
	Route::resource('my_tickets','UserTicketListController');
   	
   	Route::resource('emp_ticket_details','PrivilegeTicketDetailsController');

   	Route::resource('admin/pticket','PrivilegeTicketListController');
   	Route::resource('admin/puser','PrivilegeUserListController');
   	Route::resource('admin/papp','PrivilegeAppListController');
   	Route::resource('admin/pevent','PrivilegeAppEventListController');


	//Privilege User related pages
	Route::resource('privilege_add_user','PrivilegeUsersController');
	Route::resource('privilege_user_list','PrivilegeUserListController');
	Route::resource('privilege_edit_user','PrivilegeUpdateUsersController');
	Route::resource('privilege_user_details','PrivilegeUsersDetailsController');

	//Privilege App related pages
	Route::resource('privilege_create_app','PrivilegeAppCreateController');
	Route::resource('privilege_app_list','PrivilegeAppListController');
	Route::resource('privilege_edit_app','PrivilegeUpdateAppController');

	//Privilege Event related Pages
	Route::resource('privilege_create_event','PrivilegeAppEventCreateController');
	Route::resource('privilege_event_list','PrivilegeAppEventListController');
	Route::resource('privilege_event_edit','PrivilegeUpdateEventController');
	Route::resource('privilege_delete_event','PrivilegeAppEventDeleteController');

	Route::resource('admin/delete_pevent','PrivilegeAppEventListController');

   	Route::resource('admin/padd_tickets','PrivilegeAddTicketsController');

   	Route::resource('edit_ticket','UserUpdateTicketController');

 	Route::get('user_logout','LoginController@logout');
	Route::resource('admin/login_user','LoginController');

	Route::resource('admin/user_profile','UserProfileController');
	Route::resource('admin/change_password','ChangePasswordController');

	Route::resource('admin/mail','MailController');

	Route::resource('admin/user_log_status','UserLogStatusController');

	Route::resource('admin/create_template','EmailCreateTemplateController');
	Route::resource('admin/list_template','EmailTemplateController');
	Route::resource('admin/edit_template','EmailTemplateController');
	Route::resource('admin/delete_template','DeleteEmailTemplateController');
	Route::resource('admin/template_details','EmailTemplateDetailController');

	Route::resource('admin/sendmail','SendEmailController');
	Route::get('admin/load_template','SendEmailController@load_template');

	Route::resource('admin/customer_info','CustomerDetailsController');

	Route::resource('admin/emailnotification', 'EmailNotificationController');

	Route::resource('admin/mailbox', 'MailBoxController');
	Route::resource('admin/readmail', 'ReadMailController');
	Route::resource('admin/composemail', 'ComposeMailController');

	//CMS Menu Routes
	Route::resource('admin/contentmanage','ContentManagementController');
	Route::resource('admin/edit_menu','UpdateContentManagementController');
	Route::resource('admin/del_menu','DeleteContentManagementController');

	//Routes for Customer Feedback List & Delete
	Route::resource('admin/feedback_list','FeedbackListController');
	Route::resource('admin/del_feedback','DeleteFeedbackController');
	Route::resource('admin/feedback_details','FeedbackDetailsController');

	//Route for the Ticket Report Generate
	Route::resource('admin/ticket_report','TicketReportGenController');

	//Routes for Chat
	Route::resource('admin/chat','ChatController');
	Route::resource('admin/customer_log_status','CustomerLogStatusController');


	//Routes for new social media integration
	Route::resource('admin/cgtwitter','CgTwitterController');

	//Routes for new social media integration
	Route::resource('admin/mailsettings','MailSettingsController');

	//Routes for social media settings
	Route::resource('admin/smsettings','SocialMediaSettingsController');
	Route::resource('admin/edit_sms','UpdateSocialMediaSettingsController');
	Route::resource('admin/del_sms','DeleteSocialMediaController');

	//Routes for ticket notify supervisor and staff users
	Route::resource('load_new_ticket_notify_emp','InstantNotifyController');
	Route::resource('update_new_ticket_notify_emp','UpdateInstantNotifyController');

	//Routes for mail cron
	Route::resource('cronsendmail','CronSendMailController');
	Route::resource('admin/empsendmail','InternalUserSendMailController');


	//Route for the Ticket Report Generate
	Route::resource('admin/ticket_report','TicketReportGenController');
	Route::get('admin/load_group_user_email','TicketsController@load_group_user_email');

	//CMS Mail Account Settings
	Route::resource('admin/mailaccsettings','MailAccountSettingController');
	Route::resource('admin/del_mail','MailAccountSettingController@destroy');

	Route::resource('admin/pop3mail','Pop3MailController');

	Route::resource('admin/tweet','SocialMediaController@tweet');
	Route::resource('admin/reply','SocialMediaController@reply');
	Route::resource('admin/social', 'SocialMediaController');

	Route::resource('admin/customerchathistory','CustomerChatHistoryController');
	Route::get('admin/custchathisupd','CustomerChatHistoryController@custchathisupd');
	Route::get('admin/custchathiscls','CustomerChatHistoryController@custchathiscls');

	Route::get('admin/tick_cnt','CustomerChatHistoryController@ticket_count');

	Route::resource('load_dashboard_ticket_count','TicketsCountController');

	Route::resource('admin/fbpage','FbPageController');
	Route::post('admin/fbpagepost','FbPageController@addpost');

	Route::get('admin/ticket_report_cron','TicketReportCronController@getAllTicketReport');

	//feed
	Route::get('admin/getFacebookFeed','FbPageController@getFacebookFeed');
	Route::get('admin/getTweetFeed','SocialMediaController@getTweetFeed');

	//chat
	Route::get('admin/getonlineuser','UserLogStatusController@getOnlineUser');
	Route::get('admin/fetchempchats','CustomerChatHistoryController@fetch_emp_chat');
	Route::get('admin/fetchchats','CustomerChatHistoryController@fetch_chat');
	Route::get('admin/fetchonchats','CustomerChatHistoryController@fetch_on_chat');
	
	//for quick assign from dashboard
	Route::get('admin/quickassign', 'UpdateTicketController@quickassign');
	
	//for create Mail Ticket from dashboard
	Route::get('admin/createMailTicket', 'TicketsController@createMailTicket');
	
	Route::resource('admin/replymail','ReplyMailController');
	
	//Country controllers
	Route::resource('admin/add_country','CountryController');
	Route::resource('admin/view_country','CountryListController');	
	Route::resource('admin/edit_country','UpdateCountryController');
	
	//Team controllers
	Route::resource('admin/view_team','TeamListController');		
});

