@extends('admin.layouts.master')

@section('content')
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
			 @if (session('DeleteAppSuccess'))
                <div class="flash-message">
                   <div class="alert alert-success">
                        App Disable Successfully
              <script>
              window.setTimeout(function(){
				window.location.href = "{{asset('/admin/list_app/')}}";
               }, 1000);
             </script>
                  </div>
                </div>
              @endif
                @if (session('DeleteAppError'))
                  <div class="flash-message">
                     <div class="alert alert-danger">
                      Unable To Disable App
                    </div>
                  </div>
                @endif
  <div class="box">


                <div class="box-header">
                  <h3 class="box-title">App List</h3>
                </div><!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>App Name</th>
                  <!--<th>Description</th>-->
                  <th>Status</th>
                  <th>Created By</th>
                  <th>Create On</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                 @if(isset($appdata))
                 	@foreach ($appdata as $data)
                <tr>
                  <td>
                  		@if(isset($data->appName))
                  			{{ $data->appName}}
                  		 @endif
                  		</td>
                  <!--<td>
                   @if(isset($data->appDesc))
					{{ $data->appDesc}}
                   @endif
                  </td>-->
				      <td>
                   @if(isset($data->appStatus))
					   @if($data->appStatus==1)
						<span style="color:green;">Active</span>
						@elseif($data->appStatus==2)
						<span style="color:red;">In-Active</span>
						@endif
                   @endif
                  </td>
				   <td>

				   	<?php
						//print"<pre>";
				   		//print_r($data);
				   	?>

                  	@if(isset($data->createdBy))
					   @if($data->createdBy==1)
							Admin
						@elseif($data->createdBy==2)
							Yeshwanth
						@endif
                  	@endif
                  </td>
                  <td>
                  	@if(isset($data->creationDate))
                  		{{ $data->creationDate }}
                  	@endif
                  </td>
                  <td>
					<?php
						$app_edit_show = $app_delete_show = $event_list_show = "";

						$event_list_show = session()->get('eventView');
						$app_edit_show = session()->get('appEdit');
						$app_delete_show = session()->get('appDelete');

						$usertype = session()->get('userType');
						//echo $usertype;
					?>
                  	@if(isset($data->appId))
						<?php
							if((!empty($usertype)) && ($usertype==1)){
						?>
							<a href="{{asset('/admin/event_list/')}}/@if(isset($data->appId))
								{{ $data->appId}}
								@endif" title="Event List"><i class="fa fa-user-secret"></i>
							</a>&nbsp;&nbsp;
							<a href="{{asset('/admin/edit_app/')}}/@if(isset($data->appId))
								{{ $data->appId}}
								@endif" title="edit">
								<i class="fa fa-edit"></i>
							</a> &nbsp;&nbsp;
							<a href="{{asset('admin/list_app/')}}/@if(isset($data->appId)){{ $data->appId}} @endif" title="">
								<i class="fa fa-remove"></i>
							</a>

						<?php
							}
							else{
						?>
							<?php
								if(!empty($event_list_show)){
							?>
									<a href="{{asset('/admin/event_list/')}}/@if(isset($data->appId))
										{{ $data->appId}}
										@endif" title="Event List"><i class="fa fa-user-secret"></i>
									</a>&nbsp;&nbsp;
							<?php
								}
							?>

							<?php
								if(!empty($app_edit_show)){
							?>
									<a href="{{asset('/admin/edit_app/')}}/@if(isset($data->appId))
										{{ $data->appId}}
										@endif" title="edit">
										<i class="fa fa-edit"></i>
									</a> &nbsp;&nbsp;
							<?php
								}
							?>

							<?php
								if(!empty($app_delete_show)){
							?>
									<a href="{{asset('admin/list_app/')}}/@if(isset($data->appId)){{ $data->appId}} @endif" title="">
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



