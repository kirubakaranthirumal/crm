@extends('admin.layouts.master')

@section('content')
		<script language="javascript">
			function load_ticket_count(id){

				var url_str = "assignedUserId="+id;

				$.ajax({
					type: "GET",
					url: "{{asset('load_dashboard_ticket_count')}}",
					data: url_str,
					success: function(data){
						$('#ticket_dash_count_div').html(data);
					}
				});
			}
		</script>
		<section class="content-header">

			<script language="javascript">
					load_ticket_count('');
					setInterval(function(){
						//code goes here that will be run every 5 seconds.
						load_ticket_count('');
					}, 5000);
            </script>
            <div id="ticket_dash_count_div"></div>
		</section><!-- right col -->

@endsection
