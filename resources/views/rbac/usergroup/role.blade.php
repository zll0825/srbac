<html>
	<form action="{{url('/usergroup/setroles')}}" method="POST">
		<ul>
			@foreach ($roles as $role)
			<li>
				@if(in_array($role->ROLEID,$gr))
				<input type="checkbox" name="roleids[]" checked="checked" value="{{ $role->ROLEID }}">{{ $role->ROLENAME }}
				@else
				<input type="checkbox" name="roleids[]" value="{{ $role->ROLEID }}" >{{ $role->ROLENAME }}
				@endif
			</li>
			@endforeach
			<input type="hidden" name="usergroupid" value="{{$UGID}}">
			<button type="submit">提交</button>
		</ul>
	</form>
</html>