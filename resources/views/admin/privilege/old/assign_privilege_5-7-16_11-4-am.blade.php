@extends('admin.layouts.master')
@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script language="javascript">
		(function($,W,D){
			var JQUERY4U = {};

			$.validator.addMethod(
				  "notEqualTo",
				  function(elementValue,element,param) {
					return elementValue != param;
				  },
				  "Value cannot be {0}"
			);

			JQUERY4U.UTIL =
			{
				setupFormValidation: function()
				{
					//form validation rules
					$("#ticket-form").validate({
						rules: {
							app_name: "required",
							status: {
								required: true,
								notEqualTo: 20
							},
							description: "required"
						},
						messages: {
							app_name: "Please enter your App name",
							status: "Please select status",
							description: "Please enter description"
						},
						submitHandler: function(form){
							form.submit();
						}
					});
				}
			}
			//when the dom has loaded setup form validation rules
			$(D).ready(function($) {
				JQUERY4U.UTIL.setupFormValidation();
			});

		})(jQuery, window, document);
	</script>
<style>
	#register-form label.error{
	    color: #FB3A3A;
	    display: inline-block;
	    //margin: 4px 0 5px 125px;
	    padding: 0;
	    text-align: left;
	    width: 250px;
	}

	.form-control{
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
		color: #555;
		display: block;
		font-size: 14px;
		height: 34px;
		line-height: 1.42857;
		padding: 6px 12px;
		transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
		width: 96%;
	}

.rTable {
display: table;
}
.rTableRow {
display: table-row;
 }
 .rTableHeading {
	 display: table-header-group;
}
.rTableBody {
display: table-row-group;
 }
 .rTableFoot {
 display: table-footer-group;
 }
 .rTableCell, .rTableHead {
	 display: table-cell;
	 }

.rTable {
	  display: table;
	  width: 100%;
	  }
.rTableRow {
 	display: table-row;
	}
	.rTableHeading {
  	display: table-header-group;
 	background-color: #ddd;
	}
	.rTableHead {
			background-color: #3c8dbc;
			color:#fff;
	}
	.rTableCell, .rTableHead {
  	display: table-cell;
	border:1px solid lightgrey;

 	padding: 3px 10px;
	text-align:center;
	}
	.rTableHeading {
 	display: table-header-group;
 	background-color: #ddd;
	font-weight: bold;
	}
	.rTableFoot {
  	display: table-footer-group;
 	font-weight: bold;
 	background-color: #ddd;
	}
	.rTableBody {
  	display: table-row-group;
	background-color: #ddd;
	}

