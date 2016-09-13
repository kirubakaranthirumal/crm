

		<?php $count = 0; ?>
		@foreach($notify_tweet_data as $key => $data)
			@if($count < 3)
				<div class="media social-feed">
					<span class="pull-left">
						<img class="img-circle size-50x50" src="{!!$data->user->profile_image_url_https!!}">
					</span>
					<div class="media-body">
						<p class="media-heading"><strong>{!!$data->user->name!!}</strong> <small class="text-light text-transparent-white"><?php echo date('d M y  H:i', strtotime($data->created_at)); ?></small></p>
						<p class="text-transparent-white">{!!substr(strstr($data->text," "), 1)!!}</p>
					</div>
				</div>
			@endif	
			<?php $count++; ?>
		@endforeach	
