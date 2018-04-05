
@foreach($productos as $producto)
    {{$producto->nombre}}
    <br>
    {{$producto->created_at}}
    @endforeach
{{ $productos->render() }}