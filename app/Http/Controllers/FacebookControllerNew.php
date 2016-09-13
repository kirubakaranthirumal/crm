<?php
	namespace App\Http\Controllers;

	use Session;

	class FacebookControllerNew extends Controller {
		public function index(){
			return view('admin.facebooknew');
		}
	}
?>