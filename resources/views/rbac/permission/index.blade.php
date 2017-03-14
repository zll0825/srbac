<html>
	<h2><a href="{{url('/')}}">首页</a></h2>
	<h3><a href="{{url('/permission/create')}}">添加权限</a></h3>
	<div>
		<h3>菜单</h3><a href="{{url('/permission/menu/create')}}">添加菜单</a>
		@foreach($menus as $menu)
			@if($menu['PARENTMID'] == 0)
			<p>{{$menu['MENUNAME']}}<a href="{{url('/permission/menu/element?mid=').$menu['MID']}}">查看菜单元素</a> <span class="delete" delete="{{$menu['MID']}}" url="{{url('/permission/menu/delete')}}">删除</span> </p>
				@foreach($menus as $submenu)
					@if($submenu['PARENTMID'] == $menu['MID'])
						<p>--{{$submenu['MENUNAME']}}<a href="{{url('/permission/menu/element?mid=').$submenu['MID']}}">查看菜单元素</a> <span class="delete" delete="{{$submenu['MID']}}" url="{{url('/permission/menu/delete')}}">删除</span></p>
					@endif
				@endforeach
			@endif
		@endforeach
	</div>
	<div>
		<h3>功能</h3><a href="{{url('/permission/function/create')}}">添加功能</a>
		@foreach($funcs as $func)
			@if($func['PARENTFID'] == 0)
			<p>{{$func['FUNCTIONNAME']}} <span class="delete" delete="{{$func['FID']}}" url="{{url('/permission/function/delete')}}">删除</span></p>
				@foreach($funcs as $subfunc)
					@if($subfunc['PARENTFID'] == $func['FID'])
						<p>--{{$subfunc['FUNCTIONNAME']}} <span class="delete" delete="{{$subfunc['FID']}}" url="{{url('/permission/function/delete')}}">删除</span></p>
					@endif
				@endforeach
			@endif
		@endforeach
	</div>
	<div>
		<h3>元素</h3><a href="{{url('/permission/element/create')}}">添加元素</a>
		@foreach($elems as $elem)
			<p>{{$elem['ELEMENTCODE']}} <span class="delete" delete="{{$elem['EID']}}" url="{{url('/permission/element/delete')}}">删除</span></p>
		@endforeach
	</div>
</html>
<script type="text/javascript" src="{{url('/js/jquery.js')}}"></script>
<script>
	$(function(){
		$('.delete').click(function(){
			$.ajax({  
		        url: $(this).attr('url'),  
		        type: 'post',  
		        data: {'id':$(this).attr('delete')},
		        dataType: 'json',
		        success: function(){
	        		alert('ok')
	        		window.location.reload()
	        	}, //成功执行方法    
		        error: function(){
		        	alert('fail')
	        		window.location.reload()
		        }  //错误执行方法    
		    })
		})
	})
</script>