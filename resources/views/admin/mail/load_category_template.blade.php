<?php
	//print"<pre>";
	//print_r($templatedata);
	//exit;
?>
<select class="form-control" name="template_name" id="template_name">
	<option value="">Select Template</option>
	@foreach ($templatedata as $data)
		@if((isset($data['templateId'])) && (isset($data['templateName'])))
			<option value="{{$data['templateId']}}">{{$data['templateName']}}</option>
		@endif
	@endforeach
</select>


