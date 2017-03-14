<html>
	<form action="{{url('/user/setusergroups')}}" method="POST">
		<ul>
			@foreach ($usergroups as $usergroup)
			<li>
				@if(in_array($usergroup->UGID,$ug))
				<input type="checkbox" name="usergroupids[]" checked="checked" value="{{ $usergroup->UGID }}">{{ $usergroup->GROUPNAME }}
				@else
				<input type="checkbox" name="usergroupids[]" value="{{ $usergroup->UGID }}" >{{ $usergroup->GROUPNAME }}
				@endif
			</li>
			@endforeach
			<input type="hidden" name="userid" value="{{$UID}}">
			<button type="submit">提交</button>
		</ul>
	</form>
</html>