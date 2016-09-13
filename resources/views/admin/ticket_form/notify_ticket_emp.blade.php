<!--<a href class="dropdown-toggle" data-toggle="dropdown">
	<i class="fa fa-bell"></i>
	<span class="badge bg-lightred"><?=(!empty($new_ticket_count)?$new_ticket_count:"0")?></span>
</a>
-->



	<a href class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-envelope"></i>
		<span class="badge bg-lightred"><?=(!empty($new_ticket_count)?$new_ticket_count:"0")?></span>
	</a>
	<div class="dropdown-menu pull-right with-arrow panel panel-default animated littleFadeInDown" role="menu">
		<div class="panel-heading">
			<strong><a href="{{asset('update_new_ticket_notify_emp')}}">You have <?=(!empty($new_ticket_count)?$new_ticket_count:"0")?> newly assigned ticket </a></strong>
		</div>
	</div>


<!--
<ul class="dropdown-menu">
	<li class="panel-heading">
		<a href="{{asset('update_new_ticket_notify_emp')}}">You have <?=(!empty($new_ticket_count)?$new_ticket_count:"0")?> newly assigned ticket </a>
	</li>
</ul>
-->
