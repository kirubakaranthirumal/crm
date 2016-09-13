@extends('admin.layouts.master')
@section('content')
<div class="page page-tables-datatables">
	<div class="pageheader">
		<h2>Country</h2>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="#"><i class="fa fa-home"></i> CRM</a>
				</li>
				<li>
					<a href="#">Subsricption Management</a>
				</li>
				<li>
					<a href="#">Team</a>
				</li>
			</ul>
		</div>
		<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
	</div>
	@if (session('DeleteCountrySuccess'))
		<div class="col-md-12">
			<div class="flash-message">
				<div class="alert alert-success">
					{{session('DeleteCountrySuccess')}}
					<script language="javascript">
						window.setTimeout(function(){window.location.href = "{{asset('/admin/view_country/')}}";}, 1000);
					</script>
				</div>
			</div>
		</div>
	@endif
	@if (session('DeleteCountryError'))
		<div class="col-md-12">
			<div class="flash-message">
				<div class="alert alert-danger">
					{{session('DeleteCountrySuccess')}}
				</div>
			</div>
		</div>
	@endif
	<div style="clear:both;"></div>
        <!-- tile -->
		<section class="tile">
			<!-- tile header -->
			<div class="tile-header dvd dvd-btm">
				<h1 class="custom-font"><strong>Country</strong></h1>
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
                <thead class="thead-inverse">
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Short Name</th>
                  <th>Code</th>
                  <th>Flag</th>
                  <th>Created On</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
					<?php
						//print"<pre>";
						//print_r($countrydata);
					?>
                 @if(isset($countrydata))
                 	@foreach ($countrydata as $data)
                <tr>
					<td>
						@if(isset($data->countryId))
							{{$data->countryId}}
						@endif
					</td>
					<td>
						@if(isset($data->countryName))
							{{$data->countryName}}
						@endif
					</td>
					<td>
						@if(isset($data->StortName))
							{{ $data->StortName}}
						@endif
					</td>
					<td>
						@if(isset($data->countryCode))
							{{ $data->countryCode}}
						@endif
					</td>
					<td>
						@if(isset($data->countryFlags))
							{{ $data->countryFlags}}
						@endif
					</td>
					<td>
						@if(isset($data->createdOn))
							{{ $data->createdOn }}
						@endif
					</td>
                  <td style="width:160px;">
                  	@if(isset($data->countryId))
						<a class="btn btn-rounded-20 btn-default btn-sm bg-primary" style="width:30px;" href="{{asset('/admin/country_details/')}}/@if(isset($data->countryId))
							{{ $data->countryId}}
							@endif" title="View user details"><i class="fa fa-eye" style="margin-left: -2px;"></i>
						</a>
						<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-greensea" style="width:30px;" href="{{asset('/admin/edit_country/')}}/@if(isset($data->countryId))
							{{ $data->countryId}}
							@endif" title="edit">
							<i class="fa fa-pencil"></i>
						</a>							
						<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-danger" style="width:30px;" href="{{asset('/admin/view_country/')}}/@if(isset($data->countryId)){{ $data->countryId}} @endif" title="delete">
							<i class="fa fa-times"></i>
						</a>						
					@endif
                   </td>
                </tr>
                	@endforeach
                @endif
                </tbody>
                
              </table>
            </div>
			</div>
            <!-- /.box-body -->
			</section>
			</div>
<script>

	$(function(){
		$('#example1').DataTable( {
			"aaSorting": [[ 0, "desc" ]],
			"aoColumnDefs" : [{
		   		'bSortable' : false,
		   		'aTargets' : [ 6 ]
		 	}]
    	});
   });

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


