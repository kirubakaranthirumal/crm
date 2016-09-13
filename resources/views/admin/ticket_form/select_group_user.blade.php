<select class="form-control" name="employee" id="employee">
	<option value="">Select Employee Name</option>
	@foreach ($userdata as $data)
		@if((isset($data->userId)) && (isset($data->firstName)))
			<option @if($data->userId == $userid) selected @endif value="{{$data->userId}}">{{$data->firstName}}</option>
		@endif
	@endforeach
</select>