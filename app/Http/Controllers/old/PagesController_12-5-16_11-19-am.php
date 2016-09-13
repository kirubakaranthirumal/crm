<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class PagesController extends Controller
{
    
	public function index(){
		return view('admin.dashboard');
	}

    public function addticket()
    {
       
        return view('admin.ticket_form.add_tickets');       
    }
      public function viewtickets()
    {
       
        return view('admin.ticket_form.view_tickets');       
    }
        public function detailtickets()
    {
       
        return view('admin.ticket_form.ticket_details');       
    }
         public function dataTable()
    {
       
        return view('admin.ticket_form.datatable');       
    }
            public function postreply()
    {
       
        return view('admin.ticket_form.post_reply');       
    }

             public function depttransfer()
    {
       
        return view('admin.ticket_form.dept_transfer');       
    }
}

