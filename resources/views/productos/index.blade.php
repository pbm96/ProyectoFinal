<!-- include del nav y de los enlaces de estilos-->
@include('templates.header')
<!-- include de los errores en formularios-->
@include('templates.errors')
@foreach($productos as $producto)
    {{$producto->nombre}}
    <br>
    {{$producto->created_at}}
    @endforeach
{{ $productos->render() }}
<!-- include del footer y de los enlaces de scripts-->
@include('templates.footer')