@if ( count($applications) )
	<table class="table states-current-usage">
	@foreach($applications as $application)
		<tr>
			<td class="application">
				@if ($application['steam_app_id'] != null)
				<a href="{{ $application['url'] }}" title="View {{ $application['name'] }} in the Steam Store">
					<img src="{{ $application['logo_small'] }}" alt="{{ $application['name'] }}">
				</a>
				@else
					@if (file_exists(public_path()."/upload/gamepics/".$application['name'].".png"))
						<img src="{{ "/upload/gamepics/".$application['name'].".png" }}" title="{{ $application['name'] }}" alt="{{ $application['name'] }}">
					@else
						<h3> {{ $application['name'] }} </h3>
					@endif
				@endif
			</td>
			<td class="user-count">
				{{ count($application['users']) }} In Game
			</td>
			<td class="user-list">
				<?php $userCount = 0; ?>
				@foreach( $application['users'] as $user )
					@if (!($user['visible'] == 0 ))
						<?php 
							$userCount++; ?>
						@if ($userCount == 41)
							<a href="#app{{$application['id']}}" data-toggle="collapse" class="btn btn-default">More</a>
							<span id="app{{$application['id']}}" class="collapse">
						@endif
							<a href="{{ URL::route('users.show', $user['id']) }}">
								<img src="{{ $user['avatar_small']}}">
							</a>
						@endif
				@endforeach
				@if ($userCount >= 41)
					</span>
				@endif
			</td>
		</tr>
	@endforeach
	</table>

@else
	<p>No game usage to show!</p>
@endif

<script>
$('td.user-list span').on('hidden.bs.collapse', function () {
	var $this = $(this);
	$(this).parent().find('a.btn').text('More')
})
$('td.user-list span').on('show.bs.collapse', function () {
	var $this = $(this);
	$(this).parent().find('a.btn').text('Less')
})
	</script>
