<html>
	<h3>元素</h3><a href="{{url('/permission/element/create')}}">添加元素</a>
	@foreach($elems as $elem)
		<p>{{$elem['ELEMENTCODE']}}</p>
	@endforeach
</html>