</style>
    <section class="content">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				@if (session('AssignUpdateSuccess'))
					<div class="flash-message">
						 <div class="alert alert-success">
							Privilege updated successfully
							<script>
								window.setTimeout(function(){window.location.href = "{{asset('/admin/user_privileges/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif
				@if (session('AssignUpdateError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							Unable to update Assign
						</div>
					</div>
				@endif
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Assign Privilege</h3>

					</div><!-- /.box-header -->
					<div class="box-body">
						<!-- form start -->
						 @if(isset($userdata))
				<form action="" method="PUT" id="privilege-form" class="form-horizontal" novalidate="novalidate">
			                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
					      <div class="rTable">
						  <div class="rTableRow">
						  <div class="rTableHead"><strong>Privilege Category</strong></div>
						  <div class="rTableHead"><span style="font-weight: bold;">Create</span></div>
						   <div class="rTableHead"><span style="font-weight: bold;">Edit</span></div>
						    <div class="rTableHead"><span style="font-weight: bold;">Delete</span></div>
							 <div class="rTableHead"><span style="font-weight: bold;">View</span></div>
						  </div>
						  <div class="rTableRow">
						  <div class="rTableCell"><strong>App</strong></div>

						  @if(isset($userdata->appCreate))
								@if($userdata->appCreate==1)
									<div class="rTableCell"><input type="checkbox" title="App Create" name="app_create" value="1" checked /></div>
								@elseif($userdata->appCreate==0)
								<div class="rTableCell"><input type="checkbox"  title="App Create" name="app_create" value="1" ></div>
								@endif
							@endif
								  @if(isset($userdata->appEdit))
								@if($userdata->appEdit==1)
								<div class="rTableCell"> <input type="checkbox" title="App Edit"  name="app_edit" value="1" checked /></div>
							@elseif($userdata->appEdit==0)
							<div class="rTableCell"> <input type="checkbox" title="App Edit"  name="app_edit" value="1" /></div>
							@endif
							@endif
							 @if(isset($userdata->appDelete))
								@if($userdata->appDelete==1)
								<div class="rTableCell"><input type="checkbox" title="App Delete" name="app_delete" value="1" checked /></div>
							@elseif($userdata->appDelete==0)
							<div class="rTableCell"><input type="checkbox" title="App Delete" name="app_delete" value="1"/></div>
							@endif
							@endif
							 @if(isset($userdata->appView))
								@if($userdata->appView==1)
								<div class="rTableCell"><input type="checkbox" title="App View"name="app_view" value="1" checked /></div>
							@elseif($userdata->appView==0)
							<div class="rTableCell"><input type="checkbox" title="App View"name="app_view" value="1"/></div>
							@endif
							@endif
						  </div>
						  <div class="rTableRow">
						  <div class="rTableCell"><strong>Event</strong></div>
						   @if(isset($userdata->eventCreate))
								@if($userdata->eventCreate==1)
							   <div class="rTableCell"><input type="checkbox" title="Event Create" name="evt_create" value="1" checked /></div>
						   @elseif($userdata->eventCreate==0)
								  <div class="rTableCell"><input type="checkbox" title="Event Create" name="evt_create" value="1"/></div>
						   @endif
							@endif
							@if(isset($userdata->eventEdit))
								@if($userdata->eventEdit==1)
							   <div class="rTableCell"><input type="checkbox" title="Event Edit"  name="evt_edit" value="1" checked /></div>
						   @elseif($userdata->eventEdit==0)
						   <div class="rTableCell"><input type="checkbox" title="Event Edit"  name="evt_edit" value="1" /></div>
						     @endif
							@endif
							@if(isset($userdata->eventDelete))
								@if($userdata->eventDelete==1)
								<div class="rTableCell"><input type="checkbox" title="Event Delete"  name="evt_delete" value="1" checked /></div>
							 @elseif($userdata->eventDelete==0)
							 <div class="rTableCell"><input type="checkbox" title="Event Delete"  name="evt_delete" value="1"/></div>
							 @endif
							@endif
								@if(isset($userdata->eventView))
								@if($userdata->eventView==1)
							   <div class="rTableCell"><input type="checkbox" title="Event View"name="evt_view" value="1" checked /></div>
						    @elseif($userdata->eventView==0)
							<div class="rTableCell"><input type="checkbox" title="Event View"name="evt_view" value="1"/></div>
							 @endif
							@endif

						  </div>
						    <div class="rTableRow">
							<div class="rTableCell"><strong>Service</strong></div>
							@if(isset($userdata->serviceCreate))
								@if($userdata->serviceCreate==1)
							   <div class="rTableCell"><input type="checkbox" title="Service Create" name="ser_create" value="1" checked /></div>
						   @elseif($userdata->serviceCreate==0)
						      <div class="rTableCell"><input type="checkbox" title="Service Create" name="ser_create" value="1"/></div>
						    @endif
							@endif
							@if(isset($userdata->serviceEdit))
								@if($userdata->serviceEdit==1)
						       <div class="rTableCell"><input type="checkbox" title="Service Edit"  name="ser_edit" value="1" checked /></div>
						    @elseif($userdata->serviceEdit==0)
							 <div class="rTableCell"><input type="checkbox" title="Service Edit"  name="ser_edit" value="1"/></div>
							  @endif
							@endif
							@if(isset($userdata->serviceDelete))
								@if($userdata->serviceDelete==1)
						       <div class="rTableCell"><input type="checkbox" title="Service Delete" name="ser_delete" value="1" checked /></div>
						    @elseif($userdata->serviceDelete==0)
							<div class="rTableCell"><input type="checkbox" title="Service Delete" name="ser_delete" value="1"/></div>
							 @endif
							@endif
								@if(isset($userdata->serviceView))
								@if($userdata->serviceView==1)
						       <div class="rTableCell"><input type="checkbox" title="Service View"name="ser_view" value="1" checked /></div>
								@elseif($userdata->serviceView==0)
								 <div class="rTableCell"><input type="checkbox" title="Service View"name="ser_view" value="1"/></div>
								  @endif
							@endif
						  </div>
						    <div class="rTableRow">
						  <div class="rTableCell"><strong>User</strong></div>
						  @if(isset($userdata->userCreate))
								@if($userdata->userCreate==1)
						       <div class="rTableCell"><input type="checkbox" title="User Create" name="usr_create" value="1" checked /> </div>
					     	   @elseif($userdata->userCreate==0)
							       <div class="rTableCell"><input type="checkbox" title="User Create" name="usr_create" value="1"/> </div>
								@endif
							@endif
							 @if(isset($userdata->userEdit))
								@if($userdata->userEdit==1)
						       <div class="rTableCell"><input type="checkbox" title="User Edit"  name="usr_edit" value="1" checked /></div>
						       @elseif($userdata->userEdit==0)
							   <div class="rTableCell"><input type="checkbox" title="User Edit"  name="usr_edit" value="1"/></div>
							   @endif
							@endif
							@if(isset($userdata->userDelete))
								@if($userdata->userDelete==1)
						       <div class="rTableCell"><input type="checkbox" title="User Delete" name="usr_delete" value="1" checked /></div>
						   @elseif($userdata->userDelete==0)
						    <div class="rTableCell"><input type="checkbox" title="User Delete" name="usr_delete" value="1"/></div>
						   @endif
							@endif
							@if(isset($userdata->userView))
								@if($userdata->userView==1)
						       <div class="rTableCell"><input type="checkbox" title="User View"name="usr_view" value="1" checked /></div>
						    @elseif($userdata->userView==0)
							 <div class="rTableCell"><input type="checkbox" title="User View"name="usr_view" value="1"/></div>
							 @endif
							@endif
						  </div>
						    <div class="rTableRow">
						  <div class="rTableCell"><strong>Tickets</strong></div>
						  @if(isset($userdata->ticketCreate))
								@if($userdata->ticketCreate==1)
					           <div class="rTableCell"><input type="checkbox" title="Ticket Create" name="tk_create" value="1" checked />  </div>
						    @elseif($userdata->ticketCreate==0)
							  <div class="rTableCell"><input type="checkbox" title="Ticket Create" name="tk_create" value="1"/>  </div>
							   @endif
							@endif
							  @if(isset($userdata->ticketEdit))
								@if($userdata->ticketEdit==1)
						       <div class="rTableCell"><input type="checkbox" title="Ticket Edit"  name="tk_edit" value="1" checked /></div>
						        @elseif($userdata->ticketEdit==0)
								 <div class="rTableCell"><input type="checkbox" title="Ticket Edit"  name="tk_edit" value="1"/></div>
								 @endif
							@endif
							  @if(isset($userdata->ticketDelete))
								@if($userdata->ticketDelete==1)
						       <div class="rTableCell"><input type="checkbox" title="Ticket Delete" name="tk_delete" value="1" checked /></div>
						    @elseif($userdata->ticketDelete==0)
							<div class="rTableCell"><input type="checkbox" title="Ticket Delete" name="tk_delete" value="1"/></div>
								 @endif
							@endif
							  @if(isset($userdata->ticketView))
								@if($userdata->ticketView==1)
						       <div class="rTableCell"><input type="checkbox" title="Ticket View" name="tk_view" value="1" checked /></div>
							@elseif($userdata->ticketView==0)
                            <div class="rTableCell"><input type="checkbox" title="Ticket View" name="tk_view" value="1"/></div>
							@endif
							@endif
							@endif
						  </div>
						  </div>
							<div class="box-footer">
								<center><input type="submit" name="submit" value="Assign Privilege" class="btn btn-primary">
								<a href="{{asset('/admin/user_privileges/')}}" title="Cancel" class="btn btn-primary">
																	Cancel
								</a>
								</center>
								&nbsp;

							</div>
						  </form>
					<div style="clear:both">&nbsp;</div>
				</div>
			</div>
		</div>
	</div>
</section>
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
   $(document).ready(function(){
      $("#input_name").hide();
		$("#input_email").hide();
		$("#name").click(function(){
		  $("#input_name").show();
		  $("#input_email").hide();
		});
		$("#email").click(function(){
		  $("#input_email").show();
		  $("#input_name").hide();
		});
							});
    </script>
@endsection


