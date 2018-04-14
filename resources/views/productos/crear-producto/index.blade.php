{!! Form::Open(['route'=>'guardar_producto','method'=>'POST','files'=>true]) !!}

<div class="form-group">
    {!! Form::label('nombre','Nombre') !!}
    {!! Form::Text('nombre',null,['class'=>'','required','placeholder'=>'Nombre Producto']) !!}
</div>
<div class="form-group">
    {!! Form::label('categoria_id','Categoria') !!}
    {!! Form::select('categoria_id',$categorias,null,['class'=>'','required']) !!}
</div>
<div class="form-group">
    {!! Form::label('descripcion','Descripcion') !!}
    {!! Form::textarea('descripcion',null,['class'=>' ','required','placeholder'=>'Descripcion Producto']) !!}
</div>
<div class="form-group">
    {!! Form::label('imagen','Imagen') !!}
    {!! Form::File('imagen',['class'=>'form-control','required']) !!}
</div>
<div class="form-group">
    {!!Form::submit('Agregar articulo',['class'=>'btn btn-primary'])!!}

</div>
{!! Form::close() !!}