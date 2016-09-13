@extends('admin.layouts.master')

@section('content')
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
  <div class="box">
                <div class="box-header">
                  <h3 class="box-title">View Users</h3>
                </div><!-- /.box-header -->
           <div class="box-body">
<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Filter User</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Name or E-Mail</label>
                      <input type="text" class="form-control" placeholder="Filter By Name or E-Mail">
                    </div>
                    <div class="form-group">
                      <label>Gender</label>
					  <select class="form-control">
						<option>Select Gender</option>
						<option>Male</option>
						<option>Female</option>
					  </select>
                    </div>
                    </div>
                    <div class="col-md-6">
                           <div class="form-group">
                      		  <label>Type</label>
                              <select class="form-control">
                                  <option>Filter By Type</option>
                        <option>Admin</option>
                        <option>Employee</option>
                      </select>
                    </div>
                  <div class="form-group">
                      <label>Date</label>
                      <input type="text" class="form-control" placeholder="Filter By Created On Date">
                  </div>
                                <!-- <div class="form-group">
                  <label>Due By:</label>
                  <br>
                    <span>
                      &nbsp;&nbsp;<input type="checkbox">
                      Overdue
                    </span><br>

                     <span>
                      &nbsp;&nbsp;<input type="checkbox">
                      Today
                    </span><br>
                     <span>
                      &nbsp;&nbsp;<input type="checkbox">
                      Tomorrow
                    </span><br>
                     <span>
                      &nbsp;&nbsp;<input type="checkbox">
                      Next 8 hours
                    </span>

                  </div>-->
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
				<ul class="nav nav-tabs tabs-dark">
					<li class="active"><a href="#openticket" data-toggle="tab">Active Users (15)</a></li>
					<li><a href="#assigned" data-toggle="tab">In-Active Users (25)</a></li>
				</ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="openticket">
                    <!-- Post -->
                           <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Name</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">E-Mail</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Type</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Gender</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Last Logged</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Created On</th>
                      </tr>
                    </thead>
                    <tbody>
						<tr role="row" class="odd">
							<td class="sorting_1">Murali</td>
							<td><a href="{{ url(config('quickadmin.route').'/user_details') }}">murali@yahoo.com</a></td>
							<td>Admin</td>
							<td>Male</td>
							<td>12/04/2015</td>
							<td>12/04/2016</td>
						</tr>
						<tr role="row" class="even">
							<td class="sorting_1">Jayanthi</td>
							<td><a href="{{ url(config('quickadmin.route').'/user_details') }}">jayanthi@gmail.com</a></td>
							<td>Employee</td>
							<td>Female</td>
							<td>12/04/2013</td>
							<td>12/04/2016</td>
						</tr>
                      </tbody>
                  </table>
                  <div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="assigned">
                  <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Name</th>
					                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">E-Mail</th>
					                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Type</th>
					                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Gender</th>
					                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Last Logged</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Created On</th>
                      </tr>
                    </thead>
                    <tbody>
						    <tr role="row" class="odd">
              <td class="sorting_1">Murali</td>
              <td><a href="{{ url(config('quickadmin.route').'/user_details') }}">murali@yahoo.com</a></td>
              <td>Admin</td>
              <td>Male</td>
              <td>12/04/2015</td>
              <td>12/04/2016</td>
            </tr>
            <tr role="row" class="even">
              <td class="sorting_1">Sudha</td>
              <td><a href="{{ url(config('quickadmin.route').'/user_details') }}">sudha@gmail.com</a></td>
              <td>Employee</td>
              <td>Female</td>
              <td>12/04/2012</td>
              <td>12/04/2016</td>
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
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Date</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Subject</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Dept</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">From</th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Priority</th>

                      </tr>
                    </thead>
                    <tbody>
                  <tr role="row" class="even">
                           <td class="sorting_1">Open</td>
                         <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">45645</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John Anderson</td>
                        <td>Urgent</td>

                      </tr><tr role="row" class="odd">
                        <td class="sorting_1">Open</td>
                         <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">89789</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John Anderson</td>
                        <td>Urgent</td>
                      </tr><tr role="row" class="even">
                        <td class="sorting_1">Open</td>
                         <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">654645</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John Anderson</td>

                        <td>Urgent</td>

                      </tr><tr role="row" class="odd">
                           <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">876786</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John Anderson</td>

                        <td>Urgent</td>

                      </tbody>

                  </table><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div>
                  </div>
                  <div class="tab-pane" id="closed">
                   <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Tickets</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Date</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Subject</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Dept</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">From</th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Priority</th>

                      </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">12345</a></td>
                        <td>12/04/2016</td>
                        <td> Content ....</td>
                        <td>Payment</td>
                        <td>Anderson</td>
                        <td>Urgent</td>

                      </tr><tr role="row" class="even">
                           <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">14545</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John</td>
                        <td>Urgent</td>

                      </tr><tr role="row" class="even">
                        <td class="sorting_1">Open</td>
                         <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">654645</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John Anderson</td>

                        <td>Urgent</td>

                      </tr><tr role="row" class="odd">
                           <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">876786</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John Anderson</td>

                        <td>Urgent</td>

                      </tbody>

                  </table><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div>
                  </div><!-- /.tab-pane -->

                  <div class="tab-pane" id="woc">
              <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Tickets</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Date</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Subject</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Dept</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">From</th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Priority</th>

                      </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">12345</a></td>
                        <td>12/04/2016</td>
                        <td> Content ....</td>
                        <td>Payment</td>
                        <td>Anderson</td>
                        <td>Urgent</td>

                      </tr><tr role="row" class="even">
                        <td class="sorting_1">Open</td>
                         <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">654645</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John Anderson</td>

                        <td>Urgent</td>

                      </tr><tr role="row" class="odd">
                           <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">876786</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John Anderson</td>

                        <td>Urgent</td>

                      </tbody>

                  </table><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div>
                  </div>
                  <div class="tab-pane" id="wotp">
                   <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Tickets</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Date</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Subject</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Dept</th>
                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">From</th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Priority</th>

                      </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">12345</a></td>
                        <td>12/04/2016</td>
                        <td> Content ....</td>
                        <td>Payment</td>
                        <td>Anderson</td>
                        <td>Urgent</td>

                      </tr><tr role="row" class="even">
                           <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">14545</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John</td>
                        <td>Urgent</td>

                      </tr><tr role="row" class="odd">
                        <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">789542</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>Smith</td>

                        <td>Urgent</td>

                      </tr><tr role="row" class="even">
                           <td class="sorting_1">Open</td>
                         <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">45645</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John Anderson</td>
                        <td>Urgent</td>

                      </tr><tr role="row" class="odd">
                        <td class="sorting_1">Open</td>
                         <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">89789</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John Anderson</td>
                        <td>Urgent</td>
                      </tr><tr role="row" class="even">
                        <td class="sorting_1">Open</td>
                         <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">654645</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John Anderson</td>

                        <td>Urgent</td>

                      </tr><tr role="row" class="odd">
                           <td class="sorting_1">Open</td>
                        <td><a href="{{ url(config('quickadmin.route').'/ticket_details') }}">876786</a></td>
                        <td>12/04/2016</td>
                         <td> Content ....</td>
                        <td>Payment</td>
                        <td>John Anderson</td>

                        <td>Urgent</td>

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


