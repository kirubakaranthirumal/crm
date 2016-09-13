<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Tickets;
use App\Http\Requests\CreateTicketsRequest;
use App\Http\Requests\UpdateTicketsRequest;
use Illuminate\Http\Request;



class TicketsController extends Controller {

	/**
	 * Display a listing of tickets
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $tickets = Tickets::all();

		return view('admin.tickets.index', compact('tickets'));
	}

	/**
	 * Show the form for creating a new tickets
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.tickets.create');
	}

	/**
	 * Store a newly created tickets in storage.
	 *
     * @param CreateTicketsRequest|Request $request
	 */
	public function store(CreateTicketsRequest $request)
	{
	    
		Tickets::create($request->all());

		return redirect()->route('admin.tickets.index');
	}

	/**
	 * Show the form for editing the specified tickets.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$tickets = Tickets::find($id);
	    
	    
		return view('admin.tickets.edit', compact('tickets'));
	}

	/**
	 * Update the specified tickets in storage.
     * @param UpdateTicketsRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateTicketsRequest $request)
	{
		$tickets = Tickets::findOrFail($id);

        

		$tickets->update($request->all());

		return redirect()->route('admin.tickets.index');
	}

	/**
	 * Remove the specified tickets from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Tickets::destroy($id);

		return redirect()->route('admin.tickets.index');
	}

    /**
     * Mass delete function from index page
     * @param Request $request
     *
     * @return mixed
     */
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            Tickets::destroy($toDelete);
        } else {
            Tickets::whereNotNull('id')->delete();
        }

        return redirect()->route('admin.tickets.index');
    }

}
