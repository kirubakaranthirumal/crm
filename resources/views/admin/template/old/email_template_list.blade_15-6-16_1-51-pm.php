@extends('admin.layouts.master')

@section('content')
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">

<div class="box box-primary">
					<div class="box-header with-border">
                  <h3 class="box-title">Email Template</h3>
                </div><!-- /.box-header -->
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
           <div class="box-body">
<!--<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Filter User</h3>
                </div>
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

                  </div>
                    </div>

                  </div>

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
                  </div>
                </form>
              </div>--><!-- /.box -->

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
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
						<a href="{{asset('/admin/delete_template/')}}/@if(isset($data['templateId'])){{ $data['templateId']}} @endif" title="delete">
							<i class="fa fa-remove"></i>
						</a> &nbsp;&nbsp;
						<a href="{{asset('/admin/edit_template/')}}/@if(isset($data['templateId']))
							{{ $data['templateId']}}
							@endif" title="edit">
							<i class="fa fa-edit"></i>
						</a> &nbsp;&nbsp;
						<a href="{{asset('/admin/template_details/')}}/@if(isset($data['templateId']))
							{{ $data['templateId']}}
							@endif" title="user details"><i class="fa fa-user-secret"></i>
						</a>
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


