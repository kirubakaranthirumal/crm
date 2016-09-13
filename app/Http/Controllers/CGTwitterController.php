<?php
	namespace App\Http\Controllers;

	use Session;

	class CGTwitterController extends Controller {

		public function index(){
			return view('admin.cgtwitter');
		}
	}
?>