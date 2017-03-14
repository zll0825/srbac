<html>
	<form action="{{url('/role/setpermissions')}}" method="POST">
		<div>
			<h3>菜单</h3>
			@foreach($menus as $menu)
				@if($menu['PARENTMID'] == 0)
				<p><input type="checkbox" name="permissionids[]" value="{{ $menu['PID'] }}" @if(in_array($menu['MID'],$rm))checked='checked'@endif >{{$menu['MENUNAME']}}</p>
					@foreach($menus as $submenu)
						@if($submenu['PARENTMID'] == $menu['MID'])
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="permissionids[]" value="{{ $submenu['PID'] }}"  @if(in_array($menu['MID'],$rm))checked='checked'@endif >{{$submenu['MENUNAME']}}
						@endif
					@endforeach
				@endif
			@endforeach
		</div>
		<div>
			<h3>功能</h3>
			@foreach($funcs as $func)
				@if($func['PARENTFID'] == 0)
				<p><input type="checkbox" name="permissionids[]" value="{{$func['PID']}}"  @if(in_array($func['FID'],$rf))checked='checked'@endif >{{$func['FUNCTIONNAME']}}</p>
					@foreach($funcs as $subfunc)
						@if($subfunc['PARENTFID'] == $func['FID'])
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="permissionids[]" value="{{ $subfunc['PID'] }}" @if(in_array($subfunc['FID'],$rf))checked='checked'@endif>{{$subfunc['FUNCTIONNAME']}}
						@endif
					@endforeach
				@endif
			@endforeach
		</div>
		<div>
			<h3>元素</h3>
			@foreach($elems as $elem)
			<p><input type="checkbox" name="permissionids[]" value="{{$elem['PID']}}" @if(in_array($elem['EID'],$re))checked='checked'@endif>{{$elem['ELEMENTCODE']}}</p>
			@endforeach
		</div>
		<input type="hidden" name="roleid" value="{{$roleid}}">
		<button type="submit">提交</button>
	</form>
</html>