<?php
	//print"<pre>";
	//print_r($eventdata);
?>
<select class="form-control" name="event" id="event">
	<option value="">Select Event</option>
	<?php
		if(!empty($eventdata)){
		foreach($eventdata as $eventval){

			//print"<pre>";
			//print_r($eventval);
	?>

			<option value="<?=(!empty($eventval->eventId)?$eventval->eventId:"")?>"><?=(!empty($eventval->eventName)?$eventval->eventName:"")?></option>


	<?php
			}
		}
	?>
</select>


