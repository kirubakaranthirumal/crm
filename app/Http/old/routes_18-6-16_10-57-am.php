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

//Route::get('admin/dashboard','HomeController@index');
//Route::get('admin/add_tickets','TicketsController@addticket');
Route::get('admin/view_tickets','TicketsController@viewtickets');
//Route::get('admin/ticket_details','TicketsController@detailtickets');
Route::get('admin/post_reply','TicketsController@postreply');
/*Route::get('admin/dept_transfer','PagesController@depttransfer');
Route::get('admin/datatable','PagesController@dataTable');*/

//Route::get('admin/add_user','UsersController@adduser');
//Route::get('admin/view_user','UsersController@viewuser');
//Route::get('admin/user_details','UsersController@userdetails');


Route::group(['middleware' => ['web']], function (){

	//user controllers
	Route::resource('admin/dashboard','HomeController');
	Route::resource('admin/add_user','UsersController');
	//Route::get('admin/view_user','UsersController@viewuser');
	//Route::get('admin/view_user','UsersController@viewuser');
	Route::resource('admin/edit_user','UpdateUsersController');
	//Route::get('admin/user_details','UsersController@userdetails');
	//Route::put('admin/edit_user','UpdateUsersController@test');
	Route::resource('admin/user_details','UsersDetailsController');
	//Route::resource('admin/deleteuser','UserListController');
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

	Route::resource('admin/twitternew','TwitterNewController');
	Route::resource('admin/process','TwitterNewController@process');

	Route::resource('admin/department','DepartmentController');

	Route::resource('admin/settings','SettingsController');

	Route::resource('admin/edit_dept','UpdateSettingsController');
	Route::resource('admin/edit_cat','UpdateSettingsController');
	Route::resource('admin/edit_prior','UpdateSettingsController');
	Route::resource('admin/edit_source','UpdateSettingsController');
	Route::resource('admin/edit_type','UpdateSettingsController');

	Route::resource('admin/del_dept','DeleteSettingsController');
	Route::resource('admin/del_cat','DeleteSettingsController');
	Route::resource('admin/del_prior','DeleteSettingsController');
	Route::resource('admin/del_source','DeleteSettingsController');
	Route::resource('admin/del_type','DeleteSettingsController');

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

	//Services Routes
	Route::resource('admin/create_service','EventServiceCreateController');
	Route::resource('admin/service_list','EventServiceListController');
	Route::resource('admin/delete_service','EventServiceDeleteController');
	Route::resource('admin/service_edit','UpdateServiceController');

	//User Privilege Routes
	//Route::resource('admin/user_privileges','UserPrivilegeController');
	Route::resource('admin/user_privileges','UserPrivilegeController');
	Route::resource('admin/assign_privilege','AssignPrivilegeController');

	Route::get('admin/load_app_event', 'AppEventListController@load_event');

	//Employee Ticket related Pages
	Route::resource('emp-dashboard','EmployeeHomeController');
	Route::resource('my_tickets','UserTicketListController');
   	//Route::resource('emp_ticket_details','UserTicketDetailsController');
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

	Route::resource('admin/mailbox', 'MailBoxController');

	Route::resource('admin/emailnotification', 'EmailNotificationController');

});

