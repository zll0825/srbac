<html>
	<form action="{{url('/permission/function/create')}}" method="POST">
		<p>
			权限类型：
			<select name="permissiontype">
				<option value="MENU">菜单</option>
				<option value="FUNCTION" selected="selected">功能</option>
				<option value="ELEMENT">元素</option>
				<option value="FILE">文件</option>
			</select>
		</p>
		<p>
			应用终端：
			<select name="permissiontype">
				<option value="PC">电脑端</option>
				<option value="ANDROID">安卓端</option>
				<option value="IOS">苹果端</option>
			</select>
		</p>
		<p>
			所属功能：
			<select name="parentfid">
				<option value="0">顶级功能</option>
				@foreach($topfunctions as $topfunction)
				<option value="{{$topfunction['FID']}}">{{$topfunction['FUNCTIONNAME']}}</option>
				@endforeach
			</select>
		</p>
		<p>功能名:<input type="text" name="functionname"></p>
		<p>功能码:<input type="text" name="functioncode"></p>
		<p>功能链接:<input type="text" name="filterurl"></p>
		<button type="submit">提交</button>
		<a href="{{url('/permission/list')}}">返回</a>
	</form>
</html>