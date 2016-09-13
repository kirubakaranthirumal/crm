<?php
	namespace App\Http\Controllers;

	use Session;

	class FacebookController extends Controller {
		public function index(){
			return view('admin.facebook');
		}
	}
?>