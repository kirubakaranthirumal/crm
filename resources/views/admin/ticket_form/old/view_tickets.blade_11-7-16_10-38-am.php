@extends('admin.layouts.master')

@section('content')
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
  <div class="box">
                <div class="box-header">
                  <h3 class="box-title">View Tickets</h3>
                </div><!-- /.box-header -->
           <div class="box-body">


						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Filter Ticket</h3>
							</div><!-- /.box-header -->
							<!-- form start -->
							<form role="form">
								<div class="box-body">
									<div class="col-md-6">
										<div class="form-group">
											<label>Employee</label>
											<input type="text" class="form-control"  placeholder="Filter By Employee">
										</div>
										<div class="form-group">
											<label>Groups</label>
											<input type="text" class="form-control" placeholder="Filter By Groups">
										</div>
										<div class="form-group">
											<label>Date</label>
											<input type="date" class="form-control"></input>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Status</label>
											<select class="form-control">
												<option>Filter By Status</option>
												<option>Open</option>
												<option>Pending</option>
												<option>Resolved</option>
												<option>InProgress</option>
												<option>Closed</option>
												<option>Waiting On Customer</option>
												<option>Waiting On 3rd Party</option>
											</select>
										</div>
										<div class="form-group">
											<label>Priority</label>
											<select class="form-control">
												<option>Filter By Priority</option>
												<option>Low</option>
												<option>Medium</option>
												<option>High</option>
												<option>Urgent</option>
											</select>
										</div>
										<div class="form-group">
											<label>Source</label>
											<select class="form-control">
												<option>Filter By Source</option>
												<option>Portal</option>
												<option>Email</option>
												<option>Social Media</option>
												<option>Live Chat</option>
											</select>
										</div>
									</div>
								</div><!-- /.box-body -->
								<div class="box-footer">
									<button type="submit" class="btn btn-primary">Filter</button>
									<button type="reset" class="btn btn-primary">Reset</button>
								</div>
							</form>
              			</div><!-- /.box -->

                  <div class="box-body">
                  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                  <div class="row">
                  <div class="col-sm-6">
                  <div class="dataTables_length" id="example1_length">
                  <label>Show
                  <select name="example1_length" aria-controls="example1" class="form-control input-sm">
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                  </select> entries</label>
                  </div>
                  </div>
                  <div class="col-sm-6">
                  <div id="example1_filter" class="dataTables_filter">
                  <!--<label>Search <input type="search" class="form-control input-sm" placeholder="" aria-controls="example1"></label>-->
                  </div>
                  </div>
                  </div>
                  <div style="clear:both">&nbsp;</div>
                    <div class="row">
                           <div class="col-md-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" style="">
                 <li class="active"><a href="#aging" data-toggle="tab">Aging</a></li>
                  <li ><a href="#openticket" data-toggle="tab">Open Tickets (15)</a></li>
                  <li><a href="#assigned" data-toggle="tab">Assiged Tickets (25)</a></li>
                  <li><a href="#inprogress" data-toggle="tab">In-Progress (18)</a></li>
                   <li><a href="#closed" data-toggle="tab">Closed (18)</a></li>
                  <li><a href="#woc" data-toggle="tab">Waiting On Customer (5)</a></li>
                  <li><a href="#wotp" data-toggle="tab">Waiting On 3rd Party (6)</a></li>

                </ul>
                <div class="tab-content" >
                <div class="active tab-pane" id="aging">
                    <!-- Post -->
                           <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Tickets</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Subject</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Dept</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Priority</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Created On</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Created By</th>


                      </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">12345</a></td>
                        <td> Issue on Live streaming</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>12/04/2016</td>
                        <td>Ramakrishnan</td>


                      </tr><tr role="row" class="even">
                           <td class="sorting_1">Closed</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">14545</a></td>
                        <td> Problem of the page loading</td>
                        <td>N/W Supprt</td>
                          <td>Urgent</td>
                         <td>16/04/2016</td>
                        <td>Murali</td>


                      </tr><tr role="row" class="odd">
                        <td class="sorting_1">In Progress</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td> Problem of the page loading</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Balachander</td>

                      </tr>

                      </tbody>

                  </table><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div>
                  </div>
                  <div class="tab-pane" id="openticket">
                    <!-- Post -->
                              <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Tickets</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Subject</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Dept</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Priority</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Created On</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Created By</th>


                      </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td>Payment Issue</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Aravind</td>

                      </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">12345</a></td>
                        <td> Issue on Live streaming</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>12/04/2016</td>
                        <td>Ramakrishnan</td>


                      </tr><tr role="row" class="even">
                           <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">14545</a></td>
                        <td> Problem of the page loading</td>
                        <td>N/W Supprt</td>
                          <td>Urgent</td>
                         <td>16/04/2016</td>
                        <td>Murali</td>


                      </tr><tr role="row" class="odd">
                        <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td> Problem of the page loading</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Balachander</td>

                      </tr>

                      </tbody>

                  </table><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="assigned">
                 <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Tickets</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Subject</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Dept</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Priority</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Created On</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Created By</th>


                      </tr>
                    </thead>
                    <tbody>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Assigned</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">12345</a></td>
                        <td> Issue on Live streaming</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>12/04/2016</td>
                        <td>Ramakrishnan</td>


                      </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">Assigned</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td>Payment Issue</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Aravind</td>

                      </tr>
                  <tr role="row" class="even">
                           <td class="sorting_1">Assigned</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">14545</a></td>
                        <td> Problem of the page loading</td>
                        <td>N/W Supprt</td>
                          <td>Urgent</td>
                         <td>16/04/2016</td>
                        <td>Murali</td>


                      </tr><tr role="row" class="odd">
                        <td class="sorting_1">Assigned</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td> Problem of the page loading</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Balachander</td>

                      </tr>

                      </tbody>

                  </table><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div>
                  </div><!-- /.tab-pane -->

                  <div class="tab-pane" id="inprogress">
                <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Tickets</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Subject</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Dept</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Priority</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Created On</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Created By</th>


                      </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="even">
                           <td class="sorting_1">Inprogress</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">14545</a></td>
                        <td> Problem of the page loading</td>
                        <td>N/W Supprt</td>
                          <td>Urgent</td>
                         <td>16/04/2016</td>
                        <td>Murali</td>


                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Inprogress</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">12345</a></td>
                        <td> Issue on Live streaming</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>12/04/2016</td>
                        <td>Ramakrishnan</td>


                      </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">Inprogress</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td>Payment Issue</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Aravind</td>

                      </tr>
                  <tr role="row" class="odd">
                        <td class="sorting_1">Inprogress</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td> Problem of the page loading</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Balachander</td>

                      </tr>

                      </tbody>

                  </table><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div>
                  </div>
                  <div class="tab-pane" id="closed">
                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Tickets</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Subject</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Dept</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Priority</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Created On</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Created By</th>


                      </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        <td class="sorting_1">Closed</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td> Problem of the page loading</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Balachander</td>

                      </tr>
                    <tr role="row" class="even">
                           <td class="sorting_1">Closed</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">14545</a></td>
                        <td> Problem of the page loading</td>
                        <td>N/W Supprt</td>
                          <td>Urgent</td>
                         <td>16/04/2016</td>
                        <td>Murali</td>


                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Closed</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">12345</a></td>
                        <td> Issue on Live streaming</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>12/04/2016</td>
                        <td>Ramakrishnan</td>


                      </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">Closed</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td>Payment Issue</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Aravind</td>

                      </tr>


                      </tbody>

                  </table><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div>
                  </div><!-- /.tab-pane -->

                  <div class="tab-pane" id="woc">
             <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Tickets</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Subject</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Dept</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Priority</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Created On</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Created By</th>


                      </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        <td class="sorting_1">WOC</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td> Problem of the page loading</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Balachander</td>

                      </tr>
                            <tr role="row" class="odd">
                        <td class="sorting_1">WOC</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">12345</a></td>
                        <td> Issue on Live streaming</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>12/04/2016</td>
                        <td>Ramakrishnan</td>


                      </tr>
                    <tr role="row" class="even">
                           <td class="sorting_1">WOC</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">14545</a></td>
                        <td> Problem of the page loading</td>
                        <td>N/W Supprt</td>
                          <td>Urgent</td>
                         <td>16/04/2016</td>
                        <td>Murali</td>


                      </tr>

                    <tr role="row" class="odd">
                        <td class="sorting_1">WOC</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td>Payment Issue</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Aravind</td>

                      </tr>


                      </tbody>

                  </table><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div>
                  </div>
                  <div class="tab-pane" id="wotp">
                   <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Tickets</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Subject</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Dept</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Priority</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Created On</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Created By</th>


                      </tr>
                    </thead>
                    <tbody>
                         <tr role="row" class="even">
                           <td class="sorting_1">WOTP</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">14545</a></td>
                        <td> Problem of the page loading</td>
                        <td>N/W Supprt</td>
                          <td>Urgent</td>
                         <td>16/04/2016</td>
                        <td>Murali</td>


                      </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">WOTP</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td> Problem of the page loading</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Balachander</td>

                      </tr>
                            <tr role="row" class="odd">
                        <td class="sorting_1">WOTP</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">12345</a></td>
                        <td> Issue on Live streaming</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>12/04/2016</td>
                        <td>Ramakrishnan</td>


                      </tr>


                    <tr role="row" class="odd">
                        <td class="sorting_1">WOTP</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td>Payment Issue</td>
                        <td>Tech Support</td>
                          <td>Urgent</td>
                         <td>17/04/2016</td>
                        <td>Aravind</td>

                      </tr>


                      </tbody>

                  </table><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div>
                  </div><!-- /.tab-pane -->
<!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div>
                  <div class="row">
                  <div class="col-sm-12">
          </div>
                </div>
                </div>
                  </div>
                  </div>
                </div>
                  </div>

@endsection


