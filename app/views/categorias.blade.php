@extends('layouts.bootstrap')

@section('content')

<div class="content">

<h1>Categorías</h1>

<div class="form-group">
<a class="btn btn-small btn-success" href="#" onclick="crear()">Crear nueva categoría</a>
</div>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<td>&nbsp;</td>
			<td>Nombre</td>
			<td>Cant de lugares</td>
			<td>Acciones</td>
		</tr>
	</thead>
	<tbody>
	<?php $num=0;?>
	@foreach($categorias as $key => $value)
	<?php $num++;?>
		<tr>
			<td>{{ $num }}</td>
			<td>{{{ $value->nombre }}}</td>
			<td>{{ Lugar::where('categoria', '=', $value->id)->count()}}</td>
			<td>

				{{ Form::open(array('url' => 'categorias/' . $value->id, 'class' => 'pull-left')) }}

				{{HTML::link('#', 'Editar', array('class'=>'btn btn-small btn-info', 'onclick'=> 'editar(' . $value->id . ',' . json_encode($value->nombre) . ')'))}}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::submit('Eliminar', array('class' => 'btn btn-warning')) }}
				{{ Form::close() }}
			</td>
		</tr>
	@endforeach
	</tbody>
</table>


</div>

<script type="text/javascript"> 
     function eliminar(ide) {
         	
     	$('#botonmodaleliminar').click(function() {
  			redirigir('/categorias/eliminar/' + ide);
		});
     	
     	//mostrarlo
     	$('#modaleliminar').modal('show');
    	
    }
    
    
    function crear() {
    	
    	$('#nombrecategoria').val("");
    	$('#formcreareditar').attr("action",('/categorias/crear'));
     	
     	//mostrarlo
     	$('#modalcreareditar').modal('show');
    	
    }
    
    function editar(ide, nombre) {
    	
    	$('#nombrecategoria').val(nombre);
    	$('#formcreareditar').attr("action",'/categorias/editar/' + ide);
     	
     	//mostrarlo
     	$('#modalcreareditar').modal('show');
    	
    }
    
    function redirigir(url){
    	//redirigir a la url solicitada por el modal
    	window.location.href = url;
    	
    }
   
  </script>


  <div class="modal fade" id="modaleliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Confirmación de eliminación</h4>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro que deseas eliminar esta categoría?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="botonmodaleliminar">Eliminar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  <div class="modal fade" id="modalcreareditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	{{ Form::open(array('url' => '/categorias/guardar', 'class' => 'form-horizontal', 'role'=> 'form', 'id'=>'formcreareditar' )) }}
               
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
	        <h4 class="modal-title">Ingresa un nombre a la categoría</h4>
	      </div>
	      <div class="modal-body">
	        <p>	
	        	{{Form::label('nombre', 'Nombre: ', array('class' => 'control-label'))}}
            	{{Form::text('nombre', '', array('class' => 'form-control', 'id'=>'nombrecategoria'))}}
            	{{Form::hidden('creador', Auth::user()->id)}}
	        </p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-primary" id="botonmodalcreareditar">Guardar</button>
	      </div>
		{{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop