@extends('admin.layouts.master')

@section('content')
<div class="page page-tables-datatables">
<div class="pageheader">
	<h2>ALL Service List</h2>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#"><i class="fa fa-home"></i> CRM</a>
			</li>
			<li>
				<a href="#">App Event Service</a>
			</li>
			<li>
				<a href="#">Service</a>
			</li>
			<li>
				<a href="#">ALL Service List</a>
			</li>
		</ul>
	</div>
	<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>
			 @if (session('DeleteServiceSuccess'))
                <div class="flash-message">
                   <div class="alert alert-success">
                        Service has been Disable Sbuccessfully
							<?php
							$page_event_id="";
							if(!empty($event_id)){
								$page_event_id = $event_id;
							}
						?>
              <script>
              window.setTimeout(function(){
				 window.setTimeout(function(){window.location.href = "{{asset('/admin/service_all_list/')}}";}, 1000);
               }, 1000);
             </script>
                  </div>
                </div>
              @endif
                @if (session('DeleteServiceError'))
                  <div class="flash-message">
                     <div class="alert alert-danger">
                      Unable To Disable Service
                    </div>
                  </div>
                @endif
  <!-- tile -->
	<section class="tile">

		<!-- tile header -->
		<div class="tile-header dvd dvd-btm">
			<h1 class="custom-font"><strong>ALL</strong> Service List</h1>
			<ul class="controls">
				<li class="dropdown">
					<a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
						<i class="fa fa-cog"></i>
						<i class="fa fa-spinner fa-spin"></i>
					</a>

					<ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
						<li>
							<a role="button" tabindex="0" class="tile-toggle">
								<span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span>
								<span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span>
							</a>
						</li>
						<li>
							<a role="button" tabindex="0" class="tile-refresh">
								<i class="fa fa-refresh"></i> Refresh
							</a>
						</li>
						<li>
							<a role="button" tabindex="0" class="tile-fullscreen">
								<i class="fa fa-expand"></i> Fullscreen
							</a>
						</li>
					</ul>

				</li>
				<li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
			</ul>
		</div>
		<!-- /tile header -->

		<!-- tile body -->
		<div class="tile-body">
			<div class="table-responsive">
			             
              <table id="example1" class="table table-custom table-striped">
                <thead>
                <tr>
                  <th>Service Name</th>
                  <!--<th>Description</th>-->
                  <th>Status</th>
                  <th>Created By</th>
                  <th>Create On</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php
					//print"<pre>";
					//print_r($servicedata);
					//exit;
				?>
                 @if(isset($servicelist))
                 	@foreach ($servicelist as $data)
                <tr>
                  <td>
                  		@if(isset($data->serviceName))
                  			{{ $data->serviceName}}
                  		 @endif
                  		</td>
                  <!--<td>
                   @if(isset($data->description))
					{{ $data->description}}
                   @endif
                  </td>-->
				      <td>

				      <?php
						//print"<pre>";
						//print_r($data);
						//exit;
				      ?>

                   @if(isset($data->serviceStatus))
					   @if($data->serviceStatus==1)
						<span style="color:green;">Active</span>
						@elseif($data->serviceStatus==2)
						<span style="color:red;">In-Active</span>
						@else
						<span style="color:red;">In-Active</span>
						@endif
                   @endif
                  </td>
				   <td>
                  	@if(isset($data->firstName))
						{{$data->firstName}}
					@else
						-
					@endif
                  </td>
                  <td>
                  	@if(isset($data->createdOn))
                  		{{ $data->createdOn }}
                  	@endif
                  </td>
                  <td>
					<?php
						$service_edit_show = $service_delete_show = "";

						$service_edit_show = session()->get('serviceEdit');
						$service_delete_show = session()->get('serviceDelete');

						$usertype = session()->get('userType');
						//echo $usertype;
					?>
					@if(isset($data->serviceId))

						<?php
							if((!empty($usertype)) && ($usertype==1)){
						?>
								<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-greensea" style="width:30px;" href="{{asset('/admin/service_edit/')}}/@if(isset($data->serviceId))
									{{ $data->serviceId}}
									@endif" title="edit">
									<i class="fa fa-pencil"></i>
								</a> &nbsp;&nbsp;
								<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-danger" style="width:30px;" href="{{asset('/admin/service_delete/')}}/@if(isset($data->serviceId)){{ $data->serviceId}}@endif" title="delete">
									<i class="fa fa-times"></i>
								</a>
						<?php
							}
							else{
						?>
								<?php
									if(!empty($service_edit_show)){
								?>
										<a href="{{asset('/admin/service_edit/')}}/@if(isset($data->serviceId))
											{{ $data->serviceId}}
											@endif" title="edit">
											<i class="fa fa-edit"></i>
										</a> &nbsp;&nbsp;
								<?php
									}
								?>
								<?php
									if(!empty($service_delete_show)){
								?>
										<a href="{{asset('/admin/service_delete/')}}/@if(isset($data->serviceId)){{ $data->serviceId}}@endif" title="delete">
											<i class="fa fa-remove"></i>
										</a>
								<?php
									}
								?>
						<?php
							}
						?>
					@endif
                   </td>
				</tr>
                	@endforeach
                @endif
                </tbody>
                <!--<tfoot>
                  <tr>
                  <th>Name</th>
                  <th>E-mail</th>
                  <th>Type</th>
                  <th>Gender</th>
                  <th>Last Logged</th>
                  <th>Created On</th>
				  <th>Action</th>
                </tr>
                </tfoot>-->
              </table>
            </div>
            <!-- /.box-body -->
		</div>
	</div>
        </section>
			<script language="javascript">

			$(function(){
				$('#example1').DataTable( {
					"aaSorting": [[ 3, "desc" ]],
					"aoColumnDefs" : [{
					'bSortable' : false,
						'aTargets' : [ 4 ]
					}]
				});
			});

			/*
			  $(function () {
				$("#example1").DataTable();
				$('#example2').DataTable({
				  "paging": true,
				  "lengthChange": false,
				  "searching": false,
				  "ordering": true,
				  "info": true,
				  "autoWidth": false
				});
			  });
			  */
			</script>
@endsection



