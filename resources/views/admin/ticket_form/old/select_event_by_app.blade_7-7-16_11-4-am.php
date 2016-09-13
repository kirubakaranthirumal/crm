<?php
	//print"<pre>";
	//print_r($eventdata);

	//echo $eventid;
?>
<select class="form-control" name="event" id="event">
	<option value="">Select Event</option>
	<?php
		if(!empty($eventdata)){
		foreach($eventdata as $eventval){

			//print"<pre>";
			//print_r($eventval);

			$sel_event="";
			if((!empty($eventid)) && (!empty($eventval->eventId))){
				$sel_event="selected";
			}
	?>

			<option value="<?=(!empty($eventval->eventId)?$eventval->eventId:"")?>" <?=(!empty($sel_event)?$sel_event:"")?>><?=(!empty($eventval->eventName)?$eventval->eventName:"")?></option>


	<?php
			}
		}
	?>
</select>


