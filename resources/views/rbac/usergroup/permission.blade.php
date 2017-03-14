<html>
	<div>
		<h3>菜单</h3>
		@foreach($menus as $menu)
			@if($menu['PARENTMID'] == 0)
			<p>{{$menu['MENUNAME']}}</p>
				@foreach($menus as $submenu)
					@if($submenu['PARENTMID'] == $menu['MID'])
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$submenu['MENUNAME']}}
					@endif
				@endforeach
			@endif
		@endforeach
	</div>
	<div>
		<h3>功能</h3>
		@foreach($funcs as $func)
			@if($func['PARENTFID'] == 0)
			<p>{{$func['FUNCTIONNAME']}}</p>
				@foreach($funcs as $subfunc)
					@if($subfunc['PARENTFID'] == $func['FID'])
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$subfunc['FUNCTIONNAME']}}
					@endif
				@endforeach
			@endif
		@endforeach
	</div>
	<div>
		<h3>元素</h3>
		@foreach($elems as $elem)
		<p>{{$elem['ELEMENTCODE']}}</p>
		@endforeach
	</div>
	<a href="{{url('/usergroup/list')}}">返回</a>
</html>