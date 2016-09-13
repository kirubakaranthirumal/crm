@extends('admin.layouts.master')
@section('content')
<script language="javascript">
	$(document).ready(function(){
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
				for(var i=0, ien=json.data.length; i<ien; i++){
					json.data[i][1] = '<a href="{{ asset('/admin/country_details/') }}'+'/'+''+json.data[i][0]+'">'+json.data[i][1]+'</a>';
				}
				
				for(var i=0, ien=json.data.length; i<ien; i++ ){
					json.data[i][0] = '<a href="{{ asset('/admin/country_details/') }}'+'/'+''+json.data[i][0]+'">'+json.data[i][0]+'</a>';
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
					<h3 class="box-title">Country</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="box box-primary">				
					</div><!-- /.box -->
					<div class="box-body">
						<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
							<div class="row">
								<div class="col-sm-">
								<div class="nav-tabs-custom">
										<ul class="nav nav-tabs tabs-dark">
											<li class="active"><a href="#" data-toggle="tab">Country</a></li>
										</ul>
								        <div class="tab-content">
								            <div class="active tab-pane" id="active_user">
								              <table id="data" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
								                    <thead>
														<tr role="row">
															<th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">ID</th>
															<th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Name</th>
															<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Short Name</th>														
															<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Flag</th>
															<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Created On</th>
														</tr>
								                      </thead>
								                      <tfoot>
								                          <tr>
															<th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">ID</th>
															<th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Name</th>
															<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Short Name</th>
															<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="From: activate to sort column ascending" style="width: 98px;">Flag</th>
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
															<th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">ID</th>
															<th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Name</th>
															<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Short Name</th>
															<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Flag</th>
															<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Created On</th>
								                      </thead>
								                      <tfoot>
														<tr>
															<th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">ID</th>
															<th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 160px;">Name</th>
															<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Tickets: activate to sort column ascending" style="width: 203px;">Short Name</th>
															<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 185px;">Flag</th>
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


