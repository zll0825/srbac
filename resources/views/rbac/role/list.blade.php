<html>
	<h2><a href="{{url('/')}}">首页</a></h2>
	<a href="{{url('/role/create')}}">添加角色</a>
	<ul>
		@foreach ($roles as $role)
		<li>
			{{ $role->ROLENAME }} 
			<a href="{{url('/role/permission?roleid=').$role->ROLEID}}">角色权限</a>  <span class="delete" delete="{{$role->ROLEID}}" url="{{url('/role/delete')}}">删除</span>
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