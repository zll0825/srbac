<html>
	<form action="{{url('/permission/menu/create')}}" method="POST">
		<p>
			权限类型：
			<select name="permissiontype">
				<option value="MENU" selected="selected">菜单</option>
				<option value="FUNCTION">功能</option>
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
			所属菜单：
			<select name="parentmid">
				<option value="0">顶级菜单</option>
				@foreach($topmenus as $topmenu)
				<option value="{{$topmenu['MID']}}">{{$topmenu['MENUNAME']}}</option>
				@endforeach
			</select>
		</p>
		<p>菜单名:<input type="text" name="menuname"></p>
		<p>菜单码:<input type="text" name="menucode"></p>
		<p>菜单链接:<input type="text" name="menuurl"></p>
		<button type="submit">提交</button>
		<a href="{{url('/permission/list')}}">返回</a>
	</form>
</html>