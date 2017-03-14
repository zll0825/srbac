<html>
	<form action="{{url('/usergroup/create')}}" method="POST">
		<select name="parentugid">
			<option value="0">顶级权限</option>
			@foreach($topgroups as $topgroup)
			<option value="{{$topgroup['UGID']}}">{{$topgroup['GROUPNAME']}}</option>
			@endforeach
		</select>
		<p>
			用户组名:<input type="text" name="groupname">
		</p>
		<button type="submit">提交</button>
	</form>
</html>