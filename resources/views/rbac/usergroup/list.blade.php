<html>
	<h2><a href="{{url('/')}}">首页</a></h2>
	<a href="{{url('/usergroup/create')}}">添加用户组</a>
	<ul>
		@foreach ($usergroups as $usergroup)
		<li>
			{{ $usergroup->GROUPNAME }} 
			<a href="{{url('/usergroup/role?usergroupid=').$usergroup->UGID}}">角色</a> 
			<a href="{{url('/usergroup/permission?usergroupid=').$usergroup->UGID}}">用户组权限</a> 
			<span class="delete" delete="{{$usergroup->UGID}}" url="{{url('/usergroup/delete')}}">删除</span>
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