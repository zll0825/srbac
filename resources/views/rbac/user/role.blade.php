<html>
	<form action="{{url('/user/setroles')}}" method="POST">
		<ul>
			@foreach ($roles as $role)
			<li>
				@if(in_array($role->ROLEID,$ur))
				<input type="checkbox" name="roleids[]" checked="checked" value="{{ $role->ROLEID }}">{{ $role->ROLENAME }}
				@else
				<input type="checkbox" name="roleids[]" value="{{ $role->ROLEID }}" >{{ $role->ROLENAME }}
				@endif
			</li>
			@endforeach
			<input type="hidden" name="userid" value="{{$UID}}">
			<button type="submit">提交</button>
		</ul>
	</form>
</html>