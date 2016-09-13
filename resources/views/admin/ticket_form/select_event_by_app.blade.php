<!--<div style="float:left;">
	Event
</div>-->
<div style="float:left;clear:both;"></div>
<select class="form-control" name="event" id="event">
	<option value="">Select Event</option>
	<?php
		if(!empty($eventdata)){
			foreach($eventdata as $eventval){
				$sel_event="";
				if((!empty($eventid)) && (!empty($eventval->eventId))){
					if($eventval->eventId == $eventid){
						$sel_event="selected";
					}
				}
	?>
			<option value="<?=(!empty($eventval->eventId)?$eventval->eventId:"")?>" <?=(!empty($sel_event)?$sel_event:"")?>><?=(!empty($eventval->eventName)?$eventval->eventName:"")?></option>
	<?php
			}
		}
	?>
</select>


