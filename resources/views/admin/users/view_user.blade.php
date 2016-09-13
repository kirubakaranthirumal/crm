@extends('admin.layouts.master')

@section('content')

<script>
$(document).ready(function() {
   load_data_table();
	/*$('#in-active').click(function() {
		$('#user_inactive').DataTable( {
			"processing": true,
			"serverSide": true
			"ajax": "{{ asset('/scripts/server_processing.php') }}"
		} );
	});
	*/
});

function load_data_table(){
	$('#data').DataTable( {
	"processing": true,
	"serverSide": true,
	"Filter": false,
	"ajax":{
	"url": "{{ asset('/scripts/server_processing.php') }}",
		"dataSrc": function (json) {
			for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
				//json.data[i][2] = '<a href="{{ asset('/admin/user_details/') }}"'+json.data[i][2]+'>'+json.data[i][2]+'</a>';

				json.data[i][1] = '<a href="{{ asset('/admin/user_details/') }}'+'/'+''+json.data[i][0]+'">'+json.data[i][1]+'</a>';

			}
				for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
							//json.data[i][2] = '<a href="{{ asset('/admin/user_details/') }}"'+json.data[i][2]+'>'+json.data[i][2]+'</a>';

							json.data[i][0] = '<a href="{{ asset('/admin/user_details/') }}'+'/'+''+json.data[i][0]+'">'+json.data[i][0]+'</a>';

			}

			return json.data;
		}
	}
  });
}
</script>
<style>
	.dataTables_filter,
	.dataTables_info{
		display: none;
	}
</style>
<section class="content">
	<div class="row">
		<!-- left column -->
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Users</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="box box-primary">
						<!-- <div class="box-header with-border">
							<h3 class="box-title">Filter User</h3>
						</div>
						-->
						<!-- /.box-header -->
						<!-- form start -->
						<!--
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
								</div>
							</div>
							<div class="box-footer">
								<button type="submit" class="btn btn-primary">Filter</button>
								<button type="reset" class="btn btn-primary">Reset</button>
							</div>
						</form>
						-->
					</div><!-- /.box -->
					<div class="box-body">
						<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
							<div class="row">
								<div class="col-sm-">
								<div class="nav-tabs-custom">
										<ul class="nav nav-tabs tabs-dark">
										  <li class="active"><a href="#" data-toggle="tab"> Admin Users</a></li>
										</ul>
								        <!--<ul class="nav nav-tabs tabs-dark">
								          <li class="active"><a href="#active_user" data-toggle="tab">Active Users (15)</a></li>
								          <li><a href="#Inactive"  id="in-active" data-toggle="tab">In-Active Users (25)</a></li>
								        </ul>-->
								                <div class="tab-content">

								                              <div class="active tab-pane" id="active_user">
								              <table id="data" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
								                    <thead>
								                      <tr role="row">
								                      			                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">ID</th>
								                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Name</th>
								                                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">E-Mail</th>

								                                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Last Logged</th>
								                       <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Created On</th>
								                      </tr>

								                      </thead>
								                      <tfoot>
								                          <tr>
								                          			                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">ID</th>
								                           <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Name</th>
								                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">E-mail</th>
								                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Last Logged</th>
								                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Created On</th>
								                          </tr>
								                      </tfoot>
								                  </table>
								                  </div>
								            <!-- /.tab-pane -->
								                  <div class="tab-pane" id="Inactive">
								                    <table id="user_inactive" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
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
								                      <tfoot>
								                          <tr>
								                           <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Name</th>
								                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">E-mail</th>
								                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Type</th>
								                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Gender</th>
								                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Last Logged</th>
								                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Created On</th>
								                          </tr>
								                      </tfoot>
								                  </table>
								                  </div>
								                  </div><!-- /.tab-pane -->
								<!-- /.tab-pane -->
								                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->




								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection


