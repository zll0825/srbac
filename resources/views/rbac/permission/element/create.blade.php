<html>
	<form action="{{url('/permission/element/create')}}" method="POST">
		<p>
			权限类型：
			<select name="permissiontype">
				<option value="MENU">菜单</option>
				<option value="FUNCTION">功能</option>
				<option value="ELEMENT" selected="selected">元素</option>
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
			<select name="menucode">
				@foreach($menus as $menu)
					@if($menu['PARENTMID'] == 0)
					<option value="{{$menu['MENUCODE']}}">{{$menu['MENUNAME']}}</option>
						@foreach($menus as $submenu)
							@if($submenu['PARENTMID'] == $menu['MID'])
								<option value="{{$menu['MENUCODE']}}">--{{$menu['MENUNAME']}}</option>
							@endif
						@endforeach
					@endif
				@endforeach
			</select>
		</p>
		<p>元素码:<input type="text" name="elementcode"></p>
		<button type="submit">提交</button>
		<a href="{{url('/permission/list')}}">返回</a>
	</form>
</html>