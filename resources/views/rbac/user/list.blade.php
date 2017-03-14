<html>
	<h2><a href="{{url('/')}}">首页</a></h2>
	<a href="{{url('/user/create')}}">添加角色</a>
	<ul>
		@foreach ($users as $user)
		<li>
			{{ $user->NICKNAME }} 
			<a href="{{url('/user/role?userid=').$user->UID}}">角色</a> 
			<a href="{{url('/user/usergroup?userid=').$user->UID}}">用户组</a> 
			<a href="{{url('/user/permission?userid=').$user->UID}}">用户权限</a> 
			<span class="delete" delete="{{$user->UID}}" url="{{url('/user/delete')}}">删除</span>
		</li>
		@endforeach
	</ul>
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