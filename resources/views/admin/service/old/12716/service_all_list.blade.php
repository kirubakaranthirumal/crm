@extends('admin.layouts.master')

@section('content')
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
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
  <div class="box">


                <div class="box-header">
                  <h3 class="box-title">ALL Service List</h3>
                </div><!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
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
                  	@if(isset($data->createdBy))
                  		   @if($data->createdBy==1)
						Admin
						@elseif($data->createdBy==2)
						Yeshwanth
						@else
						 Sathish
						@endif
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
								<a href="{{asset('/admin/service_edit/')}}/@if(isset($data->serviceId))
									{{ $data->serviceId}}
									@endif" title="edit">
									<i class="fa fa-edit"></i>
								</a> &nbsp;&nbsp;
								<a href="{{asset('/admin/service_delete/')}}/@if(isset($data->serviceId)){{ $data->serviceId}}@endif" title="delete">
									<i class="fa fa-remove"></i>
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
<script>
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
</script>
@endsection



