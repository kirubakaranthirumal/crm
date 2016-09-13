@extends('admin.layouts.master')

@section('content')
<div class="page page-tables-datatables">
<div class="pageheader">
	<h2>Email Template</h2>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#"><i class="fa fa-home"></i> CRM</a>
			</li>
			<li>
				<a href="#">Settings</a>
			</li>
			<li>
				<a href="#">E-Mail Template</a>
			</li>
			<li>
				<a href="#">Email Template</a>
			</li>
		</ul>
	</div>
	<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>

				 @if (session('templateDelSuc'))
					 <div class="col-md-12">
                <div class="flash-message">
                   <div class="alert alert-success">
                        Template Deleted Successfully
						<script>
							window.setTimeout(function(){window.location.href = "{{asset('/admin/list_template/')}}";}, 1000);
						</script>
                  </div>
                </div>
				</div>
              @endif
                @if (session('DeleteUserError'))
					<div class="col-md-12">
                  <div class="flash-message">
                     <div class="alert alert-danger">
                      Cannot Update ticket
                    </div>
                  </div>
				  </div>
                @endif
        <section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Email </strong>Template</h1>
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
              <table id="example1" class="table table-custom table-stribed dt-responsive">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th>Created On</th>
                  <th>Created By</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					//print"<pre>";
                	//print_r($email_template);
                ?>
                 @if(isset($email_template))
                 	@foreach ($email_template as $data)
                <tr>
                  <td>
                  		@if(isset($data['templateName']))
                  			{{ $data['templateName']}}
                  		 @endif
                  		</td>
                  <td>
                   @if(isset($data['templateDescription']))
					{{ $data['templateDescription']}}
                   @endif
                  </td>
					<!--<td>
						@if(isset($data['userType']))
							@if($data['userType']==1)
								Admin
							@elseif($data['userType']==2)
								Supervisor
							@elseif($data['userType']==3)
								Employee
							@endif
						@endif
					</td>-->
                  <td>
                  	@if(isset($data['templateStatus']))
						@if($data['templateStatus']==1)
						  Active
						@elseif($data['templateStatus']==2)
						  In-Active
						@endif
					  @endif
                  </td>
                  <td>
                  	@if(isset($data['templateCreatedOn']))
                  		{{ $data['templateCreatedOn'] }}
                  	@endif
                  </td>
                  <td>
					@if(isset($data['templateCreatedByFirstName']))
						{{ $data['templateCreatedByFirstName'] }}
					@endif
					@if(isset($data['templateCreatedByLastName']))
						{{ $data['templateCreatedByLastName'] }}
					@endif
                  </td>
                  <td>
                  	@if(isset($data['templateId']))
						&nbsp;
						<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-greensea" style="width:30px;" href="{{asset('/admin/edit_template/')}}/@if(isset($data['templateId']))
							{{ $data['templateId']}}
							@endif" title="edit">
							<i class="fa fa-pencil"></i>
						</a> &nbsp;&nbsp;
						<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-danger" style="width:30px;" href="{{asset('/admin/delete_template/')}}/@if(isset($data['templateId'])){{ $data['templateId']}} @endif" title="delete">
							<i class="fa fa-times"></i>
						</a> &nbsp;&nbsp;
						<!--<a href="{{asset('/admin/template_details/')}}/@if(isset($data['templateId']))
							{{ $data['templateId']}}
							@endif" title="user details"><i class="fa fa-user-secret"></i>
						</a>-->
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
			</section>
            <!-- /.box-body -->
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


