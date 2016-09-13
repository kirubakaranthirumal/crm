<?php
	//print"<pre>";
	//print_r($userdata);
?>
<select class="form-control" name="employee" id="employee">
	<option value="">Select Employee Name</option>
	@foreach ($userdata as $data)
		@if((isset($data->email)) && (isset($data->email)))
			<option value="{{$data->email}}">{{$data->email}}</option>
		@endif
	@endforeach
</select>


