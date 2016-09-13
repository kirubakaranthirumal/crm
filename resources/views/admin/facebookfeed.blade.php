
		<?php $count = 0; //count?>
		@foreach($fbpage as $key => $fbpost)
			@if($count < 3)
				<div class="media social-feed">
					<span class="pull-left">
						<img class="img-circle size-50x50" src="https://graph.facebook.com/{!!$fbpost->from->id!!}/picture?access_token={!!$access_token!!}">
					</span>
					<div class="media-body">
						<p class="media-heading"><strong>{!!$fbpost->from->name!!}</strong> <small class="text-light text-transparent-white">{!!date("d M Y h:i A",strtotime($fbpost->created_time))!!}</small></p>
						<p class="text-transparent-white">{!!$fbpost->message!!}</p>
					</div>
				</div>
			@endif	
			<?php $count++; ?>
		@endforeach	
